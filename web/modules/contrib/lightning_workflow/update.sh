#!/usr/bin/env bash

FIXTURE=$TRAVIS_BUILD_DIR/tests/fixtures/$1.php.gz

if [ -e $FIXTURE ]; then
    drush sql:drop --yes
    php core/scripts/db-tools.php import $FIXTURE

    drush php:script $TRAVIS_BUILD_DIR/tests/update.php
fi

drush updatedb --yes
drush update:lightning --no-interaction --yes

# Reinstall from exported configuration to prove that it's coherent.
drush config:export --yes
drush site:install --yes --existing-config

# Big Pipe interferes with non-JavaScript functional tests, so uninstall it now.
drush pm-uninstall big_pipe --yes

# Clear any stored time zone.
drush config:set system.date timezone.default '' --yes

# Install Toolbar so ModerationSidebar.feature can pass.
drush pm-enable toolbar --yes
