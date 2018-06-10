<?php declare(strict_types=1);

namespace App\Bundles\UserBundle\Service;

use App\Bundles\AppBundle\Exception\InvalidArgumentException;
use App\Bundles\AppBundle\Model\TextField;
use App\Bundles\AppBundle\Service\Mailer;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use App\Bundles\AppBundle\Model\BaseRequestService;
use App\Bundles\UserBundle\Entity\User;
use App\Bundles\UserBundle\Exception\InvalidRegistrationSourceException;
use App\Bundles\UserBundle\Model\Role;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Validator\Constraints\Email;

class RegistrationService extends BaseRequestService
{
    /** @var UserManager */
    private $userManager;

    /** @var TokenGeneratorInterface */
    private $tokenGenerator;

    /** @var Mailer */
    private $mailer;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->userManager = $container->get('gns_user.user_manager');
        $this->tokenGenerator = $container->get('fos_user.util.token_generator');
        $this->mailer = $container->get('gns_app.mailer');
    }

    public function register($source, ParameterBag $requestParameters)
    {
        switch ($source) {
            case User::SOURCE_REGISTRATION_BY_EMAIL:
                $user = $this->registerByEmail($requestParameters);
                break;
            default:
                throw new InvalidRegistrationSourceException($source);
        }

        return $user;
    }

    public function confirmRegistration(ParameterBag $requestParameters)
    {
        $parameters = $this->handleRequest($requestParameters, null, [
            new TextField('token', ['required' => true]),
        ]);

        $token = $parameters->get('token');
        $user = $this->userManager->findUserByConfirmationToken($token);

        if (\is_null($user)) {
            throw new InvalidArgumentException('token');
        }

        $user->addRole(Role::BUYER);

        return $this->userManager->update($user, new ParameterBag([
            'confirmationToken' => null,
            'registeredAt' => new \DateTime()
        ]), ['Profile']);
    }

    private function registerByEmail(ParameterBag $requestParameters)
    {
        $parameters = new ParameterBag();

        $this->handleRequest($requestParameters, $parameters, [
            new TextField('email', [
                'required' => true,
                'constraints' => [
                    new Email()
                ]
            ]),
            new TextField('password', ['required' => true]),
            new TextField('firstName', ['required' => true]),
            new TextField('lastName', ['required' => true]),
            new TextField('legalStatus', ['required' => true]),
            new TextField('identificationNumber', ['required' => true]),
        ]);

        $parameters->set('confirmationToken', $this->tokenGenerator->generateToken());
        $parameters->set('source', User::SOURCE_REGISTRATION_BY_EMAIL);

        $user = $this->userManager->create($parameters, ['Registration']);

        $this->mailer->sendConfirmationEmailMessage($user);

        return $user;
    }
}