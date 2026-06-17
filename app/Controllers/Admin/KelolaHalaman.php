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
        'unit-kb-tk',
        'unit-tpq',
        'unit-dc',
        'unit-lansia',
    ];

    private array $kodeKontenDikunci = [
        'beranda' => ['hero', 'brosur', 'video_profile'],
        'profile' => ['judul_halaman', 'subjudul_halaman', 'profil_yayasan', 'visi_misi', 'misi', 'struktur_organisasi'],
        'tenaga-pengajar' => ['judul_halaman', 'subjudul_halaman'],
        'unit-kb-tk' => ['judul_halaman', 'subjudul_halaman', 'tentang_unit', 'program_unit', 'fasilitas_unit', 'ekstrakurikuler'],
        'unit-tpq' => ['judul_halaman', 'subjudul_halaman', 'tentang_tpq', 'tentang_rtq', 'program_unit', 'kegiatan_unit'],
        'unit-dc' => ['judul_halaman', 'subjudul_halaman', 'tentang_unit', 'program_unit', 'kegiatan_unit'],
        'unit-lansia' => ['judul_halaman', 'subjudul_halaman', 'tentang_unit', 'program_unit', 'kegiatan_unit'],
        'footer' => ['footer_identitas', 'footer_kontak_judul', 'footer_alamat', 'footer_whatsapp_1', 'footer_whatsapp_2', 'footer_instagram', 'footer_tiktok', 'footer_copyright'],
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

        $daftarKonten = $this->modelKonten->semua($kodeHalaman);
        $hakKonten = [];

        foreach ($daftarKonten as $konten) {
            $idKonten = (int) ($konten['id_konten'] ?? 0);
            $kodeKonten = (string) ($konten['kode_konten'] ?? '');

            $hakKonten[$idKonten] = [
                'tipe_upload' => $this->tipeUploadKonten($kodeHalaman, $kodeKonten),
                'boleh_hapus' => $this->bolehHapusKonten($kodeHalaman, $kodeKonten),
            ];
        }

        $data = [
            'judul'        => 'Kelola ' . $daftarHalaman[$kodeHalaman],
            'kodeHalaman'  => $kodeHalaman,
            'namaHalaman'  => $daftarHalaman[$kodeHalaman],
            'daftarKonten' => $daftarKonten,
            'hakKonten'    => $hakKonten,
            'bolehTambah'  => $this->bolehTambahKonten($kodeHalaman),
            'halamanTetap' => ! $this->bolehTambahKonten($kodeHalaman),
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
                ->to($this->adminUrl($kodeHalaman))
                ->with('error', 'Halaman ' . $daftarHalaman[$kodeHalaman] . ' hanya boleh diedit. Tidak boleh menambahkan konten baru.');
        }

        $data = [
            'judul'        => 'Tambah Konten',
            'mode'         => 'tambah',
            'kodeHalaman'  => $kodeHalaman,
            'namaHalaman'  => $daftarHalaman[$kodeHalaman],
            'konten'       => null,
            'tipeUpload'   => $this->tipeUploadDefault($kodeHalaman),
            'bolehTambah'  => true,
            'halamanTetap' => false,
            'kodeDikunci'  => false,
        ];

        return view('admin/tata_letak', [
            'judul'     => $data['judul'],
            'isi_admin' => view('admin/form_konten', $data),
        ]);
    }

    public function simpan(string $kodeHalaman)
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return redirect()->to($this->adminUrl($kodeHalaman));
        }

        $this->pastikanHalamanAda($kodeHalaman);

        if (! $this->bolehTambahKonten($kodeHalaman)) {
            return redirect()
                ->to($this->adminUrl($kodeHalaman))
                ->with('error', 'Halaman ini tidak boleh menambahkan data baru. Gunakan tombol Edit pada konten yang sudah tersedia.');
        }

        if (! $this->validasiFormKonten(true)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $kodeKonten = $this->normalisasiKodeKonten();
        $tipeUpload = $this->tipeUploadKonten($kodeHalaman, $kodeKonten);

        if (! $this->validasiUploadOpsional($tipeUpload)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        if ($this->modelKonten->kodeSudahAda($kodeHalaman, $kodeKonten)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Kode konten "' . esc($kodeKonten) . '" sudah dipakai di halaman ini. Gunakan kode lain.');
        }

        $mediaBaru = $this->uploadMedia($tipeUpload);
        $isi = (string) $this->request->getPost('isi');
        $gambar = '';

        if ($tipeUpload === 'file') {
            $isi = $mediaBaru ?? $isi;
        }

        if ($tipeUpload === 'image') {
            $gambar = $mediaBaru ?? '';
        }

        $data = [
            'kode_konten' => $kodeKonten,
            'judul'       => trim((string) $this->request->getPost('judul')),
            'isi'         => $isi,
            'gambar'      => $gambar,
            'urutan'      => (int) $this->request->getPost('urutan'),
            'status'      => (string) $this->request->getPost('status'),
        ];

        if ($kodeHalaman === 'tenaga-pengajar') {
            $data['kategori'] = trim((string) $this->request->getPost('kategori'));
            $data['pendidikan'] = trim((string) $this->request->getPost('pendidikan'));
        }

        $this->modelKonten->tambah($kodeHalaman, $data);

        return redirect()
            ->to($this->adminUrl($kodeHalaman))
            ->with('success', 'Konten berhasil ditambahkan. Frontend akan mengikuti data terbaru.');
    }

    public function edit(string $kodeHalaman, int $idKonten)
    {
        $daftarHalaman = $this->modelKonten->daftarHalaman();
        $konten = $this->modelKonten->satu($kodeHalaman, $idKonten);

        if (! isset($daftarHalaman[$kodeHalaman]) || ! $konten) {
            throw PageNotFoundException::forPageNotFound('Konten tidak ditemukan.');
        }

        $kodeKonten = (string) ($konten['kode_konten'] ?? '');

        $data = [
            'judul'        => 'Edit Konten',
            'mode'         => 'edit',
            'kodeHalaman'  => $kodeHalaman,
            'namaHalaman'  => $daftarHalaman[$kodeHalaman],
            'konten'       => $konten,
            'tipeUpload'   => $this->tipeUploadKonten($kodeHalaman, $kodeKonten),
            'bolehTambah'  => $this->bolehTambahKonten($kodeHalaman),
            'halamanTetap' => ! $this->bolehTambahKonten($kodeHalaman),
            'kodeDikunci'  => $this->kodeKontenDikunci($kodeHalaman, $kodeKonten),
        ];

        return view('admin/tata_letak', [
            'judul'     => $data['judul'],
            'isi_admin' => view('admin/form_konten', $data),
        ]);
    }

    public function update(string $kodeHalaman, int $idKonten)
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return redirect()->to($this->adminUrl($kodeHalaman));
        }

        $this->pastikanHalamanAda($kodeHalaman);

        $kontenLama = $this->modelKonten->satu($kodeHalaman, $idKonten);

        if (! $kontenLama) {
            throw PageNotFoundException::forPageNotFound('Konten tidak ditemukan.');
        }

        $kodeKontenLama = (string) ($kontenLama['kode_konten'] ?? '');
        $kodeDikunci = $this->kodeKontenDikunci($kodeHalaman, $kodeKontenLama);

        if (! $this->validasiFormKonten(! $kodeDikunci)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $kodeKonten = $kodeDikunci ? $kodeKontenLama : $this->normalisasiKodeKonten();
        $tipeUpload = $this->tipeUploadKonten($kodeHalaman, $kodeKonten);

        if (! $this->validasiUploadOpsional($tipeUpload)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        if ($this->modelKonten->kodeSudahAda($kodeHalaman, $kodeKonten, $idKonten)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Kode konten "' . esc($kodeKonten) . '" sudah dipakai di halaman ini. Gunakan kode lain.');
        }

        $mediaBaru = $this->uploadMedia($tipeUpload);
        $isi = (string) $this->request->getPost('isi');
        $gambar = (string) ($kontenLama['gambar'] ?? '');

        if ($tipeUpload === 'file') {
            if ($mediaBaru !== null) {
                $this->hapusFileMedia($kontenLama['isi'] ?? null);
                $isi = $mediaBaru;
            } else {
                $isi = (string) ($kontenLama['isi'] ?? '');
            }

            $gambar = '';
        }

        if ($tipeUpload === 'image') {
            if ($mediaBaru !== null) {
                $this->hapusFileMedia($kontenLama['gambar'] ?? null);
                $gambar = $mediaBaru;
            }
        }

        if ($tipeUpload === 'none') {
            $this->hapusFileMedia($kontenLama['gambar'] ?? null);
            $gambar = '';
        }

        $data = [
            'kode_konten' => $kodeKonten,
            'judul'       => trim((string) $this->request->getPost('judul')),
            'isi'         => $isi,
            'gambar'      => $gambar,
            'urutan'      => (int) $this->request->getPost('urutan'),
            'status'      => (string) $this->request->getPost('status'),
        ];

        if ($kodeHalaman === 'tenaga-pengajar') {
            $data['kategori'] = trim((string) $this->request->getPost('kategori'));
            $data['pendidikan'] = trim((string) $this->request->getPost('pendidikan'));
        }

        $this->modelKonten->ubah($kodeHalaman, $idKonten, $data);

        return redirect()
            ->to($this->adminUrl($kodeHalaman))
            ->with('success', 'Konten berhasil diperbarui. Frontend akan mengikuti data terbaru.');
    }

    public function hapus(string $kodeHalaman, int $idKonten)
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return redirect()->to($this->adminUrl($kodeHalaman));
        }

        $this->pastikanHalamanAda($kodeHalaman);

        $konten = $this->modelKonten->satu($kodeHalaman, $idKonten);

        if (! $konten) {
            throw PageNotFoundException::forPageNotFound('Konten tidak ditemukan.');
        }

        $kodeKonten = (string) ($konten['kode_konten'] ?? '');

        if (! $this->bolehHapusKonten($kodeHalaman, $kodeKonten)) {
            return redirect()
                ->to($this->adminUrl($kodeHalaman))
                ->with('error', 'Konten ini tidak boleh dihapus karena dipakai sebagai struktur utama halaman.');
        }

        $this->modelKonten->hapus($kodeHalaman, $idKonten);
        $this->hapusFileMedia($konten['gambar'] ?? null);
        $this->hapusFileMedia($konten['isi'] ?? null);

        return redirect()
            ->to($this->adminUrl($kodeHalaman))
            ->with('success', 'Konten berhasil dihapus. Frontend akan mengikuti data terbaru.');
    }

    private function adminUrl(string $kodeHalaman): string
    {
        return base_url('admin/' . trim($kodeHalaman, '/') . '/index.php');
    }

    private function bolehTambahKonten(string $kodeHalaman): bool
    {
        return in_array($kodeHalaman, $this->halamanBolehTambah, true);
    }

    private function bolehHapusKonten(string $kodeHalaman, string $kodeKonten): bool
    {
        if (! $this->bolehTambahKonten($kodeHalaman)) {
            return false;
        }

        return ! $this->kodeKontenDikunci($kodeHalaman, $kodeKonten);
    }

    private function kodeKontenDikunci(string $kodeHalaman, string $kodeKonten): bool
    {
        return in_array($kodeKonten, $this->kodeKontenDikunci[$kodeHalaman] ?? [], true);
    }

    private function pastikanHalamanAda(string $kodeHalaman): void
    {
        $daftarHalaman = $this->modelKonten->daftarHalaman();

        if (! isset($daftarHalaman[$kodeHalaman])) {
            throw PageNotFoundException::forPageNotFound('Halaman tidak ditemukan.');
        }
    }

    private function validasiFormKonten(bool $wajibKodeKonten): bool
    {
        $aturanKodeKonten = $wajibKodeKonten
            ? 'required|min_length[3]|max_length[100]'
            : 'permit_empty|min_length[3]|max_length[100]';

        return $this->validate([
            'kode_konten' => $aturanKodeKonten,
            'judul'       => 'permit_empty|max_length[255]',
            'isi'         => 'permit_empty',
            'urutan'      => 'permit_empty|integer',
            'status'      => 'required|in_list[aktif,nonaktif]',
        ]);
    }

    private function validasiUploadOpsional(string $tipeUpload): bool
    {
        if ($tipeUpload === 'image') {
            $file = $this->request->getFile('gambar');

            if (! $file || $file->getError() === UPLOAD_ERR_NO_FILE) {
                return true;
            }

            return $this->validate([
                'gambar' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar,2048]',
            ]);
        }

        if ($tipeUpload === 'file') {
            $file = $this->request->getFile('file_dokumen');

            if (! $file || $file->getError() === UPLOAD_ERR_NO_FILE) {
                return true;
            }

            return $this->validate([
                'file_dokumen' => 'ext_in[file_dokumen,pdf]|mime_in[file_dokumen,application/pdf,application/x-pdf]|max_size[file_dokumen,10240]',
            ]);
        }

        return true;
    }

    private function normalisasiKodeKonten(): string
    {
        return url_title(trim((string) $this->request->getPost('kode_konten')), '_', true);
    }

    private function tipeUploadDefault(string $kodeHalaman): string
    {
        if (in_array($kodeHalaman, ['tenaga-pengajar', 'informasi'], true)) {
            return 'image';
        }

        if (str_starts_with($kodeHalaman, 'unit-')) {
            return 'image';
        }

        return 'none';
    }

    private function tipeUploadKonten(string $kodeHalaman, string $kodeKonten): string
    {
        if ($kodeKonten === 'brosur') {
            return 'file';
        }

        if (in_array($kodeKonten, ['judul_halaman', 'subjudul_halaman', 'footer_kontak_judul', 'footer_copyright', 'program_unit', 'fasilitas_unit', 'ekstrakurikuler', 'kegiatan_unit', 'berita'], true)) {
            return 'none';
        }

        if (str_starts_with($kodeKonten, 'program_') || str_starts_with($kodeKonten, 'pilar_') || str_starts_with($kodeKonten, 'fasilitas_')) {
            return 'none';
        }

        if ($kodeHalaman === 'footer') {
            return 'none';
        }

        return 'image';
    }

    private function uploadMedia(string $tipeUpload): ?string
    {
        if ($tipeUpload === 'image') {
            return $this->uploadFile('gambar', 'uploads/halaman');
        }

        if ($tipeUpload === 'file') {
            return $this->uploadFile('file_dokumen', 'uploads/file');
        }

        return null;
    }

    private function uploadFile(string $namaInput, string $folderPublik): ?string
    {
        $file = $this->request->getFile($namaInput);

        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return null;
        }

        $folderTujuan = FCPATH . trim($folderPublik, '/');

        if (! is_dir($folderTujuan)) {
            mkdir($folderTujuan, 0775, true);
        }

        $namaFile = $file->getRandomName();
        $file->move($folderTujuan, $namaFile);

        return trim($folderPublik, '/') . '/' . $namaFile;
    }

    private function hapusFileMedia(?string $path): void
    {
        $path = trim((string) $path);

        if ($path === '') {
            return;
        }

        if (! str_starts_with($path, 'uploads/halaman/') && ! str_starts_with($path, 'uploads/file/')) {
            return;
        }

        $fullPath = FCPATH . $path;

        if (is_file($fullPath)) {
            unlink($fullPath);
        }
    }
}
