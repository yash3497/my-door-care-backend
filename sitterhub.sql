-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 28, 2025 at 06:37 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sitterhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_baby_pats`
--

CREATE TABLE `add_baby_pats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `profession_type` int(11) NOT NULL COMMENT '1=Baby Sitter,2=Pet Sitter',
  `profession_type_details` text NOT NULL,
  `image` varchar(191) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `add_coins`
--

CREATE TABLE `add_coins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coin` bigint(20) UNSIGNED NOT NULL,
  `price` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'ADMIN',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `mobile_code` varchar(10) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip_postal` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `device_id` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `device_info` text DEFAULT NULL,
  `last_logged_in` timestamp NULL DEFAULT NULL,
  `last_logged_out` timestamp NULL DEFAULT NULL,
  `login_status` tinyint(1) NOT NULL DEFAULT 0,
  `notification_clear_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin_role_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `firstname`, `lastname`, `username`, `user_type`, `email`, `password`, `image`, `email_verified_at`, `remember_token`, `mobile_code`, `phone`, `country`, `city`, `state`, `zip_postal`, `address`, `device_id`, `status`, `device_info`, `last_logged_in`, `last_logged_out`, `login_status`, `notification_clear_at`, `created_at`, `updated_at`, `admin_role_id`) VALUES
