<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
<?php

// Starts a session and checks if the user is logged in. If not, it redirects to the login page.
// Gets the user's ID and username from the session variables.
// Connects to the database and retrieves the user's data based on their ID.
// Displays the user's information on the page, including their ID and email address.
// Closes the database connection.

session_start();

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header('Location: login.php');
    exit();
}



$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];

// require_once("db.php");

// Get the user's data from the database
// $query = "SELECT * FROM xyz_users WHERE id='$user_id'";
// $result = mysqli_query($conn, $query);
// $user_data = mysqli_fetch_assoc($result);

// Display the user's information
echo "<div id=\"credentials\">\n";
echo "  <h1>Welcome, $username!</h1>\n";
echo "  <p>Your ID is: $user_id</p>\n";
echo "  <p>Your email is: " . $email . "</p>\n";
echo "  <a href=\"logout.php\">Logout</a>\n";
echo "</div>";


// mysqli_close($conn);
?>

<a class="btn" href="chat/">Take me to the CHAT</a>

</body>
</html>
