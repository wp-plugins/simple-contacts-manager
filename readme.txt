=== Plugin Name ===
Contributors: raeven
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=UBJF27WXZUHD2&lc=PH&item_name=Earl%20Evan%20Amante&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: tool, wordpress, wordpress.org, contacts, contact manager, google analytics
Requires at least: 3.0.1
Tested up to: 4.2.3
Stable tag: 1.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple contact manager for your personal and business use.

== Description ==
A simple contact manager for your personal and business use.
Multiple contact groups can be created to manage your contacts easier.
You may also print the contact easily in a page/post or anywhere on the page.
And as a plus, it includes easy input for your Google Analytics ID, and an option to add the Analytics codes to your site.

Add a contact group for you or your business, if you have more than 1 branch, then add more contact groups!  Simple to use, simple to love. 

== Installation ==
How to install the plugin and get it working.

1. Upload `simple-contacts-manager/` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to Contacts Manager
1. Update your Google Analytics Code ID if you have one
1. Add your first Group / Business

== Frequently Asked Questions ==

= How to use the contact manager =
This is a straight forward plugin. And the steps below will summarize what you will do with it:

* Add your group
* Edit the group contact details
* Save

= How to display your contacts to your website =
There are 2 ways to get your desired specific contact data:

**PHP:** you can use the cm_contact function then just supply the key of the contact that you are trying to get:

*E.g.*
`<?php
	echo cm_contact('just_a_test-general-group_name'); 
?>`

*Will have an output of:*

Just a Test

**SHORTCODE:** you can use the shortcode [cm_contact key=""] then just supply the key or hit the "Get Shortcode" beside the contact

*E.g.*

[cm_contact key="just_a_test-general-group_name"]

*Will have an output of:*
Just a Test

= SPECIAL KEYS: =

**The keys below will return all contacts in the section in an array**

* just_a_test-general
* just_a_test-address
* just_a_test-office
* just_a_test-social

*Using the group ID as key will return all the contacts in the group in an array*

* just_a_test


== Screenshots ==

1. Landing Page
2. Contact Group details
3. Settings Page

== Changelog ==

= 1.3.1 =
Updated the details for 4.2.3

= 1.3 =
* Initial Version (No version 1.0)

== Upgrade Notice ==

Not applicable at the moment