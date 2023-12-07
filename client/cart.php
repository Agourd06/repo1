<?php
include("db.php");
session_start();
$email = $_SESSION['LOGINEMAIL'];
$userQuery = "SELECT user_id FROM users WHERE email = '$email'";
$userResult = mysqli_query($conn, $userQuery);
$subtotal = 0;
if ($userResult) {
    $row = mysqli_fetch_assoc($userResult);
    $userID = $row['user_id'];

    // Calculate total amount
    $subtotalQuery = "SELECT SUM(plants.price * basket.quantity) as total
                      FROM basket
                      JOIN plants ON plants.id = basket.plant_id
                      WHERE user_id = $userID";
    $subtotalResult = mysqli_query($conn, $subtotalQuery);
    $subtotalRow = mysqli_fetch_assoc($subtotalResult);

    // Making sure that thesubtotal is not NULL
    $subtotal = isset($subtotalRow['total']) ? $subtotalRow['total'] : 0;

    if (isset($_POST['checkout'])) {
        $basketQuery = $conn->prepare("SELECT id, plant_id, SUM(quantity) as quantity FROM basket WHERE user_id = ? GROUP BY plant_id");
        $basketQuery->bind_param("i", $userID);
        $basketQuery->execute();
        $results = $basketQuery->get_result();

        while ($row = $results->fetch_assoc()) {
            $plantID = $row['plant_id'];
          $basketId= $row['id'];
            $commandQuery = $conn->prepare("INSERT INTO commands(user_id, plant_id, total_amount) VALUES(?, ?, ?)");
            $commandQuery->bind_param("iii", $userID, $plantID, $subtotal);
            $commandQuery->execute();
         
        }
        $deleteBasketPivoQuery = $conn->prepare("DELETE FROM plant_basket_pivot WHERE basket_id = ?");
        $deleteBasketPivoQuery->bind_param("i", $basketId);
        $deleteBasketPivoQuery->execute();
        $deleteBasketQuery = $conn->prepare("DELETE FROM basket WHERE user_id = ?");
        $deleteBasketQuery->bind_param("i", $userID);
        $deleteBasketQuery->execute();
      
        header("Location: index.php");
        exit();
    }
}
if (isset($_POST['remove'])) {
    $plantIDToRemove = $_POST['plantId'];
    $deletePlantQuery = $conn->prepare("DELETE FROM basket WHERE user_id = ? AND plant_id = ?");
    $deletePlantQuery->bind_param("ii", $userID, $plantIDToRemove);
    $deletePlantQuery->execute();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <h1 class="text-2xl font-bold my-4">Shopping Cart</h1>
            <form method="post" action="">
                <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded" type="submit"
                    name="checkout" value="checkout">
                    Checkout
                </button>
            </form>
        </div>
        <div class="mt-8">
            <?php
            $selectQuery = "SELECT * 
        FROM basket
        JOIN plants ON plants.id = basket.plant_id
        WHERE user_id = $userID";
            $queryResult = mysqli_query($conn, $selectQuery);

            while ($plantInfo = mysqli_fetch_assoc($queryResult)) {
                ?>
            <form method="post" action="">
                <div class="flex flex-col md:flex-row border-b border-gray-400 py-4">
                    <div class="flex-shrink-0">
                        <img src="<?php echo $plantInfo['image_url']; ?>" alt="Product image"
                            class="w-32 h-32 object-cover">
                    </div>
                    <div class="mt-4 md:mt-0 md:ml-6">
                        <div class="flex items-center">
                            <h2 class="text-lg font-bold">
                                <?php echo $plantInfo['name']; ?>
                            </h2>
                        </div>
                        <div class="mt-4 flex items-center">
                            <span class="mr-2 text-gray-600">Quantity:</span>
                            <div class="flex items-center">
                                <button class="bg-gray-200 rounded-l-lg px-2 py-1" type="submit" name="decrease"
                                    value="1">
                                    <input type="hidden" name="plantId" value="<?php echo $plantInfo['plant_id']; ?>">
                                    -
                                </button>
                                <span class="mx-2 text-gray-600">
                                    <?php echo $plantInfo['quantity']; ?>
                                </span>
                                <button class="bg-gray-200 rounded-r-lg px-2 py-1" type="submit" name="increase"
                                    value="1">
                                    <input type="hidden" name="plantId" value="<?php echo $plantInfo['plant_id']; ?>">
                                    +
                                </button>
                            </div>
                            <span class="ml-4 font-bold">$
                                <?php echo $plantInfo['price']; ?>
                            </span>
                        </div>
                    </div>
                    <div class="ml-auto">
                        <!-- Moved delete button to the left -->
                        <button class="text-red-500 hover:text-red-700" type="submit" name="remove" value="1">
                            <input type="hidden" name="plantId" value="<?php echo $plantInfo['plant_id']; ?>">
                            Remove
                        </button>
                    </div>
                </div>
            </form>
            <?php
            }
            ?>

        </div>
        <div class="flex justify-end items-center mt-8">
            <span class="text-gray-600 mr-4">Subtotal:</span>

            <span class="text-xl font-bold">$
                <?php echo number_format($subtotal, 2); ?>
            </span>
        </div>
    </div>

</body>

</html>