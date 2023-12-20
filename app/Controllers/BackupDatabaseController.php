<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class BackupDatabaseController extends BaseController
{
    public function backup()
    {

        $dbConfig = config('Database');
        $user = escapeshellarg($dbConfig->default['username']);
        $password = escapeshellarg($dbConfig->default['password']);
        $database = escapeshellarg($dbConfig->default['database']);
        $backupDir = WRITEPATH . 'backups/';
        $backupFile = 'db-backup-today' . '.sql';
        $backupPath = escapeshellarg($backupDir . $backupFile);

        // Ensure the backup directory exists
        if (!is_dir($backupDir) && !mkdir($backupDir, 0755, true)) {
            return $this->response->setStatusCode(500)->setBody('Error: Could not create backup directory.');
        }

        // The password should not have any space between -p and $password
        $command = "mysqldump -u {$user} -p{$password} --databases {$database} > {$backupPath}";

        exec($command, $output, $return);

        if ($return !== 0) {
            log_message('error', "Backup failed with return code {$return} and output: " . print_r($output, true));
            return $this->response->setStatusCode(500)->setBody('Error during backup: ' . print_r($output, true));
        }

        // Return success response or offer the file for download
        // If you want to offer the file for download, you should implement additional logic here
        return $this->response->setStatusCode(200)->setBody('Backup completed successfully. File: ' . $backupFile);
    }
}
