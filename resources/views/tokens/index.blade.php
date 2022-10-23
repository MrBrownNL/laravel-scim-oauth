@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>SCIM OAuth Client Credential Tokens</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('clients.index') }}"> Back</a>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>Token</th>
            <th>Issued</th>
            <th>Revoked</th>
            <th>Expires</th>
        </tr>

        @foreach ($oauthTokens as $oauthToken)
            <tr>
                <td>{{ $oauthToken->id }}</td>
                <td>{{ $oauthToken->created_at }}</td>
                <td>{{ $oauthToken->revoked }}</td>
                <td>{{ $oauthToken->expires_at }}</td>
                <td>
                    {!! Form::open(['method' => 'DELETE','route' => ['tokens.destroy', $oauthToken->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                  @if(!$oauthToken->revoked)
                    {!! Form::open(['method' => 'GET','route' => ['revoke', ['oauthClientId' => $oauthClientId, 'oauthToken' => $oauthToken->id]],'style'=>'display:inline']) !!}
                    {!! Form::submit('Revoke', ['class' => 'btn btn-info']) !!}
                    {!! Form::close() !!}
                  @endif
                </td>
            </tr>
        @endforeach
    </table>

@endsection
