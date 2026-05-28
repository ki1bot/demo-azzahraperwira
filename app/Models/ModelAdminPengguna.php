<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAdminPengguna extends Model
{
    protected $table = 'admin_pengguna';
    protected $primaryKey = 'id_admin';

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
}