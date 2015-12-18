<?php namespace CantinaPoker\Casino;


use CantinaPoker\Patrons\Hand;
use CantinaPoker\Patrons\Player;

/**
 * Class HoldEm
 * @package CantinaPoker\Casino
 */
class HoldEm implements PokerRoutine
{
    public $seats = 9;

    public $cantinaPlayers;
    public $deckOfCards;
    public $board;
    public $playerCards;
    public $dealt = FALSE;

    public function __construct(array $players, PokerDeck $deckOfCards)
    {
        $this->cantinaPlayers = $players;
        $this->deckOfCards = $deckOfCards;

        foreach($players as $player) {
            $this->cantinaPlayers[] = $player;
        }
    }

    public function sitDown(Player $player)
    {
        $this->cantinaPlayers[] = $player;
    }

    /**
     *
     */
    public function shuffleUpAndDeal()
    {
        $totalCardsDealt = 0;

        $gameDeck = $this->deckOfCards->createAndShuffle();

        foreach($this->cantinaPlayers as $player) {

            $hole0 = $gameDeck[$totalCardsDealt];
            $totalCardsDealt++;
            $hole1 = $gameDeck[$totalCardsDealt];
            $totalCardsDealt++;

            $playerHand = new Hand($hole0,  $hole1);
            $player->newHand($playerHand);

            $holeCards = [$hole0,$hole1];
            $player->setHand($holeCards);

        }

        $this->dealBoard($gameDeck, $totalCardsDealt);

//        $this->dealt = TRUE;
    }

    public function dealBoard($deck, $n) {

        $flop0 = $deck[$n];
        $n++;
        $flop1 = $deck[$n];
        $n++;
        $flop2 = $deck[$n];
        $n++;
        $turn = $deck[$n];
        $n++;
        $river = $deck[$n];

        $this->board = [ $flop0, $flop1, $flop2, $turn, $river];


    }

    public function showBoard() {
        echo "\nCommunity Cards: \n";
        foreach($this->board as $card) {
            $card->flipCard();
        }

    }

    public function texasHoldEmRules()
    {
        $handScore = [];

        foreach($this->cantinaPlayers as $player)
        {
            $ph = $player->getHand();
            $player->setHand(array_merge($ph, $this->board));
        }

        foreach ($this->cantinaPlayers as $player) {

            $handScore[$player->getName()] = $this->flipEm($player);

        }
    }

    public function flipEm()
    {
        foreach($this->cantinaPlayers as $player) {
            $player->showHand();
        }
    }

    public function scoreHand()
    {


        foreach ($this->cantinaPlayers as $player) {
            $player->addBoardToHand($this->board);
            $player->scoreHand();

        }
    }

    public function bigWinner()
    {
        // TODO: Implement bigWinner() method.
    }

    public function determineQualifyingJackpot()
    {
        // TODO: Implement determineQualifyingJackpot() method.
    }

    public function gameOverMan()
    {
        // TODO: Implement gameOverMan() method.
    }
}
