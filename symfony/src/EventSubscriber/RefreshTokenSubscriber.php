<?php

namespace App\EventSubscriber;

use App\Repository\RefreshTokenRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class RefreshTokenSubscriber implements EventSubscriberInterface
{
    private $refreshTokenRepository;
    private $em;
    private $interval;

    public function __construct(RefreshTokenRepository $refreshTokenRepository, ObjectManager $em, ParameterBagInterface $bag)
    {
        $this->refreshTokenRepository = $refreshTokenRepository;
        $this->em = $em;
        $this->interval = $bag->get('gesdinet_jwt_refresh_token.ttl');
    }

    public static function getSubscribedEvents()
    {
        return [
            'lexik_jwt_authentication.on_authentication_success' => 'onRefresh',
        ];
    }

    public function onRefresh(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $tokens = $this->refreshTokenRepository->findBy(['username' => $user->getUsername()]);

        $first = array_shift($tokens);

        foreach ($tokens as $token) {
            $this->em->remove($token);
        }

        $first->setValid((new \DateTime())->add(new \DateInterval('PT' . $this->interval . 'S')));

        $this->em->flush();

        $data['refresh_token'] = $first->getRefreshToken();

        $event->setData($data);
    }
}