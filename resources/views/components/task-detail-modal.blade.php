<div id="task-detail-modal" tabindex="-1" aria-hidden="true" data-task=""
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Chi tiết công việc
                </h3>
                <button type="button"
                        class="btn-cancel-modal-task text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6 grid grid-cols-3">
                <div class="detail__left col-span-2 flex  pr-3 flex-col">
                    <div class="left__title flex-shrink">
                        <p class="title__text text-task-edit text-xl font-semibold">Title</p>
                        <div class="mb-6 hidden input-task-edit">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tiêu
                                đề</label>
                            <input type="text" id="title"
                                   class="title__text bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>

                    <div class="left__content flex-grow">
                        <p class="text-task-edit left__content--text">Content Content Content Content Content Content
                            Content Content Content Content Content
                            Content</p>
                        <div class="mb-6 hidden input-task-edit">
                            <label for="message"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Nội
                                dung</label>
                            <textarea id="message" rows="4"
                                      class="left__content--text block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="Nội dung chính"></textarea>
                        </div>
                    </div>

                    <div class="left__due flex-shrink">
                        <p class="text-sm text-task-edit left__due--text">Thời gian</p>
                        <div class="mb-6 hidden input-task-edit">
                            <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Thời
                                hạn</label>
                            <input type="datetime-local"
                                   class="left__due--text bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <div class="right flex flex-col gap-3">
                    <div class="right__status">
                        <p class="status__title mb-2">
                            Trạng thái
                        </p>
                        <div class="flex gap-3">
                            <i class="fas text-sm text-blue-500 fa-circle"></i>
                            <p class="text-sm">Đã đã nhận</p>
                        </div>
                    </div>
                    <div class="right__users">
                        <p class="users__title mb-2">
                            Người thực hiện
                        </p>
                        <div class="flex -space-x-4" id="task-performers">

                        </div>
                    </div>
                    <div class="right__action flex flex-col">
                        <p class="mb-2">Tác vụ</p>

                        <div class="flex flex-col gap-3">
                            <button class="bg-gray-100 p-3 rounded-sm flex items-center w-full">
                                <input id="default-checkbox" type="checkbox" disabled value=""
                                       class="cursor-pointer w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="default-checkbox"
                                       class="cursor-pointer ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Hoàn
                                    thành</label>
                            </button>
                            <button class="bg-gray-100 btn-open-input-task p-3 rounded-sm flex items-center w-full">
                                <i class="fas fa-pen"></i>
                                <p class="cursor-pointer ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    Chỉnh sửa</p>
                            </button>
                            <button class="btn-delete-task bg-gray-100 p-3 rounded-sm flex items-center w-full">
                                <i class="far text-red-500 fa-trash"></i>
                                <p class="cursor-pointer ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Xoá
                                    công việc</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                <button type="button"
                        id="btn-save-task-detail"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Lưu thay đổi
                </button>
                <button type="button"
                        class="btn-cancel-modal-task text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    Huỷ bỏ
                </button>
            </div>
        </div>
    </div>
</div>
