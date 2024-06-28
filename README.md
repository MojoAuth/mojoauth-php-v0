<p align="center">
  <a href="https://www.mojoauth.com">
    <img alt="MojoAuth" src="https://mojoauth.com/assets/images/logo.svg" width="200" />
  </a>
</p>

<h1 align="center">
  PHP SDK
</h1>

PHP SDK based on MojoAuth APIs.

## Introduction

MojoAuth PHP is a wrapper which provides access to MojoAuth Platform APIs.

MojoAuth provides a secure and delightful experience to your customer with passwordless.
Here, you'll find comprehensive guides and documentation to help you to start working with MojoAuth APIs.

Please visit [here](http://www.mojoauth.com/) for more information.

# Quickstart Guide

## Installation
The MojoAuth PHP SDK can be installed with Composer. Run this command:

```
composer require mojoauth/php-sdk
```

## Configuration
After successful install, you need to define the following MojoAuth Account info in your project anywhere before using the MojoAuth SDK or in the config file of your project:

```
<?php
require 'vendor/autoload.php';
$client = new mojoAuthAPI("MOJOAUTH_APIKEY");// mojoauth apikey replace at "MOJOAUTH_APIKEY"
```                

## Documentation

[Getting Started](https://mojoauth.com/docs/) - Everything you need to begin using this SDK.

## How to contribute

We appreciate all kinds of contributions from anyone, be it finding an issue or writing a blog.

Please check the [contributing guide](CONTRIBUTING.md) to become a contributor.

## License

For more information on licensing, please refer to [License](https://github.com/MojoAuth/mojoauth-php/blob/main/LICENSE)
