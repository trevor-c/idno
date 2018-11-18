<?php

/**
 * Cron functionality.
 *
 * This requires AsynchronousQueue support, and a service installed to process each queue.
 *
 * @package idno
 * @subpackage core
 */

namespace ConsolePlugins\PeriodicExecutionService  {

    class Cron extends \Idno\Common\Component
    {

        /**
         * Most common time periods
         */
        public static $events = [
            'minute' => 60, // 60
            'hourly' => 3600, // 3600
            'daily' => 86400 // 86400
        ];

        function registerEventHooks()
        {

            if (!defined('KNOWN_CONSOLE'))
                return;

            $eventqueue = \Idno\Core\Idno::site()->queue();
            if (!$eventqueue instanceof \Idno\Core\AsynchronousQueue)
                throw new \RuntimeException(\Idno\Core\Idno::site()->language()->_('Sorry, this functionality can not be activated unless you are running with an asynchronous message queue.'));

            foreach (self::$events as $period => $interval) {

                // Register repeat handlers
                \Idno\Core\Idno::site()->addEventHook('cron/' . $period, function (\Idno\Core\Event $event) use ($period) {

                    $eventqueue = \Idno\Core\Idno::site()->queue();

                    try {
                        $eventqueue->enqueue($period, "cron/$period", []);
                    } catch (\Exception $e) {

                        \Idno\Core\Idno::site()->logging()->error($e->getMessage());
                    }
                });

                // Initial enqueue
                try {
                    $eventqueue->enqueue($period, "cron/$period", []);
                } catch (\Exception $e) {

                    \Idno\Core\Idno::site()->logging()->error($e->getMessage());
                }
            }
        }

    }

}
