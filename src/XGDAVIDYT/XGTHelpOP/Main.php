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

class Main extends PluginBase implements Listener{

	public function onEnable() : void{
		$this->saveResource("config.yml");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		if($this->getConfig()->get("version") !== 1.0){
			$this->getServer()->getLogger()->error("[XGTHelpOP] Config is outdata!");
			$this->getServer()->getPluginManager()->disablePlugin($this);
		}
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{

        $messageop =  $this->getConfig()->get("Message-OP");
		$noop =  $this->getConfig()->get("NoOpOnline");
		$noacces =  $this->getConfig()->get("NoAcces");

		if($command->getName() === "helpop"){
			if(!$sender instanceof Player){
				$sender->sendMessage("§8[§bXGT-HELPOP§8]§c Use in-game!");
			}else{
				if(!$sender->hasPermission("xgthelpop.helpop")){
					$sender->sendMessage("§8[§bXGT-HELPOP§8]§c " . $noacces);
					return false;
				}
				if(count($args) < 0){
					$sender->sendMessage("§8[§bXGT-HELPOP§8]§7 Use: §b/helpop §7<§bquestion§7>");
					return true;
				}elseif(count($args) > 0){
					foreach($this->getServer()->getOnlinePlayers() as $p){
						if($p->isOp()){
							$name = $sender->getName();
							$player = $sender->getServer()->getPlayerExact($name);
							if(!isset($this->cdhelpop[$player->getName()])){
								$this->cdhelpop[$player->getName()] = time() + 300;
								$p->sendMessage("§8[§bXGT-STAFF§8]§a " . $name . " §7" . $messageop);
								$p->sendMessage("§8[§bXGT-STAFF§8]§7 §7Question:§a " . $this->getMsg($args) . " §7from §a" . $name);
								$sender->sendMessage("§8[§bXGT-HELPOP§8]§7 Your question sent to a OP!");
							}else{
								if(time() <  $this->cdhelpop[$player->getName()]){
									$ramas =  $this->cdhelpop[$player->getName()] - time();
									$player->sendMessage("§l§8[§2!§8] »§r §7You can use this comand again in§6 ".$ramas." §7seconds!");
								}else{
									unset($this->cdhelpop[$player->getName()]);
									$sender->sendMessage("§8[§bXGT-HELPOP§8]§7 Use: §b/helpop §7<§bquestion§7>");
								}
							}
						}else{
							$sender->sendMessage("§8[§bXGT-HELPOP§8]§7 " . $noop);
						}
					}
				}
			}
		}
		return true;
		if($command->getName() === "checkop"){
			if(!$sender instanceof Player){
				$sender->sendMessage("§8[§bXGT-HELPOP§8]§c Use in-game!");
			}else{
				if(!$sender->hasPermission("xgthelpop.checkop")){
					$sender->sendMessage("§8[§bXGT-HELPOP§8]§c " . $noacces);
					return false;
				}
				$ops = "";
				foreach($this->getServer()->getOnlinePlayers() as $p){
					if($p->isOp()){
						$ops = $p->getName()." , ";
						$sender->sendMessage("§8[§bXGT-HELPOP§8]§7 OPs online:\n".substr($ops, 0, -2));	
					}else{
						$sender->sendMessage("§8[§bXGT-HELPOP§8]§7 OPs online: " . $noop);
					}
				}
			}
		}
        return true;
	}
	
	public function getMsg($words){
		return implode(" ",$words);
	}
}