(1, 'Jhon', 'Smith', 'admin', 'ADMIN', 'superadmin@appdevs.net', '$2y$10$KLn6ypfyATA41CrwGRdUyetm5.kfaAOXkVEY/noBa.Z8e6zEfyMKG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 0, NULL, '2025-03-27 13:44:26', '2025-03-27 13:44:26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_has_roles`
--

CREATE TABLE `admin_has_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `admin_role_id` bigint(20) UNSIGNED NOT NULL,
  `last_edit_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_has_roles`
--

INSERT INTO `admin_has_roles` (`id`, `admin_id`, `admin_role_id`, `last_edit_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2025-03-27 13:44:26', '2025-03-27 13:44:26');

-- --------------------------------------------------------

--
-- Table structure for table `admin_login_logs`
--

CREATE TABLE `admin_login_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `mac` varchar(17) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `browser` varchar(30) DEFAULT NULL,
  `os` varchar(30) DEFAULT NULL,
  `timezone` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_roles`
--

CREATE TABLE `admin_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `admin_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super Admin', 1, '2025-03-27 13:44:26', '2025-03-27 13:44:26'),
(2, 1, 'Sub Admin', 1, '2025-03-27 13:44:26', '2025-03-27 13:44:26'),
(3, 1, 'Moderator', 1, '2025-03-27 13:44:26', '2025-03-27 13:44:26'),
(4, 1, 'Editor', 1, '2025-03-27 13:44:26', '2025-03-27 13:44:26'),
(5, 1, 'Support Member', 1, '2025-03-27 13:44:26', '2025-03-27 13:44:26');

-- --------------------------------------------------------

--
-- Table structure for table `admin_role_has_permissions`
--

CREATE TABLE `admin_role_has_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_role_permission_id` bigint(20) UNSIGNED NOT NULL,
  `route` varchar(100) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `last_edit_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_role_permissions`
--

CREATE TABLE `admin_role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_role_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `slug` varchar(80) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_onboard_screens`
--

CREATE TABLE `app_onboard_screens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `last_edit_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_onboard_screens`
--

INSERT INTO `app_onboard_screens` (`id`, `title`, `sub_title`, `image`, `status`, `last_edit_by`, `created_at`, `updated_at`) VALUES
(1, 'Make Every Second Count', 'Earn money by selling sitter hub using sitter hub application', '5fd14c85-6433-4a31-99f2-a0bed6845e6e.webp', 1, 1, '2023-06-23 11:05:09', '2023-12-13 10:53:44'),
(2, 'Make Every Second Count', 'Earn money by selling sitter hub using sitter hub application', '965ca8b7-e19f-4734-8a88-c67afe064bc9.webp', 1, 1, '2023-10-14 06:24:20', '2023-12-13 10:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(50) DEFAULT NULL,
  `splash_screen_image` varchar(255) DEFAULT NULL,
  `url_title` varchar(191) DEFAULT NULL,
  `android_url` varchar(255) DEFAULT NULL,
  `iso_url` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `version`, `splash_screen_image`, `url_title`, `android_url`, `iso_url`, `created_at`, `updated_at`) VALUES
(1, '1.2.0', '6882c134-ade3-4485-b8d5-2c2888ece44e.webp', 'App Title', 'https://play.google.com/store', 'https://www.apple.com/app-store/', '2023-05-16 00:29:38', '2023-12-13 10:53:07');

-- --------------------------------------------------------

--
-- Table structure for table `basic_settings`
--

CREATE TABLE `basic_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(100) DEFAULT NULL,
  `site_title` varchar(255) DEFAULT NULL,
  `base_color` varchar(50) DEFAULT NULL,
  `secondary_color` varchar(50) DEFAULT NULL,
  `otp_exp_seconds` int(11) DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `user_registration` tinyint(1) NOT NULL DEFAULT 1,
  `secure_password` tinyint(1) NOT NULL DEFAULT 0,
  `agree_policy` tinyint(1) NOT NULL DEFAULT 0,
  `force_ssl` tinyint(1) NOT NULL DEFAULT 0,
  `email_verification` tinyint(1) NOT NULL DEFAULT 0,
  `sms_verification` tinyint(1) NOT NULL DEFAULT 0,
  `email_notification` tinyint(1) NOT NULL DEFAULT 0,
  `push_notification` tinyint(1) NOT NULL DEFAULT 0,
  `kyc_verification` tinyint(1) NOT NULL DEFAULT 0,
  `site_logo_dark` varchar(255) DEFAULT NULL,
  `site_logo` varchar(255) DEFAULT NULL,
  `site_fav_dark` varchar(255) DEFAULT NULL,
  `site_fav` varchar(255) DEFAULT NULL,
  `mail_config` text DEFAULT NULL,
  `mail_activity` text DEFAULT NULL,
  `push_notification_config` text DEFAULT NULL,
  `push_notification_activity` text DEFAULT NULL,
  `broadcast_config` text DEFAULT NULL,
  `broadcast_activity` text DEFAULT NULL,
  `sms_config` text DEFAULT NULL,
  `sms_activity` text DEFAULT NULL,
  `web_version` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `basic_settings`
--

INSERT INTO `basic_settings` (`id`, `site_name`, `site_title`, `base_color`, `secondary_color`, `otp_exp_seconds`, `timezone`, `user_registration`, `secure_password`, `agree_policy`, `force_ssl`, `email_verification`, `sms_verification`, `email_notification`, `push_notification`, `kyc_verification`, `site_logo_dark`, `site_logo`, `site_fav_dark`, `site_fav`, `mail_config`, `mail_activity`, `push_notification_config`, `push_notification_activity`, `broadcast_config`, `broadcast_activity`, `sms_config`, `sms_activity`, `web_version`, `created_at`, `updated_at`) VALUES
(1, 'SitterHub', 'Baby and Pet Sitting Services Platform', '#FF735F', '#ea5455', 3600, 'Asia/Dhaka', 1, 1, 1, 1, 1, 1, 1, 1, 1, 'seeder/logo.webp', 'seeder/logo.webp', 'seeder/fav-icon.webp', 'seeder/fav-icon.webp', '{\"method\":\"\",\"host\":\"\",\"port\":\"\",\"encryption\":\"\",\"username\":\"\",\"password\":\"\",\"from\":\"\",\"app_name\":\"SitterHub\"}', NULL, '{\"method\":\"pusher\",\"instance_id\":\"\",\"primary_key\":\"\"}', NULL, '{\"method\":\"pusher\",\"app_id\":\"\",\"primary_key\":\"\",\"secret_key\":\"\",\"cluster\":\"\"}', NULL, NULL, NULL, '1.2.0', '2023-05-16 00:29:38', '2023-07-09 05:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `title` text DEFAULT NULL,
  `slug` text DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `tags` longtext DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `admin_id`, `title`, `slug`, `image`, `tags`, `description`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, '{\"language\":{\"en\":{\"title\":\"Behind the Scenes: Ensuring Safety in Sitter Selection\"},\"es\":{\"title\":\"Detr\\u00e1s de escena: garantizar la seguridad en la selecci\\u00f3n de ni\\u00f1eras\"},\"ar\":{\"title\":\"\\u062e\\u0644\\u0641 \\u0627\\u0644\\u0643\\u0648\\u0627\\u0644\\u064a\\u0633: \\u0636\\u0645\\u0627\\u0646 \\u0627\\u0644\\u0633\\u0644\\u0627\\u0645\\u0629 \\u0641\\u064a \\u0627\\u062e\\u062a\\u064a\\u0627\\u0631 \\u0627\\u0644\\u062d\\u0627\\u0636\\u0646\\u0629\"},\"hi\":{\"title\":\"\\u092a\\u0930\\u0926\\u0947 \\u0915\\u0947 \\u092a\\u0940\\u091b\\u0947: \\u0938\\u093f\\u091f\\u0930 \\u091a\\u092f\\u0928 \\u092e\\u0947\\u0902 \\u0938\\u0941\\u0930\\u0915\\u094d\\u0937\\u093e \\u0938\\u0941\\u0928\\u093f\\u0936\\u094d\\u091a\\u093f\\u0924 \\u0915\\u0930\\u0928\\u093e\"},\"fr\":{\"title\":\"Dans les coulisses : garantir la s\\u00e9curit\\u00e9 lors de la s\\u00e9lection des baby-sitters\"}}}', 'behind-the-scenes-ensuring-safety-in-sitter-selection', '3299d201-2650-4900-88ff-986ccb32bc77.webp', '[\"cat\",\"nanny\",\"appdevs\"]', '{\"language\":{\"en\":{\"description\":\"<p>At SitterHub, the safety of your family is paramount. This blog takes you behind the scenes, providing an in-depth look at the meticulous process we employ to ensure the trustworthiness of our sitters. From rigorous background checks to comprehensive vetting, learn how we go the extra mile to create a secure environment for your loved ones, ensuring peace of mind in your sitter selection process.<\\/p>\"},\"es\":{\"description\":\"<p>En SitterHub, la seguridad de tu familia es primordial. Este blog lo lleva detr\\u00e1s de escena y brinda una mirada en profundidad al meticuloso proceso que empleamos para garantizar la confiabilidad de nuestros cuidadores. Desde verificaciones de antecedentes rigurosas hasta investigaciones exhaustivas, aprenda c\\u00f3mo hacemos un esfuerzo adicional para crear un entorno seguro para sus seres queridos, garantizando tranquilidad en su proceso de selecci\\u00f3n de cuidadores.<\\/p>\"},\"ar\":{\"description\":\"<p>\\u0641\\u064a SitterHub\\u060c \\u062a\\u0639\\u062a\\u0628\\u0631 \\u0633\\u0644\\u0627\\u0645\\u0629 \\u0639\\u0627\\u0626\\u0644\\u062a\\u0643 \\u0623\\u0645\\u0631\\u064b\\u0627 \\u0628\\u0627\\u0644\\u063a \\u0627\\u0644\\u0623\\u0647\\u0645\\u064a\\u0629. \\u062a\\u0623\\u062e\\u0630\\u0643 \\u0647\\u0630\\u0647 \\u0627\\u0644\\u0645\\u062f\\u0648\\u0646\\u0629 \\u0625\\u0644\\u0649 \\u0645\\u0627 \\u0648\\u0631\\u0627\\u0621 \\u0627\\u0644\\u0643\\u0648\\u0627\\u0644\\u064a\\u0633\\u060c \\u0648\\u062a\\u0642\\u062f\\u0645 \\u0646\\u0638\\u0631\\u0629 \\u0645\\u062a\\u0639\\u0645\\u0642\\u0629 \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0639\\u0645\\u0644\\u064a\\u0629 \\u0627\\u0644\\u062f\\u0642\\u064a\\u0642\\u0629 \\u0627\\u0644\\u062a\\u064a \\u0646\\u0633\\u062a\\u062e\\u062f\\u0645\\u0647\\u0627 \\u0644\\u0636\\u0645\\u0627\\u0646 \\u0645\\u0635\\u062f\\u0627\\u0642\\u064a\\u0629 \\u062c\\u0644\\u064a\\u0633\\u0627\\u062a\\u0646\\u0627. \\u0628\\u062f\\u0621\\u064b\\u0627 \\u0645\\u0646 \\u0641\\u062d\\u0648\\u0635\\u0627\\u062a \\u0627\\u0644\\u062e\\u0644\\u0641\\u064a\\u0629 \\u0627\\u0644\\u0635\\u0627\\u0631\\u0645\\u0629 \\u0648\\u062d\\u062a\\u0649 \\u0627\\u0644\\u0641\\u062d\\u0635 \\u0627\\u0644\\u0634\\u0627\\u0645\\u0644\\u060c \\u062a\\u0639\\u0644\\u0645 \\u0643\\u064a\\u0641 \\u0646\\u0628\\u0630\\u0644 \\u0642\\u0635\\u0627\\u0631\\u0649 \\u062c\\u0647\\u062f\\u0646\\u0627 \\u0644\\u062e\\u0644\\u0642 \\u0628\\u064a\\u0626\\u0629 \\u0622\\u0645\\u0646\\u0629 \\u0644\\u0623\\u062d\\u0628\\u0627\\u0626\\u0643\\u060c \\u0645\\u0645\\u0627 \\u064a\\u0636\\u0645\\u0646 \\u0631\\u0627\\u062d\\u0629 \\u0627\\u0644\\u0628\\u0627\\u0644 \\u0641\\u064a \\u0639\\u0645\\u0644\\u064a\\u0629 \\u0627\\u062e\\u062a\\u064a\\u0627\\u0631 \\u0627\\u0644\\u062d\\u0627\\u0636\\u0646\\u0629 \\u0627\\u0644\\u062e\\u0627\\u0635\\u0629 \\u0628\\u0643.<\\/p>\"},\"hi\":{\"description\":\"<p>\\u0938\\u093f\\u091f\\u0930\\u0939\\u092c \\u092e\\u0947\\u0902, \\u0906\\u092a\\u0915\\u0947 \\u092a\\u0930\\u093f\\u0935\\u093e\\u0930 \\u0915\\u0940 \\u0938\\u0941\\u0930\\u0915\\u094d\\u0937\\u093e \\u0938\\u0930\\u094d\\u0935\\u094b\\u092a\\u0930\\u093f \\u0939\\u0948\\u0964 \\u092f\\u0939 \\u092c\\u094d\\u0932\\u0949\\u0917 \\u0906\\u092a\\u0915\\u094b \\u092a\\u0930\\u094d\\u0926\\u0947 \\u0915\\u0947 \\u092a\\u0940\\u091b\\u0947 \\u0932\\u0947 \\u091c\\u093e\\u0924\\u093e \\u0939\\u0948, \\u0939\\u092e\\u093e\\u0930\\u0947 \\u0938\\u093f\\u091f\\u0930 \\u0915\\u0940 \\u0935\\u093f\\u0936\\u094d\\u0935\\u0938\\u0928\\u0940\\u092f\\u0924\\u093e \\u0938\\u0941\\u0928\\u093f\\u0936\\u094d\\u091a\\u093f\\u0924 \\u0915\\u0930\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0939\\u092e\\u093e\\u0930\\u0947 \\u0926\\u094d\\u0935\\u093e\\u0930\\u093e \\u0905\\u092a\\u0928\\u093e\\u0908 \\u091c\\u093e\\u0928\\u0947 \\u0935\\u093e\\u0932\\u0940 \\u0938\\u093e\\u0935\\u0927\\u093e\\u0928\\u0940\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092a\\u094d\\u0930\\u0915\\u094d\\u0930\\u093f\\u092f\\u093e \\u092a\\u0930 \\u0917\\u0939\\u0930\\u093e\\u0908 \\u0938\\u0947 \\u0928\\u091c\\u093c\\u0930 \\u0921\\u093e\\u0932\\u0924\\u093e \\u0939\\u0948\\u0964 \\u0915\\u0920\\u094b\\u0930 \\u092a\\u0943\\u0937\\u094d\\u0920\\u092d\\u0942\\u092e\\u093f \\u091c\\u093e\\u0901\\u091a \\u0938\\u0947 \\u0932\\u0947\\u0915\\u0930 \\u0935\\u094d\\u092f\\u093e\\u092a\\u0915 \\u091c\\u093e\\u0901\\u091a \\u0924\\u0915, \\u091c\\u093e\\u0928\\u0947\\u0902 \\u0915\\u093f \\u0939\\u092e \\u0906\\u092a\\u0915\\u0947 \\u092a\\u094d\\u0930\\u093f\\u092f\\u091c\\u0928\\u094b\\u0902 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u090f\\u0915 \\u0938\\u0941\\u0930\\u0915\\u094d\\u0937\\u093f\\u0924 \\u0935\\u093e\\u0924\\u093e\\u0935\\u0930\\u0923 \\u092c\\u0928\\u093e\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0915\\u0948\\u0938\\u0947 \\u0905\\u0924\\u093f\\u0930\\u093f\\u0915\\u094d\\u0924 \\u092a\\u094d\\u0930\\u092f\\u093e\\u0938 \\u0915\\u0930\\u0924\\u0947 \\u0939\\u0948\\u0902, \\u091c\\u093f\\u0938\\u0938\\u0947 \\u0906\\u092a\\u0915\\u0947 \\u0938\\u093f\\u091f\\u0930 \\u091a\\u092f\\u0928 \\u092a\\u094d\\u0930\\u0915\\u094d\\u0930\\u093f\\u092f\\u093e \\u092e\\u0947\\u0902 \\u092e\\u0928 \\u0915\\u0940 \\u0936\\u093e\\u0902\\u0924\\u093f \\u0938\\u0941\\u0928\\u093f\\u0936\\u094d\\u091a\\u093f\\u0924 \\u0939\\u094b\\u0924\\u0940 \\u0939\\u0948\\u0964<\\/p>\"},\"fr\":{\"description\":\"<p>Chez SitterHub, la s\\u00e9curit\\u00e9 de votre famille est primordiale. Ce blog vous emm\\u00e8ne dans les coulisses et vous offre un aper\\u00e7u d\\u00e9taill\\u00e9 du processus m\\u00e9ticuleux que nous employons pour garantir la fiabilit\\u00e9 de nos baby-sitters. Des v\\u00e9rifications d\'ant\\u00e9c\\u00e9dents rigoureuses aux contr\\u00f4les complets, d\\u00e9couvrez comment nous faisons le maximum pour cr\\u00e9er un environnement s\\u00e9curis\\u00e9 pour vos proches, garantissant ainsi la tranquillit\\u00e9 d\'esprit dans votre processus de s\\u00e9lection de baby-sitter.<\\/p>\"}}}', 1, '2024-11-15 04:49:13', '2024-11-15 04:49:13'),
(5, 1, '{\"language\":{\"en\":{\"title\":\"Flexibility in Parenting: Embracing On-Demand Care with SitterHub\"},\"es\":{\"title\":\"Flexibilidad en la crianza de los hijos: adopci\\u00f3n de la atenci\\u00f3n a pedido con SitterHub\"},\"ar\":{\"title\":\"\\u0627\\u0644\\u0645\\u0631\\u0648\\u0646\\u0629 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0628\\u0648\\u0629 \\u0648\\u0627\\u0644\\u0623\\u0645\\u0648\\u0645\\u0629: \\u0627\\u062d\\u062a\\u0636\\u0627\\u0646 \\u0627\\u0644\\u0631\\u0639\\u0627\\u064a\\u0629 \\u0639\\u0646\\u062f \\u0627\\u0644\\u0637\\u0644\\u0628 \\u0645\\u0639 SitterHub\"},\"hi\":{\"title\":\"\\u092a\\u0947\\u0930\\u0947\\u0902\\u091f\\u093f\\u0902\\u0917 \\u092e\\u0947\\u0902 \\u0932\\u091a\\u0940\\u0932\\u093e\\u092a\\u0928: \\u0938\\u093f\\u091f\\u0930\\u0939\\u092c \\u0915\\u0947 \\u0938\\u093e\\u0925 \\u0911\\u0928-\\u0921\\u093f\\u092e\\u093e\\u0902\\u0921 \\u0926\\u0947\\u0916\\u092d\\u093e\\u0932 \\u0915\\u094b \\u0905\\u092a\\u0928\\u093e\\u0928\\u093e\"},\"fr\":{\"title\":\"Flexibilit\\u00e9 dans la parentalit\\u00e9 : adopter la garde \\u00e0 la demande avec SitterHub\"}}}', 'flexibility-in-parenting-embracing-on-demand-care-with-sitterhub', '3da8f9fd-1099-485f-a510-6128c93a1369.webp', '[\"appdevs\",\"baby\"]', '{\"language\":{\"en\":{\"description\":\"<p>Modern parenting demands flexibility, and SitterHub is here to empower you with on-demand care solutions. This blog explores how SitterHub\\u2019s platform caters to the dynamic needs of parents, offering flexible scheduling options that allow you to find a caregiver for spontaneous date nights, last-minute meetings, or regular assistance. Discover how embracing on-demand care can bring balance to your parenting journey.<\\/p>\"},\"es\":{\"description\":\"<p>La crianza de los hijos moderna exige flexibilidad y SitterHub est\\u00e1 aqu\\u00ed para brindarle soluciones de atenci\\u00f3n a pedido. Este blog explora c\\u00f3mo la plataforma de SitterHub satisface las necesidades din\\u00e1micas de los padres, ofreciendo opciones de programaci\\u00f3n flexibles que le permiten encontrar un cuidador para citas nocturnas espont\\u00e1neas, reuniones de \\u00faltimo momento o asistencia regular. Descubra c\\u00f3mo adoptar la atenci\\u00f3n a pedido puede aportar equilibrio a su trayectoria como padre.<\\/p>\"},\"ar\":{\"description\":\"<p>\\u062a\\u062a\\u0637\\u0644\\u0628 \\u0627\\u0644\\u0623\\u0628\\u0648\\u0629 \\u0648\\u0627\\u0644\\u0623\\u0645\\u0648\\u0645\\u0629 \\u0627\\u0644\\u062d\\u062f\\u064a\\u062b\\u0629 \\u0627\\u0644\\u0645\\u0631\\u0648\\u0646\\u0629\\u060c \\u0648SitterHub \\u0647\\u0646\\u0627 \\u0644\\u062a\\u0632\\u0648\\u064a\\u062f\\u0643 \\u0628\\u062d\\u0644\\u0648\\u0644 \\u0627\\u0644\\u0631\\u0639\\u0627\\u064a\\u0629 \\u0639\\u0646\\u062f \\u0627\\u0644\\u0637\\u0644\\u0628. \\u062a\\u0633\\u062a\\u0643\\u0634\\u0641 \\u0647\\u0630\\u0647 \\u0627\\u0644\\u0645\\u062f\\u0648\\u0646\\u0629 \\u0643\\u064a\\u0641 \\u062a\\u0644\\u0628\\u064a \\u0645\\u0646\\u0635\\u0629 SitterHub \\u0627\\u0644\\u0627\\u062d\\u062a\\u064a\\u0627\\u062c\\u0627\\u062a \\u0627\\u0644\\u062f\\u064a\\u0646\\u0627\\u0645\\u064a\\u0643\\u064a\\u0629 \\u0644\\u0644\\u0622\\u0628\\u0627\\u0621\\u060c \\u062d\\u064a\\u062b \\u062a\\u0642\\u062f\\u0645 \\u062e\\u064a\\u0627\\u0631\\u0627\\u062a \\u062c\\u062f\\u0648\\u0644\\u0629 \\u0645\\u0631\\u0646\\u0629 \\u062a\\u0633\\u0645\\u062d \\u0644\\u0643 \\u0628\\u0627\\u0644\\u0639\\u062b\\u0648\\u0631 \\u0639\\u0644\\u0649 \\u0645\\u0642\\u062f\\u0645 \\u0631\\u0639\\u0627\\u064a\\u0629 \\u0644\\u0644\\u064a\\u0627\\u0644\\u064a \\u0627\\u0644\\u0645\\u0648\\u0627\\u0639\\u062f\\u0629 \\u0627\\u0644\\u062a\\u0644\\u0642\\u0627\\u0626\\u064a\\u0629\\u060c \\u0623\\u0648 \\u0627\\u062c\\u062a\\u0645\\u0627\\u0639\\u0627\\u062a \\u0627\\u0644\\u0644\\u062d\\u0638\\u0629 \\u0627\\u0644\\u0623\\u062e\\u064a\\u0631\\u0629\\u060c \\u0623\\u0648 \\u0627\\u0644\\u0645\\u0633\\u0627\\u0639\\u062f\\u0629 \\u0627\\u0644\\u0645\\u0646\\u062a\\u0638\\u0645\\u0629. \\u0627\\u0643\\u062a\\u0634\\u0641 \\u0643\\u064a\\u0641 \\u064a\\u0645\\u0643\\u0646 \\u0623\\u0646 \\u064a\\u0624\\u062f\\u064a \\u062a\\u0628\\u0646\\u064a \\u0627\\u0644\\u0631\\u0639\\u0627\\u064a\\u0629 \\u0639\\u0646\\u062f \\u0627\\u0644\\u0637\\u0644\\u0628 \\u0625\\u0644\\u0649 \\u062a\\u062d\\u0642\\u064a\\u0642 \\u0627\\u0644\\u062a\\u0648\\u0627\\u0632\\u0646 \\u0641\\u064a \\u0631\\u062d\\u0644\\u0629 \\u0627\\u0644\\u0623\\u0628\\u0648\\u0629 \\u0648\\u0627\\u0644\\u0623\\u0645\\u0648\\u0645\\u0629.<\\/p>\"},\"hi\":{\"description\":\"<p>\\u0906\\u0927\\u0941\\u0928\\u093f\\u0915 \\u092a\\u0947\\u0930\\u0947\\u0902\\u091f\\u093f\\u0902\\u0917 \\u092e\\u0947\\u0902 \\u0932\\u091a\\u0940\\u0932\\u0947\\u092a\\u0928 \\u0915\\u0940 \\u0906\\u0935\\u0936\\u094d\\u092f\\u0915\\u0924\\u093e \\u0939\\u094b\\u0924\\u0940 \\u0939\\u0948, \\u0914\\u0930 \\u0938\\u093f\\u091f\\u0930\\u0939\\u092c \\u0906\\u092a\\u0915\\u094b \\u0911\\u0928-\\u0921\\u093f\\u092e\\u093e\\u0902\\u0921 \\u0926\\u0947\\u0916\\u092d\\u093e\\u0932 \\u0938\\u092e\\u093e\\u0927\\u093e\\u0928\\u094b\\u0902 \\u0915\\u0947 \\u0938\\u093e\\u0925 \\u0938\\u0936\\u0915\\u094d\\u0924 \\u092c\\u0928\\u093e\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u092e\\u094c\\u091c\\u0942\\u0926 \\u0939\\u0948\\u0964 \\u092f\\u0939 \\u092c\\u094d\\u0932\\u0949\\u0917 \\u092c\\u0924\\u093e\\u0924\\u093e \\u0939\\u0948 \\u0915\\u093f \\u0938\\u093f\\u091f\\u0930\\u0939\\u092c \\u0915\\u093e \\u092a\\u094d\\u0932\\u0947\\u091f\\u092b\\u093c\\u0949\\u0930\\u094d\\u092e \\u0915\\u093f\\u0938 \\u0924\\u0930\\u0939 \\u0938\\u0947 \\u092e\\u093e\\u0924\\u093e-\\u092a\\u093f\\u0924\\u093e \\u0915\\u0940 \\u0917\\u0924\\u093f\\u0936\\u0940\\u0932 \\u091c\\u093c\\u0930\\u0942\\u0930\\u0924\\u094b\\u0902 \\u0915\\u094b \\u092a\\u0942\\u0930\\u093e \\u0915\\u0930\\u0924\\u093e \\u0939\\u0948, \\u0932\\u091a\\u0940\\u0932\\u0947 \\u0936\\u0947\\u0921\\u094d\\u092f\\u0942\\u0932\\u093f\\u0902\\u0917 \\u0935\\u093f\\u0915\\u0932\\u094d\\u092a \\u092a\\u094d\\u0930\\u0926\\u093e\\u0928 \\u0915\\u0930\\u0924\\u093e \\u0939\\u0948 \\u091c\\u094b \\u0906\\u092a\\u0915\\u094b \\u0905\\u091a\\u093e\\u0928\\u0915 \\u0921\\u0947\\u091f \\u0928\\u093e\\u0907\\u091f\\u094d\\u0938, \\u0906\\u0916\\u093f\\u0930\\u0940 \\u092e\\u093f\\u0928\\u091f \\u0915\\u0940 \\u092e\\u0940\\u091f\\u093f\\u0902\\u0917 \\u092f\\u093e \\u0928\\u093f\\u092f\\u092e\\u093f\\u0924 \\u0938\\u0939\\u093e\\u092f\\u0924\\u093e \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0926\\u0947\\u0916\\u092d\\u093e\\u0932 \\u0915\\u0930\\u0928\\u0947 \\u0935\\u093e\\u0932\\u0947 \\u0915\\u094b \\u0916\\u094b\\u091c\\u0928\\u0947 \\u0915\\u0940 \\u0905\\u0928\\u0941\\u092e\\u0924\\u093f \\u0926\\u0947\\u0924\\u093e \\u0939\\u0948\\u0964 \\u091c\\u093e\\u0928\\u0947\\u0902 \\u0915\\u093f \\u0911\\u0928-\\u0921\\u093f\\u092e\\u093e\\u0902\\u0921 \\u0926\\u0947\\u0916\\u092d\\u093e\\u0932 \\u0915\\u094b \\u0905\\u092a\\u0928\\u093e\\u0928\\u0947 \\u0938\\u0947 \\u0906\\u092a\\u0915\\u0940 \\u092a\\u0947\\u0930\\u0947\\u0902\\u091f\\u093f\\u0902\\u0917 \\u092f\\u093e\\u0924\\u094d\\u0930\\u093e \\u092e\\u0947\\u0902 \\u0915\\u0948\\u0938\\u0947 \\u0938\\u0902\\u0924\\u0941\\u0932\\u0928 \\u0906 \\u0938\\u0915\\u0924\\u093e \\u0939\\u0948\\u0964<\\/p>\"},\"fr\":{\"description\":\"<p>La parentalit\\u00e9 moderne exige de la flexibilit\\u00e9, et SitterHub est l\\u00e0 pour vous offrir des solutions de garde \\u00e0 la demande. Ce blog explore la mani\\u00e8re dont la plateforme de SitterHub r\\u00e9pond aux besoins dynamiques des parents, en proposant des options de planification flexibles qui vous permettent de trouver une personne pour vous occuper de vos enfants lors de soir\\u00e9es spontan\\u00e9es, de r\\u00e9unions de derni\\u00e8re minute ou d\'une assistance r\\u00e9guli\\u00e8re. D\\u00e9couvrez comment l\'adoption de services de garde \\u00e0 la demande peut apporter un \\u00e9quilibre \\u00e0 votre parcours parental.<\\/p>\"}}}', 1, '2024-11-15 04:56:09', '2024-11-15 04:56:09'),
(6, 1, '{\"language\":{\"en\":{\"title\":\"The Art of Finding the Perfect Sitter: A Guide to Stress-Free Searching\"},\"es\":{\"title\":\"El arte de encontrar la ni\\u00f1era perfecta: una gu\\u00eda para una b\\u00fasqueda sin estr\\u00e9s\"},\"ar\":{\"title\":\"\\u0641\\u0646 \\u0627\\u0644\\u0639\\u062b\\u0648\\u0631 \\u0639\\u0644\\u0649 \\u0627\\u0644\\u062d\\u0627\\u0636\\u0646\\u0629 \\u0627\\u0644\\u0645\\u062b\\u0627\\u0644\\u064a\\u0629: \\u062f\\u0644\\u064a\\u0644 \\u0644\\u0644\\u0628\\u062d\\u062b \\u0627\\u0644\\u062e\\u0627\\u0644\\u064a \\u0645\\u0646 \\u0627\\u0644\\u062a\\u0648\\u062a\\u0631\"},\"hi\":{\"title\":\"\\u0938\\u0939\\u0940 \\u0938\\u093f\\u091f\\u0930 \\u0916\\u094b\\u091c\\u0928\\u0947 \\u0915\\u0940 \\u0915\\u0932\\u093e: \\u0924\\u0928\\u093e\\u0935 \\u092e\\u0941\\u0915\\u094d\\u0924 \\u0916\\u094b\\u091c \\u0915\\u0947 \\u0932\\u093f\\u090f \\u090f\\u0915 \\u0917\\u093e\\u0907\\u0921\"},\"fr\":{\"title\":\"L\'art de trouver la baby-sitter id\\u00e9ale : un guide pour une recherche sans stress\"}}}', 'the-art-of-finding-the-perfect-sitter-a-guide-to-stress-free-searching', 'cef18b65-f419-420c-ab6d-10acdb898b97.webp', '[\"appdevs\",\"sitterhub\"]', '{\"language\":{\"en\":{\"description\":\"<p>Embarking on the search for the perfect babysitter or pet sitter can be both exciting and daunting. In this comprehensive guide, we delve into the art of finding the ideal caregiver. From understanding your specific needs to utilizing SitterHub\\u2019s advanced search features and reading genuine reviews, we provide expert tips and insights to ensure a stress-free and enjoyable experience in selecting the perfect sitter for your family.<\\/p>\"},\"es\":{\"description\":\"<p>Embarcarse en la b\\u00fasqueda de la ni\\u00f1era o cuidadora de mascotas perfecta puede ser a la vez emocionante y desalentador. En esta gu\\u00eda completa, profundizamos en el arte de encontrar al cuidador ideal. Desde comprender sus necesidades espec\\u00edficas hasta utilizar las funciones de b\\u00fasqueda avanzada de SitterHub y leer rese\\u00f1as genuinas, brindamos consejos e ideas de expertos para garantizar una experiencia placentera y sin estr\\u00e9s al seleccionar la ni\\u00f1era perfecta para su familia.<\\/p>\"},\"ar\":{\"description\":\"<p>\\u0627\\u0644\\u0634\\u0631\\u0648\\u0639 \\u0641\\u064a \\u0627\\u0644\\u0628\\u062d\\u062b \\u0639\\u0646 \\u062c\\u0644\\u064a\\u0633\\u0629 \\u0627\\u0644\\u0623\\u0637\\u0641\\u0627\\u0644 \\u0623\\u0648 \\u062c\\u0644\\u064a\\u0633\\u0629 \\u0627\\u0644\\u062d\\u064a\\u0648\\u0627\\u0646\\u0627\\u062a \\u0627\\u0644\\u0623\\u0644\\u064a\\u0641\\u0629 \\u0627\\u0644\\u0645\\u062b\\u0627\\u0644\\u064a\\u0629 \\u064a\\u0645\\u0643\\u0646 \\u0623\\u0646 \\u064a\\u0643\\u0648\\u0646 \\u0623\\u0645\\u0631\\u064b\\u0627 \\u0645\\u062b\\u064a\\u0631\\u064b\\u0627 \\u0648\\u0634\\u0627\\u0642\\u064b\\u0627. \\u0641\\u064a \\u0647\\u0630\\u0627 \\u0627\\u0644\\u062f\\u0644\\u064a\\u0644 \\u0627\\u0644\\u0634\\u0627\\u0645\\u0644\\u060c \\u0646\\u062a\\u0639\\u0645\\u0642 \\u0641\\u064a \\u0641\\u0646 \\u0627\\u0644\\u0639\\u062b\\u0648\\u0631 \\u0639\\u0644\\u0649 \\u0645\\u0642\\u062f\\u0645 \\u0627\\u0644\\u0631\\u0639\\u0627\\u064a\\u0629 \\u0627\\u0644\\u0645\\u062b\\u0627\\u0644\\u064a. \\u0628\\u062f\\u0621\\u064b\\u0627 \\u0645\\u0646 \\u0641\\u0647\\u0645 \\u0627\\u062d\\u062a\\u064a\\u0627\\u062c\\u0627\\u062a\\u0643 \\u0627\\u0644\\u062e\\u0627\\u0635\\u0629 \\u0648\\u062d\\u062a\\u0649 \\u0627\\u0633\\u062a\\u062e\\u062f\\u0627\\u0645 \\u0645\\u064a\\u0632\\u0627\\u062a \\u0627\\u0644\\u0628\\u062d\\u062b \\u0627\\u0644\\u0645\\u062a\\u0642\\u062f\\u0645\\u0629 \\u0641\\u064a SitterHub \\u0648\\u0642\\u0631\\u0627\\u0621\\u0629 \\u0627\\u0644\\u0645\\u0631\\u0627\\u062c\\u0639\\u0627\\u062a \\u0627\\u0644\\u062d\\u0642\\u064a\\u0642\\u064a\\u0629\\u060c \\u0646\\u0642\\u062f\\u0645 \\u0646\\u0635\\u0627\\u0626\\u062d \\u0648\\u0631\\u0624\\u0649 \\u0627\\u0644\\u062e\\u0628\\u0631\\u0627\\u0621 \\u0644\\u0636\\u0645\\u0627\\u0646 \\u062a\\u062c\\u0631\\u0628\\u0629 \\u0645\\u0645\\u062a\\u0639\\u0629 \\u0648\\u062e\\u0627\\u0644\\u064a\\u0629 \\u0645\\u0646 \\u0627\\u0644\\u062a\\u0648\\u062a\\u0631 \\u0641\\u064a \\u0627\\u062e\\u062a\\u064a\\u0627\\u0631 \\u0627\\u0644\\u062d\\u0627\\u0636\\u0646\\u0629 \\u0627\\u0644\\u0645\\u062b\\u0627\\u0644\\u064a\\u0629 \\u0644\\u0639\\u0627\\u0626\\u0644\\u062a\\u0643.<\\/p>\"},\"hi\":{\"description\":\"<p>\\u0938\\u0939\\u0940 \\u092c\\u0947\\u092c\\u0940\\u0938\\u093f\\u091f\\u0930 \\u092f\\u093e \\u092a\\u093e\\u0932\\u0924\\u0942 \\u091c\\u093e\\u0928\\u0935\\u0930\\u094b\\u0902 \\u0915\\u0940 \\u0926\\u0947\\u0916\\u092d\\u093e\\u0932 \\u0915\\u0930\\u0928\\u0947 \\u0935\\u093e\\u0932\\u0947 \\u0915\\u0940 \\u0924\\u0932\\u093e\\u0936 \\u0936\\u0941\\u0930\\u0942 \\u0915\\u0930\\u0928\\u093e \\u0930\\u094b\\u092e\\u093e\\u0902\\u091a\\u0915 \\u0914\\u0930 \\u091a\\u0941\\u0928\\u094c\\u0924\\u0940\\u092a\\u0942\\u0930\\u094d\\u0923 \\u0926\\u094b\\u0928\\u094b\\u0902 \\u0939\\u094b \\u0938\\u0915\\u0924\\u093e \\u0939\\u0948\\u0964 \\u0907\\u0938 \\u0935\\u094d\\u092f\\u093e\\u092a\\u0915 \\u0917\\u093e\\u0907\\u0921 \\u092e\\u0947\\u0902, \\u0939\\u092e \\u0906\\u0926\\u0930\\u094d\\u0936 \\u0926\\u0947\\u0916\\u092d\\u093e\\u0932\\u0915\\u0930\\u094d\\u0924\\u093e \\u0915\\u094b \\u0916\\u094b\\u091c\\u0928\\u0947 \\u0915\\u0940 \\u0915\\u0932\\u093e \\u092e\\u0947\\u0902 \\u0924\\u0932\\u094d\\u0932\\u0940\\u0928 \\u0939\\u0948\\u0902\\u0964 \\u0906\\u092a\\u0915\\u0940 \\u0935\\u093f\\u0936\\u093f\\u0937\\u094d\\u091f \\u0906\\u0935\\u0936\\u094d\\u092f\\u0915\\u0924\\u093e\\u0913\\u0902 \\u0915\\u094b \\u0938\\u092e\\u091d\\u0928\\u0947 \\u0938\\u0947 \\u0932\\u0947\\u0915\\u0930 \\u0938\\u093f\\u091f\\u0930\\u0939\\u092c \\u0915\\u0940 \\u0909\\u0928\\u094d\\u0928\\u0924 \\u0916\\u094b\\u091c \\u0938\\u0941\\u0935\\u093f\\u0927\\u093e\\u0913\\u0902 \\u0915\\u093e \\u0909\\u092a\\u092f\\u094b\\u0917 \\u0915\\u0930\\u0928\\u0947 \\u0914\\u0930 \\u0935\\u093e\\u0938\\u094d\\u0924\\u0935\\u093f\\u0915 \\u0938\\u092e\\u0940\\u0915\\u094d\\u0937\\u093e\\u090f\\u0901 \\u092a\\u0922\\u093c\\u0928\\u0947 \\u0924\\u0915, \\u0939\\u092e \\u0906\\u092a\\u0915\\u0947 \\u092a\\u0930\\u093f\\u0935\\u093e\\u0930 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0938\\u0939\\u0940 \\u0938\\u093f\\u091f\\u0930 \\u091a\\u0941\\u0928\\u0928\\u0947 \\u092e\\u0947\\u0902 \\u0924\\u0928\\u093e\\u0935-\\u092e\\u0941\\u0915\\u094d\\u0924 \\u0914\\u0930 \\u0906\\u0928\\u0902\\u0926\\u0926\\u093e\\u092f\\u0915 \\u0905\\u0928\\u0941\\u092d\\u0935 \\u0938\\u0941\\u0928\\u093f\\u0936\\u094d\\u091a\\u093f\\u0924 \\u0915\\u0930\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0935\\u093f\\u0936\\u0947\\u0937\\u091c\\u094d\\u091e \\u0938\\u0941\\u091d\\u093e\\u0935 \\u0914\\u0930 \\u091c\\u093e\\u0928\\u0915\\u093e\\u0930\\u0940 \\u092a\\u094d\\u0930\\u0926\\u093e\\u0928 \\u0915\\u0930\\u0924\\u0947 \\u0939\\u0948\\u0902\\u0964<\\/p>\"},\"fr\":{\"description\":\"<p>Se lancer dans la recherche de la baby-sitter ou du gardien d\'animaux id\\u00e9al peut \\u00eatre \\u00e0 la fois passionnant et intimidant. Dans ce guide complet, nous nous plongeons dans l\'art de trouver la personne id\\u00e9ale. De la compr\\u00e9hension de vos besoins sp\\u00e9cifiques \\u00e0 l\'utilisation des fonctions de recherche avanc\\u00e9es de SitterHub et \\u00e0 la lecture d\'avis authentiques, nous fournissons des conseils et des informations d\'experts pour garantir une exp\\u00e9rience sans stress et agr\\u00e9able dans la s\\u00e9lection de la baby-sitter parfaite pour votre famille.<\\/p>\"}}}', 1, '2024-11-15 04:55:29', '2024-11-15 04:55:29'),
(7, 1, '{\"language\":{\"en\":{\"title\":\"Community Connection: Navigating Parenthood with SitterHub\\u2019s Support Network\"},\"es\":{\"title\":\"Conexi\\u00f3n comunitaria: Navegando por la paternidad con la red de apoyo de SitterHub\"},\"ar\":{\"title\":\"\\u0627\\u0644\\u0627\\u062a\\u0635\\u0627\\u0644 \\u0627\\u0644\\u0645\\u062c\\u062a\\u0645\\u0639\\u064a: \\u0627\\u0644\\u062a\\u0646\\u0642\\u0644 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0628\\u0648\\u0629 \\u0645\\u0639 \\u0634\\u0628\\u0643\\u0629 \\u062f\\u0639\\u0645 SitterHub\"},\"hi\":{\"title\":\"\\u0938\\u093e\\u092e\\u0941\\u0926\\u093e\\u092f\\u093f\\u0915 \\u0938\\u0902\\u092a\\u0930\\u094d\\u0915: \\u0938\\u093f\\u091f\\u0930\\u0939\\u092c \\u0915\\u0947 \\u0938\\u0939\\u093e\\u092f\\u0924\\u093e \\u0928\\u0947\\u091f\\u0935\\u0930\\u094d\\u0915 \\u0915\\u0947 \\u0938\\u093e\\u0925 \\u092e\\u093e\\u0924\\u093e-\\u092a\\u093f\\u0924\\u093e \\u092c\\u0928\\u0928\\u093e\"},\"fr\":{\"title\":\"Connexion communautaire : s\'orienter dans la parentalit\\u00e9 avec le r\\u00e9seau de soutien de SitterHub\"}}}', 'community-connection-navigating-parenthood-with-sitterhubs-support-network', 'd39ab79f-4d3e-4b52-801a-e6dfbb0bb91d.webp', '[\"appdevs\",\"sitterhub\",\"care\"]', '{\"language\":{\"en\":{\"description\":\"<p>Parenthood can be a journey of highs and lows, and SitterHub believes in the power of community. This blog explores the benefits of joining SitterHub\\u2019s vibrant community, where like-minded parents and pet owners come together to share experiences, seek advice, and build connections. Discover the strength that comes from a supportive network in navigating the joys and challenges of caregiving.<br>&nbsp;<\\/p>\"},\"es\":{\"description\":\"<p>La paternidad puede ser un viaje de altibajos, y SitterHub cree en el poder de la comunidad. Este blog explora los beneficios de unirse a la vibrante comunidad de SitterHub, donde padres y due\\u00f1os de mascotas con ideas afines se re\\u00fanen para compartir experiencias, buscar consejos y establecer conexiones. Descubra la fortaleza que proviene de una red de apoyo para afrontar las alegr\\u00edas y los desaf\\u00edos de brindar cuidados.<\\/p>\"},\"ar\":{\"description\":\"<p>\\u064a\\u0645\\u0643\\u0646 \\u0623\\u0646 \\u062a\\u0643\\u0648\\u0646 \\u0627\\u0644\\u0623\\u0628\\u0648\\u0629 \\u0631\\u062d\\u0644\\u0629 \\u0645\\u0646 \\u0627\\u0644\\u0627\\u0631\\u062a\\u0641\\u0627\\u0639\\u0627\\u062a \\u0648\\u0627\\u0644\\u0627\\u0646\\u062e\\u0641\\u0627\\u0636\\u0627\\u062a\\u060c \\u0648\\u062a\\u0624\\u0645\\u0646 SitterHub \\u0628\\u0642\\u0648\\u0629 \\u0627\\u0644\\u0645\\u062c\\u062a\\u0645\\u0639. \\u062a\\u0633\\u062a\\u0643\\u0634\\u0641 \\u0647\\u0630\\u0647 \\u0627\\u0644\\u0645\\u062f\\u0648\\u0646\\u0629 \\u0641\\u0648\\u0627\\u0626\\u062f \\u0627\\u0644\\u0627\\u0646\\u0636\\u0645\\u0627\\u0645 \\u0625\\u0644\\u0649 \\u0645\\u062c\\u062a\\u0645\\u0639 SitterHub \\u0627\\u0644\\u0646\\u0627\\u0628\\u0636 \\u0628\\u0627\\u0644\\u062d\\u064a\\u0627\\u0629\\u060c \\u062d\\u064a\\u062b \\u064a\\u062c\\u062a\\u0645\\u0639 \\u0627\\u0644\\u0622\\u0628\\u0627\\u0621 \\u0648\\u0623\\u0635\\u062d\\u0627\\u0628 \\u0627\\u0644\\u062d\\u064a\\u0648\\u0627\\u0646\\u0627\\u062a \\u0627\\u0644\\u0623\\u0644\\u064a\\u0641\\u0629 \\u0630\\u0648\\u064a \\u0627\\u0644\\u062a\\u0641\\u0643\\u064a\\u0631 \\u0627\\u0644\\u0645\\u0645\\u0627\\u062b\\u0644 \\u0644\\u062a\\u0628\\u0627\\u062f\\u0644 \\u0627\\u0644\\u062e\\u0628\\u0631\\u0627\\u062a \\u0648\\u0637\\u0644\\u0628 \\u0627\\u0644\\u0645\\u0634\\u0648\\u0631\\u0629 \\u0648\\u0628\\u0646\\u0627\\u0621 \\u0627\\u0644\\u0639\\u0644\\u0627\\u0642\\u0627\\u062a. \\u0627\\u0643\\u062a\\u0634\\u0641 \\u0627\\u0644\\u0642\\u0648\\u0629 \\u0627\\u0644\\u062a\\u064a \\u062a\\u0623\\u062a\\u064a \\u0645\\u0646 \\u0634\\u0628\\u0643\\u0629 \\u062f\\u0627\\u0639\\u0645\\u0629 \\u0641\\u064a \\u0627\\u0644\\u062a\\u0639\\u0627\\u0645\\u0644 \\u0645\\u0639 \\u0623\\u0641\\u0631\\u0627\\u062d \\u0648\\u062a\\u062d\\u062f\\u064a\\u0627\\u062a \\u062a\\u0642\\u062f\\u064a\\u0645 \\u0627\\u0644\\u0631\\u0639\\u0627\\u064a\\u0629.<\\/p>\"},\"hi\":{\"description\":\"<p>\\u092e\\u093e\\u0924\\u093e-\\u092a\\u093f\\u0924\\u093e \\u092c\\u0928\\u0928\\u093e \\u0909\\u0924\\u093e\\u0930-\\u091a\\u0922\\u093c\\u093e\\u0935 \\u0938\\u0947 \\u092d\\u0930\\u093e \\u0938\\u092b\\u0930 \\u0939\\u094b \\u0938\\u0915\\u0924\\u093e \\u0939\\u0948, \\u0914\\u0930 \\u0938\\u093f\\u091f\\u0930\\u0939\\u092c \\u0938\\u092e\\u0941\\u0926\\u093e\\u092f \\u0915\\u0940 \\u0936\\u0915\\u094d\\u0924\\u093f \\u092e\\u0947\\u0902 \\u0935\\u093f\\u0936\\u094d\\u0935\\u093e\\u0938 \\u0915\\u0930\\u0924\\u093e \\u0939\\u0948\\u0964 \\u092f\\u0939 \\u092c\\u094d\\u0932\\u0949\\u0917 \\u0938\\u093f\\u091f\\u0930\\u0939\\u092c \\u0915\\u0947 \\u091c\\u0940\\u0935\\u0902\\u0924 \\u0938\\u092e\\u0941\\u0926\\u093e\\u092f \\u092e\\u0947\\u0902 \\u0936\\u093e\\u092e\\u093f\\u0932 \\u0939\\u094b\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093e\\u092d\\u094b\\u0902 \\u0915\\u0940 \\u0916\\u094b\\u091c \\u0915\\u0930\\u0924\\u093e \\u0939\\u0948, \\u091c\\u0939\\u093e\\u0901 \\u0938\\u092e\\u093e\\u0928 \\u0935\\u093f\\u091a\\u093e\\u0930\\u0927\\u093e\\u0930\\u093e \\u0935\\u093e\\u0932\\u0947 \\u092e\\u093e\\u0924\\u093e-\\u092a\\u093f\\u0924\\u093e \\u0914\\u0930 \\u092a\\u093e\\u0932\\u0924\\u0942 \\u091c\\u093e\\u0928\\u0935\\u0930\\u094b\\u0902 \\u0915\\u0947 \\u092e\\u093e\\u0932\\u093f\\u0915 \\u0905\\u0928\\u0941\\u092d\\u0935 \\u0938\\u093e\\u091d\\u093e \\u0915\\u0930\\u0928\\u0947, \\u0938\\u0932\\u093e\\u0939 \\u0932\\u0947\\u0928\\u0947 \\u0914\\u0930 \\u0938\\u0902\\u092c\\u0902\\u0927 \\u092c\\u0928\\u093e\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u090f\\u0915 \\u0938\\u093e\\u0925 \\u0906\\u0924\\u0947 \\u0939\\u0948\\u0902\\u0964 \\u0926\\u0947\\u0916\\u092d\\u093e\\u0932 \\u0915\\u0930\\u0928\\u0947 \\u0915\\u0940 \\u0916\\u0941\\u0936\\u093f\\u092f\\u094b\\u0902 \\u0914\\u0930 \\u091a\\u0941\\u0928\\u094c\\u0924\\u093f\\u092f\\u094b\\u0902 \\u0938\\u0947 \\u0928\\u093f\\u092a\\u091f\\u0928\\u0947 \\u092e\\u0947\\u0902 \\u090f\\u0915 \\u0938\\u0939\\u093e\\u092f\\u0915 \\u0928\\u0947\\u091f\\u0935\\u0930\\u094d\\u0915 \\u0938\\u0947 \\u092e\\u093f\\u0932\\u0928\\u0947 \\u0935\\u093e\\u0932\\u0940 \\u0924\\u093e\\u0915\\u0924 \\u0915\\u093e \\u092a\\u0924\\u093e \\u0932\\u0917\\u093e\\u090f\\u0902\\u0964<\\/p>\"},\"fr\":{\"description\":\"<p>La parentalit\\u00e9 peut \\u00eatre un parcours fait de hauts et de bas, et SitterHub croit au pouvoir de la communaut\\u00e9. Ce blog explore les avantages de rejoindre la communaut\\u00e9 dynamique de SitterHub, o\\u00f9 des parents et des propri\\u00e9taires d\\u2019animaux de compagnie partageant les m\\u00eames id\\u00e9es se r\\u00e9unissent pour partager leurs exp\\u00e9riences, demander des conseils et cr\\u00e9er des liens. D\\u00e9couvrez la force que procure un r\\u00e9seau de soutien pour affronter les joies et les d\\u00e9fis de la prise en charge.<\\/p>\"}}}', 1, '2024-11-15 04:47:58', '2024-11-15 04:47:58'),
(8, 1, '{\"language\":{\"en\":{\"title\":\"A Day in the Life: Daily Diary Features and Photo Updates with SitterHub\"},\"es\":{\"title\":\"Un d\\u00eda en la vida: funciones del diario y actualizaciones de fotograf\\u00edas con SitterHub\"},\"ar\":{\"title\":\"\\u064a\\u0648\\u0645 \\u0641\\u064a \\u0627\\u0644\\u062d\\u064a\\u0627\\u0629: \\u0645\\u064a\\u0632\\u0627\\u062a \\u0627\\u0644\\u064a\\u0648\\u0645\\u064a\\u0627\\u062a \\u0627\\u0644\\u064a\\u0648\\u0645\\u064a\\u0629 \\u0648\\u062a\\u062d\\u062f\\u064a\\u062b\\u0627\\u062a \\u0627\\u0644\\u0635\\u0648\\u0631 \\u0628\\u0627\\u0633\\u062a\\u062e\\u062f\\u0627\\u0645 SitterHub\"},\"hi\":{\"title\":\"\\u091c\\u0940\\u0935\\u0928 \\u0915\\u093e \\u090f\\u0915 \\u0926\\u093f\\u0928: \\u0938\\u093f\\u091f\\u0930\\u0939\\u092c \\u0915\\u0947 \\u0938\\u093e\\u0925 \\u0926\\u0948\\u0928\\u093f\\u0915 \\u0921\\u093e\\u092f\\u0930\\u0940 \\u0938\\u0941\\u0935\\u093f\\u0927\\u093e\\u090f\\u0901 \\u0914\\u0930 \\u092b\\u094b\\u091f\\u094b \\u0905\\u092a\\u0921\\u0947\\u091f\"},\"fr\":{\"title\":\"Une journ\\u00e9e dans la vie : fonctionnalit\\u00e9s du journal quotidien et mises \\u00e0 jour photo avec SitterHub\"}}}', 'a-day-in-the-life-daily-diary-features-and-photo-updates-with-sitterhub', '974cd7e0-b990-4670-b3b6-bf8c88a2ae32.webp', '[\"appdevs\"]', '{\"language\":{\"en\":{\"description\":\"<p>Curious about what your loved ones are up to while you\\u2019re away? SitterHub\\u2019s innovative features, such as the daily diary and photo updates, bridge the physical gap. This blog provides an in-depth exploration of how these features offer a virtual window into your family\\u2019s day, fostering a sense of connection and reassurance no matter where life takes you.<\\/p>\"},\"es\":{\"description\":\"<p>\\u00bfTienes curiosidad por saber qu\\u00e9 hacen tus seres queridos mientras est\\u00e1s fuera? Las funciones innovadoras de SitterHub, como el diario diario y las actualizaciones de fotograf\\u00edas, cierran la brecha f\\u00edsica. Este blog proporciona una exploraci\\u00f3n en profundidad de c\\u00f3mo estas funciones ofrecen una ventana virtual al d\\u00eda de su familia, fomentando una sensaci\\u00f3n de conexi\\u00f3n y tranquilidad sin importar a d\\u00f3nde los lleve la vida.<\\/p>\"},\"ar\":{\"description\":\"<p>\\u0647\\u0644 \\u062a\\u0634\\u0639\\u0631 \\u0628\\u0627\\u0644\\u0641\\u0636\\u0648\\u0644 \\u0628\\u0634\\u0623\\u0646 \\u0645\\u0627 \\u064a\\u0641\\u0639\\u0644\\u0647 \\u0623\\u062d\\u0628\\u0627\\u0624\\u0643 \\u0623\\u062b\\u0646\\u0627\\u0621 \\u063a\\u064a\\u0627\\u0628\\u0643\\u061f \\u062a\\u0639\\u0645\\u0644 \\u0645\\u064a\\u0632\\u0627\\u062a SitterHub \\u0627\\u0644\\u0645\\u0628\\u062a\\u0643\\u0631\\u0629\\u060c \\u0645\\u062b\\u0644 \\u0627\\u0644\\u064a\\u0648\\u0645\\u064a\\u0627\\u062a \\u0627\\u0644\\u064a\\u0648\\u0645\\u064a\\u0629 \\u0648\\u062a\\u062d\\u062f\\u064a\\u062b\\u0627\\u062a \\u0627\\u0644\\u0635\\u0648\\u0631\\u060c \\u0639\\u0644\\u0649 \\u0633\\u062f \\u0627\\u0644\\u0641\\u062c\\u0648\\u0629 \\u0627\\u0644\\u0645\\u0627\\u062f\\u064a\\u0629. \\u062a\\u0648\\u0641\\u0631 \\u0647\\u0630\\u0647 \\u0627\\u0644\\u0645\\u062f\\u0648\\u0646\\u0629 \\u0627\\u0633\\u062a\\u0643\\u0634\\u0627\\u0641\\u064b\\u0627 \\u0645\\u062a\\u0639\\u0645\\u0642\\u064b\\u0627 \\u0644\\u0643\\u064a\\u0641\\u064a\\u0629 \\u062a\\u0648\\u0641\\u064a\\u0631 \\u0647\\u0630\\u0647 \\u0627\\u0644\\u0645\\u064a\\u0632\\u0627\\u062a \\u0644\\u0646\\u0627\\u0641\\u0630\\u0629 \\u0627\\u0641\\u062a\\u0631\\u0627\\u0636\\u064a\\u0629 \\u0639\\u0644\\u0649 \\u064a\\u0648\\u0645 \\u0639\\u0627\\u0626\\u0644\\u062a\\u0643\\u060c \\u0645\\u0645\\u0627 \\u064a\\u0639\\u0632\\u0632 \\u0627\\u0644\\u0634\\u0639\\u0648\\u0631 \\u0628\\u0627\\u0644\\u0627\\u062a\\u0635\\u0627\\u0644 \\u0648\\u0627\\u0644\\u0637\\u0645\\u0623\\u0646\\u064a\\u0646\\u0629 \\u0628\\u063a\\u0636 \\u0627\\u0644\\u0646\\u0638\\u0631 \\u0639\\u0646 \\u0627\\u0644\\u0645\\u0643\\u0627\\u0646 \\u0627\\u0644\\u0630\\u064a \\u062a\\u0623\\u062e\\u0630\\u0643 \\u0625\\u0644\\u064a\\u0647 \\u0627\\u0644\\u062d\\u064a\\u0627\\u0629.<\\/p>\"},\"hi\":{\"description\":\"<p>\\u0915\\u094d\\u092f\\u093e \\u0906\\u092a \\u091c\\u093e\\u0928\\u0928\\u093e \\u091a\\u093e\\u0939\\u0924\\u0947 \\u0939\\u0948\\u0902 \\u0915\\u093f \\u0906\\u092a\\u0915\\u0947 \\u092a\\u094d\\u0930\\u093f\\u092f\\u091c\\u0928 \\u0906\\u092a\\u0915\\u0947 \\u0926\\u0942\\u0930 \\u0930\\u0939\\u0928\\u0947 \\u0915\\u0947 \\u0926\\u094c\\u0930\\u093e\\u0928 \\u0915\\u094d\\u092f\\u093e \\u0915\\u0930 \\u0930\\u0939\\u0947 \\u0939\\u0948\\u0902? SitterHub \\u0915\\u0940 \\u0905\\u092d\\u093f\\u0928\\u0935 \\u0938\\u0941\\u0935\\u093f\\u0927\\u093e\\u090f\\u0901, \\u091c\\u0948\\u0938\\u0947 \\u0915\\u093f \\u0926\\u0948\\u0928\\u093f\\u0915 \\u0921\\u093e\\u092f\\u0930\\u0940 \\u0914\\u0930 \\u092b\\u093c\\u094b\\u091f\\u094b \\u0905\\u092a\\u0921\\u0947\\u091f, \\u092d\\u094c\\u0924\\u093f\\u0915 \\u0905\\u0902\\u0924\\u0930 \\u0915\\u094b \\u092a\\u093e\\u091f\\u0924\\u0940 \\u0939\\u0948\\u0902\\u0964 \\u092f\\u0939 \\u092c\\u094d\\u0932\\u0949\\u0917 \\u0907\\u0938 \\u092c\\u093e\\u0924 \\u0915\\u0940 \\u0917\\u0939\\u0928 \\u0916\\u094b\\u091c \\u092a\\u094d\\u0930\\u0926\\u093e\\u0928 \\u0915\\u0930\\u0924\\u093e \\u0939\\u0948 \\u0915\\u093f \\u0915\\u0948\\u0938\\u0947 \\u092f\\u0947 \\u0938\\u0941\\u0935\\u093f\\u0927\\u093e\\u090f\\u0901 \\u0906\\u092a\\u0915\\u0947 \\u092a\\u0930\\u093f\\u0935\\u093e\\u0930 \\u0915\\u0947 \\u0926\\u093f\\u0928 \\u0915\\u0940 \\u090f\\u0915 \\u0906\\u092d\\u093e\\u0938\\u0940 \\u091d\\u0932\\u0915 \\u092a\\u094d\\u0930\\u0926\\u093e\\u0928 \\u0915\\u0930\\u0924\\u0940 \\u0939\\u0948\\u0902, \\u091c\\u093f\\u0938\\u0938\\u0947 \\u091c\\u0940\\u0935\\u0928 \\u0906\\u092a\\u0915\\u094b \\u091c\\u0939\\u093e\\u0901 \\u092d\\u0940 \\u0932\\u0947 \\u091c\\u093e\\u090f, \\u091c\\u0941\\u0921\\u093c\\u093e\\u0935 \\u0914\\u0930 \\u0906\\u0936\\u094d\\u0935\\u093e\\u0938\\u0928 \\u0915\\u0940 \\u092d\\u093e\\u0935\\u0928\\u093e \\u0915\\u094b \\u092c\\u0922\\u093c\\u093e\\u0935\\u093e \\u092e\\u093f\\u0932\\u0924\\u093e \\u0939\\u0948\\u0964<\\/p>\"},\"fr\":{\"description\":\"<p>Vous \\u00eates curieux de savoir ce que font vos proches pendant votre absence ? Les fonctionnalit\\u00e9s innovantes de SitterHub, telles que le journal quotidien et les mises \\u00e0 jour de photos, comblent ce foss\\u00e9 physique. Ce blog propose une exploration approfondie de la mani\\u00e8re dont ces fonctionnalit\\u00e9s offrent une fen\\u00eatre virtuelle sur la journ\\u00e9e de votre famille, favorisant un sentiment de connexion et de r\\u00e9confort, peu importe o\\u00f9 la vie vous m\\u00e8ne.<\\/p>\"}}}', 1, '2024-11-15 04:47:00', '2024-11-15 04:47:00'),
(9, 1, '{\"language\":{\"en\":{\"title\":\"Tech-Savvy Parenting: Unleashing the Power of the SitterHub App\"},\"es\":{\"title\":\"Crianza de padres expertos en tecnolog\\u00eda: liberar el poder de la aplicaci\\u00f3n SitterHub\"},\"ar\":{\"title\":\"\\u0627\\u0644\\u0623\\u0628\\u0648\\u0629 \\u0648\\u0627\\u0644\\u0623\\u0645\\u0648\\u0645\\u0629 \\u0627\\u0644\\u0628\\u0627\\u0631\\u0639\\u0629 \\u0641\\u064a \\u0627\\u0644\\u062a\\u0643\\u0646\\u0648\\u0644\\u0648\\u062c\\u064a\\u0627: \\u0625\\u0637\\u0644\\u0627\\u0642 \\u0627\\u0644\\u0639\\u0646\\u0627\\u0646 \\u0644\\u0642\\u0648\\u0629 \\u062a\\u0637\\u0628\\u064a\\u0642 SitterHub\"},\"hi\":{\"title\":\"\\u0924\\u0915\\u0928\\u0940\\u0915-\\u092a\\u094d\\u0930\\u0947\\u092e\\u0940 \\u092a\\u0947\\u0930\\u0947\\u0902\\u091f\\u093f\\u0902\\u0917: \\u0938\\u093f\\u091f\\u0930\\u0939\\u092c \\u0910\\u092a \\u0915\\u0940 \\u0936\\u0915\\u094d\\u0924\\u093f \\u0915\\u093e \\u0932\\u093e\\u092d \\u0909\\u0920\\u093e\\u090f\\u0902\"},\"fr\":{\"title\":\"\\u00catre parent \\u00e0 la pointe de la technologie : exploiter la puissance de l\'application SitterHub\"}}}', 'tech-savvy-parenting-unleashing-the-power-of-the-sitterhub-app', '9626006a-fa24-4081-8420-75d36cdbc359.webp', '[\"care\",\"appdevs\"]', '{\"language\":{\"en\":{\"description\":\"<p>Step into the world of tech-savvy parenting with the SitterHub app. This blog dives deep into the user-friendly interface, real-time updates, and secure communication features that make caregiving a breeze for modern parents. Discover how the app enhances the overall experience, making it easier and more accessible to connect with trusted sitters and ensure the well-being of your loved ones.<\\/p>\"},\"es\":{\"description\":\"<p>Ingrese al mundo de la paternidad experta en tecnolog\\u00eda con la aplicaci\\u00f3n SitterHub. Este blog profundiza en la interfaz f\\u00e1cil de usar, las actualizaciones en tiempo real y las funciones de comunicaci\\u00f3n segura que hacen que brindar cuidados sea muy sencillo para los padres modernos. Descubra c\\u00f3mo la aplicaci\\u00f3n mejora la experiencia general, haciendo que sea m\\u00e1s f\\u00e1cil y accesible conectarse con cuidadores de confianza y garantizar el bienestar de sus seres queridos.<\\/p>\"},\"ar\":{\"description\":\"<p>\\u0627\\u062f\\u062e\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0644\\u0645 \\u0627\\u0644\\u0623\\u0628\\u0648\\u0629 \\u0648\\u0627\\u0644\\u0623\\u0645\\u0648\\u0645\\u0629 \\u0627\\u0644\\u0628\\u0627\\u0631\\u0639\\u064a\\u0646 \\u0641\\u064a \\u0627\\u0644\\u062a\\u0643\\u0646\\u0648\\u0644\\u0648\\u062c\\u064a\\u0627 \\u0645\\u0646 \\u062e\\u0644\\u0627\\u0644 \\u062a\\u0637\\u0628\\u064a\\u0642 SitterHub. \\u062a\\u062a\\u0639\\u0645\\u0642 \\u0647\\u0630\\u0647 \\u0627\\u0644\\u0645\\u062f\\u0648\\u0646\\u0629 \\u0641\\u064a \\u0627\\u0644\\u0648\\u0627\\u062c\\u0647\\u0629 \\u0633\\u0647\\u0644\\u0629 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062e\\u062f\\u0627\\u0645 \\u0648\\u0627\\u0644\\u062a\\u062d\\u062f\\u064a\\u062b\\u0627\\u062a \\u0641\\u064a \\u0627\\u0644\\u0648\\u0642\\u062a \\u0627\\u0644\\u0641\\u0639\\u0644\\u064a \\u0648\\u0645\\u064a\\u0632\\u0627\\u062a \\u0627\\u0644\\u0627\\u062a\\u0635\\u0627\\u0644 \\u0627\\u0644\\u0622\\u0645\\u0646\\u0629 \\u0627\\u0644\\u062a\\u064a \\u062a\\u062c\\u0639\\u0644 \\u062a\\u0642\\u062f\\u064a\\u0645 \\u0627\\u0644\\u0631\\u0639\\u0627\\u064a\\u0629 \\u0623\\u0645\\u0631\\u064b\\u0627 \\u0633\\u0647\\u0644\\u0627\\u064b \\u0644\\u0644\\u0622\\u0628\\u0627\\u0621 \\u0627\\u0644\\u0645\\u0639\\u0627\\u0635\\u0631\\u064a\\u0646. \\u0627\\u0643\\u062a\\u0634\\u0641 \\u0643\\u064a\\u0641 \\u064a\\u0639\\u0632\\u0632 \\u0627\\u0644\\u062a\\u0637\\u0628\\u064a\\u0642 \\u0627\\u0644\\u062a\\u062c\\u0631\\u0628\\u0629 \\u0627\\u0644\\u0634\\u0627\\u0645\\u0644\\u0629\\u060c \\u0645\\u0645\\u0627 \\u064a\\u062c\\u0639\\u0644 \\u0627\\u0644\\u062a\\u0648\\u0627\\u0635\\u0644 \\u0645\\u0639 \\u0627\\u0644\\u062c\\u0644\\u064a\\u0633\\u0627\\u062a \\u0627\\u0644\\u0645\\u0648\\u062b\\u0648\\u0642\\u0627\\u062a \\u0623\\u0633\\u0647\\u0644 \\u0648\\u0623\\u0643\\u062b\\u0631 \\u0633\\u0647\\u0648\\u0644\\u0629 \\u0648\\u064a\\u0636\\u0645\\u0646 \\u0631\\u0641\\u0627\\u0647\\u064a\\u0629 \\u0623\\u062d\\u0628\\u0627\\u0626\\u0643.<\\/p>\"},\"hi\":{\"description\":\"<p>\\u0938\\u093f\\u091f\\u0930\\u0939\\u092c \\u0910\\u092a \\u0915\\u0947 \\u0938\\u093e\\u0925 \\u0924\\u0915\\u0928\\u0940\\u0915-\\u092a\\u094d\\u0930\\u0947\\u092e\\u0940 \\u092a\\u0947\\u0930\\u0947\\u0902\\u091f\\u093f\\u0902\\u0917 \\u0915\\u0940 \\u0926\\u0941\\u0928\\u093f\\u092f\\u093e \\u092e\\u0947\\u0902 \\u0915\\u0926\\u092e \\u0930\\u0916\\u0947\\u0902\\u0964 \\u092f\\u0939 \\u092c\\u094d\\u0932\\u0949\\u0917 \\u0909\\u092a\\u092f\\u094b\\u0917\\u0915\\u0930\\u094d\\u0924\\u093e \\u0915\\u0947 \\u0905\\u0928\\u0941\\u0915\\u0942\\u0932 \\u0907\\u0902\\u091f\\u0930\\u092b\\u093c\\u0947\\u0938, \\u0935\\u093e\\u0938\\u094d\\u0924\\u0935\\u093f\\u0915 \\u0938\\u092e\\u092f \\u0915\\u0947 \\u0905\\u092a\\u0921\\u0947\\u091f \\u0914\\u0930 \\u0938\\u0941\\u0930\\u0915\\u094d\\u0937\\u093f\\u0924 \\u0938\\u0902\\u091a\\u093e\\u0930 \\u0938\\u0941\\u0935\\u093f\\u0927\\u093e\\u0913\\u0902 \\u0915\\u0947 \\u092c\\u093e\\u0930\\u0947 \\u092e\\u0947\\u0902 \\u0917\\u0939\\u0930\\u093e\\u0908 \\u0938\\u0947 \\u092c\\u0924\\u093e\\u0924\\u093e \\u0939\\u0948 \\u091c\\u094b \\u0906\\u0927\\u0941\\u0928\\u093f\\u0915 \\u092e\\u093e\\u0924\\u093e-\\u092a\\u093f\\u0924\\u093e \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0926\\u0947\\u0916\\u092d\\u093e\\u0932 \\u0915\\u094b \\u0906\\u0938\\u093e\\u0928 \\u092c\\u0928\\u093e\\u0924\\u0947 \\u0939\\u0948\\u0902\\u0964 \\u091c\\u093e\\u0928\\u0947\\u0902 \\u0915\\u093f \\u0910\\u092a \\u0938\\u092e\\u0917\\u094d\\u0930 \\u0905\\u0928\\u0941\\u092d\\u0935 \\u0915\\u094b \\u0915\\u0948\\u0938\\u0947 \\u092c\\u0922\\u093c\\u093e\\u0924\\u093e \\u0939\\u0948, \\u091c\\u093f\\u0938\\u0938\\u0947 \\u092d\\u0930\\u094b\\u0938\\u0947\\u092e\\u0902\\u0926 \\u0938\\u093f\\u091f\\u0930 \\u0938\\u0947 \\u091c\\u0941\\u0921\\u093c\\u0928\\u093e \\u0914\\u0930 \\u0905\\u092a\\u0928\\u0947 \\u092a\\u094d\\u0930\\u093f\\u092f\\u091c\\u0928\\u094b\\u0902 \\u0915\\u0940 \\u092d\\u0932\\u093e\\u0908 \\u0938\\u0941\\u0928\\u093f\\u0936\\u094d\\u091a\\u093f\\u0924 \\u0915\\u0930\\u0928\\u093e \\u0906\\u0938\\u093e\\u0928 \\u0914\\u0930 \\u0905\\u0927\\u093f\\u0915 \\u0938\\u0941\\u0932\\u092d \\u0939\\u094b \\u091c\\u093e\\u0924\\u093e \\u0939\\u0948\\u0964<\\/p>\"},\"fr\":{\"description\":\"<p>Entrez dans le monde de la parentalit\\u00e9 \\u00e0 la pointe de la technologie avec l\'application SitterHub. Ce blog se penche en profondeur sur l\'interface conviviale, les mises \\u00e0 jour en temps r\\u00e9el et les fonctionnalit\\u00e9s de communication s\\u00e9curis\\u00e9es qui facilitent la prise en charge des enfants pour les parents modernes. D\\u00e9couvrez comment l\'application am\\u00e9liore l\'exp\\u00e9rience globale, en la rendant plus facile et plus accessible pour se connecter avec des baby-sitters de confiance et assurer le bien-\\u00eatre de vos proches.<\\/p>\"}}}', 1, '2024-11-15 04:46:14', '2024-11-15 04:46:14');

-- --------------------------------------------------------

--
-- Table structure for table `buy_coins`
--

CREATE TABLE `buy_coins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `trx_id` varchar(191) NOT NULL,
  `login_vender` varchar(191) NOT NULL,
  `username_or_email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `coin` varchar(191) NOT NULL,
  `price` varchar(191) NOT NULL,
  `charge` varchar(191) NOT NULL,
  `total_amount` varchar(191) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:Pending, 2:Success, 3:Reject, 4:Hold',
  `reject_reason` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coinbase_webhook_calls`
--

CREATE TABLE `coinbase_webhook_calls` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(191) DEFAULT NULL,
  `payload` text DEFAULT NULL,
  `exception` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `country` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  `symbol` varchar(20) NOT NULL,
  `type` enum('CRYPTO','FIAT') NOT NULL DEFAULT 'FIAT',
  `flag` varchar(255) DEFAULT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT 1.00000000,
  `sender` tinyint(1) NOT NULL DEFAULT 0,
  `receiver` tinyint(1) NOT NULL DEFAULT 0,
  `default` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `admin_id`, `country`, `name`, `code`, `symbol`, `type`, `flag`, `rate`, `sender`, `receiver`, `default`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'United States', 'United States dollar', 'USD', '$', 'FIAT', 'accee254-fefb-4a1f-89fa-ad087ed2889b.webp', '1.00000000', 1, 1, 1, 1, '2025-03-27 13:44:26', '2025-03-27 13:44:26');

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `script` text DEFAULT NULL,
  `shortcode` text DEFAULT NULL,
  `support_image` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=>enable, 2=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `name`, `slug`, `description`, `image`, `script`, `shortcode`, `support_image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Tawk', 'tawk-to', 'Go to your tawk to dashbaord. Click [setting icon] on top bar. Then click [Chat Widget] link from sidebar and follow the screenshot bellow. Copy property ID and paste it in Property ID field. Then copy widget ID and paste it in Widget ID field. Finally click on [Update] button and you are ready to go.', 'logo-tawk-to.png', NULL, '{\"property_id\":{\"title\":\"Property ID\",\"value\":\"\"},\"widget_id\":{\"title\":\"Widget ID\",\"value\":\"\"}}', 'instruction-tawk-to.png', 1, '2023-05-16 00:29:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `last_edit_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dir` varchar(191) NOT NULL DEFAULT 'ltr'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `status`, `last_edit_by`, `created_at`, `updated_at`, `dir`) VALUES
(4, 'English', 'en', 1, 1, '2023-06-17 05:05:32', NULL, 'ltr'),
(5, 'Spanish', 'es', 0, 1, '2023-06-19 18:11:49', '2023-06-19 18:11:49', 'ltr'),
(6, 'Arabic', 'ar', 0, 1, '2023-11-05 07:33:24', '2023-11-05 07:33:24', 'rtl'),
(7, 'Hindi', 'hi', 0, 1, '2024-11-12 00:10:34', '2024-11-12 00:10:34', 'ltr'),
(8, 'French', 'fr', 0, 1, '2024-11-12 00:10:42', '2024-11-12 00:10:42', 'ltr');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `message` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2022_12_11_061454_create_admins_table', 1),
(11, '2022_12_13_060252_create_transaction_settings_table', 1),
(12, '2022_12_14_103353_create_currencies_table', 1),
(13, '2022_12_17_104923_create_basic_settings_table', 1),
(14, '2022_12_18_093156_create_setup_seos_table', 1),
(15, '2022_12_19_072039_create_app_settings_table', 1),
(16, '2022_12_24_071800_create_site_sections_table', 1),
(17, '2022_12_24_110923_create_app_onboard_screens_table', 1),
(18, '2022_12_25_082623_create_payment_gateways_table', 1),
(19, '2022_12_26_060705_create_payment_gateway_currencies_table', 1),
(20, '2023_01_03_095454_create_extensions_table', 1),
(21, '2023_01_04_061756_create_setup_kycs_table', 1),
(22, '2023_01_07_053411_create_user_profiles_table', 1),
(23, '2023_01_08_133258_create_push_notification_records_table', 1),
(24, '2023_01_10_105235_create_user_password_resets_table', 1),
(25, '2023_01_10_115626_create_admin_login_logs_table', 1),
(26, '2023_01_11_121649_create_admin_roles_table', 1),
(27, '2023_01_11_122240_create_user_login_logs_table', 1),
(28, '2023_01_11_135434_update_admins_table', 1),
(29, '2023_01_12_052750_create_admin_role_permissions_table', 1),
(30, '2023_01_12_055705_create_user_wallets_table', 1),
(31, '2023_01_13_072007_create_nannies_table', 1),
(32, '2023_01_14_154700_create_admin_role_has_permissions_table', 1),
(33, '2023_01_15_051638_create_admin_has_roles_table', 1),
(34, '2023_01_16_095331_create_temporary_datas_table', 1),
(35, '2023_01_18_043653_create_admin_notifications_table', 1),
(36, '2023_01_18_102653_create_languages_table', 1),
(37, '2023_01_19_060838_create_coinbase_webhook_calls_table', 1),
(38, '2023_01_28_075936_create_user_support_tickets_table', 1),
(39, '2023_01_28_081512_create_user_support_chats_table', 1),
(40, '2023_01_28_101246_create_user_support_ticket_attachments_table', 1),
(41, '2023_01_30_093411_create_transactions_table', 1),
(42, '2023_02_06_070418_create_user_mail_logs_table', 1),
(43, '2023_02_06_143558_create_user_authorizations_table', 1),
(44, '2023_02_07_154740_create_user_kyc_data_table', 1),
(45, '2023_02_09_083658_create_setup_pages_table', 1),
(46, '2023_02_23_072239_create_transaction_charges_table', 1),
(47, '2023_02_23_073232_create_transaction_devices_table', 1),
(48, '2023_03_11_054132_create_user_notifications_table', 1),
(49, '2023_05_08_091637_create_add_coins_table', 1),
(50, '2023_05_10_041559_create_buy_coins_table', 1),
(51, '2023_06_20_102014_create_useful_links_table', 1),
(52, '2023_06_21_041424_create_subscribes_table', 1),
(53, '2023_06_21_045303_create_messages_table', 1),
(54, '2023_06_21_133800_create_script_table', 1),
(55, '2023_07_08_072011_create_nanny_authorizations_table', 1),
(56, '2023_07_08_072808_create_nanny_login_logs_table', 1),
(57, '2023_07_08_072924_create_nanny_kyc_data_table', 1),
(58, '2023_07_08_073008_create_nanny_mail_logs_table', 1),
(59, '2023_07_08_073037_create_nanny_notifications_table', 1),
(60, '2023_07_10_041929_create_nanny_password_resets_table', 1),
(61, '2023_07_10_083540_create_service_areas_table', 1),
(62, '2023_07_10_103648_create_nanny_professions_table', 1),
(63, '2023_07_16_091925_create_add_baby_pats_table', 1),
(64, '2023_07_23_094110_create_user_requests_table', 1),
(65, '2023_07_26_174419_create_reviews_table', 1),
(66, '2023_08_03_173136_create_blogs_table', 1),
(67, '2023_09_03_173051_add_column_on_languages_table', 1),
(68, '2023_12_10_171510_add_seenorunseen_column_to_user_requests_table', 1),
(69, '2024_01_29_063122_add_callback_ref_to_transactions_table', 1),
(70, '2024_01_30_112423_create_nanny_wallets_table', 1),
(71, '2024_02_01_124108_add_column_nanny_wallet_id_transactions_table', 1),
(72, '2024_11_15_052213_create_system_maintenances_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nannies`
--

CREATE TABLE `nannies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(191) NOT NULL,
  `lastname` varchar(191) DEFAULT NULL,
  `username` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `mobile_code` varchar(191) DEFAULT NULL,
  `mobile` varchar(191) NOT NULL,
  `full_mobile` varchar(191) DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `refferal_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 == Banned',
  `address` text DEFAULT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 == Verifiend, 0 == Not verifiend',
  `sms_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 == Verifiend, 0 == Not verifiend',
  `kyc_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Default, 1: Approved, 2: Pending, 3:Rejected',
  `profession_submitted` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Default, 1: submitted',
  `ver_code` int(11) DEFAULT NULL,
  `ver_code_send_at` timestamp NULL DEFAULT NULL,
  `two_factor_verified` tinyint(1) NOT NULL DEFAULT 0,
  `two_factor_status` tinyint(1) NOT NULL DEFAULT 0,
  `two_factor_secret` varchar(191) DEFAULT NULL,
  `device_id` varchar(191) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nanny_authorizations`
--

CREATE TABLE `nanny_authorizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nanny_id` bigint(20) UNSIGNED NOT NULL,
  `code` int(11) NOT NULL,
  `token` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nanny_kyc_data`
--

CREATE TABLE `nanny_kyc_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nanny_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `reject_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nanny_login_logs`
--

CREATE TABLE `nanny_login_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nanny_id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `mac` varchar(17) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `browser` varchar(30) DEFAULT NULL,
  `os` varchar(30) DEFAULT NULL,
  `timezone` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nanny_mail_logs`
--

CREATE TABLE `nanny_mail_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nanny_id` bigint(20) UNSIGNED NOT NULL,
  `method` varchar(191) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nanny_notifications`
--

CREATE TABLE `nanny_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nanny_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nanny_password_resets`
--

CREATE TABLE `nanny_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `code` bigint(20) UNSIGNED DEFAULT NULL,
  `token` varchar(191) NOT NULL,
  `nanny_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nanny_professions`
--

CREATE TABLE `nanny_professions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nanny_id` bigint(20) UNSIGNED NOT NULL,
  `profession_type` int(11) NOT NULL COMMENT '1=Baby Sitter,2=Pet Sitter',
  `profession_type_details` text NOT NULL,
  `work_experience` varchar(191) NOT NULL,
  `work_capability` varchar(191) NOT NULL,
  `service_area` varchar(191) NOT NULL,
  `charge` varchar(191) NOT NULL,
  `amount` decimal(16,4) NOT NULL,
  `bio` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nanny_wallets`
--

CREATE TABLE `nanny_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nanny_id` bigint(20) UNSIGNED NOT NULL,
  `currency_id` bigint(20) UNSIGNED NOT NULL,
  `balance` decimal(28,8) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(191) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(100) NOT NULL,
  `code` int(10) UNSIGNED NOT NULL,
  `type` enum('AUTOMATIC','MANUAL') NOT NULL,
  `name` varchar(100) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `alias` varchar(120) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `credentials` text DEFAULT NULL,
  `supported_currencies` text DEFAULT NULL,
  `crypto` tinyint(1) NOT NULL DEFAULT 0,
  `desc` text DEFAULT NULL,
  `input_fields` text DEFAULT NULL,
  `env` enum('SANDBOX','PRODUCTION') DEFAULT NULL COMMENT 'Payment Gateway Environment (Ex: Production/Sandbox)',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `last_edit_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `slug`, `code`, `type`, `name`, `title`, `alias`, `image`, `credentials`, `supported_currencies`, `crypto`, `desc`, `input_fields`, `env`, `status`, `last_edit_by`, `created_at`, `updated_at`) VALUES
(7, 'add-money', 105, 'AUTOMATIC', 'Stripe', 'Stripe Gateway', 'stripe', 'ed00713c-4999-4173-a1bb-373d8e755de3.webp', '[{\"label\":\"Secret Id\",\"placeholder\":\"Enter Secret Id\",\"name\":\"secret-id\",\"value\":\"sk_test_51NECrlJXLo7QTdMc2x7K5LaDuiS0MGNYHkO9dzzV0Y9XuWNZsXjECFsusjZEnqtxMIjCh3qtogc5sHHwL2oQ083900aFy1k7DE\"},{\"label\":\"Publishable Key\",\"placeholder\":\"Enter Publishable Key\",\"name\":\"publishable-key\",\"value\":\"pk_test_51NECrlJXLo7QTdMco2E4YxHSeoBnDvKmmi0CZl3hxjGgH1JwgcLVUF3ZR0yFraoRgT7hf0LtOReFADhShAZqTNuB003PnBSlGP\"}]', '[\"USD\",\"AUD\",\"AED\",\"BGN\",\"CAD\",\"EGP\",\"EUR\",\"GBP\",\"INR\"]', 0, NULL, NULL, 'SANDBOX', 1, 1, '2023-08-26 11:20:54', '2023-11-19 07:02:24'),
(8, 'add-money', 110, 'AUTOMATIC', 'Paypal', 'Paypal Gateway', 'paypal', 'c0de2683-7652-436e-b701-e1366fb47fa5.webp', '[{\"label\":\"Client Id\",\"placeholder\":\"Enter Client Id\",\"name\":\"client-id\",\"value\":\"ASS12WQ0aB5_8JbOgnt5O1_uAa3BtV2S-cFkoMHlFayEHUWrHeHaAKrsBucMHAfUIKIe-42CSkPxpLAW\"},{\"label\":\"Secret Id\",\"placeholder\":\"Enter Secret Id\",\"name\":\"secret-id\",\"value\":\"ENHLmoVg6yniDa3ULIAqYtBJBwmCW3rlLFNOHcIq42_DwOfpVJ5C1J7l31CRtHqu0HMqm3tND607UWw4\"}]', '[\"USD\",\"AUD\",\"CAD\",\"GBP\",\"SGD\",\"BRL\",\"EUR\",\"RUB\"]', 0, NULL, NULL, 'SANDBOX', 1, 1, '2023-08-26 11:27:41', '2023-11-19 07:11:16'),
(9, 'add-money', 115, 'AUTOMATIC', 'Flutterwave', 'Flutterwave Gateway', 'flutterwave', 'cca1a004-021b-473a-a498-6bfe779db594.webp', '[{\"label\":\"Public key\",\"placeholder\":\"Enter Public key\",\"name\":\"public-key\",\"value\":\"FLWPUBK_TEST-e0bc02a00395b938a4a2bed65e1bc94f-X\"},{\"label\":\"Secret key\",\"placeholder\":\"Enter Secret key\",\"name\":\"secret-key\",\"value\":\"FLWSECK_TEST-da35e3dbd28be1e7dc5d5f3519e2ebef-X\"},{\"label\":\"Encryption key\",\"placeholder\":\"Enter Encryption key\",\"name\":\"encryption-key\",\"value\":\"FLWSECK_TEST27bee2235efd\"}]', '[\"AED\", \"ARS\", \"AUD\", \"CAD\", \"CHF\", \"CZK\", \"ETB\", \"EUR\", \"GBP\", \"GHS\", \"ILS\", \"INR\", \"JPY\", \"KES\", \"MAD\", \"MUR\", \"MYR\", \"NGN\", \"NOK\", \"NZD\", \"PEN\", \"PLN\", \"RUB\", \"RWF\", \"SAR\", \"SEK\", \"SGD\", \"SLL\", \"TZS\", \"UGX\", \"USD\", \"XAF\", \"XOF\", \"ZAR\", \"ZMK\", \"ZMW\", \"MWK\"]', 0, NULL, NULL, 'SANDBOX', 1, 1, '2023-08-26 11:31:08', '2023-11-19 07:11:55'),
(10, 'add-money', 120, 'MANUAL', 'AdPay', 'AdPay Gateway', 'adpay', '9cca9d50-338d-4b94-8c96-0ed12fd7a0cd.webp', NULL, '[\"GBP\"]', 0, '<p><strong>Instructions:</strong><br>To initiate a payment using our manual payment gateway, please follow the instructions provided below. We offer two convenient methods for you to choose from:<br><br><strong>Bank Transfer</strong></p><ol><li>Visit your local bank or access your online banking platform</li><li>Initiate a new fund transfer or payment.</li><li>Enter the recipient’s bank account details:<ol><li>Bank Name: HSBC</li><li>IBAN (International Bank Account Number): 01234567890</li></ol></li><li>Specify the payment amount in the currency you intend to use.</li><li>Double-check all details, including the recipient’s account information.</li><li>Confirm and authorize the transfer.</li><li>Retain the payment receipt or confirmation for future reference.</li></ol><p>Please ensure that you keep a record of your payment as proof of the transaction. In case of any discrepancies or verification requirements, you may be asked to provide this documentation.</p><p>Your payment will be manually verified by our team, and once confirmed, your order will be processed promptly. We appreciate your cooperation and look forward to serving you!</p>', '[{\"type\":\"text\",\"label\":\"Transaction ID\",\"name\":\"transaction_id\",\"required\":true,\"validation\":{\"max\":\"30\",\"mimes\":[],\"min\":\"0\",\"options\":[],\"required\":true}},{\"type\":\"file\",\"label\":\"Screenshot\",\"name\":\"screenshot\",\"required\":true,\"validation\":{\"max\":\"10\",\"mimes\":[\"jpg\",\"png\",\"jpeg\"],\"min\":0,\"options\":[],\"required\":true}}]', NULL, 1, 1, NULL, '2023-11-19 07:21:38'),
(11, 'add-money', 125, 'AUTOMATIC', 'SSLCommerz', 'SSLCommerz Payment Gateway', 'sslcommerz', '03b61751-f1b9-4ff8-8015-7c40bbe35b30.webp', '[{\"label\":\"Live Url\",\"placeholder\":\"Enter Live Url\",\"name\":\"live-url\",\"value\":\"https:\\/\\/securepay.sslcommerz.com\"},{\"label\":\"Sandbox Url\",\"placeholder\":\"Enter Sandbox Url\",\"name\":\"sendbox-url\",\"value\":\"https:\\/\\/sandbox.sslcommerz.com\"},{\"label\":\"Store Password\",\"placeholder\":\"Enter Store Password\",\"name\":\"store-password\",\"value\":\"appde6513b3970d62c@ssl\"},{\"label\":\"Store ID\",\"placeholder\":\"Enter Store ID\",\"name\":\"store-id\",\"value\":\"appde6513b3970d62c\"}]', '[\"BDT\",\"EUR\",\"GBP\",\"AUD\",\"USD\",\"CAD\"]', 0, NULL, NULL, 'SANDBOX', 1, 1, '2023-11-02 06:45:27', '2023-11-19 07:13:19'),
(13, 'add-money', 135, 'AUTOMATIC', 'Qrpay', 'Qrpay Gateway', 'qrpay', 'eaef6529-1d23-46d6-a02f-67eec822484f.webp', '[{\"label\":\"Live Base Url\",\"placeholder\":\"Enter Live Base Url\",\"name\":\"live-base-url\",\"value\":\"https:\\/\\/envato.appdevs.net\\/qrpay\\/pay\\/api\\/v1\"},{\"label\":\"Sendbox Base Url\",\"placeholder\":\"Enter Sendbox Base Url\",\"name\":\"sendbox-base-url\",\"value\":\"https:\\/\\/envato.appdevs.net\\/qrpay\\/pay\\/sandbox\\/api\\/v1\"},{\"label\":\"Client Secret\",\"placeholder\":\"Enter Client Secret\",\"name\":\"client-secret\",\"value\":\"oZouVmqHCbyg6ad7iMnrwq3d8wy9Kr4bo6VpQnsX6zAOoEs4oxHPjttpun36JhGxDl7AUMz3ShUqVyPmxh4oPk3TQmDF7YvHN5M3\"},{\"label\":\"Client Id\",\"placeholder\":\"Enter Client Id\",\"name\":\"client-id\",\"value\":\"tRCDXCuztQzRYThPwlh1KXAYm4bG3rwWjbxM2R63kTefrGD2B9jNn6JnarDf7ycxdzfnaroxcyr5cnduY6AqpulRSebwHwRmGerA\"}]', '[\"USD\"]', 0, NULL, NULL, 'SANDBOX', 1, 1, '2023-11-04 04:28:24', '2023-11-19 07:21:04'),
(22, 'add-money', 130, 'AUTOMATIC', 'RazorPay', 'Global Setting for RazorPay in bellow', 'razorpay', '8f8b1296-4b99-42f9-82b6-106ddc7a5868.webp', '[{\"label\":\"Public key\",\"placeholder\":\"Enter Public key\",\"name\":\"public-key\",\"value\":\"rzp_test_voV4gKUbSxoQez\"},{\"label\":\"Secret Key\",\"placeholder\":\"Enter Secret Key\",\"name\":\"secret-key\",\"value\":\"cJltc1jy6evA4Vvh9lTO7SWr\"}]', '[\"USD\",\"EUR\",\"GBP\",\"SGD\",\"AED\",\"AUD\",\"CAD\",\"CNY\",\"SEK\",\"NZD\",\"MXN\",\"BDT\",\"EGP\",\"HKD\",\"INR\",\"LBP\",\"LKR\",\"MAD\",\"MYR\",\"NGN\",\"NPR\",\"PHP\",\"PKR\",\"QAR\",\"SAR\",\"UZS\",\"GHS\"]', 0, NULL, NULL, 'SANDBOX', 1, 1, '2023-10-20 22:16:15', '2024-01-29 01:15:52'),
(5000, 'add-money', 10005, 'AUTOMATIC', 'Paystack', 'Paystack Gateway', 'paystack', 'paystack.webp', '[{\"label\":\"Secret Key\",\"placeholder\":\"Enter Secret Key\",\"name\":\"secret-key\",\"value\":\"sk_test_d094bb8359027eab06ca8ea9a3b757e47e35684b\"},{\"label\":\"Public Key\",\"placeholder\":\"Enter Public Key\",\"name\":\"public-key\",\"value\":\"pk_test_64a32791e5d7acc43acafb3646a1b9ce898519ea\"}]', '[\"NGN\",\"USD\",\"GHS\",\"ZAR\",\"KES\"]', 0, NULL, NULL, 'SANDBOX', 1, 1, '2025-03-27 13:44:26', '2025-03-27 13:44:26');

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateway_currencies`
--

CREATE TABLE `payment_gateway_currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_gateway_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `alias` varchar(120) NOT NULL,
  `currency_code` varchar(20) NOT NULL,
  `currency_symbol` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `min_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000,
  `max_limit` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000,
  `fixed_charge` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) UNSIGNED NOT NULL DEFAULT 0.00000000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateway_currencies`
--

INSERT INTO `payment_gateway_currencies` (`id`, `payment_gateway_id`, `name`, `alias`, `currency_code`, `currency_symbol`, `image`, `min_limit`, `max_limit`, `percent_charge`, `fixed_charge`, `rate`, `created_at`, `updated_at`) VALUES
(1, 7, 'Stripe AUD', 'add-money-stripe-aud-automatic', 'AUD', '$', '4b017c78-a0a2-4ffb-8844-cb90b63084b7.webp', '0.00000000', '1500.00000000', '1.00000000', '1.00000000', '1.56000000', '2023-08-26 11:21:54', '2023-11-21 04:30:19'),
(2, 7, 'Stripe USD', 'add-money-stripe-usd-automatic', 'USD', '$', 'cecd4e07-9b75-47a3-8536-0d68ab89595c.webp', '0.00000000', '1000.00000000', '1.00000000', '1.00000000', '1.00000000', '2023-08-26 11:21:54', '2023-11-21 04:30:19'),
(3, 8, 'Paypal AUD', 'add-money-paypal-aud-automatic', 'AUD', '$', 'a48ea014-a0e7-4573-830f-47aa4a04143d.webp', '1.00000000', '1500.00000000', '1.00000000', '1.00000000', '1.56000000', '2023-08-26 11:28:43', '2023-11-21 04:31:08'),
(4, 8, 'Paypal USD', 'add-money-paypal-usd-automatic', 'USD', '$', 'ecbe104c-26be-48df-b30d-4698f11f9e90.webp', '1.00000000', '1000.00000000', '1.00000000', '1.00000000', '1.00000000', '2023-08-26 11:28:43', '2023-11-21 04:31:08'),
(5, 10, 'AdPay GBP', 'adpay-gbp-manual', 'GBP', '$', NULL, '1.00000000', '1000.00000000', '1.00000000', '1.00000000', '0.79000000', '2023-08-26 11:46:12', '2023-08-26 11:46:12'),
(6, 9, 'Flutterwave NGN', 'add-money-flutterwave-ngn-automatic', 'NGN', '₦', 'd6412765-63b9-4b6c-8b2b-2fc33c84e30e.webp', '1.00000000', '50000.00000000', '1.00000000', '1.00000000', '772.00000000', '2023-08-26 11:52:12', '2023-11-21 04:32:39'),
(7, 9, 'Flutterwave USD', 'add-money-flutterwave-usd-automatic', 'USD', '$', 'c0c9ca49-23eb-4a9d-a749-9a410511f2d3.webp', '1.00000000', '50000.00000000', '1.00000000', '1.00000000', '1.00000000', '2023-08-29 07:40:43', '2023-11-21 04:32:39'),
(8, 11, 'SSLCommerz BDT', 'add-money-sslcommerz-bdt-automatic', 'BDT', '৳', '4b64607b-285a-49da-b20c-5117913e6082.webp', '100.00000000', '5000.00000000', '2.00000000', '2.00000000', '111.00000000', '2023-11-02 06:59:07', '2023-11-21 04:33:31'),
(9, 13, 'Qrpay USD', 'add-money-qrpay-usd-automatic', 'USD', '$', '84f12d56-2b2a-4668-a6bf-84feb8aad297.webp', '1.00000000', '1000.00000000', '2.00000000', '1.00000000', '1.00000000', '2023-11-04 04:30:18', '2023-11-21 04:29:05'),
(10, 22, 'RazorPay INR', 'add-money-razorpay-inr-automatic', 'INR', '₹', '8165521a-5d8e-49b7-b9f5-15ff4d1d93dd.webp', '0.00000000', '500000.00000000', '2.00000000', '2.00000000', '83.00000000', '2023-12-23 22:19:09', '2023-12-23 22:21:01'),
(11, 5000, 'Paystack NGN', 'paystack-ngn-automatic', 'NGN', '₦', NULL, '1000.00000000', '100000.00000000', '1.00000000', '1.00000000', '1590.00000000', '2025-03-27 13:44:26', '2025-03-27 13:44:26'),
(12, 5000, 'Paystack USD', 'paystack-usd-automatic', 'USD', '$', NULL, '1.00000000', '100.00000000', '1.00000000', '1.00000000', '1.00000000', '2025-03-27 13:44:26', '2025-03-27 13:44:26'),
(13, 5000, 'Paystack GHS', 'paystack-ghs-automatic', 'GHS', 'GH₵', NULL, '100.00000000', '10000.00000000', '1.00000000', '1.00000000', '15.59000000', '2025-03-27 13:44:26', '2025-03-27 13:44:26'),
(14, 5000, 'Paystack ZAR', 'paystack-zar-automatic', 'ZAR', 'R', NULL, '20.00000000', '1000.00000000', '1.00000000', '1.00000000', '17.73000000', '2025-03-27 13:44:26', '2025-03-27 13:44:26'),
(15, 5000, 'Paystack KES', 'paystack-kes-automatic', 'KES', 'KSh', NULL, '100.00000000', '1000.00000000', '1.00000000', '1.00000000', '129.00000000', '2025-03-27 13:44:26', '2025-03-27 13:44:26');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `push_notification_records`
--

CREATE TABLE `push_notification_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_ids` text DEFAULT NULL,
  `device_ids` text DEFAULT NULL,
  `method` varchar(50) NOT NULL,
  `response` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `send_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nanny_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_request_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `script`
