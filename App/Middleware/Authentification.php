<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Middleware;

use App\Authentification\AutorisationInterface;
use Kernel\AWA_Interface\ActionInterface;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\AWA_Interface\SessionInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function preg_match;
use function var_dump;

/**
 * Description of Authentification
 *
 * @author wassime
 */
class Authentification implements MiddlewareInterface, AutorisationInterface {

    private $container;
    private $router;
    private $Response;
    private $Session;

    function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->router = $container->get(RouterInterface::class);
        $this->Response = $container->get(ResponseInterface::class);
        $this->Session = $container->get(SessionInterface::class);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        //return $handler->handle($request);
        $route = $this->getRouter()->match($request);

        // not is in modules
        if (!$route->isSuccess()) {
            return $handler->handle($request);
        }
        //  is in login page
        $url = $request->getUri()->getPath();
        $url_login = $this->getRouter()->generateUri("login");
        if ($url == $url_login) {
            return $handler->handle($request);
        }

        if ($this->getSession()->has(self::Name_Key_Session)) {
            if($this->is_root()){
                return $handler->handle($request);
            }

            $nameModule = $this->parseNameModule($request);
            $nameControler = $this->parseNameControler($request);
            $nameAction = $this->parseNameAction($request);
            $flag = $this->is_autorise($nameModule, $nameControler, $nameAction);

            if ($flag) {
                return $handler->handle($request);
            }
        }
        return $this->getResponse()
                        ->withHeader("Location", $url_login)
                        ->withStatus(403);
    }

    private function is_autorise(string $nameModule, string $nameControler, ActionInterface $action): bool {
        $Autorisation = $this->getSession()->get(self::Name_Key_Session);

        $nameTableAutorisation = self::Prefixe . $nameModule;
        if (isset($Autorisation[$nameTableAutorisation])) {
            $TableAutorisation = $Autorisation[$nameTableAutorisation];
            foreach ($TableAutorisation as $row) {
                if ($row['controller'] == $nameControler) {

                    if ($row["voir"] == "1" && ($action->is_index() || $action->is_message() || $action->is_show())) {
                        return true;
                    }
                    if ($row["ajouter"] == "1" && ($action->is_add() || $action->is_message() || $action->is_show())) {
                        return true;
                    }
                    if ($row["modifier"] == "1" && $action->is_update()) {
                        return true;
                    }
                    if ($row["effacer"] == "1" && ($action->is_delete() || $action->is_message() || $action->is_show())) {
                        return true;
                    }
                }
            }
            return false;
        } else {
            return true;
        }
    }

    private function is_root(): bool {
        $Autorisation = $this->getSession()->get(self::Name_Key_Session);
        //var_dump($Autorisation);
       // die();
        return $Autorisation["comptes"]["comptes"] === "root";
    }

    private function parseNameModule(ServerRequestInterface $request): string {
        $url = $request->getUri()->getPath();
        preg_match('!/([A-Za-z]+)(.*)!i', $url, $matches);
        if (empty($matches)) {
            return "";
        } else {
            return $matches[1];
        }
    }

    private function parseNameControler(ServerRequestInterface $request): string {
        $route = $this->getRouter()->match($request);
        return $route->getParam("controle");
    }

    private function parseNameAction(ServerRequestInterface $request): ActionInterface {
        $route = $this->getRouter()->match($request);
        $urlaction = $route->getParam("action");
        $action = $this->container->get(ActionInterface::class);
        $action->setAction($urlaction);
        return $action;
    }

    private function getRouter(): RouterInterface {
        return $this->router;
    }

    private function getResponse(): ResponseInterface {
        return $this->Response;
    }

    private function getSession(): SessionInterface {
        return $this->Session;
    }

}
