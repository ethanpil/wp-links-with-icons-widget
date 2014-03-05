<?php /*
Plugin Name: Links With Icons Widget
Plugin URI: http://angeleswebdesign.com
Description: A widget that lists links with icons.
Author: Ethan Piliavin
Author URI: http://piliavin.com
Version: 1.2.1
*/

class wLWI extends WP_Widget {

	const VERSION = '1.2.1';

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

		<?php 
			for($i=0;$i<$numB;$i++)
			{
				$count=$i+1;
				$target = 'iT'.$count;
				$link = 'iLink'.$count;
				$name = 'iName'.$count;
				$show = 'iShow'.$count;
				$icon = 'iIcon'.$count;
				$nofollow = 'iFollow'.$count;				
				$alt = 'iAlt'.$count;
			?>
			<hr />
			
			<h4>Link #<?php echo $count;?> Details</h4>

			<p>
				<label for="<?php echo $this->get_field_id($link);?>">URL: (Include http://) </label>
				<input class="widefat validate validate_url" style="background:#fff;" id="<?php echo $this->get_field_id($link);?>" name="<?php echo $this->get_field_name($link);?>" value="<?php if(isset($$link)) echo esc_attr($$link);?>"/>
			</p>

			<!-- New Window Opening Option: -->
			<p>
				<input type="checkbox" class="checkbox" <?php checked($instance[$target], true) ?> id="<?php echo $this->get_field_id($target);?>" name="<?php echo $this->get_field_name($target);?>" value="1"/>
				<label for="<?php echo $this->get_field_id($target);?>">Open In New Window</label>
			</p>
			<!-- /New Window Opening Option -->

			<!-- No Follow Option: -->
			<p>
				<input type="checkbox" class="checkbox" <?php checked($instance[$nofollow], true) ?> id="<?php echo $this->get_field_id($nofollow);?>" name="<?php echo $this->get_field_name($nofollow);?>" value="1"/>
				<label for="<?php echo $this->get_field_id($nofollow);?>">No Follow</label>
			</p>
			<!-- /No Follow Option: -->
			
			<!-- Link Text: -->
			<p>
				<label for="<?php echo $this->get_field_id($name);?>">Link Text: </label>
				<input class="widefat" style="background:#fff;" id="<?php echo $this->get_field_id($name);?>" name="<?php echo $this->get_field_name($name);?>" value="<?php if(isset($$name)) echo esc_attr($$name);?>"/>
			</p>
			<!-- /Link Text -->
			
			<!-- Show Option: -->
			<?php
			$imagetext_sel = '';
			$image_sel = '';
			$text_sel = '';
			if(isset($$show)) {
				switch($$show) {
					case 'text':
						$imagetext_sel = '';
						$image_sel = '';
						$text_sel = 'selected="selected"';
					break;
					case 'image':
						$imagetext_sel = '';
						$image_sel = 'selected="selected"';
						$text_sel = '';
					break;
					default:
						$imagetext_sel = 'selected="selected"';
						$image_sel = '';
						$text_sel = '';
					break;
				}
			}
			?>
			<p>
				<label for="<?php echo $this->get_field_id($show);?>">Show: </label>
				<select id="<?php echo $this->get_field_id($show);?>" name="<?php echo $this->get_field_name($show);?>">
					<option value="imagetext" <?php echo $imagetext_sel; ?>>Image and Text</option>
					<option value="image" <?php echo $image_sel; ?>>Image only</option>
					<option value="text" <?php echo $text_sel; ?>>Text only</option>
				</select>
			</p>
			<!-- /Show Option: -->
			
			<!-- Image ALT Attribute: -->
			<p>
				<label for="<?php echo $this->get_field_id($alt);?>">ALT Attribute </label>
				<input class="widefat" style="background:#fff;" id="<?php echo $this->get_field_id($alt);?>" name="<?php echo $this->get_field_name($alt);?>" value="<?php if(isset($$alt)) echo esc_attr($$alt);?>"/>
			</p>
			<!-- /Image ALT Attribute: -->		
			
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
			$show = 'iShow'.$count;
			$icon = 'iIcon'.$count;
			$nofollow = 'iFollow'.$count;	
			$alt = 'iAlt'.$count;
			
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
			
			//Determining If Link IS No Follow

			if($$nofollow == 1) 
			{
				$fol = 'rel="nofollow" ';
			}
			else
			{
				$fol = '';
			}			

			//Parse URL for proper output in HTTP or HTTPS environment
			$imgurl = parse_url($$icon);
			$imgsrc=$imgurl["host"].$imgurl["path"];
			echo '<li class="link_with_icon"><a '.$fol.$tar.'href="'.esc_attr($$link).'">';
			if (preg_match('/image/i',$$show)>0) {
				echo '<img src="//'.$imgsrc.'" alt="'.esc_attr($$alt).'">';
			}
			if (preg_match('/text/i',$$show)>0) {
				echo '<span>'.esc_attr($$name).'</span>';
			}
			echo '</a></li>';
		}

		echo '</ul>';

		echo $after_widget;
	}
}
add_action('widgets_init','register_wLWI');

function register_wLWI(){
	register_widget('wLWI');
}

