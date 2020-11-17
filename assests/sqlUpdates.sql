
#29 june 2020

CREATE TABLE `resume_remark` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `remark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `resume_remark`
--
ALTER TABLE `resume_remark`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `resume_remark`
--
ALTER TABLE `resume_remark`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;