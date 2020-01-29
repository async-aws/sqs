<?php

declare(strict_types=1);

namespace WorkingTitle\Aws\Sqs;

use Symfony\Contracts\HttpClient\ResponseInterface;

class SendMessageResult
{
    public function __construct(ResponseInterface $response)
    {
        // Do something..
    }
}
