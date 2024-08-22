<?php

namespace arrachh;

use arrachh\event\MainHandler;
use pocketmine\plugin\PluginBase;

final class Loader extends PluginBase {

    protected function onEnable(): void    {
        new MainHandler($this);
    }

}