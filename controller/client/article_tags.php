<?php
if (isset($_POST["insert"])) {
    $title = $_POST["title"];
    $image = $_POST["image"];
    $description = $_POST["description"];
    $currentDateTime = date('Y-m-d H:i:s');
 if (isset($_POST["options"])) {
    $selectedTags = $_POST["options"];
    // print_r($_POST);
    $tags = implode(" , ", $selectedTags);
    $insertArticleQuery = "INSERT INTO article (article_title, content, article_image, created_at, author_id, theme_id, article_tags)
        VALUES ('$title', '$description', '$image', '$currentDateTime', '$userId', '$theme_id', '$tags')";

    if(mysqli_query($conn, $insertArticleQuery)){
        echo " good";
    }else{
        echo " no thing";
    }
}

}