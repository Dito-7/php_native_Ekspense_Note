<?php
session_start();
include("./php/config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./style.css" type="text/css">
    <title>ExpenseNote</title>
</head>

<body>
    <div class="menu">
        <div class="logo">
            <img src="./Asset/logoKoin.png" alt="logo">
            <h2>ExpenseNote</h2>
        </div>

        <ul>
            <li><a href="./dashboardAdmin.php" id="dash">Home</a></li>
            <li><a href="./manageUser.php">Manage User</a></li>
            <li><a href="./manageKategori.php ">Manage Kategori</a></li>
        </ul>
        <?php
        // if (isset($_SESSION['pengguna_id'])) {
        //     include("headerProfileIcon.php");
        // } else {
        //     include("headerSigninSignout.php");
        // }
        include("headerProfileIcon.php");
        ?>
        <!-- <div class=" profile">
            <a href="./login.php"><img src="./Asset/Personal_icon.png" alt=""></a>
        </div> -->
    </div>