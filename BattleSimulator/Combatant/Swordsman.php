<?php

namespace BattleSimulator\Combatant;

use BattleSimulator\Combatant\AbstractCombatant;

class Swordsman extends AbstractCombatant
{
    const TYPE = 'Swordsman';
    const SPECIAL_ATTACK = 'Lucky Strike';
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
        $this->luckyStrike = true;
        $strength = $this->getStrength() * 2;
        $damage = $strength - $opponent->getDefense();

        $opponent->reduceHealth($damage);

        return "\n".$this->getName()."'s strength has increased to $strength for it's next attack."
                ."\n".$this->getName()." hit ".$opponent->getName()." for $damage."
                ."\n".$opponent->getName()."'s health is now ".$opponent->getHealth()."\n";
    }
}