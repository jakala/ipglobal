<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use Symfony\Component\Console\Event\ConsoleErrorEvent;

final class ExceptionListener
{
    public function onConsoleError(ConsoleErrorEvent $event): void
    {
        $erro = $event->getInput();
        $event->getOutput()->writeln("<info>{$erro}</info>");
        $event->setExitCode(0);
    }
}
