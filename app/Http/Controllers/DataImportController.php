<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DataImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'sql_file' => 'required|file|max:100480',
        ]);

        $file = $request->file('sql_file');
        $filePath = $file->store('sql_imports');
        $sql = Storage::get($filePath);
        $cleanSql = $this->removeComments($sql);
        $queries = explode(';', $cleanSql);

        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                try {
                    DB::statement($query);
                } catch (\Exception $e) {
                    Log::error('Error executing query: ' . $query . ' - Error: ' . $e->getMessage());
                }
            }
        }

        Storage::delete($filePath);

        return redirect()->back()->with('status', 'SQL file imported successfully!');
    }

    private function removeComments($sql)
    {
        // Remove single-line comments (-- or #)
        $sql = preg_replace('/^\s*(--|#).*/m', '', $sql);

        // Remove multi-line comments (/* ... */)
        $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);

        // Remove empty lines and extra spaces
        $sql = preg_replace('/\s+/', ' ', $sql);

        return $sql;
    }
}
