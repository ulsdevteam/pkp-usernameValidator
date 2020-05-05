<?php

/**
 * @defgroup plugins_generic_usernameValidator
 */
 
/**
 * @file plugins/generic/usernameValidator/index.php
 *
 * Copyright (c) University of Pittsburgh
 * Distributed under the GNU GPL v2 or later. For full terms see the LICENSE file.
 *
 * @ingroup plugins_generic_usernameValidator
 * @brief Wrapper for UsernameValidator plugin.
 *
 */

require_once('UsernameValidatorPlugin.inc.php');

return new UsernameValidatorPlugin();