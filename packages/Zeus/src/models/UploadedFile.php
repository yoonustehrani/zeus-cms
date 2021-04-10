<?php

namespace Zeus\Models;

use Illuminate\Http\UploadedFile as UploadedFileType;
class UploadedFile
{
    protected $file;
    public $file_name;
    public $file_upload_name;
    public $path;
    public $file_path;
    public $thumbnail_path;
    public $desired_folder;
    public $thumbnailable = false;
    private $upload_path;

    public function __construct(UploadedFileType $file, $type)
    {
        $this->file = $file;
        $this->thumbnailable = $type == 'image';
        $type_folders = ['image' => 'images/gallery'];
        $this->path = $type_folders[$type];
        $this->desired_folder = public_path();
    }
    public function make_thumbnail($image, $width = 100, $height = 100)
    {
        return $image->resize($width, $height, function($constraint) {
            $constraint->upsize();
        });
    }
    public function prepare_for_upload()
    {
        $this->make_file_name()->make_file_path();
        if ($this->thumbnailable) {
            $this->make_thumbnail_path();
        }
        return $this;
    }
    public function upload($thumbnail = false)
    {
        $image = \Image::make($this->file);
        $image->save(public_path($this->file_path));
        if ($this->thumbnailable) {
            $this->make_thumbnail($image, 200, 200)->save(public_path($this->thumbnail_path));
        }
    }
    public function make_uuid()
    {
        return \Illuminate\Support\Str::uuid();
    }
    public function make_file_path()
    {
        $file_path = "{$this->file_upload_name}.{$this->file->getClientOriginalExtension()}";
        $this->file_path = $this->path . DIRECTORY_SEPARATOR . $file_path;
        return $this;
    }
    public function make_thumbnail_path()
    {
        $file_path = "tn__{$this->file_upload_name}.{$this->file->getClientOriginalExtension()}";
        $this->thumbnail_path = $this->path . DIRECTORY_SEPARATOR . $file_path;
        return $this;
    }
    public function make_file_name($pure_name = false)
    {
        $file_extension = '.' . $this->file->getClientOriginalExtension();
        $file_name = $this->file->getClientOriginalName();
        $file_name = $file_name == $file_extension ? "new_file_{$this->make_uuid()}{$file_extension}" : $file_name;
        $file_name = substr($file_name, 0, (strlen($file_name) - strlen($file_extension)));
        $this->file_name = $file_name;
        $this->file_upload_name = $file_name . "_" . time();
        return $this;
    }
}