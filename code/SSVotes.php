<?php 

class ProjectVotes extends DataObject {
	
	static $db = array(
		'VoteType'=>"Enum('UpVote,DownVote','UpVote')"
	);
	
	static $has_one = array(
		'Project'	=>'GITProject',
		'UserSource'	=>'Member'		
	);
	
}