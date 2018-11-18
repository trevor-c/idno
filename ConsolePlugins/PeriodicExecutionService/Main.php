<?php

namespace ConsolePlugins\PeriodicExecutionService {

    class Main extends \Idno\Common\ConsolePlugin
    {

        public static $run = true;

        public $cron;

        function registerTranslations()
        {

            \Idno\Core\Idno::site()->language()->register(
                new \Idno\Core\GetTextTranslation(
                    'periodicexecutionservice', dirname(__FILE__) . '/languages/'
                )
            );
        }

        public function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
        {

            define("KNOWN_EVENT_QUEUE_SERVICE", true);

            // Initialise cron
            $this->cron = new Cron();

            // Set up shutdown listener

            pcntl_signal(SIGTERM, function($signo) {
                \Idno\Core\Idno::site()->logging()->debug(\Idno\Core\Idno::site()->language()->_('SIGTERM received, shutting down.'));
                \ConsolePlugins\EventQueueService\Main::$run = false;
                $output->writeln(\Idno\Core\Idno::site()->language()->_('Shutting down, this may take a little while...'));
            });

            $output->writeln('Starting Periodic Execution Service');

            if (!\Idno\Core\Service::isFunctionAvailable('system'))
                throw new \RuntimeException(\Idno\Core\Idno::site()->language()->_('Sorry, your hosting environment does not support functionality (the "system" function) necessary to support this action.'));

            foreach (Cron::$events as $queue => $period) {

                $pid = pcntl_fork();
                if ($pid == -1) {
                     throw new \RuntimeException(\Idno\Core\Idno::site()->language()->_('Could not fork a new process'));
                } else if ($pid) {

                } else {
                    // Child
                    $output->writeln(\Idno\Core\Idno::site()->language()->_('Starting %s queue processor.', [$queue]));

                    try {
                        while (self::$run) {

                            while (self::$run) {

                                $output->writeln(\Idno\Core\Idno::site()->language()->_('Triggering any events on the %s queue...', [$queue]));
                                if ($events = \Idno\Core\Service::call('/service/queue/list/', [
                                    'queue' => $queue
                                ])) {

                                    foreach ($events->queue as $event) {
                                        try {
                                            \Idno\Core\Idno::site()->logging()->info(\Idno\Core\Idno::site()->language()->_('Dispatching event %s', [$event]));
                                            //\Idno\Core\Service::call('/service/queue/dispatch/' . $event);

                                            system(escapeshellcmd("./known.php event-queue-manage $queue dispatch $event"));
                                        } catch (\Exception $ex) {
                                            \Idno\Core\Idno::site()->logging()->error($ex->getMessage());
                                        }
                                    }
                                }

                                sleep($period);
                                \Idno\Core\Service::call('/service/queue/gc/', [
                                    'queue' => $queue
                                ]);
                            }
                        }
                    } catch (\Error $e) {
                        \Idno\Core\Idno::site()->logging()->error($e->getMessage());
                    }
                }

            }

            pcntl_wait($status);

        }

        public function getCommand()
        {
            return 'service-cron';
        }

        public function getDescription()
        {
            return \Idno\Core\Idno::site()->language()->_('Begin the cron service');
        }

        public function getParameters()
        {
            return [
            ];
        }

    }

}
