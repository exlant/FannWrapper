<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Core\Abstracts\AController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * Class NeuralNetworkController
 *
 * @package App\Http\Controllers\Api
 */
class NeuralNetworkController extends AController
{
    protected $name;
    
    /**
     * @return string
     */
    public function name()
    {
        return 'index';
    }
    
    
    /**
     * @Route("", name="index")
     * @Method("GET")
     *
     * @return Response
     */
    public function testAction(): Response
    {
        return new Response('It works!');
    }
    
    /**
     *
     * @Route("/api/doc", name="api_doc")
     * @return Response
     */
    public function apiDocAction(): Response
    {
        return new Response('It works!');
        
    }
}