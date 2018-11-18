<?php

namespace Tests\Core {

    class EnglishTest extends \Idno\Core\ArrayKeyTranslation {

        public function getStrings() {
            return [
                'Hello!' => 'Hello!'
            ];
        }

    }

    class FrenchTest extends \Idno\Core\ArrayKeyTranslation {

        public function getStrings() {
            return [
                'Hello!' => 'Bonjour!'
            ];
        }

    }

    class LanguageTest extends \Tests\KnownTestCase {

        public function testLanguageString() {

            $english = new \Idno\Core\Language('en');
            $french = new \Idno\Core\Language('fr');
            
            $english->register(new EnglishTest('en'));
            $english->register(new FrenchTest('fr'));
            
            $french->register(new EnglishTest('en'));
            $french->register(new FrenchTest('fr'));
            
            
            echo "English: " . $english->_('Hello!');
            echo "\nFrench: " . $french->_('Hello!');
            
            $txt = $english->_('Hello!');
            $this->assertFalse(empty($txt));
            $txt2 = $french->_('Hello!');
            $this->assertFalse(empty($txt2));
            $this->assertFalse($french->_('Hello!') == $english->_('Hello!'));
        }

    }

}