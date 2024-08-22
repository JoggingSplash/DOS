<?php

namespace arrachh\utils;

use pocketmine\network\mcpe\protocol\types\DeviceOS;

class Utils {

    /**
     * Easy introduction.
     *
     * TitleID is a numerical ID present only if the user is logged into XBL.
     * It holds the title ID (XBL related) of the version that the player is on.
     * Note that these IDs are protected using XBOX Live, making the spoofing of this data very difficult.
     */


    /**
     * Translating some TitleIds to their device os int id
     */

    public static function toOs(string $titleId) : int    {
        return match ($titleId) {
            '1739947436' => DeviceOS::ANDROID,
            '1810924247' => DeviceOS::IOS,
            '1944307183' => DeviceOS::AMAZON,
            '896928775' => DeviceOS::WINDOWS_10,
            '2044456598' => DeviceOS::PLAYSTATION,
            '2047319603' => DeviceOS::NINTENDO,
            '1828326430' => DeviceOS::XBOX,
            default => -1
        };
    }

    /**
     * Translating Device Os IDs to string
     */

    public static function toStr(int $device) : string  {
        return match ($device){
            DeviceOS::ANDROID => "Android",
            DeviceOS::IOS => "IOS",
            DeviceOS::OSX => "Osx",
            DeviceOS::AMAZON => "Amazon",
            DeviceOS::GEAR_VR => "Gear VR",
            DeviceOS::HOLOLENS => "Hololens",
            DeviceOS::WINDOWS_10 => "Win10",
            DeviceOS::WIN32 => "Win32",
            DeviceOS::DEDICATED => "Dedicated",
            DeviceOS::TVOS => "TvOS",
            DeviceOS::NINTENDO => "Nintendo",
            DeviceOS::PLAYSTATION => "PlayStation",
            DeviceOS::XBOX => "Xbox",
            DeviceOS::WINDOWS_PHONE => "Windows Phone",
            default => "Linux / Unknown"
        };
    }
}