<?php

namespace App\Http\Controllers\Api\V1;

use App\address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Address::where('user_id', Auth()->user()->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressRequest $request)
    {
        $address = new Address();
        $address->user_id = Auth()->user()->id;
        $address->fill($request->validated())->save();
        return $address;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(address $address)
    {
        $address->user_id !== Auth()->user()->id && abort(403);
        return $address;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(AddressRequest $request, address $address)
    {
        $address->user_id !== Auth()->user()->id && abort(403);
        $address->fill($request->validated())->save();
        return $address;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(address $address)
    {
        $address->user_id !== Auth()->user()->id && abort(403);
        $address->delete();
        return response()->json(['message' => 'Deleted.']);
    }
}
