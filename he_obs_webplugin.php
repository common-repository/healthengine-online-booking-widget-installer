<?php
/*
Plugin Name: HealthEngine - Online Booking Widget Installer
Plugin URI: https://wordpress.org/plugins/healthengine-online-booking-widget-installer/
Description: HealthEngine plugin for online booking system
Version: 1.0.1
Author: HealthEngine
Author URI: https://healthengine.com.au/
*/

// Exit when accessed from URL
defined('ABSPATH') or exit;

define('HE_URL', 'https://healthengine.com.au');

class HE_OBS_WebPlugin extends WP_Widget {

    /**
     * Constructor for setting up OBS widget
     */
    public function __construct() {
        parent::__construct(
			'he_obs_webplugin',
			esc_html__('HealthEngine - Online Booking Widget Installer', 'text_domain'),
			array('description' => esc_html__('HealthEngine plugin for online booking system', 'text_domain'),)
		);

		if (is_active_widget(false, false, $this->id_base)) {
			add_action('wp_head', array($this, 'css'));
		}
	}

	/**
	 * Patch up CSS solution because of CSS conflict with Wordpress style.css
	 */
	function css() {
?>

<style type="text/css">
.he-row h2 {
	color: #FFF !important;
	padding: 0px !important;
	float: none !important;
	display: inline !important;
}

.he-row h2:before {
	content: none !important;
}

.he-row {
	line-height: normal !important;
}
</style>

<?php
	}

    /**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
        echo $args['before_widget'];
        
		$grpLocId = !empty($instance['grp_loc_id']) ? $instance['grp_loc_id'] : '';
		$btnType = !empty($instance['btn_type']) ? $instance['btn_type'] : '';

		// Hide the widget when practice id is not provided
		if ($grpLocId) {
			if ($btnType != 'Fixed') {
				echo '<script data-he-id="' . $grpLocId . '" data-he-button="true" data-he-img="' . $btnType . '" src="' . HE_URL . '/webplugin/appointments.js"> </script>';
			} else {
				echo '<script data-he-id="' . $grpLocId . '" data-alignment="right" data-he-fixed="true" data-background-color="#003a4c" src="' . HE_URL . '/webplugin/appointments.js"> </script>';
			}
		}

		echo $args['after_widget'];
    }
    
    /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		$grpLocId = !empty($instance['grp_loc_id']) ? $instance['grp_loc_id'] : '';
		$btnType = !empty($instance['btn_type']) ? $instance['btn_type'] : 'HE_BOOKNOW_1.png';

		?>
		<div class="widget-body">
			<div class="group practice-group">
				<h4 for="<?php echo esc_attr($this->get_field_id('grp_loc_id')); ?>"><?php esc_attr_e('1. What is your Practice Id (Find this in Practice Admin)?', 'text_domain'); ?></h4> 
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('grp_loc_id')); ?>" name="<?php echo esc_attr($this->get_field_name('grp_loc_id')); ?>" type="text" value="<?php echo esc_attr($grpLocId); ?>">
			</div>
			<div class="group select-btn-group">
				<h4 for="btn_type"><?php esc_attr_e('2. Select a "Book Now" button?', 'text_domain'); ?></h4> <br/>
				<div class="book-btn-group">
					<div class="widget-button-preview">
						<input type="radio" id="<?php echo esc_attr($this->get_field_id('radio1')); ?>" name="<?php echo esc_attr($this->get_field_name('btn_type')); ?>" value="HE_BOOKNOW_1.png" <?php if($btnType == "HE_BOOKNOW_1.png"): ?>checked<?php endif; ?>>
						<label for="<?php echo esc_attr($this->get_field_id('radio1')); ?>"> 
							<img style="width: 80%; margin-top: 10px;" src="<?php echo HE_URL; ?>/images/widget/HE_BOOKNOW_1.png">
						</label>
					</div>
					<div class="widget-button-preview">
						<input type="radio" id="<?php echo esc_attr($this->get_field_id('radio2')); ?>" name="<?php echo esc_attr($this->get_field_name('btn_type')); ?>" value="HE_BOOKNOW_2.png" <?php if($btnType == "HE_BOOKNOW_2.png"): ?>checked<?php endif; ?>>
						<label for="<?php echo esc_attr($this->get_field_id('radio2')); ?>"> 
							<img style="width: 80%; margin-top: 10px;" src="<?php echo HE_URL; ?>/images/widget/HE_BOOKNOW_2.png">
						</label>
					</div>
					<div class="widget-button-preview">
						<input type="radio" id="<?php echo esc_attr($this->get_field_id('radio3')); ?>" name="<?php echo esc_attr($this->get_field_name('btn_type')); ?>" value="HE_BOOKNOW_3.png" <?php if($btnType == "HE_BOOKNOW_3.png"): ?>checked<?php endif; ?>>
						<label for="<?php echo esc_attr($this->get_field_id('radio3')); ?>"> 
							<img style="margin-top: 10px;" src="<?php echo HE_URL; ?>/images/widget/HE_BOOKNOW_3.png">
						</label>
					</div>
					<div class="widget-button-preview">
						<input type="radio" id="<?php echo esc_attr($this->get_field_id('radio4')); ?>" name="<?php echo esc_attr($this->get_field_name('btn_type')); ?>" value="HE_BOOKNOW_4.png" <?php if($btnType == "HE_BOOKNOW_3.png"): ?>checked<?php endif; ?>>
						<label for="<?php echo esc_attr($this->get_field_id('radio4')); ?>"> 
							<img style="margin-top: 10px;" src="<?php echo HE_URL; ?>/images/widget/HE_BOOKNOW_4.png">
						</label>
					</div>
					<div class="widget-button-preview">
						<input type="radio" id="<?php echo esc_attr($this->get_field_id('radio5')); ?>" name="<?php echo esc_attr($this->get_field_name('btn_type')); ?>" value="Fixed" <?php if($btnType == "Fixed"): ?>checked<?php endif; ?>>
						<label for="<?php echo esc_attr($this->get_field_id('radio5')); ?>"> 
							<img style="width: 80%; margin-top: 10px;" src="<?php echo HE_URL; ?>/images/widget/HE_BOOKAPPT.png">
						</label>
					</div>
					<p>Button anchored at the bottom right on the page</p>
				</div>
			</div>
		</div>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {
        $instance = array();

        $instance['grp_loc_id'] = (! empty($new_instance['grp_loc_id'])) ? sanitize_text_field($new_instance['grp_loc_id']) : '';
		$instance['btn_type'] = (!empty($new_instance['btn_type'])) ? sanitize_text_field($new_instance['btn_type']) : '';

		return $instance;
	}
}

// register HE_OBS_Plugin
function register_he_obs_plugin() {
    register_widget('HE_OBS_WebPlugin');
}
add_action('widgets_init', 'register_he_obs_plugin');