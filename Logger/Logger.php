<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Logger;

use Monolog\Logger as Monolog;

class Logger extends Monolog
{
    /**
     * @var string
     */
    protected $name;

    /**
     * Set logger name
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
}
