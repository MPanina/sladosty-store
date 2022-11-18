<?php

include_once 'connect.php';
$user = $_SESSION['id'];
if (isset($_GET['prodid'])) {
    $prod = $_GET['prodid'];
    $prodInsert = "INSERT INTO `bucket` (`id_user`, `id_prod`) VALUES ('$user', '$prod')";

    if ($connect->query($prodInsert)) {
?>

<?php
    } else {
        echo "<p>" . "Ошибка:" . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/normalize.css">
    <title>Интернет-магазин десертов</title>
</head>

<body>
    <main class="main">
        <header class="header">
            <div class="container header__container">
                <nav class="header__top__nav nav">
                    <ul class="nav__list">
                        <li class="nav__item"><a href="#" class="nav__link">Контакты</a></li>
                        <li class="nav__item"><a href="#" class="nav__link">Как заказать</a></li>
                        <li class="nav__item"><a href="#" class="nav__link">Оплата</a></li>
                        <li class="nav__item"><a href="#" class="nav__link">Доставка</a></li>

                    </ul>
                    <ul class="nav__list-end">
                        <li class="nav__item"><span class="nav__top-text">8 800 535-35-35</span>
                            <br>
                        <li class="nav__item"><span class="nav__top-text">без выходных, с 8:00 до 21:00</span>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="header__none">
            <div class="container header__container">
                <div class="header__wrapper log-block">
                    <form action="actiontest.php" class="log-block__form search" method="GET">
                        <input type="text" class="search__input" name="search_string" placeholder="поиск">

                    </form>
                    <nav class="log-block__nav nav">
                        <ul class="log-nav-list">
                            <li class="log-nav-item"><a href="#" class="log-nav-ink">Волгоград</a></li>
                            <?php
                            if (isset($_SESSION["id"])) {
                                echo "<a href='cart.php' class='cart__link'>" . "Корзина" . "</a>";
                            } else {
                                echo "<a href='reg/auth.php' class='cart__link'>" . "Войдите для доступа к корзине" . "</a>";
                            }
                            ?>
                            <li class="log-nav-item"><a href="#" class="log-nav-link">Избранное</a></li>
                            <?php
                            if (isset($_SESSION["id"])) {
                                echo "<a href='profile.php?userid=" . $_SESSION['id'] . "' class='login__link'>" . $_SESSION["login"] . "</a>";
                                echo "<a href='reg/exit.php' class='login__link'>Выйти</a>";
                            } else {
                                echo "<a href='reg/auth.php' class='login__link'>Войти</a>";
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
                <?php
                $categorySelect = "SELECT * FROM `categories`";
                $categorySelectResult = mysqli_query($connect, $categorySelect);
                ?>
                <div class="container main__container">
                    <div class="header__wrapper-main main-block">
                        <a href="index.php">

                            <a href="http://sladosty/index.php"><span class="burger__item-text">Каталог товаров</span></a>
                        </a>
                        <ul class="log-nav-list">
                            <?php
                            foreach ($categorySelectResult as $categoryRow) {

                                echo "<li class='log-nav-item'>";
                                echo "<a href='category.php/" . $categoryRow['name'] . "/?categoryid=" . $categoryRow['id'] . "' class='log-nav-link'>" . $categoryRow['name'] . "</a>";
                                echo "</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <section class="main__section cart">
            <div class="container store__container">
                <div class="cart__wrapper">
                    <div class="cart__shortcut ">
                        <a href="index.php">Все продукты > </a>
                        <span class="shortcut__span">Ваша корзина</span>
                    </div>
                    <h2 class="cart__label">ВАША КОРЗИНА</h2>
                </div>
                <div class="prod__wrapper product">

                    <?php
                    $cartSelect = "SELECT * FROM `bucket`
                    INNER JOIN product on bucket.id_prod = product.id
                    WHERE bucket.id_user = $user";
                    $cartSelectResult = mysqli_query($connect, $cartSelect);

                    ?>
                    <div class="product__list">
                        <?php
                        foreach ($cartSelectResult as $cartRow) {
                            
                            echo "<a href='productcart.php?prodid=" . $cartRow['id'] . "'>";
                            echo "<div class='product__item product'>";
                            echo "<img src='img/" . $cartRow['min_image'] . "' alt='' class='game__image'>";
                            echo "<div class='product__tags'>
                                    <h3 class='product__name'>" . $cartRow['prod_name'] . "</h3>";
                            echo "<span class='product__span-price'>" . $cartRow['price'] . " ₽" . "</span>";
                            echo "<a href='buy.php?idbuygame=" . $cartRow['id_prod'] . "' class='price__delete'>Купить</a>";
                            echo "<a href='cart.php?delete=" . $cartRow['id'] . "' class='price__delete'>Удалить</a>";             
                            echo "</div>";
                            echo "</div>";
                            echo "</a>";
                        }
                        
                        if (isset($_GET['delete'])) {               
                            $proddeleteId = $_GET['delete'];
                            $deleteProd = "DELETE FROM `bucket` WHERE id_prod = '$proddeleteId'";

                            if ($connect->query($deleteProd)) {
                        ?>
                               
                        <?php
                            } else {
                                echo "<p>" . "Ошибка:" . $conn->error . "</p>";
                            }
                        }
                        ?>
                    </div>


                </div>

                <div class="prod__down down">
                    <a href="cart.php?deleteall=1" class="down__all">Удалить все товары</a>
                    <?php
                    if (isset($_GET['deleteall'])) {
                        $deleteAllprod = "DELETE FROM `bucket` WHERE id_user = '$user'";
                        if ($connect->query($deleteAllprod)) {
                    ?>
                           
                    <?php
                        } else {
                            echo "<p>" . "Ошибка:" . $conn->error . "</p>";
                        }
                    }
                    ?>
                </div>
            </div>

        </section>







    </main>
</body>

</html>