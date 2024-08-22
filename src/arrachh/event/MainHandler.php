<?php

namespace arrachh\event;

use arrachh\Loader;
use arrachh\utils\Utils;
use arrachh\utils\Variables;
use Juqn\CortexPE\DiscordWebhookAPI\Embed;
use Juqn\CortexPE\DiscordWebhookAPI\Message;
use Juqn\CortexPE\DiscordWebhookAPI\Webhook;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\TextFormat;

final class MainHandler implements Listener, Variables {

    public function __construct(protected Loader $loader){
        $this->loader->getServer()->getPluginManager()->registerEvents($this, $this->loader);
    }

    public function handleJoin(PlayerJoinEvent $event): void    {
        $player = $event->getPlayer();
        $titleId = $player->getPlayerInfo()->getExtraData()['TitleID'];
        $deviceOS = $player->getPlayerInfo()->getExtraData()['DeviceOS'];

        if($titleId === null) {
            //this should not be null if the player is logged into xbl.
            return;
        }

        $expectedOs = Utils::toOs($titleId); //translating expected device os by title id

        if ($expectedOs === -1) { // if it is not registered, it will be a new id to save
            Webhook::create(self::NEW_TITLEID)
                ->send(Message::create()
                    ->addEmbed(Embed::create()
                        ->setTitle('New Title ID')
                        ->setColor(0xFF8000)
                        ->setDescription('Player: ' . $player->getName() . "\n" . 'TitleID: ' . $titleId . "\n" . 'Device: ' . Utils::toStr($deviceOS))
                    )
                );
            return;
        }

        if($expectedOs !== $deviceOS) {
            (new PlayerCatchEvent($player, Utils::toStr($deviceOS), Utils::toStr($expectedOs)))->call();
        }
    }

    /**
     * Custom event
     */

    public function handleCatch(PlayerCatchEvent $event): void    {
        $player = $event->getPlayer();
        $deviceOs = $event->getDeviceOs();
        $expectedDevice = $event->getExpectedDevice();

        Webhook::create(self::SPOOFED)
            ->send(Message::create()
                ->addEmbed(Embed::create()
                    ->setTitle('Player caught!')
                    ->setColor(0xFF8000)
                    ->setDescription('Player: ' . $event->getPlayer()->getName())
                )
            );
        $this->loader->getServer()->broadcastMessage(TextFormat::colorize('» &r&c[Nyx] ' . $player->getName() . ' was caught trying to join with Lunar Proxy spoofer. ' . 'Device: ' . $deviceOs . ' Expected: ' . $expectedDevice));
        $player->kick('You cant join using any type of Device Modifiers', false);
    }
}
