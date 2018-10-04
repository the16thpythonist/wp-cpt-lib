<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 04.10.18
 * Time: 11:28
 */

namespace the16thpythonist\Wordpress\Post;

use the16thpythonist\Wordpress\Base\PostRegistration;

/**
 * Class ProjectPost
 *
 * A Custom Post type wrapper for the "project" post type, which is used to make a post for showcasing a project.
 */
class ProjectPost
{
    public static $REGISTRATION;

    public static function register(string $post_type, string $class=ProjectPostRegistration::class){
        /** @var PostRegistration $registration */
        $registration = new $class($post_type);
        $registration->register();

        self::$REGISTRATION = $registration;
    }
}