--

CREATE TABLE `script` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client` varchar(191) NOT NULL,
  `signature` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_areas`
--

CREATE TABLE `service_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_area` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setup_kycs`
--

CREATE TABLE `setup_kycs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(100) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `fields` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `last_edit_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setup_kycs`
--

INSERT INTO `setup_kycs` (`id`, `slug`, `user_type`, `fields`, `status`, `last_edit_by`, `created_at`, `updated_at`) VALUES
(2, 'nanny', 'NANNY', '[{\"type\":\"file\",\"label\":\"Backend\",\"name\":\"backend\",\"required\":true,\"validation\":{\"max\":\"10\",\"mimes\":[\"jpg\",\"png\",\"jpeg\"],\"min\":0,\"options\":[],\"required\":true}},{\"type\":\"file\",\"label\":\"Frontend\",\"name\":\"frontend\",\"required\":true,\"validation\":{\"max\":\"10\",\"mimes\":[\"jpg\",\"png\",\"jpeg\"],\"min\":0,\"options\":[],\"required\":true}},{\"type\":\"select\",\"label\":\"ID Type\",\"name\":\"id_type\",\"required\":true,\"validation\":{\"max\":0,\"min\":0,\"mimes\":[],\"options\":[\"NID\",\" Driving License\",\" Passport\"],\"required\":true}}]', 1, 1, '2023-07-10 04:39:15', '2023-11-12 10:23:24');

