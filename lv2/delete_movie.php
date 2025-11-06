<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);
    $db = connectDatabase();

    $stmt = $db->prepare("DELETE FROM movies WHERE id = :id");
    $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
    $stmt->execute();

    $db->close();

    header("Location: movies.php");
    exit();
} else {
    echo "Invalid request.";
}