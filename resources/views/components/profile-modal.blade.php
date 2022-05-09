<div id="profile_modal" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-full h-full max-w-lg p-4 md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 overflow-hidden">
            <div class="flex items-center justify-between p-5 bg-gray-100">
                <div class="flex items-center gap-3">
                    <i class="font-bold fal fa-pen"></i>
                    <p class="text-lg font-semibold">Hồ sơ</p>
                </div>
                <button type="button"
                    class=" text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    data-modal-toggle="profile_modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="px-6 py-6 lg:px-8">
                <form class="space-y-4" id="form_edit_profile">
                    <div>
                        <label for="txt_full_name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Họ và tên</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="far fa-user-alt"></i>
                            </div>
                            <input type="text" name="full_name" value="{{ Auth::user()->full_name }}"
                                id="txt_full_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Nguyen Van A">
                        </div>
                    </div>
                    <div>
                        <label for="txt_email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="far fa-user-alt"></i>
                            </div>
                            <input disabled type="text" name="email" value="{{ Auth::user()->email }}" id="txt_email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            for="user_avatar">Ảnh đại diện</label>
                        <div class="flex gap-3">
                            <img class="w-10 h-10 rounded-full" src="{{ Auth::user()->avatar }}"
                                id="user_avatar_preview" alt="Rounded avatar">
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                aria-describedby="user_avatar_help" id="user_avatar" type="file">
                        </div>
                    </div>
                    <div>
                        <label for="txt_phone"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Số điện thoại</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="far fa-user-alt"></i>
                            </div>
                            <input type="text" name="phone" value="{{ Auth::user()->profile->phone ?? "" }}" id="txt_phone"
                                placeholder="( 543 ) 123 - 456"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label for="txt_address"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Địa chỉ</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="far fa-user-alt"></i>
                            </div>
                            <input type="text" name="address" value="{{ Auth::user()->profile->address ?? "" }}"
                                id="txt_address" placeholder="Address"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label for="txt_country"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Quốc gia</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="far fa-user-alt"></i>
                            </div>
                            <input type="text" name="country" value="{{ Auth::user()->profile->country ?? "" }}"
                                id="txt_country" placeholder="Country"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label for="about_myself" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Giới thiệu bản thân</label>
                        <textarea id="about_myself"  rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Hãy ghi gì đó...">{{ Auth::user()->profile->about_myself ?? "" }}</textarea>
                    </div>
                    <div class="flex justify-end items-center">
                        <button type="submit"
                            class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
