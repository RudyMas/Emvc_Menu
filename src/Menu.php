<?php

namespace EasyMVC\Menu;

/**
 * Class Menu (PHP version 7.1)
 *
 * @author      Rudy Mas <rudy.mas@rmsoft.be>
 * @copyright   2017-2018, rmsoft.be. (http://www.rmsoft.be/)
 * @license     https://opensource.org/licenses/GPL-3.0 GNU General Public License, version 3 (GPL-3.0)
 * @version     2.0.0.12
 * @package     EasyMVC\Menu
 */
class Menu
{
    private $menuData = [];

    /**
     * @deprecated
     * @param array $menuArray
     * @param string $menuText
     * @param string $menuUrl
     * @param string $menuClass
     */
    public function addMenu(array $menuArray, string $menuText, string $menuUrl, string $menuClass = ''): void
    {
        trigger_error('Use addMenuItem instead.', E_USER_DEPRECATED);
        $menuOptions = $this->getIndexes($menuArray);
        $this->menuData[$menuOptions[0]][$menuOptions[1]][$menuOptions[2]][$menuOptions[3]][$menuOptions[4]][$menuOptions[5]][$menuOptions[6]][$menuOptions[7]][$menuOptions[8]][$menuOptions[9]]['url'] = $menuUrl;
        $this->menuData[$menuOptions[0]][$menuOptions[1]][$menuOptions[2]][$menuOptions[3]][$menuOptions[4]][$menuOptions[5]][$menuOptions[6]][$menuOptions[7]][$menuOptions[8]][$menuOptions[9]]['text'] = $menuText;
        $this->menuData[$menuOptions[0]][$menuOptions[1]][$menuOptions[2]][$menuOptions[3]][$menuOptions[4]][$menuOptions[5]][$menuOptions[6]][$menuOptions[7]][$menuOptions[8]][$menuOptions[9]]['class'] = $menuClass;
    }

    /**
     * @param array $menuArray
     * @param string $menuText
     * @param string $menuUrl
     * @param string $menuPlacement
     * @param string $menuId
     * @param string $menuClass
     */
    public function add(array $menuArray, string $menuText, string $menuUrl, string $menuPlacement = 'left', string $menuId = '', string $menuClass = ''): void
    {
        $menuOptions = $this->getIndexes($menuArray);
        $this->menuData[$menuOptions[0]][$menuOptions[1]][$menuOptions[2]][$menuOptions[3]][$menuOptions[4]][$menuOptions[5]][$menuOptions[6]][$menuOptions[7]][$menuOptions[8]][$menuOptions[9]]['url'] = $menuUrl;
        $this->menuData[$menuOptions[0]][$menuOptions[1]][$menuOptions[2]][$menuOptions[3]][$menuOptions[4]][$menuOptions[5]][$menuOptions[6]][$menuOptions[7]][$menuOptions[8]][$menuOptions[9]]['text'] = $menuText;
        $this->menuData[$menuOptions[0]][$menuOptions[1]][$menuOptions[2]][$menuOptions[3]][$menuOptions[4]][$menuOptions[5]][$menuOptions[6]][$menuOptions[7]][$menuOptions[8]][$menuOptions[9]]['place'] = $menuPlacement;
        $this->menuData[$menuOptions[0]][$menuOptions[1]][$menuOptions[2]][$menuOptions[3]][$menuOptions[4]][$menuOptions[5]][$menuOptions[6]][$menuOptions[7]][$menuOptions[8]][$menuOptions[9]]['id'] = $menuId;
        $this->menuData[$menuOptions[0]][$menuOptions[1]][$menuOptions[2]][$menuOptions[3]][$menuOptions[4]][$menuOptions[5]][$menuOptions[6]][$menuOptions[7]][$menuOptions[8]][$menuOptions[9]]['class'] = $menuClass;
    }

    /**
     * @deprecated
     * @param array $arrayMenu
     * @param array $args
     * @param string $id
     * @param string $class
     * @return string
     */
    public function createMenu(array $arrayMenu = [], array $args = [], string $id = '', string $class = ''): string
    {
        trigger_error('Use create instead.', E_USER_DEPRECATED);
        $menu = new EmvcMenu($this->menuData);
        $output = '<div id=' . $id . '>';
        $output .= '<div id="mainMenu">';
        $output .= $menu->createMenu($arrayMenu, $args, '', $class);
        $output .= '</div>';
        $output .= '</div>';
        return $output;
    }

    /**
     * @param string $menuType
     * @param array $arrayMenu
     * @param array $args
     * @param string $id
     * @param string $class
     * @return string
     */
    public function create(string $menuType = 'emvc', array $arrayMenu = [], array $args = [], string $id = '', string $class = ''): string
    {
        switch ($menuType) {
            case 'emvc':
                $menu = new EmvcMenu($this->menuData);
                break;
            case 'bootstrap':
                $menu = new BootstrapMenu($this->menuData);
                break;
            default:
                new \Exception("Unknown menu type: {$menuType}");
        }
        /** @var object $menu */
        $output = $menu->createMenu($arrayMenu, $args, $id, $class);
        return $output;
    }

