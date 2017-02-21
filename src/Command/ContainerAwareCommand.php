<?php

declare(strict_types=1);

namespace BOF\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class ContainerAwareCommand extends Command
{
    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->getApplication()->getContainer();
    }
}
