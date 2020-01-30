# Coupon Listing on Cart Page

With the help of coupon list plugin, assist your customers to take the benefits of attractive discounts before placing the order on your online store. Display all the coupons to the customer in a list form on the cart or checkout page, so they can get most of the offers & take home the products at the best price from a single place. The admin can restrict the coupons to be visible on the frontend & can also limit the number of coupons to be shown under the list of all available coupons.


# Features

- The coupons are present on the cart as well as on the checkout page.

- Show/hide coupons to be visible under the all coupon list.
 
- The coupon list view can appear as pop up on the cart & checkout page.

- The customer can apply the coupon code & it will be applied on cart / checkout page.

- The admin can enable and disable the coupon list at the cart / checkout page.

- Automatically filters expire coupon(s) and user restricted coupon(s), not applicable coupons.

 
# Installation/Uninstallation [Versions supported: 2.3.x onwards]

**Steps to install with composer**

- composer require ambab/module-couponlist

- bin/magento module:enable Ambab_CouponList

- bin/magento setup:upgrade

- bin/magento setup:di:compile

- bin/magento cache:flush

**Steps to uninstall a composer installed module**

- bin/magento module:disable Ambab_CouponList

- bin/magento module:uninstall Ambab_CouponList

- composer remove ambab/module-couponlist

- bin/magento cache:flush


**Steps to install module manually in app/code**

- Add directory to app/code/Ambab/CouponList manually

- bin/magento module:enable Ambab_CouponList

- bin/magento setup:upgrade

- bin/magento cache:flush

**Steps to uninstall a manually added module in app/code**

- bin/magento module:disable Ambab_CouponList

- remove directory from app/code/Ambab/CouponList manually

- bin/magento setup:upgrade

- bin/magento cache:flush


# Configurations

Go to Admin -> Stores -> Configuration -> Ambab -> Coupon List to configure CouponListing

Option to enable/disable module. 

## Contribute

Feel free to fork and contribute to this module by creating a PR to master branch (https://github.com/ambab-infotech/couponlist).

## Support

For issues please raise here https://github.com/ambab-infotech/couponlist/issues

In case of additional support feel free to reach out at tech.support@ambab.com
