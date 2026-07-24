<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SettingsModel;

class Settings extends BaseController
{
    protected $settingsModel;

    public function __construct()
    {
        $this->settingsModel = new SettingsModel();
    }

    public function index()
    {
        $settingsRaw = $this->settingsModel->findAll();
        $settings = [];
        foreach($settingsRaw as $row) {
            $settings[$row['key']] = $row['value'];
        }

        $data = [
            'title' => 'Pengaturan Sekolah',
            'settings' => $settings,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/settings/index', $data);
    }

    public function update()
    {
        $rules = [
            'school_name' => 'required',
            'school_address' => 'required',
            'school_email' => 'required|valid_email',
            'school_city' => 'required',
            'headmaster_name' => 'required',
            'headmaster_nip' => 'required',
            'weight_tugas' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
            'weight_uts' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
            'weight_uas' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
            'school_logo' => 'if_exist|is_image[school_logo]|max_size[school_logo,2048]',
            'school_favicon' => 'if_exist|is_image[school_favicon]|max_size[school_favicon,512]',
            'headmaster_signature' => 'if_exist|is_image[headmaster_signature]|max_size[headmaster_signature,1024]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Pastikan bobot nilai berupa angka 0-100.');
        }

        $wTugas = (int)$this->request->getPost('weight_tugas');
        $wUts = (int)$this->request->getPost('weight_uts');
        $wUas = (int)$this->request->getPost('weight_uas');

        if (($wTugas + $wUts + $wUas) !== 100) {
            return redirect()->back()->withInput()->with('error', 'Total bobot nilai harus tepat 100% (Sekarang: ' . ($wTugas + $wUts + $wUas) . '%).');
        }

        $data = [
            'school_name' => $this->request->getPost('school_name'),
            'school_address' => $this->request->getPost('school_address'),
            'school_email' => $this->request->getPost('school_email'),
            'school_city' => $this->request->getPost('school_city'),
            'headmaster_name' => $this->request->getPost('headmaster_name'),
            'headmaster_nip' => $this->request->getPost('headmaster_nip'),
            'weight_tugas' => $wTugas,
            'weight_uts' => $wUts,
            'weight_uas' => $wUas,
        ];

        // Handle File Uploads
        $logo = $this->request->getFile('school_logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $newName = 'logo.' . $logo->getExtension();
            $logo->move(FCPATH . 'uploads/branding/', $newName, true);
            $data['school_logo'] = 'uploads/branding/' . $newName;
        }

        $favicon = $this->request->getFile('school_favicon');
        if ($favicon && $favicon->isValid() && !$favicon->hasMoved()) {
            $newName = 'favicon.' . $favicon->getExtension();
            $favicon->move(FCPATH . 'uploads/branding/', $newName, true);
            $data['school_favicon'] = 'uploads/branding/' . $newName;
        }

        $signature = $this->request->getFile('headmaster_signature');
        if ($signature && $signature->isValid() && !$signature->hasMoved()) {
            $newName = 'signature.' . $signature->getExtension();
            $signature->move(FCPATH . 'uploads/branding/', $newName, true);
            $data['headmaster_signature'] = 'uploads/branding/' . $newName;
        }

        foreach ($data as $key => $value) {
            $this->settingsModel->setValue($key, $value);
        }

        return redirect()->to('/settings')->with('message', 'Pengaturan branding berhasil diperbarui.');
    }
}
