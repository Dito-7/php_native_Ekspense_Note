<?php
// include("config.php");

class pengguna_ekspense
{
    private $pengguna_id;
    private $name;
    private $username;
    private $Gmail;
    private $phone;
    private $password;
    private $confirm;
    private $role;
    private $saldo;
    private $status;
    private $basisdata;

    public function __construct($name = null, $username = null, $Gmail = null, $phone = null, $password = null, $confirm = null, $role = null, $saldo = null, $status = null)
    {
        if ($name != null && $username != null && $Gmail != null && $phone != null && $password != null && $confirm != null && $role != null && $saldo != null && $status != null) {
            $this->name = $name;
            $this->username = $username;
            $this->Gmail = $Gmail;
            $this->phone = $phone;
            $this->password = $password;
            $this->confirm = $confirm;
            $this->role = $role;
            $this->saldo = $saldo;
            $this->status = $status;
        }

        $this->basisdata = new config();
    }

    public function Register($name, $username, $Gmail, $phone, $password, $confirm)
    {
        if ($name == null || $username == null || $Gmail == null || $phone == null || $password == null || $confirm == null) {
            echo "Registrasi gagal, Semua kolom harus diisi.";
            return false;
        } else if ($password !== $confirm) {
            echo "Registrasi gagal, Password harus sama dengan Confirm Password.";
            return false;
        }

        $sql = "INSERT INTO pengguna_ekspense (name, username, Gmail, phone, password, confirm) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $statement = $this->basisdata->database->prepare($sql);

        if ($statement) {
            $pengguna = new pengguna_ekspense($name, $username, $Gmail, $phone, $password, $confirm);
            echo "Registrasi berhasil! " . $pengguna->getName();

            header('Location: ../login.php?pesan=Register berhasil');
        } else {
            echo "Registrasi gagal";
            return false;
        }

        return $statement->execute([$name, $username, $Gmail, $phone, $password, $confirm]);
    }

    public function login($Gmail, $password)
    {
        if ($Gmail == null) {
            header('Location: ../login.php?pesan=Login gagal, Gmail kosong');
            echo "Login gagal, Gmail kosong";
            return null;
        }

        $sql = "SELECT pengguna_id, Gmail, password, name, role, saldo, status FROM pengguna_ekspense WHERE Gmail = :Gmail LIMIT 1";

        $statement = $this->basisdata->database->prepare($sql);
        $statement->bindParam(":Gmail", $Gmail, PDO::PARAM_STR);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            // Check password
            if ($password === $data['password']) {
                session_start();
                $_SESSION['Username'] = $data['name'];
                $_SESSION['pengguna_id'] = $data['pengguna_id'];
                $_SESSION['role'] = $data['role'];
                $_SESSION['saldo'] = $data['saldo'];
                $_SESSION['status'] = $data['status'];
                echo "Login successful! Welcome " . $_SESSION['Username'];

                // var_dump($_SESSION['status']);
                if ($_SESSION['role'] === 'USER' && $_SESSION['status'] === 'aktif') {
                    header('Location: ../dashboard.php?pesan=login berhasil');
                } else if ($_SESSION['role'] === 'ADMIN' && $_SESSION['status'] === 'aktif') {
                    header('Location: ../dashboardAdmin.php?pesan=login berhasil');
                } else {
                    header('Location: ../login.php?pesan=Login gagal, akun anda tidak aktif.');
                    session_destroy();
                }

                return $data;
            } else {
                header('Location: ../login.php?pesan=Login gagal, Password salah.');
                echo "Login gagal, Password salah.";
            }
        } else {
            header('Location: ../login.php?pesan=Login gagal, Gmail tidak ditemukan.');
            echo "Login gagal, Gmail tidak ditemukan.";
        }

