<?php
require_once 'config/db_connect.php';

try {
    $db = getDB();
    echo 'Koneksi database berhasil.';
} catch (Exception $e) {
    echo 'Koneksi gagal: ' . $e->getMessage();
}
