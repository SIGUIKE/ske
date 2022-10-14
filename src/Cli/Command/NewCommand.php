<?php

declare(strict_types=1);

namespace Ske\Cli\Command;

use RuntimeException;
use Ske\Cli\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class NewCommand extends Command
{
    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('new')
            ->setDescription('Create a new SIKessEm application')
            ->addArgument('name', InputArgument::REQUIRED)
            ->addOption('dev', null, InputOption::VALUE_NONE, 'Installs the latest "development" release')
            ->addOption('git', null, InputOption::VALUE_NONE, 'Initialize a Git repository')
            ->addOption('branch', null, InputOption::VALUE_REQUIRED, 'The branch that should be created for a new repository', $this->defaultBranch())
            ->addOption('github', null, InputOption::VALUE_OPTIONAL, 'Create a new repository on GitHub', false)
            ->addOption('organization', null, InputOption::VALUE_REQUIRED, 'The GitHub organization to create the new repository for')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Forces install even if the directory already exists');
    }

    /**
     * Execute the command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $installJetstream = $input->getOption('jet') ||
                            ($input->getOption('prompt-jetstream') && ($this->stylize($input, $output))->confirm('Would you like to install the Laravel Jetstream application scaffolding?', false));

        if ($installJetstream) {
            $output->write(PHP_EOL."  <fg=magenta>
      |     |         |
      |,---.|--- ,---.|--- ,---.,---.,---.,-.-.
      ||---'|    `---.|    |    |---',---|| | |
  `---'`---'`---'`---'`---'`    `---'`---^` ' '</>".PHP_EOL.PHP_EOL);

            $stack = $this->jetstreamStack($input, $output);

            $teams = $input->getOption('teams') === true
                    ? (bool) $input->getOption('teams')
                    : $this->stylize($input, $output)->confirm('Will your application use teams?', false);
        } else {
            $output->write(PHP_EOL.'  <fg=red> _                               _
  | |                             | |
  | |     __ _ _ __ __ ___   _____| |
  | |    / _` | \'__/ _` \ \ / / _ \ |
  | |___| (_| | | | (_| |\ V /  __/ |
  |______\__,_|_|  \__,_| \_/ \___|_|</>'.PHP_EOL.PHP_EOL);
        }

        sleep(1);

        $name = $input->getArgument('name');

        $directory = $name !== '.' ? getcwd().'/'.$name : '.';

        $version = $this->getVersion($input);

        if (! $input->getOption('force')) {
            $this->verifyPackageDoesntExist($directory);
        }

        if ($input->getOption('force') && $directory === '.') {
            throw new RuntimeException('Cannot use --force option when using current directory for installation!');
        }

        $composer = $this->findComposer();

        $commands = [
            $composer." create-project laravel/laravel \"$directory\" $version --remove-vcs --prefer-dist",
        ];

        if ($directory != '.' && $input->getOption('force')) {
            if (PHP_OS_FAMILY == 'Windows') {
                array_unshift($commands, "(if exist \"$directory\" rd /s /q \"$directory\")");
            } else {
                array_unshift($commands, "rm -rf \"$directory\"");
            }
        }

        if (PHP_OS_FAMILY != 'Windows') {
            $commands[] = "chmod 755 \"$directory/artisan\"";
        }

        if (($process = $this->runCommands($commands, $input, $output))->isSuccessful()) {
            if ($name !== '.') {
                $this->replaceInFile(
                    'APP_URL=http://localhost',
                    'APP_URL='.$this->generateAppUrl($name),
                    $directory.'/.env'
                );

                $this->replaceInFile(
                    'DB_DATABASE=laravel',
                    'DB_DATABASE='.str_replace('-', '_', strtolower($name)),
                    $directory.'/.env'
                );

                $this->replaceInFile(
                    'DB_DATABASE=laravel',
                    'DB_DATABASE='.str_replace('-', '_', strtolower($name)),
                    $directory.'/.env.example'
                );
            }

            if ($input->getOption('git') || $input->getOption('github') !== false) {
                $this->createRepository($directory, $input, $output);
            }

            if ($installJetstream) {
                $this->installJetstream($directory, $stack, $teams, $input, $output);
            }

            if ($input->getOption('github') !== false) {
                $this->pushToGitHub($name, $directory, $input, $output);
                $output->writeln('');
            }

            $output->writeln('  <bg=blue;fg=white> INFO </> Application ready! <options=bold>Build something amazing.</>'.PHP_EOL);
        }

        return $process->getExitCode();
    }

    /**
     * Install Laravel Jetstream into the application.
     *
     * @param  string  $directory
     * @param  string  $stack
     * @param  bool  $teams
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    protected function installJetstream(string $directory, string $stack, bool $teams, InputInterface $input, OutputInterface $output)
    {
        chdir($directory);

        $commands = array_filter([
            $this->findComposer().' require sikessem/jetstream',
            trim(sprintf(PHP_BINARY.' artisan jetstream:install %s %s', $stack, $teams ? '--teams' : '')),
        ]);

        $this->runCommands($commands, $input, $output);

        $this->commitChanges('Install Jetstream', $directory, $input, $output);
    }

    /**
     * Determine the stack for Jetstream.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return string
     */
    protected function jetstreamStack(InputInterface $input, OutputInterface $output)
    {
        $stacks = [
            'livewire',
            'inertia',
        ];

        if ($input->getOption('stack') && in_array($input->getOption('stack'), $stacks)) {
            return $input->getOption('stack');
        }

        $helper = $this->getHelper('question');

        $question = $this->choose('Which Jetstream stack do you prefer?', $stacks);

        $output->write(PHP_EOL);

        return $helper->ask($input, $this->stylize($input, $output), $question);
    }
}
