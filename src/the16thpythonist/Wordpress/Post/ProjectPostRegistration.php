<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 04.10.18
 * Time: 11:30
 */

namespace the16thpythonist\Wordpress\Post;

use the16thpythonist\Wordpress\Base\PostRegistration;

class ProjectPostRegistration implements PostRegistration
{
    public $post_type;

    public $label;
    public $description;

    public function __construct(string $post_type,
                                string $label='Project',
                                string $description='This post type represents a post to present some form of project')
    {
        $this->label = $label;
        $this->post_type = $post_type;
    }

    public function getPostType()
    {
        return $this->post_type;
    }

    public function register() {
        add_action('init', array($this, 'registerPostType'));
    }

    public function registerPostType() {
        $args = array(
            'label'                 => $this->label,
            'description'           => $this->description,
            'public'                => true,
            'publicly_queryable'    => true,
            'exclude_from_search'   => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 10,
            'menu_icon'             => 'dashicons-hammer',
            'has_archive'           => false,
            'map_meta_cap'          => true,
        );
        register_post_type(
            $this->post_type,
            $args
        );
    }


}