

Omni Control
================================================================================

Omni Control is a collection of tweaks for WordPress websites.

It offers tweaks that are simple in implementation and that rely on simple and stable parts of the WordPress API.

Tweaks can be enabled and disabled individually or all at once. By default all tweaks are disabled.


Notes
--------------------------------------------------------------------------------

Most tweaks are self-explanatory. Below are a few notes for the rest.

**Reverse the parts of the document title**. Puts the site title before the page title. Useful if you prefer this order but don’t use an SEO plugin. If you use an SEO plugin, the reversal is better dealt there.

**Remove jQuery Migrate**. Can break themes and plugins that use old versions of jQuery! However, plugins and themes that break without jQuery Migrate will need updating sooner or later: [The future of jQuery Migrate in WordPress](https://make.wordpress.org/core/2020/06/29/updating-jquery-version-shipped-with-wordpress/)

**Remove type from script and style elements**. **CONDITIONAL**. Only runs if the current theme does not register support for HTML5 *script* and *style* elements. (If the theme registers support for HTML5 *script* and *style*, there is no type to remove.)

**Remove query string from static resources**. **TENTATIVE**. Popular tweak but I have not seen real-world benefits from using it.


Tweaks
--------------------------------------------------------------------------------

### Miscellaneous

-   Disable smilies
-   Disable visual editor
-   Disable pings completely
-   Remove WordPress.org link from meta widget
-   Reverse the parts of the document title

### HTML document

-   Remove type from *script* and *style* elements

### HTML document HEAD

-   Remove RSD link
-   Remove WLW manifest link
-   Remove REST API link
-   Remove shortlink
-   Remove prev/next rel links
-   Remove canonical link
-   Remove WordPress version

### Performance

-   Remove Dashicons CSS for visitors
-   Remove Gutenberg CSS
-   Remove jQuery Migrate
-   Remove query string from static resources

### HTTP response headers

-   Remove shortlink
-   Remove REST API link

### Administration area

-   Disable update/maintenance nag for non-admins
-   Remove help tabs
-   Remove message from footer
-   Remove version from footer

### WP Toolbar

-   Remove WordPress menu
-   Remove Customize link
-   Remove *Howdy*
-   Remove UpdraftPlus menu