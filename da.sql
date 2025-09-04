-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 12, 2025 lúc 05:00 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `da`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `classes`
--

INSERT INTO `classes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Hệ Điều Hành', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Đánh giá kiểm định chất lượng phần mềm', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'Khoa học trí tuệ nhân tạo', '2025-06-12 07:33:16', '2025-06-12 07:33:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(231, '2014_10_12_000000_create_users_table', 1),
(232, '2014_10_12_100000_create_password_resets_table', 1),
(233, '2019_08_19_000000_create_failed_jobs_table', 1),
(234, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(235, '2022_01_13_015525_create_subjects_table', 1),
(236, '2022_01_13_015542_create_teacher_profiles_table', 1),
(237, '2022_01_13_020203_create_classes_table', 1),
(238, '2022_01_13_020204_create_student_profiles_table', 1),
(239, '2022_01_13_090426_create_teacher_subject_table', 1),
(240, '2022_01_13_100112_create_scores_table', 1),
(241, '2022_01_14_143526_create_request_edit_score_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_admin`
--

CREATE TABLE `personal_access_admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `request_edit_score`
--

CREATE TABLE `request_edit_score` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `score_id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `scores`
--

CREATE TABLE `scores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `tp1` double(8,2) UNSIGNED NOT NULL,
  `tp2` double(8,2) UNSIGNED DEFAULT NULL,
  `qt` double(8,2) UNSIGNED DEFAULT NULL,
  `ck` double(8,2) UNSIGNED DEFAULT NULL,
  `tk` double(8,2) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `scores`
--

INSERT INTO `scores` (`id`, `student_id`, `subject_id`, `tp1`, `tp2`, `qt`, `ck`, `tk`, `created_at`, `updated_at`) VALUES
(57, 170, 12, 8.00, 8.00, 8.00, 8.00, 8.00, '2025-05-28 02:44:56', '2025-05-28 02:44:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `student_profiles`
--

CREATE TABLE `student_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dob` datetime NOT NULL,
  `code` varchar(255) NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `student_profiles`
--

INSERT INTO `student_profiles` (`id`, `dob`, `code`, `class_id`, `created_at`, `updated_at`) VALUES
(170, '2004-10-19 00:00:00', '22010156', 2, '2025-05-20 03:02:00', '2025-06-09 22:07:14'),
(176, '2004-10-19 00:00:00', '123456', 1, '2025-05-28 02:20:07', '2025-06-03 20:20:54'),
(177, '2004-03-12 00:00:00', '22222222', 1, '2025-05-28 05:47:40', '2025-05-28 05:47:40'),
(179, '1970-01-01 00:00:00', '654321', 1, '2025-06-03 09:27:45', '2025-06-03 09:27:45'),
(181, '1970-01-01 00:00:00', '19102004', 1, '2025-06-12 07:32:11', '2025-06-12 07:32:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `student_subjects`
--

CREATE TABLE `student_subjects` (
  `student_profile_id` int(11) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `subject_id` bigint(20) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `credits` tinyint(5) NOT NULL,
  `semester` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `code`, `credits`, `semester`, `created_at`, `updated_at`) VALUES
(1, 'Toán Cao Cấp', 'TCC', 3, 1, '2025-06-27 10:14:03', '2025-06-05 07:41:50'),
(5, 'Tư tưởng Hồ Chí Minh', 'TTH', 2, 2, '2025-06-27 10:14:13', '2025-06-05 07:46:17'),
(6, 'Mạng Máy Tính', 'MMT', 0, 3, '2025-06-26 19:38:41', '2025-06-28 10:14:46'),
(7, 'An Toàn Mạng', 'ATM', 0, 4, '2025-06-27 05:15:12', '2025-06-28 15:34:44'),
(9, 'Xác suất thống kê', 'XST', 2, 4, '2025-06-27 05:55:49', '2025-06-09 04:31:57'),
(12, 'Hệ Điều Hành', 'HDH', 2, 2, '2025-06-27 05:16:42', '2025-06-09 04:32:09'),
(13, 'Đánh giá kiểm định chất lượng phần mềm', 'DGKDCPM', 2, 1, '2025-06-03 20:22:12', '2025-06-09 04:32:13'),
(14, 'Phân tích phần mềm', 'PTPM', 3, 2, '2025-06-05 07:56:07', '2025-06-05 07:56:17'),
(15, 'Khoa học trí tuệ nhân tạo', 'TTNT', 2, 3, '2025-06-12 07:32:56', '2025-06-12 07:32:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teacher_certificates`
--

CREATE TABLE `teacher_certificates` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `degree_name` varchar(255) NOT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teacher_degrees`
--

CREATE TABLE `teacher_degrees` (
  `id` int(11) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `coefficient` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teacher_profiles`
--

CREATE TABLE `teacher_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` varchar(20) NOT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `teacher_profiles`
--

