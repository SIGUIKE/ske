<?php

declare(strict_types=1);

namespace Ske\Cli\Command;

use Ske\Cli\Command;
use Symfony\Component\Console\Helper\DescriptorHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SkeCommand extends Command
{
    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('ske')
            ->setDescription('Ske allows to manage SIKessEm packages')
            ->setHelp('Use `ske` to manage SIKessEm packages');
    }

    /**
     * Execute the command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = new DescriptorHelper();
        $helper->describe($output, $this->getApplication(), []);

        return self::SUCCESS;
    }
}
