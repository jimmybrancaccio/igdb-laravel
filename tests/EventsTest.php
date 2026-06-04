<?php

declare(strict_types=1);

namespace MarcReichel\IGDBLaravel\Tests;

use PHPUnit\Framework\Attributes\DataProvider;

/**
 * @internal
 */
class EventsTest extends TestCase
{
    #[DataProvider('webhookModelsDataProvider')]
    public function testItShouldHaveCreatedEventForEveryModel(string $className): void
    {
        $eventClassString = 'MarcReichel\IGDBLaravel\Events\\' . $className . 'Created';
        $this->assertTrue(class_exists($eventClassString));
    }

    #[DataProvider('webhookModelsDataProvider')]
    public function testItShouldHaveUpdatedEventForEveryModel(string $className): void
    {
        $eventClassString = 'MarcReichel\IGDBLaravel\Events\\' . $className . 'Updated';
        $this->assertTrue(class_exists($eventClassString));
    }

    #[DataProvider('webhookModelsDataProvider')]
    public function testItShouldHaveDeletedEventForEveryModel(string $className): void
    {
        $eventClassString = 'MarcReichel\IGDBLaravel\Events\\' . $className . 'Deleted';
        $this->assertTrue(class_exists($eventClassString));
    }
}
