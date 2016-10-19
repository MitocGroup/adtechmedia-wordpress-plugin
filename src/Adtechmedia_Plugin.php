<?php


include_once('Adtechmedia_LifeCycle.php');

class Adtechmedia_Plugin extends Adtechmedia_LifeCycle
{

    /**
     * See: http://plugin.michael-simpson.com/?page_id=31
     * @return array of option meta data.
     */
    public function getOptionMetaData()
    {
        //  http://plugin.michael-simpson.com/?page_id=31
        return array(
            //'_version' => array('Installed Version'), // Leave this one commented-out. Uncomment to test upgrades.
        );
    }
    public function getMainData()
    {
        return array(
            'key' => array(__('Key', 'adtechmedia-plugin')),
            'BuildPath' => array(__('BuildPath', 'adtechmediaplugin')),
            'Id' => array(__('Id', 'adtechmedia-plugin')),
            "website_domain_name" => array(__('website_domain_name', 'adtechmedia-plugin')),
            "website_url" => array(__('website_url', 'adtechmedia-plugin')),
            "support_email" => array(__('support_email', 'adtechmedia-plugin')),
            "country" => array(__('country', 'adtechmedia-plugin')),
            
        );
    }
    public function getPluginMetaData()
    {
        return array(
            "container" => array(__('Article container', 'adtechmedia-plugin')),
            "selector" => array(__('Article selector', 'adtechmedia-plugin')),
            "price" => array(__('Price', 'adtechmedia-plugin')),
            "author_name" => array(__('Author name', 'adtechmedia-plugin')),
            "author_avatar" => array(__('Author avatar', 'adtechmedia-plugin')),
            "ads_video" => array(__('Ads video', 'adtechmedia-plugin')),
            
            /*'ATextInput' => array(__('Enter in some text', 'my-awesome-plugin')),
            'AmAwesome' => array(__('I like this awesome plugin', 'my-awesome-plugin'), 'false', 'true'),
            'CanDoSomething' => array(__('Which user role can do something', 'my-awesome-plugin'),
                                        'Administrator', 'Editor', 'Author', 'Contributor', 'Subscriber', 'Anyone')*/
        );
    }
//    protected function getOptionValueI18nString($optionValue) {
//        $i18nValue = parent::getOptionValueI18nString($optionValue);
//        return $i18nValue;
//    }

    protected function initOptions()
    {

        $options = $this->getOptionMetaData();
        if (!empty($options)) {
            foreach ($options as $key => $arr) {
                if (is_array($arr) && count($arr > 1)) {
                    $this->addOption($key, $arr[1]);
                }
            }
        }

    }


    public function getPluginDisplayName()
    {
        return 'Adtechmedia';
    }

    protected function getMainPluginFileName()
    {
        return 'adtechmedia.php';
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Called by install() to create any database tables if needed.
     * Best Practice:
     * (1) Prefix all table names with $wpdb->prefix
     * (2) make table names lower case only
     * @return void
     */
    protected function installDatabaseTables()
    {
                global $wpdb;
                $tableName = $this->prefixTableName(Adtechmedia_Config::get('plugin_table_name'));
                $wpdb->query("CREATE TABLE IF NOT EXISTS `$tableName` (
                            `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                            `option_name` VARCHAR(191) NOT NULL DEFAULT '',
                            `option_value` LONGTEXT NOT NULL ,
                            PRIMARY KEY (`id`),
                            UNIQUE INDEX `option_name` (`option_name`)
                        )");
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Drop plugin-created tables on uninstall.
     * @return void
     */
    protected function unInstallDatabaseTables()
    {
        //        global $wpdb;
        //        $tableName = $this->prefixTableName('mytable');
        //        $wpdb->query("DROP TABLE IF EXISTS `$tableName`");
    }


    /**
     * Perform actions when upgrading from version X to version Y
     * See: http://plugin.michael-simpson.com/?page_id=35
     * @return void
     */
    public function upgrade()
    {
    }

    public function addActionsAndFilters()
    {

        // Add options administration page
        // http://plugin.michael-simpson.com/?page_id=47
        add_action('admin_menu', array(&$this, 'addSettingsSubMenuPage'));

        // Example adding a script & style just for the options administration page
        // http://plugin.michael-simpson.com/?page_id=47
        //        if (strpos($_SERVER['REQUEST_URI'], $this->getSettingsSlug()) !== false) {
        //            wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));
        //            wp_enqueue_style('my-style', plugins_url('/css/my-style.css', __FILE__));
        //        }


        // Add Actions & Filters
        // http://plugin.michael-simpson.com/?page_id=37

        if (!is_admin()) {
            if ($script = $this->getPluginOption('BuildPath')) {
                wp_enqueue_script('Adtechmedia', $script, null, null, true);
                /*wp_localize_script(
                    'Adtechmedia',
                    'window',
                    [
                        'ATM_DOMAIN' => 'adtechmedia.loc', // e.g.  www.nytimes.com
                        'ATM_CONTENT_ID' => 'post-1267', // article id
                    ]
                );*/

            }
        }

        // Adding scripts & styles to all pages
        // Examples:
        //        wp_enqueue_script('jquery');
        //        wp_enqueue_style('my-style', plugins_url('/css/my-style.css', __FILE__));
        //        wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));


        // Register short codes
        // http://plugin.michael-simpson.com/?page_id=39


        // Register AJAX hooks
        // http://plugin.michael-simpson.com/?page_id=41

    }

}
