
<?php

require_once __DIR__ . '/config/app.php';

$pageTitle = "Home | BookCraft";

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

    <!-- Website Header -->
    <?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Main Content -->
    <main>

        <section class="hero">

            <div class="hero-content">

                <p class="subtitle">YOUR BOOK. YOUR DESIGN.</p>

                <h1>
                    Every Book Has<br>
                    A Story. <span>Make Yours.</span>
                </h1>

                <p class="hero-description">
                    Create your perfect book. Choose your size,
                    pages, paper and cover. We make it exactly
                    how you imagine it.
                </p>

                <a href="<?= BASE_URL ?>pages/shop.php" class="hero-button">
                    Explore Books →
                </a>

            </div>

        </section>

    </main>

    <!-- Website Footer -->
    <?php include __DIR__ . '/includes/footer.php'; ?>

</body>

</html>
