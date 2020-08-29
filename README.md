
Omni Control
================================================================================

Omni Control is an assortment of tweaks for WordPress websites.

It offers tweaks that are simple and that rely on simple and stable parts of the WordPress API.



Settings notes
--------------------------------------------------------------------------------

Most settings are self-explanatory. Below are a few notes that go beyond the obvious.

**Reverse the parts of the document title**. Puts the site title before the page title. Useful if you prefer this order but don’t have an SEO plugin. If you have an SEO plugin, it’s better dealt there.

**Remove jQuery Migrate**. Can break themes and plugins! If it does, you can contact their authors and ask kindly if they could find the time to update their code. [On the future of jQuery Migrate in WordPress core](https://make.wordpress.org/core/2020/06/29/updating-jquery-version-shipped-with-wordpress/)

**Remove type from CSS and JavaScript resources**. **DEPRECATED**. Not needed for themes that declare support for HTML5 *script* and *style* ([a feature available since November 2019 and WordPress 5.3](https://make.wordpress.org/core/2019/10/15/miscellaneous-developer-focused-changes-in-5-3/)).

**Remove query string from static resources**. **TENTATIVE**. Popular tweak but I have not seen real-world benefits from using it.