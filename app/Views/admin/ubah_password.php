<div class="section-heading">
    <h2>Ubah Password Admin</h2>
    <p>Gunakan password yang kuat. Minimal 8 karakter dan jangan sama dengan password lama.</p>
</div>

<form action="<?= site_url('admin/ubah-password') ?>" method="post" class="admin-form" autocomplete="off">
    <div class="form-grid">
        <div class="form-group full">
            <label for="password_lama" class="form-label">Password Lama</label>

            <div class="password-field">
                <input
                    type="password"
                    name="password_lama"
                    id="password_lama"
                    class="form-control"
                    placeholder="Masukkan password lama"
                    required
                >

                <button
                    type="button"
                    class="password-toggle"
                    data-toggle-password="password_lama"
                    aria-label="Tampilkan password lama"
                >
                    Lihat
                </button>
            </div>
        </div>

        <div class="form-group">
            <label for="password_baru" class="form-label">Password Baru</label>

            <div class="password-field">
                <input
                    type="password"
                    name="password_baru"
                    id="password_baru"
                    class="form-control"
                    placeholder="Minimal 8 karakter"
                    required
                >

                <button
                    type="button"
                    class="password-toggle"
                    data-toggle-password="password_baru"
                    aria-label="Tampilkan password baru"
                >
                    Lihat
                </button>
            </div>
        </div>

        <div class="form-group">
            <label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label>

            <div class="password-field">
                <input
                    type="password"
                    name="konfirmasi_password"
                    id="konfirmasi_password"
                    class="form-control"
                    placeholder="Ulangi password baru"
                    required
                >

                <button
                    type="button"
                    class="password-toggle"
                    data-toggle-password="konfirmasi_password"
                    aria-label="Tampilkan konfirmasi password"
                >
                    Lihat
                </button>
            </div>
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