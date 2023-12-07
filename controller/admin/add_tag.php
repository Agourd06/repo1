<?php
include ("../../config/db.php");

if (isset($_POST["tag_submit"])){
    $test = $_POST["id"];
    echo $test;
    insertTags();
}

function insertTags(){
    global $conn;
    $theme_id = $_POST["id"];
    $tags = $_POST["theme_tag"];
    $array = explode (",", $tags);
    // prepare and execute this
    foreach ($array as $e){
        var_dump($theme_id);
        $query = "INSERT INTO tags (tag_name, theme_id) VALUES (?, ?);";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $e, $theme_id);
        $result = mysqli_stmt_execute($stmt);
        echo "success";
        // echo $e ."<br>";
    }
}
