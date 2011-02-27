<?php
/**
 * SP Title Filler
 *
 * Because sometimes you just don't nEEd a title
 *
 * @author 		Jamie Rumbelow
 * @version 	1.0.0
 * @copyright 	Copyright (c) 2011 Jamie Rumbelow
 **/

class Sp_title_filler_ft extends EE_Fieldtype {
	
	/* --------------------------------------------------------------
	 * VARIABLES
	 * ------------------------------------------------------------ */
	
	public $info = array(
		'name' 			=> 'SP Title Filler',
		'version'		=> '1.0.0',
		'description'	=> 'Because sometimes you just don\'t nEEd a title'
	);
	
	/* --------------------------------------------------------------
	 * GENERIC METHODS
	 * ------------------------------------------------------------ */
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->EE =& get_instance();
	}
	
	/* --------------------------------------------------------------
	 * FIELDTYPE API
	 * ------------------------------------------------------------ */
	
	/**
	 * Hide the field area and output the JavaScript
	 */
	public function display_field($data) {
		if (!$data) {
			$this->data['channel_title'] = $this->_get_channel_title();
			$this->data['next_number'] = $this->_get_next_incrementer();
			$this->data['form_name'] = $this->field_name;
			
			return $this->EE->load->view('cp', $this->data, TRUE);
		} else {
			return '';
		}
	}
	
	/* --------------------------------------------------------------
	 * HELPER METHODS
	 * ------------------------------------------------------------ */
	
	/**
	 * Get the channel title from an ID
	 */
	protected function _get_channel_title() {
		// Lookup the channel title from the database
		$channel_id = $this->EE->input->get('channel_id');
		$channel = $this->EE->db->select('channel_title')->where('channel_id', $channel_id)
								->get('channels')->row();
		
		// Return it!
		return $channel->channel_title;
	}
	
	/**
	 * Get the next incrementing integer for a channel
	 */
	protected function _get_next_incrementer() {
		// Get the old integer
		$channel_id = $this->EE->input->get('channel_id');
		$old_number = $this->EE->db->select($this->field_name)
								   ->where('channel_id', $this->EE->input->get('channel_id'))
								   ->order_by('entry_id DESC')
								   ->limit(1)
								   ->get('channel_data')
								   ->row();
		
		// Do we have one?
		if ($old_number) {
			// Increment
			$new_number = (int)$old_number->{$this->field_name} + 1;
		} else {
			// Start at 1
			$new_number = 1;
		}
		
		// Return it
		return $new_number;
	}
}