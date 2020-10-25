<?php

// $Id: questform.inc.php,v 1.2 2007/03/04 01:06:11 andrew Exp $
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
#require_once "header.inc.php";
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

echo '<br>';

/**
 * Initialise form.
 */
$questionform = new XoopsThemeForm($formcaption, 'questionform', xoops_getenv('PHP_SELF'), 'post');

/**
 * Question
 */
if (!isset($question)) {
    $question = '';
}
$question = new XoopsFormText(_AM_AMCONT_CAPQUESTION, 'formdata[question]', 50, 255, $question);
$questionform->addElement($question);
unset($question);

/**
 * Answer
 */
if (!isset($answer)) {
    $answer = '';
}
$answer = new XoopsFormText(_AM_AMCONT_CAPANSWER, 'formdata[answer]', 50, 255, $answer);
$questionform->addElement($answer);
unset($answer);

/**
 * Hidden fields
 */
if ('add' == $formaction) {
    $questionform->addElement(new XoopsFormHidden('op', 'add'));
}
if ('edit' == $formaction) {
    $questionform->addElement(new XoopsFormHidden('op', 'edit'));

    $questionform->addElement(new XoopsFormHidden('subop', 'save'));

    $questionform->addElement(new XoopsFormHidden('formdata[id]', $id));
}

/**
 * Add/submit category button
 */
$button_sub = new XoopsFormButton('', 'but_save', _AM_AMCONT_SUBMIT, 'submit');
$button_tray = new XoopsFormElementTray('');
$button_tray->addElement($button_sub);
$questionform->addElement($button_tray);

/**
 * End - Display form
 */
$questionform->display();
