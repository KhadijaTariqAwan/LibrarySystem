<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $check = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $check);
    
    if (mysqli_num_rows($result) > 0) {
        echo "Username already exists. Please try a different one.";
    } else {
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if (mysqli_query($conn, $sql)) {
            echo "Account created successfully. <a href='login.html'>Login Now</a>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
