<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        $apps = Auth::user()->applications;
        if($apps){
            return response()->json($apps,200);
        }else{
            return response()->json('No apps found',404);
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
        if(!$request->has('title')){
            return response()->json('title is required',500);
        }

        $application = new Application;
        $application->application_name = $request->title;
        $application->user_id = $request->user()->id;
        if($application->save()){
            return response()->json('Application '.$application->application_name.' created!',200);
        }else{
            return response()->json('Application haven\'t saved!',500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application,$id)
    {
        $app = Application::find($id);
        if(!$app){
            return response()->json('Application not found',404);
        }
        return $app;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        if(!$request->has('title')){
            return response()->json('title is required',500);
        }
        $app = Application::find($id);
        if(!$app){
            return response()->json('Application not found',404);
        }
        $app->application_name = $request->title;
        if($app->save()){
            return response()->json('Application '.$app->application_name.' updated!',200);
        }else{
            return response()->json('Application haven\'t updated!',500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Application $application,$id)
    {
        $app = Application::find($id)->first();
        if(!$app){
            return response()->json('Application not found',404);
        }
        if($app->delete()){
            return response()->json('Application deleted successfully',200);
        }else{
            return response()->json('Something went wrong!',500);

        }
    }
}
