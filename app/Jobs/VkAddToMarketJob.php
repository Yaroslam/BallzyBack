<?php

namespace App\Jobs;

use App\Models\Shoe;
use App\Servises\VK\VKImage;
use App\Servises\VK\VKMarket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Servises\Image;
use Illuminate\Support\Collection;

class VkAddToMarketJob implements ShouldQueue
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
            $VkImage = new VKImage();
            $VkMarket = new VKMarket();
            foreach ($this->shoes as $shoe){
                    $photoData = $VkImage->loadImage($shoe->img);
                    if(!$photoData){
                        continue;
                    }
                    $desc = "Доступные размеры ";
                    foreach ($shoe->shoes_sizes as $size) {
                        $desc = $desc . $size->size->size . " EU ";
                    }
                    $marketItemId = $VkMarket->addToMarket($photoData, $shoe->shoes_name, $desc, env("VK_SHOES_CATEGORY_ID"), $shoe->price_roubles)['market_item_id'];
                    Shoe::where("shoe_id", $shoe->shoe_id)->update(["inMarket" => 1, "market_id" => $marketItemId]);
                    file_put_contents(__DIR__.'/log.txt', getimagesize($shoe->img)[3] . PHP_EOL, FILE_APPEND);
                    $VkMarket->addToMarketInAlbum($shoe->brand->AlbumId, $marketItemId);
            }
            var_dump(1);

    }
}
