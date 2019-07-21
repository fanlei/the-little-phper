<?php

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src');

require 'chapter_1.php';

use PHPUnit\Framework\TestCase;

class Chapter1Test extends TestCase {

    public function test_car() {
    
        $this->assertSame('a', car(['a', 'b', 'c']));
        $this->assertSame(['a', 'b', 'c'], car([['a', 'b', 'c'], 'x', 'y', 'z']));
        $this->assertSame([['a']], car([[['a']], ['b'], ['c'], 'd', 'e']));
        $this->assertSame(['a'], car(car([[['a']], ['b']])));

        //$this->assertNull(@car([]));
        $this->assertNull(car([])); // L: nil

    }

    public function test_cdr() {

        $this->assertSame(['b', 'c'], cdr(['a', 'b', 'c']));
        $this->assertSame(['x', 'y', 'z'], cdr([['a', 'b', 'c'], 
                           'x', 'y', 'z']));
        $this->assertSame(['t', 'r'], cdr([['x'], 't', 'r']));

        $this->assertSame([], cdr(['hamburger']));

        $this->assertSame([], cdr([])); // L: nil

        $this->assertSame(['x', 'y'], car(cdr([['b'], ['x', 'y'] ,['c']])));
        $this->assertSame([[['c']]], cdr(cdr([['b'], ['x', 'y'], 
                           [['c']]])));
    }

    public function test_cons() {

        $this->assertSame(['a', 'b', 'c', 'd'], cons('a', ['b', 'c', 'd']));
        $this->assertSame([['a', 'b'], 'c', 'd', 'e', 'f'], 
                     cons(['a', 'b'], ['c', 'd', 'e', 'f']));
        $this->assertSame([[['a'], 'b'], 'c', 'd', [['e'], 'f', 'g']], 
                     cons([['a'], 'b'], ['c', 'd', [['e'], 'f', 'g']]));
        $this->assertSame([['a', 'b', ['c']]], cons(['a', 'b', ['c']], []));
        $this->assertSame(['a'], cons('a', []));

        $this->assertSame(['a', 'b'], cons('a', car([['b'], 'c', 'd'])));
        $this->assertSame(['a', 'c', 'd'], cons('a', cdr([['b'], 'c', 'd'])));
    
        /* In practice, (cons a b) for all values a and b, and
         *         (car (cons a b)) = a
         *         (cdr (cons a b)) = b.
         */
        //$this->assertSame(['a', 'b', 'c', 'b'], cons(['a', 'b', 'c'], 'b'));
    }

    public function test_is_nulll() {

        $this->assertTrue(is_nulll([]));
        $this->assertTrue(is_nulll(cdr(['a'])));
        $this->assertFalse(is_nulll(['a', 'b', 'c']));

        /* In practice, (null? a) is false for everything, 
         * except the empty list. 
         */
    
    }

    public function test_is_atom() {
    
        $this->assertTrue(is_atom(13));
        $this->assertTrue(is_atom('Harry'));
        $this->assertTrue(is_atom(car(['Harry', 'had', 'a', 'heap', 'of', 'apples'])));
        $this->assertTrue(is_atom(car(cdr(['swing', 'low', 'sweet', 'cherry', 'oat']))));

        $this->assertFalse(is_atom(['Harry', 'had', 'a', 'heap', 'of', 'apples']));
        $this->assertFalse(is_atom(cdr(['Harry', 'had', 'a', 'heap', 'of', 'apples'])));
        $this->assertFalse(is_atom(cdr(['Harry'])));
        $this->assertFalse(is_atom(car(cdr(['swing', ['low', 'sweet'], 'cherry', 'oat']))));
    }

    public function test_is_eq() {
        
        $this->assertTrue(is_eq('Harry', 'Harry'));
        $this->assertTrue(is_eq(0, 0));
        $this->assertTrue(is_eq([], []));
        $this->assertTrue(is_eq(TRUE, TRUE));
        $this->assertTrue(is_eq(FALSE, FALSE));
        $this->assertTrue(is_eq('', ''));
        $this->assertTrue(is_eq(NULL, NULL));
        $this->assertTrue(is_eq(['a'], ['a']));
        $this->assertTrue(is_eq(car(['Mary', 'had', 'a', 'little', 'lamb', 'chop']), 'Mary'));
        $l = ['beans', 'beans', 'we', 'need', 'jelly', 'beans'];
        $this->assertTrue(is_eq(car($l), car(cdr($l))));

        $this->assertFalse(is_eq('margarine', 'butter'));
        $this->assertFalse(is_eq([], ['strawberry']));
        $this->assertFalse(is_eq(6, 7));
        $this->assertFalse(is_eq(cdr(['soured', 'milk']), 'milk'));
    }

} // calss Chapter1Test END
