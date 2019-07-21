<?php declare(strict_types=1);

/* Chapter 6 */

/*
function is_numbered
($aexp) : bool
{return 
    is_atom($aexp) ? is_number($aexp)
    : (   is_eq(car(cdr($aexp)), '+')
       || is_eq(car(cdr($aexp)), 'x')
       || is_eq(car(cdr($aexp)), '^'))
      && is_numbered(car($aexp))
      && is_numbered(car(cdr(cdr($aexp))));
}
 */
function is_numbered
($aexp) : bool
{return
    is_atom($aexp) ?  is_number($aexp)
    : is_numbered(car($aexp)) && is_numbered(car(cdr(cdr($aexp))));
}

/*
function value
($nexp) : int
{return 
    is_atom($nexp) ? $nexp
    : (is_eq(car(cdr($nexp)), '+') ? 
      plus(value(car($nexp)), value(car(cdr(cdr($nexp)))))
      : (is_eq(car(cdr($nexp)), 'x') ? 
          x(value(car($nexp)), value(car(cdr(cdr($nexp)))))
        : power(value(car($nexp)), value(car(cdr(cdr($nexp)))))));
}
 */

function second_sub_exp
($aexp)
{return
    car(cdr(cdr($aexp)));
}

/*
// prefix
function first_sub_exp
($aexp)
{return 
    car(cdr($aexp));
}

use function car as operator;
*/

// infix
use function car as first_sub_exp;
    
function operator
($nexp)
{return 
    car(cdr($nexp));
}

/* refactored in chapter_8.php
function value
($nexp) : int
{return 
    is_atom($nexp) ? $nexp
    : (is_eq(operator($nexp), '+') ?
        plus(value(first_sub_exp($nexp)), value(second_sub_exp($nexp)))
      : (is_eq(operator($nexp), 'x') ? 
          x(value(first_sub_exp($nexp)), value(second_sub_exp($nexp)))
        : power(value(first_sub_exp($nexp)), value(second_sub_exp($nexp)))));
}
 */

/*
 * (() () ())
 * 4 primitives for numbers:
 * is_number, is_zero, add1 and sub1
 */
function is_sero
($n) : bool
{return
    is_nulll($n);
}

function edd1
($n)
{return 
    cons([], $n);
}

use function cdr as zub1;

function blus
($n, $m)
{return 
    is_sero($m) ? $n
    : edd1(blus($n, zub1($m)));
}
