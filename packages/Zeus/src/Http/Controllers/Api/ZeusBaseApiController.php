<?php

namespace Zeus\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Zeus\Traits\RequestProcess;

class ZeusBaseApiController extends Controller
{
    use RequestProcess;
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
            $details  = $datatype->details;
            if ($details) {
                $data = $this->index_process($request, $model, $datatype, $details);
            } else {
                $data = $datatype->pagination ? $model->paginate(10) : $model->all();
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