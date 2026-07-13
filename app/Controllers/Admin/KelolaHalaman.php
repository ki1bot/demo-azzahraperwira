<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelKontenHalaman;
use App\Services\KelolaHalamanService;
use App\Services\MediaHalamanService;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\KelolaHalaman as KonfigurasiKelolaHalaman;

class KelolaHalaman extends BaseController
{
    private ModelKontenHalaman $modelKonten;
    private KelolaHalamanService $layanan;
    private MediaHalamanService $media;

    public function __construct()
    {
        helper('konten');

        $this->modelKonten = new ModelKontenHalaman();
        $konfigurasi = new KonfigurasiKelolaHalaman();
        $this->media = new MediaHalamanService();

        $this->layanan = new KelolaHalamanService(
            $this->modelKonten,
            $konfigurasi,
            $this->media
        );
    }

    public function dashboard()
    {
        $data = [
            'judul' => 'Dashboard Admin',
            'daftarHalaman' => $this->modelKonten->daftarHalaman(),
        ];

        return $this->tampilkan('admin/dashboard', $data);
    }

    public function index(string $kodeHalaman)
    {
        $namaHalaman = $this->layanan->namaHalaman($kodeHalaman);
        $this->layanan->pastikanKontenOtomatis($kodeHalaman);

        $daftarKonten = $this->modelKonten->semua($kodeHalaman);
        $bolehTambah = $this->layanan->bolehTambah($kodeHalaman);

        $data = [
            'judul' => 'Kelola ' . $namaHalaman,
            'kodeHalaman' => $kodeHalaman,
            'namaHalaman' => $namaHalaman,
            'daftarKonten' => $daftarKonten,
            'hakKonten' => $this->layanan->hakKonten(
                $kodeHalaman,
                $daftarKonten
            ),
            'bolehTambah' => $bolehTambah,
            'halamanTetap' => ! $bolehTambah,
        ];

        return $this->tampilkan('admin/daftar_konten', $data);
    }

    public function tambah(string $kodeHalaman)
    {
        $namaHalaman = $this->layanan->namaHalaman($kodeHalaman);

        if (! $this->layanan->bolehTambah($kodeHalaman)) {
            return redirect()
                ->to($this->adminUrl($kodeHalaman))
                ->with(
                    'error',
                    'Halaman ' . $namaHalaman .
                    ' hanya boleh diedit. Tidak boleh menambahkan konten baru.'
                );
        }

        $data = [
            'judul' => 'Tambah Konten',
            'mode' => 'tambah',
            'kodeHalaman' => $kodeHalaman,
            'namaHalaman' => $namaHalaman,
            'konten' => null,
            'tipeUpload' => $this->layanan->tipeUploadDefault($kodeHalaman),
            'bolehTambah' => true,
            'halamanTetap' => false,
            'kodeDikunci' => false,
        ];

        return $this->tampilkan('admin/form_konten', $data);
    }

