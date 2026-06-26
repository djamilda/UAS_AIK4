<?php
/**
 * pages/about.php — Halaman Tentang Kelompok
 */
require_once '../config/data.php';
$pageTitle   = 'Tentang Kelompok';
$breadcrumbs = [['label' => 'Tentang Kelompok']];
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Hero -->
    <div class="text-center mb-14 animate__animated animate__fadeInDown">
        <div class="w-20 h-20 mx-auto bg-gradient-to-br from-emerald-400 to-teal-500 rounded-3xl
                    flex items-center justify-center text-4xl shadow-2xl shadow-emerald-500/30 mb-6 animate-float">
            🕌
        </div>
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
            Tentang <span class="gradient-text">Kelompok</span>
        </h2>
        <p class="text-white/50 max-w-2xl mx-auto text-lg leading-relaxed">
            Proyek aplikasi panduan sholat ini dikembangkan sebagai tugas mata kuliah
            <span class="text-emerald-400 font-medium"><?= MATA_KULIAH ?></span>
        </p>
    </div>

    <!-- Info Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">

        <!-- Identitas Kelompok -->
        <div class="glass-card rounded-2xl p-6 border border-white/10 animate__animated animate__fadeInLeft">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center">
                    <i class="fas fa-id-card text-emerald-400"></i>
                </div>
                <h3 class="text-white font-bold text-lg">Identitas Kelompok</h3>
            </div>

            <div class="space-y-4">
                <?php
                $items = [
                    ['icon' => 'fa-users',               'label' => 'Nama Kelompok',    'value' => KELOMPOK_NAMA],
                    ['icon' => 'fa-graduation-cap',      'label' => 'Program Studi',     'value' => PRODI],
                    ['icon' => 'fa-book',                'label' => 'Mata Kuliah',       'value' => MATA_KULIAH],
                    ['icon' => 'fa-chalkboard-teacher',  'label' => 'Dosen Pengampu',    'value' => DOSEN],
                    ['icon' => 'fa-calendar-alt',        'label' => 'Tahun Akademik',    'value' => '2024/2025'],
                ];
                foreach ($items as $item): ?>
                <div class="flex items-start gap-3 p-3 rounded-xl bg-white/3 border border-white/5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/15 flex items-center justify-center flex-shrink-0">
                        <i class="fas <?= $item['icon'] ?> text-emerald-400 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-white/40 text-xs"><?= $item['label'] ?></p>
                        <p class="text-white font-medium text-sm"><?= $item['value'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Fitur Aplikasi -->
        <div class="glass-card rounded-2xl p-6 border border-white/10 animate__animated animate__fadeInRight">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-teal-500/20 border border-teal-500/30 flex items-center justify-center">
                    <i class="fas fa-list-check text-teal-400"></i>
                </div>
                <h3 class="text-white font-bold text-lg">Fitur Aplikasi</h3>
            </div>

            <div class="space-y-3">
                <?php
                $fiturList = [
                    ['kode'=>'F-01','nama'=>'Daftar Gerakan Sholat',   'icon'=>'fa-list',        'done'=>true],
                    ['kode'=>'F-02','nama'=>'Detail Gerakan & Bacaan', 'icon'=>'fa-book-open',   'done'=>true],
                    ['kode'=>'F-03','nama'=>'Audio MP3 Bacaan',        'icon'=>'fa-music',       'done'=>true],
                    ['kode'=>'F-04','nama'=>'Opsi Video Gerakan',      'icon'=>'fa-video',       'done'=>true],
                    ['kode'=>'F-05','nama'=>'Navigasi Next/Previous',  'icon'=>'fa-arrows-left-right','done'=>true],
                    ['kode'=>'F-06','nama'=>'Autoplay Berurutan',      'icon'=>'fa-play-circle', 'done'=>true],
                    ['kode'=>'F-07','nama'=>'Mode Dewasa & Anak',      'icon'=>'fa-child',       'done'=>true],
                    ['kode'=>'F-08','nama'=>'Identitas pada Header',   'icon'=>'fa-id-badge',    'done'=>true],
                    ['kode'=>'F-09','nama'=>'Manajemen Konten (BE)',   'icon'=>'fa-database',    'done'=>false],
                ];
                foreach ($fiturList as $f): ?>
                <div class="flex items-center gap-3">
                    <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0
                        <?= $f['done'] ? 'bg-emerald-500/20 border border-emerald-500/50' : 'bg-white/5 border border-white/15' ?>">
                        <?php if ($f['done']): ?>
                        <i class="fas fa-check text-emerald-400" style="font-size:9px;"></i>
                        <?php else: ?>
                        <i class="fas fa-clock text-white/25" style="font-size:9px;"></i>
                        <?php endif; ?>
                    </div>
                    <span class="font-mono text-xs <?= $f['done'] ? 'text-emerald-400' : 'text-white/30' ?>"><?= $f['kode'] ?></span>
                    <span class="text-sm <?= $f['done'] ? 'text-white/70' : 'text-white/30' ?>"><?= $f['nama'] ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Anggota Kelompok -->
    <div class="glass-card rounded-2xl p-6 border border-white/10 mb-8 animate__animated animate__fadeInUp">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-violet-500/20 border border-violet-500/30 flex items-center justify-center">
                <i class="fas fa-user-group text-violet-400"></i>
            </div>
            <h3 class="text-white font-bold text-lg">Anggota Kelompok</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php
            $anggota = [
                ['nama' => 'Nama Anggota 1', 'nim' => 'NIM: 2xxxxxxx', 'peran' => 'Frontend Dev', 'icon' => '👨‍💻'],
                ['nama' => 'Nama Anggota 2', 'nim' => 'NIM: 2xxxxxxx', 'peran' => 'Backend Dev',  'icon' => '👩‍💻'],
                ['nama' => 'Nama Anggota 3', 'nim' => 'NIM: 2xxxxxxx', 'peran' => 'UI/UX Design',  'icon' => '🎨'],
                ['nama' => 'Nama Anggota 4', 'nim' => 'NIM: 2xxxxxxx', 'peran' => 'Konten Editor', 'icon' => '✍️'],
                ['nama' => 'Nama Anggota 5', 'nim' => 'NIM: 2xxxxxxx', 'peran' => 'Tester',        'icon' => '🧪'],
            ];
            foreach ($anggota as $idx => $orang): ?>
            <div class="flex items-center gap-3 p-4 rounded-xl bg-white/4 border border-white/8
                        hover:bg-white/8 hover:border-white/15 transition-all group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-teal-500/15
                            border border-emerald-500/20 flex items-center justify-center text-2xl flex-shrink-0
                            group-hover:scale-110 transition-transform">
                    <?= $orang['icon'] ?>
                </div>
                <div>
                    <p class="text-white font-semibold text-sm"><?= htmlspecialchars($orang['nama']) ?></p>
                    <p class="text-white/40 text-xs"><?= $orang['nim'] ?></p>
                    <span class="text-xs text-emerald-400/80 bg-emerald-500/10 px-2 py-0.5 rounded-full mt-1 inline-block">
                        <?= $orang['peran'] ?>
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Tech Stack -->
    <div class="glass-card rounded-2xl p-6 border border-white/10 animate__animated animate__fadeInUp">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-500/30 flex items-center justify-center">
                <i class="fas fa-code text-amber-400"></i>
            </div>
            <h3 class="text-white font-bold text-lg">Teknologi yang Digunakan</h3>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <?php
            $techs = [
                ['name'=>'PHP Native',    'desc'=>'Backend & Templating',   'icon'=>'fab fa-php',     'color'=>'text-indigo-400',  'bg'=>'bg-indigo-500/10 border-indigo-500/20'],
                ['name'=>'Tailwind CSS',  'desc'=>'Framework CSS Utility',  'icon'=>'fas fa-wind',    'color'=>'text-cyan-400',    'bg'=>'bg-cyan-500/10 border-cyan-500/20'],
                ['name'=>'Alpine.js',     'desc'=>'Interaktivitas Ringan',   'icon'=>'fas fa-bolt',    'color'=>'text-blue-400',    'bg'=>'bg-blue-500/10 border-blue-500/20'],
                ['name'=>'Howler.js',     'desc'=>'Audio Player Web',        'icon'=>'fas fa-music',   'color'=>'text-green-400',   'bg'=>'bg-green-500/10 border-green-500/20'],
                ['name'=>'Font Awesome',  'desc'=>'Icon Library',            'icon'=>'fas fa-icons',   'color'=>'text-orange-400',  'bg'=>'bg-orange-500/10 border-orange-500/20'],
                ['name'=>'Google Fonts',  'desc'=>'Amiri, Inter, Nunito',    'icon'=>'fas fa-font',    'color'=>'text-rose-400',    'bg'=>'bg-rose-500/10 border-rose-500/20'],
            ];
            foreach ($techs as $t): ?>
            <div class="p-4 rounded-xl border <?= $t['bg'] ?> flex items-center gap-3">
                <i class="<?= $t['icon'] ?> <?= $t['color'] ?> text-xl w-6 text-center"></i>
                <div>
                    <p class="text-white text-sm font-semibold"><?= $t['name'] ?></p>
                    <p class="text-white/40 text-xs"><?= $t['desc'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
