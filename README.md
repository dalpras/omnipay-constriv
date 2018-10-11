# Omnipay: constriv (Consorzio Triveneto Bassilichi)

**Consorzio Triveneto Bassilichi driver for the Omnipay PHP payment processing library**

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Omnipay is a payment processing library for PHP. It has been designed based on
ideas from [Active Merchant](http://activemerchant.org/), plus experience implementing
dozens of gateways for [CI Merchant]. It has a clear and consistent API,
is fully unit tested, and even comes with an example application to get you started.
This library is able compatible with omnipay payment v3.

## Install

Omnipay Constriv is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "dalpras/omnipay-constriv": "master"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update


or simpler via Composer 

``` bash
$ composer require dalpras/omnipay-constriv
```

## Basic Usage

The following gateways are provided by this package:

* Constriv (Redirect)

For general usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay)
repository.

### Initialize a gateway

Gateways are created and initialized like so:

``` php
use Omnipay\Omnipay;
$gateway = Omnipay::create(ConstrivGateway::class);
$gateway->setUsername('adrian');
$gateway->setPassword('12345');
```


## Usage

``` php
$skeleton = new Omnipay\Constriv();
echo $skeleton->echoPhrase('Hello, League!');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email stefano.dalpra@gmail.com instead of using the issue tracker.

## Credits

- [Stefano Dal Pra'][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/dalpras/omnipay-constriv.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/dalpras/omnipay-constriv/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/dalpras/omnipay-constriv.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/dalpras/omnipay-constriv.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/dalpras/omnipay-constriv.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/dalpras/omnipay-constriv
[link-travis]: https://travis-ci.org/dalpras/omnipay-constriv
[link-scrutinizer]: https://scrutinizer-ci.com/g/dalpras/omnipay-constriv/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/dalpras/omnipay-constriv
[link-downloads]: https://packagist.org/packages/dalpras/omnipay-constriv
[link-author]: https://github.com/dalpras
[link-contributors]: ../../contributors
