<?php

namespace BattleSimulator\Combatant;

abstract class AbstractCombatant
{
    const TYPE = null;
    const SPECIAL_ATTACK = null;
    protected $chance;
    protected $name;
    protected $health;
    protected $strength;
    protected $defense;
    protected $speed;
    protected $luck;
    protected $healthRange = [0, 100]; // [minimum, maximum]
    protected $strengthRange = [0, 100]; // [minimum, maximum]
    protected $defenseRange = [0, 100]; // [minimum, maximum]
    protected $speedRange = [0, 100]; // [minimum, maximum]
    protected $luckRange = [0, 1]; // [minimum, maximum]
    protected $counterAttack = false;
    protected $stunningBlow = false;
    protected $luckyStrike = false;
    protected $useSpecialAttack = false;

    public function __construct()
    {
        $this->health = random_int($this->healthRange[0], $this->healthRange[1]);
        $this->strength = random_int($this->strengthRange[0], $this->strengthRange[1]);
        $this->defense = random_int($this->defenseRange[0], $this->defenseRange[1]);
        $this->speed = random_int($this->speedRange[0], $this->speedRange[1]);
        $this->luck = round(rand(($this->luckRange[0]*100), ($this->luckRange[1]*100)) / 100, 2);
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getHealth() : int
    {
        return $this->health;
    }

    public function reduceHealth(int $damage)
    {
        if ($damage >= 0) {
            $this->health -= $damage;
        }
        if ($this->health < 0) {
            $this->health = 0;
        }
    }

    public function getStrength() : int
    {
        return $this->strength;
    }

    public function getDefense() : int
    {
        return $this->defense;
    }

    public function getSpeed() : int
    {
        return $this->speed;
    }

    public function getLuck() : float
    {
        return $this->luck;
    }

    public function getUseSpecialAttack() : bool
    {
        return $this->useSpecialAttack;
    }

    public function setUseSpecialAttack(bool $useSpecialAttack)
    {
        $this->useSpecialAttack = $useSpecialAttack;
    }

    public function getStats() : string
    {
        return "\nHealth: ".$this->getHealth()."\n".
                "Strength: ".$this->getStrength()."\n".
                "Defense: ".$this->getDefense()."\n".
                "Luck: ".$this->getLuck()."\n".
                "Special Attack: ".static::SPECIAL_ATTACK;
    }

    public function getType() : string
    {
        return static::TYPE;
    }

    public function attack(AbstractCombatant $opponent)
    {
        echo "\n". $this->getName() . "'s turn:\n";

        if ($opponent->dodgeAttack($this)) {
            return false;
        }

        if ($this->canUseSpecialAttack()) {
            echo $this->specialAttack($opponent);
        }

        if ($this->stunningBlow) {
            $this->stunningBlow = false;
            echo $this->getName() . ' you have been stunned by ' . $opponent->getName()."\n";
            return;
        }

        if ($this->luckyStrike) {
            $this->luckyStrike = false;
            return;
        }
        $this->basicAttack($opponent);
    }

    protected function basicAttack(AbstractCombatant $opponent)
    {
        $damage = (int) $this->getStrength() - $opponent->getDefense();
        $opponent->reduceHealth($damage);

        echo $this->getName() . ' hit ' . $opponent->getName() . ' for ' . $damage . ' damage.';
        echo "\n";
        echo $opponent->getName() . '\'s health is now '. $opponent->getHealth()."\n";
    }

    public function dodgeAttack(AbstractCombatant $opponent)
    {
        if (!$this->canDodge()) {
            return false;
        }
        echo $this->getName() . ' dodges '.$opponent->getName().'\'s attack.'."\n";
        return true;
    }

    protected function canDodge() : bool
    {
        $random = random_int(0, 100);

        if ($random <= round(($this->getLuck() * 100))) {
            return true;
        }
        return false;
    }

    protected function canUseSpecialAttack() : bool
    {
        $random = random_int(0, 100);
        if ($random <= $this->chance) {
            return true;
        }
        return false;
    }

    abstract protected function specialAttack(AbstractCombatant $combatant);
}