        return null;
    }

    public function tampilUser($pengguna_id)
    {
        $sql = "SELECT pengguna_id, name, username, Gmail, phone FROM pengguna_ekspense WHERE pengguna_id = :pengguna_id";

        $statement = $this->basisdata->database->prepare($sql);
        $statement->bindParam(':pengguna_id', $pengguna_id, PDO::PARAM_INT);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function editUser($data)
    {
        $sql = 'UPDATE pengguna_ekspense SET name = :name, username = :username, Gmail = :Gmail, phone = :phone WHERE pengguna_id = :pengguna_id';
        $statement = $this->basisdata->database->prepare($sql);

        $statement->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $statement->bindParam(':username', $data['username'], PDO::PARAM_STR);
        $statement->bindParam(':Gmail', $data['Gmail'], PDO::PARAM_STR);
        $statement->bindParam(':phone', $data['phone'], PDO::PARAM_STR);
        $statement->bindParam(':pengguna_id', $data['pengguna_id'], PDO::PARAM_INT);

        return $statement->execute();
    }

    public function tambahSaldo($pengguna_id, $saldo)
    {
        $sql = 'UPDATE pengguna_ekspense SET saldo = saldo + :saldo WHERE pengguna_id = :pengguna_id';
        $statement = $this->basisdata->database->prepare($sql);

        $statement->bindParam(':saldo', $saldo, PDO::PARAM_INT);
        $statement->bindParam(':pengguna_id', $pengguna_id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function kurangSaldo($pengguna_id, $jumlah_pengeluaran)
    {
        $sql = 'UPDATE pengguna_ekspense SET saldo = saldo - :jumlah_pengeluaran WHERE pengguna_id = :pengguna_id';
        $statement = $this->basisdata->database->prepare($sql);

        $statement->bindParam(':jumlah_pengeluaran', $jumlah_pengeluaran, PDO::PARAM_INT);
        $statement->bindParam(':pengguna_id', $pengguna_id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function viewSaldo()
    {
        $pengguna_id = isset($_SESSION['pengguna_id']) ? $_SESSION['pengguna_id'] : 0;

        $sql = "SELECT saldo FROM pengguna_ekspense WHERE pengguna_id = :pengguna_id";

        $statement = $this->basisdata->database->prepare($sql);
        $statement->bindParam(":pengguna_id", $pengguna_id, PDO::PARAM_INT);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function tampilHistoriPengguna($pengguna_id)
    {
        $sql = "SELECT pengguna_id, username, phone, status, role FROM pengguna_ekspense WHERE pengguna_id = :pengguna_id";

        $statement = $this->basisdata->database->prepare($sql);
        $statement->bindParam(':pengguna_id', $pengguna_id, PDO::PARAM_INT);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    }


    public function viewPengguna()
    {
        $sql = "SELECT pengguna_id, username, phone, status, role FROM pengguna_ekspense WHERE role = 'USER'";
        $statement = $this->basisdata->database->prepare($sql);
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function editStatusPengguna($data)
    {
        $sql = 'UPDATE pengguna_ekspense SET status = :status WHERE pengguna_id = :pengguna_id';

        $statement = $this->basisdata->database->prepare($sql);
        $statement->bindParam(':pengguna_id', $data['pengguna_id'], PDO::PARAM_INT);
        $statement->bindParam(':status', $data['status'], PDO::PARAM_STR);

        $success = $statement->execute();

        return $success;
    }

    public function deletePengguna($pengguna_id)
    {
        // var_dump($pengguna_id);

        $sql = 'DELETE FROM pengguna_ekspense WHERE pengguna_id = :pengguna_id';

        // prepare the statement for execution
        $statement = $this->basisdata->database->prepare($sql);

        // bind the parameter using bindValue instead of bindParam
        $statement->bindParam(':pengguna_id', $pengguna_id, PDO::PARAM_INT);

        if ($statement->execute()) {
            $pesan['status'] = 'Hapus berhasil';
            return $pesan;
        } else {
            $pesan['status'] = 'Hapus gagal';
            var_dump($statement->errorInfo());
            return $pesan;
        }

    }

    public function getPengguna_id()
    {
        return $this->pengguna_id;
    }

    public function setPengguna_id($pengguna_id)
    {
        $this->pengguna_id = $pengguna_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getGmail()
    {
        return $this->Gmail;
    }

    public function setGmail($Gmail)
    {
        $this->Gmail = $Gmail;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getConfirm()
    {
        return $this->confirm;
    }

    public function setConfirm($confirm)
    {
        $this->confirm = $confirm;
    }
}
?>