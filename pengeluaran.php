<?php
include("headerPengeluaran.php");
include("./php/pengeluaran.php");
include("auth.php");

$jumlah_pengeluaran = '';
$keterangan = '';
$kategori_id = '';

if (isset($_GET["status"]) == 'edit') {
    $pengeluaran_id = @$_GET['pengeluaran_id'];
    $Pengeluaran = new pengeluaran();

    $data = $Pengeluaran->tampilHistoriPengeluaran($pengeluaran_id);
    $status = @$_GET['status'];

    $jumlah_pengeluaran = $data['jumlah_pengeluaran'];
    $kategori_id = $data['kategori_id'];
    $keterangan = $data['keterangan'];

    // var_dump($data);
}
?>
<!-- ini isinya content -->
<div class="pengeluaran">
    <form action="./php/main.php" method="POST">
        <div>
            <input type="hidden" name="pengeluaran_id" value="<?php echo $pengeluaran_id ?>">
        </div>

        <div class="kotak_input">
            <label for="">Jumlah Pengeluaran:</label>
            <input type="number" id="pengeluaran_" name="jumlah_pengeluaran" value="<?php echo $jumlah_pengeluaran ?>">
        </div>
        <div class="kotak_input">
            <label for="kategori">Kategori:</label>
            <select id="kategori" name="kategori_id" required>
                <option value="0">- Pilih Kategori -</option>
                <?php
                include("./php/master_kategori.php");

                $Masterkategori = new master_kategori();

                // error_log("Before var_dump");
                $dataKategori = $Masterkategori->tampilKategori();
                // var_dump($dataKategori);
                
                foreach ($dataKategori as $loopKategori) {
                    echo "<option value=\"{$loopKategori['kategori_id']}\"";
                    if ($loopKategori['kategori_id'] == $kategori_id) {
                        echo " selected";
                    }
                    echo ">{$loopKategori['nama_kategori']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="kotak_input">
            <label for="">Keterangan:</label>
            <input type="text" id="keterangan" name="keterangan" value="<?php echo $keterangan ?>">
        </div>
        <div>
            <input type="hidden" id="tanggal_pengeluaran" name="tanggal_pengeluaran">
        </div>

        <button type="submit" name="submitPengeluaran"
            value="<?= @$status == 'edit' ? 'Ubah' : 'Tambah Pengeluaran' ?>">
            <?= @$status == 'edit' ? 'Ubah' : 'Tambah Pengeluaran' ?>
        </button>

        <!-- <button type="submit" name="editPengeluaran">Tambah Pengeluaran</button> -->
    </form>
</div>

<div class="history">

    <div class="total">
        <h2>Total Pengeluaran</h2>
        <h2>Rp.
            <?php
            $Pengeluaran = new pengeluaran();
            $total_pengeluaran = $Pengeluaran->getTotalPengeluaran();
            echo implode($total_pengeluaran); // implode adalah join elements antara array dan string
            ?>
        </h2>
    </div>
    <div class="total">
        <h2>Saldo Saat Ini</h2>
        <h2>Rp.
            <?php
            if (!isset($_SESSION['pengguna_id'])) {
                return;
            }
            $lihatSaldo = $Pengguna->viewSaldo();

            $_SESSION['saldo'] = $lihatSaldo;

            echo 'RP.' . implode($lihatSaldo);
            ?>
        </h2>
    </div>

    <h3>Daftar Pengeluaran</h3>
    <table class="history_table">
        <thead>
            <tr>
                <th>NO</th>
                <th>Jumlah Pengeluaran</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Tanggal Pengeluaran</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="history_list">
            <?php

            if (!isset($_SESSION['pengguna_id'])) {
                return;
            }

            $Pengeluaran = new pengeluaran();
            $data = $Pengeluaran->viewPengeluaran();

            foreach ($data as $index => $value) {
                $nomor_urut = $index + 1;
                echo "<tr>";
                echo "<td style='text-align:center;'>" . $nomor_urut . "</td>";
                echo "<td style='text-align:center;'>" . $value['jumlah_pengeluaran'] . "</td>";
                echo "<td style='text-align:center;'>" . $value['kategori'] . "</td>";
                echo "<td style='text-align:center;'>" . $value['keterangan'] . "</td>";
                echo "<td style='text-align:center;'>" . $value['tanggal_pengeluaran'] . "</td>";
                echo "<td><a href='./php/main.php?status=del&pengeluaran_id=" . $value['pengeluaran_id'] . "' onclick=\"return confirm('Yakin ingin menghapus data?')\">
                        <input type='button' value='hapus'>
                        </a>
                        <a href='pengeluaran.php?status=edit&pengeluaran_id=" . $value['pengeluaran_id'] . "' onclick=\"return confirm('Yakin ingin Mengedit data?')\">
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