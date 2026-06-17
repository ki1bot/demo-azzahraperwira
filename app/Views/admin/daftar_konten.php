<?php
helper('konten');

$daftarKonten = $daftarKonten ?? [];
$hakKonten = $hakKonten ?? [];
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

function adminHalamanUrl(string $kodeHalaman, string $aksi = '', ?int $idKonten = null): string
{
    $url = 'admin/' . trim($kodeHalaman, '/');

    if ($aksi !== '') {
        $url .= '/' . trim($aksi, '/');
    }

    if ($idKonten !== null) {
        $url .= '/' . $idKonten;
    }

    return base_url($url . '/index.php');
}
?>

<div class="table-header">
    <div>
        <h2>Kelola <?= esc($namaHalaman) ?></h2>

        <?php if ($bolehTambah): ?>
            <p>Halaman ini mendukung banyak data. Admin boleh menambah, mengedit, dan menghapus konten tambahan.</p>
        <?php else: ?>
            <p>Halaman ini hanya boleh diedit. Admin tidak bisa menambahkan atau menghapus data baru.</p>
        <?php endif; ?>
    </div>

    <?php if ($bolehTambah): ?>
        <a href="<?= adminHalamanUrl($kodeHalaman, 'tambah') ?>" class="btn btn-primary">
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

                    <?php if ($kodeHalaman === 'tenaga-pengajar'): ?>
                        <th>Kategori</th>
                        <th>Pendidikan</th>
                    <?php endif; ?>

                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Media</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($daftarKonten as $konten): ?>
                    <?php
                    $idKonten = (int) ($konten['id_konten'] ?? 0);
                    $tipeUpload = $hakKonten[$idKonten]['tipe_upload'] ?? 'none';
                    $bolehHapusKonten = (bool) ($hakKonten[$idKonten]['boleh_hapus'] ?? false);
                    ?>

                    <tr>
                        <td>
                            <strong><?= esc($konten['kode_konten'] ?? '-') ?></strong>
                        </td>

                        <?php if ($kodeHalaman === 'tenaga-pengajar'): ?>
                            <td>
                                <?= esc(adminRingkasTeks($konten['kategori'] ?? '-', 55)) ?>
                            </td>

                            <td>
                                <?= esc(adminRingkasTeks($konten['pendidikan'] ?? '-', 30)) ?>
                            </td>
                        <?php endif; ?>

                        <td>
                            <?= esc(adminRingkasTeks($konten['judul'] ?? '-', 55)) ?>
                        </td>

                        <td>
                            <span class="table-muted">
                                <?= esc(adminRingkasTeks($konten['isi'] ?? '-', 110)) ?>
                            </span>
                        </td>

                        <td>
                            <?php if ($tipeUpload === 'image'): ?>
                                <?php if (! empty($konten['gambar'])): ?>
                                    <img
                                        src="<?= base_url($konten['gambar']) ?>"
                                        alt="<?= esc($konten['judul'] ?? 'Gambar konten') ?>"
                                        class="image-thumb"
                                    >
                                <?php else: ?>
                                    <span class="table-muted">Tidak ada gambar</span>
                                <?php endif; ?>
                            <?php elseif ($tipeUpload === 'file'): ?>
                                <?php if (! empty($konten['isi'])): ?>
                                    <a href="<?= base_url($konten['isi']) ?>" target="_blank" class="btn btn-secondary btn-sm">
                                        Lihat File
                                    </a>
                                <?php else: ?>
                                    <span class="table-muted">Tidak ada file</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="table-muted">Tidak memakai media</span>
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
                                    href="<?= adminHalamanUrl($kodeHalaman, 'edit', $idKonten) ?>"
                                    class="btn btn-secondary"
                                >
                                    Edit
                                </a>

                                <?php if ($bolehHapusKonten): ?>
                                    <form
                                        action="<?= adminHalamanUrl($kodeHalaman, 'hapus', $idKonten) ?>"
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
                <a href="<?= adminHalamanUrl($kodeHalaman, 'tambah') ?>" class="btn btn-primary">
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
