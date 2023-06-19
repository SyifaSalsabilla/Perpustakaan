<?php

class Buku
{
    private $conn;
    private $table_name = "buku";

    public $id;
    public $kode;
    public $kode_kategori;
    public $judul;
    public $pengarang;
    public $penerbit;
    public $tahun;
    public $tanggal_input;
    public $harga;
    public $file_cover;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Metode untuk INSERT buku
    public function insert()
    {
        $query = "INSERT INTO " . $this->table_name . " (kode, kode_kategori, judul, pengarang, penerbit, tahun, tanggal_input, harga, file_cover) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("sssssssds", $this->kode, $this->kode_kategori, $this->judul, $this->pengarang, $this->penerbit, $this->tahun, $this->tanggal_input, $this->harga, $this->file_cover);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Metode untuk UPDATE buku
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " SET kode_kategori = ?, judul = ?, pengarang = ?, penerbit = ?, tahun = ?, tanggal_input = ?, harga = ?, file_cover = ? WHERE kode = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ssssssdss", $this->kode_kategori, $this->judul, $this->pengarang, $this->penerbit, $this->tahun, $this->tanggal_input, $this->harga, $this->file_cover, $this->kode);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Metode untuk DELETE buku
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

    // Metode untuk SELECT semua buku
    public function selectAll()
    {
        $query = "SELECT * FROM " . $this->table_name;

        $result = $this->conn->query($query);

        return $result;
    }

    // Metode untuk SELECT buku berdasarkan kode
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
