
-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `scenarios`
-- 

CREATE TABLE `scenarios` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `topic_id` int(10) unsigned default NULL COMMENT 'Topic the scenario is about.',
  `name` varchar(255) default NULL,
  `use_player` tinyint(1) NOT NULL default '1',
  `description` text,
  `introduction` text COMMENT 'Introductory, story-related text at the beginning of a scenario.',
  `epilogue` text COMMENT 'Story-related text given out at scenario completion',
  `score` int(11) NOT NULL default '0',
  `comparison` text COMMENT 'Evaluation string for scenarios with comparison-based evaluation type.',
  `evaluationtype_id` int(11) NOT NULL default '1' COMMENT 'Refers to the user input evaluation method: either shell-based or comparison-based.',
  `is_single_scenario` tinyint(1) NOT NULL default '0' COMMENT 'Scenario occupies the entire topology.',
  `is_multiplayer_scenario` tinyint(1) NOT NULL default '1' COMMENT 'Scneario can be played by multiple players.',
  `is_with_drones` tinyint(1) NOT NULL default '0' COMMENT 'Scenario involves simulated players (drones).',
  `timeout` int(11) NOT NULL default '0' COMMENT 'timeout in seconds',
  `approved` int(11) NOT NULL default '0',
  `player_id` int(11) NOT NULL default '0',
  `complete` int(11) NOT NULL default '0',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=144 ;

-- 
-- Daten für Tabelle `scenarios`
-- 

INSERT INTO `scenarios` (`id`, `topic_id`, `name`, `use_player`, `description`, `introduction`, `epilogue`, `score`, `comparison`, `evaluationtype_id`, `is_single_scenario`, `is_multiplayer_scenario`, `is_with_drones`, `timeout`, `approved`, `player_id`, `complete`, `created`, `modified`) VALUES 
(131, 5, '15 - Password Cracking (John)', 1, 'using John to decrypt the randomly generated password of a  root-user', 'You should logon via ssh to the machine. You will find the john executables in the john directory in your home directory. Use john to decrypt the unshadowed passwd file located in the john directory, named mypass.', 'Well done!', 150, '', 1, 0, 1, 0, 10, 1, 1, 127, '2008-04-16 15:38:14', '2008-09-22 12:20:09'),
(127, 1, '13 - Domain basics', 1, 'dummy', '<p>This scenario should show you, which records are stored by a registrar.</p>\r\nYour tasks:\r\n<ol>\r\n<li>Read the todo file</li> \r\n<li>Find your tool for whois query''s</li>\r\n<li>Start the query for the given domain</li>\r\n<li>Find out the records given in the table below</li>\r\n<li>Replace all <strong style="color:#F00;">?????</strong> with your answers</li>\r\n<li>Save the document</li>\r\n</ol>\r\nHint:\r\nFor your challenge you''re allowed to use tools like ''whois''.\r\nFor more informations about these tools use the man command like "man whois"<br>', '', 750, '', 1, 0, 0, 0, 10, 1, 1, 127, '2008-04-14 14:25:13', '2008-10-13 16:18:36'),
(128, 1, '12 - DNS basics', 1, '', '<p>Your boss needs some information about a domain.</p> \r\n<p>He prepared a file called <strong style="color:#F00;">todo</strong> on the DMZ server in your home directory.</p> \r\n<p>For your challenge you need  to use tools like <em>nslookup</em> and <em>dig</em></p> \r\n<p>You choose your prefered one. For more informations about these tools use the <em>man</em> command line <em>"man dig"</em></p>\r\nYour tasks:\r\n<ol>\r\n<li>login to the DMZ server</li> \r\n<li>find your tool for dns queries</li>\r\n<li>start the query for the domain specified in the <strong style="color:#F00;">todo</strong> file</li>\r\n<li>find out the records given your boss wants to know</li>\r\n<li>replace <strong style="color:#F00;">?????</strong> in the todo file with the information you found out</li>\r\n<li>save the document</li>\r\n</ol>\r\nHint: For PTR do a reverse lookup!', 'Your boss is very pleased with your quick answer.<br>\r\nWith the domain info he was able to convince a business partner to sign a contract.', 750, '', 1, 0, 0, 0, 10, 2, 1, 127, '2008-04-14 15:06:31', '2008-10-13 16:15:30'),
(129, 1, '06 - Console', 1, 'Getting general knowledge of the linux console.', '<p>This scenario will teach you where logfiles are located and how you get the IP Address of an interface without root rights.</p>\r\nYour tasks:\r\n<ol>\r\n<li>Find out in which directory log files normally would be saved.</li>\r\n<li>Check the log files, one of them must mention a secret tool.</li>\r\n<li>Copy this log file to your home directory.</li>\r\n<li>Detect the ip-address of the "eth1"-interface on your system.</li>\r\n<li>Rename the logfile in your home directory with this ip-address and don''t forget the .log extension.</li>\r\n</ol>\r\n', '', 100, '', 1, 0, 1, 0, 10, 1, 1, 127, '2008-04-16 12:24:51', '2008-10-06 14:01:01'),
(132, 4, '14 - Website defacement', 0, 'Deface a website.', '<p>You need to sniff some of your colleagues web traffic with the tool <strong>wireshark</strong> and thus try to find out the FTP password. Using it you can login with your colleague''s account via <strong>ssh</strong> and alter or erase the <i>index.html</i>  of the homepage.</p>', '', 400, '', 1, 0, 0, 0, 10, 1, 1, 127, '2008-04-17 15:57:37', '2008-10-27 13:30:16'),
(133, 6, 'Linux introduction', 1, '', 'Hello new employee, in order to test your company login credentials, you have to logon to the Company Webserver.', 'It seems your company login credentials are valid', 50, '', 1, 0, 1, 0, 10, 0, 1, 127, '2008-08-18 02:53:28', '2008-08-18 03:19:50'),
(134, 6, '01 - Linux basics', 1, '<p>You have to get familiar with our linux system. For today the command "apropos" is important.</p>\r\nYour tasks:\r\n<ol>\r\n<li>Find the name of the "GNU Bourne-Again SHell", type it into the comparison field and press submit.</li>\r\n</ol> \r\nIf you need a hint: man is short for manual, if you type man in front of a command you get the manual page displayed. ', '<p>You have to get familiar with our linux system. For today the commands "apropos" and "man" are important.</p> \r\nYour tasks:\r\n<ol>\r\n<li>Find me the name of the "GNU Bourne-Again SHell", type it into the comparison field and press submit.</li>\r\n</ol> \r\nIf you need a hint "man" is short for manual, if you type man in front of a command you get the manual page displayed (to exit the manual use the letter "q").<br>\r\nHint: It begins with the letter "b".\r\n', 'Well done.<br>\r\nDid you know, you can search through man pages?<br>\r\nJust use a "/" and write a word, complete your input with return. Then you can press n for next. If you think you are done just go back to the supervisor for further instructions.', 50, '/bash/', 2, 0, 1, 0, 10, 1, 1, 127, '2008-08-18 03:36:32', '2008-10-06 13:46:03'),
(135, 6, '04 - Basic searches', 1, '', '<p>This scenario will teach you how to find a file by name.</p>\r\nYour tasks:\r\n<ol>\r\n<li>"Find" the file called boss.orders.to. followed by your user name.</li>\r\n<li> Input the folder name where the file is located into the comparison string field.</li>\r\n</ol>', 'Nicely done. Now you know how to find files under Linux.<br>\r\nYou may know "vim" is a commandline editor. "vim test" edits the file test.<br>\r\nTo end the editing and write the file test you have to press the Esc key and write ":wq".', 50, '/geheim/', 2, 0, 1, 0, 10, 1, 1, 127, '2008-08-18 03:50:51', '2008-10-06 15:21:37'),
(136, 6, '11 - Linux identification', 1, '', '<p>This scenario will teach you things about Kernels and Releases.</p>\r\nYour tasks:\r\n<ol>\r\n<li>Find out which Kernel release (not the name) the machine is running.</li> \r\n<li>Pipe the output of the appropriate command into a file called "kernelRelease" into your home directory.</li> \r\n</ol>\r\nHint:<br>\r\nYou should use a tool to "print system information" in order to complete your task. ', 'Now we know which kernel Release we are running.<br>\r\nDid you know you can do reverse lookups with the command "nslookup".<br>\r\nA reverse lookup is when you search the domain name for an IP Address.', 100, '', 1, 0, 1, 0, 10, 1, 1, 127, '2008-08-18 04:09:38', '2008-10-06 15:13:21'),
(137, 6, '02 - ls basics', 1, 'What files are in which directory.', '<p>This scenario will teach you how to use the "ls" command.</p>\r\nYour tasks:\r\n<ol>\r\n<li>Look into your home directory into the folder target and identify its content with the command "ls". There is currently one file there.</li> \r\n</ol>\r\nHint: Type its filename into the comparison field.', 'Nicely done. Remember, this is important: you can add parameter to every command.<br>\r\nFor example "ls -l" is the process called ls executed with the parameter "l" which list files in the target directory so you can see ownership and rights of every file. If you think you are ready you can go back to the secretary for further instructions.', 50, '/hachmeier.pdf/', 2, 0, 1, 0, 10, 1, 1, 127, '2008-08-25 20:52:58', '2008-10-06 13:49:23'),
(138, 6, '03 - ls advanced', 1, '', '<p>This scenario will teach you how to use ls with additional parameters.</p>\r\nYour tasks:\r\n<ol>\r\n<li>In your home directory is another directory called target in which you will find a file.</li> \r\n<li>Identify the rights of the file</li>\r\n<li>Input these rights of the file into the comparison field.</li>\r\n</ol>\r\nThe right format is: <br>\r\nuser(rwx),group(rwx),other(rwx)<br>\r\nr is read<br>\r\nw is write<br>\r\nx is execute<br>\r\nThe string r-x------ would be read- and executeable by user.<br>\r\nHint: use ls  ', 'Very good! Please go back to the nerd for further instructions.', 100, '/rwx--x--x/', 2, 0, 1, 0, 10, 1, 1, 127, '2008-08-31 20:06:36', '2008-10-06 13:55:51'),
(130, 1, '05 - Vi/Vim', 1, 'Getting basic knowledge of Vi / Vim.', '<p>This scenario will teach you the basic handling of the vi editor.</p> \r\nThese are your tasks:\r\n<ol>\r\n<li>Find a file called <em>employees</em> on your system (it contains the string &quot;Myrath&quot;)</li>\r\n    <li>copy it to your home folder and modify the file in the following ways:</li>\r\n          <li>delete the data set of Bill Jobs</li>\r\n          <li>change the salary for Steve Gates to 100.000 (don''t forget the point)</li>\r\n          <li>add a &lt;holiday&gt; section with a value of 30 to every employee</li>\r\n    <li> save the changed file</li>\r\n</ol>\r\n<br>\r\nHint: vimtutor is a learning programm for vim.', 'Well done!<br>\r\nIf you are the next time on a Linux shell try using the Tabulator key (it''s for autocompletion).', 200, '', 1, 0, 1, 0, 10, 1, 1, 127, '2008-04-16 12:42:33', '2008-10-06 14:06:24'),
(139, 6, '07 - Linux basic file creation', 1, 'learn how to create a file', '<p>This scenario will teach you to use the commands "touch" and "cat".</p>\r\nYour tasks:\r\n<ol>\r\n<li>When you logged on with your account you must type "cat todo". A String will be displayed.</li>\r\n<li>This string should be the new filename which should be generated with the use of the tool touch.</li>\r\n</ol>', 'You might already know touch is also used to "touch" the date of a file (alter to current time).<br>\r\nVery important is the fact there is more than one way to finish the job.<br>\r\nYou could have used a pipe to redirect the standard output into a file.<br>\r\ncommand > filename    (redirect "std. out" into filename)<br>\r\ncommand1 | comand2     (uses the redirected "std. out" of command 1 as input for command2 )', 50, '', 1, 0, 1, 0, 10, 1, 1, 127, '2008-09-04 01:13:58', '2008-10-27 13:28:33'),
(140, 6, '08 - Linux advanced file creation', 1, '', '<p>This scenario will teach you how to deal with timestamps of files.</p>\r\nYour tasks:\r\n<ol>\r\n<li>Please change the timestamp of the file located in your home directory under target to the actual date.</li>\r\n</ol>', 'You really earned an award for the successful completion of the scenario.<br>\r\nDid you know you can pipe any output of any command into the next command with the help of "|", or just pipe the output into a file with ">".\r\n', 50, '', 1, 0, 1, 0, 10, 1, 1, 127, '2008-09-22 12:12:44', '2008-10-06 15:21:09'),
(141, 6, '09 - I/O stream basics', 1, '', '<p>This scenario will teach you how to use pipes.</p>\r\nYour tasks:\r\n<ol>\r\n<li> Read the todo file ("cat" todo). You will be presented  a name of a command.</li> \r\n<li>Pipe the manpage of the given command into the file "manpage" into the "target" directory located in your home directory</li>\r\n</ol>', 'You can use grep to find a string in a file or an output. It can also be used to locate a file with a specific string inside "grep -rsl string directory".', 100, '', 1, 0, 1, 0, 10, 1, 1, 127, '2008-09-22 12:14:15', '2008-10-06 15:07:25'),
(142, 6, '10 - advanced searches', 1, '', '<p>This scenario will teach you the amazing powers of the "grep" command.</p>\r\nYour tasks:\r\n<ol>\r\n<li>Read the todo file in your home directory (it contains a string).</li> \r\n<li>Locate the file containing the specified string</li>\r\n<li>Write its location incl. filename into the folder target, with the file name "location".</li>\r\n<br>\r\nHint: The file is somewhere under /var </ol>\r\n***Warning will get false positives when played on game engine machine***', '', 150, '', 1, 0, 1, 0, 10, 1, 1, 127, '2008-09-22 12:15:31', '2008-10-28 12:48:53');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `scenarios_skills`
-- 

