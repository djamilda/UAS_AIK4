<?php
/**
 * Data Gerakan dan Bacaan Sholat
 * Mengambil data dari database MySQL (F-09)
 * Fallback ke data statis jika database belum tersedia
 */

define('APP_NAME', 'Panduan Sholat');
define('KELOMPOK_NAMA', 'Kelompok 5');
define('PRODI', 'Sistem informasi');
define('MATA_KULIAH', 'AIK4');
define('DOSEN', 'Dedi Susanto, Spd.I., M.M.');

// Define BASE_URL dynamically
if (!defined('BASE_URL')) {
    $project_dir = str_replace('\\', '/', dirname(__DIR__));
    $doc_root = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'], '/'));
    $base_path = str_replace($doc_root, '', $project_dir);
    define('BASE_URL', $base_path . '/');
}

// ============================================================
// Coba ambil data dari database
// ============================================================
require_once __DIR__ . '/functions.php';

try {
    if (isDatabaseAvailable()) {
        // Ambil data dari database (format backward compatible)
        $gerakanSholat = getAllGerakanFormatted();
        // Jika database kosong, gunakan fallback statis agar daftar tetap muncul
        if (empty($gerakanSholat)) {
            $gerakanSholat = getStaticData();
        }
    } else {
        // Fallback ke data statis
        $gerakanSholat = getStaticData();
    }
} catch (Exception $e) {
    // Jika ada error, fallback ke data statis
    $gerakanSholat = getStaticData();
}

