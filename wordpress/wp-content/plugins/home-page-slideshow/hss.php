<?php
/**
 * Plugin Name: Home Page Slideshow
 * Description: Create a responsive slideshow with titles, subtitles and links for your site's home page.
 * Version: 1.2
 * Author: Jethin
 * License: GPL2
 */
 
class HSSSettingsPage
{
    /* Holds the values to be used in the fields callbacks */
    private $options;

    /* Start up */
    public function __construct(){
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /* Add options page */
    public function add_plugin_page(){
        // Page will be under "Settings"
       $hss_admin_page = add_options_page(
            'Home Page Slideshow Admin', 
            'Home Slideshow', 
            'edit_pages', 
            'hss-settings-admin', 
            array( $this, 'create_admin_page' )
        );
		add_action('load-' .  $hss_admin_page, 'hss_help_tab');
    }

    /* Options page callback */
    public function create_admin_page(){
        // Set class property
        $this->options = get_option( 'hss_slides' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Home Page Slideshow Admin</h2>
            <p>* See "Help" tab at top right of page for usage tips.</p>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'hss_options' );   
                do_settings_sections( 'hss-settings-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /* Register and add settings */
    public function page_init(){        
        register_setting(
            'hss_options', // Option group
            'hss_slides', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
		
		$hss_slides = get_option( 'hss_slides' );
		if( !empty($hss_slides) ){
			$hss_slides = array_filter( $hss_slides );
			$hss_slide_count = count( $hss_slides );
		}
		else{
			$hss_slide_count = 2;
		}
		
		for( $i = 0; $i <= $hss_slide_count; $i++ ){

			add_settings_section(
				"hss_section_$i", // ID
				'', // Title
				array( $this, 'print_section_info' ), // Callback
				'hss-settings-admin' // Page
			); 
			
			$order = $i + 1;
			add_settings_field(
				"slide$i-index", 
				"<h3>Slide <span class=\"hss-order\">$order</span></h3>", 
				array( $this, 'index_callback' ), 
				'hss-settings-admin', 
				"hss_section_$i",
				array( 'key' => $i )
			);   
			
			add_settings_field(
				"slide$i-image", 
				"Image", 
				array( $this, 'image_callback' ), 
				'hss-settings-admin', 
				"hss_section_$i",
				array( 'key' => $i )
			);  
		
			add_settings_field(
				"slide$i-title", 
				"Title", 
				array( $this, 'title_callback' ), 
				'hss-settings-admin', 
				"hss_section_$i",
				array( 'key' => $i )
			);  
			
			add_settings_field(
				"slide$i-subtitle", 
				"Subtitle", 
				array( $this, 'subtitle_callback' ), 
				'hss-settings-admin', 
				"hss_section_$i",
				array( 'key' => $i )
			);
			
			add_settings_field(
				"slide$i-link", 
				"Link", 
				array( $this, 'link_callback' ), 
				'hss-settings-admin', 
				"hss_section_$i",
				array( 'key' => $i )
			);
			
		}
    }

    /* Sanitize settings fields */
    public function sanitize( $input )
    {
		$input = array_filter( array_map('array_filter', $input) );
		$input = array_values( $input );
		foreach( $input as $key => $slide ){
			
				if( isset( $slide['image'] ) )
					$hss_slides[$key]['image'] = esc_url_raw( $slide['image'] );

				if( isset( $slide['title'] ) )
					$hss_slides[$key]['title'] = sanitize_text_field( $slide['title'] );

				if( isset( $slide['subtitle'] ) )
					$hss_slides[$key]['subtitle'] = sanitize_text_field( $slide['subtitle'] );
					
				if( isset( $slide['link'] ) )
					$hss_slides[$key]['link'] = esc_url_raw( $slide['link'] );
				
		}
		// print_r($hss_slides);
		return $hss_slides;
	}

    /* Print the Section text */
    public function print_section_info(){}

    /* Get the settings option array and print one of its values */
	public function index_callback( array $arg ){
    	echo '<input type="hidden" class="hss-index" value="' . $arg['key'] . '" /><a class="hss-new-slide">add new slide ^</a> | <a class="hss-clear">clear</a> | <a class="hss-delete">delete</a><strong style="margin-left:15px;">X</strong>';
    }

    public function title_callback( array $arg ){
        printf(
            '<input type="text" name="hss_slides[' . $arg['key'] . '][title]" value="%s" />',
            isset( $this->options[$arg['key']]['title'] ) ? esc_attr( $this->options[$arg['key']]['title']) : ''
        );
    }
	
	public function subtitle_callback( array $arg ){
        printf(
            '<input type="text" name="hss_slides[' . $arg['key'] . '][subtitle]" value="%s" />',
            isset( $this->options[$arg['key']]['subtitle'] ) ? esc_attr( $this->options[$arg['key']]['subtitle']) : ''
        );
    }
	
	public function image_callback( array $arg ){
		$image_url = isset( $this->options[$arg['key']]['image'] ) ? esc_attr( $this->options[$arg['key']]['image']) : '';
        printf(
            '<img src="%s" alt="" class="hss-image-preview" width="200" />
			 <input class="hss-select-image button" type="button" value="Select Image" />
			 <input type="hidden" class="hss-image" name="hss_slides[' . $arg['key'] . '][image]" value="%s" />', $image_url, $image_url  
        );
    }
	
	public function link_callback( array $arg ){
        printf(
            '<input type="text" name="hss_slides[' . $arg['key'] . '][link]" class="hss-link" value="%s" /> <a href="" class="hss-link-preview" target="_blank">Go</a><div class="hss-link-error">NOTE: URL appears to be invalid.</div>',
            isset( $this->options[$arg['key']]['link'] ) ? esc_attr( $this->options[$arg['key']]['link']) : ''
        );
    }

}

if( is_admin() )
    $hss_settings_page = new HSSSettingsPage();


function hss_scripts(){
	wp_dequeue_script( 'cycle1' );
	wp_register_script( 'cycle2', plugins_url( 'jquery.cycle2.min.js' , __FILE__ ), array('jquery'), '2.1.6' );
	wp_register_script( 'hss_js', plugins_url( 'hss.js', __FILE__ ), array('cycle2') );
	wp_register_style( 'hss_css', plugins_url( 'hss.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'hss_scripts', 99 );


function hss_shortcode( $atts ){
	
	// vars
	$hss_slides = get_option( 'hss_slides' );
	$no_slides = count($hss_slides);
	$hss_classes = $no_slides == 1 ? ' class="single-slide"' : '';
	$default_opts = array(
		'slides' => '> div',
		'timeout' => '6500',
		'prev' => '#hss-nav .previous',
		'next' => '#hss-nav .next',
		'pager-template' => '<a>&bull;</a>',
		'speed' => '750',
		'pager' => '#hss-pager',
		'overlay' => '#hss-info',
		'overlay-template' => '{{link}}<h2>{{title}}</h2><h3>{{desc}}{{link_close}}</h3>'
	);
	
	if( !empty($hss_slides) ){
		
		wp_enqueue_script( 'cycle2' );
		wp_enqueue_script( 'hss_js' );
		wp_enqueue_style( 'hss_css' );
		
		// options
		extract( shortcode_atts( array('options' => ''), $atts ) );
		if( !empty($options) ){
			$options = html_entity_decode($options);
			parse_str( $options, $options );
			foreach( $default_opts as $k => $v ){
				if( !array_key_exists( $k, $options ) ){
					$options[$k] = $v;
				}
			}
		}
		else{
			$options = $default_opts;
		}
		$options_string = '';
		foreach( $options as $k => $v ){
			$options_string .= "\n\tdata-cycle-" . $k . '="' . $v . '"';
		}
		$overlay_template = str_replace( array('{{link}}','{{link_close}}'), '', $options['overlay-template'] );
		$long_caption = $overlay_template_length = strlen( str_replace( array('{{title}}','{{desc}}'), '', $overlay_template ) );
		
		// begin html assembly
		$html = "\n" . '<div id="home-slideshow"' . $hss_classes .'>';
		$html .= "\n\t" . '<div id="hss-pager"></div>';
		$html .= "\n\t" . '<div class="cycle-slideshow" '. $options_string . "\n\t>\n\n";
		foreach( $hss_slides as $slide ){
			// slide vars
			$title = !empty( $slide['title'] ) ? $slide['title']: '';
			$subtitle = !empty( $slide['subtitle'] ) ? $slide['subtitle']: '';
			$link = !empty( $slide['link'] ) ? '<a href=\'' . $slide['link'] . '\'>' : '';
			$link_close = !empty( $link ) ? '</a>' : '';
			$no_caption_overlay = ( empty( $title ) && empty( $subtitle ) ) ? ' data-cycle-overlay-template=""' : '';
			// slide html
			$html .= "\t\t" . '<div data-cycle-title="' . $title . '" data-cycle-desc="' . $subtitle . '" data-cycle-link="' . $link . '" data-cycle-link_close="' . $link_close . '"' . $no_caption_overlay . '>';
			$html .= $link . '<img src="' . $slide['image'] . '" alt="' . $title . '" />' . $link_close;
			$html .= '</div>' . "\n\n";
			$caption = str_replace( '{{title}}', $title, $overlay_template );
			$caption = str_replace( '{{desc}}', $subtitle, $caption );
			$long_caption = ( strlen($caption) > strlen($long_caption) ) ? $caption : $long_caption;
		}
		$html .= "\t" . '</div>' . "\n\t";
		$html .= '<div id="hss-nav"><a class="previous">&lt;</a> <a class="next">&gt;</a></div>' . "\n\t";
		$html .= '<div id="hss-info"></div>' . "\n\t";
		if( $long_caption != $overlay_template_length ){
			$html .= '<div id="hss-long-caption">' . $long_caption . '</div>' . "\n";
		}
		$html .= "</div>\n";
		
		return $html;
	}
}
add_shortcode( 'home_slideshow', 'hss_shortcode' );



function hss_admin_scripts(){
    if ( isset($_GET['page']) && $_GET['page'] == 'hss-settings-admin' ) {
        wp_enqueue_media();
        wp_register_script('hss-admin-js', WP_PLUGIN_URL . '/home-page-slideshow/hss-admin.js', array('jquery'));
        wp_enqueue_script('hss-admin-js');
		wp_register_style( 'hss-admin-css', plugins_url( 'home-page-slideshow/hss-admin.css' ) );
		wp_enqueue_style( 'hss-admin-css' );
    }
}
add_action('admin_enqueue_scripts', 'hss_admin_scripts');


function hss_help_tab() {
    $screen = get_current_screen();
    $screen->add_help_tab( array(
        'id'	=> 'hss_help',
        'title'	=> __('Help'),
        'content'	=> '<ul>
			<li>Drag and drop boxes to reorder slides</li>
			<li>Link field can be set in image selection window</li>
			<li>Slideshows display best when images are the same size/dimensions</li>
			<li>Changes must be saved before slides are updated</li>
			<li>Insert [home_slideshow] shortcode where you\'d like your slideshow to appear</li>
		</ul>',
    ) );
}

?>