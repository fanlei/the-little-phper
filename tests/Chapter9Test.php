<?php

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src');

require 'chapter_9.php';

use PHPUnit\Framework\TestCase;

class Chapter9Test extends TestCase {

    public function test_looking() {
        
        $this->assertTrue(looking('caviar', [6, 2, 4, 'caviar', 5, 7, 3]));

        $this->assertFalse(looking('caviar', [6, 2, 'grits', 'caviar', 5, 7, 3]));
    }

    public function test_shift() {
        
        $this->assertSame(['a', ['b', 'c']], shift([['a', 'b'], 'c']));
        $this->assertSame(['a', ['b', ['c', 'd']]], shift([['a', 'b'], ['c', 'd']]));
    }

    public function test_align() {
        
        $this->assertSame(['a', ['b', 'c']], align([['a', 'b'], 'c']));
        $this->assertSame(['a', ['b', ['c', 'd']]], align([['a', 'b'], ['c', 'd']]));
    }

    public function test_lenght_star() {
        
        $this->assertSame(3, length_star([['a', 'b'], 'c']));
        $this->assertSame(3, length_star(['a', ['b', 'c']]));
    }

    public function test_weight_star() {
        
        $this->assertSame(7, weight_star([['a', 'b'], 'c']));
        $this->assertSame(5, weight_star(['a', ['b', 'c']]));
    }

    public function test_shuffle1() {
        
        $this->assertSame(['a', ['b', 'c']], shuffle1(['a', ['b', 'c']]));
        $this->assertSame(['a', 'b'], shuffle1(['a', 'b']));

        // Fatal error: Allowed memory size of bytes exhausted
        //$this->assertSame([['a', 'b'], ['c', 'd']], shuffle1([['a', 'b'], ['c', 'd']]));
    }

    public function test_C() {

        $this->assertSame(1, C(1));
        $this->assertSame(1, C(2));
        $this->assertSame(1, C(3));
        $this->assertSame(1, C(4));
        $this->assertSame(1, C(5));
        $this->assertSame(1, C(7));
        $this->assertSame(1, C(11));
        $this->assertSame(1, C(13));
    }

    public function test_A() {
        
        $this->assertSame(1, A(0, 0));
        $this->assertSame(2, A(1, 0));
        $this->assertSame(3, A(1, 1));
        $this->assertSame(7, A(2, 2));
        $this->assertSame(4, A(1, 2));
        $this->assertSame(29, A(3, 2));
        $this->assertSame(9, A(2, 3));
        $this->assertSame(61, A(3, 3));
        $this->assertSame(125, A(3, 4));
        $this->assertSame(13, A(4, 0));
    }

    public function test_Y() {
    
        $factorial = Y(function (callable $factorial) : callable
                       {return
                           function (int $n) use ($factorial) : int
                           {return
                               lt($n, 2) ? $n
                               : x($n, $factorial(sub1($n)));
                           };
        });

        $this->assertSame(1, $factorial(1));
        $this->assertSame(2, $factorial(2));
        $this->assertSame(6, $factorial(3));
        $this->assertSame(6, $factorial(3));
        $this->assertSame(120, $factorial(5));
        $this->assertSame(720, $factorial(6));
    }

} // class Chapter9Test END
