<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 07.02.19
 * Time: 11:31
 */

namespace the16thpythonist\Wordpress\Test;

use PHPUnit\Framework\TestCase;

/**
 * Class JWPTestCase
 *
 * This is a custom TestCase, that extends the normal PHPUnit TestCase.
 * It adds additional assertion methods.
 *
 * CHANGELOG
 *
 * Added 07.02.2019
 */
class JWPTestCase extends TestCase
{

    /**
     * This is a custom assertion, that asserts the two given arrays having the same values for the same keys.
     * DOES NOT SUPPORT OBJECTS AT THE MOMENT. Only supports basic built in types like int string etc but also recursive
     * checking for arrays
     *
     * CHANGELOG
     *
     * Added 07.02.2019
     *
     * @param $expected_array
     * @param $array
     */
    public function assertAssocArrayEqualContents($expected_array, $array) {
        $differing_content = '';

        foreach ($expected_array as $expected_key => $expected_value) {
            if (!array_key_exists($expected_key, $array)) {
                // In case the key does not exists, we create string that describes the situation and assign it to
                // 'differing_content' as that will cause the assertion to fail and the string to be displayed
                $differing_content = 'MISSING KEY ' . $expected_key;
                break;
            } else {

                $actual_value = $array[$expected_key];

                // First we are checking if the two values have the same type, because if they dont, we already know
                // that the values are different. Also if we check this now we can assume same type for all further
                // checks down the road.
                $expected_type = gettype($expected_value);
                $actual_type = gettype($actual_value);
                if ($expected_type !== $actual_type) {
                    $differing_content = "DIFFERENT TYPES " . $expected_type . " != " . $actual_type;
                    break;
                }

                // We are checking for an array here, because we would need to treat those differently (namely a
                // recursive call of this very method)
                if (is_array($expected_value)) {
                    $this->assertAssocArrayEqualContents($expected_value, $actual_value);
                } else {

                    // Now we check the actual value
                    if ($expected_value !== $actual_value) {
                        $differing_content = 'DIFFERENT VALUES ' . $expected_value . " != " . $actual_value;
                        break;
                    }
                }
            }
        }

        $this->assertEquals('', $differing_content);
    }
}