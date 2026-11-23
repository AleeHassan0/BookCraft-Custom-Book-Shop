<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'pages/shop.php');
    exit;
}

$pdo = getPDO();

// Get book ID
$bookId = filter_input(INPUT_POST, 'book_id', FILTER_VALIDATE_INT);

if (!$bookId || $bookId < 1) {
    exit('Invalid book.');
}

// Get book information
$stmt = $pdo->prepare("
    SELECT id, title, base_price
    FROM books
    WHERE id = :id AND is_active = 1
");

$stmt->execute(['id' => $bookId]);

$book = $stmt->fetch();

if (!$book) {
    exit('Book not found.');
}

// Define customization types
$optionTypes = [
    'size',
    'page_color',
    'paper_type',
    'cover_type',
    'page_count'
];

$selectedOptions = [];
$totalPrice = (float) $book['base_price'];

// Validate and retrieve selected options
foreach ($optionTypes as $type) {

    $optionId = filter_input(
        INPUT_POST,
        $type,
        FILTER_VALIDATE_INT
    );

    // Skip if this book does not have this option
    if (!$optionId) {
        continue;
    }

    $stmt = $pdo->prepare("
        SELECT id, option_type, option_name, price_adjustment
        FROM book_options
        WHERE id = :id
          AND book_id = :book_id
          AND is_active = 1
    ");

    $stmt->execute([
        'id' => $optionId,
        'book_id' => $bookId
    ]);

    $option = $stmt->fetch();

   if (!$option || $option['option_type'] !== $type) {
    exit('Invalid customization option.');
}

    // Store selected option
    $selectedOptions[$type] = [
        'id' => (int) $option['id'],
        'name' => $option['option_name'],
        'price' => (float) $option['price_adjustment']
    ];

    // Calculate final price
    $totalPrice += (float) $option['price_adjustment'];
}

// Create unique cart item ID
$itemKey = md5(
    $bookId . serialize($selectedOptions)
);

// Initialize cart if necessary
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// If identical customized book already exists
if (isset($_SESSION['cart'][$itemKey])) {

    $_SESSION['cart'][$itemKey]['quantity']++;

} else {

    // Add new customized book
    $_SESSION['cart'][$itemKey] = [
        'book_id' => (int) $book['id'],
        'title' => $book['title'],
        'base_price' => (float) $book['base_price'],
        'options' => $selectedOptions,
        'unit_price' => $totalPrice,
        'quantity' => 1
    ];

}

// Redirect to cart
header('Location: ' . BASE_URL . 'pages/cart.php');
exit;

?>