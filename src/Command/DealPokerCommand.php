<?php namespace CantinaPoker\Command;

use CantinaPoker\Models\Deck;
use CantinaPoker\Models\PokerGame;
use CantinaPoker\Models\PokerTable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;
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
        $this->flopTurnRiver($game);
        $output->writeln('<comment>--- SHOW YOUR HANDS ---</comment>');
        $this->showDown($game);
        $output->writeln('.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.:.');
        $output->writeln('<fg=black;bg=cyan>------------------ THE WINNER IS: -------------------</>');
        $this->declareWinner($game);


    }

    private function prepareGame($numberOfPlayers)
    {
        $pokerTable = new PokerTable($numberOfPlayers);
        $playersInGame = $pokerTable->createTable();
        $deck = new Deck();
        return new PokerGame($deck, $playersInGame);
    }

    private function preFlop(PokerGame $pokerGame)
    {
        $pokerGame->shuffleCards();
        $pokerGame->dealHands();
        $this->viewHoleCards($pokerGame);

    }

    private function flopTurnRiver(PokerGame $pokerGame)
    {
        $pokerGame->dealCommunityCards();
        $sharedCards = $pokerGame->showCommunityCards();

        $table = new Table($this->output);
        $table->setHeaders(['Flop', 'Flop', 'Flop', 'Turn', 'River']);
        $table->setRows([
            $sharedCards
        ]);

        $table->render($this->output);

    }

    private function showDown(PokerGame $pokerGame)
    {
        $pokerGame->scoreHand();

        $table = new Table($this->output);

        foreach($pokerGame->pokerPlayers as $player)
        {
            $finalHand = $player->showBestHand();
            $table->addRows([
                $finalHand
            ]);
        }

            $finalHand = $pokerGame->hero->showBestHand();

        $table->addRows([
            $finalHand
        ]);

        $table->render($this->output);

    }

    private function declareWinner(PokerGame $pokerGame)
    {
        $style = new TableStyle();
        $style
            ->setVerticalBorderChar('<fg=red;bg=black>|</>')
            ->setHorizontalBorderChar('<fg=red;bg=black>-</>')
        ;
        $winningHand = $pokerGame->getWinner();

//        echo "printing winninghand";
//        print_r($winningHand);

        $table = new Table($this->output);

        $table->setRows([
            $winningHand
        ]);

        $table->render();

    }

    private function viewHoleCards(PokerGame $pokerGame)
    {

        $table = new Table($this->output);
        $table->setHeaders(['CARD', 'CARD']);

        foreach($pokerGame->pokerPlayers as $player)
        {
            $viewHand = $player->showHand();
            $table->setRows([
                 $viewHand
            ]);
            $table->render($this->output);
        }
        $table->setHeaders(['HOLE-CARD', 'HOLE-CARD']);
        $myHand = $pokerGame->hero->showHand();

        $table->setRows([
            $myHand
        ]);

        $table->render($this->output);

    }
}



