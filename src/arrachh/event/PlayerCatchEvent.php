<?php

namespace arrachh\event;

use arrachh\profile\Profile;
use pocketmine\event\player\PlayerEvent;
use pocketmine\player\Player;

/**
 * @see Profile
 */
class PlayerCatchEvent extends PlayerEvent {

    public function __construct(
        Player $player,
        protected ?string $deviceOs = null,
        protected ?string $expectedDevice = null,
    )    {
        $this->player = $player;
    }

    public function getDeviceOs(): string    {
        return $this->deviceOs ?? 'Undefined';
    }

    public function getExpectedDevice(): string    {
        return $this->expectedDevice ?? 'Undefined';
    }
}