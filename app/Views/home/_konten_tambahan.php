<?php
$kontenHalaman = $kontenHalaman ?? [];
$excludeKode = $excludeKode ?? [];
$kontenTambahan = konten_tambahan($kontenHalaman, $excludeKode);
?>

<?php if (! empty($kontenTambahan)): ?>
    <section class="mt-16">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-az-green border-l-4 border-az-gold pl-4">
                Konten Tambahan
            </h2>
            <p class="text-gray-600 mt-3">
                Bagian ini otomatis menampilkan konten aktif yang ditambahkan admin.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php foreach ($kontenTambahan as $konten): ?>
                <?php
                    $judul = trim((string) ($konten['judul'] ?? ''));
                    $isi = trim((string) ($konten['isi'] ?? ''));
                    $gambar = trim((string) ($konten['gambar'] ?? ''));
                ?>

                <article class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
                    <?php if ($gambar !== ''): ?>
                        <img
                            src="<?= base_url($gambar) ?>"
                            alt="<?= esc($judul !== '' ? $judul : 'Konten') ?>"
                            class="w-full h-56 object-cover"
                        >
                    <?php endif; ?>

                    <div class="p-7">
                        <?php if ($judul !== ''): ?>
                            <h3 class="text-2xl font-bold text-az-green mb-3">
                                <?= esc($judul) ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ($isi !== ''): ?>
                            <p class="text-gray-600 leading-relaxed">
                                <?= nl2br(esc($isi)) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>