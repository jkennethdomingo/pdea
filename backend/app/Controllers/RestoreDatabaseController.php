<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class RestoreDatabaseController extends BaseController
{
    public function restore()
{
    $dbConfig = config('Database');

    // Specify the exact path to your backup file. 
    // This should match the location and file name of the backup file you want to restore.
    $backupFilePath = WRITEPATH . 'backups/db-backup-2023-11-27_05-27-47.sql';
    
    // Make sure the file exists
    if (!file_exists($backupFilePath)) {
        return $this->response->setStatusCode(400)->setBody('Backup file does not exist.');
    }

    $user = escapeshellarg($dbConfig->default['username']);
    $password = escapeshellarg($dbConfig->default['password']);
    $database = escapeshellarg($dbConfig->default['database']);
    
    // Command to restore database
    $command = "mysql -u {$user} -p{$password} {$database} < " . escapeshellarg($backupFilePath);

    exec($command, $output, $return);

    if ($return !== 0) {
        // Handle error, log it and/or return an error message
        log_message('error', "Database restore failed: " . print_r($output, true));
        return $this->response->setStatusCode(500)->setBody('Error during database restore: ' . print_r($output, true));
    }

    // Return success response
    return $this->response->setStatusCode(200)->setBody('Database restored successfully.');
}
}
