# WordPress Plugin Boilerplate – BrianHenryIE Fork

The popular [WordPress Plugin Boilerplate](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate/) with added Composer, namespaces, autoloading, PHP Unit, and WordPress.org deployment.

## Overview

The WordPress Plugin Boilerplate is a well-documented starting point for WordPress plugins which encourages consistent conventions in plugin development. This fork expands on that base using modern PHP practices and providing a more comprehensive development environment setup. An example plugin where the changes have been tested is [Autologin URLs](https://github.com/BrianHenryIE/BH-WP-Autologin-URLs).

### Environment

This was written for a local environment with:

* MacOS Catalina (Bash)
* Built-in Apache serving to localhost:80 from your projects directory (probably ~/Sites/)
* PHP 7.4 [setup guide](https://getgrav.org/blog/macos-catalina-apache-multiple-php-versions)
* Xdebug
* MySQL 8 – `export PATH="$PATH:/usr/local/mysql/bin"`
* NPM

## Installation

Open Terminal and set the variables and your local MySQL credentials:

```
plugin_name="Example Plugin"
your_name="Brian Henry"
your_email="BrianHenryIE@gmail.com"

mysql_username="root"
mysql_password="secret"
```

Run these commands to generate replacements:

```
plugin_slug=$(echo $plugin_name | tr '[:upper:]' '[:lower:]' | sed 's/ /-/g'); echo $plugin_slug; # example-plugin
plugin_snake=$(echo $plugin_name | tr '[:upper:]' '[:lower:]' | sed 's/ /_/g'); echo $plugin_snake; # example_plugin
plugin_package_name=$(echo $plugin_name | sed 's/ /_/g'); echo $plugin_package_name; # Example_Plugin
plugin_capitalized=$(echo $plugin_name | tr '[:lower:]' '[:upper:]' | sed 's/ /_/g'); echo $plugin_capitalized; # EXAMPLE_PLUGIN
test_site_db_name=$plugin_snake"_tests" # example_plugin_tests
test_db_name=$plugin_snake"_integration" # example_plugin_integration
plugin_db_username=${plugin_slug:0:31} # 32 character max for username 
plugin_db_password=$plugin_slug
```

Then this block of commands will take care of most of the downloading:

```
git clone https://github.com/BrianHenryIE/WordPress-Plugin-Boilerplate.git
mv WordPress-Plugin-Boilerplate $plugin_slug
cd $plugin_slug

# Branches can be merged here.
git merge origin/codeception-wp-browser
```

This the renaming:

```
find . -depth -name '*plugin-slug*' -execdir bash -c 'git mv "$1" "${1//plugin-slug/'$plugin_slug'}"' bash {} \;

find . -depth \( -name '*.php' -o -name '*.txt' \) -exec sed -i '' "s/plugin_title/$plugin_name/g" {} +

find . -type f \( -name '*.php' -o -name '*.txt' -o -name '*.json' -o -name '*.xml' -o -name '.env.testing'  -o -name '*.yml' -o -name '.gitignore' -o -name '.htaccess' \) -exec sed -i '' 's/plugin-slug/'$plugin_slug'/g' {} +
find . -depth \( -name '*.php' -o -name '*.testing' \) -exec sed -i '' 's/plugin_snake/'$plugin_snake'/g' {} +
find . -type f \( -name '*.php' -o -name '*.txt' -o -name '*.json' -o -name '*.xml' \) -exec sed -i '' 's/Plugin_Package_Name/'$plugin_package_name'/g' {} \;
find . -depth -name '*.php' -exec sed -i '' 's/PLUGIN_NAME/'$plugin_capitalized'/g' {} +
find . -type f \( -name '*.php' -o -name '*.txt' -o -name '*.json' \) -exec sed -i '' "s/Your Name/$your_name/g" {} +
find . -type f \( -name '*.php' -o -name '*.txt' -o -name '*.json' \) -exec sed -i '' "s/email@example.com/$your_email/g" {} +
find . -type f \( -name '.env.testing' \) -exec sed -i '' 's/plugin-db-username/'$plugin_db_username'/g' {} +
```

This creates two databases:

```
# export PATH=${PATH}:/usr/local/mysql/bin

mysql -u $mysql_username -p$mysql_password -e "CREATE USER '"$plugin_db_username"'@'%' IDENTIFIED WITH mysql_native_password BY '"$plugin_db_password"';"
mysql -u $mysql_username -p$mysql_password -e "CREATE DATABASE "$test_site_db_name"; USE "$test_site_db_name"; GRANT ALL PRIVILEGES ON "$test_site_db_name".* TO '"$plugin_db_username"'@'%';"
mysql -u $mysql_username -p$mysql_password -e "CREATE DATABASE "$test_db_name"; USE "$test_db_name"; GRANT ALL PRIVILEGES ON "$test_db_name".* TO '"$plugin_db_username"'@'%';"
```

Install everything + setup WordPress

```
composer update

# Remove a symlink defined in composer.json which causes npm build to fail
rm vendor/wordpress/wordpress/build/wp-content
cd vendor/wordpress/wordpress/; npm install; npm run build; cd ../../..
composer install

vendor/bin/wp config create --dbname=$test_site_db_name --dbuser=$plugin_db_username --dbpass=$plugin_db_password --path=vendor/wordpress/wordpress/build
vendor/bin/wp core install --url="localhost/$plugin_slug" --title="$plugin_name" --admin_user=admin --admin_password=password --admin_email=$your_email --path=vendor/wordpress/wordpress/build

vendor/bin/wp plugin activate $plugin_slug --path=vendor/wordpress/wordpress/build 

vendor/bin/wp user create bob bob@example.com --path=vendor/wordpress/wordpress/build

mysqldump -u $mysql_username -p$mysql_password $test_site_db_name > tests/_data/dump.sql

```

```
# create the symlink again + PhpStorm config
open -a PhpStorm ./
composer install
```

Run the tests to confirm it's working:

```
vendor/bin/codecept run acceptance
```

If this is a WooCommerce plugin:

```
composer require woocommerce/woocommerce --dev --no-update
composer require wpackagist-theme/storefront:* --dev --no-update
composer update

vendor/bin/wp plugin activate woocommerce --path=vendor/wordpress/wordpress/build
vendor/bin/wp theme activate storefront --path=vendor/wordpress/wordpress/build

vendor/bin/wp wc tool run install_pages --user=admin --path=vendor/wordpress/wordpress/build

vendor/bin/wp wc product create --name="Dummy Product" --regular_price=10 --user=admin --path=vendor/wordpress/wordpress/build

# vendor/bin/wp wc customer create: https://github.com/woocommerce/woocommerce/wiki/WC-CLI-Overview#examples

# Create dump after changing site.
mysqldump -u $mysql_username -p$mysql_password $test_site_db_name > tests/_data/dump.sql
```

```
# Import a dump (after messing up!)
mysql -u $mysql_username -p$mysql_password $test_site_db_name < tests/_data/dump.sql
```

## Usage

### WordPress Coding Standards

To see [WordPress Coding Standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) errors using [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) run:

```
vendor/bin/phpcs
```

Use PHP Code Beautifier and Fixer to automatically correct them where possible:

```
vendor/bin/phpcbf
```

To configure WPCS checking on GitHub PRs, [generate a Personal Access Token](https://github.com/settings/tokens) with the `public_repo` permission, and under your GitHub repository's Settings's Secrets add it as `GH_BOT_TOKEN`.

### Testing

```
vendor/bin/codecept run acceptance
vendor/bin/codecept run unit
vendor/bin/codecept run wpunit

```


### Deployment

To create a .zip archive for uploading to WordPress:

```
mv src $(basename "`pwd`"); zip -r $(basename "`pwd`").zip $(basename "`pwd`"); mv $(basename "`pwd`") src;
```

To configure automatic WordPress.org plugin repository deployment, add your WordPress.org username and password as Secrets `SVN_USERNAME` and `SVN_PASSWORD` in the GitHub repository's settings, then when a Release is created, the plugin will be updated on WordPress.org (from [zerowp.com](https://zerowp.com)'s [Use Github Actions to publish WordPress plugins on WP.org repository](https://zerowp.com/use-github-actions-to-publish-wordpress-plugins-on-wp-org-repository/)).

## Composer Notes

By convention, WordPress plugins and themes installed by composer get installed into the project's `/wp-content/plugins` and `/wp-content/themes` directory. In a typical PHP project, libraries required by the project during runtime are installed in the `vendor` directory. In the case of this project, libraries are downloaded to the project's `vendor` folder, then their files copied to `src/vendor` and their namespace changed.

### Mozart

[Mozart](https://github.com/coenjacobs/mozart) is included in composer.json to prefix libraries' namespaces to avoid clashes with other WordPress plugins. e.g. in this case, [wp-namespace-autoloader](https://github.com/pablo-sg-pacheco/wp-namespace-autoloader) appears in `src/vendor/` with the namespace `Plugin_Name\Pablo_Pacheco\WP_Namespace_Autoloader`.

```
 "extra": {
  "mozart": {
   "dep_namespace": "Plugin_Name\\",
   "dep_directory": "/src/vendor/",
   "classmap_directory": "/classes/dependencies/",
   "classmap_prefix": "Plugin_Name_"
  }
 }
```

### Composer-Patches

[composer-patches](https://github.com/cweagans/composer-patches) is used to apply PRs to composer dependencies (e.g. while waiting for the repository owners to accept the required changes). In this case, Mozart is patched with a PR (which configures Mozart to process all libraries listed in composer.json `require` whereas without the patch, each needs to be specified).[*](https://mindsize.me/blog/development/how-to-backport-woocommerce-security-patches-using-git-and-composer/)

```
 "extra": {
  "patches": {
   "coenjacobs/mozart": {
    "Allow default packages": "https://github.com/coenjacobs/mozart/pull/34.patch"
   }
  }
 }
```

### WordPress Packagist

Plugins published on WordPress.org are made available through composer via [wpackagist.org](https://wpackagist.org/). Add to composer.json using:

```
 "repositories": [
  {
   "type":"composer",
   "url":"https://wpackagist.org"
  }
 ]
```

Then add the plugin or theme 

```
 "require-dev": {
  "wpackagist-plugin/bh-wp-autologin-urls":">=1.1",
  "wpackagist-theme/twentytwenty":"*"
 }
```
### Local Projects

To add a project in another local directory, ensure it has its own `composer.json` with `"name": "brianhenryie/local-lib"`

```
 "repositories": [
  {
   "type": "path",
   "url": "../phpunit-github-actions-printer"
  }
 ]
```

```
 "require": {
  "brianhenryie/local-lib":"*",
 }
```

### GitHub repository containing composer.json

By including plugins direct from GitHub, you may get additional files such as unit tests and JavaScript sources.

```
 "repositories": [
 {
  "url": "https://github.com/johnbillion/user-switching",
  "type": "git"
 }
```

```
 "require-dev": {
  "johnbillion/user-switching": "dev-master"
 }
```

### GitHub Branch/Fork

When including a fork or branch, the repository may need to be changed, and the branch name should be prefixed with `dev-`.

```
 "repositories": [
 {
  "url": "https://github.com/BrianHenryIE/wp-namespace-autoloader",
  "type": "git"
 }
```

```
 "require": {
  "pablo-sg-pacheco/wp-namespace-autoloader": "dev-brianhenryie"
 }
```


### GitHub repository without composer.json

For GitHub repositories that are not set up for composer:

```
 "repositories": [
 {
  "type": "package",
  "package": {
   "name": "enhancedathlete/ea-wp-aws-sns-client-rest-endpoint",
   "version": "1.0",
   "source": {
    "url": "https://github.com/EnhancedAthlete/EA-WP-AWS-SNS-Client-REST-Endpoint",
    "type": "git",
    "reference": "master"
   }
  }
 }
```

```
 "require-dev": {
  "enhancedathlete/ea-wp-aws-sns-client-rest-endpoint":"*"
 }
```

### SatisPress

[SatisPress](https://github.com/cedaro/satispress) is a WordPress plugin that allows you to expose the plugins and themes installed on your WordPress site via a private Composer repository.

Once installed, plugins need to be whitelisted via checkboxes in the admin UI's plugins.php page, and credentials need to be defined in Settings/SatisPress.

```
 "repositories": [
 {
  "type": "composer",
  "url": "https://brianhenry.ie/satispress/"
 }
```

```
 "require-dev": {
  "satispress/my-plugin": "*
 }  
```

When running `composer update` you will be prompted (once) for the credentials you created on the site.

### Symlinks

If an included WordPress plugin or theme does not install to the project's `wp-content` folder, it can be symlinked with Composer [Symlink Handler](https://github.com/kporras07/composer-symlinks).

```
 "extra": {
  "symlinks": {
   "./vendor/enhancedathlete/ea-wp-aws-sns-client-rest-endpoint/trunk": "./wp-content/plugins/ea-wp-aws-sns-client-rest-endpoint"
  }
```

## Notes


### Minimum WordPress Version

The minimum WordPress version can be determined using [wpseek.com's Plugin Doctor](https://wpseek.com/pluginfilecheck/).

## TODO

* PHP Storm configuration
* PHP Unit for PRs via GitHub Actions
* Code coverage badge
* Downloads count badge
* JavaScript unit testing
* Local Git hooks for WPCS
* Disable commiting to master
* Update Git origin instruction
* Composer command for PHPCS+PHP Unit
* [PHP 7](https://stitcher.io/blog/php-in-2020) site:github.com inurl:WordPress-Plugin-Boilerplate php 7.3


## Acknowledgements

The contributors to [WordPress Plugin Boilerplate](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate/) and more.