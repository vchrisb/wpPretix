# Pretix Shortcodes for Wordpress

A Wordpress plugin to add shortcodes for Pretix

## Installation

Install plugin and configure the `Organization URL` in the settings.

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

* `subevent`: A subevent to be pre-selected
* `voucher`: A voucher code to be pre-selected
* `items`: A collection of items to be put in the cart
* `iframe`: if set to `disable` the shop will alway be opened in new window

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

At least `pretix_event` needs to be set in the post/event