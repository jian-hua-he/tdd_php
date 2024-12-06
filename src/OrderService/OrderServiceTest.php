<?php

namespace Root\Code\OrderService;

use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    public function testProcessOrder_Successful() {
        $orderRepo = \Mockery::mock(OrderRepoInterface::class);
        $orderRepo->expects()->save()
            ->with(\Mockery::on(function(Order $order) {
                return $order->customerName == 'John Doe' &&
                    $order->customerEmail == 'john.doe@example.com' &&
                    $order->itemName == 'Steam deck' &&
                    $order->itemPrice == '21000' &&
                    $order->itemCurrency == 'NTD' &&
                    $order->cardNumber == '1234567812345678';
            }))
            ->once()
            ->andReturn(null);

        $paymentGeteway = \Mockery::mock(PaymentGatewayInterface::class);
        $paymentGeteway->expects()->makePayment()
            ->with(\Mockery::on(function(Payment $payment) {
                return $payment->cardNumber == '1234567812345678' &&
                    $payment->amount == '21000' &&
                    $payment->currency == 'NTD';        
            }))
            ->once()
            ->andReturn(null);
        
        $emailSrv = \Mockery::mock(EmailServiceInterface::class);
        $emailSrv->expects()->send()
            ->with(\Mockery::on(function(Email $email) {
                return $email->to == 'john.doe@example.com' &&
                    $email->subject == 'Order successful' &&
                    $email->content == 'Example content';
            }))
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
    
        $orderSrv->process($input);
    }
}