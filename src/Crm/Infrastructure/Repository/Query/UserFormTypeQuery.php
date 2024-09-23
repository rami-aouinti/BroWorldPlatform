<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Infrastructure\Repository\Query;

/**
 * Can be used to pre-fill form types with: UserRepository::getQueryBuilderForFormType()
 */
final class UserFormTypeQuery extends BaseFormTypeQuery
{
    use VisibilityTrait;
}
