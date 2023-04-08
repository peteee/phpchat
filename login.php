<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Login</h1>
    
    <?php include_once("mods/navigation.inc.php"); ?>

    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>

<?php
require_once("db.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = strip_tags(trim($_POST['username']));
    $password = strip_tags(trim($_POST['password']));

    $username = $conn -> real_escape_string($username);
    $password = $conn -> real_escape_string($password);

    // Check if the username exists
    $query = "SELECT * FROM xyz_users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 0) {
        echo '<p class="err_msg">Username not found<p>';
        exit();
    }

    // Verify the password
    $user_data = mysqli_fetch_assoc($result);
    if (password_verify($password, $user_data['password'])) {
        // Password is correct, create a session
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['username'] = $user_data['username'];
        $_SESSION['email'] = $user_data['email'];
        header('Location: dashboard.php');
        exit();
    } else {
        // Password is incorrect
        echo "Incorrect password";
        exit();
    }
}
?>
