<?php

namespace LevelAPI\Alekseyfbnd1\command;

use pocketmine\command\{CommandSender, Command};
use pocketmine\Player;

class MyPointCommand extends Command {
	
  private $main;
	
  public function __construct($main, string $name, string $description, string $permission) {
    $this->main = $main;
		
    parent::__construct($name, $description);
    $this->setPermission($permission);
  }
	
  public function execute(CommandSender $sender, string $label, array $args) :bool {
    $sender->sendMessage("Твой опыт: {$this->main->getPoint($sender->getName())}");
    return true;
  }

}
