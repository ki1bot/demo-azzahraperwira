<?php

namespace App\Services;

use App\Models\ModelKontenHalaman;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\IncomingRequest;
use Config\KelolaHalaman as KonfigurasiKelolaHalaman;

class KelolaHalamanService
{
    public function __construct(
        private ModelKontenHalaman $modelKonten,
        private KonfigurasiKelolaHalaman $konfigurasi,
        private MediaHalamanService $media
    ) {
    }

    public function namaHalaman(string $kodeHalaman): string
    {
        $daftarHalaman = $this->modelKonten->daftarHalaman();

        if (! isset($daftarHalaman[$kodeHalaman])) {
            throw PageNotFoundException::forPageNotFound(
                'Halaman tidak ditemukan.'
            );
        }

        return $daftarHalaman[$kodeHalaman];
    }

    public function bolehTambah(string $kodeHalaman): bool
    {
        return in_array(
            $kodeHalaman,
            $this->konfigurasi->halamanBolehTambah,
            true
        );
    }

    public function kodeDikunci(
        string $kodeHalaman,
        string $kodeKonten
    ): bool {
        return in_array(
            $kodeKonten,
            $this->konfigurasi->kodeKontenDikunci[$kodeHalaman] ?? [],
            true
        );
    }

    public function bolehHapus(
        string $kodeHalaman,
        string $kodeKonten
    ): bool {
        return $this->bolehTambah($kodeHalaman)
            && ! $this->kodeDikunci($kodeHalaman, $kodeKonten);
    }

    public function tipeUploadDefault(
        string $kodeHalaman
    ): string {
        if (in_array(
            $kodeHalaman,
            ['tenaga-pengajar', 'informasi'],
            true
        )) {
            return 'image';
        }

        if (str_starts_with($kodeHalaman, 'unit-')) {
            return 'image';
        }

        return 'none';
    }

    public function tipeUpload(
        string $kodeHalaman,
        string $kodeKonten
    ): string {
        if ($kodeKonten === 'brosur') {
            return 'file';
        }

        if (in_array(
            $kodeKonten,
            $this->konfigurasi->kodeKontenTanpaUpload,
            true
        )) {
            return 'none';
        }

        foreach (
            $this->konfigurasi->awalanKodeTanpaUpload
            as $awalan
        ) {
            if (str_starts_with($kodeKonten, $awalan)) {
                return 'none';
            }
        }

        return $kodeHalaman === 'footer'
            ? 'none'
            : 'image';
    }

    public function pastikanKontenOtomatis(
        string $kodeHalaman
    ): void {
        $daftarKonten = $this->konfigurasi
            ->kontenOtomatis[$kodeHalaman] ?? [];

        foreach ($daftarKonten as $konten) {
            $kodeKonten = (string) (
                $konten['kode_konten'] ?? ''
            );

            if ($kodeKonten === '') {
                continue;
            }

            $kontenTersedia = $this->modelKonten
                ->satuBerdasarkanKode(
                    $kodeHalaman,
                    $kodeKonten
                );

            if ($kontenTersedia !== null) {
                continue;
            }

            $this->modelKonten->tambah(
                $kodeHalaman,
                $konten
            );
        }
    }

    public function hakKonten(
        string $kodeHalaman,
        array $daftarKonten
    ): array {
        $hakKonten = [];

        foreach ($daftarKonten as $konten) {
            $idKonten = (int) (
                $konten['id_konten'] ?? 0
            );

            $kodeKonten = (string) (
                $konten['kode_konten'] ?? ''
            );

            $hakKonten[$idKonten] = [
                'tipe_upload' => $this->tipeUpload(
                    $kodeHalaman,
                    $kodeKonten
                ),
                'boleh_hapus' => $this->bolehHapus(
                    $kodeHalaman,
                    $kodeKonten
                ),
            ];
        }

        return $hakKonten;
    }

    public function normalisasiKode(
        string $kodeKonten
    ): string {
        return url_title(
            trim($kodeKonten),
            '_',
            true
        );
    }

    public function dataBaru(
        IncomingRequest $request,
        string $kodeHalaman,
        string $kodeKonten,
        string $tipeUpload,
        ?string $mediaBaru
    ): array {
        $isi = (string) $request->getPost('isi');
        $gambar = '';

        if ($tipeUpload === 'file') {
            $isi = $mediaBaru ?? $isi;
        }

        if ($tipeUpload === 'image') {
            $gambar = $mediaBaru ?? '';
        }

        return $this->dataForm(
            $request,
            $kodeHalaman,
            $kodeKonten,
            $isi,
            $gambar
        );
    }

    public function dataUpdate(
        IncomingRequest $request,
        string $kodeHalaman,
        string $kodeKonten,
        string $tipeUpload,
        ?string $mediaBaru,
        array $kontenLama
    ): array {
        $isi = (string) $request->getPost('isi');
        $gambar = (string) (
            $kontenLama['gambar'] ?? ''
        );

        if ($tipeUpload === 'file') {
            if ($mediaBaru !== null) {
                $this->media->hapus(
                    $kontenLama['isi'] ?? null
                );

                $isi = $mediaBaru;
            } else {
                $isi = (string) (
                    $kontenLama['isi'] ?? ''
                );
            }

            $gambar = '';
        }

        if (
            $tipeUpload === 'image'
            && $mediaBaru !== null
        ) {
            $this->media->hapus(
                $kontenLama['gambar'] ?? null
            );

            $gambar = $mediaBaru;
        }

        if ($tipeUpload === 'none') {
            $this->media->hapus(
                $kontenLama['gambar'] ?? null
            );

            $gambar = '';
        }

        return $this->dataForm(
            $request,
            $kodeHalaman,
            $kodeKonten,
            $isi,
            $gambar
        );
    }

    public function hapus(
        string $kodeHalaman,
        int $idKonten,
        array $konten
    ): void {
        $this->modelKonten->hapus(
            $kodeHalaman,
            $idKonten
        );

        $this->media->hapus(
            $konten['gambar'] ?? null
        );

        $this->media->hapus(
            $konten['isi'] ?? null
        );
    }

    private function dataForm(
        IncomingRequest $request,
        string $kodeHalaman,
        string $kodeKonten,
        string $isi,
        string $gambar
    ): array {
        $data = [
            'kode_konten' => $kodeKonten,
            'judul' => trim(
                (string) $request->getPost('judul')
            ),
            'isi' => $isi,
            'gambar' => $gambar,
            'urutan' => (int) $request->getPost('urutan'),
            'status' => (string) $request->getPost('status'),
        ];

        if ($kodeHalaman === 'tenaga-pengajar') {
            $data['kategori'] = trim(
                (string) $request->getPost('kategori')
            );

            $data['pendidikan'] = trim(
                (string) $request->getPost('pendidikan')
            );
        }

        return $data;
    }
}