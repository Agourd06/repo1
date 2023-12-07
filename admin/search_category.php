<?php
include("db.php");
include("sidebar.php");
include("navbar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchTerm"])) {
    $searchTerm = mysqli_real_escape_string($conn, $_POST["searchTerm"]);

    $query = "SELECT * FROM categories WHERE name LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $query);

    $categories = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.6/dist/full.min.css" rel="stylesheet" type="text/css" />
    <title>Document</title>
</head>

<body>
    <div class="p-5 mt-14 sm:ml-64">
        <div class="relative overflow-x-auto sm:rounded-lg">
            <table id="categoryTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Category Name</th>
                        <th>See Plants</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category) : ?>
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4"><?php echo $category['id']; ?></td>
                        <td class="px-6 py-4"><?php echo $category['name']; ?></td>
                        <td>
                            <button class="btn btn-success"
                                onclick="openModal('modal_<?php echo $category['id']; ?>')">Open</button>
                        </td>
                        <td>
                            <a href="./update_category.php?category_id=<?php echo $category['id']; ?>">
                                <button class="btn btn-warning">Edit</button>
                            </a>
                        </td>
                        <td>
                            <form method="post" action="./delete_category.php">
                                <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                                <button type="submit" name="delete-category" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php foreach ($categories as $category) : ?>
    <dialog id="modal_<?php echo $category['id']; ?>" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                    onclick="closeModal(<?php echo $category['id']; ?>)">✕</button>
            </form>
            <h3 class="font-bold text-lg text-center mx-auto">Plants in Category: <?php echo $category['name']; ?>
            </h3>
            <a href="./add.php">
                <button type="submit"
                    class="mt-2 p-2.5 text-sm font-medium text-white rounded-lg border border-green-600 bg-[#2f9f5c] focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-green-500"
                    name="add-plant">
                    Add Plant
                </button>
            </a>

            <table id="plantTable_<?php echo $category['id']; ?>"
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Plant Name</th>
                        <th>Picture</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Fetch plants data from the db with the corresponding category id
                        $categoryId = $category['id'];
                        $plantQuery = "SELECT * FROM plants WHERE category_id = $categoryId";
                        $plantResult = mysqli_query($conn, $plantQuery);

                        while ($plantRow = mysqli_fetch_assoc($plantResult)) {
                            echo '<tr>
                                <td>' . $plantRow['name'] . '</td>
                                <td>
                                    <img src="' . $plantRow['image_url'] . '" alt="Product" class="h-12 w-28 object-cover my-2" />
                                </td>
                                <td>
                                    <form method="post" action="./delete_plant.php">
                                        <input type="hidden" name="plant_id" value="' . $plantRow['id'] . '">
                                        <input type="hidden" name="category_id" value="' . $category['id'] . '">
                                        <button type="submit" name="delete-plant"
                                            class="mt-2 p-2.5 text-sm font-medium text-white bg-red-500 rounded-lg border border-red-600 focus:ring-4 focus:outline-none focus:ring-gray-200">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>';
                        }
                        ?>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </dialog>
    <?php endforeach; ?>

    <script src="../js/script.js"></script>

</body>

</html>