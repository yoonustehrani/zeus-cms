<?php

namespace Zeus\Http\Controllers;

use App\Http\Controllers\Controller;
use Zeus\Extentions\EmailMarketingSystem;
use Zeus\Models\Extention;
// 
class ExtentionController extends Controller
{
    public function index()
    {
        $datatype = \Zeus::model('DataType')->whereSlug('extentions')->with('columns')->first();
        $extentions_lists = EmailMarketingSystem::list_extentions();
        $extentions = Extention::all();
        $extentions_array = $extentions->map(function($ext) {
            return strtolower($ext->title);
        })->toArray();
        $not_installed = $extentions_lists->filter(function($extention) use($extentions_array) {
            return ! in_array(strtolower($extention->name), $extentions_array);
        });
        foreach ($not_installed as $i_extention) {
            $extention = new Extention;
            $extention->title = optional($i_extention)->name;
            $extention->version = optional($i_extention)->version ?: '1.0.0';
            $extention->slug = \Illuminate\Support\Str::slug(strtolower(optional($i_extention)->name), '_');
            $extention->description = optional($i_extention)->description ?: '';
            $extention->details = [];
            if ($extention->save()) {
                $extentions->push($extention);
            }
        }
        $data = $extentions;
        return view('ZEV::pages.default.index', compact('datatype', 'data'));
    }
}