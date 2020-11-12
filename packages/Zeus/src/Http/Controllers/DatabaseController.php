<?php

namespace Zeus\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Zeus\Database\Schema\ZeusSchemaManager;
use Zeus\Facades\ZeusFacade;

class DatabaseController extends Controller
{
    public function index()
    {
        $dataTypes = ZeusFacade::model('DataType')->select('id', 'name', 'slug')->get()->keyBy('name')->toArray();
        $tables_list = ZeusSchemaManager::listTableNames();
        $new_tables_list = collect([]);
        $must_delete_tables = config('ZEC.database.hidden_tables');
        for ($i=0; $i < count($tables_list); $i++) {
            if (! in_array($tables_list[$i], $must_delete_tables)) {
                $new_tables_list->push($tables_list[$i]);
            }
        }
        $tables = array_map(function ($table) use ($dataTypes) {
            $table = \Illuminate\Support\Str::replaceFirst(DB::getTablePrefix(), '', $table);
            $table = [
                'prefix'     => DB::getTablePrefix(),
                'name'       => $table,
                'slug'       => $dataTypes[$table]['slug'] ?? null,
                'dataTypeId' => $dataTypes[$table]['id'] ?? null,
            ];
            return (object) $table;
        }, $new_tables_list->toArray());
        // return $tables;
        return view('ZEV::pages.database.index', compact('tables'));
    }
}
