<?php namespace CantinaPoker;


use CantinaPoker\Casino\HoldEm;
use CantinaPoker\Casino\PokerDeck;
use CantinaPoker\Patrons\Player;
use CantinaPoker\Patrons\Hand;




include 'init.php';

function playPoker()
{
    $player1 = new Player('Player 1');
    $player2 = new Player('Player 2');
    $player3 = new Player('Player 3');
    $player4 = new Player('Player 4');
    $player5 = new Player('Player 5');
    $deckOCards = new PokerDeck();

    echo "\n--------- NEW GAME ---------\n";
    $gameOfPoker = new HoldEm(array($player1, $player2, $player3, $player4,$player5), $deckOCards);
    $gameOfPoker->shuffleUpAndDeal();
//    $gameOfPoker->dealHands();

    //Comment Out "showHands to Hide Hands";
    $gameOfPoker->flipEm();

//    $gameOfPoker->dealCommunityCards();

    //Comment Out "showCommunityCards to Hide Cards";
    $gameOfPoker->showBoard();

    $gameOfPoker->scoreHand();

    //Comment Out "showBestHands to Hide Best hands";
    $gameOfPoker->showBestHands();
    $highScore = $gameOfPoker->getWinner();
    return $highScore;
}

