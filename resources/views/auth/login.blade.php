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
            <div class="col-span-4">
                <div class="flex items-center gap-2">
                    <svg class="w-8 h-8 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    <p class="text-2xl font-bold">Doot</p>
                </div>
                <img class="bgr" src="https://doot-light.react.themesbrand.com/static/media/auth-img.9302755e.png" alt="">
            </div>
            <div class="col-span-8 h-full bg-white content flex flex-col">
                <div class="mx-auto flex items-center justify-center flex-col h-full w-full">
                    <div class="flex flex-col items-center gap-3 mb-8">
                        <h1 class="text-2xl font-semibold">Welcome Back !</h1>
                        <p class="text-lg text-gray-500">Sign in to continue to Doot</p>
                    </div>
                    <form class="wrapper-form mb-6">
                        <div class="mb-6">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your email</label>
                            <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com" required>
                        </div>
                        <div class="mb-6">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your password</label>
                            <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>
                        <div class="flex items-start mb-6">
                            <div class="flex items-center h-5">
                                <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-green-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="remember" class="font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                            </div>
                        </div>
                        <button type="submit" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Log In</button>
                    </form>
                    <div class="wrapper-line mb-6">
                        <div class="line"></div>
                        <p class="text-md font-semibold">Sign in with</p>
                        <div class="line"></div>
                    </div>
                    <div class="wrapper-button-social mb-6">
                        <button type="button" class="w-full text-white bg-[#ea4335] hover:bg-[#ea4335]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex justify-center items-center dark:focus:ring-[#ea4335]/55 mr-2 mb-2">
                            <svg class="w-4 h-4 mr-2 -ml-1" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512">
                                <path fill="currentColor" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"></path>
                            </svg>
                            Sign in with Google
                        </button>
                    </div>
                    <div>
                        <p class="text-gray-500">Don't have account ? <a href="/auth/register" class="font-semibold text-[#4eac6d]">Register</a></p>
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