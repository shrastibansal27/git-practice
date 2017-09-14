<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: controller.php  $
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/* $task = JRequest::getCmd('task');
echo $task;
exit(); */

class JsplocationController extends JControllerLegacy {
function display($cachable = false, $urlparams=false)
	{
		 $mainframe = Jfactory::GetApplication();
		if (JRequest::getVar('installData'))
		{
			$this->installSampleData();
			$link = "index.php?option=com_jsplocation";
            $mainframe->redirect( $link );
		}
		parent::display();

	}


		function installSampleData()
		{
			$db =& JFactory::getDBO();
			$db->setQuery(
			"INSERT INTO `#__jsplocation_branch` (`id`, `branch_name`, `address1`, `latitude`, `longitude`, `lat_long_override`, `lat_ovr`, `long_ovr`, `zip`, `landmark`, `area_id`, `city_id`, `state_id`, `country_id`, `category_id`, `contact_person`, `gender`, `email`, `website`, `contact_number`, `description`, `facebook`, `twitter`, `published`, `pointerImage`, `imagename`, `image_display`, `store_videos`, `youtube_url`, `vimeo_url`, `dailymotion_url`, `flickr_url`, `slideshare_url`, `speakerdeck_url`) VALUES
(1, '1 Wall Street', '1 Wall St., New York, NY, United States', '40.707491', '-74.0116385', 0, '', '', '10286', '', 9, 31, 192, 4, '2', 'Mr. Lorem ipsum', 1, 'loremipsum@yahoo.com', 'http://www.google.co.in', '', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.\r\n', 'http://www.facebook.com/hgjh', 'http://www.twitter.com/hhhh', 1, 'jl_marker1.png', 'wall-street.jpg', 1, 1, 'https://www.youtube.com/watch?v=tEip-gVQVCM', 'https://vimeo.com/145892598', 'http://www.dailymotion.com/video/x32yatv_the-new-york-stock-exchange-wall-st-new-york-city-new-york_travel', 'https://www.flickr.com/photos/jim-in-times-square/3493401208/', '', ''),
(2, 'The World Bank Headquaters', '1818 H Street Northwest, Washington, United States', '38.8990253', '-77.0424279', 0, '10', '10', 'DC 20433', '', 10, 34, 76, 2, '2', 'Miss. Lorem ipsum2', 0, 'loremipsum2@yahoo.com', 'http://www.google.com', '9876543210', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.', 'http://www.facebook.com/name', 'http://www.twitter.com/name', 1, 'jl_marker2.png', '2_the world bank headquaters.jpg', 0, 1, 'https://www.youtube.com/watch?v=WYGhaBGdrN0', '', '', '', '', ''),
(3, '125 Old Broad Street', '125 Old Broad St London, UK', '51.5145558', '-0.0859578', 0, '', '', 'EC2N 1AR', '', 11, 35, 196, 4, '2', 'Mr. Lorem ipsum3', 1, 'loremipsum3@yahoo.com', 'http://www.google.com', '7654321098', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 'http://www.facebook.com/name', 'http://www.twitter.com/name', 1, 'jl_marker3.png', '3_125 old broad street.jpg', 0, 1, 'https://www.youtube.com/watch?v=Wge_HDYjrRY', '', 'http://www.dailymotion.com/video/x2luabk_go-ahead-london-wvls-at-old-broad-street_travel', '', '', ''),
			(4, 'Dubai World Trade Centre', 'Sheikh Zayed Road, Dubai, United Arab Emirates', '25.0627184', '55.1307613', 0, '25.225583', '55.288769', '9292', '', 12, 36, 197, 10, '2', 'Mr. Lorem ipsum4', 0, 'loremipsum4@yahoo.com', 'http://www.google.com', '6543210987', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.', 'http://www.facebook.com/name', 'http://www.twitter.com/name', 1, 'jl_marker4.png', '4_dubai world trade centre.jpg', 0, 1, 'https://www.youtube.com/watch?v=N72t6ij_BSc', 'https://vimeo.com/18014532', '', 'https://www.flickr.com/photos/rojo58/6857657248/in/photolist-x2pS6y-ksm6Q2-brZhzN', '', ''),
(5, 'M.C.G. Australia', 'Yarra Park, Melbourne, Victoria', '-37.7940597', '145.0103998', 1, '-37.82', '144.98333300000002', '8002', '', 13, 32, 183, 5, '1', '', 0, '', '', '', '', '', '', 1, 'jl_marker6.png', '5_m.c.g. australia.jpg', 1, 1, 'https://www.youtube.com/watch?v=91I3AnH0BDg', '', '', 'https://www.flickr.com/photos/jordan_in_alaska/5985814509/', '', ''),
(6, 'BMW Headquarters', 'Petuelring 124, M', '48.1764801', '11.5632549', 0, '', '', '80809', '', 14, 40, 201, 14, '2', '', 0, '', '', '', '', '', '', 1, 'jl_marker7.png', '6_bmw headquarters.jpg', 1, 1, 'https://www.youtube.com/watch?v=221NLl75MRI', 'https://vimeo.com/18200157', 'https://www.dailymotion.com/video/x2qdd82_bmw-tower-headquarters-with-the-bmw-welt-bmw-museum_aut', 'https://www.flickr.com/photos/asilikeit/6338915730/in/photolist-h4N7ub-aE5u5r-aE9ANw-diJofx-hzRxgP-aDU6w4-aDMrLK', '', ''),
(7, 'Otkrytie Arena Moscow', 'Volokolamskoye sh., ??????, Russia', '55.8256177', '37.4287902', 0, '', '', '69', '', 15, 37, 198, 11, '2', '', 0, '', '', '', 'Calle Pablo Usandizaga', '', '', 1, 'jl_marker8.png', '7_otkrytie arena moscow.jpeg', 0, 0, '', '', '', '', '', ''),
(8, 'Constitution Hill Johannesburg', '1 Kotze Street, Johannesburg,\n\n\n\n\n\n\n\nSouth Africa', '-26.1901', '28.04413', 0, '', '', '2001', '', 16, 39, 200, 13, '2', '', 0, '', '', '', '', '', '', 1, 'jl_marker9.png', '8_constitution hill johannesburg.jpg', 0, 1, 'https://www.youtube.com/watch?v=AzrX3Jbe0GA', '', 'http://www.dailymotion.com/video/x2pdg1i_constitution-hill-johannesburg-south-africa_travel', 'https://www.flickr.com/photos/lella_merani/5435493217/in/photolist-9hjjLi', '', ''),
(9, 'Googleplex California', '600 Amphitheatre Pkwy, Mountain View, United States', '37.4232059', '-122.2854036', 0, '', '', 'CA 94043', '',17, 41, 33, 2, '1', '', 0, '', '', '', '', '', '', 1, 'jl_marker10.png', '9_googleplex california.jpg', 1, 1, 'https://www.youtube.com/watch?v=8sOtjBDPQdU', '', 'https://www.dailymotion.com/video/x377ap1_googleplex-google-hq-in-california_fun', 'https://www.flickr.com/photos/lomokev/5027158873/', '', ''),
(10, 'Bombay Stock Exchange', 'Phiroze Jeejeebhoy Towers, Dalal Street, Kala Ghoda, Fort', '18.9294644', '72.8331099', 0, '', '', '400001', '',18, 1, 15, 1, '1', '', 0, '', '', '', '', '', '', 1, 'jsplocation_icon.png', '10_bombay stock exchange', 0, 1, 'https://www.youtube.com/watch?v=fKgr2xeU2eM', '', 'http://www.dailymotion.com/video/x23g6wb_bombay-stock-exchange-building-mumbai-maharashtra_travel', '', '', '');"
			);
			$db->query();
	}


	function getVersion(){
  	$params = &JComponentHelper::getParams( 'com_jsplocation' );
	$versionPresent = $params->get( 'version' );
	echo $versionPresent;
  	exit;
 	}

}
?>