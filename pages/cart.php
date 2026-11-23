<?php

require_once __DIR__ . '/../config/app.php';

$pageTitle = "Shopping Cart | BookCraft";

$cart = $_SESSION['cart'] ?? [];

$subtotal = 0;

foreach ($cart as $item) {
    $subtotal += $item['unit_price'] * $item['quantity'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title><?= $pageTitle ?></title>

    <link rel="stylesheet"
          href="<?= BASE_URL ?>assets/css/style.css">

</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="cart-page">

    <div class="cart-heading">

        <p class="subtitle">YOUR COLLECTION</p>

        <h1>Your Shopping Cart</h1>

    </div>

    <?php if (empty($cart)): ?>

        <div class="empty-cart">

            <h2>Your cart is empty.</h2>

            <p>
                You haven't added any books to your cart yet.
            </p>

            <a href="<?= BASE_URL ?>pages/shop.php"
               class="hero-button">

                Explore Books

            </a>

        </div>

    <?php else: ?>

        <div class="cart-container">

            <div class="cart-items">

                <?php foreach ($cart as $key => $item): ?>

                    <div class="cart-item">

                        <div class="cart-book-cover">

                            <span>BOOKCRAFT</span>

                            <h3>
                                <?= htmlspecialchars($item['title']) ?>
                            </h3>

                        </div>

                        <div class="cart-item-details">

                            <h2>
                                <?= htmlspecialchars($item['title']) ?>
                            </h2>

                            <p class="cart-unit-price">

                                €<?= number_format(
                                    $item['unit_price'],
                                    2
                                ) ?> per book

                            </p>

                            <!-- Customization Details -->

                            <div class="cart-options">

                                <?php foreach (
                                    $item['options'] as $option
                                ): ?>

                                    <p>

                                        <strong>
                                            <?= htmlspecialchars(
                                                ucfirst(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        array_search(
                                                            $option,
                                                            $item['options']
                                                        ) ?: ''
                                                    )
                                                )
                                            ?>:
                                        </strong>

                                        <?= htmlspecialchars(
                                            $option['name']
                                        ) ?>

                                    </p>

                                <?php endforeach; ?>

                            </div>

                            <!-- Quantity Form -->

                            <form
                                action="<?= BASE_URL ?>pages/update-cart.php"
                                method="POST"
                                class="quantity-form"
                            >

                                <input
                                    type="hidden"
                                    name="item_key"
                                    value="<?= htmlspecialchars($key) ?>"
                                >

                                <label for="quantity-<?= htmlspecialchars($key) ?>">

                                    Quantity:

                                </label>

                                <input
                                    type="number"
                                    name="quantity"
                                    id="quantity-<?= htmlspecialchars($key) ?>"
                                    value="<?= (int) $item['quantity'] ?>"
                                    min="1"
                                    max="99"
                                >

                                <button type="submit"
                                        class="update-button">

                                    Update

                                </button>

                            </form>

                            <!-- Remove Item -->

                            <form
                                action="<?= BASE_URL ?>pages/remove-from-cart.php"
                                method="POST"
                            >

                                <input
                                    type="hidden"
                                    name="item_key"
                                    value="<?= htmlspecialchars($key) ?>"
                                >

                                <button type="submit"
                                        class="remove-button">

                                    Remove

                                </button>

                            </form>

                        </div>

                        <div class="cart-item-total">

                            <strong>

                                €<?= number_format(
                                    $item['unit_price'] * $item['quantity'],
                                    2
                                ) ?>

                            </strong>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

            <!-- Cart Summary -->

            <div class="cart-summary">

                <h2>Order Summary</h2>

                <div class="summary-row">

                    <span>Subtotal</span>

                    <strong>
                        €<?= number_format($subtotal, 2) ?>
                    </strong>

                </div>

                <div class="summary-row">

                    <span>Shipping</span>

                    <strong>Calculated later</strong>

                </div>

                <div class="summary-total">

                    <span>Total</span>

                    <strong>
                        €<?= number_format($subtotal, 2) ?>
                    </strong>

                </div>

                <button class="checkout-button"
                        type="button"
                        disabled>

                    Checkout (Coming Soon)

                </button>

                <a href="<?= BASE_URL ?>pages/shop.php"
                   class="continue-shopping">

                    Continue Shopping

                </a>

            </div>

        </div>

    <?php endif; ?>

</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>

</html>