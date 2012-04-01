<?php

final class Wordefinery_LiveinternetCounter {

    const VERSION = '0.8.9';
    const DB = false;
    private $path = '';
    private $_is_counter = 0;

    private $size_idx  = array(1=>'88x31', 2=>'88x15', 3=>'31x31', 4=>'88x120');
    private $style_idx = array(1=>array(52, 53, 54, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 57, 58),
                               2=>array(23, 24, 25, 26),
                               3=>array(38, 39, 40, 41, 42, 43, 44, 45, 50),
                               4=>array(27, 28, 29));
    private $color_idx = array(1=>18, 2=>18, 3=>18, 4=>20);

    function __construct($path) {
        $this->path = $path;

        $this->plugin_title = wr___('Wordefinery LiveInternet Counter');
        $this->plugin_slug = 'wordefinery-liveinternetcounter';

        if (!Wordefinery::Requires($this->plugin_title, 'wordpress28', true)) return;

        $this->store = Wordefinery_Settings::bind(array('wordefinery', $this->plugin_slug));

        $this->store->defvalue(array(
            'size'      => key($this->size_idx),
            'style'     => current($this->style_idx[key($this->size_idx)]),
            'color'     => 1,
            'align'     => 'center',
            'mode'      => 'widget',
            'page_title ' => '0',
        ));

        list($this->store->width, $this->store->height) = explode('x', $this->size_idx[$this->store->size]);

        add_action('admin_menu', array(&$this, 'AdminMenu'));
        add_action('admin_init', array(&$this, 'AdminInit'));

        switch ($this->store->mode) {
            case 'widget':
                add_action('widgets_init', create_function('', "register_widget('Wordefinery_LiveinternetCounterWidget');"));
                break;
            case 'footer':
                add_action('wp_footer', array(&$this, 'Footer'));
                break;
            case 'shortcode':
                add_shortcode( 'liveinternetcounter', array(&$this, 'Shortcode'));
                break;
        }
//        add_filter('wp_nav_menu', array(&$this, 'Counter'));
//        add_filter('wp_page_menu', array(&$this, 'Counter'));
    }

    function AdminInit() {
        $this->store->size()->validator(array($this, 'SizeValidator'));
        $this->store->style()->validator(array($this, 'StyleValidator'));
        $this->store->color()->validator(array($this, 'ColorValidator'));
        $this->store->align()->validator(create_function('$data', "if (!in_array(\$data, array('center', 'left', 'right'))) return 'center'; ") );
        $this->store->mode()->validator(create_function('$data', "if (!in_array(\$data, array('widget', 'shortcode', 'footer'))) return 'widget'; ") );

        wp_register_style($this->plugin_slug.'-settings', WP_PLUGIN_URL . '/' . $this->path . '/(css)/liveinternetcounter-settings-page.css', array(), self::VERSION );
        wp_register_script($this->plugin_slug.'-settings', WP_PLUGIN_URL . '/' . $this->path . '/(js)/liveinternetcounter-settings-page.js', array('jquery'), self::VERSION );
        register_setting( $this->plugin_slug, 'wordefinery' );
    }

    function AdminMenu() {
        $page = add_options_page(
            wr___('Settings') . ' &mdash; ' . $this->plugin_title,
            wr___('LiveInternet Counter'),
            'manage_options',
            $this->plugin_slug . '-settings',
            array(&$this, 'SettingsPage')
        );

        $slug = $this->plugin_slug;
    	// wp_version < 3.3.x compat
		// todo: do it in wp way
        if (version_compare($GLOBALS['wp_scripts']->registered['jquery']->ver, '1.7.1') < 0) {
            add_action( 'admin_print_styles-' . $page, create_function('', "wp_deregister_script( 'jquery' ); wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'); wp_enqueue_script( 'jquery' ); ") );
        }
        add_action( 'admin_print_styles-' . $page, create_function('', "wp_enqueue_style('{$slug}-settings');") );
        add_action( 'admin_print_scripts-' . $page, create_function('', "wp_enqueue_script('{$slug}-settings');") );
        // add_action("load-$page", array( &$this, 'help_tabs'));
    }

    function SettingsPage() {
        include(WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $this->path . DIRECTORY_SEPARATOR . 'inc/5.2' . DIRECTORY_SEPARATOR . 'liveinternetcounter-settings-page.php');
    }

    function SizeValidator($size) {
        if (!isset($this->size_idx[$size])) return key($this->size_idx);
    }

    function StyleValidator($style) {
        $st_idx = array();
        foreach($this->size_idx as $i=>$s) $st_idx += array_fill_keys($this->style_idx[$i], $i);
        if (!isset($st_idx[$style])) {
            $style = current($this->style_idx[$this->store->size]);
        } elseif (isset($st_idx[$style]) && $this->store->size != $st_idx[$style]) {
            $this->store->size = $st_idx[$style];
        }
        return $style;
    }

    function ColorValidator($color) {
        if ($color > $this->color_idx[$this->store->size] || $color < 1) {
            return 1;
        }
    }

    function Shortcode($args) {
        static $x = 0;
        if ($x) return;
        $x = 1;
        return $this->Counter().
<<<END
<!--LiveInternet logo--><a href="http://www.liveinternet.ru/click"
target="_blank"><img src="http://counter.yadro.ru/logo?{$this->store->style}.{$this->store->color}" title="LiveInternet Counter"
alt="" border="0" width="{$this->store->width}" height="{$this->store->height}"/></a><!--/LiveInternet-->
END;
    }

    function Footer() {
        echo $this->Counter().
<<<END
<div style="text-align:{$this->store->align}"><!--LiveInternet logo--><a href="http://www.liveinternet.ru/click"
target="_blank"><img src="http://counter.yadro.ru/logo?{$this->store->style}.{$this->store->color}" title="LiveInternet Counter"
alt="" border="0" width="{$this->store->width}" height="{$this->store->height}"/></a><!--/LiveInternet--></div>
END;
    }

    function Counter($nav_menu = '') {
        if ($this->_is_counter) return $nav_menu;
        $this->_is_counter = 1;
        if ($this->store->page_title) {
            return $nav_menu.
<<<END
<!--LiveInternet counter--><script type="text/javascript"><!--
new Image().src = "//counter.yadro.ru/hit?r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";h"+escape(document.title.substring(0,80))+
";"+Math.random();//--></script><!--/LiveInternet-->
END;
        } else {
            return $nav_menu.
<<<END
<!--LiveInternet counter--><script type="text/javascript"><!--
new Image().src = "//counter.yadro.ru/hit?r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random();//--></script><!--/LiveInternet-->
END;
        }
    }
}