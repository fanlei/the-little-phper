<?php

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src');

require 'chapter_7.php';

use PHPUnit\Framework\TestCase;

class Chapter7Test extends TestCase {

    public function test_is_set() {
        
        $this->assertTrue(is_set(['apples', 'peaches', 'pears', 'plums']));
        $this->assertTrue(is_set([]));

        $this->assertFalse(is_set(['apple', 'peaches', 'apple', 'plum']));
        $this->assertFalse(is_set(['apple', 3, 'pear', 4, 9, 'apple', 3, 4]));
    }

    public function test_makeset() {

        /*
        $this->assertSame(['pear', 'plum', 'apple', 'lemon', 'peach'],
                   makeset(['apple', 'peach', 'pear', 'peach', 'plum', 'apple', 'lemon', 'peach']));
         */
        $this->assertSame(['apple', 'peach', 'pear', 'plum', 'lemon'],
                  makeset(['apple', 'peach', 'pear', 'peach', 'plum', 'apple', 'lemon', 'peach']));
        $this->assertSame(['apple', 3, 'pear', 4, 9],
            makeset(['apple', 3, 'pear', 4, 9, 'apple', 3, 4]));


    }

    public function test_is_subset() {
        
        $this->assertTrue(is_subset([5, 'chicken', 'wings'], 
                                    [5, 'hamburgers', 
                                     2, 'pieces', 'fired', 'chicken', 'and', 
                                     'light', 'ducking', 'wings']));
        $this->assertTrue(is_subset([6, 'large', 'chickens', 'with', 'wings'], 
                                    [6, 'chickens', 'with', 'large', 'wings']));
        $this->assertFalse(is_subset([4, 'pounds', 'of', 'horseradish'], 
                                     ['four', 'pounds', 'chichen', 'and', 
                                      '5', 'ounces', 'horseradish']));
    }

    public function test_is_eqset() {
        
        $this->assertTrue(is_eqset([], []));
        $this->assertTrue(is_eqset([1, 'a'], ['a', 1]));
        $this->assertTrue(is_eqset([[1], 'a'], ['a', [1]]));
    }

    public function test_is_intersect() {
        
        $this->assertTrue(is_intersect(['stewed', 'tomatoes', 'and', 'macaroni'], ['macaroni', 'and', 'cheese']));

        $this->assertFalse(is_intersect(['stewed', 'tomatoes', 'and', 'macaroni'], []));
        $this->assertFalse(is_intersect([], ['macaroni', 'and', 'cheese']));
        $this->assertFalse(is_intersect([], []));
        $this->assertFalse(is_intersect([1], ['1']));
    }

    public function test_intersect() {
    
        $this->assertSame(['and', 'macaroni'], 
                intersect(['stewed', 'tomatoes', 'and', 'macaroni'],
                          ['macaroni', 'and', 'cheese']));
        $this->assertSame([], intersect([], []));
        $this->assertSame([], intersect([], [1]));
        $this->assertSame([], intersect([1], []));
        $this->assertSame([], intersect([1], [2]));
    }

    public function test_union() {
    
        $this->assertSame(['stewed', 'tomatoes', 'macaroni', 'and', 'cheese'], 
                union(['stewed', 'tomatoes', 'and', 'macaroni'],
                      ['macaroni', 'and', 'cheese']));
        $this->assertSame([], union([], []));
        $this->assertSame([1], union([], [1]));
        $this->assertSame([1], union([1], []));
        $this->assertSame([1, 2], union([1], [2]));
    }

    public function test_difference() {
    
        $this->assertSame(['stewed', 'tomatoes'], 
                difference(['stewed', 'tomatoes', 'and', 'macaroni'],
                           ['macaroni', 'and', 'cheese']));
        $this->assertSame([], difference([], []));
        $this->assertSame([], difference([], [1]));
        $this->assertSame([1], difference([1], []));
        $this->assertSame([1], difference([1], [2]));
    }

    public function test_intersetall() {

        $this->assertSame([6, 'and'], intersectall([
                        [6, 'pears', 'and'],
                        [3, 'peaches', 'and', 6, 'peppers'],
                        [8, 'pears', 'and', 6, 'plums'],
                        ['and', 6, 'prunes', 'with', 'some', 'apples']]));

        $this->assertNull(intersectall([]));
        $this->assertSame([1], intersectall([[1]]));
        $this->assertSame(1, intersectall([1]));
        $this->assertSame([], intersectall([[1], [2]]));
    }

