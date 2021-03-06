<?php namespace CantinaPoker\Models;


use Exception;

class PokerGame
{

	public $seats = 9;

	public $pokerPlayers;
	public $cardDeck;
	public $hero;
	public $communityCards;

	public function __construct($deckOfCards, $players)
	{
		$this->cardDeck = $deckOfCards;
		$this->hero = new Player('YOU');
		try
		{
			if (count($players) > $this->seats)
			 {
			 	throw new \InvalidArgumentException("Sorry, there are too many players");

			}
			else
			{
				foreach($players as $player)
				{
					$this->pokerPlayers[] = $player;
				}
			}
		}
		catch(Exception $e)
		{
			echo 'Error: ' . $e->getMessage() . "\n";
		}

	}

	public function addPlayer($player)
	{
		try
		{
			if (count($pokerPlayers) >= $seats) //$hero is included in the Poker Players
			{
				throw new Exception("No Seats Available");

			}
			else
			{
				$this->pokerPlayers[]=$player;
			}
		}
		catch(Exception $e)
		{
			echo 'Error: ' . $e->getMessage() . "\n";
		}
	}

	public function getWinner()
	{
		$scoreArray = array();
		foreach($this->pokerPlayers as $node =>$pokerPlayer)
		{
			$scoreArray[$pokerPlayer->playerName] = array($pokerPlayer->getHandScore(), $pokerPlayer);

		}
		$scoreArray[$this->hero->playerName] = array($this->hero->getHandScore(), $this->hero);

		$highScore = 0;
		$highScoreArray = array();
		foreach($scoreArray as $player)
		{
			if($player[0] == $highScore)
			{
				//There will be at least ONE player in the highscorearray
				//compare the player to the winners.
				$winner = $highScoreArray[0];

				$winnerCounts = $winner[1]->getBestHand()->getValueCounts();

				$newCounts = $player[1]->getBestHand()->getValueCounts();

				$maxArray = max(array_keys($newCounts), array_keys($winnerCounts));

				$arrayReturn = array_intersect_key($newCounts, array_flip($maxArray));
				//print_r($highScoreArray);
				//echo "\nWinner Counts: \n";
			//	print_r($winnerCounts);
			//	echo "\nNewCounts: \n";
			//	print_r($newCounts);
			//	echo "\nMaxCounts: \n";
			//	print_r($maxArray);
			//	echo "\nArrayReturn\n";
			//	print_r($arrayReturn);
				//special case for straights
				if($highScore == 9 || $highScore ==5)
				{
					$sumOfPlayer = $player[1]->getBestHand()->handSum();
					$sumOfWinner = $winner[1]->getBestHand()->handSum();
					if($sumOfPlayer != 28 &&  $sumOfWinner != 28)
					{
						if($sumOfPlayer == $sumOfWinner)
						{
							$highScoreArray[] = $player;
						}
						elseif($sumOfPlayer > $sumOfWinner)
						{
							//reset the array to zero items because all previous items were ties.
							$highScoreArray = array();
							$highScoreArray[] = $player;
						}
					}
					elseif ($sumOfPlayer != 28 && $sumOfWinner ==28)
					{
						//reset the array to zero items because all previous items were ties.
						$highScoreArray = array();
						$highScoreArray[] = $player;
					}
				}
				elseif($newCounts == $winnerCounts)
				{
					$highScoreArray[] = $player;
				}
				elseif($arrayReturn === $newCounts)
				{
					//reset the array to zero items because all previous items were ties.
					$highScoreArray = array();
					$highScoreArray[] = $player;
				}

			}
			elseif ($player[0] > $highScore)
			{
				//reset highscore and clear array;
				//this also handles the first item of an array
				$highScoreArray = array();
				$highScoreArray[] = $player;
				$highScore = $player[0];

			}
		}
		if(count($highScoreArray) > 1)
		{
			echo "\n-------------------\nIt is a tie!!! " . "\n\n";
            $tieWinners = [];
			foreach ($highScoreArray as $tiePlayer) {
				$tieWinners[] = $tiePlayer[1]->showGameWinner();
			}
            return $tieWinners[0];
		}
		else
		{
			return $highScoreArray[0][1]->showGameWinner();
		}
//		return $highScore;
	}

	public function scoreHand()
	{


		foreach($this->pokerPlayers as $player)
		{
			$player->loadCommunityCards($this->communityCards);
			$player->scoreHand();

		}
		$this->hero->loadCommunityCards($this->communityCards);
		$this->hero->scoreHand();

	}


	public function dealHands()
	{
		foreach($this->pokerPlayers as $node => $players)
		{


			$card1 = $this->cardDeck->getCard();
			$card2 = $this->cardDeck->getCard();
			$pokerHand = new PokerHand($card1, $card2);
		 	$players->newHand($pokerHand);

		}
		$pokerHand = new PokerHand($this->cardDeck->getCard(), $this->cardDeck->getCard());
		$this->hero->newHand($pokerHand);

	}

	public function showHands()
	{
		foreach($this->pokerPlayers as $node =>$players)
		{
			$players->showHand();
		}
		$this->hero->showHand();
	}

	public function showBestHands()
	{
		foreach($this->pokerPlayers as $node =>$players)
		{
			$players->showBestHand();
		}
		$this->hero->showBestHand();
	}

	public function dealCommunityCards()
	{
		$this->communityCards = array(
			$this->cardDeck->getCard(),
			$this->cardDeck->getCard(),
			$this->cardDeck->getCard(),
			$this->cardDeck->getCard(),
			$this->cardDeck->getCard());
	}

	public function showCommunityCards()
	{
//		echo "\nCommunity Cards: \n";

        $boardViewer = [];
		foreach($this->communityCards as $card)
		{
			$boardViewer[] = $card->displayCard();
		}
        return $boardViewer;
//		echo "\n\n";
	}


	public function shuffleCards()
	{
		$this->cardDeck->shuffleDeck();
	}
}
