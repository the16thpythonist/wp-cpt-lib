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
    /**
     * @var PostRegistration    A static field, which will contain the registration object, that was used to register
     *                          this new post type, after the static "register" method was called on this class.
     */
    public static $REGISTRATION;

    /**
     * Registers the post type in wordpress
     *
     * CHANGELOG
     *
     * Created 04.10.2018
     *
     * @since 0.0.0.0
     *
     * @param string $post_type The name of the post type, which will be used to address the post type from now on
     * @param string $class     The class name of the PostRegistration child class to be executed to register this post
     *                          type
     */
    public static function register(string $post_type, string $class=ProjectPostRegistration::class){
        /** @var PostRegistration $registration */
        $registration = new $class($post_type);
        $registration->register();

        self::$REGISTRATION = $registration;
    }
}