INSERT INTO `teacher_profiles` (`id`, `teacher_id`, `phone_number`, `created_at`, `updated_at`) VALUES
(1, 'TVT', '0123456789', '2025-05-31 14:33:08', '2025-06-05 07:17:13'),
(2, 'BCH', '0989531828', '2025-05-31 14:32:53', '2025-06-05 07:23:29'),
(25, '', NULL, '2025-05-28 05:58:05', '2025-05-28 05:58:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teacher_subject`
--

CREATE TABLE `teacher_subject` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `teacher_subject`
--

INSERT INTO `teacher_subject` (`id`, `teacher_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(4, 1, 7, '2025-05-30 14:33:33', '2025-05-30 15:12:55'),
(28, 1, 1, '2025-06-05 07:49:03', '2025-06-05 07:49:03'),
(29, 2, 1, '2025-06-05 07:49:03', '2025-06-05 07:49:03'),
(31, 25, 14, '2025-06-05 07:56:17', '2025-06-05 07:56:17'),
(33, 2, 13, '2025-06-09 04:32:13', '2025-06-09 04:32:13'),
(34, 25, 12, '2025-06-09 04:32:24', '2025-06-09 04:32:24'),
(35, 2, 15, '2025-06-12 07:32:56', '2025-06-12 07:32:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `profile_id` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `role`, `profile_id`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Tạ Văn Thanh', 'teacher@gmail.com', 'teacher', 'teacher', 1, '$2y$10$.ZJvGGsNwmEZTGaLkNx6cObjhMgJtRyrLk0.Lrgan2DhndkZuhRk.', '2HDjVbYhmWdSwo3LlqtFVJ304b24CPcDRLFJdKOczRVnie6Qmrf44N3t4WMw', '2025-05-27 19:38:41', '2025-05-28 01:49:25'),
(8, 'Bùi Công Huy', 't@gmail.com', 'admin', 'teacher', 2, '$2y$10$tnex.O5FwQ.8Qo571ZQPbOfWG2B8J73fcJBo531R8fMlNK823BrLi', NULL, '2025-05-28 13:03:15', '2025-05-28 01:49:06'),
(193, 'bui cong huy', 'buiconghuy2004@gmail.com', '22010156', 'student', 170, '$2y$10$8RM95kHHWv2DMkwFj3RVEuKz8cUu.mnLlgocg3QattKC6tkZUU256', NULL, '2025-05-20 03:02:00', '2025-05-28 05:43:16'),
(199, 'Bùi Công H', 'buiconghuy@gmail.com', '123456', 'student', 176, '$2y$10$Sg37b0G5gJ7dbzvq9ZPfr.e0jC9WCQr1lM1N2H/K6oQ3rcarkkvUK', NULL, '2025-05-28 02:20:07', '2025-06-03 20:20:54'),
(200, 'Tạ Văn Thanh', 'huynghe2004@gmail.com', '22222222', 'student', 177, '$2y$10$gmMLUUmApGi.V78W0rI2M.sxuCs3Vtg9VmpH6aCBuvBbWI42tUqky', NULL, '2025-05-28 05:47:40', '2025-05-28 05:47:40'),
(202, 'Nguyễn Tuấn Anh', '1234@gmail.com', 'teacher1', 'teacher', 25, '$2y$10$pbJpe0WuLcPCqR3qUkB8fuhNPi55V2m9nwZ.lmUWo82C1E8S0Yx0q', NULL, '2025-05-28 05:58:05', '2025-05-28 05:58:05'),
(204, 'Nguyễn Tuấn Anh', 'nta@gmail.com', '654321', 'student', 179, '$2y$10$2di5PusDeZij9QA9fyei/./qZ.QsrfpxEkFz44/GwOLkb9y3qyUQ6', NULL, '2025-06-03 09:27:45', '2025-06-03 09:27:45'),
(206, 'Bùi Công Cường', 'buicongchuy@gmail.com', '19102004', 'student', 181, '$2y$10$gMC/Y4U279SWW.heyYngleJ3g4ATSUY19kh9nFGHJLMYqYvmJh42S', NULL, '2025-06-12 07:32:11', '2025-06-12 07:32:11');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `request_edit_score`
--
ALTER TABLE `request_edit_score`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_edit_score_score_id_foreign` (`score_id`);

--
-- Chỉ mục cho bảng `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `scores_student_id_subject_id_unique` (`student_id`,`subject_id`),
  ADD KEY `scores_subject_id_foreign` (`subject_id`);

--
-- Chỉ mục cho bảng `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_profiles_class_id_foreign` (`class_id`);

--
-- Chỉ mục cho bảng `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `teacher_certificates`
--
ALTER TABLE `teacher_certificates`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `teacher_degrees`
--
ALTER TABLE `teacher_degrees`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `teacher_profiles`
--
ALTER TABLE `teacher_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `teacher_subject`
--
ALTER TABLE `teacher_subject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_subject_teacher_id_foreign` (`teacher_id`),
  ADD KEY `teacher_subject_subject_id_foreign` (`subject_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `request_edit_score`
--
ALTER TABLE `request_edit_score`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `scores`
--
ALTER TABLE `scores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT cho bảng `student_profiles`
--
ALTER TABLE `student_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT cho bảng `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `teacher_certificates`
--
ALTER TABLE `teacher_certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `teacher_degrees`
--
ALTER TABLE `teacher_degrees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `teacher_profiles`
--
ALTER TABLE `teacher_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `teacher_subject`
--
ALTER TABLE `teacher_subject`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `request_edit_score`
--
ALTER TABLE `request_edit_score`
  ADD CONSTRAINT `request_edit_score_score_id_foreign` FOREIGN KEY (`score_id`) REFERENCES `scores` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `student_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `scores_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD CONSTRAINT `student_profiles_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`);

--
-- Các ràng buộc cho bảng `teacher_subject`
--
ALTER TABLE `teacher_subject`
  ADD CONSTRAINT `teacher_subject_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `teacher_subject_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teacher_profiles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
