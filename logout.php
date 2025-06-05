<?php

require_once __DIR__.'/session.php';

$_SESSION['user_id'] = null;
header('Location: index.php');