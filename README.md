# DoctrineEnumTypeBundle

Configures [Doctrine Enum Type](https://github.com/acelaya/doctrine-enum-type) via Symfony config file.

## Installation

```
composer require danaki/doctrine-enum-type-bundle
```

## Usage

Create `config/packages/doctrine_enum_type.yaml` with similar contents:
```
danaki_doctrine_enum_type:
    types:
        php_enum_gender: Acelaya\Enum\Gender
        App\Enum\YourEnum: ~
        php_enum_flag:
            enum_class: App\Enum\Flag
            type_class: App\Doctrine\Types\NumericPhpEnumType

    # For easier configuring when there's many enums using the same custom type class
    custom_types:
        App\Doctrine\Types\NumericPhpEnumType:
            php_enum_flag: App\Enum\Flag
            custom_some_other_enum_using_number: App\Enum\SomeOtherEnumUsingNumber
            custom_one_more_enum_using_number: App\Enum\OneMoreEnumUsingANumber
        App\Doctrine\Types\SomeOtherCustomPhpEnumType:
            custom_enum_one: App\Enum\CustomEnumOne
            custom_enum_two: App\Enum\CustomEnumTwo

```

## Problems

If you're getting "Unknown column type" error, try to clear cache with `rm -rf var/cache`
