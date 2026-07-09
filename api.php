<?php
/**
 * api.php — REST-like API Endpoints
 * Panduan Sholat - Backend API (F-09)
 *
 * Endpoint:
 *   GET  api.php?action=gerakan            → Semua gerakan
 *   GET  api.php?action=gerakan&id=1       → Detail satu gerakan + bacaan
 *   GET  api.php?action=stats              → Statistik konten
 *   POST api.php?action=create_gerakan     → Tambah gerakan
 *   POST api.php?action=update_gerakan     → Update gerakan
 *   POST api.php?action=delete_gerakan     → Hapus gerakan
 *   POST api.php?action=create_bacaan      → Tambah bacaan
 *   POST api.php?action=update_bacaan      → Update bacaan
 *   POST api.php?action=delete_bacaan      → Hapus bacaan
 *   POST api.php?action=upload_audio       → Upload audio MP3
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config/functions.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$method = $_SERVER['REQUEST_METHOD'];

// Response helper
function jsonResponse($success, $data = null, $message = '') {
    echo json_encode([
        'success' => $success,
        'data'    => $data,
        'message' => $message,
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

try {
    switch ($action) {

        // ============================================================
        // GET: Daftar Gerakan / Detail Gerakan
        // ============================================================
        case 'gerakan':
            if ($method !== 'GET') jsonResponse(false, null, 'Method tidak diizinkan.');

            if (isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                $gerakan = getGerakanLengkap($id);
                if ($gerakan) {
                    jsonResponse(true, $gerakan, 'Detail gerakan berhasil diambil.');
                } else {
                    jsonResponse(false, null, 'Gerakan tidak ditemukan.');
                }
            } else {
                $semuaGerakan = getAllGerakanFormatted();
                jsonResponse(true, $semuaGerakan, 'Daftar gerakan berhasil diambil.');
            }
            break;

        // ============================================================
        // GET: Statistik
        // ============================================================
        case 'stats':
            if ($method !== 'GET') jsonResponse(false, null, 'Method tidak diizinkan.');
            $stats = getStats();
            jsonResponse(true, $stats, 'Statistik berhasil diambil.');
            break;

        // ============================================================
        // POST: Tambah Gerakan
        // ============================================================
        case 'create_gerakan':
            if ($method !== 'POST') jsonResponse(false, null, 'Gunakan method POST.');

            $required = ['kode', 'nama', 'deskripsi_dewasa', 'deskripsi_anak'];
            foreach ($required as $field) {
                if (empty($_POST[$field])) {
                    jsonResponse(false, null, "Field '$field' wajib diisi.");
                }
            }

            $newId = createGerakan($_POST);
            jsonResponse(true, ['id' => $newId], 'Gerakan berhasil ditambahkan.');
            break;

        // ============================================================
        // POST: Update Gerakan
        // ============================================================
        case 'update_gerakan':
            if ($method !== 'POST') jsonResponse(false, null, 'Gunakan method POST.');

            if (empty($_POST['id'])) jsonResponse(false, null, 'ID gerakan wajib.');

            $id = (int)$_POST['id'];
            $existing = getGerakanById($id);
            if (!$existing) jsonResponse(false, null, 'Gerakan tidak ditemukan.');

            updateGerakan($id, $_POST);
            jsonResponse(true, ['id' => $id], 'Gerakan berhasil diupdate.');
            break;

        // ============================================================
        // POST: Hapus Gerakan
        // ============================================================
        case 'delete_gerakan':
            if ($method !== 'POST') jsonResponse(false, null, 'Gunakan method POST.');

            if (empty($_POST['id'])) jsonResponse(false, null, 'ID gerakan wajib.');

            $id = (int)$_POST['id'];
            $existing = getGerakanById($id);
            if (!$existing) jsonResponse(false, null, 'Gerakan tidak ditemukan.');

            deleteGerakan($id);
            jsonResponse(true, null, 'Gerakan berhasil dihapus.');
            break;

        // ============================================================
        // POST: Tambah Bacaan
        // ============================================================
        case 'create_bacaan':
            if ($method !== 'POST') jsonResponse(false, null, 'Gunakan method POST.');

            $required = ['gerakan_id', 'judul', 'arab', 'latin', 'terjemah_dewasa', 'terjemah_anak'];
            foreach ($required as $field) {
                if (empty($_POST[$field])) {
                    jsonResponse(false, null, "Field '$field' wajib diisi.");
                }
            }

            // Handle audio upload jika ada
            if (!empty($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = handleAudioUpload($_FILES['audio']);
                if ($uploadResult['success']) {
                    $_POST['audio_file'] = $uploadResult['path'];
                } else {
                    jsonResponse(false, null, 'Upload audio gagal: ' . $uploadResult['message']);
                }
            }

            // Validasi video URL
            if (!empty($_POST['video_url'])) {
                $_POST['video_url'] = validateVideoUrl($_POST['video_url']);
            }

            $newId = createBacaan($_POST);
            jsonResponse(true, ['id' => $newId], 'Bacaan berhasil ditambahkan.');
            break;

        // ============================================================
        // POST: Update Bacaan
        // ============================================================
        case 'update_bacaan':
            if ($method !== 'POST') jsonResponse(false, null, 'Gunakan method POST.');

            if (empty($_POST['id'])) jsonResponse(false, null, 'ID bacaan wajib.');

            $id = (int)$_POST['id'];
            $existing = getBacaanById($id);
            if (!$existing) jsonResponse(false, null, 'Bacaan tidak ditemukan.');

            // Handle audio upload jika ada file baru
            if (!empty($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = handleAudioUpload($_FILES['audio']);
                if ($uploadResult['success']) {
                    $_POST['audio_file'] = $uploadResult['path'];
                } else {
                    jsonResponse(false, null, 'Upload audio gagal: ' . $uploadResult['message']);
                }
            } else {
                // Pertahankan audio lama jika tidak ada upload baru
                $_POST['audio_file'] = $existing['audio_file'];
            }

            // Validasi video URL
            if (!empty($_POST['video_url'])) {
                $_POST['video_url'] = validateVideoUrl($_POST['video_url']);
            }

            updateBacaan($id, $_POST);
            jsonResponse(true, ['id' => $id], 'Bacaan berhasil diupdate.');
            break;

        // ============================================================
        // POST: Hapus Bacaan
        // ============================================================
        case 'delete_bacaan':
            if ($method !== 'POST') jsonResponse(false, null, 'Gunakan method POST.');

            if (empty($_POST['id'])) jsonResponse(false, null, 'ID bacaan wajib.');

            $id = (int)$_POST['id'];
            $existing = getBacaanById($id);
            if (!$existing) jsonResponse(false, null, 'Bacaan tidak ditemukan.');

            deleteBacaan($id);
            jsonResponse(true, null, 'Bacaan berhasil dihapus.');
            break;

        // ============================================================
        // POST: Upload Audio
        // ============================================================
        case 'upload_audio':
            if ($method !== 'POST') jsonResponse(false, null, 'Gunakan method POST.');

            if (empty($_FILES['audio'])) {
                jsonResponse(false, null, 'File audio tidak ditemukan.');
            }

            $customName = isset($_POST['name']) ? $_POST['name'] : '';
            $result = handleAudioUpload($_FILES['audio'], $customName);

            if ($result['success']) {
                jsonResponse(true, ['path' => $result['path']], $result['message']);
            } else {
                jsonResponse(false, null, $result['message']);
            }
            break;

        // ============================================================
        // Default: Action tidak dikenal
        // ============================================================
        default:
            jsonResponse(false, null, 'Action tidak dikenal. Gunakan: gerakan, stats, create_gerakan, update_gerakan, delete_gerakan, create_bacaan, update_bacaan, delete_bacaan, upload_audio');
            break;
    }

} catch (Exception $e) {
    jsonResponse(false, null, 'Server error: ' . $e->getMessage());
}
