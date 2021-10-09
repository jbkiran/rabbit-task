<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {

	public function __construct() {

        parent::__construct();
		$this->load->helper('directory');
	}
	public function index()
	{
		$this->load->view('listing');
	}
	public function list_directory()
	{
		$response_data 			= array();
		// $search_key 			= $this->input->get('search');

		$fetch_directory 		= config_item('directory');
		$directory_components 	= directory_map($fetch_directory,1); //in default all the content inside the directory will be read ,second parameter is the depth to be searched
		
		if($directory_components)
		{
			// if(!empty($search_key))
			// {
			// 	$pattern 		= "/(\.$search_key.)$/";
			// 	$keys 			= array_values($directory_components);
			// 	$result 		= preg_grep($pattern, $keys);
				
			// 	echo "<pre>";print_r($result);exit;
			// }
			$response_data['data'] 		= $directory_components;
			$response_data['success'] 	= true;
		}
		else
		{
			$response_data['data'] 		= array();
			$response_data['success'] 	= false;
		}
		
		echo json_encode($response_data);
	}

	public function remove_files()
	{
		$input_file 		= $this->input->post('file');
		
		$fetch_directory	= config_item('directory');
		$file_to_remove		= $fetch_directory.$input_file;
		
		if(file_exists($file_to_remove))
		{
			unlink($file_to_remove);
			$response_data['success'] = true;
			$response_data['message'] = 'file removed successfully';
		}
		else
		{
			$response_data['success'] = false;
			$response_data['message'] = 'file not found';
		}
		
	}

	public function upload_file()
	{
		$response_data				= array();
		$config 					= array();
		$config['upload_path'] 		= config_item('directory');
        $config['allowed_types'] 	= 'txt|doc|docx|pdf|png|jpeg|jpg|gif';
        $config['max_size'] 		= 2000;

		if ( !is_dir( config_item('directory') ) ) {
			mkdir(config_item('directory'),0777,true);       
		}

        $this->load->library('upload', $config);

		if (!$this->upload->do_upload('fileupload')) {

            $error = $this->upload->display_errors();

			$response_data['success'] = true;
			$response_data['message'] = 'failed to add file';  
			$response_data['data'] 	  = $error; 
			$this->load->view('listing', $response_data);
        } else {
            // $data = array('image_metadata' => $this->upload->data());
			$response_data['success'] = true;
			$response_data['message'] = 'file removed successfully';   
			// $response_data['data'] = $data; 
			redirect('homepage', 'refresh');
        }
		
	}
}
