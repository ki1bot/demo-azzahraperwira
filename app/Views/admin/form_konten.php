<?php
$mode = $mode ?? 'tambah';
$kodeHalaman = $kodeHalaman ?? '';
$namaHalaman = $namaHalaman ?? 'Halaman';
$konten = $konten ?? null;

$aksi = $mode === 'edit' && ! empty($konten['id_konten'])
    ? site_url('admin/halaman/' . $kodeHalaman . '/update/' . $konten['id_konten'])
    : site_url('admin/halaman/' . $kodeHalaman . '/simpan');
?>

<div class="kartu">
    <h2>
        <?= $mode === 'edit' ? 'Edit Konten' : 'Tambah Konten' ?> -
        <?= esc($namaHalaman) ?>
    </h2>

    <form action="<?= $aksi ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="grup-form">
            <label>Kode Konten</label>
            <input type="text" name="kode_konten" value="<?= old('kode_konten', $konten['kode_konten'] ?? '') ?>"
                placeholder="contoh: hero, profil_yayasan, visi_misi" required>
            <div class="teks-kecil">
                Kode ini dipakai frontend untuk mengambil konten. Jangan asal ganti kalau sudah dipakai di view.
            </div>
        </div>

        <div class="grup-form">
            <label>Judul</label>
            <input type="text" name="judul" value="<?= old('judul', $konten['judul'] ?? '') ?>">
        </div>

        <div class="grup-form">
            <label>Isi</label>
            <textarea name="isi"><?= old('isi', $konten['isi'] ?? '') ?></textarea>
        </div>

        <div class="grup-form">
            <label>Gambar</label>
            <input type="file" name="gambar" accept="image/png,image/jpeg,image/jpg,image/webp">
            <div class="teks-kecil">Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.</div>

            <?php if (! empty($konten['gambar'])): ?>
            <p>Gambar saat ini:</p>
            <img class="pratinjau" src="<?= base_url($konten['gambar']) ?>"
                alt="<?= esc($konten['judul'] ?? 'Gambar') ?>">
            <?php endif; ?>
        </div>

        <div class="grup-form">
            <label>Urutan</label>
            <input type="number" name="urutan" value="<?= old('urutan', $konten['urutan'] ?? 0) ?>">
        </div>

        <div class="grup-form">
            <label>Status</label>
            <?php $statusSekarang = old('status', $konten['status'] ?? 'aktif'); ?>

            <select name="status">
                <option value="aktif" <?=$statusSekarang==='aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="nonaktif" <?=$statusSekarang==='nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
            </select>
        </div>

        <button class="tombol tombol-utama" type="submit">
            Simpan
        </button>

        <a class="tombol tombol-kedua" href="<?= site_url('admin/halaman/' . $kodeHalaman) ?>">
            Kembali
        </a>
    </form>
</div>