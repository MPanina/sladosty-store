<?php
include '../connect.php';
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/normalize.css">
    <title>Вход</title>
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
                <section class="section__reg reg">
                    <div class="container reg__container">
                        <div class="login__wrapper">
                            <h2 class="login__header">Авторизация</h2>
                            <p class="login__account">
                                Нет аккаунта? <a href="reg.php" class="login__link">Зарегистрируйтесь</a>
                            </p>
                            <form action="" class="login__form form" method="POST">
                                <label for="login">Логин</label>
                                <input class="login__input" type="text" name="login" id="login" required>
                                <label for="password">Пароль</label>
                                <input class="login__input" type="password" name="password" id="password" required>
                                <input type="submit" name="submitlog" class="reg__submit btn">
                            </form>

                            <?php

                            if (isset($_POST['submitlog'])) {
                                $login = $_POST["login"];
                                $auth = "SELECT * FROM `user` WHERE login='$login'";
                                $authResult = mysqli_query($connect, $auth);
                                $authAssoc = mysqli_fetch_assoc($authResult);
                                if (!empty($authAssoc)) {
                                    $hash = $authAssoc['password'];
                                    if (password_verify($_POST['password'], $hash)) {
                                        $userid = $authAssoc['id'];
                                        $userlogin = $authAssoc['login'];
                                        $_SESSION["login"] = $userlogin;
                                        $_SESSION["id"] = $userid;

                            ?>

                            <?php
                                    } else {
                                        echo "<p>Пароль неверный</p>";
                                    }
                                } else {
                                    echo "<p>Пользователя с таким логином не существует</p>";
                                }
                            }

                            ?>
                        </div>

                    </div>
                </section>
    </main>

</body>

</html>