<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class Mail
{
    private LoggerInterface $logger;
    private Mail $mailer;

    public function __construct(LoggerInterface $logger)
    {
        $this->mailer = $_ENV["MAILER_DSN"];
        $this->logger = $logger;
    }

    public function shareMail(){
        
    }
}