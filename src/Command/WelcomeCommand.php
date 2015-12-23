<?php namespace CantinaPoker\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class WelcomeCommand extends Command
{
    protected function configure()
    {
        $this->setName("poker:start");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question(
            "<question>Input the number of players (between 2 and 9):</question>> ", 6
        );

        $playerTotal = $helper->ask($input, $output, $question);

        $output->writeln($playerTotal . " players sit around the table");

    }
}



