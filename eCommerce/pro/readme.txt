=== FluentCart Pro ===
Contributors: wpmanageninja, techjewel
Tags: ecommerce, cart, checkout, subscriptions, payments
Requires at least: 6.7
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.2.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Sell Subscriptions, Physical Products, Digital Downloads easier than ever. Built for performance, scalability, and flexibility.

== Description ==
Meet FluentCart. It’s a performance-first, self-hosted eCommerce platform for WordPress. Build your ideal store, whether you sell physical products, subscriptions, downloads, licenses, or all of them. No third-party dependencies, no platform lock-in, and no transaction fees. Just a powerful store on your terms.

[youtube https://www.youtube.com/watch?v=meMM6Nq6laE]

👉 Official Website Link: [Official Website](https://fluentcart.com/)
👉 Join Our Community: [FluentCart Community](https://community.wpmanageninja.com/portal)
👉 Official 5 Minutes Guide: [Getting started with FluentCart](https://fluentcart.com/fluentcart-101/)

== Installation ==
This section describes how to install the plugin and get it working.


OR

1. Upload the plugin files to the `/wp-content/plugins/fluent-cart-pro` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the \'Plugins\' screen in WordPress
3. Use the `FluentCart` -> `Settings` screen to configure the plugin

== Frequently Asked Questions ==

= Can I sell physical and digital products together? =

Absolutely. FluentCart supports hybrid product models with inventory, downloads, licenses, and even installment billing.

= How easy is it to set up and use? =

Very easy. Installation is just like any other WordPress plugin. FluentCart comes with an intuitive interface so you can quickly configure your store settings, add products, and connect payment gateways—all without needing technical expertise.

= Can I sell unlimited products, and how well does it scale? =

There are no limitations on the number of products or orders. FluentCart is built for scalability—how well it performs depends on your hosting infrastructure. With a good hosting setup, your store can scale comfortably.

= Does FluentCart support subscriptions and recurring billing? =

Yes. FluentCart handles subscriptions natively with support for upgrades, downgrades, billing cycles, and trial periods. No transaction fees on Free or Pro.

= Can I customize FluentCart to match my brand? =

Absolutely. FluentCart includes customizable Gutenberg blocks and supports custom CSS for advanced styling. You can even add action buttons to custom WordPress patterns, making it easy to align the cart with your brand’s visual identity.

= Is FluentCart compatible with my current WordPress theme? =

Yes. FluentCart is built using standard WordPress best practices and is compatible with any properly coded theme. It will automatically inherit your theme’s styles unless you choose to override them.

= What payment methods are supported? =
FluentCart supports major global payment options, including Stripe, PayPal, and credit cards. You can also integrate custom payment gateways using webhooks and extend functionality as needed.

= Will FluentCart Charge Fees? =

Never. Even in the free version, simple subscriptions are free and there’s no transaction fee on our end.

= Do I need any paid services to use FluentCart? =
No. FluentCart is fully self-hosted. You connect directly to Stripe or PayPal without middleman services or extra transaction fees.

= Can I customize the checkout and product layouts? =

Yes. FluentCart templates are overrideable, and it supports full visual editing in Gutenberg and Bricks Builder.

= Will store development be expensive with FluentCart? =

Absolutely not. Everything is already built and ready to be placed on your site with minimal coding knowledge needed.



== Changelog ==

= 1.2.3 (Oct 22, 2025) =
- Added LifterLMS integration
- Added LearnDash integration
- Fixed Webhook Config Issue
- Adds CSS variables on cart drawer/shop page
- Adds Refactor class name on frontend page
- Add Total on cart drawer
- Adds Product name on admin create order items
- Adds New hooks for single product and shop page products
- Adds New hook (fluent_cart/hide_unnecessary_decimals)
- Fixes Product comapre at price issue
- Fixes Variation rearrange update issue
- Fixes Console error and shipping method issue
- Fixes Validation message issue when deleting an order
- Fixes Static dollar sign appearing in price range
- Fixes Free Shipping issue that destroyed cart
- Fixes Undefined property issue on product page
- Fixes Exception property issue
- Fixes Remove force POST request validation for IPN
- Fixes Translation strings issue for all modules
- Fixes Payment method not showing issue on stripe
