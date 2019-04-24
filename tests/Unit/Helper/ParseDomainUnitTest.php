<?php namespace Ringierimu\MultiTenancy\Tests\Unit\Helper;

use Ringierimu\MultiTenancy\Tests\TestCase;

/**
 * Class ParseDomainUnitTest
 * @package Ringierimu\MultiTenancy\Tests
 */
class ParseDomainUnitTest extends TestCase
{
    private $testUrls = [
        'www.example.com' => [
            'sub_domain' => '',
            'host' => 'example.com',
            'tld' => '.com'
        ],
        'example.com' => [
            'sub_domain' => '',
            'host' => 'example.com',
            'tld' => '.com'
        ],
        'example.com.br' => [
            'sub_domain' => '',
            'host' => 'example.com.br',
            'tld' => '.com.br'
        ],
        'www.example.com.br' => [
            'sub_domain' => '',
            'host' => 'example.com.br',
            'tld' => '.com.br'
        ],
        'www.example.gov.br' => [
            'sub_domain' => '',
            'host' => 'example.gov.br',
            'tld' => '.gov.br'
        ],
        'localhost' => [
            'sub_domain' => '',
            'host' => 'localhost',
            'tld' => ''
        ],
        'www.localhost' => [
            'sub_domain' => '',
            'host' => 'localhost',
            'tld' => ''
        ],
        'subdomain.localhost' => [
            'sub_domain' => 'subdomain',
            'host' => 'localhost',
            'tld' => ''
        ],
        'www.subdomain.example.com' => [
            'sub_domain' => 'subdomain',
            'host' => 'example.com',
            'tld' => '.com'
        ],
        'subdomain.example.com' => [
            'sub_domain' => 'subdomain',
            'host' => 'example.com',
            'tld' => '.com'
        ],
        'subdomain.example.com.br' => [
            'sub_domain' => 'subdomain',
            'host' => 'example.com.br',
            'tld' => '.com.br'
        ],
        'www.subdomain.example.com.br' => [
            'sub_domain' => 'subdomain',
            'host' => 'example.com.br',
            'tld' => '.com.br'
        ],
        'www.subdomain.example.biz.br' => [
            'sub_domain' => 'subdomain',
            'host' => 'example.biz.br',
            'tld' => '.biz.br'
        ],
        'subdomain.example.biz.br' => [
            'sub_domain' => 'subdomain',
            'host' => 'example.biz.br',
            'tld' => '.biz.br'
        ],
        'subdomain.example.net' => [
            'sub_domain' => 'subdomain',
            'host' => 'example.net',
            'tld' => '.net'
        ],
        'www.subdomain.example.net' => [
            'sub_domain' => 'subdomain',
            'host' => 'example.net',
            'tld' => '.net'
        ],
        'www.subdomain.example.co.kr' => [
            'sub_domain' => 'subdomain',
            'host' => 'example.co.kr',
            'tld' => '.co.kr'
        ],
        'subdomain.example.co.kr' => [
            'sub_domain' => 'subdomain',
            'host' => 'example.co.kr',
            'tld' => '.co.kr'
        ],
        'example.co.kr' => [
            'sub_domain' => '',
            'host' => 'example.co.kr',
            'tld' => '.co.kr'
        ],
        'example.jobs' => [
            'sub_domain' => '',
            'host' => 'example.jobs',
            'tld' => '.jobs'
        ],
        'www.example.jobs' => [
            'sub_domain' => '',
            'host' => 'example.jobs',
            'tld' => '.jobs'
        ],
        'subdomain.example.jobs' => [
            'sub_domain' => 'subdomain',
            'host' => 'example.jobs',
            'tld' => '.jobs'
        ],
        'insane.subdomain.example.jobs' => [
            'sub_domain' => 'subdomain',
            'host' => 'example.jobs',
            'tld' => '.jobs'
        ],
        'insane.subdomain.example.com.br' => [
            'sub_domain' => 'subdomain',
            'host' => 'example.com.br',
            'tld' => '.com.br'
        ],
        'www.doubleinsane.subdomain.example.com.br' => [
            'sub_domain' => 'subdomain',
            'host' => 'example.com.br',
            'tld' => '.com.br'
        ],
        'www.subdomain.example.jobs' => [
            'sub_domain' => 'subdomain',
            'host' => 'example.jobs',
            'tld' => '.jobs'
        ],
        'test' => [
            'sub_domain' => '',
            'host' => 'test',
            'tld' => ''
        ],
        'www.test' => [
            'sub_domain' => '',
            'host' => 'test',
            'tld' => ''
        ],
        'subdomain.test' => [
            'sub_domain' => 'subdomain',
            'host' => 'test',
            'tld' => ''
        ],
        'www.detran.sp.gov.br' => [
            'sub_domain' => 'detran',
            'host' => 'sp.gov.br',
            'tld' => '.gov.br'
        ],
        'www.mp.sp.gov.br' => [
            'sub_domain' => 'mp',
            'host' => 'sp.gov.br',
            'tld' => '.gov.br'
        ],
        'ny.library.museum' => [
            'sub_domain' => 'ny',
            'host' => 'library.museum',
            'tld' => '.museum'
        ],
        'www.ny.library.museum' => [
            'sub_domain' => 'ny',
            'host' => 'library.museum',
            'tld' => '.museum'
        ],
        'ny.ny.library.museum' => [
            'sub_domain' => 'ny.ny',
            'host' => 'library.museum',
            'tld' => '.museum'
        ],
        'www.library.museum' => [
            'sub_domain' => '',
            'host' => 'library.museum',
            'tld' => '.museum'
        ],
        'info.abril.com.br' => [
            'sub_domain' => 'info',
            'host' => 'abril.com.br',
            'tld' => '.com.br'
        ],
        '127.0.0.1' => [
            'sub_domain' => '',
            'host' => '127.0.0.1',
            'tld' => ''
        ],
        '::1' => [
            'sub_domain' => '',
            'host' => '::1',
            'tld' => ''
        ],
    ];

    public function testResolveDomain()
    {
        foreach ($this->testUrls as $domain => $expected) {
            print("Domain: {$domain} \n\n");
            $results = parse_domain($domain);
            $this->assertEquals($expected, $results);
        }
    }
}
