<?php
$kontenMap = $kontenMap ?? [];
$kontenHalaman = $kontenHalaman ?? [];

$ambilKonten = static function (array $map, string $kode, array $fallback = []): array {
    $data = $map[$kode] ?? [];

    $judul = trim((string) ($data['judul'] ?? ''));
    $isi = trim((string) ($data['isi'] ?? ''));
    $gambar = trim((string) ($data['gambar'] ?? ''));

    return [
        'judul'  => $judul !== '' ? $judul : (string) ($fallback['judul'] ?? ''),
        'isi'    => $isi !== '' ? $isi : (string) ($fallback['isi'] ?? ''),
        'gambar' => $gambar !== '' ? $gambar : (string) ($fallback['gambar'] ?? ''),
    ];
};

$buatUrl = static function (string $url, string $fallback = ''): string {
    $url = trim($url) !== '' ? trim($url) : $fallback;

    if ($url === '') {
        return '#';
    }

    if (preg_match('~^(https?:)?//|mailto:|tel:|#~i', $url)) {
        return $url;
    }

    return base_url($url);
};

$judulHalaman = $ambilKonten($kontenMap, 'judul_halaman', [
    'judul' => 'Informasi & Berita',
]);

$subjudulHalaman = $ambilKonten($kontenMap, 'subjudul_halaman', [
    'isi' => 'Pusat informasi terbaru seputar kegiatan dan agenda sekolah',
]);

$pengumuman = $ambilKonten($kontenMap, 'pengumuman', [
    'judul'  => 'Penerimaan Siswa Baru Tahun Ajaran 2026/2027',
    'isi'    => 'Kami membuka pendaftaran untuk KB, TK, Daycare, dan Program Tahfidz. Pastikan buah hati Anda mendapatkan pendidikan terbaik dengan fondasi akhlak Islami. Segera daftar sebelum kuota terpenuhi!',
    'gambar' => 'assets/img/informasi/kegiatan_00001.jpg',
]);

$berita = $ambilKonten($kontenMap, 'berita', [
    'judul' => 'Kegiatan Terbaru',
]);

$brosur = $ambilKonten($kontenMap, 'brosur', [
    'judul' => 'Download Brosur Pendaftaran',
    'isi'   => 'assets/file/brosur-azzahra-2025.pdf',
]);

$kodeKhusus = ['judul_halaman', 'subjudul_halaman', 'pengumuman', 'berita', 'brosur'];

$daftarBeritaBackend = array_values(array_filter($kontenHalaman, static function ($item) use ($kodeKhusus) {
    return ! in_array((string) ($item['kode_konten'] ?? ''), $kodeKhusus, true);
}));

$kegiatanListDefault = [
    [
        'image'   => 'kegiatan_00001.jpg',
        'date'    => '15 April 2026',
        'title'   => 'Kajian Rutin Majelis Ta\'lim',
        'excerpt' => 'Membahas tema "Membangun Keluarga Sakinah di Usia Senja" bersama Ustadz kondang di lingkungan yayasan...',
    ],
    [
        'image'   => 'kegiatan_00002.jpg',
        'date'    => '20 April 2026',
        'title'   => 'Mansasik Haji Siswa TK',
        'excerpt' => 'Kegiatan Mansik Haji bagi siswa KB-TK Az-Zahra sebagai bagian dari penguatan Rukun Islam...',
    ],
    [
        'image'   => 'kegiatan_00003.jpg',
        'date'    => '10 April 2026',
        'title'   => 'Field Trip Edukasi',
        'excerpt' => 'Siswa Daycare dan KB mengunjungi taman edukasi untuk mengenal alam dan lingkungan sekitar...',
    ],
];
?>

<section class="bg-az-green py-16">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
            <?= esc($judulHalaman['judul']) ?>
        </h1>

        <p class="text-az-gold text-lg italic">
            <?= esc($subjudulHalaman['isi']) ?>
        </p>
    </div>
</section>

<main class="container mx-auto px-6 py-12">
    <section class="mb-16 bg-gradient-to-r from-blue-900 to-indigo-900 rounded-3xl p-8 md:p-12 text-white shadow-xl">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <span class="inline-block bg-az-gold text-az-green font-bold px-4 py-1 rounded-full text-sm mb-4">
                    PENGUMUMAN PENTING
                </span>

                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    <?= esc($pengumuman['judul']) ?>
                </h2>

                <p class="text-indigo-100 mb-6 leading-relaxed">
                    <?= nl2br(esc($pengumuman['isi'])) ?>
                </p>

                <a href="<?= esc($buatUrl($brosur['isi'], 'assets/file/brosur-azzahra-2025.pdf'), 'attr') ?>"
                   target="_blank"
                   class="inline-block bg-white text-indigo-900 font-bold px-8 py-3 rounded-full hover:bg-indigo-50 transition duration-300">
                    <?= esc($brosur['judul']) ?>
                </a>
            </div>

            <div class="h-72 bg-white/10 rounded-2xl overflow-hidden">
                <img src="<?= esc(base_url($pengumuman['gambar']), 'attr') ?>"
                     alt="<?= esc($pengumuman['judul'], 'attr') ?>"
                     class="w-full h-full object-cover">
            </div>
        </div>
    </section>

    <section>
        <h3 class="text-3xl font-bold text-az-green mb-10 text-center">
            <?= esc($berita['judul']) ?>
        </h3>

        <?php if ($berita['isi'] !== ''): ?>
            <div class="bg-white rounded-2xl shadow-lg p-8 text-gray-600 leading-relaxed mb-8">
                <?= nl2br(esc($berita['isi'])) ?>
            </div>
        <?php endif; ?>

        <?php if (! empty($daftarBeritaBackend)): ?>
            <div class="grid md:grid-cols-3 gap-8">
                <?php foreach ($daftarBeritaBackend as $item): ?>
                    <?php
                    $gambar = trim((string) ($item['gambar'] ?? ''));
                    $gambar = $gambar !== '' ? $gambar : 'assets/img/informasi/kegiatan_00001.jpg';
                    ?>

                    <article class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="<?= esc(base_url($gambar), 'attr') ?>"
                             class="w-full h-48 object-cover"
                             alt="<?= esc($item['judul'] ?? 'Informasi', 'attr') ?>">

                        <div class="p-6">
                            <h4 class="text-xl font-bold text-az-green mt-2 mb-3">
                                <?= esc($item['judul'] ?? 'Informasi') ?>
                            </h4>

                            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                                <?= nl2br(esc($item['isi'] ?? '')) ?>
                            </p>

                            <a href="#" class="text-az-green font-bold hover:underline">
                                Baca Selengkapnya →
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="grid md:grid-cols-3 gap-8">
                <?php foreach ($kegiatanListDefault as $item): ?>
                    <article class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="<?= esc(base_url('assets/img/informasi/' . $item['image']), 'attr') ?>"
                             class="w-full h-48 object-cover"
                             alt="<?= esc($item['title'], 'attr') ?>">

                        <div class="p-6">
                            <span class="text-az-gold text-sm font-semibold uppercase">
                                <?= esc($item['date']) ?>
                            </span>

                            <h4 class="text-xl font-bold text-az-green mt-2 mb-3">
                                <?= esc($item['title']) ?>
                            </h4>

                            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                                <?= esc($item['excerpt']) ?>
                            </p>

                            <a href="#" class="text-az-green font-bold hover:underline">
                                Baca Selengkapnya →
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>