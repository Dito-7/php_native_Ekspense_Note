<?php
include("./php/config.php");
include("headerRegister.php");

session_start();

?>

<div class="Register">
    <div class="imgkiri">
        <img src="Asset/papandada.png" alt="">
    </div>

    <h2>Register</h2>
    <form method="POST" action="./php/main.php">

        <div class="name">
            <input type="text" name="name" id="name" placeholder="Name">
        </div>
        <div class="username">
            <!-- <label>Username</label> -->
            <input type="text" name="username" id="username" placeholder="Username">
        </div>
        <div class="Gmail">
            <!-- <label>Gmail</label> -->
            <input type="email" name="Gmail" id="Gmail" placeholder="Gmail">
        </div>
        <div class="phone">
            <!-- <label>Phone Number</label> -->
            <input type="text" name="phone" id="phone" placeholder="Phone Number">
        </div>
        <div class="password">
            <!-- <label>Password</label> -->
            <input type="password" name="password" id="password" placeholder="password">
        </div>
        <div class="compass">
            <!-- <label>Confirm Password</label> -->
            <input type="password" name="confirm" id="confirm" placeholder="Confirm password">
        </div>

        <button type="submit" id="buttonRegis" value="create" name="submitRegister">SUBMIT</button>

    </form>

    <p>Already Have Account? <a href="./login.php"> Sign In</a></p>
</div>