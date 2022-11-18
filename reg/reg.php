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
    <title>Регистрация</title>
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
                            <h2 class="reg__header">Регистрация</h2>
                            <p class="reg__account">
                                Есть аккаунт? <a href="auth.php" class="reg__link">Войдите</a>
                            </p>
                            <form action="" class="reg__form form" method="POST">
                                <label for="login">Логин</label>
                                <input class="reg__input" type="text" name="login" id="login" required>
                                <label for="login">Пароль</label>
                                <input class="reg__input" type="password" name="password" id="password" required>
                                <input type="submit" name="submitreg" class="reg__submit btn">
                            </form>

                            <?php

                            if (isset($_POST['submitreg'])) {
                                $login = $_POST['login'];
                                $password = $_POST['password'];
                                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                                $userInsertion = "INSERT INTO `user` (`login`, `password`) VALUES ('$login', '$password')";
                                if ($connect->query($userInsertion)) {
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