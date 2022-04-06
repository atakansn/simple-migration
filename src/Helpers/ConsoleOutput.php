<?php

namespace SimpleMigration\Helpers;

use SimpleMigration\Helpers\OutputComponent\Color;
use SimpleMigration\Helpers\OutputComponent\TableFunctions;
use SimpleMigration\Helpers\OutputComponent\VariousFunctions;

class ConsoleOutput extends TableFunctions
{
    use VariousFunctions,Color;

    public const FOREGROUND = 38, BACKGROUND = 48;

    public const COLOR256_REGEXP = '~^(bg_)?color_([0-9]{1,3})$~';

    public const RESET_STYLE = 0;

    private bool $isSupported;

    private static $instance;

    public function __construct()
    {
        $this->isSupported = $this->isSupported();
    }

    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function applyStyle(string|array $style, string $text)
    {
        if (!$this->isSupported()) {
            return $text;
        }

        if (is_string($style)) {
            $style = [$style];
        }
        if (!is_array($style)) {
            echo "Style must be string or array.";
        }

        $sequences = [];

        foreach ($style as $s) {
            if ($this->isValidStyle($s)) {
                $sequences[] = $this->styleSequence($s);
            } else {
                echo $s;
            }
        }

        $sequences = array_filter($sequences, static function ($val) {
            return $val !== null;
        });

        if (empty($sequences)) {
            return $text;
        }

         return $this->escSequence(implode(';', $sequences)) . $text . $this->escSequence(self::RESET_STYLE);
    }

    public function isStyleForced()
    {
        return $this->forceStyle;
    }

    private function styleSequence($style)
    {
        if (array_key_exists($style, $this->styles)) {
            return $this->styles[$style];
        }

        if (!$this->are256ColorsSupported()) {
            return null;
        }

        preg_match(self::COLOR256_REGEXP, $style, $matches);

        $type = $matches[1] === 'bg_' ? self::BACKGROUND : self::FOREGROUND;
        $value = $matches[2];

        return "$type;5;$value";
    }

    private function isValidStyle($style)
    {
        return array_key_exists($style, $this->styles) || preg_match(self::COLOR256_REGEXP, $style);
    }

    private function escSequence($value)
    {
        return "\033[{$value}m";
    }

    public function eol()
    {

        return PHP_EOL;
    }


}