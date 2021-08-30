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
    public $route_prefix;
    public function __construct()
    {
        $this->route_prefix = config('ZEC.controllers.route_prefix');
    }
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
        $datatype = $this->getDataType($this->getSlug($request))->with('add_rows')->first();
        foreach ($datatype->add_rows as $row) {
            if ($row->relationship && $row->relationship->target_model && ! $row->relationship->dynamic) {
                switch ($row->relationship->type) {
                    case 'belongsTo':
                    case 'belongsToMany':
                        $data = \Zeus::getModel($row->relationship->target_model)->get();
                        $row->data = $data;
                        break;
                }
            }
        }
        if ($request->debug) {
            return $datatype;
        }
        return view('ZEV::pages.default.create', compact('datatype'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datatype = $this->getDataType($this->getSlug($request))->with('add_rows')->first();
        $request->validate($datatype->validation_rules($datatype->add_rows));
        try {
            \DB::beginTransaction();
            $model = \Zeus::getModel($datatype->model_name);
            $model = new $model;
            $model = $datatype->assign_value_to_instance($model, $datatype->add_rows, $request);
            if ($model->save()) {
                $datatype->assign_relationships($model, $datatype->add_rows, $request);
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }
        return redirect()->to(route("{$this->route_prefix}{$datatype->slug}.index"));
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
        try {
            $slug = $this->getSlug($request);
            $datatype = \Zeus::model('DataType')->with('edit_rows')->where('slug', '=', $slug)->first();
            $editable = \Zeus::getModel($datatype->model_name)::whereId($id)->firstOrFail();
            foreach ($datatype->edit_rows as $row) {
                if ($row->relationship && $row->relationship->target_model) {
                    $row->data = ! $row->relationship->dynamic ? \Zeus::getModel($row->relationship->target_model)->get() : [];
                    $editable->load([$row->relationship->local_method]);
                }
            }
        } catch(\Exception $e) {
            throw $e->getMessage();
        }
        if ($request->debug) {
            dd(
                'Datatype',
                $datatype->toArray(),
                'Editable',
                $editable->toArray()
            );
        }
        return view('ZEV::pages.default.edit', compact('editable', 'datatype'));
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
        $datatype = $this->getDataType($this->getSlug($request))->with('edit_rows')->first();
        $request->validate($datatype->validation_rules($datatype->edit_rows));
        $model = \Zeus::getModel($datatype->model_name);
        $editable = $model::whereId($id)->firstOrFail();
        $edited = $datatype->assign_value_to_instance($editable, $datatype->edit_rows, $request);
        if ($edited->save()) {
            $datatype->assign_relationships($edited, $datatype->add_rows, $request);
        }
        return redirect()->to(route("{$this->route_prefix}{$datatype->slug}.edit", ['id' => $edited->id]));
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
            return redirect()->to(route("{$this->route_prefix}{$datatype->slug}.index"));
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
