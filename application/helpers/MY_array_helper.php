<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('all_in_array'))
{
	function all_in_array($needle, $haystack)
	{
		return count(array_intersect($needle, $haystack)) === count($needle);
	}
}

if (!function_exists('any_in_array'))
{
	function any_in_array($needle, $haystack)
	{
		$needle = is_array($needle) ? $needle : array($needle);

		foreach ($needle as $item)
		{
			if (in_array($item, $haystack))
			{
				return TRUE;
			}
		}

		return FALSE;
	}
}