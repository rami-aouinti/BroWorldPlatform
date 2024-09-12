<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DataFixtures\ORM;

use App\Configuration\Domain\Entity\Configuration;
use App\General\Domain\Enum\Language;
use App\General\Domain\Enum\Locale;
use App\General\Domain\Rest\UuidHelper;
use App\Menu\Domain\Entity\Menu;
use App\Role\Application\Security\Interfaces\RolesServiceInterface;
use App\Tests\Utils\PhpUnitUtil;
use App\User\Domain\Entity\Address;
use App\User\Domain\Entity\Profile;
use App\User\Domain\Entity\User;
use App\User\Domain\Entity\UserGroup;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Throwable;

use function array_map;

/**
 * @package App\User
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class LoadUserData extends Fixture implements OrderedFixtureInterface
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

    public function __construct(
        private readonly RolesServiceInterface $rolesService,
    ) {
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @throws Throwable
     */
    public function load(ObjectManager $manager): void
    {
        // Create entities
        array_map(
            fn (?string $role): bool => $this->createUser($manager, $role),
            [
                null,
                ...$this->rolesService->getRoles(),
            ],
        );
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
    private function createUser(ObjectManager $manager, ?string $role = null): bool
    {
        $suffix = $role === null ? '' : '-' . $this->rolesService->getShort($role);
        // Create new entity
        $entity = (new User())
            ->setUsername('john' . $suffix)
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setEmail('john.doe' . $suffix . '@test.com')
            ->setLanguage(Language::EN)
            ->setLocale(Locale::EN)
            ->setPlainPassword('password' . $suffix);

        if ($role !== null) {
            /** @var UserGroup $userGroup */
            $userGroup = $this->getReference('UserGroup-' . $this->rolesService->getShort($role), UserGroup::class);
            $entity->addUserGroup($userGroup);
        }

        PhpUnitUtil::setProperty(
            'id',
            UuidHelper::fromString(self::$uuids['john' . $suffix]),
            $entity
        );


        // Create Address

        $address = new Address();
        $address->setCountry('Germany');
        $address->setCity('köln');
        $address->setStreet('Widdersdorfer Landstr');
        $address->setHousenumber('11');
        $address->setPostcode('50859');
        $manager->persist($address);

        // Create Profile

        $profile = new Profile();
        $profile->setTitle('Ing');
        $profile->setPhoto('img.png');
        $profile->setDescription('Hi, I’m Alec Thompson, Decisions: If you can’t decide, the answer is no.
         If two equally difficult paths, choose the one more painful in the short term
         (pain avoidance is creating an illusion of equality).');
        $profile->setMobile('(49) 176 35587613');
        $profile->setBirthday(new DateTimeImmutable('now'));
        $profile->setAddress($address);
        $manager->persist($profile);

        $entity->setProfile($profile);

        // Create Menu

        $pagesMenu = new Menu();
        $pagesMenu->setAction('image');
        $pagesMenu->setActive(false);
        $pagesMenu->setTitle('Test 14');
        $manager->persist($pagesMenu);

        // Ajout des sous-éléments sous "Pages"
        $profileMenu = new Menu();
        $profileMenu->setTitle('Test 13');
        $profileMenu->setPrefix('P');
        $profileMenu->setActive(false);
        $profileMenu->setParent($pagesMenu);
        $profileMenu->setLevel(1);
        $manager->persist($profileMenu);

        // Ajout des sous-éléments sous "Profile"
        $profileOverview = new Menu();
        $profileOverview->setTitle('Test 12');
        $profileOverview->setPrefix('P');
        $profileOverview->setLink('/pages/pages/profile/overview');
        $profileOverview->setParent($profileMenu);
        $profileOverview->setLevel(2);
        $manager->persist($profileOverview);

        $allProjects = new Menu();
        $allProjects->setTitle('Test 11');
        $allProjects->setPrefix('A');
        $allProjects->setLink('/pages/pages/profile/projects');
        $allProjects->setParent($profileMenu);
        $allProjects->setLevel(3);
        $manager->persist($allProjects);

        $messages = new Menu();
        $messages->setTitle('Test 8');
        $messages->setPrefix('M');
        $messages->setLink('/pages/pages/profile/messages');
        $messages->setParent($profileMenu);
        $messages->setLevel(4);
        $manager->persist($messages);

        // Ajout de l'élément "Users"
        $usersMenu = new Menu();
        $usersMenu->setTitle('Test 9');
        $usersMenu->setPrefix('U');
        $usersMenu->setActive(false);
        $usersMenu->setParent($pagesMenu);
        $usersMenu->setLevel(5);
        $manager->persist($usersMenu);

        // Ajout des sous-éléments sous "Users"
        $reports = new Menu();
        $reports->setTitle('Test 7');
        $reports->setPrefix('R');
        $reports->setLink('/pages/pages/users/reports');
        $reports->setParent($usersMenu);
        $reports->setLevel(6);
        $manager->persist($reports);

        $newUser = new Menu();
        $newUser->setTitle('Test 5');
        $newUser->setPrefix('N');
        $newUser->setLink('/pages/pages/users/new-user');
        $newUser->setParent($usersMenu);
        $newUser->setLevel(7);
        $manager->persist($newUser);

        // Ajout des autres éléments de niveau supérieur comme "Applications", "Ecommerce", "Authentication", etc.
        $applicationsMenu = new Menu();
        $applicationsMenu->setAction('apps');
        $applicationsMenu->setActive(false);
        $applicationsMenu->setTitle('Test 1');
        $manager->persist($applicationsMenu);

        $ecommerceMenu = new Menu();
        $ecommerceMenu->setAction('shopping_basket');
        $ecommerceMenu->setActive(false);
        $ecommerceMenu->setTitle('Test 2');
        $manager->persist($ecommerceMenu);

        $authenticationMenu = new Menu();
        $authenticationMenu->setAction('content_paste');
        $authenticationMenu->setActive(false);
        $authenticationMenu->setTitle('Test 3');

        $entity->addMenu($pagesMenu);
        $entity->addMenu($profileMenu);
        $entity->addMenu($profileOverview);
        $entity->addMenu($allProjects);
        $entity->addMenu($messages);
        $entity->addMenu($usersMenu);
        $entity->addMenu($reports);
        $entity->addMenu($newUser);
        $entity->addMenu($applicationsMenu);
        $entity->addMenu($ecommerceMenu);
        $entity->addMenu($authenticationMenu);

        // Persist entity
        $manager->persist($pagesMenu);
        $manager->persist($profileMenu);
        $manager->persist($profileOverview);
        $manager->persist($allProjects);
        $manager->persist($messages);
        $manager->persist($usersMenu);
        $manager->persist($reports);
        $manager->persist($newUser);
        $manager->persist($applicationsMenu);
        $manager->persist($ecommerceMenu);
        $manager->persist($authenticationMenu);

        // Create Configuration

        $entityConfigurationTitle = (new Configuration())
            ->setConfigurationKey('title')
            ->setConfigurationEntry('Example of Title')
            ->setUser($entity)
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


        $entity->addConfiguration($entityConfigurationTitle);
        $entity->addConfiguration($entityConfigurationDrawer);
        $entity->addConfiguration($entityConfigurationSidebarColor);
        $entity->addConfiguration($entityConfigurationSidebarTheme);
        $entity->addConfiguration($entityConfigurationNavbarFixed);

        // Persist entity
        $manager->persist($entityConfigurationTitle);
        $manager->persist($entityConfigurationDrawer);
        $manager->persist($entityConfigurationSidebarColor);
        $manager->persist($entityConfigurationSidebarTheme);
        $manager->persist($entityConfigurationNavbarFixed);
        $manager->persist($entity);
        // Create reference for later usage
        $this->addReference('User-' . $entity->getUsername(), $entity);

        return true;
    }
}
