{**
 * plugins/generic/usernameValidator/settingsForm.tpl
 *
 * Copyright (c) University of Pittsburgh
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * UsernameValidator plugin settings
 *
 *}
<script>
	$(function() {ldelim}
		// Attach the form handler.
		$('#usernameValidatorSettingsForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

<form class="pkp_form" id="usernameValidatorSettingsForm" method="post" action="{url router=$smarty.const.ROUTE_COMPONENT op="manage" category="generic" plugin=$pluginName verb="settings" save=true}">
	{csrf}

	{include file="controllers/notification/inPlaceNotification.tpl" notificationId="usageStatsSettingsFormNotification"}

	{fbvFormArea id="usernameValidatorSettings" title="plugins.generic.usernameValidator.settings"}
		{fbvFormSection for="regexType" description="plugins.generic.usernameValidator.settings.regexType"}
			{fbvElement type="select" id="regexType" from=$regexTypes selected=$regexType size=$fbvStyles.size.SMALL}
		{/fbvFormSection}
		{fbvFormSection description="plugins.generic.usernameValidator.settings.userRegex"}
			{fbvElement type="text" id="userParseRegex" value=$userParseRegex}
		{/fbvFormSection}
	{/fbvFormArea}

	{fbvFormButtons id="usernameValidatorSettingsFormSubmit" submitText="common.save" hideCancel=true}
</form>