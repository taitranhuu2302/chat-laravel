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
