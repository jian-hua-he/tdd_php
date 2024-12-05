<?php

namespace Root\Code\OrderService;

use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    public function testProcessOrder_Successful() {
        $orderSrv = new OrderService();

        $input = new ProcessInput();
    
        $orderSrv->processOrder($input);
    }
}