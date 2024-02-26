<?php
// include("config.php");

class pengeluaran
{
    private $pengeluaran_id;
    private $pengguna_id;
    private $jumlah_pengeluaran;
    private $kategori_id;
    private $keterangan;
    private $tanggal_pengeluaran;
    private $basisdata;

    public function __construct($jumlah_pengeluaran = null, $kategori_id = null, $keterangan = null, $tanggal_pengeluaran = null)
    {
        if ($jumlah_pengeluaran != null && $kategori_id != null && $keterangan != null && $tanggal_pengeluaran != null) {
            $this->jumlah_pengeluaran = $jumlah_pengeluaran;
            $this->kategori_id = $kategori_id;
            $this->keterangan = $keterangan;
            $this->tanggal_pengeluaran = $tanggal_pengeluaran;
        }

        $this->basisdata = new config();
    }

    public function tambahPengeluaran($pengguna_id, $jumlah_pengeluaran, $kategori_id, $keterangan, $tanggal_pengeluaran)
    {
        $sql = "INSERT INTO pengeluaran (pengguna_id, jumlah_pengeluaran, kategori_id, keterangan, tanggal_pengeluaran) 
                VALUES (?, ?, ?, ?, ?)";

        $statement = $this->basisdata->database->prepare($sql);

        return $statement->execute([$pengguna_id, $jumlah_pengeluaran, $kategori_id, $keterangan, $tanggal_pengeluaran]);
    }

    public function viewPengeluaran()
    {
        $pengguna_id = isset($_SESSION['pengguna_id']) ? $_SESSION['pengguna_id'] : 0;

        $sql = "SELECT p.pengeluaran_id, p.jumlah_pengeluaran, m.nama_kategori AS kategori, p.keterangan, p.tanggal_pengeluaran 
                FROM pengeluaran p
                INNER JOIN master_kategori m ON p.kategori_id = m.kategori_id
                WHERE p.pengguna_id = :pengguna_id
                ORDER BY p.pengeluaran_id ASC";

        $statement = $this->basisdata->database->prepare($sql);
        $statement->bindParam(":pengguna_id", $pengguna_id, PDO::PARAM_INT);
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }


    public function deletePengeluaran($pengeluaran_id)
    {
        // var_dump($pengeluaran_id);

        $sql = 'DELETE FROM pengeluaran WHERE pengeluaran_id = :pengeluaran_id';

        // prepare the statement for execution
        $statement = $this->basisdata->database->prepare($sql);

        // bind the parameter using bindValue instead of bindParam
        $statement->bindParam(':pengeluaran_id', $pengeluaran_id, PDO::PARAM_INT);

        if ($statement->execute()) {
            $pesan['status'] = 'Hapus berhasil';
            return $pesan;
        } else {
            $pesan['status'] = 'Hapus gagal';
            var_dump($statement->errorInfo());
            return $pesan;
        }

    }

    public function editPengeluaran($data)
    {
        $sql = 'UPDATE pengeluaran SET jumlah_pengeluaran = :jumlah_pengeluaran, kategori_id = :kategori_id, keterangan = :keterangan WHERE pengeluaran_id = :pengeluaran_id';

        $statement = $this->basisdata->database->prepare($sql);

        $statement->bindParam(':jumlah_pengeluaran', $data['jumlah_pengeluaran'], PDO::PARAM_INT);
        $statement->bindParam(':kategori_id', $data['kategori_id'], PDO::PARAM_STR);
        $statement->bindParam(':keterangan', $data['keterangan'], PDO::PARAM_STR);
        $statement->bindParam(':pengeluaran_id', $data['pengeluaran_id'], PDO::PARAM_INT);

        // var_dump($statement->execute());
        return $statement->execute();
    }

    public function tampilHistoriPengeluaran($pengeluaran_id)
    {
        $sql = "SELECT pengeluaran_id, jumlah_pengeluaran, kategori_id, keterangan FROM pengeluaran WHERE pengeluaran_id = :pengeluaran_id";

        $statement = $this->basisdata->database->prepare($sql);
        $statement->bindParam(':pengeluaran_id', $pengeluaran_id, PDO::PARAM_INT);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getTotalPengeluaran()
    {
        $pengguna_id = isset($_SESSION['pengguna_id']) ? $_SESSION['pengguna_id'] : 0;

        $sql = "SELECT SUM(jumlah_pengeluaran) AS total_pengeluaran FROM pengeluaran WHERE pengguna_id = :pengguna_id";

        $statement = $this->basisdata->database->prepare($sql);
        $statement->bindParam(":pengguna_id", $pengguna_id, PDO::PARAM_INT);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);

        return $data;
    }


    public function getPengeluaran_id()
    {
        return $this->pengeluaran_id;
    }

    public function setPengeluaran_id($pengeluaran_id)
    {
        $this->pengeluaran_id = $pengeluaran_id;
    }
    public function getPengeluaran()
    {
        return $this->jumlah_pengeluaran;
    }

    public function setPengeluaran($jumlah_pengeluaran)
    {
        $this->jumlah_pengeluaran = $jumlah_pengeluaran;
    }

    public function getkategori_id()
    {
        return $this->kategori_id;
    }

    public function setKategori_id($kategori_id)
    {
        $this->kategori_id = $kategori_id;
    }

    public function getKeterangan()
    {
        return $this->keterangan;
    }

    public function setKeterangan($keterangan)
    {
        $this->keterangan = $keterangan;
    }
}