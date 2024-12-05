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

    public function processOrder(ProcessInput $input): void {
        throw new \Exception('no implementation');
    }
}