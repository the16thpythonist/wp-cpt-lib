<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 30.01.19
 * Time: 14:18
 */

namespace the16thpythonist\Wordpress\Base;

/**
 * Interface OptionPageRegistration
 *
 * This interface is for objects used to register option pages within wordpress.
 * Since the registration of an option page also requires a callback for the actual html code. This will be implemented
 * in "OptionPageRegistrations" as well, thus the "display" method. Whether the HTML is then directly written into the
 * "display" method or just the
 *
 * CHANGELOG
 *
 * Added 30.01.2019
 *
 * @package the16thpythonist\Wordpress\Base
 */
interface OptionPageRegistration extends Registration
{
    public function getIdentifier();
    public function register();
    public function display();
}