<?php declare(strict_types=1);

/* Chapter 4 */

function add1
(int $n) : int
{return 
    $n + 1;
}

function sub1
(int $n) : int
{return 
    $n - 1;
}

function is_zero
($n) : bool
{return 
    0 === $n;
}

function plus
(int $n, int $m) : int
{return
    is_zero($m) ? $n
    : add1(plus($n, sub1($m)));
}

function minus
(int $n, int $m) : int
{return
    is_zero($m) ? $n
    : sub1(minus($n, sub1($m)));
}

function addtup
(array $tup) : int
{return
    is_nulll($tup) ? 0
    : plus(car($tup), addtup(cdr($tup)));
}

function x
(int $n, int $m) : int
{return
    is_zero($m) ? 0
    : plus($n, x($n, sub1($m)));
}

function tupplus
(array $tup1, array $tup2) : array
{return 
    is_nulll($tup1) ? $tup2
    : (is_nulll($tup2) ? $tup1
      : cons(plus(car($tup1), car($tup2)), tupplus(cdr($tup1), cdr($tup2))));
}

function gt
(int $n, int $m) : bool
{return
    is_zero($n) ? FALSE
    : is_zero($m) || gt(sub1($n), sub1($m));
}

function lt
(int $n, int $m) : bool
{return
    is_zero($m) ? FALSE
    : is_zero($n) || lt(sub1($n), sub1($m));
}

function is_eqn
(int $n, int $m) : bool
{return
    is_zero($n) ? is_zero($m)
    : (is_zero($m) ? FALSE
      : is_eqn(sub1($n), sub1($m)));
    //gt($n, $m) || lt($n, $m) ? FALSE : TRUE;
}

function power
(int $n, int $m) : int
{return
    is_zero($m) ? 1
    : x($n, power($n, sub1($m)));
}

function division
(int $n, int $m) : int
{return
    is_zero($m) ? PHP_INT_MAX
    : (lt($n, $m) ? 0
      : add1(division(minus($n, $m), $m)));
}

function length
(array $l) : int
{return
    is_nulll($l) ? 0
    : add1(length(cdr($l)));
}

function pick
(int $n, array $l)
{return
    is_zero($n) ? NULL
    //: (is_zero(sub1($n)) ? car($l) 
    : (is_one($n) ? car($l)
      : pick(sub1($n), cdr($l)));
}

function rempick
(int $n, array $l) : array
{return
    is_zero($n) ? $l
    : (is_nulll($l) ? []
    //: (is_zero(sub1($n)) ? cdr($l) 
      : (is_one($n) ? cdr($l)
        : cons(car($l), rempick(sub1($n), cdr($l)))));
}

function is_number
($n)
{return
    //is_int($n) && $n >=0;
    is_numeric($n) && +$n >=0;
}

function no_nums
(array $l) : array
{return
    is_nulll($l) ? []
    : (is_number(car($l)) ? no_nums(cdr($l))
      : cons(car($l), no_nums(cdr($l))));
}

function all_nums
(array $l) : array
{return
    is_nulll($l) ? []
    : (is_number(car($l)) ? cons(car($l), all_nums(cdr($l)))
      : all_nums(cdr($l)));
}

function is_eqan
($a1, $a2) : bool
{return 
    is_number($a1) && is_number($a2) ? is_eqn($a1, $a2)
    : (is_number($a1) || is_number($a1) ? FALSE
      : is_eq($a1, $a2));
}

function occur
($a, array $l) : int
{return
    is_nulll($l) ? 0
    : (is_eqan(car($l), $a) ? add1(occur($a, cdr($l)))
      : occur($a, cdr($l)));
}

function is_one
(int $n) : bool
{return
    is_eqn($n, 1);
    /*
    is_zero($n) ? FALSE
    : is_zero(sub1($n));
     */
}
