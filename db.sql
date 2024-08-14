-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 13, 2024 at 03:49 PM
-- Server version: 8.0.35-0ubuntu0.23.04.1
-- PHP Version: 8.1.12-1ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `semibill`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` text COLLATE utf8mb4_unicode_ci,
  `date_auth` text COLLATE utf8mb4_unicode_ci,
  `type` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `avatar`, `phone_number`, `status`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `date_auth`, `type`) VALUES
(1, 'christian umanah', 'chris@gmail.com', NULL, NULL, '0909989988', NULL, '$2y$12$Qeq7ziXdOhLoR9D9aPBg6eD3MffDCMPb0RMyKzrwoXPJUhbBfx55G', 'T2bgKyb2VQczgQhJrYFR3VPlH3MUlEMUHKZ9e40CAqohnqnwBkehwej1BEIh', '2023-12-21 10:40:39', '2024-06-16 17:19:17', NULL, NULL, 0),
(5, 'Sir Joseph Ray ', 'sirjosephray@gmail.com', NULL, NULL, '08103625000', NULL, '$2y$12$mGr92wMP6HJpqUvKnaV0petkNnk78VYZUkdoLupLhh4xiV4ggKufq', 'b1I3lSJv3xST3AUatYELQZsvLM6NZQLre1E1mylVcS6snNgzRTOuO6XosnQi', '2024-06-17 07:17:46', '2024-08-12 17:44:34', NULL, NULL, 0),
(6, 'Miss Anita ', 'anitaali226@gmail.com', NULL, NULL, '09032074295', NULL, '$2y$12$pBJPeh0/sTS7JxdPudJibO.McWfjWFJYXpPIU5zpHXPr.35KxmZoy', 'wwbgB785sLTmRd5OkUsEJjgngG90ogr8agJ8HeOVlOhPPTQ94dZppu83SQ9K', '2024-06-17 09:46:10', '2024-06-17 09:46:10', NULL, NULL, 1),
(7, 'Onyedika Ukuru', 'kachicreate@gmail.com', NULL, NULL, '08111616585', NULL, '$2y$12$SORFtv2gYaMdIvM5SiajH.Q2.2r2TidDQvOt7Vdhg2pr.mTLXz4Wq', 'Rsv1b8wiWcwAE2WT5l7bJtXkLHODskJWBZZA7LpsxQaINCAqjQnXpqSNC4q7', '2024-06-17 11:00:41', '2024-06-17 11:01:18', NULL, NULL, 1),
(9, 'prince', 'ochui.princewill@gmail.com', NULL, NULL, '07037269314', NULL, '$2y$12$4jluraPdp3r0NyY.Uu8SduJIBKqu74ZP3y.N58GCftKTKF9X.tahS', 'KM7QpClFlmyMeqZN8rH78G5hQ7413t5iTaqbJSrSOVEPqqL9Uh8n2Yd0XHdc', '2024-07-27 09:47:41', '2024-07-27 09:47:41', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_wema`
--

