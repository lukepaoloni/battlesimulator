<?php

namespace BattleSimulator\Combatant;

abstract class AbstractCombatant
{
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

    public function __construct()
    {
        $this->health = random_int($this->health[0], $this->health[1]);
        $this->strength = random_int($this->strength[0], $this->strength[1]);
        $this->defense = random_int($this->defense[0], $this->defense[1]);
        $this->speed = random_int($this->speed[0], $this->speed[1]);
        $this->luck = round(rand(($this->luckRange[0]*100), ($this->luckRange[1]*100)) / 100, 2);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getHealth()
    {
        return $this->health;
    }

    public function reduceHealth(int $damage)
    {
        if ($damage >= 0 && $damage <= 100) {
            $this->health -= $damage;
        }
    }

    public function getStrength()
    {
        return $this->strength;
    }

    public function getDefense()
    {
        return $this->defense;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function getLuck()
    {
        return $this->luck;
    }

    public function getStats()
    {
        return "\nHealth: ".$this->getHealth()."\n".
                "Strength: ".$this->getStrength()."\n".
                "Defense: ".$this->getDefense()."\n".
                "Luck: ".$this->getLuck();
    }

    public function attack(AbstractCombatant $combatant)
    {
        $damage = $this->getStrength() - $combatant->getDefense();
        $message = $this->getName() . ' hit ' . $combatant->getName() . ' for ' . $damage . ' damage.';
        $combatant->reduceHealth($damage);
        $message .= "\n";
        $message .= $combatant->getName() . '\'s health is now '. $combatant->getHealth();
        return $message;
    }

    public function getType()
    {
        return preg_replace(['/BattleSimulator/', '/Combatant/', '/\\\/'], '', get_class($this));
    }
}