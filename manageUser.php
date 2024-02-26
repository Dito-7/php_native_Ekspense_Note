<?php
include("headerManageUser.php");
include("auth.php");
include("./php/pengguna_ekspense.php");

$username = '';
$phone = '';
$status = '';
$role = '';
$displayForm = false;

if (isset($_GET["status"]) == 'edit') {
    $pengguna_id = @$_GET['pengguna_id'];
    $Pengguna = new pengguna_ekspense();

    $data = $Pengguna->tampilHistoriPengguna($pengguna_id);
    $status = @$_GET['status'];

    $username = $data['username'];
    $phone = $data['phone'];
    $status = $data['status'];
    $role = $data['role'];

    // var_dump($data);
    $displayForm = true;
}
?>

<div class="pengeluaran">
    <?php
    // Display the form only if the flag is true
    if ($displayForm) {
        ?>
        <form action="./php/main.php" method="POST">
            <div>
                <input type="hidden" name="pengguna_id" value="<?php echo $pengguna_id ?>">
            </div>
            <div class="kotak_input">
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?php echo $username; ?>" readonly>
            </div>
            <div class="kotak_input">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" value="<?php echo $phone; ?>" readonly>
            </div>
            <div class="kotak_input">
                <label for="role">Role:</label>
                <input type="text" name="role" value="<?php echo $role; ?>" readonly>
            </div>
            <div class="kotak_input">
                <label for="status">Status:</label>
                <select name="status" required>
                    <option value="aktif" <?php echo ($status == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                    <option value="tidak aktif" <?php echo ($status == 'tidak aktif') ? 'selected' : ''; ?>>Tidak Aktif
                    </option>
                </select>
            </div>
            <button type="submit" name="submitUser" value="<?= @$status == 'edit' ? 'Ubah' : 'Ubah' ?>">
                <?= @$status == 'edit' ? 'Ubah' : 'Ubah' ?>
            </button>
        </form>
        <?php
    }
    ?>
</div>

<div class="history">
    <h3>Daftar User</h3>
    <table class="history_table">
        <thead>
            <tr>
                <th>NO</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="history_list">
            <?php

            if (!isset($_SESSION['pengguna_id'])) {
                return;
            }

            $Pengguna = new pengguna_ekspense();
            $data = $Pengguna->viewPengguna();

            foreach ($data as $index => $value) {
                $nomor_urut = $index + 1;
                echo "<tr>";
                echo "<td style='text-align:center;'>" . $nomor_urut . "</td>";
                echo "<td style='text-align:center;'>" . $value['username'] . "</td>";
                echo "<td style='text-align:center;'>" . $value['phone'] . "</td>";
                echo "<td style='text-align:center;'>" . $value['status'] . "</td>";
                echo "<td style='text-align:center;'>" . $value['role'] . "</td>";
                echo "<td><a href='./php/main.php?status=del&pengguna_id=" . $value['pengguna_id'] . "' onclick=\"return confirm('Yakin ingin menghapus data?')\">
                        <input type='button' value='Hapus'>
                        </a>
                        <a href='manageUser.php?status=edit&pengguna_id=" . $value['pengguna_id'] . "' onclick=\"return confirm('Yakin ingin Mengedit data?')\">
                        <input type='button' value='Edit'>
                        </a>";

                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>