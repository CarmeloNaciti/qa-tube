<?php

namespace AppBundle\Twig;

/**
 * Class AppExtension
 * @package AppBundle\Twig
 */
class StringReplaceExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('ireplace', [$this, 'stringReplaceCaseInsensitive'])
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
     * @return string
     */
    public function getName()
    {
        return 'str_replace_extension';
    }
}