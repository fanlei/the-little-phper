<?php

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src');

require 'chapter_3.php';

use PHPUnit\Framework\TestCase;

class Chapter3Test extends TestCase {

    public function test_rember() {

        $this->assertSame([], rember('a', []));
        $this->assertSame(['lamb', 'chops', 'and', 'jelly'], 
           rember('mint', ['lamb', 'chops', 'and', 'mint', 'jelly']));
        $this->assertSame(['lamb', 'chops', 'and', 'flavored', 'mint', 'jelly'], 
           rember('mint', ['lamb', 'chops', 'and', 'mint', 'flavored', 'mint',  'jelly']));
        $this->assertSame(['bacon', 'lettuce', 'and', 'tomato'], 
          rember('toast', ['bacon', 'lettuce', 'and', 'tomato']));
        $this->assertSame(['coffee', 'tea', 'cup', 'and', 'hick', 'cup'], 
            rember('cup', ['coffee', 'cup', 'tea', 'cup', 'and', 'hick', 'cup']));
        $this->assertSame(['bacon', 'lettuce', 'tomato'], 
          rember('and', ['bacon', 'lettuce', 'and', 'tomato']));
        $this->assertSame(['soy', 'and', 'tomato', 'sauce'], 
          rember('sauce', ['soy', 'sauce', 'and', 'tomato', 'sauce']));
    }

    public function test_firsts() {
        
        $this->assertSame(['apple', 'plum', 'grape', 'bean'],
                firsts([['apple', 'peach', 'pumpkin'], 
                        ['plum', 'pear', 'cherry'], 
                        ['grape', 'raisin', 'pea'], 
                        ['bean', 'carrot', 'eggplant']]));
        $this->assertSame(['a', 'c', 'e'], 
                firsts([['a', 'b'], ['c', 'd'], ['e', 'f']]));
        $this->assertSame([], firsts([]));
        $this->assertSame(['five', 'four', 'eleven'], 
                firsts([['five', 'plums'], 
                        ['four'], 
                        ['eleven', 'green', 'oranges']]));
        $this->assertSame([['five', 'plums'], 'eleven', ['no']],
                firsts([[['five', 'plums'], 'four'], 
                        ['eleven', 'green', 'oranges'], 
                        [['no'], 'more']]));
    }

    public function test_insert_right() {

        $this->assertSame(['ice', 'cream', 'with', 'fudge', 'topping', 'for', 'dessert'], 
                insert_right('topping', 'fudge',
                        ['ice', 'cream', 'with', 'fudge', 'for', 'dessert']));
        $this->assertSame(['tacos', 'tamales', 'and', 'jalapeno', 'salsa'],
                insert_right('jalapeno', 'and',
                        ['tacos', 'tamales', 'and', 'salsa']));
        $this->assertSame(['a', 'b', 'c', 'd', 'e', 'f', 'g', 'd', 'h'],
                insert_right('e', 'd',
                          ['a', 'b', 'c', 'd', 'f', 'g', 'd', 'h']));
        $this->assertSame([], insert_right('a', 'b', []));
    }

    public function test_insert_left() {

        $this->assertSame(['ice', 'cream', 'with', 'topping', 'fudge', 'for', 'dessert'], 
                insert_left('topping', 'fudge',
                        ['ice', 'cream', 'with', 'fudge', 'for', 'dessert']));
        $this->assertSame(['tacos', 'tamales', 'jalapeno', 'and', 'salsa'],
                insert_left('jalapeno', 'and',
                        ['tacos', 'tamales', 'and', 'salsa']));
        $this->assertSame(['a', 'b', 'c', 'e', 'd', 'f', 'g', 'd', 'h'],
                insert_left('e', 'd',
                          ['a', 'b', 'c', 'd', 'f', 'g', 'd', 'h']));
        $this->assertSame([], insert_left('a', 'b', []));
    }

    public function test_subst() {

        $this->assertSame(['ice', 'cream', 'with', 'topping', 'for', 'dessert'], 
                subst('topping', 'fudge', 
                        ['ice', 'cream', 'with', 'fudge', 'for', 'dessert']));
        $this->assertSame(['tacos', 'tamales', 'jalapeno', 'salsa'],
                subst('jalapeno', 'and',
                        ['tacos', 'tamales', 'and', 'salsa']));
        $this->assertSame(['a', 'b', 'c', 'e', 'f', 'g', 'd', 'h'],
                subst('e', 'd', ['a', 'b', 'c', 'd', 'f', 'g', 'd', 'h']));
        $this->assertSame([], subst('a', 'b', []));
    }

