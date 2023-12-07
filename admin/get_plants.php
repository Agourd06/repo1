<?php
$query = "SELECT categories.id, categories.name, COUNT(plants.id) AS plant_count
FROM categories
LEFT JOIN plants ON categories.id = plants.category_id
GROUP BY categories.id, categories.name";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    echo '<table id="categoryTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Category Name
                    </th>
                    <th>See Plants</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">' . $row['name'] . '</td>
                    <td>
                        <button class="btn btn-success" onclick="openModal(\'modal_' . $row['id'] . '\')">Open</button>
                        <dialog id="modal_' . $row['id'] . '" class="modal">
                            <div class="modal-box">
                                <form method="dialog">
                                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="closeModal(' . $row['id'] . ')">✕</button>
                                </form>
                                <h3 class="font-bold text-lg text-center mx-auto">Plants in Category: ' . $row['name'] . '</h3>
                                <a href="./add.php">
                                    <button type="submit" class="mt-2 p-2.5 text-sm font-medium text-white rounded-lg border border-green-600 bg-[#2f9f5c] focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-green-500"
                                        name="add-plant">
                                        Add Plant
                                    </button>
                                </a>
                                
                                <table id="plantTable_' . $row['id'] . '" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Plant Name</th>
                                            <th>Picture</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

        $categoryId = $row['id'];
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
                                <input type="hidden" name="category_id" value="' . $row['id'] . '">
                                <button type="submit" name="delete-plant"
                                    class="mt-2 p-2.5 text-sm font-medium text-white bg-red-500 rounded-lg border border-red-600 focus:ring-4 focus:outline-none focus:ring-gray-200">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>';
        }

        echo '<tr>
                    <td colspan="3"></td>
                </tr>
            </tbody>
        </table>
    </div>
</dialog>
</td>
<td class="border px-2 py-4">

<form method="post" action="./update_category.php">
<input type="hidden" name="category_id" value="' . $row['id'] . '">
<label for="update-category-name"></label>
<input type="text" id="update-category-name" name="update-category-name" value="' . $row['name'] . '"
required>
<button type="submit" name="update-category"
    class="mt-2 p-2.5 text-sm font-medium bg-black text-white  rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    Edit
</button>
</form>

</td>
<td>
<form method="post" action="./delete_category.php">
<input type="hidden" name="category_id" value="' . $row['id'] . '">
<button type="submit" name="delete-category" class="mt-2 p-2.5 text-sm font-medium text-white bg-red-500 rounded-lg border border-red-600 focus:ring-4 focus:outline-none focus:ring-gray-200">
Delete
</button>
</form>
</td>
</tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<p>No data found</p>';
}
?>