<?php
helper('konten');

$daftarKonten = $daftarKonten ?? [];
$kodeHalaman = $kodeHalaman ?? '';
$namaHalaman = $namaHalaman ?? 'Halaman';
$bolehTambah = (bool) ($bolehTambah ?? false);
$halamanTetap = (bool) ($halamanTetap ?? false);

function adminRingkasTeks(?string $teks, int $maksimal = 95): string
{
    $teks = konten_plain($teks);

    if ($teks === '') {
        return '-';
    }

    if (strlen($teks) <= $maksimal) {
        return $teks;
    }

    return substr($teks, 0, $maksimal) . '...';
}
?>

<div class="table-header">
    <div>
        <h2>Kelola <?= esc($namaHalaman) ?></h2>

        <?php if ($bolehTambah): ?>
            <p>Halaman ini mendukung banyak data. Admin boleh menambah, mengedit, dan menghapus konten.</p>
        <?php else: ?>
            <p>Halaman ini hanya boleh diedit. Admin tidak bisa menambahkan atau menghapus data baru.</p>
        <?php endif; ?>
    </div>

    <?php if ($bolehTambah): ?>
        <a href="<?= site_url('admin/' . $kodeHalaman . '/tambah') ?>" class="btn btn-primary">
            + Tambah Konten
        </a>
    <?php endif; ?>
</div>

<?php if (! empty($daftarKonten)): ?>
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Kode Konten</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Gambar</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($daftarKonten as $konten): ?>
                    <tr>
                        <td>
                            <strong><?= esc($konten['kode_konten'] ?? '-') ?></strong>
                        </td>

                        <td>
                            <?= esc(adminRingkasTeks($konten['judul'] ?? '-', 55)) ?>
                        </td>

                        <td>
                            <span class="table-muted">
                                <?= esc(adminRingkasTeks($konten['isi'] ?? '-', 110)) ?>
                            </span>
                        </td>

                        <td>
                            <?php if (! empty($konten['gambar'])): ?>
                                <img
                                    src="<?= base_url($konten['gambar']) ?>"
                                    alt="<?= esc($konten['judul'] ?? 'Gambar konten') ?>"
                                    class="image-thumb"
                                >
                            <?php else: ?>
                                <span class="table-muted">Tidak ada gambar</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?= esc((string) ($konten['urutan'] ?? 0)) ?>
                        </td>

                        <td>
                            <?php if (($konten['status'] ?? '') === 'aktif'): ?>
                                <span class="badge badge-active">Aktif</span>
                            <?php else: ?>
                                <span class="badge badge-inactive">Nonaktif</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <div class="table-actions">
                                <a
                                    href="<?= site_url('admin/' . $kodeHalaman . '/edit/' . ($konten['id_konten'] ?? 0)) ?>"
                                    class="btn btn-secondary"
                                >
                                    Edit
                                </a>

                                <?php if ($bolehTambah): ?>
                                    <form
                                        action="<?= site_url('admin/' . $kodeHalaman . '/hapus/' . ($konten['id_konten'] ?? 0)) ?>"
                                        method="post"
                                        onsubmit="return confirm('Yakin ingin menghapus konten ini?')"
                                    >
                                        <button type="submit" class="btn btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="empty-state">
        <?php if ($bolehTambah): ?>
            <h3>Belum ada konten</h3>
            <p>Tambahkan konten pertama untuk halaman <?= esc($namaHalaman) ?>.</p>

            <div class="empty-action">
                <a href="<?= site_url('admin/halaman/' . $kodeHalaman . '/tambah') ?>" class="btn btn-primary">
                    Tambah Konten
                </a>
            </div>
        <?php else: ?>
            <h3>Data konten belum tersedia</h3>
            <p>
                Halaman ini tidak boleh menambah data baru dari tombol admin.
                Buat data awal sesuai kode konten frontend melalui database, lalu admin hanya mengedit data tersebut.
            </p>
        <?php endif; ?>
    </div>
<?php endif; ?>