CREATE TABLE `auth_wema` (
  `id` int NOT NULL,
  `transactionID` text,
  `securityINFO` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a_p_idatas`
--

CREATE TABLE `a_p_idatas` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `network_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `network_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `network_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a_p_i_airtimes`
--

CREATE TABLE `a_p_i_airtimes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `network_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `network_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `network_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a_p_i_transactions`
--

CREATE TABLE `a_p_i_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `trans_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trans_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trans_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_balance` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `data_json` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'success',
  `beneficiary_no` text COLLATE utf8mb4_unicode_ci,
  `beneficiary_name` text COLLATE utf8mb4_unicode_ci,
  `beneficiary_bank` text COLLATE utf8mb4_unicode_ci,
  `from_name` text COLLATE utf8mb4_unicode_ci,
  `from_no` text COLLATE utf8mb4_unicode_ci,
  `isReversed` varchar(22) COLLATE utf8mb4_unicode_ci DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- --------------------------------------------------------

--
-- Table structure for table `beneficiaries`
--

CREATE TABLE `beneficiaries` (
  `id` int NOT NULL,
  `acct_name` text,
  `acct_no` text,
  `bank` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` text NOT NULL,
  `recipient_code` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `id` int NOT NULL,
  `user_id` varchar(222) DEFAULT NULL,
  `customer_id` text,
  `card_data` text,
  `is_request` varchar(55) DEFAULT 'true',
  `is_verified` varchar(55) DEFAULT 'false',
  `pin` varchar(66) DEFAULT '1234',
  `report` text,
  `address` text,
  `is_paid` varchar(33) DEFAULT 'false',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `address1` text,
  `city` text,
  `lga` text,
  `state` text,
  `postalcode` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `charges`
--

CREATE TABLE `charges` (
  `id` int NOT NULL,
  `debit_acct` text,
  `credit_acct` text,
  `user_id` text,
  `amount` text,
  `status` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `trans_id` text,
  `verify_acct` varchar(22) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_import_rows`
--

CREATE TABLE `failed_import_rows` (
  `id` bigint UNSIGNED NOT NULL,
  `data` json NOT NULL,
  `import_id` bigint UNSIGNED NOT NULL,
  `validation_error` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `imports`
--

CREATE TABLE `imports` (
  `id` bigint UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `importer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int UNSIGNED NOT NULL DEFAULT '0',
  `total_rows` int UNSIGNED NOT NULL,
  `successful_rows` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_12_20_152014_create_imports_table', 1),
(6, '2023_12_20_152015_create_failed_import_rows_table', 1),
(7, '2023_12_21_102418_create_password_resets_table', 1),
(8, '2023_12_21_103543_create_admins_table', 2),
(9, '2016_06_01_000001_create_oauth_auth_codes_table', 3),
(10, '2016_06_01_000002_create_oauth_access_tokens_table', 3),
(11, '2016_06_01_000003_create_oauth_refresh_tokens_table', 3),
(12, '2016_06_01_000004_create_oauth_clients_table', 3),
(13, '2016_06_01_000005_create_oauth_personal_access_clients_table', 3),
(14, '2024_01_03_085908_create_a_p_i_airtimes_table', 4),
(15, '2024_01_03_085930_create_a_p_idatas_table', 4),
(16, '2024_01_03_135127_create_a_p_i_transactions_table', 5),
(17, '2024_01_03_174331_add_json_data_table_to_transaction', 6),
(18, '2024_01_03_190900_add_wallet_to_user_row', 7),
(19, '2023_12_20_170206_create_user_m_s_table', 8),
(20, '2024_04_11_055139_create_announcements_table', 8),
(21, '2024_04_11_055139_create_notifications_table', 9),
(22, '2024_04_11_055139_create_supports_table', 10),
(23, '2024_06_27_122504_create_notifies_table', 11),
(24, '2024_08_08_210000_add_pin_status', 12);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `notifies`
--

CREATE TABLE `notifies` (
  `id` bigint UNSIGNED NOT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci,
  `text` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'unpublished',
  `target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `recipient` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
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
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'semibill Personal Access Client', 'Nw8DmydFZUNLsq4cM9CqqRnDFjiUukVKKP4haO4T', NULL, 'http://localhost', 1, 0, 0, '2023-12-21 11:20:25', '2023-12-21 11:20:25'),
(2, NULL, 'semibill Password Grant Client', 'EETNA4askhNgSG1CEFrueiP7WaScoDpqUM7ipfbt', 'users', 'http://localhost', 0, 1, 0, '2023-12-21 11:20:25', '2023-12-21 11:20:25');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-12-21 11:20:25', '2023-12-21 11:20:25');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referral`
--

CREATE TABLE `referral` (
  `id` int NOT NULL,
  `user_id` text,
  `referer` text,
  `claimed` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `referral`
--

INSERT INTO `referral` (`id`, `user_id`, `referer`, `claimed`, `created_at`, `updated_at`) VALUES
(1, '35', '30', '0', '2024-04-11 15:03:36', '2024-04-11 15:03:36'),
(2, '6', '13', '1', '2024-04-11 15:03:36', '2024-04-11 16:43:25'),
(3, '6', '14', '1', '2024-04-11 15:03:36', '2024-04-11 16:43:25'),
(4, '6', '15', '1', '2024-04-11 15:03:36', '2024-04-11 16:43:25'),
(5, '6', '16', '0', '2024-04-11 15:03:36', '2024-04-11 16:43:25'),
(6, '6', '17', '0', '2024-04-11 15:03:36', '2024-04-11 16:43:25'),
(7, '38', '7', '0', '2024-04-22 22:39:47', '2024-04-22 22:39:47'),
(9, '40', '30', '0', '2024-04-30 19:28:45', '2024-04-30 19:28:45'),
(10, '41', '30', '0', '2024-05-01 02:06:24', '2024-05-01 02:06:24'),
(11, '49', '44', '0', '2024-05-20 13:47:25', '2024-05-20 13:47:25'),
(12, '53', '50', '0', '2024-05-23 23:42:09', '2024-05-23 23:42:09'),
(13, '54', '50', '0', '2024-05-26 12:17:44', '2024-05-26 12:17:44'),
(14, '57', '44', '0', '2024-05-30 10:52:42', '2024-05-30 10:52:42'),
(15, '61', '50', '0', '2024-05-30 12:37:35', '2024-05-30 12:37:35'),
(16, '62', '50', '0', '2024-05-30 13:33:20', '2024-05-30 13:33:20'),
(17, '63', '50', '0', '2024-05-31 12:26:07', '2024-05-31 12:26:07'),
(18, '68', '50', '0', '2024-05-31 20:43:33', '2024-05-31 20:43:33'),
(19, '70', '64', '0', '2024-05-31 22:09:47', '2024-05-31 22:09:47'),
(20, '71', '64', '0', '2024-05-31 22:32:33', '2024-05-31 22:32:33'),
(21, '81', '50', '0', '2024-06-13 07:03:15', '2024-06-13 07:03:15'),
(22, '83', '50', '0', '2024-06-13 07:21:23', '2024-06-13 07:21:23'),
(24, '96', '60', '0', '2024-06-19 10:42:15', '2024-06-19 10:42:15'),
(25, '98', '82', '0', '2024-06-19 19:58:42', '2024-06-19 19:58:42'),
(26, '99', '82', '0', '2024-06-19 20:08:56', '2024-06-19 20:08:56'),
(27, '140', '123', '0', '2024-07-08 05:14:43', '2024-07-08 05:14:43'),
(28, '182', '123', '0', '2024-07-22 13:42:08', '2024-07-22 13:42:08'),
(29, '209', '82', '0', '2024-07-23 09:53:28', '2024-07-23 09:53:28'),
(30, '217', '139', '0', '2024-07-23 19:08:59', '2024-07-23 19:08:59'),
(31, '250', '60', '0', '2024-07-25 13:55:18', '2024-07-25 13:55:18');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int NOT NULL,
  `ref_com` text,
  `phone` text,
  `email` text,
  `misc` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `trans_com` text,
  `main_acct_no` text,
  `main_bank` text,
  `giftcard_com` text,
  `card_charge` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `ref_com`, `phone`, `email`, `misc`, `created_at`, `updated_at`, `trans_com`, `main_acct_no`, `main_bank`, `giftcard_com`, `card_charge`) VALUES
(1, '20', NULL, NULL, NULL, '2024-04-11 16:03:05', '2024-07-21 05:22:12', '15', '0115257056', NULL, '1000', '2000');

-- --------------------------------------------------------

--
-- Table structure for table `supports`
--

CREATE TABLE `supports` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci,
  `type` text COLLATE utf8mb4_unicode_ci,
  `text` text COLLATE utf8mb4_unicode_ci,
  `status` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` text COLLATE utf8mb4_unicode_ci,
  `lastname` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lga` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pass_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email_verified` int DEFAULT '0',
  `email_code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `wallet_ngn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `username` text COLLATE utf8mb4_unicode_ci,
  `acct_name` text COLLATE utf8mb4_unicode_ci,
  `acct_no` text COLLATE utf8mb4_unicode_ci,
  `acct_status` text COLLATE utf8mb4_unicode_ci,
  `acct_customer_id` text COLLATE utf8mb4_unicode_ci,
  `acct_email` text COLLATE utf8mb4_unicode_ci,
  `acct_phone` text COLLATE utf8mb4_unicode_ci,
  `dod` text COLLATE utf8mb4_unicode_ci,
  `nin` text COLLATE utf8mb4_unicode_ci,
  `wema_tracking_id` text COLLATE utf8mb4_unicode_ci,
  `pin` text COLLATE utf8mb4_unicode_ci,
  `pin_token` text COLLATE utf8mb4_unicode_ci,
  `ps_cus_code` text COLLATE utf8mb4_unicode_ci,
  `ps_cus_id` text COLLATE utf8mb4_unicode_ci,
  `biometric` text COLLATE utf8mb4_unicode_ci,
  `referral_code` text COLLATE utf8mb4_unicode_ci,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `verification_type` text COLLATE utf8mb4_unicode_ci,
  `verification_number` text COLLATE utf8mb4_unicode_ci,
  `verification_status` text COLLATE utf8mb4_unicode_ci,
  `sh_id_no` text COLLATE utf8mb4_unicode_ci,
  `verification_otp` text COLLATE utf8mb4_unicode_ci,
  `sub_acct_id` text COLLATE utf8mb4_unicode_ci,
  `has_pin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `firstname`, `lastname`, `email`, `state`, `lga`, `phone`, `bank_name`, `bank_account_no`, `bank_account_name`, `device_token`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `address`, `pass_token`, `email_verified`, `email_code`, `wallet_ngn`, `username`, `acct_name`, `acct_no`, `acct_status`, `acct_customer_id`, `acct_email`, `acct_phone`, `dod`, `nin`, `wema_tracking_id`, `pin`, `pin_token`, `ps_cus_code`, `ps_cus_id`, `biometric`, `referral_code`, `avatar`, `verification_type`, `verification_number`, `verification_status`, `sh_id_no`, `verification_otp`, `sub_acct_id`, `has_pin`) VALUES
(43, 'Christian  umanah', NULL, NULL, 'pachristong@gmail.com', NULL, NULL, '07088800874', NULL, NULL, NULL, 'ct4Meo_3RRyQVTIbZJz1BP:APA91bHaxznvYtBOnXI-PoX0LO85EWVbbp8avUXsVQ0AR-k95pVSfEHZDwYap9Id1dGTcJLjkHqtMIIIdFqexWwaseuZsEQdGvJR3vxRSZTDQk5JWI1knSAV_6r9g7vJUHoQ2fSx9hNp', NULL, '$2y$12$LU.ciUbAghO./PhoK89d9.MjSGC/NfDim04H72ybVkPbRLlPx/lO.', NULL, '2024-05-03 19:07:08', '2024-08-10 07:01:10', NULL, '44114', 1, '45435', '79', 'pachristong', 'JOPAYTECHLIMITE / VICTORIA UMANAH', '8020737784', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '1234', '', 'CUS_4q7bdojju3niqgj', '162789357', NULL, '43PlcK', 'https://jopay.africa/storage/avatars/1S9XpRUhmE3cIlK1ganOgrZyEZamxTsxNc0GkWfC.jpg', 'bvn', '22640607548', 'active', '665f1aa1813433c79b3fb49e', '167968', '666a3d72aeb2870024c2c2b0', 1),
(44, 'Abdulrazak hassan', NULL, NULL, 'smile.kash.abdul@gmail.com', NULL, NULL, '09152229516', NULL, NULL, NULL, 'coTUjzs6SLKkk467qEnUUE:APA91bEI155rT0p0kk1StNSp3SIXyVaVNkoxQQ593j7Mi4HisDIal249reGs7tAmvQKhpQeIcoZARVvGpv72z_ZzQ5-mhpVqaD35f-lCjmMA21Fy1USAuVDXPdkyNGjrMYiJxI5pcCpo', NULL, '$2y$12$ugBcGkk3cYMV9lbzg73NTuTxf0O1wgsaGwiqyTE49qase74mJLgTm', NULL, '2024-05-19 18:42:39', '2024-08-09 23:17:02', NULL, '32980', 1, '76532', '100', 'smilekashabdul', 'JOPAY TECH LIMITED / ABDULRAZAK HASSAN', '0104286063', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '1358', '', NULL, NULL, NULL, '44rsi9', 'https://jopay.africa/storage/avatars/dUpbo4bGYGSnMisNE11LfJfj7Kt1vf88PN8nAX6F.jpg', 'bvn', '22644518235', 'active', '666a155b3a90ee083037b908', '638380', '666a4d28aeb2870024c59b9c', 0),
(45, 'Abdul kash', NULL, NULL, 'kash.abdul.me@gmail.com', NULL, NULL, '08036692461', NULL, NULL, NULL, 'dDxB4GRHQQaT-N2NVNshRQ:APA91bHOiNXMV-40XhrF8a2aLi3mCghFU56bD6wTSU6b9KTfnuuyx4aSmG559joECYJlBMNxEDDMkTMUK__VAZ4c6Noowt73BwjXcBshz6-LnTXTqPvm9D2LY0XbG0RaHMgWvHA0Pq_c', NULL, '$2y$12$Lp2AM9LJJ0EHZU1tEJ1XSeFvhX89kx3nObrU5pzm3ux7GVDOv/Wky', NULL, '2024-05-20 13:41:47', '2024-05-29 22:02:18', NULL, NULL, 1, '74262', '0', 'kashabdulme', 'JOPAY TECH LIMITED / ABDUL KASH', '0103767198', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '1358', '', NULL, NULL, NULL, '45GwoJ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(49, 'Ekemini Joe', NULL, NULL, 'ecemini@gmail.com', NULL, NULL, '091522295148', NULL, NULL, NULL, NULL, NULL, '$2y$12$QEZLuCmpUI9vQkwPA4s9nuixcOgCy.l1Tvz6rKqYxYkkikOAHrGte', NULL, '2024-05-20 13:47:25', '2024-05-29 18:08:22', NULL, NULL, 0, '52659', '0', 'ecemini', 'JOPAY TECH LIMITED / EKEMINI JOE', '0100681440', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '49suTx', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(50, 'Joseph ray', NULL, NULL, 'josephraysp@gmail.com', NULL, NULL, '08103625000', NULL, NULL, NULL, 'dlqVfykMRpW0ouij4xPKza:APA91bGW8ZCuVsoia69yx4NhdXvwvbuwQwUnzPXHWW0MwRMGen3O_N5TaMmfafNxuqCisOTRlaVnLsjDjQpSfezpQTNidUlSEKsj0c_3VC-_Rk6KYj6dq-aUldIQGkfkYSPGFqTz9zDd', NULL, '$2y$12$xFZNej7LXKi2Yy1zLt2kSuRgDf213mRcMob5lGPDwmmNK.gPiSG/K', NULL, '2024-05-20 14:22:16', '2024-07-28 13:07:39', NULL, '95375', 1, '83725', '5321', 'josephraysp', 'JOPAY TECH LIMITED / JOSEPH RAY', '0104517132', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '1255', '', NULL, NULL, NULL, '50exYX', 'https://jopay.africa/storage/avatars/jKW7QGskFSECfz9DUThEj4sKBqJvL6JdEPtl0nBM.jpg', 'bvn', '22272226881', 'active', '666a310a7b21481faf7a86eb', '790743', '666a9b2dfdb2ea0024117261', 0),
(51, 'Joseph betty', NULL, NULL, 'josephbetty12@gmail.com', NULL, NULL, '08105891285', NULL, NULL, NULL, 'dwAKtms1T9OWO11E-pphIs:APA91bExuF8skwjCaBIsB_bvll0GIpLFlUTSxrjE9fGaTThRTrIwXudxc-mh4eT4q4jOdpyz9Zp23OThVms0YZjD431zLXPKsRUBF4YNXq7ZlaT-Qz3B4KG7MSMW3jW3HLQrWODZ_nn1', NULL, '$2y$12$07hAX.ycG0Z5Am5EzzlRwewX7WLVAO83G0voYxLKZl3gqxdb94JQq', NULL, '2024-05-20 15:37:58', '2024-07-28 13:03:43', NULL, NULL, 1, '39490', '170', 'josephbetty12', 'JOPAYTECHLIMITE / BETTY JOSEPH', '8021679278', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '1255', '', NULL, NULL, NULL, '51cE3u', NULL, 'BVN', '22238221644', 'active', '666c42e73847c6af5709d24a', '321079', '666c42fb1fa4cd00248ad3d5', 0),
(52, 'Terry osadiaye', NULL, NULL, 'terrybankz943@gmail.com', NULL, NULL, '08101837258', NULL, NULL, NULL, 'fEqlkKViROuXFya2Ck--Yp:APA91bFo1ZJLaMa1lF47aQpaytadtZe0pZ0U-zdCZf8hm7ZO2vU1LPwAidz37zuy9t0KCo-dKYJkYPY6nL6pbzCX_mHZcyFz-bwp-XrcaWhNVOEH29YM4tdLcyFYLYd0d4HqMFTS3uNL', NULL, '$2y$12$ktyL2eTNZDZjTu93ZDYRSOguvH2nAX0N/5fXSVMQFYv/RWYVdj5FG', NULL, '2024-05-20 19:55:04', '2024-06-11 03:23:27', NULL, NULL, 1, '65526', '640', 'terrybankz943', 'JOPAY TECH LIMITED / TERRY OSADIAYE', '0101857657', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '7388', '', NULL, NULL, NULL, '52E085', 'https://jopay.africa/storage/avatars/yT775NdW8ulsVTHGi0RAineQbArL20Fr3iFKwCY5.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(53, 'Usman emmanuel', NULL, NULL, 'goldemmy825@gmail.com', NULL, NULL, '09028484137', NULL, NULL, NULL, 'fEbKbwT5Riaax40td_r3Bq:APA91bHTUiqtVRYMl4c6G68OA-BxYtLYeak0dOPCZV2aYuSEN-RUid-owKTVXjExU0Sr_lMb-vZQGJOixcw6EHOJSbeeh2J--1E-eEk-QpO7nOvbv4a1kp9hONewuxWkivMk_LHDGMTB', NULL, '$2y$12$5C6Jh6r3IJyYGiWKBJbjGOczom4G.FDG36pmwXV1/22GijtrJ/KGi', NULL, '2024-05-23 23:42:09', '2024-06-07 07:28:02', NULL, NULL, 1, '24048', '5', 'goldemmy825', 'JOPAY TECH LIMITED / USMAN EMMANUEL', '0107632489', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '6040', '', NULL, NULL, NULL, '53zuu4', 'https://jopay.africa/storage/avatars/p6h6EXyWTaAhKYA4TIo88wLzFhL6CyjDLg0yxEg8.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(58, 'Onyedika ukuru ', NULL, NULL, 'kachicreate@gmail.com', NULL, NULL, '08111616585', NULL, NULL, NULL, 'cM7nEzgg0kX7kx8dANhisU:APA91bGPE5NuIOWC9WnZTC5KcrhSXU4ELMBbch2Hr0f49sSKL1wVIShU58q5NRoN22DzpEKS3xoFeF1gdA7_asxbV1OxXszEPpGusGpcig8oSxjRS57nnd29iQN91cKQZ09FR19t0ip7', NULL, '$2y$12$vku2J09gBhUJV7d2V7b7auZXBxboPkuPO3kMiw1Xv9FWFqbIxYQla', NULL, '2024-05-30 11:00:55', '2024-07-28 10:39:01', NULL, '99386', 1, '83706', '308', 'kachicreate', 'JOPAYTECHLIMITE / ONYEDIKA UKURU', '8027744019', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '0103', '', NULL, NULL, NULL, '58CY8f', 'https://jopay.africa/storage/avatars/w7xHKHbfPhFMCfsxPTCh991WMzgIjxZ23CMI9RMh.jpg', 'BVN', '22299403274', 'active', '666cd7f7b808a110245eb40d', '385349', '666cd811f5c19700243d065a', 0),
(60, 'Ali zainab anita', NULL, NULL, 'anitaali226@gmail.com', NULL, NULL, '09032074295', NULL, NULL, NULL, 'fexhzuh4TbmPbYHY1yuAHT:APA91bE69oba6a3xGv0fbz4T96H1om5MctJMXG_Mx2iOQmVDEG5oHXIvrZg9up_ojK-ANbGwZKxvnH_kKk6NQ0GgxpgZcoxZ76oodQw8a4PrlqIIJjMcGaM1qG7hULgpw86U3tTsEBCa', NULL, '$2y$12$6SzivOY7SLXYziF4E.haluSKEIuZ51Lm..t9gUluBSw3sE622nam2', NULL, '2024-05-30 11:38:40', '2024-07-28 10:39:01', NULL, '26052', 1, '90182', '425', 'anitaali226', 'JOPAYTECHLIMITE / ZAINAB ALI', '8026546625', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '7531', '4311', NULL, NULL, NULL, '60f43C', 'https://jopay.africa/storage/avatars/G9FdINVvdpugynt07bqWK8pmTfdTo1L7U54G0tUp.webp', 'BVN', '22483802467', 'active', '666c104aa782bd9e6b57c519', '461196', '666c1065f9a35300245a2fcd', 0),
(61, 'Joseph roseline', NULL, NULL, 'josephroseline2007@gmail.com', NULL, NULL, '08054845679', NULL, NULL, NULL, 'fsnyGIsiREOw8b_SUGtQGk:APA91bGeXV47qOM1fQ7LzLWNYvAWaG1TDPdR7R7Q8boCTlnzO8uisx1-MzLDdgSHZsdE0Y1m3FFFCXtYskRvugdQKoujCHKHk10DrlANR4Q_y1BIg93Jx9l-bzzRWFqrZfCedmu_9Ilp', NULL, '$2y$12$sNfTOiGM3oAmYmmy.3B38.SFrJ7gqT/U4bzzXnndfegpm5W8Eep96', NULL, '2024-05-30 12:37:34', '2024-06-13 07:02:56', NULL, NULL, 1, '64527', '185', 'josephroseline2007', 'JOPAY TECH LIMITED / JOSEPH ROSELINE', '0104333493', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2007', '', NULL, NULL, NULL, '61VlgU', 'https://jopay.africa/storage/avatars/jWaLVQBj7gSH3fJUvy85vIi4MCIuUAnOg21G5vuD.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(62, 'Osemwengie destiny', NULL, NULL, 'destinybankz449283@gmail.com', NULL, NULL, '08112105642', NULL, NULL, NULL, 'ce698u_3N087gJAFURi00Z:APA91bGXJMB4ajYDFMBDSVhcfw8MvGZW-hjXoxTAHr1FBlnl1CGObkVo_criZcahGLCtIDhAexwCD142kBaIWROHCCPjhY1L4t3ox-485lK0ZPgZP50BvlKv3jVNl2E97sfaEwGo3mXq', NULL, '$2y$12$RW8p/tWDAO0d2NosJ/bA2esEcqGK7oQVZUH.0M7cNSL5eG6Mo0C0S', NULL, '2024-05-30 13:33:20', '2024-07-28 13:08:50', NULL, NULL, 1, '96908', '345', 'destinybankz449283', 'JOPAYTECHLIMITE / DESTINY OSEMWENGIE', '8026018128', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2020', '', NULL, NULL, NULL, '62moQg', 'https://jopay.africa/storage/avatars/23HtximbX2NbxBhioHSVWVzxvEcR7cKNCq9YQUP8.jpg', 'BVN', '22631861270', 'active', '666adad37d4fd8de11470a8b', '593656', '666adaf6722a61002437d99e', 0),
(63, 'Joseph faith', NULL, NULL, 'josephfaith1966@gmail.com', NULL, NULL, '07054702639', NULL, NULL, NULL, 'fsMTDek7TUai8-qz9zc51z:APA91bGE2YO_WYLxOSb-XZFwSR3AkpCgYyDBYpE9HHLU0EFuGVKQuT5oIqvX4IBPxBGbvsoVOkQOgUdbkPgZNDm-oWer8bEhZJkAVXn5kwiXv7hN8VKX5JKeO8NGtJSEXLhlKcJWngCY', NULL, '$2y$12$.f7/k1g7jjoskjrtxIJv1Out7gd8EaAmbGnvbViXqh0l4EW6HuLoO', NULL, '2024-05-31 12:26:06', '2024-07-28 12:38:14', NULL, NULL, 1, '94393', '12200', 'josephfaith1966', 'JOPAY TECH LIMITED / JOSEPH FAITH', '0100564293', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2007', '', NULL, NULL, NULL, '634v9K', 'https://jopay.africa/storage/avatars/EqHzr6H8Pfqx0KFBzUOqVWfWSrwGyFVsfh05NBpa.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(64, 'Micheal imade', NULL, NULL, 'michealimade21@gmail.com', NULL, NULL, '08145654845', NULL, NULL, NULL, 'czVjXyL1FaGfYO6pbQyUYb:APA91bF62DyhDgNwOvK9wN1-a5fMeVnlMMpXJ2TsxfAVAgQAie8lfJ74M9EwvOTwsk0Awwr8BlGd3W_N5FaGVojGdKLhT2xZmIVO-IXrIsVdXf5QrCgRpF78AxBdMRCfLqb3QCJmrpt8', NULL, '$2y$12$jaRhG/sGq6YaJOIhoGURgu/efDVOcc73JbjpIODRAsa3G8.cAb9gG', NULL, '2024-05-31 19:26:22', '2024-07-28 13:00:31', NULL, '88242', 1, '11398', '100', 'michealimade21', 'JOPAYTECHLIMITE / MICHEAL IMADE', '8023311110', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '1312', '', NULL, NULL, NULL, '64QgDE', NULL, 'BVN', '22444272863', 'active', '666d55ff062c3ab0d08e7ce8', '240989', '666d56355bc82e0024ce065c', 0),
(65, 'Iyoha franklin oseghale', NULL, NULL, 'iyohafranklin@gmail.com', NULL, NULL, '09021934999', NULL, NULL, NULL, 'e6t4-1A6QmmL2JwAzmsyY9:APA91bEECa8QIEYxHgLNVhqRyP3O9wo_1GPXP_dNUJHXXIB3bTQIMpk2DXADyp6vVn8McNqfki2sGGa8G2QUX4WTJ3b1RZjGph3D-cJVIv9bD6ZSk6rcUmNMxBKdppTz_iLo_h9FoTqb', NULL, '$2y$12$8I6d/uQhYyIB2LF1c0Gyl.IvWkOC6ZDrXIbL93LUz5J0Br0KmSgx2', NULL, '2024-05-31 19:44:33', '2024-06-03 14:59:10', NULL, NULL, 1, '69148', '0', 'iyohafranklin', 'JOPAY TECH LIMITED / IYOHA FRANKLIN OSEGHALE', '0102123719', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '5352', '', NULL, NULL, NULL, '65zwZe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(77, 'Abdulrazak abdulqadir', NULL, NULL, 'smile._buddy@outlook.com', NULL, NULL, '08052229516', NULL, NULL, NULL, 'cp6T0Ai1Qg2Gtane-B9aYN:APA91bFdUyDWluFGZMrEOKV-YBDRCpXPj3eedVGng9HrhzzNOwwGhT-kHvxdIn0qAjkJyp22KIeR40Y9JnxxRkeJYlXrobsoIPbBEm07WR3XzLfdqd01nL3-xLFabDLMdtH-n7e1bRpa', NULL, '$2y$12$A0QLUc0HVOxdVe7MAzZenOBeFoSfwO86NjhLEdGlDkjjQOiXXpZNC', NULL, '2024-06-12 22:05:40', '2024-07-28 10:39:07', NULL, NULL, 1, '41432', '70', 'smilebuddy', 'JOPAYTECHLIMITE / ABDULRAZAK ABDULQADIR', '8022577773', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '1358', '', NULL, NULL, NULL, '779m5s', NULL, 'BVN', '22644518235', 'active', '666a155b3a90ee083037b908', '292229', '666a4d28aeb2870024c59b9a', 0),
(82, 'Joseph ray osasere', NULL, NULL, 'sirjosephray@gmail.com', NULL, NULL, '07054702645', NULL, NULL, NULL, 'e4DF7ge8lk6Wvp8rCOE79j:APA91bHKk7d9g7siOP1u8cCZ_UIok_E4gTJNaJaFnoyh1V5fQrYz84rFcA0_nabNEwJTwYPaPdXHJH-pYO8qpkJKV-hpksO0jMTFSpHQ0mteYKbjDyakAuByqDj9MyNnmgBIyNWhN-ZW', NULL, '$2y$12$JQZwJORgygk9OHwqMxTg0ulNf1I1.HfAo0bGeeMHM/5udOayZ2EF6', NULL, '2024-06-13 07:07:23', '2024-07-28 13:08:15', NULL, '16966', 1, '74412', '81', 'sirjosephray', 'JOPAYTECHLIMITE / RAY JOSEPH', '8022859198', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '8495', '9242', NULL, NULL, NULL, '82cph7', 'https://jopay.africa/storage/avatars/bl1JSuAUgKrnGp5sUCrI7cig4BgM5NbxJQc5N2D0.jpg', 'BVN', '22272226881', 'active', '666a310a7b21481faf7a86eb', '285868', '666a9b2dfdb2ea002411725f', 0),
(83, 'Efe victor divine', NULL, NULL, 'efevictor001@gmail.com', NULL, NULL, '08079399870', NULL, NULL, NULL, 'eFzR_Z3XRTuQAHbELoun4X:APA91bF1-XjXspuxIy0wzPZGxwu9qbC9qzH4qXrA5D53a4kD_SUHyJELeJ0Hfu4uieNP6DwY2UqlqZfi3in3Ua1UCsGligYks2J0LF3E-yhM0-L1JNFAifWslZAGmCr3s5W9-AUNkNDH', NULL, '$2y$12$y5iz6Pjl2Ky4mxnC9IrMWe7Keuns.sdz9dEkpm4p1lzcxr3NvN/pC', NULL, '2024-06-13 07:21:22', '2024-07-28 10:39:08', NULL, '27610', 1, '15000', '30', 'efevictor001', 'JOPAYTECHLIMITE / VICTOR EFE', '8025193589', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '1992', '', NULL, NULL, NULL, '83dsnc', 'https://jopay.africa/storage/avatars/uD8sxMSv3XKrdiYFXmibmCE0tLnN4KXZdCB8Rlp8.jpg', 'BVN', '22724302657', 'active', '666a91e2cc6f6e22c9c8886c', '838590', '666aa17afdb2ea002413858e', 0),
(86, 'Iyoha christopher eromosele', NULL, NULL, 'chrisnero02@gmail.com', NULL, NULL, '07012391932', NULL, NULL, NULL, 'dNGPlGBOShOR-lLUgMNEP_:APA91bGwgkOs1JMAtAGUHaZgMDjqnhc1koXA0pjbB-NYzNAT1RbBqSHbNG4ipiKK882G2DTyGGDiEOzDEr-4pd0R4vPvSXibOLy6oDpPe56Ce77PrPu0bG5NPUj5pOfBY1iM9XHRg0Td', NULL, '$2y$12$3a4kPmFFS2yS9U5.XGpIX.iNCDgMILElnApCNGM/WxXLS9lDzHGCe', NULL, '2024-06-13 17:54:28', '2024-07-28 10:39:09', NULL, NULL, 1, '27497', '495', 'chrisnero02', 'JOPAYTECHLIMITE / CHRISTOPHER IYOHA', '8022405423', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '7391', '', NULL, NULL, NULL, '86deq1', NULL, 'BVN', '22485902628', 'active', '666b33d71bc0b896d370ed94', '926520', '666b3410758fea0024d14c76', 0),
(89, 'Ekpo peace itohan', NULL, NULL, 'peaceekpo705@gmail.com', NULL, NULL, '08074060363', NULL, NULL, NULL, 'fJ3GAIhLQPKqIYVsyv2yO1:APA91bH7__a-sU3ljXEBMgzbRXZsKTWLcP9ZFOHld_sybzKmVmNTfVsCB1OyKTM0lEON7dyYJvqJBHz2fOlH93NZo7uQmjBatmwrK_dbKD10HfC1QaWAvom3r5dPiN9KPGhJGdPy6gGl', NULL, '$2y$12$ze2fSy0RU/NyIcEvSu6OVODfpIoDErAJVquSeNo6Hs37KIkdSK1YO', NULL, '2024-06-14 11:30:12', '2024-07-28 10:39:09', NULL, '11727', 1, '44209', '35', 'peaceekpo705', 'JOPAYTECHLIMITE / PEACE EKPO', '8029147384', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '9873', '2534', NULL, NULL, NULL, '89wUFQ', 'https://jopay.africa/storage/avatars/vqzv9FCz1Gqrpxc8a2Y4SSU2QMBefXRLv3mS9uhv.jpg', 'BVN', '22639429328', 'active', '666c2a6ea9fbca7d2382d3d8', '803472', '666c2ac01fa4cd002482dd96', 0),
(90, 'Yakubu braimah', NULL, NULL, 'braimahyakubu23@gmail.com', NULL, NULL, '09039007870', NULL, NULL, NULL, 'cMbzzAwQ40FSnGNl1ifvFT:APA91bHnFg3Tf8zZBdoVA2LbUbSwSkfIcD3T5XA6ukZMFQ1_ZMv_igdYCxNn7zOUnbOPxaeYHAEzH6UxZaTFzEC33VY7DWbNVGcaXo9JlT7nTEFMLhgW8X2Koozox8tS39q9MdSid_-3', NULL, '$2y$12$Olb4/PlI34LodsGUHoF2uuBzwu.05pHfOVsCSjVl8eyfxcMfS3tFW', NULL, '2024-06-15 08:59:46', '2024-07-28 12:58:56', NULL, NULL, 1, '30063', '20', 'braimahyakubu23', 'JOPAYTECHLIMITE / YAKUBU BRAIMAH', '8029390465', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2580', '', NULL, NULL, NULL, '90zqhT', 'https://jopay.africa/storage/avatars/WtgrX2ogW4WqVsDoZCTuvtKzMbUcUfxjQtwzIRGw.jpg', 'BVN', '22493383871', 'active', '666ae36d7d4fd8de11470b36', '460973', '666d5a885bc82e0024cfa1ab', 0),
(93, 'Margret osazee orobosa', NULL, NULL, '2244kelvin@gmail.com', NULL, NULL, '07068749564', NULL, NULL, NULL, 'fqXR3uC-Q7WK7WC0U7hEyN:APA91bEwGB9UGKxGMpAB3Q7YLP670fHnoEKLTSgT4aKwfgx8gtypPRNsIKr5aHaQfqSm4FJMGq4I3zck-JlBUAmhJ-Wtwlk__IEXnyUt04kLoBJY-rNjjFJJKtjaPfK6j7smVHvZxJkx', NULL, '$2y$12$.PI7UrAsEwghDmhCaiJEI.zjYx/SizP3tPeK81hlRfeL/LoSaKdz2', NULL, '2024-06-18 11:42:31', '2024-07-23 21:38:23', NULL, NULL, 0, '91554', '0', '2244kelvin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '935OGD', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(94, 'Ikponmwosa.o.aideguowen', NULL, NULL, 'www.amandaowen@gmail.com', NULL, NULL, '09057727348', NULL, NULL, NULL, NULL, NULL, '$2y$12$BssnqEQ/JmqEXZWglx/JB.YqPdFGCRH8E5txIjGs2O/fQmJK.i7YW', NULL, '2024-06-18 15:42:59', '2024-06-19 09:30:58', NULL, NULL, 1, '25504', '-150', 'wwwamandaowen', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '852', '', NULL, NULL, NULL, '94AnEt', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(95, 'Isreal ojiefulu', NULL, NULL, 'ograpper4@gmail.com', NULL, NULL, '09159645337', NULL, NULL, NULL, 'dcKIi9pfQbSWHoCM1wsnMv:APA91bEMcJ35-UgLpWq8fhV5HA-0gE-LLO6UfaaAtSQfIynD0NTHUkfVCTPHKqTGzrB5UqFBvpL5pxkiozcKQc7OmNMhi1_pmM22QieScnk3l25Ay7G0c2-gcr7MIIJ4i4003omwhW__', NULL, '$2y$12$r/1Q6EVdCjZdHrsZGgxIiuMEzMvZKSCbj.4Fvjq2olm4q.UNoCNg2', NULL, '2024-06-19 07:26:31', '2024-07-28 10:39:10', NULL, '24447', 1, '24906', '445', 'ograpper4', 'JOPAYTECHLIMITE / ISREAL OJIEFULU', '8026321699', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '1255', '', NULL, NULL, NULL, '95Q9kU', 'https://jopay.africa/storage/avatars/hEw94hxfjRTXalb3EWUeosTPdRbK1KIntoChEUVO.png', 'BVN', '22708465886', 'active', '6672889c929f23052a82b95a', '203904', '667288adc90c860024d568b4', 0),
(96, 'Balogun opeyemi ibrahim', NULL, NULL, 'opeyemiibrahim0482@gmail.com', NULL, NULL, '09055512787', NULL, NULL, NULL, 'djPv3WNCSoaOp9wHfBb-6D:APA91bE7oCyWqUQsp5UfPyq1u6Nqq6aT1ffkiTRE3xjIgYJx1AauAmzp0oQ6-0rP2dTr6A9X8CYiMK2lZK7ustQKoS75BwALT-vv7Ruto2kwyPaJBpPfEkUWC8L7gM724PGYwvVaB2kS', NULL, '$2y$12$boTnG07C.kbFYIWKl5hO8eZN9hWuch8zOi1LJE6KsjIsvfdADllpG', NULL, '2024-06-19 10:42:14', '2024-07-28 10:39:10', NULL, '64645', 1, '14567', '10', 'opeyemiibrahim0482', 'JOPAYTECHLIMITE / OPEYEMI BALOGUN', '8021359237', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2502', '', NULL, NULL, NULL, '96dzke', NULL, 'BVN', '22522842276', 'active', '6672b777cedb8837f696bf72', '578728', '6672b7a8d3da7b00241d8c52', 0),
(98, 'Idehen rose', NULL, NULL, 'momohabibatuhappiness@gmail.com', NULL, NULL, '08102461992', NULL, NULL, NULL, 'e0TcUdIpsEQ2vtT37zsPvw:APA91bH25v-F_dSpFdWPDD8Zd7Po0LEuuPAHCK3nYx_uint3lBnlfxw5HKHNHd8p6_g1Maopyk3M-gLMiOyXd0TDYATEtz2DkbQPJ4ifA-n_WMrddtN-FZZ7WfZufNzxMB9a8VTOFJAD', NULL, '$2y$12$p/LMUSmWN6pW4fAGgw5NYewsrLq0bSERkhYNbF0NUEUT/HeP6RuEW', NULL, '2024-06-19 19:58:41', '2024-07-10 17:33:50', NULL, NULL, 0, '92272', '-200', 'momohabibatuhappiness', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9248', '', NULL, NULL, NULL, '98AKoh', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(99, 'Momoh abibatu happiness', NULL, NULL, 'happinessmomoh28@gmail.com', NULL, NULL, '09052407258', NULL, NULL, NULL, 'csE7G8DgaUMXsKZSLfmDHJ:APA91bFKJzHIcH5eITPoGo3_17yLPI5knZ7sp4viOD1ngzZCBktHDQYLgXCAu5z06QTtsQJNfkUWaLThcMsVU5niCzdof-k3NRaJRAX8_Kqgeu1CkLvRkZpyLogxObW9PM33No362gkb', NULL, '$2y$12$upwk51IJbVtDOQXw451/wuQRShXEfM6/CSFCL1GvX0cPjIwbs4.ie', NULL, '2024-06-19 20:08:56', '2024-07-20 19:28:39', NULL, '77589', 1, '91327', '-300', 'happinessmomoh28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8425', '', NULL, NULL, NULL, '99ZViN', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(101, 'Deborah forteta', NULL, NULL, 'debbieforteck@gmail.com', NULL, NULL, '07069142369', NULL, NULL, NULL, 'cTNqwSsfjE6Yiz3s2Pg3wp:APA91bGFjq_FTkB-i65cayfvVXOpjYq_z3AHQ099_Yqp7qmWZIZLfhr82wRYsgcnzr1fkepzuAbZvZly3Jy1nFspYilhd9TG-XM_rLfF2p5KNkClOZxoA_mWTKw5KiIS1f6PnkfPrxRZ', NULL, '$2y$12$K8ySmu0N4RsiyBHLeE0VV.ZOU1Ukl9U202BHCUiEwZWQYAIv6/izO', NULL, '2024-06-20 16:11:17', '2024-07-28 10:39:11', NULL, '89915', 1, '20054', '110', 'debbieforteck', 'JOPAYTECHLIMITE / DEBORAH FORTETA', '8020879129', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '0405', '', NULL, NULL, NULL, '101gvXN', 'https://jopay.africa/storage/avatars/RTJ0gMOBFs2SbS2fquFSoyHmFdIxRDkfZZDMFKPE.jpg', 'BVN', '22454636536', 'active', '6674554de3305a47e529e7ac', '233280', '667455bd66a36600240e351b', 0),
(111, 'Abdulhameed', NULL, NULL, 'aoshobugie@gmail.com', NULL, NULL, '09057657615', NULL, NULL, NULL, 'c0f8arjbwEKGieEXoXXPo3:APA91bFmcjYFjBOqbcvMfeWpM5ilM3u95Jo3nBw5SqNGkqWKspNF0jxRdkLhg21cbvQt2U_tcAeDs8fKat51O4y0Ux14LQ56zVAa7GP-qQR2PgKD6y3fsgFRVvK-TZV3PaaWPcqLGAsI', NULL, '$2y$12$fMf/pVO4cQ4Rnnv8vMr4wucKCS1W0fHRIAlH1sxPa2xF4fj/acNHK', NULL, '2024-06-22 09:27:37', '2024-06-22 09:28:12', NULL, NULL, 0, '50448', '0', 'aoshobugie', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1234', '', NULL, NULL, NULL, '111P66y', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(114, 'Eke alexander', NULL, NULL, 'ekealexander2@gmail.com', NULL, NULL, '08115809316', NULL, NULL, NULL, 'd5XaHGPiQSKl4hT1RiJjnT:APA91bGXPbqGkFPWSkHHuRWtAK4NiSEGaLACNlPy-ZJc-7R_0m1gn9RpnRDr--I7DL2e-0OFqFL_b9w1uaV0oWUSfA8YXldkPEFoBLeMW0Ohu-OJQG4ZZ0sgYWVKCFkXRVF1OG4nkMI0', NULL, '$2y$12$V04E8Wx1/3GsFlqk.LA6yOsMSQJ3BSMohfeu8FhguyHNuJIPS84my', NULL, '2024-06-26 15:03:31', '2024-07-02 06:53:27', NULL, NULL, 0, '74856', '0', 'ekealexander2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1149RZn', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(116, 'David olorunfemi israel', NULL, NULL, 'bedbreef@gmail.com', NULL, NULL, '09134069806', NULL, NULL, NULL, NULL, NULL, '$2y$12$71iM96okJpgiuhSn9I4xeOVv7MFiYIQZvfAdTTHQH4R1Zc0tOV3ca', NULL, '2024-06-27 16:22:51', '2024-06-27 16:22:51', NULL, NULL, 0, '39692', '0', 'bedbreef', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '116fVbc', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(118, 'Ikponmwosa gift', NULL, NULL, 'ikponmwosag14@gmail.com', NULL, NULL, '09075300518', NULL, NULL, NULL, NULL, NULL, '$2y$12$FF5IYt98etxsM4aqxMlriOPxThcY2Z5LlKimpJZDw6VtXp2uZInOW', NULL, '2024-06-28 09:37:13', '2024-06-28 09:37:13', NULL, NULL, 0, '12004', '0', 'ikponmwosag14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '118J95E', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(119, 'Ogbeide eunice', NULL, NULL, 'euniceogbeide71@gmail.com', NULL, NULL, '08061307116', NULL, NULL, NULL, 'd1h_7Wd4wExyktiQdpN_JP:APA91bH2RwPlnaCoFa0cIVA8mwTN8WCGV_tZ2M3DYikGiqWOz2OjEiSnbTogqtTBB0JUO2UGcWuW7WH5nH1KeE62op2811QHPfGPexvWTOu_oHWFoIQxPZe9dgn6t9xEo-w-ns-7V_u-', NULL, '$2y$12$Gaz1dFLQdDqV3oNgwjNFsOWeVfbV.sw3JEWqfFf47ivwlusiqHhsi', NULL, '2024-06-28 09:53:41', '2024-07-28 10:39:11', NULL, NULL, 1, '75588', '30', 'euniceogbeide71', 'JOPAYTECHLIMITE / EUNICE OGBEIDE', '8021116689', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '1995', '', NULL, NULL, NULL, '119Rs22', NULL, 'BVN', '22350344593', 'active', '667fecd5a9d3429714b91ca7', '985647', '667fecf0c54dd60024e7687a', 0),
(120, 'Kelvin ewanfoh', NULL, NULL, 'kelvinpolite5@gmail.com', NULL, NULL, '07026525472', NULL, NULL, NULL, NULL, NULL, '$2y$12$ljvG0SYpswPDuhTMhK.pEuBCPAo7lEBHvbvMpWGS2cv6NLob8kiNq', NULL, '2024-06-28 10:00:22', '2024-07-10 15:03:20', NULL, NULL, 1, '29316', '-250', 'kelvinpolite5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1991', '', NULL, NULL, NULL, '120VNVe', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(121, 'Njoku emeka  calvin', NULL, NULL, 'njokuemeka47@yahoo.com', NULL, NULL, '08069206543', NULL, NULL, NULL, NULL, NULL, '$2y$12$kOWfeAcNb7EtlMWhVbfqqO3WuvplbIDplEYDkwnLWeJtWm1Yksnye', NULL, '2024-06-28 11:04:11', '2024-06-28 11:12:24', NULL, NULL, 0, '54820', '-100', 'njokuemeka47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '121R9uC', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(125, 'Annette', NULL, NULL, 'annetteighodalo@icloud.com', NULL, NULL, '08158367121', NULL, NULL, NULL, NULL, NULL, '$2y$12$caoOSdy70rlDTs0xoltq7Oma./5OI0yO/8MIO2RiyQJIMw6CAj8UW', NULL, '2024-06-28 16:55:37', '2024-06-28 16:55:37', NULL, NULL, 0, '11994', '0', 'annetteighodalo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '125wf0x', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(126, 'Gaius', NULL, NULL, 'gaiusolsen@gmail.com', NULL, NULL, '08157787295', NULL, NULL, NULL, NULL, NULL, '$2y$12$9cjsSZwanfD9urEB9bXNn.A86FAakt8SPn7YZY9VQED8vmfRkNGu2', NULL, '2024-06-28 19:58:10', '2024-06-28 20:04:23', NULL, NULL, 1, '58120', '0', 'gaiusolsen', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '126qVJA', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(128, 'Idehen kenrich efeogbon', NULL, NULL, 'idehenefeogbonk@gmail.com', NULL, NULL, '09135666442', NULL, NULL, NULL, NULL, NULL, '$2y$12$K9B7eV/wzDI9svddWsyBLec9zuAlzQ7yE1aXrb6bEHKxD4BFrW52e', NULL, '2024-06-29 09:09:10', '2024-07-22 18:24:19', NULL, NULL, 1, '47910', '-600', 'idehenefeogbonk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5002', '', NULL, NULL, NULL, '128muEu', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(129, 'Onyekach jude emmanuel', NULL, NULL, 'oj246491@gmail.com', NULL, NULL, '08074363220', NULL, NULL, NULL, 'fHGhQ1maakF-k9SZ6WQ8nt:APA91bEvMmJGw5aPsSQZlsPLrIxoLxCrj2D4V-aJkpki6ms5RWunxi4GY65C4ziMQG1hQOzXwNvKf5vkv-NrSTzjhwSnFWCEVuf3zVnYJ-i0c7AXEzb82-aXtRSzsaWU0xI1lHAmTbDw', NULL, '$2y$12$p5HWcY9fr4aR.KUS3vvKneZqxYXQtuHLrrZeDs9SK4OT9TFqhfLkK', NULL, '2024-06-29 09:31:05', '2024-07-28 10:39:12', NULL, NULL, 1, '34318', '20', 'oj246491', 'JOPAYTECHLIMITE / ONYEKACHI EMMANUEL', '8025399020', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '6781', '', NULL, NULL, NULL, '129osVD', 'https://jopay.africa/storage/avatars/Sj4ql86Wd5JpEZD7LANxD7aNNdcX89iJ1JhEtxE3.jpg', 'BVN', '22511895568', 'active', '667fd4aca77836c802bc6316', '235312', '667fdd3cc54dd60024e22ad4', 0),
(130, 'Igbinedion efosa kelvin', NULL, NULL, 'johnharledrove@gmail.com', NULL, NULL, '08142599845', NULL, NULL, NULL, NULL, NULL, '$2y$12$SNjMMgAs7avUKOM27zi0w.fimXwudT1X6G1Ubu1O9RZABig3UsRie', NULL, '2024-06-29 10:39:28', '2024-06-29 10:55:40', NULL, NULL, 1, '75499', '0', 'johnharledrove', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4259', '', NULL, NULL, NULL, '1301iVI', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(131, 'Kenrich idehen', NULL, NULL, 'gallantese1@gmail.com', NULL, NULL, '08036329540', NULL, NULL, NULL, 'dr3EzYzTN0b9kqUZFn8NcI:APA91bEOUoyzV7AuSxCLzgafoW0Fvp1bqeQBnuBMJ6Ry4gOvXvHKHKdjOwYJi_0Me2ADeezYXaqvFE3u0dRU7SfA9VjGGNw5WVw_crlCB5F0z4j-PR-4GfOsqinC6yahhTpP1LtK1Ki7', NULL, '$2y$12$G/R8Uip9qUvhY6dBhE0L0ehe17sJXh6cF3AoKHTePGqOhtj1O/Zxu', NULL, '2024-06-30 08:23:28', '2024-07-22 18:14:49', NULL, NULL, 1, '32286', '-200', 'gallantese1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5002', '', NULL, NULL, NULL, '131HoS4', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(132, 'Tony egbon', NULL, NULL, 'nosasaturday11@gmail.com', NULL, NULL, '08073526110', NULL, NULL, NULL, 'dqRSKypZSyGjkQBxRhrW_T:APA91bFERF1wRlwRLSU371iYXJaVm3UKxFMuOy9mSZQ_V4iZYn684yI4UyjLc4sN6RkWdf0u2ht6Y2gijcWJ_JRc8Nqshq1E_JVVUgKhv7C2_i69ILdsDm1taHk_Zm20OS7yhX_lo5sJ', NULL, '$2y$12$ugg3kfWSWoyrlOfhlyYLq.BzRULnaD/hELvfdgXJZX7pLphUFtb5K', NULL, '2024-06-30 08:58:24', '2024-08-05 13:23:27', NULL, '46875', 0, '96350', '-100', 'nosasaturday11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6859', '', NULL, NULL, NULL, '132Nmc2', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(133, 'Ermelyn lumando', NULL, NULL, 'blena060893@gmail.com', NULL, NULL, '09771009436', NULL, NULL, NULL, NULL, NULL, '$2y$12$BzVw3WN9EWw5rG687TIWIuc4Z7rhPBrBP02bwusulQ.W6PVc8vJp2', NULL, '2024-07-01 15:42:50', '2024-07-01 15:47:49', NULL, NULL, 1, '27838', '0', 'blena060893', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1993', '', NULL, NULL, NULL, '133J4N1', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(134, 'Favour omorose', NULL, NULL, 'lucasmorgan4550267@gmail.com', NULL, NULL, '09056578949', NULL, NULL, NULL, NULL, NULL, '$2y$12$Q8VcrdZDWpl42G9maVepSepw6oktjjhMiD4K4vg3FdEWyamj/LFCK', NULL, '2024-07-03 03:38:03', '2024-07-03 05:11:08', NULL, NULL, 1, '60412', '-250', 'lucasmorgan4550267', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6644', '', NULL, NULL, NULL, '134pXjZ', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(136, 'Poweilatei samuel ebelo', NULL, NULL, 'ebelosamuel099@icloud.com', NULL, NULL, '09110456831', NULL, NULL, NULL, NULL, NULL, '$2y$12$OUEUvh51BjPRJ4mLOrpwBeIuEXzWp1tJe1nGSai0UdjjcCXyEqsTa', NULL, '2024-07-03 18:04:59', '2024-07-03 18:10:41', NULL, NULL, 1, '16745', '-150', 'ebelosamuel099', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0852', '', NULL, NULL, NULL, '136XEuz', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(137, 'Izevbizua', NULL, NULL, 'izevbizuaosadebamwen@gmail.com', NULL, NULL, '09031470207', NULL, NULL, NULL, NULL, NULL, '$2y$12$wOVXuhc3YPMNXXOfoLKmquqpeephZ05EZK2wIqwZWlV3CZmMQzLfK', NULL, '2024-07-03 18:15:00', '2024-07-03 18:16:03', NULL, NULL, 0, '99683', '-50', 'izevbizuaosadebamwen', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '137MlOh', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(138, 'Ogbeiwi evans', NULL, NULL, 'fredrickmoorehouse@outlook.com', NULL, NULL, '08163559416', NULL, NULL, NULL, 'd1hS2j06ektup0y704LgSy:APA91bGH97vFS6bpTdiLCszNXgkmBZ-CJkC5kYM1sKVKA7nCv8Q1xRXpdkhM5CTcE469-TmA0j3Uw_8LdELf8eZJ3WarPJIJOfr7O2h3bvObllb9ex4tcxi2aQUsCr-p9Y0--GQ0PKiI', NULL, '$2y$12$VvRRyWrQRSU7TrEB.bu.qefsTySy95B/PEF/9m14GLIZf/I/NL4yu', NULL, '2024-07-03 18:22:04', '2024-07-03 18:43:44', NULL, NULL, 0, '92177', '0', 'fredrickmoorehouse', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '138R3zz', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(139, 'Iyamu osarobo vincent', NULL, NULL, 'iyamuvincent104@gmail.com', NULL, NULL, '7040629107', NULL, NULL, NULL, 'cddTg2DBEE1MqaMsWboi7K:APA91bFHgPfrBQeDkU9kBgoRky4HkrGad0kVb52VoGY4sX5rWL39brLDBfRMApmjfc63FH7JUGQ3l2Xp-FoRTrQVe28Hva4pL031-FE1q2mEImGWMCQbfdD4EfmRIHL4KWYbi8nJDZEt', NULL, '$2y$12$ziT6AHuqz25kmIUHbuvRwurOvUtXuEwctdwDNrMC7qc4z6KEWE4I.', NULL, '2024-07-07 17:10:22', '2024-07-28 12:37:41', NULL, NULL, 1, '82748', '40', 'iyamuvincent104', 'JOPAYTECHLIMITE / OSAROBO IYAMU', '8027763205', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025', '', NULL, NULL, NULL, '139VsN5', NULL, 'BVN', '22222511122', 'active', '668ad53959bdd379fe9159d1', '706461', '668ad55a0cd6b50024995995', 0),
(140, 'Shalom osaigbovo osahenrumwen', NULL, NULL, 'shalomosaigbovo809@gmail.com', NULL, NULL, '09153556906', NULL, NULL, NULL, NULL, NULL, '$2y$12$Ynny4GyNOBUUB9oAIVDyuOBq8O2hT08iX4PU4vOKyc1HAGzY3K2oe', NULL, '2024-07-08 05:14:43', '2024-07-08 05:20:36', NULL, NULL, 1, '39818', '-100', 'shalomosaigbovo809', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1990', '', NULL, NULL, NULL, '14082PZ', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(141, 'Emwinyogho aisosa williams', NULL, NULL, 'emwinyoghoaisosawilliams@gmail.com', NULL, NULL, '0705281187', NULL, NULL, NULL, NULL, NULL, '$2y$12$qjE7EbZFqI4FjW0PZuHDeuvNQ/Xf7TZfxd/hu/dCjJWbma8RM/lXG', NULL, '2024-07-09 13:40:30', '2024-07-09 13:49:51', NULL, NULL, 1, '39830', '-150', 'emwinyoghoaisosawilliams', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '141x2yr', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(142, 'Godstime samson aimiehnior', NULL, NULL, 'aimiehniorgodstime@gmail.com', NULL, NULL, '08087162878', NULL, NULL, NULL, NULL, NULL, '$2y$12$g.ltRNr1KIAv.rqlRT53/.tzK4L1ZAk5Ij.3oXG86rZiT6gJxozSe', NULL, '2024-07-09 22:35:30', '2024-07-09 22:35:30', NULL, NULL, 0, '23736', '0', 'aimiehniorgodstime', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '142Nbe4', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(154, 'Ayomide samson', NULL, NULL, 'ayosamson266@gmail.com', NULL, NULL, '09122771813', NULL, NULL, NULL, 'eODFOCEiRlOcTrJ91jvNJj:APA91bELAxQlxDbzoQyIIsst3-a-cWXHtZBlY5A4oIHWLfNlHZezn4beH96MeprsodGKJKD6UdMYyTmAaRaOnLo7kLc5SgPE44tkaMJJcCp7GSCSkp9HzC2j8IAZP5cMXJc7XqBQ7yNT', NULL, '$2y$12$2N8VpRCuQ0SZMMCa3b4Gm.FTqpA.RFqYRxxjgOHt2a5gqh16N1Ibm', NULL, '2024-07-21 21:55:35', '2024-07-23 13:48:55', NULL, NULL, 1, '33680', '-300', 'ayosamson266', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1549', '', NULL, NULL, NULL, '154W1Sl', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(156, 'Queen wisdom', NULL, NULL, 'wisdomqueen525@gmail.com', NULL, NULL, '09164175628', NULL, NULL, NULL, 'cWakjWEJM0Y9gEi6GDLdTB:APA91bF8nTYMKRO23Vyl9VQO7tOulb4SN1tYY-S07eBbFE_TFywVJUII3vqWB3B_oZU_znVnltd4oNN0y86BWh8OU__pySl42BlF18JdFjz_OslTsqO-rPLwVumbYxmK3ZMGl5Shh5XL', NULL, '$2y$12$SUjYzFJvTcqE/zwqWsnwMueT0EAuXAEMUCj7kIr2XPvcLr59TTzc2', NULL, '2024-07-21 23:02:51', '2024-07-21 23:14:35', NULL, NULL, 1, '49610', '-100', 'wisdomqueen525', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5656', '', NULL, NULL, NULL, '156Ln1s', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(158, 'Banji idowu', NULL, NULL, 'richardking1294@gmail.com', NULL, NULL, '07030020011', NULL, NULL, NULL, 'erb74kqYSuKuoIm9d1_bev:APA91bEmse2hCrR3Gcbn3J4UmflUNJinAis62b9Wu7w9AMlSgby4PmofZR1ohnd4g3c7i7TUZD3bro6lx8GMdGGi4-wluiejE7-yHKfLFrPUTE2RJ4tWzat9gVw-m8duqYdz3mdj8Uf_', NULL, '$2y$12$DZ8Z3yAa9z47wg7ahPMpZudtvd319qaDI9JzIXGElhln0lioM4KEe', NULL, '2024-07-22 01:36:34', '2024-07-22 01:38:35', NULL, NULL, 1, '23391', '0', 'richardking1294', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2222', '', NULL, NULL, NULL, '158hxBD', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(160, 'Osagie promise oziegbe', NULL, NULL, 'comradepromiseroxy@gmail.com', NULL, NULL, '07053831630', NULL, NULL, NULL, NULL, NULL, '$2y$12$3XbUKC5a9cIIWxwBCuqKs.PvFGinbx9mdLD4St.WQ0u0BCgjLbby.', NULL, '2024-07-22 01:52:33', '2024-07-22 01:52:33', NULL, NULL, 0, '58397', '0', 'comradepromiseroxy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '160SWTB', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(162, 'Edogiawerie edoghogho happy', NULL, NULL, 'excelhandsome34@gmail.com', NULL, NULL, '09025724008', NULL, NULL, NULL, 'dfTAZK_RxkjesBGIxUlP0T:APA91bEgkskP_m1KRJglLIocEHKbXUqejtN4mZsGYOajwTH47BBm3X70UskN4mIN5BV4w6E1-1dR-9om8S-HiGr8fGoiYLt_sYVgOdYZ_mIKPILFeTtMy5YyYIASQtSgp-sLC15QSmCW', NULL, '$2y$12$4DTnchbwXiCraMjE149NvOcgYA5H3cdGbGsNlsEdz37LJ5HtCKYuC', NULL, '2024-07-22 03:25:21', '2024-07-24 07:02:52', NULL, NULL, 1, '52459', '-100', 'excelhandsome34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3519', '', NULL, NULL, NULL, '1626SW0', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(165, 'Nduka divinepsalms abuoma', NULL, NULL, 'divinenduka77@gmail.com', NULL, NULL, '09017078550', NULL, NULL, NULL, 'dG4nb2nXT2uMJ4tlhjVT0I:APA91bEVZLqAhOqdRUdD54HqsYt9H8GrtmCoeicG6x3etE7NSHjvBdZisXZumLfl_QKtafDCaclbJLnXeGYE1zimy16xgXpEo1o42VzszMuJ_7I7vLWz2Jp2xHnsvHxdDz0fFLE8XDFE', NULL, '$2y$12$UHgMvicFY98oxRrJ5yJpi.v.hSbf14.CWA6aVpiu7/u2CX1.stASq', NULL, '2024-07-22 05:04:54', '2024-07-28 10:39:13', NULL, NULL, 1, '21510', '130', 'divinenduka77', 'JOPAYTECHLIMITE / DIVINE NDUKA', '8029305869', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '0606', '', NULL, NULL, NULL, '165J8cc', 'https://jopay.africa/storage/avatars/V1FqLZdtC5lZmHuj5KfbAvQjsTjD38MpFsr6vCaW.jpg', 'BVN', '22671815954', 'active', '669de9cbd24273cf0afd5990', '044291', '669de9e58c7f9b00249a78f6', 0),
(167, 'Forteta bridget ibifubara', NULL, NULL, 'ibifubaraforteta@icloud.com', NULL, NULL, '09025696323', NULL, NULL, NULL, NULL, NULL, '$2y$12$HVEW2JthV1B3f35sRH5w6u.MkmwPYeOWEQDnhhlZFykFYnCgA/0VC', NULL, '2024-07-22 05:45:17', '2024-07-22 05:58:36', NULL, NULL, 1, '23650', '-200', 'ibifubaraforteta', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2001', '', NULL, NULL, NULL, '167Nynm', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(168, 'Hair by clara', NULL, NULL, 'adekunlejoy608@gmail.com', NULL, NULL, '09165656008', NULL, NULL, NULL, NULL, NULL, '$2y$12$4ogFbY2NCTC9KnZPGMT.eelgFDA59piwlCqOUaETq2uWcF9RnPgOa', NULL, '2024-07-22 07:43:15', '2024-07-22 07:47:43', NULL, NULL, 1, '90130', '0', 'adekunlejoy608', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2580', '', NULL, NULL, NULL, '168Q70D', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(169, 'Fabian idemudia ogbeifun', NULL, NULL, 'fabiandavid105@gmail.com', NULL, NULL, '07088402503', NULL, NULL, NULL, NULL, NULL, '$2y$12$I0sgwvX62moQW4twBK0cHuRXa4pkzIcwIb2Xi8qxk63sjbYbQ9one', NULL, '2024-07-22 07:50:50', '2024-07-22 08:22:03', NULL, NULL, 0, '72385', '-150', 'fabiandavid105', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '169Ciqb', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(170, 'Precious imhanriagbe', NULL, NULL, 'preciousimhanriagbe@gmail.com', NULL, NULL, '07058657965', NULL, NULL, NULL, 'eFZriVKYRRe-vwBaju-HJt:APA91bFOKjJooFiyLru67S6oAZ3J9I6R0FbVH5iOZ0xJHOaOqIXfHYrnfknygum4-PBHapBR445cLBNYIcZ6Ef3v9p4yHkRbapw8kPNq5moDx2pAkyC0f7o8mBT6Mpwt-haJcgaYmfbN', NULL, '$2y$12$9xs0EaFk40FzxUQGDgbBmOEc1/oUqESuHhnCf0vvHTK3bPpLe5imC', NULL, '2024-07-22 07:53:51', '2024-07-22 07:57:13', NULL, NULL, 1, '91375', '0', 'preciousimhanriagbe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5051', '', NULL, NULL, NULL, '170UJqP', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(171, 'Marvellous igberaese', NULL, NULL, 'marveldiamond@gmail.com', NULL, NULL, '07065346438', NULL, NULL, NULL, 'ezFIzINaT4WvwRl5xocW5o:APA91bE65H-ujZEysvWHkIR3bDXh_6xBG-rb5CpqJixNviYGhplKOj5xUAbZw6qZsc7lpK8cL5UGrIc4y5FV-FgrrtubQZpcT66kEqNYTDp2bQeldeTfqRBZ8uNfK3fnrx8Ls0WnDg-u', NULL, '$2y$12$5NNZuZCIxwCppXt4eqrXEOiaco.7cAazTDH1aeGlOMC0doNinv9zK', NULL, '2024-07-22 08:00:13', '2024-07-22 11:06:37', NULL, NULL, 1, '26985', '0', 'marveldiamond', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2009', '', NULL, NULL, NULL, '171HOlp', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(172, 'Annabel chinasa atuma', NULL, NULL, 'atumaannabel1@gmail.com', NULL, NULL, '07062994281', NULL, NULL, NULL, NULL, NULL, '$2y$12$rPAiJ1hf5M1tVyJJLMFD9OSF0E.dEZiJNSpPQvsomnDyDWE1/Tz8i', NULL, '2024-07-22 08:12:46', '2024-07-22 08:12:47', NULL, NULL, 0, '97287', '0', 'atumaannabel1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '172tJdg', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(173, 'Osaghae maris', NULL, NULL, 'osaghaemaris22@gmail.com', NULL, NULL, '08055524822', NULL, NULL, NULL, NULL, NULL, '$2y$12$TZRba7lu.ceO/iruPsNs8OBgvBg/Jc2aevrL7nxF5Dmk0wECJjIOi', NULL, '2024-07-22 09:16:19', '2024-07-22 09:16:20', NULL, NULL, 0, '97948', '0', 'osaghaemaris22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '173szrQ', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(177, 'Ose empire', NULL, NULL, 'bmhiz9895@gmail.com', NULL, NULL, '915 905 4351‬', NULL, NULL, NULL, 'eY3RY-z0K0KHlENzCTzG81:APA91bHNfPuI34KBNC9GvNLPlsVsIl7q63Lu1ie6UWdOs5KOLWjyuo3k5WO_UHIXwN0QEeEugxvVzsDUG4U2mEFYvsUCi1bm34Ro13-kNC9uq4zo6VDSiDzvj2SQHFOfKc0SICOmIrU4', NULL, '$2y$12$l4VGBCG.E/Cvvqibwl3bBedCPiceM2wUOsbvVnavntQK9gevvgu6O', NULL, '2024-07-22 10:28:46', '2024-07-22 11:17:12', NULL, '86107', 0, '52264', '0', 'bmhiz9895', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2424', '', NULL, NULL, NULL, '177lkOG', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(178, 'Idowu olaitan jewoola', NULL, NULL, 'jewoolaolaitan@gmail.com', NULL, NULL, '08139294988', NULL, NULL, NULL, 'e5yV8PXLSQegw-sysiCtZf:APA91bF1IBZNwn21Ej2dHGhG5CU-LGy8wZdWuMQE_x6eD5wfY-t8lY7FeUlMS0Zq09OFhPuydVe11ul3DbGAGBPh6vj5joIZ1AtyMKaidsU52pnuo3Swbq3rYw5dlOm1DQqxHJQ4oZez', NULL, '$2y$12$x3KqiPqMMXW.mgZxHNBXa.1BCAWFvKWJk36yd9BVwKPPu97xjBZeu', NULL, '2024-07-22 11:06:34', '2024-07-28 10:39:13', NULL, NULL, 1, '89600', '0', 'jewoolaolaitan', 'JOPAYTECHLIMITE / IDOWU JEWOOLA', '8022765967', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '1930', '', NULL, NULL, NULL, '178N797', 'https://jopay.africa/storage/avatars/g9mh99GLnOhCY2RvxC7ogLBifFVpEiEdG4NkBNXY.jpg', 'BVN', '22425144110', 'active', '669e3ed981e8fdf2a3fa1781', '614394', '669e3f01c15146002428b8e8', 0),
(179, 'Richard enaiho osose', NULL, NULL, 'finances4richard@gmail.com', NULL, NULL, '08166485552', NULL, NULL, NULL, NULL, NULL, '$2y$12$tequv9TkHuISyajZKeGp8eTN9a0iyLfsqbGJ2YkP.wLF/wMv.eruW', NULL, '2024-07-22 11:15:58', '2024-07-22 11:23:34', NULL, NULL, 1, '48027', '-200', 'finances4richard', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0219', '', NULL, NULL, NULL, '179tAC5', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(180, 'Victor mide', NULL, NULL, 'wscrib384@gmail.com', NULL, NULL, '08149931235', NULL, NULL, NULL, 'caTDlJL-RByAnWG3OpOaVl:APA91bFxjSJ5zddSfuzmyHqTeK4g9F8l4IwfWAKY68mNbBjc1V12kAHGXP__wWQfmtT_GSPzzFVoLkhBjyeP8gg35JF2g9hb_dYhN9-RILctVx3-dOqLyYYNd1A6b76S95S5y3GAwEE5', NULL, '$2y$12$75Jxo0TNdC1rpkH03Yct9uBbftd62pAsDx6S9IaoHSu1RFse.tGkC', NULL, '2024-07-22 11:59:49', '2024-07-22 12:07:58', NULL, NULL, 1, '29398', '0', 'wscrib384', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2121', '', NULL, NULL, NULL, '180brVT', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(182, 'Edomaroiro  efe', NULL, NULL, 'godwinsonia76@gmail.com', NULL, NULL, '08108659959', NULL, NULL, NULL, NULL, NULL, '$2y$12$OChe5UAA2haBrpqko/lhb.OIYCeqX.BHPCi8UKb7RuhyDfY6sgJ..', NULL, '2024-07-22 13:42:08', '2024-07-22 13:42:08', NULL, NULL, 0, '78861', '0', 'godwinsonia76', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '182WvJQ', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(183, 'Oside victory', NULL, NULL, 'osidevictory@gmail.com', NULL, NULL, '09076710219', NULL, NULL, NULL, 'cWxGluzxTE-Ji7iTUWp8H7:APA91bGWqpZttXWwgqEO43GeWGnwUgKcCFaLv7lWoTbTvcq72O3qBYN3kAXrkVg7IX-C3NLqA9VPpmd5qy3oM9PHu_jkBkIuQ3oyeQRvpqBPfx1hBfUXEy4dGplX-0tVX4RX3p8gopw6', NULL, '$2y$12$5QLcYcvD5w2AJvKpHZaTiuY/tIFHIoflgB7mYkSSw7iPJ8FzDnikK', NULL, '2024-07-22 14:21:50', '2024-07-23 13:32:44', NULL, NULL, 0, '54502', '-300', 'osidevictory', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '18363OA', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(187, 'Luckyosadiaye', NULL, NULL, 'worldluckino@gmail.com', NULL, NULL, '7059311636', NULL, NULL, NULL, NULL, NULL, '$2y$12$Q8CrIyZh1GVByodUDCuj/.G6J.Fc6gyusU3uUaqnkzRwjerfy4QpK', NULL, '2024-07-22 15:11:14', '2024-07-22 16:11:51', NULL, NULL, 0, '81042', '-100', 'worldluckino', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '187eZVj', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(188, 'Damilola joseph', NULL, NULL, 'dammygee491@gmail.com', NULL, NULL, '08132901640', NULL, NULL, NULL, NULL, NULL, '$2y$12$CMoMg2jNQtUEYOI30qfxZ.i.nVsEObLMzUPn3QVomug7Df2TkhB0.', NULL, '2024-07-22 15:15:24', '2024-07-22 15:15:41', NULL, NULL, 0, '94390', '-50', 'dammygee491', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '188CpKg', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(190, 'Collins somtochukwu ihuoma', NULL, NULL, 'linsihuoma01@gmail.com', NULL, NULL, '09039609386', NULL, NULL, NULL, NULL, NULL, '$2y$12$zmE4pzDPqr80bcRz0Rgt4uPlOm7fkBNDFQsI/bRVj.rv6DmEoCPra', NULL, '2024-07-22 15:45:52', '2024-07-22 15:50:55', NULL, NULL, 1, '17332', '0', 'linsihuoma01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1820', '', NULL, NULL, NULL, '1900b4i', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(191, 'Yovwin beauty erhuvwu', NULL, NULL, 'yovwinbeauty134@gmail.com', NULL, NULL, '09165627806', NULL, NULL, NULL, NULL, NULL, '$2y$12$8asuK3svpmhG93j8s2u/5ufQR2UDk2IzyamHYsjPA9sMH.bpF/AA.', NULL, '2024-07-22 15:54:00', '2024-07-22 16:00:52', NULL, NULL, 0, '76273', '-50', 'yovwinbeauty134', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '191kxoh', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(192, 'Sunday loveth efe', NULL, NULL, 'sloveth457@gmail.com', NULL, NULL, '8141605898', NULL, NULL, NULL, NULL, NULL, '$2y$12$LwejWvgVsctn5I5H3Al0b.EA0uUfxHkc1SiaQUjpqwvaO5xK9G9SS', NULL, '2024-07-22 15:59:57', '2024-07-28 10:39:14', NULL, NULL, 1, '38590', '0', 'sloveth457', 'JOPAYTECHLIMITE / LOVETH SUNDAY', '8026525143', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '3636', '', NULL, NULL, NULL, '1923YMx', NULL, 'BVN', '22597140912', 'active', '669e82a1aa7164fdaf0ccbcd', '161165', '669e82deb19e4d00246cdaee', 0),
(193, 'Shadrack okaniba', NULL, NULL, 'shadrackcocoty@gmail.com', NULL, NULL, '08136040601', NULL, NULL, NULL, NULL, NULL, '$2y$12$Rbla5MGvMfpbLbsb/J0UGeIgXMegQjN7e0.e3gLbT.BDga3zCzYwy', NULL, '2024-07-22 16:00:35', '2024-07-22 16:06:40', NULL, NULL, 1, '58819', '0', 'shadrackcocoty', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0813', '', NULL, NULL, NULL, '1932EFV', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(194, 'Joseph okoro', NULL, NULL, 'josephgeorge1914@gmail.com', NULL, NULL, '08024192044', NULL, NULL, NULL, NULL, NULL, '$2y$12$OHHHiWerSJApfDzICJSAsOcR.Liv23YMlMFcwOu9/QdH7Oooieyou', NULL, '2024-07-22 16:36:03', '2024-07-22 16:41:46', NULL, NULL, 1, '36077', '0', 'josephgeorge1914', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000', '', NULL, NULL, NULL, '194hpnt', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(196, 'Success vincent ogedegbe', NULL, NULL, 'itzsuccessvincent@gmail.com', NULL, NULL, '07049560417', NULL, NULL, NULL, NULL, NULL, '$2y$12$eRqUcaLJHTswdE0eCvAXWOXCOM1TNbX0rQoe6BMZkSpGetOS.iHSG', NULL, '2024-07-22 17:02:16', '2024-07-22 17:04:10', NULL, NULL, 0, '22158', '-50', 'itzsuccessvincent', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '196wb3u', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(201, 'Onyeka desmond rex', NULL, NULL, 'kimthompson2020@gmail.com', NULL, NULL, '09131888971', NULL, NULL, NULL, NULL, NULL, '$2y$12$oD3yHz0MCHrKzQ.DBY56suPPho1ludWU4QBZhzbkBv6JfwfMI0dGq', NULL, '2024-07-22 22:18:21', '2024-07-23 07:07:53', NULL, NULL, 1, '72853', '0', 'kimthompson2020', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5050', '', NULL, NULL, NULL, '201RAMR', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(202, 'Oluwakemi omotosho', NULL, NULL, '247olamiposi@gmail.com', NULL, NULL, '07038601898', NULL, NULL, NULL, 'e-1AizyzSzaxT3sf0g1drq:APA91bEoD1kAwftCiMRB-1sl7t8CDZIUbp9ZphufCdHKX0lxGE2zS3EPXLFZovTyzrFFRfgPkb8Vn-59Lb-GI9xmjY0esA74_RNd8urzyuWijtRM4kRI8e0832DwO5VOO88Maopn9l1r', NULL, '$2y$12$X9xMM2nv7l/eIK5RWBMAE.4Jw.D/.572WKScNNdZLChO5Vv7Dmgg2', NULL, '2024-07-22 23:21:01', '2024-07-23 08:33:56', NULL, NULL, 0, '99194', '-100', '247olamiposi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '202kTTU', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(205, 'Idemudia emmanuel', NULL, NULL, 'managementlawyer12@gmail.com', NULL, NULL, '2349165734977', NULL, NULL, NULL, NULL, NULL, '$2y$12$WStNMiHuvlQ8ZzcjamgA8OlXbKpvy2/AxcAKXrJa.U0GINNl9jCve', NULL, '2024-07-23 04:16:13', '2024-07-23 04:16:13', NULL, NULL, 0, '65681', '0', 'managementlawyer12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '205VWB8', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(206, 'Marvellous akudike', NULL, NULL, 'bigkay24710@gmail.com', NULL, NULL, '07048798519', NULL, NULL, NULL, NULL, NULL, '$2y$12$n096P/IdSnwOJuiSB1544eiR4KbH8OaZCkcMixMCKL5y/Bfwoyyfe', NULL, '2024-07-23 04:41:21', '2024-07-23 04:47:04', NULL, NULL, 1, '38753', '-200', 'bigkay24710', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2233', '', NULL, NULL, NULL, '206KFO9', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(209, 'Gift', NULL, NULL, 'aigbuzagift@gmail.com', NULL, NULL, '09061398697', NULL, NULL, NULL, NULL, NULL, '$2y$12$Edq2MDI0/5KxhPkCXoDbsOhAT6FS9NOymAJ5q4rln2G3COCtoJGdq', NULL, '2024-07-23 09:53:28', '2024-07-23 09:53:28', NULL, NULL, 0, '70496', '0', 'aigbuzagift', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '209vux2', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(213, 'Aiza d jaranilla', NULL, NULL, 'doquilaizing@gmail.com', NULL, NULL, '09266542550', NULL, NULL, NULL, NULL, NULL, '$2y$12$RccO1sHIB/1hvEVgZMJzceAkdg8ysa.hYL1xoNEiAy8u3zASLnI96', NULL, '2024-07-23 15:32:33', '2024-07-23 15:32:33', NULL, NULL, 0, '74079', '0', 'doquilaizing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '213LeWU', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(217, 'Usiosefe gaius ero', NULL, NULL, 'gaiusero0@gmail.com', NULL, NULL, '07048413709', NULL, NULL, NULL, 'fKUtbf5vSLCA7nAyILI9bT:APA91bFf-yy2K4PoZT1uA82RaYW3voL5myOG-0bwuIYyUSLoAiCBl_ROf6q5yvRUg0TJzoeQpNsn4UZ2n_R7-blucbJh5ydMJh8_qfOabxbAYzq3PEZOneXt10i1dXlIwyuK6F7Z3T7D', NULL, '$2y$12$ZIE0HEHgHaB4OnBIjW8am.Oh1M6p1QMw/P3vjZ2a351bhxyyFSpCy', NULL, '2024-07-23 19:08:59', '2024-07-23 19:15:13', NULL, NULL, 1, '41741', '-50', 'gaiusero0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1930', '', NULL, NULL, NULL, '217qYoo', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(218, 'DESTINY OSEMWENGIE', 'DESTINY ', ' OSEMWENGIE', 'destiny449283@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$B3DdDX61m4ZGNUqLXqOxh.8lBRJKXg/.rEWqOrinD3k8Is3h2s5Ce', NULL, NULL, '2024-07-28 12:29:15', NULL, '80680', 1, NULL, '48965', 'destiny449283j', '\r\nJOPAYTECHLIMITE / DESTINY OSEMWENGIE', '8029581674', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '7345', NULL, NULL, NULL, NULL, '217qYoopp', NULL, NULL, NULL, '0', NULL, NULL, '667edcdf300fb100243254fc', 0),
(220, 'Orobosa iyare', NULL, NULL, 'aikoriegielimited@gmail.com', NULL, NULL, '08036339418', NULL, NULL, NULL, 'c_zWQ4szT62mZYBnkhpUR9:APA91bFhCo6v5Nog3nD-Oim51oxlP3ORpM1TnaVa58ulUZVDf5EkDuXjreKIwpsRPWzin5IIaRjqm6Br2Lv6sG0ooK5RdhngsGJGV6wPjZbc96e8irTjlbJPAiPVA92puIWLkRAb0IiU', NULL, '$2y$12$re3BIXbRFRXY5b5vOmsOBu2S1WkjxBp5majnP/3I6YUtcM8CYKhr.', NULL, '2024-07-23 20:54:17', '2024-07-28 13:02:40', NULL, NULL, 1, '75457', '315', 'aikoriegielimited', 'JOPAYTECHLIMITE / OROBOSA IYARE', '8028163448', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '1981', '', NULL, NULL, NULL, '220VckO', NULL, 'BVN', '22264406833', 'active', '66a01962f365ad6ae279f30c', '586230', '66a01987c2bfd50024566f43', 0);
INSERT INTO `users` (`id`, `name`, `firstname`, `lastname`, `email`, `state`, `lga`, `phone`, `bank_name`, `bank_account_no`, `bank_account_name`, `device_token`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `address`, `pass_token`, `email_verified`, `email_code`, `wallet_ngn`, `username`, `acct_name`, `acct_no`, `acct_status`, `acct_customer_id`, `acct_email`, `acct_phone`, `dod`, `nin`, `wema_tracking_id`, `pin`, `pin_token`, `ps_cus_code`, `ps_cus_id`, `biometric`, `referral_code`, `avatar`, `verification_type`, `verification_number`, `verification_status`, `sh_id_no`, `verification_otp`, `sub_acct_id`, `has_pin`) VALUES
(221, 'Okunbor omoviye blessing', NULL, NULL, 'okunboromoviye@gmail.com', NULL, NULL, '08084079826', NULL, NULL, NULL, 'e57mxlBDUUZgijdJo3C2Uk:APA91bHXVZm74JBrTODJK2XTrhGlHP-Z9aol5GRMf3Dvo-6jNwismlNiGVWI8sWI_QpgIyMzcuPhcYLVgLaL6nh1_YyBPdKCP8Jjzuj5mmSKFsCGYglv_QBFropuSzOC680JbNMD3viu', NULL, '$2y$12$4qVbh7T5TFZSfPKi2/gedOlB/AUzjDzea3ObCuWE4eZz8xKchd75i', NULL, '2024-07-23 22:54:54', '2024-07-24 06:53:24', NULL, NULL, 0, '45993', '-150', 'okunboromoviye', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0704', '', NULL, NULL, NULL, '2215xXx', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(226, 'Amadasun christian osarumen', NULL, NULL, 'tjmiller5250@gmail.com', NULL, NULL, '09032602322', NULL, NULL, NULL, 'fDm2Nlb0QLatMHflxZ2jyt:APA91bFvZwBX035h_Sq6hz5oPhPVyl4K8uh4MfgsHd_z2wGl5XDdY1NmQqlzhaqx23m_z3nSx8PTU8Avz7Ztp2cN1XDKJcPJ0OAaLJxxnoIJlDMRlEBDrXT9vmvPhgJUJcsOKRbsP3Vh', NULL, '$2y$12$WVKPMTb2tssZCigG5bafa.CBZeBCzZ4fkufq3XNZspxwXJnfZLT3G', NULL, '2024-07-24 04:15:15', '2024-07-27 12:57:23', NULL, NULL, 1, '72823', '0', 'tjmiller5250', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1357', '', NULL, NULL, NULL, '226AbBV', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(230, 'Ugomaduefule caleb', NULL, NULL, 'spunkyspunk7@gmail.com', NULL, NULL, '08118627869', NULL, NULL, NULL, 'dfTVNn_n00C7lj_Kz7fJ7Q:APA91bG8T-ApeIxYVhYKRdUyJd82GGy3dtAWpW4IaneLeRRcDw0Ju0stVsv3sb3M-Pnm2aQkiZgmNSV6CfmoeXvQbg104arMovq82MuO5gqhH1e1FmuocXdDXf2xk2gOe2AQGT26_TMb', NULL, '$2y$12$2nuQTG6CiJhEwbkWwmNEA.Thqqv4sV8COU5luM5ylCfYEbnEn4MAm', NULL, '2024-07-24 07:18:44', '2024-07-24 07:42:24', NULL, NULL, 1, '50484', '-100', 'spunkyspunk7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2004', '', NULL, NULL, NULL, '230vpW5', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(231, 'Ogbeche janet e', NULL, NULL, 'janetogbeche35@gmail.com', NULL, NULL, '07025108871', NULL, NULL, NULL, 'c_WR5NzWh04hqUwu0AlIKL:APA91bEJrwPGJEgvdSFcH8sTy4GGwOcxi-zzF-G4tzMUGWyGt2bU0YTev1TVomtachFDTKAXIyB2cuHXyWmoTMMlpXwC6qK2XT8u1EeKJtpwfPAEZZZUkMoDnubybVpCRCdK80uJzbYA', NULL, '$2y$12$lMQOhjAX0ooeNR3lf3LSA.QygvZRTyBaPEZuSzrqtflD8WYkkHhn6', NULL, '2024-07-24 07:28:21', '2024-07-25 06:24:10', NULL, NULL, 1, '53063', '-150', 'janetogbeche35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1995', '', NULL, NULL, NULL, '23170cS', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(232, 'Destiny osewmengie', NULL, NULL, 'terrybankz955@gmail.com', NULL, NULL, '09075347646', NULL, NULL, NULL, 'c1zu_Uv6b03YmL-qZNbVR9:APA91bFfo_tGIoymLKWYlYS4IgO_ymkXf-L7YuCfPWOPpA9rRVa_1lJQTyfjfy9NhZhndVD_19fnCrlRbVrLIemGJaAuLPN26q0IsyWisjeB9lmKsln2HZzQqQ-dD1pq5z1dCYFtGHd_', NULL, '$2y$12$49Xg8Fyj9ZcIuuYYg2r5su5BqfqRJGEPbUPXrJVyvJshYNgj.9acq', NULL, '2024-07-24 07:41:17', '2024-07-28 13:11:04', NULL, '25983', 1, '77901', '11700', 'terrybankz955', 'JOPAYTECHLIMITE / DESTINY OSEMWENGIE', '8027958852', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '7388', '', NULL, NULL, NULL, '232eBN2', NULL, 'BVN', '22631861270', 'active', '666adad37d4fd8de11470a8b', '190286', '66a0b1a0c5c1c700242548f7', 0),
(245, 'Joel okwoli', NULL, NULL, 'okwolijoel21@gmail.com', NULL, NULL, '08133983846', NULL, NULL, NULL, NULL, NULL, '$2y$12$UutP.JkTR0Z/p76BL6mb2eV1FzrugCPrKFNT3f5UGns0V.TG3Kz/C', NULL, '2024-07-25 10:22:10', '2024-07-28 12:24:34', NULL, '33182', 1, '25888', '80', 'okwolijoel21', 'JOPAYTECHLIMITE / JOEL OKWOLI', '8022855578', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '1122', '', NULL, NULL, NULL, '245dEja', NULL, 'BVN', '22288742573', 'active', '66a2278de366a7c754fb754d', '118245', '66a22d5ca0ae0900253179cb', 0),
(246, 'Joshua sani', NULL, NULL, 'sanijoshua234@gmail.com', NULL, NULL, '09030992945', NULL, NULL, NULL, 'fyC93XQBShOLO0OqqCtM7g:APA91bGK_yYUXe3oqOqDOk6xgSLmtzd8fxW3YE3yGGgXffLgTumhgDHYkrv1urMytb-K9Ez1h4iiuaF_wNS7PGxmDcUsdppFqRSjwqQVNqkrO7dKKyjdoAq7TUh1uZ35zOD2dXXht84c', NULL, '$2y$12$P3HeThnKiAxAMbg0qWrYQeW6q66Oe8RcizDsLXuE3hv/HMZ5NehF2', NULL, '2024-07-25 10:58:25', '2024-07-25 13:31:49', NULL, NULL, 0, '85214', '-100', 'sanijoshua234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '246sHJT', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(248, 'John oludare tonade', NULL, NULL, 'tonadeoludare213@gmail.com', NULL, NULL, '09151387972', NULL, NULL, NULL, 'ekoiKukoTzqTaUisbOvk1V:APA91bE1CcJC21F4nxJx7B8j2QCjM9VNRs7nJF42cObGzpmb0aOLTcUMu7X1t2N-5EDYGycusPdHSdp-AYYOcpVaSn2x8AhTeFNGo4hrUttVR5kMfqrbvJ87I5Wdi1hGPqHjYhKgnorb', NULL, '$2y$12$t2D6AANKKrzliv/HYpqXWe1SadnZevDy8tjUvzPHWNyXoGhpx2XLO', NULL, '2024-07-25 12:52:25', '2024-07-27 10:23:54', NULL, NULL, 1, '90790', '-250', 'tonadeoludare213', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2222', '', NULL, NULL, NULL, '248Dsgw', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(249, 'John oludare tonade', NULL, NULL, 'angelinacolemill@gmail.com', NULL, NULL, '09046114146', NULL, NULL, NULL, NULL, NULL, '$2y$12$lj0f2vVHlm3X/JTDnQSjrerRC3Yjbmz9e24Ggh2OOPXSzRJVjQWAe', NULL, '2024-07-25 12:56:35', '2024-07-25 12:56:52', NULL, NULL, 0, '58058', '-50', 'angelinacolemill', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '249aaAj', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(250, 'Ikponmwosa osazuwa thomas', NULL, NULL, 'ikponmwosaosazuwa1@gmail.com', NULL, NULL, '09133044697', NULL, NULL, NULL, 'e1LliyeHTVSUV4Vy0tNEFg:APA91bHJn3BQfNjCXXkY0ApuvwzQW52VHjbpPgOEONCv7r94siilFslFxxUczUXqxmbLPVQAFp6Rvq43Yp8-sq6GFRyBF7ulvKUNGRZ3XYc7diShE0Bge7wZO8S8Xj71cKOySkM3F2OD', NULL, '$2y$12$fIWFXBSOfux35pSCUorfdue2rzo5pClBXvPT0oWjmmBqUbHB2eagO', NULL, '2024-07-25 13:55:17', '2024-07-28 10:39:16', NULL, NULL, 1, '52967', '0', 'ikponmwosaosazuwa1', 'JOPAYTECHLIMITE / OSAZUWA IKPONMWOSA', '8020177784', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '1759', '', NULL, NULL, NULL, '250RIJN', NULL, 'BVN', '22266827924', 'active', '66a2598b59922b075106c258', '714068', '66a259ac23cc610024de609d', 0),
(262, 'Charles samuel', NULL, NULL, 'marypowell4190@gmail.com', NULL, NULL, '09029650449', NULL, NULL, NULL, 'cmBv1ZFWQJi3olILsIooRK:APA91bGWXqo1sQ64WRlmI4OWUM_279D2B9ualFhRA5ZHY4y45wY0WUGk3i7pDNywkazvZiIOMpynGCsqj4MSWtCM1qU0FWj4DC3iGkceGsxXZQYWCCfVXJzR1jQ0j3kV_DmQ2x3Rsztw', NULL, '$2y$12$vqGH.a43ET/Llz0CVrCv1uLiisSIzGUxBPkS3f41niM6mwiEL.p/K', NULL, '2024-07-27 09:40:38', '2024-07-27 15:17:00', NULL, NULL, 1, '28704', '-200', 'marypowell4190', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2222', '', NULL, NULL, NULL, '262Rg0G', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(263, 'Ademola ayobami', NULL, NULL, 'dorothyaria98@gmail.com', NULL, NULL, '08163384817', NULL, NULL, NULL, 'cJHC6CG_RBO4vkawTIWjfi:APA91bEvamGGYm8VKcrX52rWmj_pHWtHAka8MRmIQS2RgPd-FTZ9J1rjag2nxY_HIwRAEQznoF8G6atSI9ozHWxRO5-41FQ0NPDZeqAkTr2DyQ6UQpXnxwmC9Faz00wOrA_oHw94P0Dh', NULL, '$2y$12$EpOLUuHRy5eZZ75UwE2f1Oldt3gfHBIMX.1/PVWfKZ36zfw/CCvnG', NULL, '2024-07-27 10:17:36', '2024-07-28 10:39:16', NULL, '98179', 1, '36733', '0', 'dorothyaria98', 'JOPAYTECHLIMITE / ADEMOLA OLADIPUPO', '8022992444', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2222', '8059', NULL, NULL, NULL, '2636PUE', NULL, 'BVN', '22446236304', 'active', '66a4c9a9bf765f5fec86dacf', '625089', '66a4c9d40afd1f0024b0fca8', 0),
(264, 'Ochui princewill patrick', NULL, NULL, 'ochuiprincewill411@gmail.com', NULL, NULL, '07037269314', NULL, NULL, NULL, 'fKufZmMATzmrXbCz5494fJ:APA91bHJjvecU6_BkByLu9CEHrQKmUbpTlqmxxoBQLe9-z-CHxp6SitE-AbspzntjC0sHAXuGbseLnTXjzw7VJkoLLi_0-lkM6Fas0FEsJKWEGpEE1YHo_wcn2Bl9ntdBQNEcydp9MjC', NULL, '$2y$12$B8yklosgVOLpncUa5FlQ7uboyNrk1qWd5QThbo/x2DuchpN58r0gS', NULL, '2024-07-27 10:30:50', '2024-08-03 18:54:54', NULL, NULL, 1, '24961', '30', 'ochuiprincewill411', 'JOPAYTECHLIMITE / PRINCEWILL OCHUI', '8021003970', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '5555', '4882', NULL, NULL, NULL, '264QwxW', NULL, 'BVN', '22358826369', 'active', '66a4ccf3701aa6f5bac247d8', '434412', '66a4cd1d0afd1f0024b2414a', 0),
(265, 'Adesola taiwo adeniji', NULL, NULL, 'jhonpowell804@gmail.com', NULL, NULL, '08146422869', NULL, NULL, NULL, 'ffvZhkD5RgWXkFC1R_KZef:APA91bFsfrpwCEzaByb8qupsWuikTdmtVwGorlWrHYUEPfpCpIyjku6Iu3vADvcuFWzdJAK_-Lvv40b9lZ11QshsgayihC30gScb9tXTBJanfrUBdan-lbVYQb-tr3vGGnsYUVrSrYWv', NULL, '$2y$12$1pbjm/S3t5tqTlOlPzl5Se58hMeSX1AYlUpe7W7EBBYm1lT00k6zq', NULL, '2024-07-27 11:12:43', '2024-07-28 10:39:17', NULL, NULL, 1, '75111', '0', 'jhonpowell804', 'JOPAYTECHLIMITE / TAIWO ADESOLA', '8024296184', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2222', '', NULL, NULL, NULL, '2658oDy', NULL, 'BVN', '22389992088', 'active', '66a4d6b673f1041fe87d2706', '198776', '66a4d6c9f2c7690024297e4e', 0),
(266, 'Anointing wayne amasihohu', NULL, NULL, 'amasihohuanointing@gmail.com', NULL, NULL, '08135973592', NULL, NULL, NULL, NULL, NULL, '$2y$12$aVIJgf8STZkeSNNshMpM8.yhIg1oxeW.5W7WM5w/QajYGirAIX1gW', NULL, '2024-07-27 12:11:35', '2024-07-27 12:12:32', NULL, NULL, 0, '22375', '-50', 'amasihohuanointing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '266fSYY', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(267, 'Adeniyi seyi', NULL, NULL, 'ojobelumi@gmail.com', NULL, NULL, '08142212273', NULL, NULL, NULL, NULL, NULL, '$2y$12$2hnkFcWhlh6RHtOY/6wBo.cNMTLUnjt6q4Fo6xM8Qe8MDRaaRADKG', NULL, '2024-07-27 12:32:44', '2024-07-28 10:39:18', NULL, NULL, 1, '15084', '0', 'ojobelumi', 'JOPAYTECHLIMITE / SEYI ADENIYI', '8021837588', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2222', '', NULL, NULL, NULL, '267ERfW', NULL, 'BVN', '22744145311', 'active', '66a4e967d8344ee81c0cf62b', '541643', '66a4e9c0f2c7690024303cdb', 0),
(268, 'Adewale abiodun', NULL, NULL, 'wrichy131@gmail.com', NULL, NULL, '08109977493', NULL, NULL, NULL, 'fX467PB5QVOaR9JlpGu3L7:APA91bHfiRGhSRbpFl04oUQrNkFlXntxFsMuxCZAoawKRoCIU1zHjxCsWHd0UqyyiXgNxML91Ht062eoqd1hz3QayxjVQppQpWvN2CszIIr9yK0Ar-WQvSW7e-g0hvj9rTXkTJmcqNix', NULL, '$2y$12$1EoJuFyNQ1NR6.5TTkvGP.e8irIjaCd.AtqKPPaME8.YAUtiI3.RS', NULL, '2024-07-27 14:37:41', '2024-07-28 10:39:18', NULL, NULL, 1, '57577', '0', 'wrichy131', 'JOPAYTECHLIMITE / PELUMI ABIODUN', '8025706413', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2239', '', NULL, NULL, NULL, '268AMyG', NULL, 'BVN', '22378862156', 'active', '66a5067d60c5bc5c75aa5d47', '673285', '66a506ad7cc1640024cbe16a', 0),
(269, 'Ojo', NULL, NULL, 'mummuman9@gmail.com', NULL, NULL, '08131175006', NULL, NULL, NULL, 'fSykKuRBR9e0cCPwWn_T4k:APA91bFQQkwXRqfa6vFq4gwUqIavi-A7WOagFm-J0NUIcahEBNScgjqO2b_RWroMvg2UQdvPc0BlWK_yZzdxqmYF6voFZTie1zyYYTIHh8tKPs6sP1YowA-H9BazumJ5BQwVCg4z7ViU', NULL, '$2y$12$Hq/LTAraIoaQPPX29W5jpeJydWT7z5gNquaaoU7n0l4BItDw0gg8C', NULL, '2024-07-27 19:06:21', '2024-07-27 19:16:28', NULL, NULL, 0, '12267', '0', 'mummuman9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2222', '', NULL, NULL, NULL, '269MkpZ', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(270, 'Moore moore', NULL, NULL, 'whytrendin@gmail.com', NULL, NULL, '09063243284', NULL, NULL, NULL, NULL, NULL, '$2y$12$db9HEUY3AR4U5Etp0nejx.hMbUZiM8R40SwpSIe8p5hY3gzcbQBuG', NULL, '2024-07-27 22:28:55', '2024-07-27 22:34:02', NULL, NULL, 1, '56402', '0', 'whytrendin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '270yDrM', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(271, 'Opeadura ajayi', NULL, NULL, 'boluwaduroolaoluwa@gmail.com', NULL, NULL, '07065365036', NULL, NULL, NULL, 'fHePcAuTQzepGc0EsQPg9-:APA91bHwC2qAJx1zxhEjjuKfLAgmy298vfkYUMhz2ovWG6C52cone6f7i6JkUzEkh6gWaIPGFRk1r2MqZ6e8r9uDRuj9G0Z8FYDDkVsO2ug6qReToKnSvyS6xN7uO1XXCE5jceGBqntB', NULL, '$2y$12$EjszubanT8ECScFodfpkG.t4aw0pVMXTXzC.G686oeUXNdfx19EAy', NULL, '2024-07-27 23:51:34', '2024-07-28 10:42:08', NULL, NULL, 1, '68540', '10', 'boluwaduroolaoluwa', 'JOPAYTECHLIMITE / OPEADURA AJAYI', '8029111934', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2580', '', NULL, NULL, NULL, '271KjLZ', NULL, 'BVN', '22503726751', 'active', '66a5883e1a36fd518ed9a287', '015235', '66a58893142ea00024c84415', 0),
(272, 'Ccv', NULL, NULL, 'hudh@gmail.com', NULL, NULL, '34651714128', NULL, NULL, NULL, NULL, NULL, '$2y$12$iuDoOm1S9.28Z0vnJmEQPO81ToNmXtwJcYU1Hm7vUBZpTXcEj3oEy', NULL, '2024-07-28 00:17:48', '2024-07-28 00:17:48', NULL, NULL, 0, '28047', '0', 'hudh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '272Gpdu', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(274, 'Raju', NULL, NULL, 'rajukisku817@gmail.com', NULL, NULL, '8170084518', NULL, NULL, NULL, NULL, NULL, '$2y$12$P6c3WUBS0M3Xd8tn2oJVze9LcULen7xY1T4YesHh1WmwgP9qzPwlm', NULL, '2024-08-04 18:29:09', '2024-08-04 18:29:09', NULL, NULL, 0, '18562', '0', 'rajukisku817', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '274GisG', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(275, 'Solomon aboki', NULL, NULL, 'bfour217@gmail.com', NULL, NULL, '08146299870', NULL, NULL, NULL, NULL, NULL, '$2y$12$5447Qx/891ZgzgMvEhKm7uAXCBauGAnLTKACwzk8JfMze9.UwSQdu', NULL, '2024-08-04 23:54:54', '2024-08-04 23:54:55', NULL, NULL, 0, '89344', '0', 'bfour217', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '275TvtR', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(276, 'Olanrewaju adubina', NULL, NULL, 'l.cara815@gmail.com', NULL, NULL, '07019610751', NULL, NULL, NULL, NULL, NULL, '$2y$12$03l6oKcz/daC4RrnznddG.8Py.uoYCS77qJC.TAss7xeQ.POxjXN6', NULL, '2024-08-04 23:58:26', '2024-08-04 23:58:26', NULL, NULL, 0, '21143', '0', 'lcara815', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '276tdF8', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(277, 'Adebayo bakare', NULL, NULL, 'mugupet868@gmail.com', NULL, NULL, '07063012438', NULL, NULL, NULL, NULL, NULL, '$2y$12$i7RseZmYmjuiQ0W3hh5xuepqApMSgo58GKpN5qH6nUG2NongqSiC2', NULL, '2024-08-05 08:59:37', '2024-08-05 08:59:37', NULL, NULL, 0, '11318', '0', 'mugupet868', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '277uggM', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(278, 'Kolade ojo', NULL, NULL, 'koladedesmond@gmail.com', NULL, NULL, '09034577908', NULL, NULL, NULL, NULL, NULL, '$2y$12$OzsHkWzaYjX2NrwyZjcEUOIVZ92P/mMiOEPVnkUJU7LVtpqT.3HtG', NULL, '2024-08-05 11:03:56', '2024-08-05 11:03:57', NULL, NULL, 0, '81839', '0', 'koladedesmond', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '278hWEK', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(279, 'Yusuf kobo', NULL, NULL, 'yusufabass080@gmail.com', NULL, NULL, '08138053919', NULL, NULL, NULL, NULL, NULL, '$2y$12$HmFurnDxpYDKxeibxUhPcOld8qW6u.Mmh78ecmfYTcMZbuDC56Emy', NULL, '2024-08-06 20:20:27', '2024-08-06 20:20:27', NULL, NULL, 0, '83677', '0', 'yusufabass080', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '279zW8J', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(280, 'Ilesanmi morakinyo martins', NULL, NULL, 'ilesanmimoraakinyo@gmail.com', NULL, NULL, '00137214219', NULL, NULL, NULL, NULL, NULL, '$2y$12$bNz6pGg.AF7Lu9Xi0zlhw.wEJxabHJqd62JOf/ZmdfVg3vW0pCg6a', NULL, '2024-08-07 07:28:17', '2024-08-07 07:28:17', NULL, NULL, 0, '16720', '0', 'ilesanmimoraakinyo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '280Y1je', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(281, 'Umar kuriyetu', NULL, NULL, 'james.scothpt@gmail.com', NULL, NULL, '09062115236', NULL, NULL, NULL, NULL, NULL, '$2y$12$hNHpawyT3lzMsoEYWeb85eH.bqtMYTN.PwMrLcbW0xslkRyqcrn0y', NULL, '2024-08-08 23:22:20', '2024-08-08 23:22:21', NULL, NULL, 0, '97377', '0', 'jamesscothpt', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '281efVx', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0),
(282, 'Faith ewuola', NULL, NULL, 'zdasola8@gmail.com', NULL, NULL, '09050326555', NULL, NULL, NULL, NULL, NULL, '$2y$12$xZa5Rnh4fVYnBuxkkwUUyeoIDiEKckW4dFIjYpVRcsyCpxIY/8qhW', NULL, '2024-08-12 22:35:48', '2024-08-12 22:35:49', NULL, NULL, 0, '84288', '0', 'zdasola8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2823jb9', NULL, NULL, NULL, '0', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_m_s`
--

CREATE TABLE `user_m_s` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_wema`
--
ALTER TABLE `auth_wema`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_p_idatas`
--
ALTER TABLE `a_p_idatas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_p_i_airtimes`
--
ALTER TABLE `a_p_i_airtimes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_p_i_transactions`
--
ALTER TABLE `a_p_i_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charges`
--
ALTER TABLE `charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `failed_import_rows_import_id_foreign` (`import_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `imports`
--
ALTER TABLE `imports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imports_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifies`
--
ALTER TABLE `notifies`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `referral`
--
ALTER TABLE `referral`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supports`
--
ALTER TABLE `supports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_m_s`
--
ALTER TABLE `user_m_s`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_wema`
--
ALTER TABLE `auth_wema`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `a_p_idatas`
--
ALTER TABLE `a_p_idatas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `a_p_i_airtimes`
--
ALTER TABLE `a_p_i_airtimes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `a_p_i_transactions`
--
ALTER TABLE `a_p_i_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1577;

--
-- AUTO_INCREMENT for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `charges`
--
ALTER TABLE `charges`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1338;

--
-- AUTO_INCREMENT for table `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `imports`
--
ALTER TABLE `imports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1661;

--
-- AUTO_INCREMENT for table `notifies`
--
ALTER TABLE `notifies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referral`
--
ALTER TABLE `referral`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supports`
--
ALTER TABLE `supports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=283;

--
-- AUTO_INCREMENT for table `user_m_s`
--
ALTER TABLE `user_m_s`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  ADD CONSTRAINT `failed_import_rows_import_id_foreign` FOREIGN KEY (`import_id`) REFERENCES `imports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `imports`
--
ALTER TABLE `imports`
  ADD CONSTRAINT `imports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
