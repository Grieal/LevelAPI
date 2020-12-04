<?php

namespace LevelAPI\Alekseyfbnd1;

use LevelAPI\Alekseyfbnd1\command\MyLevelCommand;
use LevelAPI\Alekseyfbnd1\command\MyPointCommand;
use LevelAPI\Alekseyfbnd1\command\TopLevelCommand;
use LevelAPI\Alekseyfbnd1\command\TopPointCommand;

use pocketmine\plugin\PluginBase;
use pocketmine\{Server, Player};

class LevelAPI extends PluginBase {
  
  public $users;
  
  public function onLoad() :void {
    $commands = [
      new MyLevelCommand($this, "mylevel", "твой уровень", "mylevel.command"),
      new MyPointCommand($this, "mypoint", "твой опыт", "mypoint.command"),
      new TopLevelCommand($this, "toplevel", "топ уровней", "toplevel.command"),
      new TopPointCommand($this, "toppoint", "топ опыта", "toppoint.command")
    ];
    
    foreach ($commands as $command) {
      $this->getServer()->getCommandMap()->register("LevelAPI", $command); 
    }
  }
  
  public function onEnable () :void {
    $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    if (!is_dir($this->getDataFolder())) {
      mkdir($this->getDataFolder());
    }
    
    $this->users = new SQLite3($this, "users");
  }
  
  public function registerPlayer (string $player) {
    $this->users->prepare("SELECT * FROM users WHERE name = :name"); 
    $this->users->bind(":name", $player);
    $this->users->execute();
    if (count($this->users->get()) == 0) {
      $this->users->prepare("INSERT INTO users (name) VALUES (:name)"); 
      $this->users->bind(":name", $player);
      $this->users->execute();
    }
  }
  
  public function getLevel (string $player) {
    $this->users->prepare("SELECT * FROM users WHERE name = :name"); 
    $this->users->bind(":name", $player);
    $this->users->execute();
    return $this->users->get()[0]["level"];
  }
  
  public function getPoint (string $player) {
    $this->users->prepare("SELECT * FROM users WHERE name = :name"); 
    $this->users->bind(":name", $player);
    $this->users->execute();
    return $this->users->get()[0]["point"];
  }
  
  public function reduceLevel (string $player, int $count) {
    $this->users->prepare("UPDATE users SET level = :level WHERE name = :name"); 
    $this->users->bind(":level", $this->getLevel($player) - $count);
    $this->users->bind(":name", $player);
    $this->users->execute();
  }
  
  public function reducePoint (string $player, int $count) {
    $this->users->prepare("UPDATE users SET point = :point WHERE name = :name"); 
    $this->users->bind(":point", $this->getPoint($player) - $count);
    $this->users->bind(":name", $player);
    $this->users->execute();
  }
  
  public function addLevel (string $player, int $count) {
    $this->users->prepare("UPDATE users SET level = :level WHERE name = :name"); 
    $this->users->bind(":level", $this->getLevel($player) + $count);
    $this->users->bind(":name", $player);
    $this->users->execute();
  }
  
  public function addPoint (string $player, int $count) {
    $this->users->prepare("UPDATE users SET point = :point WHERE name = :name"); 
    $this->users->bind(":point", $this->getPoint($player) + $count);
    $this->users->bind(":name", $player);
    $this->users->execute();
  }
  
}
