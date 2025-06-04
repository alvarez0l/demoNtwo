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
            if (($_POST['date'] == null) || ($_POST['peoples'] == null) || $_POST['phone'] == null) {  //Валидация данных на странице формирования заказа
                header('Location: orderAdd_form.php');
                die;
            };

            require_once __DIR__.'/session.php';
            $user = null;
            if (check_auth()) {
                // Получим данные пользователя по сохранённому идентификатору
                $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
                $stmt->execute(['id' => $_SESSION['user_id']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            require_once 'connect.php';

            $date = $_POST['date'];
            $peoples = $_POST['peoples'];
            $phone = $_POST['phone'];
            $user_id = $user['id'];

            mysqli_query($connectDB, "INSERT INTO `orders` (`id`, `date`, `peoples`, `phone`, `userid`)
            VALUES (NULL, '$date', '$peoples', '$phone', '$user_id')");
            echo "Готово! Ваш заказ находится на странице Заказы, администраторы в скором времени проверят и одобрят его.";
            // sleep(2);
        ?>
    </div>
</body>
</html>