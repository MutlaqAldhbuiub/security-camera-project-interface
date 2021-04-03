<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Camera;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CameraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($app_id)
    {
        $app = Application::find($app_id);
        if(!$app){
            return response()->json('App not found',404);
        }
        if($app->cameras){
            return response()->json($app->cameras,200);
        }else{
            return response()->json(['No cameras found'],404);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$app_id)
    {
        if(!$request->has('title')){
            return response()->json('title is required',500);
        }

        $camera = new Camera;
        $camera->camera_name = $request->title;
        $camera->application_id = $app_id;
        if($camera->save()){
            return response()->json('Camera: '.$camera->camera_name.' created!',200);
        }else{
            return response()->json('Camera haven\'t saved!',500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Camera  $camera
     * @return \Illuminate\Http\Response
     */
    public function show(Camera $camera,$app_id,$camera_id)
    {
        $app = Application::find($app_id);
        if(!$app){
            return response()->json('App not found',404);
        }

        $cam = Application::find($app_id)->cameras->find($camera_id);
        if($cam){
            return response()->json($cam,200);
        }else{
            return response()->json(['No camera found'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Camera  $camera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Camera $camera,$app_id,$camera_id)
    {
        if(!$request->has('title')){
            return response()->json('title is required',500);
        }
        $app = Application::find($app_id);
        if(!$app){
            return response()->json('App not found',404);
        }

        $cam = Application::find($app_id)->cameras->find($camera_id);
        if($cam){
            $cam->camera_name = $request->title;
            if($cam->save()){
                return response()->json('Camera '.$cam->camera_name.' updated!',200);
            }else{
                return response()->json('Camera haven\'t updated!',500);
            }
        }else{
            return response()->json(['No camera found'],404);
        }
    }


    public function images($app_id,$camera_id){
        $app = Application::find($app_id);
        if(!$app){
            return response()->json('App not found',404);
        }

        $cam = Application::find($app_id)->cameras->find($camera_id);
        if($cam){
            $images = $cam->images;
            if($images){
                return response()->json($cam->images,200);
            }
        }else{
            return response()->json(['No camera found'],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Camera  $camera
     * @return \Illuminate\Http\Response
     */
    public function destroy(Camera $camera,$app_id,$camera_id)
    {
        $app = Application::find($app_id);
        if(!$app){
            return response()->json('App not found',404);
        }

        $cam = Application::find($app_id)->cameras->find($camera_id);
        if($cam){
            if($cam->delete()){
                return response()->json('Camera deleted successfully',200);
            }else{
                return response()->json('Something went wrong!',500);

            }
        }else{
            return response()->json(['No camera found'],404);
        }
    }


    public function lastImage($app_id,$camera_id){
        $app = Application::find($app_id);
        if(!$app){
            return response()->json('App not found',404);
        }
        $cam = Application::find($app_id)->cameras->find($camera_id);
        if($cam){
            $getImage = Image::where(['application_id' => $app_id,'camera_id'=>$camera_id])->latest()->first();
            if($getImage){
                return response()->json($getImage,200);
            }
        }else{
            return response()->json(['No camera found'],404);
        }
    }
}
