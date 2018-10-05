<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 05.10.18
 * Time: 13:22
 */

namespace the16thpythonist\Wordpress\Base;

/**
 * Interface PostWrapper
 *
 * CHANGELOG
 *
 * Added 05.10.2018
 *
 * @since 0.0.0.1
 *
 * @package the16thpythonist\Wordpress\Base
 */
interface PostWrapper
{
    public static function register(string $post_type, string $class);
}