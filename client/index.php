<?php
include("db.php");

session_start();
if (!isset($_SESSION['LOGINEMAIL'])) {
    header("Location:login.php");
    exit();
}
$categoryQuery = "SELECT id, name FROM categories";
$categoryResult = mysqli_query($conn, $categoryQuery);
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

if ($_SESSION['LOGINEMAIL']) {
    $email = $_SESSION['LOGINEMAIL'];
    $query = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $SERRESULTU = $query->get_result();
    $row = $SERRESULTU->fetch_assoc();
    $IDuser = $row["user_id"];
}
// echo $IDuser;

$categoryToShow = "house";

if (isset($_GET['category'])) {
    $categoryToShow = $_GET['category'];
}

if (isset($_POST["basket"])) {
    $basket = $_POST["basket"];
    $quantity = $_POST["quantity"];

    // Check if the plant is already in the basket
    $checkPlantQuery = $conn->prepare("SELECT * FROM basket WHERE user_id = ? AND plant_id = ?");
    $checkPlantQuery->bind_param("ii", $IDuser, $basket);
    $checkPlantQuery->execute();
    $result = $checkPlantQuery->get_result();

    if ($result->num_rows > 0) {
        // If the plant is already in the basket, update the quantity
        $row = $result->fetch_assoc();
        $newQuantity = $row['quantity'] + $quantity;

        $updateQuantityQuery = $conn->prepare("UPDATE basket SET quantity = ? WHERE user_id = ? AND plant_id = ?");
        $updateQuantityQuery->bind_param("iii", $newQuantity, $IDuser, $basket);
        $updateQuantityQuery->execute();
    } else {
        // If the plant is not in the basket, insert into the basket table
        $qBasket = $conn->prepare("INSERT INTO basket (user_id, plant_id, quantity) VALUES (?, ?, ?)");
        $qBasket->bind_param("iii", $IDuser, $basket, $quantity);
        $qBasket->execute();
        $basketId = $qBasket->insert_id;
        $pivotQuery = $conn->prepare("INSERT INTO plant_basket_pivot(plant_id, basket_id) VALUES (?, ?)");
        $pivotQuery->bind_param("ii", $basket, $basketId);
        $pivotQuery->execute();
    }
}





$sql = "SELECT * FROM plants WHERE category_id = (SELECT id FROM categories WHERE name = '$categoryToShow');";
$result = $conn->query($sql);
$matchingPlants = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['plant_name'])) {
        $plant_name = $_GET['plant_name'];
        $query = "SELECT * FROM plants WHERE name LIKE '%$plant_name%'";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $matchingPlants[] = $row;
        }
    }
}

?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.9/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>

</head>