    public function test_is_pair() {

        $this->assertTrue(is_pair(['pear', 'pear']));
        $this->assertTrue(is_pair([3, 7]));
        $this->assertTrue(is_pair([[2], ['pear']]));
        $this->assertTrue(is_pair(['full', ['pear']]));

        $this->assertFalse(is_pair('a'));
        $this->assertFalse(is_pair([]));
        $this->assertFalse(is_pair([1]));
        $this->assertFalse(is_pair([1, 2, 3]));
    
    }

    public function test_build() {

        $this->assertSame([5, 6], build(5, 6));
        $this->assertSame([[5], 6], build([5], 6));
        $this->assertSame([5, [6]], build(5, [6]));
        $this->assertSame([[], []], build([], []));
        $this->assertSame([[], 3], build([], 3));
        $this->assertSame([3, []], build(3, []));
    }

    public function test_is_rel() {
    
        $this->assertFalse(is_rel(['apples', 'peaches', 'pumpkin', 'pie']));
        $this->assertFalse(is_rel([['apples', 'peaches'], 
                                   ['pumpkin', 'pie'],
                                   ['apples', 'peaches']]));

        $this->assertTrue(is_rel([[4, 3], [4, 2], [7, 6], [6, 2], [3, 4]]));
        $this->assertTrue(is_rel([['d', 4], ['b', 0], ['b', 9], ['e', 5], ['g', 4]]));
        $this->assertTrue(is_rel([[8, 3], [4, 2], [7, 6], [6, 2], [3, 4]]));
        $this->assertTrue(is_rel([['apples', 'peaches'], 
                                   ['pumpkin', 'pie']]));
    }

    public function test_is_fun() {
    
        //$this->assertFalse(is_fun(['apples', 'peaches', 'pumpkin', 'pie']));
        $this->assertFalse(is_fun([['apples', 'peaches'], 
                                   ['pumpkin', 'pie'],
                                   ['apples', 'peaches']]));
        $this->assertFalse(is_fun([[4, 3], [4, 2], [7, 6], [6, 2], [3, 4]]));
        $this->assertFalse(is_fun([['d', 4], ['b', 0], ['b', 9], ['e', 5], ['g', 4]]));

        $this->assertTrue(is_fun([[8, 3], [4, 2], [7, 6], [6, 2], [3, 4]]));
        $this->assertTrue(is_fun([['apples', 'peaches'], 
                                   ['pumpkin', 'pie']]));
    }

    public function test_revpair() {
    
        $this->assertSame([1, 2], revpair([2, 1]));
        $this->assertSame([[], []], revpair([[], []]));
    }

    public function test_revrel() {
    
        $this->assertSame([['a', 8], ['pie', 'pumpkin'], ['sick', 'got']],
                   revrel([[8, 'a'], ['pumpkin', 'pie'], ['got', 'sick']]));
    }

    public function test_seconds() {
        
        $this->assertSame(['peach', 'pear', 'raisin', 'carrot'],
                seconds([['apple', 'peach', 'pumpkin'], 
                         ['plum', 'pear', 'cherry'], 
                         ['grape', 'raisin', 'pea'], 
                         ['bean', 'carrot', 'eggplant']]));
        $this->assertSame(['b', 'd', 'f'], 
                seconds([['a', 'b'], ['c', 'd'], ['e', 'f']]));
        $this->assertSame([], seconds([]));
        $this->assertSame(['plums', NULL, 'green'], 
                seconds([['five', 'plums'], 
                         ['four'], 
                         ['eleven', 'green', 'oranges']]));
        $this->assertSame(['four', 'green', ['more']],
                seconds([[['five', 'plums'], 'four'], 
                         ['eleven', 'green', 'oranges'], 
                         ['no', ['more']]]));
    }

    public function test_is_fullfun() {

        $this->assertTrue(is_fullfun([[8, 3], [8, 8], [8, 6], [8, 2], [8, 4]]));
        $this->assertTrue(is_fullfun([[8, 3], [4, 8], [7, 6], [6, 2], [3, 4]]));
        $this->assertTrue(is_fullfun([['grape', 'raisin'],
                                      ['plum', 'prune'],
                                      ['stewed', 'grape']]));
    
        $this->assertFalse(is_fullfun([[8, 3], [4, 2], [7, 6], [6, 2], [3, 4]]));
    }

    public function test_is_one2one() {

        $this->assertTrue(is_one2one([[8, 3], [8, 8], [8, 6], [8, 2], [8, 4]]));
        $this->assertTrue(is_one2one([[8, 3], [4, 8], [7, 6], [6, 2], [3, 4]]));
        $this->assertTrue(is_one2one([['grape', 'raisin'],
                                      ['plum', 'prune'],
                                      ['stewed', 'grape']]));
    
        $this->assertFalse(is_one2one([[8, 3], [4, 2], [7, 6], [6, 2], [3, 4]]));
    }

} // class Chapter7Test END
