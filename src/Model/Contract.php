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

use App\Exception\InvalidContract;

final class Contract
{
    private $points = [
        Signature::EMPTY => 0,
        Signature::KING => 5,
        Signature::NOTARY => 2,
        Signature::VALIDATOR => 1,
    ];

    /**
     * @var array
     */
    private $signatures;

    public static function fromSignatures(array $signatures = []): self
    {
        return new self($signatures);
    }

    private function __construct(array $signatures)
    {
        $emptySignatures = array_filter($signatures, function (Signature $signature) {
            return $signature->isEmpty();
        });

        if (count($emptySignatures) > 1) {
            throw InvalidContract::withMoreThanOneEmptySignatures();
        }

        $this->signatures = $signatures;
    }

    public function signatures(): array
    {
        return $this->signatures;
    }

    public function calculateMinimumNecessarySignatureToWin(self $contract): ?Signature
    {
        $points = $this->calculatePoints();
        $contractPoints = $contract->calculatePoints();
        $difference = $contractPoints - $points;

        if ($difference >= $this->points[Signature::KING]) {
            return null;
        }

        if ($difference >= $this->points[Signature::NOTARY]) {
            return Signature::fromKing();
        }

        if ($difference >= $this->points[Signature::VALIDATOR]) {
            return Signature::fromNotary();
        }

        if ($difference > $this->points[Signature::EMPTY]) {
            return Signature::fromValidator();
        }

        return null;
    }

    public function calculatePoints(): int
    {
        $points = 0;
        $kingSignatures = array_filter($this->signatures, function (Signature $signature) {
            return $signature->isFromKing();
        });

        /** @var Signature $signature */
        foreach ($this->signatures as $signature) {
            if ($signature->isFromValidator() && $kingSignatures) {
                continue;
            }
            $points += $this->points[$signature->signer()];
        }

        return $points;
    }
}
