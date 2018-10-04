-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2018 at 08:04 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_workflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application_loans`
--

CREATE TABLE `application_loans` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `min_loan_amount` int(11) NOT NULL,
  `max_loan_amount` int(11) NOT NULL,
  `loan_tenor` int(11) NOT NULL,
  `loan_purpose` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_basic_info`
--

CREATE TABLE `app_basic_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `itr_income` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_year` int(11) NOT NULL,
  `company_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_owners`
--

CREATE TABLE `app_owners` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marital_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nyc` int(11) NOT NULL,
  `nycr` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_process`
--

CREATE TABLE `app_process` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_process`
--

INSERT INTO `app_process` (`id`, `name`, `order`, `parent_id`, `created_at`, `updated_at`) VALUES
(3, 'Register', 1, 1, '2018-09-25 07:23:28', '2018-09-25 07:23:28'),
(5, 'application', 1, 1, '2018-09-25 07:24:03', '2018-09-25 07:24:03'),
(6, 'login', 1, 1, '2018-09-25 07:24:13', '2018-09-25 07:24:13'),
(7, 'customer journey', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `app_tasks`
--

CREATE TABLE `app_tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `process_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_hidden` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_tasks`
--

INSERT INTO `app_tasks` (`id`, `process_id`, `name`, `order`, `action`, `page`, `slug`, `created_at`, `updated_at`, `is_hidden`) VALUES
(5, 3, 'register', 1, '/v1/register', '', 'Register', '2018-09-25 07:25:48', '2018-09-25 10:36:42', 1),
(6, 3, 'otp request', 2, '/v1/otp', '', 'otp_request', '2018-09-25 07:26:08', '2018-09-25 10:36:42', 1),
(9, 5, 'create application', 1, '/v1/application/create', '', 'create_application', '2018-09-26 06:35:15', '2018-09-26 06:35:15', 1),
(10, 5, 'address', 1, '/v1/application/address', '', 'address', '2018-09-26 06:37:00', '2018-09-26 06:37:00', 1),
(11, 5, 'business details', 1, '/v1/application/business-detail', '', 'business_details', '2018-09-26 06:37:56', '2018-09-26 06:37:56', 1),
(12, 5, 'loan details', 1, '/v1/application/loan-detail', '', 'loan_details', '2018-09-26 06:38:47', '2018-09-26 06:38:47', 1),
(13, 5, 'loan purpose', 1, '/v1/application/loan-purpose', '', 'loan_purpose', '2018-09-26 06:39:08', '2018-09-26 06:39:08', 1),
(14, 5, 'required document', 1, '/v1/application/required-document', '', 'required_document', '2018-09-26 06:39:50', '2018-09-26 06:39:50', 1),
(15, 5, 'upload document', 1, '/v1/application/upload-document', '', 'upload_document', '2018-09-26 06:40:16', '2018-09-26 06:40:16', 1),
(16, 5, 'company indo', 1, '/v1/application/coapplicant/company-info', '', 'company_info', '2018-09-26 06:40:45', '2018-09-26 06:40:45', 1),
(17, 5, 'coapplicant address', 1, '/v1/application/coapplicant/address', '', 'coapplicant_address', '2018-09-26 06:41:26', '2018-09-26 06:41:26', 1),
(18, 5, 'coapplicant occupation', 1, '/v1/application/coapplicant/occupation-detail', '', 'coapplicant_occupation', '2018-09-26 06:42:02', '2018-09-26 06:42:02', 1),
(19, 6, 'login', 1, '/v1/login', '', 'login', '2018-09-26 09:43:29', '2018-09-26 09:43:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `data_rows`
--

CREATE TABLE `data_rows` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `process_id` int(1) NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_action` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  `relationship` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validation_rule` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_rows`
--

INSERT INTO `data_rows` (`id`, `name`, `process_id`, `type`, `api_action`, `label`, `order`, `is_active`, `is_used`, `relationship`, `validation_rule`, `created_at`, `updated_at`) VALUES
(1, 'firstname', 3, 'text', NULL, 'First Name', 1, 1, 0, NULL, '[{\"rule\":\"alpha\",\"value\":null,\"message\":null},{\"rule\":\"min\",\"value\":\"3\",\"message\":null},{\"rule\":\"required\",\"value\":null,\"message\":null}]', '2018-10-01 07:29:03', '2018-10-01 07:29:03'),
(2, 'lastname', 3, 'text', NULL, 'Last Name', 2, 1, 0, NULL, '[{\"rule\":\"alpha\",\"value\":null,\"message\":null},{\"rule\":\"min\",\"value\":\"3\",\"message\":null},{\"rule\":\"required\",\"value\":null,\"message\":null}]', '2018-10-01 07:31:13', '2018-10-01 07:31:13'),
(3, 'email', 3, 'text', NULL, 'Email Address', 3, 1, 0, NULL, '[{\"rule\":\"email\",\"value\":null,\"message\":null},{\"rule\":\"required\",\"value\":null,\"message\":null}]', '2018-10-01 07:31:39', '2018-10-01 07:31:39'),
(4, 'phone', 3, 'text', NULL, 'Phone Number', 4, 1, 0, NULL, '[{\"rule\":\"alpha\",\"value\":null,\"message\":null},{\"rule\":\"max\",\"value\":\"12\",\"message\":null},{\"rule\":\"min\",\"value\":\"8\",\"message\":null},{\"rule\":\"required\",\"value\":null,\"message\":null}]', '2018-10-01 07:32:02', '2018-10-01 07:32:02'),
(5, 'password', 3, 'text', NULL, 'Password', 5, 1, 0, NULL, '[{\"rule\":\"alpha\",\"value\":null,\"message\":null},{\"rule\":\"min\",\"value\":\"5\",\"message\":null},{\"rule\":\"required\",\"value\":null,\"message\":null}]', '2018-10-01 07:32:34', '2018-10-01 07:32:34'),
(6, 'email', 6, 'text', NULL, 'Email Address', 1, 1, 0, NULL, '[{\"rule\":\"email\",\"value\":null,\"message\":null}]', '2018-10-01 07:32:56', '2018-10-01 07:32:56'),
(7, 'password', 6, 'text', NULL, 'Password', 2, 1, 0, NULL, '[{\"rule\":\"alpha\",\"value\":null,\"message\":null},{\"rule\":\"required\",\"value\":null,\"message\":null}]', '2018-10-01 07:33:48', '2018-10-01 07:33:48');

