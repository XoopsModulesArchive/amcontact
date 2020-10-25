<?php

// $Id: index.php,v 1.3 2007/04/27 18:58:35 andrew Exp $
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

require_once 'header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

## Temp. notes
# add option for user name or real name in name field?
# Add icon image and select answer captcha

//----------------------------------------------------------------------------//
// Check if logged in
if (1 == $xoopsModuleConfig['loggedin']) {
    if (empty($xoopsUser)) {
        //redirect_header("index.php", 2, _MD_LOGGEDIN);

        redirect_header(XOOPS_URL . '/user.php', 4, _AM_LOGGEDIN);

        exit();
    }
} // end section

//----------------------------------------------------------------------------//
// Stop if max characters exceeded.
if (isset($_POST['formdata'])) {
    $formdata = $_POST['formdata'];

    if (mb_strlen($formdata['text']) > $xoopsModuleConfig['maxchars']) {
        redirect_header(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/index.php', 2, sprintf(_AM_EMLMAXCHARS, $xoopsModuleConfig['maxchars']));

        exit();
    }
} // end section

//----------------------------------------------------------------------------//
// verification types
// Image
if (isset($xoopsModuleConfig['verifytype']) and 0 == $xoopsModuleConfig['verifytype']) {
    // Verify image captcha

    if (isset($_REQUEST['verify'])) {
        // verify

        if (md5($_POST['verify']) != $_SESSION['image_random_value']) {
            // create an error so we can alter submit process.

            $verifyerror = 1;

        #echo "<span style=\"font-weight: bold; color: red; text-align: center;\">Please check and re-enter the verification code!</span>";
            #exit;
        } else {
            $verifyerror = 0;

            #echo "verified";
            #exit;
        }
    } // end section
} // end image verify

// Question and answer
if (isset($xoopsModuleConfig['verifytype']) and 1 == $xoopsModuleConfig['verifytype']) {
    if (isset($_POST['verifyID'])) {
        $result = $xoopsDB->query(
            'SELECT answer FROM ' . $xoopsDB->prefix('amcont_questions') . " WHERE id='" . (int)$_POST['verifyID'] . "'"
        );

        [$answer] = $xoopsDB->fetchRow($result);

        if (isset($_POST['verify']) and mb_strtolower($_POST['verify']) != mb_strtolower($answer)) {
            $verifyerror = 1;
        } else {
            $verifyerror = 0;
        }
    } // end
} // end Q&A

if (isset($xoopsModuleConfig['verifytype']) and 2 == $xoopsModuleConfig['verifytype']) {
    $verifyerror = 0;
}

//----------------------------------------------------------------------------//
// Default page view
if (!isset($_REQUEST['op']) or 1 == $verifyerror) {
    #print_r($formdata);

    $GLOBALS['xoopsOption']['template_main'] = 'amcont_index.html';

    require XOOPS_ROOT_PATH . '/header.php';

    $xoopsTpl->assign('introtext', $xoopsModuleConfig['introtext']);

    /**
     * Grab form data if verify fails - saves user from re-entering data.
     */

    if (isset($_REQUEST['formdata'])) {
        $formdata = $_POST['formdata'];

        $xoopsTpl->assign('verifyerror', _AM_CONT_VERIFYERR);
    } else {
        $formdata = '';
    }

    /**
     * Get user data if logged in.
     */

    if (!empty($xoopsUser)) {
        if (isset($xoopsModuleConfig['defaultname']) and 0 == $xoopsModuleConfig['defaultname']) {
            $rname = $xoopsUser->getVar('uname', 'E');
        }

        if (isset($xoopsModuleConfig['defaultname']) and 1 == $xoopsModuleConfig['defaultname']) {
            $rname = $xoopsUser->getVar('name');
        }

        $uemail = $xoopsUser->getVar('email', 'E');
    }

    /**
     * Build/create form
     */

    $submitform = new XoopsThemeForm(_MD_SUBMIT_PAGE_TITLE, 'submitform', xoops_getenv('PHP_SELF'), 'post');

    /**
     * Name text field. Can be auto-filled for users that are logged in.
     */

    if (isset($_REQUEST['formdata'])) {
        $name = $formdata['name'];
    } else {
        $name = $rname;
    }

    $name = new XoopsFormText(_AM_CONT_FRMCAPNAME, 'formdata[name]', 40, 255, $name);

    $submitform->addElement($name);

    unset($name);

    /**
     * E-mail text field.  Can be auto-filled for users that are logged in.
     */

    if (isset($_REQUEST['formdata'])) {
        $email = $formdata['email'];
    } else {
        $email = $uemail;
    }

    $email = new XoopsFormText(_AM_CONT_FRMCAPEMAIL, 'formdata[email]', 40, 255, $email);

    $submitform->addElement($email);

    unset($email);

    /**
     * Subject text field.
     */

    if (isset($_REQUEST['formdata'])) {
        $subject = $myts->stripSlashesGPC($formdata['subject']);
    } else {
        $subject = '';
    }

    $subject = new XoopsFormText(_AM_CONT_FRMCAPSUB, 'formdata[subject]', 40, 255, $subject);

    $submitform->addElement($subject);

    unset($subject);

    /**
     * Main text textarea.
     */

    if (isset($_REQUEST['formdata'])) {
        $text = $myts->stripSlashesGPC($formdata['text']);
    } else {
        $text = '';
    }

    $editor = new XoopsFormTextArea(_AM_CONT_FRMCAPTEXT, 'formdata[text]', $text, $xoopsModuleConfig['textboxheight'], $xoopsModuleConfig['textboxwidth']);

    #$editor->setExtra('onKeyDown="textCounter(document.getElementById(\'msg\'),this.form.remLen,".$xoopsModuleConfig['maxchars'].");" onKeyUp="textCounter(document.getElementById(\'msg\'),this.form.remLen,".$xoopsModuleConfig['maxchars'].");"');

    $editor->setExtra('onKeyDown="textCounter(document.getElementById(\'formdata[text]\'), this.form.remLen, ' . $xoopsModuleConfig['maxchars'] . ');"  onKeyUp="textCounter(document.getElementById(\'formdata[text]\'), this.form.remLen, ' . $xoopsModuleConfig['maxchars'] . ');"');

    $submitform->addElement($editor);

    unset($editor);

    /**
     * <input readonly type="text" id="remLen" name="remLen" size="4" maxlength="4" value="<{$maxchars}>">
     */

    $chars = new XoopsFormText('', 'remLen', 4, 10, $xoopsModuleConfig['maxchars']);

    $chars->setExtra('readonly');

    $submitform->addElement($chars);

    unset($chars);

    /**
     * Verification methods.
     */

    if (isset($xoopsModuleConfig['verifytype']) and 0 == $xoopsModuleConfig['verifytype']) {
        /**
         * Image verify captcha
         */

        $verify_tray = new XoopsFormElementTray(_AM_CONT_FRMCAPVERIFY, '');

        $verify = new XoopsFormText('', 'verify', 5, 10, '');

        $verifyImg = new XoopsFormLabel('', '<img src="verifyimage.php" align="middle">');

        $verify_tray->addElement($verify);

        $verify_tray->addElement($verifyImg);

        $submitform->addElement($verify_tray);

        unset($verify);
    }

    if (isset($xoopsModuleConfig['verifytype']) and 1 == $xoopsModuleConfig['verifytype']) {
        /**
         * Q&A
         */

        // add sql to select question and its ID

        $result = $xoopsDB->query('SELECT id, question FROM ' . $xoopsDB->prefix('amcont_questions') . ' ORDER BY rand() LIMIT 1');

        [$id, $question] = $xoopsDB->fetchRow($result);

        #echo $question;

        $verify_tray = new XoopsFormElementTray(_AM_CONT_FRMCAPVERIFY, '');

        $verifyQ = new XoopsFormLabel($question, '<br>');

        $verify = new XoopsFormText('', 'verify', 8, 40, '');

        $verifyImg = new XoopsFormLabel('', '<img src="verifyimage.php" align="middle">');

        $verify_tray->addElement($verifyQ);

        $verify_tray->addElement($verify);

        #$verify_tray->addElement($verifyImg);

        $submitform->addElement($verify_tray);

        unset($verify);

        $submitform->addElement(new XoopsFormHidden('verifyID', $id));

        #exit;
    }

    /**
     * Hidden fields
     */

    $submitform->addElement(new XoopsFormHidden('op', 'send'));

    /**
     * Submit and cancel buttons
     */

    $button_sub = new XoopsFormButton('', 'but_save', _AM_CONT_SUBMIT, 'submit');

    $button_sub->setExtra('onclick="return checkfields();"');

    $button_can = new XoopsFormButton('', 'but_reset', _AM_CONT_SUBRESET, 'reset');

    //$button_pre->setExtra('onclick="return checkfields();"');

    $tray = new XoopsFormElementTray('');

    $tray->addElement($button_sub);

    $tray->addElement($button_can);

    //$tray->addElement($button_pre);

    $submitform->addElement($tray);

    unset($button_sub);

    unset($button_can);

    //unset($button_pre);

    /**
     * Assign to template
     */

    $xoopsTpl->assign('submitform', $submitform->render());

    #$xoopsTpl->assign('submitform', $submitform->display());

    unset($submitform);

    require_once XOOPS_ROOT_PATH . '/footer.php';
} // end if

//----------------------------------------------------------------------------//
// Process and send.
if (isset($_REQUEST['op']) and 'send' == $_REQUEST['op'] and 1 != $verifyerror) {
    #$xoopsOption['template_main']= "amcont_index.html";

    require XOOPS_ROOT_PATH . '/header.php';

    if (isset($_REQUEST['formdata'])) {
        $formdata = $_POST['formdata'];
    } else {
        $formdata = '';
    }

    #echo "<pre>";

    #print_r($formdata);

    #echo "</pre>";

    $name = $formdata['name'];

    $email = $formdata['email'];

    $subject = sprintf(_AM_CONT_SUBPREFIX . $myts->stripSlashesGPC($formdata['subject']), $xoopsConfig['sitename']);

    $msgtext = $myts->stripSlashesGPC($formdata['text']);

    #$headers  = "From: ".$name."<".$email.">\r\n";

    #$headers .= "X-mailer: AM Contact - XOOPS v2 module at XOOPS_URL.\r\n";

    /**
     * Get template from prefs.
     */

    $bodytemplate = $xoopsModuleConfig['bodytemplate'];

    /**
     * Replace various doodahs in template.
     */

    // {USER_MESSAGE} is the search string.

    $body = preg_replace('/{USER_MESSAGE}/', $msgtext, $xoopsModuleConfig['bodytemplate']);

    // Replace {USER_IP} with user's IP address.

    $body = preg_replace('/{USER_IP}/', $_SERVER['REMOTE_ADDR'], $body);

    // Replace {USER_BROWSER} with user's browser info.

    $body = preg_replace('/{USER_BROWSER}/', $_SERVER['HTTP_USER_AGENT'], $body);

    // Replace {SITE_URL} with XOOPS generated URL of site.

    $body = preg_replace('/{XOOPS_URL}/', XOOPS_URL, $body);

    // Replace {SITE_NAME} with name of site defined in XOOPS' config.

    $body = preg_replace('/{SITE_NAME}/', $xoopsConfig['sitename'], $body);

    // Replace {USER_TIME} with date and time

    $body = preg_replace('/{USER_TIME}/', formatTimestamp(mktime(), 'rss'), $body);

    // Replace {ARTICLE_URL} with URL to article.

    #$body = preg_replace("/{ARTICLE_URL}/", XOOPS_URL . "/modules/articles/article.php?id=" . $id, $body);

    // Replace {ADMIN_EMAIL} with admin email

    $body = preg_replace('/{ADMIN_EMAIL}/', $xoopsConfig['adminmail'], $body);

    // Replace {ADMIN_NAME} with admin's name

    #$body = preg_replace("/{ADMIN_NAME}/", $xoopsConfig['adminname'], $body);

    // Replace {ADMIN_NAME} with admin's name

    $body = preg_replace('/{USER_NAME}/', $name, $body);

    //USER_EMAIL

    $body = preg_replace('/{USER_EMAIL}/', $email, $body);

    /**
     * Strip HTML entities from user's message
     */

    /**
     * Convert any HTML line breaks to text and remove slashes
     */

    /**
     * Wordwrap e-mail to 72 characters and use \r\n to wrap in plain text.
     */

    $body = wordwrap($body, 72, "\r\n");

    /**
     * Send e-mail.
     */

    $xoopsMailer = getMailer();

    $xoopsMailer->useMail();

    $xoopsMailer->setToEmails($xoopsConfig['adminmail']);

    $xoopsMailer->setFromEmail($email);

    $xoopsMailer->setFromName($name);

    $xoopsMailer->setSubject($subject);

    $xoopsMailer->setBody($body);

    $xoopsMailer->send(true);

    #echo $xoopsMailer->getSuccess();

    #echo $xoopsMailer->getErrors();

    if ($xoopsMailer->getSuccess()) {
        redirect_header('index.php', 4, _AM_CONT_MESSAGESENT);

        #echo _AM_CONT_MESSAGESENT;
    }

    if ($xoopsMailer->getErrors()) {
        redirect_header('index.php', 4, _AM_CONT_MESSAGENOTSENT);

        #echo _AM_CONT_MESSAGENOTSENT;
    }

    require_once XOOPS_ROOT_PATH . '/footer.php';
} // end section
