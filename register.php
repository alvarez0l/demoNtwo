<?php

require_once __DIR__.'/session.php'; 

$stmt = pdo()->prepare("SELECT * FROM `users` WHERE `login` = :login");
$stmt->execute(['login' => $_POST['login']]);
if ($stmt->rowCount() > 0) { 
    flash('Это имя пользователя уже занято.'); 
    header('Location: reg_form.php');
    die;
};
if ((strlen($_POST['fName']) < 3) || (strlen($_POST['lName']) < 3)) {
    flash('Каждое поле ввода ФИО должны состоять как минимум из 3-х символов');
    header('Location: reg_form.php');
    die;
};
if (strlen($_POST['login']) <= 3) {
    flash('Логин должен состоять более чем из 3-х символов');
    header('Location: reg_form.php');
    die;
};
if (strlen($_POST['password']) < 4) {
    flash('Пароль должен состоять как минимум из 8 символов');
    header('Location: reg_form.php');
    die;
};
if ($_POST['rePass'] !== $_POST['password']) {
    flash('Пароли не совпадают. Повторите попытку');
    header('Location: reg_form.php');
    die;
};
$regexp = '~^(?:\+7|8)\d{10}$~'; 
if (!preg_match($regexp, $_POST['phone'])) { 
    flash('Номер телефона должен соответствовать формату +7(XXX)-XXX-XX-XX.');
    header('Location: reg_form.php');
    die;
};
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    flash('Такой почты не существует.');
    header('Location: reg_form.php');
    die;
}


$stmt = pdo()->prepare("INSERT INTO `users` (`login`, `password`, `firstName`, `lastName`, `phone`, `email`) VALUES (:login, :password, :fName, :lName, :phone, :email)");
$stmt->execute([
    'login' => $_POST['login'],
    'password' => $_POST['password'],
    'fName' => $_POST['fName'], 
    'lName' => $_POST['lName'], 
    'phone' => $_POST['phone'],  
    'email' => $_POST['email'], 
]);

header('Location: log_form.php'); 