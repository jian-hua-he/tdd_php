<?php

namespace Root\Code\Calculator;

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAdd() {
        $calculator = new Calculator();
        $got = $calculator->add(2, 3);
        $want = 5;
        $this->assertEquals($want, $got);
    }
}