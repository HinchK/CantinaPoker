<?php namespace CantinaPoker\Casino;

/**
 * Class DeckModel
 * @package CantinaPoker\Casino
 */

class PokerDeck
{
    protected $cardRankList = [
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        'Jack' => 11,
        'Queen' => 12,
        'King' => 13,
        'Ace' => 14,
    ];
    protected $suits = ['Spades', 'Hearts', 'Clubs', 'Diamonds'];

    /**
     * Iterate the deck's contents as new
     * then shuffle 'er up!
     *
     * @return array
     */
    public function createAndShuffle()
    {
        foreach($this->suits as $suit) {
            foreach($this->cardRankList as $cardRank) {
                $deckOfCards[] = new Card($cardRank, $suit);
            }
        }

        shuffle($deckOfCards);
        return $deckOfCards;
    }


}
