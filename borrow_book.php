<?php
include 'db.php';

$member_id = $_POST['member_id'];
$book_id = $_POST['book_id'];

// Check if book exists and get quantity
$check = $conn->prepare("SELECT quantity FROM books WHERE id = ?");
$check->bind_param("i", $book_id);
$check->execute();
$result = $check->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    echo "Book not found.";
    exit;
}

$current_quantity = (int)$book['quantity'];

if ($current_quantity <= 0) {
    echo "Book is currently unavailable.";
    exit;
}

// Insert borrow transaction
$log = $conn->prepare("INSERT INTO transactions (member_id, book_id, action) VALUES (?, ?, 'borrow')");
$log->bind_param("ii", $member_id, $book_id);
$log->execute();

// Update quantity and availability
$new_quantity = $current_quantity - 1;
$availability = ($new_quantity > 0) ? 'Yes' : 'No';

$update = $conn->prepare("UPDATE books SET quantity = ?, availability = ? WHERE id = ?");
$update->bind_param("isi", $new_quantity, $availability, $book_id);
$update->execute();

echo "Book borrowed successfully. Remaining quantity: $new_quantity";
$conn->close();
