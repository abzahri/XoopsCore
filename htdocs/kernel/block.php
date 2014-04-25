<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

use Xoops\Core\Database\Connection;
use Xoops\Core\Kernel\CriteriaElement;
use Xoops\Core\Kernel\XoopsObject;
use Xoops\Core\Kernel\XoopsObjectHandler;
use Xoops\Core\Kernel\XoopsPersistableObjectHandler;

/**
 * XOOPS Kernel Class
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         kernel
 * @since           2.0.0
 * @author          Kazumi Ono (AKA onokazu) http://www.myweb.ne.jp/, http://jp.xoops.org/
 * @author          Gregory Mage (AKA Mage)
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

class XoopsBlock extends XoopsObject
{
    /**
     * Constructor
     *
     * @param int|array $id
     */
    public function __construct($id = null)
    {
        $this->initVar('bid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('mid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('func_num', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('options', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 150);
        //$this->initVar('position', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('title', XOBJ_DTYPE_TXTBOX, null, false, 150);
        $this->initVar('content', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('side', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('weight', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('visible', XOBJ_DTYPE_INT, 0, false);
        // The block_type is in a mess, let's say:
        // S - generated by system module
        // M - generated by a non-system module
        // C - Custom block
        // D - cloned system/module block
        // E - cloned custom block, DON'T use it
        $this->initVar('block_type', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('c_type', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('isactive', XOBJ_DTYPE_INT, null, false);
        $this->initVar('dirname', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('func_file', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('show_func', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('edit_func', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('template', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('bcachetime', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('last_modified', XOBJ_DTYPE_INT, 0, false);

        // for backward compatibility
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            } else {
                $xoops = Xoops::getInstance();
                $blkhandler = $xoops->getHandlerBlock();
                $obj = $blkhandler->get($id);
                foreach (array_keys($obj->getVars()) as $i) {
                    $this->assignVar($i, $obj->getVar($i, 'n'));
                }
            }
        }
    }


    /**
     * @param string $format
     * @return mixed
     */
    public function id($format = 'n')
    {
        return $this->getVar('bid', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function bid($format = '')
    {
        return $this->getVar('bid', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function mid($format = '')
    {
        return $this->getVar('mid', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function func_num($format = '')
    {
        return $this->getVar('func_num', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function options($format = '')
    {
        return $this->getVar('options', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function name($format = '')
    {
        return $this->getVar('name', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function title($format = '')
    {
        return $this->getVar('title', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function content($format = '')
    {
        return $this->getVar('content', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function side($format = '')
    {
        return $this->getVar('side', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function weight($format = '')
    {
        return $this->getVar('weight', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function visible($format = '')
    {
        return $this->getVar('visible', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function block_type($format = '')
    {
        return $this->getVar('block_type', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function c_type($format = '')
    {
        return $this->getVar('c_type', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function isactive($format = '')
    {
        return $this->getVar('isactive', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function dirname($format = '')
    {
        return $this->getVar('dirname', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function func_file($format = '')
    {
        return $this->getVar('func_file', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function show_func($format = '')
    {
        return $this->getVar('show_func', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function edit_func($format = '')
    {
        return $this->getVar('edit_func', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function template($format = '')
    {
        return $this->getVar('template', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function bcachetime($format = '')
    {
        return $this->getVar('bcachetime', $format);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function last_modified($format = '')
    {
        return $this->getVar('last_modified', $format);
    }

    /**
     * return the content of the block for output
     *
     * @param string $format
     * @param string $c_type type of content<br>
     * Legal value for the type of content<br>
     * <ul><li>H : custom HTML block
     * <li>P : custom PHP block
     * <li>S : use text sanitizater (smilies enabled)
     * <li>T : use text sanitizater (smilies disabled)</ul>
     * @return string content for output
     */
    public function getContent($format = 's', $c_type = 'T')
    {
        $format = strtolower($format);
        $c_type = strtoupper($c_type);
        switch ($format) {
            case 's':
                // check the type of content
                // H : custom HTML block
                // P : custom PHP block
                // S : use text sanitizater (smilies enabled)
                // T : use text sanitizater (smilies disabled)
                if ($c_type == 'H') {
                    return str_replace('{X_SITEURL}', XOOPS_URL . '/', $this->getVar('content', 'n'));
                } else {
                    if ($c_type == 'P') {
                        ob_start();
                        echo eval($this->getVar('content', 'n'));
                        $content = ob_get_contents();
                        ob_end_clean();
                        return str_replace('{X_SITEURL}', XOOPS_URL . '/', $content);
                    } else {
                        if ($c_type == 'S') {
                            $myts = MyTextSanitizer::getInstance();
                            $content = str_replace('{X_SITEURL}', XOOPS_URL . '/', $this->getVar('content', 'n'));
                            return $myts->displayTarea($content, 1, 1);
                        } else {
                            $myts = MyTextSanitizer::getInstance();
                            $content = str_replace('{X_SITEURL}', XOOPS_URL . '/', $this->getVar('content', 'n'));
                            return $myts->displayTarea($content, 1, 0);
                        }
                    }
                }
                break;
            case 'e':
                return $this->getVar('content', 'e');
                break;
            default:
                return $this->getVar('content', 'n');
                break;
        }
    }

    /**
     * (HTML-) form for setting the options of the block
     *
     * @return string HTML for the form, FALSE if not defined for this block
     */
    public function getOptions()
    {
        $xoops = Xoops::getInstance();
        if (!$this->isCustom()) {
            $edit_func = (string)$this->getVar('edit_func');
            if (!$edit_func) {
                return false;
            }
            if (XoopsLoad::fileExists(XOOPS_ROOT_PATH . '/modules/' . $this->getVar('dirname') . '/blocks/' . $this->getVar('func_file'))) {
                $xoops->loadLanguage('blocks', $this->getVar('dirname'));
                include_once XOOPS_ROOT_PATH . '/modules/' . $this->getVar('dirname') . '/blocks/' . $this->getVar('func_file');
                if (function_exists($edit_func)) {
                    // execute the function
                    $options = explode('|', $this->getVar('options'));
                    $edit_form = $edit_func($options);
                    if (!$edit_form) {
                        return false;
                    }
                } else {
                    return false;
                }
                return $edit_form;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function isCustom()
    {
        return in_array($this->getVar("block_type"), array('C', 'E'));
    }

    /************ADDED**************/


    /**
     * Build Block
     *
     * @return array|bool
     */
    public function buildBlock()
    {
        $xoops = Xoops::getInstance();
        $block = array();
        if (!$this->isCustom()) {
            // get block display function
            $show_func = (string)$this->getVar('show_func');
            if (!$show_func) {
                return false;
            }
            if (!XoopsLoad::fileExists($func_file = $xoops->path('modules/' . $this->getVar('dirname') . '/blocks/' . $this->getVar('func_file')))) {
                return false;
            }
            // must get lang files b4 including the file
            // some modules require it for code that is outside the function
            $xoops->loadLanguage('blocks', $this->getVar('dirname'));
            $xoops->loadLocale($this->getVar('dirname'));
            include_once $func_file;

            if (function_exists($show_func)) {
                // execute the function
                $options = explode('|', $this->getVar('options'));
                $block = $show_func($options);
                if (!$block) {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            // it is a custom block, so just return the contents
            $block['content'] = $this->getContent('s', $this->getVar('c_type'));
            if (empty($block['content'])) {
                return false;
            }
        }
        return $block;
    }
}

class XoopsBlockHandler extends XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param Connection|null $db {@link \Xoops\Core\Database\Connection}
     */
    public function __construct(Connection $db = null)
    {
        parent::__construct($db, 'newblocks', 'XoopsBlock', 'bid', 'name');
    }

    /**
     * @param XoopsBlock $obj
     * @param bool $force
     * @return mixed
     */
    public function insertBlock(XoopsBlock &$obj, $force = false)
    {
        $obj->setVar('last_modified', time());
        return parent::insert($obj, $force);
    }

    /**
     * Delete a ID from the database
     *
     * @param XoopsBlock $obj
     * @return bool
     */
    public function deleteBlock(XoopsBlock &$obj)
    {
        if (!parent::delete($obj)) {
            return false;
        }
        $qb = $this->db2->createXoopsQueryBuilder();
        $eb = $qb->expr();
        $qb ->deletePrefix('group_permission', null)
            ->where($eb->eq('gperm_name', $eb->literal('block_read')))
            ->andWhere($eb->eq('gperm_itemid', $qb->createNamedParameter($obj->getVar('bid'), \PDO::PARAM_INT)))
            ->andWhere($eb->eq('gperm_modid', $qb->createNamedParameter(1, \PDO::PARAM_INT)))
            ->execute();

        $qb ->deletePrefix('block_module_link', null)
            ->where($eb->eq('block_id', $qb->createNamedParameter($obj->getVar('bid'), \PDO::PARAM_INT)))
            ->execute();

        return true;
    }

    /**
     * retrieve array of {@link XoopsBlock}s meeting certain conditions
     * @param CriteriaElement|null $criteria {@link CriteriaElement} with conditions for the blocks
     * @param bool $id_as_key should the blocks' bid be the key for the returned array?
     * @return array {@link XoopsBlock}s matching the conditions
     **/
    public function getDistinctObjects(CriteriaElement $criteria = null, $id_as_key = false)
    {
        $ret = array();

        $qb = $this->db2->createXoopsQueryBuilder();
        $eb = $qb->expr();
        $qb ->select('DISTINCT(b.bid)')
            ->addSelect('b.*')
            ->fromPrefix('newblocks', 'b')
            ->leftJoinPrefix('b', 'block_module_link', 'l', $eb->eq('b.bid', 'l.block_id'));

        if (isset($criteria) && ($criteria instanceof CriteriaElement)) {
            $criteria->renderQb($qb);
        }

        $result = $qb->execute();
        if (!$result) {
            return $ret;
        }
        while ($myrow = $result->fetch(\PDO::FETCH_ASSOC)) {
            $block = new XoopsBlock();
            $block->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] = $block;
            } else {
                $ret[$myrow['bid']] = $block;
            }
            unset($block);
        }
        return $ret;

    }

    /**
     * get a list of blocks matching certain conditions
     *
     * @param CriteriaElement|null $criteria conditions to match
     * @return array array of blocks matching the conditions
     **/
    public function getNameList(CriteriaElement $criteria = null)
    {
        $blocks = $this->getObjects($criteria, true);
        $ret = array();
        foreach (array_keys($blocks) as $i) {
            $name = (!$blocks[$i]->isCustom()) ? $blocks[$i]->getVar('name') : $blocks[$i]->getVar('title');
            $ret[$i] = $name;
        }
        return $ret;
    }

    /**
     * get all the blocks that match the supplied parameters
     *
     * @param int $side   0: sideblock - left
     *        1: sideblock - right
     *        2: sideblock - left and right
     *        3: centerblock - left
     *        4: centerblock - right
     *        5: centerblock - center
     *        6: centerblock - left, right, center
     * @param bool $asobject
     * @param int|array $groupid   groupid (can be an array)
     * @param int|null $visible   0: not visible 1: visible
     * @param string $orderby   order of the blocks
     * @param int $isactive
     * @return array of block objects
     */
    public function getAllBlocksByGroup($groupid, $asobject = true, $side = null, $visible = null, $orderby = "b.weight,b.bid", $isactive = 1)
    {
        $ret = array();
        $qb = $this->db2->createXoopsQueryBuilder();
        $eb = $qb->expr();
        if ($asobject) {
            $qb ->select('b.*');
        } else {
            $qb ->select('b.bid');
        }
        $qb ->fromPrefix('newblocks', 'b')
            ->leftJoinPrefix('b', 'group_permission', 'l', $eb->eq('b.bid', 'l.gperm_itemid'))
            ->where($eb->eq('gperm_name', $eb->literal('block_read')))
            ->andWhere($eb->eq('gperm_modid', 1));

        if (is_array($groupid)) {
            if (count($groupid) > 1) {
                $in=array();
                foreach ($groupid as $gid) {
                    $in[] = $qb->createNamedParameter($gid, \PDO::PARAM_INT);
                }
                $qb->andWhere($eb->in('l.gperm_groupid', $in));
            }
        } else {
            $qb->andWhere($eb->eq('l.gperm_groupid', $qb->createNamedParameter($groupid, \PDO::PARAM_INT)));
        }
        $qb->andWhere($eb->eq('b.isactive', $qb->createNamedParameter($isactive, \PDO::PARAM_INT)));
        if (isset($side)) {
            // get both sides in sidebox? (some themes need this)
            if ($side == XOOPS_SIDEBLOCK_BOTH) {
                $qb->andWhere($eb->in('b.side', array(0,1)));
            } elseif ($side == XOOPS_CENTERBLOCK_ALL) {
                $qb->andWhere($eb->in('b.side', array(3,4,5,7,8,9)));
            } else {
                $qb->andWhere($eb->eq('b.side', $qb->createNamedParameter($side, \PDO::PARAM_INT)));
            }
        }
        if (isset($visible)) {
            $qb->andWhere($eb->eq('b.visible', $qb->createNamedParameter($visible, \PDO::PARAM_INT)));
        }
        $qb->orderBy($orderby);
        $result = $qb->execute();
        $added = array();
        while ($myrow = $result->fetch(\PDO::FETCH_ASSOC)) {
            if (!in_array($myrow['bid'], $added)) {
                if (!$asobject) {
                    $ret[] = $myrow['bid'];
                } else {
                    $ret[] = new XoopsBlock($myrow);
                }
                array_push($added, $myrow['bid']);
            }
        }
        return $ret;
    }

    /**
     * @param string $rettype
     * @param null $side
     * @param null $visible
     * @param string $orderby
     * @param int $isactive
     * @return array
     */
    public function getAllBlocks($rettype = "object", $side = null, $visible = null, $orderby = "side,weight,bid", $isactive = 1)
    {
        $ret = array();
        $qb = $this->db2->createXoopsQueryBuilder();
        $eb = $qb->expr();

        $qb ->fromPrefix('newblocks', null)
            ->where($eb->eq('isactive', $qb->createNamedParameter($isactive, \PDO::PARAM_INT)));
        if (isset($side)) {
            // get both sides in sidebox? (some themes need this)
            if ($side == XOOPS_SIDEBLOCK_BOTH) {
                $qb->andWhere($eb->in('side', array(0,1)));
            } elseif ($side == XOOPS_CENTERBLOCK_ALL) {
                $qb->andWhere($eb->in('side', array(3,4,5,7,8,9)));
            } else {
                $qb->andWhere($eb->eq('side', $qb->createNamedParameter($side, \PDO::PARAM_INT)));
            }
        }
        if (isset($visible)) {
            $qb->andWhere($eb->eq('visible', $qb->createNamedParameter($visible, \PDO::PARAM_INT)));
        }
        $qb->orderBy($orderby);
        switch ($rettype) {
            case "object":
                $qb->select('*');
                $result = $qb->execute();
                while ($myrow = $result->fetch(\PDO::FETCH_ASSOC)) {
                    $ret[] = new XoopsBlock($myrow);
                }
                break;
            case "list":
                $qb->select('*');
                $result = $qb->execute();
                while ($myrow = $result->fetch(\PDO::FETCH_ASSOC)) {
                    $block = new XoopsBlock($myrow);
                    $title = $block->getVar("title");
                    $title = empty($title) ? $block->getVar("name") : $title;
                    $ret[$block->getVar("bid")] = $title;
                }
                break;
            case "id":
                $qb->select('bid');
                $result = $qb->execute();
                while ($myrow = $result->fetch(\PDO::FETCH_ASSOC)) {
                    $ret[] = $myrow['bid'];
                }
                break;
        }

        return $ret;
    }

    /**
     * @param int $moduleid
     * @param bool $asobject
     * @return array
     */
    public function getByModule($moduleid, $asobject = true)
    {
        $qb = $this->db2->createXoopsQueryBuilder();
        $eb = $qb->expr();

        $qb ->fromPrefix('newblocks', null)
            ->where($eb->eq('mid', $qb->createNamedParameter($moduleid, \PDO::PARAM_INT)));
        if ($asobject == true) {
            $qb->select('*');
        } else {
            $qb->select('bid');
        }

        $ret = array();
        $result = $qb->execute();
        while ($myrow = $result->fetch(\PDO::FETCH_ASSOC)) {
            if ($asobject) {
                $ret[] = new XoopsBlock($myrow);
            } else {
                $ret[] = $myrow['bid'];
            }
        }
        return $ret;
    }

    /**
     * XoopsBlock::getAllByGroupModule()
     *
     * @param mixed $groupid
     * @param integer $module_id
     * @param mixed $toponlyblock
     * @param mixed $visible
     * @param string $orderby
     * @param integer $isactive
     * @return array
     */
    public function getAllByGroupModule(
        $groupid,
        $module_id = 0,
        $toponlyblock = false,
        $visible = null,
        $orderby = 'b.weight, m.block_id',
        $isactive = 1
    ) {
        $ret = array();

        $qb = $this->db2->createXoopsQueryBuilder();
        $eb = $qb->expr();

        $blockids=null;
        if (isset($groupid)) {
            $qb ->select('DISTINCT gperm_itemid')
                ->fromPrefix('group_permission', null)
                ->where($eb->eq('gperm_name', $eb->literal('block_read')))
                ->andWhere('gperm_modid=1');

            if (is_array($groupid)) {
                $qb->andWhere($eb->in('gperm_groupid', $groupid));
            } else {
                if (intval($groupid) > 0) {
                    $qb->andWhere($eb->eq('gperm_groupid', $groupid));
                }
            }
            $result = $qb->execute();
            $blockids = $result->fetchAll(\PDO::FETCH_COLUMN, 0);
        }

        $qb->resetQueryParts();

        $qb ->select('b.*')
            ->fromPrefix('newblocks', 'b')
            ->where($eb->eq('b.isactive', $qb->createNamedParameter($isactive, \PDO::PARAM_INT)));
        if (isset($visible)) {
            $qb->andWhere($eb->eq('b.visible', $qb->createNamedParameter($visible, \PDO::PARAM_INT)));
        }
        if (isset($module_id)) {
            $qb ->fromPrefix('block_module_link', 'm')
                ->andWhere($eb->eq('m.block_id', 'b.bid'));
            if (!empty($module_id)) {
                $in=array();
                $in[]=0;
                $in[]=intval($module_id);
                if ($toponlyblock) {
                    $in[]=intval(-1);
                }
            } else {
                if ($toponlyblock) {
                    $in=array(0, -1);
                } else {
                    $in=0;
                }
            }
            if (is_array($in)) {
                $qb->andWhere($eb->in('m.module_id', $in));
            } else {
                $qb->andWhere($eb->eq('m.module_id', $in));
            }
        }
        if (!empty($blockids)) {
            $qb->andWhere($eb->in('b.bid', $blockids));
        }
        $qb->orderBy($orderby);
        $result = $qb->execute();
        while ($myrow = $result->fetch(\PDO::FETCH_ASSOC)) {
            $block = new XoopsBlock($myrow);
            $ret[$myrow['bid']] = $block;
            unset($block);
        }
        return $ret;
    }

    /**
     * XoopsBlock::getNonGroupedBlocks()
     *
     * @param integer $module_id
     * @param mixed $toponlyblock
     * @param mixed $visible
     * @param string $orderby
     * @param integer $isactive
     * @return array
     */
    public function getNonGroupedBlocks($module_id = 0, $toponlyblock = false, $visible = null, $orderby = 'b.weight, m.block_id', $isactive = 1)
    {
        $ret = array();

        $qb = $this->db2->createXoopsQueryBuilder();
        $eb = $qb->expr();

        $qb ->select('DISTINCT(bid)')
            ->fromPrefix('newblocks', null);
        $result = $qb->execute();
        $bids = $result->fetchAll(\PDO::FETCH_COLUMN, 0);

        $qb->resetQueryParts();

        $qb ->select('DISTINCT(p.gperm_itemid)')
            ->fromPrefix('group_permission', 'p')
            ->fromPrefix('groups', 'g')
            ->where($eb->eq('g.groupid', 'p.gperm_groupid'))
            ->andWhere($eb->eq('p.gperm_name', $eb->literal('block_read')));
        $result = $qb->execute();
        $grouped = $result->fetchAll(\PDO::FETCH_COLUMN, 0);

        $non_grouped = array_diff($bids, $grouped);

        if (!empty($non_grouped)) {
            $qb->resetQueryParts();

            $qb ->select('b.*')
                ->fromPrefix('newblocks', 'b')
                ->where($eb->eq('b.isactive', $qb->createNamedParameter($isactive, \PDO::PARAM_INT)));
            if (isset($visible)) {
                $qb->andWhere($eb->eq('b.visible', $qb->createNamedParameter($visible, \PDO::PARAM_INT)));
            }

            $sql = 'SELECT b.* FROM ' . $this->db2->prefix('newblocks') . ' b, '
            . $this->db2->prefix('block_module_link') . ' m';
            $sql .= ' WHERE b.isactive=' . intval($isactive);
            if (isset($visible)) {
                $sql .= ' AND b.visible=' . intval($visible);
            }
            if (isset($module_id)) {
                $qb ->fromPrefix('block_module_link', 'm')
                    ->andWhere($eb->eq('m.block_id', 'b.bid'));
                if (!empty($module_id)) {
                    $in=array();
                    $in[]=0;
                    $in[]=intval($module_id);
                    if ($toponlyblock) {
                        $in[]=intval(-1);
                    }
                } else {
                    if ($toponlyblock) {
                        $in=array(0, -1);
                    } else {
                        $in=0;
                    }
                }
                if (is_array($in)) {
                    $qb->andWhere($eb->in('m.module_id', $in));
                } else {
                    $qb->andWhere($eb->eq('m.module_id', $in));
                }
            }
            $qb->andWhere($eb->in('b.bid', $non_grouped));
            $qb->orderBy($orderby);
            $result = $qb->execute();
            while ($myrow = $result->fetch(\PDO::FETCH_ASSOC)) {
                $block = new XoopsBlock($myrow);
                $ret[$myrow['bid']] = $block;
                unset($block);
            }
        }
        return $ret;
    }

    /**
     * XoopsBlock::countSimilarBlocks()
     *
     * @param int $moduleId
     * @param string $funcNum
     * @param mixed $showFunc
     * @return int
     */
    public function countSimilarBlocks($moduleId, $funcNum, $showFunc = null)
    {
        $funcNum = intval($funcNum);
        $moduleId = intval($moduleId);
        if ($funcNum < 1 || $moduleId < 1) {
            // invalid query
            return 0;
        }

        $qb = $this->db2->createXoopsQueryBuilder();
        $eb = $qb->expr();

        $qb ->select('COUNT(*)')
            ->fromPrefix('newblocks', null)
            ->where($eb->eq('mid', $qb->createNamedParameter($moduleId, \PDO::PARAM_INT)))
            ->andWhere($eb->eq('func_num', $qb->createNamedParameter($funcNum, \PDO::PARAM_INT)));

        if (isset($showFunc)) {
            // showFunc is set for more strict comparison
            $qb->andWhere($eb->eq('show_func', $qb->createNamedParameter($showFunc, \PDO::PARAM_STR)));
        }
        if (!$result = $qb->execute()) {
            return 0;
        }
        list ($count) = $result->fetch(\PDO::FETCH_NUM);
        return $count;
    }

    /**
     * Aligns the content of a block
     * If position is 0, content in DB is positioned
     * before the original content
     * If position is 1, content in DB is positioned
     * after the original content
     *
     * @param $position
     * @param string $content
     * @param string $contentdb
     * @return string
     */
    public function buildContent($position, $content = "", $contentdb = "")
    {
        $ret = '';
        if ($position == 0) {
            $ret = $contentdb . $content;
        } else {
            if ($position == 1) {
                $ret = $content . $contentdb;
            }
        }
        return $ret;
    }

    /**
     * Enter description here...
     *
     * @param string $originaltitle
     * @param string $newtitle
     * @return string title
     */
    public function buildTitle($originaltitle, $newtitle = '')
    {
        if ($newtitle != '') {
            $ret = $newtitle;
        } else {
            $ret = $originaltitle;
        }
        return $ret;
    }

    /************ system ***************/

    /**
     * @param int|array $groupid
     * @return array
     */
    public function getBlockByPerm($groupid)
    {
        $ret = array();
        if (isset($groupid)) {
            $qb = $this->db2->createXoopsQueryBuilder();
            $eb = $qb->expr();

            $qb ->select('DISTINCT(gperm_itemid)')
                ->fromPrefix('group_permission', 'p')
                ->fromPrefix('groups', 'g')
                ->where($eb->eq('p.gperm_name', $eb->literal('block_read')))
                ->andWhere('gperm_modid=1');

            $result = $qb->execute();
            $grouped = $result->fetchAll(\PDO::FETCH_COLUMN, 0);

            if (is_array($groupid)) {
                $qb->andWhere($eb->in('gperm_groupid', $groupid));
            } else {
                if (intval($groupid) > 0) {
                    $qb->andWhere($eb->eq('gperm_groupid', $groupid));
                }
            }

            $result = $qb->execute();
            $blockids = $result->fetchAll(\PDO::FETCH_COLUMN, 0);
            return $blockids;
        }
        return $ret;
    }
}
