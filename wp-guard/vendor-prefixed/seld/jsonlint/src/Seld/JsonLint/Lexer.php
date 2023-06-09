<?php

/*
 * This file is part of the JSON Lint package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Seld\JsonLint;

/**
 * Lexer class
 *
 * Ported from https://github.com/zaach/jsonlint
 */
class Lexer
{
    /** @internal */
    const EOF = 1;
    /** @internal */
    const T_INVALID = -1;
    const T_SKIP_WHITESPACE = 0;
    const T_ERROR = 2;

    /**
     * @phpstan-var array<int<0,13>, string>
     * @const
     */
    private $rules = array(
        0 => '/\G\s+/',
        1 => '/\G-?([0-9]|[1-9][0-9]+)(\.[0-9]+)?([eE][+-]?[0-9]+)?\b/',
        2 => '{\G"(?>\\\\["bfnrt/\\\\]|\\\\u[a-fA-F0-9]{4}|[^\0-\x1f\\\\"]++)*+"}',
        3 => '/\G\{/',
        4 => '/\G\}/',
        5 => '/\G\[/',
        6 => '/\G\]/',
        7 => '/\G,/',
        8 => '/\G:/',
        9 => '/\Gtrue\b/',
        10 => '/\Gfalse\b/',
        11 => '/\Gnull\b/',
        12 => '/\G$/',
        13 => '/\G./',
    );

    /** @var string */
    private $input;
    /** @var bool */
    private $more;
    /** @var bool */
    private $done;
    /** @var 0|positive-int */
    private $offset;

    /** @var string */
    public $match;
    /** @var 0|positive-int */
    public $yylineno;
    /** @var 0|positive-int */
    public $yyleng;
    /** @var string */
    public $yytext;
    /** @var array{first_line: 0|positive-int, first_column: 0|positive-int, last_line: 0|positive-int, last_column: 0|positive-int} */
    public $yylloc;

    /**
     * @return 1|4|6|8|10|11|14|17|18|21|22|23|24|-1
     */
    public function lex()
    {
        do {
            $symbol = $this->next();
        } while ($symbol === self::T_SKIP_WHITESPACE);

        return $symbol;
    }

    /**
     * @param string $input
     * @return $this
     */
    public function setInput($input)
    {
        $this->input = $input;
        $this->more = false;
        $this->done = false;
        $this->offset = 0;
        $this->yylineno = $this->yyleng = 0;
        $this->yytext = $this->match = '';
        $this->yylloc = array('first_line' => 1, 'first_column' => 0, 'last_line' => 1, 'last_column' => 0);

        return $this;
    }

    /**
     * @return string
     */
    public function showPosition()
    {
        $pre = str_replace("\n", '', $this->getPastInput());
        $c = str_repeat('-', max(0, \strlen($pre) - 1)); // new Array(pre.length + 1).join("-");

        return $pre . str_replace("\n", '', $this->getUpcomingInput()) . "\n" . $c . "^";
    }

    /**
     * @return string
     */
    public function getPastInput()
    {
        $pastLength = $this->offset - \strlen($this->match);

        return ($pastLength > 20 ? '...' : '') . substr($this->input, max(0, $pastLength - 20), min(20, $pastLength));
    }

    /**
     * @return string
     */
    public function getUpcomingInput()
    {
        $next = $this->match;
        if (\strlen($next) < 20) {
            $next .= substr($this->input, $this->offset, 20 - \strlen($next));
        }

        return substr($next, 0, 20) . (\strlen($next) > 20 ? '...' : '');
    }

    /**
     * @return string
     */
    public function getFullUpcomingInput()
    {
        $next = $this->match;
        if (substr($next, 0, 1) === '"' && substr_count($next, '"') === 1) {
            $len = \strlen($this->input);
            if ($len === $this->offset) {
                $strEnd = $len;
            } else {
                $strEnd = min(strpos($this->input, '"', $this->offset + 1) ?: $len, strpos($this->input, "\n", $this->offset + 1) ?: $len);
            }
            $next .= substr($this->input, $this->offset, $strEnd - $this->offset);
        } elseif (\strlen($next) < 20) {
            $next .= substr($this->input, $this->offset, 20 - \strlen($next));
        }

        return $next;
    }

    /**
     * @param string $str
     * @return never
     */
    protected function parseError($str)
    {
        throw new ParsingException($str);
    }

    /**
     * @return 0|1|4|6|8|10|11|14|17|18|21|22|23|24|-1
     */
    private function next()
    {
        if ($this->done) {
            return self::EOF;
        }
        if ($this->offset === \strlen($this->input)) {
            $this->done = true;
        }

        $token = null;
        $match = null;
        $col = null;
        $lines = null;

        if (!$this->more) {
            $this->yytext = '';
            $this->match = '';
        }

        $rulesLen = 14; // count($this->rules)

        for ($i=0; $i < $rulesLen; $i++) {
            if (preg_match($this->rules[$i], $this->input, $match, 0, $this->offset)) {
                $lines = explode("\n", $match[0]);
                array_shift($lines);
                $lineCount = \count($lines);
                $this->yylineno += $lineCount;
                $this->yylloc = array(
                    'first_line' => $this->yylloc['last_line'],
                    'last_line' => $this->yylineno+1,
                    'first_column' => $this->yylloc['last_column'],
                    'last_column' => $lineCount > 0 ? \strlen($lines[$lineCount - 1]) : $this->yylloc['last_column'] + \strlen($match[0]),
                );
                $this->yytext .= $match[0];
                $this->match .= $match[0];
                $this->yyleng = \strlen($this->yytext);
                $this->more = false;
                $this->offset += \strlen($match[0]);
                return $this->performAction($i);
            }
        }

        if ($this->offset === \strlen($this->input)) {
            return self::EOF;
        }

        $this->parseError(
            'Lexical error on line ' . ($this->yylineno+1) . ". Unrecognized text.\n" . $this->showPosition()
        );
    }

    /**
     * @param  int $rule
     * @return 0|4|6|8|10|11|14|17|18|21|22|23|24|-1
     */
    private function performAction($rule)
    {
        switch ($rule) {
        case 0:/* skip whitespace */
            return self::T_SKIP_WHITESPACE;
        case 1:
            return 6;
        case 2:
            $this->yytext = substr($this->yytext, 1, $this->yyleng-2);

            return 4;
        case 3:
            return 17;
        case 4:
            return 18;
        case 5:
            return 23;
        case 6:
            return 24;
        case 7:
            return 22;
        case 8:
            return 21;
        case 9:
            return 10;
        case 10:
            return 11;
        case 11:
            return 8;
        case 12:
            return 14;
        case 13:
            return self::T_INVALID;
        default:
            throw new \LogicException('Unsupported rule '.$rule);
        }
    }
}
