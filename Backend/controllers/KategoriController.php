<?php

require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../utils/functions.php';
require_once __DIR__ . '/../models/Kategori.php';

$kategori = new Kategori($conn);

function handleInsertKategori($kategori)
{
    // Mendapatkan data dari permintaan
    $data = json_decode(file_get_contents("php://input"));

    $kategori->kode = $data->kode;
    $kategori->kategori = $data->kategori;

    // Mengeksekusi query INSERT
    if ($kategori->insert()) {
        sendResponse("success", "Kategori berhasil ditambahkan");
    } else {
        sendResponse("error", "Gagal menambahkan kategori");
    }
}

function handleUpdateKategori($kategori)
{
    // Mendapatkan data dari permintaan
    $data = json_decode(file_get_contents("php://input"));

    $kategori->kode = $data->kode;
    $kategori->kategori = $data->kategori;

    // Mengeksekusi query UPDATE
    if ($kategori->update()) {
        sendResponse("success", "Kategori berhasil diperbarui");
    } else {
        sendResponse("error", "Gagal memperbarui kategori");
    }
}

function handleDeleteKategori($kategori)
{
    // Mendapatkan data dari permintaan
    $data = json_decode(file_get_contents("php://input"));

    $kategori->kode = $data->kode;

    // Mengeksekusi query DELETE
    if ($kategori->delete()) {
        sendResponse("success", "Kategori berhasil dihapus");
    } else {
        sendResponse("error", "Gagal menghapus kategori");
    }
}

function handleSelectAllKategori($kategori)
{
    $result = $kategori->selectAll();

    if ($result->num_rows > 0) {
        $kategori_arr = array();

        while ($row = $result->fetch_assoc()) {
            $kategori_arr[] = $row;
        }

        sendResponse("success", "Data kategori", $kategori_arr);
    } else {
        sendResponse("error", "Data kategori tidak ditemukan");
    }
}

function handleSelectKategoriByKode($kategori, $kode)
{
    $kategori->kode = $kode;

    $result = $kategori->selectByKode();

    if ($result->num_rows > 0) {
        $kategori_arr = array();

        while ($row = $result->fetch_assoc()) {
            $kategori_arr[] = $row;
        }

        sendResponse("success", "Data kategori", $kategori_arr);
    } else {
        sendResponse("error", "kategori tidak ditemukan");
    }
}

// Menghandle permintaan sesuai dengan URL yang diberikan
$urlSegments = explode('/', $_SERVER['REQUEST_URI']);
if (isset($_GET['kode'])) {
    $kode = $_GET['kode'];
    $action = str_replace('?kode=' . $kode, '', end($urlSegments));
} else {
    $action = end($urlSegments);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'insert_kategori') {
    handleInsertKategori($kategori);
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT' && $action == 'update_kategori') {
    handleUpdateKategori($kategori);
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE' && $action == 'delete_kategori') {
    handleDeleteKategori($kategori);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'select_kategori_all') {
    handleSelectAllKategori($kategori);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'select_kategori_by_kode') {
    handleSelectKategoriByKode($kategori, $kode);
}
