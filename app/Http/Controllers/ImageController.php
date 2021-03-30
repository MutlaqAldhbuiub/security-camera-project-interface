<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Images  $image
     * @return \Illuminate\Http\Response
     */
    public function show($app_id,$camera_id,$image_id)
    {
        $app = Application::find($app_id);
        if(!$app){
            return response()->json('App not found',404);
        }

        $cam = Application::find($app_id)->cameras->find($camera_id);
        if($cam){
            $image = $cam->images->find($image_id);
            if($image){
                return response()->json($image,200);
            }else{
                return response()->json(['Image not found'],404);
            }
        }else{
            return response()->json(['No camera found'],404);
        }
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image,$app_id,$camera_id,$image_id)
    {
        $app = Application::find($app_id);
        if(!$app){
            return response()->json('App not found',404);
        }

        $cam = Application::find($app_id)->cameras->find($camera_id);
        if($cam){
            $image = $cam->images->find($image_id);
            if(!$image){
                return response()->json('image not found',404);
            }
            if($image->delete()){
                return response()->json('Image deleted successfully',200);
            }else{
                return response()->json('something went wrong!',500);
            }
        }else{
            return response()->json(['No camera found'],404);
        }
    }
}
