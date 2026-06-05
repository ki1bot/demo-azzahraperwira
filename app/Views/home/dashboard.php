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

$hero = $ambilKonten($kontenMap, 'hero', [
    'judul'  => 'Yayasan Az-ahra Perwira',
    'isi'    => 'KB • TK • RTQ • Pondok Tahfiz Lansia • Majelis Ta\'lim • Daycare',
    'gambar' => 'assets/img/home/home.jpg',
]);

$brosur = $ambilKonten($kontenMap, 'brosur', [
    'judul' => 'Lihat Brosur',
    'isi'   => 'assets/file/brosur-azzahra-2025.pdf',
]);

$video = $ambilKonten($kontenMap, 'video_profile', [
    'judul' => 'Video Profile',
    'isi'   => 'https://www.instagram.com/kb_tk_azzahraperwira/',
]);
?>

<div id="divUtama">
    <header class="relative h-[500px] flex items-center justify-center text-white bg-gray-800"
        style="background-image: url('<?= esc(base_url($hero['gambar']), 'attr') ?>'); background-size: cover; background-position: center;">

        <div class="absolute inset-0 bg-black opacity-50"></div>

        <div class="relative text-center px-4 max-w-3xl mx-auto">
            <h2 class="text-5xl md:text-6xl font-extrabold mb-6 tracking-tight">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 via-yellow-400 to-yellow-600">
                    <?= esc($hero['judul']) ?>
                </span>
            </h2>

            <p class="text-lg md:text-xl text-gray-200 mb-10 font-light italic tracking-wide">
                <?= nl2br(esc($hero['isi'])) ?>
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="<?= esc($buatUrl($brosur['isi'], 'assets/file/brosur-azzahra-2025.pdf'), 'attr') ?>"
                    target="_blank"
                    class="bg-yellow-500 hover:bg-yellow-600 text-black px-10 py-4 rounded-full font-bold shadow-lg hover:shadow-yellow-500/30 transition-all duration-300 transform hover:-translate-y-1 inline-block text-center">
                    <?= esc($brosur['judul']) ?>
                </a>

                <a href="<?= esc($buatUrl($video['isi'], 'https://www.instagram.com/kb_tk_azzahraperwira/'), 'attr') ?>"
                    target="_blank"
                    class="bg-yellow-500 hover:bg-yellow-600 text-black px-10 py-4 rounded-full font-bold shadow-lg hover:shadow-yellow-500/30 transition-all duration-300 transform hover:-translate-y-1 inline-block text-center">
                    <?= esc($video['judul']) ?>
                </a>
            </div>
        </div>
    </header>
</div>