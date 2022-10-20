@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>SCIM Clients</h2>
            </div>

            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('scim.create') }}"> Create New SCIM client</a>
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
            <th>Client ID</th>
            <th>Client secret</th>
            <th>Issue date</th>
            <th width="280px">Action</th>
        </tr>

	    @foreach ($scimClients as $scimClient)
	    <tr>
	        <td>{{ $scimClient->id }}</td>
            <td>{{ $scimClient->secret }}</td>
            <td>{{ $scimClient->created_at }}</td>
            <td>
                {!! Form::open(['method' => 'DELETE','route' => ['scim.destroy', $scimClient->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
	        </td>
	    </tr>
	    @endforeach
    </table>

@endsection
