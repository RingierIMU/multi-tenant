<?php

namespace Ringierimu\MultiTenant\Http\Middleware;

use Closure;
use Ringierimu\MultiTenant\TenantManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TenantMiddleware
 * @package Ringierimu\MultiTenant\Http\Middleware
 */
class TenantMiddleware
{
    /** @var TenantManager */
    protected $tenantManager;

    /**
     * TenantMiddleware constructor.
     *
     * @param TenantManager $tenantManager
     */
    public function __construct(TenantManager $tenantManager)
    {
        $this->tenantManager = $tenantManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->tenantManager->loadTenant($request->getHost())) {
            return $next($request);
        }

        throw new NotFoundHttpException();
    }
}
