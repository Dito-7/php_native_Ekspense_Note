<?php

if (isset($_POST["submitRegister"])) {
    include("config.php");
    include("pengguna_ekspense.php");

    $pengguna = new pengguna_ekspense($_POST["name"], $_POST["username"], $_POST["Gmail"], $_POST["phone"], $_POST["password"], $_POST["confirm"]);
    $pengguna->Register($_POST["name"], $_POST["username"], $_POST["Gmail"], $_POST["phone"], $_POST["password"], $_POST["confirm"]);
} else if (isset($_POST["submitLogin"])) {
    include("config.php");
    include("pengguna_ekspense.php");

    $Gmail = $_POST['Gmail'];
    $Password = $_POST['password'];

    $pengguna = new pengguna_ekspense();
    $data = $pengguna->login($Gmail, $Password);

} else if (isset($_POST["submitPengeluaran"]) && $_POST["submitPengeluaran"] == 'Tambah Pengeluaran') {
    include("config.php");
    include("pengeluaran.php");
    include("pengguna_ekspense.php");

    $tanggal_pengeluaran = date("Y-m-d");

    session_start();
    $pengguna_id = isset($_SESSION['pengguna_id']) ? $_SESSION['pengguna_id'] : 0;

    if (empty($pengguna_id)) {
        header('Location: ../pengeluaran.php?pesan=Login Terlebih Dahulu');
        return;
    } else if ($_POST["jumlah_pengeluaran"] == null || $_POST["kategori_id"] == 0 || $_POST["keterangan"] == null) {
        header('Location: ../pengeluaran.php?pesan=lengkapi form tersebut');
        return;
    }

    $Pengeluaran = new pengeluaran($_POST["jumlah_pengeluaran"], $_POST["kategori_id"], $_POST["keterangan"], $_POST["tanggal_pengeluaran"]);
    $Pengguna = new pengguna_ekspense();

    $jumlah_pengeluaran = $_POST['jumlah_pengeluaran'];
    $lihatSaldo = $Pengguna->viewSaldo();

    if ($jumlah_pengeluaran > $lihatSaldo['saldo']) {
        header('Location: ../pengeluaran.php?pesan=saldo anda kurang!');
        return;
    } else {
        $Pengeluaran->tambahPengeluaran($pengguna_id, $_POST["jumlah_pengeluaran"], $_POST["kategori_id"], $_POST["keterangan"], $tanggal_pengeluaran);
        $Pengguna->kurangSaldo($pengguna_id, $jumlah_pengeluaran);
        header('Location: ../pengeluaran.php?pesan=tambah berhasil');
        // var_dump($jumlah_pengeluaran, $lihatSaldo);
    }
    // var_dump($Pengeluaran);
} else if (isset($_POST["submitPengeluaran"]) && $_POST["submitPengeluaran"] == 'Ubah') {
    include("config.php");
    include("pengeluaran.php");

    $data['jumlah_pengeluaran'] = $_POST['jumlah_pengeluaran'];
    $data['kategori_id'] = $_POST['kategori_id'];
    $data['keterangan'] = $_POST['keterangan'];
    $data['pengeluaran_id'] = $_POST['pengeluaran_id'];

    $Pengeluaran = new pengeluaran();

    // $Pengeluaran->editPengeluaran($data);
    // var_dump($Pengeluaran);

    // $result = $Pengeluaran->editPengeluaran($data);
    // var_dump($result);
    if ($_POST['kategori_id'] == 0) {
        header('Location: ../pengeluaran.php?pesan=pilih kategori anda');
    } else if ($Pengeluaran->editPengeluaran($data)) {
        header('Location: ../pengeluaran.php?pesan=ubah berhasil');
    } else {
        echo 'Error';
    }
} else if (isset($_POST["submitCatatan"]) && $_POST["submitCatatan"] == 'Ubah') {
    include("config.php");
    include("catatan.php");

    $data['catatan'] = $_POST['catatan'];
    $data['catatan_id'] = $_POST['catatan_id'];

    $Catatan = new catatan();

    // $Catatan->editCatatan($data);
    // var_dump($Catatan);

    // $result = $Catatan->editCatatan($data);
    // var_dump($result);

    if ($Catatan->editCatatan($data)) {
        header('Location: ../CatatanPribadi.php?pesan=ubah berhasil');
        // var_dump($Catatan);
    } else {
        echo 'Error';
    }
} else if (isset($_POST["submitCatatan"])) {
    include("config.php");
    include("catatan.php");

    $tanggal_catatan = date("Y-m-d");

    session_start();
    $pengguna_id = isset($_SESSION['pengguna_id']) ? $_SESSION['pengguna_id'] : 0;

    if (empty($pengguna_id)) {
        header('Location: ../CatatanPribadi.php?pesan=Login Terlebih Dahulu');
        return;
    } else if ($_POST["catatan"] == null) {
        header('Location: ../CatatanPribadi.php?pesan=lengkapi form tersebut');
        return;
    }

    $Catatan = new catatan($_POST["catatan"], $_POST["tanggal_catatan"]);
    $Catatan->tambahCatatan($pengguna_id, $_POST["catatan"], $tanggal_catatan);

    header('Location: ../CatatanPribadi.php?pesan=tambah catatan berhasil');
} else if (isset($_GET["status"]) && $_GET["status"] == "del" && isset($_GET["pengeluaran_id"])) {
    include("config.php");
    include("pengeluaran.php");

    $pengeluaran_id = $_GET["pengeluaran_id"];
    $Pengeluaran = new pengeluaran();
    $Pengeluaran->deletePengeluaran($pengeluaran_id);

    header('Location: ../pengeluaran.php?pesan=delete berhasil');

    // var_dump($Pengeluaran);
} else if (isset($_GET["status"]) && $_GET["status"] == "del" && isset($_GET["catatan_id"])) {
    include("config.php");
    include("catatan.php");

    $catatan_id = $_GET["catatan_id"];
    $Catatan = new catatan();
    $Catatan->deleteCatatan($catatan_id);

    header('Location: ../CatatanPribadi.php?pesan=delete berhasil');

    // var_dump($Catatan);
} else if (isset($_POST["submitSaldo"])) {
    include("config.php");
    include("pengguna_ekspense.php");

    session_start(); // Make sure to start the session

    $pengguna_id = isset($_SESSION['pengguna_id']) ? $_SESSION['pengguna_id'] : 0;
    $saldo = $_POST['saldo'];

    $pengguna = new pengguna_ekspense();
    $pengguna->tambahSaldo($pengguna_id, $saldo);

    header('Location: ../dashboard.php?pesan=saldo berhasil ditambah');
} else if (isset($_POST["submitUser"]) && $_POST["submitUser"] == 'Ubah') {
    include("config.php");
    include("pengguna_ekspense.php");

    $data['pengguna_id'] = $_POST['pengguna_id'];
    $data['status'] = $_POST['status'];

    $pengguna = new pengguna_ekspense();
    if ($pengguna->editStatusPengguna($data)) {
        header('Location: ../manageUser.php?pesan=ubah berhasil');
    } else {
        echo 'Error';
    }
} else if (isset($_POST["submitKategori"]) && $_POST["submitKategori"] == 'Ubah') {
    include("config.php");
    include("master_kategori.php");

    $data['kategori_id'] = $_POST['kategori_id'];
    $data['nama_kategori'] = $_POST['nama_kategori'];

    $Masterkategori = new master_kategori();
    if ($Masterkategori->editStatusKategori($data)) {
        header('Location: ../manageKategori.php?pesan=ubah berhasil');
    } else {
        echo 'Error';
    }
} else if (isset($_POST["submitKategori"])) {
    include("config.php");
    include("master_kategori.php");

    $nama_kategori = $_POST['nama_kategori'];

    $Masterkategori = new master_kategori();
    $Masterkategori->tambahKategori($nama_kategori);

    header('Location: ../manageKategori.php?pesan=kategori berhasil ditambah');
} else if (isset($_GET["status"]) && $_GET["status"] == "del" && isset($_GET["kategori_id"])) {
    include("config.php");
    include("master_kategori.php");

    $kategori_id = $_GET["kategori_id"];
    $Masterkategori = new master_kategori();
    $Masterkategori->deleteKategori($kategori_id);

    header('Location: ../manageKategori.php?pesan=delete berhasil');

    // var_dump($Masterkategori);
} else if (isset($_GET["status"]) && $_GET["status"] == "del" && isset($_GET["pengguna_id"])) {
    include("config.php");
    include("pengguna_ekspense.php");

    $pengguna_id = $_GET["pengguna_id"];
    $Pengguna = new pengguna_ekspense();
    $Pengguna->deletePengguna($pengguna_id);

    header('Location: ../manageUser.php?pesan=delete berhasil');

    // var_dump($Pengguna);
}
?>