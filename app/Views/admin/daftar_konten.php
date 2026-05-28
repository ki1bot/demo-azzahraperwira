<?php
$daftarKonten = $daftarKonten ?? [];
$kodeHalaman = $kodeHalaman ?? '';
$namaHalaman = $namaHalaman ?? 'Halaman';

function adminRingkasTeks(?string $teks, int $maksimal = 95): string
{
    $teks = trim(strip_tags((string) $teks));

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
        <p>Atur teks, gambar, urutan, dan status konten untuk halaman ini.</p>
    </div>

    <a href="<?= site_url('admin/halaman/' . $kodeHalaman . '/tambah') ?>" class="btn btn-primary">
        + Tambah Konten
    </a>
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
                                    href="<?= site_url('admin/halaman/' . $kodeHalaman . '/edit/' . ($konten['id_konten'] ?? 0)) ?>"
                                    class="btn btn-secondary"
                                >
                                    Edit
                                </a>

                                <form
                                    action="<?= site_url('admin/halaman/' . $kodeHalaman . '/hapus/' . ($konten['id_konten'] ?? 0)) ?>"
                                    method="post"
                                    onsubmit="return confirm('Yakin ingin menghapus konten ini?')"
                                >
                                    <button type="submit" class="btn btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="empty-state">
        <h3>Belum ada konten</h3>
        <p>Tambahkan konten pertama untuk halaman <?= esc($namaHalaman) ?>.</p>

        <div class="empty-action">
            <a href="<?= site_url('admin/halaman/' . $kodeHalaman . '/tambah') ?>" class="btn btn-primary">
                Tambah Konten
            </a>
        </div>
    </div>
<?php endif; ?>