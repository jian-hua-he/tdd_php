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
        $orderRepo->expects()->save()
            ->with($mockOrder)
            ->once()
            ->andReturn(null);

        $mockPayment = new Payment();
        $mockPayment->cardNumber = '1234567812345678';
        $mockPayment->amount = '21000';
        $mockPayment->currency = 'NTD';        

        $paymentGeteway = \Mockery::mock(PaymentGatewayInterface::class);
        $paymentGeteway->expects()->makePayment()
            ->with($mockPayment)
            ->once()
            ->andReturn(null);
        
        $mockEmail = new Email();
        $mockEmail->to = 'john.doe@example.com';
        $mockEmail->subject = 'Order successful';
        $mockEmail->content = 'Example content';

        $emailSrv = \Mockery::mock(EmailServiceInterface::class);
        $emailSrv->expects()->send()
            ->with($mockEmail)
            ->once()
            ->andReturn(null);

        $orderSrv = new OrderService(
            $orderRepo,
            $paymentGeteway,
            $emailSrv,
        );

        $input = new ProcessInput();
        $input->customerName = 'John Doe';
        $input->customerEmail = 'john.doe@example.com';
        $input->itemName = 'Steam deck';
        $input->itemPrice = '21000';
        $input->itemCurrency = 'NTD';
        $input->cardNumber = '1234567812345678';
    
        $orderSrv->processOrder($input);
    }
}