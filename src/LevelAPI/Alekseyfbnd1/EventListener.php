<?php

namespace LevelAPI\Alekseyfbnd1;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class Eventlistener implements Listener {

  public $main;
  
  public function __construct ($main) {
    $this->main = $main;
  }
  
  public function onJoin (PlayerJoinEvent $event) {
    $this->main->registerPlayer($event->getPlayer()->getName());
  }

}
