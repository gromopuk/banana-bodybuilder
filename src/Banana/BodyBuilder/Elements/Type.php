<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder\Elements;

use CommerceGuys\Enum\AbstractEnum;

class Type extends AbstractEnum
{

    const LINK = 'link';
    const SCRIPT = 'script';
    const TITLE = 'title';
    const META = 'meta';

}
