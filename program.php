<?php

include_once 'table.php';
include_once 'rules.php';
include_once 'hmac.php';

class Program 
{
    private $arrOfArgs;

    private function setArrOfArgs ($array): void 
    {
        $this -> arrOfArgs = $array;
    }

    private function getArrOfArgs (): array 
    {
        return $this -> arrOfArgs;
    }

    private function checkArgs ($args): bool 
    {
        if (sizeof($args) < 3 || sizeof($args) % 2 == 0) 
        {
            echo "Invalid input: please enter an odd number of parameters (more than 3) \n\r";
            return false;
        }

        if (!($this -> checkRepeat($args))) 
        {
            echo "Invalid input: parameters are repeated \n\r";
            return false;
        }
        return true;
    }

    private function checkRepeat ($args): bool
    {
        return sizeof($args) == sizeof(array_unique($args)) ? true : false;
    }

    private function checkInput ($input): bool
    {
        foreach ($this -> arrOfArgs as $key => $val) 
        {
            if ($key == $input || $val == $input) 
            {
                return true;
            }
        }
        return ($this -> checkForHelp($input)) ? false : false;
    }

    private function checkForHelp ($input): bool 
    {
        if ($input == '?')
        {
            $table = new Table;
            $table -> showTable($this -> getArrOfArgs());
            return true;
        }
        return false;
    }

    private function checkForExit ($input): void
    {
        if ($input == 0)
        {
            die();
        }
    }

    public function move (): string 
    {
        $arr = $this -> getArrOfArgs();
        $rand = array_rand($this -> getArrOfArgs());

        return $arr[$rand];
    }

    public function showMoveList (): void 
    {
        echo "Availible moves: \n\r";

        foreach ($this -> arrOfArgs as $key => $val)
        {
            echo ($key+1). " - ". $val. "\n\r";
        }
        echo "0 - exit \n\r";
        echo "? - hepl \n\r";
    }

    private function getIndex ($param): int 
    {
        foreach ($this -> getArrOfArgs() as $key => $val) 
        {
            if ($val == $param) 
            {
                return $key;
            }
        }
        return 0;
    }

    public function Main ($args): void 
    {
        $key = new HMAC;
        $hmac = new HMAC;
        $res = new Rules;

        $this -> setArrOfArgs($args);

        if (!($this -> checkArgs($this -> getArrOfArgs())))
        {
            die();
        }
        
        $PCmove = $this -> move();
        echo "HMAC: \n\r". $hmac -> generateHMAC($key, $PCmove). "\n\r";

        $this -> showMoveList();

        $userMove = readline('Enter your move >> ');
        
        if ($userMove == $this -> checkForExit($userMove))
        {
            die();
        }

        while (!($this -> checkInput($userMove)))
        {
            $userMove = readline('Enter your move >> ');
            $this -> checkForExit($userMove);
        }
        
        echo 'Computer move: '. $PCmove. "\n\r";
        echo 'You '. $res -> decide($this -> getIndex($PCmove), $this -> getIndex($userMove), sizeof($this -> getArrOfArgs())). "\n\r";

        echo "HMAC key: \n\r". $key ->getSecretKey(). "\n\r";
        echo "You can check the result here -> https://www.liavaag.org/English/SHA-Generator/HMAC/";
    }
}

$test = new Program;

$args = $argv;
array_shift($args);

$test->Main($args);
