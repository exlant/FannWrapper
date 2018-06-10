<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * Class NeuralNetworkController
 *
 * @package App\Http\Controllers\Api
 */
class NeuralNetworkController
{
    /**
     * @Route("/", name="Test")
     * @Method("GET")
     *
     * @return Response
     */
    public function test(): Response
    {
        return new Response('It works!');
    }
}