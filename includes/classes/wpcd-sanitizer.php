<?php

/**
 * easy field sanitizer class
 * Class WPCD_Sanitizer
 */
class WPCD_Sanitizer {
	/**
	 * sanitize array
	 * this function will only gonna return the values that has defined
	 * in rules
	 *
	 * @param $source array source array to be sanitized
	 * @param $rules array key/value pairs, keys: field names, values: sanitize function to be called
	 *
	 * @return array sanitized array
	 */
	public static function sanitize( $source, $rules ) {
		$sanitized_array = [];
		foreach ($source as $key=>$value){
			if(isset($rules[$key])){
				$sanitized_field = call_user_func($rules[$key], $value);
				$sanitized_array[$key] = $sanitized_field;
			}
		}
		return $sanitized_array;
	}
}