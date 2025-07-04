<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['book_id'])) {
    $book_id = intval($_POST['book_id']);

    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        header("Location: delete_book_list.php?deleted=1");
        exit();
    } else {
        header("Location: delete_book_list.php?deleted=0");
        exit();
    }
} else {
    header("Location: delete_book_list.php?deleted=0");
    exit();
}
?>
