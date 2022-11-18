<?php
include_once 'connect.php';
if (isset($_GET['search_string'])) {
} else if ($_GET) {

    $array = $_GET; //Получаем массив GET запроса
    $c = ""; //Переменная для пустой строки


    $arraycount1 = count($array); //Считает количество элементов GET массива
    // echo $arraycount1;
    foreach ($array as $key => $value) {
        $arraycount1 = $arraycount1 - 1;
        $a = "name"; //Присваиваем имя поля
        $a = "$a = "; //Формируем строку
        $arraycount = count($value); //Считаем количество элементов в массивах
        // echo $arraycount;
        foreach ($value as $keyrow) {
            // echo $a; // переменная A содержит название характеристики для запроса
            $arraycount = $arraycount - 1;
            if ($arraycount == 0) //Если счетчик элементов равен 0
            {
                $b = $key . "." . $a . "'" . $keyrow . "' "; //Формируем конец строки из названия ключа и значения
                if ($arraycount1 !== 0) { //Если счетчик массива GET = 0 то
                    $c = $c . $b . "OR "; //Формируем новую строку и добавляем AND
                } else { //Если счетчик массива GET = 0
                    $c = $c . $b; //То формируем конец строки
                }
            } else {
                $b = $key . "." . $a . "'" . $keyrow . "' " . "OR "; //Формируем конец строки
                $c = $c . $b;
            }
        }
    }
} else {
    echo "Методом GET ничего не отправлено";
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
                            <li class="log-nav-item"><a href="#" class="log-nav-link">Корзина</a></li>
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
                    $fltSelect = "SELECT * FROM prod_genre, countries
                    WHERE prod_genre.id_genre = countries.id";
                    $fltSelectResult = mysqli_query($connect, $fltSelect); 
                    ?>

                    <div class="prod__list">
                        <?php
                        if (isset($_GET['genres'])) {
                            $genre = $_GET['genres'];
                            foreach ($genre as $gnr) {
                                $prodByCountSelect = "SELECT * FROM `product`
                                     JOIN prod_genre ON prod_genre.id_prod = product.id
                                     JOIN countries ON countries.id = prod_genre.id_genre
                                    WHERE countries.name = '$gnr'";
                                $prodByCountSelectResult = mysqli_query($connect, $prodByCountSelect);
                            }
                            foreach ($prodByCountSelectResult as $prodRow) {
                                echo "<a href='productcart.php?prodid=" . $prodRow['id'] . "'>";
                                echo "<div class='prod__item product'>";
                                echo "<img src='/img/" . $prodRow['min_image'] . "' alt='' class='prod__image'>";
                                echo "<div class='product__tags'>
                                    <h3 class='product__name'>" . $prodRow['prod_name'] . "</h3>";
                                echo "<ul class='product__list labels'>";
                                echo "</div>";
                                echo "</div>";
                        
                            }
                        } else {
                            foreach ($prodSelectResult as $prodRow) {
                                echo "<a href='productcart.php?prodid=" . $prodRow['id'] . "'>";
                                echo "<div class='prod__item product'>";
                                echo "<img src='/img/" . $prodRow['min_image'] . "' alt='' class='prod__image'>";
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
                        }

                        ?>
                    </div>

                </div>
            </div>
            </div>
        </section>
    </main>
</body>

</html>