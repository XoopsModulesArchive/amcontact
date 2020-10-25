<?php

// $Id: main.php,v 1.3 2007/03/05 00:22:34 andrew Exp $
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

/**
 * index.php
 */
define('_MD_SUBMIT_PAGE_TITLE', 'Contact us:');
define('_AM_CONT_FRMCAPNAME', 'Name:');
define('_AM_CONT_FRMCAPEMAIL', 'Your e-mail:');
define('_AM_CONT_FRMCAPSUB', 'Subject:');
define('_AM_CONT_FRMCAPTEXT', 'Your message:');
define('_AM_CONT_SUBMIT', 'Send');
define('_AM_CONT_SUBRESET', 'Clear');
define('_AM_CONT_SUBPREFIX', '%s site contact: ');

define('_AM_LOGGEDIN', 'You must be logged in to send a message!');
define('_AM_EMLMAXCHARS', 'Sorry, you have tried submitting a message with more than %d characters.');

define('_AM_CONT_JSNAME', 'Please enter your name!');
define('_AM_CONT_JSEMAIL', 'Please enter your email!');
define('_AM_CONT_JSSUBJECT', 'Please enter a subject!');
define('_AM_CONT_JSTEXT', 'Please enter a message!');

define('_AM_CONT_FRMCAPVERIFY', 'Antispam verification:');
define('_AM_CONT_VERIFYERR', '<p><span style="color: red; font-weight: bold;">There was an error with the verification, please try again.</span></p>');
define('_AM_CONT_MESSAGESENT', 'Thank you! Your message was sent successfully.');
define('_AM_CONT_MESSAGENOTSENT', 'Sorry, there was an error sending your message. Please consider sending a PM (private message) instead.');
