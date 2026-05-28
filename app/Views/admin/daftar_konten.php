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

<div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 22px;">
    <div>
        <h2 style="margin: 0 0 8px; font-size: 24px;">Kelola <?= esc($namaHalaman) ?></h2>
        <p style="margin: 0; color: var(--text-muted); line-height: 1.6;">
            Atur teks, gambar, urutan, dan status konten untuk halaman ini.
        </p>
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
                    <th style="width: 180px;">Aksi</th>
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
                            <span style="color: var(--text-muted); line-height: 1.6;">
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
                                <span style="color: var(--text-muted);">Tidak ada gambar</span>
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
                            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
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
        <div style="margin-top: 18px;">
            <a href="<?= site_url('admin/halaman/' . $kodeHalaman . '/tambah') ?>" class="btn btn-primary">
                Tambah Konten
            </a>
        </div>
    </div>
<?php endif; ?>