<?php namespace CantinaPoker\Command;

use CantinaPoker\Models\Deck;
use CantinaPoker\Models\PokerGame;
use CantinaPoker\Models\PokerTable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class DealPokerCommand extends Command
{
    private $output;

    protected function configure()
    {
        $this->setName("poker:start");
        $this->setHelp("<info>php app/console.php poker:start <env></info>");

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $helper = $this->getHelper('question');

        $question = new Question(
            "<question>Input the number of players you'd like to play against (between 1 and 8):</question>> ", 6
        );

        $playerTotal = $helper->ask($input, $output, $question);

        if ( intval($playerTotal) < 1 || intval($playerTotal) > 8 ) {
            throw new \InvalidArgumentException("Must have at least 2 and no more than 9 players to play!"
            . "\n (Including Yourself)");
        }

        $output->writeln($playerTotal . " other players stand around the table");

        $game = $this->prepareGame($playerTotal);

        $output->writeln('<comment>--- PLAYERS TAKE THEIR SEATS ---</comment>');

        $this->preFlop($game);

        $game->showHands();
        $game->dealCommunityCards();
        $game->showCommunityCards();

        $game->scoreHand();

        $game->showBestHands();

        $winner = $game->getWinner();
    }

    public function prepareGame($numberOfPlayers)
    {
        $pokerTable = new PokerTable($numberOfPlayers);
        $playersInGame = $pokerTable->createTable();
        $deck = new Deck();
        return new PokerGame($deck, $playersInGame);
    }

    public function preFlop(PokerGame $pokerGame)
    {
        $pokerGame->shuffleCards();
        $pokerGame->dealHands();
        $this->viewHoleCards($pokerGame);

    }

    private function viewHoleCards(PokerGame $pokerGame)
    {
        foreach($pokerGame->pokerPlayers as $player)
        {
//            var_dump($player->gameHand->getCards());
            $player->showHand();
//            die();
        }

        $table = new Table($this->output);
        $table
            ->setHeaders(['Hole 1', 'Hole 2'])
            ->setRows([
                ['C-1', 'C-2']
            ]);

        $this->output->write("\n");

        $table->render($this->output);



    }
}



