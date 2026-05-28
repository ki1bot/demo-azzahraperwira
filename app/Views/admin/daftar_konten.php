<?php
$kodeHalaman = $kodeHalaman ?? '';
$namaHalaman = $namaHalaman ?? 'Halaman';
$daftarKonten = $daftarKonten ?? [];
?>

<div class="kartu">
    <h2>Kelola <?= esc($namaHalaman) ?></h2>

    <p>
        <a class="tombol tombol-utama" href="<?= site_url('admin/halaman/' . $kodeHalaman . '/tambah') ?>">
            Tambah Konten
        </a>
    </p>

    <table>
        <thead>
            <tr>
                <th>Kode Konten</th>
                <th>Judul</th>
                <th>Isi</th>
                <th>Gambar</th>
                <th>Urutan</th>
                <th>Status</th>
                <th width="170">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($daftarKonten)): ?>
                <tr>
                    <td colspan="7">Belum ada konten.</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($daftarKonten as $konten): ?>
                <tr>
                    <td><?= esc($konten['kode_konten'] ?? '') ?></td>
                    <td><?= esc($konten['judul'] ?? '') ?></td>
                    <td><?= esc(mb_strimwidth(strip_tags($konten['isi'] ?? ''), 0, 100, '...')) ?></td>
                    <td>
                        <?php if (! empty($konten['gambar'])): ?>
                            <img class="pratinjau" src="<?= base_url($konten['gambar']) ?>" alt="<?= esc($konten['judul'] ?? 'Gambar') ?>">
                        <?php else: ?>
                            <span class="teks-kecil">Tidak ada gambar</span>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($konten['urutan'] ?? 0) ?></td>
                    <td><?= esc($konten['status'] ?? '') ?></td>
                    <td>
                        <a class="tombol tombol-peringatan" href="<?= site_url('admin/halaman/' . $kodeHalaman . '/edit/' . ($konten['id_konten'] ?? 0)) ?>">
                            Edit
                        </a>

                        <form action="<?= site_url('admin/halaman/' . $kodeHalaman . '/hapus/' . ($konten['id_konten'] ?? 0)) ?>" method="post" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus konten ini?')">
                            <?= csrf_field() ?>
                            <button class="tombol tombol-bahaya" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>