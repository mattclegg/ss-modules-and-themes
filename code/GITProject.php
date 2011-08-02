<?php

class GITProject extends DataObject {

	static $db = array(
		"ProjectType"	=>"Enum('Non-silverstripe,Module,Theme','Non-silverstripe')",
		'isVisible'		=>'Boolean',
		
	
		"url"			=>"Varchar(2083)",
		"has_issues"	=>'Boolean',
    	"homepage"		=>"Varchar(2083)",
	    "watchers"		=>"Int",
	    "source"		=>"Varchar(2083)",//Not sure how long this could be
	    "parent"		=>"Varchar(2083)",//Not sure how long this could be
	    "has_downloads"	=>'Boolean',
	    //"created_at"	=>'Created'
	    "forks"			=>"Int",
	    "fork"			=>'Boolean',
	    "has_wiki"		=>'Boolean',
	    "private"		=>'Boolean',
	    //"pushed_at"	=>'LastEdited'
	    //"name"		=>'Title',
	    "description"	=>'Text',
	    "owner"			=>'Varchar(255)',//Maybe userful for managing forks
	    "open_issues"	=>"Int"
	);
	
	static $has_one = array(
		'UserSource'	=>'Member'
	);
	
	static $has_many = array(
		'Votes'			=>'ProjectVotes'
	);
	
	static $defauls = array(
		'isVisible'		=>true,
	);
	
	function getContent(){
		return $this->description;
	}
	
	function TotalVotes(){
		return $this->Votes("VoteType='UpVote'")->Count()-$this->Votes("VoteType='DownVote'")->Count();
	}

}