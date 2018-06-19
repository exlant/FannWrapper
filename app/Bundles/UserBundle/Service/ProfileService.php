<?php declare(strict_types=1);

namespace App\Bundles\UserBundle\Service;

use App\Bundles\AppBundle\Exception\BadRequestHttpException;
use App\Bundles\AppBundle\Model\BaseRequestService;
use App\Bundles\AppBundle\Model\TextField;
use App\Bundles\AppBundle\Transformer\PhoneNumberTransformer;
use App\Bundles\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class ProfileService extends BaseRequestService
{
    /** @var UserManager */
    private $userManager;

    /** @var EncoderFactoryInterface */
    private $encoderFactory;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->userManager = $container->get('gns_user.user_manager');
        $this->encoderFactory = $container->get('security.encoder_factory');
    }

    public function update(User $user, ParameterBag $requestParameters)
    {
        $parameters = new ParameterBag();

        $this->handleRequest($requestParameters, $parameters, [
            new TextFiel('firstName'),
            new TextField('lastName'),
            new TextField('companyName'),
            new TextField('address'),
            new TextField('phoneNumber', [
                'transformers' => [new PhoneNumberTransformer()]
            ]),
            new TextField('legalStatus'),
            new TextField('identificationNumber'),
        ]);

        $user = $this->userManager->update($user, $parameters, ['Profile']);

        return $user;
    }

    public function updatePassword(User $user, ParameterBag $requestParameters)
    {
        $parameters = new ParameterBag();

        $this->handleRequest($requestParameters, $parameters, [
            new TextField('password', ['required' => true]),
            new TextField('newPassword', ['required' => true])
        ]);

        $password = $parameters->get('password');
        $newPassword = $parameters->get('newPassword');
        $encoder = $this->encoderFactory->getEncoder($user);

        if (!$encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
            throw new BadRequestHttpException('error.bad_request.invalid_user_password');
        }

        $user = $this->userManager->update($user,
            new ParameterBag(['password' => $newPassword]),
            ['Profile']
        );

        return $user;
    }
}