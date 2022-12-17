<?php
namespace src\Database;


use PDO;
use PDOException;

class DB
{

    public PDO $conn;

    function __construct($host, $dbname, $username, $password)
    {
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            echo "Connected to $dbname at $host successfully.";
        } catch (PDOException $pe) {
            die("Could not connect to the database $dbname :" . $pe->getMessage());
        }
    }

    private function InnerSelect($tableName, $depends, $columnsToQuery="*", $columnsToValidate=[], $columnsVal=[], $conditions=[])
    {
        $sql = 'SELECT ';
        if((count($columnsToValidate) != count($columnsVal)) & (count($columnsToValidate) != count($conditions)))
        {
            return 0;
        }

        if($columnsToQuery == "*")
        {
            $sql = $sql.$columnsToQuery;
            $sql = $sql." FROM ".$tableName;
            if(count($columnsToValidate) != 0)
            {
                $sql = $sql." WHERE ".$this->generateValidateQuery($columnsToValidate, $columnsVal, $conditions, $depends);
            }
        } else {
            $c = $this->generateQuery($columnsToQuery);
            $sql = $sql.$c;
            $sql = $sql." FROM ".$tableName;
            $c = $this->generateValidateQuery($columnsToValidate, $columnsVal, $conditions, $depends);
            $sql = $sql." WHERE ".$c;
        }
        $sth = $this->conn->prepare($sql);
        $sth->execute();
        return $sth;
    }

    public function Select($tableName, $depends, $columnsToQuery="*", $columnsToValidate=[], $columnsVal=[], $conditions=[])
    {
        $sth = $this->InnerSelect($tableName, $depends, $columnsToQuery, $columnsToValidate, $columnsVal, $conditions);
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectAll($tableName, $depends, $columnsToQuery="*", $columnsToValidate=[], $columnsVal=[], $conditions=[])
    {
        $sth = $this->InnerSelect($tableName, $depends, $columnsToQuery, $columnsToValidate, $columnsVal, $conditions);
        return $sth->fetchAll();
    }


    public function lastRowId($tableName)
    {
        $sql = "SELECT ID FROM ".$tableName." ORDER BY ID DESC LIMIT 1";
        $sth = $this->conn->prepare($sql);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_ASSOC)['ID'] ?? 0;
    }

    private function generateValidateQuery($colArray, $valArray, $conditions, $depends)
    {
        $sql = '';

        for($i = 0, $iMax = count($conditions); $i< $iMax; $i++)
        {
            $sql = $sql.$colArray[$i]." ".$conditions[$i]." \"".$valArray[$i]."\""." ";
            if($i <= count($depends)-1){
                $sql = $sql.$depends[$i]." ";
            }
        }

        return trim($sql);
    }


    private function generateQuery($array)
    {
        $sql = "(";
        foreach($array as $val)
        {
            $sql = $sql." ".$val.",";
        }
        $sql =  trim($sql, ',');
        $sql = $sql.")";
        return $sql;
    }

    public function EnterToTable($columnsNames, $parametrs, $tablename)
    {
        $columns = $this->generateQuery($columnsNames);
        $metaParam = [];
        foreach($parametrs as $parametr)
        {
            array_push($metaParam, "?");
        }
        $insert = $this->generateQuery($metaParam);
        $sql = "INSERT INTO ".$tablename." ".$columns." VALUES ".$insert;
        $sth = $this->conn->prepare($sql);
        $sth->execute($parametrs);
    }

    public function truncate($tableName)
    {
        $this->changeFKCheck(0);
        $this->conn->prepare("truncate ".$tableName.";")->execute();
        $this->changeFKCheck(1);
    }

    public function deleteRow($tableName, $columnsToValidate, $columnsVal, $columnsCond, $columnsDep){





    }


    private function changeFKCheck($isCheck)
    {
        $this->conn->prepare("SET FOREIGN_KEY_CHECKS = ".$isCheck.";")->execute();
    }

}
