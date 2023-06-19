<?php

require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../utils/functions.php';
require_once __DIR__ . '/../models/Buku.php';

$buku = new Buku($conn);

function handleInsertBuku($buku)
{
    // Mengecek apakah ada file yang diunggah
    if ($_FILES['file_cover']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['file_cover']['tmp_name'];
        $file_name = $_FILES['file_cover']['name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

        // Menentukan lokasi dan nama file baru
        $file_destination = 'uploads/' . uniqid('', true) . '.' . $file_ext;

        // Memindahkan file ke lokasi baru
        if (!move_uploaded_file($file_tmp, $file_destination)) {
            sendResponse("error", "Gagal mengunggah file");
            return;
        }

        $buku->file_cover = $file_destination;
    }

    // Mendapatkan data dari permintaan
    $data = $_POST;

    $buku->kode = $data['kode'];
    $buku->kode_kategori = $data['kode_kategori'];
    $buku->judul = $data['judul'];
    $buku->pengarang = $data['pengarang'];
    $buku->penerbit = $data['penerbit'];
    $buku->tahun = $data['tahun'];
    $buku->tanggal_input = $data['tanggal_input'];
    $buku->harga = $data['harga'];

    // Mengeksekusi query INSERT
    if ($buku->insert()) {
        sendResponse("success", "Buku berhasil ditambahkan");
    } else {
        sendResponse("error", "Gagal menambahkan buku");
    }
}

function handleUpdateBuku($buku)
{
    if (isset($_FILES['file_cover']) && $_FILES['file_cover']['error'] === UPLOAD_ERR_OK) {
        // Mengelola file cover
        $file_cover = $_FILES['file_cover'];
        $file_name = $file_cover['name'];
        $file_tmp = $file_cover['tmp_name'];

        // Pindahkan file cover ke lokasi yang diinginkan
        $destination = 'uploads/' . $file_name;
        move_uploaded_file($file_tmp, $destination);

        // Simpan nama file cover ke dalam database atau variabel $buku->file_cover
        $buku->file_cover = $destination;
    } else {
        if ($_POST['file_cover_old']) {
            $buku->file_cover = $_POST['file_cover_old'];
        }
    }

    $data = $_POST;

    $buku->kode = $data['kode'];
    $buku->kode_kategori = $data['kode_kategori'];
    $buku->judul = $data['judul'];
    $buku->pengarang = $data['pengarang'];
    $buku->penerbit = $data['penerbit'];
    $buku->tahun = $data['tahun'];
    $buku->tanggal_input = $data['tanggal_input'];
    $buku->harga = $data['harga'];

    // Mengeksekusi query UPDATE
    if ($buku->update()) {
        sendResponse("success", "Buku berhasil diperbarui");
    } else {
        sendResponse("error", "Gagal memperbarui buku");
    }
}

function handleDeleteBuku($buku)
{
    // Mendapatkan data dari permintaan
    $data = json_decode(file_get_contents("php://input"));

    $buku->kode = $data->kode;

    // Mengeksekusi query DELETE
    if ($buku->delete()) {
        sendResponse("success", "Kategori berhasil dihapus");
    } else {
        sendResponse("error", "Gagal menghapus kategori");
    }
}


function handleSelectAllBuku($buku)
{
    $result = $buku->selectAll();

    if ($result->num_rows > 0) {
        $buku_arr = array();

        while ($row = $result->fetch_assoc()) {
            $buku_arr[] = $row;
        }

        sendResponse("success", "Data buku", $buku_arr);
    } else {
        sendResponse("error", "Data buku tidak ditemukan");
    }
}
function handleSelectBukuByKode($buku, $kode)
{
    $buku->kode = $kode;

    $result = $buku->selectByKode();

    if ($result->num_rows > 0) {
        $buku_arr = array();

        while ($row = $result->fetch_assoc()) {
            $buku_arr[] = $row;
        }

        sendResponse("success", "Data buku", $buku_arr);
    } else {
        sendResponse("error", "Buku tidak ditemukan");
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'insert_buku') {
    handleInsertBuku($buku);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'update_buku') {
    handleUpdateBuku($buku);
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE' && $action == 'delete_buku') {
    handleDeleteBuku($buku);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'select_buku_all') {
    handleSelectAllBuku($buku);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'select_buku_by_kode') {
    handleSelectBukuByKode($buku, $kode);
}
