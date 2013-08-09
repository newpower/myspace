<?php



class RestClient {

  const COOKIE_JAR = '/tmp/rest-client-cookie';
  const AGENT = 'rest-client newpower(600541@mail.ru)/1.0.2';
  
  public $response_info;
  public $response_object;
  public $response_raw;

  public $http_options = array();

  function __construct($http_options = array()) {
    $this->http_options = array_merge(array(
      'cookiestore' => self::COOKIE_JAR,
      'useragent' => self::AGENT,
      'redirect' => 5
    ), $http_options);
  }
  
	function get($url, $http_options = array()) {
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, FALSE);
		//curl_setopt($ch, CURLINFO_HEADER_OUT, true);	// если этот параметр не указать не работает!
		//$ret = curl_setopt($ch, CURLOPT_HEADER,         1);
		//$ret = curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); // сохранять куки в файл
		curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
		
  		 curl_setopt($ch, CURLOPT_USERPWD, "agro2b_admin:r9305NDF");
		 
		$resp = curl_exec($ch);
		
		//$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		//echo "XXX".$resp."XXX";

		//$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		//print_r(curl_getinfo($ch));  
		//echo "\n\ncURL error number:" .curl_errno($ch);  
		//echo "\n\ncURL error:" . curl_error($ch);  

		curl_close($ch);
  	
