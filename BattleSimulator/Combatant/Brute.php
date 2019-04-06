<?php

namespace BattleSimulator\Combatant;

use BattleSimulator\Combatant\AbstractCombatant;

class Brute extends AbstractCombatant
{
    protected $healthRange = [90, 100];
    protected $strengthRange = [65, 75];
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->defenseRange = [40, 50];
        $this->speedRange = [40, 65];
        $this->luckRange = [0.3, 0.35];
        parent::__construct();
    }
}