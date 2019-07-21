<?php declare(strict_types=1);

/* Chapter 5 */

function rember_star
($a, array $l) : array
{return
    is_nulll($l) ? []
    : (is_atom(car($l)) ? 
        is_eq(car($l), $a) ? rember_star($a, cdr($l)) 
        : cons(car($l), rember_star($a, cdr($l)))
      : cons(rember_star($a, car($l)), rember_star($a, cdr($l))));
}

function insert_right_star
($new_s, $old_s, array $l) : array
{return 
    is_nulll($l) ? []
    : (is_atom(car($l)) ? 
        is_eq(car($l), $old_s) ? 
          cons($old_s, cons($new_s, insert_right_star($new_s, $old_s, cdr($l)))) 
        : cons(car($l), insert_right_star($new_s, $old_s, cdr($l)))
      : cons(insert_right_star($new_s, $old_s, car($l)),
             insert_right_star($new_s, $old_s, cdr($l))));
}

function occur_star
($a, array $l) : int
{return
is_nulll($l) ? 0 
: (is_atom(car($l)) ?
    is_eq(car($l), $a) ? add1(occur_star($a, cdr($l)))
    : occur_star($a, cdr($l))
  : plus(occur_star($a, car($l)), occur_star($a, cdr($l))));
}

function subst_star
($new_s, $old_s, array $l) : array
{return 
    is_nulll($l) ? []
    : (is_atom(car($l)) ?
        is_eq(car($l), $old_s) ? 
          cons($new_s, subst_star($new_s, $old_s, cdr($l)))
        : cons(car($l), subst_star($new_s, $old_s, cdr($l))) 
    : cons(subst_star($new_s, $old_s, car($l)),
           subst_star($new_s, $old_s, cdr($l))));
}

function insert_left_star
($new_s, $old_s, array $l) : array
{return 
    is_nulll($l) ? []
    : (is_atom(car($l)) ?
        is_eq(car($l), $old_s) ? 
          cons($new_s, cons($old_s, insert_left_star($new_s, $old_s, cdr($l))))
        : cons(car($l), insert_left_star($new_s, $old_s, cdr($l)))
      : cons(insert_left_star($new_s, $old_s, car($l)),
             insert_left_star($new_s, $old_s, cdr($l))));
}

function member_star
($a, array $l) : bool
{return
    is_nulll($l) ? FALSE
    : (is_atom(car($l)) ? is_eq(car($l), $a) || member_star($a, cdr($l))
      : member_star($a, car($l)) || member_star($a, cdr($l)));
}

function leftmost
(array $l)
{return 
    is_nulll($l) ? NULL 
    : (is_atom(car($l)) ? car($l) 
      : leftmost(car($l)));
}

/*
function is_eqlist
(array $l1, array $l2) : bool
{return 
is_nulll($l1) && is_nulll($l2) ? TRUE 
: (is_nulll($l1) || is_nulll($l2) ? FALSE 
  : (is_atom(car($l1)) && is_atom(car($l2)) ? 
      is_eqan(car($l1), car($l2)) && is_eqlist(cdr($l1), cdr($l2))
    : (is_atom(car($l1)) || is_atom(car($l2)) ? FALSE
      : is_eqlist(car($l1), car($l2)) && is_eqlist(cdr($l1), cdr($l2)))));
}
*/

function is_equal
($s1, $s2) : bool
{return 
is_atom($s1) && is_atom($s2) ? is_eqan($s1, $s2)
: (is_atom($s1) || is_atom($s2) ? FALSE
   : is_eqlist($s1, $s2));
}

function is_eqlist
(array $l1, array $l2) : bool
{return 
    is_nulll($l1) && is_nulll($l2) ? TRUE
    : (is_nulll($l1) || is_nulll($l2) ? FALSE
      : is_equal(car($l1), car($l2)) && is_eqlist(cdr($l1), cdr($l2)));
}

function rember2
($s, array $l) : array
{return
    is_nulll($l) ? []
    : (is_equal(car($l), $s) ? cdr($l)
      : cons(car($l), rember2($s, cdr($l))));
}
