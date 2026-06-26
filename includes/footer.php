<?php
/**
 * Footer Component
 */
?>
    </main><!-- /main -->

    <!-- Footer -->
    <footer class="relative z-10 mt-16 border-t border-emerald-500/15 bg-slate-900/70 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/25">
                            <i class="fas fa-mosque text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-bold"><?= APP_NAME ?></h3>
                            <p class="text-emerald-400/70 text-xs">Panduan Gerakan & Bacaan</p>
                        </div>
                    </div>
                    <p class="text-white/50 text-sm leading-relaxed">
                        Aplikasi panduan sholat interaktif yang membantu Anda belajar gerakan dan bacaan sholat dengan mudah dan menyenangkan.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-emerald-400 font-semibold text-sm uppercase tracking-wider mb-4">Navigasi Cepat</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="<?= str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 1) ?>index.php"
                               class="text-white/60 hover:text-emerald-400 text-sm transition-colors flex items-center gap-2">
                                <i class="fas fa-chevron-right text-xs"></i> Beranda
                            </a>
                        </li>
                        <?php
                        if (isset($gerakanSholat)):
                            $firstThree = array_slice($gerakanSholat, 0, 3);
                            foreach ($firstThree as $g):
                        ?>
                        <li>
                            <a href="<?= str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 1) ?>detail.php?id=<?= $g['id'] ?>"
                               class="text-white/60 hover:text-emerald-400 text-sm transition-colors flex items-center gap-2">
                                <i class="fas fa-chevron-right text-xs"></i> <?= htmlspecialchars($g['nama']) ?>
                            </a>
                        </li>
                        <?php endforeach; endif; ?>
                        <li>
                            <a href="<?= str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 1) ?>pages/about.php"
                               class="text-white/60 hover:text-emerald-400 text-sm transition-colors flex items-center gap-2">
                                <i class="fas fa-chevron-right text-xs"></i> Tentang Kelompok
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Identity Card -->
                <div>
                    <h4 class="text-emerald-400 font-semibold text-sm uppercase tracking-wider mb-4">Identitas Kelompok</h4>
                    <div class="bg-gradient-to-br from-emerald-900/40 to-teal-900/40 rounded-xl p-4 border border-emerald-500/20 space-y-2">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-users text-emerald-400 text-xs mt-1 w-4"></i>
                            <div>
                                <p class="text-white/40 text-xs">Kelompok</p>
                                <p class="text-white text-sm font-semibold"><?= KELOMPOK_NAMA ?></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fas fa-graduation-cap text-emerald-400 text-xs mt-1 w-4"></i>
                            <div>
                                <p class="text-white/40 text-xs">Program Studi</p>
                                <p class="text-white text-sm"><?= PRODI ?></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fas fa-book text-emerald-400 text-xs mt-1 w-4"></i>
                            <div>
                                <p class="text-white/40 text-xs">Mata Kuliah</p>
                                <p class="text-white text-sm"><?= MATA_KULIAH ?></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fas fa-chalkboard-teacher text-emerald-400 text-xs mt-1 w-4"></i>
                            <div>
                                <p class="text-white/40 text-xs">Dosen Pengampu</p>
                                <p class="text-white text-sm"><?= DOSEN ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-8 pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-white/30 text-xs text-center sm:text-left">
                    © 2025 <?= KELOMPOK_NAMA ?> · <?= PRODI ?> · <?= MATA_KULIAH ?>
                </p>
                <p class="text-white/30 text-xs">
                    Dibuat dengan <span class="text-emerald-400">❤</span> menggunakan PHP Native & Tailwind CSS
                </p>
            </div>
        </div>
    </footer>

    <!-- Audio Player Global (hidden) -->
    <div id="global-audio-bar"
         x-show="audioPlayer.isVisible"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-full"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-full"
         class="fixed bottom-0 left-0 right-0 z-50 bg-slate-900/95 backdrop-blur-xl border-t border-emerald-500/30 p-4">
        <div class="max-w-3xl mx-auto flex items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-white text-sm font-medium truncate" x-text="audioPlayer.title">Bacaan</p>
                <div class="mt-1 h-1.5 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-400 to-teal-400 rounded-full transition-all duration-300"
                         :style="'width:' + audioPlayer.progress + '%'"></div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button @click="audioAction('backward')"
                        class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
                    <i class="fas fa-backward-step text-sm"></i>
                </button>
                <button @click="audioAction('toggle')"
                        class="w-11 h-11 rounded-full bg-emerald-500 hover:bg-emerald-400 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 transition-all hover:scale-105">
                    <i class="fas text-sm" :class="audioPlayer.isPlaying ? 'fa-pause' : 'fa-play'"></i>
                </button>
                <button @click="audioAction('stop')"
                        class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
                    <i class="fas fa-xmark text-sm"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Scroll to top -->
    <button x-show="showScrollTop" @click="window.scrollTo({top:0,behavior:'smooth'})"
            x-transition
            class="fixed bottom-20 right-4 z-40 w-10 h-10 bg-emerald-500 hover:bg-emerald-400 text-white rounded-full shadow-lg shadow-emerald-500/30 flex items-center justify-center transition-all hover:scale-110">
        <i class="fas fa-arrow-up text-sm"></i>
    </button>

    <!-- Toast Notification -->
    <div x-show="toast.show" x-transition
         class="fixed top-24 right-4 z-50 max-w-xs bg-slate-800 border border-emerald-500/30 text-white px-4 py-3 rounded-xl shadow-2xl text-sm flex items-center gap-3">
        <i class="fas fa-info-circle text-emerald-400"></i>
        <span x-text="toast.message"></span>
    </div>

    <!-- Main JS -->
    <script src="<?= str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 1) ?>assets/js/main.js"></script>
    <script src="<?= str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 1) ?>assets/js/audio.js"></script>
</body>
</html>
