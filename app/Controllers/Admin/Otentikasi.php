<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelAdminPengguna;

class Otentikasi extends BaseController
{
    public function login()
    {
        if (session()->get('admin_masuk')) {
            return redirect()->to(site_url('admin/dashboard'));
        }

        return view('admin/login', [
            'judul' => 'Login Admin',
        ]);
    }

    public function prosesLogin()
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return redirect()->to(site_url('admin/login'));
        }

        $aturan = [
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                ],
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                ],
            ],
        ];

        if (! $this->validate($aturan)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        $modelAdmin = new ModelAdminPengguna();
        $admin = $modelAdmin->ambilBerdasarkanUsername($username);

        if (! $admin || ! password_verify($password, $admin['password'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Username atau password salah.');
        }

        session()->regenerate(true);

        session()->set([
            'admin_masuk'    => true,
            'id_admin'       => $admin['id_admin'],
            'nama_admin'     => $admin['nama_lengkap'],
            'username_admin' => $admin['username'],
        ]);

        return redirect()->to(site_url('admin/dashboard'));
    }

    public function logout()
    {
        session()->remove([
            'admin_masuk',
            'id_admin',
            'nama_admin',
            'username_admin',
        ]);

        session()->regenerate(true);

        return redirect()
            ->to(site_url('admin/login'))
            ->with('success', 'Logout berhasil.');
    }
}