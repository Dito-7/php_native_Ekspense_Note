<?php
// include("config.php");

class master_kategori
{
    private $kategori_id;
    private $nama_kategori;
    private $basisdata;

    public function __construct($kategori_id = null, $nama_kategori = null)
    {
        if ($kategori_id != null && $nama_kategori != null) {
            $this->kategori_id = $kategori_id;
            $this->nama_kategori = $nama_kategori;
        }

        $this->basisdata = new config();
    }

    public function tampilKategori()
    {
        $sql = "SELECT kategori_id, nama_kategori FROM master_kategori";
        $statement = $this->basisdata->database->prepare($sql);
        $statement->execute();
        $dataKategori = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $dataKategori;
    }

    public function tampilHistoriKategori($kategori_id)
    {
        $sql = "SELECT kategori_id, nama_kategori FROM master_kategori WHERE kategori_id = :kategori_id";

        $statement = $this->basisdata->database->prepare($sql);
        $statement->bindParam(':kategori_id', $kategori_id, PDO::PARAM_INT);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function editStatusKategori($data)
    {
        $sql = 'UPDATE master_kategori SET nama_kategori = :nama_kategori WHERE kategori_id = :kategori_id';

        $statement = $this->basisdata->database->prepare($sql);
        $statement->bindParam(':kategori_id', $data['kategori_id'], PDO::PARAM_INT);
        $statement->bindParam(':nama_kategori', $data['nama_kategori'], PDO::PARAM_STR);

        $success = $statement->execute();

        return $success;
    }

    public function tambahKategori($nama_kategori)
    {
        $sql = "INSERT INTO master_kategori (nama_kategori) VALUES (?)";
        $statement = $this->basisdata->database->prepare($sql);
        return $statement->execute([$nama_kategori]);
    }

    public function deleteKategori($kategori_id)
    {
        // var_dump($kategori_id);

        $sql = 'DELETE FROM master_kategori WHERE kategori_id = :kategori_id';

        // prepare the statement for execution
        $statement = $this->basisdata->database->prepare($sql);

        // bind the parameter using bindValue instead of bindParam
        $statement->bindParam(':kategori_id', $kategori_id, PDO::PARAM_INT);

        if ($statement->execute()) {
            $pesan['status'] = 'Hapus berhasil';
            return $pesan;
        } else {
            $pesan['status'] = 'Hapus gagal';
            var_dump($statement->errorInfo());
            return $pesan;
        }

    }

    public function getKategori_id()
    {
        return $this->kategori_id;
    }

    public function setKategori_id($kategori_id)
    {
        $this->kategori_id = $kategori_id;
    }
    public function getNama_kategori()
    {
        return $this->nama_kategori;
    }

    public function setNama_kategori($nama_kategori)
    {
        $this->nama_kategori = $nama_kategori;
    }
}
?>