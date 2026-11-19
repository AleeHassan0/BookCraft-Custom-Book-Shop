
<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

// Page title
$pageTitle = "Shop | BookCraft";

// Retrieve books from MySQL
$pdo = getPDO();

$sql = "SELECT * FROM books
        WHERE is_active = 1
        ORDER BY id ASC";

$stmt = $pdo->query($sql);

$books = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $pageTitle; ?></title>

    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">

    <script src="<?= BASE_URL ?>assets/js/app.js" defer></script>

</head>

<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="shop-page">

        <section class="shop-heading">

            <p class="subtitle">EXPLORE OUR COLLECTION</p>

            <h1>Find Your Next <span>Favourite Book.</span></h1>

            <p>
                Discover beautiful books and create
                something uniquely yours.
            </p>

        </section>

        <section class="product-section">

            <h2>Our Collection</h2>

            <div class="product-grid">

                <?php if (count($books) > 0): ?>

                    <?php foreach ($books as $book): ?>

                        <div class="product-card">

                            <div class="book-cover cover-one">

                                <span>BOOKCRAFT EDITION</span>

                                <h3>
                                    <?= htmlspecialchars($book['title']) ?>
                                </h3>

                                <small>DESIGNED FOR YOU</small>

                            </div>

                            <div class="product-info">

                                <h3>
                                    <?= htmlspecialchars($book['title']) ?>
                                </h3>

                                <p>
                                    <?= htmlspecialchars(
                                        $book['description'] ?? ''
                                    ) ?>
                                </p>

                                <div class="product-bottom">

                                    <strong>
                                        €<?= number_format(
                                            (float)$book['base_price'],
                                            2
                                        ) ?>
                                    </strong>

                                    <a
    href="<?= BASE_URL ?>pages/product.php?id=<?= (int)$book['id'] ?>"
    class="add-button"
>
    View Details
</a>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <p>No books are currently available.</p>

                <?php endif; ?>

            </div>

        </section>

    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
