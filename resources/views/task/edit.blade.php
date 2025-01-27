@extends('layouts.base')

@section('title', $actionTitle)

@section('css', asset('css/create_task.css'))

@section('content')
<form action="{{ $actionRoute }}" method="post">
    @csrf

    @if (!$isCreate) 
        @method('PUT')
    @endif
    <div class="form-group">
        <h1>
            {{ $actionTitle }}
        </h1>
        <label for="title">Task Title:</label>
        <input required class="form-control" type="text" name="title" minlength="2" maxlength="14" value="{{ $title ?? '' }}"></input>
    </div>
    <div class="form-group">
        <label for="description">Descrição da Task:</label>
        <textarea required type="text" class="form-control" name="description" maxlength="400"> {{ $description ?? '' }}</textarea>
    </div>
    @if (!$isCreate)
        <input type="text" name="id" value="{{$taskid}}" hidden>
    @endif
    <input type="submit" class="btn btn-primary">
</form>
@endsection