    public function simpan(string $kodeHalaman)
    {
        if (! $this->isPost()) {
            return redirect()->to($this->adminUrl($kodeHalaman));
        }

        $this->layanan->namaHalaman($kodeHalaman);

        if (! $this->layanan->bolehTambah($kodeHalaman)) {
            return redirect()
                ->to($this->adminUrl($kodeHalaman))
                ->with(
                    'error',
                    'Halaman ini tidak boleh menambahkan data baru. ' .
                    'Gunakan tombol Edit pada konten yang sudah tersedia.'
                );
        }

        if (! $this->validasiFormKonten(true)) {
            return $this->kembaliDenganErrorValidasi();
        }

        $kodeKonten = $this->layanan->normalisasiKode(
            (string) $this->request->getPost('kode_konten')
        );

        $tipeUpload = $this->layanan->tipeUpload(
            $kodeHalaman,
            $kodeKonten
        );

        if (! $this->validasiUpload($tipeUpload)) {
            return $this->kembaliDenganErrorValidasi();
        }

        if ($this->modelKonten->kodeSudahAda(
            $kodeHalaman,
            $kodeKonten
        )) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Kode konten "' . esc($kodeKonten) .
                    '" sudah dipakai di halaman ini. Gunakan kode lain.'
                );
        }

        $mediaBaru = $this->media->upload(
            $this->request,
            $tipeUpload
        );

        $data = $this->layanan->dataBaru(
            $this->request,
            $kodeHalaman,
            $kodeKonten,
            $tipeUpload,
            $mediaBaru
        );

        $this->modelKonten->tambah($kodeHalaman, $data);

        return redirect()
            ->to($this->adminUrl($kodeHalaman))
            ->with(
                'success',
                'Konten berhasil ditambahkan. ' .
                'Frontend akan mengikuti data terbaru.'
            );
    }

    public function edit(string $kodeHalaman, int $idKonten)
    {
        $namaHalaman = $this->layanan->namaHalaman($kodeHalaman);

        $konten = $this->modelKonten->satu(
            $kodeHalaman,
            $idKonten
        );

        if (! $konten) {
            throw PageNotFoundException::forPageNotFound(
                'Konten tidak ditemukan.'
            );
        }

        $kodeKonten = (string) ($konten['kode_konten'] ?? '');
        $bolehTambah = $this->layanan->bolehTambah($kodeHalaman);

        $data = [
            'judul' => 'Edit Konten',
            'mode' => 'edit',
            'kodeHalaman' => $kodeHalaman,
            'namaHalaman' => $namaHalaman,
            'konten' => $konten,
            'tipeUpload' => $this->layanan->tipeUpload(
                $kodeHalaman,
                $kodeKonten
            ),
            'bolehTambah' => $bolehTambah,
            'halamanTetap' => ! $bolehTambah,
            'kodeDikunci' => $this->layanan->kodeDikunci(
                $kodeHalaman,
                $kodeKonten
            ),
        ];

        return $this->tampilkan('admin/form_konten', $data);
    }

    public function update(string $kodeHalaman, int $idKonten)
    {
        if (! $this->isPost()) {
            return redirect()->to($this->adminUrl($kodeHalaman));
        }

        $this->layanan->namaHalaman($kodeHalaman);

        $kontenLama = $this->modelKonten->satu(
            $kodeHalaman,
            $idKonten
        );

        if (! $kontenLama) {
            throw PageNotFoundException::forPageNotFound(
                'Konten tidak ditemukan.'
            );
        }

        $kodeKontenLama = (string) (
            $kontenLama['kode_konten'] ?? ''
        );

        $kodeDikunci = $this->layanan->kodeDikunci(
            $kodeHalaman,
            $kodeKontenLama
        );

        if (! $this->validasiFormKonten(! $kodeDikunci)) {
            return $this->kembaliDenganErrorValidasi();
        }

        $kodeKonten = $kodeDikunci
            ? $kodeKontenLama
            : $this->layanan->normalisasiKode(
                (string) $this->request->getPost('kode_konten')
            );

        $tipeUpload = $this->layanan->tipeUpload(
            $kodeHalaman,
            $kodeKonten
        );

        if (! $this->validasiUpload($tipeUpload)) {
            return $this->kembaliDenganErrorValidasi();
        }

        if ($this->modelKonten->kodeSudahAda(
            $kodeHalaman,
            $kodeKonten,
            $idKonten
        )) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Kode konten "' . esc($kodeKonten) .
                    '" sudah dipakai di halaman ini. Gunakan kode lain.'
                );
        }

        $mediaBaru = $this->media->upload(
            $this->request,
            $tipeUpload
        );

        $data = $this->layanan->dataUpdate(
            $this->request,
            $kodeHalaman,
            $kodeKonten,
            $tipeUpload,
            $mediaBaru,
            $kontenLama
        );

        $this->modelKonten->ubah(
            $kodeHalaman,
            $idKonten,
            $data
        );

        return redirect()
            ->to($this->adminUrl($kodeHalaman))
            ->with(
                'success',
                'Konten berhasil diperbarui. ' .
                'Frontend akan mengikuti data terbaru.'
            );
    }

    public function hapus(string $kodeHalaman, int $idKonten)
    {
        if (! $this->isPost()) {
            return redirect()->to($this->adminUrl($kodeHalaman));
        }

        $this->layanan->namaHalaman($kodeHalaman);

        $konten = $this->modelKonten->satu(
            $kodeHalaman,
            $idKonten
        );

        if (! $konten) {
            throw PageNotFoundException::forPageNotFound(
                'Konten tidak ditemukan.'
            );
        }

        $kodeKonten = (string) ($konten['kode_konten'] ?? '');

        if (! $this->layanan->bolehHapus(
            $kodeHalaman,
            $kodeKonten
        )) {
            return redirect()
                ->to($this->adminUrl($kodeHalaman))
                ->with(
                    'error',
                    'Konten ini tidak boleh dihapus karena ' .
                    'dipakai sebagai struktur utama halaman.'
                );
        }

        $this->layanan->hapus(
            $kodeHalaman,
            $idKonten,
            $konten
        );

        return redirect()
            ->to($this->adminUrl($kodeHalaman))
            ->with(
                'success',
                'Konten berhasil dihapus. ' .
                'Frontend akan mengikuti data terbaru.'
            );
    }

    private function tampilkan(string $view, array $data): string
    {
        return view('admin/tata_letak', [
            'judul' => $data['judul'],
            'isi_admin' => view($view, $data),
        ]);
    }

    private function isPost(): bool
    {
        return strtolower(
            $this->request->getMethod()
        ) === 'post';
    }

    private function validasiFormKonten(
        bool $wajibKodeKonten
    ): bool {
        $aturanKodeKonten = $wajibKodeKonten
            ? 'required|min_length[3]|max_length[100]'
            : 'permit_empty|min_length[3]|max_length[100]';

        return $this->validate([
            'kode_konten' => $aturanKodeKonten,
            'judul' => 'permit_empty|max_length[255]',
            'isi' => 'permit_empty',
            'urutan' => 'permit_empty|integer',
            'status' => 'required|in_list[aktif,nonaktif]',
        ]);
    }

    private function validasiUpload(string $tipeUpload): bool
    {
        $aturan = $this->media->aturanValidasi(
            $this->request,
            $tipeUpload
        );

        return $aturan === [] || $this->validate($aturan);
    }

    private function kembaliDenganErrorValidasi()
    {
        return redirect()
            ->back()
            ->withInput()
            ->with(
                'error',
                implode('<br>', $this->validator->getErrors())
            );
    }

    private function adminUrl(string $kodeHalaman): string
    {
        return base_url(
            'admin/' . trim($kodeHalaman, '/') . '/index.php'
        );
    }
}