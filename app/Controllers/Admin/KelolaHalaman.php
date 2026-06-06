<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelKontenHalaman;
use CodeIgniter\Exceptions\PageNotFoundException;

class KelolaHalaman extends BaseController
{
    private ModelKontenHalaman $modelKonten;

    private array $halamanBolehTambah = [
        'tenaga-pengajar',
        'informasi',
    ];

    public function __construct()
    {
        helper('konten');

        $this->modelKonten = new ModelKontenHalaman();
    }

    public function dashboard()
    {
        $data = [
            'judul'         => 'Dashboard Admin',
            'daftarHalaman' => $this->modelKonten->daftarHalaman(),
        ];

        return view('admin/tata_letak', [
            'judul'     => $data['judul'],
            'isi_admin' => view('admin/dashboard', $data),
        ]);
    }

    public function index(string $kodeHalaman)
    {
        $daftarHalaman = $this->modelKonten->daftarHalaman();

        if (! isset($daftarHalaman[$kodeHalaman])) {
            throw PageNotFoundException::forPageNotFound('Halaman tidak ditemukan.');
        }

        $data = [
            'judul'          => 'Kelola ' . $daftarHalaman[$kodeHalaman],
            'kodeHalaman'    => $kodeHalaman,
            'namaHalaman'    => $daftarHalaman[$kodeHalaman],
            'daftarKonten'   => $this->modelKonten->semua($kodeHalaman),
            'bolehTambah'    => $this->bolehTambahKonten($kodeHalaman),
            'halamanTetap'   => ! $this->bolehTambahKonten($kodeHalaman),
        ];

        return view('admin/tata_letak', [
            'judul'     => $data['judul'],
            'isi_admin' => view('admin/daftar_konten', $data),
        ]);
    }

    public function tambah(string $kodeHalaman)
    {
        $daftarHalaman = $this->modelKonten->daftarHalaman();

        if (! isset($daftarHalaman[$kodeHalaman])) {
            throw PageNotFoundException::forPageNotFound('Halaman tidak ditemukan.');
        }

        if (! $this->bolehTambahKonten($kodeHalaman)) {
            return redirect()
                ->to(site_url('admin/halaman/' . $kodeHalaman))
                ->with('error', 'Halaman ' . $daftarHalaman[$kodeHalaman] . ' hanya boleh diedit. Tidak boleh menambahkan konten baru.');
        }

        $data = [
            'judul'        => 'Tambah Konten',
            'mode'         => 'tambah',
            'kodeHalaman'  => $kodeHalaman,
            'namaHalaman'  => $daftarHalaman[$kodeHalaman],
            'konten'       => null,
            'bolehTambah'  => true,
            'halamanTetap' => false,
        ];

        return view('admin/tata_letak', [
            'judul'     => $data['judul'],
            'isi_admin' => view('admin/form_konten', $data),
        ]);
    }

