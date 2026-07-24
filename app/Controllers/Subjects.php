<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SubjectModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Subjects extends BaseController
{
    protected $subjectModel;

    public function __construct()
    {
        $this->subjectModel = new SubjectModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Mata Pelajaran',
            'subjects' => $this->subjectModel->paginate(10, 'subjects'),
            'pager' => $this->subjectModel->pager
        ];
        return view('admin/subjects/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Mapel',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/subjects/create', $data);
    }

    public function store()
    {
        if (!$this->validate($this->subjectModel->getValidationRules())) {
            return redirect()->back()->withInput();
        }

        $this->subjectModel->save([
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
            'kkm' => $this->request->getVar('kkm') ?? 70,
            'category' => $this->request->getVar('category') ?? 'Wajib',
        ]);

        return redirect()->to('/subjects')->with('message', 'Data mapel berhasil ditambahkan');
    }

    public function edit($id)
    {
        $subject = $this->subjectModel->find($id);
        if (!$subject) {
            throw new PageNotFoundException('Data mapel tidak ditemukan: ' . $id);
        }

        $data = [
            'title' => 'Edit Mapel',
            'subject' => $subject,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/subjects/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate($this->subjectModel->getValidationRules())) {
            return redirect()->back()->withInput();
        }

        $this->subjectModel->update($id, [
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
            'kkm' => $this->request->getVar('kkm') ?? 70,
            'category' => $this->request->getVar('category') ?? 'Wajib',
        ]);

        return redirect()->to('/subjects')->with('message', 'Data mapel berhasil diupdate');
    }

    public function delete($id)
    {
        $this->subjectModel->delete($id);
        return redirect()->to('/subjects')->with('message', 'Data mapel berhasil dihapus');
    }

    public function exportCsv()
    {
        helper('export');
        $subjects = $this->subjectModel->findAll();
        
        $header = ['ID', 'Mata Pelajaran', 'Kategori', 'KKM', 'Deskripsi'];
        $data = [];
        
        foreach ($subjects as $row) {
            $data[] = [
                $row['id'],
                $row['name'],
                $row['category'] ?? 'Wajib',
                $row['kkm'] ?? 70,
                $row['description'] ?: '-'
            ];
        }
        
        return export_to_csv('Data_Mapel_' . date('Ymd') . '.csv', $header, $data);
    }

    public function exportPdf()
    {
        helper(['export', 'branding']);
        $subjects = $this->subjectModel->findAll();
        
        $data = [
            'title' => 'Daftar Seluruh Mata Pelajaran',
            'subjects' => $subjects,
            'school' => school_branding()
        ];
        
        return export_to_pdf('exports/subject_list', $data, 'Data_Mapel_' . date('Ymd') . '.pdf');
    }
}
