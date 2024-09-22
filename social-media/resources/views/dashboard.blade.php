<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Card for the post creation and display section -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                
                <!-- Welcome message for the logged-in user -->
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-700">Welcome, {{ Auth::user()->name }}!</h1>
            
                </div>

                <!-- Create a New Post Button -->
                <div class="text-center mb-8">
                    <a href="{{ url('posts/index.html') }}" class="px-6 py-3 bg-blue-500 hover:bg-blue-700 text-black font-bold rounded-md shadow-md transition duration-500 ease-in-out">
                       CREATE YOUR NEW POST HERE!!
                    </a>
                </div>

                <!-- Your Posts Section Title -->
                <h3 class="text-xl font-bold text-gray-700 mb-6 text-center">Posts</h3>

                <!-- Posts Display Section -->
                @if ($posts->isEmpty())
                    <p class="text-gray-500 text-center">No posts yet. Start sharing your thoughts!</p>
                @else
                    <div class="space-y-6">
                        @foreach ($posts as $post)
                            <!-- Post Card -->
                            <div class="bg-gray-50 p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out">
                                <div class="flex items-start justify-between">
                                    <!-- Post Content -->
                                    <div class="flex-1">
                                        <p class="text-gray-800 text-lg mb-2">{{ $post->content }}</p>
                                        <div class="text-gray-500 text-sm">
                                            <small>By <span class="font-bold">{{ $post->user->name }}</span> on {{ $post->created_at->format('d-m-Y H:i') }}</small>
                                        </div>
                                    </div>

                                    <!-- Action Buttons (like, comment, etc.) -->
                                    <div class="ml-4 flex items-center space-x-4">
                                        <button class="text-gray-500 hover:text-red-600 transition duration-200 ease-in-out">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15a7 7 0 1114 0H5z" />
                                            </svg>
                                        </button>

                                        <button class="text-gray-500 hover:text-blue-600 transition duration-200 ease-in-out">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8m-4-4v8" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
