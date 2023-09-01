Hi. I'm a starter theme called `starterkit`, Try turning me into the next, most awesome, WordPress theme out there. That's what I'm here for.

Here are some of the interesting things you'll find here:

* A modern workflow with a pre-made command-line interface to turn your project into a more pleasant experience.
* A just right amount of lean, well-commented, modern, HTML5 templates.
* Smartly organized starter CSS in `style.css` that will help you to quickly get your design off the ground.
* Full support for `WooCommerce plugin` integration with hooks in `inc/woocommerce.php`.

Installation
---------------

### Requirements

`starterkit` requires the following dependencies:

- [Node.js](https://nodejs.org/)
- [Composer](https://getcomposer.org/)


### Development Setup

To start using all the tools that come with `starterkit`  you need to install the necessary Node.js and Composer dependencies :

```sh
$ composer install
$ npm install
```

### Available CLI commands

`starterkit` comes packed with CLI commands tailored for WordPress theme development :

- `composer lint:wpcs` : checks all PHP files against [PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/).
- `composer lint:php` : checks all PHP files for syntax errors.
- `composer make-pot` : generates a .pot file in the `languages/` directory.
- `npm run dev` :  watch all files within your dependency graph for changess.

### Quick Guide For Backend

1. In the WordPress backend go to Appearance > Install Plugins. Install and activate ACF Pro & Gravity Forms.
2. In the WordPress backend go to Custom Fields and sync all the fields.

Now you're ready to go! The next step is easy to say, but harder to do: make an awesome WordPress theme. :)

Good luck!
