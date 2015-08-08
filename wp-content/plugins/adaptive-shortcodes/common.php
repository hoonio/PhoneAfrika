<?php
class AdapCommon
{
    /**
     * Provides the URL to this plugin's root folder
     * @return mixed
     */
    public static function get_base_url()
    {
        $folder = basename(dirname(__FILE__));
        return plugins_url($folder);
    }

    /**
     * Provides the PATH to the this plugin's root folder
     * @return string
     */
    public static function get_base_path()
    {
        $folder = basename(dirname(__FILE__));
        return WP_PLUGIN_DIR . "/" . $folder;
    }

    public static function ensure_wp_version()
    {
        if (!ADAP_SC_SUPPORTED_WP_VERSION) {
            echo "<div class='error' style='padding:10px;'>" . sprintf(__("Adaptive Shortcodes requires WordPress %s or greater. You must upgrade WordPress in order to use Gravity Forms", 'adap_sc'), ADAP_SC_MIN_WP_VERSION) . "</div>";
            return false;
        }
        return true;
    }
}


if (!function_exists('_log')) {
    function _log($message)
    {
        if (is_array($message) || is_object($message)) {
            error_log(print_r($message, true));
        } else {
            error_log($message);
        }
    }
}
