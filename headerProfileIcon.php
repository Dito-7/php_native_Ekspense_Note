<div class="saldo">
    <p>
        <?php

        if (@$_SESSION['role'] == 'USER') {
            include("./php/pengguna_ekspense.php");
            $Pengguna = new pengguna_ekspense();
            echo ' <a href="./topupSaldo.php">Top Up Saldo</a>';
        }
        ?>
    </p>
</div>

<div class=" profile">
    <a href="./profile.php"><img src="./Asset/Personal_icon.png" alt=""></a>
</div>