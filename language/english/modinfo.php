<?php

// $Id: modinfo.php,v 1.3 2007/04/27 19:00:29 andrew Exp $
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
 * xoops_version.php
 * General
 */
define('_MI_AMCONTACT_NAME', 'AM Contact');
define('_MI_AMCONTACT_DESC', 'Contact us type module with &quot;captcha&quot; and stuff.');

/**
 * xoops_version.php
 * Configs
 */
define('_MI_AMCONT_LOGGEDIN', 'Logged in:');
define('_MI_AMCONT_LOGGEDINDSC', 'Whether or not the sender has to be logged in to send messages.');
define('_MI_AMCONT_BDYTMPLT', 'Message template:');
define('_MI_AMCONT_BDYTMPLTDSC', 'This is the template for the mail that admins will receive.');
define(
    '_MI_AMCONT_BDYTMPLTTXT',
    "Hello,

{USER_NAME} {USER_EMAIL} has sent the following message from your web site at
{XOOPS_URL}:

{USER_MESSAGE}


Security information:
User's IP address: {USER_IP}
User's Browser: {USER_BROWSER}
Time sent: {USER_TIME}


"
);
define('_MI_AMCONT_MAXCHARS', 'Maximum characters:');
define('_MI_AMCONT_MAXCHARSDSC', "The maximum amount of characters allowed in user's message.");
define('_MI_AMCONT_DEFNAME', 'Default name:');
define('_MI_AMCONT_DEFNAMEDSC', "This selects whether the sender's real name or user name is used. Please note that not all users fill in the real name field.");
define('_MI_AMCONT_DEFNAME_OPT_0', 'Username');
define('_MI_AMCONT_DEFNAME_OPT_1', 'Real name');

define('_MI_AMCONT_VERTYPE', 'Verify type:');
define('_MI_AMCONT_VERTYPEDSC', 'The type of verification to use. This is a tool to help prevent spam being sent to you via the contact form.');
define('_MI_AMCONT_VERTYPE_OPT_0', 'Image captcha');
define('_MI_AMCONT_VERTYPE_OPT_1', 'Question and answer');
define('_MI_AMCONT_VERTYPE_OPT_2', 'No verification');
define('_MI_AMCONT_TBOXWIDTH', 'Text box width:');
define('_MI_AMCONT_TBOXWIDTHDSC', 'Width of message text box.');
define('_MI_AMCONT_TBOXHEIGHT', 'Text box height:');
define('_MI_AMCONT_TBOXHEIGHTDSC', 'Height of message text box.');
define('_MI_AMCONT_INTROTEXT', 'Intro text:');
define('_MI_AMCONT_INTROTEXTDSC', 'Text for introduction above contact form.');
define('_MI_AMCONT_INTROTEXTTXT', '');

/**
 * menu.php
 */
define('_MI_AMCONTACT_MENU1', 'Index');
define('_MI_AMCONTACT_MENU2', 'Questions');

/**
 * For cloning - only change when change dir name!
 */
#define("_MI_AMCONT_MODDIR",	"amcontact");
