# Basic TYPO3 Extension Skeleton for TYPO3 7LTS [![Build Status](https://travis-ci.org/helhum/ext_scaffold.svg?branch=master)](https://travis-ci.org/helhum/ext_scaffold)

## [composer.json](https://github.com/helhum/ext_scaffold/blob/master/composer.json) explained

### composer name ([doc](https://getcomposer.org/doc/04-schema.md#name))
The [composer name](https://github.com/helhum/ext_scaffold/blob/master/composer.json#L2) consists of a vendor name before
the slash and a name after the slash. To follow conventions, you should separate name parts with a dash.

### type ([doc](https://getcomposer.org/doc/04-schema.md#type))
The [type](https://github.com/helhum/ext_scaffold/blob/master/composer.json#L3) must always be set to `typo3-cms-extension`

### meta information ([doc](https://getcomposer.org/doc/04-schema.md#description))
[Meta information](https://github.com/helhum/ext_scaffold/blob/master/composer.json#L4-L18) can be used to describe and classify your extension

### license ([doc](https://getcomposer.org/doc/04-schema.md#license))
The [license](https://github.com/helhum/ext_scaffold/blob/master/composer.json#L19) must be GPL if you want to publish your extension to TER

### Package links ([doc](https://getcomposer.org/doc/04-schema.md#package-links))
Package links are specified in a require, require-dev, suggest and conflict sections, just like it can be done in the [ext_emconf.php](https://github.com/helhum/ext_scaffold/blob/master/ext_emconf.php#L21-L31)
Regarding TYPO3 it is important to note, that specifying package names there is a bit tricky. For example when specifying a dependency to
a PHP library which is available through composer, the TYPO3 extension manager will not be able to resolve this dependency and
installation will fail. Especially when distributing the extension (e.g. through [TER](https://extensions.typo3.org/)),
it is important that no other dependencies are specified there except the one to TYPO3 itself. Extensions meant for distribution should
specify dependencies in the ext_emconf.php file and only to other TER extensions.
If the extension is meant for internal use and only ever installed via composer, it is fine to add any dependency to other composer libraries there,
but only as of TYPO3 version 7.5.0. TYPO3 versions prior to that will complain about unresolved dependencies to unknown packages.

Please note, that you better specify the dependency to TYPO3 as `"typo3/cms-core": "<version constraint your extension supports>"` instead of
using `"typo3/cms": "<version constraint your extension supports>"`. Although you can specify the latter in TYPO3 versions higher than 7.5.0 or higher or equal 6.2.15,
you very likely want to test against multiple TYPO3 versions anyway, so you can then also check if that works out (see test setup section below).

### Class auto loading ([doc](https://getcomposer.org/doc/04-schema.md#autoload))
Composer allows packages to specify certain [class auto loading](https://github.com/helhum/ext_scaffold/blob/master/composer.json#L27-L37) information, so that, given the package is installed via composer, classes of the package
can be loaded automatically without any additional require calls.
TYPO3 currently also evaluates the [psr-4 section](https://github.com/helhum/ext_scaffold/blob/master/composer.json#L28-L30) in the composer.json
Starting from TYPO3 version 7.5.0, the autoload section can also be specified in the ext_emconf.php file.
Besides that it is recommended to register classes that are only needed to execute tests in the dedicated [autoload-dev](https://github.com/helhum/ext_scaffold/blob/master/composer.json#L32-L37)
section. These classes will then be available, when doing `composer install` in the extension directory, to later execute the tests.

## Define extension key
In order to define the extension key in the composer, you need to set [`extra.typo3/cms.extension-key`](https://github.com/TYPO3/TYPO3.CMS/blob/3ec52ea781621941cfedbd164070f28eb0c1e194/typo3/sysext/core/composer.json#L99). Setting a replace is deprecated and will not work with composer version 2 and forward.

### replace (deprecated) ([doc](https://getcomposer.org/doc/04-schema.md#replace))
**This configuration is deprecated !** As of composer 2.0, replace always has to have a vendor and a package name, therefore breaking this behaviour. Please refrain from using this option for TYPO3 extension and use `extra.typo3/cms.extension-key` instead (see above).

The [replace](https://github.com/helhum/ext_scaffold/blob/master/composer.json#L38-L41) section is used to specify packages, that are replaced when installing this package.
It is also useful to define aliases of the same package. The latter is what is used by TYPO3 and the `typo3/cms-composer-installers` to determine
the extension key of the package to be installed, so that a folder with the correct name can be created in `typo3conf/ext/`
Therefore it is mandatory for TYPO3 extensions with composer.json file to make use of this section and that the first replace has the
extension key as name. As version, always use `self.version` which references the exact same version as the current package.
A second line with the conventional name for TER extensions provided by https://composer.typo3.org is also useful but not mandatory.

### Branch alias ([doc](https://getcomposer.org/doc/articles/aliases.md))
It is possible to create an [alias](https://github.com/helhum/ext_scaffold/blob/master/composer.json#L52-L55) name for the branch
of the VCS the composer.json file resides in. This is especially useful for the master branch. Read the composer documentation fur further information.
 
### Test setup
The [rest](https://github.com/helhum/ext_scaffold/blob/master/composer.json#L42-L60) is used to set up everything for your tests.
Read the next chapter for details how to execute the tests.


## Testing your extension
### Test Setup
The first thing you need to do is to go to your extension directory and *"tell"* composer to set up
the testing environment for a TYPO3 version you want to test against. For that, type `composer require typo3/cms=7.6.0` if e.g. TYPO3 7.6.0 is the TYPO3 version
you want to test your extension with.
This will will install TYPO3 and all other required dependencies in a (hidden) `.Build/` folder. Since this command changed your composer.json file,
make sure you reset the changes e.g. by doing a git checkout with `git checkout composer.json`.

If you want to use this test setup with TYPO3 6.2.x, you can try out this tweak, to get 6.2.x installed: `composer require typo3/cms="~6.2.14" typo3/cms-composer-installers="1.2.2 as 1.1.4"`

### Unit Tests
You can now execute the unit tests of your extension simply by calling phpunit with the following command:
```
TYPO3_PATH_WEB=$PWD/.Build/Web \
\
.Build/bin/phpunit --colors -c \
  .Build/vendor/typo3/cms/typo3/sysext/core/Build/UnitTests.xml \
  Tests/Unit
```

### Functional Tests
You can execute the functional tests of your extension simply by calling phpunit with the following command:
```
typo3DatabaseName="ext_scaffold" \
typo3DatabaseUsername="root" \
typo3DatabasePassword="root" \
typo3DatabaseHost="localhost" \
TYPO3_PATH_WEB=$PWD/.Build/Web \
\
.Build/bin/phpunit --colors -c \
  .Build/vendor/typo3/cms/typo3/sysext/core/Build/FunctionalTests.xml \
  Tests/Functional
```

Please note, that you need to specify a database user, that is allowed to create and delete databases for that to work.
You can specify an arbitrary database name, it is only used to derive the test database names from.

### Travis CI
The extension skeleton also comes with a `.travis.yml` file, which executes your tests (including a PHP syntax check) on every merge, by using the [Travis CI](https://docs.travis-ci.com/user/languages/php/) service.
For that, your git repository must be hosted on [Github](https://github.com/).
