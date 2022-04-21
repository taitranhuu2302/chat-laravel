@extends('layouts.main_layout')

@section('title', 'Room')
@section('style-lib')
    <link rel="stylesheet" href="{{ asset('css/room.css') }}">
@endsection

@section('content')
    <div id="room" class="flex flex-col h-full w-full">
        <div class="room__header flex-shrink flex items-center border-b p-4 justify-between">
            <div class="header__left flex items-center gap-4 ">
                <img class="w-9 h-9 rounded-full" src="{{ Auth::user()->profile->avatar }}" alt="Rounded avatar">
                <div>
                    <p class="text-md font-semibold">{{ Auth::user()->profile->full_name }}</p>
                    <p class="text-sm">Online</p>
                </div>
            </div>
            <div class="header__right flex items-center gap-3">
                <button class="border rounded px-3 pt-1 flex items-center justify-center">
                    <i style="color: #0ABB87" class="text-xl far fa-phone"></i>
                </button>
                <button class="border rounded px-3 pt-1 flex items-center jusitfy-center">
                    <i style="color: #FFB822" class="text-xl far fa-video"></i>
                </button>
                <button class="border rounded px-3 pt-1 flex items-center jusitfy-center">
                    <i class="text-xl fal fa-ellipsis-h-alt"></i>
                </button>
            </div>
        </div>
        <div class="room__content gap-4 flex-grow flex flex-col-reverse px-5">
            <div class="room__chat room__chat--left">
                <div class="room__chat--avatar">
                    <img class="w-10 h-10 rounded-full" src="{{ Auth::user()->profile->avatar }}" alt="Rounded avatar">
                </div>
                <div class="room__chat--content">
                    <p class="room__chat--text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquid animi asperiores doloremque
                        ea eius eligendi error et fugit iste nesciunt nihil, obcaecati omnis optio, reiciendis suscipit
                        totam veniam voluptatum.
                    </p>
                </div>
            </div>
            <div class="room__chat room__chat--right">
                <div class="room__chat--avatar">
                    <img class="w-10 h-10 rounded-full" src="{{ Auth::user()->profile->avatar }}" alt="Rounded avatar">
                </div>
                <div class="room__chat--content">
                    <p class="room__chat--text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquid animi asperiores doloremque
                        ea eius eligendi error et fugit iste nesciunt nihil, obcaecati omnis optio, reiciendis suscipit
                        totam veniam voluptatum.
                    </p>
                </div>
            </div>
            <div class="chat__message flex justify-center my-2">
                <p class="chat__message--notify text-gray-500 text-md">
                    Thông báo
                </p>
            </div>
        </div>
        <div class="room__footer flex-shrink">
            <form class="footer__input flex-grow px-5 py-3 flex items-center gap-5">
                <input type="text" id="base-input"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <div class="footer__buttons flex">
                    <button type="button"
                            class="relative border border-gray-400 bg-gray-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800">
                        <i class="far text-md fa-image"></i>
                        <label for="input-file" class="cursor-pointer absolute top-0 left-0 right-0 bottom-0"></label>
                        <input type="file" hidden id="input-file">
                    </button>
                    <button type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm p-3 text-center inline-flex items-center mr-2 ">
                        <i class="far text-md fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
