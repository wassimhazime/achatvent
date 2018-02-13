<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of File
 *
 * @author wassime
 */

namespace Kernel\File;

class File
{

    const JSON = "json";

    private $path;
    private $type;
    private $is_null;

    function __construct(string $path, string $type = self::JSON, $is_null = null)
    {
        if ($path[-1] != DIRECTORY_SEPARATOR) {
            $path = $path . DIRECTORY_SEPARATOR;
        }

        $this->path = $path;
        $this->type = $type;
        $this->is_null = $is_null;
    }

    public function get($file)
    {

        $path_file = $this->path . $file . "." . $this->type;
        if (is_file($path_file)) {
            $file_contents = file_get_contents($path_file);
            return $this->decode($file_contents);
        }
        return $this->is_null;
    }

    public function set($contents, $file)
    {
        $path_file = $this->path . $file . "." . $this->type;


        $fp = fopen($path_file, 'w');
        fwrite($fp, $this->encode($contents));
        fclose($fp);
    }

    public function remove($file): bool
    {
        $path_file = $this->path . $file . "." . $this->type;
        if (is_file($path_file)) {
            return unlink($path_file);
        }
        return false;
    }

    private function decode(string $contents)
    {
        if ($this->type === self::JSON) {
            return json_decode($contents, true);
        }
        return $contents;
    }

    private function encode($contents)
    {
        if ($this->type === self::JSON) {
            return json_encode($contents);
        }
        return $contents;
    }
}
