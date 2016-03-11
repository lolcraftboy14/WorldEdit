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

  private $commands = [
    ["/copy", "Copies the current selection.", "worldedit.command.copy", false],
    ["/cut", "Copies and removes the current selection.", "worldedit.command.cut", false],
    ["/paste", "Pastes what's on your clipboard.", "worldedit.command.paste", false],
    ["/help [page]", "Shows the WorldEdit help.", "worldedit.command.help", true],
    ["/undo", "Reverts your last action.", "worldedit.command.undo", false],
    ["/sphere", "Creates a sphere.", "worldedit.command.sphere", false],
    ["/hsphere", "Creates a hollow sphere.", "worldedit.command.hsphere", false],
    ["/limit <blocks>", "Sets the maximum amount of blocks which can be changed at once.", "worldedit.command.limit", false],
    ["/desel", "Deselects the current selection.", "worldedit.command.desel", false],
    ["/pos1", "Selects your first position.", "worldedit.command.pos1", false],
    ["/pos2", "Selects your second position.", "worldedit.command.pos2", false]
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
        $max = 5;
        $pages = ceil(count($this->commands) / $max);
        $page = isset($args[0]) ? max(1,min($pages,intval($args[0]))) : 1;
        $help = "§e--- §fWorldEdit help page $page of $pages §e---\n";
        for($i = ($page - 1) * $max; $i <= $page * $max - 1; $i++) {
          if(isset($this->commands[$i])) {
            $help .= ($this->commands[$i][3] ? ($this->hasPermission($player, $this->commands[$i][2]) ? "§a" : "§c") : "§7") . "/{$this->commands[$i][0]}§7: §f{$this->commands[$i][1]}\n";
          }
        }
        if($page != $pages) $help .= "§fType §e//help " . ($page + 1) . "§f to see the next page.";
        $player->sendMessage($help);
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

  public function hasPermission(Player $player, $permission) {
    $base = "";
    $nodes = explode(".", $permission);
    foreach($nodes as $key => $node) {
      $seperator = $key == 0 ? "" : ".";
      $base = "$base$seperator$node";
      if($player->hasPermission($base)) {
        return true;
      }
    }
    return false;
  }

}