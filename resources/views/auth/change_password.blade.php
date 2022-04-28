<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>Change Password</title>
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
        <div class="lg:col-span-8 col-span-12 h-full bg-white content flex flex-col">
            <div class="mx-auto flex items-center justify-center flex-col h-full w-full">
                <p class="text-2xl font-semibold mb-6">Change Password</p>
                <form action="{{ url('/auth/change-password') }}" method="POST" role="form" class="wrapper-form mb-6">
                    {{ csrf_field() }}
                    <div class="mb-6">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Password</label>
                        <input type="password" id="password"
                               name="password"
                               placeholder="******************"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               required>
                        @if($errors->has('password'))
                            <p class="text-red-700">{{ $errors->first('password') }}</p>
                        @endif
                    </div>
                    <div class="mb-6">
                        <label for="password_confirm"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Confirm
                            Password</label>
                        <input type="password" id="password_confirm"
                               name="password_confirm"
                               placeholder="******************"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               required>
                        @if($errors->has('password_confirm'))
                            <p class="text-red-700">{{ $errors->first('password_confirm') }}</p>
                        @endif
                        @if(isset($password_error))
                            <p class="text-red-700">{{ $password_error }}</p>
                        @endif
                    </div>
                    <button type="submit"
                            class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Change
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>
