<?php namespace CantinaPoker\Command;

use CantinaPoker\Models\Deck;
use CantinaPoker\Models\PokerGame;
use CantinaPoker\Models\PokerTable;
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
            "<question>Input the number of players you'd like to play against (between 1 and 8):</question>> ", 6
        );

        $playerTotal = $helper->ask($input, $output, $question);

        if ( intval($playerTotal) < 1 || intval($playerTotal) > 8 ) {
            throw new \InvalidArgumentException("Must have at least 2 and no more than 9 players to play!"
            . "\n (Including Yourself)");
        }

        $output->writeln($playerTotal . " players sit around the table");

        $pokerTable = new PokerTable($playerTotal);
        $playersInGame = $pokerTable->createTable();

        $deck = new Deck();
        $output->writeln('<comment>--- THE PLAYERS TAKE THEIR SEATS ---</comment>');
        $game = new PokerGame($deck, $playersInGame);
        $game->shuffleCards();
        $game->dealHands();
        $game->showHands();
        $game->dealCommunityCards();
        $game->showCommunityCards();

        $game->scoreHand();

        $game->showBestHands();

        $winner = $game->getWinner();

    }
}



