<?php declare(strict_types=1);

namespace App\Bundles\UserBundle\Service;

use App\Bundles\AppBundle\Exception\InvalidArgumentException;
use App\Bundles\AppBundle\Exception\NotFoundException;
use App\Bundles\AppBundle\Model\TextField;
use App\Bundles\AppBundle\Service\Mailer;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use App\Bundles\AppBundle\Model\BaseRequestService;
use App\Bundles\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

class ResetPasswordService extends BaseRequestService
{
    /** @var UserManager */
    private $userManager;

    /** @var TokenGeneratorInterface */
    private $tokenGenerator;

    /** @var Mailer */
    private $mailer;

    private $tokenTtl;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->userManager = $container->get('gns_user.user_manager');
        $this->tokenGenerator = $container->get('fos_user.util.token_generator');
        $this->mailer = $container->get('gns_app.mailer');
        $this->tokenTtl = $container->getParameter('fos_user.resetting.token_ttl');
    }

    public function resetPasswordRequest(ParameterBag $requestParameters)
    {
        $parameters = $this->handleRequest($requestParameters, null, [
            new TextField('email', ['required' => true]),
        ]);

        $email = $parameters->get('email');
        $user = $this->userManager->findUserByEmail($email);

        if (\is_null($user)) {
            throw new NotFoundException('error.not_found.user', ['email' => $email]);
        }

        $user = $this->userManager->update($user, new ParameterBag([
            'confirmationToken' => $this->tokenGenerator->generateToken(),
            'passwordRequestedAt' => new \DateTime()
        ]));

        $this->mailer->sendResetPasswordMessage($user);
    }

    public function resetPassword(ParameterBag $requestParameters)
    {
        $parameters = $this->handleRequest($requestParameters, null, [
            new TextField('token', ['required' => true]),
            new TextField('password', ['required' => true]),
        ]);

        $token = $parameters->get('token');
        $newPassword = $parameters->get('password');

        /** @var User $user */
        $user = $this->userManager->findUserByConfirmationToken($token);

        if (\is_null($user) || !$user->isPasswordRequestNonExpired($this->tokenTtl)) {
            throw new InvalidArgumentException('token');
        }

        return $this->userManager->update($user, new ParameterBag([
            'password' => $newPassword,
            'confirmationToken' => null,
            'passwordRequestedAt' => null
        ]), ['Profile']);
    }
}