<?php

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src');

require 'chapter_6.php';

use PHPUnit\Framework\TestCase;

class Chapter6Test extends TestCase {

    public function test_is_numbered() {
    
        $this->assertTrue(is_numbered(1));
        $this->assertTrue(is_numbered([3, '+', [4, 'x', 5]]));
        $this->assertTrue(is_numbered([3, '+', [4, '^', 5]]));
        $this->assertTrue(is_numbered([[3, 'x', 2], '+', [4, '^', 5]]));

        $this->assertFalse(is_numbered([2, 'x', 'sausage']));
        //$this->assertFalse(@is_numbered([]));
        $this->assertFalse(is_numbered([]));
    
    }

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

        // only natural value of a numbered arithmetic expression
        //$this->assertSame('coolie', value('coolie'));
    }

    public function test_is_sero() {
    
        $this->assertTrue(is_sero([]));

        $this->assertFalse(is_sero([[]]));
        $this->assertFalse(is_sero([[], []]));
    }

    public function test_edd1() {
        
        $this->assertSame([[]], edd1([]));
        $this->assertSame([[], []], edd1([[]]));
    }

    public function test_zub1() {

        $zub1 = 'cdr';
        $this->assertSame([], $zub1([[]]));
        $this->assertSame([[]], $zub1([[], []]));
        $this->assertSame([], $zub1([]));
    }

    public function test_blus() {
        
        $this->assertSame([], blus([], []));
        $this->assertSame([[]], blus([[]], []));
        $this->assertSame([[]], blus([], [[]]));
        $this->assertSame([[], []], blus([[]], [[]]));
    }

} // class Chapter6Test END
