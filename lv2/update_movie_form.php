<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $db = connectDatabase();

    // Fetch the current details of the student
    $stmt = $db->prepare("SELECT * FROM movies WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $movie = $result->fetchArray(SQLITE3_ASSOC);

    $db->close();
} else {
    die("Invalid movie ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Movie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #333;
            margin: 20px;
        }

        form {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #444;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #3b82f6;
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #3b82f6;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2563eb;
        }

        p {
            color: #555;
            text-align: center;
        }
    </style>
</head>
<body>
<h1>Update Movie</h1>

<?php if ($movie): ?>
    <form action="update_movie.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($movie['id']); ?>">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($movie['title']); ?>" required><br><br>
        <label for="genre">Genre:</label>
        <input type="text" name="genre" value="<?php echo htmlspecialchars($movie['genre']); ?>" required><br><br>
        <label for="release_year">Release year:</label>
        <input type="number" name="release_year" value="<?php echo htmlspecialchars($movie['release_year']); ?>"
               required><br><br>
        <button type="submit">Update Movie</button>
    </form>
<?php else: ?>
    <p>Movie not found.</p>
<?php endif; ?>
</body>
</html>