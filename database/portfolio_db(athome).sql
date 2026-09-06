-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.21.0.7344
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for portfolio_db
CREATE DATABASE IF NOT EXISTS `portfolio_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `portfolio_db`;

-- Dumping structure for table portfolio_db.activity_logs
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `section` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table portfolio_db.activity_logs: ~33 rows (approximately)
INSERT INTO `activity_logs` (`id`, `user_id`, `section`, `action`, `details`, `ip_address`, `created_at`) VALUES
	(1, 1, 'Authentication', 'Login', 'Admin logged in: admin', '::1', '2026-08-25 14:59:18'),
	(2, 1, 'Hero Section', 'Updated', 'Updated bio and name for Aerhon Louis Magtira, MIT', '::1', '2026-08-25 15:00:32'),
	(3, 1, 'Hero Section', 'Updated', 'Updated bio and name for Aerhon Louis Magtira', '::1', '2026-08-25 15:02:55'),
	(4, 1, 'Projects', 'Updated', 'Updated project: test 1', '::1', '2026-08-25 15:09:36'),
	(5, 1, 'Authentication', 'Logout', 'Admin logged out: admin', '::1', '2026-08-25 15:26:44'),
	(6, NULL, 'Authentication', 'Failed Login', 'Failed login attempt for username: admin', '::1', '2026-08-25 15:26:53'),
	(7, NULL, 'Authentication', 'Failed Login', 'Failed login attempt for username: admin', '::1', '2026-08-25 15:27:00'),
	(8, NULL, 'Authentication', 'Failed Login', 'Failed login attempt for username: admin1', '::1', '2026-08-25 15:27:02'),
	(9, NULL, 'Authentication', 'Failed Login', 'Failed login attempt for username: admin1', '::1', '2026-08-25 15:27:03'),
	(10, NULL, 'Authentication', 'Lockout', 'Account locked (5 failed attempts) for user: admin1', '::1', '2026-08-25 15:27:04'),
	(11, 1, 'Authentication', 'Login', 'Admin logged in: admin', '::1', '2026-08-25 16:04:14'),
	(12, 1, 'Projects', 'Updated', 'Updated project: test 1', '::1', '2026-08-25 16:05:25'),
	(13, 1, 'Contact', 'Sent Message', 'Inquiry sent by: johndoe1@gmail.com', '::1', '2026-08-25 16:33:27'),
	(14, 1, 'Tech Stack', 'Added', 'Added skill: Amazon', '::1', '2026-08-25 16:46:08'),
	(15, 1, 'Tech Stack', 'Added', 'Added skill: Amazon', '::1', '2026-08-25 16:46:53'),
	(16, 1, 'Tech Stack', 'Added', 'Added skill: Amazon', '::1', '2026-08-25 16:48:35'),
	(17, 1, 'Tech Stack', 'Added', 'Added skill: Amazon', '::1', '2026-08-25 17:04:27'),
	(18, 1, 'Certifications', 'Added', 'Title: test', '::1', '2026-08-25 17:06:36'),
	(19, 1, 'Certifications', 'Deleted', 'Deleted cert ID: 8', '::1', '2026-08-25 17:06:51'),
	(20, 1, 'Authentication', 'Logout', 'Admin logged out: admin', '::1', '2026-08-25 17:10:43'),
	(21, 1, 'Authentication', 'Login', 'Admin logged in: admin', '::1', '2026-08-26 09:01:03'),
	(22, 1, 'Certifications', 'Added', 'Title: test', '::1', '2026-08-26 09:29:50'),
	(23, 1, 'Tech Stack', 'Added', 'Added skill: Amazon', '::1', '2026-08-26 09:42:31'),
	(24, 1, 'Tech Stack', 'Deleted', 'Removed tech item ID: 20', '::1', '2026-08-26 09:52:00'),
	(25, 1, 'Tech Stack', 'Deleted', 'Removed tech item ID: 21', '::1', '2026-08-26 09:52:09'),
	(26, 1, 'Tech Stack', 'Deleted', 'Removed tech item ID: 22', '::1', '2026-08-26 09:52:55'),
	(27, 1, 'Authentication', 'Login', 'Admin logged in: admin', '10.0.0.66', '2026-08-26 10:12:36'),
	(28, 1, 'Tech Stack', 'Deleted', 'Removed tech item ID: 24', '10.0.0.66', '2026-08-26 10:14:12'),
	(29, 1, 'Authentication', 'Logout', 'Admin logged out: admin', '::1', '2026-08-26 10:55:44'),
	(30, NULL, 'Contact', 'Sent Message', 'Inquiry sent by: johndoe@gmail.com', '10.0.0.80', '2026-08-26 13:26:23'),
	(31, NULL, 'Contact', 'Sent Message', 'Inquiry sent by: adada@com', '10.0.0.80', '2026-08-26 13:42:04'),
	(32, NULL, 'Contact', 'Sent Message', 'Inquiry sent by: sfsf@gmail.com', '10.0.0.80', '2026-08-26 13:43:24'),
	(33, NULL, 'Contact', 'Sent Message', 'Inquiry sent by: johndoe1@gmail.com', '10.0.0.80', '2026-08-26 13:48:55');

-- Dumping structure for table portfolio_db.announcement_reads
CREATE TABLE IF NOT EXISTS `announcement_reads` (
  `user_id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `read_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`,`announcement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table portfolio_db.announcement_reads: ~6 rows (approximately)
INSERT INTO `announcement_reads` (`user_id`, `announcement_id`, `read_at`) VALUES
	(1, 3, '2026-09-02 10:22:01'),
	(4, 3, '2026-09-02 10:15:19'),
	(13, 3, '2026-09-02 10:52:30'),
	(15, 3, '2026-09-02 11:09:29'),
	(19, 4, '2026-09-04 08:51:31'),
	(28, 5, '2026-09-04 16:45:54');

-- Dumping structure for table portfolio_db.announcements
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `target_user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `expires_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table portfolio_db.announcements: ~2 rows (approximately)
INSERT INTO `announcements` (`id`, `admin_id`, `target_user_id`, `title`, `message`, `category`, `created_at`, `updated_at`, `expires_at`, `is_active`) VALUES
	(4, 21, 19, 'Test 1', 'testing testing', 'General', '2026-09-04 08:51:11', '2026-09-04 08:51:11', '2026-09-04 23:59:59', 1),
	(5, 21, NULL, 'yes', '3:02pm', '', '2026-09-04 15:02:45', '2026-09-04 15:02:45', '2026-09-04 23:59:59', 1);

-- Dumping structure for table portfolio_db.certifications
CREATE TABLE IF NOT EXISTS `certifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `issuer` varchar(100) NOT NULL,
  `issue_date` date NOT NULL,
  `badge_img` varchar(100) DEFAULT 'default-cert.png',
  `cert_image` varchar(255) DEFAULT 'default-cert.jpg',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table portfolio_db.certifications: ~7 rows (approximately)
