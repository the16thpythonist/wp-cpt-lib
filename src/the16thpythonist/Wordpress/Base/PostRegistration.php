<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 04.10.18
 * Time: 15:47
 */

namespace the16thpythonist\Wordpress\Base;

/**
 * Interface PostRegistration
 *
 * A PostRegistration object is supposed to be a object, which is being used for registering a new post type in
 * wordpress. This means the process of mainly the "register_posttype" function of wordpress being called with the
 * specific argument arrays, but could also include the hook in of custom meta boxes or accompanying widgets etc.
 *
 * The arguments for the registration are not being passed to the register method directly, but rather by using the
 * constructor of the individual registration objects.
 *
 * This interface inherits from the "Registration" interface. It is encouraged to implement the "getPostType" behaviour
 * in "getIdentifier" from the "Registration" interface and then just call that in "getPostType"
 *
 * CHANGELOG
 *
 * Added 04.10.2018
 *
 * Changed 30.01.2019
 * The interface now inherits from the more basic interface "Registration", which is for generally registering anything
 * in wordpress not just posts.
 *
 * @since 0.0.0.0
 *
 * @package the16thpythonist\Wordpress\Base
 */
interface PostRegistration
{
    public function getPostType();
    public function register();
}