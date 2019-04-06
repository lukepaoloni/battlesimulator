<?php

namespace BattleSimulator\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Command\Command;
use BattleSimulator\Combatant\AbstractCombatant;

class BattleCommand extends Command
{
    private static $combatants = [
        '\BattleSimulator\Combatant\Swordsman',
        '\BattleSimulator\Combatant\Brute',
        '\BattleSimulator\Combatant\Grappler'
    ];
    
    protected static $defaultName = 'battle:start';
    
    const MAX_ROUNDS = 30;
    
    private $input;

    private $output;

    private $winner;

    private $isValid = false;

    protected function configure()
    {
        $this->
            setDescription('BattleSimulator command.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $helper = $this->getHelper('question');
        do {
            $combatant1Question = new Question('Enter your name for combatant 1: ');
            $combatants1Name = $helper->ask($input, $output, $combatant1Question);
            $this->isValid = $this->isNameValid($combatants1Name);
            
        } while (!$this->isValid);
        
        $this->isValid = false;

        do {
            $combatant2Question = new Question('Enter your name for combatant 2: ');
            $combatants2Name = $helper->ask($input, $output, $combatant2Question);
            $this->isValid = $this->isNameValid($combatants2Name);
        } while (!$this->isValid);
        
        $combatants = $this->selectCombatants($combatants1Name, $combatants2Name);
        $this->battle($combatants);
    }

    private function isNameValid(string $name)
    {
        return mb_strlen($name) <= 30 ? 
                true 
                : 
                $this->output->writeln('The name of combatant 2 must be 30 characters or less.');;
    }

    private function battle(array $battlers)
    {
        $this->output->writeln($battlers[0]->getName() . " is fighting as a " . $battlers[0]->getType().':');
        $this->output->writeln($battlers[0]->getStats());
        $this->output->writeln($battlers[1]->getName() . " is fighting as a " . $battlers[1]->getType().':');
        $this->output->writeln($battlers[0]->getStats());
        $combatants = $this->sortAttackOrder($battlers[0], $battlers[1]);
        
        for ($i = 0; $i <= self::MAX_ROUNDS - 1; $i++) {
            $this->output->writeln("Round ".($i+1));
           
            $this->output->writeln($combatants[0]->attack($combatants[1]));
            if ($this->isWinner($combatants[0], $combatants[1])) {
                break;
            }
            $this->output->writeln($combatants[1]->attack($combatants[0]));
            if ($this->isWinner($combatants[1], $combatants[0])) {
                break;
            }
        }
        if (!$this->getWinner()) {
            $this->output->writeln('The fight has ended. Draw.');
        } else {
            $this->output->writeln('The champion is '.$this->getWinner()->getName());
        }
    }

    private function isWinner(AbstractCombatant $combatant1, AbstractCombatant $combatant2)
    {
        if ($combatant1->getHealth() === 0) {
            $this->setWinner($combatant2);
            return true;
        } else if ($combatant2->getHealth() === 0) {
            $this->setWinner($combatant1);
            return true;
        }
        return false;
    }

    private function getWinner()
    {
        return $this->winner;
    }

    private function setWinner(AbstractCombatant $winner)
    {
        $this->winner = $winner;
    }

    private function sortAttackOrder(AbstractCombatant $combatant1, AbstractCombatant $combatant2)
    {
        if ($combatant1->getSpeed() > $combatant2->getSpeed()) {
            return [$combatant1, $combatant2];
        } else if ($combatant2->getSpeed() > $combatant1->getSpeed()) {
            return [$combatant2, $combatant1];
        } else { // They have the same speed
            if ($combatant1->getDefense() <= $combatant2->getDefense()) {
                return [$combatant1, $combatant2];
            } else {
                return [$combatant2, $combatant1];
            }
        }
    }

    private function selectCombatants(string $combatants1Name, string $combatants2Name)
    {
       $battlers = [];

       $combatant1 = $this->getRandomCombatant();
       $battlers[0] = new $combatant1($combatants1Name);

       $combatant2 = $this->getRandomCombatant();
       $battlers[1] = new $combatant2($combatants2Name);

       return $battlers;
    }

    private function getRandomCombatant()
    {
        $totalCombatants = count(BattleCommand::$combatants) - 1;
        return BattleCommand::$combatants[random_int(0, $totalCombatants)];
    }
}