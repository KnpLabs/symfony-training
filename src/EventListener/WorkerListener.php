<?php

declare(strict_types=1);

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Symfony\Component\Messenger\Event\WorkerRunningEvent;
use Symfony\Component\Messenger\Event\WorkerStartedEvent;
use Symfony\Component\Messenger\Event\WorkerStoppedEvent;
use Symfony\Component\Messenger\Stamp\HandledStamp;

#[AsEventListener(event: WorkerStartedEvent::class, method: 'onWorkerStartedEvent')]
#[AsEventListener(event: WorkerStoppedEvent::class, method: 'onWorkerStoppedEvent')]
#[AsEventListener(event: WorkerMessageHandledEvent::class, method: 'onWorkerMessageHandledEvent')]
#[AsEventListener(event: WorkerRunningEvent::class, method: 'onWorkerRunningEvent')]
#[AsEventListener(event: WorkerMessageReceivedEvent::class, method: 'onWorkerMessageReceivedEvent')]
#[AsEventListener(event: WorkerMessageFailedEvent::class, method: 'onWorkerMessageFailedEvent')]
class WorkerListener
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function onWorkerStartedEvent(WorkerStartedEvent $event)
    {
        $transports = $event->getWorker()->getMetadata()->getTransportNames();

        $this->logger->log(LogLevel::NOTICE, sprintf(
            'Worker started. Transports priority : [%s]',
            implode(', ', $transports)
        ));
    }

    public function onWorkerStoppedEvent(WorkerStoppedEvent $event)
    {
        $this->logger->log(LogLevel::NOTICE, 'Worker stopped');
    }

    public function onWorkerMessageReceivedEvent(WorkerMessageReceivedEvent $event)
    {
        $envelope = $event->getEnvelope();

        $message = $envelope->getMessage();
        $messageClass = get_class($message);

        $this->logger->log(LogLevel::NOTICE, sprintf('Received message %s', $messageClass));
    }

    public function onWorkerMessageHandledEvent(WorkerMessageHandledEvent $event)
    {
        $envelope = $event->getEnvelope();

        $handledStamp = $envelope->last(HandledStamp::class);

        $handlerName = $handledStamp->getHandlerName();

        $message = $envelope->getMessage();
        $messageClass = get_class($message);

        $this->logger->log(LogLevel::NOTICE, sprintf('Message %s handled by %s', $messageClass, $handlerName));
    }

    public function onWorkerMessageFailedEvent(WorkerMessageFailedEvent $event)
    {
        $envelope = $event->getEnvelope();

        $message = $envelope->getMessage();
        $messageClass = get_class($message);

        $this->logger->log(LogLevel::CRITICAL, sprintf('Message %s failed', $messageClass));
    }

    public function onWorkerRunningEvent()
    {
        $this->logger->log(LogLevel::NOTICE, 'Worker is running. Waiting for messages...');
    }
}
