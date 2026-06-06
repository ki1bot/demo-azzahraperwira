<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAdminPengguna extends Model
{
    protected $table = 'admin_pengguna';
    protected $primaryKey = 'id_admin';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nama_lengkap',
        'username',
        'password',
        'status',
    ];

    protected $useTimestamps = false;

    public function ambilBerdasarkanUsername(string $username): ?array
    {
        return $this->where('username', $username)
            ->where('status', 'aktif')
            ->first();
    }

    public function ambilBerdasarkanId(int $idAdmin): ?array
    {
        return $this->where('id_admin', $idAdmin)
            ->where('status', 'aktif')
            ->first();
    }

    public function ubahPassword(int $idAdmin, string $passwordHash): bool
    {
        return $this->update($idAdmin, [
            'password' => $passwordHash,
        ]);
    }
}