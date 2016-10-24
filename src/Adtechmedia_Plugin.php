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
        return array(//'_version' => array('Installed Version'), // Leave this one commented-out. Uncomment to test upgrades.
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
            "revenue_method" => array(
                __('revenueMethod', 'adtechmedia-plugin'),
                'advertising+micropayments',
                'advertising',
                'micropayments'
            ),
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
            "ads_video" => array(__('Link to video ad', 'adtechmedia-plugin')),
            "content_offset" => array(__('Offset', 'adtechmedia-plugin')),
            "content_lock" => array(
                __('Lock', 'adtechmedia-plugin'),
                'blur+scramble',
                'blur',
                'scramble',
                'keywords',
            ),
            "payment_pledged" => array(__('payment.pledged', 'adtechmedia-plugin')),
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
        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS `$tableName` (
                            `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                            `option_name` VARCHAR(191) NOT NULL DEFAULT '',
                            `option_value` LONGTEXT NOT NULL ,
                            PRIMARY KEY (`id`),
                            UNIQUE INDEX `option_name` (`option_name`)
                        )"
        );
        $tableName = $this->prefixTableName(Adtechmedia_Config::get('plugin_cache_table_name'));
        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS `$tableName` (
                            `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                            `item_id` VARCHAR(191) NOT NULL DEFAULT '',
                            `value` LONGTEXT NOT NULL ,
                            PRIMARY KEY (`id`),
                            UNIQUE INDEX `item_id` (`item_id`)
                        )"
        );
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

    /**
     *
     */
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
            add_action('wp_enqueue_scripts', array(&$this, 'addAdtechmediaScripts'));
        } else {
            add_action('admin_enqueue_scripts', array(&$this, 'addAdtechmediaAdminScripts'));
        }
        add_filter('the_content', array(&$this, 'hideContent'), 99999);//try do this after any other filter
        add_action('save_post', array(&$this, 'clearCacheOnUpdate'));
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

    /**
     *
     */
    public function addAdtechmediaAdminScripts($hook)
    {
        if ($hook != 'plugins_page_' . $this->getSettingsSlug()) {
            return;
        }
        wp_enqueue_style(
            'adtechmedia-style-materialdesignicons',
            plugins_url('/css/materialdesignicons.css', __FILE__)
        );
        wp_enqueue_style('adtechmedia-style-main', plugins_url('/css/main.css', __FILE__));
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('adtechmedia-admin-js',
            plugins_url('/js/main.js', __FILE__),['jquery-ui-tabs']);
        wp_enqueue_script('adtechmedia-tinymce-js','//cdn.tinymce.com/4/tinymce.min.js',['adtechmedia-admin-js']);
    }

    /**
     *
     */
    public function addAdtechmediaScripts()
    {
        if ($script = $this->getPluginOption('BuildPath')) {
            wp_enqueue_script('Adtechmedia', $script, null, null, true);
        }
    }

    /**
     * @param $postId
     */
    public function clearCacheOnUpdate($postId)
    {
        if (wp_is_post_revision($postId)) {
            return;
        }
        Adtechmedia_ContentManager::clearContent($postId);
    }

    /**
     * @param $content
     * @return bool|mixed|null
     */
    public function hideContent($content)
    {

        if (is_single()) {
            $id = (string)get_the_ID();
            $savedContent = Adtechmedia_ContentManager::getContent($id);
            if (isset($savedContent) && !empty($savedContent)) {
                return $this->contentWrapper($savedContent);
            } else {
                Adtechmedia_Request::contentCreate(
                    $id,
                    $this->getPluginOption('id'),
                    $content,
                    $this->getPluginOption('key')
                );
                $newContent = Adtechmedia_Request::contentRetrieve(
                    $id,
                    $this->getPluginOption('id'),
                    $this->getPluginOption('content_lock'),
                    "elements",
                    $this->getPluginOption('selector'),
                    $this->getPluginOption('content_offset'),
                    $this->getPluginOption('key')
                );
                Adtechmedia_ContentManager::setContent($id, $newContent);
                return $this->contentWrapper($newContent);
            }

        }
        return $content;
    }

    /**
     * @param $content
     * @return string
     */
    public function contentWrapper($content)
    {
        $propertyId = $this->getPluginOption('id');
        $contentId = (string)get_the_ID();
        $script = "<script>
                    window.ATM_PROPERTY_ID = '$propertyId'; 
                    window.ATM_CONTENT_ID = '$contentId'; 
                    </script>";
        return "<span id='content-for-atm'>$content</span>" . $script;
    }
}
