<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\PermissionModel;
use App\Models\RolePermissionModel;

class Role extends BaseController
{
    protected $roleModel;
    protected $permissionModel;
    protected $rolePermissionModel;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->permissionModel = new PermissionModel();
        $this->rolePermissionModel = new RolePermissionModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Role (Peran)',
            'roles' => $this->roleModel->findAll()
        ];
        return view('admin/rbac/roles/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Role Baru',
            'permissions' => $this->permissionModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/rbac/roles/create', $data);
    }

    public function store()
    {
        if (!$this->validate($this->roleModel->validationRules)) {
            return redirect()->back()->withInput();
        }

        $roleId = $this->roleModel->insert([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        // Save permissions
        $permissions = $this->request->getPost('permissions');
        if($permissions){
            $this->rolePermissionModel->updatePermissions($roleId, $permissions);
        }

        return redirect()->to(base_url('roles'))->with('message', 'Role berhasil dibuat');
    }

    public function edit($id)
    {
        $role = $this->roleModel->find($id);
        if (!$role) {
            return redirect()->to('/roles')->with('error', 'Role tidak ditemukan');
        }

        $rolePermissions = $this->rolePermissionModel->where('role_id', $id)->findColumn('permission_id') ?? [];

        $data = [
            'title' => 'Edit Role',
            'role' => $role,
            'permissions' => $this->permissionModel->findAll(),
            'rolePermissions' => $rolePermissions,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/rbac/roles/edit', $data);
    }

    public function update($id)
    {
        $rules = $this->roleModel->validationRules;
        $rules['name'] = "required|min_length[3]|is_unique[roles.name,id,{$id}]";

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->roleModel->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        // Save permissions
        $permissions = $this->request->getPost('permissions');
        $this->rolePermissionModel->updatePermissions($id, $permissions ?? []);

        return redirect()->to(base_url('roles'))->with('message', 'Role berhasil diperbarui');
    }

    public function delete($id)
    {
        // Prevent deleting core roles if needed, but for now simple delete
        $this->roleModel->delete($id);
        return redirect()->to('/roles')->with('message', 'Role berhasil dihapus');
    }
}