-- --------------------------------------------------------

--
-- Table structure for table `setup_pages`
--

CREATE TABLE `setup_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `last_edit_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setup_pages`
--

INSERT INTO `setup_pages` (`id`, `slug`, `title`, `url`, `last_edit_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'home', 'Home', '/', 1, 1, '2025-03-27 13:44:26', NULL),
(2, 'about', 'About', '/about', 1, 1, '2025-03-27 13:44:26', NULL),
(3, 'how-its-works', 'How It\'s Works', '/how-its-works', 1, 1, '2025-03-27 13:44:26', NULL),
(4, 'contact', 'Contact', '/contact', 1, 1, '2025-03-27 13:44:26', NULL),
(5, 'faq', 'FAQ', '/faq', 1, 1, '2025-03-27 13:44:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setup_seos`
--

CREATE TABLE `setup_seos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `last_edit_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setup_seos`
--

INSERT INTO `setup_seos` (`id`, `slug`, `title`, `desc`, `tags`, `image`, `last_edit_by`, `created_at`, `updated_at`) VALUES
(1, 'lorem_ipsum', 'AppDevs - Software Solutions', 'AppDevs Software Solutions is a most rapidly growing, innovative IT services & Consulting company, Providing consulting, Development & maintenance covering information technology, System integration & custom applications development.', '[\"appdevs\",\"software solutions\"]', NULL, 1, '2025-03-27 13:44:26', '2025-03-27 13:44:26');

-- --------------------------------------------------------

--
-- Table structure for table `site_sections`
--

CREATE TABLE `site_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `serialize` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_sections`
--

INSERT INTO `site_sections` (`id`, `key`, `value`, `status`, `serialize`, `created_at`, `updated_at`) VALUES
(1, 'site_cookie', '{\"status\":true,\"link\":\"link\\/privacy-policy\",\"desc\":\"<p>We may use cookies or any other tracking technologies when you visit our website, including any other media form, mobile website, or mobile application related or connected to help customize the Site and improve your experience.<\\/p>\"}', 1, NULL, NULL, '2024-11-15 03:48:55'),
(2, 'about-section', '{\"image\":\"c2a93900-e227-489a-b53a-7e322ccb94af.webp\",\"language\":{\"en\":{\"sub_heading\":\"About Company\",\"heading\":\"Your Trusted Partners in Exceptional Care\",\"description\":\"Welcome to SitterHub, where exceptional care meets peace of mind. We understand that finding the right caregivers for your family and pets is not just a task; it’s a heartfelt decision. SitterHub is more than a platform - it’s your dedicated partner in creating a seamless and secure caregiving experience.\",\"button_text\":\"More\",\"button_link\":null},\"es\":{\"sub_heading\":\"Acerca de la empresa\",\"heading\":\"Sus socios de confianza para una atención excepcional\",\"description\":\"Bienvenido a SitterHub, donde la atención excepcional se une a la tranquilidad. Entendemos que encontrar los cuidadores adecuados para su familia y sus mascotas no es solo una tarea; es una decisión sincera. SitterHub es más que una plataforma: es su socio dedicado a crear una experiencia de cuidado segura y fluida.\",\"button_text\":\"Más\",\"button_link\":\"\"},\"ar\":{\"sub_heading\":\"عن الشركة\",\"heading\":\"شركاؤك الموثوقون في الرعاية الاستثنائية\",\"description\":\"مرحبًا بك في SitterHub، حيث تلتقي الرعاية الاستثنائية براحة البال. نحن ندرك أن العثور على مقدمي الرعاية المناسبين لعائلتك وحيواناتك الأليفة ليس مجرد مهمة؛ إنه قرار صادق. تعد SitterHub أكثر من مجرد منصة - فهي شريكك المتفاني في إنشاء تجربة تقديم رعاية سلسة وآمنة.\",\"button_text\":\"أكثر\",\"button_link\":\"\"},\"fr\":{\"sub_heading\":\"À propos de l\'entreprise\",\"heading\":\"Vos partenaires de confiance pour des soins exceptionnels\",\"description\":\"Bienvenue sur SitterHub, où des soins exceptionnels rencontrent la tranquillité d\'esprit. Nous comprenons que trouver les bons soignants pour votre famille et vos animaux de compagnie n\'est pas seulement une tâche ; c\'est une décision sincère. SitterHub est plus qu\'une plateforme : c\'est votre partenaire dédié pour créer une expérience de prestation de soins transparente et sécurisée.\",\"button_text\":\"Plus\",\"button_link\":\"\"},\"hi\":{\"sub_heading\":\"कंपनी के बारे में\",\"heading\":\"असाधारण देखभाल में आपके विश्वसनीय भागीदार\",\"description\":\"सिटरहब में आपका स्वागत है, जहां असाधारण देखभाल के साथ मानसिक शांति भी मिलती है। हम समझते हैं कि आपके परिवार और पालतू जानवरों के लिए सही देखभाल करने वालों को ढूंढना सिर्फ एक काम नहीं है; यह दिल से लिया गया फैसला है. सिटरहब एक मंच से कहीं अधिक है - यह एक सहज और सुरक्षित देखभाल अनुभव बनाने में आपका समर्पित भागीदार है।\",\"button_text\":\"अधिक\",\"button_link\":\"\"}}}', 1, NULL, NULL, '2024-02-02 12:46:59'),
(3, 'contact-section', '{\"image\":\"b8cf5c59-edfc-41fb-8151-f713599b058c.webp\",\"language\":{\"en\":{\"sub_heading\":\"Contact\",\"heading\":\"Get In Touch With Us\"},\"es\":{\"sub_heading\":\"Contacto\",\"heading\":\"Ponte en contacto con nosotros\"},\"ar\":{\"sub_heading\":\"اتصال\",\"heading\":\"تواصل معنا\"},\"fr\":{\"sub_heading\":\"Contact\",\"heading\":\"Contactez-nous\"},\"hi\":{\"sub_heading\":\"संपर्क\",\"heading\":\"हमारे साथ जुड़े\"}}}', 1, NULL, NULL, '2024-02-05 04:46:07'),
(4, 'footer-section', '{\"language\":{\"en\":{\"footer_description\":\"Empowering Care, Connecting Hearts. Your Family. Your Pets. Our App.\",\"newsletter_description\":\"Don\\u2019t miss to subscribe to our new feeds, kindly fill the form below.\"},\"es\":{\"footer_description\":\"Empoderando el Cuidado, Conectando Corazones. Tu familia. Tus mascotas. Nuestra aplicaci\\u00f3n.\",\"newsletter_description\":\"No dejes de suscribirte a nuestros nuevos feeds, por favor completa el formulario a continuaci\\u00f3n.\"},\"ar\":{\"footer_description\":\"\\u062a\\u0645\\u0643\\u064a\\u0646 \\u0627\\u0644\\u0631\\u0639\\u0627\\u064a\\u0629\\u060c \\u0648\\u0631\\u0628\\u0637 \\u0627\\u0644\\u0642\\u0644\\u0648\\u0628. \\u0639\\u0627\\u0626\\u0644\\u062a\\u0643. \\u062d\\u064a\\u0648\\u0627\\u0646\\u0627\\u062a\\u0643 \\u0627\\u0644\\u0623\\u0644\\u064a\\u0641\\u0629. \\u062a\\u0637\\u0628\\u064a\\u0642\\u0646\\u0627.\",\"newsletter_description\":\"\\u0644\\u0627 \\u062a\\u0641\\u0648\\u062a \\u0627\\u0644\\u0627\\u0634\\u062a\\u0631\\u0627\\u0643 \\u0641\\u064a \\u062e\\u0644\\u0627\\u0635\\u0627\\u062a\\u0646\\u0627 \\u0627\\u0644\\u062c\\u062f\\u064a\\u062f\\u0629\\u060c \\u064a\\u0631\\u062c\\u0649 \\u0645\\u0644\\u0621 \\u0627\\u0644\\u0646\\u0645\\u0648\\u0630\\u062c \\u0623\\u062f\\u0646\\u0627\\u0647.\"},\"fr\":{\"footer_description\":\"Des soins responsabilisants, des c\\u0153urs connect\\u00e9s. Votre famille. Vos animaux de compagnie. Notre application.\",\"newsletter_description\":\"Ne manquez pas de vous abonner \\u00e0 nos nouveaux flux, veuillez remplir le formulaire ci-dessous.\"},\"hi\":{\"footer_description\":\"\\u0926\\u0947\\u0916\\u092d\\u093e\\u0932 \\u0915\\u094b \\u0938\\u0936\\u0915\\u094d\\u0924 \\u092c\\u0928\\u093e\\u0928\\u093e, \\u0926\\u093f\\u0932\\u094b\\u0902 \\u0915\\u094b \\u091c\\u094b\\u0921\\u093c\\u0928\\u093e\\u0964 \\u0906\\u092a\\u0915\\u093e \\u092a\\u0930\\u093f\\u0935\\u093e\\u0930\\u0964 \\u0906\\u092a\\u0915\\u0947 \\u092a\\u093e\\u0932\\u0924\\u0942 \\u091c\\u093e\\u0928\\u0935\\u0930. \\u0939\\u092e\\u093e\\u0930\\u093e \\u0910\\u092a.\",\"newsletter_description\":\"\\u0939\\u092e\\u093e\\u0930\\u0940 \\u0928\\u0908 \\u092b\\u093c\\u0940\\u0921 \\u0915\\u0940 \\u0938\\u0926\\u0938\\u094d\\u092f\\u0924\\u093e \\u0932\\u0947\\u0928\\u093e \\u0928 \\u092d\\u0942\\u0932\\u0947\\u0902, \\u0915\\u0943\\u092a\\u092f\\u093e \\u0928\\u0940\\u091a\\u0947 \\u0926\\u093f\\u092f\\u093e \\u0917\\u092f\\u093e \\u092b\\u0949\\u0930\\u094d\\u092e \\u092d\\u0930\\u0947\\u0902\\u0964\"}},\"items\":{\"649618bc598ee\":{\"language\":{\"en\":{\"item_social_icon\":\"lab la-facebook-f\",\"item_title\":\"Facebook\",\"item_link\":\"https:\\/\\/facebook.com\"},\"es\":{\"item_social_icon\":\"lab la-facebook-f\",\"item_title\":\"Facebook\",\"item_link\":\"https:\\/\\/facebook.com\"},\"ar\":{\"item_social_icon\":\"lab la-facebook-f\",\"item_title\":\"\\u0641\\u064a\\u0633\\u0628\\u0648\\u0643\",\"item_link\":\"https:\\/\\/facebook.com\"},\"hi\":{\"item_social_icon\":\"lab la-facebook-f\",\"item_title\":\"\\u092b\\u0947\\u0938\\u092c\\u0941\\u0915\",\"item_link\":\"https:\\/\\/facebook.com\"},\"fr\":{\"item_social_icon\":\"lab la-facebook-f\",\"item_title\":\"Facebook\",\"item_link\":\"https:\\/\\/facebook.com\"}},\"id\":\"649618bc598ee\",\"image\":\"\"},\"649618dbdc83e\":{\"language\":{\"en\":{\"item_social_icon\":\"lab la-twitter\",\"item_title\":\"Twitter\",\"item_link\":\"https:\\/\\/www.facebook.com\"},\"es\":{\"item_social_icon\":\"lab la-twitter\",\"item_title\":\"Gorjeo\",\"item_link\":\"https:\\/\\/www.facebook.com\"},\"ar\":{\"item_social_icon\":\"lab la-twitter\",\"item_title\":\"\\u062a\\u063a\\u0631\\u064a\\u062f\",\"item_link\":\"https:\\/\\/www.facebook.com\"},\"hi\":{\"item_social_icon\":\"lab la-twitter\",\"item_title\":\"\\u091f\\u094d\\u0935\\u093f\\u091f\\u0930\",\"item_link\":\"https:\\/\\/www.facebook.com\"},\"fr\":{\"item_social_icon\":\"lab la-twitter\",\"item_title\":\"Gazouillement\",\"item_link\":\"https:\\/\\/www.facebook.com\"}},\"id\":\"649618dbdc83e\",\"image\":\"\"},\"64961b9796bc2\":{\"language\":{\"en\":{\"item_social_icon\":\"lab la-instagram\",\"item_title\":\"Instagram\",\"item_link\":\"https:\\/\\/www.instagram.com\"},\"es\":{\"item_social_icon\":\"lab la-instagram\",\"item_title\":\"Instagram\",\"item_link\":\"https:\\/\\/www.instagram.com\"},\"ar\":{\"item_social_icon\":\"lab la-instagram\",\"item_title\":\"\\u0627\\u0646\\u0633\\u062a\\u063a\\u0631\\u0627\\u0645\",\"item_link\":\"https:\\/\\/www.instagram.com\"},\"hi\":{\"item_social_icon\":\"lab la-instagram\",\"item_title\":\"Instagram\",\"item_link\":\"https:\\/\\/www.instagram.com\"},\"fr\":{\"item_social_icon\":\"lab la-instagram\",\"item_title\":\"Instagram\",\"item_link\":\"https:\\/\\/www.instagram.com\"}},\"id\":\"64961b9796bc2\",\"image\":\"\"}}}', 1, NULL, NULL, '2024-02-05 04:20:17'),
(5, 'banner-section', '{\"image\":\"\",\"language\":{\"en\":{\"heading\":\"Trusted Partner in Baby and Pet Sitting Services\",\"sub_heading\":\"We understand that your little ones - whether they have two legs or four - are your most precious treasures. That’s why we’ve created a platform that connects you with experienced and caring babysitters and pet sitters in your local area.\",\"left_button_text\":\"Join As Nanny\",\"left_button_link\":null,\"right_button_text\":\"Get Service\",\"right_button_link\":null},\"es\":{\"heading\":\"Socio confiable en servicios de cuidado de bebés y mascotas\",\"sub_heading\":\"Entendemos que tus pequeños, ya tengan dos o cuatro patas, son tus tesoros más preciados. Es por eso que hemos creado una plataforma que lo conecta con niñeras y cuidadores de mascotas experimentados y atentos en su área local.\",\"left_button_text\":\"Únete como niñera\",\"left_button_link\":null,\"right_button_text\":\"Obtener servicio\",\"right_button_link\":null},\"ar\":{\"heading\":\"شريك موثوق به في خدمات مجالسة الأطفال والحيوانات الأليفة\",\"sub_heading\":\"نحن ندرك أن أطفالك الصغار - سواء كان لديهم قدمين أو أربعة - هم أغلى كنوزك. لهذا السبب قمنا بإنشاء منصة تربطك بمربيات الأطفال وجليسات الحيوانات الأليفة ذوي الخبرة والاهتمام في منطقتك المحلية.\",\"left_button_text\":\"انضم كمربية أطفال\",\"left_button_link\":\"\",\"right_button_text\":\"احصل على الخدمة\",\"right_button_link\":\"\"},\"fr\":{\"heading\":\"Partenaire de confiance dans les services de garde de bébés et d\'animaux\",\"sub_heading\":\"Nous comprenons que vos tout-petits, qu\'ils aient deux ou quatre pattes, sont vos trésors les plus précieux. C\'est pourquoi nous avons créé une plateforme qui vous met en relation avec des baby-sitters et des gardiens d\'animaux expérimentés et attentionnés dans votre région.\",\"left_button_text\":\"Rejoignez-nous en tant que nounou\",\"left_button_link\":\"\",\"right_button_text\":\"Obtenir un service\",\"right_button_link\":null},\"hi\":{\"heading\":\"शिशु एवं पालतू जानवरों की देखभाल संबंधी सेवाओं में विश्वसनीय भागीदार\",\"sub_heading\":\"हम समझते हैं कि आपके छोटे बच्चे - चाहे उनके दो पैर हों या चार - आपके सबसे अनमोल खजाने हैं। इसीलिए हमने एक ऐसा मंच बनाया है जो आपको आपके स्थानीय क्षेत्र में अनुभवी और देखभाल करने वाले बच्चों की देखभाल करने वालों और पालतू जानवरों की देखभाल करने वालों से जोड़ता है।\",\"left_button_text\":\"नानी के रूप में शामिल हों\",\"left_button_link\":\"\",\"right_button_text\":\"सेवा प्राप्त करें\",\"right_button_link\":null}}}', 1, NULL, '2023-08-01 12:04:10', '2024-02-02 12:43:36'),
(6, 'best-care-section', '{\"left_image\":\"fba7386b-d92a-45c0-8bcc-38072bb213b8.webp\",\"right_image\":\"03f9f560-bb0b-4c4f-b895-211a97b095bb.webp\",\"language\":{\"en\":{\"sub_heading\":\"Best Care\",\"heading\":\"Where Care Meets Comfort, Because Your Loved Ones Deserve the Best\"},\"es\":{\"sub_heading\":\"Mejor Atención\",\"heading\":\"Donde la atención se encuentra con la comodidad, porque sus seres queridos merecen lo mejor\"},\"ar\":{\"sub_heading\":\"أفضل رعاية\",\"heading\":\"حيث تجتمع الرعاية مع الراحة، لأن أحبائك يستحقون الأفضل\"},\"fr\":{\"sub_heading\":\"Meilleurs soins\",\"heading\":\"Où les soins rencontrent le confort, parce que vos proches méritent le meilleur\"},\"hi\":{\"sub_heading\":\"सर्वोत्तम देखभाल\",\"heading\":\"जहां देखभाल आराम से मिलती है, क्योंकि आपके प्रियजन सर्वश्रेष्ठ के पात्र हैं\"}}}', 1, NULL, '2023-08-02 04:44:29', '2024-02-02 13:31:42'),
(7, 'why-choose-us-section', '{\"id\":19,\"key\":\"why-choose-us-section\",\"value\":{\"id\":19,\"key\":\"why-choose-us-section\",\"value\":{\"id\":19,\"key\":\"why-choose-us-section\",\"value\":{\"id\":19,\"key\":\"why-choose-us-section\",\"value\":{\"language\":{\"en\":{\"sub_heading\":\"Why choose us\",\"heading\":\"We are the experts on your Baby and Pets.\"},\"es\":{\"sub_heading\":null,\"heading\":null}}},\"status\":1,\"serialize\":null,\"created_at\":\"2023-08-03T04:27:34.000000Z\",\"updated_at\":\"2023-08-03T04:27:34.000000Z\",\"image\":\"07b312d9-87a8-413f-bb7e-cc115d130921.webp\",\"language\":{\"en\":{\"sub_heading\":\"Why choose us\",\"heading\":\"We are the experts on your Baby and Pets.\"},\"es\":{\"sub_heading\":null,\"heading\":null}},\"items\":{\"64cb2ce3d8828\":{\"language\":{\"en\":{\"item_title\":\"Fast Service\",\"item_description\":\"We are provied fast service. When your need a nanny come to our website and get best nanny service in your day to day life.\"},\"es\":{\"item_title\":null,\"item_description\":null}},\"id\":\"64cb2ce3d8828\",\"image\":\"0d754ff9-3376-4b0b-a08b-c635f259a92b.webp\"}}},\"status\":1,\"serialize\":null,\"created_at\":\"2023-08-03T04:27:34.000000Z\",\"updated_at\":\"2023-08-03T04:28:19.000000Z\",\"language\":{\"en\":{\"sub_heading\":\"Why choose us\",\"heading\":\"We are the experts on your Baby and Pets.\"},\"es\":{\"sub_heading\":null,\"heading\":null}}},\"status\":1,\"serialize\":null,\"created_at\":\"2023-08-03T04:27:34.000000Z\",\"updated_at\":\"2023-08-03T05:25:56.000000Z\",\"language\":{\"en\":{\"sub_heading\":\"Why choose us\",\"heading\":\"We are the experts on your Baby and Pets.\"},\"es\":{\"sub_heading\":null,\"heading\":null}},\"items\":{\"64cb40c1d8b9b\":{\"language\":{\"en\":{\"item_title\":\"Online Payment\",\"item_description\":\"ff\"},\"es\":{\"item_title\":null,\"item_description\":null}},\"id\":\"64cb40c1d8b9b\",\"image\":\"19a104f2-d6da-4a4c-95a4-ed6846a19f38.webp\"}}},\"status\":1,\"serialize\":null,\"created_at\":\"2023-08-03T04:27:34.000000Z\",\"updated_at\":\"2023-08-03T05:53:06.000000Z\",\"language\":{\"en\":{\"sub_heading\":\"Why choose us\",\"heading\":\"Elevating Care, Ensuring Trust\"},\"es\":{\"sub_heading\":\"¿Por qué elegirnos?\",\"heading\":\"Mejorar la atención, garantizar la confianza\"},\"ar\":{\"sub_heading\":\"لماذا تختارنا؟\",\"heading\":\"رفع مستوى الرعاية، وضمان الثقة\"},\"fr\":{\"sub_heading\":\"Pourquoi nous choisir\",\"heading\":\"Améliorer les soins, garantir la confiance\"},\"hi\":{\"sub_heading\":\"हमें क्यों चुनें\",\"heading\":\"देखभाल को बढ़ाना, विश्वास को सुनिश्चित करना\"}},\"items\":{\"64cb435ae3eb7\":{\"language\":{\"en\":{\"item_title\":\"Trusted Excellence\",\"item_description\":\"Choose SitterHub for our commitment to trusted excellence, where every babysitter and pet sitter is carefully vetted to ensure unparalleled care for your loved ones.\"},\"es\":{\"item_title\":\"Excelencia confiable\",\"item_description\":\"Elija SitterHub por nuestro compromiso con la excelencia confiable, donde cada niñera y cuidador de mascotas es cuidadosamente examinado para garantizar una atención incomparable para sus seres queridos.\"},\"ar\":{\"item_title\":\"التميز الموثوق\",\"item_description\":\"اختر SitterHub لالتزامنا بالتميز الموثوق به، حيث يتم فحص كل جليسة أطفال وجليسة حيوانات أليفة بعناية لضمان رعاية لا مثيل لها لأحبائك.\"},\"fr\":{\"item_title\":\"Excellence fiable\",\"item_description\":\"Choisissez SitterHub pour notre engagement envers l\'excellence de confiance, où chaque baby-sitter et gardien d\'animaux est soigneusement sélectionné pour garantir des soins inégalés à vos proches.\"},\"hi\":{\"item_title\":\"विश्वसनीय उत्कृष्टता\",\"item_description\":\"विश्वसनीय उत्कृष्टता के प्रति हमारी प्रतिबद्धता के लिए सिटरहब चुनें, जहां आपके प्रियजनों के लिए अद्वितीय देखभाल सुनिश्चित करने के लिए प्रत्येक दाई और पालतू जानवर की देखभाल करने वाले की सावधानीपूर्वक जांच की जाती है।\"}},\"id\":\"64cb435ae3eb7\",\"image\":\"460a32d0-edc3-40da-965d-b43d3fcb0d00.webp\"},\"652cb7c272f9a\":{\"language\":{\"en\":{\"item_title\":\"Tailored Convenience\",\"item_description\":\"Opt for SitterHub’s tailored convenience, offering flexible scheduling options and a user-friendly platform for seamless connections with experienced caregivers.\"},\"es\":{\"item_title\":\"Comodidad a medida\",\"item_description\":\"Opte por la comodidad personalizada de SitterHub, que ofrece opciones de programación flexibles y una plataforma fácil de usar para conexiones perfectas con cuidadores experimentados.\"},\"ar\":{\"item_title\":\"راحة مصممة خصيصاً\",\"item_description\":\"اختر الراحة المخصصة التي يوفرها SitterHub، حيث يقدم خيارات جدولة مرنة ومنصة سهلة الاستخدام لإجراء اتصالات سلسة مع مقدمي الرعاية ذوي الخبرة.\"},\"fr\":{\"item_title\":\"Commodité sur mesure\",\"item_description\":\"Optez pour la commodité sur mesure de SitterHub, offrant des options de planification flexibles et une plate-forme conviviale pour des connexions transparentes avec des soignants expérimentés.\"},\"hi\":{\"item_title\":\"अनुरूप सुविधा\",\"item_description\":\"सिटरहब की अनुरूप सुविधा का विकल्प चुनें, जो लचीले शेड्यूलिंग विकल्प और अनुभवी देखभालकर्ताओं के साथ निर्बाध कनेक्शन के लिए एक उपयोगकर्ता-अनुकूल मंच प्रदान करता है।\"}},\"id\":\"652cb7c272f9a\",\"image\":\"512872ac-5544-4deb-9b4c-ef91939c7a53.webp\"},\"652cb81a27619\":{\"language\":{\"en\":{\"item_title\":\"Safety Assurance\",\"item_description\":\"Prioritize safety with SitterHub, as we employ rigorous background checks and thorough vetting processes to guarantee a secure environment for your family and pets.\"},\"es\":{\"item_title\":\"Garantía de seguridad\",\"item_description\":\"Priorice la seguridad con SitterHub, ya que empleamos rigurosas verificaciones de antecedentes y procesos de investigación exhaustivos para garantizar un entorno seguro para su familia y sus mascotas.\"},\"ar\":{\"item_title\":\"ضمان السلامة\",\"item_description\":\"قم بإعطاء الأولوية للسلامة مع SitterHub، حيث أننا نستخدم فحوصات خلفية صارمة وعمليات فحص شاملة لضمان بيئة آمنة لعائلتك وحيواناتك الأليفة.\"},\"fr\":{\"item_title\":\"Assurance de sécurité\",\"item_description\":\"Donnez la priorité à la sécurité avec SitterHub, car nous effectuons des vérifications rigoureuses des antécédents et des processus de contrôle approfondis pour garantir un environnement sécurisé pour votre famille et vos animaux de compagnie.\"},\"hi\":{\"item_title\":\"सुरक्षा आश्वासन\",\"item_description\":\"सिटरहब के साथ सुरक्षा को प्राथमिकता दें, क्योंकि हम आपके परिवार और पालतू जानवरों के लिए एक सुरक्षित वातावरण की गारंटी के लिए कठोर पृष्ठभूमि जांच और संपूर्ण जांच प्रक्रियाएं अपनाते हैं।\"}},\"id\":\"652cb81a27619\",\"image\":\"057cda1e-b988-4411-8ed9-58d0e57ac0fd.webp\"},\"652cb84ad3936\":{\"language\":{\"en\":{\"item_title\":\"Community Connection\",\"item_description\":\"Embrace community connection by choosing SitterHub, where you can share experiences, seek advice, and build relationships with like-minded parents and pet owners in our vibrant community.\"},\"es\":{\"item_title\":\"Conexión comunitaria\",\"item_description\":\"Adopte la conexión comunitaria eligiendo SitterHub, donde puede compartir experiencias, buscar consejos y establecer relaciones con padres y dueños de mascotas con ideas afines en nuestra vibrante comunidad.\"},\"ar\":{\"item_title\":\"اتصال المجتمع\",\"item_description\":\"احتضن التواصل المجتمعي عن طريق اختيار SitterHub، حيث يمكنك مشاركة الخبرات وطلب المشورة وبناء العلاقات مع الآباء وأصحاب الحيوانات الأليفة ذوي التفكير المماثل في مجتمعنا النابض بالحياة.\"},\"fr\":{\"item_title\":\"Connexion communautaire\",\"item_description\":\"Adoptez la connexion communautaire en choisissant SitterHub, où vous pouvez partager des expériences, demander des conseils et établir des relations avec des parents et des propriétaires d\'animaux partageant les mêmes idées dans notre communauté dynamique.\"},\"hi\":{\"item_title\":\"सामुदायिक कनेक्शन\",\"item_description\":\"सिटरहब को चुनकर सामुदायिक कनेक्शन को अपनाएं, जहां आप अनुभव साझा कर सकते हैं, सलाह ले सकते हैं और हमारे जीवंत समुदाय में समान विचारधारा वाले माता-पिता और पालतू जानवरों के मालिकों के साथ संबंध बना सकते हैं।\"}},\"id\":\"652cb84ad3936\",\"image\":\"e6d07ff3-636f-4608-9a59-ecf0faa2ba9b.webp\"}},\"image\":\"8c04ed14-6380-469f-bbea-1e0e3ec66baf.webp\"}', 1, NULL, '2023-08-03 04:57:34', '2024-02-02 13:38:43'),
(8, 'feature-section', '{\"language\":{\"en\":{\"sub_heading\":\"Our Services\",\"heading\":\"We are best in!\",\"type\":\"Services Type\"},\"es\":{\"sub_heading\":\"Nuestros Servicios\",\"heading\":\"¡Somos los mejores!\",\"type\":\"Tipo de servicios\"},\"ar\":{\"sub_heading\":\"خدماتنا\",\"heading\":\"نحن الأفضل في!\",\"type\":\"نوع الخدمات\"},\"fr\":{\"sub_heading\":\"Nos prestations\",\"heading\":\"Nous sommes les meilleurs !\",\"type\":\"Type de service\"},\"hi\":{\"sub_heading\":\"हमारी सेवाएँ\",\"heading\":\"हम इसमें सर्वश्रेष्ठ हैं!\",\"type\":\"सेवा प्रकार\"}},\"items\":{\"64cb52aa7d43e\":{\"language\":{\"en\":{\"item_type\":\"baby\",\"item_title\":\"Expert Babysitters\",\"item_description\":\"Connect with experienced and vetted babysitters who prioritize the safety and well-being of your little ones, ensuring they receive expert care tailored to their unique needs.\"},\"es\":{\"item_type\":\"bebé\",\"item_title\":\"Niñeras expertas\",\"item_description\":\"Conéctese con niñeras experimentadas y examinadas que priorizan la seguridad y el bienestar de sus pequeños, asegurándose de que reciban una atención experta adaptada a sus necesidades únicas.\"},\"ar\":{\"item_type\":\"طفل\",\"item_title\":\"المربيات الخبراء\",\"item_description\":\"تواصل مع جليسات الأطفال ذوي الخبرة والذين تم فحصهم والذين يعطون الأولوية لسلامة ورفاهية أطفالك الصغار، مما يضمن حصولهم على رعاية متخصصة مصممة خصيصًا لتلبية احتياجاتهم الفريدة.\"},\"fr\":{\"item_type\":\"bébé\",\"item_title\":\"Baby-sitters expertes\",\"item_description\":\"Connectez-vous avec des baby-sitters expérimentés et agréés qui donnent la priorité à la sécurité et au bien-être de vos tout-petits, en veillant à ce qu\'ils reçoivent des soins experts adaptés à leurs besoins uniques.\"},\"hi\":{\"item_type\":\"बच्चा\",\"item_title\":\"विशेषज्ञ बेबीसिटर्स\",\"item_description\":\"अनुभवी और जांचे-परखे बेबीसिटर्स से जुड़ें जो आपके छोटे बच्चों की सुरक्षा और भलाई को प्राथमिकता देते हैं, यह सुनिश्चित करते हुए कि उन्हें उनकी विशिष्ट आवश्यकताओं के अनुरूप विशेषज्ञ देखभाल प्राप्त हो।\"}},\"id\":\"64cb52aa7d43e\",\"image\":\"9481c466-c962-4e6f-a121-e2d2ef06a1f6.webp\"},\"64cb52d22e0db\":{\"language\":{\"en\":{\"item_type\":\"pet\",\"item_title\":\"Diverse Pet Sitter Profiles\",\"item_description\":\"Explore a variety of pet sitters with expertise in different animals and breeds, providing a diverse range of caregivers who understand and adore your furry friends.\"},\"es\":{\"item_type\":\"mascota\",\"item_title\":\"Diversos perfiles de cuidadores de mascotas\",\"item_description\":\"Explore una variedad de cuidadores de mascotas con experiencia en diferentes animales y razas, que brindan una amplia gama de cuidadores que comprenden y adoran a sus amigos peludos.\"},\"ar\":{\"item_type\":\"حيوان أليف\",\"item_title\":\"ملفات تعريف جليسة الحيوانات الأليفة المتنوعة\",\"item_description\":\"استكشف مجموعة متنوعة من جليسات الحيوانات الأليفة من ذوي الخبرة في الحيوانات والسلالات المختلفة، مما يوفر مجموعة متنوعة من مقدمي الرعاية الذين يفهمون أصدقاءك ذوي الفراء ويعشقونها.\"},\"fr\":{\"item_type\":\"animal de compagnie\",\"item_title\":\"Divers profils de gardiens d’animaux\",\"item_description\":\"Découvrez une variété de gardiens d\'animaux possédant une expertise dans différents animaux et races, offrant ainsi un large éventail de soignants qui comprennent et adorent vos amis à quatre pattes.\"},\"hi\":{\"item_type\":\"पालतू\",\"item_title\":\"विविध पालतू पशुपालक प्रोफाइल\",\"item_description\":\"विभिन्न जानवरों और नस्लों में विशेषज्ञता वाले विभिन्न प्रकार के पालतू जानवरों की देखभाल करने वालों का पता लगाएं, जो देखभाल करने वालों की एक विविध श्रृंखला प्रदान करते हैं जो आपके प्यारे दोस्तों को समझते हैं और उनकी सराहना करते हैं।\"}},\"id\":\"64cb52d22e0db\",\"image\":\"586974bb-b552-4a63-80bf-040995967ab9.webp\"},\"654602a4d7070\":{\"language\":{\"en\":{\"item_type\":\"baby\",\"item_title\":\"Flexible Scheduling\",\"item_description\":\"Enjoy the convenience of customizable scheduling, allowing you to book babysitters for specific hours, date nights, or last-minute needs, adapting to the dynamic lifestyle of parenthood.\"},\"es\":{\"item_type\":\"bebé\",\"item_title\":\"Horarios flexibles\",\"item_description\":\"Disfrute de la comodidad de una programación personalizable, que le permite reservar niñeras para horas específicas, citas nocturnas o necesidades de último momento, adaptándose al estilo de vida dinámico de la paternidad.\"},\"ar\":{\"item_type\":\"طفل\",\"item_title\":\"جدولة مرنة\",\"item_description\":\"استمتع براحة الجدولة القابلة للتخصيص، مما يسمح لك بحجز جليسات أطفال لساعات محددة، أو ليالي موعد، أو لاحتياجات اللحظة الأخيرة، والتكيف مع نمط الحياة الديناميكي للأبوة.\"},\"fr\":{\"item_type\":\"bébé\",\"item_title\":\"Planification flexible\",\"item_description\":\"Profitez de la commodité d\'une planification personnalisable, vous permettant de réserver des baby-sitters pour des heures spécifiques, des soirées en amoureux ou des besoins de dernière minute, en vous adaptant au style de vie dynamique de la parentalité.\"},\"hi\":{\"item_type\":\"बच्चा\",\"item_title\":\"लचीला शेड्यूलिंग\",\"item_description\":\"अनुकूलन योग्य शेड्यूलिंग की सुविधा का आनंद लें, जिससे आप माता-पिता की गतिशील जीवनशैली को अपनाते हुए विशिष्ट घंटों, डेट की रातों या आखिरी मिनट की जरूरतों के लिए बच्चों की देखभाल करने वालों को बुक कर सकते हैं।\"}},\"id\":\"654602a4d7070\",\"image\":\"953549d3-3775-4eaa-abf0-9e31b6242e4e.webp\"},\"654602f629853\":{\"language\":{\"en\":{\"item_type\":\"baby\",\"item_title\":\"Real-Time Updates\",\"item_description\":\"Stay connected with your babysitter through our secure messaging system, receiving instant updates, photos, and messages about your baby’s activities, fostering peace of mind while you’re away.\"},\"es\":{\"item_type\":\"bebé\",\"item_title\":\"Actualizaciones en tiempo real\",\"item_description\":\"Manténgase conectado con su niñera a través de nuestro sistema de mensajería seguro, recibiendo actualizaciones instantáneas, fotos y mensajes sobre las actividades de su bebé, fomentando su tranquilidad mientras está fuera.\"},\"ar\":{\"item_type\":\"طفل\",\"item_title\":\"تحديثات في الوقت الحقيقي\",\"item_description\":\"ابق على اتصال مع جليسة الأطفال الخاصة بك من خلال نظام الرسائل الآمن لدينا، وتلقي التحديثات الفورية والصور والرسائل حول أنشطة طفلك، وتعزيز راحة البال أثناء غيابك.\"},\"fr\":{\"item_type\":\"bébé\",\"item_title\":\"Mises à jour en temps réel\",\"item_description\":\"Restez en contact avec votre baby-sitter grâce à notre système de messagerie sécurisé, recevez des mises à jour instantanées, des photos et des messages sur les activités de votre bébé, favorisant ainsi la tranquillité d\'esprit pendant votre absence.\"},\"hi\":{\"item_type\":\"बच्चा\",\"item_title\":\"वास्तविक समय अपडेट\",\"item_description\":\"हमारे सुरक्षित संदेश प्रणाली के माध्यम से अपनी दाई के साथ जुड़े रहें, अपने बच्चे की गतिविधियों के बारे में त्वरित अपडेट, फ़ोटो और संदेश प्राप्त करें, जिससे आपके दूर रहने पर मानसिक शांति बनी रहेगी।\"}},\"id\":\"654602f629853\",\"image\":\"25623874-004d-49e2-b821-d46f6b92ce0d.webp\"},\"6546030fe4789\":{\"language\":{\"en\":{\"item_type\":\"baby\",\"item_title\":\"Specialized Baby Care Plans\",\"item_description\":\"Personalize your baby’s care by communicating specific instructions, routines, and preferences directly with your chosen babysitter, ensuring a tailored and nurturing experience.\"},\"es\":{\"item_type\":\"bebé\",\"item_title\":\"Planes especializados para el cuidado del bebé\",\"item_description\":\"Personalice el cuidado de su bebé comunicando instrucciones, rutinas y preferencias específicas directamente con la niñera elegida, garantizando una experiencia personalizada y enriquecedora.\"},\"ar\":{\"item_type\":\"طفل\",\"item_title\":\"خطط رعاية الطفل المتخصصة\",\"item_description\":\"قم بتخصيص رعاية طفلك من خلال توصيل تعليمات وإجراءات وتفضيلات محددة مباشرة إلى جليسة الأطفال التي اخترتها، مما يضمن تجربة مخصصة ورعاية.\"},\"fr\":{\"item_type\":\"bébé\",\"item_title\":\"Plans de soins spécialisés pour bébés\",\"item_description\":\"Personnalisez les soins de votre bébé en communiquant des instructions, des routines et des préférences spécifiques directement avec la baby-sitter de votre choix, garantissant ainsi une expérience sur mesure et enrichissante.\"},\"hi\":{\"item_type\":\"बच्चा\",\"item_title\":\"विशिष्ट शिशु देखभाल योजनाएँ\",\"item_description\":\"अपने चुने हुए दाई के साथ सीधे विशिष्ट निर्देशों, दिनचर्या और प्राथमिकताओं के बारे में संवाद करके अपने बच्चे की देखभाल को वैयक्तिकृत करें, एक अनुरूप और पोषण अनुभव सुनिश्चित करें।\"}},\"id\":\"6546030fe4789\",\"image\":\"e8063268-bd16-4fe2-8a2c-7b95473a3df0.webp\"},\"654603c07f4bb\":{\"language\":{\"en\":{\"item_type\":\"pet\",\"item_title\":\"Tailored Play Sessions\",\"item_description\":\"A nanny involves hiring an individual who will take your pet for walks during times when you are unable to do so.\"},\"es\":{\"item_type\":\"mascota\",\"item_title\":\"Sesiones de juego personalizadas\",\"item_description\":\"Una niñera implica contratar a una persona que sacará a pasear a su mascota en los momentos en que usted no pueda hacerlo.\"},\"ar\":{\"item_type\":\"حيوان أليف\",\"item_title\":\"جلسات اللعب المخصصة\",\"item_description\":\"تتضمن المربية تعيين شخص سيأخذ حيوانك الأليف للتنزه في الأوقات التي لا تستطيع فيها القيام بذلك.\"},\"fr\":{\"item_type\":\"animal de compagnie\",\"item_title\":\"Séances de jeu sur mesure\",\"item_description\":\"Une nounou consiste à embaucher une personne qui emmènera votre animal se promener lorsque vous ne pouvez pas le faire.\"},\"hi\":{\"item_type\":\"पालतू\",\"item_title\":\"अनुकूलित खेल सत्र\",\"item_description\":\"एक नानी में एक ऐसे व्यक्ति को नियुक्त करना शामिल होता है जो आपके पालतू जानवर को ऐसे समय में सैर के लिए ले जाएगा जब आप ऐसा करने में असमर्थ हों।\"}},\"id\":\"654603c07f4bb\",\"image\":\"92bb27e8-1741-4d97-8ff7-341c6f5e16ff.webp\"},\"6546040960160\":{\"language\":{\"en\":{\"item_type\":\"pet\",\"item_title\":\"Daily Diary Photo Updates\",\"item_description\":\"Experience your pet’s day in real-time with a daily diary feature, including updates on activities, meals, and adorable photo snapshots, fostering a sense of connection while you’re away.\"},\"es\":{\"item_type\":\"mascota\",\"item_title\":\"Actualizaciones diarias de fotos del diario\",\"item_description\":\"Experimente el día de su mascota en tiempo real con una función de diario, que incluye actualizaciones sobre actividades, comidas y adorables instantáneas fotográficas, fomentando una sensación de conexión mientras está fuera.\"},\"ar\":{\"item_type\":\"حيوان أليف\",\"item_title\":\"تحديثات صور اليوميات اليومية\",\"item_description\":\"استمتع بيوم حيوانك الأليف في الوقت الفعلي من خلال ميزة المذكرات اليومية، بما في ذلك تحديثات الأنشطة والوجبات ولقطات الصور الرائعة، مما يعزز الشعور بالتواصل أثناء وجودك بعيدًا.\"},\"fr\":{\"item_type\":\"animal de compagnie\",\"item_title\":\"Mises à jour quotidiennes des photos du journal\",\"item_description\":\"Vivez la journée de votre animal en temps réel grâce à une fonction de journal quotidien, comprenant des mises à jour sur les activités, les repas et d\'adorables instantanés photo, favorisant un sentiment de connexion pendant votre absence.\"},\"hi\":{\"item_type\":\"पालतू\",\"item_title\":\"दैनिक डायरी फोटो अपडेट\",\"item_description\":\"दैनिक डायरी सुविधा के साथ वास्तविक समय में अपने पालतू जानवर के दिन का अनुभव करें, जिसमें गतिविधियों, भोजन और मनमोहक फोटो स्नैपशॉट पर अपडेट शामिल हैं, जो आपके दूर रहने के दौरान जुड़ाव की भावना को बढ़ावा देते हैं।\"}},\"id\":\"6546040960160\",\"image\":\"c76198c6-dc52-4c4d-a527-1359b9edafd5.webp\"},\"65460423011f4\":{\"language\":{\"en\":{\"item_type\":\"pet\",\"item_title\":\"Medication Administration\",\"item_description\":\"For pets with medical needs, connect with caregivers experienced in administering medications, ensuring your pet’s health is managed with care and expertise.\"},\"es\":{\"item_type\":\"mascota\",\"item_title\":\"Administración de medicamentos\",\"item_description\":\"Para mascotas con necesidades médicas, comuníquese con cuidadores con experiencia en la administración de medicamentos, asegurándose de que la salud de su mascota se maneje con cuidado y experiencia.\"},\"ar\":{\"item_type\":\"حيوان أليف\",\"item_title\":\"إدارة الدواء\",\"item_description\":\"بالنسبة للحيوانات الأليفة ذات الاحتياجات الطبية، تواصل مع مقدمي الرعاية ذوي الخبرة في إدارة الأدوية، مما يضمن إدارة صحة حيوانك الأليف بعناية وخبرة.\"},\"fr\":{\"item_type\":\"animal de compagnie\",\"item_title\":\"Administration des médicaments\",\"item_description\":\"Pour les animaux ayant des besoins médicaux, contactez des soignants expérimentés dans l’administration de médicaments, afin de garantir que la santé de votre animal est gérée avec soin et expertise.\"},\"hi\":{\"item_type\":\"पालतू\",\"item_title\":\"दवा प्रशासन\",\"item_description\":\"चिकित्सा आवश्यकताओं वाले पालतू जानवरों के लिए, दवाएँ देने में अनुभवी देखभाल करने वालों से जुड़ें, यह सुनिश्चित करते हुए कि आपके पालतू जानवर का स्वास्थ्य देखभाल और विशेषज्ञता के साथ प्रबंधित किया जाता है।\"}},\"id\":\"65460423011f4\",\"image\":\"2563009c-2244-42e9-89ae-3fa54285c958.webp\"}}}', 1, NULL, '2023-08-03 07:39:10', '2024-02-02 13:30:36'),
(9, 'blog-section', '{\"language\":{\"en\":{\"sub_heading\":\"Blog\",\"heading\":\"Our Latest Blog\"},\"es\":{\"sub_heading\":\"Blog\",\"heading\":\"Nuestro último blog\"},\"ar\":{\"sub_heading\":\"مدونة\",\"heading\":\"أحدث مدونتنا\"},\"fr\":{\"sub_heading\":\"Blogue\",\"heading\":\"Notre dernier blog\"},\"hi\":{\"sub_heading\":\"ब्लॉग\",\"heading\":\"हमारा नवीनतम ब्लॉग\"}}}', 1, NULL, '2023-08-03 11:20:06', '2023-11-05 09:26:10'),
(10, 'call-to-action-section', '{\"image\":\"\",\"language\":{\"en\":{\"heading\":\"Are You Ready To Service Nanny?\",\"button_text\":\"Lets Talk to Our Experts\",\"button_link\":null},\"es\":{\"heading\":\"¿Estás listo para atender a la niñera?\",\"button_text\":\"Hablemos con nuestros expertos\",\"button_link\":null},\"ar\":{\"heading\":\"هل أنت مستعد لخدمة مربية الأطفال؟\",\"button_text\":\"فلنتحدث إلى خبرائنا\",\"button_link\":null},\"fr\":{\"heading\":\"Êtes-vous prêt à servir une nounou ?\",\"button_text\":\"Parlons à nos experts\",\"button_link\":\"\"},\"hi\":{\"heading\":\"क्या आप नानी की सेवा के लिए तैयार हैं?\",\"button_text\":\"आइए हमारे विशेषज्ञों से बात करें\",\"button_link\":\"\"}}}', 1, NULL, '2023-09-20 06:05:31', '2023-11-05 09:24:15'),
(11, 'app-download-section', '{\"image\":\"ff373001-2d7f-4597-ae9a-db555a00c601.webp\",\"language\":{\"en\":{\"sub_heading\":\"App Download\",\"heading\":\"Download Our App and Unlock a World of Care\",\"description\":\"Embark on a seamless caregiving journey by downloading the SitterHub app. Take the next step in providing the best care for your loved ones with just a few taps. Here’s why you should make SitterHub a part of your family.\"},\"es\":{\"sub_heading\":\"Descarga de la aplicación\",\"heading\":\"Descargue nuestra aplicación y descubra un mundo de atención\",\"description\":\"Embárquese en un viaje de cuidado sin interrupciones descargando la aplicación SitterHub. Dé el siguiente paso para brindar la mejor atención a sus seres queridos con solo unos pocos toques. He aquí por qué debería hacer que SitterHub forme parte de su familia.\"},\"ar\":{\"sub_heading\":\"تحميل التطبيق\",\"heading\":\"قم بتنزيل تطبيقنا وافتح عالمًا من الرعاية\",\"description\":\"انطلق في رحلة تقديم رعاية سلسة عن طريق تنزيل تطبيق SitterHub. اتخذ الخطوة التالية في تقديم أفضل رعاية لأحبائك ببضع نقرات فقط. لهذا السبب يجب عليك جعل SitterHub جزءًا من عائلتك.\"},\"fr\":{\"sub_heading\":\"Téléchargement de l\'application\",\"heading\":\"Téléchargez notre application et débloquez un monde de soins\",\"description\":\"Embarquez pour un parcours de soins fluide en téléchargeant l\'application SitterHub. Passez à l\'étape suivante en fournissant les meilleurs soins à vos proches en quelques clics. Voici pourquoi vous devriez intégrer SitterHub à votre famille.\"},\"hi\":{\"sub_heading\":\"ऐप डाउनलोड करें\",\"heading\":\"हमारा ऐप डाउनलोड करें और देखभाल की दुनिया को अनलॉक करें\",\"description\":\"सिटरहब ऐप डाउनलोड करके एक निर्बाध देखभाल यात्रा शुरू करें। बस कुछ ही टैप से अपने प्रियजनों को सर्वोत्तम देखभाल प्रदान करने की दिशा में अगला कदम उठाएँ। यहां बताया गया है कि आपको सिटरहब को अपने परिवार का हिस्सा क्यों बनाना चाहिए।\"}}}', 1, NULL, '2023-10-05 04:54:13', '2024-02-05 04:08:13'),
(12, 'login-section', '{\"image\":\"050fbc23-5485-45a3-b58e-5a9a01522092.webp\",\"language\":{\"en\":{\"heading\":\"Login\"},\"es\":{\"heading\":\"Acceso\"},\"ar\":{\"heading\":\"تسجيل الدخول\"},\"fr\":{\"heading\":\"Se connecter\"},\"hi\":{\"heading\":\"लॉग इन करें\"}}}', 1, NULL, '2023-12-13 12:27:51', '2023-12-13 13:07:20'),
(13, 'user-register-section', '{\"image\":\"767f80a1-a268-4827-b43b-947983fbc137.webp\",\"language\":{\"en\":{\"heading\":\"User Register\"},\"es\":{\"heading\":\"Registro de usuario\"},\"ar\":{\"heading\":\"تسجيل المستخدم\"},\"fr\":{\"heading\":\"Registre des utilisateurs\"},\"hi\":{\"heading\":\"उपयोगकर्ता रजिस्टर\"}}}', 1, NULL, '2023-12-13 12:50:31', '2023-12-13 12:50:31');

-- --------------------------------------------------------

--
-- Table structure for table `subscribes`
--

CREATE TABLE `subscribes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_maintenances`
--

CREATE TABLE `system_maintenances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(191) NOT NULL DEFAULT 'system-maintenance',
  `title` varchar(191) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_maintenances`
--

INSERT INTO `system_maintenances` (`id`, `slug`, `title`, `details`, `status`, `created_at`, `updated_at`) VALUES
(1, 'system-maintenance', 'Enhancing Your Experience – Site Under Maintenance', '<p>Our website is down for upgrades and will be back shortly. If you need assistance, please email us at <strong>support@sitterhub.com</strong> or message us on WhatsApp at <strong>+1234567890</strong>. Thank you for your patience!</p>', 0, '2025-03-27 13:44:26', '2025-03-27 13:44:26');

-- --------------------------------------------------------

--
-- Table structure for table `temporary_datas`
--

CREATE TABLE `temporary_datas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) NOT NULL,
  `identifier` varchar(191) NOT NULL,
  `gateway_code` varchar(191) DEFAULT NULL,
  `currency_code` varchar(191) DEFAULT NULL,
  `data` mediumtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nanny_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_wallet_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_gateway_currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('ADD-MONEY','MONEY-OUT','WITHDRAW','COMMISSION','BONUS','TRANSFER-MONEY','MONEY-EXCHANGE','ADD-SUBTRACT-BALANCE','SELL-COIN','NANNY-PAYMENT') NOT NULL,
  `trx_id` varchar(191) NOT NULL COMMENT 'Transaction ID',
  `request_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `payable` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `available_balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `remark` varchar(191) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `reject_reason` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Default, 1: Success, 2: Pending, 3: Hold, 4: Rejected',
  `attribute` enum('SEND','RECEIVED') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `callback_ref` varchar(191) DEFAULT NULL,
  `nanny_wallet_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_charges`
