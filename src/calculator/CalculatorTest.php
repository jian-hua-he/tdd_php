<?php

use PHPUnit\Framework\TestCase;
use Calculator\Calculator;

class CalculatorTest extends TestCase
{
    public function testAdd() {
        $calculator = new Calculator();
        $got = $calculator->add(2, 3);
        $want = 5;
        $this->assertEquals($want, $got);
    }
}