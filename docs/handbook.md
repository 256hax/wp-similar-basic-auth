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
### Run PHPUnit
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

### Fix for coding starndards
Check fix.
`vagrand ssh` and `cd [plugin directory]`
```
vagrant@vccw$ phpcs -p -s -v --standard=WordPress-Core [file name]
```

Fix auto.
```
vagrant@vccw$ phpcbf -p -s -v --standard=WordPress-Core [file name]
```


### Check
`vagrand ssh` and `cd [plugin directory]`
Notice: do not run on fish shell.
```
vagrant@vccw$ ~/vendor/bin/phpcs -p . --standard=PHPCompatibilityWP
```


## i18n
### Generate POT file
```
$ alias makepot="/usr/bin/php ~/wordpress-i18n-tools/makepot.php wp-plugin"
$ cd [plugin root directory]
$ makepot . languages/wp-similar-basic-auth.pot
```

### Maintenance
1. Run Poedit Application.
2. Open PO file in WordPress languages directory.
3. Click "Update from POT File..." in Catalog menu if PO file is old.
4. Translate and save PO file.


## Other
### readme.txt Generator
https://generatewp.com/plugin-readme/?clone=test-plugin-readme-txt-file


## Commit to Plugin Repository on WordPress.org
### Copy release files
```
mac$ cd [plugin directory]
mac$ cp [release file] svn/trunk/[destination directory]
```

### Commit New File
```
mac$ cd [svn directory of plugin]
mac$ cd trunk
mac$ svn add ./*
mac$ svn commit -m "[write easy-to-understand and specific comment]"
```

### Commit Update File
```
mac$ cd [svn directory of plugin]
mac$ cd trunk
mac$ svn up [Update File]
mac$ svn commit -m "[write easy-to-understand and specific comment]"
mac$ [Authentication Wordpress.org (Input Password)]
```

### Commit Release Version
```
mac$ cd [svn directory of plugin]
mac$ svn cp trunk tags/[New Version ex:0.1.1]
mac$ cd tags/[New Version ex:0.1.1]
mac$ svn commit -m "[write easy-to-understand and specific comment]"
```

### Update Tested WP Version
```
mac$ cd [svn directory of plugin]
mac$ cd trunk
mac$ vi readme.txt
     rewrite -> Tested up to: [Write New Tested up to version]
mac$ svn up readme.txt
mac$ svn commit -m "[docs: Rewrite Test up to WP version]"
```

And then

```
Updating 'readme.txt':
Revision xxxxxxxxx.

mac$ svn commit -m "docs: Rewrite Tested up to WP version"
Authentication realm: <https://plugins.svn.wordpress.org:443> Use your WordPress.org login
Password for '[YOUR mac]]': ***********

Authentication realm: <https://plugins.svn.wordpress.org:443> Use your WordPress.org login
user: [WP USER ACCOUNT]
Password for '[WP USER ACCOUNT]': **********

Adding              readme.txt
Transmitting file data ....done
Committing transaction...
Committed revision xxxxxxxxx.
```

## Trouble Shooting
### svn: E155007: None of the targets are working copies
Check .svn file exist.

```
mac$ cd [svn directory of plugin]

mac$ ls -l svn/
total 0
drwxr-xr-x@  7 user  staff  224  5 29 13:14 .
drwxr-xr-x@ 21 user  staff  672  5 29 13:00 ..
drwxr-xr-x   9 user  staff  288  5 29 12:58 .svn
drwxr-xr-x   9 user  staff  288  5 29 12:58 assets
drwxr-xr-x   2 user  staff   64  5 29 12:58 branches
drwxr-xr-x   4 user  staff  128  5 29 12:58 tags
drwxr-xr-x  10 user  staff  320  5 29 13:00 trunk
```

If it dosen't exist, checkout again repository.
ex)[WP Similar Basic Auth](https://plugins.svn.wordpress.org/wp-similar-basic-auth/)

```
mac$ cd [svn directory of plugin]
mac$ mv svn svn-backup
mac$ svn checkout https://plugins.svn.wordpress.org/wp-similar-basic-auth/
```