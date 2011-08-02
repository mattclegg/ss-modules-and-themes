<?php
class GITMember extends DataObjectDecorator {
	
	public function extraStatics() {
		return array(
			'db' => array(
				'Email'				=> 'Varchar(255)',	// alter Email to be able to save strings up to 255 chars,
														// according to proxied email addresses this is mandatory
			    "git_id"			=>"Int",
			    "git_user"			=>"Varchar(255)",
				"gravatar_id"		=>"Varchar(255)",
			    "company"			=>"Varchar(255)",
			    "name"				=>"Varchar(255)",
			    "location"			=>"Varchar(255)",
			    "public_repo_count"	=>"Int",
			    "public_gist_count"	=>"Int",
			    "blog"				=>"Varchar(2083)",
			    "following_count"	=>"Int",
			    "followers_count"	=>"Int",
			),
			'has_many' => array(
				'GITs'	=>'GITProject',
				'Votes'	=>'ProjectVotes'
			)
		);
	}
	
	function updateCMSFields(&$fields) {
		$fields=new FieldSet();
		$fields->insertBefore(new HeaderField('why_disabled','Git information must be updated on github.com'),'git_id');
		$fields->makeFieldReadonly('git_id');
		$fields->makeFieldReadonly('gravatar_id');
		$fields->makeFieldReadonly('company');
		$fields->makeFieldReadonly('name');
		$fields->makeFieldReadonly('location');
		$fields->makeFieldReadonly('name');
		$fields->makeFieldReadonly('public_repo_count');
		$fields->makeFieldReadonly('public_gist_count');
		$fields->makeFieldReadonly('blog');
		$fields->makeFieldReadonly('following_count');
		$fields->makeFieldReadonly('followers_count');
	}
	
	function onBeforeWrite(){
		parent::onBeforeWrite();

		$x=new GITRestService();
		
		$info=$x->get_user_info($this->owner->Email);
		
		if($repos=$x->get_user_repos($this->owner->git_user)){
		
			$git_urls=array();
			
			if($gits=$this->owner->GITs()){
				
				foreach ($gits as $git){
					$git_urls[]=$git->url;
				}
				
			}
	
			foreach ($repos as $repo){
				
				if(!in_array($repo->url, $git_urls)){
					
					$NewGit=new GITProject();
				}else{
					
					//Update fork/commit count ?
					
				}
				
			}
		}
	}
	
	
	function getFrontEndFields(){
		return new FieldSet(
			new TabSet("Root",
				new Tab('Repositories',new FieldSet(
					//Maybe someone who's good at extending ComplexTableField could write something to go here?
					
					new DataObjectManager($this,'GITs','GITProject',array(
						'isVisible'		=>'is Visible?',
						'ProjectType'	=>'Module/Theme',
						'Title'			=>'Title',
						'description'	=>'Description',
						'url'			=>'Source',
						'watchers'		=>'Number of Watchers',
						'forks'			=>'Number of Forks',
						'TotalVotes'	=>'Rating'
					))
				)),
				new Tab('Comments',new FieldSet(new LiteralField('text','Comments received about your repos & comments you have made about repos'))),
				new Tab('Profile',$mainFields=$this->owner->getCMSFields()->findOrMakeTab('Root.Main')->Childnen())
			)
		);
	}
	
	function isNice(){
		return $this->owner->Votes("VoteType='UpVote'")->Count()>$this->owner->Votes("VoteType='DownVote'")->Count();
	}
	
}