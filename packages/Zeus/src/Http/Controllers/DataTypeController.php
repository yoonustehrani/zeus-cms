<?php

namespace Zeus\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Zeus\Database\Schema\ZeusSchemaManager;
use Zeus\Models\DataRow;
use Zeus\Models\DataType;
use Zeus\Models\Menu;

class DataTypeController extends Controller
{
    public $types = [
        'text' => 'TextInput',
        'password' => 'Password Input',
        'email' => 'Email Input',
        'number' => 'Number Input',
        'textarea' => 'Textarea Field',
        'date' => 'Date Picker',
        'datetime' => 'DateTime Picker',
        'radio' => 'Radio Button',
        'checkbox' => 'Checkbox',
        'richtext' => 'Rich Text Editor',
        'relationship__hasOne' => 'Has One Relationship',
        'relationship__hasMany' => 'Has Many Relationship',
        'relationship__belongsTo' => 'Belongs To Relationship',
        'relationship__belongsToMany' => 'Belongs To Many Relationship',
        'relationship__morphOne' => 'Morph One Relationship',
        'relationship__morphMany' => 'Morph Many Relationship',
    ];
    public $relations = [
        'hasOne',
        'hasMany',
        'belongsTo',
        'belongsToMany',
        'morphOne',
        'morphMany',
    ];
    public $visibility = [
        'browse' => 'field will show up when you browse the current data',
        'read' => 'field will show when you click to view the current data',
        'edit' => 'field will be visible and allow you to edit the data',
        'add'  => 'field will be visible when you choose to create a new data type'
    ];
    protected function display_name($name)
    {
        $name = str_replace('_', ' ', $name);
        $name = ucfirst($name);
        return $name;
    }
    protected function visiblities_for_column($column_type, $column_name)
    {
        $visiblities = [];
        foreach ($this->visibility as $visibility => $detail) {
            if ($column_name == 'id' || $column_name == 'updated_at') {
                $visiblities[$visibility] = [false, $detail];
            } elseif($column_name == 'created_at') {
                $visiblities[$visibility] = ($visibility == 'add') ? [false, $detail] : [true, $detail];
            } else {
                $visiblities[$visibility] = [true, $detail];
            }
        }
        return $visiblities;
    }
    protected function type_for_column($column_type, $column_name)
    {
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
                'field' => $detail['name'],
                'type' => $detail['type'],
                'display_name' => $this->display_name($detail['name']),
                'auto' => $detail['autoincrement'],
                'default' => $detail['default'],
                'required' => $detail['notnull'],
                'length' => $detail['length'],
                'suggested_type' => $this->type_for_column($detail['type'], $detail['name']),
                'visiblities' => $this->visiblities_for_column($detail['type'], $detail['name'])
            ];
            $default_rows->push($info);
        }
        $types = $this->types;
        $scopes = null;
        return view('ZEV::pages.datatype.create',compact('table', 'types', 'scopes','default_rows'));
    }
    public function edit($table)
    {
        $datatype = DataType::whereSlug($table)->with('rows')->firstOrFail();
        $types = $this->types;
        $scopes = null;
        $visibilities = $this->visibility;
        return view('ZEV::pages.datatype.edit',compact('datatype', 'types', 'scopes', 'visibilities'));
    }
    public function store(Request $request, $table)
    {
        abort_if(! (! \Zeus::model('DataType')::where('slug', $table)->first() && ZeusSchemaManager::tableExists($table)), 404);
        $request->validate([
            'name' => 'required|string|min:3|max:60',
            'slug' => 'required|string|min:3|max:60|unique:data_types',
            'display_name_singular' => 'required|string|min:3|max:60',
            'display_name_plural' => 'required|string|min:3|max:60',
            'model_name' => 'required|string|min:3|max:60',
            'policy_name' => 'max:60',
            'controller' => 'max:60',
            'model_name' => 'max:60',
        ]);
        try {
            DB::beginTransaction();
            $datatype = new DataType;
            $datatype->name = $request->name;
            $datatype->slug = $request->slug;
            $datatype->display_name_singular = $request->display_name_singular;
            $datatype->display_name_plural = $request->display_name_plural;
            $datatype->icon = $request->icon;
            $datatype->model_name = $request->model_name;
            $datatype->policy_name = $request->policy_name;
            $datatype->controller = $request->controller;
            $datatype->description = $request->description;
            $datatype->details = json_decode($request->details) ?: [];
            $special_fields = ['server_side', 'generate_permission'];
            foreach ($special_fields as $field) {
                $datatype->{$field} = (! isset($request->{$field})) ? false : true;
            }
            $datatype->pushToDetails($request);
            $datatype->save();
            
            if ($datatype->save()) {

                $datatype->createDataRows($request->all());
                $menu = \Zeus::getModel('App\Menu')->whereName(config('ZEC.menus.main'))->firstOrFail();
                $menuItem = \Zeus::getModel('App\MenuItem');
                $menuItem = new $menuItem;
                $menuItem->title =  $datatype->display_name_plural;
                $menuItem->icon_class = $datatype->icon;
                $menuItem->order = $menu->generate_order();
                $menuItem->route = "RomanCamp.{$datatype->slug}.index";
                $menu->items()->create($menuItem->toArray());
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return redirect()->to(route('RomanCamp.database.index'));
    }
    public function update(Request $request, $slug)
    {
        $datatype = DataType::whereSlug($slug)->with('rows')->firstOrFail();
        $request->validate([
            'name' => 'required|string|min:3|max:60',
            'slug' => 'required|string|min:3|max:60|unique:data_types,id,' . $datatype->id,
            'display_name_singular' => 'required|string|min:3|max:60',
            'display_name_plural' => 'required|string|min:3|max:60',
            'model_name' => 'required|string|min:3|max:60',
            'policy_name' => 'max:60',
            'controller' => 'max:60',
            'model_name' => 'max:60',
        ]);
        try {
            DB::beginTransaction();
            $datatype->name = $request->name;
            $datatype->slug = $request->slug;
            $datatype->display_name_singular = $request->display_name_singular;
            $datatype->display_name_plural = $request->display_name_plural;
            $datatype->icon = $request->icon;
            $datatype->model_name = $request->model_name;
            $datatype->policy_name = $request->policy_name;
            $datatype->controller = $request->controller;
            $datatype->description = $request->description;
            $datatype->details = json_decode($request->details) ?: [];
            $special_fields = ['server_side', 'generate_permission'];
            foreach ($special_fields as $field) {
                $datatype->{$field} = (! isset($request->{$field})) ? false : true;
            }
            $datatype->pushToDetails($request);
            
            if ($datatype->save()) {
                $datatype->updateDataRows($request->all());
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return redirect()->to(route('RomanCamp.datatypes.edit', ['datatype' => $datatype->slug]));
    }
    public function show($slug)
    {
        $datatype = DataType::whereSlug($slug)->with('columns')->firstOrFail();
        $details  = (array) $datatype->details;
        try {
            $model = app($datatype->model_name);
            if ($details) {
                $orderBy = isset($details['order_column']) ? $details['order_column'] : false;
                $orderDir = (isset($details['order_direction']) && $details['order_direction'] == 'desc') ? 'desc' : 'asc'; 
                if ($orderBy) {
                    $model = $model->orderBy($orderBy, $orderDir);
                }
                if ($datatype->server_side) {
                    $target_rows = (isset($details['paginate']) && is_numeric($details['paginate'])) ? $model->paginate($details['paginate']) : $model->paginate(20);
                } else {
                    $target_rows = $orderBy ? $model->get() : $model->all();
                }
                
            } else {
                $target_rows = $model->all();
            }
            return $target_rows;
        } catch(\Exception $e) {
            throw $e;
            // abort(403, 'Model Name Not Right');
        }
    }
}
