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
        $datarow  = $datatype->rows()->findOrFail($datarow);
        $relations = [
            'hasOne',
            'hasMany',
            'belongsTo',
            'belongsToMany'
        ];
        // $datarow->type = 'relationship__' . $relations[2];
        // $datarow->required = false;
        // $details = ((array) $datarow->details);
        // $details['target_model'] = 'App\\File';
        // $datarow->details = json_decode($datarow->details);
        // $fakeDetails = 
        // $datarow->details = 'App\\File';
        // $datarow->save();
        // return $datarow;
    }
}