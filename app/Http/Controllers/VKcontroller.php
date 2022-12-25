<?php

namespace App\Http\Controllers;

use App\Jobs\CreateAlbumJob;
use App\Jobs\DecorateJob;
use App\Jobs\VkAddToMarketJob;
use App\Jobs\VkCleanMarketJob;
use App\Jobs\XMLGenerateFileVKUploadJob;
use App\Models\Shoe;
use App\Servises\VK\VKImage;
use App\Servises\VK\VKMarket;
use Illuminate\Http\Request;
use App\Servises\VK;

use Illuminate\Support\Facades\Bus;
use VK\OAuth\Scopes\VKOAuthUserScope;

class VKcontroller extends Controller
{

    public function addToMarket(){
        VkAddToMarketJob::dispatch(Shoe::all());
        return Response(redirect()->route('Shoes.index'));
    }

    public function getMarketProducts(){
        $market = new VKMarket();
        return $market->getMarketProducts();
    }

    public function cleanMarket(){
        VkCleanMarketJob::dispatch();
        return Response(redirect()->route('Shoes.index')
            ->with('Start parse'));
    }

    public function createAlbums(){
        CreateAlbumJob::dispatch()->onQueue('default');
        return Response(redirect()->route('Shoes.index')
            ->with('Start parse'));
    }

    public function generateUploadFile(){
        XMLGenerateFileVKUploadJob::dispatch(Shoe::all())->onQueue('default');
        return Response(redirect()->route('Shoes.index')
            ->with('Start parse'));
    }
}
