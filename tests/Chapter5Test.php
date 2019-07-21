<?php

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src');

require 'chapter_5.php';

use PHPUnit\Framework\TestCase;

class Chapter5Test extends TestCase {

    public function test_rember_star() {

        $this->assertSame([], rember_star('a', []));
        $this->assertSame([['coffee'], 
                           [['tea']], 
                           ['and', ['hick']]],
                rember_star('cup', 
                            [['coffee'],
                             'cup',
                             [['tea'], 'cup'],
                             ['and', ['hick']],
                             'cup']));
        $this->assertSame([[['tomato']],
                           [['bean']],
                           ['and', [['flying']]]],
                rember_star('sauce', 
                            [[['tomato', 'sauce']],
                             [['bean'], 'sauce'],
                             ['and', [['flying']], 'sauce']]));
    }

    public function test_occur_star() {

        $this->assertSame(0, occur_star('a', []));
        $this->assertSame(0, occur_star('a', ['b']));

        $this->assertSame(3,
                occur_star('cup', 
                            [['coffee'],
                             'cup',
                             [['tea'], 'cup'],
                             ['and', ['hick']],
                             'cup']));

        $this->assertSame(3,
                occur_star('sauce', 
                            [[['tomato', 'sauce']],
                             [['bean'], 'sauce'],
                             ['and', [['flying']], 'sauce']]));
    }

    public function test_insert_right_star() {

        $this->assertSame(['a', 'b'], insert_right_star('b', 'a', ['a']));

        $this->assertSame([['banana', 'orange'],
                           ['split', [[[['banana', 'orange', 'ice']]],
                                     ['cream', ['banana', 'orange']],
                                     'sherbet']],
                           ['banana', 'orange'],
                           ['bread'],
                           ['banana', 'orange', 'brandy']],
                insert_right_star('orange', 'banana',
                                [['banana'],
                                 ['split', [[[['banana', 'ice']]],
                                           ['cream', ['banana']],
                                           'sherbet']],
                                 ['banana'],
                                 ['bread'],
                                 ['banana', 'brandy']]));

        $this->assertSame([['how', 'much', ['wood']],
                           'could',
                           [['a', ['wood'], 'chuck', 'pecker']],
                           [[['chuck', 'pecker']]],
                           ['if', ['a'], [['wood', 'chuck', 'pecker']]],
                           'could', 'chuck', 'pecker', 'wood'],
                insert_right_star('pecker', 'chuck',
                                [['how', 'much', ['wood']],
                                 'could',
                                 [['a', ['wood'], 'chuck']],
                                 [[['chuck']]],
                                 ['if', ['a'], [['wood', 'chuck']]],
                                 'could', 'chuck', 'wood']));
    }

    public function test_insert_left_star() {

        $this->assertSame(['b', 'a'], insert_left_star('b', 'a', ['a']));

        $this->assertSame([['orange', 'banana'],
                           ['split', [[[['orange', 'banana', 'ice']]],
                                     ['cream', ['orange', 'banana']],
                                     'sherbet']],
                           ['orange', 'banana'],
                           ['bread'],
                           ['orange', 'banana', 'brandy']],
                insert_left_star('orange', 'banana',
                                [['banana'],
                                 ['split', [[[['banana', 'ice']]],
                                           ['cream', ['banana']],
                                           'sherbet']],
                                 ['banana'],
                                 ['bread'],
                                 ['banana', 'brandy']]));

        $this->assertSame([['how', 'much', ['wood']],
                           'could',
                           [['a', ['wood'], 'pecker', 'chuck']],
                           [[['pecker', 'chuck']]],
                           ['if', ['a'], [['wood', 'pecker', 'chuck']]],
                           'could', 'pecker', 'chuck', 'wood'],
                insert_left_star('pecker', 'chuck',
                                [['how', 'much', ['wood']],
                                 'could',
                                 [['a', ['wood'], 'chuck']],
                                 [[['chuck']]],
                                 ['if', ['a'], [['wood', 'chuck']]],
                                 'could', 'chuck', 'wood']));
    }

    public function test_subst_star() {

        $this->assertSame(['b'], subst_star('b', 'a', ['a']));

        $this->assertSame([['orange'],
                           ['split', [[[['orange', 'ice']]],
                                     ['cream', ['orange']],
                                     'sherbet']],
                           ['orange'],
                           ['bread'],
                           ['orange', 'brandy']],
                subst_star('orange', 'banana',
                            [['banana'],
                             ['split', [[[['banana', 'ice']]],
                                       ['cream', ['banana']],
                                       'sherbet']],
                             ['banana'],
                             ['bread'],
                             ['banana', 'brandy']]));

        $this->assertSame([['how', 'much', ['wood']],
                           'could',
                           [['a', ['wood'], 'pecker']],
                           [[['pecker']]],
                           ['if', ['a'], [['wood', 'pecker']]],
                           'could', 'pecker', 'wood'],
                subst_star('pecker', 'chuck',
                            [['how', 'much', ['wood']],
                             'could',
                             [['a', ['wood'], 'chuck']],
                             [[['chuck']]],
                             ['if', ['a'], [['wood', 'chuck']]],
                             'could', 'chuck', 'wood']));
    }

