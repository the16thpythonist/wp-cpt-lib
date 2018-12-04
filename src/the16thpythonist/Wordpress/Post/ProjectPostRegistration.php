<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 04.10.18
 * Time: 11:30
 */

namespace the16thpythonist\Wordpress\Post;

use the16thpythonist\Wordpress\Base\PostRegistration;
use the16thpythonist\Wordpress\Meta\BasicImageMetabox;


/**
 * Class ProjectPostRegistration
 *
 * CHANGELOG
 *
 * Added 04.10.2018
 *
 * @since 0.0.0.0
 *
 * @package the16thpythonist\Wordpress\Post
 */
class ProjectPostRegistration implements PostRegistration
{
    /**
     * @var string  The string name under which the post type will be registered and from now on be addressed by in the
     *              wordpress system.
     */
    public $post_type;

    /**
     * @var string  The string name of the post type, displayed to the used, for example in the wordpress admin area.
     */
    public $label;
    /**
     * @var string  The description of the post type, showed to the user.
     */
    public $description;

    public $image_metabox;

    /**
     * ProjectPostRegistration constructor.
     *
     * CHANGELOG
     *
     * Added 04.10.2018
     *
     * @param string $post_type     The name of the post type to be used in wordpress internally
     * @param string $label         The label to be used. This is the string showed to the user in the admin area,
     *                              whenever the post type is addressed.
     * @param string $description   The description which is showed to the user in the admin area.
     */
    public function __construct(string $post_type,
                                string $label='Project',
                                string $description='This post type represents a post to present some form of project')
    {
        $this->label = $label;
        $this->post_type = $post_type;
    }

    /**
     * Returns the string name of the post type, which is used in wordpress internally
     *
     * CHANGELOG
     *
     * Added 04.10.2018
     *
     * @since 0.0.0.0
     *
     * @return string
     */
    public function getPostType()
    {
        return $this->post_type;
    }

    /**
     * Calls the functions to actually hook in the callback methods of this class to the wordpress action hooks
     *
     * CHANGELOG
     *
     * Added 04.10.2018
     *
     * @since 0.0.0.0
     */
    public function register() {
        add_action('init', array($this, 'registerPostType'));

        $this->registerImageMetabox();
    }

    public function registerImageMetabox() {
        $this->image_metabox = new BasicImageMetabox(
            'project-thumbnail',
            'Project Thumbnail',
            'Please select an image from the media library to be used as the Thumbnail of this post.',
            'thumbnail_title',
            'thumbnail_url'
        );
        $this->image_metabox->register();
    }

    /**
     * Actually calls the "register_post" function of wordpress with the appropriate argument array
     *
     * CHANGELOG
     *
     * Added 04.10.2018
     *
     * @since 0.0.0.0
     */
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
            'has_archive'           => true,
            'map_meta_cap'          => true,
            'taxonomies'            => array(
                'category',
                'post_tag'
            )
        );
        register_post_type(
            $this->post_type,
            $args
        );
    }


}