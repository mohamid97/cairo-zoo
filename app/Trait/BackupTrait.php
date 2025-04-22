<?php

namespace App\Trait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use ZipArchive;

trait BackupTrait
{


    public function backupDatabaseTrait()
    {

        $filename = 'database_backup_' . date('d-m-Y_H-i-s') . '.sql';

        $path = storage_path("backups/{$filename}");

        try {
            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }

            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');

            $command = sprintf(
                'mysqldump --user=%s --password=%s --host=%s %s > %s',
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                escapeshellarg($database),
                escapeshellarg($path)
            );

            exec($command, $output, $returnVar);


            if ($returnVar !== 1) {
                return false;
            }

            return $path;
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }



    public function backupFolderTrait()
    {
        $folderPath = public_path('uploads/images');
        $zipFilename = 'folder_backup_' . date('d-m-Y_H-i-s') . '.zip';
        $zipPath = storage_path("backups/{$zipFilename}");

        try {
            if (!file_exists($folderPath)) {
                throw new \Exception("Folder does not exist: {$folderPath}");
            }

            if (!file_exists(dirname($zipPath))) {
                mkdir(dirname($zipPath), 0755, true);
            }

            $zip = new ZipArchive();

            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($folderPath),
                    \RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($folderPath) + 1);

                        $zip->addFile($filePath, $relativePath);
                    }
                }

                $zip->close();
                return $zipPath;
            } else {
                throw new \Exception('Failed to create zip file');
            }
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }


    // download function

    public function downloadBackup(string $filePath)
    {
        if (!file_exists($filePath)) {
            return false;
        }

        response()->download($filePath)->send();
    }





}
