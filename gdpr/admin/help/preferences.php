<style>
pre, blockquote p {
    font-size: 1rem;
    padding-top: .66001rem;
}
pre code {
    padding: 0;
    font-size: inherit;
    color: inherit;
    white-space: pre-wrap;
    background-color: transparent;
    border-radius: 0;
    border: none;
}
.hljs-number, .hljs-command, .hljs-string, .hljs-tag .hljs-value, .hljs-rules .hljs-value, .hljs-phpdoc, .hljs-dartdoc, .tex .hljs-formula, .hljs-regexp, .hljs-hexcolor, .hljs-link_url {
    color: #2aa198;
}
.hljs-preprocessor, .hljs-preprocessor .hljs-keyword, .hljs-pragma, .hljs-shebang, .hljs-symbol, .hljs-symbol .hljs-string, .diff .hljs-change, .hljs-special, .hljs-attr_selector, .hljs-subst, .hljs-cdata, .css .hljs-pseudo, .hljs-header {
    color: #cb4b16;
}
.hljs-title, .hljs-localvars, .hljs-chunk, .hljs-decorator, .hljs-built_in, .hljs-identifier, .vhdl .hljs-literal, .hljs-id, .css .hljs-function {
    color: #268bd2;
}
.hljs-attribute, .hljs-variable, .lisp .hljs-body, .smalltalk .hljs-number, .hljs-constant, .hljs-class .hljs-title, .hljs-parent, .hljs-type, .hljs-link_reference {
    color: #b58900;
}
</style>

<div class="d-flex w-100 pt-2 mb-3">
    <a class="btn btn-primary btn-sm" style="height:inherit;" href="<?php echo osc_route_admin_url('gdpr-admin-settings'); ?>"><?php _e('Return to GDPR settings', 'gdpr'); ?></a>
</div>
 
<h1><a id="Alert__Bender_theme_4"></a>GDPR preferences - Bender theme</h1>
<p>The default process to action GDPR popup preferences is to hide or remove HTML div elements that have a class name prefix that identifies the type of element.</p>
<p>'ads_' for marketing elements:</p>
<pre><code class="language-sh">&lt;div class="ads_header"&gt;
</code><code class="language-sh">...
</code><code class="language-sh">&lt;div&gt;
</code></pre>
<p>'anl_' for analytics elements:</p>
<pre><code class="language-sh">&lt;div class="anl_google"&gt;
</code><code class="language-sh">...
</code><code class="language-sh">&lt;div&gt;
</code></pre>
<p>'prf_' for preferences elements:</p>
<pre><code class="language-sh">&lt;div class="prf_register"&gt;
</code><code class="language-sh">...
</code><code class="language-sh">&lt;div&gt;
</code></pre>
<h3><a id="1_update_theme_elements"></a>1) Update theme elements.</h3>
<p>Ensure that every element within your theme has the correct class name to enable it to be hidden or removed.</p>
<p>The default bender theme already has marketing elements identified with a class name with ads_ prefix..</p>
<h3><a id="2_check_gdpr_javascript_settings"></a>2) Check the GDPR settings page javascript.</h3>
<p>Check the Javascript to disable or hide each type of element. The default is to hide the element, but it may be more appropriate to disable a category's elements.</p>
<pre><code class="language-js">$(<span class="hljs-string">'div[class*="ads_"'</span>)).hide();
</code></pre>
<p>Or set it to:</p>
<pre><code class="language-js">$(<span class="hljs-string">'div[class*="ads_"'</span>)).disable();
</code></pre>
