<?php
/**
 * Backend Functions — CRUD Operations, Audio Upload, Stats
 * Panduan Sholat - Manajemen Konten (F-09)
 */

require_once __DIR__ . '/db_connect.php';

// ============================================================
// GERAKAN: Read Operations
// ============================================================

/**
 * Ambil semua gerakan sholat, urut berdasar kolom 'urutan'
 * @return array
 */
function getAllGerakan() {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM gerakan_sholat ORDER BY urutan ASC");
    return $stmt->fetchAll();
}

/**
 * Ambil satu gerakan berdasar ID
 * @param int $id
 * @return array|null
 */
function getGerakanById($id) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM gerakan_sholat WHERE id = :id");
    $stmt->execute([':id' => (int)$id]);
    return $stmt->fetch() ?: null;
}

/**
 * Ambil semua bacaan untuk satu gerakan
 * @param int $gerakanId
 * @return array
 */
function getBacaanByGerakanId($gerakanId) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM bacaan_sholat WHERE gerakan_id = :gid ORDER BY urutan ASC");
    $stmt->execute([':gid' => (int)$gerakanId]);
    return $stmt->fetchAll();
}

/**
 * Ambil satu gerakan lengkap dengan semua bacaannya
 * Format output sesuai struktur array lama di data.php (backward compatible)
 * @param int $id
 * @return array|null
 */
function getGerakanLengkap($id) {
    $gerakan = getGerakanById($id);
    if (!$gerakan) return null;

    $bacaanRows = getBacaanByGerakanId($id);
    $bacaanFormatted = [];

    foreach ($bacaanRows as $b) {
        $bacaanFormatted[] = [
            'judul'    => $b['judul'],
            'arab'     => $b['arab'],
            'latin'    => $b['latin'],
            'terjemah' => [
                'dewasa' => $b['terjemah_dewasa'],
                'anak'   => $b['terjemah_anak'],
            ],
            'audio'    => $b['audio_file'],
            'video'    => $b['video_url'],
        ];
    }

    return [
        'id'        => (int)$gerakan['id'],
        'kode'      => $gerakan['kode'],
        'nama'      => $gerakan['nama'],
        'icon'      => $gerakan['icon'],
        'warna'     => $gerakan['warna'],
        'gambar'    => $gerakan['gambar'],
        'deskripsi' => [
            'dewasa' => $gerakan['deskripsi_dewasa'],
            'anak'   => $gerakan['deskripsi_anak'],
        ],
        'bacaan'    => $bacaanFormatted,
    ];
}

/**
 * Ambil semua gerakan dalam format array lama (backward compatible)
 * Digunakan oleh data.php agar index.php dan detail.php tetap berfungsi
 * @return array
 */
function getAllGerakanFormatted() {
    $gerakanRows = getAllGerakan();
    $result = [];

    foreach ($gerakanRows as $g) {
        $result[] = getGerakanLengkap($g['id']);
    }

    return $result;
}

// ============================================================
// GERAKAN: Create / Update / Delete
// ============================================================

/**
 * Tambah gerakan baru
 * @param array $data
 * @return int ID gerakan baru
 */
