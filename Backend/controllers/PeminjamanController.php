<?php

require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../utils/functions.php';
require_once __DIR__ . '/../models/Peminjaman.php';
require_once __DIR__ . '/../models/Anggota.php';

$pinjam = new Peminjaman($conn);
$anggota = new Anggota($conn);

function handlePeminjaman($pinjam)
{
    $data = $_POST;

    $pinjam->tanggal_peminjaman =   date('Y-m-d', strtotime($data['tanggal_peminjaman']));
    $pinjam->nomor_anggota = $data['nomor_anggota'];
    $pinjam->status_peminjaman = $data['status_peminjaman'];
    $pinjam->kode_buku = $data['kode_buku'];

    if ($pinjam->insert()) {
        sendResponse("success", "Data berhasil ditambahkan");
    } else {
        sendResponse("error", "Gagal menambahkan Data");
    }
}

function handlePengembalian($pinjam)
{
    $data = $_POST;

    $pinjam->id = $data['id'];
    $pinjam->tanggal_pengembalian = $data['tanggal_pengembalian'];
    $pinjam->durasi_keterlambatan = $data['durasi_keterlambatan'];
    $pinjam->status_peminjaman = $data['status_peminjaman'];

    if ($pinjam->pengembalian()) {
        sendResponse("success", "Data berhasil diubah");
    } else {
        sendResponse("error", "Gagal mengubah Data");
    }
}

function handleListPeminjaman($pinjam, $status)
{
    if (!$status || $status == 'all') {
        $pinjam->status_peminjaman = NULL; // you can set this to NULL or whatever default value
    } else {
        $pinjam->status_peminjaman = $status;
    }

    $data = $pinjam->listPeminjaman();

    if ($data->num_rows > 0) {
        $data_arr = array();

        while ($row = $data->fetch_assoc()) {
            $data_arr[] = $row;
        }

        sendResponse("success", "Data buku", $data_arr);
    } else {
        sendResponse("error", "Buku tidak ditemukan");
    }
}

function handleListPeminjamanDetail($pinjam, $anggota, $id)
{
    $pinjam->id = $id;
    $data = $pinjam->masterDetail();

    if ($data) {
        $anggota->nomor = $data['nomor_anggota'];
        $getData = $anggota->selectByNomor();
        $dataPeminjam = $getData->fetch_assoc();
        $data = array([
            'data_peminjaman' => $data,
            'data_peminjam' => $dataPeminjam
        ]);
        sendResponse("success", "Data Detail", $data);
    } else {
        sendResponse("error", "Data tidak ditemukan");
    }
}


$urlSegments = explode('/', $_SERVER['REQUEST_URI']);
$status = 'all';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = str_replace('?id=' . $id, '', end($urlSegments));
} elseif (isset($_GET['status'])) {
    $status = $_GET['status'];
    $action = str_replace('?status=' . $status, '', end($urlSegments));
} else {
    $action = end($urlSegments);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'peminjaman') {
    handlePeminjaman($pinjam);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'pengembalian') {
    handlePengembalian($pinjam);
} else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'list_peminjaman') {
    handleListPeminjaman($pinjam, $status);
} else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'list_peminjaman_detail') {
    handleListPeminjamanDetail($pinjam, $anggota, $id);
} else {
    sendResponse("error", "Terjadi kesalahan");
}
