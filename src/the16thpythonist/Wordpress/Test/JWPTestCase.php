<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 07.02.19
 * Time: 11:31
 */

namespace the16thpythonist\Wordpress\Test;

use PHPUnit\Framework\TestCase;
use the16thpythonist\Wordpress\Functions\PostUtil;
use WP_Post;

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

    // **********
    // ASSERTIONS
    // **********

    // **************************
    // GENERAL UTILITY ASSERTIONS
    // **************************

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
    public function assertAssocArrayContentEquals(array $expected_array, array $array) {
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
                    $this->assertAssocArrayContentEquals($expected_value, $actual_value);
                } else {
                    // var_dump($expected_value . ' ' . $actual_value);
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

    // *****************************
    // WORDPRESS SPECIFIC ASSERTIONS
    // *****************************

    /**
     * Asserts, that the post type, identified by the given string was already registered in the wordpress system.
     *
     * CHANGELOG
     *
     * Added 07.02.2019
     *
     * @param string $post_type
     */
    public function assertPostTypeExists(string $post_type) {
        // We are not just using the "assertTrue" on the "exist" variable here, because this is a custom assertion and
        // just having a "True !== False" is not a good indicator of what is wrong, but in this case the error message
        // is being printed by PHPUnit in case the post type does not exist.
        $exists = post_type_exists($post_type);
        if ($exists) {
            $message = '';
        } else {
            $message = sprintf('POST TYPE %s DOES NOT EXIST', $post_type);
        }
        $this->assertEquals('', $message);
    }

    /**
     * Asserts, that a post with the given wordpress post ID exists
     *
     * CHANGELOG
     *
     * Added 07.02.2019
     *
     * @param $post_id
     */
    public function assertPostExists($post_id) {
        $post = get_post($post_id);
        $this->assertInstanceOf('WP_Post', $post);
    }

    /**
     * Asserts, that a post with the given wordpress post id DOES NOT EXISTS!
     *
     * CHANGELOG
     *
     * Added 07.02.2019
     *
     * @param $post_id
     */
    public function assertPostNotExists($post_id) {
        $post = get_post($post_id);
        $this->assertNotInstanceOf('WP_Post', $post);
    }

    /**
     * Asserts, that ther is AT LEAST 1 post for the given post type
     *
     * CHANGELOG
     *
     * Added 07.02.2019
     *
     * @param string $post_type
     */
    public function assertPostTypePopulated(string $post_type) {
        $posts = PostUtil::getAllPostsOfType($post_type);
        $is_populated = count($posts) >= 1;
        if ($is_populated) {
            $message = '';
        } else {
            $message = sprintf('POST TYPE %s NOT CONTAIN ANY POSTS', $post_type);
        }
        $this->assertEquals('', $message);
    }

    /**
     * Asserts, that there is more than zero posts in the given post type
     *
     * CHANGELOG
     *
     * Added 07.02.2019
     *
     * @param string $post_type
     */
    public function assertPostTypeNotPopulated(string $post_type) {
        $posts = PostUtil::getAllPostsOfType($post_type);
        $post_count = count($posts);
        $is_populated = $post_count >= 1;
        if (!$is_populated) {
            $message = '';
        } else {
            $message = sprintf('POST TYPE %s NOT EMPTY CONTAINS %s', $post_type, $post_count);
        }
        $this->assertEquals('', $message);
    }

}