<?php

namespace Map\Reader;

use Doctrine\Common\Cache\Cache;
use Map\Entities\Coordinates;
use Map\Entities\Link;
use Map\Entities\Node;
use SimpleXMLElement;

class AirStreamXMLReader
{
    /**
     * @var string
     */
    private $nodeDbUsername;

    /**
     * @var string
     */
    private $nodeDbPassword;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * AirStreamXMLReader constructor.
     * @param string $nodeDbUsername
     * @param string $nodeDbPassword
     * @param Cache $cache
     */
    public function __construct(string $nodeDbUsername, string $nodeDbPassword, Cache $cache)
    {
        $this->nodeDbUsername = $nodeDbUsername;
        $this->nodeDbPassword = $nodeDbPassword;
        $this->cache = $cache;
    }

    /**
     * @return Node[]
     */
    public function nodes() : array
    {
        if ($this->cache->contains('nodes')) {
            return $this->cache->fetch('nodes');
        }

        $data = $this->xml();

        $data = array_filter($data, function ($node) {
            return $node['status'] == 3;
        });

        $nodes = array_combine(array_map(function ($node) {
            return $node['id'];
        }, $data), array_map(function ($node) {
            $coordinates = new Coordinates((float) $node['lat'], (float) $node['lon']);
            $accessPoint = count((array) $node->ap);
            return new Node((integer) $node['id'], (string) $node['name'], $coordinates, $accessPoint);
        }, $data));

        $this->cache->save('nodes', $nodes, 300);

        return $nodes;
    }

    /**
     * @return Link[]
     */
    public function links() : array
    {
        if ($this->cache->contains('links')) {
            return $this->cache->fetch('links');
        }

        $data = $this->xml();

        $nodes = $this->nodes();

        foreach ($data as $node) {
            foreach ($node->link as $link) {
                if (array_key_exists((string) $node['id'], $nodes) && array_key_exists((string) $link['dstnode'], $nodes)) {
                    $links[] = new Link(
                        $nodes[(string) $node['id']],
                        $nodes[(string) $link['dstnode']],
                        $link['mode'],
                        $link['type']
                    );
                }
            }
        }

        $this->cache->save('links', $links, 300);

        return $links;
    }

    /**
     * @return array
     */
    private function xml() : array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://members.air-stream.org/login');
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['username' => $this->nodeDbUsername, 'password' => $this->nodeDbPassword]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_exec($ch);

        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_URL, 'https://members.air-stream.org/node/xmlnodes');

        $data = curl_exec($ch);

        curl_close($ch);

        $xml = new SimpleXMLElement($data);
        $xml = (array) $xml;
        return array_pop($xml);
    }
}
