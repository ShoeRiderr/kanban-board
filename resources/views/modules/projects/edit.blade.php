@extends('layouts.app')

@section('content')
    <div class=container>
        <project-form :project="{{ $project }}" />
    </div>
@endsection
