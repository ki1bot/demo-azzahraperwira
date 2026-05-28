<?php
$mode = $mode ?? 'tambah';
$konten = $konten ?? null;
$kodeHalaman = $kodeHalaman ?? '';
$namaHalaman = $namaHalaman ?? 'Halaman';

$isEdit = $mode === 'edit' && ! empty($konten);

$action = $isEdit
    ? site_url('admin/halaman/' . $kodeHalaman . '/update/' . ($konten['id_konten'] ?? 0))
    : site_url('admin/halaman/' . $kodeHalaman . '/simpan');

$judulForm = $isEdit ? 'Edit Konten' : 'Tambah Konten';
?>

<div class="section-heading">
    <h2><?= esc($judulForm) ?> - <?= esc($namaHalaman) ?></h2>
    <p>Isi data konten dengan benar. Kode konten dipakai frontend untuk membaca data dari database.</p>
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
                value="<?= esc(old('kode_konten', $konten['kode_konten'] ?? '')) ?>"
                placeholder="Contoh: hero, tentang_singkat, galeri_1"
                required
            >
        </div>

        <div class="form-group">
            <label for="judul" class="form-label">Judul</label>
            <input
                type="text"
                name="judul"
                id="judul"
                class="form-control"
                value="<?= esc(old('judul', $konten['judul'] ?? '')) ?>"
                placeholder="Masukkan judul konten"
            >
        </div>

        <div class="form-group full">
            <label for="isi" class="form-label">Isi</label>
            <textarea
                name="isi"
                id="isi"
                class="form-control"
                placeholder="Masukkan isi konten"
            ><?= esc(old('isi', $konten['isi'] ?? '')) ?></textarea>
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
        <a href="<?= site_url('admin/halaman/' . $kodeHalaman) ?>" class="btn btn-secondary">
            Kembali
        </a>

        <button type="submit" class="btn btn-primary">
            Simpan
        </button>
    </div>
</form>