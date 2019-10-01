<?php declare(strict_types=1);

/* Chapter 10 */

function lookup_in_entry_help
($name, array $names, array $values, callable $entry_f) 
{return
    is_nulll($names) ? $entry_f($name)
    : (is_eq(car($names), $name) ? car($values)
      : lookup_in_entry_help($name, cdr($names), cdr($values), $entry_f));
}

function first
(array $l)
{return
    car($l);
}

function lookup_in_entry
($name, array $entry, callable $entry_f) 
{return 
    lookup_in_entry_help($name, first($entry), second($entry), $entry_f);
}

function lookup_in_table
($name, array $table, callable $table_f)
{return
    is_nulll($table) ? $table_f($name)
    : lookup_in_entry($name, car($table), 
                      function ($name) use ($table, $table_f)
                      {return 
                          lookup_in_table($name, cdr($table), $table_f);
                      });
}

function atom_to_action
($e) : callable
{return
    is_number($e)
    // is_member($e, ['$t', '#f', 'cons', 'car', 'cdr', 'null?', 'eq?', 'atom?', 'zero?', 'add1?', 'sub1?', 'number?'])
    ||  is_eq($e, '#t')
    ||  is_eq($e, '#f')
    ||  is_eq($e, 'cons')
    ||  is_eq($e, 'car')
    ||  is_eq($e, 'cdr')
    ||  is_eq($e, 'null?')
    ||  is_eq($e, 'eq?')
    ||  is_eq($e, 'atom?')
    ||  is_eq($e, 'zero?')
    ||  is_eq($e, 'add1?')
    ||  is_eq($e, 'sub1?')
    ||  is_eq($e, 'number?') ? 
      '_const'
    : '_identifier';
}

function list_to_aciton 
(array $e) : callable
{return
    is_atom(car($e)) ? 
        is_eq(car($e), 'quote') ? '_quote'
        : (is_eq(car($e), 'lambda') ? '_lambda' 
          : (is_eq(car($e), 'cond') ? '_cond'
            : '_application'))
    : '_application';
}

function expression_to_action
($e) : callable
{return
    is_atom($e) ? atom_to_action($e)
    : list_to_aciton($e);
}

// eval
function _value
($e)
{return
    meaning($e, []);
}

function meaning
($e, array $table)
{return
    expression_to_action($e)($e, $table);
}

function _const
($e, array $table)
{return
    is_number($e) ? $e
    : (is_eq($e, '#t') ? TRUE
      : (is_eq($e, '#f') ? FALSE
        : build('primitive', $e)));
}

use function second as text_of;

function _quote
(array $e, array $table)
{return
    text_of($e);
}

function initial_table
($name)
{return
    car([]);
}

function _identifier
($e, array $table)
{return
    lookup_in_table($e, $table, 'initial_table');
}

function _lambda
(array $e, array $table)
{return
    build('non-primitive', cons($table, cdr($e)));
}

function is_else
($x)
{return
    is_atom($x) && is_eq($x, 'else');
}

use function first as question_of;

use function second as answer_of;

function evcon
(array $lines, array $table)
{return
    is_else(question_of(car($lines))) ? 
      meaning(answer_of(car($lines)), $table)
    : (meaning(question_of(car($lines)), $table) ?
        meaning(answer_of(car($lines)), $table)
      : evcon(cdr($lines), $table));
}

use function cdr as cond_lines_of;

function _cond
(array $e, array $table)
{return
    evcon(cond_lines_of($e), $table);
}

function evlis
(array $args, array $table) : array
{return
    is_nulll($args) ? []
    : cons(meaning(car($args), $table), evlis(cdr($args), $table));
}

function is_primitive
(array $l) : bool
{return
    is_eq(first($l), 'primitive');
}

function is_non_primitive
(array $l) : bool
{return
    is_eq(first($l), 'non-primitive');
}

function _is_atom
($s) : bool
{return
    is_atom($s) ? TRUE
    : (is_nulll($s) ? FALSE
      : (is_eq(car($s), 'primitive') ? TRUE
        : (is_eq(car($s), 'non-primitive') ? TRUE
          : FALSE)));
}

// could check for cdr to the empty list, or sub1 to 0, etc. 
function apply_primitive
($name, array $vals)
{return
    is_eq($name, 'car') ? car(first($vals))
    : (is_eq($name, 'cdr') ? cdr(first($vals))
      : (is_eq($name, 'cons') ? cons(first($vals), second($vals))
        : (is_eq($name, 'null?') ? is_nulll(first($vals))
          : (is_eq($name, 'atom?') ? _is_atom(first($vals))
            : (is_eq($name, 'eq?') ? is_eq(first($vals), second($vals))
              : (is_eq($name, 'zero?') ? is_zero(first($vals))
                : (is_eq($name, 'add1') ? add1(first($vals))
                  : (is_eq($name, 'sub1') ? sub1(first($vals))
                    : (is_eq($name, 'number?') ? is_number(first($vals))
                      : $name))))))))); // no answer
}

use function build as new_entry;

use function first as table_of;

use function second as formals_of;

use function third as body_of;

use function cons as extend_table;

function apply_closure
($closure, $vals)
{return
    meaning(body_of($closure),
            extend_table(new_entry(formals_of($closure), $vals),
                         table_of($closure)));
}

function apply
(array $fun, array $vals)
{return
    is_primitive($fun) ? apply_primitive(second($fun), $vals)
    : (is_non_primitive($fun) ? apply_closure(second($fun), $vals)
      : $fun);  // no answer
}

use function car as function_of;

use function cdr as arguments_of;

function _application
(array $e, array $table)
{return
    apply(meaning(function_of($e), $table),
          evlis(arguments_of($e), $table));
}
