<?php
	//You get this URL by going to : s2Member -> Payapl Options -> Paypal IPN Integration -> IPN /w Proxy key
	//You just copy that in and replace [proxy-gateway] with WSO_Integration
//	$post_url='http://localhost/wordpress/?s2member_paypal_notify=1&s2member_paypal_proxy=WSO_Integration&s2member_paypal_proxy_verification=b6234ab61f38faa6ec11c29b609300d5';

	$post_url='http://www.authoritybloggingformula.com/?s2member_paypal_notify=1&s2member_paypal_proxy=WSO&s2member_paypal_proxy_verification=e37e2d1cfcb7900f24d6e6c77b25dac7';
	// Stop editing from here on 


	//Prepare the custom var required by s2Member, it should contain the domain name.
	$custom=explode('/', $post_url);
	$custom=$custom['2'];
	$custom=str_replace('www.','', $custom);


	if($_POST)
	{
		$name=$_POST['item_name1'];
		if($name=='')
			$name=$_POST['item_name'];
		$name=strtolower($name);

		if(strstr($name, 'oto'))
			$item_number=2;
		else
			$item_number=1;

		$options=$_POST;

		$content=print_r($_POST, true);

		$fp=fopen('log.txt','w');
		fwrite($fp, $content);
		fclose($fp);

		$options['item_number']=$item_number;
		$options['custom']=$custom;

		http_post($post_url, $options);
	}


	
	function http_post ($url, $data)
	{
	    $data_url = http_build_query ($data);
	    $data_len = strlen ($data_url);

	    return array ('content'=>file_get_contents ($url, false, stream_context_create (array ('http'=>array ('method'=>'POST'
	            , 'header'=>"Connection: close\r\nContent-Length: $data_len\r\n"
	            , 'content'=>$data_url
	            ))))
	        , 'headers'=>$http_response_header
	        );
	}