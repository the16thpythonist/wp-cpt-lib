<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 06.02.19
 * Time: 17:15
 */

use PHPUnit\Framework\TestCase;

use the16thpythonist\Wordpress\Functions\PostUtil;

class PostUtilTest extends TestCase
{

    public function testTestsAreActuallyExecuted() {
        $this->assertTrue(true);
    }

    // ****************************
    // TESTING THE STRING UTILITIES
    // ****************************

    public function testStripStringOfAllWhitespaceAndNewlines() {
        $string = "Hello this is a string\r\n\r\n with newline\r\n and \r\nwhitespace";
        $expected_string = "Hellothisisastringwithnewlineandwhitespace";

        $resulting_string = PostUtil::stripStringUnnecessary($string);

        $this->assertEquals($expected_string, $resulting_string);
    }

    // ********************************
    // TESTING THE JAVASCRIPT UTILITIES
    // ********************************

    /**
     * This is a helper function, specifically for this section. It takes two strings, containing created javascript
     * code and checks if they both contain the same content, given, that all whitespaces and all new lines are being
     * stripped away.
     * This is of course not the optimal way to do it, but in most cases the javascript is agnostic to whitespaces
     *
     * CHANGELOG
     *
     * Added 06.02.2019
     *
     * @param string $expected_string
     * @param string $resulting_string
     */
    public function assertJavascriptCodeEqualsStripped(string $expected_string, string $resulting_string) {
        // Stripping both the expected string and the actual string of all the whitespaces and the new lines, because
        // they are not important to javascript in most scenarios.
        $expected_string_stripped = PostUtil::stripStringUnnecessary($expected_string);
        $resulting_string_stripped = PostUtil::stripStringUnnecessary($resulting_string);

        $this->assertEquals($expected_string_stripped, $resulting_string_stripped);
    }

    public function testCreateSimpleJavascriptObjectCode() {
        $object = array(
            'name'      => 'KIT',
            'city'      => 'Karlsruhe',
            'number'    => 2
        );
        // Javascript is agnostic to indent and additional usage of whitespaces, that is why we can just compare the
        // stripped version of the creates string for correctness.
        $expected_string = '{name:"KIT",city:"Karlsruhe",number:"2"}';
        $resulting_string = PostUtil::javascriptObject($object);

        $this->assertJavascriptCodeEqualsStripped($expected_string, $resulting_string);
    }

    public function testCreateNestedJavascriptObjectCode() {
        $object = array(
            'name'      => 'KIT',
            'info'      => array(
                'city'      => 'Karlsruhe',
                'number'    => array(
                    'is'        => 2
                )
            )
        );
        $expected_string = '{name: "KIT", info: {city: "Karlsruhe", number: {is: "2"}}}';
        $resulting_string = PostUtil::javascriptObject($object);

        $this->assertJavascriptCodeEqualsStripped($expected_string, $resulting_string);
    }

    public function testCreateJavascriptObjectExposingCode() {
        $object = array(
            'name'      => 'KIT',
            'number'    => 2
        );
        $object_name = "info";

        $expected_string = 'var info = {name: "KIT", number: "2"};';
        $resulting_string = PostUtil::javascriptExposeObject($object_name, $object);

        $this->assertJavascriptCodeEqualsStripped($expected_string, $resulting_string);
    }

    public function testCreateJavascriptObjectArrayCode() {
        $array = array(
            array(
                'name'  => 'KIT'
            ),
            array(
                'city'  => 'Karlsruhe'
            )
        );
        $expected_string = '[{name: "KIT"}, {city: "Karlsruhe"}]';
        $resulting_string = PostUtil::javascriptObjectArray($array);

        $this->assertJavascriptCodeEqualsStripped($expected_string, $resulting_string);
    }
}