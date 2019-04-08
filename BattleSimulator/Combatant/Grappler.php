<?php

namespace BattleSimulator\Combatant;

use BattleSimulator\Combatant\AbstractCombatant;

class Grappler extends AbstractCombatant
{
    const TYPE = 'Grappler';
    protected $healthRange = [60, 100];
    protected $strengthRange = [75, 80];
    protected $defenseRange = [35, 40];
    protected $speedRange = [60, 80];
    protected $luckRange = [0.3, 0.4];

    public function __construct(string $name)
    {
        $this->name = $name;
        parent::__construct();
    }

    public function dodgeAttack(AbstractCombatant $opponent)
    {
        if (parent::dodgeAttack($opponent)) {
            $this->specialAttack($opponent);
            return true;
        }
        return false;
    }

    protected function specialAttack(AbstractCombatant $opponent)
    {
        $opponent->reduceHealth(10);

        echo "\n" .$this->getName()." counter attack's ".$opponent->getName()." for 10 damage."
                . "\n".$opponent->getName()."'s health is now ".$opponent->getHealth();
    }
}