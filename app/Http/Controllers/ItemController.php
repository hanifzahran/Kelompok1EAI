<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Api;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ItemController extends Controller
{
    private $data, $code;

    public function __construct()
    {
        $this->code = 200;
        $this->data = [];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $this->data = Item::get();
        } catch (Exception $e) {
            $this->code = 500;
            $this->data = $e;
        }
        return Api::apiRespond($this->code, $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $data = Item::create($request->all());
            $this->data = $data;
        } catch (Exception $e) {
            $this->code = 500;
            $this->data = $e;
        }
        return Api::apiRespond($this->code, $this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $this->data = Item::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            if($e instanceof ModelNotFoundException){
                $this->code = 404;
            } else{
                $this->code = 500;
                $this->data = $e;
            }
        }
        return Api::apiRespond($this->code, $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try{
            $data = Item::findOrFail($id);
            $data->fill($request->input())->save();
            $this->data = $data;
        } catch (ModelNotFoundException $e) {
            if($e instanceof ModelNotFoundException){
                $this->code = 404;
            } else{
                $this->code = 500;
                $this->data = $e;
            }
        }
        return Api::apiRespond($this->code, $this->data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $this->data = Item::findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            if($e instanceof ModelNotFoundException){
                $this->code = 404;
            } else{
                $this->code = 500;
                $this->data = $e;
            }
        }
        return Api::apiRespond($this->code, $this->data);
    }
}
