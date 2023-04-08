<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <h1>Register</h1>

    <?php include_once("mods/navigation.inc.php"); ?>
    
    <form method="post" action="register.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <input type="submit" value="Register">
    </form>

    <?php include_once("mods/footer.inc.php"); ?>

</body>
</html>

<?php

require_once("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = strip_tags(trim($_POST['username']));
    $password = strip_tags(trim($_POST['password']));
    $email = strip_tags(trim($_POST['email']));

    $username = $conn -> real_escape_string($username);
    $password = $conn -> real_escape_string($password);
    $email = $conn -> real_escape_string($email);

    // Check if the username is already taken
    $query = "SELECT * FROM xyz_users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "Username already taken";
        exit();
    }

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user data into the database
    $query = "INSERT INTO xyz_users (username, password, email) VALUES ('$username', '$password_hash', '$email')";
    if (mysqli_query($conn, $query)) {
        echo "Registration successful";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

