<?php

namespace ItemRepair;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener
{

    public function onEnable()
    {
        $this->getLogger()->info("§bItem Repair enabled!");
    }


    public function onDisable()
    {
        $this->getLogger()->info("§bItem Repair disabled!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if (strtolower($command->getName()) == "repair") {
            if ($sender->hasPermission("repair.use")) {
                if (!isset($args[0])) {
                    $sender->sendMessage(TextFormat::GOLD . "Please use /repair all|hand");
                    return true;
                }
                if ($args[0] == "all") {
                    if ($sender->hasPermission("repair.all")) {
                        if ($sender instanceof Player) {
                            foreach ($sender->getInventory()->getContents() as $item) {
                                $item->setDamage(0);
                                return true;
                            }
                            foreach ($sender->getArmorInventory()->getContents() as $item) {
                                $item->setDamage(0);
                                return true;
                            }
                            $sender->sendMessage(TextFormat::GREEN . "You have repaired everything in your inventory.");

                        }
                    }
                }
                if ($args[0] == "hand") {
                    if ($sender->hasPermission("repair.hand")) {
                        if ($sender instanceof Player) {
                            $sender->getInventory()->getItemInHand()->setDamage(0);
                        }
                    }
                    return true;
                }
            }
        }
        return true;
    }
}
