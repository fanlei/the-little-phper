<?php declare(strict_types=1);

/* Chapter 7 */

function is_set
(array $l) : bool
{return
    is_nulll($l) ? TRUE
    : (is_member(car($l), cdr($l)) ? FALSE
      : is_set(cdr($l)));
}

/*
function makeset
(array $l) : array
{return
    is_nulll($l) ? []
    : (is_member(car($l), cdr($l)) ? makeset(cdr($l))
      : cons(car($l), makeset(cdr($l))));
}
*/
function makeset
(array $l) : array
{return 
    is_nulll($l) ? []
    : cons(car($l), makeset(multirember(car($l), cdr($l))));
}

function is_subset
(array $set1, array $set2) : bool
{return 
    is_nulll($set1) ? TRUE
    : is_member(car($set1), $set2) && is_subset(cdr($set1), $set2);
}

function is_eqset
(array $set1, array $set2) : bool
{return 
    is_subset($set1, $set2) && is_subset($set2, $set1);
}

function is_intersect
(array $set1, array $set2) : bool
{return 
    is_nulll($set1) ? FALSE
    : is_member(car($set1), $set2) || is_intersect(cdr($set1), $set2);
}

function intersect
(array $set1, array $set2) : array
{return 
    is_nulll($set1) ? $set1
    : (is_member(car($set1), $set2) ? 
        cons(car($set1), intersect(cdr($set1), $set2))
      : intersect(cdr($set1), $set2));
}

function union
(array $set1, array $set2) : array
{return 
    is_nulll($set1) ? $set2
    : (is_member(car($set1), $set2) ? union(cdr($set1), $set2)
      : cons(car($set1), union(cdr($set1), $set2)));
}

function difference
(array $set1, array $set2) : array
{return 
    is_nulll($set1) ? []
    : (is_member(car($set1), $set2) ? difference(cdr($set1), $set2) 
      : cons(car($set1), difference(cdr($set1), $set2)));
}

// $l_set is non-empty
// little.js is mis-implemented
function intersectall
(array $l_set)
{return
    is_nulll(cdr($l_set)) ? car($l_set)
    : intersect(car($l_set), intersectall(cdr($l_set)));
}

function is_pair
($x) : bool
{return 
    is_atom($x) ? FALSE 
    : (is_nulll($x) ? FALSE
      : (is_nulll(cdr($x)) ? FALSE 
        : (is_nulll(cdr(cdr($x))) ? TRUE
          : FALSE)));
    //is_eq_n(length($x), 2);
}

use function car as first;

function second
(array $l)
{return 
    car(cdr($l));
}

function build
($s1, $s2) : array
{return 
    cons($s1, cons($s2, []));
    // [$s1, $s2]
}

function third
(array $l)
{return
    car(cdr(cdr($l)));
}

// not in TLS
function is_rel
(array $l)
{return
    is_set($l) ? // check in every recusion - not good
        is_pair(car($l)) ? 
            is_nulll(cdr($l)) ? TRUE
            : is_rel(cdr($l))
        : FALSE
    : FALSE;
}

function is_fun
(array $rel)
{return
    is_set(firsts($rel));
}

function revpair
(array $pair) : array
{return
    build(second($pair), first($pair));
}

function revrel
(array $rel) : array
{return 
    is_nulll($rel) ? $rel
    : cons(revpair(car($rel)), revrel(cdr($rel)));
}

function seconds
(array $l) : array
{return 
    is_nulll($l) ? []
    : cons(second(car($l)), seconds(cdr($l)));
}

function is_fullfun
(array $fun) : bool
{return 
    is_set(seconds($fun));
}

function is_one2one
(array $fun) : bool
{return
    is_fun(revrel($fun));
}
