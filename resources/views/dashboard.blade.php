<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ASyne</title>
    @vite('resources/css/app.css')
</head>
<body class="font-sans text-gray-800 bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-blue-600">ASyne</span>
                    </div>
                    <div class="flex items-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-blue-600 px-3 py-2">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="border-4 border-dashed border-gray-200 rounded-lg h-96 p-8 text-center">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome to your Dashboard!</h1>
                    <p class="text-gray-600 mb-6">You are successfully logged in to ASyne.</p>
                    <div class="bg-white rounded-lg shadow-md p-6 max-w-md mx-auto">
                        <h2 class="text-xl font-semibold mb-4">User Information</h2>
                        <p class="text-gray-700"><strong>Name:</strong> {{ Auth::user()->fullName }}</p>
                        <p class="text-gray-700"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p class="text-gray-700"><strong>Role:</strong> {{ Auth::user()->role }}</p>
                        <p class="text-gray-700"><strong>Status:</strong> {{ Auth::user()->status }}</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
