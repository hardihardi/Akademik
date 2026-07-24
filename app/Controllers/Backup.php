<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Backup extends BaseController
{
    public function download()
    {
        $db = \Config\Database::connect();
        $tables = $db->listTables();
        $output = "-- Database Backup --\n";
        $output .= "-- Generated: " . date('Y-m-d H:i:s') . " --\n\n";

        foreach ($tables as $table) {
            $output .= "-- Table: $table --\n";
            $output .= "DROP TABLE IF EXISTS `$table`;\n";
            
            $createTable = $db->query("SHOW CREATE TABLE `$table`")->getRowArray();
            $output .= $createTable['Create Table'] . ";\n\n";

            $rows = $db->table($table)->get()->getResultArray();
            foreach ($rows as $row) {
                $output .= "INSERT INTO `$table` VALUES (";
                $values = [];
                foreach ($row as $val) {
                    $values[] = $db->escape($val);
                }
                $output .= implode(", ", $values);
                $output .= ");\n";
            }
            $output .= "\n";
        }

        $filename = 'backup_akademik_' . date('Y-m-d_H-i-s') . '.sql';

        return $this->response->download($filename, $output);
    }
}
