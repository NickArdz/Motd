<?php
namespace NickArdz;

use pocketmine\event\Listener;
use pocketmine\event\server\QueryRegenerateEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener{
    

    public function onEnabled(): void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }

    public function onQueryRegenerateEvent(QueryRegenerateEvent $event){
        if($this->getConfig()->get("motdStatic", false)){
            $motd = str_replace(["%player_online%"], [$event->getQueryInfo()->getPlayerCount()], array_rand($this->getConfig()->get("modList", ["Simple Server"])));
            $event->getQueryInfo()->setServerName(TextFormat::colorize($motd));
        }
        $text = TextFormat::colorize(str_replace(["%player_online%"], [$event->getQueryInfo()->getPlayerCount()], $this->getConfig()->get("motd", "Simple Server")));
        $event->getQueryInfo()->setServerName($text);
        if($this->getConfig()->get("infiniteslots", false)){
            $event->getQueryInfo()->setMaxPlayerCount($event->getQueryInfo()->getPlayerCount() + 1);
        }
    }
}