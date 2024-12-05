<?php

namespace Root\Code\OrderService;

use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    public function testProcessOrder_Successful() {
        $orderRepo = \Mockery::mock(OrderRepoInterface::class);

        $paymentGeteway = \Mockery::mock(PaymentGatewayInterface::class);

        $emailSrv = \Mockery::mock(EmailServiceInterface::class);

        $orderSrv = new OrderService(
            $orderRepo,
            $paymentGeteway,
            $emailSrv,
        );

        $input = new ProcessInput();
    
        $orderSrv->processOrder($input);
    }
}