<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 05.10.18
 * Time: 13:22
 */

namespace the16thpythonist\Wordpress\Base;

use InvalidArgumentException;
use the16thpythonist\Wordpress\Functions\PostUtil;

/**
 * Class PostPost
 *
 * This abstract base class implements all the methods, that are universal to all(most) possible specific
 * implementations of the post wrapper classes.
 *
 * CHANGELOG
 *
 * Added 05.10.2018
 *
 * @since 0.0.0.1
 *
 * @package the16thpythonist\Wordpress\Base
 */
abstract class PostPost implements PostWrapper
{

    /**
     * Checks if the post exists and if the post type matches the given one. Throws errors if that is not the case
     *
     * CHANGELOG
     *
     * Added 05.10.2018
     *
     * @since 0.0.0.1
     *
     * @param int $post_id      The ID, which identifies the post in question
     * @param string $post_type The post type to be checked for
     */
    protected function checkPost(int $post_id, string $post_type) {
        if (!PostUtil::postExists($post_id)) {
            throw new InvalidArgumentException(sprintf("There is no post with ID %s", $post_id));
        } elseif (!PostUtil::postIsType($post_id, $post_type)) {
            throw new InvalidArgumentException(sprintf(
                "The post '%s' is not of type '%s'",
                $post_id,
                $post_type
            ));
        }
    }
}