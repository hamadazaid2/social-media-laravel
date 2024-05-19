<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Categories
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Create Categery
                            </h2>
                        </header>

                        <form method="post" action="{{ route('posts.store') }}" class="mt-6 space-y-6">
                            @csrf
                            <div>
                                <label class="block font-medium text-sl text-gray-700 dark:text-gray-300 ">
                                    Your Post
                                </label>
                                <textarea name="content" rows="10" cols="50"
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full h-48 resize-none"></textarea>
                                <div class="mb-4">
                                    <label for="category"
                                        class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Select
                                        Category</label>
                                    <select name="category_id" id="category"
                                        class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                        <option value="">-- Select a Category --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>

                                    @error('category')
                                        <div class="mt-1 text-xs text-red-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Post
                                </button>
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>


</x-app-layout>
