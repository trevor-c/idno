<?php

namespace Idno\Pages\Account\Export {

    use Idno\Common\Page;
    use Idno\Core\Idno;
    use Idno\Core\Migration;

    class RSS extends Page
    {

        function postContent()
        {

            $this->gatekeeper();

            set_time_limit(0);

            header('Content-type: text/rss');
            header('Content-disposition: attachment; filename=user_export.rss');

            $hide_private = true;
            if ($private = $this->getInput('allposts')) {
                $hide_private = false;
            }

            if ($f = Migration::getExportRSS($hide_private, Idno::site()->session()->currentUserUUID())) {

                $stats = fstat($f);

                header('Content-Length: ' . $stats['size']);

                while ($content = fgets($f)) {
                    echo $content;
                }

                fclose($f);
            }
            exit;

        }

    }

}