INSERT INTO `certifications` (`id`, `title`, `issuer`, `issue_date`, `badge_img`, `cert_image`) VALUES
	(1, 'Information Technology Specialist in HTML and CSS', 'Certiport', '2025-03-19', 'it-specialist-html-and-css.png', 'htmlcss.jpg'),
	(2, 'Information Technology Specialist in Databases', 'Certiport', '2025-05-07', 'it-specialist-databases.png', 'databases.jpg'),
	(3, 'Information Technology Specialist in Java', 'Certiport', '2026-02-02', 'it-specialist-java.png', 'java.jpg'),
	(4, 'Information Technology Specialist in Software Development', 'Certiport', '2026-06-04', 'it-specialist-software-development.png', 'softdev.jpg'),
	(5, 'Introduction to IoT', 'Cisco Networking Academy', '2026-03-13', 'introduction-to-iot.png', 'iot_certificate.jpg'),
	(6, 'Linux Essentials', 'Cisco Networking Academy', '2026-05-12', 'linux-essentials.png', 'linux_certificate.jpg'),
	(9, 'test', 'testing 1', '2026-08-26', 'badge_1787707790.jpg', 'cert_1787707790.jpg');

-- Dumping structure for table portfolio_db.inquiries
CREATE TABLE IF NOT EXISTS `inquiries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `status` enum('Open','Answered','Closed') DEFAULT 'Open',
  `admin_reply` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `replied_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `inquiries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table portfolio_db.inquiries: ~0 rows (approximately)

-- Dumping structure for table portfolio_db.intern_documents
CREATE TABLE IF NOT EXISTS `intern_documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `document_type` varchar(100) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `status` enum('Pending','Verified','Rejected') NOT NULL DEFAULT 'Pending',
  `uploaded_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `intern_document_type` (`user_id`,`document_type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table portfolio_db.intern_documents: ~2 rows (approximately)
