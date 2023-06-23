<?php

class Anggota
{
    private $conn;
    private $table_name = "anggota";

    public $id;
    public $nomor;
    public $nama;
    public $jenis_kelamin;
    public $alamat;
    public $no_hp;
    public $tanggal_terdaftar;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Metode untuk INSERT anggota
    public function insert()
    {
        $query = "INSERT INTO " . $this->table_name . " (nomor, nama, jenis_kelamin, alamat, no_hp, tanggal_terdaftar) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ssssss", $this->nomor, $this->nama, $this->jenis_kelamin, $this->alamat, $this->no_hp, $this->tanggal_terdaftar);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Metode untuk UPDATE anggota
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " SET nomor = ?, nama = ?, jenis_kelamin = ?, alamat = ?, no_hp = ?, tanggal_terdaftar = ? WHERE nomor = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ssssssi", $this->nomor, $this->nama, $this->jenis_kelamin, $this->alamat, $this->no_hp, $this->tanggal_terdaftar, $this->nomor);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Metode untuk DELETE anggota
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE nomor = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $this->nomor);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Metode untuk SELECT semua anggota
    public function selectAll()
    {
        $query = "SELECT * FROM " . $this->table_name;

        $result = $this->conn->query($query);

        return $result;
    }

    // Metode untuk SELECT anggota berdasarkan nomor
    public function selectByNomor()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE nomor = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $this->nomor);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }
}
