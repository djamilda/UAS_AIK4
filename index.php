<?php
/**
 * index.php — Halaman Utama (Daftar Gerakan Sholat)
 * Fitur: F-01 (Daftar), F-06 (Autoplay), F-07 (Mode), F-08 (Identitas)
 */
require_once 'config/data.php';
$pageTitle = 'Beranda';
include 'includes/header.php';
?>

<!-- =================== HERO SECTION =================== -->
<section class="relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-16">
        <div class="text-center animate__animated animate__fadeInUp">

            <!-- Mode Badge -->
            <div class="inline-flex items-center gap-2 mb-6">
                <span x-show="!isAnakMode"
                      class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/15 border border-emerald-500/30 text-emerald-400">
                    <i class="fas fa-user-tie"></i> Mode Dewasa Aktif
                </span>
                <span x-show="isAnakMode"
                      class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/15 border border-amber-500/30 text-amber-400">
                    <i class="fas fa-child"></i> Mode Anak-anak Aktif 🌟
                </span>
            </div>

            <!-- Hero Title -->
            <div x-show="!isAnakMode" class="mb-4">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight">
                    Panduan Gerakan<br>
                    <span class="gradient-text">Sholat Lengkap</span>
                </h2>
                <p class="mt-4 text-white/60 text-lg max-w-2xl mx-auto leading-relaxed">
                    Pelajari gerakan dan bacaan sholat secara urut dan sistematis, dilengkapi dengan
                    teks Arab, transliterasi Latin, terjemahan, dan audio bacaan.
                </p>
            </div>
            <div x-show="isAnakMode" class="mb-4">
                <h2 class="text-4xl md:text-5xl font-bold text-white leading-tight">
                    Yuk Belajar<br>
                    <span class="gradient-text-gold">Sholat Bareng! 🕌</span>
                </h2>
                <p class="mt-4 text-amber-200/70 text-lg max-w-xl mx-auto">
                    Pilih gerakan sholat di bawah dan pelajari bacaannya bersama-sama, ya!
                    Insya Allah kita bisa hafal! 💪✨
                </p>
            </div>

            <!-- Stats -->
            <div class="flex items-center justify-center gap-6 md:gap-10 mt-8 flex-wrap">
                <div class="text-center">
                    <p class="text-3xl font-bold gradient-text"><?= count($gerakanSholat) ?></p>
                    <p class="text-white/50 text-sm mt-1">Gerakan Sholat</p>
                </div>
                <div class="w-px h-8 bg-white/10"></div>
                <?php $totalBacaan = array_sum(array_map(fn($g) => count($g['bacaan']), $gerakanSholat)); ?>
                <div class="text-center">
                    <p class="text-3xl font-bold gradient-text"><?= $totalBacaan ?></p>
                    <p class="text-white/50 text-sm mt-1">Bacaan & Do'a</p>
                </div>
                <div class="w-px h-8 bg-white/10"></div>
                <div class="text-center">
                    <p class="text-3xl font-bold gradient-text">2</p>
                    <p class="text-white/50 text-sm mt-1">Mode Pengguna</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =================== AUTOPLAY BAR =================== -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
    <div class="glass-card rounded-2xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4 border border-white/10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400/20 to-teal-400/20 border border-emerald-400/30 flex items-center justify-center">
                <i class="fas fa-play-circle text-emerald-400"></i>
            </div>
            <div>
                <p class="text-white font-semibold text-sm">Mode Autoplay</p>
                <p class="text-white/50 text-xs">Putar gerakan secara otomatis berurutan</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <!-- Autoplay Progress -->
            <div x-show="autoplay.active" class="flex items-center gap-2">
                <div class="w-32 h-1.5 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-400 to-teal-400 rounded-full transition-all duration-100"
                         :style="'width:' + autoplay.progress + '%'"></div>
                </div>
                <span class="text-white/50 text-xs">Berikutnya...</span>
            </div>
            <!-- Start/Stop Button -->
            <button x-show="!autoplay.active" @click="startAutoplay()"
                    class="px-5 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-white rounded-xl text-sm font-semibold transition-all hover:scale-105 shadow-lg shadow-emerald-500/25">
                <i class="fas fa-play mr-1.5"></i>Mulai Autoplay
            </button>
            <button x-show="autoplay.active" @click="stopAutoplay()"
                    class="px-5 py-2 bg-red-500/80 hover:bg-red-500 text-white rounded-xl text-sm font-semibold transition-all hover:scale-105">
                <i class="fas fa-stop mr-1.5"></i>Stop
            </button>
        </div>
    </div>
</div>