INSERT INTO `intern_documents` (`id`, `user_id`, `document_type`, `file_path`, `original_name`, `status`, `uploaded_at`, `updated_at`) VALUES
	(1, 13, 'Resume / CV', 'assets/uploads/intern_documents/13/4bcdde441ae7b203bd2a82221fb869ed.jpg', 'Magtira,_AerhonLouis_portrait.jpg', 'Pending', '2026-09-02 10:08:00', '2026-09-02 10:10:57'),
	(2, 13, 'Registration Form / COE', 'assets/uploads/intern_documents/13/0b00c5b943d3c418e7b9ebb0a1dda142.jpg', 'test2.jpg', 'Pending', '2026-09-02 10:11:33', NULL);

-- Dumping structure for table portfolio_db.intern_inquiries
CREATE TABLE IF NOT EXISTS `intern_inquiries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `admin_reply` text DEFAULT NULL,
  `status` enum('Open','Answered','Closed') NOT NULL DEFAULT 'Open',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `replied_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table portfolio_db.intern_inquiries: ~3 rows (approximately)
INSERT INTO `intern_inquiries` (`id`, `user_id`, `category`, `message`, `admin_reply`, `status`, `created_at`, `replied_at`) VALUES
	(1, 13, 'General Concern', 'test 0', 'ok', 'Answered', '2026-09-02 10:04:55', '2026-09-02 10:39:34'),
	(2, 13, 'General Concern', 'test 1', 'test 2', 'Answered', '2026-09-02 10:07:13', '2026-09-02 10:33:44'),
	(3, 28, 'DTR Discrepancy', 'hello admin', NULL, 'Open', '2026-09-04 16:46:39', NULL);

-- Dumping structure for table portfolio_db.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_name` varchar(100) NOT NULL,
  `sender_email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message_text` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table portfolio_db.messages: ~2 rows (approximately)
INSERT INTO `messages` (`id`, `sender_name`, `sender_email`, `subject`, `message_text`, `is_read`, `created_at`) VALUES
	(2, 'Jim Doe', 'jimmydoe@gmail.com', 'OJT Log Deletion Request #29', 'Please review my request to delete OJT log #29 dated 2026-09-03.', 1, '2026-09-04 08:29:51'),
	(3, 'Jim Doe', 'jimmydoe@gmail.com', 'OJT Log Deletion Request #29', 'Please review my request to delete OJT log #29 dated 2026-09-03.', 1, '2026-09-04 08:30:57');

-- Dumping structure for table portfolio_db.ojt_logs
CREATE TABLE IF NOT EXISTS `ojt_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `log_date` date NOT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `hours_rendered` decimal(4,2) DEFAULT 0.00,
  `task_summary` text NOT NULL,
  `status` enum('active','Pending','Approved','Rejected','Completed') NOT NULL DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_ojt_logs_user` (`user_id`),
  CONSTRAINT `fk_ojt_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table portfolio_db.ojt_logs: ~2 rows (approximately)
INSERT INTO `ojt_logs` (`id`, `user_id`, `log_date`, `time_in`, `time_out`, `hours_rendered`, `task_summary`, `status`, `created_at`) VALUES
	(29, 18, '2026-09-03', '2026-09-03 10:39:16', '2026-09-04 08:29:38', 20.83, '', 'Approved', '2026-09-03 10:39:16'),
	(30, 19, '2026-09-04', '2026-09-03 10:55:07', '2026-09-04 08:51:49', 20.93, '', 'Approved', '2026-09-03 10:55:07');

