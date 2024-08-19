<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/public/css/tailwind.css" rel="stylesheet">
    <title>Dashboard</title>
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
                <form method="POST" class="flex items-center">
                    <input type="hidden" name="logout">
                    <button type="submit" class="default-btn !m-0">logout</button>
                </form>
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
                    class="text-blue-500"><?= $loggedInUser['full_name'] ?></span></h1>
            <div class="mt-4 flex items-center">
                <img src="./uploads/<?= $loggedInUser['profile_picture'] ?>"
                    class="w-16 h-16 rounded-full border-2 border-gray-300 bg-profile-placeholder bg-center bg-cover">


                <div class="ml-4">
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Email: <span id="email"
                            class="text-blue-500"><?= $loggedInUser['email'] ?></span></p>
                </div>
            </div>
            <div class="mt-6 sm:mt-auto flex items-center gap-2">
                <button type="button" class="default-btn">Edit your info</button>
                <form method="POST">
                    <input type="hidden" name="deleteSelf" value="<?= $loggedInUser['id'] ?>">
                    <button type="submit" class="danger-btn ">Delete your account</button>
                </form>
            </div>
        </div>

        <!-- Right Side: Illustration -->
        <div class="">
            <img src="https://i.pinimg.com/originals/dd/5a/31/dd5a31c736d9944eccd18bc9372274ab.png"
                alt="Welcome Illustration" class="w-64 h-auto">
        </div>
    </div>

    <!-- Show Users -->
    <section class="bg-white dark:bg-gray-800">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-6">
            <div class="mx-auto mb-8 max-w-screen-sm lg:mb-16">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Manage team</h2>
                <ev class="font-light text-gray-500 sm:text-xl dark:text-gray-400">Preview current registered users,
                    update, or remove them.</ev>
            </div>
            <div class="grid gap-8 lg:gap-16 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <?php foreach ($users as $user): ?>
                    <?php if ($user['id'] == $loggedInUser['id'])
                        continue; ?>
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        <img class="mx-auto mb-4 w-36 h-36 rounded-full bg-profile-placeholder bg-center bg-cover"
                            src="./uploads/<?= $user['profile_picture'] ?>" alt="Bonnie Avatar">
                        <h3 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            <?= $user['full_name'] ?>
                        </h3>
                        <p>Email: <span class="text-blue-500"><?= $user['email'] ?></span></p>
                        <div class="mt-4 max-w-60 mx-auto flex justify-center gap-2">
                            <button class="default-btn flex-1">Edit</button>
                            <button data-modal-target="popup-modal-<?= $user['id'] ?>"
                                data-modal-toggle="popup-modal-<?= $user['id'] ?>" class="danger-btn flex-1"
                                type="button">Remove</button>
                            <!-- DELETE MODAL -->
                            <div id="popup-modal-<?= $user['id'] ?>" tabindex="-1"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button"
                                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="popup-modal-<?= $user['id'] ?>">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-4 md:p-5 text-center flex items-center flex-col">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you
                                                sure you want
                                                to delete user <br /> <span class="text-gray-100 font-semibold">
                                                    <?= $user['full_name'] ?></span></h3>
                                            <div class="flex items-center justify-center gap-4">
                                                <form method="POST" class="flex items-center flex-1">
                                                    <input type="hidden" name="deleteUser" value="<?= $user['id'] ?>">
                                                    <button data-modal-hide="popup-modal-<?= $user['id'] ?>" type="submit"
                                                        class="danger-btn m-0">
                                                        Yes, I'm sure
                                                    </button>
                                                </form>
                                                <button data-modal-hide="popup-modal-<?= $user['id'] ?>" type="button"
                                                    class="secondary-btn">No,
                                                    cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>




        </div>
    </section>


    <script src=" /node_modules/flowbite/dist/flowbite.js"></script>
</body>

</html>