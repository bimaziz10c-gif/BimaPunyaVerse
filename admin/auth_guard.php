<?php
session_start();
if (
    !isset($_SESSION['login'], $_SESSION['username'])
    || $_SESSION['login'] !== true
    || !is_string($_SESSION['username'])
) {
    header("Location: login.php");
    exit();
}