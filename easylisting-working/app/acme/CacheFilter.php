<?php
namespace acme\Filters;
 
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Debugbar;
use Carbon;
 
use Str;
use Cache;
 
class CacheFilter {
    
    public function grab( Route $route, Request $request )
    {
        $key = $this->keygen($request->url());
        
        if( Cache::has( $key ) ) {
            Debugbar::info('read key '.$key.' from cache');
            return Cache::get( $key );
        } 
    }
    
    public function set( Route $route, Request $request, Response $response )
    {
        $key = $this->keygen($request->url());
        
        $expire_cache_at = Carbon::now()->addMinutes(1440 * 1);// 1 day

        if( ! Cache::has( $key ) ) Cache::put( $key, $response->getContent(), $expire_cache_at);
    }
    
    protected function keygen( $url )
    {
        return 'route_' . Str::slug( $url );
    }
    
}