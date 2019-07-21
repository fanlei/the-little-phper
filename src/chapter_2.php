<?php declare(strict_types=1);

//require 'chapter_1.php';

/* Chapter 2 */

function is_lat
(array $l) : bool
{return
    is_nulll($l) 
    || (is_atom(car($l)) && is_lat(cdr($l)));
}

function is_member
($s, array $l) : bool
{return
    is_nulll($l) ? FALSE
    : is_eq($s, car($l)) || is_member($s, cdr($l));
}
