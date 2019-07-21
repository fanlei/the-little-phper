<?php

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src');

require 'chapter_8.php';

use PHPUnit\Framework\TestCase;

class Chapter8Test extends TestCase {

    public function test_rember_f() {

        //$is_eqn = 'is_eqn';

        $this->assertSame([6, 2, 3], rember_f('is_eqn')(5, [6, 2, 5, 3]));

        //$is_eq = 'is_eq';

        $this->assertSame(['beans', 'are', 'good'], 
            rember_f('is_eq')('jelly', ['jelly', 'beans', 'are', 'good']));

        $this->assertSame([], rember_f('is_eq')('a', []));
        $this->assertSame(['lamb', 'chops', 'and', 'jelly'], 
            rember_f('is_eq')('mint', ['lamb', 'chops', 'and', 'mint', 'jelly']));
        $this->assertSame(['lamb', 'chops', 'and', 'flavored', 'mint', 'jelly'], 
            rember_f('is_eq')('mint', ['lamb', 'chops', 'and', 'mint', 'flavored', 'mint',  'jelly']));
        $this->assertSame(['bacon', 'lettuce', 'and', 'tomato'], 
            rember_f('is_eq')('toast', ['bacon', 'lettuce', 'and', 'tomato']));
        $this->assertSame(['coffee', 'tea', 'cup', 'and', 'hick', 'cup'], 
            rember_f('is_eq')('cup', ['coffee', 'cup', 'tea', 'cup', 'and', 'hick', 'cup']));
        $this->assertSame(['bacon', 'lettuce', 'tomato'], 
            rember_f('is_eq')('and', ['bacon', 'lettuce', 'and', 'tomato']));
        $this->assertSame(['soy', 'and', 'tomato', 'sauce'], 
            rember_f('is_eq')('sauce', ['soy', 'sauce', 'and', 'tomato', 'sauce']));

        $this->assertSame(['shrimp', 'salad', 'and', 'salad'], 
            rember_f('is_eq')('tuna', ['shrimp', 'salad', 'and', 'tuna', 'salad']));
        $this->assertSame(['equal?', 'eqan?', 'eqlist?', 'eqpair?'], 
            rember_f('is_eq')('eq?', ['equal?', 'eq?', 'eqan?', 'eqlist?', 'eqpair?']));

        //$is_equal = 'is_equal';

        $this->assertSame(['lemonade', 'and', ['cake']], 
          rember_f('is_equal')(['pop', 'corn'], ['lemonade', ['pop', 'corn'], 'and', ['cake']]));

        $rember_is_eq = rember_f('is_eq');

        $this->assertSame(['salad', 'is', 'good'], 
            $rember_is_eq('tuna', ['tuna', 'salad', 'is', 'good']));
    } // test_rember_f()

    public function test_is_eq_c() {

        $is_eq_salad = is_eq_c('salad');

        $this->assertTrue($is_eq_salad('salad'));

        $this->assertFalse($is_eq_salad('tuna'));
    }

    public function test_insert_left_f() {
    
        //$is_eq = 'is_eq';

        $this->assertSame(['ice', 'cream', 'with', 'topping', 'fudge', 'for', 'dessert'], 
                insert_left_f('is_eq')('topping', 'fudge',
                        ['ice', 'cream', 'with', 'fudge', 'for', 'dessert']));
        $this->assertSame(['tacos', 'tamales', 'jalapeno', 'and', 'salsa'],
                insert_left_f('is_eq')('jalapeno', 'and',
                        ['tacos', 'tamales', 'and', 'salsa']));
        $this->assertSame(['a', 'b', 'c', 'e', 'd', 'f', 'g', 'd', 'h'],
                insert_left_f('is_eq')('e', 'd',
                          ['a', 'b', 'c', 'd', 'f', 'g', 'd', 'h']));
        $this->assertSame([], insert_left_f('is_eq')('a', 'b', []));
    }

