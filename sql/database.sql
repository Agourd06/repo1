create DATABASE brief7;
use brief7;
CREATE TABLE `article` (
  `article_id` int(11) NOT NULL,
  `article_title` varchar(255) DEFAULT NULL,
  `content` varchar(1500) DEFAULT NULL,
  `article_image` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `author_id` int(11) DEFAULT NULL,
  `theme_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `basket` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plant_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `basket` (`id`, `user_id`, `plant_id`, `quantity`) VALUES
(90, 39, 41, 1),
(91, 39, 32, 1);


CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(3, 'love'),
(7, 'ceremonies'),
(10, 'house');

-- --------------------------------------------------------

--
-- Structure de la table `commands`
--

CREATE TABLE `commands` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plant_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commands`
--

INSERT INTO `commands` (`id`, `user_id`, `plant_id`, `total_amount`, `status`) VALUES
(9, 5, 41, 0.00, ''),
(10, 5, 41, 0.00, ''),
(11, 5, 32, 0.00, ''),
(12, 5, 41, 0.00, ''),
(13, 5, 32, 0.00, ''),
(18, 13, 41, 0.00, ''),
(19, 13, 42, 0.00, ''),
(20, 30, 41, 0.00, ''),
(21, 30, 42, 0.00, ''),
(22, 30, 43, 0.00, ''),
(23, 30, 41, 0.00, ''),
(26, 20, 41, 0.00, ''),
(27, 20, 46, 0.00, ''),
(28, 39, 46, 0.00, ''),
(29, 39, 32, 0.00, ''),
(30, 39, 41, 0.00, ''),
(31, 43, 41, 0.00, ''),
(32, 43, 32, 40.00, ''),
(33, 43, 32, 200.00, ''),
(34, 43, 44, 200.00, ''),
(35, 43, 41, 200.00, ''),
(36, 43, 42, 200.00, ''),
(37, 43, 32, 110.00, ''),
(38, 43, 44, 110.00, ''),
(39, 43, 41, 180.00, ''),
(40, 43, 41, 180.00, ''),
(41, 43, 43, 180.00, ''),
(42, 43, 41, 180.00, ''),
(43, 43, 43, 180.00, ''),
(44, 43, 41, 180.00, ''),
(45, 43, 43, 180.00, ''),
(46, 43, 41, 180.00, ''),
(47, 43, 43, 180.00, ''),
(48, 43, 41, 180.00, ''),
(49, 43, 43, 180.00, ''),
(50, 43, 41, 180.00, ''),
(51, 43, 43, 180.00, ''),
(52, 43, 41, 180.00, ''),
(53, 43, 43, 180.00, ''),
(54, 43, 41, 180.00, ''),
(55, 43, 43, 180.00, ''),
(56, 43, 41, 180.00, ''),
(57, 43, 43, 180.00, ''),
(58, 43, 41, 200.00, ''),
(59, 43, 42, 200.00, ''),
(60, 43, 41, 100.00, ''),
(61, 43, 41, 100.00, ''),
(62, 43, 55, 60.00, ''),
(63, 43, 55, 60.00, '');

-- --------------------------------------------------------

--
-- Structure de la table `plants`
--

CREATE TABLE `plants` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `discounted_price` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `plants`
--

INSERT INTO `plants` (`id`, `category_id`, `name`, `description`, `price`, `image_url`, `discounted_price`) VALUES
(32, 10, 'tulipe', 'som', 20.00, '../images/15.jpg', '10'),
(41, 10, 'tulipe', 'dzo hfe', 100.00, '../images/5.jpg', '140'),
(42, 10, 'tulipe', 'heui hhiez', 100.00, '../images/6.jpg', '120'),
(43, 10, 'rose', 'a flower', 80.00, '../images/12.jpg', '100'),
(44, 10, 'tulipe', 'jio', 90.00, '../images/4.jpg', '110'),
(45, 10, 'vase', 'jazio', 30.00, '../images/7.jpg', '50'),
(46, 3, 'tulipe', 'sio&', 20.00, '../images/ll10.jpg', '30'),
(47, 3, 'tulipe', 'jzio', 40.00, '../images/l5.jpg', '50'),
(48, 3, 'rose', 'nszél', 2.00, '../images/l7.jpg', '30'),
(49, 3, 'tulipe', 'jio', 0.00, '../images/l3.jpg', ''),
(50, 3, 'tulipe', 'sio&', 20.00, '../images/ll10.jpg', '30'),
(52, 3, 'rose', 'nszél', 2.00, '../images/l7.jpg', '30'),
(54, 7, 'bunch', 'dzio', 50.00, '../images/wd7.jpg', '60'),
(55, 7, 'bunch', 'jsaui', 30.00, '../images/wd8.jpg', '70'),
(56, 7, 'bunch', 'dzio', 50.00, '../images/wd5.jpg', '60'),
(57, 7, 'bunch', 'jsaui', 30.00, '../images/wd6.jpg', '70'),
(58, 7, 'bunch', 'dzio', 50.00, '../images/wd4.webp', '60'),
(59, 7, 'bunch', 'dzio', 50.00, '../images/wd10.jpg', '60');

-- --------------------------------------------------------

--
-- Structure de la table `plant_basket_pivot`
--

CREATE TABLE `plant_basket_pivot` (
  `id` int(11) NOT NULL,
  `plant_id` int(11) DEFAULT NULL,
  `basket_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`role_id`, `name`) VALUES
(1, 'client'),
(2, 'admin'),
(3, 'superAdmin');

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(255) DEFAULT NULL,
  `theme_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE `theme` (
  `theme_id` int(11) NOT NULL,
  `theme_name` varchar(255) DEFAULT NULL,
  `theme_image` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL,
  `profile_active` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `email`, `password`, `user_type`, `profile_active`, `status`) VALUES
(5, 'test', 'test@gmail.com', '$2y$10$6I2Eyh8Jy9Fbn2SCQoLxqerndRxtTjshhXW7vC0ymIP9dS1Gr4tQe', 2, NULL, 0),
(10, 'asmaa', 'hariti@gmail.com', '$2y$10$hrLti0pufQ48Asrfe83nXOPlLjkcqtJ.mXiuE82PBARpfYCG5qBTu', 2, NULL, NULL),
(11, 'mohamed', 'mohamed@gmail.com', '$2y$10$e2z8k/Sj.yqL2bJeVg/mGuh3KZMnp81XTFw/9xETyy/fnLZdNOIRy', 1, NULL, 1),
(12, 'aaa', 'aaa@gmail.com', '$2y$10$v0br55JFFz1i1pJfJKyAZeBizd4gXlMIQA8FnXo3h6UYV0DVSDAfS', 1, 'NULL', 0),
(13, 'super', 'superadmin@gmail.com', '$2y$10$csdTY2rv3uIzZwVbvBy.rO4qCjpRRxRDMLp0nbzTUZlpnURSOQ1we', 3, NULL, NULL),
(20, 'asmaa', 'client2@gmail.com', '$2y$10$xYipsvcBNmZzDX6986xFe.s0p9rUwAHXZlR4gLXgZfhNJlPQJ.ePi', 1, NULL, NULL),
(22, 'asmaa', 'client2@gmail.com', '$2y$10$YrdN4bKNtORzstnEqYoyz./2Xyn8uGFFGLXHzmh3PNDaZfTiFl4Qu', NULL, NULL, NULL),
(23, 'asmaa', 'client2@gmail.com', '$2y$10$m9uU6DGzRKzsamQFcv8kxe2DWY8Pak//0mdVkVIe0WiO1a0Gd6b9K', NULL, NULL, NULL),
(24, 'asmaa', 'client2@gmail.com', '$2y$10$yz57yWIBXcsK/G3aqWIWj.fLUzOamotXrDl72w7c/LogIukMbvLEC', NULL, NULL, NULL),
(30, 'asmaa', 'client@gmail.com', '$2y$10$NMQc4vYMdnQVJHibBxXvQOx61TdTl6Pu5nnQg9RpMjfw0NsikeMuS', 1, NULL, NULL),
(33, 'asmaa', 'client2@gmail.com', '$2y$10$LAMIL.VpL4RW2jaR6wD.Pe8GrNPGXvIrE5m7O1jITFs/Fo7aell5S', NULL, NULL, NULL),
(37, 'asmaa', 'client@gmail.com', '$2y$10$Op5r1tXldVLnD2b/lWe.muVuJcly1kUN3hDvsfteUyMdWaSMbY7Ci', NULL, NULL, NULL),
(39, 'asmaa', 'clients@gmail.com', '$2y$10$05JxBW4guEx3POEHjSFee.ZqhyY1re6zRiQSvUjY9yJ8WxoQ0mVqq', 1, NULL, 1),
(40, 'admin', 'admins@gmail.com', '$2y$10$O7fkohX2WGhgIRoqc7V6HOG2KwE6JfEtmPe9aOq2EQBtDi/u.yyDq', 2, NULL, NULL),
(41, 'asmaa', 'clients@gmail.com', '$2y$10$OZwlKL0VnO/kqOHhfbDQIuf4DpBywd.Za8ZvI4E0zTZySQRGVvneu', NULL, NULL, NULL),
(42, 'asmaa', 'admins@gmail.com', '$2y$10$K7O3r0bPBSfK2eLXkVC9lekcEhHZhMcGU39gYQeEZsGnY4yRcaajK', NULL, NULL, NULL),
(43, 'asmaa', 'nursery2@gmail.com', '$2y$10$DjZaI8CWLTt8dqfDqQHda.mQwrJBmMs0XACDWwI/rcolReAv9Bmg6', 1, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `theme_id` (`theme_id`);

--
-- Index pour la table `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commands`
--
ALTER TABLE `commands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_commands_user_idx` (`user_id`),
  ADD KEY `fk_commands_plant_idx` (`plant_id`);

--
-- Index pour la table `plants`
--
ALTER TABLE `plants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `plant_basket_pivot`
--
ALTER TABLE `plant_basket_pivot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plant_id` (`plant_id`),
  ADD KEY `basket_id` (`basket_id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD KEY `theme_id` (`theme_id`);

--
-- Index pour la table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`theme_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_type` (`user_type`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `basket`
--
ALTER TABLE `basket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `commands`
--
ALTER TABLE `commands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table `plants`
--
ALTER TABLE `plants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `plant_basket_pivot`
--
ALTER TABLE `plant_basket_pivot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `theme`
--
ALTER TABLE `theme`
  MODIFY `theme_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`theme_id`);

--
-- Contraintes pour la table `commands`
--
ALTER TABLE `commands`
  ADD CONSTRAINT `fk_commands_plant` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_commands_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `plants`
--
ALTER TABLE `plants`
  ADD CONSTRAINT `plants_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `plant_basket_pivot`
--
ALTER TABLE `plant_basket_pivot`
  ADD CONSTRAINT `plant_basket_pivot_ibfk_1` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `plant_basket_pivot_ibfk_2` FOREIGN KEY (`basket_id`) REFERENCES `basket` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`theme_id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_type`) REFERENCES `role` (`role_id`);
COMMIT;

