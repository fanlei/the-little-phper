<?php

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src');

require 'chapter_4.php';

use PHPUnit\Framework\TestCase;

class Chapter4Test extends TestCase {

    public function test_add1() {

        $this->assertSame(1, add1(0));
        $this->assertSame(68, add1(67));
    }

    public function test_sub1() {

        $this->assertSame(0, sub1(1));
        $this->assertSame(-1, sub1(0));
        $this->assertSame(4, sub1(5));
    }

    public function test_is_zero() {
    
        $this->assertTrue(is_zero(0));
        $this->assertFalse(is_zero(1492));
    }

    public function test_plus() {
        
        $this->assertSame(0, plus(0, 0));
        $this->assertSame(58, plus(46, 12));
    }

    public function test_minus() {
        
        $this->assertSame(0, minus(0, 0));
        $this->assertSame(11, minus(14, 3));
        $this->assertSame(8, minus(17, 9));
        $this->assertSame(-7, minus(18, 25));
    }

    public function test_addtup() {
        
        $this->assertSame(0, addtup([]));
        $this->assertSame(18, addtup([3, 5, 2, 8]));
        $this->assertSame(43, addtup([15, 6, 7, 12, 3]));
    }

    public function test_x() {

        $this->assertSame(0, x(0, 0));
        $this->assertSame(0, x(0, 1));
        $this->assertSame(0, x(1, 0));
        $this->assertSame(15, x(5, 3));
        $this->assertSame(52, x(13, 4));
        $this->assertSame(36, x(12, 3));
    }

    public function test_tupplus() {
        
        $this->assertSame([], tupplus([], []));
        $this->assertSame([0], tupplus([0], [0]));
        $this->assertSame([11, 11, 11, 11, 11],
                  tupplus([3, 6, 9, 11, 4],
                          [8, 5, 2, 0, 7]));
        $this->assertSame([6, 9],
                  tupplus([2, 3],
                          [4, 6]));
        $this->assertSame([7, 13],
                  tupplus([3, 7],
                          [4, 6]));
        $this->assertSame([7, 13, 8, 1],
                  tupplus([3, 7],
                          [4, 6, 8, 1]));
        $this->assertSame([7, 13, 8, 1],
                  tupplus([4, 6, 8, 1],
                          [3, 7]));
    }

    public function test_gt() {
        
        $this->assertTrue(gt(120, 11));
        $this->assertFalse(gt(12, 33));
        $this->assertFalse(gt(6, 6));
        $this->assertFalse(gt(0, 0));
    }

    public function test_lt() {
        
        $this->assertTrue(lt(4, 6));
        $this->assertFalse(lt(8, 3));
        $this->assertFalse(lt(6, 6));
        $this->assertFalse(lt(0, 0));
    }

    public function test_is_eqn() {
    
        $this->assertTrue(is_eqn(0, 0));
        $this->assertTrue(is_eqn(6, 6));
        $this->assertFalse(is_eqn(8, 3));
        $this->assertFalse(is_eqn(0, 6));
        $this->assertFalse(is_eqn(6, 0));
    }

    public function test_power() {
    
        $this->assertSame(1, power(1, 1));
        $this->assertSame(8, power(2, 3));
        $this->assertSame(125, power(5, 3));
    }

    public function test_division() {

        $this->assertSame(3, division(15, 4));
        $this->assertSame(3, division(3, 1));
        $this->assertSame(0, division(1, 3));
        $this->assertSame(0, division(0, 4));
        //$this->assertSame(INF, division(3, 0));
        $this->assertSame(PHP_INT_MAX, division(3, 0));
    }

    public function test_length() {
    
        $this->assertSame(0, length([]));
        $this->assertSame(6, length(['hotdogs', 'with', 'mustard', 'sauerkraut', 'and', 'pickles']));
        $this->assertSame(5, length(['ham', 'and', 'cheese', 'on', 'rye']));
    }

    public function test_pick() {
        
        //$this->assertNull(@pick(2, ['a']));
        //$this->assertNull(@pick(1, []));
        $this->assertNull(pick(2, ['a']));
        $this->assertNull(pick(1, []));
        $this->assertNull(pick(0, ['a']));
        $this->assertSame('macaroni', pick(4, ['lasagna', 'spaghetti', 'ravioli', 'macaroni', 'meatball']));
    }

    public function test_rempick() {
        
        $this->assertSame(['a', 'b'], rempick(0, ['a', 'b']));
        $this->assertSame(['a', 'b'], rempick(3, ['a', 'b']));
        $this->assertSame([], rempick(1, []));
        $this->assertSame(['hotdogs', 'with', 'mustard'],
               rempick(3, ['hotdogs', 'with', 'hot', 'mustard']));
    }

    public function test_is_number() {
        
        $this->assertTrue(is_number(0));
        $this->assertTrue(is_number(76));
        $this->assertFalse(is_number('tomato'));
        $this->assertFalse(is_number(-1));
    }

    public function test_no_nums() {
        
        $this->assertSame(['pears', 'prunes', 'dates'],
                  no_nums([5, 'pears', 6, 'prunes', 9, 'dates']));
        $this->assertSame([], no_nums([5, 6, 9]));
        $this->assertSame(['a', 'b'], no_nums(['a', 'b']));
    }

    public function test_all_nums() {
    
        $this->assertSame([5, 6, 9],
                 all_nums([5, 'pears', 6, 'prunes', 9, 'dates']));
        $this->assertSame([5, 6, 9], all_nums([5, 6, 9]));
        $this->assertSame([], all_nums(['a', 'b']));
    }

    public function test_is_eqan() {
        
        $this->assertTrue(is_eqan('Harry', 'Harry'));
        $this->assertTrue(is_eqan(0, 0));
        $this->assertTrue(is_eqan([], []));
        $this->assertTrue(is_eqan(['a'], ['a']));
        $this->assertTrue(is_eqan(car(['Mary', 'had', 'a', 'little', 'lamb', 'chop']), 'Mary'));
        $l = ['beans', 'beans', 'we', 'need', 'jelly', 'beans'];
        $this->assertTrue(is_eqan(car($l), car(cdr($l))));

        $this->assertFalse(is_eqan('margarine', 'butter'));
        $this->assertFalse(is_eqan([], ['strawberry']));
        $this->assertFalse(is_eqan(6, 7));
        $this->assertFalse(is_eqan(cdr(['soured', 'milk']), 'milk'));
    }

    public function test_occur() {
    
        $this->assertSame(0, occur(1, []));
        $this->assertSame(0, occur(1, ['a']));
        $this->assertSame(3, occur(1, [1, 1, 1]));
        $this->assertSame(3, occur(1, [2, 3, 1, 'a', 1, 1]));
    }

    public function test_is_one() {
    
        $this->assertTrue(is_one(1));
        $this->assertFalse(is_one(0));
        $this->assertFalse(is_one(2));
        $this->assertFalse(is_one(-1));
    }

} // class Chapter4Test END
