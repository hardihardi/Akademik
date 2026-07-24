<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Permission extends BaseController
{
    protected $permissionModel;

    public function __construct()
    {
        $this->permissionModel = new PermissionModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Permission (Hak Akses)',
            'permissions' => $this->permissionModel->findAll()
        ];
        return view('admin/rbac/permissions/index', $data);
    }

    public function create()
    {
         $data = [
            'title' => 'Tambah Permission Baru',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/rbac/permissions/create', $data);
    }

    public function store()
    {
        if (!$this->validate($this->permissionModel->validationRules)) {
            return redirect()->back()->withInput();
        }

        $this->permissionModel->save([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to(base_url('permissions'))->with('message', 'Permission berhasil dibuat');
    }

    public function edit($id)
    {
        $permission = $this->permissionModel->find($id);
        if (!$permission) {
            return redirect()->to('/permissions')->with('error', 'Permission tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Permission',
            'permission' => $permission,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/rbac/permissions/edit', $data);
    }

    public function update($id)
    {
        $rules = $this->permissionModel->validationRules;
        $rules['name'] = "required|min_length[3]|is_unique[permissions.name,id,{$id}]";

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->permissionModel->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to(base_url('permissions'))->with('message', 'Permission berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->permissionModel->delete($id);
        return redirect()->to('/permissions')->with('message', 'Permission berhasil dihapus');
    }
}
