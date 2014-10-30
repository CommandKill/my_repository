<?php

Class L18n{

    /*
    |
    | Gets the URL of the current page and applies the desired language to it.
    | If `lang` is set to "en" then the URL for the route `trips` should look
    | like `http://domain.com/en/trips`. If the `lang` is set to "" then the URL
    | should look like `http://domain.com/trips`.
    |
    */
    static function currentUrl($lang = "")
    {
        // if the desired language is found in the supported_locales variable
        if( in_array($lang, Config::get('locales.available_locales')) )
        {
            // if the first part of the URL is found in the supported_locales
            if( in_array(Request::segment(1), Config::get('locales.available_locales')) )
            {
                // remove the first two characters from the `path`; DELETE (en)
                $cleanPath = substr(Request::path(), 2);
                // replace current `path` with the modified `lang` + `cleanPath`; MERGE (de/path)
                $translated = str_replace(Request::path(), $lang.$cleanPath, Request::url());
            }
            // else if the first part of the URL is null; DOES NOT EXIST (there is no language set)
            elseif (Request::segment(1)==null)
            {
                // append `lang` to the end of the  current URL
                $translated = Request::url().'/'.$lang;
            }
            // else if the first part of the URL is something, but not a language then
            else{
                // save current path
                $path = Request::path();
                // append `lang` and `path` to `domain`
                $translated = Config::get('app.url').'/'.$lang.'/'.$path;
            }

            return $translated;
        }
        // if the desired language is not found in the supported_locales variable; (default to app.locale)
        else{
            // if the first part  of the URL is found in the supported_locales (the user is currently viewing the translated page)
            if( in_array(Request::segment(1), Config::get('locales.available_locales')) )
            {
                // remove the first three characters from `path`; DELETE (en/)
                $cleanPath = substr(Request::path(), 3);
                // replace current `path` with `cleanPath`
                $default = str_replace(Request::path(), $cleanPath, Request::url());
            }
            // the URL has no language set
            else{
                // just return the current URL
                $default = Request::url();
            }

            return $default;
        }
    }

}