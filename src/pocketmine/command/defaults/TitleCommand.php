<?php

#______           _    _____           _                  
#|  _  \         | |  /  ___|         | |                 
#| | | |__ _ _ __| | _\ `--. _   _ ___| |_ ___ _ __ ___   
#| | | / _` | '__| |/ /`--. \ | | / __| __/ _ \ '_ ` _ \  
#| |/ / (_| | |  |   </\__/ / |_| \__ \ ||  __/ | | | | | 
#|___/ \__,_|_|  |_|\_\____/ \__, |___/\__\___|_| |_| |_| 
#                             __/ |                       
#                            |___/

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;

class TitleCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.title.description",
			"%commands.title.usage"
		);
		$this->setPermission("pocketmine.command.title");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) < 2){
			$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));
			return true;
		}

		$player = $sender->getServer()->getPlayer($args[0]);
		if($player === null){
			$sender->sendMessage(new TranslationContainer("commands.generic.player.notFound"));
			return true;
		}

		switch($args[1]){
			case "clear":
				$player->removeTitles();
				break;
			case "reset":
				$player->resetTitles();
				break;
			case "title":
				if(count($args) < 3){
					$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));
					return false;
				}

				$player->addTitle(implode(" ", array_slice($args, 2)));
				break;
			case "subtitle":
				if(count($args) < 3){
					$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));
					return false;
				}

				$player->addSubTitle(implode(" ", array_slice($args, 2)));
				break;
			case "actionbar":
				if(count($args) < 3){
					$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));
					return false;
				}

				$player->addActionBarMessage(implode(" ", array_slice($args, 2)));
				break;
			case "times":
				if(count($args) < 4){
					$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));
					return false;
				}

				$player->setTitleDuration($this->getInteger($sender, $args[2]), $this->getInteger($sender, $args[3]), $this->getInteger($sender, $args[4]));
				break;
				default;
				$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));
				return false;
		}

		$sender->sendMessage(new TranslationContainer("commands.title.success"));

		return true;
	}
}