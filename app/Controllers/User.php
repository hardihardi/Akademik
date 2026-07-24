<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\UserRoleModel;

class User extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $userRoleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->userRoleModel = new UserRoleModel();
    }

    public function index()
    {
        // Get paginated users
        $users = $this->userModel->paginate(10, 'users');
        
        // Attach roles and photo_url to each user in current page
        helper('branding');
        foreach ($users as &$user) {
            $user['roles'] = $this->userRoleModel->getRolesByUser($user['id']);
            $user['photo_url'] = get_photo_url($user['photo']);
        }

        $data = [
            'title' => 'Manajemen Pengguna',
            'users' => $users,
            'pager' => $this->userModel->pager,
            'roles' => $this->roleModel->findAll(),
        ];
        return view('admin/users/index', $data);
    }

    public function create()
    {
        helper('branding');
        $data = [
            'title' => 'Tambah Pengguna Baru',
            'roles' => $this->roleModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/users/create', $data);
    }

    public function store()
    {
        // Validation rules
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'full_name' => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'roles'    => 'required', // Must select at least one role
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        // Insert User
        $userData = [
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'email'    => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'active'   => $this->request->getPost('active') ? 1 : 0,
            'role' => 'ortu' // Legacy field fallback
        ];

        // Handle Photo Upload
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move(FCPATH . 'uploads/users', $newName);
            $userData['photo'] = 'uploads/users/' . $newName;
        }
        
        // Try to get the name of the first role to populate legacy field
        $roleIds = $this->request->getPost('roles');
        if($roleIds && count($roleIds) > 0) {
            $firstRole = $this->roleModel->find($roleIds[0]);
            if($firstRole) {
                $userData['role'] = $firstRole['name']; 
            }
        }

        $userId = $this->userModel->insert($userData);

        // Save Roles
        if ($userId && $roleIds) {
            $this->userRoleModel->updateUserRoles($userId, $roleIds);
        }

        // Sync with specialized tables
        $db = \Config\Database::connect();
        $fullName = $this->request->getPost('full_name');
        $user = $this->userModel->find($userId); // Reload to get role/data

        if ($user['role'] == 'guru' || $user['role'] == 'kepsek') {
            $db->table('teachers')->where('user_id', $userId)->update(['full_name' => $fullName]);
        } elseif ($user['role'] == 'ortu') {
            $db->table('students')->where('user_id', $userId)->update(['parent_name' => $fullName]);
        }

        return redirect()->to('/users')->with('message', 'Pengguna berhasil dibuat');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/users')->with('error', 'Pengguna tidak ditemukan');
        }

        $userRoles = $this->userRoleModel->where('user_id', $id)->findColumn('role_id') ?? [];

        helper('branding');
        $data = [
            'title' => 'Edit Pengguna',
            'user' => $user,
            'roles' => $this->roleModel->findAll(),
            'userRoles' => $userRoles,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        // Validation rules
        $rules = [
            'username' => "required|min_length[3]|is_unique[users.username,id,{$id}]",
            'full_name' => 'required|min_length[3]',
            'email'    => "required|valid_email|is_unique[users.email,id,{$id}]",
            'roles'    => 'required',
        ];

        // Password validation only if filled
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        // Update User
        $userData = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'active'   => $this->request->getPost('active') ? 1 : 0,
        ];

        if (!empty($password)) {
            $userData['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Handle Photo Upload
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            // Delete old photo if exists
            $user = $this->userModel->find($id);
            if ($user['photo'] && file_exists(FCPATH . $user['photo'])) {
                unlink(FCPATH . $user['photo']);
            }

            $newName = $photo->getRandomName();
            $photo->move(FCPATH . 'uploads/users', $newName);
            $userData['photo'] = 'uploads/users/' . $newName;
        }
        
        // Update legacy role field for backward compatibility
        $roleIds = $this->request->getPost('roles');
        if($roleIds && count($roleIds) > 0) {
            $firstRole = $this->roleModel->find($roleIds[0]);
            if($firstRole) {
                $userData['role'] = $firstRole['name']; 
            }
        }

        $this->userModel->update($id, $userData);

        // Update Roles
        $this->userRoleModel->updateUserRoles($id, $roleIds ?? []);

        // Sync with specialized tables
        $db = \Config\Database::connect();
        $fullName = $this->request->getPost('full_name');
        $user = $this->userModel->find($id);

        if ($user['role'] == 'guru' || $user['role'] == 'kepsek') {
            $db->table('teachers')->where('user_id', $id)->update(['full_name' => $fullName]);
        } elseif ($user['role'] == 'ortu') {
            $db->table('students')->where('user_id', $id)->update(['parent_name' => $fullName]);
        }

        return redirect()->to('/users')->with('message', 'Pengguna berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/users')->with('message', 'Pengguna berhasil dihapus');
    }

    public function exportCsv()
    {
        helper('export');
        $users = $this->userModel->findAll();
        
        $header = ['ID', 'Username', 'Nama Lengkap', 'Email', 'Role', 'Status'];
        $data = [];
        
        foreach ($users as $row) {
            $roles = $this->userRoleModel->getRolesByUser($row['id']);
            $roleNames = array_column($roles, 'name');
            $data[] = [
                $row['id'],
                $row['username'],
                $row['full_name'],
                $row['email'],
                implode(', ', $roleNames),
                $row['active'] ? 'Active' : 'Inactive'
            ];
        }
        
        return export_to_csv('Data_Pengguna_' . date('Ymd') . '.csv', $header, $data);
    }

    public function exportPdf()
    {
        helper(['export', 'branding']);
        $users = $this->userModel->findAll();
        foreach ($users as &$user) {
            $user['roles'] = $this->userRoleModel->getRolesByUser($user['id']);
        }
        
        $data = [
            'title' => 'Daftar Seluruh Pengguna',
            'users' => $users,
            'school' => school_branding()
        ];
        
        return export_to_pdf('exports/user_list', $data, 'Data_Pengguna_' . date('Ymd') . '.pdf');
    }
}
