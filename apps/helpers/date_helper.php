<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Format a time interval with the requested granularity.
 *
 * @param $timestamp
 *   The length of the interval in seconds.
 * @param $granularity
 *   How many different units to display in the string.
 * @param $langcode
 *   Optional language code to translate to a language other than
 *   what is used to display the page.
 * @return
 *   A translated string representation of the interval.
 */
if ( ! function_exists('format_interval'))
{
	function format_interval($timestamp, $granularity = 2, $langcode = NULL)
	{
	
		$units = array('1 year|@count years' => 31536000, '1 week|@count weeks' => 604800, '1 day|@count days' => 86400, '1 hour|@count hours' => 3600, '1 min|@count min' => 60, '1 sec|@count sec' => 1);
	
		$output = '';
	
		foreach ($units as $key => $value) 
		{
			$key = explode('|', $key);
	
			if ($timestamp >= $value) 
			{
				//$output .= ($output ? ' ' : '') . format_plural(floor($timestamp / $value), $key[0], $key[1], array(), $langcode);
				$output .= ($output ? ' ' : '') . format_plural(floor($timestamp / $value), $key[0], $key[1]);
				$timestamp %= $value;
				$granularity--;
			}
	
			if ($granularity == 0) 
			{
				break;
			}
	
		}
		

		//return $output ? $output : t('0 sec', array(), $langcode);
		return $output? $output : '0 sec';
	}		
}

/**
 * Format a string containing a count of items.
 *
 * This function ensures that the string is pluralized correctly. Since t() is
 * called by this function, make sure not to pass already-localized strings to
 * it.
 *
 * For example:
 * @code
 *   $output = format_plural($node->comment_count, '1 comment', '@count comments');
 * @endcode
 *
 * Example with additional replacements:
 * @code
 *   $output = format_plural($update_count,
 *     'Changed the content type of 1 post from %old-type to %new-type.',
 *     'Changed the content type of @count posts from %old-type to %new-type.',
 *     array('%old-type' => $info->old_type, '%new-type' => $info->new_type)));
 * @endcode
 *
 * @param $count
 *   The item count to display.
 * @param $singular
 *   The string for the singular case. Please make sure it is clear this is
 *   singular, to ease translation (e.g. use "1 new comment" instead of "1 new").
 *   Do not use @count in the singular string.
 * @param $plural
 *   The string for the plural case. Please make sure it is clear this is plural,
 *   to ease translation. Use @count in place of the item count, as in "@count
 *   new comments".
 * @param $args
 *   An associative array of replacements to make after translation. Incidences
 *   of any key in this array are replaced with the corresponding value.
 *   Based on the first character of the key, the value is escaped and/or themed:
 *    - !variable: inserted as is
 *    - @variable: escape plain text to HTML (check_plain)
 *    - %variable: escape text and theme as a placeholder for user-submitted
 *      content (check_plain + theme_placeholder)
 *   Note that you do not need to include @count in this array.
 *   This replacement is done automatically for the plural case.
 * @param $langcode
 *   Optional language code to translate to a language other than
 *   what is used to display the page.
 * @return
 *   A translated string.
 */
if ( ! function_exists('format_plural'))
{ 
	function format_plural($count, $singular, $plural, $args = array(), $langcode = NULL) 
	{			
		if ($count == 1) 
		{
			return $singular;
		}

        return strtr($plural, array('@count' => $count));		    
	}
}	
/* End of file string_helper.php */
/* Location: ./system/helpers/string_helper.php */