/**
 * Audio Controller Helper
 * Panduan Sholat - audio.js
 * Standalone helpers for audio cards (not using Alpine directly)
 */

// Play audio from a button click and sync with Alpine state
function playAudio(src, title) {
    const alpine = document.body._x_dataStack?.[0];
    if (alpine) {
        if (alpine.audioPlayer.src === src && alpine.audioPlayer.isVisible) {
            alpine.audioAction('toggle');
        } else {
            alpine.audioAction('play', src, title);
        }
    } else {
        // Fallback: HTML5 Audio
        if (window.currentAudioSrc === src && window.currentAudio) {
            if (window.currentAudio.paused) {
                window.currentAudio.play();
            } else {
                window.currentAudio.pause();
            }
        } else {
            if (window.currentAudio) {
                window.currentAudio.pause();
            }
            window.currentAudio = new Audio(src);
            window.currentAudioSrc = src;
            window.currentAudio.play().catch(() => {
                alert('File audio tidak ditemukan: ' + src);
            });
        }
    }
}

// Format seconds to mm:ss
function formatTime(secs) {
    const m = Math.floor(secs / 60).toString().padStart(2, '0');
    const s = Math.floor(secs % 60).toString().padStart(2, '0');
    return `${m}:${s}`;
}

// Animate audio card button while playing
function toggleAudioCardState(btn, isPlaying) {
    const icon = btn.querySelector('i');
    if (!icon) return;
    if (isPlaying) {
        icon.classList.remove('fa-play');
        icon.classList.add('fa-pause');
        btn.classList.add('bg-emerald-500', 'shadow-lg', 'shadow-emerald-500/30');
        btn.classList.remove('bg-white/10');
    } else {
        icon.classList.remove('fa-pause');
        icon.classList.add('fa-play');
        btn.classList.remove('bg-emerald-500', 'shadow-lg', 'shadow-emerald-500/30');
        btn.classList.add('bg-white/10');
    }
}
