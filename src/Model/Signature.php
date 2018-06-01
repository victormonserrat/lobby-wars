<?php

/*
 * This file is part of `victormonserrat/lobby-wars`.
 * (c) Victor Monserrat <victormonserratvillatoro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Model;

use App\Exception\InvalidSignature;

final class Signature
{
    public const EMPTY = 'empty';
    public const KING = 'king';
    public const NOTARY = 'notary';
    public const VALIDATOR = 'validator';

    public const CHOICES = [
        self::EMPTY,
        self::KING,
        self::NOTARY,
        self::VALIDATOR,
    ];

    /**
     * @var string
     */
    private $signer;

    public static function empty(): self
    {
        return new self(self::EMPTY);
    }

    public static function fromKing(): self
    {
        return new self(self::KING);
    }

    public static function fromNotary(): self
    {
        return new self(self::NOTARY);
    }

    public static function fromValidator(): self
    {
        return new self(self::VALIDATOR);
    }

    public static function fromSigner(string $signer): self
    {
        return new self($signer);
    }

    private function __construct(string $signer = self::VALIDATOR)
    {
        if (!in_array($signer, self::CHOICES)) {
            throw InvalidSignature::withSigner($signer);
        }

        $this->signer = $signer;
    }

    public function signer(): string
    {
        return $this->signer;
    }

    public function isEmpty(): bool
    {
        return $this->signer === self::EMPTY;
    }

    public function isFromKing(): bool
    {
        return $this->signer === self::KING;
    }

    public function isFromNotary(): bool
    {
        return $this->signer === self::NOTARY;
    }

    public function isFromValidator(): bool
    {
        return $this->signer === self::VALIDATOR;
    }
}
