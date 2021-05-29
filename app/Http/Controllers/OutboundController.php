<?php

namespace App\Http\Controllers;

use App\Models\Outbound;
use App\Models\Item;
use Illuminate\Http\Request;
use Api;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OutboundController extends Controller
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
            $this->data = Outbound::with('item')->get();
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
            $item = Item::findOrFail($request->item_id);
            
            $data = new Outbound;
            $data->item_id = $request->item_id;
            $data->qty = $request->qty;
            $data->total_price = $item->price * $request->qty;
            $data->receiver = $request->receiver;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->exit_time = $request->exit_time;
            $data->save();

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
     * @param  \App\Models\Outbound  $Outbound
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $this->data = Outbound::with('item')->findOrFail($id);
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
     * @param  \App\Models\Outbound  $Outbound
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try{
            
            $data = Outbound::with('item')->findOrFail($id);
            
            $data->item_id = empty($request->item_id) ? $data->item_id : $request->item_id;
            $data->qty = empty($request->qty) ? $data->qty : $request->qty;
            $data->total_price = empty($request->qty) ? $data->total_price : $data->item->price * $request->qty;
            $data->receiver = empty($request->receiver) ? $data->receiver : $request->receiver;
            $data->phone = empty($request->phone) ? $data->phone : $request->phone;
            $data->address = empty($request->address) ? $data->address : $request->address;
            $data->exit_time = empty($request->exit_time) ? $data->exit_time : $request->exit_time;
            $data->save();

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
     * @param  \App\Models\Outbound  $Outbound
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $this->data = Outbound::findOrFail($id)->delete();
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
