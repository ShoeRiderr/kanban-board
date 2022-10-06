@extends('layouts.app')

@section('content')
    <div class=container>
        <tag-form :tag="{{ $tag }}" />
    </div>
@endsection
