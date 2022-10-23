<?php

namespace App\Http\Controllers;

use App\Models\OauthClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Token;

class OauthClientController extends Controller
{
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
        $oauthClients = OauthClient::where('user_id', '=', Auth::id())->get();
        return view('clients.index',compact('oauthClients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $client = new ClientRepository();
        $client->create(Auth::id(), $request->name, '');

        return redirect()->route('clients.index')->with('success','OAuth Client Credentials created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OauthClient  $oauthClient
     * @return \Illuminate\Http\Response
     */
    public function show(OauthClient $oauthClient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OauthClient  $oauthClient
     * @return \Illuminate\Http\Response
     */
    public function edit(OauthClient $oauthClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OauthClient  $oauthClient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OauthClient $oauthClient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $oauthClientId
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $oauthClientId)
    {
        $oauthClient = OauthClient::where('id', $oauthClientId)->where('user_id', Auth::id());

        if ($oauthClient) {
            $tokens = Token::where('client_id', $oauthClientId);
            $tokens->delete();

            $oauthClient->delete();
        }

        return redirect()->route('clients.index')->with('success','OAuth Client deleted successfully');
    }
}
