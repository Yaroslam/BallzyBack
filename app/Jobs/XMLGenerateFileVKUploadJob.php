<?php

namespace App\Jobs;

use App\Models\Shoe;
use App\Servises\XML\XMLCreator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class XMLGenerateFileVKUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $shoes;
    public function __construct($shoes)
    {
        $this->shoes = $shoes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $xml = new XMLCreator("new.xml");
        $xml->openNode("yml_catalog", ["date" => "2021-04-01 12:20"]);
        $xml->openNode("shop");
        $xml->openNode("currencies");
        $xml->openNode("currency" , ["id" => "RUB" ,"rate" =>"1"]);
        $xml->closeNode("currency");
        $xml->closeNode("currencies");
        $xml->openNode("offers");

        foreach ($this->shoes as $shoe){
            $desc = "Доступные размеры ";
            foreach ($shoe->shoes_sizes as $size) {
                $desc = $desc . $size->size->size . " EU ";
            }

            $xml->openNode("offer", ['id' => $shoe->shoe_id, "available" =>"true"]);

            $xml->openNode("price");
            $xml->NodeText($shoe->price_roubles);
            $xml->closeNode("price");

            $xml->openNode("currencyId");
            $xml->NodeText("RUB");
            $xml->closeNode("currencyId");

            $xml->openNode("categoryId");
            $xml->NodeText(env("VK_SHOES_CATEGORY_ID"));
            $xml->closeNode("categoryId");

            $xml->openNode("picture");
            $xml->NodeText($shoe->img);
            $xml->closeNode("picture");

            $xml->openNode("name");
            $xml->NodeText($shoe->shoes_name);
            $xml->closeNode("name");

            $xml->openNode("description");
            $xml->NodeText($desc);
            $xml->closeNode("description");

            $xml->closeNode("offer");

            Shoe::where("shoe_id", $shoe->shoe_id)->update(["inMarket" => 1]);
        }

        $xml->closeNode("offers");
        $xml->closeNode("shop");
        $xml->closeNode("yml_catalog");

    }
}
