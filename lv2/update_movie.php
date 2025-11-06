<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $release_year = intval($_POST['release_year']);

    $db = connectDatabase();

    $stmt = $db->prepare("UPDATE movies SET title = :title, genre = :genre, release_year = :release_year WHERE id = :id");
    $stmt->bindValue(':title', $title, SQLITE3_TEXT);
    $stmt->bindValue(':genre', $genre, SQLITE3_TEXT);
    $stmt->bindValue(':release_year', $release_year, SQLITE3_INTEGER);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->execute();

    $db->close();

    header("Location: movies.php");
    exit();
} else {
    echo "Invalid request.";
}