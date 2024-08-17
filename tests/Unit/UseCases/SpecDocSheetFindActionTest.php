<?php

use App\Domain\SpecDocSheet\SpecDocSheetRepositoryInterface;
use App\UseCases\SpecDocSheet\SpecDocSheetFindAction;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SpecDocSheetFindActionTest extends TestCase
{
    /**
     * @var SpecDocSheetRepositoryInterface&MockObject
     */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(SpecDocSheetRepositoryInterface::class);
    }

    public function testExistsReturnsTrueWhenIdExists(): void
    {
        $this->repository->method('exists')->willReturn(true);

        $action = new SpecDocSheetFindAction($this->repository);

        $result = $action->exists(1);

        $this->assertTrue($result);
    }

    public function testExistsReturnsFalseWhenIdDoesNotExist(): void
    {
        $this->repository->method('exists')->willReturn(false);

        $action = new SpecDocSheetFindAction($this->repository);

        $result = $action->exists(999);

        $this->assertFalse($result);
    }
}
