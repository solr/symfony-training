<?php
/**
 * Created by PhpStorm.
 * User: solr
 * Date: 21.12.2017
 * Time: 14:08
 */

namespace App\Security;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationService
{
    /**
     * @var ObjectManager
     */
    private $manager;
    /**
     * @var  UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * RegistrationService constructor.
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $this->manager = $manager;
        $this->encoder = $encoder;
    }

    public function createUser(Registration $registration) {
        $player = $registration->getPlayer();
        $rawPassword = $registration->getRawPassword();
        $password = $this->encoder->encodePassword(
            $player, $rawPassword
        );
        $player->setPassword($password);

        $this->manager->persist($player);
        $this->manager->flush();
        return $player;
    }

}