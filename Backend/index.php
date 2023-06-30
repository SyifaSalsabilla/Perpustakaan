<?php

// Menentukan header dan method HTTP
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

// Mengimpor file yang diperlukan
require_once(__DIR__ . '/config/koneksi.php');
require_once(__DIR__ . '/utils/functions.php');

// Mengimpor file-controller
require_once(__DIR__ . '/controllers/KategoriController.php');
require_once(__DIR__ . '/controllers/BukuController.php');
require_once(__DIR__ . '/controllers/AnggotaController.php');
require_once(__DIR__ . '/controllers/PeminjamanController.php');
