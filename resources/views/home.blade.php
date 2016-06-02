@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <a href="/contacts">Contacts</a>
                    <a href="/contacts/create">Create Contacts</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
