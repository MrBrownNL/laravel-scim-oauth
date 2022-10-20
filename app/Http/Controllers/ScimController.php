<?php

namespace App\Http\Controllers;

use App\Models\Scim;
use Illuminate\Http\Request;

class ScimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        // set permission
        $this->middleware('permission:scim-client');
    }

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Scim  $scim
     * @return \Illuminate\Http\Response
     */
    public function show(Scim $scim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Scim  $scim
     * @return \Illuminate\Http\Response
     */
    public function edit(Scim $scim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Scim  $scim
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scim $scim)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Scim  $scim
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scim $scim)
    {
        //
    }
}
