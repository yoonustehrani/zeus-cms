<?php

namespace Zeus\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Break_;
use Zeus\Database\Schema\ZeusSchemaManager;

class DataTypeController extends Controller
{
    public $types = ['text', 'password', 'email', 'number', 'textarea', 'date', 'datetime', 'radio', 'checkbox'];
    protected function display_name($name) {
        $name = str_replace('_', ' ', $name);
        $name = ucfirst($name);
        return $name;
    }
    protected function type_for_column($column_type, $column_name) {
        switch ($column_type) {
            case 'varchar':
                if ($column_name == 'email') return ['input','email'];
                if ($column_name == 'password') return ['input','password'];
                return ['input','text'];
                break;
            case 'text':
                return ['richtext', 'richtext'];
                break;
            case 'int':
            case 'integer':
            case 'bigint':
            case 'biginteger':
                return ['input','number'];
                break;
            case 'timestamp':
            case 'datetime':
                return ['datetimepicker','datetime'];
                break;
            case 'date':
                return ['datepicker','date'];
                break;
            case 'tinyint':
                return ['input','checkbox'];
                break;
            default:
                return ['input','text'];
        }
    }
    public function create(Request $request, $table)
    {
        abort_if(! (! \Zeus::model('DataType')::where('slug', $table)->first() && ZeusSchemaManager::tableExists($table)), 404);
        $tableDetails = ZeusSchemaManager::describeTable($table)->toArray();
        $default_rows = collect([]);
        foreach ($tableDetails as $detail) {
            $info = [
                'name' => $detail['name'],
                'type' => $detail['type'],
                'display_name' => $this->display_name($detail['name']),
                'auto' => $detail['autoincrement'],
                'default' => $detail['default'],
                'required' => $detail['notnull'],
                'length' => $detail['length'],
                'suggested_type' => $this->type_for_column($detail['type'], $detail['name'])
            ];
            // if ($detail['indexes']) {
            //     foreach ($detail['indexes'] as $key => $value) {
            //         if (! $value['isPrimary']) {
            //             $info['foreign'] = true;
            //         }
            //     }
            // }
            $default_rows->push($info);
        }
        if ($request->debug) {
            return $default_rows;
        }
        return view('ZEV::pages.datatype.create',compact('table','default_rows'));
    }
    public function store(Request $request, $table)
    {
        abort_if((\Zeus::model('DataType')::where('slug', $table)->first() && ZeusSchemaManager::tableExists($table)), 404);
        
        // $tableDetails = ZeusSchemaManager::describeTable($table)->toArray();
        // $default_rows = collect([]);
        // foreach ($tableDetails as $detail) {
        //     $info = [
        //         'name' => $detail['name'],
        //         'type' => $detail['type'],
        //         'display_name' => $this->display_name($detail['name']),
        //         'auto' => $detail['autoincrement'],
        //         'default' => $detail['default'],
        //         'required' => $detail['notnull'],
        //         'length' => $detail['length'],
        //         'suggested_type' => $this->type_for_column($detail['type'], $detail['name'])
        //     ];
        //     $default_rows->push($info);
        // }
        // if ($request->debug) {
        //     return $default_rows;
        // }
        // return view('ZEV::pages.datatype.create',compact('table','default_rows'));
    }
}