    public function test_insert_right_f() {

        //$is_eq = 'is_eq';

        $this->assertSame(['ice', 'cream', 'with', 'fudge', 'topping', 'for', 'dessert'], 
                insert_right_f('is_eq')('topping', 'fudge',
                        ['ice', 'cream', 'with', 'fudge', 'for', 'dessert']));
        $this->assertSame(['tacos', 'tamales', 'and', 'jalapeno', 'salsa'],
                insert_right_f('is_eq')('jalapeno', 'and',
                        ['tacos', 'tamales', 'and', 'salsa']));
        $this->assertSame(['a', 'b', 'c', 'd', 'e', 'f', 'g', 'd', 'h'],
                insert_right_f('is_eq')('e', 'd',
                          ['a', 'b', 'c', 'd', 'f', 'g', 'd', 'h']));
        $this->assertSame([], insert_right_f('is_eq')('a', 'b', []));
    }

    public function test_insert_g() {
    
        $insert_left = insert_g('seq_l');

        $this->assertSame(['ice', 'cream', 'with', 'topping', 'fudge', 'for', 'dessert'], 
                $insert_left('topping', 'fudge',
                        ['ice', 'cream', 'with', 'fudge', 'for', 'dessert']));
        $this->assertSame(['tacos', 'tamales', 'jalapeno', 'and', 'salsa'],
                $insert_left('jalapeno', 'and',
                        ['tacos', 'tamales', 'and', 'salsa']));
        $this->assertSame(['a', 'b', 'c', 'e', 'd', 'f', 'g', 'd', 'h'],
                $insert_left('e', 'd',
                          ['a', 'b', 'c', 'd', 'f', 'g', 'd', 'h']));
        $this->assertSame([], $insert_left('a', 'b', []));

        $insert_right = insert_g('seq_r');

        $this->assertSame(['ice', 'cream', 'with', 'fudge', 'topping', 'for', 'dessert'], 
                $insert_right('topping', 'fudge',
                        ['ice', 'cream', 'with', 'fudge', 'for', 'dessert']));
        $this->assertSame(['tacos', 'tamales', 'and', 'jalapeno', 'salsa'],
                $insert_right('jalapeno', 'and',
                        ['tacos', 'tamales', 'and', 'salsa']));
        $this->assertSame(['a', 'b', 'c', 'd', 'e', 'f', 'g', 'd', 'h'],
                $insert_right('e', 'd',
                          ['a', 'b', 'c', 'd', 'f', 'g', 'd', 'h']));
        $this->assertSame([], $insert_right('a', 'b', []));

        $subst = insert_g('seq_s');

        $this->assertSame(['ice', 'cream', 'with', 'topping', 'for', 'dessert'], 
                $subst('topping', 'fudge', 
                        ['ice', 'cream', 'with', 'fudge', 'for', 'dessert']));
        $this->assertSame(['tacos', 'tamales', 'jalapeno', 'salsa'],
                $subst('jalapeno', 'and',
                        ['tacos', 'tamales', 'and', 'salsa']));
        $this->assertSame(['a', 'b', 'c', 'e', 'f', 'g', 'd', 'h'],
                $subst('e', 'd', ['a', 'b', 'c', 'd', 'f', 'g', 'd', 'h']));
        $this->assertSame([], $subst('a', 'b', []));

        $rember = insert_g('seqrem');

        $this->assertSame([], $rember(FALSE, 'a', []));
        $this->assertSame(['lamb', 'chops', 'and', 'jelly'], 
            $rember(FALSE, 'mint',
                          ['lamb', 'chops', 'and', 'mint', 'jelly']));
        $this->assertSame(['lamb', 'chops', 'and', 'flavored', 'mint', 'jelly'], 
            $rember(FALSE, 'mint',
                          ['lamb', 'chops', 'and', 'mint', 'flavored', 'mint',  'jelly']));
        $this->assertSame(['bacon', 'lettuce', 'and', 'tomato'], 
            $rember(FALSE, 'toast',
                          ['bacon', 'lettuce', 'and', 'tomato']));
        $this->assertSame(['coffee', 'tea', 'cup', 'and', 'hick', 'cup'], 
            $rember(FALSE, 'cup',
                          ['coffee', 'cup', 'tea', 'cup', 'and', 'hick', 'cup']));
        $this->assertSame(['bacon', 'lettuce', 'tomato'], 
            $rember(FALSE, 'and',
                          ['bacon', 'lettuce', 'and', 'tomato']));
        $this->assertSame(['soy', 'and', 'tomato', 'sauce'], 
            $rember(FALSE, 'sauce',
                          ['soy', 'sauce', 'and', 'tomato', 'sauce']));

        $insert_left = insert_g(function ($new_s, $old_s, array $l) : array
                                {return 
                                    cons($new_s, cons($old_s, $l));
                                });

        $this->assertSame(['ice', 'cream', 'with', 'topping', 'fudge', 'for', 'dessert'], 
                $insert_left('topping', 'fudge',
                        ['ice', 'cream', 'with', 'fudge', 'for', 'dessert']));
        $this->assertSame(['tacos', 'tamales', 'jalapeno', 'and', 'salsa'],
                $insert_left('jalapeno', 'and',
                        ['tacos', 'tamales', 'and', 'salsa']));
        $this->assertSame(['a', 'b', 'c', 'e', 'd', 'f', 'g', 'd', 'h'],
                $insert_left('e', 'd',
                          ['a', 'b', 'c', 'd', 'f', 'g', 'd', 'h']));
        $this->assertSame([], $insert_left('a', 'b', []));
    } // test_insert_g()

