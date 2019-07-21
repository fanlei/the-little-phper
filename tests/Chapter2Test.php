<?php

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src');

require 'chapter_2.php';

use PHPUnit\Framework\TestCase;

class Chapter2Test extends TestCase {

    public function test_is_lat() {

        $this->assertTrue(is_lat(['Jack', 'Sprat', 'could', 'eat', 'no', 'chicken', 'fat']));
        $this->assertTrue(is_lat([]));

        $this->assertFalse(is_lat([['Jack'], 'Sprat', 'could', 'eat', 'no', 'chicken', 'fat']));
        $this->assertFalse(is_lat(['Jack', ['Sprat', 'could'], 'eat', 'no', 'chicken', 'fat']));
    }

    public function test_is_member() {

        $this->assertTrue(is_member('tea', ['coffee', 'tea', 'or', 'milk']));

        $this->assertFalse(is_member('poached', ['fried', 'eggs', 'and', 'scrambled', 'eggs']));
        $this->assertFalse(is_member('liver', ['bagels', 'and', 'lox']));
    }

} // class Chapter2Test END
