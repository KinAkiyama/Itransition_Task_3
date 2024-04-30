<?php

include_once 'rules.php';

require __DIR__ . '/vendor/autoload.php';

class Table 
{
    public function showTable ($arrOfArgs): void
    {
        $decide = new Rules;
        $table = new LucidFrame\Console\ConsoleTable();
        $table -> addHeader (' v PC\User >');

        foreach ($arrOfArgs as $key => $val)
        {
            $table -> addHeader(" $val ");
        }

        foreach ($arrOfArgs as $key => $val)
        {
            $table -> addRow()
                -> addColumn(" $val ");
                for ($i = 0; $i < sizeof($arrOfArgs); $i++)
                {
                    $table -> addColumn($decide -> decide($key, $i, sizeof($arrOfArgs)));
                }
        }
        $table -> showAllBorders()
            -> display();
    }
}