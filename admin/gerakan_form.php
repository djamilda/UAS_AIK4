<?php
session_start();
require_once '../config/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$gerakan = $id ? getGerakanById($id) : null;
$flash = getFlash();
$action = $gerakan ? 'update_gerakan' : 'create_gerakan';
$pageTitle = $gerakan ? 'Edit Gerakan' : 'Tambah Gerakan';
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
                <p class="text-slate-400">Kelola data gerakan sholat.</p>
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

        <form method="POST" action="process.php" class="space-y-6 bg-slate-900/80 border border-white/10 rounded-3xl p-6 shadow-xl shadow-black/20">
            <?php if ($gerakan): ?>
                <input type="hidden" name="id" value="<?= $gerakan['id'] ?>">
            <?php endif; ?>
            <input type="hidden" name="action" value="<?= $action ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-sm text-slate-300">Kode Gerakan</span>
                    <input type="text" name="kode" value="<?= htmlspecialchars($gerakan['kode'] ?? '') ?>" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400" required>
                </label>
                <label class="block">
                    <span class="text-sm text-slate-300">Nama Gerakan</span>
                    <input type="text" name="nama" value="<?= htmlspecialchars($gerakan['nama'] ?? '') ?>" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400" required>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <label class="block">
                    <span class="text-sm text-slate-300">Icon</span>
                    <input type="text" name="icon" value="<?= htmlspecialchars($gerakan['icon'] ?? '🕌') ?>" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400">
                </label>
                <label class="block">
                    <span class="text-sm text-slate-300">Warna</span>
                    <input type="text" name="warna" value="<?= htmlspecialchars($gerakan['warna'] ?? 'emerald') ?>" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400">
                </label>
                <label class="block">
                    <span class="text-sm text-slate-300">Path Gambar</span>
                    <input type="text" name="gambar" value="<?= htmlspecialchars($gerakan['gambar'] ?? '') ?>" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400">
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-sm text-slate-300">Deskripsi Dewasa</span>
                    <textarea name="deskripsi_dewasa" rows="4" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400" required><?= htmlspecialchars($gerakan['deskripsi_dewasa'] ?? '') ?></textarea>
                </label>
                <label class="block">
                    <span class="text-sm text-slate-300">Deskripsi Anak</span>
                    <textarea name="deskripsi_anak" rows="4" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400" required><?= htmlspecialchars($gerakan['deskripsi_anak'] ?? '') ?></textarea>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-sm text-slate-300">Urutan Tampil</span>
                    <input type="number" name="urutan" value="<?= htmlspecialchars($gerakan['urutan'] ?? '0') ?>" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none focus:border-emerald-400">
                </label>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3">
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-500 px-6 py-3 text-sm font-semibold text-white hover:bg-emerald-400 transition">Simpan</button>
                <a href="index.php" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/10 px-6 py-3 text-sm text-white hover:bg-white/10 transition">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
