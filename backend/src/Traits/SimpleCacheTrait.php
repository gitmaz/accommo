<?php
namespace Traits;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\AdapterInterface;

trait SimpleCacheTrait
{
    private $cache;

    public function __construct(AdapterInterface $cache = null)
    {
        // If no cache is provided, use FilesystemAdapter as default
        $this->cache = $cache ?: new FilesystemAdapter();
    }

    public function getCachedData($cacheKey)
    {
        // Attempt to get cached data
        return $this->cache->getItem($cacheKey)->get();
    }

    public function cacheData($cacheKey, $data, $expiration = 86400)
    {
        // Cache the data with expiration time
        $item = $this->cache->getItem($cacheKey);
        $item->set($data);
        $item->expiresAfter($expiration);
        $this->cache->save($item);
    }
}
