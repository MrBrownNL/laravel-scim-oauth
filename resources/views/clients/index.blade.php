@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>SCIM OAuth Client Credentials</h2>
            </div>

            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('clients.create') }}"> Create new client</a>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Client ID</th>
            <th>Client secret</th>
            <th>Tokens</th>
            <th>Last used</th>
            <th>Action</th>
        </tr>

        @foreach ($oauthClients as $oauthClient)
            <tr>
                <td>{{ $oauthClient->name }}</td>
                <td>{{ $oauthClient->id }}</td>
                <td>{{ $oauthClient->secret }}</td>
                <td>{{ $oauthClient->tokens()->count() }}</td>
                <td>{{ $oauthClient->tokens()->orderByDesc('created_at')->first()->created_at ?? 'never' }}</td>
                <td>
                    {!! Form::open(['method' => 'DELETE','route' => ['clients.destroy', $oauthClient->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    @if($oauthClient->tokens()->count() > 0)
                        {!! Form::open(['method' => 'GET','route' => ['tokens.show', $oauthClient->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Tokens', ['class' => 'btn btn-info']) !!}
                        {!! Form::close() !!}
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

@endsection
