<?php
/**
* Add an additional Bcc header to the outgoing woocommerce new order emails. 
* The email address will be that of the selected store from the checkout and sourced from the Local Pickup Plus option in wp_options
* 
* @since V.2
* 
* @param array $headers Headers for the email.
* @param string $id Order ID
* @param object $order Order Object
*/

add_filter( 'woocommerce_email_headers', 'knoppys_cc_to_store', 10, 3);

function knoppys_cc_to_store( $headers, $id, $order ) {

	#Get the order ID
	$orderId = $order->id;

	//Empty array to use $locationame outside the foreach
	$locationame = array();

	//Not sure but Woo says its required
	$orderitems = $orderId->get_items();	

		//Get the location name
		foreach ($orderitems as $orderitem) {							
			$locationame = explode(',', $orderitem['Pickup Location']);							
		}

	//The location name	
	$storename = $locationame[0];

	//Get the option value as an array.		
	$option = get_option( 'woocommerce_pickup_locations', true );

	//Get the email address of the storename.					
	$key = array_search($storename, array_column($option,'company'));

	//Get the email address of the store name in the same array. 
	//If there isnt one then fire an error email and send to store admin.
	if ($key !== false) { 	

		//Get the email address from the note field	
		$email = $option[$key]['note']; 

		//Make sure that only the new order emails are sent to the stores. 
		//Otherwise they will get bogged down with shit. 
		switch($object) {
			case 'new_order':
			$headers .= 'Bcc:' . $email . "\r\n";
		break;
		default:
		}

		return $headers;

	} else {

		//Run the error_email function.
		$message = error_email($orderId, get_site_url());		
		return;
	}

	
}


