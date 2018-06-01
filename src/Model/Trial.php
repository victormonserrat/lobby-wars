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

final class Trial
{
    /**
     * @var Contract
     */
    private $plaintiffContract;

    /**
     * @var Contract
     */
    private $defendantContract;

    public static function fromContracts(Contract $plaintiffContract, Contract $defendantContract): self
    {
        return new self($plaintiffContract, $defendantContract);
    }

    private function __construct(Contract $plaintiffContract, Contract $defendantContract)
    {
        $this->plaintiffContract = $plaintiffContract;
        $this->defendantContract = $defendantContract;
    }

    public function plaintiffContract(): Contract
    {
        return $this->plaintiffContract;
    }

    public function defendantContract(): Contract
    {
        return $this->defendantContract;
    }

    public function winner(): ?Contract
    {
        $plaintiffPoints = $this->plaintiffContract->calculatePoints();
        $defendantPoints = $this->defendantContract->calculatePoints();

        if ($plaintiffPoints > $defendantPoints) {
            return $this->plaintiffContract;
        }

        if ($plaintiffPoints < $defendantPoints) {
            return $this->defendantContract;
        }

        return null;
    }
}
