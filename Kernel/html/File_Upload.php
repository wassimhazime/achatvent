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

use Kernel\Router\Router;
use Psr\Http\Message\ServerRequestInterface;
use const ROOT;
use function date;
use function preg_match;
use function scandir;
use function str_replace;

class File_Upload {

    private $path;
    private $preffix;
    private $router;

    function setPreffix($preffix) {
        $this->preffix = $preffix;
    }

    function getRouter(): Router {
        return $this->router;
    }

    function __construct(Router $router, string $path) {
        $this->path = $path;
        $this->router = $router;
    }

    public function get($id_image) {
        $images = [];
        preg_match('/([a-zA-Z\$]+)_(.+)/i', $id_image, $matches);

        if (empty($matches)) {
            return $images;
        }
       $preffix = $matches[1];
       
        $dir_imageupload = ROOT . $this->path . $preffix;
        
        if (is_dir($dir_imageupload)) {

            foreach (scandir($dir_imageupload) as $imagesave) { /// scan les image save
                $subject = str_replace("$", "", $imagesave);
                $id_image = str_replace("$", "", $id_image);

                $pattern = '/^' . $id_image . '/';
                if (preg_match($pattern, $subject)) {
                    $images[] = $this->path . $preffix . D_S . $imagesave;
                }
            }
            return $images;
        }
    }

    public function save(string $nameRoute, ServerRequestInterface $request, string $preffix = ""): ServerRequestInterface {
        $this->setPreffix($preffix);
        $insert = $request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();

        $this->mkdir_is_not($preffix);

        $id_image = $this->preffix . "_" . date("Y-m-d-H-i-s");

        foreach ($uploadedFiles as $key => $files) {
            foreach ($files as $file) {
                $this->insert_file_upload($preffix, $file, $id_image);
            }

            $insert[$key] = $this->generateUrisave($nameRoute, $id_image);
        }

        return $request->withParsedBody($insert);
    }

    public function save_child(string $nameRoute, ServerRequestInterface $request, array $datachild, string $preffix = ""): array {
        $this->setPreffix($preffix);
        $uploadedFiles = $request->getUploadedFiles();

        $this->mkdir_is_not($preffix);

        foreach ($uploadedFiles as $key => $file) {
            //exemple image_child_5 ==> 5 regex get nombre  index  and input  image
            preg_match('/([\D\d]+)_(.+)_(\d+)/i', $key, $matches);
            $input = $matches[1];
            $index = $matches[3];

            $id_image = $this->preffix . "_" . date("Y-m-d-H-i-s") . "_" . $index;
            $this->insert_file_upload($preffix, $file, $id_image);

            $datachild[$index][$input] = $this->generateUrisave($nameRoute, $id_image);
        }

        return $datachild;
    }

    private function generateUrisave(string $nameRoute, string $id_image): string {
        $url = $this->getRouter()->generateUri($nameRoute, ["controle" => $id_image]);
        return '<a class="btn "  role="button" href="' . $url . '" > <spam class="glyphicon glyphicon-download-alt"></spam></a>';
    }

    private function insert_file_upload($preffix, $file, $id_image) {
        if ($file->getClientFilename() != "") {
            /// insert file upload
            $name = $id_image . "_" . $file->getClientFilename();
            $file->moveTo($this->path . $preffix . D_S . $name);
        }
    }

    private function mkdir_is_not($preffix) {
        if (!is_dir($this->path . $preffix) && !mkdir($this->path . $preffix, 0777, true)) {
            die('Echec lors de la création des répertoires...');
        }
    }

}
