<?php

namespace BattleSimulator\Combatant;

use BattleSimulator\Combatant\AbstractCombatant;

class Swordsman extends AbstractCombatant
{
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->healthRange = [40, 60];
        $this->strengthRange = [60, 70];
        $this->defenseRange = [20, 30];
        $this->speedRange = [90, 100];
        $this->luckRange = [0.3, 0.5];
        parent::__construct();
    }
}