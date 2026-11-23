<?php

require_once __DIR__ . '/../config/app.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'pages/cart.php');
    exit;
}

$itemKey = $_POST['item_key'] ?? '';

if (isset($_SESSION['cart'][$itemKey])) {

    unset($_SESSION['cart'][$itemKey]);

}

header('Location: ' . BASE_URL . 'pages/cart.php');

exit;

?>