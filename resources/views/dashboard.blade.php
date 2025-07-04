<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ $scopedPath->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold">{{ $scopedPath->name }} Dashboard</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">Welcome, {{ $user->name }}</span>
                        <form method="POST" action="{{ route('scoped.logout', $currentPath) }}">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto py-6 px-4">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Access Information</h2>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Current Path</dt>
                            <dd class="mt-1 text-sm text-gray-900">/{{ $currentPath }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Organization</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $scopedPath->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">User Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Access Level</dt>
                            <dd class="mt-1 text-sm text-gray-900">Scoped User</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="text-lg font-medium text-blue-900 mb-2">🎉 Success!</h3>
                <p class="text-blue-800">
                    You have successfully logged in through your assigned path. 
                    This demonstrates that the path-based scoped access system is working correctly.
                </p>
            </div>

            <!-- Sample Application Content -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-chart-bar text-2xl text-indigo-600"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Analytics</dt>
                                    <dd class="text-lg font-medium text-gray-900">View Reports</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-users text-2xl text-green-600"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Team</dt>
                                    <dd class="text-lg font-medium text-gray-900">Manage Team</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-cog text-2xl text-gray-600"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Settings</dt>
                                    <dd class="text-lg font-medium text-gray-900">Configure</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</body>
</html>