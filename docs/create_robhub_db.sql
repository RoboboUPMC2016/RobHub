SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Structure de la table `behavior`
--

CREATE TABLE `behavior` (
  `Behavior_id` bigint(20) NOT NULL,
  `Behavior_label` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Behavior_description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `User_username` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Behavior_timestamp` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Structure de la table `mark`
--

CREATE TABLE `mark` (
  `Mark_id` int(11) NOT NULL,
  `Mark_value` int(11) NOT NULL,
  `Behavior_id` bigint(20) DEFAULT NULL,
  `User_username` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `User_username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `User_password` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `User_firstname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `User_lastname` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Index pour les tables exportées
--

--
-- Index pour la table `behavior`
--
ALTER TABLE `behavior`
  ADD PRIMARY KEY (`Behavior_id`),
  ADD KEY `User_username` (`User_username`);

--
-- Index pour la table `mark`
--
ALTER TABLE `mark`
  ADD PRIMARY KEY (`Mark_id`),
  ADD KEY `Behavior_id` (`Behavior_id`),
  ADD KEY `User_username` (`User_username`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_username`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `behavior`
--
ALTER TABLE `behavior`
  MODIFY `Behavior_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT pour la table `mark`
--
ALTER TABLE `mark`
  MODIFY `Mark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
