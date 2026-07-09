-- ============================================================
-- Database: Panduan Sholat
-- Schema + Seed Data (migrasi dari config/data.php)
-- ============================================================

CREATE DATABASE IF NOT EXISTS `panduan_sholat`
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE `panduan_sholat`;

-- ============================================================
-- Tabel: gerakan_sholat
-- Menyimpan data gerakan sholat (11 gerakan)
-- ============================================================
DROP TABLE IF EXISTS `bacaan_sholat`;
DROP TABLE IF EXISTS `gerakan_sholat`;

CREATE TABLE `gerakan_sholat` (
    `id`                INT AUTO_INCREMENT PRIMARY KEY,
    `kode`              VARCHAR(10) NOT NULL UNIQUE COMMENT 'Kode unik gerakan, e.g. G01',
    `nama`              VARCHAR(100) NOT NULL COMMENT 'Nama gerakan sholat',
    `icon`              VARCHAR(50) NOT NULL DEFAULT '🕌' COMMENT 'Emoji icon',
    `warna`             VARCHAR(20) NOT NULL DEFAULT 'emerald' COMMENT 'Nama warna tema (Tailwind)',
    `gambar`            VARCHAR(255) DEFAULT NULL COMMENT 'Path gambar/SVG gerakan',
    `deskripsi_dewasa`  TEXT NOT NULL COMMENT 'Deskripsi untuk mode dewasa',
    `deskripsi_anak`    TEXT NOT NULL COMMENT 'Deskripsi untuk mode anak-anak',
    `urutan`            INT NOT NULL DEFAULT 0 COMMENT 'Urutan tampil (sorting)',
    `created_at`        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at`        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_urutan` (`urutan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Data gerakan-gerakan dalam sholat';

-- ============================================================
-- Tabel: bacaan_sholat
-- Menyimpan bacaan/doa untuk setiap gerakan
-- ============================================================
CREATE TABLE `bacaan_sholat` (
    `id`                INT AUTO_INCREMENT PRIMARY KEY,
    `gerakan_id`        INT NOT NULL COMMENT 'FK ke gerakan_sholat',
    `judul`             VARCHAR(150) NOT NULL COMMENT 'Judul bacaan',
    `arab`              TEXT NOT NULL COMMENT 'Teks Arab',
    `latin`             TEXT NOT NULL COMMENT 'Transliterasi Latin',
    `terjemah_dewasa`   TEXT NOT NULL COMMENT 'Terjemahan mode dewasa',
    `terjemah_anak`     TEXT NOT NULL COMMENT 'Terjemahan mode anak-anak',
    `audio_file`        VARCHAR(255) DEFAULT NULL COMMENT 'Path file audio MP3',
    `video_url`         VARCHAR(500) DEFAULT NULL COMMENT 'URL YouTube embed',
    `urutan`            INT NOT NULL DEFAULT 0 COMMENT 'Urutan tampil dalam gerakan',
    `created_at`        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at`        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_gerakan_urutan` (`gerakan_id`, `urutan`),
    CONSTRAINT `fk_bacaan_gerakan`
        FOREIGN KEY (`gerakan_id`) REFERENCES `gerakan_sholat`(`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Bacaan dan doa untuk setiap gerakan sholat';

-- ============================================================
-- SEED DATA: Gerakan Sholat
-- ============================================================
INSERT INTO `gerakan_sholat` (`id`, `kode`, `nama`, `icon`, `warna`, `gambar`, `deskripsi_dewasa`, `deskripsi_anak`, `urutan`) VALUES
(1,  'G01', 'Niat Sholat',              '🤲', 'emerald', 'assets/images/gerakan/niat.svg',
     'Niat adalah syarat sahnya sholat yang diucapkan di dalam hati bersamaan dengan takbiratul ihram.',
     'Niat artinya kita berjanji dalam hati mau sholat. Seperti bilang \"aku mau sholat nih!\" di dalam hati. 😊', 1),

(2,  'G02', 'Takbiratul Ihram',          '🙌', 'teal',    'assets/images/gerakan/takbir.svg',
     'Takbiratul ihram adalah gerakan mengangkat kedua tangan sejajar telinga atau bahu sambil mengucapkan \"Allahu Akbar\" sebagai tanda dimulainya sholat.',
     'Angkat kedua tangan ke atas sambil bilang \"Allahu Akbar!\" Artinya Allah Maha Besar! 🌟', 2),

(3,  'G03', 'Membaca Al-Fatihah',        '📖', 'green',   'assets/images/gerakan/fatihah.svg',
     'Membaca surah Al-Fatihah adalah rukun sholat yang wajib dibaca pada setiap rakaat.',
     'Kita baca surah Al-Fatihah di setiap rakaat. Ini adalah surah pertama di Al-Quran! 📚', 3),

(4,  'G04', 'Membaca Surah Pendek',      '📜', 'cyan',    'assets/images/gerakan/surah.svg',
     'Setelah Al-Fatihah, disunnahkan membaca surah atau ayat Al-Quran. Pada rakaat pertama dan kedua.',
     'Setelah Al-Fatihah, kita baca surah lain dari Al-Quran. Misalnya surah Al-Ikhlas yang pendek! 📝', 4),

(5,  'G05', 'Ruku\'',                    '🙇', 'blue',    'assets/images/gerakan/ruku.svg',
     'Ruku\' adalah membungkukkan badan hingga punggung sejajar dengan lantai, kedua tangan memegang lutut, pandangan ke tempat sujud.',
     'Membungkuk dengan punggung lurus seperti meja! Tangan pegang lutut. Sambil bilang pujian untuk Allah! 🙇', 5),

(6,  'G06', 'I\'tidal',                  '🧍', 'violet',  'assets/images/gerakan/itidal.svg',
     'I\'tidal adalah berdiri tegak kembali setelah ruku\', sambil mengangkat kedua tangan sejajar telinga.',
     'Berdiri tegak lagi setelah membungkuk! Angkat tangan dan puji Allah! 🙋', 6),

(7,  'G07', 'Sujud',                     '🤸', 'indigo',  'assets/images/gerakan/sujud.svg',
     'Sujud dilakukan dengan meletakkan dahi, hidung, kedua telapak tangan, kedua lutut, dan ujung jari kaki di lantai. Tujuh anggota badan menyentuh lantai.',
     'Kita menunduk sampai dahi, hidung, tangan, lutut, dan jari kaki menyentuh lantai. Ini gerakan paling dekat dengan Allah! 🌙', 7),

(8,  'G08', 'Duduk Antara Dua Sujud',    '🪑', 'amber',   'assets/images/gerakan/duduk-sujud.svg',
     'Duduk iftirasy (duduk di atas kaki kiri) di antara dua sujud sambil membaca do\'a.',
     'Duduk sebentar di antara dua sujud. Minta ampun dan minta kebaikan kepada Allah! 🙏', 8),

(9,  'G09', 'Tasyahud Awal',             '☝️', 'orange',  'assets/images/gerakan/tasyahud.svg',
     'Tasyahud awal dilakukan pada rakaat kedua (untuk sholat 3 atau 4 rakaat) dengan duduk iftirasy sambil membaca tasyahud dan shalawat.',
     'Di rakaat kedua kita duduk dan baca tasyahud. Jari telunjuk menunjuk ke atas tanda kita percaya Allah satu! ☝️', 9),

(10, 'G10', 'Tasyahud Akhir',            '🤲', 'rose',    'assets/images/gerakan/tasyahud-akhir.svg',
     'Tasyahud akhir dilakukan di rakaat terakhir dengan duduk tawarruk (duduk di atas lantai, kaki kiri dimasukkan ke bawah kaki kanan) sambil membaca tasyahud dan shalawat Ibrahim.',
     'Di rakaat terakhir, kita duduk dan baca tasyahud lagi. Ditambah do\'a shalawat untuk Nabi Ibrahim dan Nabi Muhammad! 💚', 10),

(11, 'G11', 'Salam',                     '👋', 'pink',    'assets/images/gerakan/salam.svg',
     'Salam adalah gerakan menolehkan kepala ke kanan lalu ke kiri sambil mengucapkan salam. Ini menandakan berakhirnya sholat.',
     'Menoleh ke kanan dan kiri sambil bilang salam. Ini tandanya sholat kita sudah selesai! 🎉', 11);

-- ============================================================
-- SEED DATA: Bacaan Sholat
-- ============================================================
INSERT INTO `bacaan_sholat` (`gerakan_id`, `judul`, `arab`, `latin`, `terjemah_dewasa`, `terjemah_anak`, `audio_file`, `video_url`, `urutan`) VALUES

-- G01: Niat Sholat
(1, 'Niat Sholat Subuh (2 Rakaat)',
    'أُصَلِّي فَرْضَ الصُّبْحِ رَكْعَتَيْنِ مُسْتَقْبِلَ الْقِبْلَةِ أَدَاءً لِلَّهِ تَعَالَى',
    'Ushalli fardlash shubhi rak\'ataini mustaqbilal qiblati adaa\'an lillahi ta\'ala',
    'Saya berniat sholat fardhu Subuh dua rakaat menghadap kiblat karena Allah Ta\'ala.',
    'Aku mau sholat Subuh 2 rakaat menghadap kiblat karena Allah. ☀️',
    'assets/audio/niat-subuh.mp3',
    'https://www.youtube.com/embed/LH4Te_KiILY', 1),

-- G02: Takbiratul Ihram (digabung — satu rekaman audio mencakup Takbir + Do'a Iftitah)
(2, "Takbir & Do'a Iftitah",
    'اللَّهُ أَكْبَرُ\n\nاللَّهُمَّ بَاعِدْ بَيْنِي وَبَيْنَ خَطَايَايَ كَمَا بَاعَدْتَ بَيْنَ الْمَشْرِقِ وَالْمَغْرِبِ، اللَّهُمَّ نَقِّنِي مِنْ خَطَايَايَ كَمَا يُنَقَّى الثَّوْبُ الْأَبْيَضُ مِنَ الدَّنَسِ',
    'Allahu Akbar. Allahumma baa\'id baini wa baina khatayaaya kamaa baa\'adta bainal masyriqi wal maghrib. Allahumma naqqini min khatayaaya kamash tsawbul abyadlu minad danas',
    'Allah Maha Besar. Ya Allah, jauhkanlah antara aku dan kesalahan-kesalahanku sebagaimana Engkau telah menjauhkan antara timur dan barat. Ya Allah, bersihkanlah aku dari kesalahan-kesalahanku sebagaimana baju putih dibersihkan dari kotoran.',
    'Allah Maha Besar! Ya Allah, bersihkan aku dari kesalahan seperti baju putih yang dicuci bersih! 🧼',
    'assets/audio/takbir-iftitah.mp3',
    'https://www.youtube.com/embed/LH4Te_KiILY', 1),

-- G03: Membaca Al-Fatihah (digabung — satu rekaman audio mencakup Ta'awudz + Basmalah + Al-Fatihah)
(3, "Ta'awudz, Basmalah & Al-Fatihah",
    'أَعُوذُ بِاللَّهِ مِنَ الشَّيْطَانِ الرَّجِيمِ\n\nبِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ\n\nالْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ ۝ الرَّحْمَٰنِ الرَّحِيمِ ۝ مَالِكِ يَوْمِ الدِّينِ ۝ إِيَّاكَ نَعْبُدُ وَإِيَّاكَ نَسْتَعِينُ ۝ اهْدِنَا الصِّرَاطَ الْمُسْتَقِيمَ ۝ صِرَاطَ الَّذِينَ أَنْعَمْتَ عَلَيْهِمْ غَيْرِ الْمَغْضُوبِ عَلَيْهِمْ وَلَا الضَّالِّينَ',
    'A\'uudzu billaahi minasy syaithaanir rajiim. Bismillahir rahmaanir rahiim. Alhamdu lillaahi rabbil \'aalamiin. Ar rahmaanir rahiim. Maaliki yaumid diin. Iyyaaka na\'budu wa iyyaaka nasta\'iin. Ihdinash shiraathal mustaqiim. Shiraathal ladziina an\'amta \'alaihim ghairil maghdluubi \'alaihim wa lad dlaalliin.',
    'Aku berlindung kepada Allah dari godaan setan yang terkutuk. Dengan menyebut nama Allah Yang Maha Pengasih lagi Maha Penyayang. Segala puji bagi Allah, Tuhan seluruh alam. Yang Maha Pengasih, Maha Penyayang. Pemilik hari pembalasan. Hanya kepada Engkaulah kami menyembah dan hanya kepada Engkaulah kami mohon pertolongan. Tunjukilah kami jalan yang lurus. Yaitu jalan orang-orang yang telah Engkau beri nikmat kepadanya; bukan (jalan) mereka yang dimurkai, dan bukan (pula jalan) mereka yang sesat.',
    'Aku minta perlindungan Allah dari setan jahat! Dengan nama Allah yang baik hati dan penyayang! Semua pujian untuk Allah. Allah sangat baik dan sayang. Allah yang punya hari akhir. Kami hanya minta tolong ke Allah. Tunjukkanlah kami jalan yang benar ya Allah! 🌈',
    'assets/audio/alfatihah.mp3',
    'https://www.youtube.com/embed/LH4Te_KiILY', 1),

-- G04: Membaca Surah Pendek
(4, 'Surah Al-Ikhlas',
    'قُلْ هُوَ اللَّهُ أَحَدٌ ۝ اللَّهُ الصَّمَدُ ۝ لَمْ يَلِدْ وَلَمْ يُولَدْ ۝ وَلَمْ يَكُن لَّهُ كُفُوًا أَحَدٌ',
    'Qul huwallaahu ahad. Allaahush shamad. Lam yalid wa lam yuulad. Wa lam yakul lahu kufuwan ahad.',
    'Katakanlah (Muhammad), \"Dialah Allah, Yang Maha Esa. Allah tempat meminta segala sesuatu. (Allah) tidak beranak dan tidak pula diperanakkan. Dan tidak ada sesuatu yang setara dengan Dia.\"',
    'Allah itu satu, tidak ada yang seperti Allah! Allah tempat kita minta-minta. Allah tidak punya anak dan tidak dilahirkan. 🌟',
    'assets/audio/al-ikhlas.mp3',
    'https://www.youtube.com/embed/LH4Te_KiILY', 1),

-- G05: Ruku'
(5, 'Bacaan Ruku\'',
    'سُبْحَانَ رَبِّيَ الْعَظِيمِ',
    'Subhaana rabbiyal azhiim',
    'Maha Suci Tuhanku Yang Maha Agung.',
    'Allah Tuhanku Maha Suci dan Maha Besar! ✨',
    'assets/audio/ruku.mp3',
    'https://www.youtube.com/embed/LH4Te_KiILY', 1),

-- G06: I'tidal (digabung — satu rekaman audio mencakup kedua bacaan)
(6, "Sami'allahu liman hamidah & Bacaan I'tidal",
    'سَمِعَ اللَّهُ لِمَنْ حَمِدَهُ\n\nرَبَّنَا وَلَكَ الْحَمْدُ حَمْدًا كَثِيرًا طَيِّبًا مُبَارَكًا فِيهِ',
    'Sami\'allaahu liman hamidah. Rabbanaa wa lakal hamdu hamdan katsiiran thayyiban mubaarakan fiih',
    'Allah Maha Mendengar orang yang memuji-Nya. Wahai Tuhan kami, bagi-Mu segala puji, pujian yang banyak, yang baik, dan penuh keberkahan.',
    'Allah mendengar kita yang memuji-Nya! Ya Allah, semua pujian hanya untuk-Mu, pujian yang banyak dan penuh berkah! 🌺',
    'assets/audio/itidal.mp3',
    NULL, 1),

-- G07: Sujud
(7, 'Bacaan Sujud',
    'سُبْحَانَ رَبِّيَ الْأَعْلَى',
    'Subhaana rabbiyal a\'la',
    'Maha Suci Tuhanku Yang Maha Tinggi.',
    'Allah Tuhanku Maha Suci dan Maha Tinggi! ⭐',
    'assets/audio/sujud.mp3',
    'https://www.youtube.com/embed/LH4Te_KiILY', 1),

-- G08: Duduk Antara Dua Sujud
(8, 'Bacaan Duduk Antara Dua Sujud',
    'رَبِّ اغْفِرْ لِي وَارْحَمْنِي وَاجْبُرْنِي وَارْفَعْنِي وَارْزُقْنِي وَاهْدِنِي وَعَافِنِي وَاعْفُ عَنِّي',
    'Rabbighfir lii warhamnii wajburnii warfa\'nii warzuqnii wahdinii wa\'aafinii wa\'fu \'annii',
    'Ya Tuhanku, ampunilah aku, rahmatilah aku, cukupkanlah aku, angkatlah derajatku, berilah aku rezeki, tunjukilah aku, sehatkanlah aku, dan maafkanlah aku.',
    'Ya Allah, maafkan aku, sayangi aku, beri aku rezeki, tunjukkan jalan yang benar, dan beri aku kesehatan! 💝',
    'assets/audio/duduk-sujud.mp3',
    'https://www.youtube.com/embed/LH4Te_KiILY', 1),

-- G09: Tasyahud Awal
(9, 'Tasyahud Awal',
    'التَّحِيَّاتُ الْمُبَارَكَاتُ الصَّلَوَاتُ الطَّيِّبَاتُ لِلَّهِ، السَّلَامُ عَلَيْكَ أَيُّهَا النَّبِيُّ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ، السَّلَامُ عَلَيْنَا وَعَلَى عِبَادِ اللَّهِ الصَّالِحِينَ، أَشْهَدُ أَنْ لَا إِلَهَ إِلَّا اللَّهُ وَأَشْهَدُ أَنَّ مُحَمَّدًا رَسُولُ اللَّهِ',
    'At-tahiyyaatul mubaarakaatush shalawaatuth thayyibaatu lillaah. As-salaamu \'alaika ayyuhan nabiyyu wa rahmatullahi wa barakaatuh. As-salaamu \'alainaa wa \'alaa \'ibaadillahish shaalihiin. Asyhadu allaa ilaaha illallah, wa asyhadu anna muhammadar rasuulullah.',
    'Segala kehormatan, keberkahan, shalawat, dan kebaikan adalah milik Allah. Semoga keselamatan terlimpah kepadamu wahai Nabi, serta rahmat Allah dan keberkahan-Nya. Semoga keselamatan juga terlimpah kepada kami dan hamba-hamba Allah yang shalih. Aku bersaksi bahwa tiada tuhan selain Allah, dan aku bersaksi bahwa Muhammad adalah utusan Allah.',
    'Semua kebaikan untuk Allah. Salam untuk Nabi Muhammad. Aku berjanji Allah itu satu dan Nabi Muhammad adalah utusan Allah! 🌟',
    'assets/audio/tasyahud-awal.mp3',
    'https://www.youtube.com/embed/LH4Te_KiILY', 1),

-- G10: Tasyahud Akhir
(10, 'Tasyahud Akhir',
    'التَّحِيَّاتُ الْمُبَارَكَاتُ الصَّلَوَاتُ الطَّيِّبَاتُ لِلَّهِ، السَّلَامُ عَلَيْكَ أَيُّهَا النَّبِيُّ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ، السَّلَامُ عَلَيْنَا وَعَلَى عِبَادِ اللَّهِ الصَّالِحِينَ، أَشْهَدُ أَنْ لَا إِلَهَ إِلَّا اللَّهُ وَأَشْهَدُ أَنَّ مُحَمَّدًا رَسُولُ اللَّهِ',
    'At-tahiyyaatul mubaarakaatush shalawaatuth thayyibaatu lillaah. As-salaamu \'alaika ayyuhan nabiyyu wa rahmatullahi wa barakaatuh. As-salaamu \'alainaa wa \'alaa \'ibaadillahish shaalihiin. Asyhadu allaa ilaaha illallah, wa asyhadu anna muhammadar rasuulullah.',
    'Segala kehormatan, keberkahan, shalawat, dan kebaikan adalah milik Allah. Semoga keselamatan terlimpah kepadamu wahai Nabi, serta rahmat Allah dan keberkahan-Nya. Semoga keselamatan juga terlimpah kepada kami dan hamba-hamba Allah yang shalih. Aku bersaksi bahwa tiada tuhan selain Allah, dan aku bersaksi bahwa Muhammad adalah utusan Allah.',
    'Seperti tasyahud awal, tapi di sini kita juga baca do\'a shalawat yang panjang! 🌺',
    'assets/audio/tasyahud-akhir.mp3',
    NULL, 1),

(10, 'Shalawat Ibrahim',
    'اللَّهُمَّ صَلِّ عَلَى مُحَمَّدٍ وَعَلَى آلِ مُحَمَّدٍ كَمَا صَلَّيْتَ عَلَى إِبْرَاهِيمَ وَعَلَى آلِ إِبْرَاهِيمَ، وَبَارِكْ عَلَى مُحَمَّدٍ وَعَلَى آلِ مُحَمَّدٍ كَمَا بَارَكْتَ عَلَى إِبْرَاهِيمَ وَعَلَى آلِ إِبْرَاهِيمَ، إِنَّكَ حَمِيدٌ مَجِيدٌ',
    'Allaahumma shalli \'alaa muhammadin wa \'alaa aali muhammadin kamaa shallaita \'alaa ibraahiima wa \'alaa aali ibraahiima. Wa baarik \'alaa muhammadin wa \'alaa aali muhammadin kamaa baarakta \'alaa ibraahiima wa \'alaa aali ibraahiima. Innaka hamiidum majiid.',
    'Ya Allah, berikanlah shalawat kepada Muhammad dan keluarganya, sebagaimana Engkau telah memberikan shalawat kepada Ibrahim dan keluarganya. Dan berkahilah Muhammad dan keluarganya, sebagaimana Engkau telah memberkahi Ibrahim dan keluarganya. Sesungguhnya Engkau Maha Terpuji lagi Maha Mulia.',
    'Ya Allah, berikan kebaikan untuk Nabi Muhammad seperti Engkau memberi kebaikan kepada Nabi Ibrahim! 🌹',
    'assets/audio/shalawat-ibrahim.mp3',
    NULL, 2),

-- G11: Salam
(11, 'Salam Kanan',
    'السَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللَّهِ',
    'As-salaamu \'alaikum wa rahmatullahi',
    'Semoga keselamatan dan rahmat Allah terlimpah kepada kalian.',
    'Semoga kalian selamat dan dapat rahmat Allah! (menoleh ke kanan) 😊',
    'assets/audio/salam.mp3',
    'https://www.youtube.com/embed/LH4Te_KiILY', 1),

(11, 'Salam Kiri',
    'السَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللَّهِ',
    'As-salaamu \'alaikum wa rahmatullahi',
    'Semoga keselamatan dan rahmat Allah terlimpah kepada kalian.',
    'Semoga kalian selamat dan dapat rahmat Allah! (menoleh ke kiri) 😊',
    'assets/audio/salam.mp3',
    NULL, 2);
