<?php

// $Id: verifyimage.php,v 1.2 2007/03/04 01:06:11 andrew Exp $
//  ------------------------------------------------------------------------ //
//  Author: Andrew Mills                                                     //
//  Email:  ajmills@sirium.net                                               //
//	About:  This file is part of the AM Contact module for Xoops v2.         //
//                                                                           //
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

// based on tutorial at:
// http://www.php-mysql-tutorial.com/user-authentication/image-verification.php

// includes
require_once 'header.php';

// Start
session_start();

// generate  5 digit random number
//$rand = rand(10000, 99999);

// use alphanumerical - lowercase "l/L" not used as can be confused
// for "i", unless "i" is also present to compare
$alphanum = 'abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

// generate the verication code
$rand = mb_substr(str_shuffle($alphanum), 0, 5);

// create the hash for the random number and put it in the session
$_SESSION['image_random_value'] = md5($rand);

// choose one of four background images
$bgNum = random_int(1, 6);

// create the image
//$image = imagecreate(60, 30);
$image = imagecreatefromjpeg('images/verify' . $bgNum . '.jpg');

// use white as the background image
$bgColor = imagecolorallocate($image, 255, 255, 255);

// the text color is black
$textColor = imagecolorallocate($image, 0, 0, 0);

// write the random number
imagestring($image, 5, 5, 8, $rand, $textColor);

// send several headers to make sure the image is not cached
// taken directly from the PHP Manual

// Date in the past
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

// always modified
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

// HTTP/1.1
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);

// HTTP/1.0
header('Pragma: no-cache');

// send the content type header so the image is displayed properly
header('Content-type: image/jpeg');

// send the image to the browser
imagejpeg($image);

// destroy the image to free up the memory
imagedestroy($image);
