<?php
include("../../config/db.php");

if (isset($_POST["theme_name"])) {
    insertThemes();
}

function insertThemes()
{
    global $conn;
    // get data from post
    $theme_name = $_POST['theme_name'];
    $theme_desc = $_POST['theme_desc'];
    // get file tmp_name
    $tmp_name = $_FILES['theme_image']['tmp_name'];
    $theme_image = file_get_contents($tmp_name);

    $query = "INSERT INTO theme (theme_name, theme_image, theme_desc) VALUES (?, ?, ?);";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sbs', $theme_name, $theme_image, $theme_desc);

    mysqli_stmt_send_long_data($stmt, 1, $theme_image);

    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        //echo '<script>alert("Theme inserted successfully!");</script>';
        header("location: ../../admin/add_theme.php");
        exit();
    } else {
        echo mysqli_error($conn);
    }
}


