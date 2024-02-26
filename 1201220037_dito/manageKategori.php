<?php
include("headerManageKategori.php");
include("auth.php");
include("./php/master_kategori.php");

$nama_kategori = '';

if (isset($_GET["status"]) == 'edit') {
    $kategori_id = @$_GET['kategori_id'];
    $Masterkategori = new master_kategori();

    $data = $Masterkategori->tampilHistoriKategori($kategori_id);
    $status = @$_GET['status'];

    $nama_kategori = $data['nama_kategori'];

    // var_dump($data);
}
?>

<div class="catatanpribadi">
    <form action="./php/main.php" method="POST">
        <div>
            <input type="hidden" name="kategori_id" value="<?php echo $kategori_id ?>">
        </div>

        <div class="kotak_input">
            <label for="nama_kategori">Tambah Kategori:</label>
            <input id="nama_kategori" name="nama_kategori" value="<?php echo $nama_kategori ?>">
        </div>

        <button type="submit" name="submitKategori" value="<?= @$status == 'edit' ? 'Ubah' : 'Tambah Kategori' ?>">
            <?= @$status == 'edit' ? 'Ubah' : 'Tambah Kategori' ?>
        </button>
    </form>
</div>

<div class="history">
    <h3>Daftar Kategori</h3>
    <table class="history_table">
        <thead>
            <tr>
                <th>No</th>
                <th style=" padding-right: 200px">Nama Kategori</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="history_list">
            <?php

            if (!isset($_SESSION['pengguna_id'])) {
                return;
            }

            $Masterkategori = new master_kategori();
            $data = $Masterkategori->tampilKategori();

            foreach ($data as $index => $value) {
                $nomor_urut = $index + 1;
                echo "<tr>";
                echo "<td style='text-align:center;'>" . $nomor_urut . "</td>";
                echo "<td style='text-align:center;'>" . $value['nama_kategori'] . "</td>";
                echo "<td><a href='./php/main.php?status=del&kategori_id=" . $value['kategori_id'] . "' onclick=\"return confirm('Yakin ingin menghapus data?')\">
                        <input type='button' value='hapus'>
                        </a>
                        <a href='manageKategori.php?status=edit&kategori_id=" . $value['kategori_id'] . "' onclick=\"return confirm('Yakin ingin Mengedit data?')\">
                        <input type='button' value='Edit'>
                        </a>
                </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>