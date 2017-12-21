<?php
/**
 * Created by PhpStorm.
 * User: solr
 * Date: 21.12.2017
 * Time: 11:44
 */

namespace App\Security;


use App\Entity\Player;
use Symfony\Component\Validator\Constraints as Assert;

class Registration
{
    /**
     * @var Player
     * @Assert\Valid()
     */
    private $player;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=8)
     */
    private $rawPassword;

    /**
     * @return bool
     * @Assert\IsTrue(message="form.error.invalid.password")
     */
    public function isPasswordValid() {
        return false === stripos($this->rawPassword, $this->player->getEmail());
    }

    /**
     * @return Player
     */
    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer(Player $player): void
    {
        $this->player = $player;
    }

    /**
     * @return string
     */
    public function getRawPassword(): ?string
    {
        return $this->rawPassword;
    }

    /**
     * @param string $rawPassword
     */
    public function setRawPassword(string $rawPassword): void
    {
        $this->rawPassword = $rawPassword;
    }
}