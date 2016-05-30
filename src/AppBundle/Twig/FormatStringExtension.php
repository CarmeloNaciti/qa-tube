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

    public function toSnakeCase($input)
    {
        $input = preg_replace("/[^A-Za-z0-9 ]/", ' ', $input);
        $input = preg_replace('/\s+/', ' ', $input);

        return strtolower(str_replace(' ', '_', $input));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'str_replace_extension';
    }
}