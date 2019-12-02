<?php

namespace App\Http\Controllers;

use App\SplitValues;
use Illuminate\Http\Request;

class SplitValuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $split = new SplitValues;
        $split->id_order = $request->id_order;
        $split->value30 = $request->value30;
        $split->value70 = $request->value70;
        $split->done = 'true';
        $split->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SplitValues  $split
     * @return \Illuminate\Http\Response
     */
    public function show(SplitValues $split)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SplitValues  $split
     * @return \Illuminate\Http\Response
     */
    public function edit(SplitValues $split)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SplitValues  $split
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SplitValues $split)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SplitValues  $split
     * @return \Illuminate\Http\Response
     */
    public function destroy(SplitValues $split)
    {
        //
    }
}
