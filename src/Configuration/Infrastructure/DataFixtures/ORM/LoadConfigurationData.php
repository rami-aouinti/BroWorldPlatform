<?php

declare(strict_types=1);

namespace App\Configuration\Infrastructure\DataFixtures\ORM;

use App\General\Domain\Enum\Language;
use App\General\Domain\Enum\Locale;
use App\General\Domain\Rest\UuidHelper;
use App\Role\Application\Security\Interfaces\RolesServiceInterface;
use App\Tests\Utils\PhpUnitUtil;
use App\Configuration\Domain\Entity\Configuration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Throwable;

use function array_map;

/**
 * @package App\Configuration
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class LoadConfigurationData extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var array<string, string>
     */
    public static array $uuids = [
        'john' => '20000000-0000-1000-8000-000000000001',
        'john-logged' => '20000000-0000-1000-8000-000000000002',
        'john-api' => '20000000-0000-1000-8000-000000000003',
        'john-user' => '20000000-0000-1000-8000-000000000004',
        'john-admin' => '20000000-0000-1000-8000-000000000005',
        'john-root' => '20000000-0000-1000-8000-000000000006',
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @throws Throwable
     */
    public function load(ObjectManager $manager): void
    {
        // Create entities
        $this->createConfiguration($manager);
        // Flush database changes
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     */
    public function getOrder(): int
    {
        return 3;
    }

    public static function getUuidByKey(string $key): string
    {
        return self::$uuids[$key];
    }

    /**
     * Method to create User entity with specified role.
     *
     * @throws Throwable
     */
    private function createConfiguration(ObjectManager $manager): bool
    {
        // Create new entity
        $entityConfigurationTitle = (new Configuration())
            ->setConfigurationKey('title')
            ->setConfigurationEntry('BroWorld')
        ;

        $entityConfigurationDrawer = (new Configuration())
            ->setConfigurationKey('drawer')
            ->setConfigurationEntry(null)
        ;
        $entityConfigurationSidebarColor = (new Configuration())
            ->setConfigurationKey('sidebarColor')
            ->setConfigurationEntry('success')
        ;

        $entityConfigurationSidebarTheme = (new Configuration())
            ->setConfigurationKey('sidebarTheme')
            ->setConfigurationEntry('dark')
        ;

        $entityConfigurationNavbarFixed = (new Configuration())
            ->setConfigurationKey('navbarFixed')
            ->setConfigurationEntry(false)
        ;

        // Persist entity
        $manager->persist($entityConfigurationTitle);
        $manager->persist($entityConfigurationDrawer);
        $manager->persist($entityConfigurationSidebarColor);
        $manager->persist($entityConfigurationSidebarTheme);
        $manager->persist($entityConfigurationNavbarFixed);

        return true;
    }
}
