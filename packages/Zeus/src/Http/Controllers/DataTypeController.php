<?php

namespace Zeus\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Zeus\Database\Schema\ZeusSchemaManager;

class DataTypeController extends Controller
{
    public function create($table)
    {
        if (! \Zeus::model('DataType')::where('slug', $table)->first() && ZeusSchemaManager::tableExists($table)) {
            $tableDetails = ZeusSchemaManager::describeTable($table);
            return $tableDetails;
        }
        abort(404);
    }
}
