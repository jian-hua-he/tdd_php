<?php

namespace Root\Code\OrderService;

interface OrderRepoInterface {
    function save(Order $order): void;
}

interface PaymentGatewayInterface {
    function makePayment(string $orderId): void;
}

interface EmailServiceInterface {
    function send(Email $email): void;
}