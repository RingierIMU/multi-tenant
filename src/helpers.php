<?php

if (!function_exists('parse_domain')) {

    /**
     * Extract tld, subDomain and host name
     *
     * @param string $domain
     *
     * @return array
     */
    function parse_domain(string $domain)
    {
        // non country TLD according to IANA
        $tlds = array(
            'aero',
            'arpa',
            'asia',
            'biz',
            'cat',
            'com',
            'coop',
            'edu',
            'gov',
            'info',
            'jobs',
            'mil',
            'mobi',
            'museum',
            'name',
            'net',
            'org',
            'post',
            'pro',
            'tel',
            'travel',
            'xxx',
        );

        $domain = preg_replace("/www./", '', $domain);

        $arr = array_slice(array_filter(explode('.', $domain, 3), function ($value) {
            return $value !== 'www';
        }), 0); //rebuild array indexes

        if (count($arr) > 2) {
            $count = count($arr);

            if ($count === 3) {
                $tld =  explode('.', $arr[2]);

                if (in_array($arr[1], $tlds) || strlen($arr[1]) === 2) {
                    $arr[2] = $arr[1] . "." . $arr[2];
                    $tld = explode('.', $arr[2]);
                    unset($arr[1]);
                }
            } else {
                $tld = explode('.', $arr[1]);
            }

            if (count($tld) === 2) { // two level TLD
                $subDomain = array_shift($arr); //remove the subdomain
                if (strlen($tld[0]) === 2 && count($arr) == 1) { // TLD domain must be 2 letters
                    array_unshift($arr, $subDomain);
                    $subDomain = '';
                } else {
                    if (strlen($tld[0]) !== 2 && !in_array($tld[0], $tlds)) { //special TLD don't have a country
                        array_shift($tld);
                    } elseif (in_array($tld[0], $tlds) && count($arr) == 1 && count($tld) == 2) {
                        array_unshift($arr, $subDomain);
                        $subDomain = '';
                    }
                }
            } elseif (count($tld) === 1) { // one level TLD
                $subDomain = array_shift($arr); //remove the subDomain
                if (strlen($tld[0]) === 2 && $count === 3) {// TLD domain must be 2 letters
                    //array_unshift($arr, $subDomain);
                    //$subDomain = '';
                } else {
                    if (!in_array($tld[0], $tlds)) {//special TLD don't have a country
                        array_shift($tld);
                    } elseif (in_array($tld[0], $tlds) && count($arr) == 1) {
                        array_unshift($arr, $subDomain);
                        $subDomain = '';
                    }
                }
            } else { // more than 3 levels, something is wrong
                for ($i = count($tld); $i > 1; $i--) {
                    $subDomain = array_shift($arr);
                }
            }
        } else {
            $subDomain = $tld = '';

            if (count($arr) == 2) {
                $subDomain = array_shift($arr);

                if (strlen($arr[0]) == 2 || in_array($arr[0], $tlds)
                    || in_array($arr[0], ['local','test','invalid'])) {
                    $tld = explode('.', $arr[0]);
                    array_unshift($arr, $subDomain);
                    $subDomain = '';
                }
            }
        }

        return [
            'sub_domain' => $subDomain,
            'host' => join('.', $arr),
            'tld'=> (!empty($tld)) ? "." . join('.', $tld) : ""
        ];
    }
}
