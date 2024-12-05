<?php

namespace Root\Code\OrderService;

use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    public function testProcessOrder_Successful() {
        $mockOrder = new Order();
        $mockOrder->customerName = 'John Doe';
        $mockOrder->customerEmail = 'john.doe@example.com';
        $mockOrder->itemName = 'Steam deck';
        $mockOrder->itemPrice = '21000';
        $mockOrder->itemCurrency = 'NTD';
        $mockOrder->cardNumber = '1234567812345678';

        $orderRepo = \Mockery::mock(OrderRepoInterface::class);
        $orderRepo->shouldReceive('save')
            ->once()
            ->with($mockOrder)
            ->andReturn(null);

        $mockPayment = new Payment();
        $mockPayment->cardNumber = '1234567812345678';
        $mockPayment->amount = '21000';
        $mockPayment->currency = 'NTD';        

        $paymentGeteway = \Mockery::mock(PaymentGatewayInterface::class);
        $paymentGeteway->shouldReceive('makePayment')
            ->once()
            ->with($mockPayment)
            ->andReturn(null);
        
        $mockEmail = new Email();
        $mockEmail->to = 'john.doe@example.com';
        $mockEmail->subject = 'Order successful';
        $mockEmail->content = 'Example content';

        $emailSrv = \Mockery::mock(EmailServiceInterface::class);
        $emailSrv->shouldReceive('send')
            ->once()
            ->with($mockEmail)
            ->andReturn(null);

        $orderSrv = new OrderService(
            $orderRepo,
            $paymentGeteway,
            $emailSrv,
        );

        $input = new ProcessInput();
    
        $orderSrv->processOrder($input);
    }
}