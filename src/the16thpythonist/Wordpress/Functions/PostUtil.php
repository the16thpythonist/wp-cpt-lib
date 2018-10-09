<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 05.10.18
 * Time: 12:54
 */

namespace the16thpythonist\Wordpress\Functions;

/**
 * Class PostUtil
 *
 * This is a static class, whose methods are utility functions for posts
 *
 * CHANGELOG
 *
 * Added 05.10.2018
 *
 * @since 0.0.0.1
 *
 * @package the16thpythonist\Wordpress\Base
 */
class PostUtil
{
    /**
     * Checks and returns whether a post with the given id exists
     *
     * ! Caution this function really needs the INTEGER of the post id not the string
     *
     * CHANGELOG
     *
     * Added 05.10.2018
     *
     * @since 0.0.0.1
     *
     * @param int $post_id  The id of the post to check
     * @return bool         Whether or not a post with that ID exits
     */
    public static function postExists(int $post_id) {
        /*
         * The "get_post_status" function returns FALSE, if there is not even a post with that ID, if there is a post
         * on the other hand a string will be returned, which describes the status of the post. The string for the post
         * status could either be "public" or "private".
         */
        if (get_post_status($post_id) == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Checks and returns whether the post, identified by the given post id is the same type as the given post type name
     *
     * CHANGELOG
     *
     * Added 05.10.2018
     *
     * @since 0.0.0.1
     *
     * @param int $post_id      The ID of the post in question
     * @param string $post_type The post type to be checked for
     *
     * @return bool             Whether or not the the given post is of the given post type
     */
    public static function postIsType(int $post_id, string $post_type) {
        if (get_post_type($post_id) == $post_type) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Checks and returns whether there exists a meta field with the given key for the post with the given ID
     *
     * This is simply a wrapper around the wordpress native function "metadata_exists", which simplifies one required
     * parameter, by only accepting posts (no users etc)
     *
     * CHANGELOG
     *
     * Added 08.10.2018
     *
     * @since 0.0.0.2
     *
     * @param int $post_id      The ID of the post in question
     * @param string $meta_key  The string key for the meta field to be checked
     *
     * @return bool
     */
    public static function postMetaExists(int $post_id, string $meta_key) {
        return metadata_exists('post', $post_id, $meta_key);
    }
}