--

CREATE TABLE `transaction_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `percent_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `total_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_devices`
--

CREATE TABLE `transaction_devices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `mac` varchar(17) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `browser` varchar(30) DEFAULT NULL,
  `os` varchar(30) DEFAULT NULL,
  `timezone` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_settings`
--

CREATE TABLE `transaction_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(50) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `fixed_charge` decimal(8,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `percent_charge` decimal(8,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `min_limit` decimal(8,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `max_limit` decimal(8,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `monthly_limit` decimal(8,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `daily_limit` decimal(8,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_settings`
--

INSERT INTO `transaction_settings` (`id`, `admin_id`, `slug`, `title`, `fixed_charge`, `percent_charge`, `min_limit`, `max_limit`, `monthly_limit`, `daily_limit`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'charge', 'Service Charge', '2.00', '0.00', '0.00', '50000.00', '50000.00', '5000.00', 1, NULL, '2023-06-17 17:48:11');

-- --------------------------------------------------------

--
-- Table structure for table `useful_links`
--

CREATE TABLE `useful_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) NOT NULL,
  `title` text NOT NULL,
  `slug` varchar(191) NOT NULL,
  `url` varchar(191) NOT NULL,
  `content` longtext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `editable` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `useful_links`
--

INSERT INTO `useful_links` (`id`, `type`, `title`, `slug`, `url`, `content`, `status`, `editable`, `created_at`, `updated_at`) VALUES
(1, 'UNKNOWN', '{\"language\":{\"en\":{\"title\":\"Privacy Policy\"},\"es\":{\"title\":\"política de privacidad\"},\"ar\":{\"title\":\"سياسة الخصوصية\"},\"fr\":{\"title\":\"politique de confidentialité\"},\"hi\":{\"title\":\"गोपनीयता नीति\"}}}', 'privacy-policy', 'privacy-policy', '{\"language\":{\"en\":{\"content\":\"<p>At SitterHub, we understand the importance of your privacy and are committed to protecting it. This Privacy Policy outlines how we collect, use, disclose, and safeguard your personal information. By using the SitterHub platform, you consent to the practices described in this policy.<br>**1. Information We Collect:**<br>- **User Information:** When you sign up for SitterHub, we collect personal information such as your name, email address, and contact details to create and manage your account.<br>- **Payment Information:** To facilitate transactions, we collect payment details, including credit card information, which is processed securely through our payment gateway.<br>- **Profile Information:** Users can provide additional information, such as photos, preferences, and special instructions, to personalize their profiles and enhance the caregiving experience.<br>- **Usage Data:** We collect data on how you interact with our platform, including browsing activity, search queries, and preferences, to improve our services.<br>**2. How We Use Your Information:**<br>- **Providing Services:** We use your information to connect you with suitable babysitters and pet sitters, process bookings, and facilitate communication between users.<br>- **Improving User Experience:** Collected data is utilized to enhance our platform, tailor recommendations, and optimize user experience based on preferences and feedback.<br>- **Security and Fraud Prevention:** We employ your information to ensure the security of our platform, detect and prevent fraudulent activities, and protect the rights and safety of users.<br>- **Communication:** We use your contact information to send important updates, notifications, and respond to inquiries. Users can manage communication preferences in their account settings.<br>**3. How We Share Your Information:**<br>- **Sitter Communication:** Your profile information, including preferences and special instructions, is shared with selected babysitters or pet sitters to ensure personalized care.<br>- **Third-Party Service Providers:** We may share information with trusted third-party service providers, such as payment processors and IT service providers, to support our platform’s functionality.<br>- **Legal Compliance:** We may disclose your information in response to legal requests, enforce our terms and policies, or protect the rights, property, and safety of SitterHub, its users, and others.<br>**4. Your Choices and Controls:**<br>- **Profile Management:** Users can access and update their profile information, communication preferences, and account settings at any time.<br>- **Opt-Out:** You can opt-out of certain communications by adjusting your preferences in the app or contacting us directly.<br>**5. Security Measures:**<br>We employ industry-standard security measures to protect your information from unauthorized access, disclosure, alteration, and destruction. However, no method of transmission over the internet or electronic storage is entirely secure, and absolute security cannot be guaranteed.<br>**6. Children’s Privacy:**<br>SitterHub is not directed to children under the age of 13. We do not knowingly collect personal information from children. If you become aware that a child has provided us with personal information, please contact us, and we will take steps to remove the information promptly.<br>**7. Changes to Privacy Policy:**<br>SitterHub reserves the right to update this Privacy Policy periodically. Users will be notified of any significant changes via email or through the app. Continued use of the platform after such modifications constitutes acceptance of the updated policy.<br>**8. Contact Us:**<br>If you have any questions, concerns, or requests regarding this Privacy Policy, please contact us at [support@sitterhub.com](mailto:support@sitterhub.com).<br>*Your privacy matters to us. Thank you for trusting SitterHub.*<\\/p>\"},\"es\":{\"content\":\"<p>En SitterHub, entendemos la importancia de su privacidad y estamos comprometidos a protegerla. Esta Política de Privacidad describe cómo recopilamos, utilizamos, divulgamos y salvaguardamos su información personal. Al utilizar la plataforma SitterHub, usted acepta las prácticas descritas en esta política.<br>**1. Información que recopilamos:**<br>- **Información del usuario:** Cuando se registra en SitterHub, recopilamos información personal como su nombre, dirección de correo electrónico y detalles de contacto para crear y administrar su cuenta.<br>- **Información de pago:** Para facilitar las transacciones, recopilamos detalles de pago, incluida la información de la tarjeta de crédito, que se procesa de forma segura a través de nuestra pasarela de pago.<br>- **Información de perfil:** Los usuarios pueden proporcionar información adicional, como fotografías. , preferencias e instrucciones especiales, para personalizar sus perfiles y mejorar la experiencia de cuidado.<br>- **Datos de uso:** Recopilamos datos sobre cómo interactúa con nuestra plataforma, incluida la actividad de navegación, consultas de búsqueda y preferencias, para mejorar nuestros servicios.<br>**2. Cómo usamos su información:**<br>- **Provisión de servicios:** Usamos su información para conectarlo con niñeras y cuidadores de mascotas adecuados, procesar reservas y facilitar la comunicación entre usuarios.<br>- **Mejorar al usuario Experiencia:** Los datos recopilados se utilizan para mejorar nuestra plataforma, personalizar las recomendaciones y optimizar la experiencia del usuario en función de las preferencias y los comentarios.<br>- **Seguridad y prevención de fraude:** Empleamos su información para garantizar la seguridad de nuestra plataforma. , detectar y prevenir actividades fraudulentas y proteger los derechos y la seguridad de los usuarios.<br>- **Comunicación:** Usamos su información de contacto para enviar actualizaciones importantes, notificaciones y responder a consultas. Los usuarios pueden administrar las preferencias de comunicación en la configuración de su cuenta.<br>**3. Cómo compartimos su información:**<br>- **Comunicación con la niñera:** La información de su perfil, incluidas las preferencias e instrucciones especiales, se comparte con niñeras o cuidadores de mascotas seleccionados para garantizar una atención personalizada.<br>- **Tercero- Proveedores de servicios externos:** Podemos compartir información con proveedores de servicios externos confiables, como procesadores de pagos y proveedores de servicios de TI, para respaldar la funcionalidad de nuestra plataforma.<br>- **Cumplimiento legal:** Podemos divulgar su información en responder a solicitudes legales, hacer cumplir nuestros términos y políticas, o proteger los derechos, la propiedad y la seguridad de SitterHub, sus usuarios y otros.<br>**4. Sus opciones y controles:**<br>- **Administración de perfiles:** Los usuarios pueden acceder y actualizar la información de su perfil, sus preferencias de comunicación y la configuración de su cuenta en cualquier momento.<br>- **Optar por no participar:** Usted Puede optar por no recibir ciertas comunicaciones ajustando sus preferencias en la aplicación o contactándonos directamente.<br>**5. Medidas de seguridad:**<br>Empleamos medidas de seguridad estándar de la industria para proteger su información contra el acceso no autorizado, la divulgación, la alteración y la destrucción. Sin embargo, ningún método de transmisión a través de Internet o almacenamiento electrónico es completamente seguro y no se puede garantizar una seguridad absoluta.<br>**6. Privacidad de los niños:**<br>SitterHub no está dirigido a niños menores de 13 años. No recopilamos información personal de niños de forma intencionada. Si se da cuenta de que un niño nos ha proporcionado información personal, comuníquese con nosotros y tomaremos medidas para eliminar la información de inmediato.<br>**7. Cambios a la Política de Privacidad:**<br>SitterHub se reserva el derecho de actualizar esta Política de Privacidad periódicamente. Los usuarios serán notificados de cualquier cambio significativo por correo electrónico o mediante la aplicación. El uso continuado de la plataforma después de dichas modificaciones constituye la aceptación de la política actualizada.<br>**8. Contáctenos:**<br>Si tiene alguna pregunta, inquietud o solicitud con respecto a esta Política de privacidad, contáctenos en [support@sitterhub.com](mailto:support@sitterhub.com).<br>*Su privacidad nos importa. Gracias por confiar en SitterHub.*<\\/p>\"},\"ar\":{\"content\":\"<p>في SitterHub، نتفهم أهمية خصوصيتك ونلتزم بحمايتها. توضح سياسة الخصوصية هذه كيفية جمع معلوماتك الشخصية واستخدامها والكشف عنها وحمايتها. باستخدام منصة SitterHub، فإنك توافق على الممارسات الموضحة في هذه السياسة.<br>**1. المعلومات التي نجمعها:**<br>- **معلومات المستخدم:** عندما تقوم بالتسجيل في SitterHub، نقوم بجمع معلومات شخصية مثل اسمك وعنوان بريدك الإلكتروني وتفاصيل الاتصال لإنشاء حسابك وإدارته.<br>- **معلومات الدفع:** لتسهيل المعاملات، نقوم بجمع تفاصيل الدفع، بما في ذلك معلومات بطاقة الائتمان، والتي تتم معالجتها بشكل آمن من خلال بوابة الدفع الخاصة بنا.<br>- **معلومات الملف الشخصي:** يمكن للمستخدمين تقديم معلومات إضافية، مثل الصور والتفضيلات والتعليمات الخاصة لتخصيص ملفاتهم الشخصية وتعزيز تجربة تقديم الرعاية.<br>- **بيانات الاستخدام:** نقوم بجمع بيانات حول كيفية تفاعلك مع نظامنا الأساسي، بما في ذلك نشاط التصفح واستعلامات البحث والتفضيلات لتحسين خدماتنا.<br>**2. كيف نستخدم معلوماتك:**<br>- **تقديم الخدمات:** نحن نستخدم معلوماتك لتوصيلك بجليسات أطفال وجليسات حيوانات أليفة مناسبة، ومعالجة الحجوزات، وتسهيل التواصل بين المستخدمين.<br>- **تحسين المستخدم الخبرة:** يتم استخدام البيانات المجمعة لتحسين نظامنا الأساسي، وتخصيص التوصيات، وتحسين تجربة المستخدم بناءً على التفضيلات والتعليقات.<br>- **الأمان ومنع الاحتيال:** نحن نستخدم معلوماتك لضمان أمان نظامنا الأساسي. والكشف والوقاية الأنشطة الاحتيالية، وحماية حقوق المستخدمين وسلامتهم.<br>- **الاتصال:** نستخدم معلومات الاتصال الخاصة بك لإرسال التحديثات والإشعارات المهمة والرد على الاستفسارات. يمكن للمستخدمين إدارة تفضيلات الاتصال في إعدادات حساباتهم.<br>**3. كيف نشارك معلوماتك:**<br>- **التواصل مع جليسة الأطفال:** تتم مشاركة معلومات ملفك الشخصي، بما في ذلك التفضيلات والتعليمات الخاصة، مع جليسات أطفال أو جليسات حيوانات أليفة مختارة لضمان الحصول على رعاية شخصية.<br>- **ثالثًا- مقدمو خدمات الطرف:** قد نشارك المعلومات مع مقدمي خدمات خارجيين موثوقين، مثل معالجي الدفع ومقدمي خدمات تكنولوجيا المعلومات، لدعم وظائف النظام الأساسي لدينا.<br>- **الامتثال القانوني:** قد نكشف عن معلوماتك في الاستجابة للطلبات القانونية، وإنفاذ لدينا الشروط والسياسات، أو حماية الحقوق والملكية والسلامة الخاصة بـ SitterHub ومستخدميها وغيرهم.<br>**4. اختياراتك وعناصر التحكم:**<br>- **إدارة الملفات الشخصية:** يمكن للمستخدمين الوصول إلى معلومات ملفاتهم الشخصية وتفضيلات الاتصال وإعدادات الحساب وتحديثها في أي وقت.<br>- **إلغاء الاشتراك:** أنت يمكنك إلغاء الاشتراك في اتصالات معينة عن طريق تعديل تفضيلاتك في التطبيق أو الاتصال بنا مباشرةً.<br>**5. الإجراءات الأمنية:**<br>نحن نستخدم إجراءات أمنية متوافقة مع معايير الصناعة لحماية معلوماتك من الوصول غير المصرح به والكشف والتغيير والتدمير. ومع ذلك، لا توجد طريقة آمنة تمامًا للنقل عبر الإنترنت أو التخزين الإلكتروني، ولا يمكن ضمان الأمان المطلق.<br>**6. خصوصية الأطفال:**<br>SitterHub غير موجه للأطفال دون سن 13 عامًا. نحن لا نجمع معلومات شخصية من الأطفال عن قصد. إذا علمت أن أحد الأطفال قد زودنا بمعلومات شخصية، فيرجى الاتصال بنا وسنتخذ خطوات لإزالة المعلومات على الفور.<br>**7. التغييرات في سياسة الخصوصية:**<br>تحتفظ SitterHub بالحق في تحديث سياسة الخصوصية هذه بشكل دوري. سيتم إخطار المستخدمين بأي تغييرات مهمة عبر البريد الإلكتروني أو من خلال التطبيق. ويشكل الاستمرار في استخدام النظام الأساسي بعد هذه التعديلات قبولًا للسياسة المحدثة.<br>**8. اتصل بنا:**<br>إذا كانت لديك أية أسئلة أو استفسارات أو طلبات بخصوص سياسة الخصوصية هذه، فيرجى الاتصال بنا على [support@sitterhub.com](mailto:support@sitterhub.com).<br>*خصوصيتك يهمنا. شكرًا لك على ثقتك في SitterHub.*<\\/p>\"},\"fr\":{\"content\":\"<p>Chez SitterHub, nous comprenons l\'importance de votre vie privée et nous nous engageons à la protéger. Cette politique de confidentialité décrit la manière dont nous collectons, utilisons, divulguons et protégeons vos informations personnelles. En utilisant la plateforme SitterHub, vous consentez aux pratiques décrites dans cette politique.<br>**1. Informations que nous collectons :**<br>- **Informations utilisateur :** Lorsque vous vous inscrivez à SitterHub, nous collectons des informations personnelles telles que votre nom, votre adresse e-mail et vos coordonnées pour créer et gérer votre compte.<br>- **Informations de paiement :** Pour faciliter les transactions, nous collectons les informations de paiement, y compris les informations de carte de crédit, qui sont traitées en toute sécurité via notre passerelle de paiement.<br>- **Informations de profil :** Les utilisateurs peuvent fournir des informations supplémentaires, telles que des photos. , préférences et instructions spéciales, pour personnaliser leurs profils et améliorer la prestation de soins expérience.<br>- **Données d\'utilisation :** Nous collectons des données sur la façon dont vous interagissez avec notre plate-forme, y compris votre activité de navigation, les requêtes de recherche et vos préférences, pour améliorer nos services.<br>**2. Comment nous utilisons vos informations :**<br>- **Fourniture de services :** Nous utilisons vos informations pour vous mettre en contact avec des baby-sitters et des gardiens d\'animaux appropriés, traiter les réservations et faciliter la communication entre les utilisateurs.<br>- **Amélioration de l\'utilisateur. Expérience :** Les données collectées sont utilisées pour améliorer notre plateforme, adapter les recommandations et optimiser l\'expérience utilisateur en fonction des préférences et des commentaires.<br>- **Sécurité et prévention de la fraude :** Nous utilisons vos informations pour garantir la sécurité de notre plateforme. , détecter et prévenir les activités frauduleuses, et protéger les droits et la sécurité des utilisateurs.<br>- **Communication :** Nous utilisons vos informations de contact pour envoyer des mises à jour importantes, des notifications et répondre aux demandes de renseignements. Les utilisateurs peuvent gérer leurs préférences de communication dans les paramètres de leur compte.<br>**3. Comment nous partageons vos informations :**<br>- **Communication avec les gardiennes :** Les informations de votre profil, y compris vos préférences et instructions spéciales, sont partagées avec des baby-sitters ou des gardiens d\'animaux sélectionnés pour garantir des soins personnalisés.<br>- **Troisième- Fournisseurs de services tiers :** Nous pouvons partager des informations avec des prestataires de services tiers de confiance, tels que des processeurs de paiement et des fournisseurs de services informatiques, pour prendre en charge les fonctionnalités de notre plateforme.<br>- **Conformité juridique :** Nous pouvons divulguer vos informations dans réponse aux demandes légales, appliquer nos conditions et politiques, ou protéger les droits, la propriété et la sécurité de SitterHub, de ses utilisateurs et d\'autres personnes.<br>**4. Vos choix et contrôles :**<br>- **Gestion du profil :** Les utilisateurs peuvent accéder et mettre à jour leurs informations de profil, leurs préférences de communication et les paramètres de leur compte à tout moment.<br>- **Désinscription :** Vous Vous pouvez vous désinscrire de certaines communications en ajustant vos préférences dans l\'application ou en nous contactant directement.<br>**5. Mesures de sécurité :**<br>Nous utilisons des mesures de sécurité conformes aux normes de l\'industrie pour protéger vos informations contre tout accès, divulgation, altération et destruction non autorisés. Cependant, aucune méthode de transmission sur Internet ou de stockage électronique n\'est entièrement sécurisée et une sécurité absolue ne peut être garantie.<br>**6. Confidentialité des enfants :**<br>SitterHub ne s\'adresse pas aux enfants de moins de 13 ans. Nous ne collectons pas sciemment d\'informations personnelles auprès des enfants. Si vous réalisez qu\'un enfant nous a fourni des informations personnelles, veuillez nous contacter et nous prendrons des mesures pour supprimer ces informations dans les plus brefs délais.<br>**7. Modifications de la politique de confidentialité :**<br>SitterHub se réserve le droit de mettre à jour cette politique de confidentialité périodiquement. Les utilisateurs seront informés de tout changement important par e-mail ou via l\'application. L\'utilisation continue de la plateforme après de telles modifications constitue l\'acceptation de la politique mise à jour.<br>**8. Contactez-nous :**<br>Si vous avez des questions, des préoccupations ou des demandes concernant cette politique de confidentialité, veuillez nous contacter à [support@sitterhub.com](mailto:support@sitterhub.com).<br>*Votre confidentialité compte pour nous. Merci de faire confiance à SitterHub.*<\\/p>\"},\"hi\":{\"content\":\"<p>सिटरहब में, हम आपकी गोपनीयता के महत्व को समझते हैं और इसकी सुरक्षा के लिए प्रतिबद्ध हैं। यह गोपनीयता नीति बताती है कि हम आपकी व्यक्तिगत जानकारी कैसे एकत्रित, उपयोग, प्रकटीकरण और सुरक्षा करते हैं। सिटरहब प्लेटफ़ॉर्म का उपयोग करके, आप इस नीति में वर्णित प्रथाओं से सहमति देते हैं।<br>**1. हमारे द्वारा एकत्रित की जाने वाली जानकारी:**<br>- **उपयोगकर्ता जानकारी:** जब आप सिटरहब के लिए साइन अप करते हैं, तो हम आपका खाता बनाने और प्रबंधित करने के लिए आपका नाम, ईमेल पता और संपर्क विवरण जैसी व्यक्तिगत जानकारी एकत्र करते हैं।<br>- **भुगतान जानकारी:** लेनदेन को सुविधाजनक बनाने के लिए, हम क्रेडिट कार्ड की जानकारी सहित भुगतान विवरण एकत्र करते हैं, जिसे हमारे भुगतान गेटवे के माध्यम से सुरक्षित रूप से संसाधित किया जाता है।<br>- **प्रोफ़ाइल जानकारी:** उपयोगकर्ता अतिरिक्त जानकारी प्रदान कर सकते हैं, जैसे फ़ोटो , प्राथमिकताएँ, और विशेष निर्देश, उनकी प्रोफाइल को वैयक्तिकृत करने और देखभाल करने वाले अनुभव को बढ़ाने के लिए। br>**2. हम आपकी जानकारी का उपयोग कैसे करते हैं:**<br>- **सेवाएं प्रदान करना:** हम आपकी जानकारी का उपयोग आपको उपयुक्त बच्चों की देखभाल करने वालों और पालतू जानवरों की देखभाल करने वालों से जोड़ने, बुकिंग की प्रक्रिया करने और उपयोगकर्ताओं के बीच संचार की सुविधा प्रदान करने के लिए करते हैं।<br>- **उपयोगकर्ता को बेहतर बनाना अनुभव:** एकत्रित डेटा का उपयोग हमारे प्लेटफ़ॉर्म को बेहतर बनाने, अनुशंसाओं को तैयार करने और प्राथमिकताओं और फीडबैक के आधार पर उपयोगकर्ता अनुभव को अनुकूलित करने के लिए किया जाता है।<br>- **सुरक्षा और धोखाधड़ी की रोकथाम:** हम अपने प्लेटफ़ॉर्म की सुरक्षा सुनिश्चित करने के लिए आपकी जानकारी का उपयोग करते हैं , धोखाधड़ी वाली गतिविधियों का पता लगाएं और उन्हें रोकें, और उपयोगकर्ताओं के अधिकारों और सुरक्षा की रक्षा करें।<br>- **संचार:** हम महत्वपूर्ण अपडेट, सूचनाएं भेजने और पूछताछ का जवाब देने के लिए आपकी संपर्क जानकारी का उपयोग करते हैं। उपयोगकर्ता अपनी खाता सेटिंग में संचार प्राथमिकताएं प्रबंधित कर सकते हैं।<br>**3. हम आपकी जानकारी कैसे साझा करते हैं:**<br>- **पालक संचार:** आपकी प्रोफ़ाइल जानकारी, प्राथमिकताओं और विशेष निर्देशों सहित, व्यक्तिगत देखभाल सुनिश्चित करने के लिए चयनित बेबीसिटर्स या पालतू जानवरों की देखभाल करने वालों के साथ साझा की जाती है।<br>- **तीसरा- पार्टी सेवा प्रदाता:** हम अपने प्लेटफ़ॉर्म की कार्यक्षमता का समर्थन करने के लिए विश्वसनीय तृतीय-पक्ष सेवा प्रदाताओं, जैसे भुगतान प्रोसेसर और आईटी सेवा प्रदाताओं के साथ जानकारी साझा कर सकते हैं।<br>- **कानूनी अनुपालन:** हम कर सकते हैं कानूनी अनुरोधों के जवाब में अपनी जानकारी का खुलासा करें, हमारी शर्तों और नीतियों को लागू करें, या सिटरहब, उसके उपयोगकर्ताओं और अन्य लोगों के अधिकारों, संपत्ति और सुरक्षा की रक्षा करें।<br>**4. आपकी पसंद और नियंत्रण:**<br>- **प्रोफ़ाइल प्रबंधन:** उपयोगकर्ता किसी भी समय अपनी प्रोफ़ाइल जानकारी, संचार प्राथमिकताओं और खाता सेटिंग्स तक पहुंच सकते हैं और अपडेट कर सकते हैं।<br>- **ऑप्ट-आउट:** आप ऐप में अपनी प्राथमिकताओं को समायोजित करके या सीधे हमसे संपर्क करके कुछ संचार से ऑप्ट-आउट कर सकते हैं।<br>**5. सुरक्षा उपाय:**<br>हम आपकी जानकारी को अनधिकृत पहुंच, प्रकटीकरण, परिवर्तन और विनाश से बचाने के लिए उद्योग-मानक सुरक्षा उपाय अपनाते हैं। हालाँकि, इंटरनेट या इलेक्ट्रॉनिक स्टोरेज पर ट्रांसमिशन का कोई भी तरीका पूरी तरह से सुरक्षित नहीं है, और पूर्ण सुरक्षा की गारंटी नहीं दी जा सकती है।<br>**6. बच्चों की गोपनीयता:**<br>सिटरहब 13 वर्ष से कम उम्र के बच्चों के लिए नहीं है। हम जानबूझकर बच्चों से व्यक्तिगत जानकारी एकत्र नहीं करते हैं। यदि आपको पता चलता है कि किसी बच्चे ने हमें व्यक्तिगत जानकारी प्रदान की है, तो कृपया हमसे संपर्क करें, और हम जानकारी को तुरंत हटाने के लिए कदम उठाएंगे।<br>**7. गोपनीयता नीति में परिवर्तन:**<br>सिटरहब इस गोपनीयता नीति को समय-समय पर अद्यतन करने का अधिकार सुरक्षित रखता है। उपयोगकर्ताओं को किसी भी महत्वपूर्ण परिवर्तन के बारे में ईमेल या ऐप के माध्यम से सूचित किया जाएगा। ऐसे संशोधनों के बाद प्लेटफ़ॉर्म का निरंतर उपयोग अद्यतन नीति की स्वीकृति माना जाता है।<br>**8. हमसे संपर्क करें:**<br>यदि इस गोपनीयता नीति के संबंध में आपके कोई प्रश्न, चिंताएं या अनुरोध हैं, तो कृपया हमसे [support@sitterhub.com](mailto:support@sitterhub.com) पर संपर्क करें।<br>*आपकी गोपनीयता हमारे लिए मायने रखता है. सिटरहब पर भरोसा करने के लिए धन्यवाद।*<\\/p>\"}}}', 1, 1, '2023-06-19 23:02:20', '2024-02-05 04:38:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(191) NOT NULL,
  `lastname` varchar(191) DEFAULT NULL,
  `username` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `mobile_code` varchar(191) DEFAULT NULL,
  `mobile` varchar(191) DEFAULT NULL,
  `full_mobile` varchar(191) DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `refferal_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 == Banned',
  `address` text DEFAULT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 == Verifiend, 0 == Not verifiend',
  `sms_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 == Verifiend, 0 == Not verifiend',
  `kyc_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Default, 1: Approved, 2: Pending, 3:Rejected',
  `ver_code` int(11) DEFAULT NULL,
  `ver_code_send_at` timestamp NULL DEFAULT NULL,
  `two_factor_verified` tinyint(1) NOT NULL DEFAULT 0,
  `two_factor_status` tinyint(1) NOT NULL DEFAULT 0,
  `two_factor_secret` varchar(191) DEFAULT NULL,
  `device_id` varchar(191) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_authorizations`
--

CREATE TABLE `user_authorizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `code` int(11) NOT NULL,
  `token` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_kyc_data`
--

CREATE TABLE `user_kyc_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `reject_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_login_logs`
--