    public function test_value() {
    
        // infix
        $this->assertSame(13, value(13));
        $this->assertSame(4, value([1, '+', 3]));
        $this->assertSame(82, value([1, '+', [3, '^', 4]]));
        
/*
        // prefix
        $this->assertSame(13, value(13));
        $this->assertSame(4, value(['+', 1, 3]));
        $this->assertSame(82, value(['+', 1, ['^', 3, 4]]));
*/
    }

    public function test_multirember_f() {
    
        $multirember_is_eq = multirember_f('is_eq');

        $this->assertSame([], $multirember_is_eq('a', []));
        $this->assertSame(['lamb', 'chops', 'and', 'jelly'], 
                $multirember_is_eq('mint',
                          ['lamb', 'chops', 'and', 'mint', 'jelly']));
        $this->assertSame(['lamb', 'chops', 'and', 'flavored', 'jelly'], 
                $multirember_is_eq('mint',
                          ['lamb', 'chops', 'and', 'mint', 'flavored', 'mint',  'jelly']));
        $this->assertSame(['bacon', 'lettuce', 'and', 'tomato'], 
                $multirember_is_eq('toast',
                          ['bacon', 'lettuce', 'and', 'tomato']));
        $this->assertSame(['coffee', 'tea', 'and', 'hick'], 
                $multirember_is_eq('cup',
                          ['coffee', 'cup', 'tea', 'cup', 'and', 'hick', 'cup']));
        $this->assertSame(['bacon', 'lettuce', 'tomato'], 
                $multirember_is_eq('and',
                          ['bacon', 'lettuce', 'and', 'tomato']));
        $this->assertSame(['soy', 'and', 'tomato'], 
                $multirember_is_eq('sauce',
                          ['soy', 'sauce', 'and', 'tomato', 'sauce']));
    }

    public function test_multirember_t() {
    
        $is_eq_tuna = is_eq_c('tuna');
        $this->assertSame(['shrimp', 'salad', 'salad', 'and'], 
            multirember_t($is_eq_tuna,
                          ['shrimp', 'salad', 'tuna', 'salad', 'and', 'tuna']));
        $this->assertSame(['shrimp', 'salad', 'salad', 'and'], 
            multirember_t($is_eq_tuna,
                          ['shrimp', 'salad', 'salad', 'and']));
        $this->assertSame([], multirember_t($is_eq_tuna, []));
    }

