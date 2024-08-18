<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/public/css/tailwind.css" rel="stylesheet">
    <title>Login</title>
</head>

<body class="dark:bg-gray-800">
    <!-- Navbar -->
    <nav class="nav">
        <div class="">
            <a href="?page=home" class="text-2xl font-semibold text-gray-900 dark:text-white">Dashboard</a>

            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="nav-ul">
                    <li>
                        <a href="?page=register" class="link">Register</a>
                    </li>
                    <li>
                        <a href="?page=login" class="link" aria-current="page">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Body -->
    <!-- Hero Section -->

    <div
        class="sm:container mx-4 sm:mx-auto mt-8 flex flex-col-reverse sm:flex-row items-center justify-center sm:items-stretch sm:justify-between p-6 sm:p-8 bg-white dark:bg-gray-900 shadow-lg rounded-lg">
        <!-- Left Side: Welcome Message and User Info -->
        <div class="flex flex-col items-start">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">Welcome Back! <span id="username"
                    class="text-blue-500">John</span></h1>
            <div class="mt-4 flex items-center">
                <img src="https://www.w3schools.com/w3images/avatar2.png" alt="Profile Picture"
                    class="w-16 h-16 rounded-full border-2 border-gray-300">


                <div class="ml-4">
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Email: <span id="email"
                            class="text-blue-500">user@example.com</span></p>
                </div>
            </div>
            <div class="mt-6 sm:mt-auto">
                <button type="button" class="default-btn">Edit your info</button>
                <button type="button" class="danger-btn ">Delete your account</button>
            </div>
        </div>

        <!-- Right Side: Illustration -->
        <div class="">
            <img src="https://i.pinimg.com/originals/dd/5a/31/dd5a31c736d9944eccd18bc9372274ab.png"
                alt="Welcome Illustration" class="w-64 h-auto">
        </div>
    </div>

    <script src=" /node_modules/flowbite/dist/flowbite.js"></script>
</body>

</html>