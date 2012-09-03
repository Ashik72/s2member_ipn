<?php
	if($_POST)
	{
		$name=$_POST['item_name1'];
		if($name=='')
			$name=$_POST['item_name'];
		$name=strtolower($name);

		if(strstr($name, 'oto'))
			$role='s2member_level2';
		else
			$role='s2member_level1';

		$options=$_POST;

		$content=print_r($_POST, true);

		$fp=fopen('log.txt','w');
		fwrite($fp, $content);
		fclose($fp);

	


		$username=explode('@', $_POST['payer_email']);
		$username=$username[0];





		include 'wp-blog-header.php';
		include 'wp-includes/registration.php';
		include 'wp-includes/user.php';


		$password=wp_generate_password();

		// If the user doesn't exit, create it.
		if(!username_exists($username) && !email_exists(($_POST['payer_email'])))
		{
			$user_id=wp_create_user($username, $password,$_POST['payer_email']);
			if(is_int($user_id))
			{
				$user=new WP_User($user_id);
				$user->set_role($role);
			}
		}
		else
		{
			//If the user name already exists, only updated capabilities.

		}


	}


