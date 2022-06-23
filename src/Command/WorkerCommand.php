<?php

namespace App\Command;

use Aws\Exception\AwsException;
use Aws\Sqs\SqsClient;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

#[AsCommand(
    name: 'app:worker',
    description: 'Receive a message',
    aliases: ['app:worker'],
    hidden: false
)]
class WorkerCommand extends Command
{
    private SqsClient $sqsClient;
    private ContainerBagInterface $params;

    public function __construct(SqsClient $sqsClient, ContainerBagInterface $params, string $name = null)
    {
        parent::__construct($name);
        $this->params = $params;
        $this->sqsClient = $sqsClient;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $queueUrl = $this->params->get('sqsurl');
        try {
            $result = $this->sqsClient->receiveMessage(array(
                'AttributeNames' => ['SentTimestamp'],
                'MaxNumberOfMessages' => 1,
                'MessageAttributeNames' => ['All'],
                'QueueUrl' => $queueUrl, // REQUIRED
                'WaitTimeSeconds' => 0,
            ));
            if (!empty($result->get('Messages'))) {
                $output->writeln('Received');
                $output->writeln($result->get('Messages')[0]['Body']);
                $result = $this->sqsClient->deleteMessage([
                    'QueueUrl' => $queueUrl, // REQUIRED
                    'ReceiptHandle' => $result->get('Messages')[0]['ReceiptHandle'] // REQUIRED
                ]);
            } else {
                $output->writeln('No message in queue');
            }
            return Command::SUCCESS;
        } catch (AwsException $e) {
            $output->writeln('Error receiving');
            return Command::FAILURE;
        }
    }

}
