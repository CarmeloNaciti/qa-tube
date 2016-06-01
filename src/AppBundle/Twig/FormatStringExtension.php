<?php

namespace AppBundle\Twig;

/**
 * Class AppExtension
 * @package AppBundle\Twig
 */
class FormatStringExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('ireplace', [$this, 'stringReplaceCaseInsensitive']),
            new \Twig_SimpleFilter('snakecase', [$this, 'toSnakeCase']),
            new \Twig_SimpleFilter('snippet', [$this, 'generateSnippet']),
        ];
    }

    /**
     * @param $input
     * @param array $replace
     *
     * @return mixed
     */
    public function stringReplaceCaseInsensitive($input, array $replace)
    {
        return str_ireplace(array_keys($replace), array_values($replace), $input);
    }

    /**
     * @param $input
     *
     * @return string
     */
    public function toSnakeCase($input)
    {
        $input = preg_replace("/[^A-Za-z0-9 ]/", ' ', $input);
        $input = preg_replace('/\s+/', ' ', $input);

        return strtolower(str_replace(' ', '_', $input));
    }

    /**
     * @param string $text
     * @param string $query
     * @param int    $expand
     *
     * @return string
     */
    public function generateSnippet($text, $query, $expand = 5)
    {
        $start = stripos($text, $query);
        $len = strlen($text);
        $end = strpos($text, ' ', $start + strlen($query));
        $end = ($end == false) ? $len : $end;
        $before = '';
        $after = '';

        if ($start > 0) {
            $words = array_reverse(explode(' ', substr($text, 0, $start)));
            $expand = (sizeof($words) > $expand) ? $expand : sizeof($words);
            $before = implode(' ', array_reverse(array_slice($words, 0, $expand)));
        }

        if ($start + strlen($query) < $len - 1) {
            $words = explode(' ', substr($text, $end + 1, $len - 1));
            $expand = (sizeof($words) > $expand) ? $expand : sizeof($words);
            $after = implode(' ', array_slice($words, 0, $expand));
        }

        $result = $before . substr($text, $start, $end - $start) . ' ' . $after;

        return '...' . $result . '...';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'str_replace_extension';
    }
}