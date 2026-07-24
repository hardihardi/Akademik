<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Classes extends BaseController
{
    protected $classModel;

    public function __construct()
    {
        $this->classModel = new ClassModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $activeYear = $db->table('academic_years')->where('status', 'Active')->get()->getRowArray();

        $data = [
            'title' => 'Daftar Kelas',
            'classes' => $this->classModel->orderBy('name', 'ASC')->paginate(10, 'classes'),
            'pager' => $this->classModel->pager,
            'activeYear' => $activeYear
        ];
        return view('admin/classes/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Kelas',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/classes/create', $data);
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $activeYear = $db->table('academic_years')->where('status', 'Active')->get()->getRowArray();
        $academicYearId = $activeYear ? $activeYear['id'] : null;

        $this->classModel->save([
            'name' => $this->request->getVar('name'),
            'academic_year' => $this->request->getVar('academic_year'),
            'academic_year_id' => $academicYearId,
            'capacity' => $this->request->getVar('capacity') ?? 30,
        ]);

        return redirect()->to('/classes')->with('message', 'Data kelas berhasil ditambahkan');
    }

    public function show($id)
    {
        $class = $this->classModel->find($id);
        if (!$class) {
            throw new PageNotFoundException('Data kelas tidak ditemukan: ' . $id);
        }

        $data = [
            'title' => 'Detail Kelas',
            'class' => $class
        ];
        return view('admin/classes/show', $data); // We'll create this if needed, for now just for method discovery
    }

    public function edit($id)
    {
        $class = $this->classModel->find($id);
        if (!$class) {
            throw new PageNotFoundException('Data kelas tidak ditemukan: ' . $id);
        }

        $data = [
            'title' => 'Edit Kelas',
            'class' => $class,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/classes/edit', $data);
    }

    public function update($id)
    {
        $db = \Config\Database::connect();
        $activeYear = $db->table('academic_years')->where('status', 'Active')->get()->getRowArray();
        $academicYearId = $activeYear ? $activeYear['id'] : null;

        $this->classModel->update($id, [
            'name' => $this->request->getVar('name'),
            'academic_year' => $this->request->getVar('academic_year'),
            'academic_year_id' => $academicYearId,
            'capacity' => $this->request->getVar('capacity') ?? 30,
        ]);

        return redirect()->to('/classes')->with('message', 'Data kelas berhasil diupdate');
    }

    public function delete($id)
    {
        $this->classModel->delete($id);
        return redirect()->to('/classes')->with('message', 'Data kelas berhasil dihapus');
    }

    public function exportCsv()
    {
        helper('export');
        $classes = $this->classModel->findAll();
        
        $header = ['ID', 'Nama Kelas', 'Tahun Akademik', 'Kapasitas'];
        $data = [];
        
        foreach ($classes as $row) {
            $data[] = [
                $row['id'],
                $row['name'],
                $row['academic_year'],
                $row['capacity']
            ];
        }
        
        return export_to_csv('Data_Kelas_' . date('Ymd') . '.csv', $header, $data);
    }

    public function exportPdf()
    {
        helper(['export', 'branding']);
        $classes = $this->classModel->findAll();
        
        $data = [
            'title' => 'Daftar Seluruh Kelas',
            'classes' => $classes,
            'school' => school_branding()
        ];
        
        return export_to_pdf('exports/class_list', $data, 'Data_Kelas_' . date('Ymd') . '.pdf');
    }
}
