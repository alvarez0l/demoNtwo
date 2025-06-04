<?php
if(isset($_POST["id"])) {
    $conn = new mysqli("MySQL-8.2", "root", "", "db_rest");
    if($conn->connect_error){
        die("Ошибка: " . $conn->connect_error);
    }
    $userid = $conn->real_escape_string($_POST["id"]);
    $userstatus = $conn->real_escape_string($_POST["status"]);
    $sql = "UPDATE `orders` SET `status` = '$userstatus' WHERE `orders`.`id` = '$userid'";
    if($conn->query($sql)){
        header("Location: admin_panel.php");
        echo "Done!";
    }
    else{
        echo "Ошибка: " . $conn->error;
    }
    echo "Done!";
    $conn->close();  
}