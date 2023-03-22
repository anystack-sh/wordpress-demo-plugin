<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\Lexer\TokenEmulator;

use Anystack\WPGuard\V001\PhpParser\Lexer\Emulative;

final class FnTokenEmulator extends KeywordEmulator
{
    public function getPhpVersion(): string
    {
        return Emulative::PHP_7_4;
    }

    public function getKeywordString(): string
    {
        return 'fn';
    }

    public function getKeywordToken(): int
    {
        return \T_FN;
    }
}