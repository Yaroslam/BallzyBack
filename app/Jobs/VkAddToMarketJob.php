<?php

namespace App\Jobs;

use App\Models\Shoe;
use App\Servises\VK\VKImage;
use App\Servises\VK\VKMarket;
use App\Servises\XML\XMLCreator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Servises\Image;
use Illuminate\Support\Collection;
use VK\Exceptions\Api\VKApiServerException;
use VK\Exceptions\Api\VKApiTooManyException;
use VK\Exceptions\Api\VKApiUnknownException;

class VkAddToMarketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
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
        $vkMarket = new VKMarket();
    }
}
