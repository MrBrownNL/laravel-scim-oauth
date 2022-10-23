<?php

namespace App\Http\Controllers;

use App\Models\OauthAccessToken;
use App\Models\OauthClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Token;

class OauthTokenController extends Controller
{
    function __construct()
    {
        // set permission
        $this->middleware('permission:scim-client');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  string $oauthClientId
     * @return \Illuminate\Http\Response
     */
    public function index(string $oauthClientId)
    {
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
     * @param  string $oauthClientId
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(string $oauthClientId)
    {
        $oauthClient = OauthClient::where('id', $oauthClientId)->where('user_id', Auth::id())->first();
        if ($oauthClient === null) {
            return redirect()->route('clients.index')->with('error','Invalid client specified');
        }

        $oauthTokens = OauthAccessToken::where('client_id', '=', $oauthClientId)->get();

        return view('tokens.index',compact('oauthTokens', 'oauthClientId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Revoke a token.
     *
     * @param  string  $oauthClientId
     * @param  string  $oauthToken
     * @return \Illuminate\Http\RedirectResponse
     */
    public function revoke(string $oauthClientId, string $oauthToken)
    {
        if (!$this->userOwnsToken($oauthClientId, $oauthToken)) {
            return redirect()->route('tokens.show', $oauthClientId)->with('error','Invalid token specified');
        }

        OauthAccessToken::where('id', $oauthToken)->where('client_id', $oauthClientId)->update(['revoked' => true]);

        //$token->update(['revoked' => true]);
        return redirect()->route('tokens.show', $oauthClientId)->with('success','Token revoked');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $oauthClientId
     * @param  string  $oauthToken
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $oauthClientId, string $oauthToken)
    {
        if (!$this->userOwnsToken($oauthClientId, $oauthToken)) {
            return redirect()->route('tokens.show', $oauthClientId)->with('error','Invalid token specified');
        }

        OauthAccessToken::where('id', $oauthToken)->where('client_id', $oauthClientId)->delete();
        return redirect()->route('tokens.show', $oauthClientId)->with('success','Token deleted');
    }


    /**
     * Check if the current user owns the token.
     *
     * @param  string  $oauthClientId
     * @param  string  $oauthToken
     * @return bool
     */
    private function userOwnsToken(string $oauthClientId, string $oauthToken): bool
    {
        $token = OauthAccessToken::where('id', $oauthToken)->where('client_id', $oauthClientId)->first();
        $client = OauthClient::where('user_id', '=', Auth::id())->where('id', $oauthClientId)->first();
        return $token !== null && $client !== null;
    }
}
