<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

class ImportController extends Controller
{
    // Students
    public function showStudents()
    {
        return view('admin.import.users', ['role' => 'student']);
    }

    public function handleStudents(Request $request)
    {
        return $this->handle($request, 'student');
    }

    // Teachers
    public function showTeachers()
    {
        return view('admin.import.users', ['role' => 'teacher']);
    }

    public function handleTeachers(Request $request)
    {
        return $this->handle($request, 'teacher');
    }

    // Core handler
    private function handle(Request $request, string $role)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        $import = new UsersImport($role);

        try {
            Excel::import($import, $request->file('file'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Import failed: '.$e->getMessage());
        }

        return back()->with(
            'success',
            "Import done. Created: {$import->created}, Updated: {$import->updated}, Skipped: {$import->skipped}"
        );
    }
}