-- Dumping structure for table portfolio_db.ojt_settings
CREATE TABLE IF NOT EXISTS `ojt_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `required_hours` int(11) DEFAULT 500,
  `student_name` varchar(100) DEFAULT 'Aerhon Magtira',
  PRIMARY KEY (`id`),
  KEY `fk_ojt_settings_user` (`user_id`),
  CONSTRAINT `fk_ojt_settings_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table portfolio_db.ojt_settings: ~0 rows (approximately)

-- Dumping structure for table portfolio_db.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `about_project` text DEFAULT NULL,
  `tech_stack` varchar(255) DEFAULT NULL,
  `site_url` varchar(255) DEFAULT NULL,
  `project_img` varchar(255) DEFAULT 'default_project.jpg',
  `thumbnail_img` varchar(255) DEFAULT NULL,
  `github_link` varchar(255) DEFAULT NULL,
  `demo_link` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `gallery_images` text DEFAULT NULL,
  `long_description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table portfolio_db.projects: ~4 rows (approximately)
INSERT INTO `projects` (`id`, `title`, `slug`, `description`, `about_project`, `tech_stack`, `site_url`, `project_img`, `thumbnail_img`, `github_link`, `demo_link`, `created_at`, `gallery_images`, `long_description`) VALUES
	(1, 'A Mobile-Based Multi-Barangay Complaint Management System', 'justifi', 'JustiFi is a mobile-based Capstone project designed to streamline complaint processing and management.', NULL, 'PHP, Ionic Framework, MySQL, Bootstrap 5', NULL, 'proj_1787623482.jpeg', 'capstone.jpeg', NULL, 'https://facebook.com', '2026-08-18 16:10:35', 'justifi1.png,justifi2.png,justifi3.png', 'JustiFi is a mobile-based Capstone project designed to streamline complaint processing and management across local barangays. Developed to bridge the gap between residents and local officials, the system features automated incident reporting, real-time status tracking, integrated notifications, and administrative analytics dashboards.\n\nKey Features:\n• Resident Reporting Portal: Enables community members to submit complaints online and upload photo evidence directly from mobile devices.\n• Real-Time Case Tracking: Monitor resolution status (Pending, Under Review, Resolved) in real time.\n• Analytics and Announcements: Allows barangay officials to display statistics for complaints filed, and track resolution timelines efficiently for transparency.'),
	(2, 'GlycoPlate: An IoT-Based Smart Glycemic Plate for Dietary Monitoring', 'glycoplate', 'GlycoPlate is an IoT project that measures food portions, tracks and analyzes dietarty intake.', NULL, 'ESP32 Wroom 32, HX711, Loadcell, Firebase', NULL, 'proj_1787623496.jpeg', 'iot-project.jpeg', NULL, 'https://glycoplate.web.app', '2026-08-18 16:10:35', 'glycoplate1.jpeg,glycoplate2.png,glycoplate3.png', 'GlycoPlate is an IoT-based smart glycemic plate system designed for precise dietary monitoring and daily intake tracking. Built using ESP32 microcontrollers, HX711 load cell sensors, and Firebase real-time database, the plate accurately measures food portion weights and calculates glycemic load/index values in real time.\n\nKey Features:\n• Real-Time Weight Sensing: Measures food portions instantly using HX711 load cells integrated into the physical plate.\n• Nutritional & Glycemic Analysis: Automatically computes calorie and glycemic impact based on food selections.\n• Mobile & Cloud Dashboard: Syncs dietary analytics with Firebase to allow users to monitor their historical food logs and health metrics seamlessly.'),
	(3, 'SDCA OJT Hours & Task Tracker System', 'ojt-tracker', 'A web-based portal for monitoring intern attendance, daily time logs, task progress, and supervisor evaluations.', NULL, 'PHP, CodeIgniter 3, MySQL, Bootstrap 5', NULL, 'proj_1787623513.png', 'ojt-tracker.png', NULL, 'http://localhost/portfolio-project/index.php/ojt', '2026-08-18 16:10:35', 'ojt1.png,ojt2.png,ojt3.png', 'SDCA OJT Hours & Task Tracker is an integrated web-based portal engineered to streamline internship attendance tracking, daily time logs (DTR), and task management for St. Dominic College of Asia students. It has an additional feature of a simple calculator.\n\nKey Features:\n• Digital Attendance & DTR: Enables interns to log daily attendance, track accumulated hours, and submit work logs digitally.\n• Supervisor Evaluation System: Allows industry supervisors and faculty coordinators to review task progress, verify hours, and complete performance evaluations online.\n• Interactive Dashboards: Displays real-time progress bars and milestone indicators to keep students on target toward completing required internship hours.'),
	(10, 'test 1', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt.', NULL, 'JavaScript, TypeScript, Tailwind CSS', NULL, 'proj_1787627783.jpg', NULL, NULL, NULL, '2026-08-25 05:16:07', NULL, NULL);

-- Dumping structure for table portfolio_db.tech_stack
CREATE TABLE IF NOT EXISTS `tech_stack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT 'language',
  `icon` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table portfolio_db.tech_stack: ~18 rows (approximately)
