<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
/**
 * From V3.6
 * Get app_config
 * @param string #params
 * @return config data
 */

if (!function_exists('app_config')) {
    function app_config($params)
    {
        $CI = &get_instance();
        $value = $CI->config->item($params);
        return $value;
    }
}

/**
 * From V3.6
 * Performs simple auto-escaping of data for security reasons.
 * Might consider making this more complex at a later date.
 *
 * If $data is a string, then it simply escapes and returns it.
 * If $data is an array, then it loops over it, escaping each
 * 'value' of the key/value pairs.
 *
 * Valid context values: html, js, css, url, attr, raw, null
 *
 * @param array|string $data
 * @param string       $encoding
 *
 * @throws InvalidArgumentException
 *
 * @return array|string
 */
if (!function_exists('esc')) {
    function esc($data, $context = 'html', $encoding = null)
    {
        if (is_array($data)) {
            foreach ($data as &$value) {
                $value = esc($value, $context);
            }
        }

        if (is_string($data)) {
            $context = strtolower($context);

            // Provide a way to NOT escape data since
            // this could be called automatically by
            // the View library.
            if (empty($context) || $context === 'raw') {
                return $data;
            }

            if (!in_array($context, ['html', 'js', 'css', 'url', 'attr'], true)) {
                throw new InvalidArgumentException('Invalid escape context provided.');
            }

            $method = $context === 'attr' ? 'escapeHtmlAttr' : 'escape' . ucfirst($context);

            static $escaper;
            $CI = &get_instance();
            $CI->load->library('Escaper');
            if (!$escaper) {
                $escaper = new Escaper($encoding);
            }

            if ($encoding && $escaper->getEncoding() !== $encoding) {
                $escaper = new Escaper($encoding);
            }

            $data = $escaper->{$method}($data);
        }

        return $data;
    }
}
