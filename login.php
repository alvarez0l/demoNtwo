<?php

require_once __DIR__.'/session.php';  //Импортируем файл Сессии

$stmt = pdo()->prepare("SELECT * FROM `users` WHERE `login` = :login");  //Создаем переменную, обращаемся к PDO, кт. готовит SQL-запрос в БД
$stmt->execute(['login' => $_POST['login']]);  //Выполняет подготовленный запрос, передавая значения для подстановки в массив
if (!$stmt->rowCount()) {  //Если данные не соответствуют - ошибка
    header('Location: log_form.php');
    flash('Ошибка! Неверные логин или пароль. Попробуйте еще раз.');
    die;
}
$user = $stmt->fetch(PDO::FETCH_ASSOC);  //Создаем переменную, куда будем извлекать данные юзера "$stmt->fetch()", далее определяем формат результата как Ассоц. массив

if ($_POST['password'] === $user['password']) {  //Сверяем пароль из формы с паролем из БД
    //Далее просто обновляем данные в БД
    $stmt = pdo()->prepare('UPDATE `users` SET `password` = :password WHERE `login` = :login');
    $stmt->execute([
        'login' => $_POST['login'],
        'password' => $_POST['password'],
    ]);
    $_SESSION['user_id'] = $user['id'];  //Сохраняем пользователя в Сессии
    header('Location: index.php');  //Переводим на главную страницу
    die;
}
//Вывод ошибки, если что то пошло не так
flash('Ошибка! Неверные логин или пароль. Попробуйте еще раз.');
header('Location: log_form.php');