<?php

    /**
     * Handle default annotation
     */

    namespace Idno\Pages\Annotation {

        /**
         * Default class to serve the homepage
         */
        class View extends \Idno\Common\Page
        {

            // Handle GET requests to the entity

            function getContent()
            {
                if (!empty($this->arguments[0])) {
                    $object = \Idno\Common\Entity::getByID($this->arguments[0]);
                    if (empty($object)) {
                        $object = \Idno\Common\Entity::getBySlug($this->arguments[0]);
                    }
                }
                if (empty($object)) {
                    $this->goneContent();
                }

                $this->setOwner($object->getOwner());

                // Specific annotation being requested
                if (!empty($this->arguments[1])) {
                    $permalink  = $object->getUrl() . '/annotations/' . $this->arguments[1];
                    $annotation = $object->getAnnotation($permalink);
                    $subtype    = $object->getAnnotationSubtype($permalink);
                

                    $this->setPermalink(); // This is a permalink
                    $t = \Idno\Core\Idno::site()->template();
                    $t->__(array(

                        'title'       => $object->getTitle(),
                        'body'        => $t->__(array('annotation' => $annotation, 'subtype' => $subtype, 'permalink' => $permalink, 'object' => $object))->draw('entity/annotations/shell'),
                        'description' => $object->getShortDescription()

                    ))->drawPage();
                } else {
                    // List annotations for object
                    
                    $t = \Idno\Core\Idno::site()->template();
                    
                    $annotations = $object->getAllAnnotations();
                    $body = "";
                    $items = [];
                    
                    foreach ($annotations as $subtype => $list) {
                        
                        foreach ($list as $permalink => $annotation) {
                            $body .= $t->__(array('annotation' => $annotation, 'subtype' => $subtype, 'permalink' => $permalink, 'object' => $object))->draw('entity/annotations/shell');
                            unset($t->vars['annotation']);
                            unset($t->vars['annotation_permalink']);
                            unset($t->vars['annotations']);
                            unset($t->vars['action']);
                            unset($t->vars['subtype']);
                            unset($t->vars['permalink']);
                            
                            if ($t->getTemplateType() == 'rss')
                                unset($t->vars['object']);
                            
                            $items[] = $annotation;
                        }
                    }
                    
                    if ($t->getTemplateType() == 'rss')
                        $t->vars['annotations'] = $items;
                   
                    $t->__(array(

                        'title'       => "Annotations on: " .$object->getTitle(),
                        'body'        => $body,
                        'description' => $object->getShortDescription()

                    ))->drawPage();
                    
                }
            }

        }

    }
