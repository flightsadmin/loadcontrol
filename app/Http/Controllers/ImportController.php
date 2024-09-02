<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{
    public function showForm()
    {
        return view('imports.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'sql_file' => 'required|file|max:2048', // Ensure the file is a SQL file and within size limit
        ]);

        $file = $request->file('sql_file');
        $path = $file->store('sql_imports');

        try {
            $sql = Storage::get($path);

            if (stripos($sql, 'CREATE DATABASE') !== false) {
                preg_match('/CREATE DATABASE `(.+?)`/', $sql, $matches);
                $databaseName = $matches[1] ?? null;

                if ($databaseName) {
                    DB::statement("CREATE DATABASE IF NOT EXISTS `$databaseName`");

                    DB::statement("USE `$databaseName`");
                }
            }

            DB::transaction(function () use ($sql) {
                DB::unprepared($sql);
            });

            Storage::delete($path);

            return redirect()->back()->with('success', 'Database import successful.');
        } catch (\Exception $e) {
            \Log::error('Database import failed: ' . $e->getMessage());

            Storage::delete($path);

            return redirect()->back()->with('error', 'Database import failed. Please check the logs.');
        }
    }
}
