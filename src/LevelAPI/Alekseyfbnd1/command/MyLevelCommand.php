<?php

namespace LevelAPI\Alekseyfbnd1\command;

use pocketmine\command\{CommandSender, Command};
use pocketmine\Player;

class MyLevelCommand extends Command {
	
  private $main;
	
  public function __construct($main, string $name, string $description, string $permission) {
    $this->main = $main;
		
    parent::__construct($name, $description);
    $this->setPermission($permission);
  }
	
  public function execute(CommandSender $sender, string $label, array $args) :bool {
    $sender->sendMessage("Твой уровень: {$this->main->getLevel($sender->getName())}");
    return true;
  }

}
