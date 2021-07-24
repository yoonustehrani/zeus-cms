<?php

namespace Zeus\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Rules\MustHaveExtension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Zeus\Models\File as ZeusFile;
use Zeus\Models\UploadedFile;

class FileManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'order' => [
                'nullable',
                Rule::in(['desc', 'asc'])
            ],
            'order_by' => [
                'nullable',
                Rule::in(['name', 'ext', 'type', 'created_at'])
            ],
            'type' => 'nullable|string'
        ]);
        
        $files = ($request->trash == 'true') ? ZeusFile::onlyTrashed() : new ZeusFile;
        

        if ($request->type && in_array($request->type, ['image', 'video', 'audio'])) {
            $files = $files->whereType($request->type);
        }

        if ($request->ext) {
            $files = $files->whereExt($request->ext);
        }

        /**
         * Types of orderby over $request
         * @param string order_by (name | ext | type)
         * @param string order (desc | asc)
        */
        if ($request->order_by) {
            $order = $request->order == 'desc' ? 'desc' : 'asc';
            $files = $files->orderBy($request->order_by, $order);
        }

        if ($request->query('q')) {
            $files = $files->search($request->query('q'), null, true);
        }

        return $files->paginate(12);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $type
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $type)
    {
        $types = ['image', 'video', 'audio'];
        $type_extentions = ['image' => 'jpeg,jpg,png,svg,gif'];
        if (! in_array($type, ['image'])) {
            abort(404);
        }
        $request->validate([
            'file' => [
                'required',
                'file',
                // 'lte:2048',
                "mimes:{$type_extentions[$type]}",
                new MustHaveExtension(explode(',', strtolower($type_extentions[$type])))
            ]
        ]);
        $file_uploaded = $request->file('file');
        $uploadedFile = new UploadedFile($file_uploaded, $type);
        $uploadedFile->prepare_for_upload();
        $file = new ZeusFile();
        $file->path = $uploadedFile->file_path;
        $file->thumbnail_path = $uploadedFile->thumbnail_path;
        $file->name = $uploadedFile->file_name;
        $file->type = $type;
        $file->ext = strtolower($file_uploaded->getClientOriginalExtension());
        if ($file->save()) {
            $uploadedFile->upload(
                $type == 'image'
            );
        }
        return $file;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $file
     * @return \Illuminate\Http\Response
     */
    public function show($file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $file)
    {
        $file = ($request->restore == 'true') ? ZeusFile::withTrashed()->findOrFail($file) : ZeusFile::findOrFail($file);

        if ($request->restore == 'true' && $file->deleted_at) {
            return ['okay' => $file->restore()];
        }

        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'ext'  => 'required|string',
            'path'  => 'required|string',
            'thumbnail_path'  => 'required|string',
        ]);

        $file->name = $request->name;
        $file->path = $request->path;
        $file->thumbnail_path = $request->thumbnail_path;
        $file->ext = $request->ext;
        
        $file->save();

        return $file;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$file)
    {
        $file = ($request->force_delete == 'true') ? ZeusFile::onlyTrashed()->findOrFail($file) : ZeusFile::findOrFail($file);
        if ($request->force_delete == 'true') {
            if($file->forceDelete()) {
                if (Storage::exists($file->path)) {
                    return ['okay' => Storage::delete($file->path)];
                }
                return ['okay' => true];
            }
            return ['okay' => false];
        }
        return ['okay' => $file->delete()];
    }
}
