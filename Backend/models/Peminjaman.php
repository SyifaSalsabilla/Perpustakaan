<?php

class Peminjaman
{
    private $conn;
    private $table_name = "peminjaman_master";
    private $table2 = "peminjaman_detail";

    public $id;
    public $tanggal_peminjaman;
    public $nomor_anggota;
    public $tanggal_pengembalian;
    public $durasi_keterlambatan;
    public $tanggal_pinjam;
    public $status_peminjaman;
    public $kode_buku;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function insert()
    {
        $query = "INSERT INTO " . $this->table_name . " (nomor_anggota, tanggal_peminjaman, tanggal_pengembalian, status_peminjaman) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("isss", $this->nomor_anggota, $this->tanggal_peminjaman, $this->tanggal_pengembalian, $this->status_peminjaman);

        if ($stmt->execute()) {
            $id_peminjaman_master = $stmt->insert_id;

            $query2 = "INSERT INTO " . $this->table2 . " (id_peminjaman_master, kode_buku) VALUES (?, ?)";

            $stmt2 = $this->conn->prepare($query2);

            $stmt2->bind_param("is", $id_peminjaman_master, $this->kode_buku);

            if ($stmt2->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function pengembalian()
    {
        $query = "UPDATE " . $this->table_name . " SET tanggal_pengembalian = ?, durasi_keterlambatan = ?, status_peminjaman = ? WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("sisi",  $this->tanggal_pengembalian, $this->durasi_keterlambatan, $this->status_peminjaman, $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function listPeminjaman()
    {
        // Check if status is not set or empty
        if (!isset($this->status_peminjaman) || empty($this->status_peminjaman)) {
            // If status is not provided, select all
            $query = "SELECT * FROM " . $this->table_name;
        } else {
            // If status is provided, select by status
            $query = "SELECT * FROM " . $this->table_name . " WHERE status_peminjaman = ?";
        }

        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            throw new Exception("Failed to prepare SQL statement: " . $this->conn->error);
        }

        // Bind the parameter only if status is not empty
        if (!empty($this->status_peminjaman)) {
            $bind_result = $stmt->bind_param("s", $this->status_peminjaman);

            if ($bind_result === false) {
                throw new Exception("Failed to bind parameters: " . $stmt->error);
            }
        }

        $execute_result = $stmt->execute();

        if ($execute_result === false) {
            throw new Exception("Failed to execute SQL statement: " . $stmt->error);
        }

        $result = $stmt->get_result();

        if ($result === false) {
            throw new Exception("Failed to get result: " . $stmt->error);
        }

        return $result;
    }

    public function masterDetail()
    {
        $query = "SELECT * FROM " . $this->table2 . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            throw new Exception("Failed to prepare SQL statement: " . $this->conn->error);
        }

        $bind_result = $stmt->bind_param("i", $this->id);

        if ($bind_result === false) {
            throw new Exception("Failed to bind parameters: " . $stmt->error);
        }

        $execute_result = $stmt->execute();

        if ($execute_result === false) {
            throw new Exception("Failed to execute SQL statement: " . $stmt->error);
        }

        $result = $stmt->get_result();

        if ($result === false) {
            throw new Exception("Failed to get result: " . $stmt->error);
        }

        $data = $result->fetch_assoc();

        $query2 = "SELECT * FROM " . $this->table_name . " WHERE id = ?";

        $stmt2 = $this->conn->prepare($query2);

        if ($stmt2 === false) {
            throw new Exception("Failed to prepare SQL statement: " . $this->conn->error);
        }

        $bind_result2 = $stmt2->bind_param("i", $data['id_peminjaman_master']);

        if ($bind_result2 === false) {
            throw new Exception("Failed to bind parameters: " . $stmt2->error);
        }

        $execute_result2 = $stmt2->execute();

        if ($execute_result2 === false) {
            throw new Exception("Failed to execute SQL statement: " . $stmt2->error);
        }

        $result2 = $stmt2->get_result();

        if ($result2 === false) {
            throw new Exception("Failed to get result: " . $stmt2->error);
        }

        $data2 = $result2->fetch_assoc();

        $result = array_merge($data, $data2);

        return $result;
    }
}
