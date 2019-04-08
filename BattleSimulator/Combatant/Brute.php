<?php

namespace BattleSimulator\Combatant;

use BattleSimulator\Combatant\AbstractCombatant;

class Brute extends AbstractCombatant
{
    const TYPE = 'Brute';
    const SPECIAL_ATTACK = 'Stunning Blow';
    protected $healthRange = [90, 100];
    protected $strengthRange = [65, 75];
    protected $defenseRange = [40, 50];
    protected $speedRange = [40, 65];
    protected $luckRange = [0.3, 0.35];
    protected $chance = 2;

    public function __construct(string $name)
    {
        $this->name = $name;
        parent::__construct();
    }

    protected function specialAttack(AbstractCombatant $opponent)
    {
        $opponent->stunningBlow = true;
        $this->basicAttack($opponent);
    }
}