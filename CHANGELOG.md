# Changelog

All notable changes to **Mighty** will be documented in this file.

<br />

## [[1.1.1] - 2022-11-07](https://github.com/MarwanAlsoltany/mighty/compare/v1.1.0...v1.1.1)
- Update rules:
    - Fix `data` rules:
        - Refactor `json` rule to use `JSON_THROW_ON_ERROR`.
        - Update `xml` rule to clear libxml errors before checking.
- Update `Engine` class:
    - Fix `evaluateBitwiseExpression()` method checks for expression validity.
    - Update `parseExpression()` method to allow for same rule repetition.
    - Add `cleanExpression()` method.
    - Add `evaluateExpression()` method.

<br />

## [[1.1.0] - 2022-10-04](https://github.com/MarwanAlsoltany/mighty/compare/v1.0.1...v1.1.0)
- Update rules:
    - Fix `common`, `condition`, and `image` rules messages placeholders.
- Update `Expression` class:
    - Fix `build()` method checks for expression validity.
    - Add `concat()` method.
    - Update `write()` method.
    - Add `comment()` method.
    - Update `variable()` method.
- Update `Engine` class:
    - Fix `evaluateBitwiseExpression()` method checks for expression validity.
    - Update `parseExpression()` method to allow for same rule repetition.
    - Add `cleanExpression()` method.
    - Add `evaluateExpression()` method.
- Update `Utility` class:
    - Update `transform()` method to always use `UTF-8`.
- Update `Validator` class:
    - Refactor `validateOne()` method.
- Update test:
    - Add `EngineTest` class.
    - Update `ValidationTest` class.
    - Update `ValidatorTest` class.

<br />

## [[1.0.1] - 2022-09-20](https://github.com/MarwanAlsoltany/mighty/compare/v1.0.0...v1.0.1)
- Update `Rule` class:
    - Update `createErrorMessage()` to pass rule name as a second parameter for message translation callback to allow for translating error messages easily based on rule name rather than the actual message.
- Update `Shape` class:
    - Update `__construct()` to add a check for the type of the nested attributes (allow only valid attributes).

<br />

## [[1.0.0] - 2022-08-11](https://github.com/MarwanAlsoltany/mighty/compare/v1.0.0-rc...v1.0.0)
- Stable release.

<br />

## [[1.0.0-rc] - 2022-08-09](https://github.com/MarwanAlsoltany/mighty/compare/v1.0.0-beta...v1.0.0-rc)
- Release candidate.

<br />

## [[1.0.0-beta] - 2022-08-09](https://github.com/MarwanAlsoltany/mighty/commits/v1.0.0-beta)
- Beta release.

<br />

## [Unreleased]

<br />

<!-- reference for Changelog formatting -->
<!--

<br />

## [[1.0.1] - YYYY-MM-DD](https://github.com/MarwanAlsoltany/mighty/compare/v1.0.0...v1.0.1)
- Update `Something`:
    - Details ...
    - Update ...
    - Fix ...

<br />

## [[1.0.0] - YYYY-MM-DD](https://github.com/MarwanAlsoltany/mighty/compare/v1.0.0-rc...v1.0.0)
- Initial release.

<br />

## [[1.0.0-rc] - YYYY-MM-DD](https://github.com/MarwanAlsoltany/mighty/compare/v1.0.0-beta...v1.0.0-rc)
- Release candidate.

<br />

## [[1.0.0-beta] - YYYY-MM-DD](https://github.com/MarwanAlsoltany/mighty/commits/v1.0.0-beta)
- Beta release.

<br />

-->
