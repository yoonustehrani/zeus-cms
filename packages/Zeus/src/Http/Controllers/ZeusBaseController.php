<?php

namespace Zeus\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ZeusBaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datatype = $this->getDataType($this->getSlug($request))->with('columns')->first();
        try {
            $model = \Zeus::getModel($datatype->model_name);
            $details  = (array) $datatype->details;
            if ($details) {
                $orderBy = isset($details['order_column']) ? $details['order_column'] : false;
                if ($request->sort_by) {
                    $orderBy = $request->sort_by;
                }
                $orderDir = (isset($details['order_direction']) && $details['order_direction'] == 'desc') ? 'desc' : 'asc'; 
                if ($request->sort) {
                    $orderDir = $request->sort == 'asc' ? 'asc' : 'desc';
                }
                if ($orderBy) {
                    $model = $model->orderBy($orderBy, $orderDir);
                }
                if ($datatype->server_side) {
                    $data = (isset($details['paginate']) && is_numeric($details['paginate'])) ? $model->paginate($details['paginate']) : $model->paginate(20);
                } else {
                    $data = $orderBy ? $model->get() : $model->all();
                }
                
            } else {
                $data = $model->all();
            }
            return view('ZEV::pages.default.index', compact('data', 'datatype'));
        } catch(\Exception $e) {
            throw $e;
            // abort(403, 'Model Name Not Right');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		$datatype = $this->getDataType($this->getSlug($request))->with('addRows')->first();
        return $datatype;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datatype = $this->getDataType($this->getSlug($request))->with('rows')->first();
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
        $datatype = $this->getDataType($this->getSlug($request))->with('rows')->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $datatype = $this->getDataType($this->getSlug($request))->first();
        try {
            $model = \Zeus::getModel($datatype->model_name);
            $target = $model::whereId($id)->firstOrFail();
            $target->delete();
            return back();
        } catch(\Throwable $e) {
            throw $e;
        }
    }
    protected function getDataType($slug) {
        return \Zeus::model('DataType')->whereSlug($slug);
    }
    protected function getSlug($request)
    {
        if (isset($this->slug)) {
            $slug = $this->slug;
        } else {
            $slug = explode('.', $request->route()->getName())[1];
        }

        return $slug;
    }
}
