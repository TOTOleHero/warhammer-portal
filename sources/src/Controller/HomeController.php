<?php

namespace App\Controller;

use App\Manager\GameSystemManager;
use App\Manager\NationManager;
use App\Manager\ProfileManager;
use App\Manager\UnitGameSystemManager;
use App\Manager\UnitGenericManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class HomeController extends AbstractFOSRestController
{
    /**
     * @Route("/", name="home")
     */
    public function index(
        UnitGenericManager $unitGenericManager, NationManager $nationManager,
    UnitGameSystemManager $unitGameSystemManager,
    ProfileManager $profileManager,
    GameSystemManager $gameSystemManager
    ): Response {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'stats' => [
                'Profile' => $profileManager->countAll(),
                'UnitGeneric' => $unitGenericManager->countAll(),
                'UnitGameSystem' => $unitGameSystemManager->countAll(),
                'Nation' => $nationManager->countAll(),
                'GameSystem' => $gameSystemManager->countAll(),
            ],
        ]);
    }

    /**
     * @Route("/api/", name="api_index", methods={"GET"})
     *
     * @OA\Tag(name="root")
     */
    public function apiIndex(RouterInterface $router): Response
    {
        $baseLinks = [
            '_links' => [
                'nations' => [
                    'href' => $router->generate('api_nation_index'),
                ],
                'races' => [
                    'href' => $router->generate('api_race_index'),
                ],
                'gameSystems' => [
                    'href' => $router->generate('api_game_system_index'),
                ],
                'equipmentTypes' => [
                    'href' => $router->generate('api_equipment_type_index'),
                ],
                'equipments' => [
                    'href' => $router->generate('api_equipment_index'),
                ],
                'worlds' => [
                    'href' => $router->generate('api_world_index'),
                ],
            ],
        ];

        $view = $this->view($baseLinks, 200);

        return $this->handleView($view);
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
