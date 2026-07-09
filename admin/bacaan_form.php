<?php
session_start();
require_once '../config/functions.php';

$gerakanId = isset($_GET['gerakan_id']) ? (int)$_GET['gerakan_id'] : 0;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$gerakan = $gerakanId ? getGerakanById($gerakanId) : null;
$bacaan = $id ? getBacaanById($id) : null;
$flash = getFlash();
$action = $bacaan ? 'update_bacaan' : 'create_bacaan';
$pageTitle = $bacaan ? 'Edit Bacaan' : 'Tambah Bacaan';

if (!$gerakan) {
    setFlash('error', 'Gerakan tidak ditemukan.');
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> — Admin Panduan Sholat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="min-h-screen bg-slate-950 text-white">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold"><?= $pageTitle ?></h1>
                <p class="text-slate-400">Kelola bacaan untuk gerakan <strong><?= htmlspecialchars($gerakan['nama']) ?></strong>.</p>
            </div>
            <a href="index.php" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 border border-white/10 text-white hover:bg-white/15">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <?php if ($flash): ?>
            <div class="mb-6 p-4 rounded-xl border <?php echo $flash['type'] === 'success' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-200' : 'border-red-500 bg-red-500/10 text-red-200'; ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="process.php" enctype="multipart/form-data" class="space-y-6 bg-slate-900/80 border border-white/10 rounded-3xl p-6 shadow-xl shadow-black/20">
            <input type="hidden" name="action" value="<?= $action ?>">
            <input type="hidden" name="gerakan_id" value="<?= $gerakanId ?>">
            <?php if ($bacaan): ?>
                <input type="hidden" name="id" value="<?= $bacaan['id'] ?>">
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-sm text-slate-300">Judul Bacaan</span>
                    <input type="text" name="judul" value="<?= htmlspecialchars($bacaan['judul'] ?? '') ?>" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400" required>
                </label>
                <label class="block">
                    <span class="text-sm text-slate-300">Urutan</span>
                    <input type="number" name="urutan" value="<?= htmlspecialchars($bacaan['urutan'] ?? '0') ?>" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400">
                </label>
            </div>

            <label class="block">
                <span class="text-sm text-slate-300">Teks Arab</span>
                <textarea name="arab" rows="4" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400" required><?= htmlspecialchars($bacaan['arab'] ?? '') ?></textarea>
            </label>

            <label class="block">
                <span class="text-sm text-slate-300">Transliterasi Latin</span>
                <textarea name="latin" rows="3" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400" required><?= htmlspecialchars($bacaan['latin'] ?? '') ?></textarea>
            </label>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-sm text-slate-300">Terjemah Dewasa</span>
                    <textarea name="terjemah_dewasa" rows="3" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400" required><?= htmlspecialchars($bacaan['terjemah_dewasa'] ?? '') ?></textarea>
                </label>
                <label class="block">
                    <span class="text-sm text-slate-300">Terjemah Anak</span>
                    <textarea name="terjemah_anak" rows="3" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400" required><?= htmlspecialchars($bacaan['terjemah_anak'] ?? '') ?></textarea>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-sm text-slate-300">Audio MP3</span>
                    <input type="file" name="audio" accept="audio/mp3" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400">
                    <?php if (!empty($bacaan['audio_file'])): ?>
                        <p class="mt-2 text-slate-400 text-xs">File saat ini: <?= htmlspecialchars($bacaan['audio_file']) ?></p>
                    <?php endif; ?>
                </label>
                <label class="block">
                    <span class="text-sm text-slate-300">YouTube URL</span>
                    <input type="url" name="video_url" value="<?= htmlspecialchars($bacaan['video_url'] ?? '') ?>" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400">
                </label>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3">
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-500 px-6 py-3 text-sm font-semibold text-white hover:bg-emerald-400 transition">Simpan</button>
                <a href="index.php" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/10 px-6 py-3 text-sm text-white hover:bg-white/10 transition">Batal</a>
            </div>
        </form>

        <?php if ($bacaan): ?>
        <form method="POST" action="process.php" class="mt-4 inline-flex">
            <input type="hidden" name="action" value="delete_bacaan">
            <input type="hidden" name="id" value="<?= $bacaan['id'] ?>">
            <button type="submit" class="rounded-2xl bg-red-500 px-6 py-3 text-sm font-semibold text-white hover:bg-red-400 transition" onclick="return confirm('Yakin ingin menghapus bacaan ini?');">Hapus Bacaan</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
