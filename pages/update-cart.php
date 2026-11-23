<?php

require_once __DIR__ . '/../config/app.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'pages/cart.php');
    exit;
}

$itemKey = $_POST['item_key'] ?? '';

$quantity = filter_input(
    INPUT_POST,
    'quantity',
    FILTER_VALIDATE_INT
);

if (
    isset($_SESSION['cart'][$itemKey]) &&
    $quantity !== false &&
    $quantity !== null &&
    $quantity >= 1 &&
    $quantity <= 99
) {

    $_SESSION['cart'][$itemKey]['quantity'] = $quantity;

}

header('Location: ' . BASE_URL . 'pages/cart.php');

exit;

?>