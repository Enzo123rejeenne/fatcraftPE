<?php

namespace hungergames;

use fatutils\loot\ChestsManager;
use fatutils\FatUtils;
use fatutils\players\PlayersManager;
use fatutils\tools\Timer;
use fatutils\tools\WorldUtils;
use fatutils\game\GameManager;
use fatutils\spawns\SpawnManager;
use fatutils\loot\LootManager;
use pocketmine\level\Location;
use pocketmine\network\mcpe\protocol\BossEventPacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class HungerGame extends PluginBase
{
    private $m_HungerGameConfig;
    private static $m_Instance;
    private $m_WaitingTimer;

    public static function getInstance(): HungerGame
    {
        return self::$m_Instance;
    }

    public function onLoad()
    {
        self::$m_Instance = $this;
    }

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);

        FatUtils::getInstance()->setTemplateConfig($this->getConfig());
        $this->m_HungerGameConfig = new HungerGameConfig($this->getConfig());
        $this->initialize();
    }

    private function initialize()
    {
        SpawnManager::getInstance()->blockSpawns();
    }

    public function handlePlayerConnection(Player $p_Player)
    {
        if (GameManager::getInstance()->isWaiting())
        {
            foreach (SpawnManager::getInstance()->getSpawns() as $l_Slot)
            {
                if ($l_Slot instanceof Location)
                {
                    $l_NearbyEntities = $l_Slot->getLevel()
                        ->getNearbyEntities(WorldUtils::getRadiusBB($l_Slot, doubleval(1)));

                    if (count($l_NearbyEntities) == 0)
                    {
                        echo $l_Slot . " available !\n";
                        $p_Player->teleport($l_Slot);
                        break;
                    } else
                        echo $l_Slot . " not available\n";
                }
            }

            echo "onlinePlayers: " . count($this->getServer()->getOnlinePlayers()) >= PlayersManager::getInstance()->getMinPlayer() . "\n";
            if (count($this->getServer()->getOnlinePlayers()) >= PlayersManager::getInstance()->getMaxPlayer())
            {
                echo "MAX PLAYER REACH !\n";
                if ($this->m_WaitingTimer instanceof Timer)
                    $this->m_WaitingTimer->cancel();
                $this->startGame();
            }
            else if (count($this->getServer()->getOnlinePlayers()) >= PlayersManager::getInstance()->getMinPlayer())
            {
                if (is_null($this->m_WaitingTimer))
                {
                    echo "MIN PLAYER REACH !\n";
                    $this->m_WaitingTimer = (new Timer(GameManager::getInstance()->getWaitingTickDuration()))
                        ->addTickCallback(function ()
                        {
                            if ($this->getServer()->getTick() % 20 == 0)
                            {
                                if ($this->m_WaitingTimer instanceof Timer)
                                {
                                    foreach ($this->getServer()->getOnlinePlayers() as $l_Player)
                                    {
                                        $l_Player->sendTip(TextFormat::YELLOW . $this->m_WaitingTimer->getSecondLeft() . TextFormat::RESET . " sec left");
                                    }
                                }
                            }
                        })
                        ->addStopCallback(function ()
                        {
                            $this->startGame();
                        })
                        ->start();
                }
            }

        } else
        {
            $p_Player->setGamemode(3);
            $p_Player->sendMessage(TextFormat::YELLOW . "You've been automatically set to SPECTATOR");
            $this->getServer()->getLogger()->info($p_Player->getName() . " has been set to SPECTATOR");
        }
    }

    //---------------------
    // UTILS
    //---------------------
    public function startGame()
    {
        ChestsManager::getInstance()->fillChests();

        foreach ($this->getServer()->getOnlinePlayers() as $l_Player)
        {
            PlayersManager::getInstance()->getFatPlayer($l_Player)->setPlaying();
            if ($this->getHungerGameConfig()->isSkyWars())
                $l_Player->setGamemode(0);
            $l_Player->sendTip(TextFormat::GREEN . "GO !");
        }

        GameManager::getInstance()->setPlaying();
        SpawnManager::getInstance()->unblockSpawns();
    }

    //---------------------
    // GETTERS
    //---------------------
    /**
     * @return mixed
     */
    public function getHungerGameConfig(): HungerGameConfig
    {
        return $this->m_HungerGameConfig;
    }
}
