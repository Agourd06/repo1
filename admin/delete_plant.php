<?php
include("../config/db.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete-plant"])) {
    $plantIdToDelete = mysqli_real_escape_string($conn, $_POST["plant_id"]);
    $categoryId = mysqli_real_escape_string($conn, $_POST["category_id"]);

    // Perform the deletion
    $deletePlantQuery = "DELETE FROM plants WHERE id = '$plantIdToDelete' AND category_id = '$categoryId'";
    $deletePlantResult = mysqli_query($conn, $deletePlantQuery);
    if ($deletePlantResult) {
        echo '<script>alert("Plant deleted successfully!");</script>';
    } else {
        echo '<script>alert("Error deleting plant: ' . mysqli_error($conn) . '");</script>';
    }
}
header("Location:./admin.php");



?>