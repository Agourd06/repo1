<?php
// article.php

include("db.php");

if (isset($_GET['id'])) {
    $article_id = $_GET['id'];
    $articleQuery = "SELECT * FROM article WHERE article_id = $article_id";
    $articleResult = mysqli_query($conn, $articleQuery);

    if ($articleResult && mysqli_num_rows($articleResult) > 0) {
        $articleData = mysqli_fetch_assoc($articleResult);

        // Display article details
        $articleTitle = $articleData['article_title'];
        $articleImage = $articleData['article_image'];
        $articleDescription = $articleData['content'];
    } else {
        echo "Article not found!";
    }
} else {
    echo "Invalid request!";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Details</title>
</head>

<body>

    <div>
        <h1><?php echo $articleTitle; ?></h1>
        <p><?php echo $articleDescription; ?></p>
        <?php if ($articleImage): ?>
        <img src="<?php echo $articleImage; ?>" alt="Article Image" style="max-width: 100%;">
        <?php endif; ?>
    </div>

</body>

</html>