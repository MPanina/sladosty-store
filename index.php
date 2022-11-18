<?php

include_once 'connect.php';

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

                $genreSelect = "SELECT * FROM `countries`";
                $genreSelectResult = mysqli_query($connect, $genreSelect);



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
                                echo "<a href='category.php?categoryid="  . $categoryRow['id'] . "' class='log-nav-link'>" . $categoryRow['name'] . "</a>";
                                echo "</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </div>


        <aside class="promo__aside aside">
            <form class="aside__form form" method="GET" action="genreselect.php">
                <h3 class="form__label">Страна-производитель</h3>
                <div class="form__checkbox__wrapper">
                    <?php
                    include_once 'filter.php'
                    ?>
                </div>
                <input type="submit" class="aside__button" value="Отправить">
            </form>
        </aside>


        <section class="main__section store">
            <div class="container store__container">
                <div class="store__wrapper product">
                    <?php

                    $prodSelect = "SELECT * FROM `product` ORDER BY prod_name";
                    $prodSelectResult = mysqli_query($connect, $prodSelect);

                    $fltSelect = "SELECT * FROM prod_genre, countries
                        WHERE prod_genre.id_genre = countries.id";
                    $fltSelectResult = mysqli_query($connect, $fltSelect);

                    ?>
                    <div class="product__list">
                        <?php
                        foreach ($prodSelectResult as $prodRow) {
                            echo "<a href='productcart.php?prodid=" . $prodRow['id'] . "'>";
                            echo "<div class='product__item product'>";
                            echo "<img src='img/" . $prodRow['min_image'] . "' alt='' class='prod__image'>";
                            echo "<div class='product__tags'>
                                    <h3 class='product__name'>" . $prodRow['prod_name'] . "</h3>";

                            echo "<ul class='product__list labels'>";
                            foreach ($fltSelectResult as $fltRow) {
                                if ($fltRow['id_prod'] == $prodRow['id']) {
                                    echo "<span class='product__span'>" . $fltRow['name'] . "</span>";
                                }
                            }
                            echo "<span class='product__span-price'>" . $prodRow['price'] . " ₽" . "</span>";
                            echo "</ul>";
                            echo "</div>";
                            echo "</div>";
                            echo "</a>";
                        }
                        ?>
                    </div>
                </div>


            </div>

        </section>
    </main>
</body>

</html>