// ============================================================
// Data statis sebagai fallback jika database belum di-setup
// ============================================================
function getStaticData() {
    return [
        [
            'id'         => 1,
            'kode'       => 'G01',
            'nama'       => 'Niat Sholat',
            'icon'       => '🤲',
            'warna'      => 'emerald',
            'gambar'     => 'assets/images/gerakan/niat.svg',
            'deskripsi'  => [
                'dewasa' => 'Niat adalah syarat sahnya sholat yang diucapkan di dalam hati bersamaan dengan takbiratul ihram.',
                'anak'   => 'Niat artinya kita berjanji dalam hati mau sholat. Seperti bilang "aku mau sholat nih!" di dalam hati. 😊',
            ],
            'bacaan'     => [
                [
                    'judul'    => 'Niat Sholat Subuh (2 Rakaat)',
                    'arab'     => 'أُصَلِّي فَرْضَ الصُّبْحِ رَكْعَتَيْنِ مُسْتَقْبِلَ الْقِبْلَةِ أَدَاءً لِلَّهِ تَعَالَى',
                    'latin'    => 'Ushalli fardlash shubhi rak\'ataini mustaqbilal qiblati adaa\'an lillahi ta\'ala',
                    'terjemah' => [
                        'dewasa' => 'Saya berniat sholat fardhu Subuh dua rakaat menghadap kiblat karena Allah Ta\'ala.',
                        'anak'   => 'Aku mau sholat Subuh 2 rakaat menghadap kiblat karena Allah. ☀️',
                    ],
                    'audio'    => 'assets/audio/niat-subuh.mp3',
                    'video'    => 'assets/videos/niat-iftitah.mp4',
                ]
            ]
        ],
        [
            'id'         => 2,
            'kode'       => 'G02',
            'nama'       => 'Takbiratul Ihram',
            'icon'       => '🙌',
            'warna'      => 'teal',
            'gambar'     => 'assets/images/gerakan/takbir.svg',
            'deskripsi'  => [
                'dewasa' => 'Takbiratul ihram adalah gerakan mengangkat kedua tangan sejajar telinga atau bahu sambil mengucapkan "Allahu Akbar" sebagai tanda dimulainya sholat.',
                'anak'   => 'Angkat kedua tangan ke atas sambil bilang "Allahu Akbar!" Artinya Allah Maha Besar! 🌟',
            ],
            'bacaan'     => [
                [
                    'judul'    => "Takbir & Do'a Iftitah",
                    'arab'     => 'اللَّهُ أَكْبَرُ\n\nاللَّهُمَّ بَاعِدْ بَيْنِي وَبَيْنَ خَطَايَايَ كَمَا بَاعَدْتَ بَيْنَ الْمَشْرِقِ وَالْمَغْرِبِ، اللَّهُمَّ نَقِّنِي مِنْ خَطَايَايَ كَمَا يُنَقَّى الثَّوْبُ الْأَبْيَضُ مِنَ الدَّنَسِ',
                    'latin'    => 'Allahu Akbar. Allahumma baa\'id baini wa baina khatayaaya kamaa baa\'adta bainal masyriqi wal maghrib. Allahumma naqqini min khatayaaya kamash tsawbul abyadlu minad danas',
                    'terjemah' => [
                        'dewasa' => 'Ya Allah, aku mengucapkan takbir sebagai tanda memulai sholat dan memohon agar Engkau menjauhkan aku dari dosa-dosaku sebagaimana Engkau menjauhkan timur dan barat. Berikanlah aku hati yang bersih seperti baju putih yang dicuci bersih.',
                        'anak'   => 'Ya Allah, aku mengucapkan Takbir dan minta tolong agar Engkau jauhkan aku dari kesalahan, seperti baju putih yang dicuci jadi bersih! 🌟',
                    ],
                    'audio' => 'assets/audio/takbir-iftitah.mp3',
                    'video'    => 'assets/videos/niat-iftitah.mp4',
                ]
            ]
        ],
        [
            'id'         => 3,
            'kode'       => 'G03',
            'nama'       => 'Membaca Al-Fatihah',
            'icon'       => '📖',
            'warna'      => 'green',
            'gambar'     => 'assets/images/gerakan/fatihah.svg',
            'deskripsi'  => [
                'dewasa' => 'Membaca surah Al-Fatihah adalah rukun sholat yang wajib dibaca pada setiap rakaat.',
                'anak'   => 'Kita baca surah Al-Fatihah di setiap rakaat. Ini adalah surah pertama di Al-Quran! 📚',
            ],
            'bacaan'     => [
                [
                    'judul'    => "Ta'awudz, Basmalah & Al-Fatihah",
                    'arab'     => 'أَعُوذُ بِاللَّهِ مِنَ الشَّيْطَانِ الرَّجِيمِ\n\nبِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ\n\nالْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ ۝ الرَّحْمَٰنِ الرَّحِيمِ ۝ مَالِكِ يَوْمِ الدِّينِ ۝ إِيَّاكَ نَعْبُدُ وَإِيَّاكَ نَسْتَعِينُ ۝ اهْدِنَا الصِّرَاطَ الْمُسْتَقِيمَ ۝ صِرَاطَ الَّذِينَ أَنْعَمْتَ عَلَيْهِمْ غَيْرِ الْمَغْضُوبِ عَلَيْهِمْ وَلَا الضَّالِّينَ',
                    'latin'    => 'A\'uudzu billaahi minasy syaithaanir rajiim. Bismillahir rahmaanir rahiim. Alhamdu lillaahi rabbil \'aalamiin. Ar rahmaanir rahiim. Maaliki yaumid diin. Iyyaaka na\'budu wa iyyaaka nasta\'iin. Ihdinash shiraathal mustaqiim. Shiraathal ladziina an\'amta \'alaihim ghairil maghdluubi \'alaihim wa lad dlaalliin.',
                    'terjemah' => [
                        'dewasa' => 'Aku berlindung kepada Allah dari godaan setan yang terkutuk. Dengan menyebut nama Allah Yang Maha Pengasih lagi Maha Penyayang. Segala puji bagi Allah, Tuhan seluruh alam. Yang Maha Pengasih, Maha Penyayang. Pemilik hari pembalasan. Hanya kepada Engkaulah kami menyembah dan hanya kepada Engkaulah kami mohon pertolongan. Tunjukilah kami jalan yang lurus. Yaitu jalan orang-orang yang telah Engkau beri nikmat kepadanya; bukan (jalan) mereka yang dimurkai, dan bukan (pula jalan) mereka yang sesat.',
                        'anak'   => 'Aku minta perlindungan Allah dari setan jahat! Dengan nama Allah yang baik hati dan penyayang! Semua pujian untuk Allah. Allah sangat baik dan sayang. Allah yang punya hari akhir. Kami hanya minta tolong ke Allah. Tunjukkanlah kami jalan yang benar ya Allah! 🌈',
                    ],
                    'audio'    => 'assets/audio/alfatihah.mp3',
                    'video'    => 'assets/videos/alfatihah-al-ikhlas.mp4',
                ]
            ]
        ],
        [
            'id'         => 4,
            'kode'       => 'G04',
            'nama'       => "Membaca Surah Pendek",
            'icon'       => '📜',
            'warna'      => 'cyan',
            'gambar'     => 'assets/images/gerakan/surah.svg',
            'deskripsi'  => [
                'dewasa' => 'Setelah Al-Fatihah, disunnahkan membaca surah atau ayat Al-Quran. Pada rakaat pertama dan kedua.',
                'anak'   => 'Setelah Al-Fatihah, kita baca surah lain dari Al-Quran. Misalnya surah Al-Ikhlas yang pendek! 📝',
            ],
            'bacaan'     => [
                [
                    'judul'    => 'Surah Al-Ikhlas',
                    'arab'     => 'قُلْ هُوَ اللَّهُ أَحَدٌ ۝ اللَّهُ الصَّمَدُ ۝ لَمْ يَلِدْ وَلَمْ يُولَدْ ۝ وَلَمْ يَكُن لَّهُ كُفُوًا أَحَدٌ',
                    'latin'    => 'Qul huwallaahu ahad. Allaahush shamad. Lam yalid wa lam yuulad. Wa lam yakul lahu kufuwan ahad.',
                    'terjemah' => [
                        'dewasa' => 'Katakanlah (Muhammad), "Dialah Allah, Yang Maha Esa. Allah tempat meminta segala sesuatu. (Allah) tidak beranak dan tidak pula diperanakkan. Dan tidak ada sesuatu yang setara dengan Dia."',
                        'anak'   => 'Allah itu satu, tidak ada yang seperti Allah! Allah tempat kita minta-minta. Allah tidak punya anak dan tidak dilahirkan. 🌟',
                    ],
                    'audio'    => 'assets/audio/al-ikhlas.mp3',
                    'video'    => 'assets/videos/alfatihah-al-ikhlas.mp4',
                ]
            ]
        ],
        [
            'id'         => 5,
            'kode'       => 'G05',
            'nama'       => "Ruku'",
            'icon'       => '🙇',
            'warna'      => 'blue',
            'gambar'     => 'assets/images/gerakan/ruku.svg',
            'deskripsi'  => [
                'dewasa' => 'Ruku\' adalah membungkukkan badan hingga punggung sejajar dengan lantai, kedua tangan memegang lutut, pandangan ke tempat sujud.',
                'anak'   => 'Membungkuk dengan punggung lurus seperti meja! Tangan pegang lutut. Sambil bilang pujian untuk Allah! 🙇',
            ],
            'bacaan'     => [
                [
                    'judul'    => "Bacaan Ruku'",
                    'arab'     => 'سُبْحَانَ رَبِّيَ الْعَظِيمِ',
                    'latin'    => 'Subhaana rabbiyal azhiim',
                    'terjemah' => [
                        'dewasa' => 'Maha Suci Tuhanku Yang Maha Agung.',
                        'anak'   => 'Allah Tuhanku Maha Suci dan Maha Besar! ✨',
                    ],
                    'audio'    => 'assets/audio/ruku.mp3',
                    'video'    => 'assets/videos/ruku.mp4',
                ]
            ]
        ],
        [
            'id'         => 6,
            'kode'       => 'G06',
            'nama'       => "I'tidal",
            'icon'       => '🧍',
            'warna'      => 'violet',
            'gambar'     => 'assets/images/gerakan/itidal.svg',
            'deskripsi'  => [
                'dewasa' => 'I\'tidal adalah berdiri tegak kembali setelah ruku\', sambil mengangkat kedua tangan sejajar telinga.',
                'anak'   => 'Berdiri tegak lagi setelah membungkuk! Angkat tangan dan puji Allah! 🙋',
            ],
            'bacaan'     => [
                [
                    'judul'    => "Sami'allahu liman hamidah & Bacaan I'tidal",
                    'arab'     => 'سَمِعَ اللَّهُ لِمَنْ حَمِدَهُ\n\nرَبَّنَا وَلَكَ الْحَمْدُ حَمْدًا كَثِيرًا طَيِّبًا مُبَارَكًا فِيهِ',
                    'latin'    => 'Sami\'allaahu liman hamidah. Rabbanaa wa lakal hamdu hamdan katsiiran thayyiban mubaarakan fiih',
                    'terjemah' => [
                        'dewasa' => 'Allah Maha Mendengar orang yang memuji-Nya. Wahai Tuhan kami, bagi-Mu segala puji, pujian yang banyak, yang baik, dan penuh keberkahan.',
                        'anak'   => 'Allah mendengar kita yang memuji-Nya! Ya Allah, semua pujian hanya untuk-Mu, pujian yang banyak dan penuh berkah! 🌺',
                    ],
                    'audio'    => 'assets/audio/itidal.mp3',
                    'video'    => 'assets/videos/takbiratulihram.mp4',
                ]
            ]
        ],
        [
            'id'         => 7,
            'kode'       => 'G07',
            'nama'       => 'Sujud',
            'icon'       => '🤸',
            'warna'      => 'indigo',
            'gambar'     => 'assets/images/gerakan/sujud.svg',
            'deskripsi'  => [
                'dewasa' => 'Sujud dilakukan dengan meletakkan dahi, hidung, kedua telapak tangan, kedua lutut, dan ujung jari kaki di lantai. Tujuh anggota badan menyentuh lantai.',
                'anak'   => 'Kita menunduk sampai dahi, hidung, tangan, lutut, dan jari kaki menyentuh lantai. Ini gerakan paling dekat dengan Allah! 🌙',
            ],
            'bacaan'     => [
                [
                    'judul'    => 'Bacaan Sujud',
                    'arab'     => 'سُبْحَانَ رَبِّيَ الْأَعْلَى',
                    'latin'    => 'Subhaana rabbiyal a\'la',
                    'terjemah' => [
                        'dewasa' => 'Maha Suci Tuhanku Yang Maha Tinggi.',
                        'anak'   => 'Allah Tuhanku Maha Suci dan Maha Tinggi! ⭐',
                    ],
                    'audio'    => 'assets/audio/sujud.mp3',
                    'video'    => 'assets/videos/sujud.mp4',
                ]
            ]
        ],
        [
            'id'         => 8,
            'kode'       => 'G08',
            'nama'       => 'Duduk Antara Dua Sujud',
            'icon'       => '🪑',
            'warna'      => 'amber',
            'gambar'     => 'assets/images/gerakan/duduk-sujud.svg',
            'deskripsi'  => [
                'dewasa' => 'Duduk iftirasy (duduk di atas kaki kiri) di antara dua sujud sambil membaca do\'a.',
                'anak'   => 'Duduk sebentar di antara dua sujud. Minta ampun dan minta kebaikan kepada Allah! 🙏',
            ],
            'bacaan'     => [
                [
                    'judul'    => 'Bacaan Duduk Antara Dua Sujud',
                    'arab'     => 'رَبِّ اغْفِرْ لِي وَارْحَمْنِي وَاجْبُرْنِي وَارْفَعْنِي وَارْزُقْنِي وَاهْدِنِي وَعَافِنِي وَاعْفُ عَنِّي',
                    'latin'    => 'Rabbighfir lii warhamnii wajburnii warfa\'nii warzuqnii wahdinii wa\'aafinii wa\'fu \'annii',
                    'terjemah' => [
                        'dewasa' => 'Ya Tuhanku, ampunilah aku, rahmatilah aku, cukupkanlah aku, angkatlah derajatku, berilah aku rezeki, tunjukilah aku, sehatkanlah aku, dan maafkanlah aku.',
                        'anak'   => 'Ya Allah, maafkan aku, sayangi aku, beri aku rezeki, tunjukkan jalan yang benar, dan beri aku kesehatan! 💝',
                    ],
                    'audio'    => 'assets/audio/duduk-antara2sujud.mp3',
                    'video'    => 'assets/videos/duduk-2-sujud.mp4',
                ]
            ]
        ],
        [
            'id'         => 9,
            'kode'       => 'G09',
            'nama'       => 'Tasyahud Awal',
            'icon'       => '☝️',
            'warna'      => 'orange',
            'gambar'     => 'assets/images/gerakan/tasyahud.svg',
            'deskripsi'  => [
                'dewasa' => 'Tasyahud awal dilakukan pada rakaat kedua (untuk sholat 3 atau 4 rakaat) dengan duduk iftirasy sambil membaca tasyahud dan shalawat.',
                'anak'   => 'Di rakaat kedua kita duduk dan baca tasyahud. Jari telunjuk menunjuk ke atas tanda kita percaya Allah satu! ☝️',
            ],
            'bacaan'     => [
                [
                    'judul'    => 'Tasyahud Awal',
                    'arab'     => 'التَّحِيَّاتُ الْمُبَارَكَاتُ الصَّلَوَاتُ الطَّيِّبَاتُ لِلَّهِ، السَّلَامُ عَلَيْكَ أَيُّهَا النَّبِيُّ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ، السَّلَامُ عَلَيْنَا وَعَلَى عِبَادِ اللَّهِ الصَّالِحِينَ، أَشْهَدُ أَنْ لَا إِلَهَ إِلَّا اللَّهُ وَأَشْهَدُ أَنَّ مُحَمَّدًا رَسُولُ اللَّهِ',
                    'latin'    => 'At-tahiyyaatul mubaarakaatush shalawaatuth thayyibaatu lillaah. As-salaamu \'alaika ayyuhan nabiyyu wa rahmatullahi wa barakaatuh. As-salaamu \'alainaa wa \'alaa \'ibaadillahish shaalihiin. Asyhadu allaa ilaaha illallah, wa asyhadu anna muhammadar rasuulullah.',
                    'terjemah' => [
                        'dewasa' => 'Segala kehormatan, keberkahan, shalawat, dan kebaikan adalah milik Allah. Semoga keselamatan terlimpah kepadamu wahai Nabi, serta rahmat Allah dan keberkahan-Nya. Semoga keselamatan juga terlimpah kepada kami dan hamba-hamba Allah yang shalih. Aku bersaksi bahwa tiada tuhan selain Allah, dan aku bersaksi bahwa Muhammad adalah utusan Allah.',
                        'anak'   => 'Semua kebaikan untuk Allah. Salam untuk Nabi Muhammad. Aku berjanji Allah itu satu dan Nabi Muhammad adalah utusan Allah! 🌟',
                    ],
                    'audio'    => 'assets/audio/tahiyatawal.mp3',
                    'video'    => 'assets/videos/attahiyat-awal.mp4',
                ]
            ]
        ],
        [
            'id'         => 10,
            'kode'       => 'G10',
            'nama'       => 'Tasyahud Akhir & Shalawat Ibrahim',
            'icon'       => '🤲',
            'warna'      => 'rose',
            'gambar'     => 'assets/images/gerakan/tasyahud-akhir.svg',
            'deskripsi'  => [
                'dewasa' => 'Tasyahud akhir dilakukan di rakaat terakhir dengan duduk tawarruk (duduk di atas lantai, kaki kiri dimasukkan ke bawah kaki kanan) sambil membaca tasyahud dan dilanjutkan dengan shalawat Ibrahim.',
                'anak'   => 'Di rakaat terakhir, kita duduk dan baca tasyahud lagi. Ditambah do\'a shalawat untuk Nabi Ibrahim dan Nabi Muhammad! 💚',
            ],
            'bacaan'     => [
                [
                    'judul'    => 'Tasyahud Akhir & Shalawat Ibrahim',
                    'arab'     => "التَّحِيَّاتُ الْمُبَارَكَاتُ الصَّلَوَاتُ الطَّيِّبَاتُ لِلَّهِ، السَّلَامُ عَلَيْكَ أَيُّهَا النَّبِيُّ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ، السَّلَامُ عَلَيْنَا وَعَلَى عِبَادِ اللَّهِ الصَّالِحِينَ، أَشْهَدُ أَنْ لَا إِلَهَ إِلَّا اللَّهُ وَأَشْهَدُ أَنَّ مُحَمَّدًا رَسُولُ اللَّهِ\n\nاللَّهُمَّ صَلِّ عَلَى مُحَمَّدٍ وَعَلَى آلِ مُحَمَّدٍ كَمَا صَلَّيْتَ عَلَى إِبْرَاهِيمَ وَعَلَى آلِ إِبْرَاهِيمَ، وَبَارِكْ عَلَى مُحَمَّدٍ وَعَلَى آلِ مُحَمَّدٍ كَمَا بَارَكْتَ عَلَى إِبْرَاهِيمَ وَعَلَى آلِ إِبْرَاهِيمَ، إِنَّكَ حَمِيدٌ مَجِيدٌ",
                    'latin'    => 'At-tahiyyaatul mubaarakaatush shalawaatuth thayyibaatu lillaah. As-salaamu \'alaika ayyuhan nabiyyu wa rahmatullahi wa barakaatuh. As-salaamu \'alainaa wa \'alaa \'ibaadillahish shaalihiin. Asyhadu allaa ilaaha illallah, wa asyhadu anna muhammadar rasuulullah. Allaahumma shalli \'alaa muhammadin wa \'alaa aali muhammadin kamaa shallaita \'alaa ibraahiima wa \'alaa aali ibraahiima. Wa baarik \'alaa muhammadin wa \'alaa aali muhammadin kamaa baarakta \'alaa ibraahiima wa \'alaa aali ibraahiima. Innaka hamiidum majiid.',
                    'terjemah' => [
                        'dewasa' => 'Segala kehormatan, keberkahan, shalawat, dan kebaikan adalah milik Allah. Semoga keselamatan terlimpah kepadamu wahai Nabi, serta rahmat Allah dan keberkahan-Nya. Semoga keselamatan juga terlimpah kepada kami dan hamba-hamba Allah yang shalih. Aku bersaksi bahwa tiada tuhan selain Allah, dan aku bersaksi bahwa Muhammad adalah utusan Allah. Ya Allah, berikanlah shalawat kepada Muhammad dan keluarganya, sebagaimana Engkau telah memberikan shalawat kepada Ibrahim dan keluarganya. Dan berkahilah Muhammad dan keluarganya, sebagaimana Engkau telah memberkahi Ibrahim dan keluarganya. Sesungguhnya Engkau Maha Terpuji lagi Maha Mulia.',
                        'anak'   => 'Semua kebaikan untuk Allah. Salam untuk Nabi Muhammad. Aku berjanji Allah itu satu dan Nabi Muhammad utusan Allah! Ya Allah, berikan kebaikan untuk Nabi Muhammad seperti Engkau memberi kebaikan kepada Nabi Ibrahim! 🌹',
                    ],
                    'audio'    => 'assets/audio/tahiyatakhir-shalawatibrahim.mp3',
                    'video'    => 'assets/videos/attahiyat-akhir.mp4',
                ]
            ]
        ],
        [
            'id'         => 11,
            'kode'       => 'G11',
            'nama'       => 'Salam',
            'icon'       => '👋',
            'warna'      => 'pink',
            'gambar'     => 'assets/images/gerakan/salam.svg',
            'deskripsi'  => [
                'dewasa' => 'Salam adalah gerakan menolehkan kepala ke kanan lalu ke kiri sambil mengucapkan salam. Ini menandakan berakhirnya sholat.',
                'anak'   => 'Menoleh ke kanan dan kiri sambil bilang salam. Ini tandanya sholat kita sudah selesai! 🎉',
            ],
            'bacaan'     => [
                [
                    'judul'    => 'Salam Kanan & Kiri',
                    'arab'     => "السَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللَّهِ\n\nالسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللَّهِ",
                    'latin'    => 'As-salaamu \'alaikum wa rahmatullahi (menoleh ke kanan). As-salaamu \'alaikum wa rahmatullahi (menoleh ke kiri).',
                    'terjemah' => [
                        'dewasa' => 'Semoga keselamatan dan rahmat Allah terlimpah kepada kalian. (Diucapkan dua kali: saat menoleh ke kanan dan saat menoleh ke kiri)',
                        'anak'   => 'Semoga kalian selamat dan dapat rahmat Allah! Pertama menoleh ke kanan, lalu menoleh ke kiri! 😊🎉',
                    ],
                    'audio'    => 'assets/audio/salam.mp3',
                    'video'    => 'assets/videos/salam.mp4',
                ]
            ]
        ],
    ];
}
