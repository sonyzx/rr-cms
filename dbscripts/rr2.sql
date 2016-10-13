-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2016 at 11:28 PM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rr2`
--

-- --------------------------------------------------------

--
-- Table structure for table `awsconfig`
--

CREATE TABLE IF NOT EXISTS `awsconfig` (
  `secret` varchar(200) DEFAULT NULL,
  `key` varchar(200) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `awsconfig`
--

INSERT INTO `awsconfig` (`secret`, `key`, `region`) VALUES
('955jR.JtkU3lqaWJSaOiM1e2kuQqRaRvCkrhBDpxKkLbIO~HgGz2N38llBwMmImTOIJkqstMVm7QNg72ezFIs8qKBSMZRb.Sk7dM4uddLD.HeY3OUd2Av27GV6hNDiug', 'DzxFmP6g1hLFLw.CrT7vH~4lhIXWR~mEe6BcTC3biYAWaqWbVBkmXXOa0VVXLRkN~hIqfdVW7OMfJPKql9hx9g--', 'us-east-1');

-- --------------------------------------------------------

--
-- Table structure for table `block`
--

CREATE TABLE IF NOT EXISTS `block` (
`blockID` int(11) NOT NULL,
  `blockType` text CHARACTER SET utf8 COLLATE utf8_bin,
  `datecreate` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `block`
--

INSERT INTO `block` (`blockID`, `blockType`, `datecreate`) VALUES
(1, 'a:3:{s:2:"en";s:7:"Article";s:2:"es";s:9:"Artículo";s:2:"zh";s:6:"文章";}', 1441725208),
(2, 'a:3:{s:2:"en";s:13:"Image Gallery";s:2:"es";s:21:"Galería de Imágenes";s:2:"zh";s:9:"图片库";}', 1441725209),
(3, 'a:3:{s:2:"en";s:9:"Room List";s:2:"es";s:22:" Lista de Habitaciones";s:2:"zh";s:12:"房间列表";}', 1441725238),
(4, 'a:3:{s:2:"en";s:15:"Hotel Amenities";s:2:"es";s:19:"Servicios del Hotel";s:2:"zh";s:12:"酒店设施";}', 1441725250),
(5, 'a:3:{s:2:"en";s:3:"Map";s:2:"es";s:3:"Map";s:2:"zh";s:3:"Map";}', 1455181189);

-- --------------------------------------------------------

--
-- Table structure for table `bodypost`
--

CREATE TABLE IF NOT EXISTS `bodypost` (
`bodyID` int(11) NOT NULL,
  `postID` int(11) DEFAULT NULL,
  `bodyType` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `content` text,
  `orderbody` tinyint(7) DEFAULT '0',
  `position` char(7) DEFAULT NULL,
  `caption` text
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bodypost`
--