    public function test_subst2() {
    
        $this->assertSame(['vanilla', 'ice', 'cream', 'with', 'chocolate', 'topping'],
                subst2('vanilla', 'chocolate', 'banana',
                    ['banana', 'ice', 'cream', 'with', 'chocolate', 'topping']));
        $this->assertSame([], subst2('a', 'b', 'c', []));
    }

    public function test_multirember() {

        $this->assertSame([], multirember('a', []));
        $this->assertSame(['lamb', 'chops', 'and', 'jelly'], 
                multirember('mint',
                          ['lamb', 'chops', 'and', 'mint', 'jelly']));
        $this->assertSame(['lamb', 'chops', 'and', 'flavored', 'jelly'], 
                multirember('mint',
                          ['lamb', 'chops', 'and', 'mint', 'flavored', 'mint',  'jelly']));
        $this->assertSame(['bacon', 'lettuce', 'and', 'tomato'], 
                multirember('toast',
                          ['bacon', 'lettuce', 'and', 'tomato']));
        $this->assertSame(['coffee', 'tea', 'and', 'hick'], 
                multirember('cup',
                          ['coffee', 'cup', 'tea', 'cup', 'and', 'hick', 'cup']));
        $this->assertSame(['bacon', 'lettuce', 'tomato'], 
                multirember('and',
                          ['bacon', 'lettuce', 'and', 'tomato']));
        $this->assertSame(['soy', 'and', 'tomato'], 
                multirember('sauce',
                          ['soy', 'sauce', 'and', 'tomato', 'sauce']));
    }

    public function test_multiinsert_right() {
    
        $this->assertSame(['ice', 'cream', 'with', 'fudge', 'topping', 'for', 'dessert'], 
                multiinsert_right('topping', 'fudge',
                          ['ice', 'cream', 'with', 'fudge', 'for', 'dessert']));
        $this->assertSame(['tacos', 'tamales', 'and', 'jalapeno', 'salsa'],
                multiinsert_right('jalapeno', 'and',
                          ['tacos', 'tamales', 'and', 'salsa']));
        $this->assertSame(['a', 'b', 'c', 'd', 'e', 'f', 'g', 'd', 'e', 'h'],
                multiinsert_right('e', 'd',
                          ['a', 'b', 'c', 'd', 'f', 'g', 'd', 'h']));
        $this->assertSame([], multiinsert_right('a', 'b', []));
    }

    public function test_multiinsert_left() {

        $this->assertSame(['ice', 'cream', 'with', 'topping', 'fudge', 'for', 'dessert'], 
                multiinsert_left('topping', 'fudge',
                          ['ice', 'cream', 'with', 'fudge', 'for', 'dessert']));
        $this->assertSame(['tacos', 'tamales', 'jalapeno', 'and', 'salsa'],
                multiinsert_left('jalapeno', 'and',
                          ['tacos', 'tamales', 'and', 'salsa']));
        $this->assertSame(['a', 'b', 'c', 'e', 'd', 'f', 'g', 'e', 'd', 'h'],
                multiinsert_left('e', 'd',
                          ['a', 'b', 'c', 'd', 'f', 'g', 'd', 'h']));
        $this->assertSame([], insert_left('a', 'b', []));
    }

    public function test_multisubst() {
    
        $this->assertSame(['ice', 'cream', 'with', 'topping', 'for', 'dessert'], 
                multisubst('topping', 'fudge', 
                          ['ice', 'cream', 'with', 'fudge', 'for', 'dessert']));
        $this->assertSame(['tacos', 'tamales', 'jalapeno', 'salsa'],
                multisubst('jalapeno', 'and',
                          ['tacos', 'tamales', 'and', 'salsa']));
        $this->assertSame(['a', 'b', 'c', 'e', 'f', 'g', 'e', 'h'],
                multisubst('e', 'd',
                          ['a', 'b', 'c', 'd', 'f', 'g', 'd', 'h']));
        $this->assertSame([], multisubst('a', 'b', []));
    }

} // class Chapter3Test END