<body>
    <div class="  bg-cover bg-center h-screen ">
        <?php
        include("navbar.php");
        ?>
        <div class="max-w-screen-xl px-10 bg-transparent w-full h-screen py-10 flex-col">
            <div class="backdrop-blur-sm bg-white w-full h-full p-10 mr-10 flex justify-around">
                <img src="../images/6.jpg" alt="" class="h-screen w-auto -ml-16 -mt-10">
                <div class="flex-col items-center justify-center mt-32">
                    <p class="font-semibold text-3xl lg:text-5xl xl:text-6xl text-black">PLANTS AND FLOWERS</p>
                    <span class="text-sm text-[#3c7b04] mt-14 ">YOU THINK WE DESIGN</span>
                    <a href="#" id="but1"
                        class="border border-1 border-solid bg-black opacity-1 border-black rounded-full w-32 h-8 flex items-center justify-center">
                        <button class="text-white text-xl">Shop Now</button>
                    </a>
                </div>
            </div>

            <div class="flex flex-col items-center  mt-24">
                <svg xmlns="http://www.w3.org/2000/svg" width="54" height="55" viewBox="0 0 54 55" fill="none">
                    <path
                        d="M29.0935 35.5185C31.9938 27.8983 39.6288 24.1487 45.8454 23.1624C36.7386 27.8669 32.1935 32.8702 28.975 43.0516L30.8302 43.5109C31.3483 41.5312 32.0679 39.7423 32.9374 38.0939C39.2891 40.2052 45.0796 39.5651 49.7954 34.5328C55.6539 27.2587 53.7062 19.3641 51.2458 11.4286C48.9033 19.0689 35.8448 17.9149 30.9458 26.864C29.9115 28.753 29.0443 30.6118 28.3496 32.4997"
                        fill="#7FB241" />
                    <path
                        d="M31.3927 27.107C37.6864 19.1703 49.4794 19.4874 51.2458 11.4292C48.521 17.3476 39.4764 15.1101 33.2794 20.1696C29.688 23.2424 27.4842 27.0542 28.349 32.5009C29.0437 30.6124 30.0935 28.8247 31.3927 27.107Z"
                        fill="#719C40" />
                    <path
                        d="M24.846 35.5185C21.9457 27.8983 14.3107 24.1487 8.09412 23.1624C17.2009 27.8669 21.7466 32.8702 24.9651 43.0516L23.1099 43.5109C22.5918 41.5312 21.8722 39.7423 21.0027 38.0939C14.6509 40.2052 8.86052 39.5651 4.14473 34.5328C-1.71386 27.2587 0.233867 19.3641 2.69431 11.4286C5.03679 19.0689 18.0953 17.9149 22.9943 26.864C24.0286 28.753 24.8958 30.6118 25.5905 32.4997"
                        fill="#7FB241" />
                    <path
                        d="M22.5468 27.107C16.2537 19.1697 4.46067 19.4874 2.69373 11.4286C5.41853 17.347 14.4631 15.1095 20.6601 20.169C24.2515 23.2418 26.4553 27.0537 25.5905 32.5003C24.8958 30.6124 23.846 28.8247 22.5468 27.107Z"
                        fill="#719C40" />
                </svg>
                <h3 class="font-serif text-3xl mx-auto text-center mb-10">TRENDING PRODUCTS</h3>
            </div>
            <?php
      if (mysqli_num_rows($categoryResult) > 0) {
        echo '<div id="categories" class="flex justify-center items-center gap-4 my-5">';
    
        while ($category = mysqli_fetch_assoc($categoryResult)) {
            $categoryId = $category['id'];
            $categoryName = $category['name'];
            $isActive = ($selectedCategory == $categoryName || ($selectedCategory == '' && $categoryName == 'love')) ? 'bg-green-800' : 'bg-white';
                echo '<a href="?category=' . $categoryName . '" class="border-2 border-solid opacity-1 border-gray-200 rounded-full w-32 h-8 ' . $isActive . ' flex items-center justify-center">';
            echo '<button class="text-gray-200">' . $categoryName . '</button>';
            echo '</a>';
        }
    
        echo '</div>';
    } else {
        echo '<p>No categories found.</p>';
    }   
        ?>

            <div class="container mx-auto mt-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php foreach ($matchingPlants as $plant): ?>
                    <div
                        class="swiper-slide w-72 bg-white shadow-md rounded-md duration-500 hover:scale-105 hover:shadow-xl">
                        <a href="#">
                            <img src="<?php echo $plant['image_url']; ?>" alt=" Product"
                                class="h-80 w-72 object-cover rounded-t-xl" />
                            <div class="px-4 py-3 w-72">
                                <span class="text-gray-400 mr-3 uppercase text-xs">Nursery</span>
                                <p class="text-lg font-bold text-black truncate block capitalize">
                                    <?php echo $plant['name']; ?>
                                </p>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <section
                class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-14 mt-10 mb-5">

                <?php
            while ($row = $result->fetch_assoc()) {
                ?>

                <div
                    class="swiper-slide w-72 bg-white shadow-md rounded-md duration-500 hover:scale-105 hover:shadow-xl">
                    <a href="#">
                        <img src="<?php echo $row['image_url']; ?>" alt=" Product"
                            class="h-80 w-72 object-cover rounded-t-xl" />
                        <div class="px-4 py-3 w-72">
                            <span class="text-gray-400 mr-3 uppercase text-xs">Nursery</span>
                            <p class="text-lg font-bold text-black truncate block capitalize">
                                <?php echo $row['name']; ?>
                            </p>
                            <div class="flex items-center">
                                <p class="text-lg font-semibold text-black cursor-auto my-3">
                                    $
                                    <?php echo $row['price']; ?>
                                </p>
                                <del>
                                    <p class="text-sm text-gray-600 cursor-auto ml-2">
                                        $
                                        <?php echo $row['discounted_price']; ?>

                                    </p>
                                </del>
                                <div class="ml-auto">
                                    <form action="" method="POST">
                                        <button type="submit" name="basket" value="<?php echo $row['id']; ?>">
                                            <input type="number" hidden name="quantity" value="1" min="1">

                                            <svg xmlns=" http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor"
                                                class="bi bi-bag-plus hover:text-green-500 duration-200"
                                                viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z" />
                                                <path
                                                    d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                            </svg>

                                        </button>



                                    </form>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <?php
            }
            ?>

            </section>
            <!-- wedding cards -->
            <div class=" flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="54" height="55" viewBox="0 0 54 55" fill="none">
                    <path
                        d="M29.0935 35.5185C31.9938 27.8983 39.6288 24.1487 45.8454 23.1624C36.7386 27.8669 32.1935 32.8702 28.975 43.0516L30.8302 43.5109C31.3483 41.5312 32.0679 39.7423 32.9374 38.0939C39.2891 40.2052 45.0796 39.5651 49.7954 34.5328C55.6539 27.2587 53.7062 19.3641 51.2458 11.4286C48.9033 19.0689 35.8448 17.9149 30.9458 26.864C29.9115 28.753 29.0443 30.6118 28.3496 32.4997"
                        fill="#7FB241" />
                    <path
                        d="M31.3927 27.107C37.6864 19.1703 49.4794 19.4874 51.2458 11.4292C48.521 17.3476 39.4764 15.1101 33.2794 20.1696C29.688 23.2424 27.4842 27.0542 28.349 32.5009C29.0437 30.6124 30.0935 28.8247 31.3927 27.107Z"
                        fill="#719C40" />
                    <path
                        d="M24.846 35.5185C21.9457 27.8983 14.3107 24.1487 8.09412 23.1624C17.2009 27.8669 21.7466 32.8702 24.9651 43.0516L23.1099 43.5109C22.5918 41.5312 21.8722 39.7423 21.0027 38.0939C14.6509 40.2052 8.86052 39.5651 4.14473 34.5328C-1.71386 27.2587 0.233867 19.3641 2.69431 11.4286C5.03679 19.0689 18.0953 17.9149 22.9943 26.864C24.0286 28.753 24.8958 30.6118 25.5905 32.4997"
                        fill="#7FB241" />
                    <path
                        d="M22.5468 27.107C16.2537 19.1697 4.46067 19.4874 2.69373 11.4286C5.41853 17.347 14.4631 15.1095 20.6601 20.169C24.2515 23.2418 26.4553 27.0537 25.5905 32.5003C24.8958 30.6124 23.846 28.8247 22.5468 27.107Z"
                        fill="#719C40" />
                </svg>
                <h3 class="font-serif text-3xl mx-auto text-center mb-10">TRENDING BLOGS</h3>
            </div>


          
            <section id="blogs" class="text-gray-800 my-8">
    <div class="container mx-auto space-y-8">
        <div class="gap-x-4 gap-y-8 flex justify-center items-center">
            <?php 
                $display_theme = mysqli_query($conn, 'SELECT * FROM theme ');
                
                if (!$display_theme) {
                    echo 'NO THEME EXISTE';
                } else {
                    while ($row = mysqli_fetch_assoc($display_theme)) :
                        ?>
                        <article class="flex flex-col bg-gray-50 swiper-slide w-72 shadow-md rounded-md duration-500 hover:scale-105 hover:shadow-xl">
                        <div class="flex flex-col flex-1">
                                <div class="flex flex-wrap justify-between pt-3 space-x-2 text-xxl-end text-gray-600">
                                    <span ><?php echo $row["theme_name"]; ?></span>
                                    <?php 
                                        $articleQuery = "SELECT COUNT(article.article_id) AS nb_article FROM article JOIN theme ON theme.theme_id = article.theme_id WHERE theme.theme_id = {$row['theme_id']}";
                                        $articleResult = mysqli_query($conn, $articleQuery);

                                        if ($articleResult) {
                                            $articleRow = mysqli_fetch_assoc($articleResult);
                                            $nb_article = $articleRow['nb_article'];

                                            echo '<span>' . $nb_article . ' Articles</span>';
                                        } else {
                                            echo "Error in the query: " . mysqli_error($conn);
                                        }
                                    ?>
                                </div>
                            <a rel="noopener noreferrer" href="#" aria-label="Te nulla oportere reprimique his dolorum">
                                <?php echo "<img  src='data:image/jpg;charset=utf8;base64," . base64_encode($row['theme_image']) . "'>"; ?>
                            </a>
                           
                                <span><?php echo $row["theme_desc"]; ?></span>
                            </div>
                            <div class="flex items-center justify-center py-4">
                            <a href="addArticle.php ?id_theme=<?=$row["theme_id"]?>">
                                <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                    More
                                 </button>
                            </a>
                            </div>


                        </article>
                    <?php endwhile;
                }
            ?>
        </div>
    </div>