CREATE TABLE `user_login_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `mac` varchar(17) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `browser` varchar(30) DEFAULT NULL,
  `os` varchar(30) DEFAULT NULL,
  `timezone` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_mail_logs`
--

CREATE TABLE `user_mail_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `method` varchar(191) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_password_resets`
--

CREATE TABLE `user_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `code` bigint(20) UNSIGNED DEFAULT NULL,
  `token` text NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `zip_code` varchar(191) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `information` text DEFAULT NULL,
  `reject_reason` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_requests`
--

CREATE TABLE `user_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nanny_id` bigint(20) UNSIGNED NOT NULL,
  `add_baby_pet_id` bigint(20) UNSIGNED NOT NULL,
  `started_date` date NOT NULL,
  `end_date` date NOT NULL,
  `service_type` int(11) NOT NULL COMMENT '1:baby setter, 2:pet setter',
  `service_day` int(11) NOT NULL,
  `daily_working_hour` int(11) NOT NULL,
  `total_hour` int(11) NOT NULL,
  `nanny_charge` int(11) NOT NULL,
  `started_time` time NOT NULL,
  `total` int(11) NOT NULL,
  `service_charge` decimal(8,2) DEFAULT NULL,
  `payable` decimal(8,2) NOT NULL,
  `currency_code` varchar(191) NOT NULL,
  `trx` varchar(191) NOT NULL,
  `address` varchar(191) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0:Pending,1:Accept,2:Reject,4:task complete,5:payment,6:review',
  `seen_status` enum('seen','unseen') NOT NULL DEFAULT 'unseen',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_support_chats`
--

CREATE TABLE `user_support_chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_support_ticket_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender` bigint(20) UNSIGNED NOT NULL,
  `sender_type` varchar(191) NOT NULL,
  `receiver` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_type` varchar(191) DEFAULT NULL,
  `message` text NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_support_tickets`
--

CREATE TABLE `user_support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nanny_id` bigint(20) UNSIGNED DEFAULT NULL,
  `token` varchar(120) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `desc` text DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Default, 1: Solved, 2: Active, 3: Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_support_ticket_attachments`
