<?php
require_once('../db/connection.php');
if(isset($_POST['username'])){
    $pdoDB = new DB();

    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $pdoDB->stmt = $pdoDB->pdo->query("SELECT * FROM user WHERE user.username = '$username' and user.password = '$password'");
    $pdoDB->stmt->setFetchMode(PDO::FETCH_ASSOC);
    $data =$pdoDB->stmt->fetchAll();
    if(count($data) == 1){
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['status_login'] = 'login';
        header("location:configuration.php");
    }else{
        header("location:login.php");
    }
}