INSERT INTO `tech_stack` (`id`, `name`, `category`, `icon`, `created_at`) VALUES
	(2, 'HTML', 'language', 'fa-brands fa-html5 text-danger', '2026-08-25 13:18:26'),
	(3, 'CSS', 'language', 'fa-brands fa-css3-alt text-primary', '2026-08-25 13:18:26'),
	(4, 'JavaScript', 'language', 'fa-brands fa-js text-warning', '2026-08-25 13:18:26'),
	(5, 'PHP', 'language', 'fa-brands fa-php text-primary', '2026-08-25 13:18:26'),
	(6, 'Java', 'language', 'fa-brands fa-java text-danger', '2026-08-25 13:18:26'),
	(7, 'MySQL', 'language', 'fa-solid fa-database text-info', '2026-08-25 13:18:26'),
	(8, 'Bootstrap', 'language', 'fa-brands fa-bootstrap text-purple', '2026-08-25 13:18:26'),
	(9, 'Linux', 'language', 'fa-brands fa-linux text-dark', '2026-08-25 13:18:26'),
	(10, 'Git', 'language', 'fa-brands fa-git-alt text-danger', '2026-08-25 13:18:26'),
	(11, 'Python', 'language', 'fa-brands fa-python text-warning', '2026-08-25 13:18:26'),
	(12, 'Data Manipulation', 'concept', 'fa-solid fa-sliders', '2026-08-25 13:18:26'),
	(13, 'Database Administration', 'concept', 'fa-solid fa-database', '2026-08-25 13:18:26'),
	(14, 'File Management', 'concept', 'fa-solid fa-folder-open', '2026-08-25 13:18:26'),
	(15, 'Internet of Things', 'concept', 'fa-solid fa-microchip', '2026-08-25 13:18:26'),
	(16, 'Object-Oriented Programming', 'concept', 'fa-solid fa-cubes', '2026-08-25 13:18:26'),
	(17, 'Software Development', 'concept', 'fa-solid fa-code', '2026-08-25 13:18:26'),
	(18, 'Web Applications', 'concept', 'fa-solid fa-globe', '2026-08-25 13:18:26'),
	(23, 'Amazon', 'Languages & Essentials', 'fa-brands fa-aws text-warning', '2026-08-25 17:04:27');

-- Dumping structure for table portfolio_db.user_profile
CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `required_hours` decimal(6,2) DEFAULT 500.00,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table portfolio_db.user_profile: ~2 rows (approximately)
INSERT INTO `user_profile` (`id`, `full_name`, `bio`, `profile_image`, `required_hours`) VALUES
	(1, 'Aerhon Louis Magtira', 'I am a fresh BSIT Graduate who just finished a bachelor\'s degree as Magna Cum Laude. I am currently a Web Development Engineer specializing in Web Applications, PHP, CodeIgniter 3, and modern frontend design. ', NULL, 500.00),
	(4, '', '', NULL, 400.00);

