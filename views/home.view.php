<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/public/css/tailwind.css" rel="stylesheet">
    <title>Dashboard</title>
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
                <div class="flex items-center gap-2">
                    <button class="secondary-btn" onclick="toggleDarkMode()">
                        Toggle theme
                    </button>
                    <form method="POST" class="flex items-center">
                        <input type="hidden" name="logout">
                        <button type="submit" class="default-btn !m-0">logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <!-- Body -->
    <!-- Hero Section -->
    <div
        class="mx-4 sm:container sm:mx-auto mt-8 flex flex-col-reverse sm:flex-row items-center justify-center sm:items-stretch sm:justify-between p-6 sm:p-8 bg-white dark:bg-gray-900 shadow-lg rounded-lg">
        <!-- Left Side: Welcome Message and User Info -->
        <div class="flex flex-col">
            <div class="flex flex-col sm:flex-row  sm:items-start items-center gap-4">
                <img src="./public/uploads/<?= $loggedInUser['profile_picture'] ?>"
                    class="h-32 w-32 rounded-full border-2 border-gray-300 bg-profile-placeholder bg-cover bg-center object-cover" />

                <div class="flex flex-col items-center sm:items-start gap-4 ">
                    <h1 class="text-center text-3xl font-bold text-gray-800 dark:text-gray-200 sm:text-start">
                        Welcome Back!
                        <span id="username"
                            class="block text-blue-500 sm:mt-1.5 lg:inline"><?= $loggedInUser['full_name'] ?></span>
                    </h1>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                        Email:
                        <span id="email" class="text-blue-500"><?= $loggedInUser['email'] ?></span>
                    </p>
                </div>
            </div>
            <div class="mt-6 max-w-sm grid grid-cols-2 items-center gap-2 sm:mt-auto ">
                <!-- UPDATE: Modal toggle -->
                <button type="button" data-modal-target="authentication-modal-<?= $loggedInUser['id'] ?>"
                    data-modal-toggle="authentication-modal-<?= $loggedInUser['id'] ?>" class="default-btn">
                    Edit info
                </button>

                <button data-modal-target="popup-modal-<?= $loggedInUser['id'] ?>"
                    data-modal-toggle="popup-modal-<?= $loggedInUser['id'] ?>" class="danger-btn" type="button">
                    Delete account
                </button>
                <!-- DELETE MODAL -->
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
                    edit, or remove them.</ev>
            </div>
            <div class="grid gap-8 lg:gap-16 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <?php foreach ($users as $user): ?>
                    <?php if ($user['id'] == $loggedInUser['id'])
                        continue; ?>
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        <img class="team-avatar" src="./public/uploads/<?= $user['profile_picture'] ?>"
                            alt="<?= $user['full_name'] ?>">
                        <h3 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            <?= $user['full_name'] ?>
                        </h3>
                        <p>Email: <span class="text-blue-500"><?= $user['email'] ?></span></p>
                        <div class="mt-4 max-w-60 mx-auto flex justify-center gap-2">
                            <button type="button" data-modal-target="authentication-modal-<?= $user['id'] ?>"
                                data-modal-toggle="authentication-modal-<?= $user['id'] ?>" class="default-btn flex-1">Edit
                                info</button>
                            <button data-modal-target="popup-modal-<?= $user['id'] ?>"
                                data-modal-toggle="popup-modal-<?= $user['id'] ?>" class="danger-btn flex-1"
                                type="button">Remove</button>
                            <!--** ** ** UPDATE: Main modal ** ** **-->
                            <!--** ** ** UPDATE: Main modal ** ** **-->
                            <!--** ** ** UPDATE: Main modal ** ** **-->
                            <div id="authentication-modal-<?= $user['id'] ?>" tabindex="-1" aria-hidden="true"
                                class="<?php if (!$persistModal) {
                                    echo 'hidden';
                                } else {
                                    echo 'flex';
                                } ?> overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Edit <?= $user['full_name'] ?> info
                                            </h3>
                                            <form method="POST">
                                                <input type="hidden" name="closeModal" value="true">
                                                <button type="submit"
                                                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-hide="authentication-modal-<?= $user['id'] ?>">
                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </form>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5">
                                            <!--** ** **  UPDATE FORM ** ** **-->
                                            <!--** ** **  UPDATE FORM ** ** **-->
                                            <!--** ** **  UPDATE FORM ** ** **-->
                                            <form class="space-y-4" action="?page=home" method="POST" novalidate
                                                enctype="multipart/form-data">
                                                <!-- username -->
                                                <div class="flex flex-col items-start justify-start">
                                                    <?php if (array_key_exists("name", $errors)): ?>
                                                        <label for="name" class="label !text-red-950 text-start">
                                                            <?= $errors["name"] ?>
                                                        </label>
                                                    <?php else: ?>
                                                        <label for="name" class="label">Name</label>
                                                    <?php endif ?>
                                                    <input type="text" name="name" id="name" class="basic-input"
                                                        placeholder="john.doe@example.com" />
                                                </div>
                                                <!-- Password -->
                                                <div class="flex flex-col items-start justify-start">
                                                    <?php if (array_key_exists("password", $errors)): ?>
                                                        <label for="password" class="label !text-red-950 text-start">
                                                            <?= $errors["password"] ?>
                                                        </label>
                                                    <?php else: ?>
                                                        <label for="password" class="label">Password</label>
                                                    <?php endif ?>
                                                    <input type="password" name="password" id="password"
                                                        placeholder="••••••••" class="basic-input" />
                                                </div>
                                                <!-- Confirm password -->
                                                <div class="flex flex-col items-start justify-start">
                                                    <?php if (array_key_exists("confirmPassword", $errors)): ?>
                                                        <label for="confirmPassword" class="label !text-red-950 text-start">
                                                            <?= $errors["confirmPassword"] ?>
                                                        </label>
                                                    <?php else: ?>
                                                        <label for="confirmPassword" class="label">ConfirmPassword</label>
                                                    <?php endif ?>
                                                    <input type="password" name="confirmPassword" id="confirmPassword"
                                                        placeholder="••••••••" class="basic-input" />
                                                </div>
                                                <div class="flex flex-col items-start justify-start">
                                                    <?php if (array_key_exists("profilePicture", $errors)): ?>
                                                        <label for="file_input" class="label !text-red-950 text-start">
                                                            <?= $errors["profilePicture"] ?>
                                                        </label>
                                                    <?php else: ?>
                                                        <label for="file_input" class="label">Profile picture</label>
                                                    <?php endif ?>
                                                    <input class="file-input" id="file_input" type="file"
                                                        name="newProfilePicture">
                                                    <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-300"
                                                        id="file_input_help">
                                                        PNG, or JPG
                                                        (MAX. SIZE 5MB).</p>
                                                </div>

                                                <div class="flex items-center gap-2">
                                                    <input type="hidden" name="isEditing" value="otherEdit">
                                                    <input type="hidden" name="removeOldImage"
                                                        value="<?= $user['profile_picture'] ?>">
                                                    <button type="submit" name="editId" value="<?= $user['id'] ?>"
                                                        class="default-btn flex-1">Save edits</button>
                                                </div>

                                            </form>
                                            <form method="POST" class="mt-3.5 w-full">
                                                <input type="hidden" name="closeModal" value="true">
                                                <button type="submit" class="secondary-btn w-full ">cancel</button>
                                            </form>
                                            <?php if (array_key_exists("invalid", $errors)): ?>
                                                <div class='p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-900 border border-red-800 dark:text-red-400'
                                                    role='alert'>
                                                    <?= $errors['invalid'] ?>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                                    <input type="hidden" name="whoIsBeingDeleted" value="otherUser">
                                                    <input type="hidden" name="idToDelete" value="<?= $user['id'] ?>">
                                                    <input type="hidden" name="imageToDelete"
                                                        value="<?= $user['profile_picture'] ?>">
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



    <div id="popup-modal-<?= $loggedInUser['id'] ?>" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="popup-modal-<?= $loggedInUser['id'] ?>">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center flex items-center flex-col">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you
                        sure you want
                        to delete user <br /> <span class="text-gray-100 font-semibold">
                            <?= $loggedInUser['full_name'] ?></span></h3>
                    <div class="flex items-center justify-center gap-4">
                        <form method="POST" class="flex items-center flex-1">
                            <input type="hidden" name="whoIsBeingDeleted" value="self">
                            <input type="hidden" name="idToDelete" value="<?= $loggedInUser['id'] ?>">
                            <input type="hidden" name="imageToDelete" value="<?= $loggedInUser['profile_picture'] ?>">
                            <button data-modal-hide="popup-modal-<?= $loggedInUser['id'] ?>" type="submit"
                                class="danger-btn m-0">
                                Yes, I'm sure
                            </button>
                        </form>
                        <button data-modal-hide="popup-modal-<?= $loggedInUser['id'] ?>" type="button"
                            class="secondary-btn">No,
                            cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--** ** ** UPDATE SELF: Main modal ** ** **-->
    <!--** ** ** UPDATE SELF: Main modal ** ** **-->
    <div id="authentication-modal-<?= $loggedInUser['id'] ?>" tabindex="-1" aria-hidden="true"
        class="<?php if (!$persistModal) {
            echo 'hidden';
        } else {
            echo 'flex';
        } ?> overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit <?= $loggedInUser['full_name'] ?> info
                    </h3>
                    <form method="POST">
                        <input type="hidden" name="closeModal" value="true">
                        <button type="submit"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="authentication-modal-<?= $loggedInUser['id'] ?>">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </form>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <!--** ** **  UPDATE SELF FORM ** ** **-->
                    <!--** ** **  UPDATE SELF FORM ** ** **-->
                    <!--** ** **  UPDATE SELF FORM ** ** **-->
                    <form class="space-y-4" action="?page=home" method="POST" novalidate enctype="multipart/form-data">
                        <!-- username -->
                        <div class="flex flex-col items-start justify-start">
                            <?php if (array_key_exists("name", $errors)): ?>
                                <label for="name" class="label !text-red-950 text-start">
                                    <?= $errors["name"] ?>
                                </label>
                            <?php else: ?>
                                <label for="name" class="label">Name</label>
                            <?php endif ?>
                            <input type="text" name="name" id="name" class="basic-input"
                                placeholder="john.doe@example.com" />
                        </div>
                        <!-- Password -->
                        <div class="flex flex-col items-start justify-start">
                            <?php if (array_key_exists("password", $errors)): ?>
                                <label for="password" class="label !text-red-950 text-start">
                                    <?= $errors["password"] ?>
                                </label>
                            <?php else: ?>
                                <label for="password" class="label">Password</label>
                            <?php endif ?>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="basic-input" />
                        </div>
                        <!-- Confirm password -->
                        <div class="flex flex-col items-start justify-start">
                            <?php if (array_key_exists("confirmPassword", $errors)): ?>
                                <label for="confirmPassword" class="label !text-red-950 text-start">
                                    <?= $errors["confirmPassword"] ?>
                                </label>
                            <?php else: ?>
                                <label for="confirmPassword" class="label">ConfirmPassword</label>
                            <?php endif ?>
                            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="••••••••"
                                class="basic-input" />
                        </div>
                        <div class="flex flex-col items-start justify-start">
                            <?php if (array_key_exists("profilePicture", $errors)): ?>
                                <label for="file_input" class="label !text-red-950 text-start">
                                    <?= $errors["profilePicture"] ?>
                                </label>
                            <?php else: ?>
                                <label for="file_input" class="label">Profile picture</label>
                            <?php endif ?>
                            <input class="file-input" id="file_input" type="file" name="newProfilePicture">
                            <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">
                                PNG, or JPG
                                (MAX. SIZE 5MB).</p>
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="hidden" name="isEditing" value="selfEdit">
                            <input type="hidden" name="removeOldImage" value="<?= $loggedInUser['profile_picture'] ?>">
                            <button type="submit" name="editId" value="<?= $loggedInUser['id'] ?>"
                                class="default-btn flex-1">Save edits</button>
                        </div>

                    </form>
                    <form method="POST" class="mt-3.5 w-full">
                        <input type="hidden" name="closeModal" value="true">
                        <button type="submit" class="secondary-btn w-full ">cancel</button>
                    </form>
                    <?php if (array_key_exists("invalid", $errors)): ?>
                        <div class='p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-900 border border-red-800 dark:text-red-400'
                            role='alert'>
                            <?= $errors['invalid'] ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>


    <script src=" /node_modules/flowbite/dist/flowbite.js"></script>
    <?php if ($persistModal): ?>
        <div class='bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40'></div>
    <?php endif; ?>
</body>

</html>