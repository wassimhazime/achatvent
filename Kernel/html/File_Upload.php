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
;

use Psr\Http\Message\ServerRequestInterface;

class File_Upload {

    private $path;
    private $preffix;

    function setPreffix($preffix) {
        $this->preffix = $preffix;
    }

    function __construct($path ) {
        $this->path = $path;
        
    }

    public function get($id_image) {


        $images = [];
        foreach (scandir(ROOT . $this->path) as $imagesave) { /// scan les image save
            $subject = str_replace("$", "", $imagesave);
            $id_image = str_replace("$", "", $id_image);

            $pattern = '/^' . $id_image . '/';
            if (preg_match($pattern, $subject)) {
                $images[] = $this->path . $imagesave;
            }
        }
        return $images;
    }

    public function save(ServerRequestInterface $request, string $preffix = ""): ServerRequestInterface {
        $this->setPreffix($preffix);
        $insert = $request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();
        $id_image = $this->preffix . "_" . date("Y-m-d-H-i-s");
        
        foreach ($uploadedFiles as $key => $files) {
            foreach ($files as $file) {
                if ($file->getClientFilename() != "") {
                    /// insert file upload
                    $name = $id_image . "_" . $file->getClientFilename();
                    $file->moveTo($this->path . $name);
                }
            }
            $insert[$key] = '<a class="btn btn-default"  role="button" href="/files/' . $id_image . '" >les fichiers</a>';
        }

        return $request->withParsedBody($insert);
    }

    public function save_child(ServerRequestInterface $request, array $datachild, string $preffix = "") : array{
        $this->setPreffix($preffix);
        $uploadedFiles = $request->getUploadedFiles();

        foreach ($uploadedFiles as $key => $file) {
            //exemple image_child_5 ==> 5 regex get nombre  index  and input  image
            preg_match('/([\D\d]+)_(.+)_(\d+)/i', $key, $matches);
            $input = $matches[1];
            $index = $matches[3];
            
            $id_image = $this->preffix . "_" . date("Y-m-d-H-i-s") . "_" . $index;
            if ($file->getClientFilename() != "") {
                /// insert file upload
                $name = $id_image . "_" . $file->getClientFilename();
                $file->moveTo($this->path . $name);
            }
            $datachild[$index][$input] = '<a class="btn btn-default"  role="button" href="/admin/files/' . $id_image . '" > fichier</a>';
        }

        return $datachild;
    }

}
