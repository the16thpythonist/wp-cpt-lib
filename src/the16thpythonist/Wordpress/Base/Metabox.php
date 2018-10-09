<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 08.10.18
 * Time: 09:07
 */

namespace the16thpythonist\Wordpress\Base;

/**
 * Interface Metabox
 *
 * The Interface for creating new MetaBox objects
 *
 * CHANGELOG
 *
 * Added 08.20.2018
 *
 * @since 0.0.0.2
 *
 * @package the16thpythonist\Wordpress\Base
 */
interface Metabox
{
    /**
     * This function will be called to register the meta box in wordpress.
     *
     * CHANGELOG
     *
     * Added 08.10.2018
     *
     * @since 0.0.0.2
     *
     * @return mixed
     */
    public function register();

    /**
     * This function will have to ECHO the whole html, which actually makes up the meta box
     *
     * CHANGELOG
     *
     * Added 08.10.2018
     *
     * @since 0.0.0.2
     *
     * @param \WP_Post $post    The post object of the post at whose edit page the meta box is being displayed
     * @return mixed            Nothing. The html has to be echoed
     */
    public function display($post);

    /**
     * This function is responsible for saving any data the meta box needs into new custom meta fields of the post.
     * This function is triggered, when the post/update button is pressed in the backend
     *
     * Possible data from input fields can be found in the $_POST array with their respective names
     *
     * CHANGELOG
     *
     * Added 08.10.2018
     *
     * @since 0.0.0.2
     *
     * @param string|int $post_id   The ID of the post, which is being saved
     *
     * @return mixed
     */
    public function save($post_id);

    /**
     * This function CAN be called in the "display" function. If the meta box relies on displaying data from custom
     * meta fields of the post, this function is responsible for loading those
     *
     * CHANGELOG
     *
     * Added 08.10.2018
     *
     * @since 0.0.0.2
     *
     * @param \WP_Post $post    The post object of the post at whose edit page the meta box is being displayed
     * @return mixed
     */
    public function load($post);
}