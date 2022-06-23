<?php

namespace App\Tests\Entity;

use App\Entity\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    /**
     * @return void
     * @covers \App\Entity\Image
     */
    public function testGetSet(): void
    {
        $image = new Image();
        $date = new \DateTimeImmutable();
        $image->setPath('testPath');
        $image->setCreatedAt($date);
        $this->assertEquals([$image->getId(), $image->getPath(), $image->getCreatedAt()], [null, 'testPath', $date]);
    }
}
