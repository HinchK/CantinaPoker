<?php namespace CantinaPoker\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class DealPokerCommand extends Command
{
    protected function configure()
    {
        $this->setName("poker:start");
        $this->setHelp("<info>php app/console.php poker:start <env></info>");

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question(
            "<question>Input the number of players (between 2 and 9):</question>> ", 6
        );

        $playerTotal = $helper->ask($input, $output, $question);

        if ( intval($playerTotal) < 2 || intval($playerTotal) > 9 ) {
            throw new \InvalidArgumentException("Must have at least 2 and no more than 9 players to play!");
        }

        $output->writeln($playerTotal . " players sit around the table");

    }
}



