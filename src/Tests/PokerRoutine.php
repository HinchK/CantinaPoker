<?php namespace CantinaPoker\Casino;

use CantinaPoker\Patrons\Player;

interface PokerRoutine
{
    public function __construct(array $players, PokerDeck $deck);

    public function sitDown(Player $player);

    public function shuffleUpAndDeal();

    public function texasHoldEmRules();

    public function bigWinner();

    public function determineQualifyingJackpot();

    public function gameOverMan();



}
