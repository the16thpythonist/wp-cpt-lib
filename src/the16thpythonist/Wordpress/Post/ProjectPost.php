<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 04.10.18
 * Time: 11:28
 */

namespace the16thpythonist\Wordpress\Post;

use the16thpythonist\Wordpress\Base\PostRegistration;
use the16thpythonist\Wordpress\Base\PostUtil;
use the16thpythonist\Wordpress\Base\PostPost;

use InvalidArgumentException;

/**
 * Class ProjectPost
 *
 * A Custom Post type wrapper for the "project" post type, which is used to make a post for showcasing a project.
 */
class ProjectPost extends PostPost
{
    /**
     * @var PostRegistration    A static field, which will contain the registration object, that was used to register
     *                          this new post type, after the static "register" method was called on this class.
     */
    public static $REGISTRATION;
    /**
     * @var string              A static field, which will store the string post type name, which was chosen to register
     *                          the post type in wordpress, after the static "register" method was called.
     */
    public static $post_type;

    /**
     * @var int                 The wordpress ID of the post.
     */
    public $id;
    /**
     * @var array|null|\WP_Post The actual wordpress Post object, which is being wrapped by this wrapper
     */
    public $post;
    /**
     * @var string              The string title of the post object
     */
    public $title;
    /**
     * @var string              The string content of the post.
     */
    public $content;
    public $banner;

    /**
     * ProjectPost constructor.
     *
     * CHANGELOG
     *
     * Added 05.10.2018
     *
     * @since 0.0.0.1
     *
     * @throws InvalidArgumentException In case the post, identified by the given post id either doesnt exist or does
     *                                  not have the appropriate post type.
     *
     * @param string $post_id   The wordpress id for the post to be wrapped
     */
    public function __construct(string $post_id)
    {
        // Converting the post id into a int, as the integer version will be needed for some functions (as parameter)
        $this->id = (int) $post_id;

        /*
         * Here we will be checking if a post of that ID exists and if it does not than we will throw appropriate
         * error messages. This will make debugging easier, because the message itself describes the problem pretty
         * well already on this layer.
         */
        $this->checkPost($this->id, self::$post_type);

        $this->post = get_post($this->id);
        $this->title = $this->post->post_title;
        $this->content = $this->post->post_content;
    }

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

        self::$post_type = $post_type;

        self::$REGISTRATION = $registration;
    }
}