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

    public function getName()
    {
        return $this->name;
    }

    public function getHealth()
    {
        return $this->health;
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
}