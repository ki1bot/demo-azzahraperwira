<?php
$mode = $mode ?? 'tambah';
$konten = $konten ?? null;
$kodeHalaman = $kodeHalaman ?? '';
$namaHalaman = $namaHalaman ?? 'Halaman';
$halamanTetap = (bool) ($halamanTetap ?? false);

$isEdit = $mode === 'edit' && ! empty($konten);

$adminFormUrl = static function (string $kodeHalaman, string $aksi, ?int $idKonten = null): string {
    $url = 'admin/' . trim($kodeHalaman, '/') . '/' . trim($aksi, '/');

    if ($idKonten !== null) {
        $url .= '/' . $idKonten;
    }

    return base_url($url . '/index.php');
};

$adminIndexUrl = static function (string $kodeHalaman): string {
    return base_url('admin/' . trim($kodeHalaman, '/') . '/index.php');
};

$action = $isEdit
    ? $adminFormUrl($kodeHalaman, 'update', (int) ($konten['id_konten'] ?? 0))
    : $adminFormUrl($kodeHalaman, 'simpan');

$judulForm = $isEdit ? 'Edit Konten' : 'Tambah Konten';
$kodeValue = old('kode_konten', $konten['kode_konten'] ?? '');
?>

<div class="section-heading">
    <h2><?= esc($judulForm) ?> - <?= esc($namaHalaman) ?></h2>

    <?php if ($halamanTetap): ?>
        <p>
            Halaman ini memakai kode konten tetap agar backend sesuai dengan frontend.
            Kode konten tidak bisa diubah, hanya judul, isi, gambar, urutan, dan status yang bisa diedit.
        </p>
    <?php else: ?>
        <p>
            Isi data konten dengan benar. Untuk format teks, gunakan tombol format atau ketik format teks biasa tanpa tag HTML.
        </p>
    <?php endif; ?>
</div>

<form action="<?= $action ?>" method="post" enctype="multipart/form-data" class="admin-form">
    <div class="form-grid">
        <div class="form-group">
            <label for="kode_konten" class="form-label">Kode Konten</label>

            <input
                type="text"
                name="kode_konten"
                id="kode_konten"
                class="form-control"
                value="<?= esc($kodeValue) ?>"
                placeholder="Contoh: hero, tentang_singkat, galeri_1"
                <?= $halamanTetap && $isEdit ? 'readonly' : '' ?>
                required
            >

            <?php if ($halamanTetap && $isEdit): ?>
                <div class="form-help">
                    Kode konten dikunci supaya tetap cocok dengan kode yang dipanggil di frontend.
                </div>
            <?php endif; ?>
        </div>

        <?php if ($kodeHalaman === 'tenaga-pengajar'): ?>
            <div class="form-group">
                <label for="kategori" class="form-label">Kategori Pengajar</label>
                <input
                    type="text"
                    name="kategori"
                    id="kategori"
                    class="form-control"
                    value="<?= esc(old('kategori', $konten['kategori'] ?? '')) ?>"
                    placeholder="Contoh: Pendidik Rumah Quran (RTQ)"
                >
            </div>

            <div class="form-group">
                <label for="pendidikan" class="form-label">Pendidikan / Lulusan</label>
                <input
                    type="text"
                    name="pendidikan"
                    id="pendidikan"
                    class="form-control"
                    value="<?= esc(old('pendidikan', $konten['pendidikan'] ?? '')) ?>"
                    placeholder="Contoh: S1, S2, D2, Madrasah A’liyah"
                >
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label for="judul" class="form-label">
                <?= $kodeHalaman === 'tenaga-pengajar' ? 'Nama Pengajar' : 'Judul' ?>
            </label>
            <input
                type="text"
                name="judul"
                id="judul"
                class="form-control"
                value="<?= esc(old('judul', $konten['judul'] ?? '')) ?>"
                placeholder="<?= $kodeHalaman === 'tenaga-pengajar' ? 'Masukkan nama pengajar' : 'Masukkan judul konten' ?>"
            >
        </div>

        <div class="form-group full">
            <label for="isi" class="form-label">
                <?= $kodeHalaman === 'tenaga-pengajar' ? 'Jabatan' : 'Isi' ?>
            </label>

            <div class="editor-toolbar" data-editor-toolbar="isi">
                <button type="button" class="btn btn-secondary btn-sm" data-format="bold">Bold</button>
                <button type="button" class="btn btn-secondary btn-sm" data-format="italic">Italic</button>
                <button type="button" class="btn btn-secondary btn-sm" data-format="underline">Underline</button>
                <button type="button" class="btn btn-secondary btn-sm" data-format="strike">Coret</button>
                <button type="button" class="btn btn-secondary btn-sm" data-format="code">Kode</button>
            </div>

            <textarea
                name="isi"
                id="isi"
                class="form-control"
                placeholder="<?= $kodeHalaman === 'tenaga-pengajar' ? 'Contoh: Guru Tahfidz Juz 30' : 'Masukkan isi konten' ?>"
            ><?= esc(old('isi', $konten['isi'] ?? '')) ?></textarea>

            <div class="form-help">
                Format tanpa tag HTML:
                <strong>**tebal**</strong>,
                <em>*miring*</em>,
                <u>__garis bawah__</u>,
                <del>~~coret~~</del>,
                <code>`kode`</code>.
            </div>
        </div>

        <div class="form-group">
            <label for="gambar" class="form-label">Gambar</label>
            <input
                type="file"
                name="gambar"
                id="gambar"
                class="form-control"
                accept="image/jpeg,image/png,image/webp"
            >
            <div class="form-help">
                Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Preview Gambar Saat Ini</label>

            <?php if (! empty($konten['gambar'])): ?>
                <img
                    src="<?= base_url($konten['gambar']) ?>"
                    alt="<?= esc($konten['judul'] ?? 'Gambar konten') ?>"
                    class="preview-img"
                >
                <div class="form-help">
                    Upload gambar baru hanya jika ingin mengganti gambar lama.
                </div>
            <?php else: ?>
                <div class="empty-state compact">
                    <p>Belum ada gambar.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="urutan" class="form-label">Urutan</label>
            <input
                type="number"
                name="urutan"
                id="urutan"
                class="form-control"
                value="<?= esc(old('urutan', $konten['urutan'] ?? 0)) ?>"
                min="0"
            >
        </div>

        <div class="form-group">
            <label for="status" class="form-label">Status</label>

            <?php $status = old('status', $konten['status'] ?? 'aktif'); ?>

            <select name="status" id="status" class="form-control" required>
                <option value="aktif" <?= $status === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="nonaktif" <?= $status === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
            </select>
        </div>
    </div>

    <div class="form-actions">
        <a href="<?= $adminIndexUrl($kodeHalaman) ?>" class="btn btn-secondary">
            Kembali
        </a>

        <button type="submit" class="btn btn-primary">
            Simpan
        </button>
    </div>
</form>