function createGerakan($data) {
    $db = getDB();
    $stmt = $db->prepare("
        INSERT INTO gerakan_sholat (kode, nama, icon, warna, gambar, deskripsi_dewasa, deskripsi_anak, urutan)
        VALUES (:kode, :nama, :icon, :warna, :gambar, :deskripsi_dewasa, :deskripsi_anak, :urutan)
    ");
    $stmt->execute([
        ':kode'             => $data['kode'],
        ':nama'             => $data['nama'],
        ':icon'             => $data['icon'] ?? '🕌',
        ':warna'            => $data['warna'] ?? 'emerald',
        ':gambar'           => $data['gambar'] ?? null,
        ':deskripsi_dewasa' => $data['deskripsi_dewasa'],
        ':deskripsi_anak'   => $data['deskripsi_anak'],
        ':urutan'           => $data['urutan'] ?? 0,
    ]);
    return (int)$db->lastInsertId();
}

/**
 * Update gerakan
 * @param int $id
 * @param array $data
 * @return bool
 */
function updateGerakan($id, $data) {
    $db = getDB();
    $stmt = $db->prepare("
        UPDATE gerakan_sholat SET
            kode = :kode,
            nama = :nama,
            icon = :icon,
            warna = :warna,
            gambar = :gambar,
            deskripsi_dewasa = :deskripsi_dewasa,
            deskripsi_anak = :deskripsi_anak,
            urutan = :urutan
        WHERE id = :id
    ");
    return $stmt->execute([
        ':id'               => (int)$id,
        ':kode'             => $data['kode'],
        ':nama'             => $data['nama'],
        ':icon'             => $data['icon'] ?? '🕌',
        ':warna'            => $data['warna'] ?? 'emerald',
        ':gambar'           => $data['gambar'] ?? null,
        ':deskripsi_dewasa' => $data['deskripsi_dewasa'],
        ':deskripsi_anak'   => $data['deskripsi_anak'],
        ':urutan'           => $data['urutan'] ?? 0,
    ]);
}

/**
 * Hapus gerakan (bacaan akan otomatis terhapus via CASCADE)
 * @param int $id
 * @return bool
 */
function deleteGerakan($id) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM gerakan_sholat WHERE id = :id");
    return $stmt->execute([':id' => (int)$id]);
}

// ============================================================
// BACAAN: Read
// ============================================================

/**
 * Ambil satu bacaan berdasar ID
 * @param int $id
 * @return array|null
 */
function getBacaanById($id) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM bacaan_sholat WHERE id = :id");
    $stmt->execute([':id' => (int)$id]);
    return $stmt->fetch() ?: null;
}

// ============================================================
// BACAAN: Create / Update / Delete
// ============================================================

/**
 * Tambah bacaan baru
 * @param array $data
 * @return int ID bacaan baru
 */
function createBacaan($data) {
    $db = getDB();
    $stmt = $db->prepare("
        INSERT INTO bacaan_sholat (gerakan_id, judul, arab, latin, terjemah_dewasa, terjemah_anak, audio_file, video_url, urutan)
        VALUES (:gerakan_id, :judul, :arab, :latin, :terjemah_dewasa, :terjemah_anak, :audio_file, :video_url, :urutan)
    ");
    $stmt->execute([
        ':gerakan_id'       => (int)$data['gerakan_id'],
        ':judul'            => $data['judul'],
        ':arab'             => $data['arab'],
        ':latin'            => $data['latin'],
        ':terjemah_dewasa'  => $data['terjemah_dewasa'],
        ':terjemah_anak'    => $data['terjemah_anak'],
        ':audio_file'       => $data['audio_file'] ?? null,
        ':video_url'        => $data['video_url'] ?? null,
        ':urutan'           => $data['urutan'] ?? 0,
    ]);
    return (int)$db->lastInsertId();
}

/**
 * Update bacaan
 * @param int $id
 * @param array $data
 * @return bool
 */
function updateBacaan($id, $data) {
    $db = getDB();
    $stmt = $db->prepare("
        UPDATE bacaan_sholat SET
            gerakan_id = :gerakan_id,
            judul = :judul,
            arab = :arab,
            latin = :latin,
            terjemah_dewasa = :terjemah_dewasa,
            terjemah_anak = :terjemah_anak,
            audio_file = :audio_file,
            video_url = :video_url,
            urutan = :urutan
        WHERE id = :id
    ");
    return $stmt->execute([
        ':id'               => (int)$id,
        ':gerakan_id'       => (int)$data['gerakan_id'],
        ':judul'            => $data['judul'],
        ':arab'             => $data['arab'],
        ':latin'            => $data['latin'],
        ':terjemah_dewasa'  => $data['terjemah_dewasa'],
        ':terjemah_anak'    => $data['terjemah_anak'],
        ':audio_file'       => $data['audio_file'] ?? null,
        ':video_url'        => $data['video_url'] ?? null,
        ':urutan'           => $data['urutan'] ?? 0,
    ]);
}

/**
 * Hapus bacaan
 * @param int $id
 * @return bool
 */
function deleteBacaan($id) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM bacaan_sholat WHERE id = :id");
    return $stmt->execute([':id' => (int)$id]);
}

// ============================================================
// AUDIO UPLOAD
// ============================================================

/**
 * Handle upload file audio MP3
 * @param array $file — $_FILES['audio']
 * @param string $customName — nama file kustom (opsional)
 * @return array ['success' => bool, 'path' => string, 'message' => string]
 */
function handleAudioUpload($file, $customName = '') {
    $uploadDir = __DIR__ . '/../assets/audio/';

    // Pastikan direktori ada
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Validasi file ada
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        return ['success' => false, 'path' => '', 'message' => 'Tidak ada file yang diupload.'];
    }

    // Validasi error
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'path' => '', 'message' => 'Error upload: code ' . $file['error']];
    }

    // Validasi tipe file (hanya MP3)
    $allowedTypes = ['audio/mpeg', 'audio/mp3'];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    if (!in_array($mimeType, $allowedTypes)) {
        return ['success' => false, 'path' => '', 'message' => 'Hanya file MP3 yang diizinkan. Tipe terdeteksi: ' . $mimeType];
    }

    // Validasi ukuran (max 10MB)
    $maxSize = 10 * 1024 * 1024; // 10MB
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'path' => '', 'message' => 'Ukuran file terlalu besar. Maksimal 10MB.'];
    }

    // Generate nama file
    if (!empty($customName)) {
        $fileName = preg_replace('/[^a-zA-Z0-9\-_]/', '', $customName) . '.mp3';
    } else {
        $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
        $safeName = preg_replace('/[^a-zA-Z0-9\-_]/', '-', $originalName);
        $fileName = strtolower($safeName) . '.mp3';
    }

    // Jika file sudah ada, tambahkan timestamp
    if (file_exists($uploadDir . $fileName)) {
        $name = pathinfo($fileName, PATHINFO_FILENAME);
        $fileName = $name . '-' . time() . '.mp3';
    }

    $targetPath = $uploadDir . $fileName;

    // Pindahkan file
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $relativePath = 'assets/audio/' . $fileName;
        return ['success' => true, 'path' => $relativePath, 'message' => 'File berhasil diupload.'];
    }

    return ['success' => false, 'path' => '', 'message' => 'Gagal menyimpan file.'];
}

