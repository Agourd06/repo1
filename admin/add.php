<?php
include("../includes/navbar.php");
include("../includes/sidebar.php");
include("../config/db.php");

// Handle adding a new plant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add-plant"])) {
    $categoryId = mysqli_real_escape_string($conn, $_POST["category_id"]);
    $plantName = mysqli_real_escape_string($conn, $_POST["plant-name"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $price = mysqli_real_escape_string($conn, $_POST["price"]);
    $discountedPrice = mysqli_real_escape_string($conn, $_POST["discounted_price"]);

    // Handle image upload
    $targetDirectory = "../uploads/";
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if (isset($_POST["add-plant"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo '<script>alert("File is not an image.");</script>';
            $uploadOk = 0;
        }
    }

    // Check if the file already exists
    if (file_exists($targetFile)) {
        echo '<script>alert("Sorry, file already exists.");</script>';
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo '<script>alert("Sorry, your file is too large.");</script>';
        $uploadOk = 0;
    }

    // Allow only certain file formats
    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedFormats)) {
        echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");</script>';
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo '<script>alert("Sorry, your file was not uploaded.");</script>';
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Insert plant data into the database
            $imagePath = $targetFile;
            $insertPlantQuery = "INSERT INTO plants (category_id, name, description, price, image_url, discounted_price)
                                VALUES ('$categoryId', '$plantName', '$description', '$price', '$imagePath', '$discountedPrice')";
            $insertPlantResult = mysqli_query($conn, $insertPlantQuery);

            if ($insertPlantResult) {
                echo '<script>alert("Plant added successfully!");</script>';
            } else {
                echo '<script>alert("Error adding plant: ' . mysqli_error($conn) . '");</script>';
            }
        } else {
            echo '<script>alert("Sorry, there was an error uploading your file.");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<body class="bg-[#ECECF8]">
    <?php
    // Fetch categories to populate the category dropdown in the form
    $categoriesQuery = "SELECT id, name FROM categories";
    $categoriesResult = mysqli_query($conn, $categoriesQuery);
    ?>

    <div class="p-5 mt-14 sm:ml-64">
        <h2 class="text-xl font-semibold mb-2">Add New Plant</h2>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
            <label for="category-id" class="sr-only">Category</label>
            <select id="category-id" name="category_id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required>
                <?php
                while ($category = mysqli_fetch_assoc($categoriesResult)) {
                    echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
                }
                ?>
            </select>

            <label for="plant-name" class="sr-only">Plant Name</label>
            <input type="text" id="plant-name" name="plant-name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Enter plant name" required>

            <label for="description" class="sr-only">Description</label>
            <textarea id="description" name="description"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Enter plant description"></textarea>

            <label for="price" class="sr-only">Price</label>
            <input type="text" id="price" name="price"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Enter plant price" required>
            <label for="image" class="sr-only">Image</label>
            <input type="file" id="image" name="image" accept="image/*" required>


            <label for="discounted-price" class="sr-only">Discounted Price</label>
            <input type="text" id="discounted-price" name="discounted_price"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Enter discounted price">

            <button type="submit"
                class="mt-2 p-2.5 text-sm font-medium text-white bg-[#2F329F] rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                name="add-plant">
                Add Plant
            </button>
        </form>
    </div>
</body>

</html>