<?php
session_start();
if (($_SESSION['role']) === 'USER') {
    include("headerTopup.php");
}
?>

<div class="catatanpribadi">
    <form action="./php/main.php" method="POST">

        <div class="kotak_input">
            <label for="">saldo:</label>
            <input type="number" id="saldo" name="saldo" required>
            <?php ?></input>
        </div>

        <button type="submit" name="submitSaldo" value="saldo">Top up Saldo</button>
    </form>
</div>