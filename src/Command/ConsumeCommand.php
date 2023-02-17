<?php

declare(strict_types=1);

namespace App\Command;

use App\Message\Food\Consume;
use App\Repository\DinosaurRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ConsumeCommand extends Command
{
    protected static $defaultName = 'app:food:consume';

    public function __construct(
        private MessageBusInterface $bus,
        private DinosaurRepository $dinosaurRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Dispatch some food comsumption messages.')
            ->setHelp('This command allows you dispatch some food consumptions messages...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dinosaurs = $this->dinosaurRepository->findAll();

        for ($i = 0; $i < 100; $i++) {
            $randomDinoKey = array_rand($dinosaurs);

            $dinosaur = $dinosaurs[$randomDinoKey];

            $consumeMessage = new Consume(
                $dinosaur->getId()->toRfc4122(),
                $dinosaur->getName()
            );

            $this->bus->dispatch($consumeMessage);
        }

        return Command::SUCCESS;
    }
}
