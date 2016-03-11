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

  $commands = [
                ["/copy", "Copies the current selection.", false],
                ["/cut", "Copies and removes the current selection.", false],
                ["/paste", "Pastes what's on your clipboard.", false],
                ["/sphere", "Creates a sphere.", false],
                ["/hsphere", "Creates a hollow sphere.", false]
              ];

  public function onEnable() {
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }

  public function onCommand(CommandSender $player, Command $command, $label, array $args) {
    if(!($player instanceof Player)) {
      $player->sendMessage("§cCommand must be used in-game.");
      return true;
    }
    switch(strtolower($label)) {
      case "/":
      case "/help":
        
      break;
      default:
        $player->sendMessage("§cThis command hasn't been added yet.");
    }
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