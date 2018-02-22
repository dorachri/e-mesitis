-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Φιλοξενητής: 127.0.0.1
-- Χρόνος δημιουργίας: 22 Φεβ 2018 στις 12:08:27
-- Έκδοση διακομιστή: 10.1.13-MariaDB
-- Έκδοση PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `mesitiko_grafeio`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `ads`
--

CREATE TABLE `ads` (
  `ad_id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `surface` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `available` date NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `bathrooms` int(11) NOT NULL,
  `wc` int(11) NOT NULL,
  `levels` int(11) NOT NULL,
  `floor` varchar(45) NOT NULL,
  `year` year(4) NOT NULL,
  `geo` varchar(45) NOT NULL,
  `commune` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `post_code` varchar(20) NOT NULL,
  `userid` int(11) NOT NULL,
  `image` varchar(45) NOT NULL DEFAULT 'includes/images/not_found.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `ads`
--

INSERT INTO `ads` (`ad_id`, `phone`, `type`, `category`, `surface`, `price`, `available`, `bedrooms`, `bathrooms`, `wc`, `levels`, `floor`, `year`, `geo`, `commune`, `address`, `post_code`, `userid`, `image`) VALUES
(1, '6984561238', 'Rent', 'Property', 60, 300, '2016-07-30', 1, 1, 1, 1, '2', 2002, 'Attica', 'Athina', 'E. Venizelou 30', '14265', 2, 'includes/images/not_found.jpg'),
(2, '69760314526', 'Rent', 'Land', 300, 60, '2016-07-27', 0, 0, 0, 0, '0', 2000, 'Peloponnese', 'Tripoli', 'E. Antistaseos 15', '12345', 3, 'includes/images/not_found.jpg'),
(3, '6954555632', 'Rent', 'Business Property', 1200, 2300, '2016-07-29', 0, 0, 2, 0, '3', 2007, 'Attica', 'Athina', 'Panepistimiou 120', '11223', 4, 'includes/images/not_found.jpg'),
(4, '6955575445', 'Sale', 'Property', 55, 35000, '2017-01-24', 1, 1, 1, 1, '1', 2005, 'Attica', 'Athina', 'Anastaseos 125', '12355', 3, 'includes/images/not_found.jpg'),
(5, '6933353663', 'Sale', 'Land', 150, 80000, '2017-01-10', 0, 0, 0, 0, '0', 2000, 'Attica', 'Gerakas', 'Stauros Geraka', '11223', 6, 'includes/images/not_found.jpg'),
(6, '6974757887', 'Sale', 'Property', 80, 60000, '2017-01-16', 2, 1, 1, 1, '2', 2003, 'Attica', 'Aigaleo', 'Ag. Paulou 45', '1789', 6, 'includes/images/not_found.jpg'),
(7, '6936333554', 'Rent', 'Property', 45, 250, '2016-12-20', 1, 1, 1, 1, '1', 2006, 'Attica', 'Athina', 'M. Alexandrou 20', '1567', 4, 'includes/images/not_found.jpg'),
(8, '6985868777', 'Sale', 'Business Property', 30, 200000, '2016-12-06', 0, 0, 1, 1, '0', 2002, 'Attica', 'Athina', 'Ermou 33', '12553', 2, 'includes/images/not_found.jpg');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `isadmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`userid`, `username`, `email`, `name`, `surname`, `isadmin`) VALUES
(1, 'dora', 'doraxrs@hotmail.com', 'Theodora', 'Chri', 1),
(2, 'fotini92', 'fotini92@gmail.com', 'Fotini', 'Papa', 0),
(3, 'anastasia85', 'anastasia85@gmail.com', 'Anastasia', 'Papadopoulou', 0),
(4, 'maria78', 'maria78@hotmail.com', 'Maria', 'Antoniou', 0),
(5, 'eleni123', 'eleni123@gmail.com', 'Eleni', 'Vaf', 1),
(6, 'giorgos75', 'giorgos75@gmail.com', 'Giorgos', 'Athanasiou', 0),
(7, 'marina', 'marina@gmail.com', 'Marina', 'Petr', 1);

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`ad_id`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `ads`
--
ALTER TABLE `ads`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
