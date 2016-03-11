<?php

namespace LDX\WorldEdit;

use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandExecutor;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerInteractEvent;

class Main extends PluginBase implements CommandExecutor, Listener {

  public function onEnable() {
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }

  public function onCommand(CommandSender $player, Command $command, $label, array $args) {
    $player->sendMessage($label); // Test
    return true;
  }

  public function onPlayerInteract(PlayerInteractEvent $event) {
    $player = $event->getPlayer();
    
  }

  public function getSession(Player $player) {
    if(isset($this->sessions[strtolower($player->getName())])) {
      return $this->sessions[strtolower($player->getName())];
    }
    return startSession($player);
  }

  public function startSession(Player $player) {
    
  }

}