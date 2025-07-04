<?php
include 'db.php';

$title = $_POST['title'];
$author = $_POST['author'];
$category = $_POST['category'];
$isbn = $_POST['isbn'];
$quantity = intval($_POST['quantity']);

// Check if the book already exists
$sql = "SELECT * FROM books WHERE title = ? AND author = ? AND isbn = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $title, $author, $isbn);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Book exists — update quantity
    $update = $conn->prepare("UPDATE books SET quantity = quantity + ? WHERE title = ? AND author = ? AND isbn = ?");
    $update->bind_param("isss", $quantity, $title, $author, $isbn);
    $update->execute();

    echo "Book already exists. Quantity updated.";
} else {
    // Insert new book with entered quantity and availability
    $availability = $quantity > 0 ? "Yes" : "No";
    $insert = $conn->prepare("INSERT INTO books (title, author, category, isbn, quantity, availability) VALUES (?, ?, ?, ?, ?, ?)");
    $insert->bind_param("ssssis", $title, $author, $category, $isbn, $quantity, $availability);
    $insert->execute();

    echo "New book added successfully.";
}

$conn->close();
?>
