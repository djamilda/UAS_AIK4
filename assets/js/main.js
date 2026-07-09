/**
 * Main Alpine.js Application State
 * Panduan Sholat - main.js
 */

function appState() {
    return {
        // ---- Mode (F-07) ----
        isAnakMode: false,

        // ---- Mobile Menu ----
        mobileMenu: false,

        // ---- Autoplay (F-06) ----
        autoplay: {
            active: false,
            interval: null,
            delay: 8000,
            progress: 0,
            progressInterval: null,
        },

        // ---- Audio Player (F-03) ----
        audioPlayer: {
            isVisible: false,
            isPlaying: false,
            title: '',
            progress: 0,
            src: '',
            howl: null,
            progressTimer: null,
        },

        // ---- Scroll ----
        showScrollTop: false,

        // ---- Toast ----
        toast: { show: false, message: '' },

        // =========================================
        // INIT
        // =========================================
        init() {
            // Load saved mode
            const savedMode = localStorage.getItem('sholat_mode');
            this.isAnakMode = savedMode === 'anak';

            // Scroll listener
            window.addEventListener('scroll', () => {
                this.showScrollTop = window.scrollY > 400;
            });

            // Keyboard navigation (F-05)
            window.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowRight') this.navigate('next');
                if (e.key === 'ArrowLeft')  this.navigate('prev');
                if (e.key === ' ') { e.preventDefault(); this.audioAction('toggle'); }
                if (e.key === 'Escape') this.closeVideo();
            });

            // Page animation
            document.body.classList.add('page-enter');
        },

        // =========================================
        // MODE TOGGLE (F-07)
        // =========================================
        toggleMode() {
            this.isAnakMode = !this.isAnakMode;
            localStorage.setItem('sholat_mode', this.isAnakMode ? 'anak' : 'dewasa');
            this.showToast(this.isAnakMode
                ? '🌟 Mode Anak-anak aktif!'
                : '📖 Mode Dewasa aktif!');
            // Dispatch event for other components to react
            window.dispatchEvent(new CustomEvent('modeChanged', { detail: { isAnak: this.isAnakMode } }));
        },

        // =========================================
        // NAVIGATION (F-05)
        // =========================================
        navigate(direction) {
            const btn = document.getElementById(`nav-${direction}`);
            if (btn) btn.click();
        },

        // =========================================
        // AUDIO ACTIONS (F-03)
        // =========================================
        audioAction(action, src = null, title = null) {
            if (action === 'play' && src) {
                this._stopCurrentAudio();
                this.audioPlayer.src = src;
                this.audioPlayer.title = title || 'Bacaan';
                this.audioPlayer.isVisible = true;
                this.audioPlayer.isPlaying = true;
                this.audioPlayer.progress = 0;

                this.audioPlayer.howl = new Howl({
                    src: [src],
                    html5: true,
                    onplay: () => {
                        this.audioPlayer.isPlaying = true;
                        this._startProgressTimer();
                    },
                    onpause: () => { this.audioPlayer.isPlaying = false; },
                    onend: () => {
                        this.audioPlayer.isPlaying = false;
                        this.audioPlayer.progress = 100;
                        clearInterval(this.audioPlayer.progressTimer);
                    },
                    onloaderror: () => {
                        this.showToast('⚠️ File audio tidak ditemukan. Tambahkan file MP3 ke folder assets/audio/');
                        this.audioPlayer.isPlaying = false;
                    }
                });
                this.audioPlayer.howl.play();
            }
            else if (action === 'toggle') {
                if (!this.audioPlayer.howl) return;
                if (this.audioPlayer.isPlaying) {
                    this.audioPlayer.howl.pause();
                } else {
                    this.audioPlayer.howl.play();
                }
            }
            else if (action === 'stop') {
                this._stopCurrentAudio();
                this.audioPlayer.isVisible = false;
                this.audioPlayer.progress = 0;
            }
            else if (action === 'backward') {
                if (this.audioPlayer.howl) {
                    const newPos = Math.max(0, this.audioPlayer.howl.seek() - 10);
                    this.audioPlayer.howl.seek(newPos);
                }
            }
        },

        _stopCurrentAudio() {
            if (this.audioPlayer.howl) {
                this.audioPlayer.howl.stop();
                this.audioPlayer.howl.unload();
                this.audioPlayer.howl = null;
            }
            clearInterval(this.audioPlayer.progressTimer);
            this.audioPlayer.isPlaying = false;
        },

        _startProgressTimer() {
            clearInterval(this.audioPlayer.progressTimer);
            this.audioPlayer.progressTimer = setInterval(() => {
                if (this.audioPlayer.howl && this.audioPlayer.isPlaying) {
                    const seek     = this.audioPlayer.howl.seek() || 0;
                    const duration = this.audioPlayer.howl.duration() || 1;
                    this.audioPlayer.progress = (seek / duration) * 100;
                }
            }, 500);
        },

        // =========================================
        // AUTOPLAY (F-06)
        // =========================================
        startAutoplay() {
            this.autoplay.active = true;
            this.autoplay.progress = 0;
            this.showToast('▶️ Autoplay dimulai!');
            this._runAutoplayStep();
        },

        stopAutoplay() {
            this.autoplay.active = false;
            clearTimeout(this.autoplay.interval);
            clearInterval(this.autoplay.progressInterval);
            this.autoplay.progress = 0;
        },

        _runAutoplayStep() {
            if (!this.autoplay.active) return;
            this.autoplay.progress = 0;

            // Animate progress bar
            clearInterval(this.autoplay.progressInterval);
            const tickMs = 100;
            const ticks  = this.autoplay.delay / tickMs;
            let   count  = 0;
            this.autoplay.progressInterval = setInterval(() => {
                count++;
                this.autoplay.progress = (count / ticks) * 100;
                if (count >= ticks) clearInterval(this.autoplay.progressInterval);
            }, tickMs);

            this.autoplay.interval = setTimeout(() => {
                const nextBtn = document.getElementById('nav-next');
                if (nextBtn) {
                    nextBtn.click();
                    setTimeout(() => this._runAutoplayStep(), 500);
                } else {
                    // Reached the end
                    this.stopAutoplay();
                    this.showToast('✅ Autoplay selesai!');
                }
            }, this.autoplay.delay);
        },

        // =========================================
        // VIDEO MODAL (F-04)
        // =========================================
        videoModal: { show: false, url: '', title: '', type: 'youtube' },

        openVideo(url, title) {
            const isMp4 = typeof url === 'string' && url.toLowerCase().endsWith('.mp4');
            this.videoModal.url   = isMp4 ? url : url + '?autoplay=1&rel=0';
            this.videoModal.title = title;
            this.videoModal.type  = isMp4 ? 'mp4' : 'youtube';
            this.videoModal.show  = true;
        },

        closeVideo() {
            this.videoModal.show = false;
            this.videoModal.url  = '';
            this.videoModal.type = 'youtube';
        },

        // =========================================
        // TOAST NOTIFICATIONS
        // =========================================
        showToast(message, duration = 3000) {
            this.toast.message = message;
            this.toast.show    = true;
            setTimeout(() => { this.toast.show = false; }, duration);
        },
    };
}
