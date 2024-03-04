<?php

declare(strict_types=1);

namespace App\Command;

use App\Message\Food\Refill;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:food:refill')]
class RefillCommand extends Command
{
    public function __construct(
        private MessageBusInterface $bus
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Dispatch a food refill message.')
            ->setHelp('This command allows you to dispatch a food refill command...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bus->dispatch(new Refill());

        return Command::SUCCESS;
    }
}
