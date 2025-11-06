<?php

include 'db_connection.php';

$db = connectDatabase();

$query = "SELECT * FROM movies";
$result = $db->query($query);

if (!$result) {
    die("Error fetching movies: " . $db->lastErrorMsg());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Movies</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        h1 {
            margin: 0;
            color: #111827;
        }

        a {
            background-color: #10b981;
            color: white;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #059669;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        th, td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #374151;
        }

        tr:hover {
            background-color: #f1f5f9;
        }

        button {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            margin-left: 6px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2563eb;
        }

        form {
            display: inline;
        }

        .delete-btn {
            background-color: #ef4444;
        }

        .delete-btn:hover {
            background-color: #dc2626;
        }

        div[style*="justify-content: space-between"] {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div style="display: flex; align-items: center; justify-content: space-between">
    <h1>Movie List</h1>
    <a href="add_movie_form.php">
        Add New Movie
    </a>
</div>
<table>
    <thead>
    <tr>
        <th>Title</th>
        <th>Genre</th>
        <th>Release year</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($result): ?>
        <?php while ($movie = $result->fetchArray(SQLITE3_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($movie['title']); ?></td>
                <td><?php echo htmlspecialchars($movie['genre']); ?></td>
                <td><?php echo htmlspecialchars($movie['release_year']); ?></td>
                <td>
                    <form action="delete_movie.php" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $movie['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                    <form action="update_movie_form.php" method="get" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $movie['id']; ?>">
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No movies found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>
