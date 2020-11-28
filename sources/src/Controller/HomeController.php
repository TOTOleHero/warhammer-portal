<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(): Response
    {
        /** @var $router \Symfony\Component\Routing\Router */
        $router = $this->container->get('router');
        /** @var $collection \Symfony\Component\Routing\RouteCollection */
        $collection = $router->getRouteCollection();
        $allRoutes = $collection->all();

        $routes = [];

        /** @var $params \Symfony\Component\Routing\Route */
        foreach ($allRoutes as $route => $params) {
            $defaults = $params->getDefaults();

            $controllerAction = explode(':', $defaults['_controller']);
            $controller = $controllerAction[0];

            if ('App\Controller\HomeController' == $controller) {
                continue;
            }

            if ('App\Controller' != substr($controller, 0, strlen('App\Controller'))) {
                continue;
            }

            if (!method_exists($controller, 'index')) {
                continue;
            }

            if (!isset($routes[$controller])) {
                $routes[$controller] = [];
            }

            $routes[$controller][] = $route;
        }

        return $this->render('home/test.html.twig', [
            'routesController' => array_keys($routes),
        ]);
    }
}
