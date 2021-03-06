# Release Notes for 3.x

## [Unreleased](https://github.com/litstack/litstack/compare/v3.2.4...3.x)

### Added

-   Added relation preview inline fields ([#143](https://github.com/litstack/litstack/pull/143))
-   Added `appends` method to Crud show page ([#135](https://github.com/litstack/litstack/pull/135))
-   Added `info` method to Crud index page ([e69a6e8](https://github.com/litstack/litstack/commit/e69a6e8a1ef99637aecdccd637d8b23c79c1b1e3))
-   Added `translation` option to the crud meta macro ([#146](https://github.com/litstack/litstack/pull/146))

### Fixed

-   Fixed table column `date` method casting `null` as carbon instance ([338dae9](https://github.com/litstack/litstack/commit/338dae90d575a960206ea8ca100390e9cae7428a))
-   Fixed crud model binding ([#141](https://github.com/litstack/litstack/pull/141))
-   Fixed script mime types ([#142](https://github.com/litstack/litstack/pull/142))
-   Fixed missing translations ([#145](https://github.com/litstack/litstack/pull/145))
-   Fixed nested block fields ([#144](https://github.com/litstack/litstack/pull/144))

### Changed

-   Changed field constructor ([#147](https://github.com/litstack/litstack/pull/147))

## [v3.2.5](https://github.com/litstack/litstack/compare/v3.2.4...v3.2.5)

### Added

-   Added `confirmDelete` method to block field ([#131](https://github.com/litstack/litstack/pull/131))

## [v3.2.4](https://github.com/litstack/litstack/compare/v3.2.3...v3.2.4)

### Added

-   Added `allowEmpty` method to route field ([#129](https://github.com/litstack/litstack/pull/129))

## [v3.2.3](https://github.com/litstack/litstack/compare/v3.2.2...v3.2.3)

### Added

-   Added `whenIn` field condition method ([#125](https://github.com/litstack/litstack/pull/125))

### Fixed

-   Fixed authentication with custom guard ([#103](https://github.com/litstack/litstack/issues/103), [#128](https://github.com/litstack/litstack/pull/128))
-   Fixed modal bug for multiple image fields ([ad56d49](https://github.com/litstack/litstack/commit/ad56d4911dee16b47750be49e3c27acc7b5a96c9))

## [v3.2.2](https://github.com/litstack/litstack/compare/v3.2.1...v3.2.2)

### Added

-   Added PHP 8.0 support ([#126](https://github.com/litstack/litstack/pull/126))

### Fixed

-   Fixed sluggable stub ([f8515e8](https://github.com/litstack/litstack/commit/f8515e8d912acfd1a3cc12648aa45bb1f1f8b000))
-   Fixed `manyRelation` and `oneRelation` field ([384f5e4](https://github.com/litstack/litstack/commit/384f5e4de12ed2d5e00cfe50862f5476c512c235), [2f04d4e](https://github.com/litstack/litstack/commit/2f04d4e22698aa6ad67d8ff5f76693bf31f2b52b))

## [v3.2.1](https://github.com/litstack/litstack/compare/v3.2.0...v3.2.1)

### Fixed

-   Fixed media field crop ([#123](https://github.com/litstack/litstack/issues/123), [c4542cb](https://github.com/litstack/litstack/commit/c4542cb3028f1f229ab8d679f7dccd2873aac285))

## [v3.2.0](https://github.com/litstack/litstack/compare/v3.1.3...v3.2.0)

### Added

-   Added table column fields :fire: ([5e76e3f](https://github.com/litstack/litstack/commit/5e76e3ffb47a0bd803c79c54487d972d7a16fb8e))
-   Added changelog ([949ed52](https://github.com/litstack/litstack/commit/949ed5224da968500780f91f45b596268c9f6613))
-   Added `resource` method to `Ignite\Crud\Models\LitFormModel` ([#97](https://github.com/litstack/litstack/issues/97), [#100](https://github.com/litstack/litstack/pull/100))
-   Added `right` method to `datetime` field ([#96](https://github.com/litstack/litstack/pull/96))
-   Added boolean support for table column value options ([
    129f722](https://github.com/litstack/litstack/commit/129f722e26f5af7f386cc46e2b4aac9fe783ea49))
-   Added datetime field methods `minuteInterval` and `disableHours` ([#110](https://github.com/litstack/litstack/pull/110))
-   Added medialibrary 9 support ([720290d](https://github.com/litstack/litstack/commit/720290d4aec58d7811bb7b7dea4b9ad56e00be34))
-   Added wysiwyg field settings to `lit` config ([#120](https://github.com/litstack/litstack/pull/120))
-   Images can now be recropped after upload ([#108](https://github.com/litstack/litstack/pull/108))

### Fixed

-   Fixed relation form modal closing after saving ([62db77e](https://github.com/litstack/litstack/commit/62db77e92fe5b29d7fdd27393e7e8c3a41f4573d))
-   Fixed installation issue with custom permissions tables names ([#105](https://github.com/litstack/litstack/issues/105), [#106](https://github.com/litstack/litstack/pull/106))
-   Fixed image column `square` ([#95](https://github.com/litstack/litstack/pull/95))
-   Fixed crud config route binding ([9a2f5db](https://github.com/litstack/litstack/commit/9a2f5dbe2c6801d7b164a6ce57b564a394d68e2a))

### Changed

-   Moved litstack core ServiceProvider's to the config `lit.providers` ([#99](https://github.com/litstack/litstack/issues/99), [#101](https://github.com/litstack/litstack/pull/101))
-   Improvid ordering performance ([a7558cb](https://github.com/litstack/litstack/commit/a7558cbf014d2c58f0655cd3b25a60bce29f8db5))
