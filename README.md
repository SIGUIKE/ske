<div align="center">
    <p><a href="https://sikessem.com/" title="SIKessEm"><img src="https://github.com/sikessem/static/blob/main/logo.svg" alt="SIKessEm logo" height="300"/></a></p>
    <p>
        <a href="https://github.com/sikessem/ske/blob/HEAD/LICENSE"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="SIKessEm Package is released under the MIT license."/></a>
        <a href="https://github.com/sikessem/ske/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/workflow/status/sikessem/ske/Tests/main"/></a>
        <a href="https://packagist.org/packages/sikessem/ske"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/sikessem/ske"/></a>
        <a href="https://packagist.org/packages/sikessem/ske"><img alt="Latest Version" src="https://img.shields.io/packagist/v/sikessem/ske"/></a>
        <a href="https://packagist.org/packages/sikessem/ske"><img alt="License" src="https://img.shields.io/packagist/l/sikessem/ske"/></a>
        <a href="https://sikessem.github.io/ske/contributing"><img src="https://img.shields.io/badge/PRs-welcome-brightgreen.svg" alt="PRs welcome!"/></a>
        <a href="https://twitter.com/intent/follow?screen_name=ske_sikessem"><img src="https://img.shields.io/twitter/follow/ske_sikessem.svg?label=Follow%20@ske_sikessem" alt="Follow @ske_sikessem"/></a>
    </p>
</div>

***

# Create a new SIKessEm Package

Create a template based on this repository to create your custom package.

### 🔖 Contents

- [Getting Started](#-getting-started)
- [Requirements](#-requirements)
- [Documentation](#-documentation)
- [Community](#-community)
- [Security Reports](#-security-reports)
- [Contribution](#-contribution)
- [License](#-license)

## 🎉 Getting Started

⚡️ Create your [Custom Package](https://github.com/sikessem/ske) using [Composer](https://getcomposer.org/):

- as template:
```bash
create-project sikessem/ske --prefer-source package
```
- as dependency:
```bash
composer require sikessem/ske --no-dev
```

🧹 Keep a modern codebase with **Pint**:
```bash
composer lint
```

⚗️ Run static analysis using **PHPStan**:
```bash
composer test:types
```

✅ Run unit tests using **PEST**
```bash
composer test:unit
```

🚀 Run the entire test suite:
```bash
composer test
```

## 📋 Requirements

> **Requires [PHP 8.1+](https://php.net/releases/)** (at least 8.1.11 recommended to avoid potential bugs).

## 📖 Documentation

The full documentation for Ske can be found on [our Documentation][docs].

[docs]: https://sikessem.github.io/ske

## 💬 Community

For support, you can use [our GitHub Discussions](https://github.com/sikessem/ske/discussions).

## 👥 Contribution

Read [our contributing guide][c] to learn about our development process, how to propose bugfixes and improvements, and how to build and test your changes to Package.

[c]: https://github.com/sikessem/ske/blob/HEAD/CONTRIBUTING.md

## 🔐 Security Reports

If you discover a security vulnerability within Package, please send an e-mail to [SIGUI Kessé Emmanuel](https://sikessem.com) via [ske@sikessem.com](mailto:ske@sikessem.com). All security vulnerabilities will be promptly addressed.

## 📄 License

The SIKessEm Package is open-sourced software licensed under the  [MIT License](https://opensource.org/licenses/MIT) - see the [LICENSE][l] file for details.

[l]: https://github.com/sikessem/ske/blob/HEAD/LICENSE

------

**Ske** was created by [SIGUI Kessé Emmanuel](https://sikessem.com).
