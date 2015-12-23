<?php namespace CantinaPoker\Models;


class PokerTable
{
    protected $players;


    public function __construct($numberOfPlayers)
    {
        $this->players = intval($numberOfPlayers);
        $this->createTable();

    }

    public function createTable()
    {
        var_dump($this->players);

        $playing = array();

        for ($i = 0; $i < $this->players; $i++) {
            $playerNumber = $i + 1;
            $playerName = "Player " . $playerNumber;
            echo($playerName);
            $playing[$i] = new Player($playerName);
        }

        var_dump($playing);

    }
}
