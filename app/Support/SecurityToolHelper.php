<?php

namespace App\Support;

class SecurityToolHelper
{
    public static function normalizeDomain(string $input): ?string
    {
        $input = trim($input);
        if ($input === '') {
            return null;
        }

        if (!preg_match('#^https?://#i', $input)) {
            $input = 'http://' . $input;
        }

        $host = parse_url($input, PHP_URL_HOST);
        if (!$host) {
            return null;
        }

        $host = strtolower(trim($host, ". \t\n\r\0\x0B"));
        if (function_exists('idn_to_ascii')) {
            $ascii = idn_to_ascii($host, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
            if ($ascii) {
                $host = $ascii;
            }
        }

        if (!filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            return null;
        }

        return $host;
    }

    public static function normalizeUrl(string $input): ?string
    {
        $input = trim($input);
        if ($input === '') {
            return null;
        }

        if (!preg_match('#^https?://#i', $input)) {
            $input = 'https://' . $input;
        }

        $host = self::normalizeDomain($input);
        if (!$host) {
            return null;
        }

        $parts = parse_url($input);
        $scheme = strtolower($parts['scheme'] ?? 'https');
        $path = $parts['path'] ?? '';
        $query = isset($parts['query']) ? '?' . $parts['query'] : '';

        return $scheme . '://' . $host . $path . $query;
    }
}
