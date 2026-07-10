<?php
$detailInformasi = $detailInformasi ?? [];
$judul = trim((string) ($detailInformasi['judul'] ?? 'Detail Informasi'));
$isi = trim((string) ($detailInformasi['isi'] ?? ''));
$gambar = trim((string) ($detailInformasi['gambar'] ?? ''));
?>

<section class="bg-az-green py-16">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
            <?= esc($judul) ?>
        </h1>
    </div>
</section>

<main class="container mx-auto px-6 py-12">
    <article class="bg-white rounded-3xl shadow-lg overflow-hidden max-w-5xl mx-auto">
        <?php if ($gambar !== ''): ?>
            <div class="h-80 bg-slate-200 overflow-hidden">
                <img src="<?= esc(base_url($gambar), 'attr') ?>"
                     alt="<?= esc($judul, 'attr') ?>"
                     class="w-full h-full object-cover">
            </div>
        <?php endif; ?>

        <div class="p-8 md:p-12">
            <div class="text-gray-700 leading-relaxed text-lg space-y-4">
                <?= nl2br(esc($isi)) ?>
            </div>

            <div class="mt-10">
                <a href="<?= base_url('index.php/home/informasi') ?>" class="inline-block bg-az-green text-white font-bold px-8 py-3 rounded-full hover:bg-emerald-700 transition duration-300">
                    Kembali ke Informasi
                </a>
            </div>
        </div>
    </article>
</main>
