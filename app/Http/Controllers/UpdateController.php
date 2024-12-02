<?php

namespace App\Http\Controllers;
use App\Models\Migration;
use Illuminate\Support\Facades\Artisan;

class UpdateController extends Controller
{
    public function index()
    {
        return view('update.index', ['view' => 'update.welcome']);
    }
    public function overview()
    {
        $migrations = $this->getMigrations();
        $executedMigrations = $this->getExecutedMigrations();

        return view('update.index', ['view' => 'update.overview', 'updates' => count($migrations) - count($executedMigrations)]);
    }
    public function complete()
    {
        return view('update.index', ['view' => 'update.complete']);
    }
    public function updateDatabase()
    {
        $migrateDatabase = $this->migrateDatabase();
        if ($migrateDatabase !== true) {
            return back()->with('error', __('Failed to migrate the database. ' . $migrateDatabase));
        }

        return redirect()->route('update.complete');
    }
    private function getMigrations()
    {
        $migrations = scandir(database_path().'/migrations');

        $output = [];
        foreach($migrations as $migration) {
            // Select only the .php files
            if($migration != '.' && $migration != '..' && substr($migration, -4, 4) == '.php') {
                $output[] = str_replace('.php', '', $migration);
            }
        }

        return $output;
    }
    private function getExecutedMigrations()
    {
        return Migration::all()->pluck('migration');
    }
    private function migrateDatabase()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            Artisan::call('config:clear');

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
