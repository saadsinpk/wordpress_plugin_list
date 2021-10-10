<?php /*
Plugin Name: Plugin List
Plugin URI: http://sitechno.com
description: >- a plugin to create to list plugins
Version: 1
Author: Muhammad Saad
Author URI: http://sidtechno.com
*/

// function that runs when shortcode is called
function sidtechnno_plugin_list($attrs) {
	if(isset($attrs['category']) AND !empty($attrs['category'])) {
		echo 'test-'.$attrs['category'];
	    $args = array(  
	        'post_type' => 'plugin_lists',
	        'post_status' => 'publish',
	        'posts_per_page' => -1, 
	        'orderby' => 'title', 
			    'tax_query' => array(
			        array(
			            'taxonomy' => 'plugin_list_category',
			            'field'    => 'slug',
			            'terms'    => $attrs['category']
			        )
			      )
	    );
	} else {
	    $args = array(  
	        'post_type' => 'plugin_lists',
	        'post_status' => 'publish',
	        'posts_per_page' => -1, 
	        'orderby' => 'title', 
	        'relation' => 'AND',
	        'order' => 'ASC', 
	    );
	}

    $loop = new WP_Query( $args ); 

	$html = '
	<style>
		.sidtech-plugin-option { direction: rtl; }
		.sidtech-plugin-option table{width:100%;margin:0;padding:0;text-align:center;     display: table;    border-collapse: separate;    box-sizing: border-box;    text-indent: initial;    border-spacing: 2px;    border-color: grey;}
		.sidtech-plugin-option table tr{background-color:#fff;border-bottom:3px solid #ECECEC;transition:300ms;}
		.sidtech-plugin-option table tr:hover{background-color:#f3f3f3;}
		.sidtech-plugin-option table tr th{font-size:15px;color:#fff;line-height:1.4;padding-top:16px;padding-bottom:16px;text-align:center;background-color:#354D73;}
		.sidtech-plugin-option table tr td{font-size:15px;color:gray;line-height:1.4;padding-top:16px;padding-bottom:16px;text-align:center;}
		.sidtech-plugin-option table tr td.title,.sidtech-plugin-option table tr td.status{text-transform:capitalize;}
		.wsd-save-field{background-color:#354D73;color:#fff;border-radius:5px;border:none;outline:none;font-size:13px;font-weight:bold;cursor:pointer;transition:300ms;display:inline-block;padding:7px 12px 9px;margin:0 5px;}
		.wsd-save-field:hover{background-color:#283a56;}
		.wsd-toggler .wsd-toggler-shape{margin:0 auto;}
		.wsd-toggler .wsd-loading{display:inline-flex;width:30px;height:30px;vertical-align:middle;opacity:0;transition:100ms;}
		input[type=checkbox].wsd-toggler-input{display:none;}
		.wsd-toggler-shape{display:inline-flex;align-items:center;width:60px;height:30px;background:#2c3e50;border-radius:2.5em;transition:all 0.5s ease;cursor:pointer;}
		.wsd-toggler-handler{display:flex;margin-left:0.5em;justify-content:center;align-items:center;width:20px;height:20px;background:#34495e;border-radius:50%;transition:all 0.5s ease;box-shadow:0 0 8px rgba(0, 0, 0, 0.3);}
		.rtl .wsd-toggler-handler{margin-right:6px;margin-left:unset;}
		.wsd-toggler-handler:before{content:"×";color:white;font-size:16px;font-weight:bold;padding-bottom:5px;}
		input[type=checkbox].wsd-toggler-input:checked + .wsd-toggler-shape{background:#16a085;}
		input[type=checkbox].wsd-toggler-input:checked + .wsd-toggler-shape .wsd-toggler-handler{margin-left:56%;background:#1abc9c;}
		.rtl input[type=checkbox].wsd-toggler-input:checked + .wsd-toggler-shape .wsd-toggler-handler{margin-left:unset;margin-right:56%;}
		input[type=checkbox].wsd-toggler-input:checked + .wsd-toggler-shape .wsd-toggler-handler::before{content:"✔";padding-bottom:0;}

	</style>
	<div class="sidtech-plugin-option"><table>
        <tbody><tr class="sidtech-plugin-option-table-head">
            <th>#</th>
            <th></th>
            <th>اسم طريقة الدفع</th>
            <th>تفعيل</th>
            <th></th>
        </tr>';
        $count = 1;
	    while ( $loop->have_posts() ) : $loop->the_post(); 
		    $plugin_name = esc_attr( get_post_meta( get_the_ID(), 'sidtechno_select_plugin', true ) );
	    	$feat_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );

	    	$html .= '<tr id="payment-gateway-'.get_the_title().'" class="wsd-payment-gateway payment-gateway-method-'.get_the_title().'            wsd-payment-gateway-row-4">
                <td class="number">
					'.$count.'                </td>
                <td>';
                if(!empty($feat_image)) {
					$html .= '<img src="'.$feat_image.'" alt="'.get_the_title().'" class="img-responsive" style="max-width:157px;max-height:50px;">';
                }
                $html .= '</td><td class="title">
					'.get_the_title().'		
                </td>
                <td class="status">';
                if(!empty($plugin_name) AND $plugin_name != 'Select Plugin') {
	                               $html .= '<div class="wsd-toggler">
                <input id="toggler-'.get_the_ID().'" type="checkbox" class="wsd-toggler-input wsd-plugin-controller-toggle" data-plugin-slug="'.$plugin_name.'" ';
				if ( is_plugin_active($plugin_name) ) {
					$html .= 'data-state="deactivate" checked=""';
				} else {
					$html .= 'data-state="activate"';
				}
                $html .= ' disabled>
                <label for="toggler-'.get_the_ID().'" class="check-trail wsd-toggler-shape">
                    <span class="check-handler wsd-toggler-handler"></span>
                </label>
                <img src="https://wkala.myinnoshop.com/wp-content/mu-plugins/plugins-controller//spinner.svg" class="wsd-loading" alt="loading">
                </div>';
                }                $html .='</td>
                <td class="moderate">

		';

			if(!empty($plugin_name) AND $plugin_name != 'Select Plugin') {
				if(is_plugin_active($plugin_name)) {
					if(!empty(esc_attr( get_post_meta( get_the_ID(), 'sidtechno_option_url', true ) ))) {
						$option_urls = json_decode(get_post_meta( get_the_ID(), 'sidtechno_option_url', true ));
						$option_name = json_decode(get_post_meta( get_the_ID(), 'sidtechno_option_name', true ));

						foreach ($option_urls as $option_key => $option_value) {
							if(!empty($option_value)) {
													$html .= '<a href="'.$option_value.'" class="wsd-payment-popup-button wsd-save-field" >'.$option_name[$option_key].'</a>';
								}
						}
					}
				} else {
					if(!empty(esc_attr( get_post_meta( get_the_ID(), 'sidtechno_option_url', true ) ))) {
						$option_urls = json_decode(get_post_meta( get_the_ID(), 'sidtechno_option_url', true ));
						$option_name = json_decode(get_post_meta( get_the_ID(), 'sidtechno_option_name', true ));

						foreach ($option_urls as $option_key => $option_value) {
							if(!empty($option_value)) {
													$html .= '<a href="'.$option_value.'" class="wsd-payment-popup-button wsd-save-field" style="display:none;">'.$option_name[$option_key].'</a>';
								}
						}
					}
				}
			} else {
				if(!empty(esc_attr( get_post_meta( get_the_ID(), 'sidtechno_option_url', true ) ))) {
					$option_urls = json_decode(get_post_meta( get_the_ID(), 'sidtechno_option_url', true ));
					$option_name = json_decode(get_post_meta( get_the_ID(), 'sidtechno_option_name', true ));

					foreach ($option_urls as $option_key => $option_value) {
						if(!empty($option_value)) {
									$html .= '<a href="'.$option_value.'" class="wsd-payment-popup-button wsd-save-field" >'.$option_name[$option_key].'</a>';
							}
					}
				}
			}

						                $html .= '</td>
            </tr>';
      $count++;
	    endwhile;

    $html .= '</tbody></table></div>'; 
    $html .= '	<script>
	jQuery( document ).ready(function() {
		jQuery(".wsd-toggler-input").removeAttr("disabled");
	});
	jQuery( ".wsd-toggler-input" ).change(function() {
		jQuery("body").append("<div id=\'loading_div\' style=\'position: fixed;  display: block;  width: 100%;  height: 100%;  top: 0;  left: 0;  text-align: center;  opacity: 0.7;  background-color: #fff;  z-index: 99;\'>Loadin</div>")
		var plugin_slug = jQuery(this).attr("data-plugin-slug");
		var plugin_state = jQuery(this).attr("data-state");
		if(plugin_state == "deactivate") {
			jQuery(this).closest("tr").find(".wsd-payment-popup-button").hide();
			jQuery(this).attr("data-state","activate");
		} else {
			jQuery(this).closest("tr").find(".wsd-payment-popup-button").show();
			jQuery(this).attr("data-state","deactivate");
		}
		wp.ajax.post( "get_data", {"plugin_id":plugin_slug,"plugin_state":plugin_state} )
		.done(function(response) {
			jQuery("#loading_div").remove();
		});
	});
	</script>';
	return $html;
} 
// register shortcode
add_shortcode('plugin_list', 'sidtechnno_plugin_list'); 

add_action( 'wp_ajax_nopriv_get_data', 'my_ajax_handler' );
add_action( 'wp_ajax_get_data', 'my_ajax_handler' );

function my_ajax_handler() {
	$plugin_id = $_POST['plugin_id'];
	$plugin_state = $_POST['plugin_state'];
	if($plugin_state == 'deactivate') {
	    deactivate_plugins($plugin_id);    
	} else {
	    activate_plugins($plugin_id);    
	}

    wp_send_json_success( 'It works' );
}

function custom_post_type() {
	$labels = array(
		'name' => _x( 'Plugin List Categories', 'taxonomy general name' ),
		'singular_name' => _x( 'Plugin List Category', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Plugin List Categories' ),
		'all_items' => __( 'All Plugin List Categories' ),
		'parent_item' => __( 'Parent Plugin List Category' ),
		'parent_item_colon' => __( 'Parent Plugin List Category:' ),
		'edit_item' => __( 'Edit Plugin List Category' ), 
		'update_item' => __( 'Update Plugin List Category' ),
		'add_new_item' => __( 'Add New Plugin List Category' ),
		'new_item_name' => __( 'New Plugin List Category Name' ),
		'menu_name' => __( 'Plugin List Categories' ),
	);    

	// Now register the taxonomy
	register_taxonomy('plugin_list_category',array('books'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_in_rest' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'plugin_list_category' ),
	)); 

 
    $labels = array(
        'name'                => _x( 'Plugin Lists', 'Post Type General Name', 'twentytwenty' ),
        'singular_name'       => _x( 'Plugin List', 'Post Type Singular Name', 'twentytwenty' ),
        'menu_name'           => __( 'Plugin Lists', 'twentytwenty' ),
        'parent_item_colon'   => __( 'Parent Plugin List', 'twentytwenty' ),
        'all_items'           => __( 'All Plugin Lists', 'twentytwenty' ),
        'view_item'           => __( 'View Plugin List', 'twentytwenty' ),
        'add_new_item'        => __( 'Add New Plugin List', 'twentytwenty' ),
        'add_new'             => __( 'Add New', 'twentytwenty' ),
        'edit_item'           => __( 'Edit Plugin List', 'twentytwenty' ),
        'update_item'         => __( 'Update Plugin List', 'twentytwenty' ),
        'search_items'        => __( 'Search Plugin List', 'twentytwenty' ),
        'not_found'           => __( 'Not Found', 'twentytwenty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
    );
     
    $args = array(
        'label'               => __( 'Plugin Lists', 'twentytwenty' ),
        'description'         => __( 'Custom Plugin List', 'twentytwenty' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'thumbnail', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'plugin_list_category' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'capability_type'     => 'post',
        'show_in_rest' => true,
 
    );
     
    // Registering your Custom Post Type
    register_post_type( 'plugin_lists', $args );
	add_action( 'add_meta_boxes', 'sidtechno_add_post_meta_boxes' );
	add_action( 'save_post', 'sidtechno_save_post_class_meta', 10, 2 );

}

function sidtechno_add_post_meta_boxes() {

	add_meta_box(
		'sidtechno-select-plugin',      // Unique ID
		esc_html__( 'Select Plugin', 'example' ),    // Title
		'sidtechno_post_class_meta_box',   // Callback function
		'plugin_lists',         // Admin page (or post type)
		'normal',         // Context
		'default'         // Priority
	);
}

add_action( 'init', 'custom_post_type', 0 );

function sidtechno_post_class_meta_box( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'sidtechno_post_class_nonce' );
	$all_plugins = get_plugins();
	$selected_plugin = esc_attr( get_post_meta( $post->ID, 'sidtechno_select_plugin', true ) );
	$option_urls = get_post_meta( $post->ID, 'sidtechno_option_url', true );
	$option_name = get_post_meta( $post->ID, 'sidtechno_option_name', true );
	$pass_true = 0;
	if(!empty($option_urls)) {
		$pass_true = 1;
		$option_urls = json_decode($option_urls);
		$option_name = json_decode($option_name);
	}
	echo '<p>
		<label for="sidtechno-select-plugin">Select Plugin</label>
		<br />
		<select name="sidtechno_select_plugin" class="widefat" id="select_plugin">
			<option value="">Select Plugin</option>';
			foreach ($all_plugins as $key => $value) {
				echo '<option '; if($selected_plugin == $key) { echo 'selected'; } echo ' value="'.$key.'" data-value="'.$value['Name'].'">'.$value['Name'].'</option>';
			}
		echo '</select>
		<br />

		<label for="sidtechno-option-url">Plugin Option URL <span id="add_more_option" style="font-size:24px;">+</span></label>
		<br />';
			if($pass_true == 1) {
				foreach ($option_urls as $url_key => $url_value) {
		    	echo '<input class="widefat" type="text" name="sidtechno_option_url[]" id="sidtechno_option_url" value="'.$url_value.'" size="30" placeholder="Option Url" />';
		    	echo '<input class="widefat" type="text" name="sidtechno_option_name[]" id="sidtechno_option_name" value="'.$option_name[$url_key].'" size="30" placeholder="Option Name" />';
				}
			} else {
	    	echo '<input class="widefat" type="text" name="sidtechno_option_url[]" id="sidtechno_option_url" value="'.esc_attr( get_post_meta( $post->ID, 'sidtechno_option_url', true ) ).'" size="30" placeholder="Option Url" />';
	    	echo '<input class="widefat" type="text" name="sidtechno_option_name[]" id="sidtechno_option_name" value="'.esc_attr( get_post_meta( $post->ID, 'sidtechno_option_name', true ) ).'" size="30" placeholder="Option Name" />';
			}
	    echo '<div id="display_option_array"></div>
	</p>';
}

function custom_admin_js() {
	echo '	<script>
		jQuery( document ).ready(function() {
			jQuery( "#select_plugin" ).change(function() {
				jQuery("#title").val(jQuery(this).find(":selected").attr("data-value"));
				jQuery("#title").closest("#titlewrap").find("#title-prompt-text").addClass("screen-reader-text");
			});
			jQuery( "#add_more_option" ).click(function() {
				jQuery("#display_option_array").append(\'<input class="widefat" type="text" name="sidtechno_option_url[]" id="sidtechno_option_url" value="" size="30" placeholder="Option URL" /><input class="widefat" type="text" name="sidtechno_option_name[]" id="sidtechno_option_name" value="" size="30" placeholder="Option Name" /><br>\');
			});


		});
	</script>';
}


add_action('admin_footer', 'custom_admin_js');	

function sidtechno_save_post_class_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['sidtechno_post_class_nonce'] ) || !wp_verify_nonce( $_POST['sidtechno_post_class_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  $new_sidtechno_select_plugin = ( isset( $_POST['sidtechno_select_plugin'] ) ? $_POST['sidtechno_select_plugin'] : ’ );

  $sidtechno_select_plugin = 'sidtechno_select_plugin';
  if($sidtechno_select_plugin == 'Select Plugin') {
  	$sidtechno_select_plugin = '';
  }
  
  $sidtechno_option_url = 'sidtechno_option_url';
  $new_sidtechno_option_url = ( isset( $_POST['sidtechno_option_url'] ) ? $_POST['sidtechno_option_url'] : ’ );

  if(!empty($new_sidtechno_option_url)) {
  	$new_sidtechno_option_url = json_encode($new_sidtechno_option_url);
  }

  $sidtechno_option_name = 'sidtechno_option_name';
  $new_sidtechno_option_name = ( isset( $_POST['sidtechno_option_name'] ) ? $_POST['sidtechno_option_name'] : ’ );
  if(!empty($new_sidtechno_option_name)) {
  	$new_sidtechno_option_name = json_encode($new_sidtechno_option_name, JSON_UNESCAPED_UNICODE);
  }
  $sidtechno_option_name = 'sidtechno_option_name';


  /* Get the meta value of the custom field key. */
  $meta_value = get_post_meta( $post_id, $sidtechno_select_plugin, true );

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_sidtechno_select_plugin && ’ == $meta_value )
    add_post_meta( $post_id, $sidtechno_select_plugin, $new_sidtechno_select_plugin, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_sidtechno_select_plugin && $new_sidtechno_select_plugin != $meta_value )
    update_post_meta( $post_id, $sidtechno_select_plugin, $new_sidtechno_select_plugin );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( ’ == $new_sidtechno_select_plugin && $meta_value )
    delete_post_meta( $post_id, $sidtechno_select_plugin, $meta_value );


  /* Get the meta value of the custom field key. */
  $meta_value = get_post_meta( $post_id, $sidtechno_option_name, true );

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_sidtechno_option_name && ’ == $meta_value )
    add_post_meta( $post_id, $sidtechno_option_name, $new_sidtechno_option_name, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_sidtechno_option_name && $new_sidtechno_option_name != $meta_value )
    update_post_meta( $post_id, $sidtechno_option_name, $new_sidtechno_option_name );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( ’ == $new_sidtechno_option_name && $meta_value )
    delete_post_meta( $post_id, $sidtechno_option_name, $meta_value );


  /* Get the meta value of the custom field key. */
  $meta_value = get_post_meta( $post_id, $sidtechno_option_url, true );

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_sidtechno_option_url && ’ == $meta_value )
    add_post_meta( $post_id, $sidtechno_option_url, $new_sidtechno_option_url, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_sidtechno_option_url && $new_sidtechno_option_url != $meta_value )
    update_post_meta( $post_id, $sidtechno_option_url, $new_sidtechno_option_url );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( ’ == $new_sidtechno_option_url && $meta_value )
    delete_post_meta( $post_id, $sidtechno_option_url, $meta_value );
}
?>
