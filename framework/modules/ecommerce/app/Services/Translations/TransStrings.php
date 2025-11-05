<?php

namespace FluentCart\App\Services\Translations;
class TransStrings
{
    public static function getStrings(): array
    {
        $translations = require 'admin-translation.php';
        return apply_filters("fluent_cart/admin_translations", $translations, []);
    }

    public static function blockStrings(): array
    {
        $translations = require 'block-editor-translation.php';
        return apply_filters("fluent_cart/blocks_translations", $translations, []);
    }


    public static function getShopAppBlockEditorString(): array
    {

        return [
            'Also search in Content'            => _x('Also search in Content', 'Shop App Block Editor', 'fluent-cart'),
            'Apply Filter'                      => _x('Apply Filter', 'Shop App Block Editor', 'fluent-cart'),
            'Add to Cart'                       => _x('Add to Cart', 'Shop App Block Editor', 'fluent-cart'),
            'Default'                           => _x('Default', 'Shop App Block Editor', 'fluent-cart'),
            'Display Name For Filter'           => _x('Display Name For Filter', 'Shop App Block Editor', 'fluent-cart'),
            'Enable Default Filtering'          => _x('Enable Default Filtering', 'Shop App Block Editor', 'fluent-cart'),
            'Enable Filtering'                  => _x('Enable Filtering', 'Shop App Block Editor', 'fluent-cart'),
            'Enable'                            => _x('Enable', 'Shop App Block Editor', 'fluent-cart'),
            'Enabled?'                          => _x('Enabled?', 'Shop App Block Editor', 'fluent-cart'),
            'Filter Option'                     => _x('Filter Option', 'Shop App Block Editor', 'fluent-cart'),
            'Grid'                              => _x('Grid', 'Shop App Block Editor', 'fluent-cart'),
            'List'                              => _x('List', 'Shop App Block Editor', 'fluent-cart'),
            'Numbers'                           => _x('Numbers', 'Shop App Block Editor', 'fluent-cart'),
            'Option'                            => _x('Option', 'Shop App Block Editor', 'fluent-cart'),
            'Paginator'                         => _x('Paginator', 'Shop App Block Editor', 'fluent-cart'),
            'Per Page'                          => _x('Per Page', 'Shop App Block Editor', 'fluent-cart'),
            'Product Box Grid Size'             => _x('Product Box Grid Size', 'Shop App Block Editor', 'fluent-cart'),
            'Product Categories'                => _x('Product Categories', 'Shop App Block Editor', 'fluent-cart'),
            'Product Grid Size'                 => _x('Product Grid Size', 'Shop App Block Editor', 'fluent-cart'),
            'Product Types'                     => _x('Product Types', 'Shop App Block Editor', 'fluent-cart'),
            'Product'                           => _x('Product', 'Shop App Block Editor', 'fluent-cart'),
            'Range Filter Only works in pages.' => _x('Range Filter Only works in pages.', 'Shop App Block Editor', 'fluent-cart'),
            'Scroll'                            => _x('Scroll', 'Shop App Block Editor', 'fluent-cart'),
            'Search Grid Size'                  => _x('Search Grid Size', 'Shop App Block Editor', 'fluent-cart'),
            'Search'                            => _x('Search', 'Shop App Block Editor', 'fluent-cart'),
            'View mode'                         => _x('View mode', 'Shop App Block Editor', 'fluent-cart'),
            'Wildcard Filter'                   => _x('Wildcard Filter', 'Shop App Block Editor', 'fluent-cart'),

            'Primary'                => _x('Primary', 'Shop App Block Editor', 'fluent-cart'),
            'Product Heading'        => _x('Product Heading', 'Shop App Block Editor', 'fluent-cart'),
            'Text'                   => _x('Text', 'Shop App Block Editor', 'fluent-cart'),
            'Border'                 => _x('Border', 'Shop App Block Editor', 'fluent-cart'),
            'Badge Count Background' => _x('Badge Count Background', 'Shop App Block Editor', 'fluent-cart'),
            'Badge Count'            => _x('Badge Count', 'Shop App Block Editor', 'fluent-cart'),
            'Badge Count Border'     => _x('Badge Count Border', 'Shop App Block Editor', 'fluent-cart'),


            'Background'                => _x('Background', 'Shop App Block Editor', 'fluent-cart'),
            'Input Border'              => _x('Input Border', 'Shop App Block Editor', 'fluent-cart'),
            'Input Focus Border'        => _x('Input Focus Border', 'Shop App Block Editor', 'fluent-cart'),
            'Heading'                   => _x('Heading', 'Shop App Block Editor', 'fluent-cart'),
            'Label'                     => _x('Label', 'Shop App Block Editor', 'fluent-cart'),
            'Item Border'               => _x('Item Border', 'Shop App Block Editor', 'fluent-cart'),
            'Reset Button Bg'           => _x('Reset Button Bg', 'Shop App Block Editor', 'fluent-cart'),
            'Reset Button'              => _x('Reset Button', 'Shop App Block Editor', 'fluent-cart'),
            'Reset Button Border'       => _x('Reset Button Border', 'Shop App Block Editor', 'fluent-cart'),
            'Reset Button Hover Bg'     => _x('Reset Button Hover Bg', 'Shop App Block Editor', 'fluent-cart'),
            'Reset Button Hover'        => _x('Reset Button Hover', 'Shop App Block Editor', 'fluent-cart'),
            'Reset Button Hover Border' => _x('Reset Button Hover Border', 'Shop App Block Editor', 'fluent-cart'),
            'Checkbox'                  => _x('Checkbox', 'Shop App Block Editor', 'fluent-cart'),
            'Checkbox Active'           => _x('Checkbox Active', 'Shop App Block Editor', 'fluent-cart'),
            'Checkmark Bg'              => _x('Checkmark Bg', 'Shop App Block Editor', 'fluent-cart'),
            'Checkmark Border'          => _x('Checkmark Border', 'Shop App Block Editor', 'fluent-cart'),
            'Checkmark Active Bg'       => _x('Checkmark Active Bg', 'Shop App Block Editor', 'fluent-cart'),
            'Checkmark Active Border'   => _x('Checkmark Active Border', 'Shop App Block Editor', 'fluent-cart'),
            'Checkmark After Border'    => _x('Checkmark After Border', 'Shop App Block Editor', 'fluent-cart'),
            'Range Slider Connect Bg'   => _x('Range Slider Connect Bg', 'Shop App Block Editor', 'fluent-cart'),

        ];
    }

