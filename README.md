# Username Validator plugin for OJS/OMP

Plugin for OJS, validates the username with user specified regex or in-built regex

## Requirements

* OJS/OMP 3.1.2 or later

## Configuration

Install this as a "generic" plugin in OJS.  The preferred installation method is through the Plugin Gallery.  To install manually via the filesystem, extract the contents of this archive to a "usernameValidator" directory under "plugins/generic" in your OJS root.  To install via Git submodule, target that same directory path: `git submodule add https://github.com/shanu17/pkp-usernameValidator plugins/generic/usernameValidator` and `git submodule update --init --recursive plugins/generic/usernameValidator`. Run the installation script to register this plugin, e.g.: `php lib/pkp/tools/installPluginVersion.php plugins/generic/usernameValidator/version.xml`.

Login as a Site Administrator and navigate to any context.  Enable the plugin via Login -> Settings -> Website -> Plugins -> Username Validator -> Enable.

To configure the plugin, you will need to select what types of regex you want to enable for the username.

## Author / License

Written by Sudheendra Kusume for the [University of Pittsburgh](http://www.pitt.edu).  Copyright (c) University of Pittsburgh.

Released under a license of GPL v2 or later.
