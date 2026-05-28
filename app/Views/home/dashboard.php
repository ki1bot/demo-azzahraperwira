<?php
$kontenMap = $kontenMap ?? [];
$kontenHalaman = $kontenHalaman ?? [];

$heroJudul = konten_judul($kontenMap, 'hero', 'Yayasan Az-ahra Perwira');
$heroIsi = konten_isi(
    $kontenMap,
    'hero',
    'KB • TK • RTQ • Pondok Tahfiz Lansia • Majelis Ta\'lim • Daycare'
);
$heroGambar = konten_gambar_url($kontenMap, 'hero', 'assets/img/home/home.jpg');

$kartuUtama = [
    [
        'kode'    => 'tentang_singkat',
        'icon'    => 'fa-solid fa-school',
        'judul'   => 'Tentang Kami',
        'isi'     => 'Yayasan Azzahra Perwira hadir sebagai lembaga pendidikan dan pembinaan yang berkomitmen membentuk generasi bertaqwa, cerdas, terampil, dan mandiri.',
        'gambar'  => 'assets/img/home/home3.jpg',
    ],
    [
        'kode'    => 'layanan_singkat',
        'icon'    => 'fa-solid fa-hands-holding-child',
        'judul'   => 'Layanan Kami',
        'isi'     => 'Kami menyediakan layanan KB, TK, RTQ, Daycare, Pondok Tahfiz Lansia, Majelis Ta\'lim, dan kegiatan pembinaan masyarakat.',
        'gambar'  => '',
    ],
    [
        'kode'    => 'kontak_singkat',
        'icon'    => 'fa-solid fa-phone-volume',
        'judul'   => 'Hubungi Kami',
        'isi'     => 'Silakan hubungi Yayasan Azzahra Perwira untuk informasi pendaftaran, kegiatan, dan layanan pendidikan.',
        'gambar'  => '',
    ],
];
?>

<div id="divUtama">
    <header
        class="relative min-h-[500px] flex items-center justify-center text-white bg-gray-800"
        style="background-image: url('<?= esc($heroGambar) ?>'); background-size: cover; background-position: center;"
    >
        <div class="absolute inset-0 bg-black opacity-50"></div>

        <div class="relative text-center px-4 max-w-3xl mx-auto">
            <h2 class="text-5xl md:text-6xl font-extrabold mb-6 tracking-tight">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 via-yellow-400 to-yellow-600">
                    <?= esc($heroJudul) ?>
                </span>
            </h2>

            <p class="text-lg md:text-xl text-gray-200 mb-10 font-light italic tracking-wide">
                <?= esc($heroIsi) ?>
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a
                    href="<?= base_url('assets/file/brosur-azzahra-2025.pdf') ?>"
                    target="_blank"
                    class="bg-yellow-500 hover:bg-yellow-600 text-black px-10 py-4 rounded-full font-bold shadow-lg hover:shadow-yellow-500/30 transition-all duration-300 transform hover:-translate-y-1 inline-block text-center"
                >
                    Lihat Brosur
                </a>

                <a
                    href="https://www.instagram.com/kb_tk_azzahraperwira/"
                    target="_blank"
                    class="bg-yellow-500 hover:bg-yellow-600 text-black px-10 py-4 rounded-full font-bold shadow-lg hover:shadow-yellow-500/30 transition-all duration-300 transform hover:-translate-y-1 inline-block text-center"
                >
                    Video Profile
                </a>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6 py-14">
        <section class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-az-green mb-4">
                Selamat Datang di Yayasan Azzahra Perwira
            </h1>
            <p class="text-gray-600 leading-relaxed">
                Data pada bagian ini sekarang terhubung ke halaman admin. Saat admin mengubah teks, gambar, urutan, atau status konten, tampilan frontend akan mengikuti data terbaru dari database.
            </p>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($kartuUtama as $kartu): ?>
                <?php
                    $kode = $kartu['kode'];
                    $judul = konten_judul($kontenMap, $kode, $kartu['judul']);
                    $isi = konten_isi($kontenMap, $kode, $kartu['isi']);
                    $gambarUrl = konten_gambar_url($kontenMap, $kode, $kartu['gambar']);
                ?>

                <article class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition">
                    <?php if ($gambarUrl !== ''): ?>
                        <img
                            src="<?= esc($gambarUrl) ?>"
                            alt="<?= esc($judul) ?>"
                            class="w-full h-52 object-cover"
                        >
                    <?php endif; ?>

                    <div class="p-7">
                        <div class="w-14 h-14 rounded-full bg-yellow-100 text-az-green flex items-center justify-center mb-5">
                            <i class="<?= esc($kartu['icon']) ?> text-2xl"></i>
                        </div>

                        <h2 class="text-2xl font-bold text-az-green mb-3">
                            <?= esc($judul) ?>
                        </h2>

                        <p class="text-gray-600 leading-relaxed">
                            <?= nl2br(esc($isi)) ?>
                        </p>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>

        <?= view('home/_konten_tambahan', [
            'kontenHalaman' => $kontenHalaman,
            'excludeKode'   => [
                'hero',
                'tentang_singkat',
                'layanan_singkat',
                'kontak_singkat',
            ],
        ]) ?>
    </main>
</div>