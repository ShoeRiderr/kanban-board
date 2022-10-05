@extends('layouts.app')

@section('content')
    <div class=container>
        <kanban-boards :table-id="{{ $table->id }}" :auth-user="{{ auth()->user() }}" />
    </div>
@endsection