    public static function getCustomerProfileString(): array
    {
        $translations = require 'customer-profile-translation.php';
        return apply_filters("fluent_cart/customer_profile_translations", $translations, []);
    }

    public static function singleProductPageString(): array
    {
        return [
            'In Stock'     => _x('In Stock', 'Single Product Page', 'fluent-cart'),
            'Out Of Stock' => _x('Out Of Stock', 'Single Product Page', 'fluent-cart'),
        ];
    }

    public static function checkoutPageString()
    {
        $translations = require 'checkout-translation.php';
        return apply_filters("fluent_cart/checkout_translations", $translations, []);
    }

    public static function paymentsString()
    {
        $translations = require 'payments-translation.php';
        return apply_filters("fluent_cart/payments_translations", $translations, []);
    }

    public static function elStrings(): array
    {
        return [
            'name' => get_locale(),
            'el'   => [
                'colorpicker' => [
                    'confirm' => __('Confirm', 'fluent-cart'),
                    'clear'   => __('Clear', 'fluent-cart'),
                ],
                'datepicker'  => [
                    'now'        => __('Now', 'fluent-cart'),
                    'today'      => __('Today', 'fluent-cart'),
                    'cancel'     => __('Cancel', 'fluent-cart'),
                    'clear'      => __('Clear', 'fluent-cart'),
                    'confirm'    => __('Confirm', 'fluent-cart'),
                    'selectDate' => __('Select date', 'fluent-cart'),
                    'selectTime' => __('Select time', 'fluent-cart'),
                    'startDate'  => __('Start date', 'fluent-cart'),
                    'startTime'  => __('Start time', 'fluent-cart'),
                    'endDate'    => __('End date', 'fluent-cart'),
                    'endTime'    => __('End time', 'fluent-cart'),
                    'prevYear'   => __('Previous year', 'fluent-cart'),
                    'nextYear'   => __('Next year', 'fluent-cart'),
                    'prevMonth'  => __('Previous month', 'fluent-cart'),
                    'nextMonth'  => __('Next month', 'fluent-cart'),
                    'year'       => __('Year', 'fluent-cart'),
                    'month1'     => __('January', 'fluent-cart'),
                    'month2'     => __('February', 'fluent-cart'),
                    'month3'     => __('March', 'fluent-cart'),
                    'month4'     => __('April', 'fluent-cart'),
                    'month5'     => __('May', 'fluent-cart'),
                    'month6'     => __('June', 'fluent-cart'),
                    'month7'     => __('July', 'fluent-cart'),
                    'month8'     => __('August', 'fluent-cart'),
                    'month9'     => __('September', 'fluent-cart'),
                    'month10'    => __('October', 'fluent-cart'),
                    'month11'    => __('November', 'fluent-cart'),
                    'month12'    => __('December', 'fluent-cart')
                ],
                'select'      => [
                    'loading'     => __('Loading', 'fluent-cart'),
                    'noMatch'     => __('No match', 'fluent-cart'),
                    'noData'      => __('No data', 'fluent-cart'),
                    'placeholder' => __('Select', 'fluent-cart'),
                ],
                'cascader'    => [
                    'noMatch'     => __('No match', 'fluent-cart'),
                    'loading'     => __('Loading', 'fluent-cart'),
                    'placeholder' => __('Select', 'fluent-cart'),
                    'noData'      => __('No data', 'fluent-cart'),
                ],
                'pagination'  => [
                    'goto'               => __('Go to', 'fluent-cart'),
                    'pagesize'           => __('per page', 'fluent-cart'),
                    'total'              => __('Total {total}', 'fluent-cart'),
                    'pageClassifier'     => __('page', 'fluent-cart'),
                    'page'               => __('page', 'fluent-cart'),
                    'prev'               => __('Prev', 'fluent-cart'),
                    'next'               => __('Next', 'fluent-cart'),
                    'currentPage'        => __('Page {pager}', 'fluent-cart'),
                    'prevPages'          => __('Previous {pager} pages', 'fluent-cart'),
                    'nextPages'          => __('Next {pager} pages', 'fluent-cart'),
                    'deprecationWarning' => '',
                ],
                'messagebox'  => [
                    'title'   => __('Message', 'fluent-cart'),
                    'confirm' => __('Confirm', 'fluent-cart'),
                    'cancel'  => __('Cancel', 'fluent-cart'),
                    'error'   => __('Invalid input', 'fluent-cart'),
                ],
                'upload'      => [
                    'deleteTip' => __('press delete to remove', 'fluent-cart'),
                    'delete'    => __('Delete', 'fluent-cart'),
                    'preview'   => __('Preview', 'fluent-cart'),
                    'continue'  => __('Continue', 'fluent-cart'),
                ],
                'table'       => [
                    'emptyText'     => __('No data', 'fluent-cart'),
                    'confirmFilter' => __('Confirm', 'fluent-cart'),
                    'resetFilter'   => __('Reset', 'fluent-cart'),
                    'clearFilter'   => __('All', 'fluent-cart'),
                    'sumText'       => __('Sum', 'fluent-cart'),
                ],
                'tree'        => [
                    'emptyText' => __('No data', 'fluent-cart'),
                ],
                'transfer'    => [
                    'noMatch'           => __('No match', 'fluent-cart'),
                    'noData'            => __('No data', 'fluent-cart'),
                    'titles'            => [__('List 1', 'fluent-cart'), __('List 2', 'fluent-cart')],
                    'filterPlaceholder' => __('Enter keyword', 'fluent-cart'),
                    'noCheckedFormat'   => __('{total} items', 'fluent-cart'),
                    'hasCheckedFormat'  => __('{checked}/{total} selected', 'fluent-cart'),
                ],
                'image'       => [
                    'error' => __('Failed', 'fluent-cart'),
                ],
                'pageHeader'  => [
                    'title' => __('Go back', 'fluent-cart'),
                ],
                'popconfirm'  => [
                    'confirmButtonText' => __('Yes', 'fluent-cart'),
                    'cancelButtonText'  => __('No', 'fluent-cart'),
                ],
                'empty'       => [
                    'description' => __('No data', 'fluent-cart'),
                ],
            ],
        ];
    }

