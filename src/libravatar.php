<?php
/*
 Plugin Name: Libravatar
 Plugin URI: http://www.gabsoftware.com/products/scripts/libravatar/
 Description: Libravatar support for Wordpress
 Version: 1.0.3
 Author: Gabriel Hautclocq
 Author URI: http://www.gabsoftware.com/
 License: ISC
*/

//error_reporting( E_ALL );

// security check
if( !defined( 'WP_PLUGIN_DIR' ) )
{
	die( 'There is nothing to see here!' );
}

/* constants */
// Libravatar text domain
define( 'LIBRAVATAR_TD', 'libravatar' );

// Libravatar version
define( 'LIBRAVATAR_VERSION_MAJ', 1 );
define( 'LIBRAVATAR_VERSION_MIN', 0 );
define( 'LIBRAVATAR_VERSION_REV', 3 );

include_once( 'Services_Libravatar.php' );

add_filter( 'get_avatar', 'libravatar_get_avatar_filter_callback', 10, 5 );
add_filter( 'avatar_defaults', 'libravatar_avatar_defaults_filter_callback' );

//return true if the connection uses SSL
function libravatar_is_ssl()
{
	if( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' )
	{
		return true;
	}
	elseif( $_SERVER['SERVER_PORT'] == 443 )
	{
		return true;
	}
	else
	{
		return false;
	}
}

function libravatar_avatar_defaults_filter_callback( $avatar_defaults )
{
	$avatar_defaults['libravatar_default'] = __('Libravatar Logo');
	return $avatar_defaults;
}

function libravatar_get_avatar_filter_callback( $avatar, $id_or_email, $size, $default, $alt )
{
	if( 'libravatar_default' == $default )
	{
		if( false === $alt)
		{
			$safe_alt = '';
		}
		else
		{
			$safe_alt = esc_attr( $alt );
		}

		$email = '';
		if( is_numeric( $id_or_email ) )
		{
			$id = (int) $id_or_email;
			$user = get_userdata( $id );
			if( $user )
			{
				$email = $user->user_email;
			}
		}
		elseif( is_object( $id_or_email ) )
		{
			// No avatar for pingbacks or trackbacks
			$allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );

			if( ! empty( $id_or_email->user_id ) )
			{
				$id = (int) $id_or_email->user_id;
				$user = get_userdata( $id );
				if( $user)
				{
					$email = $user->user_email;
				}
			}
			elseif( ! empty( $id_or_email->comment_author_email ) )
			{
				$email = $id_or_email->comment_author_email;
			}
		}
		else
		{
			$email = $id_or_email;
		}

		$libravatar = new Services_Libravatar();
		$options = array();
		$options['s'] = $size;
		$options['algorithm'] = 'md5';
		$options['https'] = libravatar_is_ssl();
		//$options['d'] = ( $options['https'] == true ? 'https://sec' : 'http://' ) . 'cdn.libravatar.org/nobody/60.png';
		$url = $libravatar->url( $email, $options );

		$avatar = "<img alt='{$safe_alt}' src='{$url}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
	}

	return $avatar;
}




?>
