<?php

namespace wordefinery;

class LiveinternetCounterWidget extends \WP_Widget {
    function __construct() {
        $this->plugin = \Wordefinery::Plugin('LiveinternetCounter');
        parent::__construct(
            'wordefinery_liveinternetcounter_widget',
            __('LiveInternet.ru Counter'),
            array(
                'description' => __('LiveInternet.ru Counter Widget')
            )
        );
    }

    function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $before_widget;
        if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
        echo $this->plugin->Counter();
        ?><div class="textwidget"><div style="text-align:<?php echo $this->plugin->store->align ?>"><!--LiveInternet logo--><a href="http://www.liveinternet.ru/click"
target="_blank"><img src="http://counter.yadro.ru/logo?<?php echo $this->plugin->store->style ?>.<?php echo $this->plugin->store->color; ?>" title="LiveInternet Counter"
alt="" border="0" width="<?php echo $this->plugin->store->width ?>" height="<?php echo $this->plugin->store->height ?>"/></a><!--/LiveInternet--></div></div><?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'style' => '23', 'title' => '', 'color' => '6') );
        $title = esc_attr( $instance['title'] );
        ?>
        <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <?php
    }

}