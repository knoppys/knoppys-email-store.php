<?php
/**
* This will send a graceful error email if there is no email address assigned to a store.
* This means the admin will know if the order is placed and to contact the store. 
* 
* @since V.2
*/


	/**
	* Create the email template 
	*
	* @param string $orderID The ID of the order thats failed to be sent to the store.
	* @param string $siteurl The entry from the site URL field in wp_options. This will make the links in the email dynamic. 
	*/  
	function email_content($orderId, $siteurl) {

		ob_start(); ?>

		<html xmlns="http://www.w3.org/1999/xhtml">

		<head>
		    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		</head>
		<body>
		<table cellspacing="0" cellpadding="0" class="" width="100%" style="width:100%;background: #fff;" border-collapse="collapse">
		    <tbody>
		        <tr>    
		            <td>
		                
		            
		                <center style="">
	                      	<table cellspacing="0" cellpadding="0" class="" width="500" style="width:500px;background: #003;border:3px solid #003" border-collapse="collapse">
	                          	<tbody>
	                              	<tr>    
	                                  	<td>
	                                        
	                                        <table cellspacing="0" cellpadding="0" class="" width="500" style="width:500px;margin:0 auto;padding:10px;" border-collapse="collapse">
	                                            <tbody>
	                                                <tr> 
	                                                    <td valign="middle" style="text-align:center;">
	                                                        <h2 style="font-family: 'Helvetica', 'Arial', sans-serif;color:#555;">Store Notification Error</h2>
	                                                        <p style="font-family: 'Helvetica', 'Arial', sans-serif;color:#555;">Dear Admin</p>
	                                                        <p style="font-family: 'Helvetica', 'Arial', sans-serif;color:#555;">The order ID: <strong><?php echo $orderId; ?></strong> has been processed, but has failed to notify the store chosen by the customer for Local Pickup.</p>
	                                                        <p style="font-family: 'Helvetica', 'Arial', sans-serif;color:#555;">Reason: No email address has been supplied for the store.</p>
	                                                        <p style="font-family: 'Helvetica', 'Arial', sans-serif;color:#555;">Please log into the store admin <a href="<?php echo $siteurl; ?>/wp-admin/edit.php?post_type=shop_order" target="_blank">here</a> and contact the appropriate store.</p>
	                                                        <p style="font-family: 'Helvetica', 'Arial', sans-serif;color:#555;">You may also wish to update the store email address <a href="<?php echo $siteurl; ?>/wp-admin/admin.php?page=wc-settings&tab=shipping&section=local_pickup_plus" target="_blank">here</a></p>
	                                                        <p style="font-family: 'Helvetica', 'Arial', sans-serif;color:#555;">Regards</p>
	                                                    </td>
	                                                </tr>
	                                            </tbody>
	                                        </table> 

	                                    </td>
	                                </tr>
	                           	</tbody>
	                       	</table>
	                    </center>

	                </td>
	            </tr>
	        </tbody>
	    </table>
	    </body>
	    </html>

		<?php $content = ob_get_clean();
		return $content;
	};


	/**
	* Send the email content to the admin. 
	*
	* @param string $orderID The ID of the order thats failed to be sent to the store.
	* @param string $siteurl The entry from the site URL field in wp_options. This will make the links in the email dynamic. 
	*/ 
	function error_email($orderId, $siteurl) {

		if(isset($orderId))	{ 

			//Get the admin email from WP Options
			$email = get_option('woocommerce_new_order_settings', true);

			//Construct the email for WP-MAIL
			$to = $email['recipient'];
			$message = email_content($orderId, $siteurl);        
			$subject = "Store Notification Error";
			$headers .= "Content-type: text/html;charset=utf-8\n";
			$headers .= "X-Priority: 3\n";
			$headers .= "X-MSMail-Priority: Normal\n";
			$headers .= "X-Mailer: php\n";
			$headers .= "From: InTime <intime@intime.co.uk>\n";    
			wp_mail( $to, $subject, $message, $headers);

		}

	die();
		
	};