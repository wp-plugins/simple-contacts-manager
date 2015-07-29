<?php
/**
 * Plugin Name: Simple Contacts Manager
 * Plugin URI: https://wordpress.org/plugins/simple-contacts-manager/
 * Description: A simple contact manager for your personal use and business.  Multiple contact groups can be created to manage your contacts easier.  You may also print the contact easily in a page/post or anywhere on the page.  And as a plus, it includes easy input for your Google Analytics ID, and an option to add the Analytics codes to your site.
 * Version: 1.3.1
 * Author: Earl Evan Amante
 * Author URI: https://github.com/earlamante/
 * License: GPL2
 */
	/**
	 * Common fix for adding menu page in plugins
	 */
	include(ABSPATH . "wp-includes/pluggable.php"); 
	
	Class W3B_contacts_manager {
		var $plugin_name = 'Simple Contacts Manager';
		var $menu_title = 'Contacts Manager';
		var $menu_slug	= 'contacts-manager';
		var $plugin_description = '
			<p>This plugin is a simple plugin that will enable you to create multiple contact groups to sort your contact details easier.</p>
			<p>And as a plus, it includes easy input for your Google Analytics ID, and an option to add the Analytics codes to your site.</p>
		';
		var $icon_url;
		var $in_page;

		var $sections = array(
			'general',
			'address',
			'office',
			'social'
		);
		var $protected = array(
			'general-group_name',
			'general-email_address',
			'address-address_1',
			'address-address_2',
			'address-city',
			'address-suburb',
			'address-state',
			'address-country',
			'social-facebook',
			'social-google_plus',
			'social-twitter',
			'social-linked_in',
			'social-youtube'
		);

		var $roles = array(
			'Administrator'	=> 'manage_options',
			'Editor'			=> 'publish_pages',
			'Author'			=> 'publish_posts',
			'Contributor'		=> 'edit_posts',
			'Subscriber'		=> 'read',
		);
		var $statuses = array(
			'',
			'updated',
			'error'
		);
		var $status;
		var $msg;

		var $data;
		var $current_group;

		public function __construct() {
			$this->init();
		}

		private function _in_page() {
			if( empty( $_REQUEST['page'] ) )
				return FALSE;
			if( $_REQUEST['page'] === $this->menu_slug )
				return TRUE;
			return FALSE;
		}

		private function _check_requests() {
			if( !empty( $_REQUEST['group'] ) ) {
				$groups = $this->get_contact_groups();
				$this->current_group = $_REQUEST['group'];
				$this->current_group_name = !empty($groups[$_REQUEST['group']])?$groups[$_REQUEST['group']]:'';
			}

			if( !empty( $_REQUEST['action'] ) ) {
				extract( $_REQUEST );

				$action = $this->cleanup( $action );
				switch( $action ) {
					case 'add_contact_group':
						if( empty( $contact_group ) ):
							$this->status = 2;
							$this->msg = 'Group name is empty';
						elseif( $this->_check_group( $contact_group ) ):
							$this->status = 2;
							$this->msg = 'Group name is already taken';
						else:
							$group_name = $this->cleanup( $contact_group );

							$this->data['w3b_cm_contacts_schema'][$group_name]['general']['group_name']['label'] = 'Group Name (Label)';
							$this->data['w3b_cm_contacts_schema'][$group_name]['general']['group_name']['value'] = $contact_group;
							$this->data['w3b_cm_contacts_schema'][$group_name]['general']['email_address']['label'] = 'Email Address';
							$this->data['w3b_cm_contacts_schema'][$group_name]['general']['email_address']['value'] = '';

							$this->data['w3b_cm_contacts_schema'][$group_name]['address']['address_1']['label'] = 'Address 1';
							$this->data['w3b_cm_contacts_schema'][$group_name]['address']['address_1']['value'] = '';
							$this->data['w3b_cm_contacts_schema'][$group_name]['address']['address_2']['label'] = 'Address 2';
							$this->data['w3b_cm_contacts_schema'][$group_name]['address']['address_2']['value'] = '';
							$this->data['w3b_cm_contacts_schema'][$group_name]['address']['city']['label'] = 'City';
							$this->data['w3b_cm_contacts_schema'][$group_name]['address']['city']['value'] = '';
							$this->data['w3b_cm_contacts_schema'][$group_name]['address']['suburb']['label'] = 'Suburb';
							$this->data['w3b_cm_contacts_schema'][$group_name]['address']['suburb']['value'] = '';
							$this->data['w3b_cm_contacts_schema'][$group_name]['address']['state']['label'] = 'State';
							$this->data['w3b_cm_contacts_schema'][$group_name]['address']['state']['value'] = '';
							$this->data['w3b_cm_contacts_schema'][$group_name]['address']['country']['label'] = 'Country';
							$this->data['w3b_cm_contacts_schema'][$group_name]['address']['country']['value'] = '';

							$this->data['w3b_cm_contacts_schema'][$group_name]['social']['facebook']['label'] = 'Facebook';
							$this->data['w3b_cm_contacts_schema'][$group_name]['social']['facebook']['value'] = '';
							$this->data['w3b_cm_contacts_schema'][$group_name]['social']['google_plus']['label'] = 'Google Plus';
							$this->data['w3b_cm_contacts_schema'][$group_name]['social']['google_plus']['value'] = '';
							$this->data['w3b_cm_contacts_schema'][$group_name]['social']['twitter']['label'] = 'Twitter';
							$this->data['w3b_cm_contacts_schema'][$group_name]['social']['twitter']['value'] = '';
							$this->data['w3b_cm_contacts_schema'][$group_name]['social']['linked_in']['label'] = 'Linked In';
							$this->data['w3b_cm_contacts_schema'][$group_name]['social']['linked_in']['value'] = '';
							$this->data['w3b_cm_contacts_schema'][$group_name]['social']['youtube']['label'] = 'Youtube';
							$this->data['w3b_cm_contacts_schema'][$group_name]['social']['youtube']['value'] = '';

							if( $this->status = $this->_set_option('w3b_cm_contacts_schema') ) {
								$this->msg = 'Group added';
							}
						endif;
					break;

					case 'update_analytics_settings':

						$this->data['w3b_cm_settings']['google_analytics_id'] = $google_analytics;
						$this->data['w3b_cm_settings']['insert_analytics_code'] = !empty($insert_analytics_code);

						if( $this->status = $this->_set_option('w3b_cm_settings') )
							$this->msg = 'Google Analytics Settings updated';
					break;

					case 'delete':
						if( $this->_check_group( $group ) ) {
							$group = $this->cleanup( $group );
							if( !empty( $this->data['w3b_cm_contacts_schema'][$group] ) )
								unset( $this->data['w3b_cm_contacts_schema'][$group] );
							if( $this->status = $this->_set_option('w3b_cm_contacts_schema') ) {
								$this->msg = 'Group deleted';
							}
						}
					break;

					case 'update_group_details':
						$groups = $this->data['w3b_cm_contacts_schema'];
						$current_group = array();

						foreach( $this->sections as $section ) {
							$section_key = $section.'_keys';

							if( !empty( $$section_key ) && is_array( $$section_key ) ) {
								$keys = $$section_key;

								for( $y=0; $y<sizeof( $keys ) ;$y++ ) {
									$key = $this->cleanup( $keys[$y] );
									$section_label = $section.'_'.$key.'_label';
									$section_value = $section.'_'.$key.'_value';
									$current_group[$section][$key] = array(
										'label'	=> $$section_label,
										'value'	=> $$section_value
									);
								}
							}
						}
						$this->_set_group_schema( $group, $current_group );
						if( $this->status = $this->_set_option('w3b_cm_contacts_schema') )
							$this->msg = 'Group updated';
					break;

					case 'update_plugin_settings':
						$this->data['w3b_cm_settings']['min_access_level'] = $min_access_level;

						if( $this->status = $this->_set_option('w3b_cm_settings') )
							$this->msg = 'Plugin Settings updated';
					break;
				}
			}
		}

		private function _get_minimun_role() {
			if( !empty( $this->data['w3b_cm_settings']['min_access_level'] ) )
				return $this->data['w3b_cm_settings']['min_access_level'];
			return $this->roles['Administrator'];
		}

		public function init() {
			add_action( 'admin_menu', array($this, 'admin_menu') );
			add_action( 'admin_enqueue_scripts', array($this, 'admin_head') );

			add_shortcode( 'cm_contact', array($this, 'do_shortcode') );

			$this->page = !empty($_REQUEST['page'])? $_REQUEST['page']:'';
			$this->page_link = '?page=' . $this->page;
			$this->in_page = $this->_in_page();

			$this->_init_data_schema();
			$this->_check_requests();


			if( $this->_check_insert_codes() )
				add_action( 'wp_footer', array($this, 'insert_analytics_code') );
		}

		public function admin_menu() {
			add_menu_page(
				$this->plugin_name,
				$this->menu_title,
				$this->_get_minimun_role(),
				$this->menu_slug,
				array($this, 'print_page'),
				plugins_url( 'img/contacts.png', __FILE__ )
			);
			add_submenu_page(
				$this->menu_slug,
				$this->plugin_name,
				$this->menu_title,
				$this->_get_minimun_role(),
				$this->menu_slug,
				array($this, 'print_page')
			);
			add_submenu_page(
				$this->menu_slug,
				$this->plugin_name.' Settings',
				'Settings',
				$this->_get_minimun_role(),
				$this->menu_slug.'-settings',
				array($this, 'print_page')
			);
		}

		public function admin_head() {
			wp_register_style( 'cm_custom_css', plugins_url( 'css/style.css', __FILE__ ), false, '1.3' );
			wp_enqueue_style( 'cm_custom_css' );

			wp_enqueue_script( 'cm_custom_js', plugins_url( 'js/main.js', __FILE__ ), false, '1.3' );
		}

		public function do_shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'key' => ''
			), $atts, 'cm_contact' );

			return $this->get_contact( $atts['key'] );
		}

		public function insert_analytics_code() {
			echo $this->get_template( 'google_analytics_code' );
		}

		public function print_page() {
			echo $this->get_template( 'main-container' );
		}

		public function get_template($template_file='') {
			if( file_exists( dirname( __FILE__ ) . '/views/' . $template_file . '.php' ) ) {
				ob_start();
				include( dirname( __FILE__ ) . '/views/' . $template_file . '.php' );
				return ob_get_clean();
			}
			return FALSE;
		}

		public function get_msg() {
			return $this->msg? '<div id="message" class="'. $this->statuses[$this->status] .' notice is-dismissible below-h2"><p>'.$this->msg.'</p></div>':'';
		}

		public function cleanup($text='') {
			$text = preg_replace('/[^\w ]+/', '', strtolower($text) );
			return $text = preg_replace('/[ ]+/', '_', $text );
		}

		// Main functionality
		// Check Section
		private function _check_group( $group_name ) {
			$groups = $this->get_contact_groups();
			if( empty( $groups[ $this->cleanup( $group_name ) ] ) )
				return FALSE;
			return TRUE;
		}

		private function _check_insert_codes() {
			if( !empty( $this->data['w3b_cm_settings']['insert_analytics_code'] ) )
				return $this->data['w3b_cm_settings']['insert_analytics_code'];
			return FALSE;
		}

		// Set Section
		private function _init_data_schema() {
			if( empty($this->data['w3b_cm_settings'] ) )
				$this->data['w3b_cm_settings'] = $this->get_option('w3b_cm_settings');
			if( empty( $this->data['w3b_cm_contacts_schema'] ) )
				$this->data['w3b_cm_contacts_schema'] = $this->get_option( 'w3b_cm_contacts_schema' );
		}
		private function _set_option( $option_name ) {
			return update_option( $option_name, serialize( $this->data[$option_name]) );
		}

		private function _set_group_schema( $group='', $data='' ) {
			if( $group )
				$this->data['w3b_cm_contacts_schema'][$group] = $data;
		}

		// Get Section
		public function get_option($option_name) {
			if( !empty( $this->data[$option_name] ) )
				return $this->data[$option_name];
			else 
				if( $this->orig_data[$option_name] = $this->data[$option_name] = unserialize( get_option( $option_name ) ) )
					return $this->data[$option_name];
				else
					return $this->data[$option_name] = '';
		}

		public function get_contact_groups() {
			$groups = $this->get_option( 'w3b_cm_contacts_schema' );
			if( $groups ) {
				$this->data['w3b_cm_contact_groups'] = array();

				foreach( $groups as $key => $val )
					$this->data['w3b_cm_contact_groups'][$key] = $val['general']['group_name']['value'];

				return $this->data['w3b_cm_contact_groups'];
			}
			
			return FALSE;
		}

		// Helper Functions
		public function get_contact( $key='' ) {
			if( !$key )
				return FALSE;
			
			$keys = explode( '-', $key );
			$group = !empty($keys[0])?$keys[0]:'';
			$section = !empty($keys[1])?$keys[1]:'';
			$key = !empty($keys[2])?$keys[2]:'';

			if( !empty( $this->data['w3b_cm_contacts_schema'][$group][$section][$key] ) && sizeof($keys) == 3 )
				return $this->data['w3b_cm_contacts_schema'][$group][$section][$key]['value'];
			elseif( !empty( $this->data['w3b_cm_contacts_schema'][$group][$section] ) && sizeof($keys) == 2 )
				return$this->data['w3b_cm_contacts_schema'][$group][$section];
			elseif( !empty( $this->data['w3b_cm_contacts_schema'][$group] ) && sizeof($keys) == 1 )
				return $this->data['w3b_cm_contacts_schema'][$group];
			return '';
		}

		public function get_analytics_id() {
			if( !empty( $this->data['w3b_cm_settings']['google_analytics_id'] ) )
				return $this->data['w3b_cm_settings']['google_analytics_id'];
			return FALSE;
		}
	}

	$w3b_cm = new W3B_contacts_manager;

	function cm_contact( $key='' ) {
		global $w3b_cm;

		return $w3b_cm->get_contact($key);
	}

	function cm_get_analytics_id() {
		global $w3b_cm;

		return $w3b_cm->get_analytics_id();
	}
?>