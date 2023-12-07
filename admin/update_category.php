<?php
include("db.php");


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update-category"])) {
    $categoryIdToUpdate = $_POST["category_id"];
    $updatedCategoryName = mysqli_real_escape_string($conn, $_POST["update-category-name"]);

    // Perform the update
    $updateCategoryQuery = "UPDATE categories SET name = ? WHERE id = ?";
    $updateCategoryResult = mysqli_prepare($conn, $updateCategoryQuery);
    mysqli_stmt_bind_param($updateCategoryResult,"si",$updatedCategoryName,$categoryIdToUpdate);
    $updatedResult=mysqli_stmt_execute($updateCategoryResult);

    if ($updatedResult) {
        echo '<script>alert("Category updated successfully!");</script>';
    } else {
        echo '<script>alert("Error updating category: ' . mysqli_error($conn) . '");</script>';
    }
}
header("Location:./admin.php");

?>