<?php
namespace VCOMedia\PhpCommon\Util;

class ArrayUtil {
    
	public static function mergeOnKey(array $array1, array $array2, $key) {
		$array1 = static::removeDuplicatesByKeyInArray($array1, $key);
		$array2 = static::removeDuplicatesByKeyInArray($array2, $key);

		$temparray = array();
		if (count($array1) > 0) {
			foreach ($array1 as $val) {
				if (is_array($val) && array_key_exists($key, $val) && !static::valueExistsForKeyInArray($array2, $key, $val[$key])) {
					$temparray[] = $val;
				}
			}
		}

		$out = array();

		if (count($temparray) > 0) {
			foreach ($temparray as $val) {
				$out[] = $val;
			}
		}

		if (count($array2) > 0) {
			foreach ($array2 as $val) {
				$out[] = $val;
			}
		}

		return $out;
	}

	public static function valueExistsForKeyInArray(array $array, $key, $value) {
		$exists = false;
		if (count($array) > 0) {
			foreach ($array as $val) {
				if (is_array($val) && array_key_exists($key, $val) && $val[$key] == $value) {
					$exists = true;
					break;
				}
			}
		}

		return $exists;
	}

	public static function removeDuplicatesByKeyInArray(array $array, $key) {
		if (array_key_exists($key, $array))
			$array = array($array);

		$temp = array();
		for ($ii = count($array) - 1; $ii >= 0; $ii--) {
			if (is_array($array[$ii]) && array_key_exists($key, $array[$ii]) && !static::valueExistsForKeyInArray($temp, $key, $array[$ii][$key]))
				$temp[] = $array[$ii];
		}

		return array_reverse($temp);
	}

	public static function filterLeafs($value, $filters) {
		if (is_array($value)) {
			$out = array();
			foreach ($value as $k => $v) {
				if (is_array($v)) {
					$out[$k] = static::filterLeafs($v, $filters);
				} else {
					foreach ($filters as $filter) {
						$v = $filter->filter($v);
					}
					$out[$k] = $v;
				}
			}
			return $out;
		} else {
			foreach ($filters as $filter) {
				$value = $filter->filter($value);
			}
			return $value;
		}
	}

	public static function isAllLeafsNullOrEmptySting($value) {
		if (is_array($value)) {
			foreach ($value as $k => $v) {
				if (is_array($v)) {
					$allEmpty = static::isAllLeafsNullOrEmptySting($v);

					if (!$allEmpty) {
						return false;
					}
				} elseif (!is_null($v) && trim($v) != '') {
					return false;
				}
			}
		} else {
			if (!is_null($value) && trim($value) != '') {
				return false;
			}
		}
		return true;
	}

	public function valueForKey($array, $key, $default = null) {
		if (!is_array($array)) {
			return $default;
		}

		$keyArray = explode('.', $key);

		if (count($keyArray) > 0) {
			$temp = $array;

			foreach ($keyArray as $k) {
				if (array_key_exists($k, $temp)) {
					$temp = $temp[$k];
				} else {
					return $default;
				}
			}

			return $temp;

		} else {
			return $default;
		}
	}

	public static function multiSortByColumn(&$arr, $col, $dir = SORT_ASC) {
        $sort_col = array();
        foreach ($arr as $key=> $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $dir, $arr);
	}
	
	public static function arrayRecursiveDiff($aArray1, $aArray2) { 
        $aReturn = array(); 
    
        foreach ($aArray1 as $mKey => $mValue) { 
            if (array_key_exists($mKey, $aArray2)) { 
                if (is_array($mValue)) { 
                    $aRecursiveDiff = static::arrayRecursiveDiff($mValue, $aArray2[$mKey]); 
                    if (count($aRecursiveDiff)) { $aReturn[$mKey] = $aRecursiveDiff; } 
                } else { 
                    if ($mValue != $aArray2[$mKey]) { 
                        $aReturn[$mKey] = $mValue; 
                    } 
                } 
            } else { 
                $aReturn[$mKey] = $mValue; 
            } 
        } 
    
        return $aReturn; 
    } 
    
    public static function isAssociative($a) {
    	foreach(array_keys($a) as $key) {
    		if (!is_int($key)) {
    		    return TRUE;
    		}
    	}
    	
    	return FALSE;
    }
    
    public static function valueFromDotNotation($array, $key, $defaultValue = null) {
        $tempValue = $defaultValue;
        $keyPieces = explode('.', $key);
        if(count($keyPieces) > 0) {
            $tempValue = $array;
            foreach($keyPieces as $kP) {
                if(isset($tempValue[$kP])) {
                    $tempValue = $tempValue[$kP];
                } else {
                    return $defaultValue;
                }
            }
        }
        return $tempValue;
    }
    
    public static function stdObjectToArray($data){
        return json_decode(json_encode($data), true);
    }
}
