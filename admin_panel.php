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
            if ($user) { 
                if ($user['type'] != 'Admin') {
                    header('Location: index.php');
                }
            } else {
                header('Location: index.php');
            }
        ?>
        <div class="content">
            <h2>Панель Администратора</h2>
            <span>Администрирование заказов возможно только с пометкой "Новое"</span>
                <table>
                    <tr>
                        <th>ID заказа</th>
                        <th>ID пользователя</th>
                        <th>Дата/Время</th>
                        <th>Количество персон</th>
                        <th>Телефон</th>
                        <th>Статус заказа</th>
                    </tr>

            <?php if ($user) { ?>
                <?php if ($user['type'] == 'Admin') 
                    {
                        require_once 'connect.php';
                        $user_id = $user['id'];
                        $ticket = mysqli_query($connectDB, "SELECT * FROM `orders`");
                        $ticket = mysqli_fetch_all($ticket);
                        foreach($ticket as $obj)
                        {
                    ?>
                        <tr>
                        <td><?= $obj[0] ?></td>
                        <td><?= $obj[1] ?></td>
                        <td><?= $obj[2] ?></td>
                        <td><?= $obj[3] ?></td>
                        <td><?= $obj[4] ?></td>
                        <td><?= $obj[5] ?></td>
                        <?php if ($obj[5] == "Новое") { ?>
                            <td id="redac">
                                <form action='orderEdit_form.php' method='POST'>
                                    <input type='hidden' name='id' value='<?= $obj[0] ?>' />
                                    <input type='hidden' name='order_status' value='<?= $obj[5] ?>' />
                                    <input id="edit-btn" type='submit' value='Изменить'>
                                </form>
                            </td>
                            <td id="del-btn">
                                <form action='orderDelete.php' method='POST'>
                                    <input type='hidden' name='id' value='<?= $obj[0] ?>' />
                                    <input id="delete-btn" type='submit' value='Удалить'>
                                </form>
                            </td>
                        <?php } ?>
                        </tr>
                        <?php } ?>
                <?php } ?>
            <?php } ?>
                </table>
        </div>
    </div>
</body>
</html>