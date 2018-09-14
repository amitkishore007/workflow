<?php
namespace App\Http\Middleware;

use Closure;

/**
 * @author  Nitesh Kaushik <nitesh.kaushik@biz2credit.com>
 */
class CorsMiddleware
{
    /**
     * Handle an incoming request.
     * @author Nitesh Kaushik <nitesh.kaushik@biz2credit.com>
     *
     * @param  \Illuminate\Http\Request  $Request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(\Illuminate\Http\Request $Request, Closure $Next)
    {
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => '*'
        ];

        if ($Request->isMethod('OPTIONS')) {
            $response = response('', 200);
        } else {
            $response = $Next($Request);
        }

        if($response instanceof Illuminate\Http\Response) {
            foreach ($headers as $key => $value) {
                $response->header($key, $value);
            }
        }

        if($response instanceof Symfony\Component\HttpFoundation\Response) {
            foreach ($headers as $key => $value) {
                $response->headers->set($key, $value);
            }
        }

        return $response;
    }
}