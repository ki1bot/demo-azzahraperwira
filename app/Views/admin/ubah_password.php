<div style="margin-bottom: 22px;">
    <h2 style="margin: 0 0 8px; font-size: 24px;">Ubah Password Admin</h2>
    <p style="margin: 0; color: var(--text-muted); line-height: 1.6;">
        Gunakan password yang kuat. Minimal 8 karakter dan jangan sama dengan password lama.
    </p>
</div>

<form action="<?= site_url('admin/ubah-password') ?>" method="post" class="admin-form" autocomplete="off">
    <div class="form-grid">
        <div class="form-group full">
            <label for="password_lama" class="form-label">Password Lama</label>
            <input
                type="password"
                name="password_lama"
                id="password_lama"
                class="form-control"
                placeholder="Masukkan password lama"
                required
            >
        </div>

        <div class="form-group">
            <label for="password_baru" class="form-label">Password Baru</label>
            <input
                type="password"
                name="password_baru"
                id="password_baru"
                class="form-control"
                placeholder="Minimal 8 karakter"
                required
            >
        </div>

        <div class="form-group">
            <label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label>
            <input
                type="password"
                name="konfirmasi_password"
                id="konfirmasi_password"
                class="form-control"
                placeholder="Ulangi password baru"
                required
            >
        </div>
    </div>

    <div class="form-actions">
        <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-secondary">
            Kembali
        </a>

        <button type="submit" class="btn btn-primary">
            Simpan Password
        </button>
    </div>
</form>