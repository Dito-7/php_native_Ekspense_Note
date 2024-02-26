<?php
include("headerCatatan.php");
include("./php/catatan.php");
include("auth.php");

$catatan = '';

if (isset($_GET["status"]) == 'edit') {
    $catatan_id = isset($_GET['catatan_id']) ? $_GET['catatan_id'] : ''; //ini adalah ternery
    $Catatan = new catatan();

    $data = $Catatan->tampilHistori($catatan_id);

    // var_dump($data);

    $status = @$_GET['status'];

    $catatan = $data['catatan'];

}
?>

<!-- ini isinya content -->
<div class="catatanpribadi">
    <form action="./php/main.php" method="POST">
        <div>
            <input type="hidden" name="catatan_id" value="<?php echo $catatan_id ?>">
        </div>

        <div class="kotak_input">
            <label for="">Catatan:</label>
            <textarea id="catatan" name="catatan"><?php echo $catatan ?></textarea>
        </div>
        <div>
            <input type="date" id="tanggal_catatan" name="tanggal_catatan">
        </div>

        <button type="submit" name="submitCatatan" value="<?= @$status == 'edit' ? 'Ubah' : 'Tambah Catatan' ?>">
            <?= @$status == 'edit' ? 'Ubah' : 'Tambah Catatan' ?>
        </button>
    </form>
</div>

<div class="history">
    <h3>Daftar Catatan Pribadi</h3>
    <table class="history_table">
        <thead>
            <tr>
                <th>No</th>
                <th style=" padding-right: 200px">Catatan</th>
                <th>Tanggal Catatan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="history_list">
            <?php

            if (!isset($_SESSION['pengguna_id'])) {
                return;
            }

            $Catatan = new catatan();
            $data = $Catatan->viewCatatan();

            foreach ($data as $index => $value) {
                $nomor_urut = $index + 1;
                echo "<tr>";
                echo "<td style='text-align:center;'>" . $nomor_urut . "</td>";
                echo "<td style='text-align:center;'>" . $value['catatan'] . "</td>";
                echo "<td style='text-align:center;'>" . $value['tanggal_catatan'] . "</td>";
                echo "<td><a href='./php/main.php?status=del&catatan_id=" . $value['catatan_id'] . "' onclick=\"return confirm('Yakin ingin menghapus data?')\">
                        <input type='button' value='hapus'>
                        </a>
                        <a href='CatatanPribadi.php?status=edit&catatan_id=" . $value['catatan_id'] . "' onclick=\"return confirm('Yakin ingin Mengedit data?')\">
                        <input type='button' value='Edit'>
                        </a>
                </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include("footer.php");
?>