<?php

/*
 * This file is part of `victormonserrat/lobby-wars`.
 * (c) Victor Monserrat <victormonserratvillatoro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Exception;

use DomainException;

final class InvalidContract extends DomainException
{
    public static function withMoreThanOneEmptySignatures(): self
    {
        return new self('More than one empty signatures');
    }

    private function __construct(string $message)
    {
        parent::__construct($message);
    }
}