</section>



            <main id="faq" class=" p-5 bg-light-blue -mt-20">
                <div class="flex justify-center items-start my-2">
                    <div class="w-full sm:w-10/12 md:w-1/2 my-1">
                        <div class="flex flex-col items-center  mt-24">
                            <svg xmlns="http://www.w3.org/2000/svg" width="54" height="55" viewBox="0 0 54 55"
                                fill="none">
                                <path
                                    d="M29.0935 35.5185C31.9938 27.8983 39.6288 24.1487 45.8454 23.1624C36.7386 27.8669 32.1935 32.8702 28.975 43.0516L30.8302 43.5109C31.3483 41.5312 32.0679 39.7423 32.9374 38.0939C39.2891 40.2052 45.0796 39.5651 49.7954 34.5328C55.6539 27.2587 53.7062 19.3641 51.2458 11.4286C48.9033 19.0689 35.8448 17.9149 30.9458 26.864C29.9115 28.753 29.0443 30.6118 28.3496 32.4997"
                                    fill="#7FB241" />
                                <path
                                    d="M31.3927 27.107C37.6864 19.1703 49.4794 19.4874 51.2458 11.4292C48.521 17.3476 39.4764 15.1101 33.2794 20.1696C29.688 23.2424 27.4842 27.0542 28.349 32.5009C29.0437 30.6124 30.0935 28.8247 31.3927 27.107Z"
                                    fill="#719C40" />
                                <path
                                    d="M24.846 35.5185C21.9457 27.8983 14.3107 24.1487 8.09412 23.1624C17.2009 27.8669 21.7466 32.8702 24.9651 43.0516L23.1099 43.5109C22.5918 41.5312 21.8722 39.7423 21.0027 38.0939C14.6509 40.2052 8.86052 39.5651 4.14473 34.5328C-1.71386 27.2587 0.233867 19.3641 2.69431 11.4286C5.03679 19.0689 18.0953 17.9149 22.9943 26.864C24.0286 28.753 24.8958 30.6118 25.5905 32.4997"
                                    fill="#7FB241" />
                                <path
                                    d="M22.5468 27.107C16.2537 19.1697 4.46067 19.4874 2.69373 11.4286C5.41853 17.347 14.4631 15.1095 20.6601 20.169C24.2515 23.2418 26.4553 27.0537 25.5905 32.5003C24.8958 30.6124 23.846 28.8247 22.5468 27.107Z"
                                    fill="#719C40" />
                            </svg>
                            <h3 class="font-serif text-3xl mx-auto text-center mb-10">FAQ</h3>
                        </div>
                        <ul class="flex flex-col items-center justify-center">
                            <li class="bg-white my-2 shadow-lg w-[80vw] " x-data="accordion(1)">
                                <h2 @click="handleClick()"
                                    class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                    <span>When will my order arrive?</span>
                                    <svg :class="handleRotate()"
                                        class="fill-current text-green-600 h-6 w-6 transform transition-transform duration-500"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                        </path>
                                    </svg>

                                </h2>
                                <div x-ref="tab" :style="handleToggle()"
                                    class="border-l-2 border-green-600 overflow-hidden max-h-0 duration-500 transition-all">
                                    <p class="p-3 text-gray-900">
                                        Shipping time is set by our delivery partners, according to the
                                        delivery method
                                        chosen by you. Additional details can be found in the order
                                        confirmation
                                    </p>
                                </div>
                            </li>
                            <li class="bg-white my-2 shadow-lg  w-[80vw]" x-data="accordion(2)">
                                <h2 @click="handleClick()"
                                    class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                    <span>How do I track my order?</span>
                                    <svg :class="handleRotate()"
                                        class="fill-current text-green-600 h-6 w-6 transform transition-transform duration-500"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                        </path>
                                    </svg>
                                </h2>
                                <div class="border-l-2 border-green-600 overflow-hidden max-h-0 duration-500 transition-all"
                                    x-ref="tab" :style="handleToggle()">
                                    <p class="p-3 text-gray-900">
                                        Once shipped, you’ll get a confirmation email that includes a
                                        tracking number
                                        and additional information regarding tracking your order.
                                    </p>
                                </div>
                            </li>
                            <li class="bg-white my-2 shadow-lg  w-[80vw]" x-data="accordion(3)">
                                <h2 @click="handleClick()"
                                    class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                    <span>What’s your return policy?</span>
                                    <svg :class="handleRotate()"
                                        class="fill-current text-green-600 h-6 w-6 transform transition-transform duration-500"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                        </path>
                                    </svg>
                                </h2>
                                <div class="border-l-2 border-green-600 overflow-hidden max-h-0 duration-500 transition-all"
                                    x-ref="tab" :style="handleToggle()">
                                    <p class="p-3 text-gray-900">
                                        We allow the return of all items within 30 days of your original
                                        order’s date.
                                        If you’re interested in returning your items, send us an email
                                        with your order
                                        number and we’ll ship a return label.
                                    </p>
                                </div>
                            </li>
                            <li class="bg-white my-2 shadow-lg  w-[80vw]" x-data="accordion(4)">
                                <h2 @click="handleClick()"
                                    class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                    <span>How do I make changes to an existing order?</span>
                                    <svg :class="handleRotate()"
                                        class="fill-current text-green-600 h-6 w-6 transform transition-transform duration-500"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                        </path>
                                    </svg>
                                </h2>
                                <div class="border-l-2 border-green-600 overflow-hidden max-h-0 duration-500 transition-all"
                                    x-ref="tab" :style="handleToggle()">
                                    <p class="p-3 text-gray-900">
                                        Changes to an existing order can be made as long as the order is
                                        still in
                                        “processing” status. Please contact our team via email and we’ll
                                        make sure to
                                        apply the needed changes. If your order has already been
                                        shipped, we cannot
                                        apply any changes to it. If you are unhappy with your order when
                                        it arrives,
                                        please contact us for any changes you may require.
                                    </p>
                                </div>
                            </li>
                            <li class="bg-white my-2 shadow-lg  w-[80vw]" x-data="accordion(5)">
                                <h2 @click="handleClick()"
                                    class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                    <span>What shipping options do you have?</span>
                                    <svg :class="handleRotate()"
                                        class="fill-current text-green-600 h-6 w-6 transform transition-transform duration-500"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                        </path>
                                    </svg>
                                </h2>
                                <div class="border-l-2 border-green-600 overflow-hidden max-h-0 duration-500 transition-all"
                                    x-ref="tab" :style="handleToggle()">
                                    <p class="p-3 text-gray-900">
                                        For USA domestic orders we offer FedEx and USPS shipping.
                                    </p>
                                </div>
                            </li>
                            <li class="bg-white my-2 shadow-lg  w-[80vw]" x-data="accordion(6)">
                                <h2 @click="handleClick()"
                                    class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                    <span>What payment methods do you accept?</span>
                                    <svg :class="handleRotate()"
                                        class="fill-current text-green-600 h-6 w-6 transform transition-transform duration-500"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                        </path>
                                    </svg>
                                </h2>
                                <div class="border-l-2 border-green-600 overflow-hidden max-h-0 duration-500 transition-all"
                                    x-ref="tab" :style="handleToggle()">
                                    <p class="p-3 text-gray-900">
                                        Any method of payments acceptable by you. For example: We accept
                                        MasterCard,
                                        Visa, American Express, PayPal, JCB Discover, Gift Cards, etc.
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </main>
            <div class="flex flex-col items-center  mt-24">
                <svg xmlns="http://www.w3.org/2000/svg" width="54" height="55" viewBox="0 0 54 55" fill="none">
                    <path
                        d="M29.0935 35.5185C31.9938 27.8983 39.6288 24.1487 45.8454 23.1624C36.7386 27.8669 32.1935 32.8702 28.975 43.0516L30.8302 43.5109C31.3483 41.5312 32.0679 39.7423 32.9374 38.0939C39.2891 40.2052 45.0796 39.5651 49.7954 34.5328C55.6539 27.2587 53.7062 19.3641 51.2458 11.4286C48.9033 19.0689 35.8448 17.9149 30.9458 26.864C29.9115 28.753 29.0443 30.6118 28.3496 32.4997"
                        fill="#7FB241" />
                    <path
                        d="M31.3927 27.107C37.6864 19.1703 49.4794 19.4874 51.2458 11.4292C48.521 17.3476 39.4764 15.1101 33.2794 20.1696C29.688 23.2424 27.4842 27.0542 28.349 32.5009C29.0437 30.6124 30.0935 28.8247 31.3927 27.107Z"
                        fill="#719C40" />
                    <path
                        d="M24.846 35.5185C21.9457 27.8983 14.3107 24.1487 8.09412 23.1624C17.2009 27.8669 21.7466 32.8702 24.9651 43.0516L23.1099 43.5109C22.5918 41.5312 21.8722 39.7423 21.0027 38.0939C14.6509 40.2052 8.86052 39.5651 4.14473 34.5328C-1.71386 27.2587 0.233867 19.3641 2.69431 11.4286C5.03679 19.0689 18.0953 17.9149 22.9943 26.864C24.0286 28.753 24.8958 30.6118 25.5905 32.4997"
                        fill="#7FB241" />
                    <path
                        d="M22.5468 27.107C16.2537 19.1697 4.46067 19.4874 2.69373 11.4286C5.41853 17.347 14.4631 15.1095 20.6601 20.169C24.2515 23.2418 26.4553 27.0537 25.5905 32.5003C24.8958 30.6124 23.846 28.8247 22.5468 27.107Z"
                        fill="#719C40" />
                </svg>
                <h3 class="font-serif text-3xl mx-auto text-center mb-10">Contact Us</h3>
            </div>
            <div id="contact" class="container my-24 mx-auto md:px-6">
                <section class="mb-32">
                    <div
                        class="relative h-[300px] overflow-hidden bg-cover bg-[50%] bg-no-repeat bg-[url('../images/mn.jpg')]">
                    </div>
                    <div class="container px-6 md:px-12">
                        <div
                            class="block rounded-lg bg-[hsla(0,0%,100%,0.7)] px-6 py-12 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-[hsla(0,0%,5%,0.7)] dark:shadow-black/20 md:py-16 md:px-12 -mt-[100px] backdrop-blur-[30px]">
                            <div class="mb-12 grid gap-x-6 md:grid-cols-2 lg:grid-cols-4">
                                <div class="mx-auto mb-12 text-center lg:mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="black"
                                        class="mx-auto mb-6 h-8 w-8 text-primary dark:text-primary-400">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.107 1.107 0 00-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 01-1.652.928l-.679-.906a1.125 1.125 0 00-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 00-8.862 12.872M12.75 3.031a9 9 0 016.69 14.036m0 0l-.177-.529A2.25 2.25 0 0017.128 15H16.5l-.324-.324a1.453 1.453 0 00-2.328.377l-.036.073a1.586 1.586 0 01-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 01-5.276 3.67m0 0a9 9 0 01-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25" />
                                    </svg>

                                    <h6 class="font-medium">Unites States</h6>
                                </div>
                                <div class="mx-auto mb-12 text-center lg:mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="black"
                                        class="mx-auto mb-6 h-8 w-8 text-primary dark:text-primary-400">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    <h6 class="font-medium ">New York, 94126</h6>
                                </div>
                                <div class="mx-auto mb-6 text-center md:mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="black"
                                        class=" mx-auto mb-6 h-8 w-8 text-primary dark:text-primary-400">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                    <h6 class="font-medium">+ 01 234 567 89</h6>
                                </div>
                                <div class="mx-auto text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="black"
                                        class="mx-auto mb-6 h-8 w-8 text-primary dark:text-primary-400">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                    </svg>
                                    <h6 class="font-medium">Tax ID: 273 384</h6>
                                </div>
                            </div>
                            <div class="mx-auto max-w-[700px]">
                                <form>
                                    <div class="relative mb-6" data-te-input-wrapper-init>
                                        <input type="text"
                                            class="peer block min-h-[auto] w-full rounded border border-gray-500 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                            id="exampleInput90" placeholder="Name" />
                                        <label
                                            class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary"
                                            for="exampleInput90">Name
                                        </label>

                                    </div>
                                    <div class="relative mb-6" data-te-input-wrapper-init>
                                        <input type="email"
                                            class="peer block min-h-[auto] w-full rounded border border-gray-500 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                            id="exampleInput91" placeholder="Email address" />
                                        <label
                                            class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary"
                                            for="exampleInput91">Email address
                                        </label>
                                    </div>
                                    <div class="relative mb-6" data-te-input-wrapper-init>
                                        <textarea
                                            class="peer block min-h-[auto] w-full rounded border border-gray-500 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                            id="exampleFormControlTextarea1" rows="3"
                                            placeholder="Your message"></textarea>
                                        <label for="exampleFormControlTextarea1"
                                            class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">Message</label>
                                    </div>
                                    <div class="mb-6 inline-block min-h-[1.5rem] justify-center pl-[1.5rem] md:flex">
                                        <input
                                            class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent dark:border-neutral-600 dark:checked:border-primary dark:checked:bg-primary dark:focus:before:shadow-[0px_0px_0px_13px_rgba(255,255,255,0.4)] dark:checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca]"
                                            type="checkbox" value="" id="exampleCheck96" checked />
                                        <label class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                            for="exampleCheck96">
                                            Send me a copy of this message
                                        </label>
                                    </div>
                                    <button type="button" data-te-ripple-init data-te-ripple-color="light"
                                        class="inline-block w-full rounded bg-green-800 px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] lg:mb-0">
                                        Send
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <footer
                class="flex flex-col items-center bg-neutral-100 text-center text-white dark:bg-neutral-600  w-[100vw] overflow-x-hidde ">
                <div class="container pt-9">
                    <div class="mb-9 flex justify-center">
                        <a href="#!" class="mr-9 text-neutral-800 dark:text-neutral-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                            </svg>
                        </a>
                        <a href="#!" class="mr-9 text-neutral-800 dark:text-neutral-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                            </svg>
                        </a>
                        <a href="#!" class="mr-9 text-neutral-800 dark:text-neutral-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M7 11v2.4h3.97c-.16 1.029-1.2 3.02-3.97 3.02-2.39 0-4.34-1.979-4.34-4.42 0-2.44 1.95-4.42 4.34-4.42 1.36 0 2.27.58 2.79 1.08l1.9-1.83c-1.22-1.14-2.8-1.83-4.69-1.83-3.87 0-7 3.13-7 7s3.13 7 7 7c4.04 0 6.721-2.84 6.721-6.84 0-.46-.051-.81-.111-1.16h-6.61zm0 0 17 2h-3v3h-2v-3h-3v-2h3v-3h2v3h3v2z"
                                    fill-rule="evenodd" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#!" class="mr-9 text-neutral-800 dark:text-neutral-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#!" class="mr-9 text-neutral-800 dark:text-neutral-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
                            </svg>
                        </a>
                        <a href="#!" class="text-neutral-800 dark:text-neutral-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div
                    class=" bg-neutral-200 p-4 text-center text-neutral-700 dark:bg-neutral-700 dark:text-neutral-200 w-[100vw] overflow-x-hidden">
                    © 2023 Copyright:
                    <a class="text-neutral-800 dark:text-neutral-400" href="https://tw-elements.com/">TW elements</a>
                </div>
            </footer>

            <?php
        $conn->close();
        ?>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const button = document.getElementById('navbar-toggle');
                const searchButton = document.getElementById('search-toggle');
                const menu = document.getElementById('navbar-search');

                searchButton.addEventListener('click', function() {
                    menu.classList.toggle('hidden');
                });

                button.addEventListener('click', function() {
                    menu.classList.toggle('hidden');
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                // open
                const burger = document.querySelectorAll('.navbar-burger');
                const menu = document.querySelectorAll('.navbar-menu');

                if (burger.length && menu.length) {
                    for (var i = 0; i < burger.length; i++) {
                        burger[i].addEventListener('click', function() {
                            for (var j = 0; j < menu.length; j++) {
                                menu[j].classList.toggle('hidden');
                            }
                        });
                    }
                }

                // close
                const close = document.querySelectorAll('.navbar-close');
                const backdrop = document.querySelectorAll('.navbar-backdrop');

                if (close.length) {
                    for (var i = 0; i < close.length; i++) {
                        close[i].addEventListener('click', function() {
                            for (var j = 0; j < menu.length; j++) {
                                menu[j].classList.toggle('hidden');
                            }
                        });
                    }
                }

                if (backdrop.length) {
                    for (var i = 0; i < backdrop.length; i++) {
                        backdrop[i].addEventListener('click', function() {
                            for (var j = 0; j < menu.length; j++) {
                                menu[j].classList.toggle('hidden');
                            }
                        });
                    }
                }
            });
            document.addEventListener('alpine:init', () => {
                Alpine.store('accordion', {
                    tab: 0
                });

                Alpine.data('accordion', (idx) => ({
                    init() {
                        this.idx = idx;
                    },
                    idx: -1,
                    handleClick() {
                        this.$store.accordion.tab = this.$store.accordion.tab ===
                            this.idx ? 0 : this
                            .idx;
                    },
                    handleRotate() {
                        return this.$store.accordion.tab === this.idx ?
                            'rotate-180' : '';
                    },
                    handleToggle() {
                        return this.$store.accordion.tab === this.idx ?
                            `max-height: ${this.$refs.tab.scrollHeight}px` : '';
                    }
                }));
            })
            </script>
</body>

</html>