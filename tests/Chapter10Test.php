<?php

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src');

require 'chapter_10.php';

use PHPUnit\Framework\TestCase;

class Chapter10Test extends TestCase {

    public function test_lookup_in_entry() {

        $this->assertSame('tastes', 
                lookup_in_entry('entree', 
                    [['appetizer', 'entree', 'beverage'], 
                     ['food', 'tastes', 'good']], 'is_atom'));
        $this->assertSame(20, 
                lookup_in_entry(2, [[1, 2], [10, 20]], 'is_atom'));
    }

    public function test_lookup_in_table() {

        $this->assertSame('spaghetti', 
                lookup_in_table('entree',
                [[['entree', 'dessert'], 
                  ['spaghetti', 'spumoni']],
                 [['appetizer', 'entree', 'beverage'], 
                  ['food', 'tastes', 'good']]], 'is_atom'));
    }

    public function test__const() {
        
        $this->assertSame(0, _const(0, []));
        $this->assertSame(1, _const(1, []));
        $this->assertTrue(_const('#t', []));
        $this->assertFalse(_const('#f', []));
        $this->assertSame(['primitive', 'car'], _const('car', []));
        $this->assertSame(['primitive', 'cdr'], _const('cdr', []));
        $this->assertSame(['primitive', 'cons'], _const('cons', []));
        $this->assertSame(['primitive', 'null?'], _const('null?', []));
        $this->assertSame(['primitive', 'eq?'], _const('eq?', []));
        $this->assertSame(['primitive', 'atom?'], _const('atom?', []));
        $this->assertSame(['primitive', 'zero?'], _const('zero?', []));
        $this->assertSame(['primitive', 'number?'], _const('number?', []));
        $this->assertSame(['primitive', 'add1'], _const('add1', []));
        $this->assertSame(['primitive', 'sub1'], _const('sub1', []));
    }

    public function test__quote() {
    
        $this->assertSame(1, _quote(['quote', 1], []));
    }

    public function test_initial_table() {
        
        $this->assertNull(initial_table('Hope never been used'));
    }

    public function test__identifier() {
    
        $this->assertSame(3, 
                _identifier('c',
                [[['a', 'b'], 
                  [1, 2]],
                 [['c', 'd', 'e'], 
                  [3, 4, 5]]]));
    }

    public function test__lambda() {
    
        $this->assertSame(['non-primitive', [[], ['x'], 'x']],
                              _lambda(['lambda', ['x'], 'x'], []));
        $this->assertSame(['non-primitive', 
                           [[[['y', 'z'], [[8], 9]]],
                            ['x'], ['cons', 'x', 'y']]],
         _lambda(['lambda', ['x'], ['cons', 'x', 'y']], 
                            [[['y', 'z'], [[8], 9]]]));
    }

    public function test_is_else() {
    
        $this->assertTrue(is_else('else'));
        $this->assertFalse(is_else([]));
        $this->assertFalse(is_else('cond'));
    }

    public function test__cond() {

        $this->assertSame(5, 
            _cond(['cond', ['coffee', 'klatsch'], ['else', 'party']], 
                    [[['coffee'], [TRUE]],
                     [['klatsch', 'party'], [5, ['6']]]]));
        $this->assertSame([6], 
            _cond(['cond', ['coffee', 'klatsch'], ['else', 'party']], 
                    [[['coffee'], [FALSE]],
                     [['klatsch', 'party'], [5, [6]]]]));
    }

    public function test_apply_closure() {
    
        $this->assertSame([6, 'a', 'b', 'c'],
            apply_closure([[[['u', 'v', 'w'],
                             [1, 2, 3]],
                            [['x', 'y', 'z'],
                             [4, 5, 6]]],
                           ['x', 'y'],
                           ['cons', 'z', 'x']],
                        [['a', 'b', 'c'], ['d', 'e', 'f']]));
    }

    public function test__value() {
        
        $this->assertSame(1, _value(['quote', 1]));
        $this->assertSame('1', _value(['quote', '1']));
        $this->assertSame(0, _value(['quote', 0]));
        $this->assertSame('a', _value(['quote', 'a']));

        $this->assertTrue(_value(['eq?', 1, 1]));
        $this->assertTrue(_value(['eq?', ['quote', 1], ['quote', 1]]));
        $this->assertTrue(_value(['eq?', '#t', '#t']));
        $this->assertTrue(_value(['eq?', '#f', '#f']));
        $this->assertFalse(_value(['eq?', 1, '1']));
        $this->assertFalse(_value(['eq?', 1, 0]));
        $this->assertFalse(_value(['eq?', '#t', '#f']));
        $this->assertFalse(_value(['eq?', ['quote', 'x'], ['quote', 'y']]));
        $this->assertFalse(_value(['eq?', '1', ['quote', 1]]));

        $this->assertSame(1, _value(['car', ['quote', [1, 2]]]));

        $this->assertSame(1, _value([['lambda', ['x', 'y'], 'x'], 1]));
        $this->assertSame([1], _value([['lambda', ['x', 'y'], 'x'], ['quote', [1]]]));
        $this->assertSame([0, 1], _value([['lambda', ['x', 'y'], ['cons', 'x', 'y']], 0, ['quote', [1]]]));

        $this->assertSame([0, 1], _value([['lambda', ['x', 'y'], ['cons', 'x', 'y']], 0, ['quote', [1]]]));

    }
    //((lambda (x y) (cons x y)) 0 (quote (1)))
    
} // class Chapter10Test END
