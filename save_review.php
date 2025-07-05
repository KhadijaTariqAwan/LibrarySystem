<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $review = $_POST['review'];

    // Create table if not exists
    $conn->query("CREATE TABLE IF NOT EXISTS reviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        title VARCHAR(255),
        review TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $stmt = $conn->prepare("INSERT INTO reviews (name, title, review) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $title, $review);

    if ($stmt->execute()) {
        echo "<script>alert('Thank you for your review!'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "Error saving review.";
    }

    $stmt->close();
    $conn->close();
}
?>
