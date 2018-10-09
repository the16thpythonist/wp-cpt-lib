<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 08.10.18
 * Time: 09:19
 */

namespace the16thpythonist\Wordpress\Meta;

use the16thpythonist\Wordpress\Base\Metabox;
use the16thpythonist\Wordpress\Functions\PostUtil;


class BasicImageMetabox implements Metabox
{
    const INPUT_KEY_PREFIX = "simple-image-metabox";

    // THESE FIELDS WILL HAVE DATA FROM THE GET GO, AS THEY CONTAIN THE INFORMATION PASSED TO THE CONSTRUCTOR

    public $id;

    public $title;

    public $description;

    /**
     * @var string      Will contain the post meta data key string for the field in which the pure image title will be
     *                  saved
     */
    public $meta_key_title;

    /**
     * @var string      Will contain the post meta data key string for the field in which the actual image url will be
     *                  saved into.
     */
    public $meta_key_url;

    /**
     * @var string      The string unique name of the HTML input element used to get the image title from the user.
     *                  This string will therefore be the key in the $_POST array, once the post is being saved.
     */
    public $input_key;

    // ALL THESE FIELDS WILL ONLY CONTAIN DATA AFTER THE LOAD METHOD WAS CALLED

    public $image_title;

    public $image_url;


    public function __construct(
        string $id,
        string $title,
        string $description,
        string $meta_key_title,
        string $meta_key_url)
    {
        // Just saving all the data passed to the constructor to their own property fields
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->meta_key_title = $meta_key_title;
        $this->meta_key_url = $meta_key_url;

        /*
         * The name of the HTML input element needs to be unique, but it could be possible, that any metabox is used
         * multiple times with a single post type, so additional to the constant name specific to the metabox class this
         * name is being extended by the given, specific id.
         */
        $this->input_key = self::INPUT_KEY_PREFIX . '-' . $this->id;
    }

    public function register()
    {
        add_meta_box(
            $this->id,
            $this->title,
            array($this, "display")
        );
    }

    public function display($post)
    {
        $this->load($post);

        $this->displayHeader($post);
        $this->displayInput($post);
        $this->displayImage($post);
        $this->displayFooter($post);
    }

    /**
     * Echos the HTML for displaying the title of the
     *
     * @param $post
     */
    private function displayHeader($post) {
        ?>
        <div class="image-metabox-wrapper">
            <p class="image-metabox-description">
                <?php echo $this->description; ?>
            </p>

        <?php
    }

    private function displayInput($post) {
        ?>
        <div class="metabox-input">
            <p>The title: </p>
            <input type="text" title="<?php echo $this->input_key; ?>" name="<?echo $this->input_key; ?>" value="<?php echo ($this->image_title ? $this->image_title : '') ?>">
        </div>
        <?php
    }

    private function displayImage($post) {
        ?>
        <div class="image-metabox-image-container">
            <img src="">
        </div>
        <?php
    }

    private function displayFooter($post) {
        ?>
        </div>
        <?php
    }

    /**
     *
     *
     * @param \WP_Post $post
     *
     * @return void
     */
    public function load($post)
    {
        // The title of the image, if exists
        $exists = PostUtil::postMetaExists($post->ID, $this->meta_key_title);
        $this->image_title = ($exists ? get_post_meta($post->ID, $this->meta_key_title, true) : NULL);

        // The url of the image, if exists
        $exists = PostUtil::postMetaExists($post->ID, $this->meta_key_url);
        $this->image_url = ($exists ? get_post_meta($post->ID, $this->meta_key_url, true) : NULL);
    }

    public function save($post_id)
    {
        // TODO: Implement save() method.
    }
}