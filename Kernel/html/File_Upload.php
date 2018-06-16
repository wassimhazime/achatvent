<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html;

/**
 * Description of File_Upload
 *
 * @author wassime
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class File_Upload
{
    private $path;
    private $preffix;
    function setPreffix($preffix)
    {
        $this->preffix = $preffix;
    }

    function __construct($path = "public/imageUpload/", $preffix = "")
    {
        $this->path = $path;
        $this->preffix = $preffix;
    }

    public function get($id_image)
    {
      
        $images = [];
        
        foreach (scandir(ROOT.$this->path) as $image) {
            $image = str_replace("$", " ", $image);
           
            $subject = $image;
             $id_image = str_replace("$", " ", $id_image);
            $pattern = '/^' . $id_image . '/';

            if (preg_match($pattern, $subject)) {
                $images[] = $this->path . $image;
            }
        }
       
        foreach ($images as $image) {
            $image = "/".str_replace(" ", "$", $image);
           
            echo '<center><a href="'. $image . '"><img src="'. $image . '" alt="fichier" style="width:300px;" /></a><br></center>
';
        }

        die();
    }

    public function set($request)
    {
       
        
        $insert = $request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();
        $id_image = $this->preffix . "_" . date("Y-m-d-H-i-s");

        foreach ($uploadedFiles as $key => $files) {
            foreach ($files as $file) {
                if ($file->getClientFilename() != "") {
                    /// insert file upload
                    $name = $id_image . "_" . $file->getClientFilename();
                    $file->moveTo($this->path .$name);
                } else {
                    /// pour update si no upload image ne faire rien
                    return $insert;
                }
            }
            
         
            $insert[$key] = '<a class="btn btn-default"  role="button" href="?imageview=' . $id_image . '" >les fichies</a>';
        }


        return $insert;
    }
}
