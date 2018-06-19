<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Facades\FRoute;
use App\Core\Facades\FRouteCollection;
use App\Http\Controllers\Api\NeuralNetworkController;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class SRouting
 *
 * @package App\Services
 */
class SRouting
{
    
    /**
     * @var FRouteCollection
     */
    private $routeCollection;
    
    /**
     * SRouting constructor.
     * @param FRouteCollection $routeCollection
     */
    public function __construct(FRouteCollection $routeCollection)
    {
        $this->routeCollection = $routeCollection;
    }
    
    /**
     * @return RouteCollection
     */
    public function loadRoutes(): RouteCollection
    {
        $route = new FRoute('', ['_controller' => NeuralNetworkController::class]);
        $route1 = new FRoute('', ['_controller' => NeuralNetworkController::class]);
        $this->routeCollection->add('index', $route);
        $this->routeCollection->add('index', $route1);
        $this->routeCollection->setMethods('apiDocAction');
        $this->routeCollection->setMethods('index');
        
        return $this->routeCollection;
    }
    
}