    public function test_member_star() {
        
        $this->assertTrue(member_star('chips', 
                [['potato'], ['chips', [['with'], 'fish'], ['chips']]]));
        $this->assertTrue(member_star('a', [[['a']]]));

        $this->assertFalse(member_star('a', []));
    }

    public function test_leftmost() {

        $this->assertSame('potato', 
            leftmost([['potato'], ['chips', [['with'], 'fish'], ['chips']]]));
        $this->assertSame('hot', 
            leftmost([[['hot'], ['tuna', ['and']]], 'cheese']));
        $this->assertSame('a', leftmost(['a', 'b']));

        $this->assertNull(leftmost([[[[], 'four']], 17]));
        $this->assertNull(leftmost([]));
    }

    public function test_is_eqlist() {
    
        $this->assertTrue(is_eqlist([], []));
        $this->assertTrue(is_eqlist(['strawberry', 'ice', 'cream'],
                                    ['strawberry', 'ice', 'cream']));
        $this->assertTrue(is_eqlist(['banana', [['split']]],
                                    ['banana', [['split']]]));
        $this->assertTrue(is_eqlist(['beef', [['sausage']], ['and', ['soda']]],
                                    ['beef', [['sausage']], ['and', ['soda']]]));

        $this->assertFalse(is_eqlist(['strawberry', 'ice', 'cream'],
                                     ['strawberry', 'cream', 'ice']));
        $this->assertFalse(is_eqlist(['banana', [['split']]],
                                     ['banana', ['split']]));
        $this->assertFalse(is_eqlist(['beef', [['sausage']], ['and', ['soda']]],
                                     ['beef', [['salami']], ['and', ['soda']]]));
    
    }

    public function test_is_equal() {
    
        $this->assertTrue(is_equal('Harry', 'Harry'));
        $this->assertTrue(is_equal(0, 0));
        $this->assertTrue(is_equal([], []));
        $this->assertTrue(is_equal(['a'], ['a']));
        $this->assertTrue(is_equal(car(['Mary', 'had', 'a', 'little', 'lamb', 'chop']), 'Mary'));
        $l = ['beans', 'beans', 'we', 'need', 'jelly', 'beans'];
        $this->assertTrue(is_equal(car($l), car(cdr($l))));

        $this->assertFalse(is_equal('margarine', 'butter'));
        $this->assertFalse(is_equal([], ['strawberry']));
        $this->assertFalse(is_equal(6, 7));
        $this->assertFalse(is_equal(cdr(['soured', 'milk']), 'milk'));

        $this->assertTrue(is_equal([], []));
        $this->assertTrue(is_equal(['strawberry', 'ice', 'cream'],
                                   ['strawberry', 'ice', 'cream']));
        $this->assertTrue(is_equal(['banana', [['split']]],
                                   ['banana', [['split']]]));
        $this->assertTrue(is_equal(['beef', [['sausage']], ['and', ['soda']]],
                                   ['beef', [['sausage']], ['and', ['soda']]]));

        $this->assertFalse(is_equal(['strawberry', 'ice', 'cream'],
                                    ['strawberry', 'cream', 'ice']));
        $this->assertFalse(is_equal(['banana', [['split']]],
                                    ['banana', ['split']]));
        $this->assertFalse(is_equal(['beef', [['sausage']], ['and', ['soda']]],
                                    ['beef', [['salami']], ['and', ['soda']]]));
    }

    public function test_rember2() {

        $this->assertSame([], rember2('a', []));
        $this->assertSame(['lamb', 'chops', 'and', 'jelly'], 
          rember2('mint', ['lamb', 'chops', 'and', 'mint', 'jelly']));
        $this->assertSame(['lamb', 'chops', 'and', 'flavored', 'mint', 'jelly'], 
          rember2('mint', ['lamb', 'chops', 'and', 'mint', 'flavored', 'mint',  'jelly']));
        $this->assertSame(['bacon', 'lettuce', 'and', 'tomato'], 
         rember2('toast', ['bacon', 'lettuce', 'and', 'tomato']));
        $this->assertSame(['coffee', 'tea', 'cup', 'and', 'hick', 'cup'], 
           rember2('cup', ['coffee', 'cup', 'tea', 'cup', 'and', 'hick', 'cup']));
        $this->assertSame(['bacon', 'lettuce', 'tomato'], 
           rember2('and', ['bacon', 'lettuce', 'and', 'tomato']));
        $this->assertSame(['soy', 'and', 'tomato', 'sauce'], 
         rember2('sauce', ['soy', 'sauce', 'and', 'tomato', 'sauce']));
    }

} // class Chapter5Test END
