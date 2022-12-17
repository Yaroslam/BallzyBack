<?php

namespace App\Jobs;

use App\Models\Brand;
use App\Servises\VK\VKMarket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateAlbumJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $VkMarket = new VKMarket();
        $brands = Brand::all();
        $albums = $VkMarket->getPublicAlbums();

        foreach ($brands as $brand){
            $isBrandReal = 0;
            foreach ($albums['items'] as $album){
                if($brand->brand_name == $album['title']){
                    $isBrandReal++;
                }
            }
            if($isBrandReal == 0){
                sleep(3);
                $albumId = $VkMarket->createAlbum($brand->brand_name);
                $a = Brand::where("brand_id", $brand->brand_id)->update(["AlbumId" => $albumId['market_album_id']]);
            }
        }
    }
}
