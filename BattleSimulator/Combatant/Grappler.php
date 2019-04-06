<?php

namespace BattleSimulator\Combatant;

use BattleSimulator\Combatant\AbstractCombatant;

class Grappler extends AbstractCombatant
{
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->healthRange = [60, 100];
        $this->strengthRange = [75, 80];
        $this->defenseRange = [35, 40];
        $this->speedRange = [60, 80];
        $this->luckRange = [0.3, 0.4];
        parent::__construct();
    }
}