    public function test_multirember_co() {
    
        $this->assertTrue(multirember_co('tuna', [], 'a_friend'));
        $this->assertFalse(multirember_co('tuna', ['tuna'], 'a_friend'));
        $this->assertFalse(multirember_co('tuna', ['strawberries', 'tuna', 'and', 'swordfish'], 'a_friend'));


        $this->assertSame(3, multirember_co('tuna', ['strawberries', 'tuna', 'and', 'swordfish'], 'last_friend'));
        $this->assertSame(0, multirember_co(NULL, [], 'last_friend'));
        $this->assertSame(0, multirember_co([], [], 'last_friend'));
        $this->assertSame(1, multirember_co(3, [[]], 'last_friend'));
        $this->assertSame(0, multirember_co([], [[]], 'last_friend'));
        $this->assertSame(0, multirember_co(3, [], 'last_friend'));
        $this->assertSame(4, multirember_co(3, ['strawberries', 'tuna', 'and', 'swordfish'], 'last_friend'));
    }

    public function test_multiinsert_left_right_co() {
        
        $this->assertSame(11, multiinsert_left_right_co('salty', 'fish', 'chips', ['chips', 'and', 'fish', 'or', 'fish', 'and', 'chips'], 'length'));
        $this->assertSame(7, multiinsert_left_right_co('salty', 'a', 'b', ['chips', 'and', 'fish', 'or', 'fish', 'and', 'chips'], 'length'));
        $this->assertSame(9, multiinsert_left_right_co('salty', 'fish', 'b', ['chips', 'and', 'fish', 'or', 'fish', 'and', 'chips'], 'length'));
        $this->assertSame(9, multiinsert_left_right_co('salty', 3, 'chips', ['chips', 'and', 'fish', 'or', 'fish', 'and', 'chips'], 'length'));
        $this->assertSame(0, multiinsert_left_right_co('salty', 3, 'chips', [], 'length'));

        $this->assertTrue(multiinsert_left_right_co('salty', 'fish', 'chips', ['chips', 'and', 'fish', 'or', 'fish', 'and', 'chips'], 
        function ($new_l, $n_L, $n_R) : bool {return is_eqn($n_L, $n_R);}));
    }

    public function test_is_even() {
    
        $this->assertTrue(is_even(0));
        $this->assertTrue(is_even(2));

        $this->assertFalse(is_even(1));
        $this->assertFalse(is_even(3));
    }

    public function test_evens_only_star() {
    
        $this->assertSame([[2, 8], 10, [[], 6], 2], 
                evens_only_star([[9, 1, 2, 8,], 3, 10, [[9, 9], 7, 6], 2]));
        $this->assertSame([[], [[]]], evens_only_star([[1], 3, [[9, 9], 7], 1]));
        $this->assertSame([], evens_only_star([3, 1]));
        $this->assertSame([], evens_only_star([]));
        $this->assertSame([0], evens_only_star([0]));
    }

    public function test_evens_only_star_co() {

        $this->assertSame([38, 1920, [2, 8], 10, [[], 6], 2],
            evens_only_star_co([[9, 1, 2, 8], 3, 10, [[9, 9], 7, 6], 2], 'the_last_friend'));
        $this->assertSame([0, 1], evens_only_star_co([], 'the_last_friend'));
        $this->assertSame([0, 0, 0], evens_only_star_co([0], 'the_last_friend'));
        $this->assertSame([8, 1], evens_only_star_co([3, 5], 'the_last_friend'));
        $this->assertSame([0, 8, 2, 2, 2], evens_only_star_co([2, 2, 2], 'the_last_friend'));
        $this->assertSame([30, 1, [], [[]]], evens_only_star_co([[1], 3, [[9, 9], 7], 1], 'the_last_friend'));
        $this->assertSame([30, 2, [2], [[]]], evens_only_star_co([[1, 2], 3, [[9, 9], 7], 1], 'the_last_friend'));
    }

} // class Chapter8Test END
