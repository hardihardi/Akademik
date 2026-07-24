<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function loginProcess()
    {
        $session = session();
        $model = new UserModel();
        $db = \Config\Database::connect();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $data = $model->where('username', $username)->first();

        if ($data) {
            $pass = $data['password_hash'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                if ($data['active'] == 1) {
                    // Fetch full_name based on role
                    $fullName = $data['full_name']; // Priority to users.full_name
                    
                    if (!$fullName) {
                        if ($data['role'] == 'admin') {
                            $fullName = $data['username'];
                        } elseif ($data['role'] == 'guru' || $data['role'] == 'kepsek') {
                            $teacher = $db->table('teachers')->where('user_id', $data['id'])->get()->getRowArray();
                            $fullName = $teacher ? $teacher['full_name'] : $data['username'];
                        } elseif ($data['role'] == 'ortu') {
                            $student = $db->table('students')->where('user_id', $data['id'])->get()->getRowArray();
                            $fullName = $student ? ($student['parent_name'] ?: ($student['full_name'] ?: $data['username'])) : $data['username'];
                        }
                    }

                    $ses_data = [
                        'id'         => $data['id'],
                        'username'   => $data['username'],
                        'full_name'  => $fullName,
                        'email'      => $data['email'],
                        'photo'      => $data['photo'],
                        'role'       => $data['role'],
                        'isLoggedIn' => true
                    ];
                    $session->set($ses_data);
                    return redirect()->to('/dashboard');
                } else {
                    $session->setFlashdata('msg', 'Akun Anda dinonaktifkan.');
                    return redirect()->to('/login');
                }
            } else {
                $session->setFlashdata('msg', 'Password salah.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username tidak ditemukan.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
