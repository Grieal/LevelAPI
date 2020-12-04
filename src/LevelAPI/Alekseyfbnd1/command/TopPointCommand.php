<?php

namespace LevelAPI\Alekseyfbnd1\command;

use pocketmine\command\{CommandSender, Command};
use pocketmine\Player;

class TopPointCommand extends Command {
	
  private $main;
	
  public function __construct($main, string $name, string $description, string $permission) {
    $this->main = $main;
		
    parent::__construct($name, $description);
    $this->setPermission($permission);
  }
	
  public function execute(CommandSender $sender, string $label, array $args) :bool {
    $this->main->users->prepare("SELECT * FROM users ORDER BY level DESC LIMIT 10");
    $this->main->users->execute();
    $get = $this->main->users->get();
    $message = [];
    for ($i = 1, $i < 10, $i++) {
      $message[] = "{$i}. {$get[0]["name"]}: {$get[0]["point"]}$";
    }
    
    foreach ($message as $msg) {
      $sender->sendMessage("{$msg}\n");
    }
    return true;
  }

}
