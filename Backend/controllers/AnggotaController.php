<?php

require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../utils/functions.php';
require_once __DIR__ . '/../models/Anggota.php';

$anggota = new Anggota($conn);

function handleInsertAnggota($anggota)
{
    // Mendapatkan data dari permintaan
    $data = $_POST;
    $anggota->nomor = $data['nomor'];
    $anggota->nama = $data['nama'];
    $anggota->jenis_kelamin = $data['jenis_kelamin'];
    $anggota->alamat = $data['alamat'];
    $anggota->no_hp = $data['no_hp'];
    $anggota->tanggal_terdaftar = $data['tanggal_terdaftar'];

    // Mengeksekusi query INSERT
    if ($anggota->insert()) {
        sendResponse("success", "Anggota berhasil ditambahkan");
    } else {
        sendResponse("error", "Gagal menambahkan Anggota");
    }
}


function handleUpdateAnggota($anggota)
{
    $data = $_POST;

    $anggota->nomor = $data['nomor'];
    $anggota->nama = $data['nama'];
    $anggota->jenis_kelamin = $data['jenis_kelamin'];
    $anggota->alamat = $data['alamat'];
    $anggota->no_hp = $data['no_hp'];
    $anggota->tanggal_terdaftar = $data['tanggal_terdaftar'];

    // Mengeksekusi query UPDATE
    if ($anggota->update()) {
        sendResponse("success", "Anggota berhasil diperbarui");
    } else {
        sendResponse("error", "Gagal memperbarui Anggota");
    }
}

function handleDeleteAnggota($anggota)
{
    // Mendapatkan data dari permintaan
    $data = json_decode(file_get_contents("php://input"));

    $anggota->nomor = $data->nomor;

    // Mengeksekusi query DELETE
    if ($anggota->delete()) {
        sendResponse("success", "Anggota berhasil dihapus");
    } else {
        sendResponse("error", "Gagal menghapus Anggota");
    }
}


function handleSelectAllAnggota($anggota)
{
    $result = $anggota->selectAll();

    if ($result->num_rows > 0) {
        $anggota_arr = array();

        while ($row = $result->fetch_assoc()) {
            $anggota_arr[] = $row;
        }

        sendResponse("success", "Data anggota", $anggota_arr);
    } else {
        sendResponse("error", "Data anggota tidak ditemukan");
    }
}
function handleSelectAnggotaByNomor($anggota, $nomor)
{
    $anggota->nomor = $nomor;

    $result = $anggota->selectByNomor();

    if ($result->num_rows > 0) {
        $anggota_arr = array();

        while ($row = $result->fetch_assoc()) {
            $anggota_arr[] = $row;
        }

        sendResponse("success", "Data Anggota", $anggota_arr);
    } else {
        sendResponse("error", "Anggota tidak ditemukan");
    }
}


// Menghandle permintaan sesuai dengan URL yang diberikan
$urlSegments = explode('/', $_SERVER['REQUEST_URI']);

if (isset($_GET['nomor'])) {
    $nomor = $_GET['nomor'];
    $action = str_replace('?nomor=' . $nomor, '', end($urlSegments));
} else {
    $action = end($urlSegments);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'insert_anggota') {
    handleInsertAnggota($anggota);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'update_anggota') {
    handleUpdateAnggota($anggota);
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE' && $action == 'delete_anggota') {
    handleDeleteAnggota($anggota);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'select_anggota_all') {
    handleSelectAllAnggota($anggota);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'select_anggota_by_nomor') {
    handleSelectAnggotaByNomor($anggota, $nomor);
}
