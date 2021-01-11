<?php

namespace Zeus\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Zeus\Models\DataRow;
use Zeus\Models\DataType;

class DataRowController extends Controller
{
    public function create(Request $request, $datatype)
    {
        if ($request->type == 'relationship') {
            $datatype = DataType::with(['rows' => function($q) {
                $q->where('field', 'LIKE', '%_id%');
            }])->findOrFail($datatype);
            return view('ZEV::pages.datatype.create-rel', compact('datatype'));
        }
        $datatype = DataType::findOrFail($datatype);
        return view('ZEV::pages.datatype.create-rows', compact('datatype'));
    }
    public function edit($datatype, $datarow)
    {
        $datatype = DataType::findOrFail($datatype);
        // $datarow = new DataRow();
        // $datarow->field = "permissions";
        // $datarow->required = false;
        // $datarow->type  = "relationship__belongsToMany";
        // $datarow->display_name = "Permissions";
        // $datarow->details = [];
        // $datarow->order = 5;
        // $datatype->rows()->create($datarow->toArray());
        // return $datarow;
        // $datarow  = $datatype->rows()->findOrFail($datarow);
        // $relations = [
        //     'hasOne',
        //     'hasMany',
        //     'belongsTo',
        //     'belongsToMany'
        // ];
        // $datarow->type = 'relationship__' . $relations[2];
        // $datarow->required = false;
        // $details = ((array) $datarow->details);
        // $details['target_method'] = 'file';        
        // $datarow->details = json_decode($datarow->details);
        // $fakeDetails = 
        // $datarow->details = 'App\\File';
        // $datarow->save();
        // return $datarow;
    }
}