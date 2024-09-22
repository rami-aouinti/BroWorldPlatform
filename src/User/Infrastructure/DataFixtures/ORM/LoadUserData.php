<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DataFixtures\ORM;

use App\Blog\Domain\Entity\Comment;
use App\Blog\Domain\Entity\Post;
use App\Blog\Domain\Entity\Tag;
use App\Configuration\Domain\Entity\Configuration;
use App\Crm\Domain\Entity\UserPreference;
use App\General\Domain\Enum\Language;
use App\General\Domain\Enum\Locale;
use App\General\Domain\Rest\UuidHelper;
use App\Messenger\Domain\Entity\Message;
use App\Resume\Domain\Entity\Experience;
use App\Resume\Domain\Entity\Formation;
use App\Resume\Domain\Entity\Hobby;
use App\Resume\Domain\Entity\Media;
use App\Resume\Domain\Entity\Project;
use App\Resume\Domain\Entity\Reference;
use App\Resume\Domain\Entity\Skill;
use App\Role\Application\Security\Interfaces\RolesServiceInterface;
use App\Tests\Utils\PhpUnitUtil;
use App\User\Domain\Entity\Address;
use App\User\Domain\Entity\Profile;
use App\User\Domain\Entity\User;
use App\User\Domain\Entity\UserGroup;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Random\RandomException;
use Symfony\Component\String\AbstractUnicodeString;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\String\UnicodeString;
use Throwable;

use function array_map;
use function array_slice;
use function Symfony\Component\String\u;

