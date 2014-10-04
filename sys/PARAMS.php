<?php


/**
 * This remembers parameters for certain pages
 */
class PARAMS
{
    const PARAM_KEY = 'param_';
    
    public static function Create($paramName, $paramValue, $page=null)
    {
        // format: 'param_PAGENAME'
        $paramKey = self::__GetQualifiedKey($page);
        if ( !isset($_SESSION[$paramKey]) )
        {
            $_SESSION[$paramKey] = array();
        }
        array_push($_SESSION[$paramKey], array(
                'name' => $paramName,
                'value' => $paramValue
            )
        );
    }
    
    public static function Get($paramName, $page=null)
    {
        for ( $x=0,reset($_SESSION); $x<count($_SESSION); $x++,next($_SESSION) )
        {
            $key = key($_SESSION);
            $value = current($_SESSION);
            
            // Prepare the target key
            $targetkey = self::__GetQualifiedKey($page);
            
            if ( $key === $targetkey )
            {
                $parameters = $value;
                // find the given parameter
                foreach ($parameters as $parameter)
                {
                    if ($parameter['name'] == $paramName )
                    {
                        return $parameter['value'];
                    }
                }
            }
        }
        return null;
    }
    
    protected static function __GetQualifiedKey($page=null)
    {
        if ( is_null($page) )
        {
            $page = '';
        }
        return self::PARAM_KEY . strtoupper($page);
    }
    
}


?>