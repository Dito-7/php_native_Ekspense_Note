<?php
// include("config.php");

class catatan
{
    private $catatan_id;
    private $pengguna_id;
    private $catatan;
    private $tanggal_catatan;
    private $basisdata;

    public function __construct($catatan = null, $tanggal_catatan = null)
    {
        if ($catatan != null && $tanggal_catatan != null) {
            $this->catatan = $catatan;
            $this->tanggal_catatan = $tanggal_catatan;
        }

        $this->basisdata = new config();
    }

    function tambahCatatan($pengguna_id, $catatan, $tanggal_catatan)
    {
        $tanggal_catatan = date("Y-m-d");

        $sql = "INSERT INTO catatan (pengguna_id, catatan, tanggal_catatan)
                VALUES (?, ?, ?)";

        $statement = $this->basisdata->database->prepare($sql);

        var_dump($statement);
        return ($statement->execute([$pengguna_id, $catatan, $tanggal_catatan]));
    }

    public function viewCatatan()
    {
        $pengguna_id = isset($_SESSION['pengguna_id']) ? $_SESSION['pengguna_id'] : 0;

        $sql = "SELECT catatan_id, catatan, tanggal_catatan 
                FROM catatan
                WHERE pengguna_id = :pengguna_id";
        $statement = $this->basisdata->database->prepare($sql);
        $statement->bindParam(":pengguna_id", $pengguna_id, PDO::PARAM_INT);
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function deleteCatatan($catatan_id)
    {
        // var_dump($catatan_id);

        $sql = 'DELETE FROM catatan WHERE catatan_id = :catatan_id';

        // prepare the statement for execution
        $statement = $this->basisdata->database->prepare($sql);

        // bind the parameter using bindValue instead of bindParam
        $statement->bindParam(':catatan_id', $catatan_id, PDO::PARAM_INT);

        if ($statement->execute()) {
            $pesan['status'] = 'Hapus berhasil';
            return $pesan;
        } else {
            $pesan['status'] = 'Hapus gagal';
            var_dump($statement->errorInfo());
            return $pesan;
        }

    }

    public function editCatatan($data)
    {
        $sql = 'UPDATE catatan SET catatan = :catatan WHERE catatan_id = :catatan_id';

        $statement = $this->basisdata->database->prepare($sql);
        $statement->bindParam(':catatan_id', $data['catatan_id'], PDO::PARAM_INT);
        $statement->bindParam(':catatan', $data['catatan'], PDO::PARAM_STR);

        var_dump($statement->execute());

        return $statement->execute();

    }

    public function tampilHistori($catatan_id)
    {
        $sql = "SELECT catatan_id, catatan FROM catatan WHERE catatan_id = :catatan_id";

        $statement = $this->basisdata->database->prepare($sql);
        $statement->bindParam(':catatan_id', $catatan_id, PDO::PARAM_INT);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    }


    public function getCatatan_id()
    {
        return $this->catatan_id;
    }

    public function setCatatan_id($catatan_id)
    {
        $this->catatan_id = $catatan_id;
    }
    public function getCatatan()
    {
        return $this->catatan;
    }

    public function setCatatan($catatan)
    {
        $this->catatan = $catatan;
    }
}
?>