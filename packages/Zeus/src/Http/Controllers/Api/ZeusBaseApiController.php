<?php

namespace Zeus\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ZeusBaseApiController extends Controller
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
                $limit = $request->query('limit') ?? 10;
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

                if ($request->query('q') && method_exists($datatype->model_name, 'scopeSearch')) {
                    $model = $model->search($request->query('q'), null, true);
                }

                if ($datatype->server_side && !$request->query('limit') ) {
                    $data = (isset($details['paginate']) && is_numeric($details['paginate'])) ? $model->paginate($details['paginate']) : $model->paginate(20);
                } else {
                    $data = $orderBy ? $model->limit($limit)->get() : $model->all();
                }
                
            } else {
                $data = $model->all();
            }
            return $data;
        } catch(\Exception $e) {
            throw $e;
            // abort(403, 'Model Name Not Right');
        }
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
    public function show($id)
    {
        // return $id;
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

    protected function getDataType($slug) {
        return \Zeus::model('DataType')->whereSlug($slug);
    }
    protected function getSlug($request)
    {
        if (isset($this->slug)) {
            $slug = $this->slug;
        } else {
            $slug = explode('.', $request->route()->getName())[2];
        }
        return $slug;
    }
}