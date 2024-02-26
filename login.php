<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./login.css" type="text/css">
    <title>ExpenseNote</title>
</head>

<body>
    <div class="menu">
        <a href="./dashboard.php">
            <h2>ExpenseNote</h2>
        </a>
    </div> -->
<?php
session_start();

$pengguna_id = isset($_SESSION['pengguna_id']) ? $_SESSION['pengguna_id'] : 0;

if (!empty($pengguna_id)) {
    header('Location:dashboard.php?pesan=anda sudah login!');
}

include("headerLogin.php");
?>

<div class="Login">
    <div class="imgkiri">
        <img src="Asset/kalkulator.png" alt="">
    </div>

    <h2>Login</h2>

    <form id="diform" action="./php/main.php" name="Form Login" method="POST">
        <div class="Gmail">
            <!-- <label>Gmail</label> -->
            <input type="text" name="Gmail" id="Gmail" placeholder="Gmail">
        </div>
        <div class="password">
            <!-- <label>Password</label> -->
            <input type="password" name="password" id="password" placeholder="Password">
        </div>
        <button type="submit" id="buttonLogin" value="create" name="submitLogin">SUBMIT</button>

    </form>

    <p>Dont Have an Account? <a href="./register.php"> Sign up</a></p>
</div>

<?php
// include("footer.php");
?>
<!-- </body>

</html> -->