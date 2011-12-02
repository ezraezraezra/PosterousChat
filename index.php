<?php
header('Content-type: application/json; charset=utf-8');

/*
 * Project:     Posterous
 * Description: Programatically create a site with an embed.
 * Website:     coming soon
 * 
 * Author:      Ezra Velazquez
 * Website:     http://ezraezraezra.com
 * Date:        Nov 2011
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
	var $email = 'test-23';
	var $results = '';
	
	
	
	
	function Server() {
			
		$this->email = $this->embed_id;
		
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
		 //$this->runCommand('style');
		 //$this->setTheme();
		  
		/*
		 * Step 5: Return site address
		 */
		echo "http://tb-".$this->email.".posterous.com/";

	}
	
	
	function runCommand($command) {
		switch($command) {
			case "create":
				$verb = 'POST';
				$body = '-d "site[hostname]=tb-'.$this->email.'" -d "site[name]=Video Chat, Powered by OpenTok"';
				$url_tail = 'sites';
				break;
			case "add":
				$verb = 'POST';
				$body = '-d "post[body]=<iframe id=\'videoEmbed\' src=\'http://api.opentok.com/hl/embed/'.$this->embed_id.'\' width=\'350\' height=\'265\' style=\'border:none\' frameborder=\'0\'></iframe>"';
				$url_tail = 'sites/'.$this->site_id.'/posts';
				break;
		}
		$shell_command = 'curl -X '.$verb.' --user '.$this->user.':'.$this->pwd.' -d "api_token='.$this->api_token.'" '.$body.' '.$this->url.$url_tail;
		//echo $shell_command;
		$command_results = shell_exec($shell_command);
		
		$this->results = $command_results;
		
		return $command_results;
	}
	
	function getSiteId() {
		$json_results = json_decode($this->results, TRUE);
		$this->site_id = $json_results['id'];
	}
	
	function setTheme() {
		$verb = 'POST';
		$url_tail = 'sites/'.$this->site_id.'/theme';
		$shell_command = 'curl -X POST --user andrew@tokbox.com:andrew -d "api_token=wqruIyIqmCaBbeanjxytIdiAJhzAwHfz" -d "theme[friendly_name]=Minimal" -d "theme[raw_theme]=&lt;&#33;DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\"&gt;&lt;html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" xmlns:fb=\"http://www.facebook.com/2008/fbml\"&gt;&lt;head&gt;&lt;meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\" /&gt;&lt;meta http-equiv=\"Content-Language\" content=\"en-us\" /&gt;&lt;link rel=\"icon\" href=\"/images/favicon.png\" type=\"image/x-png\"/&gt;&lt;link rel=\"stylesheet\" type=\"text/css\" href=\"/themes/minimal/post-style.css\" /&gt;&lt;title&gt;{PageTitle}&lt;/title&gt;&lt;style type=\"text/css\"&gt;    div.posterous_bar { float: right; margin-top: 10px; }    div.posterous_header { margin-left: 150px; width: 100px; }    div.posterous_flash { margin-left: 150px; width: 500px; }&lt;/style&gt;&lt;/head&gt;&lt;body&gt;&lt;div id=\"container\"&gt;    &lt;div id=\"header\" class=\"clearfix\"&gt;        {block:PosterousHeader /}        {block:HeaderImage}             &lt;h1 class=\"logo header_image\"&gt;&lt;a href=\"{BlogURL}\"&gt;&lt;img src=\"{HeaderImageURL}\" alt=\"{Title}\"/&gt;&lt;/a&gt;&lt;/h1&gt;        {Else}             &lt;h1 class=\"logo\"&gt;&lt;a href=\"{BlogURL}\"&gt;{Title}&lt;/a&gt;&lt;/h1&gt;        {/block:HeaderImage}                {block:List}            &lt;p class=\"intro-text\"&gt;{Description}&lt;/p&gt;        {/block:List}        {block:HasPages}            &lt;ul class=\"pages\"&gt;            {block:Pages}                    &lt;li&gt;&lt;a href=\"{URL}\" title=\"{Label}\" class=\"{Current}\"&gt;{Label}&lt;/a&gt;&lt;/li&gt;                {/block:Pages}            &lt;/ul&gt;        {/block:HasPages}    &lt;/div&gt;            &lt;div id=\"left-column\"&gt;         {block:Posts}            &lt;div class=\"post clearfix\" id=\"postunit_{PostID}\"&gt;                &lt;div class=\"post-content\" id=\"postbox_{PostID}\"&gt;                    &lt;div class=\"editbox clearfix\" id=\"editunit_{PostID}\"&gt;                        {block:EditBox}{EditBoxContents}{/block:EditBox}                      &lt;/div&gt;                                        {block:ShowOrList}                        &lt;a href=\"{Permalink}\" class=\"date-bubble\"&gt;                            &lt;span class=\"month\"&gt;{DayOfMonth} {ShortMonth}&lt;/span&gt;                            &lt;span class=\"year\"&gt;{Year}&lt;/span&gt;                        &lt;/a&gt;               {/block:ShowOrList}                                        {block:Title}                        &lt;h2 id=\"posttitle_{PostID}\" class=\"post-title\"&gt;&lt;a href=\"{Permalink}\"&gt;{Title}&lt;/a&gt;&lt;/h2&gt;                    {/block:Title}                    &lt;div class=\"copy\"&gt;                        {Body}                        {block:Private/}                    &lt;/div&gt;                &lt;/div&gt;               {block:ShowOrList}                    &lt;ul class=\"post-meta-data clearfix\"&gt;                        {block:TagList}                            &lt;li class=\"tags\"&gt;{block:TagListing} &lt;a href=\"{TagLink}\"&gt;{TagName}&lt;/a&gt;{/block:TagListing}&lt;/li&gt;                        {/block:TagList}                        &lt;li&gt;&lt;a href=\"{Permalink}\"&gt;Permalink&lt;/a&gt;&lt;/li&gt;                        {block:SMS}&lt;li&gt;(SMS)&lt;/li&gt;{/block:SMS}                        {block:AuthorEmail}&lt;li&gt;Via Email&lt;/li&gt;{/block:AuthorEmail}                        {block:List}                            &lt;li&gt;&lt;a href=\"{Permalink}#comment\" id=\'comment_link_{PostID}\'&gt;{ResponseCount} Comment{ResponseCountPluralized}&lt;/a&gt; &lt;/li&gt;                        {/block:List}                        {block:Sharing}                          &lt;li class=\"retweet-button clearfix\"&gt;                              {block:Tweet /}                          &lt;/li&gt;                          &lt;li class=\"fb-like-button\"&gt;                              {block:FbLike /}                          &lt;/li&gt;                        {/block:Sharing}                                            &lt;/ul&gt;               {/block:ShowOrList}            &lt;/div&gt;            {block:Show}              &lt;div class=\"comments-container clearfix\"&gt;                {block:Responses /}                &lt;/div&gt;{/block:Show}        {/block:Posts}        &lt;&#33;-- PAGINATION --&gt;        {block:Pagination}            &lt;div class=\"next-prev clearfix\"&gt;                {block:PreviousPage}                    &lt;a class=\"prev-page\" href=\"{PreviousPage}\"&gt;Previous&lt;/a&gt;                {/block:PreviousPage}                {block:NextPage}                    &lt;a class=\"next-page\" href=\"{NextPage}\"&gt;Next&lt;/a&gt;                {/block:NextPage}            &lt;/div&gt;        {/block:Pagination}    &lt;/div&gt;            &lt;div id=\"right-column\"&gt;        &lt;div class=\"author clearfix\"&gt;            &lt;a href=\"{ProfileLink}\" class=\"author-image\"&gt;                &lt;img src=\"{PortraitURL-45}\" width=\"45\" class=\"site-author\" /&gt;            &lt;/a&gt;            &lt;h4&gt;&lt;a href=\"{ProfileLink}\"&gt;{OwnerName}\'s Space&lt;/a&gt;&lt;/h4&gt;            &lt;p&gt;{Profile}&lt;/p&gt;            {block:Author}                {block:AuthorUser}                    &lt;p&gt;Contributed by &lt;a href=\"{AuthorURL}\"&gt;{AuthorName}&lt;/a&gt;&lt;/p&gt;                {/block:AuthorUser}            {/block:Author}                        &lt;div class=\"social-icons\"&gt;                {ProfileExternalLinks}            &lt;/div&gt;                    &lt;/div&gt;                &lt;div class=\"subscribe_to_mysite clearfix\"&gt;          &lt;div&gt;&lt;a href=\"{RSS}\" class=\"subscribe_link\" target=\"_blank\"&gt;Subscribe via RSS&lt;/a&gt; &lt;/div&gt;                             &lt;/div&gt;                            {block:HasLinks}          {block:LinkCategories}            &lt;div class=\"blog-links clearfix\"&gt;&lt;h4&gt;{Label}&lt;/h4&gt;&lt;div&gt;                &lt;ul&gt;{block:Links}&lt;li&gt;&lt;a href=\"{URL}\"&gt;{Label}&lt;/a&gt;&lt;/li&gt;{/block:Links}&lt;/ul&gt;&lt;/div&gt;  &lt;/div&gt;{/block:LinkCategories}{/block:HasLinks}                {block:Contributors}            &lt;div class=\"contributors clearfix\"&gt;                &lt;h4&gt;Contributors&lt;/h4&gt;                &lt;div&gt;                    {block:Contributor collapsible=\'true\' count=\'5\' action_id=\'seemore_contribs_link\'}                        &lt;a href=\"{ContributorProfileLink}\" title=\"{ContributorName}\"&gt;&lt;img src=\"{ContributorPortraitURL-45}\" class=\"site-author\" alt=\"{ContributorName}\" /&gt;&lt;/a&gt;                    {/block:Contributor}                  {block:ContributorMore}&lt;a href=\"#\" id=\"seemore_contribs_link\"&gt;View all {NumContributors} contributors È&lt;/a&gt;{/block:ContributorMore}                &lt;/div&gt;            &lt;/div&gt;        {/block:Contributors}                {block:Show}            {block:PostLocations}                &lt;div class=\"geolocation\"&gt;                    &lt;h4&gt;Posted from&lt;/h4&gt;                    &lt;div class=\"map\"&gt;{MapIframe}&lt;/div&gt;                &lt;/div&gt;            {/block:PostLocations}        {/block:Show}                &lt;div class=\"search-bar clearfix\"&gt;            &lt;h4&gt;Search            &lt;/h4&gt;            {block:Tag}                &lt;p&gt;Listing {Tag}&lt;/p&gt;            {/block:Tag}            {block:SearchPage}                &lt;p&gt;                    {block:SearchResultOne}One Result{/block:SearchResultOne}                    {block:SearchResultMany}{SearchResultCount} Results{/block:SearchResultMany}                    {block:SearchResultNone}No Results{/block:SearchResultNone}                    for \"&lt;strong&gt;{SearchQuery}&lt;/strong&gt;\"                &lt;/p&gt;                &lt;p&gt;                    &lt;strong&gt;Sort Options&lt;/strong&gt;&lt;br /&gt;                    {block:SearchSortBestmatch}Sort by best match{Else}&lt;a href=\"{CurrentURL}?search={SearchQuery}&sort=bestmatch\"&gt;Sort by best match&lt;/a&gt;{/block:SearchSortBestmatch}&lt;br /&gt;                    {block:SearchSortRecent}Sort by most recent{Else}&lt;a href=\"{CurrentURL}?search={SearchQuery}&sort=recent\"&gt;Sort by most recent&lt;/a&gt;{/block:SearchSortRecent}&lt;br /&gt;                    {block:SearchSortInteresting}Sort by most interesting{Else}&lt;a href=\"{CurrentURL}?search={SearchQuery}&sort=interesting\"&gt;Sort by most interesting&lt;/a&gt;{/block:SearchSortInteresting}&lt;br /&gt;                    &lt;a href=\"{PosterousURL}/explore/?search={SearchQuery}\"&gt;Search all of posterous &raquo;&lt;/a&gt;                &lt;/p&gt;            {/block:SearchPage}                        &lt;form action=\"{SiteURL}\" method=\"get\" class=\"search-form\"&gt;                &lt;input type=\"hidden\" name=\"sort\" value=\"{SearchSort}\"/&gt;                {block:NotSearchOrTag}                    &lt;input type=\"text\" name=\"search\" value=\"\" class=\"search\" id=\"searchbox\"/&gt;                {/block:NotSearchOrTag}                {block:Tag}                    &lt;input type=\"text\" name=\"search\" value=\"{Tag}\" class=\"search\" id=\"searchbox\"/&gt;                {/block:Tag}                {block:SearchPage}                    &lt;input type=\"text\" name=\"search\" value=\"{SearchQuery}\" class=\"search\" id=\"searchbox\"/&gt;                {/block:SearchPage}                &lt;input class=\"search_button\" src=\"http://posterous.com/themes/minimal/images/layout/search-button.png\" type=\"image\" /&gt;             &lt;/form&gt;        &lt;/div&gt;                                {block:HasArchives}              &lt;div class=\"archives clearfix\"&gt;                &lt;h4&gt;Archive&lt;/h4&gt;                                  &lt;div class=\"archive_list\"&gt;                 {block:ArchiveYear}                    &lt;div class=\"archive\"&gt;&lt;a href=\"#\" id=\"{ArchiveYearId}\"&gt;{ArchiveDateYear} ({ArchiveYearCount})&lt;/a&gt;&lt;/div&gt;                      &lt;div id=\"{ArchiveMonthsId}\" style=\"display:none;\"&gt;                        &lt;div class=\"inner\"&gt;                                             {block:Archive}                                                            &lt;div&gt;&lt;a href=\"{ArchiveLink}\"&gt;{ArchiveMonth} ({ArchiveCount})&lt;/a&gt;&lt;/div&gt;                          {/block:Archive}                        &lt;/div&gt;                      &lt;/div&gt;                {/block:ArchiveYear}                &lt;/div&gt;              &lt;/div&gt;            {/block:HasArchives}                        &lt;div class=\"copyright\"&gt;            &lt;a href=\"http://www.obox-design.com/\" class=\"visit-obox\"&gt;&lt;img src=\"http://posterous.com/themes/madmen/images/layout/obox-logo.png\" alt=\"Obox Design\" /&gt;&lt;/a&gt;        &lt;/div&gt;    &lt;/div&gt;    &lt;/div&gt;&lt;/body&gt;&lt;/html&gt;" http://posterous.com/api/2/sites/4903180/theme';
		//echo $shell_command;
		$command_results = shell_exec($shell_command);
		
		$this->results = $command_results;
		
		echo $command_results;
	}
	
}

$start = new Server();
	
?>