<!-- =================== GERAKAN SHOLAT GRID (F-01) =================== -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">

    <!-- Section Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-white">
                Urutan Gerakan Sholat
                <span class="text-white/40 text-base font-normal ml-2">(Qiyam → Salam)</span>
            </h2>
            <p class="text-white/50 text-sm mt-1">Klik gerakan untuk melihat detail dan bacaan</p>
        </div>
        <!-- View Toggle -->
        <div class="flex items-center gap-1 bg-white/5 rounded-lg p-1" x-data="{gridView: true}">
            <button @click="gridView=true"
                    :class="gridView ? 'bg-white/15 text-white' : 'text-white/40'"
                    class="p-2 rounded-md transition-colors">
                <i class="fas fa-grid-2 text-sm"></i>
            </button>
            <button @click="gridView=false"
                    :class="!gridView ? 'bg-white/15 text-white' : 'text-white/40'"
                    class="p-2 rounded-md transition-colors">
                <i class="fas fa-list text-sm"></i>
            </button>
        </div>
    </div>

    <!-- Cards Grid -->
    <div x-data="{gridView: true}" class="gerakan-grid" :class="!gridView && 'flex flex-col gap-3'">
        <?php foreach ($gerakanSholat as $idx => $gerakan): ?>
        <?php
            $colorMap = [
                'emerald' => ['ring' => 'ring-emerald-500/40', 'bg' => 'from-emerald-500/20 to-emerald-600/10', 'text' => 'text-emerald-400', 'badge' => 'bg-emerald-500/20 text-emerald-300'],
                'teal'    => ['ring' => 'ring-teal-500/40',    'bg' => 'from-teal-500/20 to-teal-600/10',       'text' => 'text-teal-400',    'badge' => 'bg-teal-500/20 text-teal-300'],
                'green'   => ['ring' => 'ring-green-500/40',   'bg' => 'from-green-500/20 to-green-600/10',     'text' => 'text-green-400',   'badge' => 'bg-green-500/20 text-green-300'],
                'cyan'    => ['ring' => 'ring-cyan-500/40',    'bg' => 'from-cyan-500/20 to-cyan-600/10',       'text' => 'text-cyan-400',    'badge' => 'bg-cyan-500/20 text-cyan-300'],
                'blue'    => ['ring' => 'ring-blue-500/40',    'bg' => 'from-blue-500/20 to-blue-600/10',       'text' => 'text-blue-400',    'badge' => 'bg-blue-500/20 text-blue-300'],
                'violet'  => ['ring' => 'ring-violet-500/40',  'bg' => 'from-violet-500/20 to-violet-600/10',   'text' => 'text-violet-400',  'badge' => 'bg-violet-500/20 text-violet-300'],
                'indigo'  => ['ring' => 'ring-indigo-500/40',  'bg' => 'from-indigo-500/20 to-indigo-600/10',   'text' => 'text-indigo-400',  'badge' => 'bg-indigo-500/20 text-indigo-300'],
                'amber'   => ['ring' => 'ring-amber-500/40',   'bg' => 'from-amber-500/20 to-amber-600/10',     'text' => 'text-amber-400',   'badge' => 'bg-amber-500/20 text-amber-300'],
                'orange'  => ['ring' => 'ring-orange-500/40',  'bg' => 'from-orange-500/20 to-orange-600/10',   'text' => 'text-orange-400',  'badge' => 'bg-orange-500/20 text-orange-300'],
                'rose'    => ['ring' => 'ring-rose-500/40',    'bg' => 'from-rose-500/20 to-rose-600/10',       'text' => 'text-rose-400',    'badge' => 'bg-rose-500/20 text-rose-300'],
                'pink'    => ['ring' => 'ring-pink-500/40',    'bg' => 'from-pink-500/20 to-pink-600/10',       'text' => 'text-pink-400',    'badge' => 'bg-pink-500/20 text-pink-300'],
            ];
            $c = $colorMap[$gerakan['warna']] ?? $colorMap['emerald'];
        ?>
        <a href="detail.php?id=<?= $gerakan['id'] ?>"
           id="gerakan-card-<?= $gerakan['id'] ?>"
           class="gerakan-card glass-card glass-card-hover rounded-2xl p-5 flex flex-col items-center text-center gap-3 cursor-pointer group border border-white/8 relative overflow-hidden animate__animated animate__fadeIn"
           style="animation-delay: <?= $idx * 0.05 ?>s">

            <!-- Step Number -->
            <div class="absolute top-3 left-3 step-number w-6 h-6 rounded-full flex items-center justify-center text-xs">
                <?= str_pad($idx + 1, 2, '0', STR_PAD_LEFT) ?>
            </div>

            <!-- Kode Badge -->
            <span class="absolute top-3 right-3 text-xs <?= $c['badge'] ?> px-2 py-0.5 rounded-full font-mono">
                <?= $gerakan['kode'] ?>
            </span>

            <!-- Icon -->
            <div class="mt-3 w-16 h-16 rounded-2xl bg-gradient-to-br <?= $c['bg'] ?> flex items-center justify-center text-3xl
                        group-hover:scale-110 transition-transform duration-300 border border-white/10">
                <?= $gerakan['icon'] ?>
            </div>

            <!-- Name -->
            <div>
                <h3 class="text-white font-semibold text-sm leading-tight"><?= htmlspecialchars($gerakan['nama']) ?></h3>
                <p class="text-white/40 text-xs mt-1"><?= count($gerakan['bacaan']) ?> bacaan</p>
            </div>

            <!-- Audio count badge -->
            <div class="flex items-center gap-1 text-xs <?= $c['text'] ?>">
                <i class="fas fa-music text-xs"></i>
                <span><?= count($gerakan['bacaan']) ?> audio</span>
            </div>

            <!-- Hover Arrow -->
            <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                <i class="fas fa-arrow-right text-xs text-white/50"></i>
            </div>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Quick Tip -->
    <div class="mt-8 p-4 rounded-xl bg-emerald-500/8 border border-emerald-500/20 flex items-start gap-3">
        <i class="fas fa-lightbulb text-emerald-400 mt-0.5 flex-shrink-0"></i>
        <div class="text-sm text-white/60">
            <span class="text-emerald-400 font-medium">Tips:</span>
            Gunakan tombol <kbd class="px-1.5 py-0.5 bg-white/10 rounded text-white/80 text-xs font-mono">←</kbd>
            <kbd class="px-1.5 py-0.5 bg-white/10 rounded text-white/80 text-xs font-mono">→</kbd>
            untuk navigasi antar gerakan, dan
            <kbd class="px-1.5 py-0.5 bg-white/10 rounded text-white/80 text-xs font-mono">Space</kbd>
            untuk play/pause audio.
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
