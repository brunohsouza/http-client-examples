# httpClientExamples

> This simple application has the goal to test some usages of the Symfony HTTP Client.

It is a CLI application with some methods like retry-failed and simple requests using HTTP2.

This application requires just a few libs like:

        "php": ">=7.2.5",
        "ext-ctype": "*",
        "ext-iconv": "*",
        "symfony/console": "5.1.*",
        "symfony/dotenv": "5.1.*",
        "symfony/flex": "^1.3.1",
        "symfony/framework-bundle": "5.1.*",
        "symfony/yaml": "5.1.*"

## Usage

> To execute the test to retry-failed feature:
  `symfony console http-client:retry-failed`

> To execute the test to http2 request feature:
  `symfony console http-client:http2-support`