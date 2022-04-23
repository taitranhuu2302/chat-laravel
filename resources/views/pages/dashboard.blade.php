@extends('layouts.main_layout')

@section('title', 'Chat')


@section('content')
    <div class="flex items-center justify-center w-full h-full">
        <div class="flex flex-col items-center gap-5">
            <i class="text-8xl text-gray-500 far fa-comment-lines"></i>
            <p class="text-lg text-gray-500">Select a chat to read messages</p>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
