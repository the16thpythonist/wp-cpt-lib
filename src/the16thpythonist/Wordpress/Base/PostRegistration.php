<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 04.10.18
 * Time: 15:47
 */

namespace the16thpythonist\Wordpress\Base;

interface PostRegistration
{
    public function getPostType();
    public function register();
}