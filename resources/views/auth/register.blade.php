<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>Login Chat App</title>
</head>

<body>
<div id="wrapper">
    <div class="grid grid-cols-12 h-full">
        <div class="lg:col-span-4 lg:block hidden">
            <div class="flex items-center gap-2">
                <svg class="w-8 h-8 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
                <p class="text-2xl font-bold">Doot</p>
            </div>
            <img class="bgr" src="https://doot-light.react.themesbrand.com/static/media/auth-img.9302755e.png" alt="">
        </div>
        <div class="lg:col-span-8 col-span-12 h-full bg-white content flex flex-col ">
            <div class="mx-auto flex items-center justify-center flex-col h-full w-full">
                <div class="flex flex-col items-center gap-3 mb-8">
                    <h1 class="text-2xl font-semibold">Welcome Back !</h1>
                    <p class="text-lg text-gray-500">Sign up to continue to Doot</p>
                </div>
                <form action="{{ url('/auth/register') }}" method="POST" role="form" class="w-full wrapper-form mb-6">
                    {{ csrf_field() }}
                    <div class="mb-6">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your
                            email</label>
                        <input type="text" name="email" id="email"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="name@flowbite.com">
                        @if($errors->has('email'))
                            <p class="text-red-700">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                    <div class="mb-6">
                        <label for="full_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Full Name</label>
                        <input type="text" name="full_name" id="full_name"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               >
                        @if($errors->has('full_name'))
                            <p class="text-red-700">{{ $errors->first('full_name') }}</p>
                        @endif
                    </div>
                    <button type="submit"
                            class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Sign Up
                    </button>
                </form>
                <div class="wrapper-line mb-6">
                    <div class="line"></div>
                    <p class="text-md font-semibold">Sign in with</p>
                    <div class="line"></div>
                </div>
                <div class="wrapper-button-social mb-6 w-full">
                    <a href="{{ url('/auth/google') }}" type="button"
                       class="w-full text-white bg-[#ea4335] hover:bg-[#ea4335]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex justify-center items-center dark:focus:ring-[#ea4335]/55 mr-2 mb-2">
                        <svg class="w-4 h-4 mr-2 -ml-1" aria-hidden="true" focusable="false" data-prefix="fab"
                             data-icon="google" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512">
                            <path fill="currentColor"
                                  d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"></path>
                        </svg>
                        Sign in with Google
                    </a>
                </div>
                <div>
                    <p class="text-gray-500">I already have an account ? <a href="{{ route('login') }}"
                                                                     class="font-semibold text-[#4eac6d]">Login</a>
                    </p>
                </div>
            </div>
            <div class="pb-5 flex items-center justify-center">
                <p class="font-semibold text-gray-500">© 2020 Doot. All rights reserved.</p>
            </div>
        </div>
    </div>
</div>
</body>

</html>
