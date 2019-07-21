<?php declare(strict_types=1);

//require 'chapter_1.php';

/* Chapter 3 */

function rember
($s, array $l) : array
{return
    is_nulll($l) ? [] 
    : (is_eq(car($l), $s) ? cdr($l) 
      : cons(car($l), rember($s, cdr($l))));
}

function firsts
(array $l) : array
{return
    is_nulll($l) ? [] 
    : cons(car(car($l)), firsts(cdr($l)));
}

function insert_right
($new_s, $old_s, array $l) : array
{return
    is_nulll($l) ? []
    : (is_eq(car($l), $old_s) ? cons($old_s, cons($new_s, cdr($l)))
      : cons(car($l), insert_right($new_s, $old_s, cdr($l))));
}

function insert_left
($new_s, $old_s, array $l) : array
{return
    is_nulll($l) ? []
    : (is_eq(car($l), $old_s) ? cons($new_s, $l)
      : cons(car($l), insert_left($new_s, $old_s, cdr($l))));
}

function subst
($new_s, $old_s, array $l) : array
{return
    is_nulll($l) ? []
    : (is_eq(car($l), $old_s) ? cons($new_s, cdr($l))
      : cons(car($l), subst($new_s, $old_s, cdr($l))));
}

function subst2
($new_s, $old_s1, $old_s2, array $l) : array
{return 
    is_nulll($l) ? []
    : (is_eq(car($l), $old_s1) || is_eq(car($l), $old_s2) ? 
        cons($new_s, cdr($l))
      : cons(car($l), subst2($new_s, $old_s1, $old_s2, cdr($l))));
}

function multirember
($s, array $l) : array
{return
    is_nulll($l) ? []
    : (is_eq(car($l), $s) ? multirember($s, cdr($l))
      : cons(car($l), multirember($s, cdr($l))));
}

function multiinsert_right
($new_s, $old_s, array $l) : array
{return
    is_nulll($l) ? []
    : (is_eq(car($l), $old_s) ? 
        cons($old_s, 
             cons($new_s, 
                    multiinsert_right($new_s, $old_s, cdr($l))))
      : cons(car($l), multiinsert_right($new_s, $old_s, cdr($l))));
}

function multiinsert_left
($new_s, $old_s, array $l) : array
{return
    is_nulll($l) ? []
    : (is_eq(car($l), $old_s) ?
            cons($new_s,
                 cons($old_s,
                    multiinsert_left($new_s, $old_s, cdr($l))))
      : cons(car($l), multiinsert_left($new_s, $old_s, cdr($l))));
}

function multisubst
($new_s, $old_s, array $l) : array
{return
    is_nulll($l) ? []
    : (is_eq(car($l), $old_s) ?
       cons($new_s, multisubst($new_s, $old_s, cdr($l)))
      : cons(car($l), multisubst($new_s, $old_s, cdr($l))));
}
