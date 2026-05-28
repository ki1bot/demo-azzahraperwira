<?php
$kontenMap = $kontenMap ?? [];

$hero = $kontenMap['hero'] ?? [];

$heroJudul = trim((string) ($hero['judul'] ?? ''));
$heroIsi   = trim((string) ($hero['isi'] ?? ''));
$heroGambar = trim((string) ($hero['gambar'] ?? ''));

if ($heroJudul === '') {
    $heroJudul = 'Yayasan Az-ahra Perwira';
}

if ($heroGambar === '') {
    $heroGambar = 'assets/img/home/home.jpg';
}
?>

<div id="divUtama">

    <header class="relative h-[500px] flex items-center justify-center text-white bg-gray-800"
    style="background-image: url('<?php echo base_url($heroGambar); ?>'); background-size: cover; background-position: center;">

    <div class="absolute inset-0 bg-black opacity-50"></div>

    <div class="relative text-center px-4 max-w-3xl mx-auto">

    <h2 class="text-5xl md:text-6xl font-extrabold mb-6 tracking-tight">

    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 via-yellow-400 to-yellow-600">

    <?php echo esc($heroJudul); ?>

    </span>

    </h2>
    <p class="text-lg md:text-xl text-gray-200 mb-10 font-light italic tracking-wide">

    <?php if ($heroIsi !== ''): ?>

        <?php echo nl2br(esc($heroIsi)); ?>

    <?php else: ?>

    KB <span class="mx-2 opacity-50">•</span>

    TK <span class="mx-2 opacity-50">•</span>

    RTQ <span class="mx-2 opacity-50">•</span>

    Pondok Tahfiz Lansia <span class="mx-2 opacity-50">•</span>

    Majelis Ta'lim <span class="mx-2 opacity-50">•</span>

    Daycare

    <?php endif; ?>

    </p>

    <div class="flex flex-col sm:flex-row justify-center gap-4">

    <a href="<?php echo base_url('assets/file/brosur-azzahra-2025.pdf'); ?>"

    target="_blank"
    class="bg-yellow-500 hover:bg-yellow-600 text-black px-10 py-4 rounded-full font-bold shadow-lg hover:shadow-yellow-500/30 transition-all duration-300 transform hover:-translate-y-1 inline-block text-center">

    Lihat Brosur

    </a>

    <a href="https://www.instagram.com/kb_tk_azzahraperwira/"

    target="_blank"
    class="bg-yellow-500 hover:bg-yellow-600 text-black px-10 py-4 rounded-full font-bold shadow-lg hover:shadow-yellow-500/30 transition-all duration-300 transform hover:-translate-y-1 inline-block text-center">

    Video Profile

    </a>

    </div>

    </div>

    </header>

</div>