--

CREATE TABLE `user_support_ticket_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_support_ticket_id` bigint(20) UNSIGNED NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `attachment_info` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_wallets`
--

CREATE TABLE `user_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `currency_id` bigint(20) UNSIGNED NOT NULL,
  `balance` decimal(28,8) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_baby_pats`
--
ALTER TABLE `add_baby_pats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `add_baby_pats_user_id_foreign` (`user_id`);

--
-- Indexes for table `add_coins`
--
ALTER TABLE `add_coins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_image_unique` (`image`),
  ADD KEY `admins_username_index` (`username`),
  ADD KEY `admins_email_index` (`email`),
  ADD KEY `admins_phone_index` (`phone`),
  ADD KEY `admins_admin_role_id_foreign` (`admin_role_id`);

--
-- Indexes for table `admin_has_roles`
--
ALTER TABLE `admin_has_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_has_roles_admin_id_foreign` (`admin_id`),
  ADD KEY `admin_has_roles_admin_role_id_foreign` (`admin_role_id`),
  ADD KEY `admin_has_roles_last_edit_by_foreign` (`last_edit_by`);

--
-- Indexes for table `admin_login_logs`
--
ALTER TABLE `admin_login_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_login_logs_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_notifications_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_password_resets_email_index` (`email`);

--
-- Indexes for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_roles_name_unique` (`name`),
  ADD KEY `admin_roles_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `admin_role_has_permissions`
