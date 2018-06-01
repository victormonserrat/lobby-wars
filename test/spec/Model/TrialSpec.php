<?php

/*
 * This file is part of `victormonserrat/lobby-wars`.
 * (c) Victor Monserrat <victormonserratvillatoro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\App\Model;

use App\Model\Contract;
use App\Model\Signature;
use PhpSpec\ObjectBehavior;

final class TrialSpec extends ObjectBehavior
{
    public function it_creates_trial_from_contracts(): void
    {
        $plaintiffContract = Contract::fromSignatures([]);
        $defendantContract = Contract::fromSignatures([]);
        $this->beConstructedThrough('fromContracts', [
            $plaintiffContract,
            $defendantContract,
        ]);
        $this->plaintiffContract()->shouldReturn($plaintiffContract);
        $this->defendantContract()->shouldReturn($defendantContract);
    }

    public function it_judges_correctly(): void
    {
        $plaintiffContract = Contract::fromSignatures([
            Signature::fromKing(),
            Signature::fromNotary(),
        ]);
        $defendantContract = Contract::fromSignatures([
            Signature::fromNotary(),
            Signature::fromValidator(),
            Signature::fromValidator(),
        ]);
        $this->beConstructedThrough('fromContracts', [
            $plaintiffContract,
            $defendantContract,
        ]);
        $this->winner()->shouldReturn($plaintiffContract);
    }
}