-- --------------------------------------------------------

--
-- Table structure for table `data_row_validation`
--

CREATE TABLE `data_row_validation` (
  `id` int(10) UNSIGNED NOT NULL,
  `validation_id` int(11) NOT NULL,
  `data_row_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_row_validation`
--

INSERT INTO `data_row_validation` (`id`, `validation_id`, `data_row_id`, `created_at`, `updated_at`) VALUES
(4, 3, 16, NULL, NULL),
(5, 1, 16, NULL, NULL),
(6, 3, 17, NULL, NULL),
(7, 1, 17, NULL, NULL),
(8, 2, 18, NULL, NULL),
(9, 3, 19, NULL, NULL),
(10, 1, 19, NULL, NULL),
(11, 2, 20, NULL, NULL),
(12, 2, 21, NULL, NULL),
(13, 1, 22, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2018_07_29_060122_create_user_table', 1),
(2, '2018_08_16_093113_create_verification_hash_table', 1),
(3, '2018_09_14_065546_create_app_process_table', 1),
(4, '2018_09_17_072556_create_application_table', 1),
(5, '2018_09_17_091527_create_owner_details_table', 1),
(6, '2018_09_17_101559_create_application_loan_info_table', 1),
(7, '2018_09_19_050601_create_basic_info_table', 1),
(8, '2018_09_24_055334_create_tasks_table', 1),
(9, '2018_09_25_051541_add_is_hidden_column', 1),
(10, '2018_09_26_070335_create_data_row_validation_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_phone_verified` tinyint(4) NOT NULL DEFAULT '0',
  `is_email_verified` tinyint(4) NOT NULL DEFAULT '0',
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `validation_rules`
--

CREATE TABLE `validation_rules` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` int(11) DEFAULT NULL,
  `value_required` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `validation_rules`
--

INSERT INTO `validation_rules` (`id`, `name`, `value`, `value_required`, `created_at`, `updated_at`) VALUES
(1, 'required', NULL, 0, NULL, NULL),
(2, 'email', NULL, 0, NULL, NULL),
(3, 'alpha', NULL, 0, NULL, NULL),
(4, 'min', 3, 1, NULL, NULL),
(5, 'max', 15, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `verification_hashes`
--

CREATE TABLE `verification_hashes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applications_user_id_foreign` (`user_id`);

--
-- Indexes for table `application_loans`
--
ALTER TABLE `application_loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_loans_app_id_foreign` (`app_id`);

--
-- Indexes for table `app_basic_info`
--
ALTER TABLE `app_basic_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_basic_info_app_id_foreign` (`app_id`);

--
-- Indexes for table `app_owners`
--
ALTER TABLE `app_owners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_owners_app_id_foreign` (`app_id`);

--
-- Indexes for table `app_process`
--
ALTER TABLE `app_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_tasks`
--
ALTER TABLE `app_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_tasks_process_id_foreign` (`process_id`);

--
-- Indexes for table `data_rows`
--
ALTER TABLE `data_rows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_row_validation`
--
ALTER TABLE `data_row_validation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `validation_rules`
--
ALTER TABLE `validation_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verification_hashes`
--
ALTER TABLE `verification_hashes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verification_hashes_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `application_loans`
--
ALTER TABLE `application_loans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_basic_info`
--
ALTER TABLE `app_basic_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_owners`
--
ALTER TABLE `app_owners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_process`
--
ALTER TABLE `app_process`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `app_tasks`
--
ALTER TABLE `app_tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `data_rows`
--
ALTER TABLE `data_rows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `data_row_validation`
--
ALTER TABLE `data_row_validation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `validation_rules`
--
ALTER TABLE `validation_rules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `verification_hashes`
--
ALTER TABLE `verification_hashes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `application_loans`
--
ALTER TABLE `application_loans`
  ADD CONSTRAINT `application_loans_app_id_foreign` FOREIGN KEY (`app_id`) REFERENCES `applications` (`id`);

--
-- Constraints for table `app_basic_info`
--
ALTER TABLE `app_basic_info`
  ADD CONSTRAINT `app_basic_info_app_id_foreign` FOREIGN KEY (`app_id`) REFERENCES `applications` (`id`);

--
-- Constraints for table `app_owners`
--
ALTER TABLE `app_owners`
  ADD CONSTRAINT `app_owners_app_id_foreign` FOREIGN KEY (`app_id`) REFERENCES `applications` (`id`);

--
-- Constraints for table `app_tasks`
--
ALTER TABLE `app_tasks`
  ADD CONSTRAINT `app_tasks_process_id_foreign` FOREIGN KEY (`process_id`) REFERENCES `app_process` (`id`);

--
-- Constraints for table `verification_hashes`
--
ALTER TABLE `verification_hashes`
  ADD CONSTRAINT `verification_hashes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
