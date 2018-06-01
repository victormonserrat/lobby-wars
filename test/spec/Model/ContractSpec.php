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

use App\Exception\InvalidContract;
use App\Model\Contract;
use App\Model\Signature;
use PhpSpec\ObjectBehavior;

final class ContractSpec extends ObjectBehavior
{
    public function it_creates_contract_from_signatures(): void
    {
        $this->beConstructedThrough('fromSignatures');
        $this->signatures()->shouldBeArray();
    }

    public function it_doesnt_create_contract_with_more_than_one_empty_signature(): void
    {
        $this->beConstructedThrough('fromSignatures', [[
                Signature::empty(),
                Signature::empty(),
        ]]);
        $this->shouldThrow(InvalidContract::withMoreThanOneEmptySignatures())->duringInstantiation();
    }

    public function it_calculates_minimum_necessary_signature_to_win()
    {
        $this->beConstructedThrough('fromSignatures', [[
            Signature::fromNotary(),
            Signature::empty(),
            Signature::fromValidator(),
        ]]);
        $contract = Contract::fromSignatures([
            Signature::fromNotary(),
            Signature::fromValidator(),
            Signature::fromValidator(),
        ]);
        $this->calculateMinimumNecessarySignatureToWin($contract)->signer()->shouldReturn(Signature::NOTARY);
    }

    public function it_calculates_points_correctly()
    {
        $this->beConstructedThrough('fromSignatures', [[
            Signature::fromKing(),
            Signature::fromNotary(),
            Signature::fromValidator(),
        ]]);
        $this->calculatePoints()->shouldReturn(7);
    }
}
