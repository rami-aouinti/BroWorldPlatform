<?php

declare(strict_types=1);

namespace App\Configuration\Infrastructure\DataFixtures\ORM;

use App\Configuration\Domain\Entity\Configuration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Throwable;

/**
 * @package App\Configuration
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class LoadConfigurationData extends Fixture implements OrderedFixtureInterface
{
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

    /**
     * Method to create User entity with specified role.
     *
     * @throws Throwable
     */
    private function createConfiguration(ObjectManager $manager): void
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
    }
}
