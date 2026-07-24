<?php

namespace App\Controllers;

use App\Models\ClassModel;
use App\Models\SubjectModel;
use App\Models\TeacherModel;

class TempDataFetcher extends BaseController
{
    public function index()
    {
        $classModel = new ClassModel();
        $subjectModel = new SubjectModel();
        $teacherModel = new TeacherModel();

        $data = [
            'classes' => $classModel->findAll(5),
            'subjects' => $subjectModel->findAll(5),
            'teachers' => $teacherModel->findAll(5),
        ];

        return $this->response->setJSON($data);
    }
}
