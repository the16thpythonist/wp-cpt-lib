<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 05.10.18
 * Time: 12:54
 */

namespace the16thpythonist\Wordpress\Functions;

/**
 * Class PostUtil
 *
 * This is a static class, whose methods are utility functions for posts
 *
 * CHANGELOG
 *
 * Added 05.10.2018
 *
 * @since 0.0.0.1
 *
 * @package the16thpythonist\Wordpress\Base
 */
class PostUtil
{
    // ****************************
    // WORDPRESS SPECIFIC UTILITIES
    // ****************************

    /**
     * Checks and returns whether a post with the given id exists
     *
     * ! Caution this function really needs the INTEGER of the post id not the string
     *
     * CHANGELOG
     *
     * Added 05.10.2018
     *
     * @since 0.0.0.1
     *
     * @param int $post_id  The id of the post to check
     * @return bool         Whether or not a post with that ID exits
     */
    public static function postExists(int $post_id) {
        /*
         * The "get_post_status" function returns FALSE, if there is not even a post with that ID, if there is a post
         * on the other hand a string will be returned, which describes the status of the post. The string for the post
         * status could either be "public" or "private".
         */
        if (get_post_status($post_id) == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Checks and returns whether the post, identified by the given post id is the same type as the given post type name
     *
     * CHANGELOG
     *
     * Added 05.10.2018
     *
     * @since 0.0.0.1
     *
     * @param int $post_id      The ID of the post in question
     * @param string $post_type The post type to be checked for
     *
     * @return bool             Whether or not the the given post is of the given post type
     */
    public static function postIsType(int $post_id, string $post_type) {
        if (get_post_type($post_id) == $post_type) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Checks and returns whether there exists a meta field with the given key for the post with the given ID
     *
     * This is simply a wrapper around the wordpress native function "metadata_exists", which simplifies one required
     * parameter, by only accepting posts (no users etc)
     *
     * CHANGELOG
     *
     * Added 08.10.2018
     *
     * @since 0.0.0.2
     *
     * @param int $post_id      The ID of the post in question
     * @param string $meta_key  The string key for the meta field to be checked
     *
     * @return bool
     */
    public static function postMetaExists(int $post_id, string $meta_key) {
        return metadata_exists('post', $post_id, $meta_key);
    }

    /**
     * Checks whether or not a post of the given post type is currently being saved
     *
     * This function is supposed to be used inside a 'save_post' filter function. it is advised to use this function
     * instead of writing the if statement by hand, because the statement is not as straight forward as one might think.
     * To avoid errors when calling the "wp_insert_post" function, checking if the _POST array even contains certain
     * keys is necessary first.
     *
     * CHANGELOG
     *
     * Added 20.10.2018
     *
     * Changed 21.10.2018
     * Added the parameter $post_id for the ID of the post, that is being saved. That was necessary to make the function
     * work if the post was saved using the "wp_insert_post" function from the code directly
     *
     * @param string $post_type The post type for which to be checked
     * @param string $post_id   The post id of the post being saved
     * @return bool
     */
    public static function isSavingPostType(string $post_type, $post_id) {

        // There are two possibilities of the "save_post" filter being called:
        // The first is by some user creating a new post on the backend page and then pressing the "publish" button.
        // In this case all information about the post is saved in the $_POST array.
        // The second is calling the function wp_insert_post from the code. In such a case the $_POST array is empty
        // and the post type has to be checked using the actual id of the post and querying the database
        $http_condition = (array_key_exists('post_type', $_POST) && ($_POST['post_type'] == $post_type));
        $insert_condition = ($post_type == get_post_type($post_id));

        return $http_condition || $insert_condition;
    }

    /**
     * Returns the single meta value of a meta field of a post given the meta key string
     *
     * CHANGELOG
     *
     * Added 23.10.2018
     *
     * @param string $post_id
     * @param string $meta_key
     * @return mixed
     */
    public static function loadSinglePostMeta(string $post_id, string $meta_key) {
        return get_post_meta($post_id, $meta_key, true);
    }

    /**
     * Returns the string name of a single taxonomy term, given the ID of the post and the name of the tax.
     *
     * CHANGELOG
     *
     * Added 23.10.2018
     *
     * Changed 28.10.2018
     * In case there is no term to be returned, raises a LengthException
     *
     * @param string $post_id   The ID of the post
     * @param string $taxonomy  The name of the taxonomy
     * @param int $which        The index at which the desired term is. DEFAULT is 0, which is the alphabetically first
     * @return string
     */
    public static function loadSingleTaxonomyString(string $post_id, string $taxonomy, int $which=0) {
        $terms = wp_get_post_terms($post_id, $taxonomy);

        // In case there are no taxonomy terms, we raise an exception
        if (count($terms) == 0) {
            throw new \LengthException(sprintf('The post %s does not have a term from taxonomy %s', $post_id, $taxonomy));
        }

        /** @var \WP_Term $term */
        $term = $terms[$which];
        return $term->name;
    }

    /**
     * Given the ID of a post and the taxonomy name, this will return an array of the name strings of the tax terms
     *
     * CHANGELOG
     *
     * Added 23.10.2018
     *
     * @param string $post_id   The ID of the post
     * @param string $taxonomy  The name of the taxonomy
     * @return array
     */
    public static function loadTaxonomyStrings(string $post_id, string $taxonomy){
        $terms = wp_get_post_terms($post_id, $taxonomy);
        return array_map(function($term) {return $term->name;}, $terms);
    }

    /**
     * Given the ID of a post will return a html <a> string which is the title of the post and links to the
     * page by using the permalink.
     *
     * CHANGELOG
     *
     * Added 20.11.2018
     *
     * @param string $post_id   The ID of the post to be linked to
     * @return string
     */
    public static function getPermalinkHTML(string $post_id) {
        $title = get_the_title($post_id);
        $url = get_the_permalink($post_id);

        return sprintf('<a href="%s">%s</a>', $url, $title);
    }

    /**
     * Returns true when the _GET array contains all the keys given in the params array and false if only a single one
     * is missing.
     *
     * CHANGELOG
     *
     * Added 06.01.2019
     *
     * @param array $params     An array with string key names, which the _GET array has to contain as keys.
     * @return bool
     */
    public static function containsGETParameters(array $params) {
        // This function will evaluate as false if only a single of the required parameters was not passed in the _GET
        // array (URL parameters for AJAX for example)
        foreach ($params as $param) {
            if (!array_key_exists($param, $_GET)) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Returns an array of all the post objects, belonging to the given post type
     *
     * CHANGELOG
     *
     * Added 07.02.2019
     *
     * @param string $post_type
     *
     * @return array
     */
    public static function getAllPostsOfType(string $post_type) {

        $args = array(
            'post_status'       => 'any',
            'posts_per_page'    => -1,
            'post_type'         => $post_type
        );
        // Building the WP_Query object for getting all the posts
        $query = new \WP_Query($args);
        $posts = $query->get_posts();

        return $posts;
    }

    // *********************************
    // UTILITIES FOR HANDLING JAVASCRIPT
    // *********************************

    /**
     * Creates a string, which contains the javascript code for a javascript object, that is based on the key value
     * combinations of the passed associative array.
     * The given array may even contain nested arrays as values, as in this case the function is being called
     * recursively.
     *
     * CHANGELOG
     *
     * Added 05.02.2019
     *
     * Changed 06.02.2019
     * Fixed the operator at the end not working and falsely adding that last comma
     * Fixed the assignment inside the object code from being "=" to ":"
     *
     * @param array $object
     * @return false|string
     */
    public static function javascriptObject(array $object) {
        ob_start();
        $index = 1;
        ?>
        {
            <?php foreach($object as $key => $value): ?>
                <?php if(is_array($value)) {
                    echo $key . ' : ' . self::javascriptObject($value) . ($index === count($object) ? '' : ',');
                } else {
                    echo $key . ' : "' . $value . '"' . ($index === count($object) ? '' : ',');
                }

                // 06.02.2019
                // Obviously we need to increment the index counter here, when it is necessary for the functioning
                $index++;
                ?>
            <?php endforeach; ?>
        }
        <?php
        return ob_get_clean();
    }

    /**
     * Creates a string, which contains javascript code, that assigns a js object based on the key/values of the given
     * associative array "object" to a js variable which is named like the given string "name".
     *
     * CHANGELOG
     *
     * Added 05.02.2019
     *
     * @param string $name
     * @param array $object
     * @return string
     */
    public static function javascriptExposeObject(string $name, array $object) {
        return 'var ' . $name . ' = ' . self::javascriptObject($object) . ';';
    }

    /**
     * Creates a string, which contains the javascript code to create an array of objects based on the given "array"
     * array (which has to be an array of associative arrays, no other values!).
     *
     * CHANGELOG
     *
     * Added 05.02.2019
     *
     * Changed 07.02.2019
     * Added an index counter variable, which gets incremented in the loop, so that after the last array element no
     * additional comma will be added to the code string.
     *
     * @param array $array
     * @return false|string
     */
    public static function javascriptObjectArray(array $array) {
        ob_start();
        $index = 1;
        ?>
        [
            <?php foreach ($array as $object):?>
                <?php echo self::javascriptObject($object) . ($index === count($array) ? '' : ','); $index++;?>
            <?php endforeach; ?>
        ]
        <?php
        return ob_get_clean();
    }

    /**
     * Creates a string, which contains the javascript code to assign an array of objects based on the given "array"
     * parameter (which is supposed to be an array of associative arrays) to a variable with the name given by the
     * string parameter "name"
     *
     * CHANGELOG
     *
     * Added 05.02.2019
     *
     * @param string $name
     * @param array $array
     * @return string
     */
    public static function javascriptExposeObjectArray(string $name, array $array) {
        return 'var ' . $name . ' = ' . self::javascriptObjectArray($array) . ';';
    }

    // *********************
    // UTILITIES FOR STRINGS
    // *********************

    /**
     * Takes the given string strips all the whitespaces and new lines from it and returns the result
     *
     * Added
     *
     * 06.02.2019
     *
     * @param string $string
     * @return string|string[]|null
     */
    public static function stripStringUnnecessary(string $string) {
        $pattern = '/\s*/m';
        $replace = '';

        return preg_replace($pattern, $replace, $string);
    }

    // ********************
    // UTILITIES FOR ARRAYS
    // ********************

    /**
     * The data array is supposed to be an un-nested assoc array. The mapping array defines as its keys the keys of the
     * data array and as the values strings, which are to be mapped as key strings of a new array. Those mappings can
     * also contain a nesting operation 'key1/key2', which means that an additional nested array is to be created as
     * the result.
     *
     * EXAMPLE
     *
     * $data = array('test' => 15);
     * $mapping = array('test' => 'test/nested');
     *
     * The resulting array, which would be returned by this function:
     * $result = array(
     *      'test'  => array(
     *          'nested'    => 15
     *      )
     * );
     * The original array has thus been mapped to a nested structure
     *
     * CHANGELOG
     *
     * Added 06.01.2019
     *
     * @param array $mapping
     * @param array $data
     * @return array
     */
    public static function subArrayMapping(array $mapping, array $data) {
        $result = array();
        foreach ($mapping as $source => $destination) {

            // The nested structure, or any new value to the result array will only be created, when there actually
            // is a value to be copied in the data array.
            if (array_key_exists($source, $data)) {

                // Here we use a loop to create and then go further down the nested array structure, always holding a
                // reference to the current array of nesting as a variable.
                $current_array = &$result;
                $sub_keys = explode('/', $destination);
                $index = 1;
                foreach ($sub_keys as $key) {
                    // If the nested array doesnt already exist, it is being created.
                    if (!array_key_exists($key, $current_array) || !is_array($current_array[$key])) {
                        $current_array[$key] = array();
                    }

                    // In case the current level is indeed the last in line of the nested structure, no new array is
                    // created. Instead a the actual value is being copied into the final array.
                    if ($index === count($sub_keys)) {
                        $current_array[$key] = $data[$source];
                        break;
                    }

                    // In case this ISN'T the last layer, we will just climb one layer deeper and repeat the process.
                    // We can safely assume, that this array exists, because we would have created it even if it didnt
                    // before
                    $current_array = &$current_array[$key];
                    $index ++;
                }
            }
        }
        return $result;
    }
}