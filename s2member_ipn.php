<?php
	//Editable stuff;

	//The message the user sees on the WSO return page, via key generation
	$oto_message="The OTO has been added to your user account";


	// Don't edit unless you know what you're doing


	include 'wp-blog-header.php';
	include 'wp-includes/registration.php';
	//include 'wp-includes/user.php';
	//echo bloginfo('name');
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
		fwrite($fp, $content."\r\n");
		

	


		$username=explode('@', $_POST['payer_email']);
		$username=$username[0];







		$password=wp_generate_password();

		// If the user doesn't exit, create it.
		if(!username_exists($username) && !email_exists(($_POST['payer_email'])))
		{
			fwrite($fp, "inside 1 \r\n");
			$user_id=wp_create_user($username, $password,$_POST['payer_email']);
			if(is_int($user_id))
			{
				$user=new WP_User($user_id);
				$user->set_role($role);
			}

			//Prepare to send the mail 
			$title=' Registration';
			$message="Welcome! Here is your registration data \r\n\r\n";
			$message.="Your username : {$username} \r\n";
			$message.="Your password : {$password} \r\n";

			wp_mail($_POST['payer_email'], $title, $message);

			echo $message;
		}
		else
		{
			$user=get_user_by('email', $_POST['payer_email']);

			if($user)
			{
				$user->set_role($role);
			}
			//If the user name already exists, only updated capabilities.

			echo $oto_message;

		}


	}


