@extends('layouts.base')

@section('title', 'To-do-list')

@section('content')

@section('css', asset('css/main_page.css'))

<main>
    <h1>To do list</h1>
    <a class="btn btn-dark github-button" href="https://github.com/RajadorDev/To-do-list">
        <i class="bi bi-github"></i>
        GitHub
    </a>
</main>

<div class="info">
    <h2>What it does?</h2>
    <p>This is a simple to-do-list that you can create, edit and delete your tasks</p>
</div>

<div class="login-area">
    <p>You need to sign in to use:</p>
    <div class="login-buttons">
        <a href="{{ url('/login') }}" class="btn btn-dark">Login</a>
        <a href="{{ url('/register') }}" class="btn btn-dark">Register</a>
    </div>
</div>

@endsection