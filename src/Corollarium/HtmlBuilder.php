<?php

namespace Corollarium;

use RuntimeException;


class HtmlBuilder
{
    const EOL = "\r\n";


    private static $instance;

    private $title = 'Corollarium';
    private $links = [];
    private $scripts = [];
    private $header = '';
    private $content = '';
    private $footer = '';


    private function __construct()
    {
    }

    public static function sanitizeSpecialChars(string $val)
    {
        return filter_var($val, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    
    public static function builder(): HtmlBuilder
    {
        if (!self::$instance)
        {
            self::$instance = new HtmlBuilder();
        }

        return self::$instance;
    }

    public function addJS(array $paths): HtmlBuilder
    {
        $this->scripts = [];

        foreach ($paths as $path)
        {
            if (!is_string($path)) throw new RuntimeException('Path is invalid');

            $path = self::sanitizeSpecialChars($path);

            $this->scripts[] = "<script type='text/javascript' src='{$path}'></script>";
        }

        return $this;
    }

    public function addCSS(array $paths): HtmlBuilder
    {
        $this->links = [];

        foreach ($paths as $path)
        {
            if (!is_string($path)) throw new RuntimeException('Path is invalid');

            $path = self::sanitizeSpecialChars($path);

            $this->links[] = "<link rel='stylesheet' href='{$path}' />";
        }

        return $this;
    }

    public function setTitle(string $title): HtmlBuilder
    {
        $this->title = self::sanitizeSpecialChars($title);;

        return $this;
    }

    public function head(): string
    {
        $links = implode(self::EOL, $this->links);

        $head = "
            <head>
                <meta charset='UTF-8'>
                <title>{$this->title}</title>
                {$links}
            </head>
        ";

        return trim($head);
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getFooter(): string
    {
        return $this->footer;
    }

    public function setHeader(callable $returnString): HtmlBuilder
    {
        $this->setStrAttribute($this->header, $returnString);

        return $this;
    }

    public function setContent(callable $returnString): HtmlBuilder
    {
        $this->setStrAttribute($this->content, $returnString);

        return $this;
    }

    public function setFooter(callable $returnString): HtmlBuilder
    {
        $this->setStrAttribute($this->footer, $returnString);

        return $this;
    }

    public function render(): string
    {
        $head = $this->head();
        $scripts = implode(self::EOL, $this->scripts);

        $html = "
            <html>
            {$head}
            <body>
            {$this->header}
            {$this->content}
            {$this->footer}
            {$scripts}
            </body>
            </html>
        ";

        return trim($html);
    }

    private function setStrAttribute(&$attribute, callable $returnString)
    {
        $ret = $returnString();

        if (!is_string($ret)) throw new RuntimeException('Callable did not return a string');

        $attribute = trim($ret);
    }
}