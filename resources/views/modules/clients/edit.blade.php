@extends('layouts.app')

@section('content')
    <div class=container>
        <client-form :client="{{ $client }}" />
    </div>
@endsection
