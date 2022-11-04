# Pretix Shortcodes for Wordpress

A Wordpress plugin to add shortcodes for Pretix using the [Embeddable Widget](https://docs.pretix.eu/en/latest/user/events/widget.html)

## Installation

Install plugin and configure the `Organization URL` in the settings and optionally alter the widged style and script paths.

## Button

### Styling

Add some css in your theme to style the button, e.g.:

```
.pretix-button {
  background-color: #C8BBAD;
  border: none;
  border-radius: 12px;
  color: #FFFFFF;
  font-size: 19px;
  padding: 8px 16px;
  cursor: pointer;
}
```

### Usage

```
[pretix-button event="eventname"]
```

Optionally the following attributes can be configured:

* `event`: The event
* `subevent`: A subevent to be pre-selected
* `voucher`: A voucher code to be pre-selected
* `items`: A collection of items to be put in the cart
* `iframe`: if set to `disable` the shop will alway be opened in new window
* `text`: Button Text

### Usage with custom fields

It is also possible to configure the shortcode by custom fields in e.g. a post or event ([The Events Calendar](https://wordpress.org/plugins/the-events-calendar/))
In this case it is enough to only add the shortcode without attributes

```
[pretix-button]
```

The following custom fields can be set:

* `pretix_event`: The event
* `pretix_subevent`: A subevent to be pre-selected
* `pretix_voucher`: A voucher code to be pre-selected
* `pretix_items`: A collection of items to be put in the cart
* `pretix_iframe`: if set to `disable` the shop will alway be opened in new window
* `pretix_text`: Button Text

At least `pretix_event` needs to be set in the post/event. Shortcode attributes do have precedence.

## Widget

### Styling

There are many custom classes prefixed with `pretix-widget` that can be customized.

### Usage

```
[pretix-widget event="eventname"]
```

Optionally the following attributes can be configured:

* `event`: The event, if empty string all events will be shown.
* `subevent`: A subevent to be pre-selected
* `voucher`: A voucher code to be pre-selected
* `vouchers`: if set to `disable` the voucher input is disabled
* `iframe`: if set to `disable` the shop will alway be opened in new window
* `style`: Show series as `list`, `calendar` or `week`
* `items`: Filter by a list of product IDs
* `categories`: Filter by one or more categories
* `variations`: Filter by one or more variations
* `filter`: Filter by meta data attributes

### Usage with custom fields

It is also possible to configure the shortcode by custom fields in e.g. a post or event ([The Events Calendar](https://wordpress.org/plugins/the-events-calendar/))
In this case it is enough to only add the shortcode without attributes

```
[pretix-widget]
```

The following custom fields can be set:

* `pretix_event`: The event, if empty string all events will be shown.
* `pretix_subevent`: A subevent to be pre-selected
* `pretix_voucher`: A voucher code to be pre-selected
* `pretix_vouchers`: if set to `disable` the voucher input is disabled
* `pretix_iframe`: if set to `disable` the shop will alway be opened in new window
* `pretix_style`: Show series as `list`, `calendar` or `week`
* `pretix_items`: Filter by a list of product IDs
* `pretix_categories`: Filter by one or more categories
* `pretix_variations`: Filter by one or more variations
* `pretix_filter`: Filter by meta data attributes

At least `pretix_event` needs to be set in the post/event. Shortcode attributes do have precedence.