// ============================================================
// VIDEO URL VALIDATION
// ============================================================

/**
 * Validasi dan format URL YouTube embed
 * @param string $url
 * @return string|null URL yang sudah di-format, atau null jika invalid
 */
function validateVideoUrl($url) {
    if (empty($url)) return null;

    $url = trim($url);

    // Sudah format embed
    if (preg_match('/^https:\/\/www\.youtube\.com\/embed\/[\w-]+/', $url)) {
        return $url;
    }

    // Format youtube.com/watch?v=
    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]+)/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }

    // Jika tidak cocok format apapun, kembalikan null
    return null;
}

// ============================================================
// STATISTICS
// ============================================================

/**
 * Hitung statistik konten
 * @return array
 */
function getStats() {
    $db = getDB();

    $totalGerakan = $db->query("SELECT COUNT(*) FROM gerakan_sholat")->fetchColumn();
    $totalBacaan  = $db->query("SELECT COUNT(*) FROM bacaan_sholat")->fetchColumn();
    $totalAudio   = $db->query("SELECT COUNT(*) FROM bacaan_sholat WHERE audio_file IS NOT NULL AND audio_file != ''")->fetchColumn();
    $totalVideo   = $db->query("SELECT COUNT(*) FROM bacaan_sholat WHERE video_url IS NOT NULL AND video_url != ''")->fetchColumn();

    return [
        'total_gerakan' => (int)$totalGerakan,
        'total_bacaan'  => (int)$totalBacaan,
        'total_audio'   => (int)$totalAudio,
        'total_video'   => (int)$totalVideo,
    ];
}

// ============================================================
// FLASH MESSAGE HELPER
// ============================================================

/**
 * Set flash message ke session
 * @param string $type — 'success', 'error', 'info'
 * @param string $message
 */
function setFlash($type, $message) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Ambil dan hapus flash message dari session
 * @return array|null
 */
function getFlash() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
