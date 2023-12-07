<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset=UTF-8>

    <meta name=viewport content="width=device-width, initial-scale=1.0">
    <script src=https://cdn.tailwindcss.com></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <link href=https://cdn.jsdelivr.net/npm/daisyui@4.4.6/dist/full.min.css rel=stylesheet type=text/css />
    <title>Document</title>
</head>

<body class="bg-[#ECECF8]">
    <?php
    include("../includes/navbar.php");
    include("./sidebar.php");
    include("db.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add-category"])) {
        $categoryName = mysqli_real_escape_string($conn, $_POST["category-name"]);
        $insertQuery = "INSERT INTO categories (name) VALUES ('$categoryName')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            echo '<script>alert("Category added successfully!");</script>';
        } else {
            echo '<script>alert("Error adding category: ' . mysqli_error($conn) . '");</script>';
        }
    }
    ?>
    <div class="p-5 mt-14 sm:ml-64">
        <div class="relative overflow-x-auto sm:rounded-lg">
            <div
                class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 dark:bg-gray-900">


                <button onclick="my_modal_3.showModal()"
                    class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                    type="button">
                    Add Category
                </button>
                <dialog id="my_modal_3" class="modal">
                    <div class="modal-box">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>
                        <div class="mt-4 ">
                            <h2 class="text-xl font-semibold mb-2">Add New Category</h2>
                            <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                <label for="category-name" class="sr-only">Category Name</label>
                                <input type="text" id="category-name" name="category-name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Enter category name" required>
                                <button type="submit"
                                    class="mt-2 p-2.5 text-sm font-medium text-white bg-[#2F329F] rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                    name="add-category">
                                    Add Category
                                </button>
                            </form>
                        </div>

                    </div>
                </dialog>

                <label for="table-search" class="sr-only">Search</label>

                <form method="post" action="" id="searchForm" class=" flex items-center">
                    <div class=" w-full">
                        <input type="text" id="simple-search" name="searchTerm"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search for a category" required>
                    </div>
                    <button type="submit" id="searchButton"
                        class="p-2.5 ms-2 text-sm font-medium text-white bg-[#2f9f5c] rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </button>
                </form>

            </div>
            <?php
          
              include("./get_plants.php") ?>


        </div>
    </div>
    <script src="../js/script.js"></script>

    <script src="../js/ajax.js"></script>
</body>


</html>