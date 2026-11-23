<header>

    <nav>

        <a href="<?= BASE_URL ?>index.php"
           class="logo">

            BookCraft

        </a>

        <ul>

            <li>
                <a href="<?= BASE_URL ?>index.php">
                    Home
                </a>
            </li>

            <li>
                <a href="<?= BASE_URL ?>pages/shop.php">
                    Shop
                </a>
            </li>

            

            <li>

                <a href="<?= BASE_URL ?>pages/cart.php">

                    Cart

                    <?php

                    $cartCount = 0;

                    if (isset($_SESSION['cart'])) {

                        foreach ($_SESSION['cart'] as $item) {

                            $cartCount += $item['quantity'];

                        }

                    }

                    ?>

                    <span class="cart-count">

                        <?= $cartCount ?>

                    </span>

                </a>

            </li>

        </ul>

    </nav>

</header>
