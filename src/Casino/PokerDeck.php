<?php namespace CantinaPoker\Casino;

/**
 * Class DeckModel
 * @package CantinaPoker\Casino
 */

class PokerDeck
{
    protected $cardRankList = [
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        'Jack',
        'Queen',
        'King',
        'Ace',
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
