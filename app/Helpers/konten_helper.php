<?php

if (! function_exists('konten_item')) {
    function konten_item(array $kontenMap, string $kodeKonten): array
    {
        return $kontenMap[$kodeKonten] ?? [];
    }
}

if (! function_exists('konten_value')) {
    function konten_value(array $kontenMap, string $kodeKonten, string $kolom, string $default = ''): string
    {
        $item = konten_item($kontenMap, $kodeKonten);

        if (! isset($item[$kolom])) {
            return $default;
        }

        $nilai = trim((string) $item[$kolom]);

        return $nilai !== '' ? $nilai : $default;
    }
}

if (! function_exists('konten_judul')) {
    function konten_judul(array $kontenMap, string $kodeKonten, string $default = ''): string
    {
        return konten_value($kontenMap, $kodeKonten, 'judul', $default);
    }
}

if (! function_exists('konten_isi')) {
    function konten_isi(array $kontenMap, string $kodeKonten, string $default = ''): string
    {
        return konten_value($kontenMap, $kodeKonten, 'isi', $default);
    }
}

if (! function_exists('konten_html')) {
    function konten_html(array $kontenMap, string $kodeKonten, string $default = ''): string
    {
        return nl2br(esc(konten_isi($kontenMap, $kodeKonten, $default)));
    }
}

if (! function_exists('konten_gambar_path')) {
    function konten_gambar_path(array $kontenMap, string $kodeKonten, string $default = ''): string
    {
        return konten_value($kontenMap, $kodeKonten, 'gambar', $default);
    }
}

if (! function_exists('konten_gambar_url')) {
    function konten_gambar_url(array $kontenMap, string $kodeKonten, string $default = ''): string
    {
        $path = konten_gambar_path($kontenMap, $kodeKonten, $default);

        return $path !== '' ? base_url($path) : '';
    }
}

if (! function_exists('konten_tambahan')) {
    function konten_tambahan(array $kontenHalaman, array $excludeKode = []): array
    {
        $hasil = [];

        foreach ($kontenHalaman as $konten) {
            $kode = (string) ($konten['kode_konten'] ?? '');

            if ($kode === '') {
                continue;
            }

            if (in_array($kode, $excludeKode, true)) {
                continue;
            }

            if (($konten['status'] ?? '') !== 'aktif') {
                continue;
            }

            $hasil[] = $konten;
        }

        return $hasil;
    }
}