<?php
/*
Plugin Name: Point and Stare Category Authors Widget
Plugin URI: http://pointandstare.com
Description: Adds a widget that displays authors who have contributed to the current category.
Author: Lee Rickler
Version: 0.1
Author URI: http://pointandstare.com
*/

class WP_Widget_PandS_Cat_Authors_Widget extends WP_Widget {
	function WP_Widget_PandS_Cat_Authors_Widget() {
		$widget_ops = array( 'classname' => 'widget_PandSCAW', 'description' => __( "Displays a list of authors who have contributed to the current category and links to their profile." ) );
		$this->WP_Widget('PandSCAW', __('Point and Stare Category Authors'), $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		echo $before_widget; ?>
		<div class="pands-caw-widget">
<?php if (is_category()) {?>
<?php
$current_category = single_cat_title("", false);
$author_array = array();
$args = array(
'numberposts' => -1,
'category_name' => $current_category,
'orderby' => 'author',
'order' => 'ASC'
);
$cat_posts = get_posts($args);
echo "<h3 class=\"widget-title\">";
echo $current_category;
echo " authors</h3>";
echo "<ul>";
foreach ($cat_posts as $cat_post) :
if (!in_array($cat_post->post_author,$author_array)) {
$author_array[] = $cat_post->post_author;
}
endforeach;
foreach ($author_array as $author) :
$auth = get_userdata($author)->display_name;
$auth_link = get_userdata($author)->user_login;
echo "<li>";
echo "<a href='";
echo bloginfo('home');
echo "/author/";
echo $auth_link;
echo "'>";
echo $auth;
echo "</a>";
echo "</li>";
endforeach;
?>
</ul>
</div>
<?php }?>
<?php echo $after_widget;
	}
}
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_PandS_Cat_Authors_Widget");'));
?>