    /**
     * @param array $arrayMenu
     * @param array $args
     * @param string $id
     * @param string $class
     * @param bool $isOnline
     * @return string
     */
    public function createMenuWithLogin(array $arrayMenu = [], array $args = [], string $id = '', string $class = '', bool $isOnline = false): string
    {
        $menu = new EmvcMenu($this->menuData);
        $output = '<div id=' . $id . '>';
        $output .= '<div id="loginMenu">';
        $output .= $this->createLoginMenu($isOnline);
        $output .= '</div>';
        $output .= '<div id="mainMenu">';
        $output .= $menu->createMenu($arrayMenu, $args, '', $class);
        $output .= '</div>';
        $output .= '</div>';
        return $output;
    }

    /**
     * @param int $pageNumber
     * @param int $items
     * @param int $itemsPerPage
     * @param string $pageUrl
     * @param string $menuSize
     * @return string
     */
    public function createPagination(int $pageNumber, int $items, int $itemsPerPage, string $pageUrl, string $menuSize = ''): string
    {
        $numberOfPages = ceil($items / $itemsPerPage);

        if ($menuSize == 'lg') {
            $output = '<ul class="pagination pagination-lg">';
        } elseif ($menuSize == 'sm') {
            $output = '<ul class="pagination pagination-sm">';
        } else {
            $output = '<ul class="pagination">';
        }

        if ($numberOfPages == 1) {
            return '';
        } else {
            $class = ($pageNumber == 1) ? 'page-item active' : 'page-item';
            $output .= '<li class="' . $class . '"><a class="page-link" href="' . BASE_URL . $pageUrl . '/1">1</a></li>';

            if ($numberOfPages > 2) {
                if ($numberOfPages > 15) {
                    $class = ($pageNumber < 11) ? 'page-item disabled' : 'page-item';
                    $output .= '<li class="' . $class . '"><a class="page-link" href="' . BASE_URL . $pageUrl . '/' . ($pageNumber - 10) . '">&laquo;</a></li>';
                }

                if ($numberOfPages > 5) {
                    $class = ($pageNumber == 1) ? 'page-item disabled' : 'page-item';
                    $output .= '<li class="' . $class . '"><a class="page-link" href="' . BASE_URL . $pageUrl . '/' . ($pageNumber - 1) . '">&lsaquo;</a></li>';
                }

                if ($numberOfPages < 8) {
                    $xStart = 2;
                    $xStop = $numberOfPages;
                } elseif ($pageNumber < 5) {
                    $xStart = 2;
                    $xStop = 7;
                } elseif ($pageNumber > ($numberOfPages - 4)) {
                    $xStart = $numberOfPages - 5;
                    $xStop = $numberOfPages;
                } else {
                    $xStart = $pageNumber - 2;
                    $xStop = $pageNumber + 3;
                }
                for ($x = $xStart; $x < $xStop; $x++) {
                    $class = ($pageNumber == $x) ? 'page-item active' : 'page-item';
                    $output .= '<li class="' . $class . '"><a class="page-link" href="' . BASE_URL . $pageUrl . '/' . $x . '">' . $x . '</a></li>';
                }

                if ($numberOfPages > 5) {
                    $class = ($pageNumber == $numberOfPages) ? 'page-item disabled' : 'page-item';
                    $output .= '<li class="' . $class . '"><a class="page-link" href="' . BASE_URL . $pageUrl . '/' . ($pageNumber + 1) . '">&rsaquo;</a></li>';
                }

                if ($numberOfPages > 15) {
                    $class = ($pageNumber > $numberOfPages - 10) ? 'page-item disabled' : 'page-item';
                    $output .= '<li class="' . $class . '"><a class="page-link" href="' . BASE_URL . $pageUrl . '/' . ($pageNumber + 10) . '">&raquo;</a></li>';
                }
            }

            $class = ($pageNumber == $numberOfPages) ? 'page-item active' : 'page-item';
            $output .= '<li class="' . $class . '"><a class="page-link" href="' . BASE_URL . $pageUrl . '/' . $numberOfPages . '">' . $numberOfPages . '</a></li>';
        }

        $output .= '</ul>';

        return $output;
    }

    // TODO: Rewrite the creation of the Login Menu. It has to be the same as for a normal menu

    /**
     * @param bool $isOnline
     * @return string
     */
    private function createLoginMenu(bool $isOnline): string
    {
        $output = '<ul>';
        if ($isOnline) {
            $output .= '<li><a href="' . BASE_URL . '/user/account">Account</a>';
            $output .= '<ul>';
            $output .= '<li><a href="' . BASE_URL . '/onderhoud">Onderhoud Foto\'s</a></li>';
            $output .= '</ul></li>';
            $output .= '<li><a href="' . BASE_URL . '/user/logout">Afmelden</a></li>';
        } else {
            $output .= '<li><a href="' . BASE_URL . '/user/login">Aanmelden</a></li>';
            $output .= '<li><a href="' . BASE_URL . '/user/register">Registreren</a></li>';
        }
        $output .= '</ul>';
        return $output;
    }

    /**
     * @param array $args
     * @return array
     */
    public static function getIndexes(array $args): array
    {
        $arguments = ['none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none'];
        for ($x = 0; $x < count($args); $x++) {
            if (isset($args[$x])) $arguments[$x] = $args[$x];
        }
        return $arguments;
    }
}