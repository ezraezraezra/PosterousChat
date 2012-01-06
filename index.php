<?php
header('Content-type: application/json; charset=utf-8');
require "../application/models/Build.class.php";
/*
 * Project:     Posterous
 * Description: Programatically create a site with an embed.
 * Website:     http://www.tokbox.com/opentok/plugnplay
 * 
 * Author:      Ezra Velazquez
 * Website:     http://ezraezraezra.com
 * Date:        Jan 2012
 * 
 */

class Posterous {
	// REQUIRED POSTEROUS VALUES
	const user = '';
	const pwd = '';
	const api_token = '';
	const url = '';
}	
	
class Server {
	var $site_id = '4895673';
	var $user_url = '';

	function Server($temp_id) {
		$this->site_id = $temp_id;
	}
	
	function runCommand($command) {
		switch($command) {
			case "create":
				$site_url = $this->uglifyURL(time());
				
				$verb = 'POST';
				$body =  '-d "site[hostname]=tokbox-'.$site_url.'" -d "site[name]=Video Chat, Powered by OpenTok"';
				$url_tail = 'sites';
				$this->user_url = "http://tokbox-".$site_url.".posterous.com";
				break;
			case "add":
				$tb_embbed = $this->createEmbbed();
				
				$verb = 'POST';
				$body = '-d "post[body]=<iframe id=\'videoEmbed\' src='.Build::staging_api_url.'/embed/'.$tb_embbed.'\' width=\'528\' height=\'400\' style=\'border:none\' frameborder=\'0\'></iframe>"';
				$url_tail = 'sites/'.$this->site_id.'/posts';
				break;
			case "design":
				$verb = 'POST';
				$body = "-d 'theme[friendly_name]=Minimal' -d 'theme[raw_theme]=".Design::design."'";
				$url_tail = 'sites/'.$this->site_id.'/theme';
				break;
		}
		$shell_command = 'curl -X '.$verb.' --user '.Posterous::user.':'.Posterous::pwd.' -d "api_token='.Posterous::api_token.'" '.$body.' '.Posterous::url.$url_tail;
		
		$command_results = shell_exec($shell_command);
		$this->results = $command_results;
		return $command_results;
	}
	
	function getSiteId() {
		$json_results = json_decode($this->results, TRUE);
		$this->site_id = $json_results['id'];
	}
	
	function createEmbbed() {
		$shell_command = 'curl "'.Build::staging_api_url.'/hl/embed/create?email=ezra@tokbox.com&callback=embbed"';
		$command_results = shell_exec($shell_command);
		
		$results = substr($command_results, 7, strlen($command_results) - 9);
		
		$obj = json_decode($results);
		return $obj->embed_id;
	}
	
	function uglifyURL($url) {
		$alphaNumeric = "abcdefghijklmnopqrstuvwxyz";
		$url_explode = preg_split('//', $url, -1, PREG_SPLIT_NO_EMPTY);	
		
		for($x = 0; $x < count($url_explode); $x++) {
			$show_number = rand(0, 1);
			if($show_number == 1) {
				$url_explode[$x] = substr($alphaNumeric, $url_explode[$x], 1);
			}
		}
		
		$url_implode = implode("", $url_explode);
		return $url_implode;
	} 
	
}

class Design {
		const design = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml"> <head> <link rel="stylesheet" type="text/css" href="http://ezraezraezra.com/tb/posterous/minimal.css" />  <title>{PageTitle}</title> </head> <body>   {block:PosterousHeader /} <div id="container">      <div id="header" class="clearfix">                       <h1 class="logo header_image"><a href="{BlogURL}"><img src="http://s3.amazonaws.com/files.posterous.com/headers/4292638/original.png?1322781217" alt="{Title}"/></a></h1>                           {block:List}             <p class="intro-text">{Description}</p>         {/block:List}         {block:HasPages}             <ul class="pages">                 {block:Pages}                     <li><a href="{URL}" title="{Label}" class="{Current}">{Label}</a></li>                 {/block:Pages}             </ul>         {/block:HasPages}     </div>              <div id="left-column">          {block:Posts}             <div class="post clearfix" id="postunit_{PostID}">                 <div class="post-content" id="postbox_{PostID}">                     <div class="editbox clearfix" id="editunit_{PostID}">                         {block:EditBox}{EditBoxContents}{/block:EditBox}                       </div>                                          {block:ShowOrList}                         <a href="{Permalink}" class="date-bubble">                             <span class="month">{DayOfMonth} {ShortMonth}</span>                             <span class="year">{Year}</span>                         </a>                        {/block:ShowOrList}                                          {block:Title}                         <h2 id="posttitle_{PostID}" class="post-title"><a href="{Permalink}">{Title}</a></h2>                     {/block:Title}                     <div class="copy">                         {Body}                         {block:Private/}                     </div>                 </div>                    {block:ShowOrList}                     <ul class="post-meta-data clearfix">{block:Sharing}                           <li class="retweet-button clearfix">                               {block:Tweet /}                           </li>                           <li class="fb-like-button">                               {block:FbLike /}                           </li><li id="copyright">Design by: <a href="http://www.obox-design.com"><img src="http://posterous.com/themes/madmen/images/layout/obox-logo.png" /></a></li>                         {/block:Sharing}                                              </ul>                    {/block:ShowOrList}             </div>             {block:Show}               <div class="comments-container clearfix">                 {block:Responses /}                 </div>             {/block:Show}         {/block:Posts}          <!-- PAGINATION -->         {block:Pagination}             <div class="next-prev clearfix">                 {block:PreviousPage}                     <a class="prev-page" href="{PreviousPage}">Previous</a>                 {/block:PreviousPage}                 {block:NextPage}                     <a class="next-page" href="{NextPage}">Next</a>                 {/block:NextPage}             </div>         {/block:Pagination}     </div>              <!-- Right Column -->      </div> </body> </html>';
}


if($_GET['comm'] == 'create') {
	$start = new Server('4895673');
	$start->runCommand('create');
	$start->getSiteId('id');
	$arr = array("command"=>"create", "user_url"=>$start->user_url, "site_id"=>$start->site_id);
}
else if($_GET['comm'] == 'add') {
	$start = new Server($_GET['site_id']);
	$start->runCommand('add');
	$arr = array("command"=>"add", "site_id"=>$start->site_id);
}
else if($_GET['comm'] == 'design') {
	$start = new Server($_GET['site_id']);
	$start->runCommand('design');
	$arr = array("command"=>"design", "site_id"=>$start->site_id);
}


$output = json_encode($arr);
echo $output;	
	
?>