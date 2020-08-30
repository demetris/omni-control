
Omni Control
================================================================================

Omni Control is an assortment of optional tweaks for WordPress websites.

It offers tweaks that are simple to implement and that rely on simple and stable parts of the WordPress API.



Settings notes
--------------------------------------------------------------------------------

Most settings are self-explanatory. Below are a few notes that go beyond the obvious.

### Reverse the parts of the document title

Puts the site title before the page title. Useful if you prefer this order but don’t have an SEO plugin. If you have an SEO plugin, it’s better dealt there.

### Remove jQuery Migrate

Can break themes and plugins! If it does, contact their authors and ask kindly if they could find the time to update their code. – [On the future of jQuery Migrate in WordPress core](https://make.wordpress.org/core/2020/06/29/updating-jquery-version-shipped-with-wordpress/)

### Remove type from script and style elements – CONDITIONAL

Only takes effect if the current theme does not register support for HTML5 *script* and *style* elements. (If the theme registers support for HTML5 *script* and *style*, there is nothing to remove.)

###  Remove query string from static resources – TENTATIVE

Popular tweak but I have not seen real-world benefits from using it.