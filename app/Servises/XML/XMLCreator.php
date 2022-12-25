<?php

namespace App\Servises\XML;

use stringEncode\Exception;

class XMLCreator
{
    private string $file;
    private array $nodes;

    public function __construct($file)
    {
        $this->file = $file;
        file_put_contents(__DIR__.$this->file, "<?xml version=\"1.0\" encoding=\"utf-8\"?>" . PHP_EOL, FILE_APPEND);
    }

    public function openNode($nodeName, $nodeParam = [], $soloClose = false)
    {
        $this->nodes[] = $nodeName;
        $nodeString = '<'.$nodeName;

        foreach (array_keys($nodeParam) as $param){
            $nodeString = $nodeString." $param=\"$nodeParam[$param]\"";
        }
        if($soloClose){
            $nodeString.="/>";
        } else {
            $nodeString.=">";
        }
        file_put_contents(__DIR__.$this->file, $nodeString . PHP_EOL, FILE_APPEND);

    }

    public function NodeText($text){
        file_put_contents(__DIR__.$this->file, $text . PHP_EOL, FILE_APPEND);
    }

    public function closeNode($nodeName): int|string
    {
        if (!in_array($nodeName, $this->nodes)){
            return Exception::class;
        } else {
            $nodeString = '</'.$nodeName.">";
            file_put_contents(__DIR__.$this->file, $nodeString . PHP_EOL, FILE_APPEND);
        }
        return 0;
    }













}
