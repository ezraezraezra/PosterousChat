<?php
header('Content-type: application/json; charset=utf-8');
require "design.php";
//require "counter.php";

/*
 * Project:     Posterous
 * Description: Programatically create a site with an embed.
 * Website:     coming soon
 * 
 * Author:      Ezra Velazquez
 * Website:     http://ezraezraezra.com
 * Date:        Jan 2012
 * 
 */

class Server {
	
	// NEED
	var $embed_id = '2embd612ebaa6199af97694bf3377973341bf723';
	
	var $user = 'andrew@tokbox.com';
	var $pwd = 'andrew';
	var $site_id = '4895673';
	var $api_token = 'wqruIyIqmCaBbeanjxytIdiAJhzAwHfz';
	var $url = 'http://posterous.com/api/2/';
	var $email = 'test-45';
	var $user_url = '';
	var $design_object;
	var $counter_object;
	
	
	
	function Server() {	
		$this->design_object = new design();
		//$this->counter_object = new Counter();
		
		/*
		 * Step 1: Create unique site for embed video
		 */
		$this->runCommand('create');

		/*
		 * Step 2: Get site id
		 */
		$this->getSiteId('id');
		
		/*
		 * Step 3: Add video post to site
		 */
		$this->runCommand('add');
		
		/*
		 * Step 4: Set site theme
		 */
		 $this->runCommand('design');
		  
		/*
		 * Step 5: Return site address
		 */
		echo $this->user_url;

	}
	
	
	function runCommand($command) {
		switch($command) {
			case "create":
				//$site_url = $this->counter_object->createURL();
				$site_url = time();
				
				$verb = 'POST';
				$body =  '-d "site[hostname]=tokbox-'.$site_url.'" -d "site[name]=Video Chat, Powered by OpenTok"';
				$url_tail = 'sites';
				
				$this->user_url = "http://tokbox-".$site_url.".posterous.com";
				
				break;
			case "add":
				//$tb_embbed = $this->counter_object->createEmbbed();
				$tb_embbed = $this->createEmbbed();
				
				
				$verb = 'POST';
				$body = '-d "post[body]=<iframe id=\'videoEmbed\' src=\'http://50.18.234.160:4000/embed/'.$tb_embbed.'\' width=\'830\' height=\'628\' style=\'border:none\' frameborder=\'0\'></iframe>"';
				$url_tail = 'sites/'.$this->site_id.'/posts';
				break;
			case "design":
				$verb = 'POST';
				$body = "-d 'theme[friendly_name]=Minimal' -d 'theme[raw_theme]=".$this->design_object->design."'";
				$url_tail = 'sites/'.$this->site_id.'/theme';
				break;
		}
		$shell_command = 'curl -X '.$verb.' --user '.$this->user.':'.$this->pwd.' -d "api_token='.$this->api_token.'" '.$body.' '.$this->url.$url_tail;
		$command_results = shell_exec($shell_command);
		
		$this->results = $command_results;
		
		return $command_results;
	}
	
	function getSiteId() {
		$json_results = json_decode($this->results, TRUE);
		$this->site_id = $json_results['id'];
	}
	
	function createEmbbed() {
		$shell_command = 'curl "http://50.18.234.160:4000/hl/embed/create?email=ezra@tokbox.com&callback=embbed"';
		$command_results = shell_exec($shell_command);
		
		$results = substr($command_results, 7, strlen($command_results) - 9);
		
		$obj = json_decode($results);
		return $obj->embed_id;
	} 
	
}

$start = new Server();
	
?>