<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AcademicYearModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AcademicYear extends BaseController
{
    protected $academicYearModel;

    public function __construct()
    {
        $this->academicYearModel = new AcademicYearModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Tahun Akademik',
            'years' => $this->academicYearModel->findAll()
        ];
        return view('admin/academic_years/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Tahun Akademik',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/academic_years/create', $data);
    }

    public function store()
    {
        if (!$this->validate($this->academicYearModel->getValidationRules())) {
            return redirect()->back()->withInput();
        }

        $this->academicYearModel->save([
            'year' => $this->request->getVar('year'),
            'semester' => $this->request->getVar('semester'),
            'status' => $this->request->getVar('status'),
        ]);

        return redirect()->to('/academic-years')->with('message', 'Data tahun akademik berhasil ditambahkan');
    }

    public function edit($id)
    {
        $year = $this->academicYearModel->find($id);
        if (!$year) {
            throw new PageNotFoundException('Data tidak ditemukan: ' . $id);
        }

        $data = [
            'title' => 'Edit Tahun Akademik',
            'year' => $year,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/academic_years/edit', $data);
    }


    public function activate($id)
    {
        // Custom method to set active year
        $model = new AcademicYearModel();
        // Deactivate all
        $model->set('status', 'Inactive')->where('id !=', $id)->update();
        // Activate selected
        $model->set('status', 'Active')->where('id', $id)->update();

        return redirect()->to('/academic-years')->with('message', 'Tahun akademik diaktifkan.');
    }

    public function lock($id)
    {
        $year = $this->academicYearModel->find($id);
        if (!$year) {
            return redirect()->to('/academic-years')->with('error', 'Data tidak ditemukan.');
        }

        $newLockStatus = ($year['is_locked'] ?? 0) ? 0 : 1;
        $this->academicYearModel->update($id, ['is_locked' => $newLockStatus]);

        $message = $newLockStatus ? 'Tahun akademik telah dikunci. Data tidak dapat diubah.' : 'Tahun akademik telah dibuka kembali.';
        return redirect()->to('/academic-years')->with('message', $message);
    }

    public function update($id)
    {
        $year = $this->academicYearModel->find($id);
        if ($year && ($year['is_locked'] ?? 0)) {
            return redirect()->to('/academic-years')->with('error', 'Tahun akademik ini telah dikunci dan tidak dapat diubah.');
        }

        if (!$this->validate($this->academicYearModel->getValidationRules())) {
            return redirect()->back()->withInput();
        }

        $this->academicYearModel->update($id, [
            'year' => $this->request->getVar('year'),
            'semester' => $this->request->getVar('semester'),
            'status' => $this->request->getVar('status'),
        ]);

        return redirect()->to('/academic-years')->with('message', 'Data tahun akademik berhasil diupdate');
    }

    public function delete($id)
    {
        $year = $this->academicYearModel->find($id);
        if ($year && ($year['is_locked'] ?? 0)) {
            return redirect()->to('/academic-years')->with('error', 'Tahun akademik ini telah dikunci dan tidak dapat dihapus.');
        }

        $this->academicYearModel->delete($id);
        return redirect()->to('/academic-years')->with('message', 'Data tahun akademik berhasil dihapus');
    }

    public function exportCsv()
    {
        helper('export');
        $years = $this->academicYearModel->findAll();
        
        $header = ['ID', 'Tahun', 'Semester', 'Status'];
        $data = [];
        
        foreach ($years as $row) {
            $data[] = [
                $row['id'],
                $row['year'],
                $row['semester'],
                $row['status']
            ];
        }
        
        return export_to_csv('Data_Tahun_Akademik_' . date('Ymd') . '.csv', $header, $data);
    }

    public function exportPdf()
    {
        helper(['export', 'branding']);
        $years = $this->academicYearModel->findAll();
        
        $data = [
            'title' => 'Daftar Tahun Akademik',
            'years' => $years,
            'school' => school_branding()
        ];
        
        return export_to_pdf('exports/academic_year_list', $data, 'Data_Tahun_Akademik_' . date('Ymd') . '.pdf');
    }
}
