<?php

namespace App\Http\Controllers\Admin;

use   App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Trait\BackupTrait;
class BackupController extends Controller
{

    use BackupTrait;
    //
    public function index(){
        return view('admin.backup.index');
    }

    public function backupDatabase()
    {


        $filePath = $this->backupDatabaseTrait();
        if ($filePath) {
            return $this->downloadBackup($filePath);
            Alert::error('success' , 'Export Done Successfully !');
            return redirect()->back();
        }
        Alert::error('error' , 'Can Not Export Database');
        return redirect()->back();


    }


    public function backupFolder(Request $request)
    {
        $folderPath = $request->input('public', base_path()); // Default to project root if not provided
        $filePath = $this->backupFolderTrait($folderPath);

        if ($filePath) {
             $this->downloadBackup($filePath);
            Alert::error('success' , 'Download Done Successfully !');
            return redirect()->back();
        }
        Alert::error('error' , 'Can Not Download File');
        return redirect()->back();    }





}
