<?php
/*
Plugin Name: Inbox Widget
Plugin URI: http://www.twitter.com/davidtcarson
Author: David Carson
Author URI: http://www.twitter.com/davidtcarson
Description: Adds a widget showing three most recent private messages to logged-in users on a site powered by BuddyPress.
Version: .01
Site Wide Only: false
License: General Public License version 3 
Requires at least: WPMU 2.8.6, BuddyPress trunk?
Tested up to: WPMU 2.8.6, BuddyPress trunk revision 2243


"Inbox Widget" for BuddyPress
Copyright (C) 2009 David Carson

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License version 3 as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses/.

*/





/* Create the widget. */

function bp_core_register_inbox_widget() {

	add_action('widgets_init', create_function('', 'return register_widget("BP_Core_Inbox_Widget");') );
	
	
}
add_action( 'plugins_loaded', 'bp_core_register_inbox_widget' );



class BP_Core_Inbox_Widget extends WP_Widget {
	function bp_core_inbox_widget() {
		parent::WP_Widget( false, $name = __( "Inbox", 'buddypress' ) );
	}


	function widget($args, $instance) {
		global $bp;
	 
	 // Show the widget only to logged-in users on the homepage
	  If ( !is_user_logged_in() || bp_is_page( BP_HOME_BLOG_SLUG ) || !bp_is_page( 'home' ) )
		return;
		
	
	    extract( $args );

		echo $before_widget;
		echo $before_title
		   . $widget_name
		   . $after_title; ?>

	
		
	
	<?php if ( bp_has_message_threads('per_page=3') ) : ?>

 	<ul id="message-threads">
 
 		<?php while ( bp_message_threads() ) : bp_message_thread(); ?>

    	<li<?php if ( bp_message_thread_has_unread() ) : ?> class="unread"<?php else: ?> class="read"<?php endif; ?>>
      
     		<div class="message-subject"> 
     			<?php bp_message_thread_avatar() ?>
      			<?php bp_message_thread_subject() ?>
    		 </div>
    
    		<div class="message-body">
     			<?php bp_message_thread_excerpt() ?>
     		</div>
     	
     		<div class="message-meta">
     			<p><a class="button view" title="View Message" href="<?php bp_message_thread_view_link() ?>">View Message</a> <a class="button view" title="Send Reply" href="<?php bp_message_thread_view_link() ?>/#send-reply">Reply</a></p>
   			</div>
     
    	</li>
    
  		<?php endwhile; ?>
  
  	</ul>

	<?php else: ?>

 	<div id="message" class="info">
   
    <p>There are no messages to display.</p>
  
  	</div>	

	<?php endif;?>

		<?php echo $after_widget; ?>
	<?php
	}

	}

/* Add basic css. */

function bp_inbox_widget_add_css() { ?>

	<style type="text/css">
	 
	
		.widget #message-threads li {
		
			padding: 10px; 
			border-bottom: 1px solid #EEEEEE;
			margin-bottom: 14px;  
			
		}
		
		.widget #message-threads li.unread {
		
			background:#FFF9DB none repeat scroll 0 0;
			border-bottom:1px solid #FFE8C4;
			border-top:1px solid #FFE8C4;
			
		}

		.widget #message-threads li.read {
		
			opacity: .6;
			
		}
		
		.widget #message-threads img.avatar {

			height:20px;
			width:20px;
			
		}

		.widget .message-subject, .widget .message-body {

			width: 100%; 
			float: left; 
			margin-bottom: 8px; 	

		}

		.widget .message-subject p {

			font-size: 16px; 
			font-weight: bold; 
			margin: 2px 0 0 30px;
			
		}
		
	

	</style>
<?php	
}
add_action( 'wp_footer', 'bp_inbox_widget_add_css' );


?>