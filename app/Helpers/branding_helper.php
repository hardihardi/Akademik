<?php

if (!function_exists('get_setting')) {
    function get_setting($key, $default = '')
    {
        $settingsModel = new \App\Models\SettingsModel();
        return $settingsModel->getValue($key) ?? $default;
    }
}

if (!function_exists('school_branding')) {
    function school_branding()
    {
        static $cache = null;
        
        if ($cache !== null) {
            return $cache;
        }

        $settingsModel = new \App\Models\SettingsModel();
        $settingsRaw = $settingsModel->findAll();
        $settings = [];
        foreach ($settingsRaw as $row) {
            $settings[$row['key']] = $row['value'];
        }

        $cache = [
            'name' => $settings['school_name'] ?? 'SDI Al-Ukhuwah',
            'logo' => !empty($settings['school_logo']) ? base_url($settings['school_logo']) : null,
            'logo_raw' => $settings['school_logo'] ?? null,
            'favicon' => !empty($settings['school_favicon']) ? base_url($settings['school_favicon']) : null,
            'favicon_raw' => $settings['school_favicon'] ?? null,
            'address' => $settings['school_address'] ?? 'Alamat Sekolah Belum Diatur',
            'city' => $settings['school_city'] ?? '',
            'email' => $settings['school_email'] ?? 'admin@sekolah.sch.id',
            'headmaster' => $settings['headmaster_name'] ?? 'Kepala Sekolah',
            'headmaster_nip' => $settings['headmaster_nip'] ?? '-',
            'headmaster_signature' => !empty($settings['headmaster_signature']) ? base_url($settings['headmaster_signature']) : null,
            'signature_raw' => $settings['headmaster_signature'] ?? null,
        ];

        return $cache;
    }
}
if (!function_exists('unread_notifications')) {
    function unread_notifications()
    {
        if (!session()->get('id')) return ['count' => 0, 'recent' => []];
        
        $userId = session()->get('id');
        $cacheKey = 'notif_' . $userId;
        
        $cached = cache($cacheKey);
        if ($cached !== null) {
            return $cached;
        }
        
        $notificationModel = new \App\Models\NotificationModel();
        $result = [
            'count' => $notificationModel->getUnreadCount($userId),
            'recent' => $notificationModel->getRecent($userId, 5)
        ];
        
        cache()->save($cacheKey, $result, 30);
        
        return $result;
    }
}

if (!function_exists('get_photo_url')) {
    /**
     * Get correct photo URL for both local and remote paths
     */
    function get_photo_url($path)
    {
        if (empty($path)) return null;
        
        // If it starts with http or https, it's a remote URL
        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }
        
        // Otherwise use base_url
        return base_url($path);
    }
}

if (!function_exists('get_active_academic_year')) {
    /**
     * Get currently active academic year
     */
    function get_active_academic_year()
    {
        static $activeYear = null;
        
        if ($activeYear !== null) {
            return $activeYear;
        }

        $model = new \App\Models\AcademicYearModel();
        $activeYear = $model->where('status', 'Active')->first();
        
        return $activeYear;
    }
}

if (!function_exists('get_academic_year_display')) {
    /**
     * Get formatted academic year display string
     */
    function get_academic_year_display()
    {
        $activeYear = get_active_academic_year();
        if (!$activeYear) {
            return 'Periode Aktif Belum Diatur';
        }

        return $activeYear['semester'] . ' ' . $yearDisplay = $activeYear['year'];
    }
}

if (!function_exists('get_semester_id')) {
    /**
     * Map semester name to ID (1 or 2)
     */
    function get_semester_id($semesterName = null)
    {
        if ($semesterName === null) {
            $activeYear = get_active_academic_year();
            $semesterName = $activeYear['semester'] ?? 'Ganjil';
        }
        
        return ($semesterName == 'Ganjil') ? '1' : '2';
    }
}

if (!function_exists('get_assessment_weights')) {
    /**
     * Get assessment weights for Tasks, UTS, and UAS
     */
    function get_assessment_weights()
    {
        return [
            'tugas' => (float)get_setting('weight_tugas', 40) / 100,
            'uts'   => (float)get_setting('weight_uts', 30) / 100,
            'uas'   => (float)get_setting('weight_uas', 30) / 100
        ];
    }
}

