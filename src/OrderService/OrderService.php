<?php

namespace Root\Code\OrderService;

class ProcessInput
{
    public string $customerName;
    public string $customerEmail;
    public string $itemName;
    public string $itemPrice;
    public string $itemCurrency;
    public string $cardNumber;
}

class OrderService
{
    private OrderRepoInterface $orderRepo;
    private PaymentGatewayInterface $paymentGateway;
    private EmailServiceInterface $emailService;

    public function __construct(
        OrderRepoInterface $orderRepo,
        PaymentGatewayInterface $paymentGateway,
        EmailServiceInterface $emailService
    ) {
        $this->orderRepo = $orderRepo;
        $this->paymentGateway = $paymentGateway;
        $this->emailService = $emailService;
    }

    public function process(ProcessInput $input): void {
        $order = new Order();
        $order->customerName = $input->customerName;
        $order->customerEmail = $input->customerEmail;
        $order->itemName = $input->itemName;
        $order->itemPrice = $input->itemPrice;
        $order->itemCurrency = $input->itemCurrency;
        $order->cardNumber = $input->cardNumber;

        $this->orderRepo->save($order);

        $payment = new Payment();
        $payment->cardNumber = $input->cardNumber;
        $payment->amount = $input->itemPrice;
        $payment->currency = $input->itemCurrency;

        $this->paymentGateway->makePayment($payment);

        $email = new Email();
        $email->to = $input->customerEmail;
        $email->subject = 'Order successful';
        $email->content = 'Example content';

        $this->emailService->send($email);
    }
}