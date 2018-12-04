<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 20.10.18
 * Time: 15:27
 */

namespace the16thpythonist\Wordpress\Base;

/**
 * Interface Shortcode
 *
 * The interface for shortcode objects.
 *
 * One thing to note here is that unlike with the "PostWrapper" interface, here the "register" method is NOT static,
 * which means that a object has to be created first to call the register method.
 * In the PostWrapper interface this behaviour was deemed unidiomatic as the post wrapper objects were supposed to be
 * created only when a representation of a specific Post was needed and thus the registration was a concern of the
 * class as a whole. So why is that not the case here?
 *
 * With a shortcode, the actual instance of this class has no purpose. There is no situation in which a shortcode
 * object would be needed in the code. A shortcode is more of a general construct, thus this class will be representing
 * something more like "ShortcodeRegistration" because it is way more comparable with the "PostRegistration" interface
 * than with "PostWrapper", in the sense, that a PostRegistration is also more of a mental construct.
 *
 * This design choice was made, to reduce the amount of different classes, although sacrificing unity of interfacing.
 *
 * CHANGELOG
 *
 * Added 20.10.2018
 *
 * @since 0.0.0.1
 *
 * @package the16thpythonist\Wordpress\Base
 */
interface Shortcode
{
    // This function will have to return the name of the shortcode, as it would be used by a user
    public function getName();

    // This function will have to register the shortcode in wordpress
    public function register();

    // This function will have to echo the actual html code
    public function display();
}