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

class HelpOp extends PluginBase {

    public function onEnable() : void{
        $this->config = new Config($this->getDataFolder() . "HelpOp.yml", Config::YAML);
        $this->saveResource("HelpOp.yml");
        $this->getLogger()->info("HelpOP by XGDAVIDYT enabled!\nWebsite: tcg-xgt.tk");
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $name = $player->getName();
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{

        $issuer = $sender;
        $s = $sender;
        $messageop =  $this->getConfig()->get("Message-OP");
        $noop =  $this->getConfig()->get("NoOpOnline");

        switch($command->getName()){
        case "helpop":
            if(!isset($args[0])){
                $sender->sendMessage("§8[§7XGT§8]§7 Use: /helpop <question>");
                return false;
            }                  
            if(count($args) < 1){ //inutile
                foreach($this->getServer()->getOnlinePlayers() as $p){  //inutile
                    if($p->isOnline() && $p->isOp){  //inutile
                        $p->sendMessage("§8(§eSTAFF§8) →§7 Questions:§a " . $this->getMsg($args) . "§7 de la§e " . $s->getName());  //inutile
                        $p->sendMessage("§8(§eSTAFF§8) →§7 Foloseste comanda x pentru a raspunde.");  //inutile
                        $issuer->sendMessage("§8[§a?§8]§7 Intreabarea ta a fost trimisa staff-ului!");  //inutile
        return true;  //inutile
                    }else{  //inutile
                        $issuer->sendMessage("§8[§2!§8]§7 In acest moment nu sunt§e Helperi§7 online!");  //inutile
        return true;  //inutile
                    }  //inutile
                }  //inutile
        return true;  //inutile
            }else if(count($args) => 1){
                foreach($this->getServer()->getOnlinePlayers() as $p){
                    if($p->isOnline() && $p->isOp){
                        $p->sendMessage("§8(§eSTAFF§8) §7 Question:§a " . $this->getMsg($args) . "§7 from§e " . $s->getName());
                        $p->sendMessage($messageop);
                        $issuer->sendMessage("§8[§7XGT§8]§7 Your question send to OP!");
        return true;
                    }else{
                        $issuer->sendMessage("§8[§7XGT§8]§7 " . $noop);
                        return true;
                    }
                }
            }
        break;
        case "checkop":
            $ops = "";
            if($issuer-getName() !== "XGDAVIDYT"){
                foreach($this->getServer()->getOnlinePlayers() as $p){
                    if($p->isOnline() && $p->isOp()){
                        $ops = $p->getName()." , ";
                        $issuer->sendMessage(TextFormat::DARK_RED."§8[§7XGT§8]§7".TextFormat::WHITE." OPs online:\n".substr($ops, 0, -2));		
                        return true;
                    }else{
                        $issuer->sendMessage(TextFormat::DARK_RED."§8[§7XGT§8]§7 ".TextFormat::WHITE."OPs online: \n");
                        return true;
                    }
                }
            }else{
                $issuer->sendMessage(TextFormat::RED."Bine ai venit sefu meu XGDAVIDYT iti multumesc ca nu m ai lasat la greu.");
                return true;
            }
        break;
        }
    }
}
