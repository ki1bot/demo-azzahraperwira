<?php
$kontenMap = $kontenMap ?? [];

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

$tentangDefault = 'Di tengah dinamika kesibukan orang tua masa kini, kami hadir sebagai mitra terpercaya yang memahami bahwa setiap anak membutuhkan kasih sayang, perhatian, dan stimulasi yang tepat di usia emasnya. Daycare Az-Zahra Perwira bukan sekadar tempat penitipan; ini adalah "rumah kedua" di mana buah hati Anda tumbuh dalam lingkungan yang aman, bersih, dan sarat dengan nilai-nilai Islami.

Kami menyadari bahwa memberikan kepercayaan kepada pihak lain untuk menjaga buah hati adalah keputusan besar bagi setiap orang tua. Oleh karena itu, kami menerapkan standar pelayanan yang tinggi. Setiap pengasuh kami tidak hanya terlatih dalam aspek pengasuhan, tetapi juga dibekali pemahaman mendalam tentang psikologi perkembangan anak usia dini. Kami menciptakan suasana di mana anak-anak merasa dicintai, dihargai, dan selalu ingin belajar.';

$judulHalaman = $ambilKonten($kontenMap, 'judul_halaman', [
    'judul' => 'Day Care Az-Zahra Perwira',
]);

$subjudulHalaman = $ambilKonten($kontenMap, 'subjudul_halaman', [
    'isi' => 'Rumah Kedua yang Penuh Kasih dan Stimulasi',
]);

$tentang = $ambilKonten($kontenMap, 'tentang_unit', [
    'judul'  => 'Tentang Unit Daycare',
    'isi'    => $tentangDefault,
    'gambar' => 'assets/img/home/home1.jpg',
]);

$program = $ambilKonten($kontenMap, 'program_unit', [
    'judul' => 'Program Kelas',
]);

$kegiatan = $ambilKonten($kontenMap, 'kegiatan_unit', [
    'judul' => 'Galeri Kegiatan',
]);
?>

<div id="divUtama">
    <div class="bg-az-green py-16">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                <?= esc($judulHalaman['judul']) ?>
            </h1>

            <p class="text-az-gold text-lg italic">
                <?= esc($subjudulHalaman['isi']) ?>
            </p>
        </div>
    </div>

    <main class="container mx-auto px-6 py-12 space-y-16">
        <section class="grid md:grid-cols-2 gap-12 items-start">
            <div>
                <h2 class="text-3xl font-bold text-az-green mb-6">
                    <?= esc($tentang['judul']) ?>
                </h2>

                <p class="text-gray-600 leading-relaxed text-justify">
                    <?= nl2br(esc($tentang['isi'])) ?>
                </p>
            </div>

            <div class="h-80 w-full bg-slate-200 rounded-2xl overflow-hidden shadow-lg border-4 border-white">
                <img src="<?= esc(base_url($tentang['gambar']), 'attr') ?>"
                     alt="<?= esc($tentang['judul'], 'attr') ?>"
                     class="w-full h-full object-cover">
            </div>
        </section>

        <section class="py-8">
            <h3 class="text-3xl font-bold text-az-green mb-10 text-center">
                <?= esc($program['judul']) ?>
            </h3>

            <?php if ($program['isi'] !== ''): ?>
                <div class="bg-white p-8 rounded-2xl shadow-lg text-gray-600 leading-relaxed max-w-3xl mx-auto">
                    <?= nl2br(esc($program['isi'])) ?>
                </div>
            <?php else: ?>
                <div class="grid md:grid-cols-1 gap-4 max-w-lg mx-auto">
                    <div class="bg-white p-8 rounded-2xl border-t-4 border-az-green shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <h4 class="text-2xl font-bold text-az-green mb-2">Day Care</h4>
                        <p class="text-base text-gray-500 mb-6 font-medium">Usia 0 - 12 Tahun</p>

                        <div class="space-y-2">
                            <p class="text-lg font-semibold text-gray-800">Sabtu (08.00 - 10.30 & 12.30 - 15.00)</p>
                            <p class="text-lg font-semibold text-gray-800">Ahad (08.00 - 10.30)</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </section>

        <section>
            <h3 class="text-2xl font-bold text-az-green mb-8 text-center">
                <?= esc($kegiatan['judul']) ?>
            </h3>

            <?php if ($kegiatan['isi'] !== ''): ?>
                <div class="bg-white p-8 rounded-2xl shadow-lg text-gray-600 leading-relaxed">
                    <?= nl2br(esc($kegiatan['isi'])) ?>
                </div>
            <?php else: ?>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="h-72 bg-slate-200 rounded-xl overflow-hidden shadow-md">
                        <img src="<?= base_url('assets/img/home/home.jpg') ?>" alt="Galeri Daycare 1" class="w-full h-full object-cover">
                    </div>

                    <div class="h-72 bg-slate-200 rounded-xl overflow-hidden shadow-md">
                        <img src="<?= base_url('assets/img/home/home1.jpg') ?>" alt="Galeri Daycare 2" class="w-full h-full object-cover">
                    </div>

                    <div class="h-72 bg-slate-200 rounded-xl overflow-hidden shadow-md">
                        <img src="<?= base_url('assets/img/home/homedas.jpg') ?>" alt="Galeri Daycare 3" class="w-full h-full object-cover">
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </main>
</div>