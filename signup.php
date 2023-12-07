<?php
// Handle form submission
include("config/db.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    if (empty($fullname) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "<p class='text-red-500'>All fields are required.</p>";
    } elseif ($password !== $confirm_password) {
        echo "<p class='text-red-500'>Password and Confirm Password do not match.</p>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Use prepared statement to prevent SQL injection
        $insert_query = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
        $stmt=$conn->prepare($insert_query);

        if ($stmt === false) {
            die("Error in statement preparation: " . $conn->error);
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("sss", $fullname, $email, $hashed_password);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            // Registration successful, redirect to login page
            session_start();
            $_SESSION['LOGINEMAIL'] = $email;
            header("Location: whos.php");
            exit;
        } else {
            echo "<p class='text-red-500'>Error in registration.</p>";
        }

        // Close the statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="bg-grey-lighter min-h-screen flex flex-col">
        <div class="container max-w-sm mx-auto flex-1 flex flex-col items-center justify-center px-2">
            <div class="bg-white px-6 py-8 rounded shadow-md text-black w-full">
                <h1 class="mb-8 text-3xl text-center">Sign up</h1>

                <?php
                // Display success or error messages here
                ?>

                <form method="post">
                    <input type="text" class="block border border-grey-light w-full p-3 rounded mb-4" name="fullname"
                        placeholder="Full Name" />

                    <input type="text" class="block border border-grey-light w-full p-3 rounded mb-4" name="email"
                        placeholder="Email" type="email" />

                    <input type=" password" class="block border border-grey-light w-full p-3 rounded mb-4"
                        name="password" placeholder="Password" />
                    <input type="password" class="block border border-grey-light w-full p-3 rounded mb-4"
                        name="confirm_password" placeholder="Confirm Password" />

                    <button type="submit"
                        class="w-full text-center py-3 border  rounded bg-green-400 text-black hover:bg-green-dark focus:outline-none my-1">Create
                        Account</button>
                </form>
            </div>

            <div class="text-grey-dark mt-6">
                Already have an account? <a class="no-underline border-b border-blue text-blue" href="./login.php">Log
                    in</a>.
            </div>
        </div>
    </div>
</body>

</html>