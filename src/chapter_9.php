<?php declare(strict_types=1);

/* Chapter 9 */

// unnatural recursion
// sorn - Symbol or number
function keep_looking
($s, $sorn, array $l) : bool
{return
    is_number($sorn) ? keep_looking($s, pick($sorn, $l), $l)
    : is_eq($sorn, $s);
}

function looking
($s, array $l) : bool
{return
    keep_looking($s, pick(1, $l), $l);
}

function eternity
($x)
{return
    eternity($x);
}

use function car as first;

function shift
(array $pair) : array
{return
    build(first(first($pair)), build(second(first($pair)), second($pair)));
}

function align
($pora)
{return
    is_atom($pora) ? $pora 
    : (is_pair(first($pora)) ? align(shift($pora))
      : build(first($pora), align(second($pora))));
}

function length_star
($pora) : int
{return
    is_atom($pora) ? 1
    : plus(length_star(first($pora)), length_star(second($pora)));
}

function weight_star
($pora) : int
{return
    is_atom($pora) ? 1
    : plus(x(weight_star(first($pora)), 2), weight_star(second($pora)));
}

function shuffle1
($pora) 
{return
    is_atom($pora) ? $pora
    : (is_pair(first($pora)) ? shuffle1(revpair($pora))
      : build(first($pora), shuffle1(second($pora))));
}

// Lothar Collatz
function C
(int $n) : int
{return
    is_one($n) ? 1
    : (is_even($n) ? C(division($n, 2))
      : C(add1(x(3, $n))));
}

// Wilhelm Ackermann
function A
(int $n, int $m) : int
{return
    is_zero($n) ? add1($m)
    : (is_zero($m) ? A(sub1($n), 1)
      : A(sub1($n), A($n, sub1($m))));
}

function Y
(callable $le) : callable
{return
    (function (callable $f) 
     {return
        $f($f);
     })(function (callable $f) use ($le) 
        {return
            $le(function ($x) use ($f) 
                {return
                    $f($f)($x);
                });
        });
}
