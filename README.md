# dic-service-benchmark-bundle

This code will instantiate every registered service from the DIC and checks the time taken.

---

### Installation

Require the dawen/dic-service-benchmark-bundle package in your composer.json and update your dependencies.

```shell
    $ composer require dawen/dic-service-benchmark-bundle
```

This bundle contains no code for Runtime, or any services. You don't have to add it to your AppKernel.

---

## Usage

Check out where you phpunit is installed and run:

```shell
    bin/phpunit -c app vendor/dawen/dic-service-benchmark-bundle/Dawen/Bundle/DicServiceBenchmarkBundle/Tests/DicServiceBenchmarkTest.php
```

This will print out a list of services and their time elapsed when instantiating.
This test will fail, if services will take longer than 50ms.
