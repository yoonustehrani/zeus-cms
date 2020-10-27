<?php

namespace Zeus\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ZeusBaseController extends Controller
{
    public function getSlug(Request $request)
    {
        if (isset($this->slug)) {
            $slug = $this->slug;
        } else {
            $slug = explode('.', $request->route()->getName())[1];
        }

        return $slug;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $slug = $this->getSlug($request);
        $dataType = \Zeus::model('DataType')->with('columns')->where('slug', '=', $slug)->first();
        $model = \Zeus::getModel($dataType->model_name);
		$data  = ($dataType->server_side) ? $model->paginate(20) : $model::all();
        return view('ZEV::components.index', compact('data', 'dataType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		$slug = $this->getSlug($request);
		$dataType = \Zeus::model('DataType')->with('rows')->where('slug', '=', $slug)->first();
        return $dataType;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $slug = $this->getSlug($request);
        $dataType = \Zeus::model('DataType')->where('slug', '=', $slug)->first();
        $model = \Zeus::getModel($dataType->model_name);
        return $model::whereId($id)->firstOrFail();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $slug = $this->getSlug($request);
        $dataType = \Zeus::model('DataType')->with(['columns' => function($q) {
            $q->where('edit', true);
        }])->where('slug', '=', $slug)->first();
        $model = \Zeus::getModel($dataType->model_name);
        $editable = $model::whereId($id)->firstOrFail();
        return [$editable->toArray(), $dataType->toArray()];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}