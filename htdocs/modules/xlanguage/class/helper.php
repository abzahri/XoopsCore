<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       2010-2014 The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package         xlanguage
 * @since           2.6.0
 * @author          Laurent JEN (Aka DuGris)
 * @version         $Id$
 */

class Xlanguage extends Xoops\Module\Helper\HelperAbstract
{
    /**
     * Init the module
     *
     * @return null|void
     */
    public function init()
    {
        if (XoopsLoad::fileExists($hnd_file = XOOPS_ROOT_PATH . '/modules/xlanguage/include/vars.php')) {
            include_once $hnd_file;
        }

        if (XoopsLoad::fileExists($hnd_file = XOOPS_ROOT_PATH . '/modules/xlanguage/include/functions.php')) {
            include_once $hnd_file;
        }
        $this->setDirname('xlanguage');
    }

    /**
     * @return Xlanguage
     */
    public static function getInstance()
    {
        return parent::getInstance();
    }

    /**
     * @return XlanguageXlanguageHandler
     */
    public function getHandlerLanguage()
    {
        return $this->getHandler('xlanguage');
    }
}
