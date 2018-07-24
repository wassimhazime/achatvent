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

use Kernel\AWA_Interface\File_UploadInterface;
use Kernel\AWA_Interface\RouterInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use const D_S;
use const ROOT;
use function count;
use function date;
use function filesize;
use function is_dir;
use function is_file;
use function mime_content_type;
use function mkdir;
use function preg_match;
use function scandir;
use function str_replace;
use function strpos;
use function unlink;

class File_Upload implements File_UploadInterface{

    const FIN_REGEX = "_";

    private $path;
    private $preffix;
    private $router;

    public function __construct(RouterInterface $router, string $path) {
        $this->path = $path;
        $this->router = $router;
    }

    public function setPreffix($preffix) {
        $this->preffix = $preffix;
    }

    public function getRouter(): RouterInterface {
        return $this->router;
    }

    public function get(string $id_file): array {

        $files = [];
        $preffix = $this->get_preffix($id_file);

        $dir_filesUpload = ROOT . $this->path . $preffix;


        if (is_dir($dir_filesUpload)) {

            foreach (scandir($dir_filesUpload) as $file_save) { /// scan les image save
                $path = $this->path . $preffix . D_S . $file_save;
                $file = [];

                $is_match = $this->is_match($id_file, $file_save);
                $is_file = is_file($path);

                if ($is_match && $is_file) {
                    $file["name"] = $file_save;
                    $file["path"] = $path;
                    $mime = mime_content_type($file["path"]);

                    if (strpos($mime, "pdf") !== false) {
                        $file["type"] = 'pdf';
                    } elseif (strpos($mime, "image") !== false) {
                        $file["type"] = 'image';
                    } else {
                        $file["type"] = "file";
                    }


                    $file["size"] = (filesize($file["path"]) * 0.000001) . ' MB';

                    $files[] = $file;
                }
            }


            return $files;
        }
    }

    public function delete(string $id_file): array {

        $files = [];
        $preffix = $this->get_preffix($id_file);

        $dir_filesUpload = ROOT . $this->path . $preffix;

        if (is_dir($dir_filesUpload)) {

            foreach (scandir($dir_filesUpload) as $file_save) { /// scan les image save
                $path = $this->path . $preffix . D_S . $file_save;
                $etat = [];

                $is_match = $this->is_match($id_file, $file_save, self::FIN_REGEX);
                $is_file = is_file($path);

                if ($is_match && $is_file) {
                    $etat[] = unlink($path);
                }
            }


            return $etat;
        }
    }

    public function save(string $nameRoute, ServerRequestInterface $request, string $preffix = ""): ServerRequestInterface {
        $this->setPreffix($preffix);
        $insert = $request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();


        $this->mkdir_is_not($preffix);

        $id_file = $this->preffix . "_" . date("Y-m-d-H-i-s");

        foreach ($uploadedFiles as $key => $files) {
            $file_upload = [];
            foreach ($files as $file) {
                $file_upload[] = $this->insert_file_upload($preffix, $file, $id_file);
            }

            $insert[$key] = $this->generateUrisave($nameRoute, $id_file, $file_upload);
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

            $id_file = $this->preffix . "_" . date("Y-m-d-H-i-s") . "_" . $index;
            $file_upload = [];
            $file_upload[] = $this->insert_file_upload($preffix, $file, $id_file);

            $datachild[$index][$input] = $this->generateUrisave($nameRoute, $id_file, $file_upload);
        }

        return $datachild;
    }

    private function generateUrisave(string $nameRoute, string $id_file, array $file_uploads): string {


        $con = count($file_uploads);

        $url = $this->getRouter()->generateUri($nameRoute, ["controle" => $id_file]);

        return '<a class="btn "  role="button"'
                . ' href="' . $url . '" '
                . ' data-regex="/' . $id_file . '/" > '
                . '<spam class="glyphicon glyphicon-download-alt"></spam> '
                . $con .
                '</a>';
    }

    private function insert_file_upload(string $preffix, UploadedFileInterface $file, string $id_file): array {
        $file_upload = [];
        if ($file->getClientFilename() != "" && $file->getError() == 0) {
            /// insert file upload

            $name = $id_file . self::FIN_REGEX . $file->getClientFilename();
            $type = $file->getClientMediaType();
            $path = $this->path . $preffix . D_S . $name;
            $size = $file->getSize();

            $file->moveTo($path);

            $file_upload = ["name" => $name, "type" => $type, "path" => $path, "size" => $size];
        }
        return $file_upload;
    }

    private function mkdir_is_not(string $preffix) {
        if (!is_dir($this->path . $preffix) && !mkdir($this->path . $preffix, 0777, true)) {
            die('Echec lors de la création des répertoires...');
        }
    }

    private function get_preffix(string $id_file): string {
        preg_match('/([a-zA-Z\$]+)_(.+)/i', $id_file, $matches);
        if (empty($matches)) {
            return "";
        }
        $preffix = $matches[1];
        return $preffix;
    }

    private function is_match(string $_id_file, string $file_save, string $finregex = ""): bool {
        $subject = str_replace("$", "", $file_save);
        $id_file = str_replace("$", "", $_id_file);
        $pattern = '!^' . $id_file . $finregex . '!';
        return preg_match($pattern, $subject);
    }

}
