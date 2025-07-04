<?php
session_start();
include 'db.php';

// Run only if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Safely get values or assign empty string if missing
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepare and execute query
    $sql = "SELECT * FROM members WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check login
    if ($result->num_rows > 0) {
        $_SESSION['email'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Login failed. <a href='index.php'>Try again</a>";
    }
} else {
    // If accessed directly without POST
    header("Location: login.html");
    exit();
}
?>
