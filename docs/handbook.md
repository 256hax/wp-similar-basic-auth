# HandBook


## Plugin Reference
### Starter code
[wp scaffold plugin](https://developer.wordpress.org/cli/commands/scaffold/plugin/)

### Plugin Guidelines
[Detailed Plugin Guidelines](https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/)

### Conding Guidelines
[Coding Standard](https://make.wordpress.org/core/handbook/best-practices/)

### Best Practice
- [Plugin Handbook - Best Practices](https://developer.wordpress.org/plugins/plugin-basics/best-practices/)
- [advanced-custom-fields-pro](https://github.com/wp-premium/advanced-custom-fields-pro)
- [Automattic/sensei](https://github.com/Automattic/sensei)


## WP-CLI
### Install Plugin
Copy Plugin to plugins direcotry.

### Activate Plugin
`$ wp plugin activate wp-similar-basic-auth`

### Deactivate Plugin
`$ wp plugin deactivate wp-similar-basic-auth`

### Uninstall Plugin
Notice: Delete plugin on your PC.
`$ wp plugin uninstall wp-similar-basic-auth`


## Test
### Run
Starting vagrant(VCCW).
```
mac$ cd [vccw directory]
mac$ vagrant up
mac$ vagrant ssh
vagrant@vccw$ cd /var/www/html/wp-content/plugins/wp-similar-basic-auth
```

Run following command if get "Could not find /tmp/wordpress-tests-lib/includes/functions.php, have you run bin/install-wp-tests.sh ?" error.
```
vagrant@vccw$ bash bin/install-wp-tests.sh wordpress_test root 'wordpress' localhost latest
```

Run phpunit.
```
vagrant@vccw$ phpunit
```


## i18n
### Generate POT file
```
$ alias makepot="/usr/bin/php ~/wordpress-i18n-tools/makepot.php wp-plugin"
$ cd [plugin root directory]
$ makepot . languages/wp-similar-basic-auth.pot
```

### Maintenance
1. Run Poedit.
2. Open PO file.
3. Click "Update from POT File..." in Catalog menu if PO file is old.
4. Translate and save PO file.