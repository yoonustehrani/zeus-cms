<?php

namespace Zeus\Extentions;

abstract class Extention
{
    public static function list_extentions()
    {
        $extentions = collect([]);
        $folders = self::list_folders(__DIR__);
        foreach ($folders as $path) {
            if (! file_exists($path . DIRECTORY_SEPARATOR . 'extention_info.json')) {
                continue;
            }
            $content = file_get_contents($path . DIRECTORY_SEPARATOR . 'extention_info.json');
            $extentions->push(json_decode($content));
        }
        return ($extentions);
    }
    protected static function list_folders($dir)
    {
        $scanned_dir = scandir($dir);
        $folders = collect([]);
        foreach ($scanned_dir as $name) {
            $filtered = ['.', '..'];
            $path = $dir . DIRECTORY_SEPARATOR . $name;
            if (! in_array($name, $filtered) && is_dir($path)) {
                $folders->push($path);
            }
        }
        return $folders;
    }
}