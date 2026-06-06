<?php
$footerMap = $footerMap ?? [];

$ambilFooter = static function (array $map, string $kode, array $fallback = []): array {
    $data = $map[$kode] ?? [];

    $judul = trim((string) ($data['judul'] ?? ''));
    $isi = trim((string) ($data['isi'] ?? ''));

    return [
        'judul' => $judul !== '' ? $judul : (string) ($fallback['judul'] ?? ''),
        'isi'   => $isi !== '' ? $isi : (string) ($fallback['isi'] ?? ''),
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

$tampilkanTeks = static function (?string $teks): string {
    if (function_exists('konten_format')) {
        return konten_format($teks);
    }

    return nl2br(esc((string) $teks));
};

$identitas = $ambilFooter($footerMap, 'footer_identitas', [
    'judul' => 'Yayasan Az-Zahra Perwira',
    'isi'   => 'Lembaga pendidikan dan sosial yang berdedikasi menciptakan generasi yang Bertaqwa, Cerdas, Terampil, Mandiri dengan bimbingan kasih sayang untuk menggapai kebahagiaan hidup di dunia & akhirat.',
]);

$kontakJudul = $ambilFooter($footerMap, 'footer_kontak_judul', [
    'judul' => 'Informasi Kontak',
]);

$alamat = $ambilFooter($footerMap, 'footer_alamat', [
    'judul' => 'Alamat',
    'isi'   => 'Kav. Perwira Jaya Jl Bintara IV Rt 004/012 Kelurahan Perwira, Kecamatan Bekasi Utara, Kota Bekasi Jawa Barat',
]);

$whatsapp1 = $ambilFooter($footerMap, 'footer_whatsapp_1', [
    'judul' => '0852-1558-5570',
    'isi'   => 'https://wa.me/6285215585570',
]);

$whatsapp2 = $ambilFooter($footerMap, 'footer_whatsapp_2', [
    'judul' => '0878-8170-1715',
    'isi'   => 'https://wa.me/6287881701715',
]);

$instagram = $ambilFooter($footerMap, 'footer_instagram', [
    'judul' => '@kb_tk_azzahraperwira',
    'isi'   => 'https://www.instagram.com/kb_tk_azzahraperwira/',
]);

$tiktok = $ambilFooter($footerMap, 'footer_tiktok', [
    'judul' => '@kbtk.azzahra.perwira',
    'isi'   => 'https://www.tiktok.com/@kbtk.azzahra.perwira',
]);

$copyright = $ambilFooter($footerMap, 'footer_copyright', [
    'isi' => '© 2026 Yayasan Az-Zahra Perwira. All rights reserved.',
]);
?>

<footer class="bg-slate-900 text-slate-300 py-16">
    <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12">
        <div>
            <h4 class="text-white font-bold text-lg mb-4">
                <?= esc($identitas['judul']) ?>
            </h4>

            <p class="text-sm leading-relaxed max-w-sm">
                <?= $tampilkanTeks($identitas['isi']) ?>
            </p>
        </div>

        <div class="space-y-4">
            <h4 class="text-white font-bold text-lg mb-4">
                <?= esc($kontakJudul['judul']) ?>
            </h4>

            <div class="flex items-start gap-3">
                <span class="text-emerald-500">📍</span>
                <p class="text-sm">
                    <?= $tampilkanTeks($alamat['isi']) ?>
                </p>
            </div>

            <?php if ($whatsapp1['judul'] !== ''): ?>
                <div class="flex items-center gap-3">
                    <span class="text-emerald-500">
                        <i class="fab fa-whatsapp"></i>
                    </span>

                    <p class="text-sm">
                        <a
                            href="<?= esc($buatUrl($whatsapp1['isi']), 'attr') ?>"
                            target="_blank"
                            class="hover:text-emerald-400 transition"
                        >
                            <span><?= esc($whatsapp1['judul']) ?></span>
                        </a>
                    </p>
                </div>
            <?php endif; ?>

            <?php if ($whatsapp2['judul'] !== ''): ?>
                <div class="flex items-center gap-3">
                    <span class="text-emerald-500">
                        <i class="fab fa-whatsapp"></i>
                    </span>

                    <p class="text-sm">
                        <a
                            href="<?= esc($buatUrl($whatsapp2['isi']), 'attr') ?>"
                            target="_blank"
                            class="hover:text-emerald-400 transition"
                        >
                            <span><?= esc($whatsapp2['judul']) ?></span>
                        </a>
                    </p>
                </div>
            <?php endif; ?>

            <?php if ($instagram['judul'] !== ''): ?>
                <div class="flex items-center gap-3 text-white">
                    <span>
                        <i class="fab fa-instagram"></i>
                    </span>

                    <p class="text-sm">
                        <a
                            href="<?= esc($buatUrl($instagram['isi']), 'attr') ?>"
                            target="_blank"
                            class="hover:text-gray-300 transition"
                        >
                            <span><?= esc($instagram['judul']) ?></span>
                        </a>
                    </p>
                </div>
            <?php endif; ?>

            <?php if ($tiktok['judul'] !== ''): ?>
                <div class="flex items-center gap-3">
                    <span>
                        <i class="fab fa-tiktok"></i>
                    </span>

                    <p class="text-sm">
                        <a
                            href="<?= esc($buatUrl($tiktok['isi']), 'attr') ?>"
                            target="_blank"
                            class="hover:text-gray-300 transition"
                        >
                            <span><?= esc($tiktok['judul']) ?></span>
                        </a>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="container mx-auto px-6 mt-12 pt-8 border-t border-slate-800 text-center text-xs">
        <?= $tampilkanTeks($copyright['isi']) ?>
    </div>
</footer>