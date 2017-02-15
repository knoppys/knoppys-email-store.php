Plugin Name:       Knoppys - Store Notifications for Local Pickup Plus
Plugin URI:        https://www.knoppys.co.uk
Description:       Send email notifications to your store locations when using the Local Pickup Plus Plugin.
Version:           2
Author:            Knoppys Digital Limited
License:           GNU General Public License v2
License URI:       http://www.gnu.org/licenses/gpl-2.0.html

Changelog
V2
- Created the woocommerce_email_headers filter and added the test function to get the store email.
- Added a switch on line 49 of woo_email_headers_filter to make sure only the new order emails go out to the stores.
- Added a failsafe funtion error_email($orderId, $siteurl); to send a falire email to the admin if the Store doesnt have an email address. 
- Added a seperate function in there email_content($orderid, $siteurl); to keep things neat and tidy. 
- Commented the shit out of all the code. 

V1
- Just added a custom menu page to loop through products finding all the variables and fields I needed to pass the data to the function. 
- Found that the Local Pickups Plugin uses a wordpress option to store all its data which meant sigting through arrays.
