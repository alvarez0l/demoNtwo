<?php

require_once __DIR__.'/session.php';

$stmt = pdo()->prepare("SELECT * FROM `users` WHERE `login` = :login");
$stmt->execute(['login' => $_POST['login']]);
if (!$stmt->rowCount()) {
    header('Location: log_form.php');
    flash('Ошибка! Неверные логин или пароль. Попробуйте еще раз.');
    die;
}
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($_POST['password'] === $user['password']) { 
    $stmt = pdo()->prepare('UPDATE `users` SET `password` = :password WHERE `login` = :login');
    $stmt->execute([
        'login' => $_POST['login'],
        'password' => $_POST['password'],
    ]);
    $_SESSION['user_id'] = $user['id'];
    header('Location: index.php'); 
    die;
}
flash('Ошибка! Неверные логин или пароль. Попробуйте еще раз.');
header('Location: log_form.php');