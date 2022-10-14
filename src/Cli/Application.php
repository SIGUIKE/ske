<?php

declare(strict_types=1);

namespace Ske\Cli;

use Symfony\Component\Console\Application as BaseApplication;

final class Application extends BaseApplication
{
    private static string $logo = '';

    private function __construct()
    {
        parent::__construct('Ske', '0.0.0');
        $skeCommand = new Command\SkeCommand();
        $this->add($skeCommand);
        $this->setDefaultCommand($skeCommand->getName(), true);
    }

    protected static self $INSTANCE;

    public static function main(): int
    {
        if (! isset(self::$INSTANCE)) {
            self::$INSTANCE = new self;
        }

        return self::$INSTANCE->run();
    }

    public function getHelp(): string
    {
        return self::$logo.parent::getHelp();
    }

    public function getLongVersion(): string
    {
        return sprintf(
            '<info>%s</info> <comment>%s</comment>',
            $this->getName(),
            $this->getVersion()
        );
    }

    /**
     * Initializes all the composer commands.
     *
     * @return \Symfony\Component\Console\Command\Command[]
     */
    protected function getDefaultCommands(): array
    {
        $commands = array_merge(parent::getDefaultCommands(), [
            new Command\NewCommand(),
        ]);

        return $commands;
    }
}
