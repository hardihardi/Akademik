<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
    protected $table            = 'schedules';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'class_id', 'subject_id', 'teacher_id', 'academic_year_id',
        'day', 'start_time', 'end_time', 'room'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'class_id'         => 'required|integer',
        'subject_id'       => 'required|integer',
        'teacher_id'       => 'required|integer',
        'academic_year_id' => 'required|integer',
        'day'              => 'required|in_list[Senin,Selasa,Rabu,Kamis,Jumat,Sabtu]',
        'start_time'       => 'required',
        'end_time'         => 'required',
    ];
    protected $validationMessages  = [];
    protected $skipValidation      = false;
    protected $cleanValidationRules = true;

    /**
     * Get schedules with related data (class, subject, teacher)
     */
    public function getSchedulesWithRelations(?int $classId = null, ?int $academicYearId = null)
    {
        return $this->getSchedulesWithRelationsBuilder($classId, $academicYearId)
                    ->findAll();
    }

    /**
     * Get builder for schedules with related data
     */
    public function getSchedulesWithRelationsBuilder(?int $classId = null, ?int $academicYearId = null)
    {
        $builder = $this->select('schedules.*, classes.name as class_name, subjects.name as subject_name, teachers.full_name as teacher_name')
                        ->join('classes', 'classes.id = schedules.class_id', 'left')
                        ->join('subjects', 'subjects.id = schedules.subject_id', 'left')
                        ->join('teachers', 'teachers.id = schedules.teacher_id', 'left');

        if ($classId) {
            $builder->where('schedules.class_id', $classId);
        }
        if ($academicYearId) {
            $builder->where('schedules.academic_year_id', $academicYearId);
        }

        return $builder->orderBy("FIELD(schedules.day, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
                       ->orderBy('schedules.start_time', 'ASC');
    }

    /**
     * Get schedules for a specific teacher
     */
    public function getTeacherSchedule(int $teacherId, ?int $academicYearId = null)
    {
        $builder = $this->select('schedules.*, classes.name as class_name, subjects.name as subject_name')
                        ->join('classes', 'classes.id = schedules.class_id', 'left')
                        ->join('subjects', 'subjects.id = schedules.subject_id', 'left')
                        ->where('schedules.teacher_id', $teacherId);

        if ($academicYearId) {
            $builder->where('schedules.academic_year_id', $academicYearId);
        }

        return $builder->orderBy("FIELD(schedules.day, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
                       ->orderBy('schedules.start_time', 'ASC')
                       ->findAll();
    }

    /**
     * Check for schedule conflict (same class, same day, overlapping time)
     */
    public function hasConflict(int $classId, string $day, string $startTime, string $endTime, ?int $excludeId = null): bool
    {
        $builder = $this->where('class_id', $classId)
                        ->where('day', $day)
                        ->where('start_time <', $endTime)
                        ->where('end_time >', $startTime);

        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->countAllResults() > 0;
    }
}
