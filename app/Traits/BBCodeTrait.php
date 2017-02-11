<?php

namespace App\Traits;

trait BBCodeTrait{
public function bbcode($string)
    {
        if (!empty($string)) {
            $search = array(
                '@\[(?i)b\](.*?)\[/(?i)b\]@si',
                '@\[(?i)i\](.*?)\[/(?i)i\]@si',
                '@\[(?i)u\](.*?)\[/(?i)u\]@si',
                '@\[(?i)img=(.*?)\](.*?)\[/(?i)img\]@si',
                '@\[(?i)youtube\](.*?)\[/(?i)youtube\]@si',
                '@\[(?i)vimeo\](.*?)\[/(?i)vimeo\]@si',
                '@\[(?i)p\](.*?)\[/(?i)p\]@si',
                '@\[(?i)br/\]@si',
                '@\[(?i)url=(.*?)\](.*?)\[/(?i)url\]@si',
            );
            $replace = array(
                '<b>\\1</b>',
                '<i>\\1</i>',
                '<u>\\1</u>',
                '<img src="\\1" alt="\\2" />',
                '<iframe width="400" height="250" src="http://www.youtube.com/embed/\\1?theme=dark&iv_load_policy=3&wmode=transparent" frameborder="0" allowfullscreen></iframe>',
                '<iframe src="http://player.vimeo.com/video/\\1?title=0&amp;byline=0&amp;portrait=0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0" width="400" height="250"></iframe>',
                '<p>\\1</p>',
                '<br/>',
                '<a href="\\1">\\2</a>'
            );
            return preg_replace($search , $replace, $string);
        }
        return false;
    }
}
