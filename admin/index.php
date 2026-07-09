<?php
/**
 * Admin Panel — Dashboard
 * Panduan Sholat - Manajemen Konten (F-09)
 */
session_start();
require_once '../config/data.php';
require_once '../config/functions.php';

$stats = getStats();
$gerakanList = getAllGerakan();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .stat-card:hover { transform: translateY(-2px); }
        .table-row:hover { background: rgba(255,255,255,0.04); }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-emerald-950 to-slate-900 text-white">

    <!-- Background Decorations -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -left-40 w-80 h-80 bg-teal-500/8 rounded-full blur-3xl"></div>
    </div>

    <!-- Header -->
    <header class="relative z-10 bg-slate-900/80 backdrop-blur-xl border-b border-emerald-500/20 sticky top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/25">
                        <i class="fas fa-cog text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg">Admin Panel</h1>
                        <p class="text-emerald-400/70 text-xs"><?= APP_NAME ?> — Manajemen Konten</p>
                    </div>
                </div>
                <a href="../index.php"
                   class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 text-white/70 hover:text-white text-sm transition-all">
                    <i class="fas fa-external-link-alt text-xs"></i>
                    Lihat Website
                </a>
            </div>
        </div>
    </header>

    <main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Flash Message -->
        <?php if ($flash): ?>
        <div class="mb-6 p-4 rounded-xl border flex items-center gap-3 animate-fade-in
            <?php if ($flash['type'] === 'success'): ?>
                bg-emerald-500/15 border-emerald-500/30 text-emerald-300
            <?php elseif ($flash['type'] === 'error'): ?>
                bg-red-500/15 border-red-500/30 text-red-300
            <?php else: ?>
                bg-blue-500/15 border-blue-500/30 text-blue-300
            <?php endif; ?>">
            <i class="fas <?= $flash['type'] === 'success' ? 'fa-check-circle' : ($flash['type'] === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle') ?>"></i>
            <span class="text-sm"><?= htmlspecialchars($flash['message']) ?></span>
        </div>
        <?php endif; ?>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <?php
            $statCards = [
                ['label' => 'Total Gerakan',  'value' => $stats['total_gerakan'],  'icon' => 'fa-mosque',     'color' => 'emerald'],
                ['label' => 'Total Bacaan',   'value' => $stats['total_bacaan'],   'icon' => 'fa-book-open',  'color' => 'teal'],
                ['label' => 'File Audio',     'value' => $stats['total_audio'],    'icon' => 'fa-music',      'color' => 'blue'],
                ['label' => 'Video YouTube',  'value' => $stats['total_video'],    'icon' => 'fa-video',      'color' => 'rose'],
            ];
            foreach ($statCards as $stat): ?>
            <div class="stat-card glass-card rounded-2xl p-5 border border-white/10 transition-all duration-200">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-<?= $stat['color'] ?>-500/15 border border-<?= $stat['color'] ?>-500/25 flex items-center justify-center">
                        <i class="fas <?= $stat['icon'] ?> text-<?= $stat['color'] ?>-400"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-white"><?= $stat['value'] ?></p>
                <p class="text-white/50 text-sm mt-1"><?= $stat['label'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Actions Bar -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
            <div>
                <h2 class="text-xl font-bold text-white">Daftar Gerakan Sholat</h2>
                <p class="text-white/50 text-sm mt-0.5">Kelola semua gerakan dan bacaan sholat</p>
            </div>
            <a href="gerakan_form.php"
               class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-white rounded-xl text-sm font-semibold transition-all hover:scale-105 shadow-lg shadow-emerald-500/25">
                <i class="fas fa-plus text-xs"></i>
                Tambah Gerakan
            </a>
        </div>

        <!-- Gerakan Table -->
        <div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="text-left px-5 py-4 text-white/60 text-xs font-semibold uppercase tracking-wider">No</th>
                            <th class="text-left px-5 py-4 text-white/60 text-xs font-semibold uppercase tracking-wider">Kode</th>
                            <th class="text-left px-5 py-4 text-white/60 text-xs font-semibold uppercase tracking-wider">Gerakan</th>
                            <th class="text-center px-5 py-4 text-white/60 text-xs font-semibold uppercase tracking-wider">Bacaan</th>
                            <th class="text-center px-5 py-4 text-white/60 text-xs font-semibold uppercase tracking-wider">Urutan</th>
                            <th class="text-right px-5 py-4 text-white/60 text-xs font-semibold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php foreach ($gerakanList as $idx => $g):
                            $bacaanCount = count(getBacaanByGerakanId($g['id']));
                        ?>
                        <tr class="table-row transition-colors">
                            <td class="px-5 py-4 text-white/40 text-sm"><?= $idx + 1 ?></td>
                            <td class="px-5 py-4">
                                <span class="text-xs font-mono text-emerald-400 bg-emerald-500/10 px-2 py-1 rounded-lg"><?= htmlspecialchars($g['kode']) ?></span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl"><?= $g['icon'] ?></span>
                                    <div>
                                        <p class="text-white font-medium text-sm"><?= htmlspecialchars($g['nama']) ?></p>
                                        <p class="text-white/40 text-xs mt-0.5 max-w-xs truncate"><?= htmlspecialchars($g['deskripsi_dewasa']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="text-white/70 text-sm"><?= $bacaanCount ?> bacaan</span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="text-white/50 text-sm"><?= $g['urutan'] ?></span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Kelola Bacaan -->
                                    <a href="bacaan_form.php?gerakan_id=<?= $g['id'] ?>"
                                       class="w-8 h-8 rounded-lg bg-blue-500/15 border border-blue-500/25 flex items-center justify-center text-blue-400 hover:bg-blue-500/30 transition-colors"
                                       title="Kelola Bacaan">
                                        <i class="fas fa-book-open text-xs"></i>
                                    </a>
                                    <!-- Edit -->
                                    <a href="gerakan_form.php?id=<?= $g['id'] ?>"
                                       class="w-8 h-8 rounded-lg bg-amber-500/15 border border-amber-500/25 flex items-center justify-center text-amber-400 hover:bg-amber-500/30 transition-colors"
                                       title="Edit Gerakan">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <!-- Delete -->
                                    <form method="POST" action="process.php" onsubmit="return confirm('Yakin ingin menghapus gerakan ini? Semua bacaan terkait juga akan dihapus.');" class="inline">
                                        <input type="hidden" name="action" value="delete_gerakan">
                                        <input type="hidden" name="id" value="<?= $g['id'] ?>">
                                        <button type="submit"
                                                class="w-8 h-8 rounded-lg bg-red-500/15 border border-red-500/25 flex items-center justify-center text-red-400 hover:bg-red-500/30 transition-colors"
                                                title="Hapus Gerakan">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if (empty($gerakanList)): ?>
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center">
                                <div class="text-4xl mb-3">📭</div>
                                <p class="text-white/50 text-sm">Belum ada data gerakan.</p>
                                <a href="gerakan_form.php" class="text-emerald-400 text-sm hover:underline mt-1 inline-block">Tambah gerakan pertama →</a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Info Card -->
        <div class="mt-8 p-4 rounded-xl bg-emerald-500/8 border border-emerald-500/20 flex items-start gap-3">
            <i class="fas fa-info-circle text-emerald-400 mt-0.5 flex-shrink-0"></i>
            <div class="text-sm text-white/60">
                <span class="text-emerald-400 font-medium">Info:</span>
                Admin panel ini merupakan implementasi dari fitur <strong>F-09 (Manajemen Konten Backend)</strong>.
                Data disimpan di database MySQL <code class="px-1 py-0.5 bg-white/10 rounded text-white/80 text-xs">panduan_sholat</code>.
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="relative z-10 border-t border-white/10 mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center">
            <p class="text-white/30 text-xs">Admin Panel — <?= APP_NAME ?> · <?= KELOMPOK_NAMA ?> · <?= MATA_KULIAH ?></p>
        </div>
    </footer>

</body>
</html>
