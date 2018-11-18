<?php

    /**
     * Content announcement (via webmention) class
     *
     * @package idno
     * @subpackage core
     */

    namespace Idno\Core {

        class Webmention extends \Idno\Common\Component
        {

            private static $mentionClient = false;

            /**
             * Get the MentionClient singleton (initializes on first use).
             * @return \Idno\Core\MentionClient
             */
            private static function mentionClient()
            {
                if (!self::$mentionClient) {
                    self::$mentionClient = new \Idno\Core\MentionClient();

                    if (!empty(\Idno\Core\Idno::site()->config()->proxy_string)) {
                        self::$mentionClient->setProxy(\Idno\Core\Idno::site()->config()->proxy_string);
                    }
                }

                return self::$mentionClient;
            }

            /**
             * Pings mentions from a given page to any linked pages
             * @param $pageURL Page URL
             * @param string $text The text to mine for links
             * @return int The number of pings that were sent out
             */
            static function pingMentions($pageURL, $text)
            {
                // There's no point in sending webmentions to private resources
                if (!Idno::site()->config()->isPublicSite()) {
                    return false;
                }

                if ($current_page = \Idno\Core\Idno::site()->currentPage()) {
                    if ($nowebmention = $current_page->getInput('nomention') || defined('KNOWN_NOMENTION')) {
                        return true;
                    }
                }

                return self::mentionClient()->sendMentions($pageURL, $text);
            }

            /**
             * Send a webmention payload to a target without parsing HTML
             *
             * @param $sourceURL
             * @param $targetURL
             * @return bool
             */
            static function sendWebmentionPayload($sourceURL, $targetURL)
            {
                return self::mentionClient()->sendFirstSupportedMention($sourceURL, $targetURL);
            }

            /**
             * Does the supplied page support webmentions?
             * @param $pageURL
             * @param bool $sourceBody
             * @return mixed
             */
            static function supportsMentions($pageURL, $sourceBody = false)
            {
                // TODO check pingback here too?
                return self::mentionClient()->discoverWebmentionEndpoint($pageURL);
            }

            /**
             * Given an array of URLs (or an empty array) and a target URL to check,
             * adds and rel="syndication" URLs in the target to the array
             * @param $url
             * @param array $inreplyto
             * @param array $response (optional) response from fetching $url
             * @return array
             */
            static function addSyndicatedReplyTargets($url, $inreplyto = array(), $response = false)
            {
                $inreplyto = (array) $inreplyto;

                if (!$response) {
                    $response = \Idno\Core\Webservice::get($url);
                }

                if ($response && $response['response'] >= 200 && $response['response'] < 300) {
                    if ($mf2 = self::parseContent($response['content'], $url)) {
                        // first check rel-syndication
                        if (!empty($mf2['rels']['syndication'])) {
                            if (is_array($mf2['rels']['syndication'])) {
                                foreach ($mf2['rels']['syndication'] as $syndication) {
                                    if (!in_array($syndication, $inreplyto) && !empty($syndication)) {
                                        $inreplyto[] = $syndication;
                                    }
                                }
                            }
                        }

                        // then look for u-syndication
                        if ($entry = self::findRepresentativeHEntry($mf2, $url, ['h-entry', 'h-event'])) {
                            if (!empty($entry['properties']['syndication'])) {
                                foreach ($entry['properties']['syndication'] as $syndication) {
                                    if (!in_array($syndication, $inreplyto) && is_string($syndication)) {
                                        $inreplyto[] = $syndication;
                                    }
                                }
                            }
                        }
                    }
                }

                return $inreplyto;
            }

            /**
             * Parses a given set of HTML for Microformats 2 content
             * @param $content HTML to parse
             * @param $url Optionally, the source URL of the content, so relative URLs can be parsed into absolute ones
             * @return array
             */
            static function parseContent($content, $url = null)
            {
                $parser = new \Mf2\Parser($content, $url);
                try {
                    $return = $parser->parse();
                } catch (\Exception $e) {
                    $return = false;
                }

                return $return;
            }

            /**
             * Given a microformats document, find the "primary" item of a given type or types.
             * Primary means either a) it is the only item of that type at the top level,
             * or b) it is the first item that has the current page as its u-url
             * @param array $mf2 parsed mf2 document
             * @param string $url the source url of the document
             * @param array or string $types the type or types of an item to consider
             * @return the parsed mf2 item, or false
             */
            static function findRepresentativeHEntry($mf2, $url, $types=['h-entry'])
            {
                $types = (array) $types;

                $items = [];
                foreach ($mf2['items'] as $item) {
                    foreach ($types as $type) {
                        if (isset($item['type']) && in_array($type, $item['type'])) {
                            $items[] = $item;
                            break;
                        }
                    }
                }

                // if there is only one h-entry on the page, then it's primary
                if (count($items) == 1) {
                    return $items[0];
                }

                // if there are more items, then looks like a feed, so we'll ignore it
                // ... unless one of the entry's "url" values is the current page
                if (count($items) > 1) {
                    foreach ($items as $item) {
                        if (!empty($item['properties']['url']) && in_array($url, $item['properties']['url'])) {
                            return $item;
                        }
                    }
                }

                return false;
            }

            /**
             * Given a mf2 entry, try to find its author h-card. First check its "author"
             * property. Then check the top-level h-cards. If there is one and only one, return it.
             * @param array $mf2 the full parsed mf2 document
             * @param string $url the url of the document
             * @param array $item the mf2 item in question
             * @return array|false an h-card representing the author of this document
             */
            static function findAuthorHCard($mf2, $url, $item)
            {
                if ($item && isset($item['properties']['author'])) {
                    // look for an author h-card
                    foreach ($item['properties']['author'] as $author) {
                        if (is_array($author) && isset($author['type']) && in_array('h-card', $author['type'])) {
                            return $author;
                        }
                    }
                }

                // fallback to top-level hcard if there is 1 and only 1
                // TODO follow http://indiewebcamp.com/authorship
                $hcards = [];
                foreach ($mf2['items'] as $item) {
                    if (isset($item['type']) && in_array('h-card', $item['type'])) {
                        $hcards[] = $item;
                    }
                }

                if (count($hcards) === 1) {
                    return $hcards[0];
                }

                if ($item && isset($item['properties']['author'])) {
                    // look for an author name or url
                    foreach ($item['properties']['author'] as $author) {
                        if (is_string($author)) {
                            if (filter_var($author, FILTER_VALIDATE_URL)) {
                                return ['type'       => ['h-card'],
                                        'properties' => ['url' => [$author]]];
                            } else {
                                return ['type'       => ['h-card'],
                                        'properties' => ['name' => [$author]]];
                            }
                        }
                    }
                }

                return false;
            }

            /**
             * Given a source and HTML content, return the value of the <title> tag
             * @param string $source_content the fetched HTML content
             * @param string $source url for the source
             * @return string title of the document or its url if no title is found
             */
            static function getTitleFromContent($source_content, $source)
            {
                try {
                    $dom = new \DOMDocument();
                    $dom->loadHTML($source_content);
                    $xpath = new \DOMXPath($dom);
                    foreach ($xpath->query('//title') as $element) {
                        return $element->textContent;
                    }
                } catch (\Exception $e) {
                    // Do nothing
                }
                return $source; // url is the best we can do
            }

            /**
             * Given content, returns the type of action you can respond with
             * @param $content
             * @return string
             */
            static function getActionTypeFromHTML($content)
            {
                $share_type = 'comment';
                if ($mf2 = \Idno\Core\Webmention::parseContent($content['content'])) {
                    if (!empty($mf2['items'])) {
                        foreach ($mf2['items'] as $item) {
                            if (!empty($item['type'])) {
                                if (in_array('h-entry', $item['type'])) {
                                    $share_type = 'reply';
                                }
                                if (in_array('h-event', $item['type'])) {
                                    $share_type = 'rsvp';
                                }
                            }
                        }
                    }
                }

                return $share_type;
            }

            /**
             * Given a URL, returns a user icon (or false)
             * @param $url
             * @return bool|string
             */
            static function getIconFromURL($url)
            {
                if ($content = Webservice::get($url)) {
                    return self::getIconFromWebsiteContent($content['content'], $url);
                }

                return false;
            }

            /**
             * Retrieve a user's icon from a given homepage
             * @param $content The content of the page
             * @param $url The URL of the page
             * @return $icon_url
             */
            static function getIconFromWebsiteContent($content, $url)
            {
                if ($mf2 = self::parseContent($content, $url)) {
                    $mf2 = (array)$mf2;
                    foreach ($mf2['items'] as $item) {

                        // Figure out what kind of Microformats 2 item we have
                        if (!empty($item['type']) && is_array($item['type'])) {
                            foreach ($item['type'] as $type) {

                                switch ($type) {
                                    case 'h-card':
                                        if (!empty($item['properties'])) {
                                            if (!empty($item['properties']['name'])) $mentions['owner']['name'] = $item['properties']['name'][0];
                                            if (!empty($item['properties']['url'])) $mentions['owner']['url'] = $item['properties']['url'][0];
                                            if (!empty($item['properties']['photo'])) {
                                                
                                                return \Idno\Core\Idno::site()->template()->getProxiedImageUrl($item['properties']['photo'][0], 300, 'square');
                                                
                                            }
                                        }
                                        break;
                                }

                            }
                        }

                    }
                }

                return false;
            }

            function init()
            {
            }

            function registerPages()
            {
                \Idno\Core\Idno::site()->addPageHandler('/webmention/?', '\Idno\Pages\Webmentions\Endpoint', true);
            }

            function registerEventHooks()
            {

                // Add webmention headers to the top of the page
                Idno::site()->addEventHook('page/head', function (Event $event) {
                    if (!empty(site()->config()->hub)) {
                        $eventdata = $event->data();
                        header('Link: <' . \Idno\Core\Idno::site()->config()->getURL() . 'webmention/>; rel="http://webmention.org/"', false);
                        header('Link: <' . \Idno\Core\Idno::site()->config()->getURL() . 'webmention/>; rel="webmention"', false);
                    }
                });

                Idno::site()->addEventHook('webmention/sendall', function (Event $event) {
                    $data = $event->data();
                    $result = self::pingMentions($data['source'], $data['text']);
                    $event->setResponse($result);
                });

                Idno::site()->addEventHook('webmention/send', function (Event $event) {
                    $data = $event->data();
                    $result = self::sendWebmentionPayload($data['source'], $data['target']);
                    $event->setResponse($result);
                });

            }

        }

    }
