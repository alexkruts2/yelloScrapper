<?php

namespace App\YelloScrapper;

class curlRequest
{
    private $ch;
    public  $Rheaders = [];
    public $responseHeaders = [];
    public function init($params)
    {
        $this->responseHeaders = [];
        $this->ch = @curl_init();
        $user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36';
        $header = array(
        "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5",
        "Accept-Language: en-US,en;q=0.9",
        "Accept-Charset: utf-8",
        "Keep-Alive: 300");
        if (isset($params['host']) && $params['host'])      $header[]="Host: ".$params['host'];
        if (isset($params['header']) && $params['header']) $header[]=$params['header'];
        
        @curl_setopt ( $this -> ch , CURLOPT_RETURNTRANSFER , 1 );
        @curl_setopt ( $this -> ch , CURLOPT_VERBOSE , 1 );
        @curl_setopt ( $this -> ch , CURLOPT_HEADER , 1 );

        if ($params['method'] == "HEAD") @curl_setopt($this -> ch,CURLOPT_NOBODY,1);
        @curl_setopt ( $this -> ch, CURLOPT_FOLLOWLOCATION, 1);
        @curl_setopt ( $this -> ch , CURLOPT_HTTPHEADER, $header );
        if ($params['referer'])    @curl_setopt ($this -> ch , CURLOPT_REFERER, $params['referer'] );
        @curl_setopt ( $this -> ch , CURLOPT_USERAGENT, $user_agent);
        if (isset($params['cookie']))    @curl_setopt ($this -> ch , CURLOPT_COOKIE, $params['cookie']);
        if (isset($params['cookie_file']))
        {
            @curl_setopt($this -> ch,CURLOPT_COOKIEJAR,$params['cookie_file']); 
            @curl_setopt ($this -> ch , CURLOPT_COOKIEFILE, $params['cookie_file']);
        }    
        if ( $params['method'] == "POST" )
        {
            @curl_setopt( $this -> ch, CURLOPT_POST, true );
            @curl_setopt( $this -> ch, CURLOPT_POSTFIELDS, $params['post_fields'] );
        }
        @curl_setopt( $this -> ch, CURLOPT_URL, $params['url']);
        @curl_setopt ( $this -> ch , CURLOPT_SSL_VERIFYPEER, 0 );
        @curl_setopt ( $this -> ch , CURLOPT_SSL_VERIFYHOST, 0 );
        if (isset($params['login']) & isset($params['password']))
            @curl_setopt($this -> ch , CURLOPT_USERPWD,$params['login'].':'.$params['password']);
        @curl_setopt ( $this -> ch , CURLOPT_TIMEOUT, $params['timeout']);
        @curl_setopt($this -> ch, CURLOPT_HEADERFUNCTION, 
        function($curl, $header) use ($Rheaders)
        {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) // ignore invalid headers
                return $len;
            $name = strtolower(trim($header[0]));
            if (!array_key_exists($name, $this->responseHeaders))
                $this->responseHeaders[$name] = [trim($header[1])];
            else
                $this->responseHeaders[$name][] = trim($header[1]);
            return $len;
        });
    }
    /**
     * Make curl request
     *
     * @return array  'header','body','curl_error','http_code','last_url'
     */
    public function exec()
    {
        $response = @curl_exec($this->ch);
        $error = @curl_error($this->ch);
        $result = array( 'header' => '', 
                         'body' => '', 
                         'curl_error' => '', 
                         'http_code' => '',
                         'last_url' => '');
        if ( $error != "" )
        {
            $result['curl_error'] = $error;
            return $result;
        }
        $header_size = @curl_getinfo($this->ch,CURLINFO_HEADER_SIZE);
        $result['header'] = $this->responseHeaders;
        $result['body'] = substr( $response, $header_size );
        $result['http_code'] = @curl_getinfo($this -> ch,CURLINFO_HTTP_CODE);
        $result['last_url'] = @curl_getinfo($this -> ch,CURLINFO_EFFECTIVE_URL);
        @curl_close ($this->ch);
        return $result;
    }
}

?>