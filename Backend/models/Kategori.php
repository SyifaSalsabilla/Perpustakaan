<?php

class Kategori
{
    private $conn;
    private $table_name = "kategori";

    public $id;
    public $kode;
    public $kategori;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Metode untuk INSERT kategori
    public function insert()
    {
        $query = "INSERT INTO " . $this->table_name . " (kode, kategori) VALUES (?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ss", $this->kode, $this->kategori);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Metode untuk UPDATE kategori
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " SET kategori = ? WHERE kode = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ss", $this->kategori, $this->kode);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Metode untuk DELETE kategori
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE kode = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("s", $this->kode);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Metode untuk SELECT semua kategori
    public function selectAll()
    {
        $query = "SELECT * FROM " . $this->table_name;

        $result = $this->conn->query($query);

        return $result;
    }

    // Metode untuk SELECT kategori berdasarkan kode
    public function selectByKode()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE kode = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("s", $this->kode);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }
}
