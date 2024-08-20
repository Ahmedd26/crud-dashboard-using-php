<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/public/css/tailwind.css" rel="stylesheet">
    <title>Register</title>
    <script src="../theme-toggle.js" defer></script>

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
                    <li class="flex items-center">
                        <a href="?page=register" class="active-link" aria-current="page">Register</a>
                    </li>
                    <li class="flex items-center">
                        <a href="?page=login" class="link">Login</a>
                    </li>
                    <li>
                        <button class="secondary-btn" onclick="toggleDarkMode()">
                            Toggle theme
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Form -->
    <div class="my-8 max-w-xl mx-auto">
        <div class="p-4 md:p-5">
            <form class="space-y-5" action="?page=register" method="POST" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="register">
                <div>
                    <?php if (array_key_exists("name", $_SESSION['errors'])): ?>
                        <label for="name" class="label !text-red-500">
                            <?= $_SESSION['errors']["name"] ?>
                        </label>
                    <?php else: ?>
                        <label for="name" class="label">Name</label>
                    <?php endif ?>
                    <input type="text" name="name" id="name" class="basic-input" placeholder="John Doe" required />
                </div>
                <div>
                    <?php if (array_key_exists("email", $_SESSION['errors'])): ?>
                        <label for="email" class="label !text-red-500">
                            <?= $_SESSION['errors']["email"] ?>
                        </label>
                    <?php else: ?>
                        <label for="email" class="label">Email</label>
                    <?php endif ?> <input type="email" name="email" id="email" class="basic-input"
                        placeholder="name@company.com" required />
                </div>
                <div>
                    <?php if (array_key_exists("password", $_SESSION['errors'])): ?>
                        <label for="password" class="label !text-red-500">
                            <?= $_SESSION['errors']["password"] ?>
                        </label>
                    <?php else: ?>
                        <label for="password" class="label">Password</label>
                    <?php endif ?>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="basic-input"
                        required />
                </div>
                <div>
                    <?php if (array_key_exists("confirmPassword", $_SESSION['errors'])): ?>
                        <label for="confirmPassword" class="label !text-red-500">
                            <?= $_SESSION['errors']["confirmPassword"] ?></label>
                    <?php else: ?>
                        <label for="confirmPassword" class="label">Confirm password</label>
                    <?php endif ?>
                    <input type="password" name="confirmPassword" id="confirmPassword" placeholder="••••••••"
                        class="basic-input" required />
                </div>
                <div>
                    <?php if (array_key_exists("profilePicture", $_SESSION['errors'])): ?>
                        <label for="file_input" class="label !text-red-500">
                            <?= $_SESSION['errors']["profilePicture"] ?>
                        </label>
                    <?php else: ?>
                        <label for="file_input" class="label">Profile picture</label>
                    <?php endif ?>
                    <input class="file-input" id="file_input" type="file" name="profilePicture">
                    <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, or JPG
                        (MAX. SIZE 5MB).</p>
                </div>
                <button type="submit" class="full-btn">Register</button>
                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                    Already have an account? <a href="?page=login"
                        class="text-blue-700 hover:underline dark:text-blue-500">Login
                    </a>
                </div>
                <div>
                    <?php if (array_key_exists("internal_error", $_SESSION['errors'])): ?>
                        <div class='alert' role='alert'>
                            <?= $_SESSION['errors']['internal_error'] ?>
                        </div>
                    <?php endif ?>
                </div>
            </form>
        </div>
    </div>

    <script src="/node_modules/flowbite/dist/flowbite.js"></script>
</body>

</html>