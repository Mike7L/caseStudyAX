-- --------------------------------------------------------

--
-- Table structure for table `felgen`
--

CREATE TABLE IF NOT EXISTS `felgen` (
  `FelgenCode` int(11) NOT NULL,
  `Felgenmaulweite` float DEFAULT NULL,
  `Felgenhornhoehe` varchar(1) DEFAULT NULL,
  `Eintelige_Felge` varchar(1) DEFAULT NULL,
  `Felgedurchmesser` tinyint(2) DEFAULT NULL,
  `Material` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`FelgenCode`)
)

-- --------------------------------------------------------

--
-- Table structure for table `protokoll`
--

CREATE TABLE IF NOT EXISTS `protokoll` (
  `startTime` datetime DEFAULT CURRENT_TIMESTAMP,
  `endTime` datetime DEFAULT CURRENT_TIMESTAMP,
  `inserts` int(11) DEFAULT '0',
  `updates` int(11) DEFAULT '0',
  `errors` int(11) DEFAULT '0'
)

-- --------------------------------------------------------

--
-- Table structure for table `zeitraum`
--

CREATE TABLE IF NOT EXISTS `zeitraum` (
  `ZeitID` int(11) NOT NULL,
  `SchwackeCode` int(11) DEFAULT NULL,
  `Gueltig_ab` date DEFAULT NULL,
  `Gueltig_bis` date DEFAULT NULL,
  PRIMARY KEY (`ZeitID`)
)
