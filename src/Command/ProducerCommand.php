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
    name: 'app:producer',
    description: 'Sent a message',
    aliases: ['app:producer'],
    hidden: false
)]
class ProducerCommand extends Command
{
    private SqsClient $sqsClient;
    private ContainerBagInterface $params;

    public function __construct(SqsClient $sqsClient, ContainerBagInterface $params, string $name = null)
    {
        parent::__construct($name);
        $this->sqsClient = $sqsClient;
        $this->params = $params;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sqsUrl = $this->params->get('sqsurl');
        $params = [
            'DelaySeconds' => 2,
            'MessageAttributes' => [
                "Title" => [
                    'DataType' => "String",
                    'StringValue' => "The Hitchhiker's Guide to the Galaxy"
                ],
                "Author" => [
                    'DataType' => "String",
                    'StringValue' => "Douglas Adams."
                ],
                "WeeksOn" => [
                    'DataType' => "Number",
                    'StringValue' => "6"
                ]
            ],
            'MessageBody' => $this->ramdomName() . " ngu",
            'QueueUrl' => $sqsUrl,
        ];
        try {
            $result = $this->sqsClient->sendMessage($params);
            $output->writeln('Sent');
            return Command::SUCCESS;
        } catch (AwsException $exception) {
            $output->writeln('Error sending');
            return Command::FAILURE;
        }
    }
    private function ramdomName(): string
    {
        $arr = ['Hoai', 'Khoa', 'Tri', 'Kha', 'Sang', 'Thang'];
        $idx = array_rand($arr);
        return $arr[$idx];
    }
}
