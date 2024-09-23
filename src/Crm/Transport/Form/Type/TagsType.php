<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Transport\Form\Type;

use App\Crm\Infrastructure\Repository\TagRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class TagsType extends AbstractType
{
    private ?int $count = null;

    public function __construct(
        private readonly AuthorizationCheckerInterface $auth,
        private readonly TagRepository $repository
    ) {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_create' => $this->auth->isGranted('create_tag'),
        ]);
    }

    public function getParent(): string
    {
        if ($this->count === null) {
            $this->count = $this->repository->count([]);
        }

        if ($this->count > TagRepository::MAX_AMOUNT_SELECT) {
            return TagsInputType::class;
        }

        return TagsSelectType::class;
    }
}
