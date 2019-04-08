<?php

namespace BattleSimulator\Combatant;

use BattleSimulator\Combatant\AbstractCombatant;

class Swordsman extends AbstractCombatant
{
    const TYPE = 'Swordsman';
    protected $healthRange = [40, 60];
    protected $strengthRange = [60, 70];
    protected $defenseRange = [20, 30];
    protected $speedRange = [90, 100];
    protected $luckRange = [0.3, 0.5];
    protected $chance = 5;

    public function __construct(string $name)
    {
        $this->name = $name;
        parent::__construct();
    }

    protected function specialAttack(AbstractCombatant $opponent)
    {
        $strength = $this->getStrength() * 2;
        $damage = $strength - $opponent->getDefense();

        $opponent->reduceHealth($damage);

        return "\n".$this->getName()."'s strength has increased to $strength for his next attack."
                ."\n".$opponent->getName()."'s health is now ".$opponent->getHealth();
    }
}