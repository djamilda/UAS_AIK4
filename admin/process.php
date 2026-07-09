<?php
session_start();
require_once '../config/functions.php';

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function setErrorAndRedirect($message, $redirectUrl) {
    setFlash('error', $message);
    redirect($redirectUrl);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create_gerakan':
        $required = ['kode', 'nama', 'deskripsi_dewasa', 'deskripsi_anak'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                setErrorAndRedirect("Field '$field' wajib diisi.", 'gerakan_form.php');
            }
        }

        try {
            createGerakan([ 
                'kode' => $_POST['kode'],
                'nama' => $_POST['nama'],
                'icon' => $_POST['icon'] ?? '🕌',
                'warna' => $_POST['warna'] ?? 'emerald',
                'gambar' => $_POST['gambar'] ?: null,
                'deskripsi_dewasa' => $_POST['deskripsi_dewasa'],
                'deskripsi_anak' => $_POST['deskripsi_anak'],
                'urutan' => $_POST['urutan'] ?: 0,
            ]);
            setFlash('success', 'Gerakan berhasil ditambahkan.');
            redirect('index.php');
        } catch (Exception $e) {
            setErrorAndRedirect('Gagal menambahkan gerakan: ' . $e->getMessage(), 'gerakan_form.php');
        }
        break;

    case 'update_gerakan':
        if (empty($_POST['id'])) {
            setErrorAndRedirect('ID gerakan wajib.', 'index.php');
        }

        $id = (int)$_POST['id'];
        $existing = getGerakanById($id);
        if (!$existing) {
            setErrorAndRedirect('Gerakan tidak ditemukan.', 'index.php');
        }

        try {
            updateGerakan($id, [
                'kode' => $_POST['kode'],
                'nama' => $_POST['nama'],
                'icon' => $_POST['icon'] ?? '🕌',
                'warna' => $_POST['warna'] ?? 'emerald',
                'gambar' => $_POST['gambar'] ?: null,
                'deskripsi_dewasa' => $_POST['deskripsi_dewasa'],
                'deskripsi_anak' => $_POST['deskripsi_anak'],
                'urutan' => $_POST['urutan'] ?: 0,
            ]);
            setFlash('success', 'Gerakan berhasil diupdate.');
            redirect('gerakan_form.php?id=' . $id);
        } catch (Exception $e) {
            setErrorAndRedirect('Gagal mengupdate gerakan: ' . $e->getMessage(), 'gerakan_form.php?id=' . $id);
        }
        break;

    case 'delete_gerakan':
        if (empty($_POST['id'])) {
            setErrorAndRedirect('ID gerakan wajib.', 'index.php');
        }

        $id = (int)$_POST['id'];
        $existing = getGerakanById($id);
        if (!$existing) {
            setErrorAndRedirect('Gerakan tidak ditemukan.', 'index.php');
        }

        try {
            deleteGerakan($id);
            setFlash('success', 'Gerakan berhasil dihapus.');
            redirect('index.php');
        } catch (Exception $e) {
            setErrorAndRedirect('Gagal menghapus gerakan: ' . $e->getMessage(), 'index.php');
        }
        break;

    case 'create_bacaan':
        $required = ['gerakan_id', 'judul', 'arab', 'latin', 'terjemah_dewasa', 'terjemah_anak'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                setErrorAndRedirect("Field '$field' wajib diisi.", 'bacaan_form.php?gerakan_id=' . urlencode($_POST['gerakan_id'] ?? ''));
            }
        }

        $gerakanId = (int)$_POST['gerakan_id'];
        if (!getGerakanById($gerakanId)) {
            setErrorAndRedirect('Gerakan tidak ditemukan.', 'index.php');
        }

        if (!empty($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = handleAudioUpload($_FILES['audio']);
            if ($uploadResult['success']) {
                $_POST['audio_file'] = $uploadResult['path'];
            } else {
                setErrorAndRedirect('Upload audio gagal: ' . $uploadResult['message'], 'bacaan_form.php?gerakan_id=' . $gerakanId);
            }
        }

        if (!empty($_POST['video_url'])) {
            $videoUrl = validateVideoUrl($_POST['video_url']);
            if ($videoUrl === null) {
                setErrorAndRedirect('URL video YouTube tidak valid.', 'bacaan_form.php?gerakan_id=' . $gerakanId);
            }
            $_POST['video_url'] = $videoUrl;
        }

        try {
            createBacaan([
                'gerakan_id' => $gerakanId,
                'judul' => $_POST['judul'],
                'arab' => $_POST['arab'],
                'latin' => $_POST['latin'],
                'terjemah_dewasa' => $_POST['terjemah_dewasa'],
                'terjemah_anak' => $_POST['terjemah_anak'],
                'audio_file' => $_POST['audio_file'] ?? null,
                'video_url' => $_POST['video_url'] ?? null,
                'urutan' => $_POST['urutan'] ?: 0,
            ]);
            setFlash('success', 'Bacaan berhasil ditambahkan.');
            redirect('bacaan_form.php?gerakan_id=' . $gerakanId);
        } catch (Exception $e) {
            setErrorAndRedirect('Gagal menambahkan bacaan: ' . $e->getMessage(), 'bacaan_form.php?gerakan_id=' . $gerakanId);
        }
        break;

    case 'update_bacaan':
        if (empty($_POST['id'])) {
            setErrorAndRedirect('ID bacaan wajib.', 'index.php');
        }

        $id = (int)$_POST['id'];
        $existing = getBacaanById($id);
        if (!$existing) {
            setErrorAndRedirect('Bacaan tidak ditemukan.', 'index.php');
        }

        $gerakanId = (int)$_POST['gerakan_id'];
        if (!getGerakanById($gerakanId)) {
            setErrorAndRedirect('Gerakan tidak ditemukan.', 'index.php');
        }

        if (!empty($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = handleAudioUpload($_FILES['audio']);
            if ($uploadResult['success']) {
                $_POST['audio_file'] = $uploadResult['path'];
            } else {
                setErrorAndRedirect('Upload audio gagal: ' . $uploadResult['message'], 'bacaan_form.php?gerakan_id=' . $gerakanId . '&id=' . $id);
            }
        } else {
            $_POST['audio_file'] = $existing['audio_file'];
        }

        if (!empty($_POST['video_url'])) {
            $videoUrl = validateVideoUrl($_POST['video_url']);
            if ($videoUrl === null) {
                setErrorAndRedirect('URL video YouTube tidak valid.', 'bacaan_form.php?gerakan_id=' . $gerakanId . '&id=' . $id);
            }
            $_POST['video_url'] = $videoUrl;
        }

        try {
            updateBacaan($id, [
                'gerakan_id' => $gerakanId,
                'judul' => $_POST['judul'],
                'arab' => $_POST['arab'],
                'latin' => $_POST['latin'],
                'terjemah_dewasa' => $_POST['terjemah_dewasa'],
                'terjemah_anak' => $_POST['terjemah_anak'],
                'audio_file' => $_POST['audio_file'] ?? null,
                'video_url' => $_POST['video_url'] ?? null,
                'urutan' => $_POST['urutan'] ?: 0,
            ]);
            setFlash('success', 'Bacaan berhasil diupdate.');
            redirect('bacaan_form.php?gerakan_id=' . $gerakanId . '&id=' . $id);
        } catch (Exception $e) {
            setErrorAndRedirect('Gagal mengupdate bacaan: ' . $e->getMessage(), 'bacaan_form.php?gerakan_id=' . $gerakanId . '&id=' . $id);
        }
        break;

    case 'delete_bacaan':
        if (empty($_POST['id'])) {
            setErrorAndRedirect('ID bacaan wajib.', 'index.php');
        }

        $id = (int)$_POST['id'];
        $existing = getBacaanById($id);
        if (!$existing) {
            setErrorAndRedirect('Bacaan tidak ditemukan.', 'index.php');
        }

        try {
            deleteBacaan($id);
            setFlash('success', 'Bacaan berhasil dihapus.');
            redirect('bacaan_form.php?gerakan_id=' . $existing['gerakan_id']);
        } catch (Exception $e) {
            setErrorAndRedirect('Gagal menghapus bacaan: ' . $e->getMessage(), 'bacaan_form.php?gerakan_id=' . $existing['gerakan_id']);
        }
        break;

    default:
        setErrorAndRedirect('Action tidak dikenal.', 'index.php');
        break;
}
