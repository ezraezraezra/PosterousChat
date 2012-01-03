<?php
	class design {
		var $design = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml"> <head> <link rel="stylesheet" type="text/css" href="http://ezraezraezra.com/tb/posterous/minimal.css" />  <title>{PageTitle}</title> </head> <body>   {block:PosterousHeader /} <div id="container">      <div id="header" class="clearfix">                       <h1 class="logo header_image"><a href="{BlogURL}"><img src="http://s3.amazonaws.com/files.posterous.com/headers/4292638/original.png?1322781217" alt="{Title}"/></a></h1>                           {block:List}             <p class="intro-text">{Description}</p>         {/block:List}         {block:HasPages}             <ul class="pages">                 {block:Pages}                     <li><a href="{URL}" title="{Label}" class="{Current}">{Label}</a></li>                 {/block:Pages}             </ul>         {/block:HasPages}     </div>              <div id="left-column">          {block:Posts}             <div class="post clearfix" id="postunit_{PostID}">                 <div class="post-content" id="postbox_{PostID}">                     <div class="editbox clearfix" id="editunit_{PostID}">                         {block:EditBox}{EditBoxContents}{/block:EditBox}                       </div>                                          {block:ShowOrList}                         <a href="{Permalink}" class="date-bubble">                             <span class="month">{DayOfMonth} {ShortMonth}</span>                             <span class="year">{Year}</span>                         </a>                        {/block:ShowOrList}                                          {block:Title}                         <h2 id="posttitle_{PostID}" class="post-title"><a href="{Permalink}">{Title}</a></h2>                     {/block:Title}                     <div class="copy">                         {Body}                         {block:Private/}                     </div>                 </div>                    {block:ShowOrList}                     <ul class="post-meta-data clearfix">                         {block:TagList}                             <li class="tags">{block:TagListing} <a href="{TagLink}">{TagName}</a>{/block:TagListing}</li>                         {/block:TagList}                         <li><a href="{Permalink}">Permalink</a></li>                         {block:SMS}<li>(SMS)</li>{/block:SMS}                         {block:AuthorEmail}<li>Via Email</li>{/block:AuthorEmail}                         {block:List}                             <li><a href="{Permalink}#comment" id=\'comment_link_{PostID}\'>{ResponseCount} Comment{ResponseCountPluralized}</a> </li>                         {/block:List}                         {block:Sharing}                           <li class="retweet-button clearfix">                               {block:Tweet /}                           </li>                           <li class="fb-like-button">                               {block:FbLike /}                           </li>                         {/block:Sharing}                                              </ul>                    {/block:ShowOrList}             </div>             {block:Show}               <div class="comments-container clearfix">                 {block:Responses /}                 </div>             {/block:Show}         {/block:Posts}          <!-- PAGINATION -->         {block:Pagination}             <div class="next-prev clearfix">                 {block:PreviousPage}                     <a class="prev-page" href="{PreviousPage}">Previous</a>                 {/block:PreviousPage}                 {block:NextPage}                     <a class="next-page" href="{NextPage}">Next</a>                 {/block:NextPage}             </div>         {/block:Pagination}     </div>              <!-- Right Column -->      </div> </body> </html>'; 
	
	function design() {
		// Do nothing
	}
}  
?>