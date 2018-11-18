<?php

    /**
     * File picker
     */

    namespace Idno\Pages\File {

        use Idno\Core\Idno;

        class Picker extends \Idno\Common\Page
        {

            function getContent()
            {

                $this->setAsset("image", \Idno\Core\Idno::site()->config()->getDisplayURL() . 'js/image.min.js', 'javascript');
                $this->setAsset("exif-js", \Idno\Core\Idno::site()->config()->getDisplayURL() . 'external/exif-js/exif.min.js', 'javascript');
                
                $template   = 'file/picker/image';
                $t          = \Idno\Core\Idno::site()->template();
                $t->title   = 'Image picker';
                $t->hidenav = true;
                $t->body    = $t->draw($template);
                $t->drawPage();
            }

            function post()
            {
                if (\Idno\Core\Idno::site()->session()->isLoggedOn()) {
                    if (!empty($_FILES['file']['tmp_name'])) {
                        if (!\Idno\Core\Idno::site()->triggerEvent("file/upload", [], true)) {
                            exit;
                        }
                        if (\Idno\Entities\File::isImage($_FILES['file']['tmp_name'])) {
                            $return = false;
                            $file   = false;
                            if ($file = \Idno\Entities\File::createThumbnailFromFile($_FILES['file']['tmp_name'], $_FILES['file']['name'], 1024)) {
                                
                                \Idno\Core\Idno::site()->logging()->debug("Creating new file from thumbnail as {$file}");
                                
                                $return           = true;
                                $returnfile       = new \stdClass;
                                $returnfile->file = ['_id' => $file];
                                $file             = $returnfile;
                            } else if ($file = \Idno\Entities\File::createFromFile($_FILES['file']['tmp_name'], $_FILES['file']['name'], $_FILES['file']['type'], true, true)) {
                                \Idno\Core\Idno::site()->logging()->debug("Creating new file");
                                
                                $return = true;
                            }
                            if ($return) {
                                $t       = \Idno\Core\Idno::site()->template();
                                $t->file = $file;
                                echo $t->draw('file/picker/donejs');
                                exit;
                            }
                        } else {
                            Idno::site()->session()->addErrorMessage("You can only upload images.");
                        }
                    }
                    $this->forward($_SERVER['HTTP_REDIRECT']);
                }
            }

        }

    }