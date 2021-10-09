<?php

if ( ! function_exists('upload_url'))
{
	/**
	 * Site URL
	 *
	 * Create a local URL based on your basepath. Segments can be passed via the
	 * first parameter either as a string or an array.
	 *
	 * @param	string	$uri
	 * @param	string	$protocol
	 * @return	string
	 */
	function upload_url()
	{
		return base_url('uploads/');
	}
    if (!function_exists('assets_url'))
    {
        function assets_url()
        {
            return base_url('assets');
        }
    } 
}
