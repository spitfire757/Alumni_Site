<?php
session_start();

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);

if(isset($_POST['submit'])) {
    $forumID = substr(hash('sha256', $_POST['title']), 0, 16);
    $userID = $_POST['userID'];
    $title = $_POST['title'];
    $
