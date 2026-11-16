<?php

namespace spec\Domain\UseCase\EditDinosaur;

use Domain\Collection\DinosaursCollection;
use Domain\Collection\SpeciesCollection;
use Domain\Exception\DinosaurNotFoundException;
use Domain\Model\Dinosaur;
use Domain\Model\Species;
use Domain\UseCase\EditDinosaur\Handler;
use Domain\UseCase\EditDinosaur\Input;
use Domain\UseCase\EditDinosaur\Output;
use PhpSpec\ObjectBehavior;

final class HandlerSpec extends ObjectBehavior
{
    function let(
        DinosaursCollection $dinosaurs,
        SpeciesCollection $species,
    ): void {
        $this->beConstructedWith($dinosaurs, $species);
    }

    function it_edits_a_dinosaur(
        DinosaursCollection $dinosaurs,
        SpeciesCollection $species,
    ): void {
        $date = new \DateTimeImmutable('2018-07-01');
        $diplodocus = new Species('Diplodocus', ['forest'], 'herbivore');
        $dinosaur = new Dinosaur('Poupsy', 'male', $diplodocus, 10, '#0f0', $date);
        $dinosaurs->find('42')->willReturn($dinosaur);
        $species->find('1')->willReturn($diplodocus);

        $this(new Input('42', 'Poupsy', 'male', '1', 12, '#f00', $date))
            ->shouldBeLike(new Output(
                new Dinosaur('Poupsy', 'male', $diplodocus, 12, '#f00', $date),
            ));
    }

    function it_rejects_an_unknown_dinosaur(
        DinosaursCollection $dinosaurs,
    ): void {
        $dinosaurs->find('42')->willReturn(null);
        $date = new \DateTimeImmutable('2018-07-01');

        $this
            ->shouldThrow(DinosaurNotFoundException::class)
            ->during('__invoke', [
                new Input('42', 'Poupsy', 'male', '1', 12, '#f00', $date),
            ]);
    }
}