INSERT INTO `bodypost` (`bodyID`, `postID`, `bodyType`, `content`, `orderbody`, `position`, `caption`) VALUES
(222, 1, 'introtext', 'a:3:{s:2:"en";s:58:"<p><strong>Great Location, Service and Stays </strong></p>";s:2:"es";s:58:"<p><strong>Great Location, Service and Stays </strong></p>";s:2:"zh";s:58:"<p><strong>Great Location, Service and Stays </strong></p>";}', 0, NULL, NULL),
(223, 1, 'introtext', 'a:3:{s:2:"en";s:45:"<p>Homewood Suites. Make Yourself at Home</p>";s:2:"es";s:45:"<p>Homewood Suites. Make Yourself at Home</p>";s:2:"zh";s:45:"<p>Homewood Suites. Make Yourself at Home</p>";}', 0, NULL, NULL),
(224, 1, 'introtext', 'a:3:{s:2:"en";s:41:"<p>See what a difference a stay makes</p>";s:2:"es";s:41:"<p>See what a difference a stay makes</p>";s:2:"zh";s:41:"<p>See what a difference a stay makes</p>";}', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bucket`
--

CREATE TABLE IF NOT EXISTS `bucket` (
`bucketID` int(11) NOT NULL,
  `bucketName` varchar(55) DEFAULT NULL,
  `blockID` int(11) DEFAULT NULL,
  `datecreate` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bucket`
--

INSERT INTO `bucket` (`bucketID`, `bucketName`, `blockID`, `datecreate`) VALUES
(4, 'roomranger', 1, 1441808313);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `custom_room_amenities`
--

CREATE TABLE IF NOT EXISTS `custom_room_amenities` (
`id` int(11) NOT NULL,
  `hotelid` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `lang_id` varchar(3) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `amenity_group_id` int(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `globals`
--

CREATE TABLE IF NOT EXISTS `globals` (
`globalID` int(11) NOT NULL,
  `copyright` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `contactUs` text CHARACTER SET utf8,
  `email` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `postdate` datetime DEFAULT NULL,
  `titlesite` text CHARACTER SET utf8,
  `metadata` text CHARACTER SET utf8,
  `logo` text COLLATE utf8mb4_bin,
  `themes_color` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `introtext` text CHARACTER SET utf8 COLLATE utf8_bin,
  `latitude` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `longitude` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `globals`
--

INSERT INTO `globals` (`globalID`, `copyright`, `contactUs`, `email`, `userID`, `postdate`, `titlesite`, `metadata`, `logo`, `themes_color`, `introtext`, `latitude`, `longitude`) VALUES
(1, 'Reservation', 'a:6:{s:2:"id";s:10:"Contact Us";s:2:"en";s:28:"+51 84 232233  +51 84 260502";s:2:"du";s:14:"Contacteer ons";s:2:"fr";s:14:"Contactez nous";s:2:"es";s:10:"Contact Us";s:2:"zh";s:10:"Contact Us";}', 'wahyu@javathemes.com', 1, '0000-00-00 00:00:00', 'a:5:{s:2:"en";s:15:"Hotel CoriHuasi";s:2:"fr";s:524:"Alors que le tableau de données de session dans le cookie de lutilisateur contient un ID de session, à moins que vous stockez des données de session dans une base de données, il est impossible de le valider. Pour certaines applications qui nécessitent peu ou pas de sécurité, la validation dID de session peut ne pas être nécessaire, mais si votre application nécessite la sécurité, la validation est obligatoire. Sinon, une ancienne session pourrait être rétablie par un utilisateur de modifier leurs cookies.";s:2:"du";s:448:"Terwijl de sessie data-array opgeslagen in de cookie van de gebruiker bevat een sessie-ID, tenzij je sessie gegevens op te slaan in een database is er geen manier om het te valideren. Voor sommige toepassingen die weinig of geen beveiliging nodig hebben, kunnen sessie-ID validatie niet nodig, maar als uw toepassing vereist veiligheid, validatie is verplicht. Anders zou een oude sessie hersteld worden door een gebruiker wijzigen van hun cookies.";s:2:"es";s:16:"Hostel CoriHuasi";s:2:"zh";s:18:"预订门户网站";}', 'a:5:{s:2:"en";s:115:"Instant hotel-style reservations for vacation homes and apartments Over 31,000 properties in 1,000s of destinations";s:2:"fr";s:524:"Alors que le tableau de données de session dans le cookie de lutilisateur contient un ID de session, à moins que vous stockez des données de session dans une base de données, il est impossible de le valider. Pour certaines applications qui nécessitent peu ou pas de sécurité, la validation dID de session peut ne pas être nécessaire, mais si votre application nécessite la sécurité, la validation est obligatoire. Sinon, une ancienne session pourrait être rétablie par un utilisateur de modifier leurs cookies.";s:2:"du";s:448:"Terwijl de sessie data-array opgeslagen in de cookie van de gebruiker bevat een sessie-ID, tenzij je sessie gegevens op te slaan in een database is er geen manier om het te valideren. Voor sommige toepassingen die weinig of geen beveiliging nodig hebben, kunnen sessie-ID validatie niet nodig, maar als uw toepassing vereist veiligheid, validatie is verplicht. Anders zou een oude sessie hersteld worden door een gebruiker wijzigen van hun cookies.";s:2:"es";s:400:"While the session data array stored in the users cookie contains a Session ID, unless you store session data in a database there is no way to validate it. For some applications that require little or no security, session ID validation may not be needed, but if your application requires security, validation is mandatory. Otherwise, an old session could be restored by a user modifying their cookies.";s:2:"zh";s:400:"While the session data array stored in the users cookie contains a Session ID, unless you store session data in a database there is no way to validate it. For some applications that require little or no security, session ID validation may not be needed, but if your application requires security, validation is mandatory. Otherwise, an old session could be restored by a user modifying their cookies.";}', 'a:15:{s:9:"file_name";s:36:"d88c99104ea5a9577b3432484c41836b.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/d88c99104ea5a9577b3432484c41836b.jpg";s:8:"raw_name";s:32:"d88c99104ea5a9577b3432484c41836b";s:9:"orig_name";s:9:"logo2.jpg";s:11:"client_name";s:9:"logo2.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:124.6400000000000005684341886080801486968994140625;s:8:"is_image";b:1;s:11:"image_width";i:1200;s:12:"image_height";i:877;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:25:"width="1200" height="877"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/d88c99104ea5a9577b3432484c41836b_thumb.jpg";}', 'green', 'a:3:{s:2:"en";s:69:"Located in Cusco the city that reflect Latin America with full force.";s:2:"es";s:78:"Situado en la ciudad de Cusco que reflejan América Latina con toda su fuerza.";s:2:"zh";s:53:"At The Heart Of Lowcountry Style, Culture and Cuisine";}', '-13.5143326', '-71.9804478');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE IF NOT EXISTS `hotel` (
`hotelid` int(11) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `hotelname` varchar(100) DEFAULT NULL,
  `business_name` varchar(100) DEFAULT NULL,
  `business_number` varchar(50) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `street2` varchar(100) DEFAULT NULL,
  `suburb` varchar(100) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postcode` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `short_description` text CHARACTER SET utf8,
  `main_description` longtext CHARACTER SET utf8,
  `stars` decimal(1,0) DEFAULT NULL,
  `phone1` varchar(20) DEFAULT NULL,
  `phone2` varchar(20) DEFAULT NULL,
  `email1` varchar(256) DEFAULT NULL,
  `email2` varchar(256) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `total_rooms_active` int(11) NOT NULL DEFAULT '0',
  `logo` text,
  `feature_image` text,
  `longitude` float(11,8) DEFAULT NULL,
  `latitude` float(11,8) DEFAULT NULL,
  `rooms_total` int(11) NOT NULL DEFAULT '0',
  `timezone` varchar(50) NOT NULL,
  `roomratestructure` int(4) NOT NULL DEFAULT '1',
  `deposit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `currency_id` int(4) NOT NULL DEFAULT '1',
  `date_created` int(11) DEFAULT '0',
  `userID` int(11) DEFAULT NULL,
  `act_delete` tinyint(2) DEFAULT '0',
  `payment_gateway` varchar(100) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`hotelid`, `slug`, `owner_id`, `hotelname`, `business_name`, `business_number`, `street`, `street2`, `suburb`, `state`, `postcode`, `country`, `short_description`, `main_description`, `stars`, `phone1`, `phone2`, `email1`, `email2`, `fax`, `total_rooms_active`, `logo`, `feature_image`, `longitude`, `latitude`, `rooms_total`, `timezone`, `roomratestructure`, `deposit`, `currency_id`, `date_created`, `userID`, `act_delete`, `payment_gateway`) VALUES
(6, 'villa-zorada', 1, 'Villa Zorada', 'Visa', '12121231', 'oke', 'oye', NULL, 'New York', '542221', 'United States', 'a:3:{s:2:"en";s:273:"<p>pemstrongLorem ipsum dolor sit amet, labitur phaedrum cum ex, vix eu ceteros signiferumque. Ei has quando vocent impetus, no est assueverit inciderint. Eum in euismod recteque. Cibo nemore inimicus ex eam. Saperet percipitur ei has, vim officiis lucilius atstrongemp</p>";s:2:"es";s:266:"pemstrongLorem ipsum dolor sit amet, labitur phaedrum cum ex, vix eu ceteros signiferumque. Ei has quando vocent impetus, no est assueverit inciderint. Eum in euismod recteque. Cibo nemore inimicus ex eam. Saperet percipitur ei has, vim officiis lucilius atstrongemp";s:2:"zh";s:266:"pemstrongLorem ipsum dolor sit amet, labitur phaedrum cum ex, vix eu ceteros signiferumque. Ei has quando vocent impetus, no est assueverit inciderint. Eum in euismod recteque. Cibo nemore inimicus ex eam. Saperet percipitur ei has, vim officiis lucilius atstrongemp";}', 'a:3:{s:2:"en";s:275:"<p>ppemstrongLorem ipsum dolor sit amet, labitur phaedrum cum ex, vix eu ceteros signiferumque. Ei has quando vocent impetus, no est assueverit inciderint. Eum in euismod recteque. Cibo nemore inimicus ex eam. Saperet percipitur ei has, vim officiis lucilius atstrongempp</p>";s:2:"es";s:266:"pemstrongLorem ipsum dolor sit amet, labitur phaedrum cum ex, vix eu ceteros signiferumque. Ei has quando vocent impetus, no est assueverit inciderint. Eum in euismod recteque. Cibo nemore inimicus ex eam. Saperet percipitur ei has, vim officiis lucilius atstrongemp";s:2:"zh";s:266:"pemstrongLorem ipsum dolor sit amet, labitur phaedrum cum ex, vix eu ceteros signiferumque. Ei has quando vocent impetus, no est assueverit inciderint. Eum in euismod recteque. Cibo nemore inimicus ex eam. Saperet percipitur ei has, vim officiis lucilius atstrongemp";}', '7', '087912112', '', 'wahyusoft@yahoo.com', '', '23', 11, '', '', -74.01166534, 40.70869827, 22, 'Beijing', 1, '45.00', 1, 1441946726, 1, 0, '2checkout'),
(8, 'modern-blue-jay-estate', 1, 'Modern Blue Jay Estate', 'Test Business Name', 'Test Number', 'California S', '', NULL, 'New York', '66782', 'United States', 'a:3:{s:2:"en";s:239:"<p><strong>Sitting</strong> at the crest of the hills in the prestigious Bird Streets area, our Modern Blue Jay Estate boasts over 10,000 sq ft of living space, 4 bedrooms6 bathrooms, and has Breathtaking views of downtown Los Angeles.</p>";s:2:"es";s:216:"Sitting at the crest of the hills in the prestigious Bird Streets area, our Modern Blue Jay Estate boasts over 10,000 sq ft of living space, 4 bedrooms6 bathrooms, and has Breathtaking views of downtown Los Angeles. ";s:2:"zh";s:216:"Sitting at the crest of the hills in the prestigious Bird Streets area, our Modern Blue Jay Estate boasts over 10,000 sq ft of living space, 4 bedrooms6 bathrooms, and has Breathtaking views of downtown Los Angeles. ";}', 'a:3:{s:2:"en";s:1981:"<p>Sitting at the crest of the hills in the prestigious Bird Streets area, our Modern Blue Jay Estate boasts over 10,000 sq ft of living space, 4 bedrooms6 bathrooms, and has Breathtaking views of downtown Los Angeles. This estate was made to entertain with two separate recreationlounge areas, both with their own billiards table, and a club level complete with DJ booth, full wet bar, and a state of the art lighting and audio system. If thats not enough, there also is a large fitness room, and theater room with seating room for over 20 people.br  br  The estate also has unique features including a smart house system that controls lighting, audio, and window shades, a glass floor that looks into the wine cellar, and an underwater window that peers into the pool from the recreation room on the lower level. Every single bedroom has a view of the city with shared wrap around balconies.br  br  The master bedroom has custom setting for various moods combining window shades, lights, and audio levels. The master bathroom has his and her sinks, a large two person shower and a two person Jacuzzi tub in the middle of the bathroom that overlooks the views of the city. There is also a wrap around master closet in the bathroom.br  br  The main level of the estate has a spacious kitchen with stainless steel appliances and custom lighting install around the outline of the kitchen. Next to the kitchen towards the back of the house is a TV viewing area. The opposite side of this floor includes a lounge area next to the kitchen, large dining room area, and finally the second recreation area surrounded with couches for seating up to 20, a billiards table in the center of the room, and an outdoor terrace that overlooks the views of the city.br  br  The location of the estate is just over a 5 minute drive from the Sunset Blvd. and Sunset Plaza Dr. intersection putting guests within a 10 minute drive to grocery store, restaurants, <strong>shopping, and banks</strong></p>";s:2:"es";s:1959:"pSitting at the crest of the hills in the prestigious Bird Streets area, our Modern Blue Jay Estate boasts over 10,000 sq ft of living space, 4 bedrooms6 bathrooms, and has Breathtaking views of downtown Los Angeles. This estate was made to entertain with two separate recreationlounge areas, both with their own billiards table, and a club level complete with DJ booth, full wet bar, and a state of the art lighting and audio system. If thats not enough, there also is a large fitness room, and theater room with seating room for over 20 people.br  br  The estate also has unique features including a smart house system that controls lighting, audio, and window shades, a glass floor that looks into the wine cellar, and an underwater window that peers into the pool from the recreation room on the lower level. Every single bedroom has a view of the city with shared wrap around balconies.br  br  The master bedroom has custom setting for various moods combining window shades, lights, and audio levels. The master bathroom has his and her sinks, a large two person shower and a two person Jacuzzi tub in the middle of the bathroom that overlooks the views of the city. There is also a wrap around master closet in the bathroom.br  br  The main level of the estate has a spacious kitchen with stainless steel appliances and custom lighting install around the outline of the kitchen. Next to the kitchen towards the back of the house is a TV viewing area. The opposite side of this floor includes a lounge area next to the kitchen, large dining room area, and finally the second recreation area surrounded with couches for seating up to 20, a billiards table in the center of the room, and an outdoor terrace that overlooks the views of the city.br  br  The location of the estate is just over a 5 minute drive from the Sunset Blvd. and Sunset Plaza Dr. intersection putting guests within a 10 minute drive to grocery store, restaurants, shopping, and banksp";s:2:"zh";s:1959:"pSitting at the crest of the hills in the prestigious Bird Streets area, our Modern Blue Jay Estate boasts over 10,000 sq ft of living space, 4 bedrooms6 bathrooms, and has Breathtaking views of downtown Los Angeles. This estate was made to entertain with two separate recreationlounge areas, both with their own billiards table, and a club level complete with DJ booth, full wet bar, and a state of the art lighting and audio system. If thats not enough, there also is a large fitness room, and theater room with seating room for over 20 people.br  br  The estate also has unique features including a smart house system that controls lighting, audio, and window shades, a glass floor that looks into the wine cellar, and an underwater window that peers into the pool from the recreation room on the lower level. Every single bedroom has a view of the city with shared wrap around balconies.br  br  The master bedroom has custom setting for various moods combining window shades, lights, and audio levels. The master bathroom has his and her sinks, a large two person shower and a two person Jacuzzi tub in the middle of the bathroom that overlooks the views of the city. There is also a wrap around master closet in the bathroom.br  br  The main level of the estate has a spacious kitchen with stainless steel appliances and custom lighting install around the outline of the kitchen. Next to the kitchen towards the back of the house is a TV viewing area. The opposite side of this floor includes a lounge area next to the kitchen, large dining room area, and finally the second recreation area surrounded with couches for seating up to 20, a billiards table in the center of the room, and an outdoor terrace that overlooks the views of the city.br  br  The location of the estate is just over a 5 minute drive from the Sunset Blvd. and Sunset Plaza Dr. intersection putting guests within a 10 minute drive to grocery store, restaurants, shopping, and banksp";}', '8', '087912112', '', 'wahyusoft@yahoo.com', '', '', 47, 'a:15:{s:9:"file_name";s:36:"8547b85bf7a96fd6464433a8e4d20ef5.png";s:9:"file_type";s:9:"image/png";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/8547b85bf7a96fd6464433a8e4d20ef5.png";s:8:"raw_name";s:32:"8547b85bf7a96fd6464433a8e4d20ef5";s:9:"orig_name";s:9:"logo1.png";s:11:"client_name";s:9:"logo1.png";s:8:"file_ext";s:4:".png";s:9:"file_size";d:122.8599999999999994315658113919198513031005859375;s:8:"is_image";b:1;s:11:"image_width";i:1500;s:12:"image_height";i:656;s:10:"image_type";s:3:"png";s:14:"image_size_str";s:25:"width="1500" height="656"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/8547b85bf7a96fd6464433a8e4d20ef5_thumb.png";}', 'a:15:{s:9:"file_name";s:36:"d295940208336a01579ce18739d9a11c.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/d295940208336a01579ce18739d9a11c.jpg";s:8:"raw_name";s:32:"d295940208336a01579ce18739d9a11c";s:9:"orig_name";s:13:"featureH2.jpg";s:11:"client_name";s:13:"featureH2.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:990.2100000000000363797880709171295166015625;s:8:"is_image";b:1;s:11:"image_width";i:1181;s:12:"image_height";i:784;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:25:"width="1181" height="784"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/d295940208336a01579ce18739d9a11c_thumb.jpg";}', -74.01166534, 40.70869827, 3, 'Tz', 1, '345.00', 1, 1442329510, 2, 0, 'payum'),
(10, 'oceanfront-celebrity', 1, 'Oceanfront Celebrity', 'Test Business Name', 'Test Number', 'California S', '', NULL, 'New York', '542221', 'United States', 'a:3:{s:2:"en";s:145:"<p>This 6bed5bath celebrity styled home is on Malibus pristine shore on the one the most spectacular private beaches in all of California. Aa</p>";s:2:"es";s:138:"This 6bed5bath celebrity styled home is on Malibus pristine shore on the one the most spectacular private beaches in all of California. Aa";s:2:"zh";s:138:"This 6bed5bath celebrity styled home is on Malibus pristine shore on the one the most spectacular private beaches in all of California. Aa";}', 'a:3:{s:2:"en";s:1946:"<p>pThis 6bed5bath celebrity styled home is on Malibus pristine shore on the one the most spectacular private beaches in all of California.br  br  Located on the sandy beaches of Malibu, this modern 3 story home has something to offer for everyone. With breathtaking 180 degree views of the Pacific Ocean, you can walk right down to the sand on your private staircase and later enjoy the beautiful sunset on any of your 3 balconies. This contemporary home features a main house with 4 bedrooms 3.5 baths and a guest house with 2 bedrooms1 bath. The main house has 3 levels all with end to end glass windows for amazing ocean views. With top of the line appliances in the kitchen and the finest bedding you will enjoy a peaceful sleep with the ocean waves sweeping under you. All 3 levels also have private balconies for soaking up the sun during the day and romantic sunsets at night.br  br  The guest house has 2 bedrooms 1 bath with a full kitchen, washer dryer and is attached to the main house with a separate entrance. There is an attached 3 car garage with room for up to 4 additional parking spaces in front of the garage and even more available close by street parking.br  br  An important amazing feature about this house, is that its off the highway so it is completely safe for children.br  br  Located directly across the street is the famous Mediterranean restaurant BeauRivage which has been featured in many fine dining magazines. Also located across the street is beautiful hiking with multiple trails to choose from to fit everyones needs.br  br  Less than a mile down the street is a shopping area that has a Starbucks, CVS, grocery shopping, restaurants and cafes, as well as retail shopping.br  br  Whether you are looking for a romantic week to share with a loved one, a fun-filled family vacation, or sunny get-a-way with a group of friends, this home is just what you need to enjoy the best of what Malibu has to offerp</p>";s:2:"es";s:1939:"pThis 6bed5bath celebrity styled home is on Malibus pristine shore on the one the most spectacular private beaches in all of California.br  br  Located on the sandy beaches of Malibu, this modern 3 story home has something to offer for everyone. With breathtaking 180 degree views of the Pacific Ocean, you can walk right down to the sand on your private staircase and later enjoy the beautiful sunset on any of your 3 balconies. This contemporary home features a main house with 4 bedrooms 3.5 baths and a guest house with 2 bedrooms1 bath. The main house has 3 levels all with end to end glass windows for amazing ocean views. With top of the line appliances in the kitchen and the finest bedding you will enjoy a peaceful sleep with the ocean waves sweeping under you. All 3 levels also have private balconies for soaking up the sun during the day and romantic sunsets at night.br  br  The guest house has 2 bedrooms 1 bath with a full kitchen, washer dryer and is attached to the main house with a separate entrance. There is an attached 3 car garage with room for up to 4 additional parking spaces in front of the garage and even more available close by street parking.br  br  An important amazing feature about this house, is that its off the highway so it is completely safe for children.br  br  Located directly across the street is the famous Mediterranean restaurant BeauRivage which has been featured in many fine dining magazines. Also located across the street is beautiful hiking with multiple trails to choose from to fit everyones needs.br  br  Less than a mile down the street is a shopping area that has a Starbucks, CVS, grocery shopping, restaurants and cafes, as well as retail shopping.br  br  Whether you are looking for a romantic week to share with a loved one, a fun-filled family vacation, or sunny get-a-way with a group of friends, this home is just what you need to enjoy the best of what Malibu has to offerp";s:2:"zh";s:1939:"pThis 6bed5bath celebrity styled home is on Malibus pristine shore on the one the most spectacular private beaches in all of California.br  br  Located on the sandy beaches of Malibu, this modern 3 story home has something to offer for everyone. With breathtaking 180 degree views of the Pacific Ocean, you can walk right down to the sand on your private staircase and later enjoy the beautiful sunset on any of your 3 balconies. This contemporary home features a main house with 4 bedrooms 3.5 baths and a guest house with 2 bedrooms1 bath. The main house has 3 levels all with end to end glass windows for amazing ocean views. With top of the line appliances in the kitchen and the finest bedding you will enjoy a peaceful sleep with the ocean waves sweeping under you. All 3 levels also have private balconies for soaking up the sun during the day and romantic sunsets at night.br  br  The guest house has 2 bedrooms 1 bath with a full kitchen, washer dryer and is attached to the main house with a separate entrance. There is an attached 3 car garage with room for up to 4 additional parking spaces in front of the garage and even more available close by street parking.br  br  An important amazing feature about this house, is that its off the highway so it is completely safe for children.br  br  Located directly across the street is the famous Mediterranean restaurant BeauRivage which has been featured in many fine dining magazines. Also located across the street is beautiful hiking with multiple trails to choose from to fit everyones needs.br  br  Less than a mile down the street is a shopping area that has a Starbucks, CVS, grocery shopping, restaurants and cafes, as well as retail shopping.br  br  Whether you are looking for a romantic week to share with a loved one, a fun-filled family vacation, or sunny get-a-way with a group of friends, this home is just what you need to enjoy the best of what Malibu has to offerp";}', '0', '087912112', '', 'wahyusoft@yahoo.com', '', '', 34, 'a:15:{s:9:"file_name";s:36:"b54e72b6bac369a8b972e14218ae842a.png";s:9:"file_type";s:9:"image/png";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/b54e72b6bac369a8b972e14218ae842a.png";s:8:"raw_name";s:32:"b54e72b6bac369a8b972e14218ae842a";s:9:"orig_name";s:9:"logo1.png";s:11:"client_name";s:9:"logo1.png";s:8:"file_ext";s:4:".png";s:9:"file_size";d:122.8599999999999994315658113919198513031005859375;s:8:"is_image";b:1;s:11:"image_width";i:1500;s:12:"image_height";i:656;s:10:"image_type";s:3:"png";s:14:"image_size_str";s:25:"width="1500" height="656"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/b54e72b6bac369a8b972e14218ae842a_thumb.png";}', 'a:15:{s:9:"file_name";s:36:"6acc7c0e9444e8fb54b100d0faa5e14d.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/6acc7c0e9444e8fb54b100d0faa5e14d.jpg";s:8:"raw_name";s:32:"6acc7c0e9444e8fb54b100d0faa5e14d";s:9:"orig_name";s:13:"featureH1.jpg";s:11:"client_name";s:13:"featureH1.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:245.210000000000007958078640513122081756591796875;s:8:"is_image";b:1;s:11:"image_width";i:1920;s:12:"image_height";i:1080;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:26:"width="1920" height="1080"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/6acc7c0e9444e8fb54b100d0faa5e14d_thumb.jpg";}', -74.01166534, 40.70869827, 45, 'us', 1, '445.00', 1, 1442329916, 1, 0, '2checkout');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
`imagesID` int(11) NOT NULL,
  `typeassets` varchar(50) DEFAULT NULL,
  `imagesFile` text CHARACTER SET utf8,
  `imagesCaption` text CHARACTER SET utf8,
  `postDate` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `imagesDescription` text CHARACTER SET utf8
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`imagesID`, `typeassets`, `imagesFile`, `imagesCaption`, `postDate`, `userID`, `imagesDescription`) VALUES
(1, 'siteassets', 'a:15:{s:9:"file_name";s:36:"f06c35a47e4309ceabe3d1af86f0bc3b.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/f06c35a47e4309ceabe3d1af86f0bc3b.jpg";s:8:"raw_name";s:32:"f06c35a47e4309ceabe3d1af86f0bc3b";s:9:"orig_name";s:13:"featureH1.jpg";s:11:"client_name";s:13:"featureH1.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:245.210000000000007958078640513122081756591796875;s:8:"is_image";b:1;s:11:"image_width";i:1920;s:12:"image_height";i:1080;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:26:"width="1920" height="1080"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/f06c35a47e4309ceabe3d1af86f0bc3b_thumb.jpg";}', 'a:3:{s:2:"en";s:6:"test 1";s:2:"es";s:6:"test 1";s:2:"zh";s:6:"test 1";}', 1454099809, 1, 'a:3:{s:2:"en";s:13:"lorem ipsum 3";s:2:"es";s:13:"lorem ipsum 3";s:2:"zh";s:13:"lorem ipsum 3";}'),
(2, 'siteassets', 'a:15:{s:9:"file_name";s:36:"61e75a408590df31ef674b8e08d0f77e.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/61e75a408590df31ef674b8e08d0f77e.jpg";s:8:"raw_name";s:32:"61e75a408590df31ef674b8e08d0f77e";s:9:"orig_name";s:13:"featureH2.jpg";s:11:"client_name";s:13:"featureH2.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:990.2100000000000363797880709171295166015625;s:8:"is_image";b:1;s:11:"image_width";i:1181;s:12:"image_height";i:784;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:25:"width="1181" height="784"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/61e75a408590df31ef674b8e08d0f77e_thumb.jpg";}', 'a:3:{s:2:"en";s:6:"test 2";s:2:"es";s:6:"test 2";s:2:"zh";s:6:"test 2";}', 1454099816, 1, 'a:3:{s:2:"en";s:13:"lorem ipsum 2";s:2:"es";s:13:"lorem ipsum 2";s:2:"zh";s:13:"lorem ipsum 2";}'),
(3, 'siteassets', 'a:15:{s:9:"file_name";s:36:"c1e2ccfcb4ee2e4a22f0c646a30b5302.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/c1e2ccfcb4ee2e4a22f0c646a30b5302.jpg";s:8:"raw_name";s:32:"c1e2ccfcb4ee2e4a22f0c646a30b5302";s:9:"orig_name";s:11:"unduhan.jpg";s:11:"client_name";s:11:"unduhan.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:10.6099999999999994315658113919198513031005859375;s:8:"is_image";b:1;s:11:"image_width";i:249;s:12:"image_height";i:188;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="249" height="188"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/c1e2ccfcb4ee2e4a22f0c646a30b5302_thumb.jpg";}', 'a:3:{s:2:"en";s:6:"Test 3";s:2:"es";s:6:"Test 3";s:2:"zh";s:6:"Test 3";}', 1454099823, 1, 'a:3:{s:2:"en";s:13:"lorem ipsum 3";s:2:"es";s:13:"lorem ipsum 3";s:2:"zh";s:13:"lorem ipsum 3";}'),
(4, 'siteassets', 'a:15:{s:9:"file_name";s:36:"964f0365fd2ae68ca3ea01e19d0ecb91.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:40:"D:/XAMPP/htdocs/hostelcorihuasi/uploads/";s:9:"full_path";s:76:"D:/XAMPP/htdocs/hostelcorihuasi/uploads/964f0365fd2ae68ca3ea01e19d0ecb91.jpg";s:8:"raw_name";s:32:"964f0365fd2ae68ca3ea01e19d0ecb91";s:9:"orig_name";s:6:"b1.jpg";s:11:"client_name";s:6:"b1.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:94.68999999999999772626324556767940521240234375;s:8:"is_image";b:1;s:11:"image_width";i:799;s:12:"image_height";i:533;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="799" height="533"";s:5:"thumb";s:82:"D:/XAMPP/htdocs/hostelcorihuasi/uploads/964f0365fd2ae68ca3ea01e19d0ecb91_thumb.jpg";}', 'a:3:{s:2:"en";s:6:"temple";s:2:"es";s:6:"temple";s:2:"zh";s:6:"temple";}', 1455243420, 1, 'a:3:{s:2:"en";s:0:"";s:2:"es";s:0:"";s:2:"zh";s:0:"";}'),
(6, 'about', 'a:15:{s:9:"file_name";s:36:"8e99f21928723dd956ca4e26347f6100.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/8e99f21928723dd956ca4e26347f6100.jpg";s:8:"raw_name";s:32:"8e99f21928723dd956ca4e26347f6100";s:9:"orig_name";s:7:"b10.jpg";s:11:"client_name";s:7:"b10.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:111.969999999999998863131622783839702606201171875;s:8:"is_image";b:1;s:11:"image_width";i:800;s:12:"image_height";i:943;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="800" height="943"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/8e99f21928723dd956ca4e26347f6100_thumb.jpg";}', '', 1455578683, 1, ''),
(8, 'about', 'a:15:{s:9:"file_name";s:36:"e3288847ecc8af0317287dca93d09fa4.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/e3288847ecc8af0317287dca93d09fa4.jpg";s:8:"raw_name";s:32:"e3288847ecc8af0317287dca93d09fa4";s:9:"orig_name";s:7:"b11.jpg";s:11:"client_name";s:7:"b11.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:128.009999999999990905052982270717620849609375;s:8:"is_image";b:1;s:11:"image_width";i:800;s:12:"image_height";i:561;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="800" height="561"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/e3288847ecc8af0317287dca93d09fa4_thumb.jpg";}', '', 1455578693, 1, ''),
(9, 'about', 'a:15:{s:9:"file_name";s:36:"c827518b696b27b7e4efcf3d84d8dd52.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/c827518b696b27b7e4efcf3d84d8dd52.jpg";s:8:"raw_name";s:32:"c827518b696b27b7e4efcf3d84d8dd52";s:9:"orig_name";s:7:"b12.jpg";s:11:"client_name";s:7:"b12.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:74.849999999999994315658113919198513031005859375;s:8:"is_image";b:1;s:11:"image_width";i:800;s:12:"image_height";i:531;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="800" height="531"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/c827518b696b27b7e4efcf3d84d8dd52_thumb.jpg";}', '', 1455579302, 1, ''),
(12, 'location', 'a:15:{s:9:"file_name";s:36:"8c72b0143dc19bf00f91c1297b859ecc.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/8c72b0143dc19bf00f91c1297b859ecc.jpg";s:8:"raw_name";s:32:"8c72b0143dc19bf00f91c1297b859ecc";s:9:"orig_name";s:6:"a1.jpg";s:11:"client_name";s:6:"a1.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:26.030000000000001136868377216160297393798828125;s:8:"is_image";b:1;s:11:"image_width";i:399;s:12:"image_height";i:266;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="399" height="266"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/8c72b0143dc19bf00f91c1297b859ecc_thumb.jpg";}', '', 1455587546, 1, ''),
(13, 'location', 'a:15:{s:9:"file_name";s:36:"fb368f2ad5175f166f458a49229efeaf.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/fb368f2ad5175f166f458a49229efeaf.jpg";s:8:"raw_name";s:32:"fb368f2ad5175f166f458a49229efeaf";s:9:"orig_name";s:6:"a6.jpg";s:11:"client_name";s:6:"a6.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:37.38000000000000255795384873636066913604736328125;s:8:"is_image";b:1;s:11:"image_width";i:399;s:12:"image_height";i:266;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="399" height="266"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/fb368f2ad5175f166f458a49229efeaf_thumb.jpg";}', '', 1455587555, 1, ''),
(14, 'siteassets', 'a:15:{s:9:"file_name";s:36:"ba199c4bec1a60fe3257769085c8000a.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/ba199c4bec1a60fe3257769085c8000a.jpg";s:8:"raw_name";s:32:"ba199c4bec1a60fe3257769085c8000a";s:9:"orig_name";s:6:"b3.jpg";s:11:"client_name";s:6:"b3.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:54.28999999999999914734871708787977695465087890625;s:8:"is_image";b:1;s:11:"image_width";i:800;s:12:"image_height";i:453;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="800" height="453"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/ba199c4bec1a60fe3257769085c8000a_thumb.jpg";}', 'a:3:{s:2:"en";s:4:"Test";s:2:"es";s:4:"Test";s:2:"zh";s:4:"Test";}', 1455612677, 1, 'a:3:{s:2:"en";s:4:"Okay";s:2:"es";s:4:"Okay";s:2:"zh";s:4:"Okay";}'),
(15, 'siteassets', 'a:15:{s:9:"file_name";s:36:"e128eb4702dcb05fb510d4d87638cb64.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/e128eb4702dcb05fb510d4d87638cb64.jpg";s:8:"raw_name";s:32:"e128eb4702dcb05fb510d4d87638cb64";s:9:"orig_name";s:6:"d8.jpg";s:11:"client_name";s:6:"d8.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:57.659999999999996589394868351519107818603515625;s:8:"is_image";b:1;s:11:"image_width";i:800;s:12:"image_height";i:531;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="800" height="531"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/e128eb4702dcb05fb510d4d87638cb64_thumb.jpg";}', 'a:3:{s:2:"en";s:11:"First Slide";s:2:"es";s:11:"First Slide";s:2:"zh";s:11:"First Slide";}', 1455613261, 1, 'a:3:{s:2:"en";s:394:"Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.  nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.";s:2:"es";s:394:"Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.  nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.";s:2:"zh";s:394:"Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.  nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.";}'),
(16, 'siteassets', 'a:15:{s:9:"file_name";s:36:"494adc653e0770fa9636b7e65555503c.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/494adc653e0770fa9636b7e65555503c.jpg";s:8:"raw_name";s:32:"494adc653e0770fa9636b7e65555503c";s:9:"orig_name";s:6:"ha.jpg";s:11:"client_name";s:6:"ha.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:80.1700000000000017053025658242404460906982421875;s:8:"is_image";b:1;s:11:"image_width";i:800;s:12:"image_height";i:591;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="800" height="591"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/494adc653e0770fa9636b7e65555503c_thumb.jpg";}', 'a:3:{s:2:"en";s:11:"First Slide";s:2:"es";s:11:"First Slide";s:2:"zh";s:11:"First Slide";}', 1455613367, 1, 'a:3:{s:2:"en";s:394:"Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.  nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.";s:2:"es";s:394:"Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.  nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.";s:2:"zh";s:394:"Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.  nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.";}'),
(17, 'siteassets', 'a:15:{s:9:"file_name";s:36:"f972cf4f8647dd07f04c005f1be5c9aa.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/f972cf4f8647dd07f04c005f1be5c9aa.jpg";s:8:"raw_name";s:32:"f972cf4f8647dd07f04c005f1be5c9aa";s:9:"orig_name";s:6:"b7.jpg";s:11:"client_name";s:6:"b7.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:70.7000000000000028421709430404007434844970703125;s:8:"is_image";b:1;s:11:"image_width";i:800;s:12:"image_height";i:531;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="800" height="531"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/f972cf4f8647dd07f04c005f1be5c9aa_thumb.jpg";}', 'a:3:{s:2:"en";s:4:"test";s:2:"es";s:4:"test";s:2:"zh";s:4:"test";}', 1455613834, 1, 'a:3:{s:2:"en";s:3:"one";s:2:"es";s:3:"one";s:2:"zh";s:3:"one";}'),
(21, 'services', 'a:15:{s:9:"file_name";s:36:"7235233086e6138a9370b3ac9d53035c.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/7235233086e6138a9370b3ac9d53035c.jpg";s:8:"raw_name";s:32:"7235233086e6138a9370b3ac9d53035c";s:9:"orig_name";s:6:"d1.jpg";s:11:"client_name";s:6:"d1.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:64.900000000000005684341886080801486968994140625;s:8:"is_image";b:1;s:11:"image_width";i:800;s:12:"image_height";i:550;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="800" height="550"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/7235233086e6138a9370b3ac9d53035c_thumb.jpg";}', 'a:3:{s:2:"en";s:12:"Second Slide";s:2:"es";s:12:"Second Slide";s:2:"zh";s:12:"Second Slide";}', 1455617564, 1, 'a:3:{s:2:"en";s:394:"Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.  nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.";s:2:"es";s:394:"Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.  nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.";s:2:"zh";s:394:"Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.  nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.";}'),
(22, 'services', 'a:15:{s:9:"file_name";s:36:"283c22433b85011e182ace26aee9fb82.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/283c22433b85011e182ace26aee9fb82.jpg";s:8:"raw_name";s:32:"283c22433b85011e182ace26aee9fb82";s:9:"orig_name";s:6:"ha.jpg";s:11:"client_name";s:6:"ha.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:80.1700000000000017053025658242404460906982421875;s:8:"is_image";b:1;s:11:"image_width";i:800;s:12:"image_height";i:591;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="800" height="591"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/283c22433b85011e182ace26aee9fb82_thumb.jpg";}', 'a:3:{s:2:"en";s:11:"First Slide";s:2:"es";s:11:"First Slide";s:2:"zh";s:11:"First Slide";}', 1455617576, 1, 'a:3:{s:2:"en";s:394:"Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.  nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.";s:2:"es";s:394:"Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.  nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.";s:2:"zh";s:394:"Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.  nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.";}'),
(23, 'facilities', 'a:15:{s:9:"file_name";s:36:"7f8947140d4af24b293e7a74fb05accc.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/7f8947140d4af24b293e7a74fb05accc.jpg";s:8:"raw_name";s:32:"7f8947140d4af24b293e7a74fb05accc";s:9:"orig_name";s:6:"a6.jpg";s:11:"client_name";s:6:"a6.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:37.38000000000000255795384873636066913604736328125;s:8:"is_image";b:1;s:11:"image_width";i:399;s:12:"image_height";i:266;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="399" height="266"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/7f8947140d4af24b293e7a74fb05accc_thumb.jpg";}', '', 1455663965, 1, ''),
(24, 'facilities', 'a:15:{s:9:"file_name";s:36:"b07bc23f3e38a527a1433620aebc7550.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/b07bc23f3e38a527a1433620aebc7550.jpg";s:8:"raw_name";s:32:"b07bc23f3e38a527a1433620aebc7550";s:9:"orig_name";s:6:"b4.jpg";s:11:"client_name";s:6:"b4.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:78.5;s:8:"is_image";b:1;s:11:"image_width";i:800;s:12:"image_height";i:504;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="800" height="504"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/b07bc23f3e38a527a1433620aebc7550_thumb.jpg";}', '', 1455663983, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
`idlang` int(11) NOT NULL,
  `lang` varchar(10) DEFAULT NULL,
  `code` char(2) DEFAULT NULL,
  `isactive` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`idlang`, `lang`, `code`, `isactive`) VALUES
(1, 'English', 'en', 1),
(2, 'Espanol', 'es', 0),
(3, 'Chinese', 'zh', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
`postID` int(11) NOT NULL,
  `postTitle` text CHARACTER SET utf8,
  `postDescription` text CHARACTER SET utf8,
  `postHeading` text CHARACTER SET utf8,
  `postSubheading` text CHARACTER SET utf8,
  `dateEntry` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '1',
  `postModule` varchar(100) DEFAULT NULL,
  `postSlug` text CHARACTER SET utf8,
  `dateExpiration` int(11) DEFAULT NULL,
  `postImages` text,
  `postAlign` varchar(100) DEFAULT NULL,
  `act_delete` tinyint(2) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postID`, `postTitle`, `postDescription`, `postHeading`, `postSubheading`, `dateEntry`, `userID`, `publish`, `postModule`, `postSlug`, `dateExpiration`, `postImages`, `postAlign`, `act_delete`) VALUES
(1, 'a:3:{s:2:"en";s:14:"Awesome places";s:2:"fr";s:29:"Réservation de sièges Infos";s:2:"du";s:24:"Seat Reservation Info Ok";}', 'a:3:{s:2:"en";s:1783:"<h4>Austrian myHoliday introduces following service for all customers:</h4><p class="bodytext">Passengers can reserve their favourite seat for the next leisure flight: no matter if it should be a window seat, an aisle seat or the first row.</p><p class="bodytext">Austrian myHoliday offers following categories and prices: Standard-Seat for EUR 10,-, Preferred Seat in rows 1-3 for EUR 13,- and the XL Seat with additional legroom and recline for EUR 20,-.</p><p class="bodytext">All prices are quoted oneway and per person!</p><p class="bodytext">Please note that all seat-reservations for infants (under 2 years of age) are free of charge. This applies not only for the infant , but also for the whole family (up to two adults as well as all children under 12 years of age) in the same reservation.</p><p class="bodytext">Seat reservation is open to all Austrian myHoliday passengers- no matter if the booking was made online on <a href="http://www.austrian.com/myHoliday" target="_blank">www.austrian.com/myHoliday</a>  or via a travel agent. It is also possible to buy this service, when your Austrian myHoliday flight is part of an "inclusive-tour".</p><p class="bodytext">Sear reservation can be done at the moment of booking or up to 2 days before departure <em>(e.g.: Is your flight on Wednesday - you have to complete the reservation until Sunday midnight)</em> with a valid credit card on <a href="http://www.austrian.com/myholiday" target="_blank">www.austrian.com/myholiday</a> . Additional information is available at our Call Centre 0820 320 321 (Mo-Fr 8 am - 7 pm, Sa,Su & bank holidays 8 am - 430 pm) - International: +43 5 176 676 700. Please note that this service is not bookable on triangle flights (i.e.: Vienna-Luxor-Hurghada) or seleted "special flights". </p>";s:2:"fr";s:3588:"<p><span id="result_box" class="" lang="fr"><span title="Austrian myHoliday introduces following service for all customers:\r\n\r\n">Myholiday autrichienne introduit service suivant pour tous les clients:<br /><br /></span><span title="Passengers can reserve their favourite seat for the next leisure flight: no matter if it should be a window seat, an aisle seat or the first row.\r\n\r\n">Les passagers peuvent réserver leur siège préféré pour le prochain vol de loisirs: peu importe si elle devrait être un siège de fenêtre, un siège côté couloir ou la première ligne.<br /><br /></span><span title="Austrian myHoliday offers following categories and prices: Standard-Seat for EUR 10,-, Preferred Seat in rows 1-3 for EUR 13,- and the XL Seat with additional legroom and recline for EUR 20,-.\r\n\r\n">Myholiday autrichienne propose catégories et les prix suivants: Standard-Siège pour 10 EUR, -, siège préféré dans les rangées 1-3 pour EUR 13, - et le siège XL avec espace pour les jambes supplémentaire et incliner pour 20 euros, -.<br /><br /></span><span title="All prices are quoted oneway and per person!\r\n\r\n">Tous les prix sont indiqués oneway et par personne!<br /><br /></span><span title="Please note that all seat-reservations for infants (under 2 years of age) are free of charge.">S''il vous plaît noter que tous les sièges-réservations pour les nourrissons (de moins de 2 ans) sont gratuits. </span><span title="This applies not only for the infant , but also for the whole family (up to two adults as well as all children under 12 years of age) in the same reservation.\r\n\r\n">Cela vaut non seulement pour l''enfant, mais aussi pour toute la famille (jusqu''à deux adultes ainsi que tous les enfants de moins de 12 ans) dans la même réserve.<br /><br /></span><span title="Seat reservation is open to all Austrian myHoliday passengers- no matter if the booking was made online on www.austrian.com/myHoliday or via a travel agent.">La réservation des places est ouverte à tous autrichienne myholiday passengers- peu importe si la réservation a été faite en ligne sur www.austrian.com/myHoliday ou via un agent de Voyage. </span><span title="It is also possible to buy this service, when your Austrian myHoliday flight is part of an ">Il est également possible d''acheter ce service, lorsque votre vol Austrian myholiday fait partie d''un «inclusive-tour".<br /><br /></span><span title="Sear reservation can be done at the moment of booking or up to 2 days before departure (eg: Is your flight on Wednesday - you have to complete the reservation until Sunday midnight) with a valid credit card on www.austrian.com/myholiday .">Sear réservation peut se faire au moment de la réservation ou jusqu''à 2 jours avant le départ (par exemple: Est votre vol le mercredi - vous devez remplir la réservation jusqu''à dimanche minuit) avec une carte de crédit valide sur www.austrian.com/myholiday. </span><span title="Additional information is available at our Call Centre 0820 320 321 (Mo-Fr 8 am - 7 pm, Sa,Su & bank holidays 8 am - 430 pm) - International: +43 5 176 676 700. Please note that this service is not">Des informations complémentaires sont disponibles à notre Centre d''appel 0820 320 321 (Lu-Ve 8 heures-19 heures, Sa, Su & banque vacances 8 heures - 430 h) - International: +43 5 176 676 700. S''il vous plaît noter que ce service est pas </span><span title="bookable on triangle flights (ie: Vienna-Luxor-Hurghada) or seleted ">réservables sur les vols de triangle (ie: Vienne-Louxor-Hurghada) ou seleted "vols spéciaux".</span></span></p>";s:2:"du";s:1720:"p classbodytextAustrian myHoliday introduces following service for all customers:p\r\np classbodytextPassengers can reserve their favourite seat for the next leisure flight: no matter if it should be a window seat, an aisle seat or the first rowp\r\np classbodytextAustrian myHoliday offers following categories and prices: Standard-Seat for EUR 10,-, Preferred Seat in rows 1-3 for EUR 13,- and the XL Seat with additional legroom and recline for EUR 20,-p\r\np classbodytextAll prices are quoted oneway and per person!p\r\np classbodytextPlease note that all seat-reservations for infants (under 2 years of age) are free of charge. This applies not only for the infant , but also for the whole family (up to two adults as well as all children under 12 years of age) in the same reservationp\r\np classbodytextSeat reservation is open to all Austrian myHoliday passengers- no matter if the booking was made online on a hrefhttp:www.austrian.commyHoliday target_blankwww.austrian.commyHolidaya  or via a travel agent. It is also possible to buy this service, when your Austrian myHoliday flight is part of an inclusive-tourp\r\np classbodytextSear reservation can be done at the moment of booking or up to 2 days before departure em(e.g.: Is your flight on Wednesday - you have to complete the reservation until Sunday midnight)em with a valid credit card on a hrefhttp:www.austrian.commyholiday target_blankwww.austrian.commyholidaya . Additional information is available at our Call Centre 0820 320 321 (Mo-Fr 8 am - 7 pm, Sa,Su  bank holidays 8 am - 430 pm) - International: +43 5 176 676 700. Please note that this service is not bookable on triangle flights (i.e.: Vienna-Luxor-Hurghada) or seleted special flights. p";}', NULL, NULL, 1441287105, 1, 1, 'articles', NULL, 1441287105, 'a:15:{s:9:"file_name";s:36:"93bd7d612a41bc7a34dd658b949720d6.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/93bd7d612a41bc7a34dd658b949720d6.jpg";s:8:"raw_name";s:32:"93bd7d612a41bc7a34dd658b949720d6";s:9:"orig_name";s:12:"D71_8568.jpg";s:11:"client_name";s:12:"D71_8568.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:1035.579999999999927240423858165740966796875;s:8:"is_image";b:1;s:11:"image_width";i:1280;s:12:"image_height";i:853;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:25:"width="1280" height="853"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/93bd7d612a41bc7a34dd658b949720d6_thumb.jpg";}', 'left', 0),
(6, 'Hidden gem in the heart of cusco!', 'a:3:{s:2:"en";s:235:"<p>Perfect quiet neighborhood that''s just few blocks away from the main \r\nsquare. Staff were all so accommodating; even helped us carry our big \r\nsuitcases down to our room. Clean room, warm beds and spectacular view \r\nof the city!</p>";s:2:"es";s:235:"<p>Perfect quiet neighborhood that''s just few blocks away from the main \r\nsquare. Staff were all so accommodating; even helped us carry our big \r\nsuitcases down to our room. Clean room, warm beds and spectacular view \r\nof the city!</p>";s:2:"zh";s:235:"<p>Perfect quiet neighborhood that''s just few blocks away from the main \r\nsquare. Staff were all so accommodating; even helped us carry our big \r\nsuitcases down to our room. Clean room, warm beds and spectacular view \r\nof the city!</p>";}', 'The Resa F', '5', 1455436533, 1, 1, 'testimonial', NULL, NULL, 'a:15:{s:9:"file_name";s:36:"46633b09f181c564b683b08fd77a477a.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/46633b09f181c564b683b08fd77a477a.jpg";s:8:"raw_name";s:32:"46633b09f181c564b683b08fd77a477a";s:9:"orig_name";s:16:"jessica-jung.jpg";s:11:"client_name";s:16:"jessica-jung.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:94.3900000000000005684341886080801486968994140625;s:8:"is_image";b:1;s:11:"image_width";i:770;s:12:"image_height";i:920;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="770" height="920"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/46633b09f181c564b683b08fd77a477a_thumb.jpg";}', NULL, 0),
(7, 'Nice Hostel with great view!', 'a:3:{s:2:"en";s:274:"<p>A nice place to spend some nights! The rooms are big with great view to \r\nthe city. The personnel is very friendly and helpful. Also, you can \r\nenjoy there a good breakfast starting at already 6 am. Also good is the \r\nlocation, only 5 minutes away from Plaza de Armas</p>";s:2:"es";s:274:"<p>A nice place to spend some nights! The rooms are big with great view to \r\nthe city. The personnel is very friendly and helpful. Also, you can \r\nenjoy there a good breakfast starting at already 6 am. Also good is the \r\nlocation, only 5 minutes away from Plaza de Armas</p>";s:2:"zh";s:274:"<p>A nice place to spend some nights! The rooms are big with great view to \r\nthe city. The personnel is very friendly and helpful. Also, you can \r\nenjoy there a good breakfast starting at already 6 am. Also good is the \r\nlocation, only 5 minutes away from Plaza de Armas</p>";}', 'Christo75', '4', 1455436654, 1, 1, 'testimonial', NULL, NULL, 'a:15:{s:9:"file_name";s:36:"153f0ae139c57140f6aa2ac5771b881f.jpg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:67:"D:/XAMPP/htdocs/rr-cms/uploads/153f0ae139c57140f6aa2ac5771b881f.jpg";s:8:"raw_name";s:32:"153f0ae139c57140f6aa2ac5771b881f";s:9:"orig_name";s:55:"40210-jessica-and-krystal-selc-9314-4933-1428896593.jpg";s:11:"client_name";s:55:"40210-jessica-and-krystal-selc-9314-4933-1428896593.jpg";s:8:"file_ext";s:4:".jpg";s:9:"file_size";d:30.989999999999998436805981327779591083526611328125;s:8:"is_image";b:1;s:11:"image_width";i:500;s:12:"image_height";i:375;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:24:"width="500" height="375"";s:5:"thumb";s:73:"D:/XAMPP/htdocs/rr-cms/uploads/153f0ae139c57140f6aa2ac5771b881f_thumb.jpg";}', NULL, 0),
(8, 'a:3:{s:2:"en";s:27:"Welcome to Hostel Corihuasi";s:2:"es";s:27:"Welcome to Hostel Corihuasi";s:2:"zh";s:27:"Welcome to Hostel Corihuasi";}', 'a:3:{s:2:"en";s:682:"<p>Hostel Corihausi offers you a warm welcome and a friendly base for your stay in Cusco, capital of the ancient Inca Empire.</p><p>Located in a respectfully restored 18th century colonial \r\nmansion built on ancient Inca crop terraces, your hotel is in the very \r\nheart of the city, two minutes from the main square and Plaza de Amas.</p><p>Our beautifully restored rooms reflect their original \r\ncharm and combine stunning views of the city with historic ambiance and \r\nall the modern comforts.</p><p>You will find our knowledgable staff available at all \r\ntimes to ensure you have everything you need to enjoy your stay both in \r\nthe hotel, around the city and further afield.</p>";s:2:"es";s:682:"<p>Hostel Corihausi offers you a warm welcome and a friendly base for your stay in Cusco, capital of the ancient Inca Empire.</p><p>Located in a respectfully restored 18th century colonial \r\nmansion built on ancient Inca crop terraces, your hotel is in the very \r\nheart of the city, two minutes from the main square and Plaza de Amas.</p><p>Our beautifully restored rooms reflect their original \r\ncharm and combine stunning views of the city with historic ambiance and \r\nall the modern comforts.</p><p>You will find our knowledgable staff available at all \r\ntimes to ensure you have everything you need to enjoy your stay both in \r\nthe hotel, around the city and further afield.</p>";s:2:"zh";s:682:"<p>Hostel Corihausi offers you a warm welcome and a friendly base for your stay in Cusco, capital of the ancient Inca Empire.</p><p>Located in a respectfully restored 18th century colonial \r\nmansion built on ancient Inca crop terraces, your hotel is in the very \r\nheart of the city, two minutes from the main square and Plaza de Amas.</p><p>Our beautifully restored rooms reflect their original \r\ncharm and combine stunning views of the city with historic ambiance and \r\nall the modern comforts.</p><p>You will find our knowledgable staff available at all \r\ntimes to ensure you have everything you need to enjoy your stay both in \r\nthe hotel, around the city and further afield.</p>";}', NULL, NULL, 0, 1, 1, 'about', NULL, NULL, NULL, NULL, 0),
(9, 'a:3:{s:2:"en";s:17:"Hostel Facilities";s:2:"es";s:17:"Hostel Facilities";s:2:"zh";s:17:"Hostel Facilities";}', 'a:3:{s:2:"en";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";s:2:"es";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";s:2:"zh";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";}', NULL, NULL, 1455579762, 1, 1, 'about', NULL, 1455579762, NULL, NULL, 0),
(10, 'a:3:{s:2:"en";s:18:"Hostel Facilities ";s:2:"es";s:18:"Hostel Facilities ";s:2:"zh";s:18:"Hostel Facilities ";}', 'a:3:{s:2:"en";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";s:2:"es";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";s:2:"zh";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";}', NULL, NULL, 1455584378, 1, 1, 'about', NULL, 1455584378, NULL, NULL, 0),
(11, 'a:3:{s:2:"en";s:17:"Hostel Facilities";s:2:"es";s:17:"Hostel Facilities";s:2:"zh";s:17:"Hostel Facilities";}', 'a:3:{s:2:"en";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";s:2:"es";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";s:2:"zh";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";}', NULL, NULL, 1455584627, 1, 1, 'about', NULL, 1455584627, NULL, NULL, 0),
(12, 'a:3:{s:2:"en";s:17:"Hostel Facilities";s:2:"es";s:17:"Hostel Facilities";s:2:"zh";s:17:"Hostel Facilities";}', 'a:3:{s:2:"en";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";s:2:"es";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";s:2:"zh";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";}', NULL, NULL, 0, 1, 1, 'about', NULL, NULL, NULL, NULL, 0),
(13, 'a:3:{s:2:"en";s:17:"Hostel Facilities";s:2:"es";s:17:"Hostel Facilities";s:2:"zh";s:17:"Hostel Facilities";}', 'a:3:{s:2:"en";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";s:2:"es";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";s:2:"zh";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";}', NULL, NULL, 0, 1, 1, 'about', NULL, NULL, NULL, NULL, 0),
(14, 'a:3:{s:2:"en";s:17:"Hostel Facilities";s:2:"es";s:17:"Hostel Facilities";s:2:"zh";s:17:"Hostel Facilities";}', 'a:3:{s:2:"en";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";s:2:"es";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";s:2:"zh";s:549:"<p>Our facilities and services include: </p><ul><li>Free pick-up from Cusco airport or train station </li><li>24 hour reception desk </li><li>Private bathrooms with abundant hot water 24 hours (not always a certainty in South America)</li><li>Breakfast (included in room rate) </li><li>High speed WiFi Internet access </li><li>Telephone, cable TV, ample power points </li><li>Gift Shop </li><li>Precise information about travel agencies</li><li>Bar/Coffee service</li><li>Safe deposit boxes in rooms</li><li>Luggage storage laundry service</li></ul>";}', NULL, NULL, 1455585618, 1, 1, 'facilities', NULL, 1455585618, NULL, NULL, 0),
(15, 'a:3:{s:2:"en";s:8:"Location";s:2:"es";s:8:"Location";s:2:"zh";s:8:"Location";}', 'a:3:{s:2:"en";s:450:"<p>Calle Suecia 561, Cusco - Peru </p><p>We are just two small blocks (125 m) from the Main Square and Plaza de Armas. </p><p>This is the very heart of the ancient Cusco city and the must see \r\nsites such as the cathedral, churches, monuments and museums are all \r\nhere. </p><p>It is also the living heart of the city with fabulous restaurants,\r\n bars, cafes and markets. Most fascinating of all is the unforgettable, \r\never-changing street life.</p>";s:2:"es";s:450:"<p>Calle Suecia 561, Cusco - Peru </p><p>We are just two small blocks (125 m) from the Main Square and Plaza de Armas. </p><p>This is the very heart of the ancient Cusco city and the must see \r\nsites such as the cathedral, churches, monuments and museums are all \r\nhere. </p><p>It is also the living heart of the city with fabulous restaurants,\r\n bars, cafes and markets. Most fascinating of all is the unforgettable, \r\never-changing street life.</p>";s:2:"zh";s:450:"<p>Calle Suecia 561, Cusco - Peru </p><p>We are just two small blocks (125 m) from the Main Square and Plaza de Armas. </p><p>This is the very heart of the ancient Cusco city and the must see \r\nsites such as the cathedral, churches, monuments and museums are all \r\nhere. </p><p>It is also the living heart of the city with fabulous restaurants,\r\n bars, cafes and markets. Most fascinating of all is the unforgettable, \r\never-changing street life.</p>";}', NULL, NULL, 1455587507, 1, 1, 'location', NULL, 1455587507, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE IF NOT EXISTS `room_types` (
`roomtypeid` int(11) NOT NULL,
  `hotelid` int(11) DEFAULT NULL,
  `roomname` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `main_description` longtext NOT NULL,
  `short_description` text,
  `active` tinyint(4) NOT NULL,
  `colour` varchar(12) CHARACTER SET latin1 NOT NULL,
  `mon` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `tue` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `wed` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `thu` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `fri` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `sat` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `sun` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `hourly_rate` decimal(16,6) DEFAULT '0.000000',
  `default_bed_id` int(5) DEFAULT '0',
  `ma_room_type_id` int(11) DEFAULT '0',
  `ma_mapped` tinyint(4) DEFAULT '0',
  `gender` varchar(10) DEFAULT 'Mixed',
  `occupancy` int(11) DEFAULT '2',
  `private_room` tinyint(11) DEFAULT '1',
  `image_url` varchar(256) DEFAULT NULL,
  `widget_footer` longtext,
  `widget_minimum_stay` int(11) DEFAULT '1',
  `userID` int(11) DEFAULT NULL,
  `act_delete` tinyint(2) DEFAULT '0',
  `date_created` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`roomtypeid`, `hotelid`, `roomname`, `main_description`, `short_description`, `active`, `colour`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `sun`, `hourly_rate`, `default_bed_id`, `ma_room_type_id`, `ma_mapped`, `gender`, `occupancy`, `private_room`, `image_url`, `widget_footer`, `widget_minimum_stay`, `userID`, `act_delete`, `date_created`) VALUES
(1, 6, 'Chemin De La Pralay', 'a:3:{s:2:"en";s:1352:"ppp3-room house, comfortable and tasteful furnishings: dining room with dining table. Living room with cable-TV. 1 room with 2 beds. Kitchen (4 hotplates, oven, dishwasher). ShowerWC. Large patio. Terrace furniture, deck chairs. Nice view of the swimming pool and the garden. Facilities: Internet (DSLLAN). Please note: non-smokers onlyp pGenthod 7 km from Genève: Small, comfortable house, renovated in 2008, surrounded by trees. In the centre of Genthod, in the residential district, located by a road. For shared use: garden 150 m2, swimming pool angular (8 x 4 m, 01.06.-31.08.). In the house: washing machine. Parking by the house. Grocers, restaurant, bus stop 300 m, railway station Genthod 600 m. Please note: not suitable for small children. The owner lives in the same grounds. Airfield closeby. Warning: the swimming pool is not secured. Children must be supervised. Swim at your own riskp div classnotes-special-terms pPlease note these Check-in Day Requirements for this property:p ul liSep 09 2015 - Sep 13 2015 : Wednesday, Thursday, Friday, Saturday or Sunday check-out requiredli liNov 04 2015 - Nov 08 2015 : Wednesday, Thursday, Friday, Saturday or Sunday check-out requiredli ul div div classnotes-special-termsPlease note: European properties may be subject to small additional fees at check in to comply with local ordinancedivpp";s:2:"es";s:1357:"p3-room house, comfortable and tasteful furnishings: dining room with dining table. Living room with cable-TV. 1 room with 2 beds. Kitchen (4 hotplates, oven, dishwasher). ShowerWC. Large patio. Terrace furniture, deck chairs. Nice view of the swimming pool and the garden. Facilities: Internet (DSLLAN). Please note: non-smokers onlyp\r\npGenthod 7 km from Genève: Small, comfortable house, renovated in 2008, surrounded by trees. In the centre of Genthod, in the residential district, located by a road. For shared use: garden 150 m2, swimming pool angular (8 x 4 m, 01.06.-31.08.). In the house: washing machine. Parking by the house. Grocers, restaurant, bus stop 300 m, railway station Genthod 600 m. Please note: not suitable for small children. The owner lives in the same grounds. Airfield closeby. Warning: the swimming pool is not secured. Children must be supervised. Swim at your own riskp\r\ndiv classnotes-special-terms\r\npPlease note these Check-in Day Requirements for this property:p\r\nul\r\nliSep 09 2015 - Sep 13 2015 : Wednesday, Thursday, Friday, Saturday or Sunday check-out requiredli\r\nliNov 04 2015 - Nov 08 2015 : Wednesday, Thursday, Friday, Saturday or Sunday check-out requiredli\r\nul\r\ndiv\r\ndiv classnotes-special-termsPlease note: European properties may be subject to small additional fees at check in to comply with local ordinancediv";s:2:"zh";s:1357:"p3-room house, comfortable and tasteful furnishings: dining room with dining table. Living room with cable-TV. 1 room with 2 beds. Kitchen (4 hotplates, oven, dishwasher). ShowerWC. Large patio. Terrace furniture, deck chairs. Nice view of the swimming pool and the garden. Facilities: Internet (DSLLAN). Please note: non-smokers onlyp\r\npGenthod 7 km from Genève: Small, comfortable house, renovated in 2008, surrounded by trees. In the centre of Genthod, in the residential district, located by a road. For shared use: garden 150 m2, swimming pool angular (8 x 4 m, 01.06.-31.08.). In the house: washing machine. Parking by the house. Grocers, restaurant, bus stop 300 m, railway station Genthod 600 m. Please note: not suitable for small children. The owner lives in the same grounds. Airfield closeby. Warning: the swimming pool is not secured. Children must be supervised. Swim at your own riskp\r\ndiv classnotes-special-terms\r\npPlease note these Check-in Day Requirements for this property:p\r\nul\r\nliSep 09 2015 - Sep 13 2015 : Wednesday, Thursday, Friday, Saturday or Sunday check-out requiredli\r\nliNov 04 2015 - Nov 08 2015 : Wednesday, Thursday, Friday, Saturday or Sunday check-out requiredli\r\nul\r\ndiv\r\ndiv classnotes-special-termsPlease note: European properties may be subject to small additional fees at check in to comply with local ordinancediv";}', 'a:3:{s:2:"en";s:334:"3-room house, comfortable and tasteful furnishings: dining room with dining table. Living room with cable-TV. 1 room with 2 beds. Kitchen (4 hotplates, oven, dishwasher). ShowerWC. Large patio. Terrace furniture, deck chairs. Nice view of the swimming pool and the garden. Facilities: Internet (DSLLAN). Please note: non-smokers only.";s:2:"es";s:334:"3-room house, comfortable and tasteful furnishings: dining room with dining table. Living room with cable-TV. 1 room with 2 beds. Kitchen (4 hotplates, oven, dishwasher). ShowerWC. Large patio. Terrace furniture, deck chairs. Nice view of the swimming pool and the garden. Facilities: Internet (DSLLAN). Please note: non-smokers only.";s:2:"zh";s:334:"3-room house, comfortable and tasteful furnishings: dining room with dining table. Living room with cable-TV. 1 room with 2 beds. Kitchen (4 hotplates, oven, dishwasher). ShowerWC. Large patio. Terrace furniture, deck chairs. Nice view of the swimming pool and the garden. Facilities: Internet (DSLLAN). Please note: non-smokers only.";}', 1, '1', '235.0000000', '235.0000000', '235.0000000', '235.0000000', '235.0000000', '235.0000000', '235.0000000', '421.000000', 0, 0, 0, 'all', 1, 1, 'http://assets03.redawning.com/sites/default/files/styles/480320/public/rental_property/8727/354080-1-2371763-1382703570.jpg?itok=lmYtLbNK', 'this widget footer', 3, 1, 0, 1441946726),
(2, 6, 'Gramercy Queen', 'a:3:{s:2:"en";s:1478:"div classleft_col grid_50 sub_grid \r\ndiv classspacer_right\r\np classtext_indentThe beautifully designed 220-275 square-foot Gramercy Queen features views of the bright Courtyard and a Queen Feather Bed topped with imported Italian linens. The Guest Room accommodates up to two guests. The bold, haute bohemian spirit of the public spaces at the Gramercy Park Hotel is carried on into its 185 Guest Rooms and Luxury Suites. Each of the beautifully designed rooms are decorated in a vivid Renaissance color palette and filled with such luxurious furnishings as velvet drapery, mahogany wood English drinking cabinet and hand-stitched leather-topped desks. In these Guest Rooms, no detail is overlooked — bronze rods, brass door handles and finials were forged by the Hotels creative genius, Julian Schnabelp\r\ndiv classright_col grid_50 sub_grid\r\ndiv classspacer_left\r\npAnd with a unique collection of Photographs and other custom, handcrafted furniture, each room is madly eclectic and uniquep\r\np classtext_indentThe Guest Rooms all come appointed with high-end amenities and furnishings like feather beds with imported Italian linens, embroidered chairs, original red oak floors, Corian sinks set in a vanity made from St. Laurent Marble and luxurious care products from Davines Momo, Le Labo, and Aesop Amenities. And the elegant space is complemented by state-of-the-art technologies, including Wi-Fi access, a Flat Screen TV with DVD player, and an iHomep\r\ndiv\r\ndiv\r\ndiv\r\ndiv";s:2:"es";s:1478:"div classleft_col grid_50 sub_grid \r\ndiv classspacer_right\r\np classtext_indentThe beautifully designed 220-275 square-foot Gramercy Queen features views of the bright Courtyard and a Queen Feather Bed topped with imported Italian linens. The Guest Room accommodates up to two guests. The bold, haute bohemian spirit of the public spaces at the Gramercy Park Hotel is carried on into its 185 Guest Rooms and Luxury Suites. Each of the beautifully designed rooms are decorated in a vivid Renaissance color palette and filled with such luxurious furnishings as velvet drapery, mahogany wood English drinking cabinet and hand-stitched leather-topped desks. In these Guest Rooms, no detail is overlooked — bronze rods, brass door handles and finials were forged by the Hotels creative genius, Julian Schnabelp\r\ndiv classright_col grid_50 sub_grid\r\ndiv classspacer_left\r\npAnd with a unique collection of Photographs and other custom, handcrafted furniture, each room is madly eclectic and uniquep\r\np classtext_indentThe Guest Rooms all come appointed with high-end amenities and furnishings like feather beds with imported Italian linens, embroidered chairs, original red oak floors, Corian sinks set in a vanity made from St. Laurent Marble and luxurious care products from Davines Momo, Le Labo, and Aesop Amenities. And the elegant space is complemented by state-of-the-art technologies, including Wi-Fi access, a Flat Screen TV with DVD player, and an iHomep\r\ndiv\r\ndiv\r\ndiv\r\ndiv";s:2:"zh";s:1478:"div classleft_col grid_50 sub_grid \r\ndiv classspacer_right\r\np classtext_indentThe beautifully designed 220-275 square-foot Gramercy Queen features views of the bright Courtyard and a Queen Feather Bed topped with imported Italian linens. The Guest Room accommodates up to two guests. The bold, haute bohemian spirit of the public spaces at the Gramercy Park Hotel is carried on into its 185 Guest Rooms and Luxury Suites. Each of the beautifully designed rooms are decorated in a vivid Renaissance color palette and filled with such luxurious furnishings as velvet drapery, mahogany wood English drinking cabinet and hand-stitched leather-topped desks. In these Guest Rooms, no detail is overlooked — bronze rods, brass door handles and finials were forged by the Hotels creative genius, Julian Schnabelp\r\ndiv classright_col grid_50 sub_grid\r\ndiv classspacer_left\r\npAnd with a unique collection of Photographs and other custom, handcrafted furniture, each room is madly eclectic and uniquep\r\np classtext_indentThe Guest Rooms all come appointed with high-end amenities and furnishings like feather beds with imported Italian linens, embroidered chairs, original red oak floors, Corian sinks set in a vanity made from St. Laurent Marble and luxurious care products from Davines Momo, Le Labo, and Aesop Amenities. And the elegant space is complemented by state-of-the-art technologies, including Wi-Fi access, a Flat Screen TV with DVD player, and an iHomep\r\ndiv\r\ndiv\r\ndiv\r\ndiv";}', 'a:3:{s:2:"en";s:206:"The beautifully designed 220-275 square-foot Gramercy Queen features views of the bright Courtyard and a Queen Feather Bed topped with imported Italian linens. The Guest Room accommodates up to two guests. ";s:2:"es";s:206:"The beautifully designed 220-275 square-foot Gramercy Queen features views of the bright Courtyard and a Queen Feather Bed topped with imported Italian linens. The Guest Room accommodates up to two guests. ";s:2:"zh";s:206:"The beautifully designed 220-275 square-foot Gramercy Queen features views of the bright Courtyard and a Queen Feather Bed topped with imported Italian linens. The Guest Room accommodates up to two guests. ";}', 1, 'Red', '23.0000000', '34.0000000', '43.0000000', '34.0000000', '43.0000000', '33.0000000', '43.0000000', '234.000000', 0, 0, 0, 'all', 1, 2, 'http://www.gramercyparkhotel.com/media/W1siZiIsInBob3Rvc2V0LzEzNjEzMTc4OTRfN2o4M3MuanBnIl1d', 'the widget', 3, 2, 0, 1441946726),
(4, 6, 'Gramercy Double Double', 'a:3:{s:2:"en";s:1638:"div classtext_container grid text_justify\r\ndiv classleft_col grid_50 sub_grid\r\ndiv classspacer_right\r\np classthemed_color fancy_letter_tThe beautifully designed 385 square-foot Gramercy Double Double features views of the bright courtyard and two luxurious Double Beds topped with imported Italian linens. The room accommodates up to four guests and offers a connecting option to the Gramercy Suitep\r\np classtext_indentThe bold, haute bohemian spirit of the public spaces at the Gramercy Park Hotel is carried on into its 185 Guest Rooms and Luxury Suites. Each of the beautifully designed rooms are decorated in a vivid Renaissance color palette and filled with such luxurious furnishings as velvet drapery, mahogany wood English drinking cabinet and hand-stitched leather-topped desksp\r\np classtext_indentIn these Guest Rooms, no detail is overlooked — bronze rods,p\r\ndiv\r\ndiv\r\ndiv classright_col grid_50 sub_grid\r\ndiv classspacer_left\r\npbrass door handles and finials were forged by the Hotels creative genius, Julian Schnabel. And with a unique collection of Photographs and other custom, handcrafted furniture, each room is madly eclectic and uniquep\r\np classtext_indentThe Guest Rooms all come appointed with high-end amenities and furnishings like feather beds with imported Italian linens, embroidered chairs, original red oak floors, Corian sinks set in a vanity made from St. Laurent Marble and luxurious care products from Davines Momo, Le Labo, and Aesop Amenities. And the elegant space is complemented by state-of-the-art technologies, including Wi-Fi access, a Flat Screen TV with DVD player, and an iHomep\r\ndiv\r\ndiv\r\ndiv";s:2:"es";s:1638:"div classtext_container grid text_justify\r\ndiv classleft_col grid_50 sub_grid\r\ndiv classspacer_right\r\np classthemed_color fancy_letter_tThe beautifully designed 385 square-foot Gramercy Double Double features views of the bright courtyard and two luxurious Double Beds topped with imported Italian linens. The room accommodates up to four guests and offers a connecting option to the Gramercy Suitep\r\np classtext_indentThe bold, haute bohemian spirit of the public spaces at the Gramercy Park Hotel is carried on into its 185 Guest Rooms and Luxury Suites. Each of the beautifully designed rooms are decorated in a vivid Renaissance color palette and filled with such luxurious furnishings as velvet drapery, mahogany wood English drinking cabinet and hand-stitched leather-topped desksp\r\np classtext_indentIn these Guest Rooms, no detail is overlooked — bronze rods,p\r\ndiv\r\ndiv\r\ndiv classright_col grid_50 sub_grid\r\ndiv classspacer_left\r\npbrass door handles and finials were forged by the Hotels creative genius, Julian Schnabel. And with a unique collection of Photographs and other custom, handcrafted furniture, each room is madly eclectic and uniquep\r\np classtext_indentThe Guest Rooms all come appointed with high-end amenities and furnishings like feather beds with imported Italian linens, embroidered chairs, original red oak floors, Corian sinks set in a vanity made from St. Laurent Marble and luxurious care products from Davines Momo, Le Labo, and Aesop Amenities. And the elegant space is complemented by state-of-the-art technologies, including Wi-Fi access, a Flat Screen TV with DVD player, and an iHomep\r\ndiv\r\ndiv\r\ndiv";s:2:"zh";s:1638:"div classtext_container grid text_justify\r\ndiv classleft_col grid_50 sub_grid\r\ndiv classspacer_right\r\np classthemed_color fancy_letter_tThe beautifully designed 385 square-foot Gramercy Double Double features views of the bright courtyard and two luxurious Double Beds topped with imported Italian linens. The room accommodates up to four guests and offers a connecting option to the Gramercy Suitep\r\np classtext_indentThe bold, haute bohemian spirit of the public spaces at the Gramercy Park Hotel is carried on into its 185 Guest Rooms and Luxury Suites. Each of the beautifully designed rooms are decorated in a vivid Renaissance color palette and filled with such luxurious furnishings as velvet drapery, mahogany wood English drinking cabinet and hand-stitched leather-topped desksp\r\np classtext_indentIn these Guest Rooms, no detail is overlooked — bronze rods,p\r\ndiv\r\ndiv\r\ndiv classright_col grid_50 sub_grid\r\ndiv classspacer_left\r\npbrass door handles and finials were forged by the Hotels creative genius, Julian Schnabel. And with a unique collection of Photographs and other custom, handcrafted furniture, each room is madly eclectic and uniquep\r\np classtext_indentThe Guest Rooms all come appointed with high-end amenities and furnishings like feather beds with imported Italian linens, embroidered chairs, original red oak floors, Corian sinks set in a vanity made from St. Laurent Marble and luxurious care products from Davines Momo, Le Labo, and Aesop Amenities. And the elegant space is complemented by state-of-the-art technologies, including Wi-Fi access, a Flat Screen TV with DVD player, and an iHomep\r\ndiv\r\ndiv\r\ndiv";}', 'a:3:{s:2:"en";s:263:"The beautifully designed 385 square-foot Gramercy Double Double features views of the bright courtyard and two luxurious Double Beds topped with imported Italian linens. The room accommodates up to four guests and offers a connecting option to the Gramercy Suite.";s:2:"es";s:263:"The beautifully designed 385 square-foot Gramercy Double Double features views of the bright courtyard and two luxurious Double Beds topped with imported Italian linens. The room accommodates up to four guests and offers a connecting option to the Gramercy Suite.";s:2:"zh";s:263:"The beautifully designed 385 square-foot Gramercy Double Double features views of the bright courtyard and two luxurious Double Beds topped with imported Italian linens. The room accommodates up to four guests and offers a connecting option to the Gramercy Suite.";}', 1, 'Blue', '2.0000000', '2.0000000', '2.0000000', '3.0000000', '2.0000000', '2.0000000', '2.0000000', '22.000000', 0, 0, 0, 'all', 1, 3, 'http://www.gramercyparkhotel.com/media/W1siZiIsInBob3Rvc2V0LzEzNjE5MTMwODUuanBnIl1d', 'the widget here', 2, 1, 0, 1441946726);

-- --------------------------------------------------------

--
-- Table structure for table `room_types_photos`
--

CREATE TABLE IF NOT EXISTS `room_types_photos` (
`id` int(11) unsigned NOT NULL,
  `roomtypeid` int(11) DEFAULT NULL,
  `hotelid` int(11) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `sort_order` int(11) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `room_types_photos`
--

INSERT INTO `room_types_photos` (`id`, `roomtypeid`, `hotelid`, `url`, `sort_order`) VALUES
(15, 1, 6, 'http://assets06.redawning.com/sites/default/files/styles/480320/public/rental_property/1761/image31179.jpeg?itok=k94E9wx_', 0),
(16, 1, 6, 'http://assets06.redawning.com/sites/default/files/styles/480320/public/rental_property/1761/image31187.jpeg?itok=bkKO7Giw', 0),
(17, 1, 6, 'http://assets06.redawning.com/sites/default/files/styles/480320/public/rental_property/1761/image27228.jpeg?itok=DPZsnC2y', 0),
(18, 2, 6, 'http://www.gramercyparkhotel.com/media/W1siZiIsInBob3Rvc2V0LzEzNjEzMTc4OTUuanBnIl1d', 0),
(19, 2, 6, 'http://www.gramercyparkhotel.com/media/W1siZiIsInBob3Rvc2V0LzEzNjE0ODE2NDIuanBlZyJdXQ', 0),
(20, 3, 6, 'http://www.gramercyparkhotel.com/media/W1siZiIsInBob3Rvc2V0LzEzNjE0ODE5ODQuanBlZyJdXQ', 0),
(21, 3, 6, 'http://www.gramercyparkhotel.com/media/W1siZiIsInBob3Rvc2V0LzEzNjE0ODE5OTUuanBlZyJdXQ', 0),
(22, 3, 6, 'http://www.gramercyparkhotel.com/media/W1siZiIsInBob3Rvc2V0LzEzNjE0ODIwMDkuanBlZyJdXQ', 0),
(23, 4, 6, 'http://www.gramercyparkhotel.com/media/W1siZiIsInBob3Rvc2V0LzEzNjE0ODAzNzUuanBnIl1d', 0),
(24, 4, 6, 'http://www.gramercyparkhotel.com/media/W1siZiIsInBob3Rvc2V0LzEzNjE4OTIxMDkuanBnIl1d', 0),
(25, 4, 6, 'http://www.gramercyparkhotel.com/media/W1siZiIsInBob3Rvc2V0LzEzNjE0ODAzOTEuanBnIl1d', 0);

-- --------------------------------------------------------

--
-- Table structure for table `userblocks`
--

CREATE TABLE IF NOT EXISTS `userblocks` (
`userblockID` int(11) NOT NULL,
  `blockID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `datecreate` int(11) DEFAULT NULL,
  `act_delete` tinyint(2) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userblocks`
--

INSERT INTO `userblocks` (`userblockID`, `blockID`, `userID`, `datecreate`, `act_delete`) VALUES
(9, 4, 1, 1441187119, 0),
(13, 1, 1, 1441264653, 0),
(14, 2, 1, 1441264661, 0),
(15, 3, 1, 1441264669, 0),
(16, 1, 2, 1442739099, 0),
(17, 2, 2, 1442739112, 0),
(18, 3, 2, 1442756565, 0),
(19, 4, 2, 1442756574, 0),
(20, 5, 1, 1455184102, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`userID` int(11) NOT NULL,
  `userName` varchar(55) DEFAULT NULL,
  `userPassword` varchar(41) DEFAULT NULL,
  `reg_date` int(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `phonenumber` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `soc_fb` varchar(100) DEFAULT NULL,
  `soc_in` varchar(100) DEFAULT NULL,
  `soc_plus` varchar(100) DEFAULT NULL,
  `soc_twit` varchar(100) DEFAULT NULL,
  `profile_pic` text,
  `lastlogin` int(11) DEFAULT NULL,
  `isonline` tinyint(1) DEFAULT NULL,
  `about` text CHARACTER SET utf8,
  `levelaccess` varchar(50) DEFAULT NULL,
  `isblock` enum('yes','no') DEFAULT 'no',
  `ipaddress` varchar(55) DEFAULT NULL,
  `activatedate` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `userPassword`, `reg_date`, `email`, `firstname`, `lastname`, `phonenumber`, `address`, `city`, `state`, `zip`, `soc_fb`, `soc_in`, `soc_plus`, `soc_twit`, `profile_pic`, `lastlogin`, `isonline`, `about`, `levelaccess`, `isblock`, `ipaddress`, `activatedate`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1442669202, 'wahyusoft@yahoo.com', 'Wahyu', 'Widodo', '081318218989', 'Jl.Druwo ', 'Yogyakarta', 'Bantul', '54174', 'http://facebook.com/users/test', 'http://linkedln.com/users/test', 'http://plusgoogle.com/users/test', 'http://twitter.com/users/test', 'a:15:{s:9:"file_name";s:37:"5937b2a92e1a4a7e23ecf81f9399594e.jpeg";s:9:"file_type";s:10:"image/jpeg";s:9:"file_path";s:31:"D:/XAMPP/htdocs/rr-cms/uploads/";s:9:"full_path";s:68:"D:/XAMPP/htdocs/rr-cms/uploads/5937b2a92e1a4a7e23ecf81f9399594e.jpeg";s:8:"raw_name";s:32:"5937b2a92e1a4a7e23ecf81f9399594e";s:9:"orig_name";s:10:"users.jpeg";s:11:"client_name";s:10:"users.jpeg";s:8:"file_ext";s:5:".jpeg";s:9:"file_size";d:447.76999999999998181010596454143524169921875;s:8:"is_image";b:1;s:11:"image_width";i:1600;s:12:"image_height";i:1200;s:10:"image_type";s:4:"jpeg";s:14:"image_size_str";s:26:"width="1600" height="1200"";s:5:"thumb";s:74:"D:/XAMPP/htdocs/rr-cms/uploads/5937b2a92e1a4a7e23ecf81f9399594e_thumb.jpeg";}', 1456842244, 1, 'a:3:{s:2:"en";s:573:"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";s:2:"es";s:10:"About Fara";s:2:"zh";s:10:"About Fara";}', 'admin', 'no', NULL, NULL),
(2, 'masaruedo', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1442669202, NULL, 'Edo', 'Masaru', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1442789060, 1, NULL, 'users', 'no', '127.0.0.1', 1442675108);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `block`
--
ALTER TABLE `block`
 ADD PRIMARY KEY (`blockID`);

--
-- Indexes for table `bodypost`
--
ALTER TABLE `bodypost`
 ADD PRIMARY KEY (`bodyID`);

--
-- Indexes for table `bucket`
--
ALTER TABLE `bucket`
 ADD PRIMARY KEY (`bucketID`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
 ADD PRIMARY KEY (`session_id`), ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `custom_room_amenities`
--
ALTER TABLE `custom_room_amenities`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `globals`
--
ALTER TABLE `globals`
 ADD PRIMARY KEY (`globalID`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
 ADD PRIMARY KEY (`hotelid`), ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
 ADD PRIMARY KEY (`imagesID`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
 ADD PRIMARY KEY (`idlang`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
 ADD PRIMARY KEY (`postID`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
 ADD PRIMARY KEY (`roomtypeid`), ADD KEY `hotel_id` (`hotelid`);

--
-- Indexes for table `room_types_photos`
--
ALTER TABLE `room_types_photos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userblocks`
--
ALTER TABLE `userblocks`
 ADD PRIMARY KEY (`userblockID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `block`
--
ALTER TABLE `block`
MODIFY `blockID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `bodypost`
--
ALTER TABLE `bodypost`
MODIFY `bodyID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=225;
--
-- AUTO_INCREMENT for table `bucket`
--
ALTER TABLE `bucket`
MODIFY `bucketID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `custom_room_amenities`
--
ALTER TABLE `custom_room_amenities`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `globals`
--
ALTER TABLE `globals`
MODIFY `globalID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
MODIFY `hotelid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
MODIFY `imagesID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
MODIFY `idlang` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
MODIFY `roomtypeid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `room_types_photos`
--
ALTER TABLE `room_types_photos`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `userblocks`
--
ALTER TABLE `userblocks`
MODIFY `userblockID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
