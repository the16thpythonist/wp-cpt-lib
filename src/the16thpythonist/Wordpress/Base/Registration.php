<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 30.01.19
 * Time: 14:11
 */

namespace the16thpythonist\Wordpress\Base;


/**
 * Interface Registration
 *
 * This will be the base class for all "registrations". Registrations will be classes, which encapsulate the process
 * of registering something within wordpress.
 *
 * CHANGELOG
 *
 * Added 30.01.2019
 *
 * @package the16thpythonist\Wordpress\Base
 */
interface Registration
{
    public function getIdentifier();
    public function register();
}