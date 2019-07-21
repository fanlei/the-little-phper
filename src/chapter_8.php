<?php declare(strict_types=1);
/*
foreach (get_defined_functions()['user'] as $func_name) {
    $$func_name = $func_name;
}
*/

/* Chapter 8 */

/*
function rember_f
(callable $test, $s, array $l) : array
{return 
    is_nulll($l) ? []
    : ($test(car($l), $s) ? cdr($l)
    : cons(car($l), rember_f($test, $s, cdr($l))));
}
 */

function is_eq_c
($a) : callable
{return 
    function ($x) use ($a) : bool
    {return
        is_eq($x, $a);
    };
}

function rember_f
(callable $test) : callable
{return 
    function ($s, array $l) use ($test) : array {
    return
        is_nulll($l) ? []
        : ($test(car($l), $s) ? cdr($l) 
          : cons(car($l), rember_f($test)($s, cdr($l))));
          //cons(car($l), call_user_func_array($rember_f($test), [$s, cdr($l)]));
    };
}

function insert_left_f
(callable $test) : callable
{return
    function ($new_s, $old_s, array $l) use ($test) : array
    {return 
        is_nulll($l) ? []
        : ($test(car($l), $old_s) ? cons($new_s, cons($old_s, cdr($l)))
          : cons(car($l), insert_left_f($test)($new_s, $old_s, cdr($l))));
    };
}

function insert_right_f
(callable $test) : callable
{return 
    function($new_s, $old_s, array $l) use ($test) : array
    {return
    is_nulll($l) ? []
    : ($test(car($l), $old_s) ? cons($old_s, cons($new_s, cdr($l)))
      : cons(car($l), insert_right_f($test)($new_s, $old_s, cdr($l))));
    };
}

function seq_l
($new_s, $old_s, array $l) : array
{return 
    cons($new_s, cons($old_s, $l));
}

function seq_r
($new_s, $old_s, array $l) : array
{return 
    cons($old_s, cons($new_s, $l));
}

function seq_s
($new_s, $old_s, array $l) : array
{return 
    cons($new_s, $l);
}

function seqrem
($new_s, $old_s, array $l) : array
{return
    $l;
}

function insert_g
(callable $seq) : callable
{return 
    function($new_s, $old_s, array $l) use ($seq) : array
    {return 
        is_nulll($l) ? []
        : (is_eq(car($l), $old_s) ? $seq($new_s, $old_s, cdr($l)) 
          : cons(car($l), insert_g($seq)($new_s, $old_s, cdr($l))));
    };
}

function atom_to_function
($operator) : callable
{return
    is_eq($operator, '+') ? 'plus'
    : (is_eq($operator, 'x') ? 'x'
      : 'power');
}

/*
// prefix
use function car as operator;
 */

// infix
use function car as first_sub_exp;

function value
($nexp) : int
{return
    is_atom($nexp) ? $nexp
    : atom_to_function(operator($nexp))
        (value(first_sub_exp($nexp)),
            value(second_sub_exp($nexp)));
}

function multirember_f
(callable $test) : callable
{return 
    function($s, array $l) use ($test) : array
    {return 
        is_nulll($l) ? []
        : ($test($s, car($l)) ? multirember_f($test)($s, cdr($l))
          : cons(car($l), multirember_f($test)($s, cdr($l))));
    };
}

function multirember_t
($test, array $l) : array
{return
    is_nulll($l) ? []
    : ($test(car($l)) ? multirember_t($test, cdr($l))
      : cons(car($l), multirember_t($test, cdr($l))));
}

function multirember_co
($s, array $l, callable $col)
{return 
    is_nulll($l) ? $col([], [])
    : (is_eq($s, car($l)) ? 
      multirember_co($s, cdr($l),
          function (array $new_l, array $seen) use ($col, $l)
          {return // new-friend
              $col($new_l, cons(car($l), $seen));
          })
      : (multirember_co($s, cdr($l),
          function (array $new_l, array $seen) use ($col, $l)
          {return // latest-friend
              $col(cons(car($l), $new_l), $seen);
          })));
}

function a_friend
($s_1, $s_2) : bool
{return 
    is_nulll($s_2);
}

function last_friend
(array $new_l, array $seen) : int
{return 
    length($new_l);
}

function multiinsert_left_right
($new_s, $old_L, $old_R, array $l) : array
{return
    is_nulll($l) ? []
    : (is_eq($old_L, car($l)) ?
      cons($new_s, cons($old_L,
            multiinsert_left_right($new_s, $old_L, $old_R, cdr($l))))
      : (is_eq($old_R, car($l)) ?
        cons($old_R, cons($new_s,
            multiinsert_left_right($new_s, $old_L, $old_R, cdr($l))))
        : (cons(car($l),
            multiinsert_left_right($new_s, $old_L, $old_R, cdr($l))))));
}

function multiinsert_left_right_co
($new_s, $old_L, $old_R, array $l, callable $col)
{return 
    is_nulll($l) ? $col([], 0, 0)
    : (is_eq($old_L, car($l)) ?
      multiinsert_left_right_co($new_s, $old_L, $old_R, cdr($l),
            function (array $new_l, $n_L, $n_R) use ($col, $new_s, $old_L)
            {return
                $col(cons($new_s, cons($old_L, $new_l)), add1($n_L), $n_R);
            })
      : (is_eq($old_R, car($l)) ?
        multiinsert_left_right_co($new_s, $old_L, $old_R, cdr($l),
            function (array $new_l, $n_L, $n_R) use ($col, $new_s, $old_R)
            {return
                $col(cons($old_R, cons($new_s, $new_l)), $n_L, add1($n_R));
            })
        : (multiinsert_left_right_co($new_s, $old_L, $old_R, cdr($l),
            function (array $new_l, $n_L, $n_R) use ($col, $l)
            {return
                $col(cons(car($l), $new_l), $n_L, $n_R);
            }))));
}

function is_even
(int $n) : bool
{return 
    is_eqn($n, x(division($n, 2), 2));
}

function evens_only_star
(array $l) : array
{return
    is_nulll($l) ? []
    : (is_atom(car($l)) ? 
        is_even(car($l)) ? cons(car($l), evens_only_star(cdr($l)))
        : evens_only_star(cdr($l))
      : cons(evens_only_star(car($l)), evens_only_star(cdr($l))));
}

function evens_only_star_co
(array $l, callable $col)
{return 
    is_nulll($l) ? $col([], 1, 0)
    : (is_atom(car($l)) ?
        is_even(car($l)) ? evens_only_star_co(cdr($l),
            function (array $new_l, int $product, int $sum) use ($col, $l)
            {return 
                $col(cons(car($l), $new_l), x(car($l), $product), $sum);
            })
        : evens_only_star_co(cdr($l),
            function (array $new_l, int $product, int $sum) use ($col, $l)
            {return 
                $col($new_l, $product, plus(car($l), $sum));
            })
      : evens_only_star_co(car($l), 
            function (array $a_l, int $a_product, int $a_sum) use ($col, $l)
            {return
                evens_only_star_co(cdr($l), 
                    function(array $d_l, int $d_product, int $d_sum) 
                    use ($col, $l, $a_l, $a_product, $a_sum)
                    {return
                        $col(cons($a_l, $d_l), 
                             x($a_product, $d_product), 
                             plus($a_sum, $d_sum));
                    });
            }));
}

function the_last_friend
(array $new_l, int $product, int $sum) : array
{return
    cons($sum, cons($product, $new_l));
}

/*
foreach (get_defined_functions()['user'] as $func_name) {
    
    $$func_name = $func_name;
}
 */
