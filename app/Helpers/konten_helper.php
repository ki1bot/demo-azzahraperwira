<?php

if (! function_exists('konten_format')) {
    function konten_format(?string $teks): string
    {
        $teks = (string) $teks;

        if (trim($teks) === '') {
            return '';
        }

        $teks = str_replace(["\r\n", "\r"], "\n", $teks);
        $teks = htmlspecialchars($teks, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        $pola = [
            '/\*\*(.+?)\*\*/s',
            '/__(.+?)__/s',
            '/~~(.+?)~~/s',
            '/`(.+?)`/s',
            '/(^|[^\\\\*])\*(?!\*)(.+?)(?<!\*)\*(?!\*)/s',
        ];

        $ganti = [
            '<strong>$1</strong>',
            '<u>$1</u>',
            '<del>$1</del>',
            '<code>$1</code>',
            '$1<em>$2</em>',
        ];

        $teks = preg_replace($pola, $ganti, $teks) ?? $teks;

        return nl2br($teks, false);
    }
}

if (! function_exists('konten_plain')) {
    function konten_plain(?string $teks): string
    {
        $teks = strip_tags((string) $teks);

        $teks = preg_replace('/\*\*(.+?)\*\*/s', '$1', $teks) ?? $teks;
        $teks = preg_replace('/__(.+?)__/s', '$1', $teks) ?? $teks;
        $teks = preg_replace('/~~(.+?)~~/s', '$1', $teks) ?? $teks;
        $teks = preg_replace('/`(.+?)`/s', '$1', $teks) ?? $teks;
        $teks = preg_replace('/(^|[^\\\\*])\*(?!\*)(.+?)(?<!\*)\*(?!\*)/s', '$1$2', $teks) ?? $teks;

        return trim($teks);
    }
}