--
ALTER TABLE `admin_role_has_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_role_has_permissions_admin_role_permission_id_foreign` (`admin_role_permission_id`),
  ADD KEY `admin_role_has_permissions_last_edit_by_foreign` (`last_edit_by`);

--
-- Indexes for table `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_role_permissions_name_unique` (`name`),
  ADD UNIQUE KEY `admin_role_permissions_slug_unique` (`slug`),
  ADD KEY `admin_role_permissions_admin_role_id_foreign` (`admin_role_id`),
  ADD KEY `admin_role_permissions_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `app_onboard_screens`
--
ALTER TABLE `app_onboard_screens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app_onboard_screens_image_unique` (`image`),
  ADD KEY `app_onboard_screens_last_edit_by_foreign` (`last_edit_by`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basic_settings`
--
ALTER TABLE `basic_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blogs_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `buy_coins`
--
ALTER TABLE `buy_coins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buy_coins_user_id_foreign` (`user_id`);

--
-- Indexes for table `coinbase_webhook_calls`
--
ALTER TABLE `coinbase_webhook_calls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currencies_flag_unique` (`flag`),
  ADD KEY `currencies_admin_id_foreign` (`admin_id`),
  ADD KEY `currencies_country_index` (`country`),
  ADD KEY `currencies_name_index` (`name`),
  ADD KEY `currencies_code_index` (`code`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `extensions_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_name_unique` (`name`),
  ADD UNIQUE KEY `languages_code_unique` (`code`),
  ADD KEY `languages_last_edit_by_foreign` (`last_edit_by`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nannies`
--
ALTER TABLE `nannies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nannies_username_unique` (`username`),
  ADD UNIQUE KEY `nannies_email_unique` (`email`),
  ADD UNIQUE KEY `nannies_full_mobile_unique` (`full_mobile`);

--
-- Indexes for table `nanny_authorizations`
--
ALTER TABLE `nanny_authorizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nanny_kyc_data`
--
ALTER TABLE `nanny_kyc_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nanny_kyc_data_nanny_id_foreign` (`nanny_id`);

--
-- Indexes for table `nanny_login_logs`
--
ALTER TABLE `nanny_login_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nanny_login_logs_nanny_id_foreign` (`nanny_id`);

--
-- Indexes for table `nanny_mail_logs`
--
ALTER TABLE `nanny_mail_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nanny_mail_logs_nanny_id_foreign` (`nanny_id`);

--
-- Indexes for table `nanny_notifications`
--
ALTER TABLE `nanny_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nanny_notifications_nanny_id_foreign` (`nanny_id`);

--
-- Indexes for table `nanny_password_resets`
--
ALTER TABLE `nanny_password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nanny_password_resets_token_unique` (`token`),
  ADD UNIQUE KEY `nanny_password_resets_code_unique` (`code`),
  ADD KEY `nanny_password_resets_nanny_id_foreign` (`nanny_id`);

--
-- Indexes for table `nanny_professions`
--
ALTER TABLE `nanny_professions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nanny_professions_nanny_id_foreign` (`nanny_id`);

--
-- Indexes for table `nanny_wallets`
--
ALTER TABLE `nanny_wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nanny_wallets_currency_id_foreign` (`currency_id`),
  ADD KEY `nanny_wallets_nanny_id_foreign` (`nanny_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_gateways_code_unique` (`code`),
  ADD KEY `payment_gateways_last_edit_by_foreign` (`last_edit_by`);

--
-- Indexes for table `payment_gateway_currencies`
--
ALTER TABLE `payment_gateway_currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_gateway_currencies_alias_unique` (`alias`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `push_notification_records`
--
ALTER TABLE `push_notification_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `push_notification_records_send_by_foreign` (`send_by`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_nanny_id_foreign` (`nanny_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_user_request_id_foreign` (`user_request_id`);

--
-- Indexes for table `script`
--
ALTER TABLE `script`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_areas`
--
ALTER TABLE `service_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setup_kycs`
--
ALTER TABLE `setup_kycs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setup_kycs_slug_unique` (`slug`);

--
-- Indexes for table `setup_pages`
--
ALTER TABLE `setup_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setup_pages_slug_unique` (`slug`),
  ADD KEY `setup_pages_last_edit_by_foreign` (`last_edit_by`);

--
-- Indexes for table `setup_seos`
--
ALTER TABLE `setup_seos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `setup_seos_last_edit_by_foreign` (`last_edit_by`);

--
-- Indexes for table `site_sections`
--
ALTER TABLE `site_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribes`
--
ALTER TABLE `subscribes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_maintenances`
--
ALTER TABLE `system_maintenances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `system_maintenances_slug_unique` (`slug`);

--
-- Indexes for table `temporary_datas`
--
ALTER TABLE `temporary_datas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_admin_id_foreign` (`admin_id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_nanny_id_foreign` (`nanny_id`),
  ADD KEY `transactions_user_wallet_id_foreign` (`user_wallet_id`),
  ADD KEY `transactions_payment_gateway_currency_id_foreign` (`payment_gateway_currency_id`),
  ADD KEY `transactions_nanny_wallet_id_foreign` (`nanny_wallet_id`);

--
-- Indexes for table `transaction_charges`
--
ALTER TABLE `transaction_charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_charges_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `transaction_devices`
--
ALTER TABLE `transaction_devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_devices_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `transaction_settings`
--
ALTER TABLE `transaction_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_settings_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `useful_links`
--
ALTER TABLE `useful_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_full_mobile_unique` (`full_mobile`),
  ADD KEY `users_mobile_index` (`mobile`);

--
-- Indexes for table `user_authorizations`
--
ALTER TABLE `user_authorizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_kyc_data`
--
ALTER TABLE `user_kyc_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_kyc_data_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_login_logs`
--
ALTER TABLE `user_login_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_login_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_mail_logs`
--
ALTER TABLE `user_mail_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_mail_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_password_resets`
--
ALTER TABLE `user_password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_password_resets_code_unique` (`code`),
  ADD KEY `user_password_resets_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_requests`
--
ALTER TABLE `user_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_requests_user_id_foreign` (`user_id`),
  ADD KEY `user_requests_nanny_id_foreign` (`nanny_id`),
  ADD KEY `user_requests_add_baby_pet_id_foreign` (`add_baby_pet_id`);

--
-- Indexes for table `user_support_chats`
--
ALTER TABLE `user_support_chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_support_chats_user_support_ticket_id_foreign` (`user_support_ticket_id`);

--
-- Indexes for table `user_support_tickets`
--
ALTER TABLE `user_support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_support_tickets_token_unique` (`token`),
  ADD KEY `user_support_tickets_user_id_foreign` (`user_id`),
  ADD KEY `user_support_tickets_nanny_id_foreign` (`nanny_id`);

--
-- Indexes for table `user_support_ticket_attachments`
--
ALTER TABLE `user_support_ticket_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_support_ticket_attachments_user_support_ticket_id_foreign` (`user_support_ticket_id`);

--
-- Indexes for table `user_wallets`
--
ALTER TABLE `user_wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_wallets_currency_id_foreign` (`currency_id`),
  ADD KEY `user_wallets_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_baby_pats`
--
ALTER TABLE `add_baby_pats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `add_coins`
--
ALTER TABLE `add_coins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_has_roles`
--
ALTER TABLE `admin_has_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_login_logs`
--
ALTER TABLE `admin_login_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admin_role_has_permissions`
--
ALTER TABLE `admin_role_has_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_onboard_screens`
--
ALTER TABLE `app_onboard_screens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `basic_settings`
--
ALTER TABLE `basic_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `buy_coins`
--
ALTER TABLE `buy_coins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coinbase_webhook_calls`
--
ALTER TABLE `coinbase_webhook_calls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `nannies`
--
ALTER TABLE `nannies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nanny_authorizations`
--
ALTER TABLE `nanny_authorizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nanny_kyc_data`
--
ALTER TABLE `nanny_kyc_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nanny_login_logs`
--
ALTER TABLE `nanny_login_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nanny_mail_logs`
--
ALTER TABLE `nanny_mail_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nanny_notifications`
--
ALTER TABLE `nanny_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nanny_password_resets`
--
ALTER TABLE `nanny_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nanny_professions`
--
ALTER TABLE `nanny_professions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nanny_wallets`
--
ALTER TABLE `nanny_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5001;

--
-- AUTO_INCREMENT for table `payment_gateway_currencies`
--
ALTER TABLE `payment_gateway_currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `push_notification_records`
--
ALTER TABLE `push_notification_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `script`
--
ALTER TABLE `script`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_areas`
--
ALTER TABLE `service_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setup_kycs`
--
ALTER TABLE `setup_kycs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `setup_pages`
--
ALTER TABLE `setup_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `setup_seos`
--
ALTER TABLE `setup_seos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `site_sections`
--
ALTER TABLE `site_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `subscribes`
--
ALTER TABLE `subscribes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_maintenances`
--
ALTER TABLE `system_maintenances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `temporary_datas`
--
ALTER TABLE `temporary_datas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_charges`
--
ALTER TABLE `transaction_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_devices`
--
ALTER TABLE `transaction_devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_settings`
--
ALTER TABLE `transaction_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `useful_links`
--
ALTER TABLE `useful_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_authorizations`
--
ALTER TABLE `user_authorizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_kyc_data`
--
ALTER TABLE `user_kyc_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_login_logs`
--
ALTER TABLE `user_login_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_mail_logs`
--
ALTER TABLE `user_mail_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_password_resets`
--
ALTER TABLE `user_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_requests`
--
ALTER TABLE `user_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_support_chats`
--
ALTER TABLE `user_support_chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_support_tickets`
--
ALTER TABLE `user_support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_support_ticket_attachments`
--
ALTER TABLE `user_support_ticket_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_wallets`
--
ALTER TABLE `user_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_baby_pats`
--
ALTER TABLE `add_baby_pats`
  ADD CONSTRAINT `add_baby_pats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_admin_role_id_foreign` FOREIGN KEY (`admin_role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `admin_has_roles`
--
ALTER TABLE `admin_has_roles`
  ADD CONSTRAINT `admin_has_roles_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_has_roles_admin_role_id_foreign` FOREIGN KEY (`admin_role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_has_roles_last_edit_by_foreign` FOREIGN KEY (`last_edit_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `admin_login_logs`
--
ALTER TABLE `admin_login_logs`
  ADD CONSTRAINT `admin_login_logs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD CONSTRAINT `admin_notifications_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD CONSTRAINT `admin_roles_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `admin_role_has_permissions`
--
ALTER TABLE `admin_role_has_permissions`
  ADD CONSTRAINT `admin_role_has_permissions_admin_role_permission_id_foreign` FOREIGN KEY (`admin_role_permission_id`) REFERENCES `admin_role_permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_role_has_permissions_last_edit_by_foreign` FOREIGN KEY (`last_edit_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  ADD CONSTRAINT `admin_role_permissions_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_role_permissions_admin_role_id_foreign` FOREIGN KEY (`admin_role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `app_onboard_screens`
--
ALTER TABLE `app_onboard_screens`
  ADD CONSTRAINT `app_onboard_screens_last_edit_by_foreign` FOREIGN KEY (`last_edit_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `buy_coins`
--
ALTER TABLE `buy_coins`
  ADD CONSTRAINT `buy_coins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `currencies`
--
ALTER TABLE `currencies`
  ADD CONSTRAINT `currencies_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `languages`
--
ALTER TABLE `languages`
  ADD CONSTRAINT `languages_last_edit_by_foreign` FOREIGN KEY (`last_edit_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nanny_kyc_data`
--
ALTER TABLE `nanny_kyc_data`
  ADD CONSTRAINT `nanny_kyc_data_nanny_id_foreign` FOREIGN KEY (`nanny_id`) REFERENCES `nannies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nanny_login_logs`
--
ALTER TABLE `nanny_login_logs`
  ADD CONSTRAINT `nanny_login_logs_nanny_id_foreign` FOREIGN KEY (`nanny_id`) REFERENCES `nannies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nanny_mail_logs`
--
ALTER TABLE `nanny_mail_logs`
  ADD CONSTRAINT `nanny_mail_logs_nanny_id_foreign` FOREIGN KEY (`nanny_id`) REFERENCES `nannies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nanny_notifications`
--
ALTER TABLE `nanny_notifications`
  ADD CONSTRAINT `nanny_notifications_nanny_id_foreign` FOREIGN KEY (`nanny_id`) REFERENCES `nannies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nanny_password_resets`
--
ALTER TABLE `nanny_password_resets`
  ADD CONSTRAINT `nanny_password_resets_nanny_id_foreign` FOREIGN KEY (`nanny_id`) REFERENCES `nannies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nanny_professions`
--
ALTER TABLE `nanny_professions`
  ADD CONSTRAINT `nanny_professions_nanny_id_foreign` FOREIGN KEY (`nanny_id`) REFERENCES `nannies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nanny_wallets`
--
ALTER TABLE `nanny_wallets`
  ADD CONSTRAINT `nanny_wallets_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nanny_wallets_nanny_id_foreign` FOREIGN KEY (`nanny_id`) REFERENCES `nannies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD CONSTRAINT `payment_gateways_last_edit_by_foreign` FOREIGN KEY (`last_edit_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `push_notification_records`
--
ALTER TABLE `push_notification_records`
  ADD CONSTRAINT `push_notification_records_send_by_foreign` FOREIGN KEY (`send_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_nanny_id_foreign` FOREIGN KEY (`nanny_id`) REFERENCES `nannies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_request_id_foreign` FOREIGN KEY (`user_request_id`) REFERENCES `user_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `setup_pages`
--
ALTER TABLE `setup_pages`
  ADD CONSTRAINT `setup_pages_last_edit_by_foreign` FOREIGN KEY (`last_edit_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `setup_seos`
--
ALTER TABLE `setup_seos`
  ADD CONSTRAINT `setup_seos_last_edit_by_foreign` FOREIGN KEY (`last_edit_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_nanny_id_foreign` FOREIGN KEY (`nanny_id`) REFERENCES `nannies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_nanny_wallet_id_foreign` FOREIGN KEY (`nanny_wallet_id`) REFERENCES `nanny_wallets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_payment_gateway_currency_id_foreign` FOREIGN KEY (`payment_gateway_currency_id`) REFERENCES `payment_gateway_currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_user_wallet_id_foreign` FOREIGN KEY (`user_wallet_id`) REFERENCES `user_wallets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction_charges`
--
ALTER TABLE `transaction_charges`
  ADD CONSTRAINT `transaction_charges_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction_devices`
--
ALTER TABLE `transaction_devices`
  ADD CONSTRAINT `transaction_devices_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction_settings`
--
ALTER TABLE `transaction_settings`
  ADD CONSTRAINT `transaction_settings_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_kyc_data`
--
ALTER TABLE `user_kyc_data`
  ADD CONSTRAINT `user_kyc_data_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_login_logs`
--
ALTER TABLE `user_login_logs`
  ADD CONSTRAINT `user_login_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_mail_logs`
--
ALTER TABLE `user_mail_logs`
  ADD CONSTRAINT `user_mail_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `user_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_password_resets`
--
ALTER TABLE `user_password_resets`
  ADD CONSTRAINT `user_password_resets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_requests`
--
ALTER TABLE `user_requests`
  ADD CONSTRAINT `user_requests_add_baby_pet_id_foreign` FOREIGN KEY (`add_baby_pet_id`) REFERENCES `add_baby_pats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_requests_nanny_id_foreign` FOREIGN KEY (`nanny_id`) REFERENCES `nannies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_support_chats`
--
ALTER TABLE `user_support_chats`
  ADD CONSTRAINT `user_support_chats_user_support_ticket_id_foreign` FOREIGN KEY (`user_support_ticket_id`) REFERENCES `user_support_tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_support_tickets`
--
ALTER TABLE `user_support_tickets`
  ADD CONSTRAINT `user_support_tickets_nanny_id_foreign` FOREIGN KEY (`nanny_id`) REFERENCES `nannies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_support_tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_support_ticket_attachments`
--
ALTER TABLE `user_support_ticket_attachments`
  ADD CONSTRAINT `user_support_ticket_attachments_user_support_ticket_id_foreign` FOREIGN KEY (`user_support_ticket_id`) REFERENCES `user_support_tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_wallets`
--
ALTER TABLE `user_wallets`
  ADD CONSTRAINT `user_wallets_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