    public function simpan(string $kodeHalaman)
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return redirect()->to(site_url('admin/halaman/' . $kodeHalaman));
        }

        $this->pastikanHalamanAda($kodeHalaman);

        if (! $this->bolehTambahKonten($kodeHalaman)) {
            return redirect()
                ->to(site_url('admin/halaman/' . $kodeHalaman))
                ->with('error', 'Halaman ini tidak boleh menambahkan data baru. Gunakan tombol Edit pada konten yang sudah tersedia.');
        }

        if (! $this->validasiFormKonten()) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        if (! $this->validasiGambarOpsional()) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $kodeKonten = $this->normalisasiKodeKonten();

        if ($this->modelKonten->kodeSudahAda($kodeHalaman, $kodeKonten)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Kode konten "' . esc($kodeKonten) . '" sudah dipakai di halaman ini. Gunakan kode lain.');
        }

        $data = [
            'kode_konten' => $kodeKonten,
            'judul'       => trim((string) $this->request->getPost('judul')),
            'isi'         => (string) $this->request->getPost('isi'),
            'gambar'      => $this->uploadGambar(),
            'urutan'      => (int) $this->request->getPost('urutan'),
            'status'      => (string) $this->request->getPost('status'),
        ];

        $this->modelKonten->tambah($kodeHalaman, $data);

        return redirect()
            ->to(site_url('admin/halaman/' . $kodeHalaman))
            ->with('success', 'Konten berhasil ditambahkan. Frontend akan mengikuti data terbaru.');
    }

    public function edit(string $kodeHalaman, int $idKonten)
    {
        $daftarHalaman = $this->modelKonten->daftarHalaman();
        $konten = $this->modelKonten->satu($kodeHalaman, $idKonten);

        if (! isset($daftarHalaman[$kodeHalaman]) || ! $konten) {
            throw PageNotFoundException::forPageNotFound('Konten tidak ditemukan.');
        }

        $data = [
            'judul'        => 'Edit Konten',
            'mode'         => 'edit',
            'kodeHalaman'  => $kodeHalaman,
            'namaHalaman'  => $daftarHalaman[$kodeHalaman],
            'konten'       => $konten,
            'bolehTambah'  => $this->bolehTambahKonten($kodeHalaman),
            'halamanTetap' => ! $this->bolehTambahKonten($kodeHalaman),
        ];

        return view('admin/tata_letak', [
            'judul'     => $data['judul'],
            'isi_admin' => view('admin/form_konten', $data),
        ]);
    }

    public function update(string $kodeHalaman, int $idKonten)
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return redirect()->to(site_url('admin/halaman/' . $kodeHalaman));
        }

        $this->pastikanHalamanAda($kodeHalaman);

        $kontenLama = $this->modelKonten->satu($kodeHalaman, $idKonten);

        if (! $kontenLama) {
            throw PageNotFoundException::forPageNotFound('Konten tidak ditemukan.');
        }

        if (! $this->validasiFormKonten()) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        if (! $this->validasiGambarOpsional()) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $kodeKonten = $this->bolehTambahKonten($kodeHalaman)
            ? $this->normalisasiKodeKonten()
            : (string) ($kontenLama['kode_konten'] ?? '');

        if ($this->modelKonten->kodeSudahAda($kodeHalaman, $kodeKonten, $idKonten)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Kode konten "' . esc($kodeKonten) . '" sudah dipakai di halaman ini. Gunakan kode lain.');
        }

        $gambarBaru = $this->uploadGambar();

        $data = [
            'kode_konten' => $kodeKonten,
            'judul'       => trim((string) $this->request->getPost('judul')),
            'isi'         => (string) $this->request->getPost('isi'),
            'urutan'      => (int) $this->request->getPost('urutan'),
            'status'      => (string) $this->request->getPost('status'),
        ];

        if ($gambarBaru !== null) {
            $data['gambar'] = $gambarBaru;
            $this->hapusFileGambar($kontenLama['gambar'] ?? null);
        }

        $this->modelKonten->ubah($kodeHalaman, $idKonten, $data);

        return redirect()
            ->to(site_url('admin/halaman/' . $kodeHalaman))
            ->with('success', 'Konten berhasil diperbarui. Frontend akan mengikuti data terbaru.');
    }

    public function hapus(string $kodeHalaman, int $idKonten)
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return redirect()->to(site_url('admin/halaman/' . $kodeHalaman));
        }

        $this->pastikanHalamanAda($kodeHalaman);

        if (! $this->bolehTambahKonten($kodeHalaman)) {
            return redirect()
                ->to(site_url('admin/halaman/' . $kodeHalaman))
                ->with('error', 'Konten halaman ini tidak boleh dihapus. Halaman ini hanya boleh diedit.');
        }

        $konten = $this->modelKonten->satu($kodeHalaman, $idKonten);

        if (! $konten) {
            throw PageNotFoundException::forPageNotFound('Konten tidak ditemukan.');
        }

        $this->modelKonten->hapus($kodeHalaman, $idKonten);
        $this->hapusFileGambar($konten['gambar'] ?? null);

        return redirect()
            ->to(site_url('admin/halaman/' . $kodeHalaman))
            ->with('success', 'Konten berhasil dihapus. Frontend akan mengikuti data terbaru.');
    }

    private function bolehTambahKonten(string $kodeHalaman): bool
    {
        return in_array($kodeHalaman, $this->halamanBolehTambah, true);
    }

    private function pastikanHalamanAda(string $kodeHalaman): void
    {
        $daftarHalaman = $this->modelKonten->daftarHalaman();

        if (! isset($daftarHalaman[$kodeHalaman])) {
            throw PageNotFoundException::forPageNotFound('Halaman tidak ditemukan.');
        }
    }

    private function validasiFormKonten(): bool
    {
        return $this->validate([
            'kode_konten' => 'required|min_length[3]|max_length[100]',
            'judul'       => 'permit_empty|max_length[255]',
            'isi'         => 'permit_empty',
            'urutan'      => 'permit_empty|integer',
            'status'      => 'required|in_list[aktif,nonaktif]',
        ]);
    }

    private function validasiGambarOpsional(): bool
    {
        $file = $this->request->getFile('gambar');

        if (! $file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return true;
        }

        return $this->validate([
            'gambar' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar,2048]',
        ]);
    }

    private function normalisasiKodeKonten(): string
    {
        return url_title(trim((string) $this->request->getPost('kode_konten')), '_', true);
    }

    private function uploadGambar(): ?string
    {
        $file = $this->request->getFile('gambar');

        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return null;
        }

        $folderTujuan = FCPATH . 'uploads/halaman';

        if (! is_dir($folderTujuan)) {
            mkdir($folderTujuan, 0775, true);
        }

        $namaFile = $file->getRandomName();
        $file->move($folderTujuan, $namaFile);

        return 'uploads/halaman/' . $namaFile;
    }

    private function hapusFileGambar(?string $path): void
    {
        $path = trim((string) $path);

        if ($path === '') {
            return;
        }

        if (! str_starts_with($path, 'uploads/halaman/')) {
            return;
        }

        $fullPath = FCPATH . $path;

        if (is_file($fullPath)) {
            unlink($fullPath);
        }
    }
}