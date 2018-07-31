<?php

namespace EasyMVC\Menu;

/**
 * Class BootstrapMenu (PHP version 7.1)
 *
 * @author      Rudy Mas <rudy.mas@rmsoft.be>
 * @copyright   2018, rmsoft.be. (http://www.rmsoft.be/)
 * @license     https://opensource.org/licenses/GPL-3.0 GNU General Public License, version 3 (GPL-3.0)
 * @version     0.0.1.1
 * @package     EasyMVC\Menu
 */
class BootstrapMenu
{
    private $menuData;

    /**
     * BootstrapMenu constructor.
     * @param array $menuData
     */
    public function __construct(array $menuData)
    {
        $this->menuData = $menuData;
    }

    /**
     * @param array $arrayMenu
     * @param array $args
     * @param string $id
     * @param string $class
     * @return string
     */
    public function createMenu(array $arrayMenu, array $args, string $id, string $class): string
    {
        return 'Nope';
    }
}