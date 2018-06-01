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

use App\Exception\InvalidSignature;
use App\Model\Signature;
use PhpSpec\ObjectBehavior;

final class SignatureSpec extends ObjectBehavior
{
    public function it_creates_an_empty_signature(): void
    {
        $this->beConstructedThrough('empty');
        $this->isEmpty()->shouldReturn(true);
    }

    public function it_creates_signature_from_a_king(): void
    {
        $this->beConstructedThrough('fromKing');
        $this->isFromKing()->shouldReturn(true);
    }

    public function it_creates_signature_from_a_notary(): void
    {
        $this->beConstructedThrough('fromNotary');
        $this->isFromNotary()->shouldReturn(true);
    }

    public function it_creates_signature_from_a_validator(): void
    {
        $this->beConstructedThrough('fromValidator');
        $this->isFromValidator()->shouldReturn(true);
    }

    public function it_creates_signature_from_signer(): void
    {
        $this->beConstructedThrough('fromSigner', [
            Signature::KING,
        ]);
        $this->signer()->shouldReturn(Signature::KING);
    }

    public function it_doesnt_create_signature_from_any_signer(): void
    {
        $this->beConstructedThrough('fromSigner', [
            'Any',
        ]);
        $this->shouldThrow(InvalidSignature::withSigner('Any'))->duringInstantiation();
    }
}
