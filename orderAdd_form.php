<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/style.css">
    <title>Я буду кушац</title>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <nav>
                <ul class="menu">
                    <li><a href="index.php">Главная</a></li>
                    <?php
                        require_once __DIR__.'/session.php';
                        $user = null;
                        require_once __DIR__.'/getUser.php';

                        if ($user == null) {
                    ?>
                        <li><a href="log_form.php">Вход</a></li>
                        <li><a href="reg_form.php">Регистрация</a></li>
                    <?php 
                        }
                        if ($user) { 
                            ?><li><a href="orders.php">Заказы</a></li><?php
                            if ($user['type'] == 'Admin') { ?>
                                <li><a id="a-admin" href="admin_panel.php">Admin's Panel</a></li>
                            <?php } ?>
                            <li><a href="orderAdd_form.php">Забронировать</a></li>
                            <form class="mt-5" method="post" action="logout.php">
                                    <button type="submit" class="btn" id="logout-btn">Выйти</button>
                            </form>
                    <?php } ?>
                </ul>
            </nav>
        </div>
        <div class="content">
            <h2>Страница формирования брони</h2>
            <p class="content_p">
                <?php
                    if ($user == null) { 
                        header('Location: log_form.php');
                    }
                ?>
                <span>Укажите необходимые данные для брони свободного стола</span>
            </p>
            <form class="mt-5" method="POST" action="orderAdd.php">
                <input class="input" type="text" placeholder="Дата Время" name="date">
                <input class="input" type="text" placeholder="Количество персон (до 10)" name="peoples">
                <input class="input" type="text" placeholder="Контактный номер телефона" name="phone">
                <?php require_once __DIR__.'/session.php'; flash() ?>
                <button type="submit" class="btn">Оформить бронь</button>
            </form>
        </div>
    </div>
</body>
<footer>
    <div class="footer">
        <span>Нужна помощь? +7 (978)-900-90-90 - Звонок бесплатный</span>
        <span>Проект веб-приложение "Я буду кушац". Все права защищены.</span>
    </div>
</footer>
</html>

