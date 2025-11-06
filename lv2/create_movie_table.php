<?php

$db = new SQLite3(__DIR__ . "/database/university_lv_db.sqlite3");

$createTableQuery = <<<SQL
CREATE TABLE IF NOT EXISTS movies (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    genre TEXT NOT NULL,
    release_year INTEGER NOT NULL
);
SQL;

if ($db->exec($createTableQuery)) {
    echo "Table movies created successfully";
} else {
    echo "Error creating table: " . $db->lastErrorMsg();
}

$db->close();