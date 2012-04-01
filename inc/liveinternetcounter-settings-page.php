<?php

namespace wordefinery;

$title = __('Settings') . ' &mdash; ' . $this->plugin_title;
$parent_file = 'options-general.php';

?>

<div class="wrap">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>

<form method="post" action="options.php">
<?php settings_fields($this->plugin_slug); ?>
<input type="hidden" name="wordefinery[__section__]" value="<?php echo $this->plugin_slug; ?>" />
<input type="hidden" name="wordefinery[size]" value="<?php echo $this->store->size; ?>" id="<?php echo $this->plugin_slug; ?>-size" />
<input type="hidden" name="wordefinery[style]" value="<?php echo $this->store->style; ?>" id="<?php echo $this->plugin_slug; ?>-style" />
<input type="hidden" name="wordefinery[color]" value="<?php echo $this->store->color; ?>" id="<?php echo $this->plugin_slug; ?>-color" />
<input type="hidden" name="wordefinery[align]" value="<?php echo $this->store->align; ?>" id="<?php echo $this->plugin_slug; ?>-align" />
<table class="form-table">
    <tr valign="top">
        <th scope="row"><?php _e('Counter') ?></th>
        <td><div class="relative">
        <div id="<?php echo $this->plugin_slug; ?>-counter">

        <div class="selector size">
        <?php foreach ($this->size_idx as $i=>$s) : ?>
        <?php list($w, $h) = explode('x', $s); ?>
        <a name="<?php echo $i; ?>"><img src="<?php echo WP_PLUGIN_URL.'/'.$this->path; ?>/(img)/<?php echo $s; ?>.png" width="<?php echo $w; ?>" height="<?php echo $h; ?>" alt="<?php echo $s; ?>" /></a>
        <?php endforeach; ?>
        </div>

        <?php foreach ($this->size_idx as $i=>$s) : ?>
        <?php list($w, $h) = explode('x', $s); ?>
        <div class="selector style-<?php echo $i; ?> style hidden">
        <?php foreach ($this->style_idx[$i] as $style) : ?>
        <a name="<?php echo $style; ?>"><img src="http://counter.yadro.ru/logo?<?php echo $style; ?>.6" width="<?php echo $w; ?>" height="<?php echo $h; ?>" /></a>
        <?php endforeach; ?>
        </div>
        <?php endforeach; ?>

        <?php foreach ($this->size_idx as $i=>$s) : ?>
        <?php list($w, $h) = explode('x', $s); $style = $this->style_idx[$i][0]; ?>
        <div class="selector color-<?php echo $i; ?> color hidden">
        <?php for ($color=1; $color<=$this->color_idx[$i]; $color++) : ?>
        <a name="<?php echo $color; ?>"><img src="http://counter.yadro.ru/logo?<?php echo $style; ?>.<?php echo $color; ?>" width="<?php echo $w; ?>" height="<?php echo $h; ?>" /></a>
        <?php endfor; ?>
        </div>
        <?php endforeach; ?>

        </div>

        <div id="<?php echo $this->plugin_slug; ?>-preview">
        <div class="align">
        <a name="left"><?php _e('Left') ?></a>
        <a name="center"><?php _e('Center') ?></a>
        <a name="right"><?php _e('Right') ?></a>
        </div>
        <div class="preview">
            <img src="http://counter.yadro.ru/logo?<?php echo $this->store->style; ?>.<?php echo $this->store->color; ?>" />
        </div>
        </div>

        </div></td>
    </tr>
    <tr valign="top">
        <th scope="row"><?php _e('Mode') ?></th>
        <td>
        <label><input type="radio" name="wordefinery[mode]" value="widget" <?php \checked('widget', $this->store->mode); ?> />
        <?php _e('Widget') ?></label><br/>
        <label><input type="radio" name="wordefinery[mode]" value="footer" <?php \checked('footer', $this->store->mode); ?> />
        <?php _e('Footer') ?></label><br/>
        <label><input type="radio" name="wordefinery[mode]" value="shortcode" <?php \checked('shortcode', $this->store->mode); ?> />
        <?php _e('Shortcode') ?></label> <code>[liveinternetcounter]</code><br/>
        <code>&lt;?php do_shortcode('[liveinternetcounter]') ?&gt;</code> &mdash; <i><?php _e('Use this code in your template') ?></i><br/>
        </td>
    </tr>
    <tr valign="top"><th scope="row"><?php _e('Page Title in Statistic') ?></th>
        <td>
        <label><input type="radio" name="wordefinery[page_title]" value="0" <?php \checked(0, $this->store->page_title); ?> />
        <?php _e('Disable') ?></label><br/>
        <label><input type="radio" name="wordefinery[page_title]" value="1" <?php \checked(1, $this->store->page_title); ?> />
        <?php _e('Enable') ?></label><br/>
        </td>
    </tr>
</table>

<p class="submit">
    <input type="submit" name="Submit" class="button-primary" value="<?php \esc_attr_e('Save Changes') ?>" />
</p>
</form>

<img src="http://wordefinery.com/i/liveinternet-counter.gif?wp=<?php echo $GLOBALS['wp_version']; ?>&v=<?php echo self::VERSION; ?>" width="1" height="1" border="0" alt="" />
</div>
