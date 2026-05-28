<?php
$daftarHalaman = $daftarHalaman ?? [];
?>

<div class="kartu">
    <h2>Dashboard Admin</h2>
    <p>Pilih halaman yang ingin dikelola. Setiap halaman bisa ditambah, diedit, dan dihapus konten teks atau gambarnya.</p>

    <table>
        <thead>
            <tr>
                <th>Nama Halaman</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($daftarHalaman as $kode => $nama): ?>
                <tr>
                    <td><?= esc($nama) ?></td>
                    <td>
                        <a class="tombol tombol-utama" href="<?= site_url('admin/halaman/' . $kode) ?>">
                            Kelola
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($daftarHalaman)): ?>
                <tr>
                    <td colspan="2">Belum ada halaman yang tersedia.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>