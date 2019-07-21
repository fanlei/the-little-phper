<?php declare(strict_types=1);

/* Chapter 1 */

function car
(array $l) 
{return 
    @$l[0];
}

function cdr
(array $l) : array
{return
    array_slice($l, 1);
}

function cons
($s, array $l) : array
{
    return array_merge([$s], $l);
}

function is_nulll
(array $l) : bool
{return
    [] === $l;
}

function is_atom
($s) : bool
{return 
    ! is_array($s);
}

function is_eq
($s1, $s2) : bool
{return
    $s1 === $s2;
}
