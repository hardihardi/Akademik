<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Silakan login kembali.');
        }

        // Fetch Full Name: Priority to users.full_name, then role tables, then username
        $fullName = $user['full_name'];
        $db = \Config\Database::connect();
        
        if (!$fullName) {
            if ($user['role'] == 'admin') {
                $fullName = $user['username'];
            } elseif ($user['role'] == 'guru' || $user['role'] == 'kepsek') {
                $teacher = $db->table('teachers')->where('user_id', $userId)->get()->getRowArray();
                $fullName = $teacher ? $teacher['full_name'] : $user['username'];
            } elseif ($user['role'] == 'ortu') {
                $student = $db->table('students')->where('user_id', $userId)->get()->getRowArray();
                $fullName = $student ? ($student['parent_name'] ?: ($student['full_name'] ?: $user['username'])) : $user['username'];
            }
        }

        $data = [
            'title' => 'Pengaturan Profil',
            'user' => $user,
            'full_name' => $fullName,
            'validation' => \Config\Services::validation()
        ];

        return view('profile/index', $data);
    }

    public function update()
    {
        $userId = session()->get('id');
        $user = $this->userModel->find($userId);
        
        $rules = [
            'email'     => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'full_name' => 'required|min_length[3]'
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[6]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $userData = [
            'email' => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
        ];

        if (!empty($password)) {
            $userData['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Handle Photo Upload
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            // Delete old photo if exists and not a placeholder URL
            if ($user['photo'] && !filter_var($user['photo'], FILTER_VALIDATE_URL) && file_exists(FCPATH . $user['photo'])) {
                unlink(FCPATH . $user['photo']);
            }

            $newName = $photo->getRandomName();
            $photo->move(FCPATH . 'uploads/users', $newName);
            $userData['photo'] = 'uploads/users/' . $newName;
            
            // Update session
            session()->set('photo', $userData['photo']);
        }

        $this->userModel->update($userId, $userData);

        // Update Full Name in role tables & Session
        $db = \Config\Database::connect();
        $newFullName = $this->request->getPost('full_name');
        
        // Always update session name
        session()->set('full_name', $newFullName);
        
        if ($user['role'] == 'guru' || $user['role'] == 'kepsek') {
            $db->table('teachers')->where('user_id', $userId)->update(['full_name' => $newFullName]);
        } elseif ($user['role'] == 'ortu') {
            $student = $db->table('students')->where('user_id', $userId)->get()->getRowArray();
            if ($student) {
                $db->table('students')->where('user_id', $userId)->update(['parent_name' => $newFullName]);
            }
        }

        return redirect()->to('/profile')->with('message', 'Profil berhasil diperbarui.');
    }
}
