<?php
// session_start();
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
            <li><a href="./dashboard.php">Home</a></li>
            <li><a href="./pengeluaran.php">ExpenseNote</a></li>
            <li><a href="./CatatanPribadi.php">Personal Note</a></li>
        </ul>
        <?php
        if (isset($_SESSION['pengguna_id'])) {
            include("headerProfileIcon.php");
        } else {
            include("headerSigninSignout.php");
        }
        ?>
    </div>