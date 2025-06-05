<?php

require_once __DIR__.'/session.php';  //Импортируем файл Сессии

$stmt = pdo()->prepare("SELECT * FROM `users` WHERE `login` = :login");  //Создаем переменную, обращаемся к PDO, кт. готовит SQL-запрос в БД
$stmt->execute(['login' => $_POST['login']]);  //Выполняет подготовленный запрос, передавая значения для подстановки в массив
if ($stmt->rowCount() > 0) {  //Проверка количества строк
    flash('Это имя пользователя уже занято.'); //Ошибка
    header('Location: reg_form.php'); //Возврат на форму регистрации
    die;
};
if ((strlen($_POST['fName']) < 3) || (strlen($_POST['lName']) < 3)) {  //Валидация ФИО
    flash('Каждое поле ввода ФИО должны состоять как минимум из 3-х символов');
    header('Location: reg_form.php');
    die;
};
if (strlen($_POST['login']) <= 3) {  //Проверка на количесво символов в логине
    flash('Логин должен состоять более чем из 3-х символов');
    header('Location: reg_form.php');
    die;
};
if (strlen($_POST['password']) < 4) {  //Проверка на количество символов в пароле
    flash('Пароль должен состоять как минимум из 8 символов');
    header('Location: reg_form.php');
    die;
};
if ($_POST['rePass'] !== $_POST['password']) {  //Валидация повтора пароля
    flash('Пароли не совпадают. Повторите попытку');
    header('Location: reg_form.php');
    die;
};
$regexp = '~^(?:\+7|8)\d{10}$~'; 
if (!preg_match($regexp, $_POST['phone'])) {   //Валидация номера телефона
    flash('Номер телефона должен соответствовать формату +7(XXX)-XXX-XX-XX.');
    header('Location: reg_form.php');
    die;
};
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    flash('Такой почты не существует.');
    header('Location: reg_form.php');
    die;
}


$stmt = pdo()->prepare("INSERT INTO `users` (`login`, `password`, `firstName`, `lastName`, `phone`, `email`) VALUES (:login, :password, :fName, :lName, :phone, :email)"); //Создаем переменную, обращаемся к PDO, кт. готовит SQL-запрос в БД
$stmt->execute([ //Выполняет подготовленный запрос, передавая значения для подстановки в массив
    'login' => $_POST['login'],  //Имя
    'password' => $_POST['password'],
    'fName' => $_POST['fName'],  //Имя
    'lName' => $_POST['lName'],  //Фамилия
    'phone' => $_POST['phone'],  //Телефон
    'email' => $_POST['email'],  //Почта
]);

header('Location: log_form.php');  //Перевод на страницу Логина