
<?php

require_once __DIR__ . '/config/database.php';

try {

    $pdo = getPDO();

    echo "<h1>BookCraft Database Connected!</h1>";

    $stmt = $pdo->query("SELECT COUNT(*) FROM books");

    $totalBooks = $stmt->fetchColumn();

    echo "<p>Total books in database: " . $totalBooks . "</p>";

} catch (Throwable $e) {

    echo "<h2>Database connection failed.</h2>";
    echo "<p>Please check the database configuration.</p>";

}

?>
