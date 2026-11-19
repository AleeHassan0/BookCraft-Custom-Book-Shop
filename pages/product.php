
<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

$pageTitle = "Book Details | BookCraft";

// Get book ID from URL
$bookId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$bookId || $bookId < 1) {
    http_response_code(404);
    exit("Book not found.");
}

// Retrieve selected book from database
$pdo = getPDO();

$sql = "SELECT * FROM books
        WHERE id = :id AND is_active = 1";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    'id' => $bookId
]);

$book = $stmt->fetch();



// Check if book exists
if (!$book) {
    http_response_code(404);
    exit("Book not found.");
}

require_once __DIR__ . '/../classes/BookOption.php';

$bookOption = new BookOption($pdo);

$options = $bookOption->getByBookId($bookId);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($book['title']) ?> | BookCraft</title>

    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">

    <script src="<?= BASE_URL ?>assets/js/app.js" defer></script>
    <script src="<?= BASE_URL ?>assets/js/customizer.js" defer></script>

</head>

<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="product-detail-page">

        <div class="product-detail-container">

            <div class="product-preview">

<div class="book-cover cover-one detail-book-cover">
                    <span>BOOKCRAFT EDITION</span>

                    <h3>
                        <?= htmlspecialchars($book['title']) ?>
                    </h3>

                    <small>DESIGNED FOR YOU</small>

                </div>

            </div>

<div class="product-details">

    <p class="subtitle">BOOKCRAFT COLLECTION</p>

    <h1>
        <?= htmlspecialchars($book['title']) ?>
    </h1>

    <p class="detail-description">
        <?= htmlspecialchars($book['description'] ?? '') ?>
    </p>

    <!-- Base Price -->
    <div class="detail-price">

        <span
            id="total-price"
            data-base-price="<?= htmlspecialchars($book['base_price']) ?>"
        >
            €<?= number_format((float)$book['base_price'], 2) ?>
        </span>

    </div>

    <!-- Customization Options -->
    <div class="customization-placeholder">

        <h3>Customize Your Book</h3>

        <?php

        $optionLabels = [
            'size' => 'Book Size',
            'page_color' => 'Page Colour',
            'paper_type' => 'Paper Type',
            'cover_type' => 'Cover Type',
            'page_count' => 'Number of Pages'
        ];

        foreach ($optionLabels as $type => $label):

            if (empty($options[$type])) {
                continue;
            }

        ?>

            <div class="custom-option">

                <label for="<?= htmlspecialchars($type) ?>">
                    <?= htmlspecialchars($label) ?>
                </label>

                <select
                    name="<?= htmlspecialchars($type) ?>"
                    id="<?= htmlspecialchars($type) ?>"
                    class="book-option-select"
                >

                    <?php foreach ($options[$type] as $option): ?>

                        <option
                            value="<?= (int)$option['id'] ?>"
                            data-price="<?= htmlspecialchars(
                                $option['price_adjustment']
                            ) ?>"
                        >

                            <?= htmlspecialchars($option['option_name']) ?>

                            <?php if ((float)$option['price_adjustment'] > 0): ?>

                                (+€<?= number_format(
                                    (float)$option['price_adjustment'],
                                    2
                                ) ?>)

                            <?php elseif ((float)$option['price_adjustment'] < 0): ?>

                                (-€<?= number_format(
                                    abs((float)$option['price_adjustment']),
                                    2
                                ) ?>)

                            <?php endif; ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

        <?php endforeach; ?>

    </div>

    <!-- Total Price -->
    <div class="price-summary">

        <h3>Total Price</h3>

        <p id="total-price-display">
            €<?= number_format((float)$book['base_price'], 2) ?>
        </p>

    </div>

    <a href="<?= BASE_URL ?>pages/shop.php"
       class="back-button">

        ← Back to Shop

    </a>

</div>

                



             

            </div>

        </div>

    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
