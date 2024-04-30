<?php

class Rules 
{
    public function decide ($computerMove, $userMove, $numOfMove): string 
    {
        if ($computerMove == $userMove)
        {
            return 'DRAW';
        }

        return (gmp_sign(($computerMove - $userMove + $numOfMove + floor($numOfMove / 2)) % $numOfMove - floor($numOfMove / 2)) < 0) ? 'WIN' : 'LOSE';
    }
}