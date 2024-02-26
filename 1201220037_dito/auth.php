<?php
// session_start();

$currentpage = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);

$permitedpage = [
    'index.php',
    'dashboard.php',
    'registrasi.php',
    'login.php'
];

if (@$_SESSION['role'] != null) {

    switch (@$_SESSION['role']) {
        case 'USER':
            $permitedpage = array_merge($permitedpage, [
                'topupSaldo.php',
                'profile.php',
                'pengeluaran.php',
                'CatatanPribadi.php',
            ]);
            break;
        case 'ADMIN':
            $permitedpage = array_merge($permitedpage, [
                'manageKategori.php',
                'manageUser.php',
                'profile.php'
            ]);
            break;
        default:
            break;
    }
    // var_dump($permitedpage);
    // echo "<hr>";
    // var_dump(array_search($currentpage,$permitedpage));die;
    if (array_search($currentpage, $permitedpage) === false) {
        if (@$_SESSION['role'] == 'USER') {
            header('Location:dashboard.php?pesan=anda tidak diijinkan masuk halaman tersebut!');
        }
        if (@$_SESSION['role'] == 'ADMIN') {
            header('Location:dashboardAdmin.php?pesan=anda tidak diijinkan masuk halaman tersebut!');
        }
    } else if (!isset($_SESSION['pengguna_id'])) {
        header('Location:login.php?pesan=anda belum login!');
    }
}
?>