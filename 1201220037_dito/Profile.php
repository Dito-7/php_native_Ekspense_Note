<?php
session_start();
include("./php/config.php");
include("./php/pengguna_ekspense.php");
include("auth.php");

if (@$_SESSION['role'] == 'USER') {
    include("headerProfile.php");
} else if (@$_SESSION['role'] == 'ADMIN') {
    include("headerProfileAdmin.php");
}

// session_start();

// if (!isset($_SESSION['pengguna_id'])) {
//     header('Location: ./login.php?pesan=anda belom login!');
//     exit();
// }

$Pengguna = new pengguna_ekspense();

$pengguna_id = $_SESSION['pengguna_id'];

$data = $Pengguna->tampilUser($pengguna_id);
$status = @$_GET['status'];

$name = $data['name'];
$username = $data['username'];
$Gmail = $data['Gmail'];
$phone = $data['phone'];

if (isset($_POST["submitProfile"])) {
    $status = 'edit';

    $buttonValue = $_POST['submitProfile'];

    if ($buttonValue == 'Save') {
        $data['name'] = $_POST['name'];
        $data['username'] = $_POST['username'];
        $data['Gmail'] = $_POST['Gmail'];
        $data['phone'] = $_POST['phone'];
        $data['pengguna_id'] = $_POST['pengguna_id'];

        if ($Pengguna->editUser($data)) {
            header('Location: ./profile.php?pesan=ubah berhasil');
            exit();
        } else {
            echo 'Error updating user data';
        }
    }
}

?>
<div class="profilePage">
    <div class="profilePersonal">
        <a href="logout.php">
            <img id="logout" src="./Asset/logout.png" alt="">
        </a>

        <form class="formProfile" method="POST">

            <h2>Personal Data</h2>
            <div>
                <input type="hidden" name="pengguna_id" value="<?php echo $pengguna_id; ?>">
            </div>
            <ul>
                <img id="PersonalImg" src="https://source.unsplash.com/random/94x100/?film" alt="">
            </ul>
            <ul>

                <li>
                    <label for="name">Nama</label>
                    <input type="text" name="name" <?= $status == 'edit' ? '' : 'readonly' ?> value="<?php echo $name ?>">
                    <hr>
                </li>
                <li>
                    <label for="username">Username</label>
                    <input type="text" name="username" <?= $status == 'edit' ? '' : 'readonly' ?>
                        value="<?php echo $username ?>">
                    <hr>
                </li>
            </ul>
            <ul>
                <li>
                    <label for="Gmail">Gmail</label>
                    <input type="text" name="Gmail" <?= $status == 'edit' ? '' : 'readonly' ?>
                        value="<?php echo $Gmail ?>">
                    <hr>
                </li>
                <li>
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" <?= $status == 'edit' ? '' : 'readonly' ?>
                        value="<?php echo $phone ?>">
                    <hr>
                </li>
            </ul>
            <div class="buttonPlace">
                <button type="submit" name="submitProfile" value="<?= $status == 'edit' ? 'Save' : 'Edit' ?>">
                    <?= $status == 'edit' ? 'Save' : 'Edit' ?>
                </button>
            </div>
        </form>
    </div>
</div>