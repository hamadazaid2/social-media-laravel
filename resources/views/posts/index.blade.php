<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Posts
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('posts.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                New Post
            </a>
            @forelse ($posts as $post)
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-6">
                    <div class="flex items-start space-x-4">
                        <!-- User Profile Picture -->
                        <img class="w-12 h-12 rounded-full object-cover" src="{{ $post->user->profile_picture }}"
                            alt="{{ $post->user->name }}">
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <!-- User Name and Follow Button -->
                                    <div class="flex items-center space-x-2">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $post->user->name }}
                                        </h4>
                                        <!-- Follow Button -->
                                        @if (Auth::user()->id !== $post->user->id)
                                            @if (Auth::user()->isFollowing($post->user->id))
                                                <form
                                                    action="{{ route('followers.custom_destroy', ['follower_user_id' => $post->user->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="follower_user_id"
                                                        value="{{ $post->user->id }}">
                                                    <button type="submit"
                                                        class="px-2 py-1 bg-red-600 text-white rounded-md text-sm hover:bg-red-500 focus:outline-none focus:bg-red-700">
                                                        Unfollow
                                                    </button>
                                                </form>
                                            @else
                                                <form
                                                    action="{{ route('followers.store', ['follower_user_id' => $post->user->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-2 py-1 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-500 focus:outline-none focus:bg-blue-700">
                                                        Follow
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                    <!-- Post Created At -->
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $post->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <!-- Settings Dropdown -->
                                <div class="relative" x-data="{ open: false }"
                                    x-show="{{ $post->user->id === auth()->user()->id ? 'true' : 'false' }}">
                                    <button @click="open = !open"
                                        class="text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-400">
                                        <!-- Three Dots Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6h.01M12 12h.01M12 18h.01" />
                                        </svg>
                                    </button>
                                    <!-- Dropdown Menu -->
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 shadow-lg rounded-lg py-1">
                                        <a href="{{ route('posts.edit', $post) }}"
                                            class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Edit</a>
                                        <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="block w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Post Content -->
                            <div class="mt-4 text-gray-800 dark:text-gray-200">
                                {{ $post->content }}
                            </div>
                            <!-- Like and Comment Buttons -->
                            <div class="mt-4 flex items-center space-x-4">
                                <!-- Like Button -->
                                <form action="{{ route('reaction', ['post_id' => $post->id]) }}" method="post">
                                    @csrf
                                    <button
                                        class="flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M2 10a8 8 0 1115.32 3.905l.568 2.274a1 1 0 01-1.496 1.05l-2.027-.996a8.033 8.033 0 01-11.967-6.812 7.978 7.978 0 012.735-6.02A7.978 7.978 0 0110 2zm4-1h6a1 1 0 010 2H6a1 1 0 010-2zm0 4h4a1 1 0 010 2H6a1 1 0 010-2z" />
                                        </svg>
                                        <span>Like</span>
                                        <!-- Display Reaction Count -->
                                        <span
                                            class="ml-1 text-gray-600 dark:text-gray-300">{{ $post->reactions_count }}</span>
                                    </button>
                                </form>
                                <!-- Comment Button -->
                                <button @click="open = !open"
                                    class="flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M18 10a8 8 0 10-8 8 8 8 0 008-8zm-4 1h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 112 0v3h3a1 1 0 110 2z" />
                                    </svg>
                                    <span>Comment</span>
                                </button>
                            </div>
                            <!-- Add Comment Input -->
                            <div class="mt-2" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-500 focus:outline-none">
                                    Reply
                                </button>
                                <div x-show="open">
                                    <form action="{{ route('comments.store', ['post_id' => $post->id]) }}"
                                        method="POST">
                                        @csrf
                                        <textarea name="comment"
                                            class="mt-2 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300"
                                            rows="3" placeholder="Write your reply here..."></textarea>
                                        <div class="flex justify-end mt-2">
                                            <button type="submit"
                                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500 focus:outline-none focus:bg-indigo-700">
                                                Comment
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Comments Section -->
                            <div class="mt-6">
                                <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Comments</h5>
                                @foreach ($post->comments as $comment)
                                    <div class="mt-4">
                                        <div class="flex items-center space-x-2">
                                            <!-- Commenter Profile Picture -->
                                            <img class="w-8 h-8 rounded-full object-cover"
                                                src="{{ $comment->user->profile_picture }}"
                                                alt="{{ $comment->user->name }}">
                                            <!-- Commenter Name and Content -->
                                            <div>
                                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-300">
                                                    {{ $comment->user->name }}
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $comment->comment }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg" style="color: white"> No
                    Categories Yet!</div>
            @endforelse
            {{ $posts->links() }}

        </div>

</x-app-layout>