CREATE TABLE `scenarios_skills` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `scenario_id` int(10) unsigned NOT NULL,
  `skill_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=152 ;

-- 
-- Daten für Tabelle `scenarios_skills`
-- 

INSERT INTO `scenarios_skills` (`id`, `scenario_id`, `skill_id`) VALUES 
(68, 138, 3),
(66, 134, 1),
(67, 137, 2),
(69, 135, 4),
(70, 130, 5),
(71, 129, 7),
(72, 139, 6),
(9, 141, 9),
(10, 142, 10),
(143, 136, 11),
(8, 140, 8),
(144, 128, 12),
(145, 127, 13),
(146, 132, 14),
(147, 131, 50);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `scenarios_systemaccounts`
-- 

CREATE TABLE `scenarios_systemaccounts` (
  `id` int(11) NOT NULL auto_increment,
  `scenario_id` int(11) NOT NULL,
  `systemaccount_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

-- 
-- Daten für Tabelle `scenarios_systemaccounts`
-- 

INSERT INTO `scenarios_systemaccounts` (`id`, `scenario_id`, `systemaccount_id`) VALUES 
(72, 132, 108),
(71, 132, 107),
(70, 132, 106),
(69, 132, 105),
(68, 132, 104),
(67, 132, 103),
(66, 132, 102),
(65, 132, 101),
(64, 132, 100),
(63, 132, 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `scenariosetups`
-- 

CREATE TABLE `scenariosetups` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `player_id` int(10) unsigned NOT NULL,
  `scenario_id` int(10) unsigned NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `scenariosetups`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `scripts`
-- 

CREATE TABLE `scripts` (
  `id` int(11) NOT NULL auto_increment,
  `description` varchar(255) default NULL,
  `name` varchar(45) default NULL,
  `script` text COMMENT 'The shell script code.',
  `scenario_id` int(11) default NULL COMMENT 'The scenario the shell script belongs to. ',
  `scripttype_id` int(11) default NULL COMMENT 'Script type mean the combination of one of the three categories environment, user, or drone plus the subcategories setup, evaluate and clean up.',
  `sequence_no` int(11) NOT NULL default '1' COMMENT 'Defines the succession of the script within the script stack.',
  `deployment_package` varchar(255) default NULL COMMENT 'Path to the tar file which deploys the file on the target system.',
  `player_id` int(11) default NULL COMMENT 'The logged in player.',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=172 ;

-- 
-- Daten für Tabelle `scripts`
-- 

INSERT INTO `scripts` (`id`, `description`, `name`, `script`, `scenario_id`, `scripttype_id`, `sequence_no`, `deployment_package`, `player_id`, `created`, `modified`) VALUES 
(129, 'a fake unshadowed passwd will be generated. The john executables will be copied to the user''s homedirectory', 'john player setup', '#!/bin/sh\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER  # Hacking game user name\\nH_PASSWORT=$CAKEPASS  # must be md5 encrypted\\n\\nif [ $(echo $H_USERNAME | wc -m) -eq 1 ]; then\\n  exit 3; #empty username = error and quit!\\nfi\\n\\n\\n#adduser and make home dir \\nuseradd -m $H_USERNAME -p $H_PASSWORT -s /bin/bash || exit $?\\necho $CAKEUSER:$CAKEPASS | chpasswd\\ncp /etc/skel/.bash_profile /home/$H_USERNAME/ || exit $?\\ncp /etc/skel/.bashrc /home/$H_USERNAME/ || exit $?\\n\\n#copy needed files\\n#put john.tar in the deployment field to have it deployed by game engine (not implemented yet)\\ncd /tmp/ || exit $?\\nmkdir -p /tmp/$H_USERNAME || exit $?\\nmv /tmp/john.tar /tmp/$H_USERNAME/ || exit $?\\ntar -xf /tmp/$H_USERNAME/john.tar || exit $?\\nmkdir -p /home/$H_USERNAME/john || exit $?\\ncp -r /tmp/john/run/* /home/$H_USERNAME/john || exit $?\\n#mv /home/$H_USERNAME/run /home/$H_USERNAME/john || exit $?\\n\\n\\n#create mypass file (fake unshadowed passw)\\npassw=$(echo $(date +%S)$(date +%M))\\npass=$( perl -e "print crypt($passw,''xy'');")\\npuser="root"$(echo $(date +%M))\\necho "$puser:$pass:1019:100::/home/$puser:/bin/bash"> /home/$H_USERNAME/john/mypass || exit $?\\n\\n#background_eval\\n#mkdir -p /tmp/$H_USERNAME || exit $?\\nBACKGROUND_EVAL=/tmp/$H_USERNAME/background_eval\\necho "#!/bin/sh" > $BACKGROUND_EVAL\\necho "USER_NAME=$H_USERNAME" >> $BACKGROUND_EVAL\\necho "RUNNING=1" >> $BACKGROUND_EVAL\\necho "echo" >> $BACKGROUND_EVAL\\necho "echo ======================================================" >> $BACKGROUND_EVAL\\necho "echo The john executable is located in home/$H_USERNAME/john." >> $BACKGROUND_EVAL\\necho "echo The unshadowed passwd is also located there and named" >> $BACKGROUND_EVAL\\necho "echo mypass. Good luck!" >> $BACKGROUND_EVAL\\necho "echo ======================================================" >> $BACKGROUND_EVAL\\nRUNNING=''$RUNNING''\\necho "while [ $RUNNING -eq 1 ]" >> $BACKGROUND_EVAL\\necho "do" >> $BACKGROUND_EVAL\\necho "if (cat /home/$H_USERNAME/john/john.pot | grep "$pass" >> /dev/null); then" >> $BACKGROUND_EVAL\\necho "RUNNING=0" >> $BACKGROUND_EVAL\\necho "fi" >> $BACKGROUND_EVAL\\necho "sleep 3" >> $BACKGROUND_EVAL\\necho "done" >> $BACKGROUND_EVAL\\necho "echo done >> done" >> $BACKGROUND_EVAL\\necho "sleep 10" >> $BACKGROUND_EVAL\\necho "killall -u $H_USERNAME sshd" >> $BACKGROUND_EVAL \\n\\n#change owner\\nchown -R $H_USERNAME:$H_USERNAME /home/$H_USERNAME || exit $?\\nchown $H_USERNAME:$H_USERNAME $BACKGROUND_EVAL || exit $?\\nchmod u+x $BACKGROUND_EVAL || exit $?\\nchmod o+x /home/$H_USERNAME/ || exit $?\\nchmod o+x /tmp/$H_USERNAME/ || exit $?\\n\\n#modify user .bashrc\\necho "$BACKGROUND_EVAL &" >> /home/$H_USERNAME/.bashrc || exit $?', 131, 3, 1, 'john.tar', 1, '2008-04-16 15:44:25', '2008-08-25 13:04:20'),
(149, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\n\\n\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	 # Hacking game user name\\nH_PASSWORD=$CAKEPASS     # Hacking game user pass\\n\\n#user check\\nif [ $(echo $H_USERNAME | wc -m) -eq 1 ]; then\\n  exit 3; #empty username = error and quit!\\nfi\\n\\n#internal parameter\\nFILE1=$CAKE1\\n \\n#adduser and make home dir \\nuseradd -m $CAKEUSER -p $CAKEPASS -s /bin/bash || exit $?\\necho "$CAKEUSER:$CAKEPASS" | chpasswd\\ncp /etc/skel/.bash_profile /home/$H_USERNAME/ || exit $?\\ncp /etc/skel/.bashrc /home/$H_USERNAME/ || exit $?\\n\\nmkdir -p /home/$CAKEUSER/target\\ntouch /home/$CAKEUSER/target/$FILE1\\necho "This is a Test File!!!" >> /home/$CAKEUSER/target/$FILE1\\n#change dir and file permissions\\nchown -R $H_USERNAME:$H_USERNAME /home/$H_USERNAME || exit $?\\n', 137, 3, 1, '', 1, '2008-08-25 21:05:02', '2008-09-22 10:35:29'),
(117, '', 'domain basics setup', '#!/bin/bash\\n\\n#external parameter\\nUSERNAME=$CAKEUSER	# Hacking game user name\\nPASSWORD=$CAKEPASS # must be md5 encrypted\\ndomain=$CAKE1  	# Domain to check\\n\\n#USERNAME=tester # Hacking game user name\\n#PASSWORD=lxSigVD0RJEAM  # must be md5 encrypted\\n#domain=hs-bremen.de  	# Domain to check\\n\\n\\nif [ $(echo $USERNAME | wc -m) -eq 1 ]; then\\n  exit 3; #empty username = error and quit!\\nfi\\n#just for the style\\nif [ "${#domain}" -gt 8 ]; then\\n	tabulator="\\t\\t"\\n	if [ "${#domain}" -gt 15 ]; then\\n		tabulator="\\t"\\n	fi\\nfi\\n\\n#internal parameter\\nBACKGROUND_SCRIPT=/tmp/$USERNAME/background_script\\nTODO_FILE=/home/$USERNAME/todo\\n\\n#functions\\n#script builder needs $mylist and $TARGET_AND_LOCATION\\nscriptbuild()\\n{ \\nfor i in "${mylist[@]}"; do\\n           echo  $i >> $TARGET_AND_LOCATION || exit 1\\ndone\\n}\\n\\n#chmodder needs $mylist and $newrights\\nchmodder()\\n{ \\nfor i in "${mylist[@]}"; do\\n           chmod $newrights $i > /dev/null 2>&1 || exit 1\\ndone\\n}\\n\\n#dirmaker needs $mylist \\ndirmaker()\\n{ \\nfor i in "${mylist[@]}"; do\\n           mkdir -p $i > /dev/null 2>&1 || exit 1\\ndone\\n}\\n\\n#funtion to make random querys need $mylist $record\\nrandomquery()\\n{	\\nrandom_number=$RANDOM	\\nlet "random_number %=${#mylist[@]}"\\nfor ((a=0; a<random_number ; a++))\\ndo\\n	declare -a checklist\\n	while [ "${#checklist[@]}" -le "$random_number" ]\\n	do\\n		check=0\\n		length=${#checklist[@]}	\\n		random_field=$RANDOM\\n		let "random_field %= ${#mylist[@]}"\\n		for ((x=0; x<=length ; x++))\\n		do\\n			if [ "${checklist[x]}" == "${mylist[$random_field]}" ]; then\\n				check=1\\n			fi\\n		done\\n		if [ "$check" -eq 0 ]; then\\n			checklist=( ${checklist[@]} ${mylist[$random_field]} )\\n		fi\\n	done\\n	#append todo file \\n	if [ "${#record}" -lt 7 ]; then \\n		tabulator2="\\t\\t"\\n	else\\n		tabulator2="\\t"\\n	fi\\n	if [ "${#checklist[$a]}" -lt 7 ]; then \\n		tabulator3="\\t\\t"\\n	else \\n		tabulator3="\\t"\\n	fi\\n	echo -e "$domain$tabulator $record$tabulator2 ${checklist[$a]}$tabulator3"''??????'' >> $TODO_FILE || exit 1\\ndone\\n}\\n\\n##end functions\\n\\n#adduser and make home dir \\nuseradd -m $USERNAME -p $PASSWORD -s /bin/bash > /dev/null 2>&1 || exit 1\\necho "$USERNAME:$CAKEPASS" | chpasswd > /dev/null 2>&1 || exit 1\\n\\n#add needed dirs\\nmylist=(/tmp/$USERNAME)\\ndirmaker\\n\\n#make the todo file\\nTARGET_AND_LOCATION=$TODO_FILE\\nmylist=(''# Hello User'' ''# You start with scenario domain'' ''# This scenario should show you, which records are stored by a registrar.'' ''# The records you have to find out are given in the table below.'' "# For your challenge you''re allowed to use tools like ''whois''." ''# For more informations about these tools use the man command like "man whois"'' ''#'' ''# 1) start the commandline'' "# 2) find your tool for whois query''s" ''# 3) start the query for the given domain'' ''# 4) find out the records given in the table below'' ''# 5) replace ????? with your answer'' ''# 6) save the document'' ''# 7) wait for a response'' ''#'' "# Please don''t change anything else in this document" ''#'' ''#'')\\nscriptbuild\\n\\n#append the random questions\\necho -e "Domain  $tabulator Record\\t\\t Field\\t\\t Entry" >> $TODO_FILE || exit 1\\n\\n#Functionality only for .com .net .org .edu .de .us\\ncase  ${domain#[(a-zA-Z0-9)|(_)|(-)]*.} in\\n	de)\\n		#Lists for DE Domains\\n		recordlist=( Admin-C Tech-C Zone-C )\\n		nameserver=Nserver\\n		#nameserver is always a query\\n		echo -e "$domain$tabulator $nameserver\\t $nameserver\\t??????" >> $TODO_FILE || exit 1\\n		#funtion to make random querys need $mylist $record\\n		for i in ${recordlist[@]}\\n		do\\n			record=$i\\n			case $i in\\n				${recordlist[0]}) \\n				mylist=( Type Name Address Pcode City Country Changed )\\n				randomquery\\n				;;\\n				${recordlist[1]})\\n				mylist=( Type Name Address Pcode City Country Phone Fax Email Changed )\\n				randomquery\\n				;;\\n				${recordlist[2]})\\n				mylist=( Type Name Address Pcode City Country Phone Fax Email Changed )\\n				randomquery\\n				;;\\n			esac\\n		done\\n	;;\\n	com)\\n		#Lists for Com Domains\\n		recordlist=( Registrant Administrative Technical )\\n		nameserver=Nameserver\\n		#nameserver is always a query\\n		echo -e "$domain$tabulator $nameserver\\t $nameserver\\t\\t??????" >> $TODO_FILE  || exit 1\\n		#funtion to make random querys need $mylist $record\\n		for i in ${recordlist[@]}\\n		do\\n			record=$i\\n			#List is always the same by .com\\n			mylist=( Name Organisation Address City State Country Postal Phone Fax Email Registration Updated )\\n			randomquery\\n		done\\n	;;\\n	net)\\n		#Lists for net Domains\\n		recordlist=( Registrant Administrative Technical )\\n		nameserver=Nameserver\\n		#nameserver is always a query\\n		echo -e "$domain$tabulator $nameserver\\t $nameserver\\t\\t??????" >> $TODO_FILE  || exit 1\\n		#funtion to make random querys need $mylist $record\\n		for i in ${recordlist[@]}\\n		do\\n			record=$i\\n			#List is always the same by .net\\n			mylist=( Name Organisation Address City State Country Postal Phone Fax Email Registration Updated )\\n			randomquery\\n		done\\n	;;\\n\\n	org)\\n		#Lists for org Domains\\n		recordlist=( Registrant Admin Tech )\\n		nameserver=Name\\n		#nameserver is always a query\\n		echo -e "$domain$tabulator Name\\t\\t Server\\t\\t??????" >> $TODO_FILE || exit 1\\n		#funtion to make random querys need $mylist $record\\n		for i in ${recordlist[@]}\\n		do\\n			record=$i\\n			#List is always the same by .org\\n			mylist=( Name Organisation Street City State Country Postal Phone FAX Email)\\n			randomquery\\n		done\\n	;;	\\n	edu)\\n		#Lists for edu Domains\\n		recordlist=( Registrant Administrative Technical )\\n		nameserver=Name\\n		#nameserver is always a query\\n		echo -e "$domain$tabulator $nameserver\\t\\t Servers\\t??????" >> $TODO_FILE || exit 1\\n		#funtion to make random querys need $mylist $record\\n		for i in ${recordlist[@]}\\n		do\\n			record=$i\\n			case $i in\\n				${recordlist[0]}) \\n				mylist=( Name Address City Country )\\n				randomquery\\n				;;\\n				${recordlist[1]})\\n				mylist=( Name Address City Country Tel Email )\\n				randomquery\\n				;;\\n				${recordlist[2]})\\n				mylist=( Name Address City Country Tel Email )\\n				randomquery\\n				;;\\n			esac\\n		done\\n	;;\\n	us)\\n		#Lists for us Domains\\n		recordlist=( Registrant Administrative Billing Technical )\\n		#nameserver isn''t given but Domain ID is a special field\\n		nameserver=Domain\\n		#nameserver is always a query\\n		echo -e "$domain$tabulator $nameserver\\t\\t ID\\t\\t??????" >> $TODO_FILE || exit 1\\n		#funtion to make random querys need $mylist $record\\n		for i in ${recordlist[@]}\\n		do\\n			record=$i\\n			#List is always the same in us\\n			mylist=( Name Address City State Postal Country Phone Email )\\n			randomquery\\n		done\\n	;;\\nesac\\n\\n\\n#make Background_script\\n\\nTARGET_AND_LOCATION=/tmp/$USERNAME/background_script\\n#mylist=(''#!/bin/bash'' "todo=$TODO_FILE" ''lastAccess=`stat $todo -c%x`'' ''lastMod=`stat $todo -c%y`'' ''checker()'' ''{''	''if [ "$check" == "" ]; then'' ''echo "your task isnt finished"'' ''let "verifier++"'' ''echo "Problem at ${domainlist[$a]} ${recordlist[$a]} ${fieldlist[$a]} ${entrylist[$a]}"'' ''fi'' ''}'' ''while [ "`stat $todo -c%x`" == "$lastAccess"  ]'' ''do'' ''sleep 10'' ''echo "You have to read $todo"'' ''done'' ''while [ checker=1 ]'' ''do'' ''while [ "`stat $todo -c%y`" == "$lastMod" ]'' ''do'' ''sleep 10'' ''done'' ''echo "we check your work"'' ''lastMod=`stat $todo -c%y`'' ''declare -a domainlist'' ''declare -a recordlist'' ''declare -a fieldlist'' ''declare -a stringlist'')\\n#scriptbuild\\n#something difficult to insert\\n#echo ''domainlist=(`grep -v "#" $todo | sed ''\\''s/[\\\\t \\\\ ]\\\\\\{1,\\\\\\}/:/g\\''''| awk -F: ''\\''{print ''$1''}\\''''`)'' >> $TARGET_AND_LOCATION\\n#echo ''recordlist=(`grep -v "#" $todo | sed ''\\''s/[\\\\t \\\\ ]\\\\\\{1,\\\\\\}/:/g\\''''| awk -F: ''\\''{print ''$2''}\\''''`)'' >> $TARGET_AND_LOCATION\\n#echo ''fieldlist=(`grep -v "#" $todo | sed ''\\''s/[\\\\t \\\\ ]\\\\\\{1,\\\\\\}/:/g\\''''| awk -F: ''\\''{print ''$3''}\\''''`)'' >> $TARGET_AND_LOCATION\\n#echo ''entrylist=(`grep -v "#" $todo | sed ''\\''s/[\\\\t \\\\ ]\\\\\\{1,\\\\\\}/:/g\\''''| awk -F: ''\\''{print ''$4''}\\''''`)'' >> $TARGET_AND_LOCATION\\n#mylist=(''entry=${#domainlist[@]}'' ''verifier=0'' ''for ((a=1; a<entry ; a++))'' ''do'' ''domain=${domainlist[$a]}'' ''case  ${domain#[(a-zA-Z0-9)|(_)|(-)]*.} in'' ''de)'' ''check=`whois ${domainlist[$a]} | grep -i -A 10 ${recordlist[$a]} | grep -i ${fieldlist[$a]} | grep -i ${entrylist[$a]}`'' ''checker'' '';;'' ''us)'' ''check=`whois ${domainlist[$a]} | grep -i ${recordlist[$a]} | grep -i ${fieldlist[$a]} | grep -i ${entrylist[$a]}`'' ''checker'' '';;'' ''org)'' ''check=`whois ${domainlist[$a]} | grep -i ${recordlist[$a]} | grep -i ${fieldlist[$a]} | grep -i ${entrylist[$a]}`'' ''checker'' '';;'' ''edu)'' ''check=`whois ${domainlist[$a]} | grep -i -A 10 ${recordlist[$a]} | grep -i ${entrylist[$a]}`'' ''checker'' '';;'' ''net)'' ''check=`whois ${domainlist[$a]} | grep -i -A 16 ${recordlist[$a]} | grep -i ${fieldlist[$a]} | grep -i ${entrylist[$a]}`'' ''checker'' '';;'' ''com)'' ''check=`whois ${domainlist[$a]} | grep -i -A 16 ${recordlist[$a]} | grep -i "${fieldlist[$a]}" | grep -i ${entrylist[$a]}`'' ''checker'' '';;'' ''esac'' ''done'' ''if [ "$verifier" -eq 0 ]; then'' ''echo "!!! Well done !!! You finished."'' ''exit 0'' ''fi'' ''done'')\\n#scriptbuild\\n\\n\\n#change dir and file permissions\\nchown -R $USERNAME:$USERNAME /home/$USERNAME/ > /dev/null 2>&1 || exit 1\\n#chown $USERNAME:$USERNAME $BACKGROUND_SCRIPT > /dev/null 2>&1 || exit 1\\n#chmod u+x $BACKGROUND_SCRIPT > /dev/null 2>&1 || exit 1\\n#modify user .bashrc\\n#echo "$BACKGROUND_SCRIPT &" >> /home/$USERNAME/.bashrc || exit 1\\nexit 0', 127, 3, 1, '', 1, '2008-04-14 14:36:10', '2008-10-06 14:58:33'),
(118, '', 'domain basics cleanup', '#!/bin/bash\\nUSERNAME=$CAKEUSER\\nkillall -u $CAKEUSER\\nrm -r /tmp/$CAKEUSER > /dev/null 2>&1 || exit 1\\ndeluser --remove-home $CAKEUSER > /dev/null 2>&1 || exit 1\\nexit 0\\n', 127, 4, 1, '', 1, '2008-04-14 14:36:42', '2008-08-25 14:24:47'),
(119, '', 'domain basics evaluation', '#!/bin/bash\\nuser=$CAKEUSER #username\\ntodo=/home/$user/todo\\ntmpfile=/tmp/${user}.whois\\nchecker()\\nif [ "$check" == "" ]; then\\n	# echo "your task isnt finished"\\n	let "verifier++"\\n        sleep 1\\n#echo "Problem at ${domainlist[$a]} ${recordlist[$a]} ${fieldlist[$a]} ${entrylist[$a]}"\\nfi\\ndeclare -a domainlist\\ndeclare -a recordlist\\ndeclare -a fieldlist\\ndeclare -a stringlist\\ndomainlist=(`grep -v "#" $todo | sed ''s/[\\t \\ ]\\{1,\\}/:/g''| awk -F: ''{print $1}''`) || exit 1\\nrecordlist=(`grep -v "#" $todo | sed ''s/[\\t \\ ]\\{1,\\}/:/g''| awk -F: ''{print $2}''`) || exit 1\\nfieldlist=(`grep -v "#" $todo | sed ''s/[\\t \\ ]\\{1,\\}/:/g''| awk -F: ''{print $3}''`) || exit 1\\nentrylist=(`grep -v "#" $todo | sed ''s/[\\t \\ ]\\{1,\\}/:/g''| awk -F: ''{print $4}''`) || exit 1\\nentry=${#domainlist[@]}\\nverifier=0\\ndomain=${domainlist[1]}\\n`whois $domain > $tmpfile`\\nfor ((a=1; a<entry ; a++))\\ndo\\n	check=`cat $tmpfile | grep -i -A 15 ${recordlist[$a]} | grep -i ${fieldlist[$a]} | grep -i ${entrylist[$a]}`\\n        checker\\ndone\\nrm $tmpfile\\nif [ "$verifier" -eq 0 ]; then\\n#	echo "finished"\\n	exit 2\\nelse\\n#	echo "not finished"\\n	exit 3\\nfi\\nexit 1', 127, 5, 1, '', 1, '2008-04-14 14:37:58', '2008-10-06 15:04:23'),
(120, '', 'dns basics setup', '#!/bin/bash\\n\\n#external parameter\\nUSERNAME=$CAKEUSER	# Hacking game user name\\nPASSWORD=$CAKEPASS # must be md5 encrypted\\nDOMAIN=$CAKE1  	# Domain to check\\nREVERSE=$CAKE2	# IP for Reverse Check \\n\\nif [ $(echo $USERNAME | wc -m) -eq 1 ]; then\\n  exit 1; #empty username = error and quit!\\nfi\\n\\n#internal parameter\\nBACKGROUND_SCRIPT=/tmp/$USERNAME/background_script\\nTODO_FILE=/home/$USERNAME/todo\\n\\n#functions\\n#script builder needs $mylist and $TARGET_AND_LOCATION\\nscriptbuild()\\n{ \\nfor i in "${mylist[@]}"; do\\n           echo  $i >> $TARGET_AND_LOCATION\\ndone\\n}\\n\\n#chmodder needs $mylist and $newrights\\nchmodder()\\n{ \\nfor i in "${mylist[@]}"; do\\n           chmod $newrights $i > /dev/null 2>&1 || exit 1\\ndone\\n}\\n\\n#dirmaker needs $mylist \\ndirmaker()\\n{ \\nfor i in "${mylist[@]}"; do\\n           mkdir -p $i > /dev/null 2>&1 || exit 1\\ndone\\n}\\n##end functions\\n\\n#adduser and make home dir \\nuseradd -m $USERNAME -p $PASSWORD -s /bin/bash > /dev/null 2>&1 || exit 1\\necho "$USERNAME:$CAKEPASS" | chpasswd\\n\\n#add needed dirs\\nmylist=(/tmp/$USERNAME)\\ndirmaker\\n\\n#make needed files\\nTARGET_AND_LOCATION=$TODO_FILE\\nmylist=(''# Hello User'' ''# You start with scenario dns'' ''# This scenario should show you, which records are stored in the dns.'' ''# The records you have to find out are given in the table below.'' "# For your challenge you''re allowed to use tools like ''nslookup'' and ''dig''." ''# Feel Free to choose your prefered one.'' ''# For more informations about these tools use the man command like "man dig"'' ''#'' ''# 1) start the commadline'' "# 2) find your tool for dns query''s" ''# 3) start the query for the given domain'' ''# 4) find out the records given in the table below'' ''# 5) replace ????? with your answer'' ''# 6) save the document'' ''# 7) wait for a response'' ''#'' "# Please don''t change anything else in this document" ''#'' ''#'')\\nscriptbuild\\n\\necho -e "Domain : \\t\\t\\t $DOMAIN" >> $TARGET_AND_LOCATION\\necho -e "A :	\\t\\t\\t ?????"	>> $TARGET_AND_LOCATION\\necho -e "MX :	\\t\\t\\t ?????"	>> $TARGET_AND_LOCATION\\necho -e "PTR $REVERSE:	\\t ?????"	>> $TARGET_AND_LOCATION\\n\\n#make Background_script\\n\\nTARGET_AND_LOCATION=$BACKGROUND_SCRIPT\\nmylist=("#!/bin/bash" "todo=$TODO_FILE" ''lastAccess=`stat $todo -c%x`'' ''lastMod=`stat $todo -c%y`'' ''while [ "`stat $todo -c%x`" == "$lastAccess"  ]'' ''do'' ''sleep 10'' ''echo "You have to read $todo"'' ''done''  ''while [ checker=1 ]'' ''do'' ''while [ "`stat $todo -c%y`" == "$lastMod" ]'' ''do'' ''sleep 10'' ''done'' ''echo "we check your work"'' ''lastMod=`stat $todo -c%y`'' ''declare -a todoList'' ''declare -a entryList'')\\n#scriptbuild\\n#something difficult to insert\\n#echo ''todoList=(`grep -v "#" $todo | sed ''\\''s/[\\\\\\\\t \\\\\\ ]\\\\\\\\\\{1,\\\\\\\\\\}//g\\''''| awk -F: ''\\''{print ''$1''}\\''''`)'' >> $TARGET_AND_LOCATION\\n#echo ''entryList=(`grep -v "#" $todo | sed ''\\''s/[\\\\\\\\t \\\\\\ ]\\\\\\\\\\{1,\\\\\\\\\\}//g\\''''| awk -F: ''\\''{print ''$2''}\\''''`)'' >> $TARGET_AND_LOCATION\\n\\nmylist=(''entrys=${#todoList[@]}'' ''domain=${entryList[0]}'' ''verifier=0'' ''for ((a=1; a<entrys ; a++))'' ''do'' ''if [ "${todoList[$a]}" == "${todoList[$a]#PTR}" ];'' ''then'' ''check=`dig ${todoList[$a]} $domain | grep ${entryList[$a]}`'' ''else'' ''check=`dig -x "${todoList[$a]#PTR}" | grep ${entryList[$a]}`'' ''fi''	''if [ "$check" == "" ]; then'' ''echo "You did not finish yet."'' ''echo "Fault with Record ${todoList[$a]} Entry ${entryList[$a]}."'' ''let "verifier++"'' ''fi''	''done'' ''if [ "$verifier" -eq 0 ]; then'' ''echo "!!! Well done !!! You finished."'' ''exit 0'' ''fi'' ''done'')\\n\\n#scriptbuild\\n\\n#change dir and file permissions\\nchown -R $USERNAME:$USERNAME /home/$USERNAME/ > /dev/null 2>&1 || exit 1\\n#chown $USERNAME:$USERNAME $BACKGROUND_SCRIPT > /dev/null 2>&1 || exit 1\\n#chmod u+x $BACKGROUND_SCRIPT > /dev/null 2>&1 || exit 1\\n\\n#modify user .bashrc\\n#echo "$BACKGROUND_SCRIPT &" >> /home/$USERNAME/.bashrc || exit 1\\nexit 0', 128, 3, 1, '', 1, '2008-04-14 15:09:24', '2008-09-29 16:08:41'),
(121, '', 'dns basics evaluation', '#!/bin/bash\\nuser=$CAKEUSER\\n\\ntodo=/home/$user/todo\\ndeclare -a todoList\\ndeclare -a entryList\\ntodoList=(`grep -v "#" $todo | sed ''s/[\\t \\ ]\\{1,\\}//g''| awk -F: ''{print $1}''`) || exit 1\\nentryList=(`grep -v "#" $todo | sed ''s/[\\t \\ ]\\{1,\\}//g''| awk -F: ''{print $2}''`) || exit 1\\nentrys=${#todoList[@]}\\ndomain=${entryList[0]}\\nverifier=0\\nfor ((a=1; a<entrys ; a++))\\ndo\\n	if [ "${todoList[$a]}" == "${todoList[$a]#PTR}" ]; then\\n		check=`dig ${todoList[$a]} $domain | grep ${entryList[$a]}` \\n	else\\n		check=`dig -x "${todoList[$a]#PTR}" | grep ${entryList[$a]}` \\n	fi\\nif [ "$check" == "" ]; then\\n	#echo "Fault with Record ${todoList[$a]} Entry ${entryList[$a]}."\\n	let "verifier++"\\nfi\\ndone\\nif [ "$verifier" -eq 0 ]; then\\n	#echo "finished."\\n	exit 2\\nelse\\n	#echo "not finished"\\n	exit 3\\nfi\\nexit 1', 128, 5, 1, '', 2, '2008-04-14 15:10:01', '2008-04-14 15:10:01'),
(122, '', 'dns basics cleanup', '#!/bin/bash\\nUSERNAME=$CAKEUSER\\nkillall -u $USERNAME sshd > /dev/null\\nrm -r /tmp/$USERNAME > /dev/null 2>&1 || exit 1\\ndeluser --remove-home $USERNAME > /dev/null 2>&1 || exit 1\\nexit 0', 128, 4, 1, '', 2, '2008-04-14 15:10:31', '2008-04-17 16:35:50'),
(123, 'Setting up the user data (secure.log, etc)', 'console setup', '#!/bin/bash\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	 # Hacking game user name\\nH_PASSWORD=$CAKEPASS      # must be md5 encrypted\\n\\n\\nif [ $(echo $H_USERNAME | wc -m) -eq 1 ]; then\\n  exit 3; #empty username = error and quit!\\nfi\\n\\n#internal parameter\\nLOG_FILE=/var/log/secure.log\\n\\n#adduser and make home dir \\nuseradd -m $H_USERNAME -p $H_PASSWORD -s /bin/bash || exit $?\\necho "$H_USERNAME:$CAKEPASS" | chpasswd\\ncp /etc/skel/.bash_profile /home/$H_USERNAME/ || exit $?\\ncp /etc/skel/.bashrc /home/$H_USERNAME/ || exit $?\\n\\n\\n\\n#change dir and file permissions\\nchown -R $H_USERNAME:$H_USERNAME /home/$H_USERNAME || exit $?\\n\\n', 129, 3, 1, '', 1, '2008-04-16 12:30:53', '2008-09-21 14:15:36'),
(159, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\nrm /var/log/secure.log > /dev/null', 129, 2, 1, '', 1, '2008-09-21 14:16:11', '2008-09-21 14:16:11'),
(124, 'checks the filename of copied secure.log', 'console evaluation', '#!/bin/sh\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	# Hacking game user name\\n\\n\\nRENAMEDFILE=/home/$H_USERNAME/$(ifconfig eth1|grep eth1 -A 1|cut -d ":" -f 2|cut -d " " -f 1|tail -n 1).log\\n\\n \\nif [ -f "$RENAMEDFILE" ]; then \\n	diff -q /var/log/secure.log $RENAMEDFILE >/dev/null 2>&1\\nRC=$?\\nif [ $RC -ne "0" ]; then\\n  exit 3;\\n\\nelse\\n  exit 2;\\nfi\\nelse\\n	exit 3;\\nfi', 129, 5, 1, '', 1, '2008-04-16 12:32:15', '2008-09-21 14:42:33'),
(125, 'removes copied file and user', 'console cleanup', '#!/bin/sh\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	# Hacking game user name\\nkillall -u $H_USERNAME sshd > /dev/null\\n\\n\\nRC=0\\ndeluser --remove-home $H_USERNAME > /dev/null || RC=$? \\nexit $RC', 129, 4, 1, '', 1, '2008-04-16 12:32:57', '2008-09-21 14:15:56'),
(126, '', 'Vi setup', '#!/bin/bash\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	# Hacking game user name\\nH_PASSWORD=$CAKEPASS      # must be md5 encrypted\\n\\nif [ $(echo $H_USERNAME | wc -m) -eq 1 ]; then\\n  exit 3; #empty username = error and quit!\\nfi\\n\\n\\n\\n#adduser and make home dir \\nuseradd -m $H_USERNAME -p $H_PASSWORD -s /bin/bash || exit $?\\necho "$H_USERNAME:$CAKEPASS" | chpasswd\\ncp /etc/skel/.bash_profile /home/$H_USERNAME/ || exit $?\\ncp /etc/skel/.bashrc /home/$H_USERNAME/ || exit $?\\n\\n\\n\\n\\n#change dir and file permissions\\nchown -R $H_USERNAME:$H_USERNAME /home/$H_USERNAME || exit $?\\n', 130, 3, 1, '', 1, '2008-04-16 12:46:02', '2008-09-21 14:46:14'),
(160, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\n#internal parameter\\nCHANGEFILE=/usr/share/employees\\n#make needed files\\n   #employees\\n\\necho "<data>" > $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>122</number>" >> $CHANGEFILE\\necho "		<forename>Heiko</forename>" >> $CHANGEFILE\\necho "		<surname>Meyer</surname>" >> $CHANGEFILE\\necho "		<salary>12.000</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>123</number>" >> $CHANGEFILE\\necho "		<forename>Dieter</forename>" >> $CHANGEFILE\\necho "		<surname>Machielsky</surname>" >> $CHANGEFILE\\necho "		<salary>14.000</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>125</number>" >> $CHANGEFILE\\necho "		<forename>Mathilde</forename>" >> $CHANGEFILE\\necho "		<surname>Brehmer</surname>" >> $CHANGEFILE\\necho "		<salary>23.900</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>126</number>" >> $CHANGEFILE\\necho "		<forename>Holger</forename>" >> $CHANGEFILE\\necho "		<surname>Schmidt</surname>" >> $CHANGEFILE\\necho "		<salary>11.000</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>128</number>" >> $CHANGEFILE\\necho "		<forename>Max</forename>" >> $CHANGEFILE\\necho "		<surname>Dax</surname>" >> $CHANGEFILE\\necho "		<salary>29.000</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>129</number>" >> $CHANGEFILE\\necho "		<forename>Susanne</forename>" >> $CHANGEFILE\\necho "		<surname>Feudel</surname>" >> $CHANGEFILE\\necho "		<salary>18.230</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>134</number>" >> $CHANGEFILE\\necho "		<forename>Myrath</forename>" >> $CHANGEFILE\\necho "		<surname>Staglos</surname>" >> $CHANGEFILE\\necho "		<salary>14.200</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>135</number>" >> $CHANGEFILE\\necho "		<forename>Mike</forename>" >> $CHANGEFILE\\necho "		<surname>Doode</surname>" >> $CHANGEFILE\\necho "		<salary>17.300</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>136</number>" >> $CHANGEFILE\\necho "		<forename>Jens</forename>" >> $CHANGEFILE\\necho "		<surname>Kalusche</surname>" >> $CHANGEFILE\\necho "		<salary>11.300</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>137</number>" >> $CHANGEFILE\\necho "		<forename>Bill</forename>" >> $CHANGEFILE\\necho "		<surname>Jobs</surname>" >> $CHANGEFILE\\necho "		<salary>89.000</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>138</number>" >> $CHANGEFILE\\necho "		<forename>Steve</forename>" >> $CHANGEFILE\\necho "		<surname>Gates</surname>" >> $CHANGEFILE\\necho "		<salary>1</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>140</number>" >> $CHANGEFILE\\necho "		<forename>George</forename>" >> $CHANGEFILE\\necho "		<surname>Tree</surname>" >> $CHANGEFILE\\necho "		<salary>800</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>142</number>" >> $CHANGEFILE\\necho "		<forename>Hans-Georg</forename>" >> $CHANGEFILE\\necho "		<surname>Schneider</surname>" >> $CHANGEFILE\\necho "		<salary>23.280</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>143</number>" >> $CHANGEFILE\\necho "		<forename>Melanie</forename>" >> $CHANGEFILE\\necho "		<surname>Dreist</surname>" >> $CHANGEFILE\\necho "		<salary>14.500</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>144</number>" >> $CHANGEFILE\\necho "		<forename>Beate</forename>" >> $CHANGEFILE\\necho "		<surname>Heide</surname>" >> $CHANGEFILE\\necho "		<salary>21.200</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "	<employee>" >> $CHANGEFILE\\necho "		<number>145</number>" >> $CHANGEFILE\\necho "		<forename>Matthias</forename>" >> $CHANGEFILE\\necho "		<surname>Koehler</surname>" >> $CHANGEFILE\\necho "		<salary>19.300</salary>" >> $CHANGEFILE\\necho "	</employee>" >> $CHANGEFILE\\necho "</data>" >> $CHANGEFILE\\nchmod 777 $CHANGEFILE || exit $?\\nchmod o-wx $CHANGEFILE || exit $?\\nexit 0', 130, 1, 1, '', 1, '2008-09-21 14:46:36', '2008-09-21 14:53:57'),
(127, 'Checks file modifications', 'Vi evaluation', '#!/bin/sh\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER # Hacking game user name\\n\\n\\n\\nCHANGEFILE=/home/$CAKEUSER/employees\\n\\nHOLIDAY=$(grep -c ''<holiday>30</holiday>'' $CHANGEFILE) #muss 15 sein\\nBILL=$(grep -c ''Bill'' $CHANGEFILE) #muss 0 sein\\nTOP=$(grep -c ''<salary>100.000</salary>'' $CHANGEFILE) #muss 1 sein\\n\\nif [ "$HOLIDAY" -eq 15 ]; then\\n	if [ "$BILL" -eq 0 ]; then\\n		if [ "$TOP" -eq 1 ]; then\\n			exit 2;\\n		fi\\n	fi\\nfi\\n\\nexit 3;', 130, 5, 1, '', 1, '2008-04-16 12:46:44', '2008-09-29 13:44:27'),
(128, 'Removes user and employee file', 'Vi cleanup', '#!/bin/sh\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER # Hacking game user name\\nkillall -u $H_USERNAME sshd > /dev/null\\n\\n\\nRC=0\\ndeluser --remove-home $H_USERNAME >/dev/null|| RC=$? > /dev/null\\nexit $RC', 130, 4, 1, '', 1, '2008-04-16 12:48:27', '2008-09-21 14:46:51'),
(130, 'evaluation script to know when scenario is done', 'john player evaluation', '#/bin/sh\\nH_USERNAME=$CAKEUSER\\n\\nif (cat /home/$H_USERNAME/done | grep done > /dev/null); then\\n exit 2;\\nelse\\n exit 3;\\nfi', 131, 5, 1, '', 2, '2008-04-16 15:47:37', '2008-04-17 15:50:37'),
(131, 'removes files, directorys and the user from the machine', 'player cleanup script', '#!/bin/sh\\nH_USERNAME=$CAKEUSER\\n\\nRC=0\\nkillall -u $H_USERNAME sshd\\ndeluser -q --remove-home $H_USERNAME || RC=$?\\nrm -r /tmp/john || RC=$?\\nrm -r /tmp/$H_USERNAME || RC=$?\\nexit $RC', 131, 4, 1, '', 1, '2008-04-16 15:48:51', '2008-06-26 14:56:42'),
(132, '', 'new script', '#!/bin/sh\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER  # Hacking game user name\\nH_PASSWORT=$CAKEPASS  # must be md5 encrypted\\n\\nif [ $(echo $CAKEUSER | wc -m) -eq 1 ]; then\\n  exit 3; #empty username = error and quit!\\nfi\\n\\n#internal parameter\\n#BACKGROUND_EVAL=/tmp/$H_USERNAME/background_eval\\nHTML_FILE=/home/$H_USERNAME/www/index.html\\nDELIMITER=$(12 - $(echo "$H_USERNAME"| wc -m))\\n\\n#adduser and make home dir \\nuseradd -m $CAKEUSER -p $H_PASSWORT -s /bin/bash|| exit $?\\necho "$CAKEUSER:$H_PASSWORT" | chpasswd\\ncp /etc/skel/.bash_profile /home/$H_USERNAME/\\ncp /etc/skel/.bashrc /home/$H_USERNAME/\\n\\n#add needed dirs\\nmkdir -p /home/$H_USERNAME/www/ || exit $?\\nmkdir -p /var/www/$H_USERNAME/ || exit $?\\nmkdir -p /tmp/$H_USERNAME || exit $?\\n\\n\\n#make needed files\\n   #index.html\\necho "<html>" > $HTML_FILE\\necho "<head>" >> $HTML_FILE\\necho "<title>" >> $HTML_FILE\\necho " Hello World Hacking Document" >> $HTML_FILE\\necho "</title>" >> $HTML_FILE\\necho "</head>" >> $HTML_FILE\\necho "<body>" >> $HTML_FILE\\necho "Hello, World!" >> $HTML_FILE\\necho "</body>" >> $HTML_FILE\\necho "</html>" >> $HTML_FILE\\n\\n\\n#background_eval\\n#echo "#!/bin/sh" > $BACKGROUND_EVAL\\n#echo "USER_NAME=$H_USERNAME" >> $BACKGROUND_EVAL\\n#echo "ORIGINAL=/tmp/\\\\$USER_NAME/index.html" >> $BACKGROUND_EVAL\\n#echo "WEBSITE=/var/www/\\\\$USER_NAME/index.html" >> $BACKGROUND_EVAL\\n#echo "RUNNING=1" >> $BACKGROUND_EVAL\\n#echo "while [ \\\\$RUNNING -eq 1 ]" >> $BACKGROUND_EVAL\\n#echo "do" >> $BACKGROUND_EVAL\\n#echo "sleep 3" >> $BACKGROUND_EVAL\\n#echo "diff -q \\\\$ORIGINAL \\\\$WEBSITE >/dev/null 2>&1 || RUNNING=0" >> $BACKGROUND_EVAL\\n#echo "done" >> $BACKGROUND_EVAL\\n#echo "echo " >> $BACKGROUND_EVAL\\n#echo "echo arrrg, my super duper website was defaced!" >> $BACKGROUND_EVAL\\n#echo "echo your task is done." >> $BACKGROUND_EVAL\\n#echo "echo you will be logged out in 5 sek." >> $BACKGROUND_EVAL     \\n#echo "sleep 5" >> $BACKGROUND_EVAL\\n#echo "killall -u $H_USERNAME sshd" >> $BACKGROUND_EVAL \\n\\n#change dir and file permissions\\nchown -R $H_USERNAME:$H_USERNAME /home/$H_USERNAME/ || exit $?\\n#chown $H_USERNAME:$H_USERNAME $BACKGROUND_EVAL || exit $?\\n#chmod u+x $BACKGROUND_EVAL || exit $?\\nchmod o+x /home/$H_USERNAME/ || exit $?\\nchmod o+x /home/$H_USERNAME/www || exit $?\\nchmod o+x /tmp/$H_USERNAME/ || exit $?\\nmount --bind /home/$H_USERNAME/www /var/www/$H_USERNAME/ || exit $?\\ncp $HTML_FILE /tmp/$H_USERNAME || exit $?\\n\\n#modify user .bashrc\\n#echo "$BACKGROUND_EVAL &" >> /home/$H_USERNAME/.bashrc || exit $?', 132, 3, 1, '', 1, '2008-04-17 15:59:32', '2008-10-13 16:52:34'),
(133, '', 'user eval', '#/bin/sh\\nH_USERNAME=$CAKEUSER\\n\\ndiff -q /tmp/$H_USERNAME/index.html /var/www/$H_USERNAME/index.html >/dev/null 2>&1\\nRC=$?\\nif [ $RC -ne "0" ]; then\\n  exit 2;\\n  # if file has been erased or changed RC != 0\\n  # but for cake we have to return 0 to indicate success!!!\\nelse\\n  exit 3;\\nfi\\n', 132, 5, 1, '', 1, '2008-04-17 16:00:09', '2008-08-25 13:17:14'),
(134, '', 'cleanup', '#!/bin/sh\\nH_USERNAME=$CAKEUSER\\n#if [ $(echo $CAKEUSER | wc -m) -eq 1 ]; then\\n#  exit 0; 	#empty username = error and quit!\\n#fi\\nRC=0\\nkillall -u $CAKEUSER sshd > /dev/null\\numount /var/www/$CAKEUSER >/dev/null|| RC=$?\\nrm -r /var/www/$CAKEUSER >/dev/null|| RC=$?\\nrm -r /tmp/$CAKEUSER >/dev/null|| RC=$?\\ndeluser --remove-home $CAKEUSER >/dev/null|| RC=$?\\nexit $RC', 132, 4, 1, '', 1, '2008-04-17 16:00:36', '2008-10-28 16:07:01'),
(135, '', 'user setup', '#!/bin/bash\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	 # Hacking game user name\\nH_PASSWORD=$CAKEPASS     # Hacking game user pass\\n\\n\\n \\n#adduser and make home dir \\nuseradd -m $CAKEUSER -p $CAKEPASS -s /bin/bash|| exit $?\\necho "$H_USERNAME:$CAKEPASS" | chpasswd\\ncp /etc/skel/.bash_profile /home/$H_USERNAME/ || exit $?\\ncp /etc/skel/.bashrc /home/$H_USERNAME/ || exit $?\\n\\n#change dir and file permissions\\nchown -R $H_USERNAME:$H_USERNAME /home/$H_USERNAME || exit $?\\n\\nexit 0', 133, 3, 1, '', 1, '2008-08-18 02:54:58', '2008-08-18 03:19:47'),
(138, '', 'new script', '#!/bin/bash\\n\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	 # Hacking game user name\\nH_PASSWORD=$CAKEPASS     # Hacking game user pass\\n\\n\\n \\n#adduser and make home dir \\nuseradd -m $CAKEUSER -p $CAKEPASS -s /bin/bash || exit $?\\necho "$H_USERNAME:$CAKEPASS" | chpasswd\\ncp /etc/skel/.bash_profile /home/$H_USERNAME/ || exit $?\\ncp /etc/skel/.bashrc /home/$H_USERNAME/ || exit $?\\n\\n#change dir and file permissions\\nchown -R $H_USERNAME:$H_USERNAME /home/$H_USERNAME || exit $?\\nexit 0', 134, 3, 1, '', 1, '2008-08-18 03:38:29', '2008-08-18 03:38:29'),
(136, '', 'eval', '#!/bin/bash \\n#external parameter\\nH_USERNAME=$CAKEUSER	# Hacking game user name\\ndate| cut -d " " -f 2|cut -d "." -f 1 > /home/$H_USERNAME/new\\ndate| cut -d ":" -f 1|cut -d " " -f 4 >> /home/$H_USERNAME/new\\ngrep "session opened for user $H_USERNAME" /var/log/auth.log|grep sshd|cut -d "." -f 1 > /home/$H_USERNAME/old\\ngrep "session opened for user $H_USERNAME" /var/log/auth.log|grep sshd|cut -d " " -f 4 > /home/$H_USERNAME/old\\ndiff -q /home/$H_USERNAME/new /home/$H_USERNAME/old >/dev/null 2>&1\\nrm /home/$H_USERNAME/new >/dev/null\\nrm /home/$H_USERNAME/old >/dev/null\\nRC=$?\\nif [ $RC -ne "0" ]; then\\n exit 3;\\n # if file has been erased or changed RC != 0\\n # but for cake we have to return 0 to indicate success!!!\\nelse\\n exit 2;\\nfi\\n', 133, 5, 1, '', 1, '2008-08-18 02:55:40', '2008-08-18 03:05:10'),
(137, '', 'cleanup', '#!/bin/bash \\n#external parameter\\nH_USERNAME=$CAKEUSER	# Hacking game user name\\n#internal parameter\\nRC=0\\ndeluser --remove-home $H_USERNAME > /dev/null || RC=$? \\nexit $RC\\n', 133, 4, 1, '', 1, '2008-08-18 02:56:23', '2008-08-18 03:05:17'),
(139, '', 'new script', '#!/bin/bash \\n#external parameter\\nH_USERNAME=$CAKEUSER	# Hacking game user name\\n#internal parameter\\nRC=0\\nkillall -u $CAKEUSER sshd > /dev/null\\ndeluser --remove-home $H_USERNAME > /dev/null || RC=$? \\nexit $RC\\n', 134, 4, 1, '', 1, '2008-08-18 03:38:55', '2008-09-03 13:43:11'),
(140, '', 'new script', '#!/bin/bash\\n\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	 # Hacking game user name\\nH_PASSWORD=$CAKEPASS     # Hacking game user pass\\n\\n\\n \\n#adduser and make home dir \\nuseradd -m $CAKEUSER -p $CAKEPASS -s /bin/bash || exit $?\\necho "$H_USERNAME:$CAKEPASS" | chpasswd\\ncp /etc/skel/.bash_profile /home/$CAKEUSER/ || exit $?\\ncp /etc/skel/.bashrc /home/$CAKEUSER/ || exit $?\\n\\n#change dir and file permissions\\nchown -R $H_USERNAME:$H_USERNAME /home/$H_USERNAME || exit $?\\nmkdir -p /$CAKE1\\ntouch /$CAKE1/boss.orders.to.$H_USERNAME > /dev/null\\nexit 0', 135, 3, 1, '', 1, '2008-08-18 03:51:15', '2008-08-18 04:03:30'),
(142, '', 'new script', '#!/bin/bash\\n\\n\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	 # Hacking game user name\\nH_PASSWORD=$CAKEPASS     # Hacking game user pass\\n\\n \\n#adduser and make home dir \\nuseradd -m $CAKEUSER -p $CAKEPASS -s /bin/bash || exit $?\\necho "$H_USERNAME:$CAKEPASS" | chpasswd\\ncp /etc/skel/.bash_profile /home/$H_USERNAME/ || exit $?\\ncp /etc/skel/.bashrc /home/$H_USERNAME/ || exit $?\\n\\n#change dir and file permissions\\nchown -R $H_USERNAME:$H_USERNAME /home/$H_USERNAME || exit $?\\nexit 0', 136, 3, 1, '', 1, '2008-08-18 04:10:56', '2008-08-18 04:13:51'),
(141, '', 'new script', '#!/bin/bash \\n#external parameter\\nH_USERNAME=$CAKEUSER	# Hacking game user name\\nkillall -u $CAKEUSER sshd > /dev/null\\n#internal parameter\\nRC=0\\ndeluser --remove-home $H_USERNAME > /dev/null || RC=$? \\nrm /$CAKE1/boss.orders.to.$H_USERNAME\\nexit $RC\\n', 135, 4, 1, '', 1, '2008-08-18 03:51:38', '2008-09-15 11:01:35'),
(143, '', 'new script', '#!/bin/bash \\n#external parameter\\nkillall -u $CAKEUSER sshd > /dev/null\\nH_USERNAME=$CAKEUSER	# Hacking game user name\\n#internal parameter\\nRC=0\\ndeluser --remove-home $H_USERNAME > /dev/null || RC=$? \\nexit $RC\\n', 136, 4, 1, '', 1, '2008-08-18 04:11:15', '2008-08-25 11:56:46'),
(144, '', 'new script', '#!/bin/bash \\n#external parameter\\nH_USERNAME=$CAKEUSER	# Hacking game user name\\nuname -r > /home/$H_USERNAME/rightRelease\\ndiff -q /home/$H_USERNAME/kernelRelease /home/$H_USERNAME/rightRelease >/dev/null 2>&1\\nRC=$?\\nif [ $RC -ne "0" ]; then\\n rm /home/$H_USERNAME/rightRelease >/dev/null\\n exit 3;\\n # if file has been erased or changed RC != 0\\n # but for cake we have to return 3 to indicate success!!!\\nelse\\n rm /home/$H_USERNAME/rightRelease >/dev/null\\n exit 2;\\nfi\\n\\n', 136, 5, 1, '', 1, '2008-08-18 04:13:38', '2008-08-25 11:54:50'),
(145, '', 'new script', '#!/bin/bash\\n#apt-get install nslookup -y', 128, 1, 1, '', 1, '2008-08-18 04:20:30', '2008-08-25 11:17:08'),
(146, '', 'new script', '#!/bin/bash\\napt-get remove --purge nslookup -y', 128, 2, 1, '', 1, '2008-08-18 04:21:15', '2008-08-18 04:21:15'),
(147, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\napt-get install whois -y >/dev/null', 127, 1, 1, '', 1, '2008-08-18 04:21:52', '2008-08-25 14:32:08'),
(148, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\napt-get remove --purge whois > /dev/null', 127, 2, 1, '', 1, '2008-08-18 04:22:12', '2008-08-25 14:32:21'),
(150, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n#external parameter\\nH_USERNAME=$CAKEUSER	# Hacking game user name\\n#internal parameter\\nRC=0\\nkillall -u $CAKEUSER sshd > /dev/null\\ndeluser --remove-home $H_USERNAME > /dev/null || RC=$? \\nexit $RC\\n', 137, 4, 1, '', 1, '2008-08-25 21:06:00', '2008-09-15 11:01:03'),
(151, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\n\\n\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	 # Hacking game user name\\nH_PASSWORD=$CAKEPASS     # Hacking game user pass\\n\\n#user check\\nif [ $(echo $H_USERNAME | wc -m) -eq 1 ]; then\\n  exit 3; #empty username = error and quit!\\nfi\\n\\n#internal parameter\\nFILE1=$CAKE1\\n \\n#adduser and make home dir \\nuseradd -m $CAKEUSER -p $CAKEPASS -s /bin/bash || exit $?\\necho "$CAKEUSER:$CAKEPASS" | chpasswd\\ncp /etc/skel/.bash_profile /home/$H_USERNAME/ || exit $?\\ncp /etc/skel/.bashrc /home/$H_USERNAME/ || exit $?\\n\\nmkdir -p /home/$CAKEUSER/target\\ntouch /home/$CAKEUSER/target/$FILE1\\nchmod u+x /home/$CAKEUSER/target/$FILE1\\nchmod go-r /home/$CAKEUSER/target/$FILE1\\nchmod go+x /home/$CAKEUSER/target/$FILE1\\n#change dir and file permissions\\nchown -R $H_USERNAME:$H_USERNAME /home/$H_USERNAME || exit $?', 138, 3, 1, '', 1, '2008-08-31 20:08:46', '2008-08-31 20:16:04'),
(152, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n#external parameter\\nH_USERNAME=$CAKEUSER	# Hacking game user name\\n#internal parameter\\nRC=0\\nkillall -u $CAKEUSER sshd > /dev/null\\ndeluser --remove-home $H_USERNAME > /dev/null || RC=$? \\nexit $RC\\n', 138, 4, 1, '', 1, '2008-08-31 20:09:10', '2008-09-01 10:45:47'),
(153, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\n\\n\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	 # Hacking game user name\\nH_PASSWORD=$CAKEPASS     # Hacking game user pass\\n\\n#user check\\nif [ $(echo $H_USERNAME | wc -m) -eq 1 ]; then\\n  exit 3; #empty username = error and quit!\\nfi\\n\\n#internal parameter\\n\\n \\n#adduser and make home dir \\nuseradd -m $CAKEUSER -p $CAKEPASS -s /bin/bash || exit $?\\necho "$CAKEUSER:$CAKEPASS" | chpasswd\\ncp /etc/skel/.bash_profile /home/$H_USERNAME/ || exit $?\\ncp /etc/skel/.bashrc /home/$H_USERNAME/ || exit $?\\n\\necho "$CAKE1" > /home/$CAKEUSER/todo\\n\\n#change dir and file permissions\\nchown -R $H_USERNAME:$H_USERNAME /home/$H_USERNAME || exit $?', 139, 3, 1, '', 1, '2008-09-04 01:16:12', '2008-09-04 01:22:44'),
(154, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\nif [ -n "`ls /home/$CAKEUSER/$CAKE1`" ]; then\\nexit 2\\nelse\\nexit 3\\nfi', 139, 5, 1, '', 1, '2008-09-04 01:16:46', '2008-09-04 01:16:46'),
(155, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\n#internal parameter\\nRC=0\\nkillall -u $CAKEUSER sshd > /dev/null\\ndeluser --remove-home $CAKEUSER > /dev/null || RC=$? \\nexit $RC', 139, 4, 1, '', 1, '2008-09-04 01:18:40', '2008-09-04 01:18:40'),
(156, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\nmkdir -p /$CAKE1', 135, 1, 1, '', 1, '2008-09-15 10:49:27', '2008-09-15 10:49:27'),
(157, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\nif [ $(echo $CAKE1 | wc -m) -eq 1 ]; then\\n  exit 4; 	#empty username = error and quit!\\nfi\\n\\nrm -R /$CAKE1', 135, 2, 1, '', 1, '2008-09-15 10:51:59', '2008-09-15 10:51:59'),
(158, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\n#make needed files\\n   #secure.log\\necho "Jan 05 14:23:01 secret tool: just made a very secret operation" > /var/log/secure.log\\necho "Jan 05 14:23:06 secret tool: just made a very secret operation" >> /var/log/secure.log\\necho "Jan 05 14:23:13 secret tool: delete some heavy stuff" >> /var/log/secure.log\\necho "Jan 05 14:23:15 secret tool: don''t tell anybody about this special operation" >> /var/log/secure.log\\nchmod 744 /var/log/secure.log || exit $?', 129, 1, 1, '', 1, '2008-09-21 14:15:06', '2008-09-21 14:26:07'),
(161, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\nrm /usr/share/employees > /dev/null\\nexit 0', 130, 2, 1, '', 1, '2008-09-21 14:47:07', '2008-09-21 14:47:07'),
(162, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\nif [ "`ls -la  /home/$CAKEUSER/target/$CAKE1|cut -d " " -f 6`" = "1978-09-01" ]; then\\n exit 3;\\nelse\\n exit 2;\\nfi\\n', 140, 5, 1, '', 1, '2008-09-22 16:23:47', '2008-09-29 15:41:33'),
(163, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	 # Hacking game user name\\nH_PASSWORD=$CAKEPASS     # Hacking game user pass\\n\\n#user check\\nif [ $(echo $H_USERNAME | wc -m) -eq 1 ]; then\\n  exit 3; #empty username = error and quit!\\nfi\\n\\n#internal parameter\\nFILE1=$CAKE1\\n \\n#adduser and make home dir \\nuseradd -m $CAKEUSER -p $CAKEPASS -s /bin/bash || exit $?\\necho "$CAKEUSER:$CAKEPASS" | chpasswd\\ncp /etc/skel/.bash_profile /home/$H_USERNAME/ || exit $?\\ncp /etc/skel/.bashrc /home/$H_USERNAME/ || exit $?\\n\\nmkdir -p /home/$CAKEUSER/target\\ntouch -d 1978-09-01 /home/$CAKEUSER/target/$FILE1\\n\\n#change dir and file permissions\\nchown -R $H_USERNAME:$H_USERNAME /home/$H_USERNAME || exit $?', 140, 3, 1, '', 1, '2008-09-22 16:24:28', '2008-09-29 00:39:16'),
(164, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	# Hacking game user name\\n#internal parameter\\nRC=0\\nkillall -u $CAKEUSER sshd > /dev/null\\ndeluser --remove-home $H_USERNAME > /dev/null || RC=$? \\nexit $RC\\n', 140, 4, 1, '', 1, '2008-09-22 16:24:36', '2008-09-29 00:40:17');
INSERT INTO `scripts` (`id`, `description`, `name`, `script`, `scenario_id`, `scripttype_id`, `sequence_no`, `deployment_package`, `player_id`, `created`, `modified`) VALUES 
(165, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	 # Hacking game user name\\nH_PASSWORD=$CAKEPASS     # Hacking game user pass\\n\\n#user check\\nif [ $(echo $H_USERNAME | wc -m) -eq 1 ]; then\\n  exit 3; #empty username = error and quit!\\nfi\\n\\n\\n \\n#adduser and make home dir \\nuseradd -m $CAKEUSER -p $CAKEPASS -s /bin/bash || exit $?\\necho "$CAKEUSER:$CAKEPASS" | chpasswd\\ncp /etc/skel/.bash_profile /home/$H_USERNAME/ || exit $?\\ncp /etc/skel/.bashrc /home/$H_USERNAME/ || exit $?\\n\\nmkdir -p /home/$CAKEUSER/target\\necho "$CAKE1" > /home/$CAKEUSER/todo\\n\\n#change dir and file permissions\\nchown -R $H_USERNAME:$H_USERNAME /home/$H_USERNAME || exit $?', 141, 3, 1, '', 1, '2008-09-22 16:25:49', '2008-09-29 01:14:29'),
(166, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\nman $CAKE1 > /home/$CAKEUSER/answer\\n\\ndiff -q /home/$CAKEUSER/answer /home/$CAKEUSER/target/manpage >/dev/null 2>&1\\nRC=$?\\nif [ $RC -ne "0" ]; then\\nrm /home/$CAKEUSER/answer;  \\nexit 3;\\n\\nelse\\n  exit 2;\\nfi\\n', 141, 5, 1, '', 1, '2008-09-22 16:26:00', '2008-09-29 01:18:35'),
(167, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	# Hacking game user name\\n#internal parameter\\nRC=0\\nkillall -u $CAKEUSER sshd > /dev/null\\ndeluser --remove-home $H_USERNAME > /dev/null || RC=$? \\nexit $RC\\n', 141, 4, 1, '', 1, '2008-09-22 16:26:07', '2008-09-29 01:09:29'),
(168, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	 # Hacking game user name\\nH_PASSWORD=$CAKEPASS     # Hacking game user pass\\n\\n#user check\\nif [ $(echo $H_USERNAME | wc -m) -eq 1 ]; then\\n  exit 3; #empty username = error and quit!\\nfi\\n\\n\\n \\n#adduser and make home dir \\nuseradd -m $CAKEUSER -p $CAKEPASS -s /bin/bash || exit $?\\necho "$CAKEUSER:$CAKEPASS" | chpasswd\\ncp /etc/skel/.bash_profile /home/$H_USERNAME/ || exit $?\\ncp /etc/skel/.bashrc /home/$H_USERNAME/ || exit $?\\n\\nmkdir -p /home/$CAKEUSER/target\\necho "$CAKE1" > /home/$CAKEUSER/todo\\necho "$CAKE1" > $CAKE2\\n\\n#change dir and file permissions\\nchown -R $H_USERNAME:$H_USERNAME /home/$H_USERNAME || exit $?', 142, 3, 1, '', 1, '2008-09-22 16:27:25', '2008-09-29 01:42:34'),
(169, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\nif [ "`cat /home/$CAKEUSER/target/location`" = "$CAKE2" ]; then\\n exit 2;\\nelse\\n exit 3;\\nfi\\n\\n', 142, 5, 1, '', 1, '2008-09-22 16:27:38', '2008-09-29 01:40:44'),
(170, '', 'new script', '#!/bin/bash\\n\\n# CAKEUSER : use this variable name for login user on machine\\n# CAKEPASS : use this variable name for login password on machine\\n# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff\\n# SCRIPTHOST : The ip of the host where the scripts are distributed to.\\n\\n\\n#external parameter\\nH_USERNAME=$CAKEUSER	# Hacking game user name\\n#internal parameter\\nRC=0\\nkillall -u $CAKEUSER sshd > /dev/null\\nrm $CAKE2 > /dev/null\\ndeluser --remove-home $H_USERNAME > /dev/null || RC=$? \\nexit $RC', 142, 4, 1, '', 1, '2008-09-22 16:27:45', '2008-09-29 01:38:35');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `scripttypes`
-- 

CREATE TABLE `scripttypes` (
  `id` int(11) NOT NULL auto_increment,
  `description` varchar(255) NOT NULL,
  `name` varchar(45) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Daten für Tabelle `scripttypes`
-- 

INSERT INTO `scripttypes` (`id`, `description`, `name`, `created`, `modified`) VALUES 
(1, 'Sets up the global environment on the target system.', 'environment setup', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Cleans up the global environment on the target system.', 'environment cleanup', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Sets up the user-specific environment on the target system.', 'user setup', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Cleans up the user-specific environment on the target system.', 'user cleanup', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Evaluates the user-specific input on the target system.', 'user evaluation', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Sets up the drone (simulated player) on the target system.', 'drone setup', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Cleans up the drone (simulated player) on the target system.', 'drone cleanup', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `settings`
-- 

CREATE TABLE `settings` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Daten für Tabelle `settings`
-- 

INSERT INTO `settings` (`id`, `name`, `value`, `created`, `modified`) VALUES 
(1, 'communication channel interface', 'eth3', '0000-00-00 00:00:00', '2008-08-07 15:19:01'),
(2, 'game internet interface', 'eth0', '0000-00-00 00:00:00', '2008-08-07 15:21:56');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `skills`
-- 

CREATE TABLE `skills` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `description` mediumtext NOT NULL,
  `icon` varchar(255) NOT NULL default 'skill_unknown.png' COMMENT 'filename of the icon in the /img folder',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

-- 
-- Daten für Tabelle `skills`
-- 

INSERT INTO `skills` (`id`, `name`, `description`, `icon`, `created`, `modified`) VALUES 
(1, 'linux manual pages', '', 'skill_linux1.png', NULL, NULL),
(2, 'linux basic file listing', '', 'skill_linux2.png', NULL, NULL),
(3, 'linux advanced file listing', '', 'skill_linux3.png', NULL, NULL),
(4, 'linux basic searches', '', 'skill_linux4.png', NULL, NULL),
(5, 'linux basic text editing', '', 'skill_linux5.png', NULL, NULL),
(6, 'linux advanced text editing', '', 'skill_linux6.png', NULL, NULL),
(7, 'linux basic file creation', '', 'skill_linux7.png', NULL, NULL),
(8, 'linux advanced file creation', '', 'skill_linux8.png', NULL, NULL),
(9, 'linux input/output usage', '', 'skill_linux9.png', NULL, NULL),
(10, 'linux advanced searches', '', 'skill_linux10.png', NULL, NULL),
(11, 'linux identification', '', 'skill_linux11.png', NULL, NULL),
(12, 'DNS basics', '', 'skill_dns.png', NULL, NULL),
(13, 'domain basics', '', 'skill_domain_basics.png', NULL, NULL),
(14, 'wireshark and passwords', '', 'skill_wireshark.png', NULL, NULL),
(15, 'directory traversal', '', 'skill_directory.png', '2007-08-15 13:11:25', NULL),
(16, 'TCP/UDP ports', '', 'skill_tcpudp.png', '2007-10-04 14:00:07', '2007-10-04 14:00:07'),
(17, 'basic Linux knowledge', '', 'skill_basic_linux.png', NULL, NULL),
(18, 'SSH', '', 'skill_ssh.png', NULL, NULL),
(19, 'TCP and UDP protocol internals', '', 'skill_tcpudp.png', NULL, NULL),
(20, 'OSI model', '', 'skill_osi.png', NULL, NULL),
(21, 'theoretical concepts of vulnerability, security management, patches, updates, etc. (Nessus)', '', 'skill_nessus.png', NULL, NULL),
(22, 'network basics / topology', '', 'skill_basics_networking.png', NULL, NULL),
(23, 'DNS basics', '', 'skill_dns.png', NULL, NULL),
(24, 'DNS server manipulation', '', 'skill_dnsserver.png', NULL, NULL),
(25, 'man-in-the-middle (MITM)', '', 'skill_mitm.png', NULL, NULL),
(26, 'DHCP', '', 'skill_dhcp.png', NULL, NULL),
(27, 'router configuration', '', 'skill_router.png', NULL, NULL),
(28, 'vi basics', '', 'skill_vi.png', NULL, NULL),
(29, 'telnet', '', 'skill_telnet.png', NULL, NULL),
(30, 'CACTI', '', 'skill_cacti.png', NULL, NULL),
(31, 'Ntop', '', 'skill_ntop.png', NULL, NULL),
(32, 'ARP', '', 'skill_arp.png', NULL, NULL),
(33, 'spoofing', '', 'skill_spoofing.png', NULL, NULL),
(34, 'SSL', '', 'skill_ssl.png', NULL, NULL),
(35, 'sniffing', '', 'skill_sniffing.png', NULL, NULL),
(36, 'Proxy basics', '', 'skill_proxies.png', NULL, NULL),
(37, 'Snort', '', 'skill_snort.png', NULL, NULL),
(38, 'Samhain', '', 'skill_samhain.png', NULL, NULL),
(39, 'LDAP', '', 'skill_ldap.png', NULL, NULL),
(40, 'Radius', '', 'skill_radius.png', NULL, NULL),
(41, 'Kerberos', '', 'skill_kerberos.png', NULL, NULL),
(42, 'Ettercap', '', 'skill_ettercap.png', NULL, NULL),
(43, 'cron', '', 'skill_cron.png', NULL, NULL),
(44, 'Honeypot', '', 'skill_honeypot.png', NULL, NULL),
(45, 'IOS', '', 'skill_ios.png', NULL, NULL),
(46, 'NMAP', '', 'skill_nmap.png', NULL, NULL),
(47, 'secure passwords', '', 'skill_securepasswords.png', NULL, NULL),
(48, 'MD5', '', 'skill_md5.png', NULL, NULL),
(49, 'etc/shadow', '', 'skill_etcshadow.png', NULL, NULL),
(50, 'John the Ripper', '', 'skill_johntheripper.png', NULL, NULL),
(51, 'brute force (Hydra)', '', 'skill_bruteforce.png', NULL, NULL),
(52, 'ACLs (firewall)', '', 'skill_acl.png', NULL, NULL);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `systemaccounts`
-- 

CREATE TABLE `systemaccounts` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `passwd` varchar(64) NOT NULL,
  `passwd_clear` varchar(64) NOT NULL,
  `player_id` int(11) NOT NULL default '0' COMMENT 'the player id determines who is using this systemaccount at the moment! if nobody->0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=130 ;

-- 
-- Daten für Tabelle `systemaccounts`
-- 

INSERT INTO `systemaccounts` (`id`, `name`, `passwd`, `passwd_clear`, `player_id`, `created`, `modified`) VALUES 
(1, 'ogollemon', '''$1$1fckadfasdf$SFWasdf/sfdsf/''', 'rmHF371', 0, '2008-02-19 16:36:23', '2008-10-28 16:01:03'),
(100, 'fritz', 'd2d086a5b605228d820757a9ded505c7', 'lmaa', 0, '2008-08-25 13:01:04', '2008-10-06 14:39:51'),
(101, 'sandra', '83b63b3e3a4ad9e2e5578be4256bd650', 'Lkah3', 0, '2008-08-25 13:01:23', '2008-10-13 16:44:32'),
(102, 'paul', '5e8bc3fd4bfe378fcca6baa647db0a83', 'tgw271', 0, '2008-08-25 13:01:41', '2008-10-28 16:11:38'),
(103, 'sina', '3c55957b1957f84f3eabc2df37377a95', 'sqLT2', 0, '2008-08-25 13:02:13', '2008-10-13 16:43:16'),
(104, 'vera', '8eb252b8cf01ab2591da81ccc5171b51', 'xhk73', 0, '2008-08-25 13:02:31', '2008-10-28 15:10:17'),
(105, 'franka', 'd3cbe2a6463f7280a93ae490565e3f13', 'ckm953', 0, '2008-08-25 13:02:50', '2008-10-28 15:08:20'),
(106, 'frank', 'fc54515ea7ab95abcd540ea14b98d430', 'yj138', 0, '2008-08-25 13:03:08', '2008-10-23 16:22:27'),
(107, 'peter', '5ba5ac1917ec20befcb8094d3bd52dec', 'sha731', 0, '2008-08-25 13:03:24', '2008-10-28 12:02:52'),
(108, 'tina', '8b519d8ca33f263acdfa70716440e56c', 'sM318', 0, '2008-08-25 13:03:38', '2008-10-20 12:56:44');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `topics`
-- 

CREATE TABLE `topics` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `keywords` varchar(255) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Daten für Tabelle `topics`
-- 

INSERT INTO `topics` (`id`, `name`, `description`, `keywords`, `created`, `modified`) VALUES 
(1, 'General IT knowledge', 'all articles with no specific topic or too general for one topic', 'general, ', NULL, NULL),
(2, 'Database Security', 'Here you learn about database security issues.', 'database, security, injection', '2007-08-14 09:46:30', '2007-08-14 09:46:30'),
(3, 'Social Engineering', 'Here you learn about how to protect your sensitive data from third party eyes.', NULL, '2007-08-14 09:46:30', '2007-08-14 09:46:30'),
(4, 'Web Applications Security', 'Web Applications Security related stuff', 'web php lamp mysql', NULL, NULL),
(5, 'Password Security and Encryption', NULL, 'encryption, passwords', '2008-04-09 17:11:16', NULL),
(6, 'Linux', '', '', '2008-09-08 17:30:07', '2008-09-08 17:30:07');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `used_hosts`
-- 

CREATE TABLE `used_hosts` (
  `id` int(11) NOT NULL auto_increment,
  `host_id` int(11) NOT NULL,
  `scenariosetup_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `used_hosts`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `used_parametersets`
-- 

CREATE TABLE `used_parametersets` (
  `id` int(11) NOT NULL auto_increment,
  `scenariosetup_id` int(11) NOT NULL,
  `parameterset_id` int(11) NOT NULL,
  `sequence_no` int(11) NOT NULL,
  `locked` tinyint(1) NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `used_parametersets`
-- 

