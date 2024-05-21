<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Followers and Following
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Followers</h3>
                <ul>
                    @forelse ($followers as $follower)
                        <li class="flex items-center space-x-4 mb-4">
                            <img class="w-10 h-10 rounded-full" src="{{ $follower->following_user->profile_picture }}" alt="{{ $follower->following_user->name }}">
                            <div>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $follower->following_user->name }}</p>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $follower->following_user->email }}</p>
                            </div>
                        </li>
                    @empty
                        <p class="text-gray-600 dark:text-gray-400">No followers yet.</p>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Following</h3>
                <ul>
                    @forelse ($following as $follow)
                        <li class="flex items-center space-x-4 mb-4">
                            <img class="w-10 h-10 rounded-full" src="{{ $follow->follower_user->profile_picture }}" alt="{{ $follow->follower_user->name }}">
                            <div>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $follow->follower_user->name }}</p>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $follow->follower_user->email }}</p>
                            </div>
                        </li>
                    @empty
                        <p class="text-gray-600 dark:text-gray-400">No following users yet.</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
