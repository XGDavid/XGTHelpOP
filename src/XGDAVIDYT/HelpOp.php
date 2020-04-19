<?php
declare(strict_types=1);


namespace XGDAVIDYT;

use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;
use pocketmine\permission\ServerOperator;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\entity;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\utils\Utils;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginManager;

use function count;

class HelpOp extends PluginBase {

    public function onEnable() : void{
        $this->saveResource("config.yml");
        $this->getLogger()->info("HelpOP by XGDAVIDYT enabled!\nWebsite: tcg-xgt.tk");
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $name = $player->getName();
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{

        $issuer = $sender;
        $cmd = $command;
        $messageop =  $this->getConfig()->get("Message-OP");
        $noop =  $this->getConfig()->get("NoOpOnline");

		if($cmd->getName() === "helpop"){
			if(count($args) < 1){
				$sender->sendMessage("§8[§bXGT-HELPOP§8]§7 Use: /helpop <question>");
				
				return true;
			}else if(count($args) > 0){
				foreach($this->getServer()->getOnlinePlayers() as $p){
					if($p->isOnline() && $p->isOp()){
							$p->sendMessage(TextFormat::DARK_RED."§8[§bXGT-STAFF§8]§a " . $issuer->getName() . " §7" . $messageop);
							$p->sendMessage(TextFormat::DARK_RED."§8[§bXGT-STAFF§8]§7 §7Question:§a " . $this->getMsg($args) . " §7from §a" . $issuer->getName());
							$issuer->sendMessage(TextFormat::DARK_RED."§8[§bXGT-HELPOP§8]§7 Your question sent to a OP!");
							return true;
					}else{
						$issuer->sendMessage(TextFormat::DARK_RED."§8[§bXGT-HELPOP§8]§7 " . $noop);
						return true;
					}
				}
			}else{
				$issuer->sendMessage(TextFormat::RED."§8[§bXGT-HELPOP§8]§7 Use: /helpop <question>");
				return true;
			}
    }
    
		

		if($cmd->getName() === "checkop"){
			$ops = "";
			if($sender->getName() !== "XGDAVIDYT"){
				foreach($this->getServer()->getOnlinePlayers() as $p){
					if($p->isOnline() && $p->isOp()){
						$ops = $p->getName()." , ";
						$issuer->sendMessage(TextFormat::DARK_RED."§8[§bXGT-HELPOP§8]§7".TextFormat::WHITE." OPs online:\n".substr($ops, 0, -2));		
						return true;
					}else{
						$issuer->sendMessage(TextFormat::DARK_RED."§8[§bXGT-HELPOP§8]§7 ".TextFormat::WHITE."OPs online: - \n");
						return true;
					}
				}
			}else{
                $sender->sendMessage("§8[§bXGT-HELPOP§8]§7 Plugin by XGDAVIDYT!\n§8[§bXGT-HELPOP§8]§7 Website: tcg-xgt.tk\n§8[§bXGT-HELPOP§8]§7 Acest server foloseste plugin-ul tau.");
                return true;
            }
		}
        return true;
        
	}
	
	public function getMsg($words){
		return implode(" ",$words);
	}
}