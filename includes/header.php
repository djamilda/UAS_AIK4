<?php
/**
 * Header Component
 * Menampilkan identitas kelompok (F-08) + Mode Toggle (F-07)
 */
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="id" x-data="appState()" :class="{ 'mode-anak': isAnakMode }" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi Panduan Gerakan dan Bacaan Sholat - Lengkap dengan Audio, Video, dan Dua Mode Pengguna">
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?><?= APP_NAME ?></title>

    <!-- Tailwind CSS CDN Play -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'arabic': ['Amiri', 'serif'],
                        'sans':   ['Inter', 'Nunito', 'system-ui', 'sans-serif'],
                        'display':['Nunito', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0',
                            300: '#86efac', 400: '#4ade80', 500: '#22c55e',
                            600: '#16a34a', 700: '#15803d', 800: '#166534',
                            900: '#14532d', 950: '#052e16',
                        },
                        islamic: {
                            green: '#1B6B3A', gold: '#D4A017', teal: '#0F4C5C',
                            cream: '#FFF8E7', dark: '#0D1F1A',
                        }
                    },
                    animation: {
                        'fade-in':    'fadeIn 0.5s ease-in-out',
                        'slide-up':   'slideUp 0.4s ease-out',
                        'pulse-soft': 'pulseSoft 2s ease-in-out infinite',
                        'float':      'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn:    { '0%': { opacity: 0 }, '100%': { opacity: 1 } },
                        slideUp:   { '0%': { opacity: 0, transform: 'translateY(20px)' }, '100%': { opacity: 1, transform: 'translateY(0)' } },
                        pulseSoft: { '0%,100%': { opacity: 1 }, '50%': { opacity: 0.7 } },
                        float:     { '0%,100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-8px)' } },
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/custom.css">

    <!-- Alpine.js Collapse Plugin -->
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Howler.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.4/howler.min.js"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-emerald-950 to-slate-900 font-sans"
      :class="isAnakMode ? 'mode-anak-body' : ''">

    <!-- Decorative Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -left-40 w-80 h-80 bg-teal-500/8 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 right-1/3 w-72 h-72 bg-emerald-600/10 rounded-full blur-3xl"></div>
        <!-- Subtle pattern -->
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: url('data:image/svg+xml,<svg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"><g fill=\"none\" fill-rule=\"evenodd\"><g fill=\"%23ffffff\" fill-opacity=\"1\"><path d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/></g></g></svg>');"></div>
    </div>

    <!-- Main Header -->
    <header class="relative z-50 bg-slate-900/80 backdrop-blur-xl border-b border-emerald-500/20 sticky top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">

                <!-- Logo & Brand -->
                <a href="<?= BASE_URL ?>index.php"
                   class="flex items-center gap-3 group">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/25 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-mosque text-white text-lg md:text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg md:text-xl leading-tight"><?= APP_NAME ?></h1>
                        <p class="text-emerald-400/70 text-xs hidden sm:block">Panduan Gerakan & Bacaan</p>
                    </div>
                </a>

                <!-- Desktop Identity Info -->
                <div class="hidden lg:flex items-center gap-6 text-center">
                    <div class="text-right">
                        <p class="text-emerald-400 text-xs font-semibold uppercase tracking-wider"><?= KELOMPOK_NAMA ?></p>
                        <p class="text-white/60 text-xs"><?= PRODI ?></p>
                    </div>
                    <div class="h-8 w-px bg-emerald-500/30"></div>
                    <div class="text-right">
                        <p class="text-white/80 text-xs font-medium"><?= MATA_KULIAH ?></p>
                        <p class="text-white/50 text-xs"><?= DOSEN ?></p>
                    </div>
                </div>

                <!-- Right Side Controls -->
                <div class="flex items-center gap-2 md:gap-3">

                    <!-- Mode Toggle (F-07) -->
                    <button @click="toggleMode()"
                            id="mode-toggle-btn"
                            class="relative flex items-center gap-2 px-3 py-2 rounded-xl border transition-all duration-300 text-sm font-semibold cursor-pointer"
                            :class="isAnakMode
                                ? 'bg-amber-400/20 border-amber-400/40 text-amber-300 hover:bg-amber-400/30'
                                : 'bg-emerald-500/15 border-emerald-500/30 text-emerald-300 hover:bg-emerald-500/25'">
                        <span x-show="!isAnakMode" class="flex items-center gap-1.5">
                            <i class="fas fa-user-tie text-xs"></i>
                            <span class="hidden sm:inline">Dewasa</span>
                        </span>
                        <span x-show="isAnakMode" class="flex items-center gap-1.5">
                            <i class="fas fa-child text-xs"></i>
                            <span class="hidden sm:inline">Anak-anak</span>
                        </span>
                        <!-- Toggle Pill -->
                        <div class="w-8 h-4 rounded-full relative transition-colors duration-300"
                             :class="isAnakMode ? 'bg-amber-400' : 'bg-emerald-500'">
                            <div class="absolute top-0.5 w-3 h-3 bg-white rounded-full shadow transition-transform duration-300"
                                 :class="isAnakMode ? 'translate-x-4' : 'translate-x-0.5'"></div>
                        </div>
                    </button>

                    <!-- Navigation Links -->
                    <nav class="hidden md:flex items-center gap-1">
                        <a href="<?= BASE_URL ?>index.php"
                           class="px-3 py-2 text-sm rounded-lg transition-all duration-200
                                  <?= $currentPage === 'index' ? 'text-emerald-400 bg-emerald-500/15' : 'text-white/60 hover:text-white hover:bg-white/5' ?>">
                            <i class="fas fa-home mr-1.5"></i>Beranda
                        </a>
                        <a href="<?= BASE_URL ?>pages/about.php"
                           class="px-3 py-2 text-sm rounded-lg transition-all duration-200
                                  <?= $currentPage === 'about' ? 'text-emerald-400 bg-emerald-500/15' : 'text-white/60 hover:text-white hover:bg-white/5' ?>">
                            <i class="fas fa-users mr-1.5"></i>Kelompok
                        </a>
                    </nav>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenu = !mobileMenu"
                            class="md:hidden w-9 h-9 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-white/10 transition-colors">
                        <i class="fas" :class="mobileMenu ? 'fa-times' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" x-transition class="md:hidden border-t border-white/10 bg-slate-900/95 backdrop-blur-xl">
            <div class="max-w-7xl mx-auto px-4 py-4 space-y-2">
                <!-- Identity -->
                <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 mb-3">
                    <p class="text-emerald-400 text-xs font-bold"><?= KELOMPOK_NAMA ?> • <?= PRODI ?></p>
                    <p class="text-white/60 text-xs mt-0.5"><?= MATA_KULIAH ?> | <?= DOSEN ?></p>
                </div>
                <a href="<?= BASE_URL ?>index.php"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm <?= $currentPage === 'index' ? 'text-emerald-400 bg-emerald-500/15' : 'text-white/70 hover:bg-white/5' ?>">
                    <i class="fas fa-home w-4"></i> Beranda
                </a>
                <a href="<?= BASE_URL ?>pages/about.php"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm <?= $currentPage === 'about' ? 'text-emerald-400 bg-emerald-500/15' : 'text-white/70 hover:bg-white/5' ?>">
                    <i class="fas fa-users w-4"></i> Kelompok
                </a>
            </div>
        </div>
    </header>

    <!-- Identity Banner (Mobile + Tablet) -->
    <div class="lg:hidden relative z-10 bg-gradient-to-r from-emerald-900/60 to-teal-900/60 border-b border-emerald-500/15 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between">
            <div class="flex items-center gap-4 text-xs">
                <span class="text-emerald-400 font-semibold"><?= KELOMPOK_NAMA ?></span>
                <span class="text-white/40">•</span>
                <span class="text-white/60"><?= MATA_KULIAH ?></span>
            </div>
            <span class="text-white/40 text-xs hidden sm:block"><?= DOSEN ?></span>
        </div>
    </div>

    <!-- Main Content Wrapper -->
    <main class="relative z-10">
