# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 5.2.0 - TBD

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 5.1.0 - 2021-01-18

-----

### Release Notes for [5.1.0](https://github.com/nucleos/nucleos-form-extensions/milestone/1)



### 5.1.0

- Total issues resolved: **0**
- Total pull requests resolved: **7**
- Total contributors: **2**

#### Bug

 - [180: Rename form prefixes](https://github.com/nucleos/nucleos-form-extensions/pull/180) thanks to @core23
 - [141: Missing dependency](https://github.com/nucleos/nucleos-form-extensions/pull/141) thanks to @core23

#### dependency

 - [175: Bump pugx/autocompleter-bundle](https://github.com/nucleos/nucleos-form-extensions/pull/175) thanks to @core23
 - [155: Bump ini from 1.3.5 to 1.3.8](https://github.com/nucleos/nucleos-form-extensions/pull/155) thanks to @dependabot[bot]
 - [144: Add support for PHP 8](https://github.com/nucleos/nucleos-form-extensions/pull/144) thanks to @core23

#### Enhancement

 - [70: Move configuration to PHP](https://github.com/nucleos/nucleos-form-extensions/pull/70) thanks to @core23


-----

## 5.0.0

### Changes

- Renamed namespace `Core23\Form` to `Nucleos\Form` after move to [@nucleos]

  Run

  ```
  $ composer remove core23/form-extensions
  ```

  and

  ```
  $ composer require nucleos/form-extensions
  ```

  to update.

  Run

  ```
  $ find . -type f -exec sed -i '.bak' 's/Core23\\Form/Nucleos\\Form/g' {} \;
  ```

  to replace occurrences of `Core23\Form` with `Nucleos\Form`.

  Run

  ```
  $ find -type f -name '*.bak' -delete
  ```

  to delete backup files created in the previous step.

### 🚀 Features

- Add combined assets [@core23] ([#68])

### 📦 Dependencies

- Drop support for PHP 7.2 [@core23] ([#59])


## 4.0.2

### Changes

### 🐛 Bug Fixes

- Fix wrong date after validation for null values [@core23] ([#55])

## 4.0.1

### Changes

### 🐛 Bug Fixes

- Remove date after violation if not required [@core23] ([#54])

## 4.0.0

### Changes

- Use class alias in validators [@core23] ([#50])
- Add missing strict file header [@core23] ([#44])
- Add missing (optional) doctrine extension [@core23] ([#39])
- Use dataset instead of getAttribute [@core23] ([#34])

### ❌ BC Breaks

- Remove custom Date(Time)PickerType [@core23] ([#40])

### 🚀 Features

- Add support for symfony 5 [@core23] ([#32])

### 📦 Dependencies

- Add missing twig bridge dependency [@core23] ([#31])

[#68]: https://github.com/nucleos/nucleos-form-extensions/pull/68
[#59]: https://github.com/nucleos/nucleos-form-extensions/pull/59
[#55]: https://github.com/nucleos/nucleos-form-extensions/pull/55
[#54]: https://github.com/nucleos/nucleos-form-extensions/pull/54
[#50]: https://github.com/nucleos/nucleos-form-extensions/pull/50
[#44]: https://github.com/nucleos/nucleos-form-extensions/pull/44
[#40]: https://github.com/nucleos/nucleos-form-extensions/pull/40
[#39]: https://github.com/nucleos/nucleos-form-extensions/pull/39
[#34]: https://github.com/nucleos/nucleos-form-extensions/pull/34
[#32]: https://github.com/nucleos/nucleos-form-extensions/pull/32
[#31]: https://github.com/nucleos/nucleos-form-extensions/pull/31
[@nucleos]: https://github.com/nucleos
[@core23]: https://github.com/core23
