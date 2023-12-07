<?php
include(__DIR__ . '/../../config/db.php');
function selectThemes()
{
    global $conn;
    $query = "SELECT * FROM theme;";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $result;
}
