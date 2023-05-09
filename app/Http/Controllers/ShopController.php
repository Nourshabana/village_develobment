<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use App\Models\Shoprates;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ShopController extends Controller
{
    use HttpResponses;
    public function index(){
        return ShopResource::collection(Shop::all());
    }


    public function show(Shop $shop){
        return new ShopResource($shop);

    }


    public function store(StoreShopRequest $request){
        $request->validated($request->all());
        $filename=$this->uploadimage($request,'shops');
        $sec=Shop::create([
            'name'=>$request->name,
            'photo'=>$filename,
            'location'=>$request->location
        ]);
        return new ShopResource($sec);


        
    }

    public function update(Request $request,Shop $shop){
        $filename=$this->updateimage($request,'shops',$shop);
        if($request->has('name')){$shop->name=$request->name;}
        if($request->has('location')){$shop->location=$request->location;}
        
        $shop->photo=$filename;
        $shop->save();
        return new ShopResource($shop);
    }

    public function destroy(Shop $shop){
        
        $this->deleteimage($shop);
        //$shoprates=Shoprates::where('shop_id',$shop->id);
        $shop->delete();
        return $this->succes('','your record was deleted succesfully');
        //
    }
    //
}
