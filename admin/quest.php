<?php

// $Id: quest.php,v 1.2 2007/03/04 01:06:11 andrew Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://www.xoops.org>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

// includes
require_once 'header.inc.php';

//----------------------------------------------------------------------------//
if (!isset($_REQUEST['op'])) {
    xoops_cp_header();

    amcontact_adminmenu(1, _AM_AMCONT_QUEST);

    $rowclass = '';

    echo '<table border="0" cellspacing="1" width="100%" class="outer">';

    echo '<tr>';

    echo '<th colspan="5">' . _AM_AMCONT_QUESTTBLCAP . '</th>';

    echo '</tr>';

    echo '<tr>';

    echo '<td class="head" style="text-align: center;">' . _AM_AMCONT_CAPID . '</td>';

    echo '<td class="head" style="text-align: center;">' . _AM_AMCONT_CAPTTL . '</td>';

    echo '<td class="head" style="text-align: center;">' . _AM_AMCONT_CAPANS . '</td>';

    echo '<td class="head"></td>';

    echo '<td class="head"></td>';

    echo '</tr>';

    $sql = ('SELECT * FROM ' . $xoopsDB->prefix('amcont_questions') . ' ');

    $result = $xoopsDB->query($sql);

    if ($xoopsDB->getRowsNum($result) > 0) {
        while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
            $rowclass = ('odd' == $rowclass) ? 'even' : 'odd';

            echo '<tr>';

            echo '<td style="text-align: center; width: 20px;" class="' . $rowclass . '">' . $myrow['id'] . '</td>';

            echo '<td style="text-align: left;" class="' . $rowclass . '">' . $myrow['question'] . '</td>';

            echo '<td style="text-align: left;" class="' . $rowclass . '">' . $myrow['answer'] . '</td>';

            echo '<td style="text-align: center; width: 20px;" class="' . $rowclass . '"><a href="quest.php?id=' . $myrow['id'] . '&amp;op=edit">edit</a></td>';

            echo '<td style="text-align: center; width: 20px;" class="' . $rowclass . '"><a href="quest.php?id=' . $myrow['id'] . '&amp;op=del">del</a></td>';

            echo '</tr>';
        }
    }

    echo '</table>';

    $formaction = 'add';

    $formcaption = _AM_AMCONT_QUESTTBLCAPADD;

    require_once 'questform.inc.php';

    amcontact_adminfooter();

    xoops_cp_footer();
} // end if

//----------------------------------------------------------------------------//
// Add new Q&A
if (isset($_REQUEST['op']) and 'add' == $_REQUEST['op']) {
    #xoops_cp_header();

    #amcontact_adminmenu(1, _AM_AMCONT_QUEST);

    $formdata = $_POST['formdata'] ?? '';

    $question = $myts->addSlashes($formdata['question']);

    $answer = $myts->addSlashes($formdata['answer']);

    $sql = 'INSERT INTO ' . $xoopsDB->prefix('amcont_questions') . " VALUES (
			NULL, 
			'$question',
			'$answer'
			)";

    $xoopsDB->query($sql); // or $eh->show("0013");

    if ($xoopsDB->getAffectedRows($sql) > 0) {
        redirect_header('quest.php', 2, _AM_AMCONT_DBUPDATED);

    #echo "entered";
    } else {
        redirect_header('quest.php', 2, _AM_AMCONT_DBNOUPDATED);

        #echo "not entered - ".$GLOBALS['xoopsDB']->error();
    }

    #amcontact_adminfooter();
    #xoops_cp_footer();
} // end if

//----------------------------------------------------------------------------//
// Edit Q&A
if (isset($_REQUEST['op']) and 'edit' == $_REQUEST['op']) {
    /**
     * Load form if subop not set.
     */

    if (!isset($_REQUEST['subop'])) {
        xoops_cp_header();

        amcontact_adminmenu(1, _AM_AMCONT_QUEST);

        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        } else {
            $id = '';
        }

        $sql = ('SELECT * FROM ' . $xoopsDB->prefix('amcont_questions') . " WHERE id='" . $id . "'");

        $result = $xoopsDB->query($sql);

        if ($xoopsDB->getRowsNum($result) > 0) {
            while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
                $id = $myrow['id'];

                $question = $myrow['question'];

                $answer = $myrow['answer'];
            }
        }

        $formaction = 'edit';

        $formcaption = _AM_AMCONT_QUESTTBLCAPEDIT;

        require_once 'questform.inc.php';

        amcontact_adminfooter();

        xoops_cp_footer();
    } // if

    /**
     * Save update if subop set.
     */

    if (isset($_REQUEST['subop']) and 'save' == $_REQUEST['subop']) {
        xoops_cp_header();

        $formdata = $_POST['formdata'] ?? '';

        //echo "<pre>";

        //print_r($formdata);

        //exit;

        //echo "</pre>";

        $id = (int)$formdata['id'];

        $question = $myts->addSlashes($formdata['question']);

        $answer = $myts->addSlashes($formdata['answer']);

        /**
         * Save updates
         */

        $sql = ('UPDATE ' . $xoopsDB->prefix('amcont_questions') . " SET 
				id			= '$id',
				question	= '$question',
				answer		= '$answer'
				WHERE id='$id'");

        #$result=$xoopsDB->query($sql);

        $xoopsDB->query($sql); // or $eh->show("0013");

        if ($xoopsDB->getAffectedRows($sql) > 0) {
            redirect_header('quest.php', 2, _AM_AMCONT_DBUPDATED);

        #echo "entered";
        } else {
            redirect_header('quest.php', 2, _AM_AMCONT_DBNOUPDATED);

            #echo "not entered - ".$GLOBALS['xoopsDB']->error();
        }
    } // end  save update
} // end edit section

//----------------------------------------------------------------------------//
// Add new Q&A
if (isset($_REQUEST['op']) and 'del' == $_REQUEST['op']) {
    if (isset($_REQUEST['id'])) {
        $id = (int)$_REQUEST['id'];
    } else {
        $id = '';
    }

    /**
     * Confirm deletion.
     */

    if (!isset($_REQUEST['subop'])) {
        xoops_cp_header();

        xoops_confirm(['op' => 'del', 'id' => $id, 'subop' => 'delok'], 'quest.php', _AM_AMCONT_DBCONFMDEL);

        #echo "confrim del";

        xoops_cp_footer();
    } // end if

    /**
     * Delete
     */

    if (isset($_REQUEST['subop']) && 'delok' == $_REQUEST['subop']) {
        $sql = sprintf('DELETE FROM %s WHERE id = %u', $xoopsDB->prefix('amcont_questions'), $id);

        #if ($xoopsDB->queryF($sql)) {

        $xoopsDB->queryF($sql);

        if ($xoopsDB->getAffectedRows($sql) > 0) {
            redirect_header('quest.php', 2, _AM_AMCONT_DBDELETED);

        #echo "deleted";
        } else {
            redirect_header('quest.php', 2, _AM_AMCONT_DBNOTDELETED);

            #echo "not deleted - ".$GLOBALS['xoopsDB']->error();
        }
    }
}// end if

#amcontact_adminfooter();
#xoops_cp_footer();
