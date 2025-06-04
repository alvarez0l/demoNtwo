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
        <?php 
            if ($user == null) { 
                header('Location: log_form.php');
            }
        ?>
        <div class="content">
            <h2>Ваши заказы</h2>
            <p class="content_p">
                <span>Ниже будут видны все ваши заказы</span>
            </p>
            <table>
                <tr>
                    <th>Номер заказа</th>
                    <th>Дата/Время</th>
                    <th>Количество персон</th>
                    <th>Телефон</th>
                    <th>Статус заказа</th>
                </tr>

            <?php if ($user) {
                require_once 'connect.php';
                $user_id = $user['id'];
                @$sort = $_POST['sort'];
                $ticket = mysqli_query($connectDB, "SELECT * FROM `orders` WHERE `userID` = $user_id");
                $ticket = mysqli_fetch_all($ticket);
                foreach($ticket as $obj)
                { ?>
                    <tr>
                        <td><?= $obj[0] ?></td>
                        <td><?= $obj[2] ?></td>
                        <td><?= $obj[3] ?></td>
                        <td><?= $obj[4] ?></td>
                        <td><?= $obj[5] ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </table>
            <form class="mt-5" method="post" action="orderAdd_form.php">
                <button type="submit" class="btn" id="newOrder-btn">Оформить новый заказ</button>
            </form>
        </div>
    </div>
</body>
</html>