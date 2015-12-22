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

Check out where you phpunit is installed and run *(hint: disable coverage for this test)*:

```shell
    bin/phpunit -c app vendor/dawen/dic-service-benchmark-bundle/Dawen/Bundle/DicServiceBenchmarkBundle/Tests/DicServiceBenchmarkTest.php
```

This will print out a list of services and their time elapsed when instantiating.
This test will fail, if services will take longer than 50ms.


If you want to ignore service id's you can add in your phpunit.xml a global war that holds all service id's colon separated.

```xml
  <php>
      <var name="dic-service-benchmark-ignore" value="web_profiler.controller.router,my-service"/>
  </php>
```
