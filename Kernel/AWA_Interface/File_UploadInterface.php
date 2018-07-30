<?php

namespace Kernel\AWA_Interface;

use Kernel\AWA_Interface\RouterInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 *
 * @author wassime
 */
interface File_UploadInterface
{

    public function __construct(RouterInterface $router, string $path);

    public function setPreffix($preffix);

    public function getRouter(): RouterInterface;

    public function get(string $id_file): array;

    public function delete(string $id_file): array;

    public function save(string $nameRoute, ServerRequestInterface $request, string $preffix = ""): ServerRequestInterface;

    public function save_child(string $nameRoute, ServerRequestInterface $request, array $datachild, string $preffix = ""): array;
}
