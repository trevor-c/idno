<?php

namespace Idno\Pages\Admin\Export {

    use Idno\Common\Page;
    use Idno\Core\Migration;

    class RSS extends Page
    {

        function postContent()
        {

            $this->adminGatekeeper();

            set_time_limit(0);

            header('Content-type: text/rss');
            header('Content-disposition: attachment; filename=export.rss');

            $hide_private = true;
            if ($private = $this->getInput('allposts')) {
                $hide_private = false;
            }

            if ($f = Migration::getExportRSS($hide_private)) {

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

