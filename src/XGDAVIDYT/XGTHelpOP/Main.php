<?php

declare(strict_types=1);

namespace XGDAVIDYT\XGTHelpOP;

use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;
use pocketmine\permission\ServerOperator;
use pocketmine\utils\TextFormat;
use pocketmine\event\entity;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\utils\Utils;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginManager;

class Main extends PluginBase{

	public function onEnable() : void{
        $this->saveResource("config.yml");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{

        $sender = $sender;
        $cmd = $command;
        $messageop =  $this->getConfig()->get("Message-OP");
        $noop =  $this->getConfig()->get("NoOpOnline");

		if($command->getName() === "helpop"){
			if(count($args) < 0){
				$sender->sendMessage("§8[§bXGT-HELPOP§8]§7 Use: /helpop <question>");
				
				return true;
			}elseif(count($args) > 0){
				foreach($this->getServer()->getOnlinePlayers() as $p){
					if($p->isOnline() && $p->isOp()){
						$p->sendMessage(TextFormat::DARK_RED."§8[§bXGT-STAFF§8]§a " . $sender->getName() . " §7" . $messageop);
						$p->sendMessage(TextFormat::DARK_RED."§8[§bXGT-STAFF§8]§7 §7Question:§a " . $this->getMsg($args) . " §7from §a" . $sender->getName());
						$sender->sendMessage(TextFormat::DARK_RED."§8[§bXGT-HELPOP§8]§7 Your question sent to a OP!");
						return true;
					}else{
						$sender->sendMessage(TextFormat::DARK_RED."§8[§bXGT-HELPOP§8]§7 " . $noop);
						return true;
					}
				}
			}
    }
    
		

		if($command->getName() === "checkop"){
			$ops = "";
			foreach($this->getServer()->getOnlinePlayers() as $p){
				if($p->isOnline() && $p->isOp()){
					$ops = $p->getName()." , ";
					$sender->sendMessage(TextFormat::DARK_RED."§8[§bXGT-HELPOP§8]§7".TextFormat::WHITE." OPs online:\n".substr($ops, 0, -2));		
					return true;
				}else{
					$sender->sendMessage(TextFormat::DARK_RED."§8[§bXGT-HELPOP§8]§7 ".TextFormat::WHITE."OPs online: - \n");
					return true;
				}
			}
		}
        return true;
	}
	
	public function getMsg($words){
		return implode(" ",$words);
	}
}