/**
 * @package App\User
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class LoadUserData extends Fixture implements OrderedFixtureInterface
{
    public const string DEFAULT_PASSWORD = 'kitten-test';
    public const string DEFAULT_API_TOKEN = 'api_kitten';
    public const string DEFAULT_AVATAR = 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=retro&f=y';

    public const string USERNAME_USER = 'john_user';
    public const string USERNAME_TEAMLEAD = 'tony_teamlead';
    public const string USERNAME_ADMIN = 'anna_admin';
    public const string USERNAME_SUPER_ADMIN = 'susan_super';

    public const int AMOUNT_EXTRA_USER = 25;

    public const int MIN_RATE = 30;
    public const int MAX_RATE = 120;

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
        private readonly SluggerInterface $slugger
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
        $this->loadTags($manager);
        $this->loadPosts($manager);
        $this->loadMessages($manager);
        $this->loadDefaultAccounts($manager);
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

        $this->createResume($manager, $entity);

        return true;
    }

    /**
     * @throws Throwable
     */
    private function loadTags(ObjectManager $manager): void
    {
        foreach ($this->getTagData() as $name) {
            $tag = new Tag($name);

            $manager->persist($tag);
            $this->addReference('tag-' . $name, $tag);
        }

        $manager->flush();
    }

    /**
     * @throws RandomException
     * @throws Exception
     */
    private function loadPosts(ObjectManager $manager): void
    {
        foreach ($this->getPostData() as [$title, $slug, $summary, $content, $publishedAt, $author, $tags]) {
            $post = new Post();
            $post->setTitle($title);
            $post->setSlug((string)$slug);
            $post->setSummary((string)$summary);
            $post->setContent($content);
            $post->setPublishedAt($publishedAt);
            $post->setAuthor($author);
            $post->addTag(...$tags);

            foreach (range(1, 5) as $i) {
                /** @var User $commentAuthor */
                $commentAuthor = $this->getReference('User-john-user');

                $comment = new Comment();
                $comment->setAuthor($commentAuthor);
                $comment->setContent((string)$this->getRandomText(random_int(255, 512)));
                $comment->setPublishedAt(new DateTimeImmutable('now + ' . $i . 'seconds'));

                $post->addComment($comment);
            }

            $manager->persist($post);
        }

        $manager->flush();
    }

    /**
     * @return string[]
     */
    private function getTagData(): array
    {
        return [
            'lorem',
            'ipsum',
            'consectetur',
            'adipiscing',
            'incididunt',
            'labore',
            'voluptate',
            'dolore',
            'pariatur',
        ];
    }

    /**
     * @throws Exception
     *
     * @return array<int, array{0: string, 1: AbstractUnicodeString, 2: string, 3: string, 4: DateTimeImmutable, 5: User, 6: array<Tag>}>
     */
    private function getPostData(): array
    {
        $posts = [];

        foreach ($this->getPhrases() as $i => $title) {
            // $postData = [$title, $slug, $summary, $content, $publishedAt, $author, $tags, $comments];

            /** @var User $user */
            $user = $this->getReference(['User-john-user', 'User-john-root', 'User-john-admin'][$i === 0 ? 0 : random_int(0, 1)]);

            $posts[] = [
                $title,
                $this->slugger->slug($title)->lower(),
                $this->getRandomText(),
                $this->getPostContent(),
                (new DateTimeImmutable('now - ' . $i . 'days'))->setTime(random_int(8, 17), random_int(7, 49), random_int(0, 59)),
                // Ensure that the first post is written by Jane Doe to simplify tests
                $user,
                $this->getRandomTags(),
            ];
        }

        return $posts;
    }

    /**
     * @return string[]
     */
    private function getPhrases(): array
    {
        return [
            'Lorem ipsum dolor sit amet consectetur adipiscing elit',
            'Pellentesque vitae velit ex',
            'Mauris dapibus risus quis suscipit vulputate',
            'Eros diam egestas libero eu vulputate risus',
            'In hac habitasse platea dictumst',
            'Morbi tempus commodo mattis',
            'Ut suscipit posuere justo at vulputate',
            'Ut eleifend mauris et risus ultrices egestas',
            'Aliquam sodales odio id eleifend tristique',
            'Urna nisl sollicitudin id varius orci quam id turpis',
            'Nulla porta lobortis ligula vel egestas',
            'Curabitur aliquam euismod dolor non ornare',
            'Sed varius a risus eget aliquam',
            'Nunc viverra elit ac laoreet suscipit',
            'Pellentesque et sapien pulvinar consectetur',
            'Ubi est barbatus nix',
            'Abnobas sunt hilotaes de placidus vita',
            'Ubi est audax amicitia',
            'Eposs sunt solems de superbus fortis',
            'Vae humani generis',
            'Diatrias tolerare tanquam noster caesium',
            'Teres talis saepe tractare de camerarius flavum sensorem',
            'Silva de secundus galatae demitto quadra',
            'Sunt accentores vitare salvus flavum parses',
            'Potus sensim ad ferox abnoba',
            'Sunt seculaes transferre talis camerarius fluctuies',
            'Era brevis ratione est',
            'Sunt torquises imitari velox mirabilis medicinaes',
            'Mineralis persuadere omnes finises desiderium',
            'Bassus fatalis classiss virtualiter transferre de flavum',
        ];
    }

    private function getRandomText(int $maxLength = 255): UnicodeString
    {
        $phrases = $this->getPhrases();
        shuffle($phrases);

        do {
            $text = u('. ')->join($phrases)->append('.');
            array_pop($phrases);
        } while ($text->length() > $maxLength);

        return $text;
    }

    private function getPostContent(): string
    {
        return <<<'MARKDOWN'
            Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor
            incididunt ut labore et **dolore magna aliqua**: Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
            deserunt mollit anim id est laborum.

              * Ut enim ad minim veniam
              * Quis nostrud exercitation *ullamco laboris*
              * Nisi ut aliquip ex ea commodo consequat

            Praesent id fermentum lorem. Ut est lorem, fringilla at accumsan nec, euismod at
            nunc. Aenean mattis sollicitudin mattis. Nullam pulvinar vestibulum bibendum.
            Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos
            himenaeos. Fusce nulla purus, gravida ac interdum ut, blandit eget ex. Duis a
            luctus dolor.

            Integer auctor massa maximus nulla scelerisque accumsan. *Aliquam ac malesuada*
            ex. Pellentesque tortor magna, vulputate eu vulputate ut, venenatis ac lectus.
            Praesent ut lacinia sem. Mauris a lectus eget felis mollis feugiat. Quisque
            efficitur, mi ut semper pulvinar, urna urna blandit massa, eget tincidunt augue
            nulla vitae est.

            Ut posuere aliquet tincidunt. Aliquam erat volutpat. **Class aptent taciti**
            sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi
            arcu orci, gravida eget aliquam eu, suscipit et ante. Morbi vulputate metus vel
            ipsum finibus, ut dapibus massa feugiat. Vestibulum vel lobortis libero. Sed
            tincidunt tellus et viverra scelerisque. Pellentesque tincidunt cursus felis.
            Sed in egestas erat.

            Aliquam pulvinar interdum massa, vel ullamcorper ante consectetur eu. Vestibulum
            lacinia ac enim vel placerat. Integer pulvinar magna nec dui malesuada, nec
            congue nisl dictum. Donec mollis nisl tortor, at congue erat consequat a. Nam
            tempus elit porta, blandit elit vel, viverra lorem. Sed sit amet tellus
            tincidunt, faucibus nisl in, aliquet libero.
            MARKDOWN;
    }

    /**
     * @throws Exception
     *
     * @return array<Tag>
     */
    private function getRandomTags(): array
    {
        $tagNames = $this->getTagData();
        shuffle($tagNames);
        $selectedTags = array_slice($tagNames, 0, random_int(2, 4));

        return array_map(function ($tagName) {
            /** @var Tag $tag */
            $tag = $this->getReference('tag-' . $tagName);

            return $tag;
        }, $selectedTags);
    }

    private function loadMessages(ObjectManager $manager): void
    {
        /** @var User $messageUser1 */
        $messageUser1 = $this->getReference('User-john');

        /** @var User $messageUser2 */
        $messageUser2 = $this->getReference('User-john-user');

        /** @var User $messageUser3 */
        $messageUser3 = $this->getReference('User-john-admin');

        /** @var User $messageUser4 */
        $messageUser4 = $this->getReference('User-john-root');

        $message = new Message();
        $message->setContent('Hey ' . $messageUser3);
        $message->setSender($messageUser4);
        $message->setReceiver($messageUser3);
        $message->setSentAt(new DateTime('now'));

        $message1 = new Message();
        $message1->setContent('Hey ' . $messageUser1);
        $message1->setSender($messageUser4);
        $message1->setReceiver($messageUser1);
        $message1->setSentAt(new DateTime('now'));

        $message2 = new Message();
        $message2->setContent('Hey ' . $messageUser2);
        $message2->setSender($messageUser4);
        $message2->setReceiver($messageUser2);
        $message2->setSentAt(new DateTime('now'));

        $message3 = new Message();
        $message3->setContent('Hey ' . $messageUser4);
        $message3->setSender($messageUser1);
        $message3->setReceiver($messageUser4);
        $message3->setSentAt(new DateTime('now'));

        $message4 = new Message();
        $message4->setContent('Hey ' . $messageUser4);
        $message4->setSender($messageUser2);
        $message4->setReceiver($messageUser4);
        $message4->setSentAt(new DateTime('now'));

        $message5 = new Message();
        $message5->setContent('Hey ' . $messageUser4);
        $message5->setSender($messageUser3);
        $message5->setReceiver($messageUser4);
        $message5->setSentAt(new DateTime('now'));

        $manager->persist($message);
        $manager->persist($message1);
        $manager->persist($message2);
        $manager->persist($message3);
        $manager->persist($message4);
        $manager->persist($message5);
    }

    /**
     * Default users for all test cases
     */
    private function loadDefaultAccounts(ObjectManager $manager): void
    {
        $allUsers = $this->getUserDefinition();
        foreach ($allUsers as $userData) {
            $user = new User();
            $user->setAlias($userData[0]);
            $user->setTitle($userData[1]);
            $user->setUserIdentifier($userData[2]);
            $user->setEmail($userData[3]);
            $user->setAvatar($userData[5]);
            $user->setEnabled($userData[6]);
            $user->setPlainPassword($userData[8]);
            $manager->persist($user);

            $prefs = $this->getUserPreferences($user, $userData[7]);
            $user->setPreferences($prefs);

            $manager->persist($prefs[0]);
            $manager->persist($prefs[1]);
        }

        $manager->flush();
        $manager->clear();
    }

    private function getUserPreferences(User $user, string $timezone = null): array
    {
        $preferences = [];

        $prefHourlyRate = new UserPreference(UserPreference::HOURLY_RATE, rand(self::MIN_RATE, self::MAX_RATE));
        $user->addPreference($prefHourlyRate);
        $preferences[] = $prefHourlyRate;

        if ($timezone !== null) {
            $prefTimezone = new UserPreference(UserPreference::TIMEZONE, $timezone);
            $user->addPreference($prefTimezone);
            $preferences[] = $prefTimezone;
        }

        return $preferences;
    }

    private function getUserDefinition(): array
    {
        // alias = $userData[0]
        // title = $userData[1]
        // username = $userData[2]
        // email = $userData[3]
        // roles = [$userData[4]]
        // avatar = $userData[5]
        // enabled = $userData[6]
        // timezone = $userData[7]
        // password = $userData[8]
        // api old = $userData[9]
        // api new = $userData[10]

        return [
            [
                'John Doe',
                'Developer',
                self::USERNAME_USER,
                'john_user@example.com',
                User::ROLE_USER,
                self::DEFAULT_AVATAR,
                true,
                'America/Vancouver',
                self::DEFAULT_PASSWORD,
                self::DEFAULT_API_TOKEN,
                self::DEFAULT_API_TOKEN . '_john',
            ],
            [
                'John Doe',
                'Developer',
                'user',
                'user@example.com',
                User::ROLE_USER,
                self::DEFAULT_AVATAR,
                true,
                'America/Vancouver',
                'password',
                'password',
                self::DEFAULT_API_TOKEN . '_user',
            ],
            // inactive user to test login
            [
                'Chris Deactive',
                'Developer (left company)',
                'chris_user',
                'chris_user@example.com',
                User::ROLE_USER,
                self::DEFAULT_AVATAR,
                false,
                'Australia/Sydney',
                self::DEFAULT_PASSWORD,
                self::DEFAULT_API_TOKEN,
                self::DEFAULT_API_TOKEN . '_inactive',
            ],
            [
                'Tony Maier',
                'Head of Sales',
                self::USERNAME_TEAMLEAD,
                'tony_teamlead@example.com',
                User::ROLE_TEAMLEAD,
                'https://en.gravatar.com/userimage/3533186/bf2163b1dd23f3107a028af0195624e9.jpeg',
                true,
                'Asia/Bangkok',
                self::DEFAULT_PASSWORD,
                self::DEFAULT_API_TOKEN,
                self::DEFAULT_API_TOKEN . '_teamlead',
            ],
            [
                'Tony Maier',
                'Head of Sales',
                'teamlead',
                'teamlead@example.com',
                User::ROLE_TEAMLEAD,
                'https://en.gravatar.com/userimage/3533186/bf2163b1dd23f3107a028af0195624e9.jpeg',
                true,
                'Asia/Bangkok',
                'password',
                'password',
                self::DEFAULT_API_TOKEN . '_tony',
            ],
            // no avatar to test default image macro
            [
                'Anna Smith',
                'Administrator',
                self::USERNAME_ADMIN,
                'anna_admin@example.com',
                User::ROLE_ADMIN,
                null,
                true,
                'Europe/London',
                self::DEFAULT_PASSWORD,
                self::DEFAULT_API_TOKEN,
                self::DEFAULT_API_TOKEN . '_anna',
            ],
            [
                'Anna Smith',
                'Administrator',
                'administrator',
                'administrator@example.com',
                User::ROLE_ADMIN,
                null,
                true,
                'Europe/London',
                'password',
                'password',
                self::DEFAULT_API_TOKEN . '_admin',
            ],
            // no alias to test twig username macro
            [
                null,
                'Super Administrator',
                self::USERNAME_SUPER_ADMIN,
                'susan_super@example.com',
                User::ROLE_SUPER_ADMIN,
                '/touch-icon-192x192.png',
                true,
                'Europe/Berlin',
                self::DEFAULT_PASSWORD,
                self::DEFAULT_API_TOKEN,
                self::DEFAULT_API_TOKEN . '_susan',
            ],
            [
                null,
                'Super Administrator',
                'super_admin',
                'super_admin@example.com',
                User::ROLE_SUPER_ADMIN,
                '/touch-icon-192x192.png',
                true,
                'Europe/Berlin',
                'password',
                'password',
                self::DEFAULT_API_TOKEN . '_super',
            ],
        ];
    }

    /**
     * @param      $manager
     * @param User $entity
     *
     * @return void
     */
    private function createResume($manager, User $entity): void
    {
        // Fixtures for Skills
        $skill = new Skill();
        $skill->setName('PHP');
        $skill->setType('Programming Language');
        $skill->setLevel(8);
        $skill->setUser($entity);
        $manager->persist($skill);

        // Fixtures for References
        $reference = new Reference();
        $reference->setTitle('Senior Developer');
        $reference->setCompany('Tech Company');
        $reference->setDescription('Worked as a senior developer in a tech company.');
        $reference->setStartedAt(new DateTimeImmutable('2019-01-01'));
        $reference->setEndedAt(new DateTimeImmutable('2021-01-01'));
        $reference->setUser($entity);
        $manager->persist($reference);

        // Fixtures for Projects
        $project = new Project();
        $project->setName('Awesome Project');
        $project->setDescription('This is an awesome project.');
        $project->setReference($reference);
        $project->addSkill($skill);
        $manager->persist($project);

        // Fixtures for Media
        $media = new Media();
        $media->setPath('/images/sample.jpg');
        $media->setReference($reference);
        $manager->persist($media);

        // Fixtures for Languages
        $language = new \App\Resume\Domain\Entity\Language();
        $language->setName('English');
        $language->setLevel(10);
        $language->setFlag('us');
        $language->setUser($entity);
        $manager->persist($language);

        // Fixtures for Hobbies
        $hobby = new Hobby();
        $hobby->setName('Photography');
        $hobby->setIcon('camera');
        $hobby->setUser($entity);
        $manager->persist($hobby);

        // Fixtures for Formations
        $formation = new Formation();
        $formation->setName('Master\'s in Computer Science');
        $formation->setSchool('University XYZ');
        $formation->setGradeLevel(5);
        $formation->setDescription('Advanced studies in computer science.');
        $formation->setStartedAt(new DateTimeImmutable('2017-09-01'));
        $formation->setEndedAt(new DateTimeImmutable('2019-06-30'));
        $formation->setUser($entity);
        $manager->persist($formation);

        // Fixtures for Experiences
        $experience = new Experience();
        $experience->setTitle('Software Engineer');
        $experience->setCompany('Software Inc.');
        $experience->setDescription('Worked as a software engineer developing applications.');
        $experience->setStartedAt(new DateTimeImmutable('2015-01-01'));
        $experience->setEndedAt(new DateTimeImmutable('2018-12-31'));
        $experience->setUser($entity);
        $manager->persist($experience);

        // Flush all changes to the database
        $manager->flush();
    }
}
