<?php
/**
 * detail.php — Halaman Detail Gerakan Sholat
 * Fitur: F-02 (Detail), F-03 (Audio), F-04 (Video), F-05 (Next/Prev), F-07 (Mode)
 */
require_once 'config/data.php';

// Get requested gerakan ID
$id      = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$gerakan = null;
$idx     = 0;

foreach ($gerakanSholat as $i => $g) {
    if ($g['id'] === $id) {
        $gerakan = $g;
        $idx     = $i;
        break;
    }
}

if (!$gerakan) {
    header('Location: index.php');
    exit;
}

$prevGerakan = $idx > 0 ? $gerakanSholat[$idx - 1] : null;
$nextGerakan = $idx < count($gerakanSholat) - 1 ? $gerakanSholat[$idx + 1] : null;

$pageTitle   = $gerakan['nama'];
$breadcrumbs = [['label' => $gerakan['nama']]];

include 'includes/header.php';
include 'includes/nav.php';
?>

<!-- =================== PROGRESS STEPPER =================== -->
<div class="relative z-10 overflow-x-auto py-6 bg-slate-900/40 border-b border-white/5">
    <div class="flex items-center min-w-max mx-auto px-6 gap-0">
        <?php foreach ($gerakanSholat as $i => $g): ?>
        <div class="flex items-center">
            <!-- Step Dot -->
            <a href="detail.php?id=<?= $g['id'] ?>"
               title="<?= htmlspecialchars($g['nama']) ?>"
               class="progress-step flex flex-col items-center gap-1 group">
                <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center text-xs font-bold transition-all duration-300
                    <?php if ($g['id'] == $id): ?>
                        border-emerald-500 bg-emerald-500 text-white shadow-lg shadow-emerald-500/30
                    <?php elseif ($i < $idx): ?>
                        border-emerald-600/60 bg-emerald-600/20 text-emerald-400
                    <?php else: ?>
                        border-white/15 bg-white/5 text-white/30 group-hover:border-emerald-500/50 group-hover:text-white/60
                    <?php endif; ?>">
                    <?php if ($i < $idx): ?>
                        <i class="fas fa-check text-xs"></i>
                    <?php else: ?>
                        <?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?>
                    <?php endif; ?>
                </div>
                <span class="text-xs whitespace-nowrap max-w-16 truncate text-center
                    <?= $g['id'] == $id ? 'text-emerald-400 font-medium' : 'text-white/30' ?>">
                    <?= htmlspecialchars($g['nama']) ?>
                </span>
            </a>
            <!-- Connector Line -->
            <?php if ($i < count($gerakanSholat) - 1): ?>
            <div class="w-8 h-0.5 mx-1 rounded-full transition-colors
                <?= $i < $idx ? 'bg-emerald-500/50' : 'bg-white/10' ?>"></div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- =================== MAIN CONTENT =================== -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

        <!-- ===== LEFT PANEL: Gerakan Info ===== -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Gerakan Header Card -->
            <div class="glass-card rounded-2xl p-6 border border-white/10 animate__animated animate__fadeInLeft">
                <!-- Kode & Number -->
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-mono text-white/40 bg-white/5 px-2 py-1 rounded-lg"><?= $gerakan['kode'] ?></span>
                    <span class="text-xs text-white/30">Gerakan ke-<?= $idx + 1 ?> dari <?= count($gerakanSholat) ?></span>
                </div>

                <!-- Icon -->
                <div class="flex justify-center mb-5">
                    <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-emerald-500/25 to-teal-500/15
                                border border-emerald-500/25 flex items-center justify-center text-5xl
                                animate-float shadow-xl shadow-emerald-900/30">
                        <?= $gerakan['icon'] ?>
                    </div>
                </div>

                <!-- Name -->
                <h2 class="text-2xl md:text-3xl font-bold text-white text-center mb-2">
                    <?= htmlspecialchars($gerakan['nama']) ?>
                </h2>

                <!-- Description -->
                <div x-show="!isAnakMode" class="text-white/60 text-sm leading-relaxed text-center mt-3">
                    <?= htmlspecialchars($gerakan['deskripsi']['dewasa']) ?>
                </div>
                <div x-show="isAnakMode"
                     class="text-amber-200/70 text-base leading-relaxed text-center mt-3 font-display">
                    <?= htmlspecialchars($gerakan['deskripsi']['anak']) ?>
                </div>
            </div>

            <!-- Navigation Card (F-05) -->
            <div class="glass-card rounded-2xl p-4 border border-white/10">
                <p class="text-white/40 text-xs text-center mb-3 uppercase tracking-wider font-semibold">Navigasi Gerakan</p>
                <div class="flex gap-3">
                    <?php if ($prevGerakan): ?>
                    <a href="detail.php?id=<?= $prevGerakan['id'] ?>"
                       id="nav-prev"
                       class="flex-1 flex flex-col items-center p-3 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 transition-all group">
                        <div class="flex items-center gap-1 text-white/50 group-hover:text-white text-sm mb-1">
                            <i class="fas fa-chevron-left text-xs"></i>
                            <span class="text-xs">Sebelumnya</span>
                        </div>
                        <span class="text-white font-medium text-xs text-center"><?= htmlspecialchars($prevGerakan['nama']) ?></span>
                        <span class="text-2xl mt-1"><?= $prevGerakan['icon'] ?></span>
                    </a>
                    <?php else: ?>
                    <div class="flex-1 flex flex-col items-center p-3 rounded-xl bg-white/3 border border-white/5 opacity-40">
                        <span class="text-white/30 text-xs">Awal</span>
                    </div>
                    <?php endif; ?>

                    <?php if ($nextGerakan): ?>
                    <a href="detail.php?id=<?= $nextGerakan['id'] ?>"
                       id="nav-next"
                       class="flex-1 flex flex-col items-center p-3 rounded-xl bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/25 hover:border-emerald-500/50 transition-all group">
                        <div class="flex items-center gap-1 text-emerald-400/70 group-hover:text-emerald-400 text-sm mb-1">
                            <span class="text-xs">Berikutnya</span>
                            <i class="fas fa-chevron-right text-xs"></i>
                        </div>
                        <span class="text-white font-medium text-xs text-center"><?= htmlspecialchars($nextGerakan['nama']) ?></span>
                        <span class="text-2xl mt-1"><?= $nextGerakan['icon'] ?></span>
                    </a>
                    <?php else: ?>
                    <a href="index.php"
                       id="nav-next"
                       class="flex-1 flex flex-col items-center p-3 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/25 transition-all">
                        <i class="fas fa-flag-checkered text-amber-400 text-xl mb-1"></i>
                        <span class="text-amber-300 text-xs">Selesai!</span>
                        <span class="text-amber-400/70 text-xs">Kembali ke Beranda</span>
                    </a>
                    <?php endif; ?>
                </div>

                <!-- Keyboard hint -->
                <p class="text-center text-white/25 text-xs mt-3">
                    Tekan <kbd class="px-1 bg-white/10 rounded text-white/40">←</kbd>
                    <kbd class="px-1 bg-white/10 rounded text-white/40">→</kbd> untuk berpindah
                </p>
            </div>

            <!-- Back to list -->
            <a href="index.php"
               class="flex items-center justify-center gap-2 p-3 rounded-xl border border-white/10 hover:border-white/20 text-white/50 hover:text-white transition-all text-sm">
                <i class="fas fa-grid-2"></i>
                <span>Semua Gerakan</span>
            </a>
        </div>

        <!-- ===== RIGHT PANEL: Bacaan Section ===== -->
        <div class="lg:col-span-3 space-y-6 animate__animated animate__fadeInRight">

            <!-- Section Title -->
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-white">Bacaan & Do'a</h3>
                    <p class="text-white/40 text-sm mt-0.5"><?= count($gerakan['bacaan']) ?> bacaan untuk gerakan ini</p>
                </div>
                <!-- Mode indicator -->
                <div x-show="isAnakMode" class="mode-anak-badge">
                    <i class="fas fa-star text-xs"></i> Anak-anak
                </div>
            </div>

            <!-- Bacaan Cards (F-02) -->
            <?php foreach ($gerakan['bacaan'] as $bIdx => $bacaan): ?>
            <div class="glass-card rounded-2xl border border-white/10 overflow-hidden"
                 x-data="{ showVideo: false, isExpanded: true }"
                 style="animation-delay: <?= $bIdx * 0.1 ?>s">

                <!-- Bacaan Header -->
                <div class="flex items-center justify-between p-4 border-b border-white/8 cursor-pointer"
                     @click="isExpanded = !isExpanded">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-500/15 border border-emerald-500/25 flex items-center justify-center text-emerald-400 text-sm font-bold">
                            <?= $bIdx + 1 ?>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold text-sm"><?= htmlspecialchars($bacaan['judul']) ?></h4>
                            <p class="text-white/40 text-xs">Bacaan <?= $bIdx + 1 ?></p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-down text-white/30 transition-transform duration-200"
                       :class="isExpanded ? 'rotate-180' : ''"></i>
                </div>

                <!-- Bacaan Content -->
                <div x-show="isExpanded" x-collapse class="p-5 space-y-5">

                    <!-- Arabic Text (F-02) -->
                    <div class="p-5 rounded-xl bg-gradient-to-br from-amber-900/20 to-yellow-900/10 border border-amber-500/20">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fas fa-language text-amber-400 text-xs"></i>
                            <span class="text-amber-400/70 text-xs uppercase tracking-wider font-semibold">Teks Arab</span>
                        </div>
                        <p class="arabic-text"><?= nl2br($bacaan['arab']) ?></p>
                    </div>

                    <!-- Latin & Terjemahan Tabs -->
                    <div x-data="{ tab: 'latin' }">
                        <!-- Tab Buttons -->
                        <div class="flex gap-2 mb-4">
                            <button @click="tab='latin'"
                                    :class="tab === 'latin' ? 'bacaan-tab-btn active bg-emerald-500/15 border-emerald-500/40 text-emerald-400' : 'bacaan-tab-btn bg-white/5 border-white/10 text-white/50 hover:text-white hover:bg-white/10'"
                                    class="flex-1 py-2 text-xs font-semibold rounded-lg border transition-all">
                                <i class="fas fa-font mr-1.5"></i>Latin
                            </button>
                            <button @click="tab='terjemah'"
                                    :class="tab === 'terjemah' ? 'bacaan-tab-btn active bg-emerald-500/15 border-emerald-500/40 text-emerald-400' : 'bacaan-tab-btn bg-white/5 border-white/10 text-white/50 hover:text-white hover:bg-white/10'"
                                    class="flex-1 py-2 text-xs font-semibold rounded-lg border transition-all">
                                <i class="fas fa-book-open mr-1.5"></i>Terjemahan
                            </button>
                        </div>

                        <!-- Latin Tab -->
                        <div x-show="tab === 'latin'" x-transition>
                            <div class="p-4 rounded-xl bg-teal-900/20 border border-teal-500/20">
                                <p class="text-teal-200/90 text-sm leading-loose italic font-medium">
                                    <?= htmlspecialchars($bacaan['latin']) ?>
                                </p>
                            </div>
                        </div>

                        <!-- Terjemahan Tab -->
                        <div x-show="tab === 'terjemah'" x-transition>
                            <div class="p-4 rounded-xl bg-blue-900/20 border border-blue-500/20">
                                <!-- Dewasa -->
                                <div x-show="!isAnakMode" class="text-blue-200/80 text-sm leading-relaxed">
                                    <?= htmlspecialchars($bacaan['terjemah']['dewasa']) ?>
                                </div>
                                <!-- Anak -->
                                <div x-show="isAnakMode" class="text-amber-200/90 text-base leading-relaxed font-display">
                                    <?= htmlspecialchars($bacaan['terjemah']['anak']) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Audio Player (F-03) -->
                    <?php
                        $audioJs = htmlspecialchars(json_encode(BASE_URL . $bacaan['audio'], JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');
                        $judulJs = htmlspecialchars(json_encode($bacaan['judul'], JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');
                    ?>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10">
                        <button onclick="playAudio(<?= $audioJs ?>, <?= $judulJs ?>)"
                                id="audio-btn-<?= $bIdx ?>"
                                class="w-11 h-11 rounded-full bg-emerald-500 hover:bg-emerald-400 text-white flex items-center justify-center shadow-lg shadow-emerald-500/30 transition-all hover:scale-105 flex-shrink-0">
                            <i class="fas fa-play text-sm"></i>
                        </button>
                        <div class="flex-1 min-w-0">
                            <p class="text-white/70 text-xs font-medium"><?= htmlspecialchars($bacaan['judul']) ?></p>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="audio-wave paused" id="wave-<?= $bIdx ?>">
                                    <span></span><span></span><span></span><span></span><span></span>
                                </div>
                                <span class="text-white/30 text-xs">Klik play untuk mendengarkan</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 text-white/30">
                            <i class="fas fa-volume-up text-xs"></i>
                            <span class="text-xs">MP3</span>
                        </div>
                    </div>

                    <!-- Video Button (F-04) -->
                    <?php if (!empty($bacaan['video'])): ?>
                    <?php
                        $videoJs = htmlspecialchars(json_encode($bacaan['video'], JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');
                    ?>
                    <button @click="openVideo(<?= $videoJs ?>, <?= $judulJs ?>)"
                            class="w-full flex items-center justify-center gap-2.5 py-3 rounded-xl
                                   bg-gradient-to-r from-red-900/30 to-rose-900/20 border border-red-500/25
                                   hover:from-red-900/50 hover:border-red-500/50 transition-all group text-sm font-medium text-red-300 hover:text-red-200">
                        <div class="w-8 h-8 rounded-full bg-red-500/20 flex items-center justify-center group-hover:bg-red-500/30 transition-colors">
                            <i class="fab fa-youtube text-red-400"></i>
                        </div>
                        <span>Tonton Video <?= htmlspecialchars($bacaan['judul']) ?></span>
                        <i class="fas fa-external-link-alt text-xs opacity-50"></i>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- All Bacaan Done -->
            <div class="p-4 rounded-xl bg-emerald-500/8 border border-emerald-500/20 flex items-center gap-3">
                <i class="fas fa-circle-check text-emerald-400 text-lg flex-shrink-0"></i>
                <div>
                    <p class="text-white text-sm font-semibold">Semua bacaan ditampilkan</p>
                    <p class="text-white/40 text-xs">Pelajari dengan baik, ulangi hingga hafal.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =================== VIDEO MODAL (F-04) =================== -->
<div x-show="videoModal.show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click.self="closeVideo()"
     class="fixed inset-0 z-[100] modal-overlay flex items-center justify-center p-4">

    <div class="w-full max-w-3xl animate__animated animate__zoomIn animate__faster">
        <!-- Modal Header -->
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center">
                    <i class="fab fa-youtube text-red-400"></i>
                </div>
                <h3 class="text-white font-semibold" x-text="videoModal.title">Video</h3>
            </div>
            <button @click="closeVideo()"
                    class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <!-- Video Embed -->
        <div class="rounded-2xl overflow-hidden bg-black shadow-2xl aspect-video">
            <template x-if="videoModal.type === 'mp4'">
                <video x-show="videoModal.type === 'mp4'"
                       :src="videoModal.url"
                       controls
                       autoplay
                       class="w-full h-full bg-black"
                       playsinline>
                </video>
            </template>

            <template x-if="videoModal.type === 'youtube'">
                <iframe :src="videoModal.url"
                        width="100%" height="100%"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        class="w-full h-full">
                </iframe>
            </template>
        </div>
        <p class="text-center text-white/30 text-xs mt-3">Klik di luar video untuk menutup</p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
