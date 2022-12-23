<?php

namespace App\Http\Controllers;

use App\Jobs\ParseJob;
use App\Models\Brand;
use App\Models\Shoe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use App\Servises\Parsers;

class ShoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shoes = Shoe::paginate(10);
        $brands = Brand::all();
        return Response(view('shoes.index', compact('shoes', 'brands')));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        ParseJob::dispatch();
        return Response(redirect()->route('Shoes.index')
            ->with('Start parse'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shoes = Shoe::where("shoe_id",$id)->first();
        return Response(view("Shoes.show", compact("shoes")), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shoes = Shoe::where("shoe_id",$id)->first();
        return Response(view("Shoes.edit", compact("shoes")), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return "SDAAAAAAAAAAA";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Shoe::where("shoe_id",$id)->delete();
        return Response(redirect()->route('Shoes.index')
            ->with('success','post deleted successfully'));
    }
}
