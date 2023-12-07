<?php
include("../config/db.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete-category"])) {
    $categoryIdToDelete = mysqli_real_escape_string($conn, $_POST["category_id"]);

    // Delete plants associated with the category
    $deletePlantsQuery = "DELETE FROM plants WHERE category_id = '$categoryIdToDelete'";
    $deletePlantsResult = mysqli_query($conn, $deletePlantsQuery);

    if ($deletePlantsResult) {
        // Now,  let's delete the category itself
        $deleteCategoryQuery = "DELETE FROM categories WHERE id = '$categoryIdToDelete'";
        $deleteCategoryResult = mysqli_query($conn, $deleteCategoryQuery);

        if ($deleteCategoryResult) {
            echo '<script>alert("Category and associated plants deleted successfully!");</script>';
        } else {
            echo '<script>alert("Error deleting category: ' . mysqli_error($conn) . '");</script>';
        }
    } else {
        echo '<script>alert("Error deleting plants associated with the category: ' . mysqli_error($conn) . '");</script>';
    }
}

header("Location:./admin.php");
?>