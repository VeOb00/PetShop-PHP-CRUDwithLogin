-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2020 at 02:52 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cr11_vedrana_petadoption`
--
CREATE DATABASE IF NOT EXISTS `cr11_vedrana_petadoption` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cr11_vedrana_petadoption`;

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `image` varchar(250) NOT NULL DEFAULT 'placeholder.jpg',
  `size` enum('small','large') NOT NULL,
  `type` varchar(50) NOT NULL,
  `location` varchar(250) NOT NULL,
  `gender` enum('female','male') NOT NULL,
  `description` varchar(6000) DEFAULT NULL,
  `hobbies` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `date_of_birth`, `image`, `size`, `type`, `location`, `gender`, `description`, `hobbies`) VALUES
(1, 'Leena', '2015-01-12', 'leena.jpg', 'small', 'cat', 'Mariahilfer Straße 115, Vienna', 'female', 'Leena arrived after her owner could no longer look after her and is now ready to find a new home to call her own. She is sweet needy little girl who enjoys her fuss and cuddles. She will give you a little nip if you ignore her too so she knows what she wants and that is to be the centre of attention. She would be prefer to live in a quiet all adult home as she can be a bit spooked of loud noises and become worried. Any person in the home will need to have had some previous cat care experience and she will appreciate a home that lets her flourish and provides her the care and affection she deserves. She will enjoy a garden but regardless of your working hours she will need a cat flap fitted so she can be free to explore her own patch on her own terms. With this in mind Leena has had her front right leg amputated so she will need easy access in and out of her home and garden so it is important you can provide a safe space to call home.', 'chasing the rope, sleeping, pushing stuff of the shelve'),
(2, 'Micky', '2010-05-10', 'micky.jpg', 'small', 'cat', 'Kärntner Straße 10, Vienna', 'male', 'Mickie arrived after his owner passed away and he was found injured in the garden. He is fine now and is ready to find a new home to call his own. He is a friendly soul who has an outstanding moustache and likes his fuss and grub. He would be best suited to an all adult home as he is used to an older home and likes to go with the flow. He would enjoy a quiet home as he knows what he wants as he can nip if you touch him in the wrong spot. Any people in the home will need to have had some previous cat experience and he will appreciate a home that lets him be a cat and express normal behaviour. He will also enjoy a garden but must have a cat flap fitted if you work a full day so he can be free to explore his own patch on his own terms. Mickie has had a cat bite abscess treated as well as having a tooth extracted and is now fine.', 'sleeping'),
(3, 'Cookie', '2019-12-10', 'cookie.jpg', 'small', 'dog', 'Boulevard 10, France', 'male', 'Fun-loving Cookie is an active and outgoing boy who craves human companionship. He\'s looking for a dedicated and knowledgeable owner who has researched his breed type. They will need to have plenty of time on their hands to teach him all the basics and continue his ongoing socialisation.', 'chasing the ball, eating, digging up bones'),
(4, 'Bella Boo', '2002-02-01', 'bella boo.jpg', 'large', 'dog', 'Chinatown 10, Hong Kong', 'female', 'Beautiful Bella Boo is a sensitive soul. It can take her a while to build an attachment with new people but once a bond has been built she becomes very attached and is extremely loyal. She\'s calm and well-behaved but doesn\'t cope with being left home alone so she\'s looking for a committed and understanding owner who is at home during the day and will give her the time and space to settle in.', 'sleeping'),
(5, 'Buddy', '1999-03-10', 'buddy.jpg', 'large', 'horse', 'Horsington street 21, Horsetown', 'male', 'Buddy is a 16.2h TB 21yrs old gelding born in New Zealand who retired from a successful UK racing career in 2005 and was with his new owner since then. He did local shows and hacking out then unfortunately in 2010 he became too ill to take care of him.', 'running'),
(6, 'Mr. Moo', '2017-08-19', 'mr moo.jpg', 'large', 'cow', 'Green Hills 234, Dublin', 'male', 'The iconic Highland cow is seen on many Kent Wildlife Trust reserves and is crucial in helping us achieve our conservation aims, clearing large areas of scrub and all manner of vegetation. They are handsome, docile and friendly herd animals and people love them.', 'grazing, chewing'),
(7, 'Alpi', '2018-12-10', 'alpi.jpg', 'large', 'alpaca', 'Grazing Hills 41, Greenland', 'male', 'This goofy looking animal will steal your heart.', 'grazing, chewing, spitting'),
(8, 'Lemmy', '2020-01-25', 'lemmy.jpg', 'small', 'lemur', 'Tree Boulevard 24, Madagascar', 'male', 'They are native only to the island of Madagascar. Most existing lemurs are small, have a pointed snout, large eyes, and a long tail. They chiefly live in trees (arboreal), and are active at night (nocturnal). Lemurs share resemblance with other primates, but evolved independently from monkeys and apes.', 'sitting on a tree'),
(9, 'Shee', '2019-09-10', 'shee.jpg', 'large', 'sheep', 'Grazing Hills 41, Greenland', 'female', 'Contrary to popular belief, sheep are extremely intelligent animals capable of problem solving. They are considered to have a similar IQ level to cattle and are nearly as clever as pigs. Like various other species including humans, sheep make different vocalisations to communicate different emotions. They also display and recognise emotion by facial expressions. Sheep are known to self-medicate when they have some illnesses. They will eat specific plants when ill that can cure them. Sheep are precocial (highly independent from birth) and gregarious (like to be in a group). Female sheep (ewes) are very caring mothers and form deep bonds with their lambs that can recognise them by their call (bleat) when they wander too far away. Egyptians believed that sheep were sacred. They even had them mummified when they died, just like humans.', 'grazing, chewing, looking'),
(10, 'JoJo', '2000-10-21', 'jojo.jpg', 'large', 'ape', 'Jungle Camp, Ibiza', 'male', 'When we first found JoJo in 2009, he was just skin and bone. His body was bent and weak from a lifetime of a poor diet and living chained up over an open sewer. Today JoJo is a handsome adult, and a very active individual in his enclosure, swinging around and spinning on the ropes. At meal times, JoJo still loves to take as much food as possible up to the high hammock in his enclosure. JoJo is a highly intelligent orangutan and enjoys every enrichment we provide. He loves problem-solving and is very skilled at getting food out of the various puzzles our care staff have prepared for him. He is also able to communicate with the medical team if he feels unwell. If he has a small wound on his back or wrist, he will point it out to his carers when they are doing their rounds. Thank you for helping us care for JoJo.', 'sitting in a tree, playing cards, eating bananas'),
(11, 'Toyah', '2012-04-05', 'toyah.jpg', 'small', 'dog', 'Landstraßer Hauptstraße 150, Vienna', 'female', 'Toyah is a sensitive girl who is looking for understanding and very experienced owners to help give her further guidance and manage some of her behaviours. She needs a calm and quiet adult only household away from towns in a rural setting. She is nervous of strangers so adopters will need to be prepared to work closely with the animal behaviour and welfare advisor, and be prepared to put a few simple measures in place in the home if expecting visitors. Toyah is a strong willed dog who will need ongoing training and management around other dogs, so adopters will have realistic expectations with regard to taking her out and about with them. She loves toys and games and will make a fun and interactive companion. Toyah is affectionate, comical, playful and intelligent.', 'relaxing, sleeping, getting pets'),
(12, 'Poppet', '2014-03-07', 'poppet.jpg', 'small', 'dog', 'Dog Street 10, Dogtown', 'female', 'Poppet would like a home where she can potter around with calm like-minded dogs, or have a nice fuss with her people. She is a lovely girl with a brilliant character that is sure to brighten up your day! She is currently in a foster home where she is getting five star treatment and enjoying the luxuries they have to offer. Any new owner will need to discuss her medical issues before they can take her home.', 'playing fetch');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `useremail` varchar(60) NOT NULL,
  `userpass` varchar(225) NOT NULL,
  `status` enum('user','admin','superadmin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `useremail`, `userpass`, `status`) VALUES
(1, 'superadmin', 'superadmin@superadmin.com', '186cf774c97b60a1c106ef718d10970a6a06e06bef89553d9ae65d938a886eae', 'superadmin'),
(2, 'admin', 'admin@admin.com', 'd82494f05d6917ba02f7aaa29689ccb444bb73f20380876cb05d1f37537b7892', 'admin'),
(3, 'user', 'user@user.com', 'e172c5654dbc12d78ce1850a4f7956ba6e5a3d2ac40f0925fc6d691ebb54f6bf', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usermail` (`useremail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
