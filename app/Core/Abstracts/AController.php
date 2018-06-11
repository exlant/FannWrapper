<?php
declare(strict_types=1);

namespace App\Core\Abstracts;

use Doctrine\ORM\EntityManagerInterface;
use GNS\AppBundle\Service\ResponseHandler;
use GNS\AppBundle\Service\SerializationService;
use GNS\UserBundle\Entity\User;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AController
 *
 * @package App\Core\Abstracts
 */
abstract class AController extends Controller
{
    /**
     * @param mixed $data
     * @param array|null $groups
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function handleResponse($data, array $groups = null)
    {
        return $this->getResponseHandler()->handleSuccessResponse($data, $groups);
    }

    /**
     * @return ResponseHandler
     */
    protected function getResponseHandler()
    {
        return $this->get('gns_app.response_handler');
    }

    /**
     * @return EntityManagerInterface|object
     */
    protected function getManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @param $channel
     * @return Logger|object
     */
    protected function getLogger($channel)
    {
        return $this->get('monolog.logger.' . $channel);
    }

    /**
     * @return ValidatorInterface
     */
    protected function getValidator()
    {
        return $this->get('validator');
    }

    /**
     * @return TranslatorInterface
     */
    protected function getTranslator()
    {
        return $this->container->get('translator');
    }

    /**
     * @return SerializationService|object
     */
    protected function getSerializer()
    {
        return $this->get('gns_app.serializer_service');
    }

    /**
     * @return User|null
     */
    protected function getCurrentUser()
    {
        return $this->get('gns_oauth.security_service')->getCurrentUser();
    }
}