    public static function dateTimeStrings(): array
    {
        return [
            'weekdays'      => array(
                'sunday'    => _x('Sunday', 'weekdays', 'fluent-cart'),
                'monday'    => _x('Monday', 'weekdays', 'fluent-cart'),
                'tuesday'   => _x('Tuesday', 'weekdays', 'fluent-cart'),
                'wednesday' => _x('Wednesday', 'weekdays', 'fluent-cart'),
                'thursday'  => _x('Thursday', 'weekdays', 'fluent-cart'),
                'friday'    => _x('Friday', 'weekdays', 'fluent-cart'),
                'saturday'  => _x('Saturday', 'weekdays', 'fluent-cart'),
            ),
            'months'        => array(
                'January'   => _x('January', 'months', 'fluent-cart'),
                'February'  => _x('February', 'months', 'fluent-cart'),
                'March'     => _x('March', 'months', 'fluent-cart'),
                'April'     => _x('April', 'months', 'fluent-cart'),
                'May'       => _x('May', 'months', 'fluent-cart'),
                'June'      => _x('June', 'months', 'fluent-cart'),
                'July'      => _x('July', 'months', 'fluent-cart'),
                'August'    => _x('August', 'months', 'fluent-cart'),
                'September' => _x('September', 'months', 'fluent-cart'),
                'October'   => _x('October', 'months', 'fluent-cart'),
                'November'  => _x('November', 'months', 'fluent-cart'),
                'December'  => _x('December', 'months', 'fluent-cart')
            ),
            'weekdaysShort' => array(
                'sun' => _x('Sun', 'weekdaysShort', 'fluent-cart'),
                'mon' => _x('Mon', 'weekdaysShort', 'fluent-cart'),
                'tue' => _x('Tue', 'weekdaysShort', 'fluent-cart'),
                'wed' => _x('Wed', 'weekdaysShort', 'fluent-cart'),
                'thu' => _x('Thu', 'weekdaysShort', 'fluent-cart'),
                'fri' => _x('Fri', 'weekdaysShort', 'fluent-cart'),
                'sat' => _x('Sat', 'weekdaysShort', 'fluent-cart')
            ),
            'monthsShort'   => array(
                'jan' => _x('Jan', 'monthsShort', 'fluent-cart'),
                'feb' => _x('Feb', 'monthsShort', 'fluent-cart'),
                'mar' => _x('Mar', 'monthsShort', 'fluent-cart'),
                'apr' => _x('Apr', 'monthsShort', 'fluent-cart'),
                'may' => _x('May', 'monthsShort', 'fluent-cart'),
                'jun' => _x('Jun', 'monthsShort', 'fluent-cart'),
                'jul' => _x('Jul', 'monthsShort', 'fluent-cart'),
                'aug' => _x('Aug', 'monthsShort', 'fluent-cart'),
                'sep' => _x('Sep', 'monthsShort', 'fluent-cart'),
                'oct' => _x('Oct', 'monthsShort', 'fluent-cart'),
                'nov' => _x('Nov', 'monthsShort', 'fluent-cart'),
                'dec' => _x('Dec', 'monthsShort', 'fluent-cart')
            ),
            'am'          => __('AM', 'fluent-cart'),
            'pm'          => __('PM', 'fluent-cart')
        ];
    }
}
