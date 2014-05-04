<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Y12_Shortcode_Hello_Post_Type {

	public function __construct () {

		// Regsiter post type
		add_action( 'init' , array( $this, 'register_post_type' ) );

		// Register taxonomy
		add_action('init', array( $this, 'register_taxonomy' ) );

		if ( is_admin() ) {

			// Handle custom fields for post
			add_action( 'admin_menu', array( $this, 'meta_box_setup' ), 20 );
			add_action( 'save_post', array( $this, 'meta_box_save' ) );

			// Modify text in main title text box
			add_filter( 'enter_title_here', array( $this, 'enter_title_here' ) );

			// Display custom update messages for posts edits
			add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );

			// Handle post columns
			add_filter( 'manage_edit-' . $this->_token . '_columns', array( $this, 'register_custom_column_headings' ), 10, 1 );
			add_action( 'manage_posts_custom_column', array( $this, 'register_custom_columns' ), 10, 2 );

		}

	}

	/**
	 * Register new post type
	 * @return void
	 */
	public function register_post_type () {

		$labels = array(
			'name' => _x( 'Post Type', 'post type general name' , 'y12-shortcode-hello' ),
			'singular_name' => _x( 'Post Type', 'post type singular name' , 'y12-shortcode-hello' ),
			'add_new' => _x( 'Add New', $this->_token , 'y12-shortcode-hello' ),
			'add_new_item' => sprintf( __( 'Add New %s' , 'y12-shortcode-hello' ), __( 'Post' , 'y12-shortcode-hello' ) ),
			'edit_item' => sprintf( __( 'Edit %s' , 'y12-shortcode-hello' ), __( 'Post' , 'y12-shortcode-hello' ) ),
			'new_item' => sprintf( __( 'New %s' , 'y12-shortcode-hello' ), __( 'Post' , 'y12-shortcode-hello' ) ),
			'all_items' => sprintf( __( 'All %s' , 'y12-shortcode-hello' ), __( 'Posts' , 'y12-shortcode-hello' ) ),
			'view_item' => sprintf( __( 'View %s' , 'y12-shortcode-hello' ), __( 'Post' , 'y12-shortcode-hello' ) ),
			'search_items' => sprintf( __( 'Search %a' , 'y12-shortcode-hello' ), __( 'Posts' , 'y12-shortcode-hello' ) ),
			'not_found' =>  sprintf( __( 'No %s Found' , 'y12-shortcode-hello' ), __( 'Posts' , 'y12-shortcode-hello' ) ),
			'not_found_in_trash' => sprintf( __( 'No %s Found In Trash' , 'y12-shortcode-hello' ), __( 'Posts' , 'y12-shortcode-hello' ) ),
			'parent_item_colon' => '',
			'menu_name' => __( '*Posts' , 'y12-shortcode-hello' )
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'query_var' => false,
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => true,
			'supports' => array( 'title' , 'editor' , 'excerpt' , 'comments' ),
			'menu_position' => 5,
			'menu_icon' => ''
		);

		register_post_type( $this->_token, $args );
	}

	/**
	 * Register new taxonomy
	 * @return void
	 */
	public function register_taxonomy () {

        $labels = array(
            'name' => __( 'Terms' , 'y12-shortcode-hello' ),
            'singular_name' => __( 'Term', 'y12-shortcode-hello' ),
            'search_items' =>  __( 'Search Terms' , 'y12-shortcode-hello' ),
            'all_items' => __( 'All Terms' , 'y12-shortcode-hello' ),
            'parent_item' => __( 'Parent Term' , 'y12-shortcode-hello' ),
            'parent_item_colon' => __( 'Parent Term:' , 'y12-shortcode-hello' ),
            'edit_item' => __( 'Edit Term' , 'y12-shortcode-hello' ),
            'update_item' => __( 'Update Term' , 'y12-shortcode-hello' ),
            'add_new_item' => __( 'Add New Term' , 'y12-shortcode-hello' ),
            'new_item_name' => __( 'New Term Name' , 'y12-shortcode-hello' ),
            'menu_name' => __( 'Terms' , 'y12-shortcode-hello' ),
        );

        $args = array(
            'public' => true,
            'hierarchical' => true,
            'rewrite' => true,
            'labels' => $labels
        );

        register_taxonomy( 'post_type_terms' , $this->_token , $args );
    }

    /**
     * Regsiter column headings for post type
     * @param  array $defaults Default columns
     * @return array           Modified columns
     */
    public function register_custom_column_headings ( $defaults ) {
		$new_columns = array(
			'custom-field' => __( 'Custom Field' , 'y12-shortcode-hello' )
		);

		$last_item = '';

		if ( isset( $defaults['date'] ) ) { unset( $defaults['date'] ); }

		if ( count( $defaults ) > 2 ) {
			$last_item = array_slice( $defaults, -1 );

			array_pop( $defaults );
		}
		$defaults = array_merge( $defaults, $new_columns );

		if ( $last_item != '' ) {
			foreach ( $last_item as $k => $v ) {
				$defaults[$k] = $v;
				break;
			}
		}

		return $defaults;
	}

	/**
	 * Load data for post type columns
	 * @param  string  $column_name Name of column
	 * @param  integer $id          Post ID
	 * @return void
	 */
	public function register_custom_columns ( $column_name, $id ) {

		switch ( $column_name ) {

			case 'custom-field':
				$data = get_post_meta( $id, '_custom_field', true );
				echo $data;
			break;

			default:
			break;
		}

	}

	/**
	 * Set up admin messages for post type
	 * @param  array $messages Default message
	 * @return array           Modified messages
	 */
	public function updated_messages ( $messages ) {
	  global $post, $post_ID;

	  $messages[$this->_token] = array(
	    0 => '', // Unused. Messages start at index 1.
	    1 => sprintf( __( 'Post updated. %sView post%s.' , 'y12-shortcode-hello' ), '<a href="' . esc_url( get_permalink( $post_ID ) ) . '">', '</a>' ),
	    2 => __( 'Custom field updated.' , 'y12-shortcode-hello' ),
	    3 => __( 'Custom field deleted.' , 'y12-shortcode-hello' ),
	    4 => __( 'Post updated.' , 'y12-shortcode-hello' ),
	    /* translators: %s: date and time of the revision */
	    5 => isset($_GET['revision']) ? sprintf( __( 'Post restored to revision from %s.' , 'y12-shortcode-hello' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	    6 => sprintf( __( 'Post published. %sView post%s.' , 'y12-shortcode-hello' ), '<a href="' . esc_url( get_permalink( $post_ID ) ) . '">', '</a>' ),
	    7 => __( 'Post saved.' , 'y12-shortcode-hello' ),
	    8 => sprintf( __( 'Post submitted. %sPreview post%s.' , 'y12-shortcode-hello' ), '<a target="_blank" href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) . '">', '</a>' ),
	    9 => sprintf( __( 'Post scheduled for: %1$s. %2$sPreview post%3$s.' , 'y12-shortcode-hello' ), '<strong>' . date_i18n( __( 'M j, Y @ G:i' , 'y12-shortcode-hello' ), strtotime( $post->post_date ) ) . '</strong>', '<a target="_blank" href="' . esc_url( get_permalink( $post_ID ) ) . '">', '</a>' ),
	    10 => sprintf( __( 'Post draft updated. %sPreview post%s.' , 'y12-shortcode-hello' ), '<a target="_blank" href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) . '">', '</a>' ),
	  );

	  return $messages;
	}

	/**
	 * Add meta box to post type
	 * @return void
	 */
	public function meta_box_setup () {
		add_meta_box( 'post-data', __( 'Post Details' , 'y12-shortcode-hello' ), array( $this, 'meta_box_content' ), $this->_token, 'normal', 'high' );
	}

	/**
	 * Load meta box content
	 * @return void
	 */
	public function meta_box_content () {
		global $post_id;
		$fields = get_post_custom( $post_id );
		$field_data = $this->get_custom_fields_settings();

		$html = '';

		$html .= '<input type="hidden" name="' . $this->_token . '_nonce" id="' . $this->_token . '_nonce" value="' . wp_create_nonce( plugin_basename( $this->dir ) ) . '" />';

		if ( 0 < count( $field_data ) ) {
			$html .= '<table class="form-table">' . "\n";
			$html .= '<tbody>' . "\n";

			foreach ( $field_data as $k => $v ) {
				$data = $v['default'];

				if ( isset( $fields[$k] ) && isset( $fields[$k][0] ) ) {
					$data = $fields[$k][0];
				}

				if( $v['type'] == 'checkbox' ) {
					$html .= '<tr valign="top"><th scope="row">' . $v['name'] . '</th><td><input name="' . esc_attr( $k ) . '" type="checkbox" id="' . esc_attr( $k ) . '" ' . checked( 'on' , $data , false ) . ' /> <label for="' . esc_attr( $k ) . '"><span class="description">' . $v['description'] . '</span></label>' . "\n";
					$html .= '</td><tr/>' . "\n";
				} else {
					$html .= '<tr valign="top"><th scope="row"><label for="' . esc_attr( $k ) . '">' . $v['name'] . '</label></th><td><input name="' . esc_attr( $k ) . '" type="text" id="' . esc_attr( $k ) . '" class="regular-text" value="' . esc_attr( $data ) . '" />' . "\n";
					$html .= '<p class="description">' . $v['description'] . '</p>' . "\n";
					$html .= '</td><tr/>' . "\n";
				}

			}

			$html .= '</tbody>' . "\n";
			$html .= '</table>' . "\n";
		}

		echo $html;
	}

	/**
	 * Save meta box
	 * @param  integer $post_id Post ID
	 * @return void
	 */
	public function meta_box_save ( $post_id ) {
		global $post, $messages;

		// Verify nonce
		if ( ( get_post_type() != $this->_token ) || ! wp_verify_nonce( $_POST[ $this->_token . '_nonce'], plugin_basename( $this->dir ) ) ) {
			return $post_id;
		}

		// Verify user permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Handle custom fields
		$field_data = $this->get_custom_fields_settings();
		$fields = array_keys( $field_data );

		foreach ( $fields as $f ) {

			if( isset( $_POST[$f] ) ) {
				${$f} = strip_tags( trim( $_POST[$f] ) );
			}

			// Escape the URLs.
			if ( 'url' == $field_data[$f]['type'] ) {
				${$f} = esc_url( ${$f} );
			}

			if ( ${$f} == '' ) {
				delete_post_meta( $post_id , $f , get_post_meta( $post_id , $f , true ) );
			} else {
				update_post_meta( $post_id , $f , ${$f} );
			}
		}

	}

	/**
	 * Load custom title placeholder text
	 * @param  string $title Default title placeholder
	 * @return string        Modified title placeholder
	 */
	public function enter_title_here ( $title ) {
		if ( get_post_type() == $this->_token ) {
			$title = __( 'Enter the post title here' , 'y12-shortcode-hello' );
		}
		return $title;
	}

	/**
	 * Load custom fields for post type
	 * @return array Custom fields array
	 */
	public function get_custom_fields_settings () {
		$fields = array();

		$fields['_custom_field'] = array(
		    'name' => __( 'Custom field:' , 'y12-shortcode-hello' ),
		    'description' => __( 'Description of this custom field.' , 'y12-shortcode-hello' ),
		    'type' => 'text',
		    'default' => '',
		    'section' => 'plugin-data'
		);

		return $fields;
	}

}