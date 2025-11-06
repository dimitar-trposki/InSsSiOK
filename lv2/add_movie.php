<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $release_year = intval($_POST['release_year']);

    if (empty($title) || empty($genre) || empty($release_year)) {
        echo "Please fill in all required fields correctly.";
        exit;
    }

    $db = connectDatabase();

    $stmt = $db->prepare("INSERT INTO movies (title, genre, release_year) VALUES (:title, :genre, :release_year)");
    $stmt->bindValue(':title', $title, SQLITE3_TEXT);
    $stmt->bindValue(':genre', $genre, SQLITE3_TEXT);
    $stmt->bindValue(':release_year', $release_year, SQLITE3_INTEGER);

    if ($stmt->execute()) {
        header('Location: movies.php');
    } else {
        echo "Error adding movie: " . $db->lastErrorMsg();
    }

    $db->close();
} else {
    echo "Invalid request method. Please submit the form to add a movie.";
}