<?php

namespace AsyncAws\Sqs\Tests\Unit\Result;

use AsyncAws\Core\Response;
use AsyncAws\Core\Test\Http\SimpleMockedResponse;
use AsyncAws\Core\Test\TestCase;
use AsyncAws\Sqs\Result\ChangeMessageVisibilityBatchResult;
use Psr\Log\NullLogger;
use Symfony\Component\HttpClient\MockHttpClient;

class ChangeMessageVisibilityBatchResultTest extends TestCase
{
    public function testChangeMessageVisibilityBatchResult(): void
    {
        // see https://docs.aws.amazon.com/AWSSimpleQueueService/latest/APIReference/API_ChangeMessageVisibilityBatch.html
        $response = new SimpleMockedResponse(<<<JSON
{
    "Failed": [],
    "Successful": [
        {
            "Id": "change_visibility_msg_2"
        },
        {
            "Id": "change_visibility_msg_3"
        }
    ]
}
JSON
        );

        $client = new MockHttpClient($response);
        $result = new ChangeMessageVisibilityBatchResult(new Response($client->request('POST', 'http://localhost'), $client, new NullLogger()));

        self::assertCount(2, $result->getSuccessful());
        self::assertSame('change_visibility_msg_2', $result->getSuccessful()[0]->getId());
        self::assertSame('change_visibility_msg_3', $result->getSuccessful()[1]->getId());
        self::assertCount(0, $result->getFailed());
    }
}
