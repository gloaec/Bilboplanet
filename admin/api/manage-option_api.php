<?php
if(isset($_POST) && isset($_POST['action'])) {
	
	switch (trim($_POST['action'])){
######################################
# Update Options
######################################
		case 'update':
			$flash = array();
			
			if (!empty($_POST['title'])) {
				$title = htmlentities(stripslashes(trim($_POST['title'])), ENT_QUOTES, 'UTF-8');
				$blog_settings->put('planet_title', $title, "string");
			}
			else {
				$flash[] = array('type' => 'error', 'msg' => T_("The title can not be empty"));
			}
			
			if (!empty($_POST['desc'])) {
				$desc = htmlentities(stripslashes(trim($_POST['desc'])), ENT_QUOTES, 'UTF-8');
				$blog_settings->put('planet_desc', $desc, "string");
			}
			else {
				$blog_settings->put('planet_desc', '', "string");
			}
			
			$blog_settings->put('planet_theme', trim($_POST['theme']), "string");
			$blog_settings->put('planet_lang', trim($_POST['lang']), "string");

			if (!empty($_POST['msg_info'])) {
				$msg_info = htmlentities(stripslashes(trim($_POST['msg_info'])), ENT_QUOTES, 'UTF-8');
				$blog_settings->put('planet_msg_info', $msg_info, "string");
			}
			else {
				$blog_settings->put('planet_msg_info', '', "string");
			}

			if (isset($_POST['show_contact'])) {
				$blog_settings->put('planet_contact_page', '1', "boolean");
			}
			else {
				$blog_settings->put('planet_contact_page', '0', "boolean");
			}

			if (isset($_POST['show_votes'])) {
				$blog_settings->put('planet_vote', '1', "boolean");
			}
			else {
				$blog_settings->put('planet_vote', '0', "boolean");
			}

			$blog_settings->put('planet_votes_system', trim($_POST['system_votes']), "string");
			
			if (isset($_POST['moderation'])) {
				$blog_settings->put('planet_moderation', '1', "boolean");
			}
			else {
				$blog_settings->put('planet_moderation', '0', "boolean");
			}
			
			if (isset($_POST['avatar'])) {
				$blog_settings->put('planet_avatar', '1', "boolean");
			}
			else {
				$blog_settings->put('planet_avatar', '0', "boolean");
			}
			
			if (isset($_POST['maintenance'])) {
				$blog_settings->put('planet_maint', '1', "boolean");
			}
			else {
				$blog_settings->put('planet_maint', '0', "boolean");
			}

			$blog_settings->put('planet_log', trim($_POST['log_level']), "string");
			
			if (is_numeric(trim($_POST['nb_posts_page']))) {
				$nb_posts_page = trim($_POST['nb_posts_page']);
				$blog_settings->put('planet_nb_post', $nb_posts_page, "integer");
			}
			else {
				$flash[] = array('type' => 'error', 'msg' => T_("Only numeric value are allowed for number of posts by page"));
			}
			
			if (isset($_POST['subscription'])) {
				$blog_settings->put('planet_subscription', '1', "boolean");
			}
			else {
				$blog_settings->put('planet_subscription', '0', "boolean");
			}
			
			if(!empty($_POST['subscription_content'])) {
				$subscription_content = htmlentities(stripslashes(trim($_POST['subscription_content'])), ENT_QUOTES, 'UTF-8');
				$blog_settings->put('planet_subscription_content', $subscription_content, "string");
			}
			else {
				$flash[] = array('type' => 'error', 'msg' => T_("Subscription page content can not be empty"));
			}
			
			sleep (2);
			
			if (!empty($flash)) {
				$output = '<ul>';
				foreach($flash as $value) {
					$output .= "<li>".$value['msg']."</li>";
				}
				$output .= '</ul>';
				print '<div class="flash error">'.$output.'</div>';
			}
			else {
				$output = T_("Modification succeeded");
				print '<div class="flash notice">'.$output.'</div>';
			}
			break;
######################################
# Get Options
######################################
		case 'options-form':
			
			# Init var
			$output = "";
			$theme_list = array();
			$lang_list = array();
			$arr_system_votes = array('yes-no', 'yes-warn');
			$arr_log_level = array('notice', 'debug');
			
			# Load value from setting table
			$title = stripslashes($blog_settings->get('planet_title'));
			$desc = stripslashes($blog_settings->get('planet_desc'));
			$msg_info = stripslashes($blog_settings->get('planet_msg_info'));
			$votes = $blog_settings->get('planet_vote');
			$contact = $blog_settings->get('planet_contact_page');
			$theme = $blog_settings->get('planet_theme');
			$lang = $blog_settings->get('planet_lang');
			$moderation = $blog_settings->get('planet_moderation');
			$maintenance = $blog_settings->get('planet_maint');
			$system_votes = $blog_settings->get('planet_votes_system');
			$avatar = $blog_settings->get('planet_avatar');
			$log_level = $blog_settings->get('planet_log');
			$nb_posts_page = $blog_settings->get('planet_nb_post');
			$subscription = $blog_settings->get('planet_subscription');
			$subscription_content = html_entity_decode(stripslashes($blog_settings->get('planet_subscription_content')), ENT_QUOTES, 'UTF-8');
			
			# Build an array of available theme
			$theme_path = dirname(__FILE__)."/../../themes/";
			$dir_handle = @opendir($theme_path) or die("Unable to open $theme_path");
			while ($file = readdir($dir_handle)){
				if($file!="." && $file!=".." && $file!=".svn" && $file!=".DS_Store" && $file!=".htaccess" && is_dir($theme_path.$file)){
					if ($file == $theme) {
						$theme_list[] = array('name' => $file, 'selected' => true);
					}
					else {
						$theme_list[] = array('name' => $file, 'selected' => false);
					}
				}
			}
			closedir($dir_handle);
			
			# Build an array of available lang
			$lang_path = dirname(__FILE__)."/../../i18n/";
			$dir_handle = @opendir($lang_path) or die("Unable to open $lang_path");
			while ($file = readdir($dir_handle)){
				if($file!="." && $file!=".." && $file!=".svn" && $file!=".DS_Store" && $file!=".htaccess" && is_dir($lang_path.$file)){
					if ($file == $lang) {
						$lang_list[] = array('name' => $file, 'selected' => true);
					}
					else {
						$lang_list[] = array('name' => $file, 'selected' => false);
					}
				}
			}

			# Display form
			$output .= '<form method="POST" id="manage_options">
	<table id="tbl1" class="table-news">
		<thead>
			<tr>
				<th class="tc5 tcr" scope="col">'.T_('Option').'</th>
				<th class="tc2 tcr" scope="col">'.T_('Value').'</th>
			</tr>
		</thead>
		<tr>
			<td>'.T_('Title of the Planet').'</td>
			<td><input id="cadre_options" class="input field" type="text" name="title" value="'.$title.'" /></td>
		</tr>
		<tr>
			<td>'.T_('Description of the Planet').'</td>
			<td><input id="cadre_options" class="input field" type="text" name="desc" value="'.$desc.'" /></td>
		</tr>
		<tr>
			<td>'.T_('Graphical theme').'</td>
			<td>
				<select name="theme" class="field">';
				foreach($theme_list as $value) {
					if($value['selected']) {
						$output .= '<option value="'.$value['name'].'" selected >'.$value['name'].'</option>'."\n";
					}
					else {
						$output .= '<option value="'.$value['name'].'" >'.$value['name'].'</option>'."\n";
					}
				}
				$output .= '</select>
			</td>
		</tr>
		<tr>
			<td>'.T_('Language of the Planet').'</td>
			<td>
				<select name="lang" class="field">';
				foreach($lang_list as $value) {
					if($value['selected']) {
						$output .= '<option value="'.$value['name'].'" selected >'.$value['name'].'</option>'."\n";
					}
					else {
						$output .= '<option value="'.$value['name'].'" >'.$value['name'].'</option>'."\n";
					}
				}
				if($lang == "en") {
					$output .= '<option value="en" selected >en</option>'."\n";
				}
				else {
					$output .= '<option value="en" >en</option>'."\n";
				}
				$output .= '</select>
			</td>
		</tr>
		<tr>
			<td>'.T_('Information message (optional)').'</td>
			<td><textarea class="cadre_option field" name="msg_info" rows=3>'.$msg_info.'</textarea></td>
		</tr>
		<tr>
			<td>'.T_('Show the contact page').'</td>';
			if($contact) {
				$output .= '<td><input type="checkbox" class="input field" id="show_contact" name="show_contact" checked/></td>';
			}
			else {
				$output .= '<td><input type="checkbox" class="input field" id="show_contact" name="show_contact" /></td>';
			}
			$output .='</tr>
		<tr>
			<td>'.T_('Enable voting').'</td>';
			if($votes) {
				$output .= '<td><input type="checkbox" class="input field" id="show_votes" name="show_votes" checked onclick="javascript:votes_state(\'options-form\');" /></td>';
			}
			else {
				$output .= '<td><input type="checkbox" class="input field" id="show_votes" name="show_votes" onclick="javascript:votes_state(\'options-form\');" /></td>';
			}
			$output .='</tr>
		<tr id="votes_system" style="display: none;">
			<td>
				'.T_('Votes system').'
				<div class="comment">
					<p>
						'.T_('yes-no').' : '.T_('Positive and Negative').'
						<br />
						'.T_('yes-warn').' : '.T_('Positive and Warning').'
					</p>
				</div>
			</td>
			<td>';
				$output .= '<select name="system_votes" class="field">';
					foreach($arr_system_votes as $value) {
						if($value == $system_votes) {
							$output .= '<option value="'.$value.'" selected>'.T_($value).'</option>';
						}
						else {
							$output .= '<option value="'.$value.'" >'.T_($value).'</option>';
						}
					}
				$output .= '</select>
			</td>
		</tr>
		<tr>
			<td>'.T_('Option of moderation').'</td>';
			if($moderation) {
				$output .= '<td><input type="checkbox" class="input field" id="moderation" name="moderation" checked ></td>';
			}
			else {
				$output .= '<td><input type="checkbox" class="input field" id="moderation" name="moderation" ></td>';
			}
		$output .= '</tr>
		<tr>
			<td>
				'.T_('Enable avatar').'
				<div class="comment">
					<p>
						'.T_('Work with').' <a href="http://www.gravatar.com" target="_blank" >www.gravatar.com</a>
					</p>
				</div>
			</td>';
			if($avatar) {
				$output .= '<td><input type="checkbox" class="input field" id="avatar" name="avatar" checked /></td>';
			}
			else {
				$output .= '<td><input type="checkbox" class="input field" id="avatar" name="avatar" /></td>';
			}
		$output .= '</tr>
		<tr>
			<td>'.T_('Maintenance mode').'</td>';
			if($maintenance) {
				$output .= '<td><input type="checkbox" class="input field" id="maintenance" name="maintenance" checked /></td>';
			}
			else {
				$output .= '<td><input type="checkbox" class="input field" id="maintenance" name="maintenance" /></td>';
			}
		$output .= '</tr>
		<tr>
			<td>'.T_('Log level').'</td>
			<td>
				<select name="log_level" class="field">';
				foreach($arr_log_level as $value) {
					if($value == $log_level) {
						$output .= '<option value="'.$value.'" selected>'.T_($value).'</option>';
					}
					else {
						$output .= '<option value="'.$value.'" >'.T_($value).'</option>';
					} 
				}
				$output .= '</select>
			</td>
		</tr>
		<tr>
			<td>'.T_('Number of posts by page').'</td>
			<td><input id="cadre_options" class="input field" type="text" name="nb_posts_page" value="'.$nb_posts_page.'" /></td>
		</tr>
		<tr>
			<td>'.T_('Enable subscription').'</td>';
			if($subscription) {
				$output .= '<td><input type="checkbox" class="input field" id="subscription" name="subscription" checked onclick="javascript:subscription_state(\'options-form\');" /></td>';
			}
			else {
				$output .= '<td><input type="checkbox" class="input field" id="subscription" name="subscription" onclick="javascript:subscription_state(\'options-form\');" /></td>';
			}
		$output .= '</tr>
	</table>
	<br />
	<div id="subscription_content" style="display:none;">
		'.T_('Subscription page content').'
		<br />
		<div class="wysiwyg"><script type="text/javascript">edToolbar(\'form_subscription_content\')</script></div>
		<textarea id="form_subscription_content" class="cadre_option field" name="subscription_content" rows="30">'.$subscription_content.'</textarea>
		<br /><br />
	</div>
	<div id="preview_button" style="display:none;" class="MyPreview">
		<div id="toto" class="button br3px">
			<input type="button" class="preview field" name="preview" onclick="javascript:call_preview(\'form_subscription_content\')" value="'.T_('Preview').'" />
		</div>
	</div>
	<div class="button br3px">
		<input type="button" class="valide field" name="submit" value="'.T_('Apply').'" onclick="javascript:updateopt()"/>
	</div>
	<div id="options-loading" ><!--Spinner--></div>
</form>';

			print $output;
			break;
##############################
# Display settings of planet
##############################
		case 'list':
			# Load value from setting table
			$title = stripslashes($blog_settings->get('planet_title'));
			$desc = stripslashes($blog_settings->get('planet_desc'));
			$msg_info = stripslashes($blog_settings->get('planet_msg_info'));
			$votes = $blog_settings->get('planet_vote');
			$contact = $blog_settings->get('planet_contact_page');
			$theme = $blog_settings->get('planet_theme');
			$lang = $blog_settings->get('planet_lang');
			$moderation = $blog_settings->get('planet_moderation');
			$maintenance = $blog_settings->get('planet_maint');
			$system_votes = $blog_settings->get('planet_votes_system');
			$avatar = $blog_settings->get('planet_avatar');
			$log_level = $blog_settings->get('planet_log');
			$nb_posts_page = $blog_settings->get('planet_nb_post');
			$subscription = $blog_settings->get('planet_subscription');
			$subscription_content = html_entity_decode(stripslashes($blog_settings->get('planet_subscription_content')), ENT_QUOTES, 'UTF-8');
			
			$output = "";
			$output .= '<table id="tbl1" class="table-news">
			<thead>
				<tr>
					<th class="tc5 tcr" scope="col">'.T_('Option').'</th>
					<th class="tc2 tcr" scope="col">'.T_('Value').'</th>
				</tr>
			</thead>
			<tr>
				<td>'.T_('Title of the Planet').'</td>
				<td>'.$title.'</td>
			</tr>
			<tr>
				<td>'.T_('Description of the Planet').'</td>
				<td>'.$desc.'</td>
			</tr>
			<tr>
				<td>'.T_('Graphical theme').'</td>
				<td>'.$theme.'</td>
			</tr>
			<tr>
				<td>'.T_('Language of the Planet').'</td>
				<td>'.$lang.'</td>
			</tr>
			<tr>
				<td>'.T_('Information message (optional)').'</td>
				<td>'.$msg_info.'</td>
			</tr>
			<tr>
				<td>'.T_('Show the contact page').'</td>';
				if($contact) {
					$output .= '<td>'.T_('Enable').'</td>';
				}
				else {
					$output .= '<td>'.T_('Disable').'</td>';
				}
			$output .= '</tr>
			<tr>
				<td>'.T_('Enable voting').'</td>';
				if($votes) {
					$output .= '<td>'.T_('Enable').'</td>
					</tr>
					<tr>
						<td>'.T_('Votes system').'</td>
						<td>'.$system_votes.'</td>
					</tr>';
				}
				else {
					$output .= '<td>'.T_('Disable').'</td>
					</tr>';
				}
			$output .= '<tr>
				<td>'.T_('Option of moderation').'</td>';
				if($moderation) {
					$output .= '<td>'.T_('Enable').'</td>';
				}
				else {
					$output .= '<td>'.T_('Disable').'</td>';
				}
			$output .= '</tr>
			<tr>
				<td>'.T_('Enable avatar').'</td>';
				if ($avatar) {
					$output .= '<td>'.T_('Enable').'</td>';
				}
				else {
					$output .= '<td>'.T_('Disable').'</td>';
				}
			$output .= '</tr>
			<tr>
				<td>'.T_('Maintenance mode').'</td>';
				if($maintenance) {
					$output .= '<td>'.T_('Enable').'</td>';
				}
				else {
					$output .= '<td>'.T_('Disable').'</td>';
				}
			$output .= '</tr>
			<tr>
				<td>'.T_('Log level').'</td>
				<td>'.$log_level.'</td>
			</tr>
			<tr>
				<td>'.T_('Number of posts by page').'</td>
				<td>'.$nb_posts_page.'</td>
			</tr>
			<tr>
				<td>'.T_('Enable subscription').'</td>';
				if($subscription) {
					$output .= '<td>'.T_('Enable').'</td>
				<tr>
					<td>'.T_('Subscription page content').'</td>
						<td>
							<div style="display:none;">
								<textarea id="list_subscription_content" name="subscription_content" >'.$subscription_content.'</textarea>
							</div>
							<div class="button br3px">
								<input type="button" class="preview field" name="preview" onclick="javascript:call_preview(\'list_subscription_content\')" value="'.T_('Preview').'" />
							</div>
						</td>
				</tr>';
				}
				else {
					$output .= '<td>'.T_('Disable').'</td>';
				}
			$output .= '</tr>
			</table>';
			
		print $output;
		break;
		}
}
else {
	$output = T_("Nothing to do");
	print '<div class="flash notice">'.$output.'</div>';
}
?>