-- Dumping structure for table portfolio_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `role` enum('admin','intern') NOT NULL DEFAULT 'intern',
  `account_status` enum('pending','approved','rejected','active','done','terminated','deactivated') NOT NULL DEFAULT 'pending',
  `role_position` varchar(50) DEFAULT 'Web Developer',
  `student_id` varchar(50) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `year_section` varchar(50) DEFAULT NULL,
  `academic_year` varchar(20) DEFAULT NULL,
  `semester` varchar(30) DEFAULT NULL,
  `profile_completed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table portfolio_db.users: ~8 rows (approximately)
INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `email`, `username`, `password`, `created_at`, `role`, `account_status`, `role_position`, `student_id`, `gender`, `birthday`, `school`, `year_section`, `academic_year`, `semester`, `profile_completed`) VALUES
	(18, 'Jim', '', 'Doe', 'jimmydoe@gmail.com', 'jimmydoe@gmail.com', '$2y$10$9Tw5jEopP6kBf9tpEFFzZenkTo7zoZT9YOcjuf/cr/tfaKqcDR8Ou', '2026-09-03 10:37:27', 'intern', 'active', 'Web Developer', '', 'Male', '2026-09-03', 'St. Dominic College of Asia', 'BSIT - 4A', '2026-2027', '1st Semester', 1),
	(19, 'Jenny', '', 'Doe', 'jennydoe@gmail.com', 'jennydoe@gmail.com', '$2y$10$sA7P5CkYGQ6ff5/YQ5mza.2YV8sd4iNtoednm/Pzfj2vy4H2cQK6O', '2026-09-03 10:45:46', 'intern', 'active', 'Web Developer', '', 'Female', '2026-09-03', 'St. Dominic College of Arts and Sciences', 'BSIT - 4A', '2026-2027', '1st Semester', 1),
	(21, 'admin', NULL, 'istrator', 'admin@sdca.edu.ph', 'admin@sdca.edu.ph', 'Sdca@2026', '2026-09-03 10:49:30', 'admin', 'approved', 'Web Developer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
	(23, 'Cael', '', 'Fernandez', 'michaelfernandez@gmail.com', 'michaelfernandez@gmail.com', '$2y$10$tfq2Fgds8FcVOd79LXxp7ufMjljScEfEKD3ZQKcKFoOIqiYN4EUpK', '2026-09-04 09:34:15', 'intern', 'active', 'Technical Support', '', 'Male', '2026-09-01', 'St. Nomo', 'BSIT - 4A', '2026-2027', '2nd Semester', 1),
	(26, 'CJ', '', 'Perez', 'buuzzerbeater14@gmail.com', 'buuzzerbeater14@gmail.com', '$2y$10$5g.71fgn4llZ6Uej0JQL4.ajcUmBBk2DsEiHVwzhfiVl9sjZEI5se', '2026-09-04 15:43:28', 'intern', 'active', 'Web Developer', '', NULL, NULL, '', '', '', '', 0),
	(27, 'Chris', '', 'Phee', 'moonton@gmail.com', 'moonton@gmail.com', '$2y$10$HAyudcHRCvtiUknF94upce14mi/.iAJQLtKK5zQZTLT/vsqEKGMJW', '2026-09-04 15:51:28', 'intern', 'active', 'Web Developer', '', NULL, NULL, '', '', '', '', 0),
	(29, 'Nicolette', '', 'Santos', 'nicolette.santos@sdca.edu.ph', 'nicolette.santos@sdca.edu.ph', '$2y$10$9fINGge2.gUX/t1C4cgGaOpHsBvNzELna.CZxAnboL8O34e2chGGy', '2026-09-07 01:13:43', 'intern', 'approved', 'Web Developer', NULL, 'Female', '2004-07-10', 'St. Dominic College of Asia', 'BSIT - 4A', '2026-2027', '2nd Semester', 1),
	(30, 'Aerhon', '', 'Magtira', 'aerhonlouis_magtira@sdca.edu.ph', 'aerhonlouis_magtira@sdca.edu.ph', '$2y$10$9FAWbLUwAnT4XfN0zJUvtO46Y6vwlAcTNHy4yqD.8bltr4tMde9XS', '2026-09-07 02:09:33', 'intern', 'approved', 'Web Developer', NULL, 'Male', '2003-05-31', 'Cavite School of St. Mark', 'BSIT - 4A', '2026-2027', '2nd Semester', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
