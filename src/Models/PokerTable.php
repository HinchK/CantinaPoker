<?php namespace CantinaPoker\Models;


class PokerTable
{
    protected $players;


    public function __construct($numberOfPlayers)
    {
        $this->players = $numberOfPlayers;

        if (!$numberOfPlayers) {
            $this->players = 6;
        }
    }
}
