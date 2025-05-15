<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Log;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = Log::with('user')->orderBy('created_at', 'desc');
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');    
            $query->where(function($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('model_type', 'like', "%{$search}%")
                  ->orWhere('model_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%");  
                  });
            });
        }
        
        $logs = $query->paginate(20);
        
        return view('admin.logs.index', ['logs' => $logs]);
    } //end index


    public function show(Log $log)
{
    $log->load('user');
   
    return view('admin.logs.show', [
        'log' => $log,
        'modelName' => class_basename($log->model_type),
        'changes' => $this->formatChanges($log->changes)
    ]);
}

private function formatChanges($changes)
{
    if (!is_array($changes)) {
        return $changes;
    }

    $formatted = [];
    
    foreach ($changes as $key => $value) {
        if (is_array($value)) {
            $formatted[$key] = $value;
        } else {
            $formatted[$key] = $value;
        }
    }
    
    return $formatted;
}



public function delete(Log $log)
{
    $log->delete();
    Alert::success('Success', 'Log deleted successfully.');
    return redirect()->route('admin.logs.index');


}



public function userLogs(Request $request)
{
    $query = Log::with('user')->where('user_id', auth()->id())->orderBy('created_at', 'desc');
    $logs = $query->paginate(20);
    
    return view('admin.logs.user_logs', ['logs' => $logs]);



}


}