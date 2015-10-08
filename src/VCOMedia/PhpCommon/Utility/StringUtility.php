<?php
namespace VCOMedia\PhpCommon\Utility;

class StringUtility
{   
    public static function convert_smart_quotes($string) {
        $search = array(chr(145),chr(146),chr(147),chr(148),chr(151));
        $replace = array("'","'",'"','"','-');
        return str_replace($search, $replace, $string);
    }

    public static function createSlug($str, $removeCommonWords = false) {
        $str = self::removeAccents($str);
        $str = strtolower($str);
        if($removeCommonWords) {
            $str = self::removeCommonWords($str);
        }
        return preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $str);
    }
    
    public static function removeCommonWords($str){
    	$commonWords = array('a','able','about','above','abroad','according','accordingly','across','actually','adj',
    	    'after','afterwards','again','against','ago','ahead','ain\'t','all','allow','allows','almost','alone',
    	    'along','alongside','already','also','although','always','am','amid','amidst','among','amongst','an',
    	    'and','another','any','anybody','anyhow','anyone','anything','anyway','anyways','anywhere','apart',
    	    'appear','appreciate','appropriate','are','aren\'t','around','as','a\'s','aside','ask','asking',
    	    'associated','at','available','away','awfully','b','back','backward','backwards','be','became','because',
    	    'become','becomes','becoming','been','before','beforehand','begin','behind','being','believe','below',
    	    'beside','besides','best','better','between','beyond','both','brief','but','by','c','came','can','cannot',
    	    'cant','can\'t','caption','cause','causes','certain','certainly','changes','clearly','c\'mon','co','co.',
    	    'com','come','comes','concerning','consequently','consider','considering','contain','containing',
    	    'contains','corresponding','could','couldn\'t','course','c\'s','currently','d','dare','daren\'t',
    	    'definitely','described','despite','did','didn\'t','different','directly','do','does','doesn\'t',
    	    'doing','done','don\'t','down','downwards','during','e','each','edu','eg','eight','eighty','either',
    	    'else','elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore',
    	    'every','everybody','everyone','everything','everywhere','ex','exactly','example','except','f','fairly',
    	    'far','farther','few','fewer','fifth','first','five','followed','following','follows','for','forever',
    	    'former','formerly','forth','forward','found','four','from','further','furthermore','g','get','gets',
    	    'getting','given','gives','go','goes','going','gone','got','gotten','greetings','h','had','hadn\'t',
    	    'half','happens','hardly','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','hello',
    	    'help','hence','her','here','hereafter','hereby','herein','here\'s','hereupon','hers','herself','he\'s',
    	    'hi','him','himself','his','hither','hopefully','how','howbeit','however','hundred','i','i\'d','ie','if',
    	    'ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated',
    	    'indicates','inner','inside','insofar','instead','into','inward','is','isn\'t','it','it\'d','it\'ll',
    	    'its','it\'s','itself','i\'ve','j','just','k','keep','keeps','kept','know','known','knows','l','last',
    	    'lately','later','latter','latterly','least','less','lest','let','let\'s','like','liked','likely',
    	    'likewise','little','look','looking','looks','low','lower','ltd','m','made','mainly','make','makes',
    	    'many','may','maybe','mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t','mine',
    	    'minus','miss','more','moreover','most','mostly','mr','mrs','much','must','mustn\'t','my','myself','n',
    	    'name','namely','nd','near','nearly','necessary','need','needn\'t','needs','neither','never','neverf',
    	    'neverless','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone',
    	    'no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of',
    	    'off','often','oh','ok','okay','old','on','once','one','ones','one\'s','only','onto','opposite','or',
    	    'other','others','otherwise','ought','oughtn\'t','our','ours','ourselves','out','outside','over',
    	    'overall','own','p','particular','particularly','past','per','perhaps','placed','please','plus',
    	    'possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd','re',
    	    'really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively',
    	    'right','round','s','said','same','saw','say','saying','says','second','secondly','see','seeing','seem',
    	    'seemed','seeming','seems','seen','self','selves','sensible','sent','serious','seriously','seven',
    	    'several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t','since','six','so',
    	    'some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere',
    	    'soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken',
    	    'taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'s',
    	    'that\'ve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby',
    	    'there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve',
    	    'these','they','they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty',
    	    'this','thorough','thoroughly','those','though','three','through','throughout','thru','thus','till','to',
    	    'together','too','took','toward','towards','tried','tries','truly','try','trying','t\'s','twice','two',
    	    'u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up',
    	    'upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus',
    	    'very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll',
    	    'went','were','we\'re','weren\'t','we\'ve','what','whatever','what\'ll','what\'s','what\'ve','when',
    	    'whence','whenever','where','whereafter','whereas','whereby','wherein','where\'s','whereupon','wherever',
    	    'whether','which','whichever','while','whilst','whither','who','who\'d','whoever','whole','who\'ll',
    	    'whom','whomever','who\'s','whose','why','will','willing','wish','with','within','without','wonder',
    	    'won\'t','would','wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re','yours',
    	    'yourself','yourselves','you\'ve','z','zero');
     
    	return preg_replace('/\b('.implode('|',$commonWords).')\b/','',$str);
    }

    public static function removeAccents($str){
        $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','Ā','ā','Ă','ă','Ą','ą','Ć','ć','Ĉ','ĉ','Ċ','ċ','Č','č','Ď','ď','Đ','đ','Ē','ē','Ĕ','ĕ','Ė','ė','Ę','ę','Ě','ě','Ĝ','ĝ','Ğ','ğ','Ġ','ġ','Ģ','ģ','Ĥ','ĥ','Ħ','ħ','Ĩ','ĩ','Ī','ī','Ĭ','ĭ','Į','į','İ','ı','Ĳ','ĳ','Ĵ','ĵ','Ķ','ķ','Ĺ','ĺ','Ļ','ļ','Ľ','ľ','Ŀ','ŀ','Ł','ł','Ń','ń','Ņ','ņ','Ň','ň','ŉ','Ō','ō','Ŏ','ŏ','Ő','ő','Œ','œ','Ŕ','ŕ','Ŗ','ŗ','Ř','ř','Ś','ś','Ŝ','ŝ','Ş','ş','Š','š','Ţ','ţ','Ť','ť','Ŧ','ŧ','Ũ','ũ','Ū','ū','Ŭ','ŭ','Ů','ů','Ű','ű','Ų','ų','Ŵ','ŵ','Ŷ','ŷ','Ÿ','Ź','ź','Ż','ż','Ž','ž','ſ','ƒ','Ơ','ơ','Ư','ư','Ǎ','ǎ','Ǐ','ǐ','Ǒ','ǒ','Ǔ','ǔ','Ǖ','ǖ','Ǘ','ǘ','Ǚ','ǚ','Ǜ','ǜ','Ǻ','ǻ','Ǽ','ǽ','Ǿ','ǿ');
        $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
        return str_replace($a, $b, $str);
    }


 /**
 * truncateHtml can truncate a string up to a number of characters while preserving whole words and HTML tags
 *
 * @param string $text String to truncate.
 * @param integer $length Length of returned string, including ellipsis.
 * @param string $ending Ending to be appended to the trimmed string.
 * @param boolean $exact If false, $text will not be cut mid-word
 * @param boolean $considerHtml If true, HTML tags would be handled correctly
 *
 * @return string Trimmed string.
 */
    public static function truncate($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
	if ($considerHtml) {
		// if the plain text is shorter than the maximum length, return the whole text
		if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
			return $text;
		}
		// splits all html-tags to scanable lines
		preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
		$total_length = strlen($ending);
		$open_tags = array();
		$truncate = '';
		foreach ($lines as $line_matchings) {
			// if there is any html-tag in this line, handle it and add it (uncounted) to the output
			if (!empty($line_matchings[1])) {
				// if it's an "empty element" with or without xhtml-conform closing slash
				if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
					// do nothing
				// if tag is a closing tag
				} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
					// delete tag from $open_tags list
					$pos = array_search($tag_matchings[1], $open_tags);
					if ($pos !== false) {
					unset($open_tags[$pos]);
					}
				// if tag is an opening tag
				} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
					// add tag to the beginning of $open_tags list
					array_unshift($open_tags, strtolower($tag_matchings[1]));
				}
				// add html-tag to $truncate'd text
				$truncate .= $line_matchings[1];
			}
			// calculate the length of the plain text part of the line; handle entities as one character
			$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
			if ($total_length+$content_length> $length) {
				// the number of characters which are left
				$left = $length - $total_length;
				$entities_length = 0;
				// search for html entities
				if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
					// calculate the real length of all entities in the legal range
					foreach ($entities[0] as $entity) {
						if ($entity[1]+1-$entities_length <= $left) {
							$left--;
							$entities_length += strlen($entity[0]);
						} else {
							// no more characters left
							break;
						}
					}
				}
				$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
				// maximum lenght is reached, so get off the loop
				break;
			} else {
				$truncate .= $line_matchings[2];
				$total_length += $content_length;
			}
			// if the maximum length is reached, get off the loop
			if($total_length>= $length) {
				break;
			}
		}
	} else {
		if (strlen($text) <= $length) {
			return $text;
		} else {
			$truncate = substr($text, 0, $length - strlen($ending));
		}
	}
	// if the words shouldn't be cut in the middle...
	if (!$exact) {
		// ...search the last occurance of a space...
		$spacepos = strrpos($truncate, ' ');
		if (isset($spacepos)) {
			// ...and cut the text in this position
			$truncate = substr($truncate, 0, $spacepos);
		}
	}
	// add the defined ending to the text
	$truncate .= $ending;
	if($considerHtml) {
		// close all unclosed html-tags
		foreach ($open_tags as $tag) {
			$truncate .= '</' . $tag . '>';
		}
	}
	return $truncate;
}

    public static function autoFormat($pee, $br = 1) {
        if ( trim($pee) === '' )
            return '';
        $pee = $pee . "\n"; // just to make things a little easier, pad the end
        $pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
        // Space things out a little
        $allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr)';
        $pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
        $pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
        $pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
        if ( strpos($pee, '<object') !== false ) {
            $pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
            $pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
        }
        $pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
        // make paragraphs, including one at the end
        $pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
        $pee = '';
        foreach ( $pees as $tinkle )
            $pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
        $pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
        $pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
        $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
        $pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
        $pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
        $pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
        $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
        $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
        if ($br) {
            $pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', create_function('$matches', 'return str_replace("\n", "<WPPreserveNewline />", $matches[0]);'), $pee);
            $pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
            $pee = str_replace('<WPPreserveNewline />', "\n", $pee);
        }
        $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
        $pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
        if (strpos($pee, '<pre') !== false)
            $pee = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', 'clean_pre', $pee );
        $pee = preg_replace( "|\n</p>$|", '</p>', $pee );
        //$pee = preg_replace('/<p>\s*?(' . get_shortcode_regex() . ')\s*<\/p>/s', '$1', $pee); // don't auto-p wrap shortcodes that stand alone

        $pee =  preg_replace("/<li>(.+)<\/li>\n/", "<li>$1</li>", $pee);
        return $pee;
    }

    // credit: https://gist.github.com/tylerhall/521810
    // Generates a strong password of N length containing at least one lower case letter,
    // one uppercase letter, one digit, and one special character. The remaining characters
    // in the password are chosen at random from those four sets.
    //
    // The available characters in each set are user friendly - there are no ambiguous
    // characters such as i, l, 1, o, 0, etc. This, coupled with the $add_dashes option,
    // makes it much easier for users to manually type or speak their passwords.
    public static function generatePassword($length = 9, $available_sets = 'luds') {
    	$sets = array();
    	if(strpos($available_sets, 'l') !== false)
    		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
    	if(strpos($available_sets, 'u') !== false)
    		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
    	if(strpos($available_sets, 'd') !== false)
    		$sets[] = '23456789';
    	if(strpos($available_sets, 's') !== false)
    		$sets[] = '!@#$%&*?';
    	$all = '';
    	$password = '';
    	foreach($sets as $set) {
    		$password .= $set[array_rand(str_split($set))];
    		$all .= $set;
    	}
    	$all = str_split($all);
    	for($i = 0; $i < $length - count($sets); $i++)
    		$password .= $all[array_rand($all)];
    	$password = str_shuffle($password);
        return $password;
    }

    public static function startsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public static function endsWith($haystack, $needle) {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
    
    public static function contains($haystack, $needle) {
        if (strpos($haystack, $needle) !== false) {
            return true;
        } else {
            return false;
        }
    }

    public static function renderHtmlAttributes(array $attributes) {
        $output = '';

        if(count($attributes ) > 0 ) {
            foreach ($attributes as $key => $value) {
                $output .= $key . '="' . $value . '" ';
            }
        }

        return $output;
    }

    /**
     * Translates a number to a short alhanumeric version
     *
     * Translated any number up to 9007199254740992
     * to a shorter version in letters e.g.:
     * 9007199254740989 --> PpQXn7COf
     *
     * specifiying the second argument true, it will
     * translate back e.g.:
     * PpQXn7COf --> 9007199254740989
     *
     * this function is based on any2dec && dec2any by
     * fragmer[at]mail[dot]ru
     * see: http://nl3.php.net/manual/en/function.base-convert.php#52450
     *
     * If you want the alphaID to be at least 3 letter long, use the
     * $pad_up = 3 argument
     *
     * In most cases this is better than totally random ID generators
     * because this can easily avoid duplicate ID's.
     * For example if you correlate the alpha ID to an auto incrementing ID
     * in your database, you're done.
     *
     * The reverse is done because it makes it slightly more cryptic,
     * but it also makes it easier to spread lots of IDs in different
     * directories on your filesystem. Example:
     * $part1 = substr($alpha_id,0,1);
     * $part2 = substr($alpha_id,1,1);
     * $part3 = substr($alpha_id,2,strlen($alpha_id));
     * $destindir = "/".$part1."/".$part2."/".$part3;
     * // by reversing, directories are more evenly spread out. The
     * // first 26 directories already occupy 26 main levels
     *
     * more info on limitation:
     * - http://blade.nagaokaut.ac.jp/cgi-bin/scat.rb/ruby/ruby-talk/165372
     *
     * if you really need this for bigger numbers you probably have to look
     * at things like: http://theserverpages.com/php/manual/en/ref.bc.php
     * or: http://theserverpages.com/php/manual/en/ref.gmp.php
     * but I haven't really dugg into this. If you have more info on those
     * matters feel free to leave a comment.
     *
     * The following code block can be utilized by PEAR's Testing_DocTest
     * <code>
     * // Input //
     * $number_in = 2188847690240;
     * $alpha_in  = "SpQXn7Cb";
     *
     * // Execute //
     * $alpha_out  = alphaID($number_in, false, 8);
     * $number_out = alphaID($alpha_in, true, 8);
     *
     * if ($number_in != $number_out) {
     *	 echo "Conversion failure, ".$alpha_in." returns ".$number_out." instead of the ";
     *	 echo "desired: ".$number_in."\n";
     * }
     * if ($alpha_in != $alpha_out) {
     *	 echo "Conversion failure, ".$number_in." returns ".$alpha_out." instead of the ";
     *	 echo "desired: ".$alpha_in."\n";
     * }
     *
     * // Show //
     * echo $number_out." => ".$alpha_out."\n";
     * echo $alpha_in." => ".$number_out."\n";
     * echo alphaID(238328, false)." => ".alphaID(alphaID(238328, false), true)."\n";
     *
     * // expects:
     * // 2188847690240 => SpQXn7Cb
     * // SpQXn7Cb => 2188847690240
     * // aaab => 238328
     *
     * </code>
     *
     * @author	Kevin van Zonneveld <kevin@vanzonneveld.net>
     * @author	Simon Franz
     * @author	Deadfish
     * @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
     * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
     * @version   SVN: Release: $Id: alphaID.inc.php 344 2009-06-10 17:43:59Z kevin $
     * @link	  http://kevin.vanzonneveld.net/
     *
     * @param mixed   $in	  String or long input to translate
     * @param boolean $to_num  Reverses translation when true
     * @param mixed   $pad_up  Number or boolean padds the result up to a specified length
     * @param string  $passKey Supplying a password makes it harder to calculate the original ID
     *
     * @return mixed string or long
     */
    public static function alphaID($in, $to_num = false, $pad_up = false, $passKey = null)
    {
    	$index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    	if ($passKey !== null) {
    		// Although this function's purpose is to just make the
    		// ID short - and not so much secure,
    		// with this patch by Simon Franz (http://blog.snaky.org/)
    		// you can optionally supply a password to make it harder
    		// to calculate the corresponding numeric ID

    		for ($n = 0; $n<strlen($index); $n++) {
    			$i[] = substr( $index,$n ,1);
    		}

    		$passhash = hash('sha256',$passKey);
    		$passhash = (strlen($passhash) < strlen($index))
    			? hash('sha512',$passKey)
    			: $passhash;

    		for ($n=0; $n < strlen($index); $n++) {
    			$p[] =  substr($passhash, $n ,1);
    		}

    		array_multisort($p,  SORT_DESC, $i);
    		$index = implode($i);
    	}

    	$base  = strlen($index);

    	if ($to_num) {
    		// Digital number  <<--  alphabet letter code
    		$in  = strrev($in);
    		$out = 0;
    		$len = strlen($in) - 1;
    		for ($t = 0; $t <= $len; $t++) {
    			$bcpow = bcpow($base, $len - $t);
    			$out   = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
    		}

    		if (is_numeric($pad_up)) {
    			$pad_up--;
    			if ($pad_up > 0) {
    				$out -= pow($base, $pad_up);
    			}
    		}
    		$out = sprintf('%F', $out);
    		$out = substr($out, 0, strpos($out, '.'));
    	} else {
    		// Digital number  -->>  alphabet letter code
    		if (is_numeric($pad_up)) {
    			$pad_up--;
    			if ($pad_up > 0) {
    				$in += pow($base, $pad_up);
    			}
    		}

    		$out = "";
    		for ($t = floor(log($in, $base)); $t >= 0; $t--) {
    			$bcp = bcpow($base, $t);
    			$a   = floor($in / $bcp) % $base;
    			$out = $out . substr($index, $a, 1);
    			$in  = $in - ($a * $bcp);
    		}
    		$out = strrev($out); // reverse
    	}

    	return $out;
    }

    private static function _make_url_clickable_cb($matches) {
    	$ret = '';
    	$url = $matches[2];

    	if ( empty($url) )
    		return $matches[0];
    	// removed trailing [.,;:] from URL
    	if ( in_array(substr($url, -1), array('.', ',', ';', ':')) === true ) {
    		$ret = substr($url, -1);
    		$url = substr($url, 0, strlen($url)-1);
    	}
    	return $matches[1] . "<a href=\"$url\" rel=\"nofollow\" target=\"_blank\">$url</a>" . $ret;
    }

    private static function _make_web_ftp_clickable_cb($matches) {
    	$ret = '';
    	$dest = $matches[2];
    	$dest = 'http://' . $dest;

    	if ( empty($dest) )
    		return $matches[0];
    	// removed trailing [,;:] from URL
    	if ( in_array(substr($dest, -1), array('.', ',', ';', ':')) === true ) {
    		$ret = substr($dest, -1);
    		$dest = substr($dest, 0, strlen($dest)-1);
    	}
    	return $matches[1] . "<a href=\"$dest\" rel=\"nofollow\">$dest</a>" . $ret;
    }

    private static function _make_email_clickable_cb($matches) {
    	$email = $matches[2] . '@' . $matches[3];
    	return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
    }

    public static function makeLinksAnchors($ret) {
    	$ret = ' ' . $ret;
    	// in testing, using arrays here was found to be faster
    	$ret = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is',  'StringUtility::_make_url_clickable_cb', $ret);
    	$ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', 'StringUtility::_make_web_ftp_clickable_cb', $ret);
    	$ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', 'StringUtility::_make_email_clickable_cb', $ret);

    	// this one is not in an array because we need it to run last, for cleanup of accidental links within links
    	$ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret);
    	$ret = trim($ret);
    	return $ret;
    }
    
    public static function paramFromUrl($key,$url, $default = null) {
        $query = parse_url(trim($url), PHP_URL_QUERY);
        $args = array();
        parse_str($query, $args);
        return isset($args[$key]) ? $args[$key] : $default;
    }
    
    public static function generateGUID(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                    .substr($charid, 0, 8).$hyphen
                    .substr($charid, 8, 4).$hyphen
                    .substr($charid,12, 4).$hyphen
                    .substr($charid,16, 4).$hyphen
                    .substr($charid,20,12)
                    .chr(125);// "}"
            return $uuid;
        }
    }
}