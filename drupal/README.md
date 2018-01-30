<p align="center" class="text-center"><img src="https://www.drupal.org/files/drupal_logo-blue.png" height="64"></p>

## About drupal

TODO

## Override

Adding *custom scripts* into `composer.json`.

```json
  ...
  "scripts": {
    "run-phpcs": [
      "@run-phpcs:modules",
      "@run-phpcs:theme"
    ],
    "run-phpcs:modules": [
      "vendor/bin/phpcs --standard=Drupal --extensions=php -p -n -s --colors ./modules/custom/"
    ],
    "run-phpcs:theme": [
      "vendor/bin/phpcs --standard=Drupal --extensions=php -p -n -s --colors ./themes/custom/"
    ],
    "fix-phpcs": [
      "@fix-phpcs:modules",
      "@fix-phpcs:theme"
    ],
    "fix-phpcs:modules": [
      "vendor/bin/phpcbf --standard=Drupal --extensions=php -n ./modules/custom/"
    ],
    "fix-phpcs:theme": [
      "vendor/bin/phpcbf --standard=Drupal --extensions=php -n ./themes/custom/"
    ]
  },
  ...
```

You can check if configuration is apply with command:
```bash
composer
```

If error is returned, check if standard is supported:
```bash
vendor/bin/phpcs -i
# Return attempt: The installed coding standards are MySource, PHPCS, PSR1, PEAR, PSR2, Squiz, Zend, Drupal and DrupalPractice

# If `Drupal` is not show, launch the following command
vendor/bin/phpcs --config-set installed_paths vendor/drupal/coder/coder_sniffer
```

Then, you can launch specific script:
```bash
composer run-phpcs
```
