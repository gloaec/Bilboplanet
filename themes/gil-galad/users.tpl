<div id="content" class="pages">

	<div id="users">
	<!-- BEGIN user.block -->
		<div class="userbox">
			<a href="{$planet.url}/index.php?list=1&user_id={$user.id}" class="image" title="{_Show posts of} {$user.fullname}">
				<img class="avatar" src="{$avatar_url}"/>
			</a>
			<p class="nickname">{$user.fullname}</p>
			<div class="feedlink"><a href="{$planet.url}/feed.php?type=atom&users={$user.id}"><img alt="RSS" src="{$planet.url}/themes/{$planet.theme}/images/rss_24.png" /></a></div>
		</div>
	<!-- ELSE user.block -->
		<div class="userbox">
			{_No users found}
		</div>
	<!-- END user.block -->
	</div>

</div>

