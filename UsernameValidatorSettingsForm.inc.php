<?php

/**
 * @file plugins/generic/usernameValidator/UsernameValidatorSettingsForm.inc.php
 *
 * @class UsernameValidatorSettingsForm
 * @ingroup plugins_generic_usernameValidator
 * 
 * @brief Form for site admins to modify usernameValidator plugin settings
 * @author suk117
 */

import('lib.pkp.classes.form.Form');

class UsernameValidatorSettingsForm extends Form{

	/** @var $plugin object */
	var $_plugin;
	
	/**
	 * Constructor
	 * @param object $plugin
	 */
	function __construct($plugin) {
		$this->_plugin = $plugin;
		parent::__construct(method_exists($plugin, 'getTemplateResource') ? $plugin->getTemplateResource('settingsForm.tpl') : $plugin->getTemplatePath() . 'settingsForm.tpl');
	}
	
	/**
	 * Save Settings
	 */
	function execute() {
		$plugin = $this->_plugin;
		$plugin->updateSetting(CONTEXT_SITE, 'regexType', $this->getData('regexType'));
		$plugin->updateSetting(CONTEXT_SITE, 'userParseRegex', $this->getData('userParseRegex'));
	}
	
	/**
	 * @copydoc Form::initData()
	 */
	function initData() {
		$plugin = $this->_plugin;
		$this->setData('regexType', $plugin->getSetting(CONTEXT_SITE, 'regexType'));
		$this->setData('userParseRegex', $plugin->getSetting(CONTEXT_SITE, 'userParseRegex'));
	}
	
	/**
	 * @copydoc Form::readInputData()
	 */
	function readInputData() {
		$this->readUserVars(array(
			'regexType',
			'userParseRegex'
			));
	}
	/**
	 * Fetch the form
	 * @copydoc Form::fetch()
	 */
	function fetch($request, $template = null, $display = false) {
		$plugin = $this->_plugin;
		$templateMgr = TemplateManager::getManager($request);
		$regexTypes = array(
			'Email' => __('plugins.generic.usernameValidator.settings.regexType.email'),
			'Alpha-Numeric' => __('plugins.generic.usernameValidator.settings.regexType.alphanumeric')
			);
		$userParseRegex = $plugin->getSetting(CONTEXT_SITE, 'userParseRegex');
		$templateMgr->assign('regexTypes', $regexTypes);
		$templateMgr->assign('pluginName', $this->_plugin->getName());
		$templateMgr->assign('userParseRegex', $userParseRegex);
		return parent::fetch($request);
	}
}
