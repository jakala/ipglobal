<?php

declare(strict_types=1);

namespace App\Shop\OrderProducer\Infrastructure;

use App\Shared\Application\CreateOrderCommand;
use App\Shared\Domain\OrderStatus;
use App\Shop\OrderProducer\Application\CreateOrder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[asCommand(
    name: 'app:order:create',
    description: 'Create a new order'
)]
final class ConsoleCreateOrderCommand extends Command
{
    public function __construct(
        private CreateOrder $createOrder
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        parent::configure();
        $this->addArgument('userId', InputArgument::REQUIRED)
            ->addArgument('productId', InputArgument::REQUIRED)
            ->addArgument('amount', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $randomId = random_int(0, 1000000);
        $command = CreateOrderCommand::fromPrimitives(
            $randomId,
            (int)$input->getArgument('userId'),
            (int)$input->getArgument('productId'),
            (int)$input->getArgument('amount'),
            OrderStatus::PENDING,
            ''
        );
        $this->createOrder->__invoke($command);

        return self::SUCCESS;
    }
}
