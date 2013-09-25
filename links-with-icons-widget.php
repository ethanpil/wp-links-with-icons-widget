<?php
/*
Plugin Name: Links With Icons Widget
Plugin URI: http://angeleswebdesign.com
Description: A widget that lists links with icons. Based on Custom Link Widget by Pankaj Biswas.
Author: Ethan Piliavin
Author URI: http://piliavin.com
Version: 1.0
*/
class wLWI extends WP_Widget {

	const VERSION = '1.0.0';

	function __construct(){
		$options = array(
			'description' => 'A widget that displays links with icons.',
			'name' => 'Links With Icons'
		);
		parent::__construct('wLWI','',$options);
		
		//Enqueue javascript in admin
		add_action( 'sidebar_admin_setup', array( $this, 'admin_setup' ) );
		
		//Enqueue default style in frontend if widget is displayed
		if ( is_active_widget(false, false, $this->id_base) ) 
		{
			add_action( 'wp_head', array(&$this, 'frontend_styles_and_scripts') );
		}
        
	}
	
	//Enqueue javascript in admin
	function admin_setup() {
		wp_enqueue_media();
		wp_enqueue_script( 'links-with-icons-widget', plugins_url('script.js', __FILE__), array( 'jquery', 'media-upload', 'media-views' ), self::VERSION );
	}	
	
	function frontend_styles_and_scripts(){
		//since its wp_head you need to echo out your style link:
		echo '<link rel="stylesheet" href="'.plugins_url('style.css', __FILE__).'" type="text/css" />';
		
		//as for javascript it can be included using wp_enqueue_script and set the footer parameter to true:
		// wp_enqueue_script( 'widget_script','http://example.com/js/script.js',array(),'',true );
	}
	
	//Taking Input From User
	public function form($instance)
	{
		extract($instance);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title');?>">Widget Title: </label>
			<input class="widefat" style="background:#fff;" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" value="<?php if(isset($title)) echo esc_attr($title);?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('hLinks');?>">Number of Links To Display? </label>
			<input type="number" min="1" max="20" class="widefat" style="background:#fff;width:40px;text-align:center;" id="<?php echo $this->get_field_id('numB');?>" name="<?php echo $this->get_field_name('numB');?>" value="<?php echo !empty($numB) ? $numB:1;?>"/>
			<br><i>Save to See Additional Fields. NOTE: Reducing the number of links will delete the extra link data.</i>
		</p>
		<?php for($i=0;$i<$numB;$i++)
		{
			$count=$i+1;
			$target = 'iT'.$count;
			$link = 'iLink'.$count;
			$name = 'iName'.$count;
			$icon = 'iIcon'.$count;
		?>
		<hr />
		<h4>Link #<?php echo $count;?> Details</h4>

		<p>
			<label for="<?php echo $this->get_field_id($link);?>">URL: (Include http://) </label>
			<input class="widefat validate validate_url" style="background:#fff;" id="<?php echo $this->get_field_id($link);?>" name="<?php echo $this->get_field_name($link);?>" value="<?php if(isset($$link)) echo esc_attr($$link);?>"/>
		</p>
		
				<!-- New Window Opening Option -->
		<p>
			
			<input type="checkbox" class="checkbox" <?php checked($instance[$target], true) ?> id="<?php echo $this->get_field_id($target);?>" name="<?php echo $this->get_field_name($target);?>" value="1"/>
			<label for="<?php echo $this->get_field_id($target);?>">Open In New Window</label>
		</p>
		<!-- /New Window Opening Option -->

		
		<p>
			<label for="<?php echo $this->get_field_id($name);?>">Link Text: </label>
			<input class="widefat" style="background:#fff;" id="<?php echo $this->get_field_id($name);?>" name="<?php echo $this->get_field_name($name);?>" value="<?php if(isset($$name)) echo esc_attr($$name);?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id($icon);?>">Icon: </label>
			<img id="<?php echo $this->get_field_id($icon);?>-preview" style="max-width:100%;" <?php if (isset($icon)) echo 'src="'.$$icon.'"'?> >
			<br />
			<input type="submit" class="button upload_image_button" value="<?php _e('Select Image', 'links_with_icons_widget'); ?>" data-target-id="<?php echo $this->get_field_id($icon);?>"/>
			<input type="hidden" id="<?php echo $this->get_field_id($icon);?>" name="<?php echo $this->get_field_name($icon);?>" value="<?php echo $$icon; ?>" />
		</p>
		<?php
		}?>
		<?php
	}
	
	//Displaying The Data To Widget

	public function widget($args,$instance){
		extract($args);
		extract($instance);
		$title = apply_filters('widget_title',$title);
		
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo '<ul class="links_with_icons">';
		for($i=0;$i<$numB;$i++)
		{
			$count=$i+1;
			$target = 'iT'.$count;
			$link = 'iLink'.$count;
			$name = 'iName'.$count;
			$icon = 'iIcon'.$count;
			if(empty($$name)) return false;

			//Determining Whether To Open In New Window Or Not
			if($$target == 1) 
			{
				$tar = 'target="_blank" ';
			}
			else
			{
				$tar = '';
			}
			echo '<li class="link_with_icon"><img src="'.$$icon.'"><a '.$tar.'href="'.esc_attr($$link).'">'.esc_attr($$name).'</a></li>';
		}
		echo '</ul>';
		echo $after_widget;
	
	}
}
add_action('widgets_init','register_wLWI');
function register_wLWI(){
	register_widget('wLWI');
}