    	return $resp;
		
	}

	public function post($url, $data = array(), $http_options = array()) 
	{
  			echo "POST_BASE_URL[ $url ]<br />";	
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");  //for updating we have to use PUT method.
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data);

		//curl_setopt($ch, CURLINFO_HEADER_OUT, true);	// если этот параметр не указать не работает!
		//$ret = curl_setopt($ch, CURLOPT_HEADER,         1);
		//$ret = curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); // сохранять куки в файл
		curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
		
  		 curl_setopt($ch, CURLOPT_USERPWD, "agro2b_admin:r9305NDF");
		 
		$resp = curl_exec($ch);
		
		//$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		//echo "XXX".$resp."XXX";

		//$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		//print_r(curl_getinfo($ch));  
		//echo "\n\ncURL error number:" .curl_errno($ch);  
		//echo "\n\ncURL error:" . curl_error($ch);  

		curl_close($ch);
  	
    	return $resp;
  }
  
	function put($url, $data = '', $http_options = array()) 
	{
		echo "PUT_BASE_URL[ $url ]<br />";
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, true);
		
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");  //for updating we have to use PUT method.
		//curl_setopt($ch,CURLOPT_HTTPHEADER,$http_options);

			//curl_setopt($ch, CURLINFO_HEADER_OUT, true);	// если этот параметр не указать не работает!
		$ret = curl_setopt($ch, CURLOPT_HEADER,         1);
			//$ret = curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		
		curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); // сохранять куки в файл
		curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
		
		curl_setopt($ch, CURLOPT_USERPWD, "agro2b_admin:r9305NDF");

		$resp = curl_exec($ch);
			//echo "XXXXXXXXXXX".$result."XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXx";

			//$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			//print_r(curl_getinfo($ch));  
			//echo "\n\ncURL error number:" .curl_errno($ch);  
			//echo "\n\ncURL error:" . curl_error($ch);  

		curl_close($ch);
  	
    	return $resp;
			
		
	}

	function delete($url, $http_options = array()) 
  		{
  			echo "DELETE_BASE_URL[ $url ]<br />";	
	  		$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			//curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");  //for updating we have to use PUT method.
			//curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); // сохранять куки в файл
			curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
			curl_setopt($ch, CURLOPT_USERPWD, "agro2b_admin:r9305NDF");
			$resp = curl_exec($ch);
			
			
				
			curl_close($ch);
	  	   	return $resp;
		}

	function array_to_fields($array=array())
	{
		$str_param="";
		$ampersand="";
		
		foreach ($array as $key => $value)
		{
			$str_param=$str_param.$ampersand.$key."=".urlencode($value);
			$ampersand="&";	
		
		}
		return $str_param;
		
	}
	/**
	 * Coding json format
	 * @param array
	 * @return string json
	 */
	function json_encode_cyr($arr) 
    {
        $arr_replace_utf = array('\u0410', '\u0430','\u0411','\u0431','\u0412','\u0432',
        '\u0413','\u0433','\u0414','\u0434','\u0415','\u0435','\u0401','\u0451','\u0416',
        '\u0436','\u0417','\u0437','\u0418','\u0438','\u0419','\u0439','\u041a','\u043a',
        '\u041b','\u043b','\u041c','\u043c','\u041d','\u043d','\u041e','\u043e','\u041f',
        '\u043f','\u0420','\u0440','\u0421','\u0441','\u0422','\u0442','\u0423','\u0443',
        '\u0424','\u0444','\u0425','\u0445','\u0426','\u0446','\u0427','\u0447','\u0428',
        '\u0448','\u0429','\u0449','\u042a','\u044a','\u042d','\u044b','\u042c','\u044c',
        '\u042d','\u044d','\u042e','\u044e','\u042f','\u044f');
        $arr_replace_cyr = array('А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е',
        'Ё', 'ё', 'Ж','ж','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н','О','о',
        'П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ч','ч','Ш','ш',
        'Щ','щ','Ъ','ъ','Ы','ы','Ь','ь','Э','э','Ю','ю','Я','я');
        $str1 = json_encode($arr);
        $str2 = str_replace($arr_replace_utf, $arr_replace_cyr, $str1);
        return $str2;
    }

	/**
	 * function return absolut url
	 * @param link to site, 
	 * @param link to transver
	 * @return absolute link
	 */
	function url_to_absolute( $baseUrl, $relativeUrl )
	{
	    // If relative URL has a scheme, clean path and return.
	    $r = $this->split_url( $relativeUrl );
	    if ( $r === FALSE )
	        return FALSE;
	    if ( !empty( $r['scheme'] ) )
	    {
	        if ( !empty( $r['path'] ) && $r['path'][0] == '/' )
	            $r['path'] = $this->url_remove_dot_segments( $r['path'] );
	        return $this->join_url( $r ); 
	    }
	 
	    // Make sure the base URL is absolute.
	    $b = $this->split_url( $baseUrl );
	    if ( $b === FALSE || empty( $b['scheme'] ) || empty( $b['host'] ) )
	        return FALSE;
	    $r['scheme'] = $b['scheme'];
	 
	    // If relative URL has an authority, clean path and return.
	    if ( isset( $r['host'] ) )
	    {
	        if ( !empty( $r['path'] ) )
	            $r['path'] = $this->url_remove_dot_segments( $r['path'] );
	        return $this->join_url( $r );
	    }
	    unset( $r['port'] );
	    unset( $r['user'] );
	    unset( $r['pass'] );
	 
	    // Copy base authority.
	    $r['host'] = $b['host'];
	    if ( isset( $b['port'] ) ) $r['port'] = $b['port'];
	    if ( isset( $b['user'] ) ) $r['user'] = $b['user'];
	    if ( isset( $b['pass'] ) ) $r['pass'] = $b['pass'];
	 
	    // If relative URL has no path, use base path
	    if ( empty( $r['path'] ) )
	    {
	        if ( !empty( $b['path'] ) )
	            $r['path'] = $b['path'];
	        if ( !isset( $r['query'] ) && isset( $b['query'] ) )
	            $r['query'] = $b['query'];
	        return $this->join_url( $r );
	    }
	 
	    // If relative URL path doesn't start with /, merge with base path
	    if ( $r['path'][0] != '/' )
	    {
	        $base = mb_strrchr( $b['path'], '/', TRUE, 'UTF-8' );
	        if ( $base === FALSE ) $base = '';
	        $r['path'] = $base . '/' . $r['path'];
	    }
	    $r['path'] = $this->url_remove_dot_segments( $r['path'] );
	    return $this->join_url( $r );
	}

	/**
	 * This function parses an absolute or relative URL and splits it
	 * into individual components.
	 *
	 * RFC3986 specifies the components of a Uniform Resource Identifier (URI).
	 * A portion of the ABNFs are repeated here:
	 *
	 *	URI-reference	= URI
	 *			/ relative-ref
	 *
	 *	URI		= scheme ":" hier-part [ "?" query ] [ "#" fragment ]
	 *
	 *	relative-ref	= relative-part [ "?" query ] [ "#" fragment ]
	 *
	 *	hier-part	= "//" authority path-abempty
	 *			/ path-absolute
	 *			/ path-rootless
	 *			/ path-empty
	 *
	 *	relative-part	= "//" authority path-abempty
	 *			/ path-absolute
	 *			/ path-noscheme
	 *			/ path-empty
	 *
	 *	authority	= [ userinfo "@" ] host [ ":" port ]
	 *
	 * So, a URL has the following major components:
	 *
	 *	scheme
	 *		The name of a method used to interpret the rest of
	 *		the URL.  Examples:  "http", "https", "mailto", "file'.
	 *
	 *	authority
	 *		The name of the authority governing the URL's name
	 *		space.  Examples:  "example.com", "user@example.com",
	 *		"example.com:80", "user:password@example.com:80".
	 *
	 *		The authority may include a host name, port number,
	 *		user name, and password.
	 *
	 *		The host may be a name, an IPv4 numeric address, or
	 *		an IPv6 numeric address.
	 *
	 *	path
	 *		The hierarchical path to the URL's resource.
	 *		Examples:  "/index.htm", "/scripts/page.php".
	 *
	 *	query
	 *		The data for a query.  Examples:  "?search=google.com".
	 *
	 *	fragment
	 *		The name of a secondary resource relative to that named
	 *		by the path.  Examples:  "#section1", "#header".
	 *
	 * An "absolute" URL must include a scheme and path.  The authority, query,
	 * and fragment components are optional.
	 *
	 * A "relative" URL does not include a scheme and must include a path.  The
	 * authority, query, and fragment components are optional.
	 *
	 * This function splits the $url argument into the following components
	 * and returns them in an associative array.  Keys to that array include:
	 *
	 *	"scheme"	The scheme, such as "http".
	 *	"host"		The host name, IPv4, or IPv6 address.
	 *	"port"		The port number.
	 *	"user"		The user name.
	 *	"pass"		The user password.
	 *	"path"		The path, such as a file path for "http".
	 *	"query"		The query.
	 *	"fragment"	The fragment.
	 *
	 * One or more of these may not be present, depending upon the URL.
	 *
	 * Optionally, the "user", "pass", "host" (if a name, not an IP address),
	 * "path", "query", and "fragment" may have percent-encoded characters
	 * decoded.  The "scheme" and "port" cannot include percent-encoded
	 * characters and are never decoded.  Decoding occurs after the URL has
	 * been parsed.
	 *
	 * Parameters:
	 * 	url		the URL to parse.
	 *
	 * 	decode		an optional boolean flag selecting whether
	 * 			to decode percent encoding or not.  Default = TRUE.
	 *
	 * Return values:
	 * 	the associative array of URL parts, or FALSE if the URL is
	 * 	too malformed to recognize any parts.
	 */

	function split_url( $url, $decode=TRUE )
	{
		// Character sets from RFC3986.
		$xunressub     = 'a-zA-Z\d\-._~\!$&\'()*+,;=';
		$xpchar        = $xunressub . ':@%';
	
		// Scheme from RFC3986.
		$xscheme        = '([a-zA-Z][a-zA-Z\d+-.]*)';
	
		// User info (user + password) from RFC3986.
		$xuserinfo     = '((['  . $xunressub . '%]*)' .
		                 '(:([' . $xunressub . ':%]*))?)';
	
		// IPv4 from RFC3986 (without digit constraints).
		$xipv4         = '(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})';
	
		// IPv6 from RFC2732 (without digit and grouping constraints).
		$xipv6         = '(\[([a-fA-F\d.:]+)\])';
	
		// Host name from RFC1035.  Technically, must start with a letter.
		// Relax that restriction to better parse URL structure, then
		// leave host name validation to application.
		$xhost_name    = '([a-zA-Z\d-.%]+)';
	
		// Authority from RFC3986.  Skip IP future.
		$xhost         = '(' . $xhost_name . '|' . $xipv4 . '|' . $xipv6 . ')';
		$xport         = '(\d*)';
		$xauthority    = '((' . $xuserinfo . '@)?' . $xhost .
			         '?(:' . $xport . ')?)';
	
		// Path from RFC3986.  Blend absolute & relative for efficiency.
		$xslash_seg    = '(/[' . $xpchar . ']*)';
		$xpath_authabs = '((//' . $xauthority . ')((/[' . $xpchar . ']*)*))';
		$xpath_rel     = '([' . $xpchar . ']+' . $xslash_seg . '*)';
		$xpath_abs     = '(/(' . $xpath_rel . ')?)';
		$xapath        = '(' . $xpath_authabs . '|' . $xpath_abs .
				 '|' . $xpath_rel . ')';
	
		// Query and fragment from RFC3986.
		$xqueryfrag    = '([' . $xpchar . '/?' . ']*)';
	
		// URL.
		$xurl          = '^(' . $xscheme . ':)?' .  $xapath . '?' .
		                 '(\?' . $xqueryfrag . ')?(#' . $xqueryfrag . ')?$';
	
	
		// Split the URL into components.
		if ( !preg_match( '!' . $xurl . '!', $url, $m ) )
			return FALSE;
	
		if ( !empty($m[2]) )		$parts['scheme']  = strtolower($m[2]);
	
		if ( !empty($m[7]) ) {
			if ( isset( $m[9] ) )	$parts['user']    = $m[9];
			else			$parts['user']    = '';
		}
		if ( !empty($m[10]) )		$parts['pass']    = $m[11];
	
		if ( !empty($m[13]) )		$h=$parts['host'] = $m[13];
		else if ( !empty($m[14]) )	$parts['host']    = $m[14];
		else if ( !empty($m[16]) )	$parts['host']    = $m[16];
		else if ( !empty( $m[5] ) )	$parts['host']    = '';
		if ( !empty($m[17]) )		$parts['port']    = $m[18];
	
		if ( !empty($m[19]) )		$parts['path']    = $m[19];
		else if ( !empty($m[21]) )	$parts['path']    = $m[21];
		else if ( !empty($m[25]) )	$parts['path']    = $m[25];
	
		if ( !empty($m[27]) )		$parts['query']   = $m[28];
		if ( !empty($m[29]) )		$parts['fragment']= $m[30];
	
		if ( !$decode )
			return $parts;
		if ( !empty($parts['user']) )
			$parts['user']     = rawurldecode( $parts['user'] );
		if ( !empty($parts['pass']) )
			$parts['pass']     = rawurldecode( $parts['pass'] );
		if ( !empty($parts['path']) )
			$parts['path']     = rawurldecode( $parts['path'] );
		if ( isset($h) )
			$parts['host']     = rawurldecode( $parts['host'] );
		if ( !empty($parts['query']) )
			$parts['query']    = rawurldecode( $parts['query'] );
		if ( !empty($parts['fragment']) )
			$parts['fragment'] = rawurldecode( $parts['fragment'] );
		return $parts;
	} 

	function url_remove_dot_segments( $path )
	{
	    // multi-byte character explode
	    $inSegs  = preg_split( '!/!u', $path );
	    $outSegs = array( );
	    foreach ( $inSegs as $seg )
	    {
	        if ( $seg == '' || $seg == '.')
	            continue;
	        if ( $seg == '..' )
	            array_pop( $outSegs );
	        else
	            array_push( $outSegs, $seg );
	    }
	    $outPath = implode( '/', $outSegs );
	    if ( $path[0] == '/' )
	        $outPath = '/' . $outPath;
	    // compare last multi-byte character against '/'
	    if ( $outPath != '/' &&
	        (mb_strlen($path)-1) == mb_strrpos( $path, '/', 'UTF-8' ) )
	        $outPath .= '/';
	    return $outPath;
	}
	
	
	/**
	 * This function joins together URL components to form a complete URL.
	 *
	 * RFC3986 specifies the components of a Uniform Resource Identifier (URI).
	 * This function implements the specification's "component recomposition"
	 * algorithm for combining URI components into a full URI string.
	 *
	 * The $parts argument is an associative array containing zero or
	 * more of the following:
	 *
	 *	"scheme"	The scheme, such as "http".
	 *	"host"		The host name, IPv4, or IPv6 address.
	 *	"port"		The port number.
	 *	"user"		The user name.
	 *	"pass"		The user password.
	 *	"path"		The path, such as a file path for "http".
	 *	"query"		The query.
	 *	"fragment"	The fragment.
	 *
	 * The "port", "user", and "pass" values are only used when a "host"
	 * is present.
	 *
	 * The optional $encode argument indicates if appropriate URL components
	 * should be percent-encoded as they are assembled into the URL.  Encoding
	 * is only applied to the "user", "pass", "host" (if a host name, not an
	 * IP address), "path", "query", and "fragment" components.  The "scheme"
	 * and "port" are never encoded.  When a "scheme" and "host" are both
	 * present, the "path" is presumed to be hierarchical and encoding
	 * processes each segment of the hierarchy separately (i.e., the slashes
	 * are left alone).
	 *
	 * The assembled URL string is returned.
	 *
	 * Parameters:
	 * 	parts		an associative array of strings containing the
	 * 			individual parts of a URL.
	 *
	 * 	encode		an optional boolean flag selecting whether
	 * 			to do percent encoding or not.  Default = true.
	 *
	 * Return values:
	 * 	Returns the assembled URL string.  The string is an absolute
	 * 	URL if a scheme is supplied, and a relative URL if not.  An
	 * 	empty string is returned if the $parts array does not contain
	 * 	any of the needed values.
	 */
	function join_url( $parts, $encode=TRUE )
	{
		if ( $encode )
		{
			if ( isset( $parts['user'] ) )
				$parts['user']     = rawurlencode( $parts['user'] );
			if ( isset( $parts['pass'] ) )
				$parts['pass']     = rawurlencode( $parts['pass'] );
			if ( isset( $parts['host'] ) &&
				!preg_match( '!^(\[[\da-f.:]+\]])|([\da-f.:]+)$!ui', $parts['host'] ) )
				$parts['host']     = rawurlencode( $parts['host'] );
			if ( !empty( $parts['path'] ) )
				$parts['path']     = preg_replace( '!%2F!ui', '/',
					rawurlencode( $parts['path'] ) );
			if ( isset( $parts['query'] ) )
				$parts['query']    = rawurlencode( $parts['query'] );
			if ( isset( $parts['fragment'] ) )
				$parts['fragment'] = rawurlencode( $parts['fragment'] );
		}
	
		$url = '';
		if ( !empty( $parts['scheme'] ) )
			$url .= $parts['scheme'] . ':';
		if ( isset( $parts['host'] ) )
		{
			$url .= '//';
			if ( isset( $parts['user'] ) )
			{
				$url .= $parts['user'];
				if ( isset( $parts['pass'] ) )
					$url .= ':' . $parts['pass'];
				$url .= '@';
			}
			if ( preg_match( '!^[\da-f]*:[\da-f.:]+$!ui', $parts['host'] ) )
				$url .= '[' . $parts['host'] . ']';	// IPv6
			else
				$url .= $parts['host'];			// IPv4 or name
			if ( isset( $parts['port'] ) )
				$url .= ':' . $parts['port'];
			if ( !empty( $parts['path'] ) && $parts['path'][0] != '/' )
				$url .= '/';
		}
		if ( !empty( $parts['path'] ) )
			$url .= $parts['path'];
		if ( isset( $parts['query'] ) )
			$url .= '?' . $parts['query'];
		if ( isset( $parts['fragment'] ) )
			$url .= '#' . $parts['fragment'];
		return $url;
	}
}