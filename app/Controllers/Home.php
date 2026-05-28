<?php

namespace App\Controllers;

use App\Models\ModelKontenHalaman;

class Home extends BaseController
{
    private ModelKontenHalaman $modelKonten;

    public function __construct()
    {
        helper('konten');

        $this->modelKonten = new ModelKontenHalaman();
    }

    public function index()
    {
        return redirect()->to(site_url('home/beranda'));
    }

    public function beranda()
    {
        return $this->tampilHalaman('beranda', 'home/dashboard', 'beranda');
    }

    public function profile()
    {
        return $this->tampilHalaman('profile', 'home/profile', 'profile');
    }

    public function tenagaPengajar()
    {
        return $this->tampilHalaman('tenagaPengajar', 'home/tenagaPengajar', 'tenaga-pengajar');
    }

    public function unitKBTK()
    {
        return $this->tampilHalaman('unit-kb-tk', 'home/unit-kb-tk', 'unit-kb-tk');
    }

    public function unitTPQ()
    {
        return $this->tampilHalaman('unit-tpq', 'home/unit-tpq', 'unit-tpq');
    }

    public function unitDC()
    {
        return $this->tampilHalaman('unit-dc', 'home/unit-dc', 'unit-dc');
    }

    public function unitLansia()
    {
        return $this->tampilHalaman('unit-lansia', 'home/unit-lansia', 'unit-lansia');
    }

    public function informasi()
    {
        return $this->tampilHalaman('informasi', 'home/informasi', 'informasi');
    }

    private function tampilHalaman(string $statusMenu, string $viewKonten, string $kodeHalaman)
    {
        $daftarHalaman = $this->modelKonten->daftarHalaman();

        $data = [
            'title'         => 'Yayasan Azzahra Perwira',
            'statusMenu'    => $statusMenu,
            'content'       => $viewKonten,
            'kodeHalaman'   => $kodeHalaman,
            'namaHalaman'   => $daftarHalaman[$kodeHalaman] ?? 'Halaman',
            'kontenHalaman' => $this->modelKonten->semuaAktif($kodeHalaman),
            'kontenMap'     => $this->modelKonten->petaAktif($kodeHalaman),
        ];

        return view('home/utama', $data);
    }
}