<?php

/**
 * @file plugins/generic/usernameValidator/UsernameValidatorPlugin.inc.php
 * 
 * @class UsernameValidatorPlugin
 * @ingroup plugins_generic_usernameValidator
 * 
 * @brief UsernameValidator plugin class
 * @author suk117
 */

import('lib.pkp.classes.plugins.GenericPlugin');

class UsernameValidatorPlugin extends GenericPlugin{
	
	/**
	 * @copydoc LazyLoadPlugin::register()
	 */
	function register($category, $path, $mainContextId = NULL) {
		$success = parent::register($category, $path, $mainContextId);
		if (!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return true;
		if ($success && $this->getEnabled()) {
			HookRegistry::register('registrationform::validate', array(&$this, 'checkUsername'));
			HookRegistry::register('installform::validate', array(&$this, 'checkUsername'));
			HookRegistry::register('userdetailsform::validate', array(&$this, 'checkUsername'));
			HookRegistry::register('createreviewerform::validate', array(&$this, 'checkUsername'));
			}
		return $success;
	}
	
	/**
	 * @copydoc Plugin::getActions()
	 */
	function getActions($request, $verb) {
		$router = $request->getRouter();
		import('lib.pkp.classes.linkAction.request.AjaxModal');
		// Must be site administrator to access the settings option
		return array_merge(
				$this->getEnabled() && Validation::isSiteAdmin() ? array(
			new LinkAction(
					'settings', new AjaxModal(
					$router->url($request, null, null, 'manage', null, array('verb' => 'settings', 'plugin' => $this->getName(), 'category' => 'generic')), $this->getDisplayName()
					), __('manager.plugins.settings'), null
			),
				) : array(), parent::getActions($request, $verb)
		);
	}
	
	/**
	 * @copydoc Plugin::manage()
	 */
	function manage($args, $request) {
		$user =& Request::getUser();
		import('classes.notification.NotificationManager');
		$notificationManager = new NotificationManager();
		switch ($request->getUserVar('verb')) {
			case 'settings':
				$templateMgr =& TemplateManager::getManager();
				$templateMgr->register_function('plugin_url', array(&$this, 'smartyPluginUrl'));
				
				$this->import('UsernameValidatorSettingsForm');
				$form = new UsernameValidatorSettingsForm($this);
				if ($request->getUserVar('save')) {
					$form->readInputData();
					$form->execute();
					if(empty($this->getSetting(CONTEXT_SITE, 'userParseRegex'))) {
						return new JSONMessage(false, __('plugins.generic.usernameValidator.settings.invalidRegex'));
					}
					return new JSONMessage(true);
				} else {
					$form->initData();
					return new JSONMessage(true, $form->fetch($request));
				}
		}
		return parent::manage($args, $request);
	}

	/**
	 * Get the display name of this plugin.
	 * @return String
	 */
	function getDisplayName() {
		return __('plugins.generic.usernameValidator.displayName');
	}

	/**
	 * Get a description of the plugin.
	 * @return String
	 */
	function getDescription() {
		return __('plugins.generic.usernameValidator.description');
	}

	/**
	 * Hook Callback: check the username in a form matches a regex specified
	 * @see Form::validate()
	 */
	function checkUsername($hookname, $args) {
		$form = $args[0];
		$username = $form->getData('username');
		$regexType = $this->getSetting(CONTEXT_SITE, 'regexType');
		$userRegex = $this->getSetting(CONTEXT_SITE, 'userParseRegex');
		if (!is_null($username)) {
			if (empty($userRegex) || $userRegex == 'NA') {
				switch ($regexType) {
					default:
						if (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $username)) {
							$form->addError('username', __('plugins.generic.usernameValidator.checks.default'));
						}
					case 'Email':
						if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
							$form->addError('username', __('plugins.generic.usernameValidator.checks.email'));
						}
					case 'Alpha-Numeric':
						if (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9]+$/', $username)) {
							$form->addError('username', __('plugins.generic.usernameValidator.checks.alphaNum'));
						}
				}
			} else {
				if (!preg_match($userRegex, $username)) {
					$form->addError('username', __('plugins.generic.usernameValidator.checks.userRegex'));
				}
			}
		}
		return false;
	}
}
