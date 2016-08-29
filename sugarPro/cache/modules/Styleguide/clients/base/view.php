<?php
$clientCache['Styleguide']['base']['view'] = array (
  'sg-headerpane' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'headerpane\',
    pageData: {},
    section: {},
    page: {},
    section_page: false,
    parent_link: \'\',
    file: \'\',
    keys: [],
    $find: [],

    initialize: function(options) {
        var self = this;

        this._super(\'initialize\', [options]);

        this.pageData = app.metadata.getLayout(this.module, \'docs\').page_data;

        this.file = this.context.get(\'page_name\');

        if (!_.isUndefined(this.file) && !_.isEmpty(this.file)) {
            this.keys = this.file.split(\'-\');
        }

        if (this.keys.length) {
            // get page content variables from pageData (defined in view/docs.php)
            if (this.keys[0] === \'index\') {
                if (this.keys.length > 1) {
                    // section index call
                    this.section = this.pageData[this.keys[1]];
                } else {
                    // master index call
                    this.section = this.pageData[this.keys[0]];
                    //this.index_search = true;
                }
                this.section_page = true;
                this.file = \'index\';
            } else if (this.keys.length > 1) {
                // section page call
                this.section = this.pageData[this.keys[0]];
                this.page = this.section.pages[this.keys[1]];
                this.parent_link = \'-\' + this.keys[0];
            } else {
                // general page call
                this.section = this.pageData[this.keys[0]];
            }
        }
    },

    _render: function() {
        var self = this,
            $optgroup = {};

        // render view
        this._super(\'_render\');

        // styleguide guide doc search
        this.$find = $(\'#find_patterns\');

        if (this.$find.length) {
            // build search select2 options
            $.each(this.pageData, function (k, v) {
                if ( !v.index ) {
                    return;
                }
                $optgroup = $(\'<optgroup>\').appendTo(self.$find).attr(\'label\',v.title);
                $.each(v.pages, function (i, d) {
                    renderSearchOption(k, i, d, $optgroup);
                });
            });

            // search for patterns
            this.$find.on(\'change\', function (e) {
                window.location.href = $(this).val();
            });

            // init select2 control
            this.$find.select2();
        }

        function renderSearchOption(section, page, d, optgroup) {
            $(\'<option>\')
                .appendTo(optgroup)
                .attr(\'value\', (d.url ? d.url : fmtLink(section, page)) )
                .text(d.label);
        }

        function fmtLink(section, page) {
            return \'#Styleguide/docs/\' +
                (page?\'\':\'index-\') + section.replace(/[\\s\\,]+/g,\'-\').toLowerCase() + (page?\'-\'+page:\'\');
        }
    },

    _dispose: function() {
        this.$find.off(\'change\');
        this._super(\'_dispose\');
    }
})
',
    ),
    'meta' => 
    array (
      'template_values' => 
      array (
        'last_updated' => '2014-02-14T22:47:00+00:00',
        'version' => '7.2.0',
      ),
    ),
    'templates' => 
    array (
      'sg-headerpane' => '
<h1>
    <div class="record-cell">
        <span class="module-title">{{{section.title}}}</span>
    </div>
    <div class="btn-toolbar pull-right">
        <span class="list-headerpane">
            <select name="sections" id="find_patterns" class="select2 search" data-placeholder="Search styleguide&hellip;">
                <option></option>
            </select>
        </span>
    </div>
</h1>
',
    ),
  ),
  'docs-base-icons' => 
  array (
    'templates' => 
    array (
      'docs-base-icons' => '
<!-- Icons
================================================== -->
<script src="styleguide/content/charts/js/chart-utils.js"></script>

<section id="icons">
  <div class="page-header">
    <h1>Icons <small>without images.</small></h1>
  </div>
  <p>Font Awesome gives you scalable vector icons that can instantly be customized — size, color, drop shadow, and anything that can be done with the power of CSS. [<a href="http://fontawesome.io/"><i class="fa fa-book"></i> Font Awesome Docs</a>][<a href="https://github.com/FortAwesome/Font-Awesome" target="_blank">Font Awesome GitHub project.</a>]</p>
</section>

<section id="icons-new">
  <div class="row-fluid">
    <div class="span12">
      <h3 class="page-header">Icons Used in Sugar7</h3>
      <p>The following fonts are used in the Sugar7 application.</p>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span4">
      <ul class="the-icons">
<li><i class="fa fa-arrow-down"></i> fa-arrow-down</li>
<li><i class="fa fa-arrow-left"></i> fa-arrow-left</li>
<li><i class="fa fa-arrow-right"></i> fa-arrow-right</li>
<li><i class="fa fa-arrow-up"></i> fa-arrow-up</li>
<li><i class="fa fa-ban"></i> fa-ban</li>
<li><i class="fa fa-book"></i> fa-book</li>
<li><i class="fa fa-briefcase"></i> fa-briefcase</li>
<li><i class="fa fa-calendar"></i> fa-calendar</li>
<li><i class="fa fa-caret-down"></i> fa-caret-down</li>
<li><i class="fa fa-caret-left"></i> fa-caret-left</li>
<li><i class="fa fa-caret-right"></i> fa-caret-right</li>
<li><i class="fa fa-caret-up"></i> fa-caret-up</li>
<li><i class="fa fa-chevron-down"></i> fa-chevron-down</li>
<li><i class="fa fa-chevron-left"></i> fa-chevron-left</li>
<li><i class="fa fa-chevron-right"></i> fa-chevron-right</li>
<li><i class="fa fa-chevron-up"></i> fa-chevron-up</li>
<li><i class="fa fa-circle"></i> fa-circle</li>
<li><i class="fa fa-cog"></i> fa-cog</li>
<li><i class="fa fa-comment"></i> fa-comment</li>
<li><i class="fa fa-comments-o"></i> fa-comments-o</li>
<li><i class="fa fa-angle-double-down"></i> fa-angle-double-down</li>
<li><i class="fa fa-angle-double-left"></i> fa-angle-double-left</li>
<li><i class="fa fa-angle-double-right"></i> fa-angle-double-right</li>
<li><i class="fa fa-angle-double-up"></i> fa-angle-double-up</li>
<li><i class="fa fa-arrow-circle-o-down"></i> fa-arrow-circle-o-down</li>
      </ul>
    </div>
    <div class="span4">
      <ul class="the-icons">
<li><i class="fa fa-download"></i> fa-download</li>
<li><i class="fa fa-ellipsis-h"></i> fa-ellipsis-h</li>
<li><i class="fa fa-ellipsis-v"></i> fa-ellipsis-v</li>
<li><i class="fa fa-envelope"></i> fa-envelope</li>
<li><i class="fa fa-exclamation-circle"></i> fa-exclamation-circle</li>
<li><i class="fa fa-eye-slash"></i> fa-eye-slash</li>
<li><i class="fa fa-eye"></i> fa-eye</li>
<li><i class="fa fa-arrows-alt"></i> fa-arrows-alt</li>
<li><i class="fa fa-globe"></i> fa-globe</li>
<li><i class="fa fa-users"></i> fa-users</li>
<li><i class="fa fa-info-circle"></i> fa-info-circle</li>
<li><i class="fa fa-link"></i> fa-link</li>
<li><i class="fa fa-list-alt"></i> fa-list-alt</li>
<li><i class="fa fa-minus"></i> fa-minus</li>
<li><i class="fa fa-minus-circle"></i> fa-minus-circle</li>
<li><i class="fa fa-mobile"></i> fa-mobile</li>
<li><i class="fa fa-arrows"></i> fa-arrows</li>
<li><i class="fa fa-check"></i> fa-check</li>
<li><i class="fa fa-check-sign"></i> fa-check-sign</li>
<li><i class="fa fa-pencil"></i> fa-pencil</li>
<li><i class="fa fa-plus"></i> fa-plus</li>
<li><i class="fa fa-plus-circle"></i> fa-plus-circle</li>
<li><i class="fa fa-plus-square"></i> fa-plus-square</li>
<li><i class="fa fa-question-circle"></i> fa-question-circle</li>
<li><i class="fa fa-refresh"></i> fa-refresh</li>
      </ul>
    </div>
    <div class="span4">
      <ul class="the-icons">
<li><i class="fa fa-times"></i> fa-times</li>
<li><i class="fa fa-times-circle-o"></i> fa-times-circle-o</li>
<li><i class="fa fa-times-circle"></i> fa-times-circle</li>
<li><i class="fa fa-expand"></i> fa-expand</li>
<li><i class="fa fa-arrows-h"></i> fa-arrows-h</li>
<li><i class="fa fa-arrows-v"></i> fa-arrows-v</li>
<li><i class="fa fa-road"></i> fa-road</li>
<li><i class="fa fa-search"></i> fa-search</li>
<li><i class="fa fa-sign-out"></i> fa-sign-out</li>
<li><i class="fa fa-sitemap"></i> fa-sitemap</li>
<li><i class="fa fa-sort"></i> fa-sort</li>
<li><i class="fa fa-sort-down"></i> fa-sort-down</li>
<li><i class="fa fa-sort-up"></i> fa-sort-up</li>
<li><i class="fa fa-star"></i> fa-star</li>
<li><i class="fa fa-star-o"></i> fa-star-o</li>
<li><i class="fa fa-table"></i> fa-table</li>
<li><i class="fa fa-th"></i> fa-th</li>
<li><i class="fa fa-th-list"></i> fa-th-list</li>
<li><i class="fa fa-clock-o"></i> fa-clock-o</li>
<li><i class="fa fa-trash-o"></i> fa-trash-o</li>
<li><i class="fa fa-chain-broken"></i> fa-chain-broken</li>
<li><i class="fa fa-arrow-circle-o-up"></i> fa-arrow-circle-o-up</li>
<li><i class="fa fa-user"></i> fa-user</li>
<li><i class="fa fa-wrench"></i> fa-wrench</li>
      </ul>
    </div>
  </div>
</section>

<section id="icons-new">
  <div class="row-fluid">
    <div class="span12">
      <h3 class="page-header">All Other Icons</h3>
      <p>The following fonts are not used in the Sugar7 application.</p>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span4">
      <ul class="the-icons">
<li><i class="fa fa-adjust"></i> fa-adjust</li>
<li><i class="fa fa-adn"></i> fa-adn</li>
<li><i class="fa fa-align-center"></i> fa-align-center</li>
<li><i class="fa fa-align-justify"></i> fa-align-justify</li>
<li><i class="fa fa-align-left"></i> fa-align-left</li>
<li><i class="fa fa-align-right"></i> fa-align-right</li>
<li><i class="fa fa-ambulance"></i> fa-ambulance</li>
<li><i class="fa fa-anchor"></i> fa-anchor</li>
<li><i class="fa fa-android"></i> fa-android</li>
<li><i class="fa fa-angle-down"></i> fa-angle-down</li>
<li><i class="fa fa-angle-left"></i> fa-angle-left</li>
<li><i class="fa fa-angle-right"></i> fa-angle-right</li>
<li><i class="fa fa-angle-up"></i> fa-angle-up</li>
<li><i class="fa fa-apple"></i> fa-apple</li>
<li><i class="fa fa-archive"></i> fa-archive</li>
<li><i class="fa fa-arrow-circle-down"></i> fa-arrow-circle-down</li>
<li><i class="fa fa-arrow-circle-left"></i> fa-arrow-circle-left</li>
<li><i class="fa fa-arrow-circle-o-left"></i> fa-arrow-circle-o-left</li>
<li><i class="fa fa-arrow-circle-o-right"></i> fa-arrow-circle-o-right</li>
<li><i class="fa fa-arrow-circle-right"></i> fa-arrow-circle-right</li>
<li><i class="fa fa-arrow-circle-up"></i> fa-arrow-circle-up</li>
<li><i class="fa fa-asterisk"></i> fa-asterisk</li>
<li><i class="fa fa-backward"></i> fa-backward</li>
<li><i class="fa fa-bar-chart-o"></i> fa-bar-chart-o</li>
<li><i class="fa fa-barcode"></i> fa-barcode</li>
<li><i class="fa fa-bars"></i> fa-bars</li>
<li><i class="fa fa-beer"></i> fa-beer</li>
<li><i class="fa fa-bell"></i> fa-bell</li>
<li><i class="fa fa-bell-o"></i> fa-bell-o</li>
<li><i class="fa fa-bitbucket"></i> fa-bitbucket</li>
<li><i class="fa fa-bitbucket-square"></i> fa-bitbucket-square</li>
<li><i class="fa fa-bitcoin"></i> fa-bitcoin</li>
<li><i class="fa fa-bold"></i> fa-bold</li>
<li><i class="fa fa-bolt"></i> fa-bolt</li>
<li><i class="fa fa-bookmark"></i> fa-bookmark</li>
<li><i class="fa fa-bookmark-o"></i> fa-bookmark-o</li>
<li><i class="fa fa-btc"></i> fa-btc</li>
<li><i class="fa fa-bug"></i> fa-bug</li>
<li><i class="fa fa-building-o"></i> fa-building-o</li>
<li><i class="fa fa-bullhorn"></i> fa-bullhorn</li>
<li><i class="fa fa-bullseye"></i> fa-bullseye</li>
<li><i class="fa fa-calendar-o"></i> fa-calendar-o</li>
<li><i class="fa fa-camera"></i> fa-camera</li>
<li><i class="fa fa-camera-retro"></i> fa-camera-retro</li>
<li><i class="fa fa-caret-square-o-down"></i> fa-caret-square-o-down</li>
<li><i class="fa fa-caret-square-o-left"></i> fa-caret-square-o-left</li>
<li><i class="fa fa-caret-square-o-right"></i> fa-caret-square-o-right</li>
<li><i class="fa fa-caret-square-o-up"></i> fa-caret-square-o-up</li>
<li><i class="fa fa-certificate"></i> fa-certificate</li>
<li><i class="fa fa-chain"></i> fa-chain</li>
<li><i class="fa fa-check-circle"></i> fa-check-circle</li>
<li><i class="fa fa-check-circle-o"></i> fa-check-circle-o</li>
<li><i class="fa fa-check-square"></i> fa-check-square</li>
<li><i class="fa fa-check-square-o"></i> fa-check-square-o</li>
<li><i class="fa fa-chevron-circle-down"></i> fa-chevron-circle-down</li>
<li><i class="fa fa-chevron-circle-left"></i> fa-chevron-circle-left</li>
<li><i class="fa fa-chevron-circle-right"></i> fa-chevron-circle-right</li>
<li><i class="fa fa-chevron-circle-up"></i> fa-chevron-circle-up</li>
<li><i class="fa fa-circle-o"></i> fa-circle-o</li>
<li><i class="fa fa-clipboard"></i> fa-clipboard</li>
<li><i class="fa fa-cloud"></i> fa-cloud</li>
<li><i class="fa fa-cloud-download"></i> fa-cloud-download</li>
<li><i class="fa fa-cloud-upload"></i> fa-cloud-upload</li>
<li><i class="fa fa-cny"></i> fa-cny</li>
<li><i class="fa fa-code"></i> fa-code</li>
<li><i class="fa fa-code-fork"></i> fa-code-fork</li>
<li><i class="fa fa-coffee"></i> fa-coffee</li>
<li><i class="fa fa-cogs"></i> fa-cogs</li>
<li><i class="fa fa-columns"></i> fa-columns</li>
<li><i class="fa fa-comment-o"></i> fa-comment-o</li>
<li><i class="fa fa-comments"></i> fa-comments</li>
<li><i class="fa fa-compass"></i> fa-compass</li>
<li><i class="fa fa-compress"></i> fa-compress</li>
<li><i class="fa fa-copy"></i> fa-copy</li>
<li><i class="fa fa-credit-card"></i> fa-credit-card</li>
<li><i class="fa fa-crop"></i> fa-crop</li>
<li><i class="fa fa-crosshairs"></i> fa-crosshairs</li>
<li><i class="fa fa-css3"></i> fa-css3</li>
<li><i class="fa fa-cut"></i> fa-cut</li>
<li><i class="fa fa-cutlery"></i> fa-cutlery</li>
<li><i class="fa fa-dashboard"></i> fa-dashboard</li>
<li><i class="fa fa-dedent"></i> fa-dedent</li>
<li><i class="fa fa-desktop"></i> fa-desktop</li>
<li><i class="fa fa-dollar"></i> fa-dollar</li>
<li><i class="fa fa-dot-circle-o"></i> fa-dot-circle-o</li>
<li><i class="fa fa-dribbble"></i> fa-dribbble</li>
<li><i class="fa fa-dropbox"></i> fa-dropbox</li>
<li><i class="fa fa-edit"></i> fa-edit</li>
<li><i class="fa fa-eject"></i> fa-eject</li>
<li><i class="fa fa-envelope-o"></i> fa-envelope-o</li>
<li><i class="fa fa-eraser"></i> fa-eraser</li>
<li><i class="fa fa-eur"></i> fa-eur</li>
<li><i class="fa fa-euro"></i> fa-euro</li>
<li><i class="fa fa-exchange"></i> fa-exchange</li>
<li><i class="fa fa-exclamation"></i> fa-exclamation</li>
<li><i class="fa fa-exclamation-triangle"></i> fa-exclamation-triangle</li>
<li><i class="fa fa-external-link"></i> fa-external-link</li>
<li><i class="fa fa-external-link-square"></i> fa-external-link-square</li>
<li><i class="fa fa-facebook"></i> fa-facebook</li>
<li><i class="fa fa-facebook-square"></i> fa-facebook-square</li>
<li><i class="fa fa-fast-backward"></i> fa-fast-backward</li>
<li><i class="fa fa-fast-forward"></i> fa-fast-forward</li>
<li><i class="fa fa-female"></i> fa-female</li>
<li><i class="fa fa-fighter-jet"></i> fa-fighter-jet</li>
<li><i class="fa fa-file"></i> fa-file</li>
<li><i class="fa fa-file-o"></i> fa-file-o</li>
<li><i class="fa fa-file-text"></i> fa-file-text</li>
<li><i class="fa fa-file-text-o"></i> fa-file-text-o</li>
<li><i class="fa fa-files-o"></i> fa-files-o</li>
<li><i class="fa fa-film"></i> fa-film</li>
<li><i class="fa fa-filter"></i> fa-filter</li>
<li><i class="fa fa-fire"></i> fa-fire</li>
<li><i class="fa fa-fire-extinguisher"></i> fa-fire-extinguisher</li>
      </ul>
    </div>
    <div class="span4">
      <ul class="the-icons">
<li><i class="fa fa-flag"></i> fa-flag</li>
<li><i class="fa fa-flag-checkered"></i> fa-flag-checkered</li>
<li><i class="fa fa-flag-o"></i> fa-flag-o</li>
<li><i class="fa fa-flash"></i> fa-flash</li>
<li><i class="fa fa-flask"></i> fa-flask</li>
<li><i class="fa fa-flickr"></i> fa-flickr</li>
<li><i class="fa fa-floppy-o"></i> fa-floppy-o</li>
<li><i class="fa fa-folder"></i> fa-folder</li>
<li><i class="fa fa-folder-o"></i> fa-folder-o</li>
<li><i class="fa fa-folder-open"></i> fa-folder-open</li>
<li><i class="fa fa-folder-open-o"></i> fa-folder-open-o</li>
<li><i class="fa fa-font"></i> fa-font</li>
<li><i class="fa fa-forward"></i> fa-forward</li>
<li><i class="fa fa-foursquare"></i> fa-foursquare</li>
<li><i class="fa fa-frown-o"></i> fa-frown-o</li>
<li><i class="fa fa-gamepad"></i> fa-gamepad</li>
<li><i class="fa fa-gavel"></i> fa-gavel</li>
<li><i class="fa fa-gbp"></i> fa-gbp</li>
<li><i class="fa fa-gear"></i> fa-gear</li>
<li><i class="fa fa-gears"></i> fa-gears</li>
<li><i class="fa fa-gift"></i> fa-gift</li>
<li><i class="fa fa-github"></i> fa-github</li>
<li><i class="fa fa-github-alt"></i> fa-github-alt</li>
<li><i class="fa fa-github-square"></i> fa-github-square</li>
<li><i class="fa fa-gittip"></i> fa-gittip</li>
<li><i class="fa fa-glass"></i> fa-glass</li>
<li><i class="fa fa-google-plus"></i> fa-google-plus</li>
<li><i class="fa fa-google-plus-square"></i> fa-google-plus-square</li>
<li><i class="fa fa-group"></i> fa-group</li>
<li><i class="fa fa-h-square"></i> fa-h-square</li>
<li><i class="fa fa-hand-o-down"></i> fa-hand-o-down</li>
<li><i class="fa fa-hand-o-left"></i> fa-hand-o-left</li>
<li><i class="fa fa-hand-o-right"></i> fa-hand-o-right</li>
<li><i class="fa fa-hand-o-up"></i> fa-hand-o-up</li>
<li><i class="fa fa-hdd-o"></i> fa-hdd-o</li>
<li><i class="fa fa-headphones"></i> fa-headphones</li>
<li><i class="fa fa-heart"></i> fa-heart</li>
<li><i class="fa fa-heart-o"></i> fa-heart-o</li>
<li><i class="fa fa-home"></i> fa-home</li>
<li><i class="fa fa-hospital-o"></i> fa-hospital-o</li>
<li><i class="fa fa-html5"></i> fa-html5</li>
<li><i class="fa fa-inbox"></i> fa-inbox</li>
<li><i class="fa fa-indent"></i> fa-indent</li>
<li><i class="fa fa-info"></i> fa-info</li>
<li><i class="fa fa-inr"></i> fa-inr</li>
<li><i class="fa fa-instagram"></i> fa-instagram</li>
<li><i class="fa fa-italic"></i> fa-italic</li>
<li><i class="fa fa-jpy"></i> fa-jpy</li>
<li><i class="fa fa-key"></i> fa-key</li>
<li><i class="fa fa-keyboard-o"></i> fa-keyboard-o</li>
<li><i class="fa fa-krw"></i> fa-krw</li>
<li><i class="fa fa-laptop"></i> fa-laptop</li>
<li><i class="fa fa-leaf"></i> fa-leaf</li>
<li><i class="fa fa-legal"></i> fa-legal</li>
<li><i class="fa fa-lemon-o"></i> fa-lemon-o</li>
<li><i class="fa fa-level-down"></i> fa-level-down</li>
<li><i class="fa fa-level-up"></i> fa-level-up</li>
<li><i class="fa fa-lightbulb-o"></i> fa-lightbulb-o</li>
<li><i class="fa fa-linkedin"></i> fa-linkedin</li>
<li><i class="fa fa-linkedin-square"></i> fa-linkedin-square</li>
<li><i class="fa fa-linux"></i> fa-linux</li>
<li><i class="fa fa-list"></i> fa-list</li>
<li><i class="fa fa-list-ol"></i> fa-list-ol</li>
<li><i class="fa fa-list-ul"></i> fa-list-ul</li>
<li><i class="fa fa-location-arrow"></i> fa-location-arrow</li>
<li><i class="fa fa-lock"></i> fa-lock</li>
<li><i class="fa fa-long-arrow-down"></i> fa-long-arrow-down</li>
<li><i class="fa fa-long-arrow-left"></i> fa-long-arrow-left</li>
<li><i class="fa fa-long-arrow-right"></i> fa-long-arrow-right</li>
<li><i class="fa fa-long-arrow-up"></i> fa-long-arrow-up</li>
<li><i class="fa fa-magic"></i> fa-magic</li>
<li><i class="fa fa-magnet"></i> fa-magnet</li>
<li><i class="fa fa-mail-forward"></i> fa-mail-forward</li>
<li><i class="fa fa-mail-reply-all"></i> fa-mail-reply-all</li>
<li><i class="fa fa-mail-reply"></i> fa-mail-reply</li>
<li><i class="fa fa-male"></i> fa-male</li>
<li><i class="fa fa-map-marker"></i> fa-map-marker</li>
<li><i class="fa fa-maxcdn"></i> fa-maxcdn</li>
<li><i class="fa fa-medkit"></i> fa-medkit</li>
<li><i class="fa fa-meh-o"></i> fa-meh-o</li>
<li><i class="fa fa-microphone"></i> fa-microphone</li>
<li><i class="fa fa-microphone-slash"></i> fa-microphone-slash</li>
<li><i class="fa fa-minus-square"></i> fa-minus-square</li>
<li><i class="fa fa-minus-square-o"></i> fa-minus-square-o</li>
<li><i class="fa fa-mobile-phone"></i> fa-mobile-phone</li>
<li><i class="fa fa-money"></i> fa-money</li>
<li><i class="fa fa-moon-o"></i> fa-moon-o</li>
<li><i class="fa fa-music"></i> fa-music</li>
<li><i class="fa fa-outdent"></i> fa-outdent</li>
<li><i class="fa fa-pagelines"></i> fa-pagelines</li>
<li><i class="fa fa-paperclip"></i> fa-paperclip</li>
<li><i class="fa fa-paste"></i> fa-paste</li>
<li><i class="fa fa-pause"></i> fa-pause</li>
<li><i class="fa fa-pencil-square"></i> fa-pencil-square</li>
<li><i class="fa fa-pencil-square-o"></i> fa-pencil-square-o</li>
<li><i class="fa fa-phone"></i> fa-phone</li>
<li><i class="fa fa-phone-square"></i> fa-phone-square</li>
<li><i class="fa fa-picture-o"></i> fa-picture-o</li>
<li><i class="fa fa-pinterest"></i> fa-pinterest</li>
<li><i class="fa fa-pinterest-square"></i> fa-pinterest-square</li>
<li><i class="fa fa-plane"></i> fa-plane</li>
<li><i class="fa fa-play"></i> fa-play</li>
<li><i class="fa fa-play-circle"></i> fa-play-circle</li>
<li><i class="fa fa-play-circle-o"></i> fa-play-circle-o</li>
<li><i class="fa fa-plus-square-o"></i> fa-plus-square-o</li>
<li><i class="fa fa-power-off"></i> fa-power-off</li>
<li><i class="fa fa-print"></i> fa-print</li>
<li><i class="fa fa-puzzle-piece"></i> fa-puzzle-piece</li>
<li><i class="fa fa-qrcode"></i> fa-qrcode</li>
<li><i class="fa fa-question"></i> fa-question</li>
<li><i class="fa fa-quote-left"></i> fa-quote-left</li>
<li><i class="fa fa-quote-right"></i> fa-quote-right</li>
<li><i class="fa fa-random"></i> fa-random</li>
      </ul>
    </div>
    <div class="span4">
      <ul class="the-icons">
<li><i class="fa fa-renren"></i> fa-renren</li>
<li><i class="fa fa-repeat"></i> fa-repeat</li>
<li><i class="fa fa-reply"></i> fa-reply</li>
<li><i class="fa fa-reply-all"></i> fa-reply-all</li>
<li><i class="fa fa-retweet"></i> fa-retweet</li>
<li><i class="fa fa-rmb"></i> fa-rmb</li>
<li><i class="fa fa-rocket"></i> fa-rocket</li>
<li><i class="fa fa-rotate-left"></i> fa-rotate-left</li>
<li><i class="fa fa-rotate-right"></i> fa-rotate-right</li>
<li><i class="fa fa-rouble"></i> fa-rouble</li>
<li><i class="fa fa-rss"></i> fa-rss</li>
<li><i class="fa fa-rss-square"></i> fa-rss-square</li>
<li><i class="fa fa-rub"></i> fa-rub</li>
<li><i class="fa fa-ruble"></i> fa-ruble</li>
<li><i class="fa fa-rupee"></i> fa-rupee</li>
<li><i class="fa fa-save"></i> fa-save</li>
<li><i class="fa fa-scissors"></i> fa-scissors</li>
<li><i class="fa fa-search-minus"></i> fa-search-minus</li>
<li><i class="fa fa-search-plus"></i> fa-search-plus</li>
<li><i class="fa fa-share"></i> fa-share</li>
<li><i class="fa fa-share-square"></i> fa-share-square</li>
<li><i class="fa fa-share-square-o"></i> fa-share-square-o</li>
<li><i class="fa fa-shield"></i> fa-shield</li>
<li><i class="fa fa-shopping-cart"></i> fa-shopping-cart</li>
<li><i class="fa fa-sign-in"></i> fa-sign-in</li>
<li><i class="fa fa-signal"></i> fa-signal</li>
<li><i class="fa fa-skype"></i> fa-skype</li>
<li><i class="fa fa-smile-o"></i> fa-smile-o</li>
<li><i class="fa fa-sort-alpha-asc"></i> fa-sort-alpha-asc</li>
<li><i class="fa fa-sort-alpha-desc"></i> fa-sort-alpha-desc</li>
<li><i class="fa fa-sort-amount-asc"></i> fa-sort-amount-asc</li>
<li><i class="fa fa-sort-amount-desc"></i> fa-sort-amount-desc</li>
<li><i class="fa fa-sort-asc"></i> fa-sort-asc</li>
<li><i class="fa fa-sort-desc"></i> fa-sort-desc</li>
<li><i class="fa fa-sort-down"></i> fa-sort-down</li>
<li><i class="fa fa-sort-numeric-asc"></i> fa-sort-numeric-asc</li>
<li><i class="fa fa-sort-numeric-desc"></i> fa-sort-numeric-desc</li>
<li><i class="fa fa-sort-up"></i> fa-sort-up</li>
<li><i class="fa fa-spinner"></i> fa-spinner</li>
<li><i class="fa fa-square"></i> fa-square</li>
<li><i class="fa fa-square-o"></i> fa-square-o</li>
<li><i class="fa fa-stack-exchange"></i> fa-stack-exchange</li>
<li><i class="fa fa-stack-overflow"></i> fa-stack-overflow</li>
<li><i class="fa fa-star-half"></i> fa-star-half</li>
<li><i class="fa fa-star-half-empty"></i> fa-star-half-empty</li>
<li><i class="fa fa-star-half-full"></i> fa-star-half-full</li>
<li><i class="fa fa-star-half-o"></i> fa-star-half-o</li>
<li><i class="fa fa-step-backward"></i> fa-step-backward</li>
<li><i class="fa fa-step-forward"></i> fa-step-forward</li>
<li><i class="fa fa-stethoscope"></i> fa-stethoscope</li>
<li><i class="fa fa-stop"></i> fa-stop</li>
<li><i class="fa fa-strikethrough"></i> fa-strikethrough</li>
<li><i class="fa fa-subscript"></i> fa-subscript</li>
<li><i class="fa fa-suitcase"></i> fa-suitcase</li>
<li><i class="fa fa-sun-o"></i> fa-sun-o</li>
<li><i class="fa fa-superscript"></i> fa-superscript</li>
<li><i class="fa fa-tablet"></i> fa-tablet</li>
<li><i class="fa fa-tachometer"></i> fa-tachometer</li>
<li><i class="fa fa-tag"></i> fa-tag</li>
<li><i class="fa fa-tags"></i> fa-tags</li>
<li><i class="fa fa-tasks"></i> fa-tasks</li>
<li><i class="fa fa-terminal"></i> fa-terminal</li>
<li><i class="fa fa-text-height"></i> fa-text-height</li>
<li><i class="fa fa-text-width"></i> fa-text-width</li>
<li><i class="fa fa-th-large"></i> fa-th-large</li>
<li><i class="fa fa-thumb-tack"></i> fa-thumb-tack</li>
<li><i class="fa fa-thumbs-down"></i> fa-thumbs-down</li>
<li><i class="fa fa-thumbs-o-down"></i> fa-thumbs-o-down</li>
<li><i class="fa fa-thumbs-o-up"></i> fa-thumbs-o-up</li>
<li><i class="fa fa-thumbs-up"></i> fa-thumbs-up</li>
<li><i class="fa fa-ticket"></i> fa-ticket</li>
<li><i class="fa fa-tint"></i> fa-tint</li>
<li><i class="fa fa-toggle-down"></i> fa-toggle-down</li>
<li><i class="fa fa-toggle-left"></i> fa-toggle-left</li>
<li><i class="fa fa-toggle-right"></i> fa-toggle-right</li>
<li><i class="fa fa-toggle-up"></i> fa-toggle-up</li>
<li><i class="fa fa-trello"></i> fa-trello</li>
<li><i class="fa fa-trophy"></i> fa-trophy</li>
<li><i class="fa fa-truck"></i> fa-truck</li>
<li><i class="fa fa-try"></i> fa-try</li>
<li><i class="fa fa-tumblr"></i> fa-tumblr</li>
<li><i class="fa fa-tumblr-square"></i> fa-tumblr-square</li>
<li><i class="fa fa-turkish-lira"></i> fa-turkish-lira</li>
<li><i class="fa fa-twitter"></i> fa-twitter</li>
<li><i class="fa fa-twitter-square"></i> fa-twitter-square</li>
<li><i class="fa fa-umbrella"></i> fa-umbrella</li>
<li><i class="fa fa-underline"></i> fa-underline</li>
<li><i class="fa fa-undo"></i> fa-undo</li>
<li><i class="fa fa-unlink"></i> fa-unlink</li>
<li><i class="fa fa-unlock"></i> fa-unlock</li>
<li><i class="fa fa-unlock-alt"></i> fa-unlock-alt</li>
<li><i class="fa fa-unsorted"></i> fa-unsorted</li>
<li><i class="fa fa-upload"></i> fa-upload</li>
<li><i class="fa fa-usd"></i> fa-usd</li>
<li><i class="fa fa-user-md"></i> fa-user-md</li>
<li><i class="fa fa-video-camera"></i> fa-video-camera</li>
<li><i class="fa fa-vimeo-square"></i> fa-vimeo-square</li>
<li><i class="fa fa-vk"></i> fa-vk</li>
<li><i class="fa fa-volume-down"></i> fa-volume-down</li>
<li><i class="fa fa-volume-off"></i> fa-volume-off</li>
<li><i class="fa fa-volume-up"></i> fa-volume-up</li>
<li><i class="fa fa-warning"></i> fa-warning</li>
<li><i class="fa fa-weibo"></i> fa-weibo</li>
<li><i class="fa fa-wheelchair"></i> fa-wheelchair</li>
<li><i class="fa fa-windows"></i> fa-windows</li>
<li><i class="fa fa-won"></i> fa-won</li>
<li><i class="fa fa-xing"></i> fa-xing</li>
<li><i class="fa fa-xing-square"></i> fa-xing-square</li>
<li><i class="fa fa-yen"></i> fa-yen</li>
<li><i class="fa fa-youtube"></i> fa-youtube</li>
<li><i class="fa fa-youtube-play"></i> fa-youtube-play</li>
<li><i class="fa fa-youtube-square"></i> fa-youtube-square</li>
      </ul>
    </div>
  </div>
</section>

<section id="examples">
  <div class="row-fluid">
    <div class="span12">
      <h3 class="page-header">Examples</h3>
      <p>Many examples re-used from the Twitter Bootstrap documentation.</p>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span3">
      <div class="well well-transparent">
        <p>Use Font Awesome icons in:</p>
        <ul class="icons">
          <li><i class="fa fa-check"></i>Bulleted lists (like this one)</li>
          <li><i class="fa fa-check"></i>Buttons</li>
          <li><i class="fa fa-check"></i>Button groups</li>
          <li><i class="fa fa-check"></i>Navigation</li>
          <li><i class="fa fa-check"></i>Prepended form inputs</li>
          <li><i class="fa fa-check"></i>And many more with Custom CSS</li>
        </ul>
      </div>
    </div>
    <div class="span5">
      <p>
        <a class="btn"><i class="fa fa-repeat"></i> Reload</a>
        <a class="btn btn-success"><i class="fa fa-shopping-cart"></i> Checkout</a>
        <a class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
      </p>
      <p>
        <a class="btn btn-primary"><i class="fa fa-comment"></i> Comment</a>
        <a class="btn btn-small"><i class="fa fa-cog"></i> Settings</a>
        <a class="btn btn-small btn-info"><i class="fa fa-info-circle"></i> Info</a>
      </p>
      <div class="well" style="padding: 8px 0;">
        <ul class="nav nav-list">
          <li class="active"><a><i class="fa fa-home"></i> Home</a></li>
          <li><a><i class="fa fa-book"></i> Library</a></li>
          <li><a><i class="fa fa-pencil"></i> Applications</a></li>
          <li><a><i class="fa fa-cogs"></i> Settings</a></li>
        </ul>
      </div>
    </div>
    <div class="span4">
      <div class="btn-toolbar">
        <div class="btn-group">
          <a class="btn"><i class="fa fa-align-left"></i></a>
          <a class="btn"><i class="fa fa-align-center"></i></a>
          <a class="btn"><i class="fa fa-align-right"></i></a>
          <a class="btn"><i class="fa fa-align-justify"></i></a>
        </div>
        <div class="btn-group">
          <a class="btn btn-primary"><i class="fa fa-user"></i> User</a>
          <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu">
            <li><a><i class="fa fa-pencil"></i> Edit</a></li>
            <li><a><i class="fa fa-trash"></i> Delete</a></li>
            <li><a><i class="fa fa-ban-circle"></i> Ban</a></li>
            <li class="divider"></li>
            <li><a><i class="i"></i> Make admin</a></li>
          </ul>
        </div>
      </div>
      <form>
        <div class="control-group">
          <div class="controls">
            <div class="input-prepend">
              <span class="add-on"><i class="fa fa-envelope"></i></span>
              <input class="span2" id="inputIcon" type="text" placeholder="Email address">
            </div>
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <div class="input-prepend">
              <span class="add-on"><i class="fa fa-key"></i></span>
              <input class="span2" id="inputIcon2" type="text" placeholder="Password">
            </div>
          </div>
        </div>
      </form>
      <div>
        <span class="rating">
          <span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span>
        </span>
      </div>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span12">
      <h3 class="page-header">New Styles in 3.0</h3>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span3">
      <i class="fa fa-quote-left fa-4x pull-left fa-muted"></i>
      Use a few of the new styles together, and you\'ve got easy pull quotes or a great introductory article image.
      Or spinning icons for loading and refreshing content. Or fun big icons in multi-line buttons. Lots of new possibilities.
    </div>
    <div class="span5">
      <div class="well well-large well-transparent lead">
        <i class="fa fa-spinner fa-spin fa-2x pull-left"></i> Spinner icon when loading content...
      </div>
    </div>
    <div class="span4">
      <p>
        <a class="btn btn-large btn-danger"><i class="fa fa-flag fa-2x pull-left"></i>Font Awesome<br>Version 3.0</a>
      </p>
      <a class="btn btn-primary"><i class="fa fa-refresh fa-spin"></i> Synchronizing Content...</a>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span12">
      <h3 class="page-header">Example HTML</h3>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span12">
      <h4>Inline Icons</h4>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span3">
      <p>Place Font Awesome icons just about anywhere with the <code>&lt;i&gt;</code> tag.</p>
    </div>
    <div class="span5">
      <div class="well well-transparent">
        <div style="font-size: 24px; line-height: 1.5em;">
          <i class="fa fa-camera-retro"></i> fa-camera-retro
        </div>
      </div>
    </div>
    <div class="span4">
      <pre class="prettyprint linenums">
      &lt;i class="fa fa-camera-retro"&gt;&lt;/i&gt; fa-camera-retro
      </pre>
      <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> Icon classes are echoed via CSS :before.
      </div>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span12">
      <h4>Larger Icons</h4>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span3">
      <p>
        To increase the size of icons relative to its container, use <code>fa-lg</code>, <code>fa-2x</code>,
        <code>fa-3x</code>, or <code>fa-4x</code>.
      </p>
      <p>
        Increase the icon size by using the <code>fa-large</code> (33% increase), <code>fa-2x</code>,
        <code>fa-3x</code>, or <code>fa-4x</code> classes.
      </p>
    </div>
    <div class="span5">
      <div class="well well-transparent">
        <div style="font-size: 24px; line-height: 1.5em;">
          <p><i class="fa fa-camera-retro fa-lg"></i> fa-camera-retro</p>
          <p><i class="fa fa-camera-retro fa-2x"></i> fa-camera-retro</p>
          <p><i class="fa fa-camera-retro fa-3x"></i> fa-camera-retro</p>
          <p><i class="fa fa-camera-retro fa-4x"></i> fa-camera-retro</p>
        </div>
      </div>
    </div>
    <div class="span4">
      <pre class="prettyprint linenums">
      &lt;p&gt;&lt;i class=&quot;fa-camera-retro fa-large&quot;&gt;&lt;/i&gt; fa-camera-retro&lt;/p&gt;
      &lt;p&gt;&lt;i class=&quot;fa-camera-retro fa-2x&quot;&gt;&lt;/i&gt; fa-camera-retro&lt;/p&gt;
      &lt;p&gt;&lt;i class=&quot;fa-camera-retro fa-3x&quot;&gt;&lt;/i&gt; fa-camera-retro&lt;/p&gt;
      &lt;p&gt;&lt;i class=&quot;fa-camera-retro fa-4x&quot;&gt;&lt;/i&gt; fa-camera-retro&lt;/p&gt;
      </pre>
      <div class="alert alert-info">
        <i class="fa fa-info-sign"></i> If your icons are getting chopped off on top and bottom, make sure you have
        sufficient line-height.
      </div>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span12">
      <h4>Animated Spinner</h4>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span3">
      <p>
        Use the <code>fa-spin</code> class to get any icon to rotate. Works best with <code>fa-spinner</code> and
        <code>fa-refresh</code>.
      </p>
    </div>
    <div class="span5">
      <div class="well well-large well-transparent lead">
        <i class="fa fa-spinner fa-spin"></i> Spinner icon when loading content...
      </div>
    </div>
    <div class="span4">
      <pre class="prettyprint linenums">
      &lt;i class=&quot;fa-spinner fa-spin&quot;&gt;&lt;/i&gt; Spinner icon when loading content...
      </pre>
      <p class="alert alert-info">
        <i class="fa fa-info-sign"></i> CSS3 animations aren\'t supported in IE7 - IE9.
      </p>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span12">
      <h4>Chart Icons</h4>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span3">
      <p>
        The Sugar chart types have icons created in svg. The svg code is available in the <code>/assets/js/chart-utils.js</code> page. SVG images can be scaled by setting their height and width.
      </p>
    </div>
    <div class="span5">
      <div class="well well-large well-transparent chart-icon-container">
        <b>Donut</b>
        <span class="chart-icon" data-chart-type="donut"></span>
        <b>Funnel</b>
        <span class="chart-icon" data-chart-type="funnel"></span>
        <b>Horizontal</b>
        <span class="chart-icon" data-chart-type="horizontal"></span>
        <b>Line</b>
        <span class="chart-icon" data-chart-type="line"></span>
      </div>
      <div class="well well-large well-transparent chart-icon-container">
        <b>Pareto</b>
        <span class="chart-icon" data-chart-type="pareto"></span>
        <b>Pie</b>
        <span class="chart-icon" data-chart-type="pie"></span>
        <b>Stack</b>
        <span class="chart-icon" data-chart-type="stack"></span>
        <b>Vertical</b>
        <span class="chart-icon" data-chart-type="vertical"></span>
      </div>
    </div>
    <div class="span4">
      <pre class="prettyprint linenums">
      &lt;script&gt;
        var myChartSvg = svgChartIcon(\'funnel\');
      &lt;/script&gt;
      </pre>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <h4>Filetype Thumbnails</h4>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span3">
      <p>
        File type thumbnails are created by inserting a <code>span</code> tag with a classname of <code>.filetype-thumbnail</code> and adding a data-filetype property that is set to the file extension. If the file extension is one of "PDF,PNG,TXT,JPG,GIF,PPT,DOC,XLS" then it will have a colored background, else it will be grey. The last step is to insert the thumbmail SVG into the span.
      </p>
    </div>
    <div class="span5 filetype-thumbnails">
      <span class="filetype-thumbnail" data-filetype="PDF"></span>
      <span class="filetype-thumbnail" data-filetype="DOC"></span>
      <span class="filetype-thumbnail" data-filetype="PPT"></span>
      <span class="filetype-thumbnail" data-filetype="XLS"></span>
      <span class="filetype-thumbnail" data-filetype="PNG"></span>
      <span class="filetype-thumbnail" data-filetype="JPG"></span>
      <span class="filetype-thumbnail" data-filetype="GIF"></span>
      <span class="filetype-thumbnail" data-filetype="TXT"></span>
      <span class="filetype-thumbnail" data-filetype="XYZ"></span>
    </div>
    <div class="span4">
      <pre class="prettyprint linenums">
      &lt;script&gt;
      $(\'.filetype-thumbnail\').each(function(){
        $(this).html( \'&lt;svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" version="1.1" width="28" height="33" id="filetype-svg2"&gt;&lt;g id="layer1"&gt;&lt;path d="m 1,1 19,0 7,7 0,24 -26,0 z" id="rect2985" style="fill:#ececec;stroke:#000000;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:4" /&gt;&lt;path d="m 20,1 0,7 7,0 z" style="fill:#cccccc;stroke:#000000;stroke-width:1px;stroke-linecap:square;stroke-linejoin:round;" /&gt;&lt;/g&gt;&lt;/svg&gt;\' );
      });
      &lt;/script&gt;
      </pre>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <h4>The Sugar Cube</h4>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span3 offset3" style="padding:20px 0">
        <span class="sugar-cube"></span>
    </div>
    <div class="span3" style="background-color: #ddd;padding:20px 25px">
        <span class="sugar-cube sc-white"></span>
    </div>
    <div class="span3" style="padding:40px 0">
        <span class="sugar-cube sc-small fa-spin"></span>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span9 offset3">
        <span class="sugar-cube sc-large"></span>
    </div>
  </div>

</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // base icons
    _renderHtml: function () {
        this._super(\'_renderHtml\');

        this.$(\'.chart-icon\').each(function(){
            var svg = svgChartIcon($(this).data(\'chart-type\'));
            $(this).html(svg);
        });

        this.$(\'.filetype-thumbnail\').each(function(){
            $(this).html( \'<svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" version="1.1" width="28" height="33"><g><path class="ft-ribbon" d="M 0,15 0,29 3,29 3,13 z" /><path d="M 3,1 20.5,1 27,8 27,32 3,32 z" style="fill:#ececec;stroke:#b3b3b3;stroke-width:1;stroke-linecap:butt;" /><path d="m 20,1 0,7 7,0 z" style="fill:#b3b3b3;stroke-width:0" /></g></svg>\' );
        });

        this.$(\'.sugar-cube\').each(function(){
            var svg = svgChartIcon(\'sugar-cube\');
            $(this).html(svg);
        });
    }
})
',
    ),
  ),
  'docs-base-theme' => 
  array (
    'templates' => 
    array (
      'docs-base-theme' => '
<section id="edit-documentation">
  <div class="page-header">
    <h1>Custom Theme Variables <small>Instructions for modifying theme colors.</small></h1>
  </div>

  <h2>Themeable Colors</h2>
  <div class="row-fluid">
    <div class="span12">
      <p>There are three colors in a basic theme that can be customized:</p>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Variable</th>
        <th>Usage</th>
        <th>Example</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <code>@BorderColor</code>
        </td>
        <td>
          Accent border under top navigation menu.
        </td>
        <td class="swatch-col"><span class="swatch BorderColor"></span></td>
      </tr>
      <tr>
        <td>
          <code>@NavigationBar</code>
        </td>
        <td>
          Background color of top navigation menu.
        </td>
        <td class="swatch-col"><span class="swatch NavigationBar"></span></td>
      </tr>
      <tr>
        <td>
          <code>@PrimaryButton</code>
        </td>
        <td>
          Background color of primary action buttons like "Save" and "Create".
        </td>
        <td class="swatch-col"><span class="swatch PrimaryButton"></span></td>
      </tr>
    </tbody>
  </table>
    </div>
  </div>

    <h2>Create your own theme</h2>

    <div class="row-fluid">
        <div class="span5">
            <p>To override the default theme colors, a new variables.php file will need to be created.</p>

            <p>Copy the <code>/sugarcrm/styleguide/themes/clients/base/default/variables.php</code> to <code>/sugarcrm/custom/themes/clients/base/default/variables.php</code>
                and edit the following three HEX color values.</p>

            <p>Anytime you make a change, go to <code>Administration > Repair > Quick Repair and Rebuild</code> in order
                to rebuild css files.</p>
        </div>
        <div class="span7">
<pre class="prettyprint linenums">
\'BorderColor\' => \'#1977cb\',
\'NavigationBar\' => \'#d4742f\',
\'PrimaryButton\' => \'#f54d27\',
</pre>
        </div>
    </div>

    <h2>Add your own CSS</h2>

    <div class="row-fluid">
        <div class="span5">
            <p>The application allows you to write custom CSS and have it loaded automatically.</p>

            <p>You need to create a custom.less file in <code>/sugarcrm/custom/themes/custom.less</code>.
                Then you are free to use any bootstrap variables, as well as the 3 themeable variables.
                However, you can define your own variables but it is not the right place to override existing variables.</p>

            <p>Anytime you make a change, go to <code>Administration > Repair > Quick Repair and Rebuild</code> in order
                to rebuild css files.</p>
        </div>
        <div class="span7">
  <pre class="prettyprint linenums">
  //You can import any less file you want and define your own file structure
  //@import \'anyotherfile.less

  @myCustomBgColor: lighten(@NavigationBar,10%); //variable defined on a custom variable.

  .myCustomClass {
      color: @linkColor; //bootstrap variable
      background-color: @myCustomBgColor;
  }
  </pre>
        </div>
    </div>

    <h2>Revert customizations</h2>

    <div class="row-fluid">
        <p>If you are not satisfied by your customizations, just remove <code>/sugarcrm/custom/themes/custom.less</code>.
        </p>

        <p>If you want to delete your custom theme, remove <code>/sugarcrm/custom/themes/clients/base/default/variables.php</code>
            and go to <code>Administration > Repair > Quick Repair and Rebuild</code> in order to rebuild css
            files.</p>
    </div>

</section>

',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\'
})
',
    ),
  ),
  'docs-layouts-list' => 
  array (
    'templates' => 
    array (
      'docs-layouts-list' => '
<!-- Tables
================================================== -->
<section id="tables">
  <div class="page-header">
    <h1>List Tables <small>For, you guessed it, tabular data</small></h1>
  </div>

  <div class="row-fluid">
    <div class="span3 columns">
      <h3>About data tables</h3>
      <p>Sugar7 uses custom code to create dynamic data tables.</p>
      <p>The LESS file for styling data tables can be found at:<br>
        /sugarcrm/styleguide/less/sugar-specific/datatables.less.</p>
    </div>
    <div class="span9 columns">


  <h2>List Layout</h2>
  <p>The layout for a <a href="#Styleguide/view/list">standard list view</a> containing all basic field types.</p>

  <h2>Table options</h2>
  <table class="table table-bordered table-striped">
  <thead>
      <tr>
        <th>Name</th>
        <th>Class</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Default</td>
        <td class="muted">None</td>
        <td>No styles, just columns and rows</td>
      </tr>
      <tr>
        <td>Basic</td>
        <td>
          <code>.table</code>
        </td>
        <td>Only horizontal lines between rows</td>
      </tr>
      <tr>
        <td>Bordered</td>
        <td>
          <code>.table-bordered</code>
        </td>
        <td>Rounds corners and adds outter border</td>
      </tr>
      <tr>
        <td>Zebra-stripe</td>
        <td>
          <code>.table-striped</code>
        </td>
        <td>Adds light gray background color to odd rows (1, 3, 5, etc)</td>
      </tr>
      <tr>
        <td>Condensed</td>
        <td>
          <code>.table-condensed</code>
        </td>
        <td>Cuts vertical padding in half, from 8px to 4px, within all <code>td</code> and <code>th</code> elements</td>
      </tr>
    </tbody>
  </table>


  <h2>Example tables</h2>

  <h3>1. Default table styles</h3>
  <div class="row-fluid">
    <div class="span4">
      <p>Tables are automatically styled with only a few borders to ensure readability and maintain structure. With 2.0, the <code>.table</code> class is required.</p>
<pre class="prettyprint linenums">
&lt;table class="table"&gt;
  …
&lt;/table&gt;</pre>
    </div>
    <div class="span8">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Language</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Mark</td>
            <td>Otto</td>
            <td>CSS</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>Javascript</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Stu</td>
            <td>Dent</td>
            <td>HTML</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>


  <h3>2. Striped table</h3>
  <div class="row-fluid">
    <div class="span4">
      <p>Get a little fancy with your tables by adding zebra-striping&mdash;just add the <code>.table-striped</code> class.</p>
      <p class="muted"><strong>Note:</strong> Striped tables use the <code>:nth-child</code> CSS selector and is not available in IE7-IE8.</p>
<pre class="prettyprint linenums" style="margin-bottom: 18px;">
&lt;table class="table table-striped"&gt;
  …
&lt;/table&gt;</pre>
    </div>
    <div class="span8">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Language</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Mark</td>
            <td>Otto</td>
            <td>CSS</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>Javascript</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Stu</td>
            <td>Dent</td>
            <td>HTML</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>


  <h3>3. Bordered table</h3>
  <div class="row-fluid">
    <div class="span4">
      <p>Add borders around the entire table and rounded corners for aesthetic purposes.</p>
<pre class="prettyprint linenums">
&lt;table class="table table-bordered"&gt;
  …
&lt;/table&gt;</pre>
    </div>
    <div class="span8">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Language</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td colspan="2">Mark Otto</td>
            <td>CSS</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jacob</td>
            <td>Thornton</td>
            <td rowspan="2">Javascript</td>
          </tr>
          </tr>
            <td>3</td>
            <td>Stu</td>
            <td>Dent</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Brosef</td>
            <td>Stalin</td>
            <td>HTML</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>


  <h3>4. Condensed table</h3>
  <div class="row-fluid">
    <div class="span4">
      <p>Make your tables more compact by adding the <code>.table-condensed</code> class to cut table cell padding in half (from 8px to 4px).</p>
<pre class="prettyprint linenums" style="margin-bottom: 18px;">
&lt;table class="table table-condensed"&gt;
  …
&lt;/table&gt;</pre>
    </div>
    <div class="span8">
      <table class="table table-condensed">
        <thead>
          <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Language</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Mark</td>
            <td>Otto</td>
            <td>CSS</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>Javascript</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Stu</td>
            <td>Dent</td>
            <td>HTML</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>



  <h3>5. Combine them all!</h3>
  <div class="row-fluid">
    <div class="span4">
      <p>Feel free to combine any of the table classes to achieve different looks by utilizing any of the available classes.</p>
<pre class="prettyprint linenums" style="margin-bottom: 18px;">
&lt;table class="table table-striped table-bordered table-condensed"&gt;
  ...
&lt;/table&gt;</pre>
    </div>
    <div class="span8">
      <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Language</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Mark</td>
            <td>Otto</td>
            <td>CSS</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>Javascript</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Stu</td>
            <td>Dent</td>
            <td>HTML</td>
          </tr>
          <tr>
            <td>4</td>
            <td>Brosef</td>
            <td>Stalin</td>
            <td>HTML</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <h2>Table column widths</h2>
  <table class="table table-bordered table-striped">
  <thead>
      <tr>
        <th>Name</th>
        <th>Class</th>
        <th>Width</th>
        <th>Example</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>xxsmall</td>
        <td><code>.cell-xxsmall</code></td>
        <td>21px</td>
        <td><div class="cell-swatch cell-xxsmall"><span>Ex.</span></div>
      </tr>
      <tr>
        <td>xsmall</td>
        <td><code>.cell-xsmall</code></td>
        <td>42px</td>
        <td><div class="cell-swatch cell-xsmall"><span>Exam</span></div>
      </tr>
      <tr>
        <td>small</td>
        <td><code>.cell-small</code></td>
        <td>68px</td>
        <td><div class="cell-swatch cell-small"><span>Example</span></div>
      </tr>
      <tr>
        <td>medium</td>
        <td><code>.cell-medium</code></td>
        <td>110px</td>
        <td><div class="cell-swatch cell-medium"><span>Example</span></div>
      </tr>
      <tr>
        <td>large</td>
        <td><code>.cell-large</code></td>
        <td>178px</td>
        <td><div class="cell-swatch cell-large"><span>Example</span></div>
      </tr>
      <tr>
        <td>xlarge</td>
        <td><code>.cell-xlarge</code></td>
        <td>288px</td>
        <td><div class="cell-swatch cell-xlarge"><span>Example</span></div>
      </tr>
      <tr>
        <td>xxlarge</td>
        <td><code>.cell-xxlarge</code></td>
        <td>466px</td>
        <td><div class="cell-swatch cell-xxlarge"><span>Example</span></div>
      </tr>
    </table>
</div>
</div>
</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\'
})
',
    ),
  ),
  'docs-dashboards-intel' => 
  array (
    'templates' => 
    array (
      'docs-dashboards-intel' => '
<section id="dashboards_intel">

    <div class="page-header">
        <h2>Intelligence Pane <small>Layout and patterns</small></h2>
    </div>

    <div class="row-fluid">

        <div class="span2">
            <h3>Element Description</h3>
            <h4>Header</h4>
            <p>layout n stuff</p>
        </div> <!-- end col1-->
        <div class="span4">

            <h3>Basic layout and classes</h3>
            <h4>side side-bar-content, side-pane active, dashboard-pane, dashboard, preview-headerbar, headerpane</h4>
<pre class="prettyprint linenums">
&lt;div class="side sidebar-content span4"&gt;
    &lt;div class="side-pane active"&gt;
    &lt;/div&gt;
    &lt;div class="dashboard-pane"&gt;
            &lt;div class="preview-headerbar"&gt;
</pre>

        </div> <!-- end col 2-->
        <!--<div class="span6">-->
            <!--<h3>My Dashboard</h3>-->
            <!--<p>Picture stuff goes here??!</p>-->
        <!--</div> &lt;!&ndash;end of col3&ndash;&gt;-->
    </div> <!-- end row1 -->
    <!--<div class="row-fluid">-->
        <!--<div class="span2">-->
            <!--<h4>Content</h4>-->
            <!--<p>See Dashlets</p>-->
        <!--</div> &lt;!&ndash;end of col1&ndash;&gt;-->
        <!--<div class="span4">-->
            <!--<h4>Name of Class</h4>-->
        <!---->
        <!--</div> &lt;!&ndash;end of col2&ndash;&gt;-->
        <!--<div class="span6">-->
            <!--<h3>My Dashboard</h3>-->
            <!--<p>Picture stuff goes here??!</p>-->
        <!--</div> &lt;!&ndash;end of col3&ndash;&gt;-->
    <!--</div> &lt;!&ndash; end of row2&ndash;&gt;-->

</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // dashboard intel
    _renderHtml: function () {
        var self = this;
        this._super(\'_renderHtml\');

        this.$(\'.dashlet-example\').on(\'click.styleguide\', function(){
            var dashlet = $(this).data(\'dashlet\'),
                metadata = app.metadata.getView(\'Home\', dashlet).dashlets[0];
            metadata.type = dashlet;
            metadata.component = dashlet;
            self.layout.previewDashlet(metadata);
        });
    },

    _dispose: function() {
        this.$(\'.dashlet-example\').off(\'click.styleguide\');
        this._super(\'_dispose\');
    }
})
',
    ),
  ),
  'docs-charts-horizontal' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // charts horizontal
    _renderHtml: function() {
        this._super(\'_renderHtml\');

        // Multibar Horizontal Chart
        this.chart1 = nv.models.multiBarChart()
              .vertical(false)
              .margin({top: 10, right: 10, bottom: 10, left: 10})
              .showValues(true)
              .showTitle(false)
              .tooltips(true)
              .stacked(true)
              .showControls(false)
              .direction(app.lang.direction)
              .tooltipContent(function(key, x, y, e, graph) {
                return \'<p>Outcome: <b>\' + key + \'</b></p>\' +
                       \'<p>Lead Source: <b>\' + x + \'</b></p>\' +
                       \'<p>Amount: <b>$\' + parseInt(y) + \'K</b></p>\';
                });
        this.chart1.yAxis
            .tickFormat(d3.format(\',.2f\'));
        nv.utils.windowResize(this.chart1.update);

        // Multibar Horizontal Chart with Baseline
        this.chart2 = nv.models.multiBarChart()
              .vertical(false)
              .margin({top: 10, right: 10, bottom: 10, left: 10})
              .showValues(true)
              .showTitle(false)
              .tooltips(true)
              .showControls(false)
              .stacked(false)
              .direction(app.lang.direction)
              .tooltipContent(function(key, x, y, e, graph) {
                return \'<p>Outcome: <b>\' + key + \'</b></p>\' +
                       \'<p>Lead Source: <b>\' + x + \'</b></p>\' +
                       \'<p>Amount: <b>$\' + parseInt(y) + \'K</b></p>\';
              });
        this.chart2.yAxis
            .tickFormat(d3.format(\',.2f\'));
        nv.utils.windowResize(this.chart2.update);

        this.loadData();
    },

    loadData: function(options) {
        // Multibar Horizontal Chart
        d3.json(\'styleguide/content/charts/data/multibar_data_opportunities.json\', _.bind(function(data) {
            d3.select(\'#horiz1 svg\')
                .datum(data)
              .transition().duration(500)
                .call(this.chart1);
        }, this));

        // Multibar Horizontal Chart with Baseline
        d3.json(\'styleguide/content/charts/data/multibar_data_negative.json\', _.bind(function(data) {
            d3.select(\'#horiz2 svg\')
                .datum(data)
              .transition().duration(500)
                .call(this.chart2);
        }, this));

        //this._super(\'loadData\', [options]);
    }
})
',
    ),
    'templates' => 
    array (
      'docs-charts-horizontal' => '
<section id="horizontal-bar">
  <div class="page-header">
    <h2>Horizontal Bar <small>used for comparing many values in a single series</small></h2>
  </div>
  <div class="row-fluid">
    <div class="span6">
      <h3>All Opportunities By Lead Source</h3>
      <p>A horizontal bar chart with stacked data. [<a href="styleguide/content/charts/multiBarChart.html?orientation=horizontal" target="_blank">Full Screen</a> | <a href="styleguide/content/charts/multiBarChart_colors.html?orientation=horizontal" target="_blank">Color Options</a>]</p>
      <div>
<div id="horiz1" class="nv-chart">
<svg></svg>
</div>
      </div>
    </div>
    <div class="span6">
      <h3>Short/Long Horizontal Bar</h3>
      <p>A horizontal bar chart relative to a baseline. [<a href="styleguide/content/charts/multiBarChart.html?orientation=horizontal&file=multibar_data_negative" target="_blank">Full Screen</a>]</p>
      <div>
<div id="horiz2" class="nv-chart">
<svg></svg>
</div>
      </div>
    </div>
  </div>
</section>
',
    ),
  ),
  'docs-forms-switch' => 
  array (
    'templates' => 
    array (
      'docs-forms-switch' => '
<script src="include/javascript/twitterbootstrap/bootstrap-switch.js"></script>

<!-- Switch
================================================== -->
<section id="slider">
    <div class="page-header">
        <h1>Switch <small>bootstrap-switch.js</small></h1>
    </div>
    <div class="row-fluid">
        <div class="span3 columns">
            <h3>About Bootstrap switch</h3>
            <p>Bootstrap switch is an unofficial bootstrap plugin that transforms checkboxes into a toggle switch.</p>
            <p>The bootstrap-switch.js plugin is included in the default build of SugarCRM.</p>
            <p><a href="http://www.larentis.eu/switch/">Documentation</a> from bootstrap-switch.js developer.</p>
        </div>
        <div class="span9 columns">
            <h2>Example</h2>
            <div class="well">
                <div class="switch switch-mini round-switch">
                    <input type="checkbox" id="switch_example1" checked>
                </div>
            </div>
            <hr>
            <h2>Using Bootstrap switch</h2>
            <p>Initiating a switch:</p>
<pre class="prettyprint linenums">
&lt;div class="switch switch-mini round-switch"&gt;
  &lt;input type="checkbox" checked /&gt;
&lt;/div&gt;
</pre>
            <h3>Options</h3>
            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <th>Name</th>
                    <th>Example</th>
                    <th>Description</th>
                </tr>
                <tr>
                    <td>animation</td>
                    <td>&lt;div class="switch" data-animated="false"&gt;</td>
                    <td>Disable animation</td>
                </tr>
                <tr>
                    <td>text</td>
                    <td>&lt;div class="switch" data-on-label="SI" data-off-label="NO"&gt;</td>
                    <td>replaces default text</td>
                </tr>
                <tr>
                    <td>HTML text</td>
                    <td>&lt;div class="switch" data-on-label="&lt;i class=\'fa fa-check fa-white\'>&lt;/i&gt;" data-off-label="&lt;i class=\'fa fa-times\'&gt;&lt;/i&gt;"&gt;</td>
                    <td>replaces default text with HTML</td>
                </tr>
                </tbody>
            </table>
            <h3>Event Handler</h3>
            <div class="well">
                <div id="mySwitch" class="switch switch-mini round-switch">
                    <input type="checkbox" id="switch_example2" checked>
                </div>
            </div>
<pre class="prettyprint linenums">
$(\'#mySwitch\').on(\'switch-change\', function (e, data) {
    var $el = $(data.el)
    , value = data.value;
});
</pre>
        </div>
    </div>
</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // forms switch
    _renderHtml: function () {
        this._super(\'_renderHtml\');

        this.$(\'#mySwitch\').on(\'switch-change\', function (e, data) {
            var $el = $(data.el),
                value = data.value;
        });
    },

    _dispose: function() {
        this.$(\'#mySwitch\').off(\'switch-change\');

        this._super(\'_dispose\');
    }
})
',
    ),
  ),
  'docs-forms-layouts' => 
  array (
    'templates' => 
    array (
      'docs-forms-layouts' => '
<!-- Form layouts
================================================== -->
<section id="form-layouts">
  <div class="page-header">
    <h1>Form Layouts <small>custom layouts of field components</small></h1>
  </div>

  <h2 id="dFE3fA">Address</h2>

  <div class="row-fluid">
    <div class="span6 record-cell" data-type="fieldset" data-name="fieldset_address">
      <div class="record-label" data-name="">Billing Address</div>
      <span class="normal index8" data-fieldname="fieldset_address" data-index="8" data-tour="tour-Accounts-fieldset_address">
        <span sfuuid="412">
          <span sfuuid="413" class="address_street">
            <div class="ellipsis_inline" >
              111 Silicon Valley Road
            </div>
          </span>
          <span sfuuid="414" class="address_city">
            <div class="ellipsis_inline" >
              St. Petersburg
            </div>
          </span>
          <span sfuuid="415" class="address_state">
            <div class="ellipsis_inline" >
              CA
            </div>
          </span>
          <span sfuuid="416" class="address_zip">
            <div class="ellipsis_inline" >
              30373
            </div>
          </span>
          <span sfuuid="417" class="address_country">
            <div class="ellipsis_inline" >
              USA
            </div>
          </span>
        </span>
      </span>
      <span class="record-edit-link-wrapper" data-name="fieldset_address">
        <a class="record-edit-link btn btn-invisible" data-type="fieldset" data-name="fieldset_address"><i class="fa fa-pencil"></i></a>
      </span>
    </div>
  </div>

  <hr>
  <h2>Input fields inheriting width of the parent container</h2>

  <form class="form-horizontal clearfix">
    <fieldset class="card2 span6">

      <div class="row-fluid control-group">
        <div class="control-label span3">
          <label for="input01">Field:</label>
        </div>
        <div class="controls span9 controls-four btn-fit">
          <input type="text" id="input01" class="inherit-width">
          <a href="" class="btn fourth" rel="tooltip" title="Primary"><i class="fa fa-star"></i></a>
          <a href="" class="btn third" rel="tooltip" title="Add another"><i class="fa fa-plus"></i></a>
          <a href="" class="btn second" rel="tooltip" title="Primary"><i class="fa fa-minus"></i></a>
          <a href="" class="btn first" rel="tooltip" title="Add another"><i class="fa fa-star"></i></a>
        </div>
      </div>

      <div class="row-fluid control-group">
        <div class="control-label span3">
          <label for="input01">Field:</label>
        </div>
        <div class="controls span9 controls-three btn-fit">
          <input type="text" id="input01" class="inherit-width">
          <a href="" class="btn third" rel="tooltip" title="Primary"><i class="fa fa-star"></i></a>
          <a href="" class="btn second" rel="tooltip" title="Add another"><i class="fa fa-plus"></i></a>
          <a href="" class="btn first" rel="tooltip" title="Primary"><i class="fa fa-star"></i></a>
        </div>
      </div>

      <div class="row-fluid control-group">
        <div class="control-label span3">
          <label for="input01">Field:</label>
        </div>
        <div class="controls span9 controls-two btn-fit">
          <input type="text" id="input01" class="inherit-width">
          <a href="" class="btn second" rel="tooltip" title="Primary"><i class="fa fa-star"></i></a>
          <a href="" class="btn first" rel="tooltip" title="Add another"><i class="fa fa-plus"></i></a>
        </div>
      </div>

      <div class="row-fluid control-group">
        <div class="control-label span3">
          <label for="input01">Field:</label>
        </div>
        <div class="controls span9 controls-one btn-fit">
          <input type="text" id="input01" class="inherit-width">
          <a href="" class="btn first" rel="tooltip" title="Primary"><i class="fa fa-star"></i></a>
        </div>
      </div>

      <div class="row-fluid control-group">
        <div class="control-label span3">
          <label for="input01">Field:</label>
        </div>
        <div class="controls span9">
          <input type="text" id="input01" class="inherit-width">
        </div>
      </div>

    </fieldset>
  </form>

  <form class="form-horizontal clearfix">
    <fieldset class="card2 span6">

      <div class="row-fluid control-group">
        <div class="control-label span3">
          <label for="input01">Field:</label>
        </div>
        <div class="controls span9 controls-four btn-group-fit">
          <input type="text" id="input01" class="inherit-width">
          <div class="btn-group">
            <a href="" class="btn" rel="tooltip" title="Primary"><i class="fa fa-star"></i></a>
            <a href="" class="btn" rel="tooltip" title="Add another"><i class="fa fa-plus"></i></a>
            <a href="" class="btn" rel="tooltip" title="Primary"><i class="fa fa-minus"></i></a>
            <a href="" class="btn" rel="tooltip" title="Add another"><i class="fa fa-star"></i></a>
          </div>
        </div>
      </div>

      <div class="row-fluid control-group">
        <div class="control-label span3">
          <label for="input01">Field:</label>
        </div>
        <div class="controls span9 controls-three btn-group-fit">
          <input type="text" id="input01" class="inherit-width">
          <div class="btn-group">
            <a href="" class="btn" rel="tooltip" title="Primary"><i class="fa fa-star"></i></a>
            <a href="" class="btn" rel="tooltip" title="Add another"><i class="fa fa-plus"></i></a>
            <a href="" class="btn" rel="tooltip" title="Primary"><i class="fa fa-star"></i></a>
          </div>
        </div>
      </div>

      <div class="row-fluid control-group">
        <div class="control-label span3">
          <label for="input01">Field:</label>
        </div>
        <div class="controls span9 controls-two btn-group-fit">
          <input type="text" id="input01" class="inherit-width">
          <div class="btn-group">
            <a href="" class="btn" rel="tooltip" title="Primary"><i class="fa fa-star"></i></a>
            <a href="" class="btn" rel="tooltip" title="Add another"><i class="fa fa-plus"></i></a>
          </div>
        </div>
      </div>

    </fieldset>
  </form>

  <hr>
  <h2>Card fields</h2>

  <div class="record row-fluid panel_body">
    <div class="span6 record-cell" data-type="type" data-name="name">
      <div class="record-label">Label</div>
      <span class="normal index5" >
        <span sfuuid="123451">
          <input type="text" name="name" value="111-222-3333" class="input-large">
          <p class="help-block"></p>
        </span>
      </span>
    </div>

    <div class="span6 record-cell error" data-type="type" data-name="name">
      <div class="record-label">Label</div>
      <span class="normal index5" >
        <span sfuuid="123451">
            <div class="input-append error">
                <input type="text" name="name" value="111-222-3333" class="input-large">
                <span class="error-tooltip  add-on local" rel="tooltip" data-original-title="Error: This field is required"><i class="fa fa-exclamation-circle"></i></span>
            </div>
        </span>
      </span>
    </div>
  </div>

  <hr>
  <h2>Card 2</h2>

  <form class="form-horizontal padded">
    <fieldset class="card2">
      <div class="row-fluid control-group">
        <div class="control-label span2">
          <label for="input01">Name:</label>
        </div>
        <div class="controls span10">
          <input type="text" id="input01" class="inherit-width">
        </div>
      </div>
      <div class="row-fluid control-group">
        <div class="span2 control-label">
          <label for="select01">Sales Stage:</label>
        </div>
        <div class="controls span10">
          <select id="select01" data-placeholder="Choose a Lead..." class="select2 inherit-width">
            <option value="pk" selected="selected">Proposal</option>
            <option value="pk">Closed Won</option>
            <option value="pk">Closed Lost</option>
          </select>
        </div>
      </div>
      <div class="row-fluid control-group">
        <div class="span2 control-label">
          <label for="select02">Account:</label>
        </div>
        <div class="controls span4">
          <select id="select02" data-placeholder="Choose a Lead..." class="select2 inherit-width">
            <option value="pk" selected="selected">Perkin Kleiners</option>
            <option value="pk">Underwater Mining Inc.</option>
            <option value="pk">Weyland</option>
          </select>
        </div>
      </div>
      <div class="row-fluid control-group">
        <div class="span2 control-label">
          <label for="input03">Amount:</label>
        </div>
        <div class="controls span4">
          <input type="text" id="input01" class="inherit-width">
        </div>
      </div>
    </fieldset>
  </form>

  <hr>

  <div class="modal hide in" style="display: block;position: relative;top: 0;left: 0;margin: 0; ">
    <div class="modal-header">
      <a class="close" data-dismiss="modal"><i class="fa fa-times"></i></a>
      <h3>Create Note or Add Attachment</h3>
    </div>
    <div class="modal-body">
      <div class="modal-content">
        <form class="form-horizontal" enctype="multipart/form-data" method="POST">
          <!-- Fix for styleguide -->
          <fieldset style="width: 100%">
            <div class="row-fluid control-group">
              <label class="span2">Subject</label>
              <div class="span10">
                <span sfuuid="311">
                  <input type="text" name="name" value="" class="input-large">
                  <p class="help-block"></p>
                </span>
              </div>
            </div>

            <div class="row-fluid control-group error">
              <label class="span2">Subject</label>
              <div class="span10">
                <div class="input-append">
                  <span sfuuid="311">
                      <div class="input-append error">
                          <input type="text" name="name" value="" class="input-large">
                          <span class="error-tooltip  add-on local" rel="tooltip" data-original-title="Error: This field is required"><i class="fa fa-exclamation-circle"></i></span>
                      </div>
                  </span>
                </div>
              </div>
            </div>
            <hr>

            <div class="row-fluid control-group">
              <label class="span2">Note</label>
              <div class="span10">
                <span sfuuid="312">
                  <textarea rows="5" cols="90" name="description" class="input-xlarge wide tleft"></textarea>
                  <p class="help-block"></p>
                </span>
              </div>
            </div>

            <div class="row-fluid control-group error">
              <label class="span2">Note</label>
              <div class="span10">
                <div class="input-append textarea">
                  <span sfuuid="312">
                      <div class="input-append error">
                          <textarea rows="5" cols="90" name="description" class="input-xlarge wide tleft"></textarea>
                          <span class="error-tooltip  add-on local" rel="tooltip" data-original-title="Error: This field is required"><i class="fa fa-exclamation-circle"></i></span>
                      </div>
                  </span>
                </div>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
          <span sfuuid="314"><a class="btn btn-invisible btn-link" href="javascript:void(0)" name="cancel_button">Cancel</a></span>
          <span sfuuid="315"><a class="btn btn-primary" href="javascript:void(0)" name="save_button">Save</a></span>
      </div>
    </div>
  </div>

</section>

<!-- dynamic generation -->
<div class="modal hide" id="noteModal">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Add a Note</h3>
  </div>
  <div class="modal-body">
    <div class="modal-content">
    <form class="form-horizontal">
      <fieldset>
        <div class="control-group">
          <label for="input01" class="control-label">Subject:</label>
          <div class="controls">
            <input type="text" id="input01" class="input-xlarge">
          </div>
        </div>
        <div class="control-group">
          <label for="select01" class="control-label">Note:</label>
          <div class="controls">
            <textarea class="input-xlarge"></textarea>
          </div>
        </div>
        <div class="control-group">
          <label for="select01" class="control-label">Attachement:</label>
          <div class="controls">
            <input type="file">
          </div>
        </div>
        <div class="hide">
          <div class="control-group">
            <label for="select01" class="control-label">Contact:</label>
            <div class="controls">
              <select data-placeholder="Choose a user..." class="select2" tabindex="2">
                <option value="pk"></option>
                <option value="pk">Administrator</option>
                <option value="pk">Majed Itani</option>
                <option value="pk">Uriah Welcome</option>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label for="select01" class="control-label">Related to:</label>
            <div class="controls">
              <select data-placeholder="Choose a account..." class="select2" tabindex="2">
                <option value="pk" selected="selected">Account</option>
                <option value="pk">Contact</option>
                <option value="pk">Opportunity</option>
              </select>
              <select data-placeholder="Choose a account..." class="select2" tabindex="2">
                <option value="pk" selected="selected">Perkin Kleiners</option>
                <option value="pk">Underwater Mining Inc.</option>
                <option value="pk">Weyland</option>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label for="select01" class="control-label">Assigned to:</label>
            <div class="controls">
              <select data-placeholder="Choose a user..." class="select2" tabindex="2">
                <option value="pk"></option>
                <option value="pk">Administrator</option>
                <option value="pk">Majed Itani</option>
                <option value="pk">Uriah Welcome</option>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label for="select01" class="control-label">Teams:</label>
            <div class="controls">
              <select data-placeholder="Choose a account..." class="select2" tabindex="2" multiple>
                <option value="pk">Global</option>
                <option value="pk" selected="selected">East</option>
                <option value="pk">West</option>
                <option value="pk">North</option>
                <option value="pk">South</option>
              </select>
            </div>
          </div>
        </div>
      </fieldset>
    </form>
    </div>
    <div class="modal-footer">
      <button class="btn cancel" data-dismiss="modal">Cancel</button>
      <a href="index.html" data-loading-text="Saving..." class="btn loading btn-primary">
        Save
      </a>
    </div>
  </div>
</div>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // forms switch
    _renderHtml: function () {
        this._super(\'_renderHtml\');

        var self = this;

        this.$(\'select.select2\').each(function(){
            var $this = $(this),
                ctor = self.getSelect2Constructor($this);
            $this.select2(ctor);
        });

        this.$(\'table td [rel=tooltip]\').tooltip({
            container:\'body\',
            placement:\'top\',
            html:\'true\'
        });

        this.$(\'.error input, .error textarea\').on(\'focus\', function(){
            $(this).next().tooltip(\'show\');
        });

        this.$(\'.error input, .error textarea\').on(\'blur\', function(){
            $(this).next().tooltip(\'hide\');
        });

        this.$(\'.add-on\')
            .tooltip(\'destroy\')  // I cannot find where _this_ tooltip gets initialised with \'hover\', so i detroy it first, -f1vlad
            .tooltip({
                trigger: \'click\',
                container: \'body\'
        });
    },

    _dispose: function() {
        this.$(\'.error input, .error textarea\').off(\'focus\');
        this.$(\'.error input, .error textarea\').off(\'blur\');
    },

    getSelect2Constructor: function($select) {
        var _ctor = {};
        _ctor.minimumResultsForSearch = 7;
        _ctor.dropdownCss = {};
        _ctor.dropdownCssClass = \'\';
        _ctor.containerCss = {};
        _ctor.containerCssClass = \'\';

        if ( $select.hasClass(\'narrow\') ) {
            _ctor.dropdownCss.width = \'auto\';
            _ctor.dropdownCssClass = \'select2-narrow \';
            _ctor.containerCss.width = \'75px\';
            _ctor.containerCssClass = \'select2-narrow\';
            _ctor.width = \'off\';
        }

        if ( $select.hasClass(\'inherit-width\') ) {
            _ctor.dropdownCssClass = \'select2-inherit-width \';
            _ctor.containerCss.width = \'100%\';
            _ctor.containerCssClass = \'select2-inherit-width\';
            _ctor.width = \'off\';
        }

        return _ctor;
    }
})
',
    ),
  ),
  'docs-forms-file' => 
  array (
    'templates' => 
    array (
      'docs-forms-file' => '
<section id="file-uploader">
  <div class="page-header">
    <h1>File uploader <small>custom layouts of field components</small></h1>
  </div>

  <div class="row-fluid control-group">
    <div class="span2">Label</div>
    <div class="span10">
      <span sfuuid="1">
        <label class="file-upload">
          <input type="file" name="uploadfile4" />
        </label>
      </span>
      <p class="help-block"></p></span>
    </div>
  </div>

  <h4><em>styled</em> <small>note: js required, look in application.js near line that has: <code>var uobj = []</code></small></h4>
  <div class="row-fluid control-group">
    <div class="span2">Label</div>
    <div class="span10">
      <span sfuuid="1">
        <span class="upload-field-custom btn">
          <label class="file-upload">
            <span><strong>Upload file</strong></span>
            <input type="file" name="uploadfile14" />
          </label>
        </span>
      </span>
      <p class="help-block"></p></span>
    </div>
  </div>

  <div class="row-fluid control-group">
    <div class="span2">Label</div>
    <div class="span10">
      <span sfuuid="1">
        <span class="upload-field-custom btn">
          <label class="file-upload">
            <span><strong><i class="fa fa-upload"></i></strong></span>
            <input type="file" name="uploadfile24" />
          </label>
        </span>
      </span>
      <p class="help-block"></p></span>
    </div>
  </div>

  <hr>

  <form id="imageform" method="post" enctype="multipart/form-data" action=\'ajaximage.php\'>
    <div class="row-fluid control-group">
      <div class="span1">Avatar</div>
      <div class="span3">
        <span sfuuid="1">
          <div class="image_field image_edit" style="max-width: 42px; height: 42px; min-height: 42px; line-height: 42px;">
            <label style="line-height: 42px;">
              <span class="image_input">
                <input type="file" name="picture">
              </span>
              <span class="image_btn image_btn_label">Edit</span>
              <span class="image_preview">
                <i class="fa fa-plus" style="line-height: 32px;"></i>
              </span>
              <span class="image_btn delete fa fa-trash-o"></span>
            </label>
          </div>
          <p class="help-block"></p>
        </span>
      </div>
      <div class="span1">Avatar</div>
      <div class="span3">
        <span sfuuid="1">
          <div class="image_field image_edit" style="max-width: 42px; height: 42px; min-height: 42px; line-height: 42px;">
            <label style="line-height: 42px;">
              <span class="image_input">
                <input type="file" name="picture">
              </span>
              <span class="image_btn image_btn_label">Edit</span>
              <span class="image_preview">
                <i class="fa fa-plus" style="line-height: 32px;"></i>
              </span>
              <span class="image_btn delete fa fa-times"></span>
            </label>
          </div>
          <p class="help-block"></p>
        </span>
      </div>
      <div class="span1">Avatar</div>
      <div class="span3 error">
        <span sfuuid="1">
          <div class="image_field image_edit" style="max-width: 42px; height: 42px; min-height: 42px; line-height: 42px;">
            <label style="line-height: 42px;">
              <span class="image_input">
                <input type="file" name="picture">
              </span>
              <span class="image_btn image_btn_label">Edit</span>
              <span class="image_preview">
                <i class="fa fa-plus" style="line-height: 32px;"></i>
              </span>
            </label>
            <span class="error-tooltip  add-on" rel="tooltip" data-original-title="Invalid file format, only image file can be uploaded."><i class="fa fa-exclamation-circle"></i></span>
          </div>
          <p class="help-block"></p>
        </span>
      </div>
    </div>
  </form>

</div>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
  className: \'container-fluid\',

  // components dropdowns
  _renderHtml: function () {
    this._super(\'_renderHtml\');

    /* Custom file upload overrides and avatar widget */
    var uobj = [],
        onUploadChange = function (e) {
          var status = $(this),
              opts = \'show\';
          if (this.value) {
            var this_container = $(this).parent(\'.file-upload\').parent(\'.upload-field-custom\'),
              value_explode = this.value.split(\'\\\\\'),
              value = value_explode[value_explode.length-1];

            if ($(this).closest(\'.upload-field-custom\').hasClass(\'avatar\')===true) { /* hide status for avatars */
              opts = "hide";
            }

            if (this_container.next(\'.file-upload-status\').length > 0) {
              this_container.next(\'.file-upload-status\').remove();
            }
            //this_container.append(\'<span class="file-upload-status">\'+value+\'</span>\');
            this.$(\'<span class="file-upload-status \' + opts + \' ">\' + value + \'</span>\').insertAfter(this_container);
          }
        },
        onUploadFocus = function () {
          $(this).parent().addClass(\'focus\');
        },
        onUploadBlur = function () {
          $(this).parent().addClass(\'focus\');
        };

    this.$(\'.upload-field-custom input[type=file]\').each(function() {
      // Bind events
      $(this)
        .bind(\'focus\', onUploadFocus)
        .bind(\'blur\', onUploadBlur)
        .bind(\'change\', onUploadChange);

      // Get label width so we can make button fluid, 12px default left/right padding
      var lbl_width = $(this).parent().find(\'span strong\').width() + 24;
      $(this)
        .parent().find(\'span\').css(\'width\',lbl_width)
        .closest(\'.upload-field-custom\').css(\'width\',lbl_width);

      // Set current state
      onUploadChange.call(this);

      // Minimizes the text input part in IE
      $(this).css(\'width\', \'0\');
    });

    this.$(\'#photoimg\').on(\'change\', function() {
      $("#preview1").html(\'\');
      $("#preview1").html(\'<span class="loading">Loading...</span>\');
      $("#imageform").ajaxForm({
        target: \'#preview1\'
      }).submit();
    });

    this.$(\'.preview.avatar\').on(\'click.styleguide\', function(e){
        $(this).closest(\'.span10\').find(\'label.file-upload span strong\').trigger(\'click\');
    });
  },

  _dispose: function(view) {
      this.$(\'#photoimg\').off(\'change\');
      this.$(\'.preview.avatar\').off(\'click.styleguide\');
  }
})
',
    ),
  ),
  'docs-forms-range' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // forms range
    _renderHtml: function () {
        this._super(\'_renderHtml\');

        var fieldSettings = {
            view: this,
            def: {
                name: \'include\',
                type: \'range\',
                view: \'edit\',
                sliderType: \'connected\',
                minRange: 0,
                maxRange: 100,
                \'default\': true,
                enabled: true
            },
            viewName: \'edit\',
            context: this.context,
            module: this.module,
            model: this.model,
            meta: app.metadata.getField(\'range\')
        },
        rangeField = app.view.createField(fieldSettings);

        this.$(\'#test_slider\').append(rangeField.el);

        rangeField.render();

        rangeField.sliderDoneDelegate = function(minField, maxField) {
            return function(value) {
                minField.val(value.min);
                maxField.val(value.max);
            };
        }(this.$(\'#test_slider_min\'), this.$(\'#test_slider_max\'));
    }
})
',
    ),
    'templates' => 
    array (
      'docs-forms-range' => '
<!-- Slider
================================================== -->
<section id="slider">
    <div class="page-header">
        <h1>Range Field <small>built with the noUiSlider jQuery plugin</small></h1>
    </div>
    <div class="row-fluid">
        <div class="span3 columns">
            <h3>About noUiSlider</h3>
            <p>noUiSlider is a little jQuery plugin that makes really cool (double) range sliders. Every slider can have two handles to select a range, a fixed minimum or maximum can be set to select a limit, or two handles can be used, to simply pick some points. </p>
            <p>The jquery.nouislider.js plugin is included in the default build of SugarCRM. [<a href="http://refreshless.com/nouislider/"><i class="fa fa-book"></i> Docs</a>]</p>
        </div>
        <div class="span9 columns">
            <h2>Sugar7 Example</h2>
            <div class="well" id="test_slider">
            </div>
            <div class="row-fluid record">
              <div class="span6">
                <label>Min: </label><input id="test_slider_min" value="0">
              </div>
              <div class="span6">
                <label>Max: </label><input id="test_slider_max" value="100">
              </div>
            </div>
            <hr>

            <h2>Using noUiSlider</h2>

            <h3>Markup</h3>
<pre class="prettyprint linenums">
&lt;div id="test_slider" class="noUiSlider"&gt;&lt;/div&gt;
&lt;input id="test_slider_min" value="0"&gt;
&lt;input id="test_slider_max" value="100"&gt;
</pre>

            <h3>JavaScript</h3>
<pre class="prettyprint linenums">
var fieldSettings = {
    view: this,
    def: { OPTIONS },
    viewName: \'edit\',
    context: this.context,
    module: this.module,
    model: this.model,
    meta: app.metadata.getField(\'range\')
},
rangeField = app.view.createField(fieldSettings);

this.$(\'#test_slider\').append(rangeField.el);
rangeField.render();

rangeField.sliderDoneDelegate = function(minField, maxField) {
    return function(value) {
        minField.val(value.min);
        maxField.val(value.max);
    };
}(this.$(\'#test_slider_min\'), this.$(\'#test_slider_max\'));
</pre>

            <h3>Options</h3>
            <table class="table table-bordered table-striped">
                <tbody><tr>
                    <th>Name</th>
                    <th>Parameter type</th>
                    <th>Possible parameter values</th>
                    <th>Description</th>
                </tr>
                <tr>
                    <td>name</td>
                    <td>[VARCHAR]</td>
                    <td></td>
                    <td>Name of field in model.</td>
                </tr>
                <tr>
                    <td>type</td>
                    <td>[VARCHAR]</td>
                    <td>"range"</td>
                    <td>Field type.</td>
                </tr>
                <tr>
                    <td>view</td>
                    <td>[VARCHAR]</td>
                    <td>"edit", "detail"</td>
                    <td>Display mode for field.</td>
                </tr>
                <tr>
                    <td>sliderType</td>
                    <td>[VARCHAR]</td>
                    <td>"single", "upper", "lower", "double", "connected"</td>
                    <td>Type of knobs to display in slider.</td>
                </tr>
                <tr>
                    <td>minRange, maxRange</td>
                    <td>[INT]</td>
                    <td>Any value between 0 an 100. The value will be corrected to fit within the edges of the slider. The upper knob will not be place below and lower knob, and vice versa.</td>
                    <td>The position to move a knob to.</td>
                </tr>
                <tr>
                    <td>default</td>
                    <td>[BOOLEAN]</td>
                    <td>true, false</td>
                    <td></td>
                </tr>
                <tr>
                    <td>enabled</td>
                    <td>[BOOLEAN]</td>
                    <td>true, false</td>
                    <td>Whether or not the control is enabled.</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
',
    ),
  ),
  'list' => 
  array (
    'templates' => 
    array (
      'list-doc' => '
<section id="typography">
  <div class="page-header">
    <h2>List Views &amp; Tables</h2>
  </div>

  <p>Here are some <a href="#Styleguide/docs/layouts_list">instructions</a> for how to style list views using Bootstrap classes. By default only the <code>.table-striped</code> styling is applied.</p>

  <h3>Example list view</h3>
  <div id="exampleView" class="example-view">
  </div>

  <h3>General markup</h3>
<pre class="prettyprint linenums">
&lt;div class="list-view"&gt;
  &lt;table class="table table-striped dataTable"&gt;
    &lt;thead&gt;
      &lt;tr&gt;
        &lt;th class="sorting orderBy[field]" data-fieldname="[field]" data-orderby=""&gt;
          &lt;span&gt;...&lt;/span&gt;
        &lt;/th&gt;
      &lt;/tr&gt;
    &lt;/thead&gt;
    &lt;tbody&gt;
     &lt;tr&gt;
      &lt;td&gt;...&lt;/td&gt;
    &lt;/tbody&gt;
  &lt;/table&gt;
&lt;/div&gt;</pre>
</section>
',
    ),
    'meta' => 
    array (
      'panels' => 
      array (
        0 => 
        array (
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'full_name',
              'type' => 'fullname',
              'fields' => 
              array (
                0 => 'salutation',
                1 => 'first_name',
                2 => 'last_name',
              ),
              'link' => true,
              'css_class' => 'full-name',
              'label' => 'fullname',
              'enabled' => true,
              'default' => true,
            ),
            1 => 
            array (
              'name' => 'title',
              'label' => 'base',
            ),
            2 => 
            array (
              'name' => 'do_not_call',
              'label' => 'bool',
            ),
            3 => 
            array (
              'name' => 'parent_name',
              'label' => 'parent',
              'sortable' => false,
            ),
            4 => 
            array (
              'name' => 'email',
              'label' => 'email',
              'sortable' => false,
            ),
            5 => 
            array (
              'name' => 'assigned_user_name',
              'label' => 'relate',
              'id' => 'ASSIGNED_USER_ID',
              'default' => true,
              'sortable' => false,
            ),
            6 => 
            array (
              'name' => 'filename',
              'label' => 'file',
            ),
            7 => 
            array (
              'name' => 'list_price',
              'label' => 'currency',
            ),
            8 => 
            array (
              'name' => 'date_entered',
              'label' => 'datetimecombo',
              'sortable' => false,
            ),
          ),
        ),
      ),
    ),
  ),
  'docs-components-progress' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\'
})
',
    ),
    'templates' => 
    array (
      'docs-components-progress' => '
<!-- Progress bars
================================================== -->
<section id="progress-bars">
  <div class="page-header">
    <h1>Progress bars <small>For loading, redirecting, or action status</small></h1>
  </div>

  <h2>Examples and markup</h2>
  <div class="row-fluid">
    <div class="span4">
      <h3>Basic</h3>
      <p>Default progress bar with a vertical gradient.</p>
      <div class="progress">
        <div class="bar" style="width: 60%;"></div>
      </div>
      <br>
<pre class="prettyprint linenums">
&lt;div class="progress"&gt;
  &lt;div class="bar"
       style="width: 60%;"&gt;&lt;/div&gt;
&lt;/div&gt;
</pre>
    </div>
    <div class="span4">
      <h3>Striped</h3>
      <p>Uses a gradient to create a striped effect.</p>
      <div class="progress progress-info progress-striped">
        <div class="bar" style="width: 20%;"></div>
      </div>
      <br>
<pre class="prettyprint linenums">
&lt;div class="progress progress-info
     progress-striped"&gt;
  &lt;div class="bar"
       style="width: 20%;"&gt;&lt;/div&gt;
&lt;/div&gt;
</pre>
    </div>
    <div class="span4">
      <h3>Animated</h3>
      <p>Takes the striped example and animates it.</p>
      <div class="progress progress-success progress-striped active">
        <div class="bar" style="width: 45%"></div>
      </div>
      <br>
<pre class="prettyprint linenums">
&lt;div class="progress progress-success
     progress-striped active"&gt;
  &lt;div class="bar"
       style="width: 40%;"&gt;&lt;/div&gt;
&lt;/div&gt;
</pre>
    </div>
  </div>

  <h2>Options and browser support</h2>
  <div class="row-fluid">
    <div class="span4">
      <h3>Additional colors</h3>
      <p>Progress bars utilize some of the same class names as buttons and alerts for similar styling.</p>
      <ul>
        <li><code>.progress-info</code></li>
        <li><code>.progress-success</code></li>
        <li><code>.progress-danger</code></li>
      </ul>
      <p>Alternatively, you can customize the LESS files and roll your own colors and sizes.</p>
    </div>
    <div class="span4">
      <h3>Behavior</h3>
      <p>Progress bars use CSS3 transitions, so if you dynamically adjust the width via javascript, it will smoothly resize.</p>
      <p>If you use the <code>.active</code> class, your <code>.progress-striped</code> progress bars will animate the stripes left to right.</p>
    </div>
    <div class="span4">
      <h3>Browser support</h3>
      <p>Progress bars use CSS3 gradients, transitions, and animations to achieve all their effects. These features are not supported in IE7-8 or older versions of Firefox.</p>
      <p>Opera does not support animations at this time.</p>
    </div>
  </div>

</section>
',
    ),
  ),
  'docs-base-mixins' => 
  array (
    'templates' => 
    array (
      'docs-base-mixins' => '
<!-- MIXINS
================================================== -->
<section id="mixins">
  <div class="page-header">
    <h1>Mixins <small></small></h1>
  </div>
  <h2>About mixins</h2>
  <div class="row-fluid">
    <div class="span4">
      <h3>Basic mixins</h3>
      <p>A basic mixin is essentially an include or a partial for a snippet of CSS. They\'re written just like a CSS class and can be called anywhere.</p>
<pre class="prettyprint linenums">
.element {
  .clearfix();
}
</pre>
    </div><!-- /span4 -->
    <div class="span4">
      <h3>Parametric mixins</h3>
      <p>A parametric mixin is just like a basic mixin, but it also accepts parameters (hence the name) with optional default values.</p>
<pre class="prettyprint linenums">
.element {
  .border-radius(4px);
}
</pre>
    </div><!-- /span4 -->
    <div class="span4">
      <h3>Easily add your own</h3>
      <p>Nearly all of the mixins are stored in mixins.less, a wonderful utility .less file that enables you to use a mixin in any of the .less files in the toolkit.</p>
      <p>So, go ahead and use the existing ones or feel free to add your own as you need.</p>
    </div><!-- /span4 -->
  </div><!-- /row -->
  <h2>Included mixins</h2>
  <h3>Utilities</h3>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th class="span4">Mixin</th>
        <th>Parameters</th>
        <th>Usage</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><code>.clearfix()</code></td>
        <td><em class="muted">none</em></td>
        <td>Add to any parent to clear floats within</td>
      </tr>
      <tr>
        <td><code>.tab-focus()</code></td>
        <td><em class="muted">none</em></td>
        <td>Apply the Webkit focus style and round Firefox outline</td>
      </tr>
      <tr>
        <td><code>.center-block()</code></td>
        <td><em class="muted">none</em></td>
        <td>Auto center a block-level element using <code>margin: auto</code></td>
      </tr>
      <tr>
        <td><code>.ie7-inline-block()</code></td>
        <td><em class="muted">none</em></td>
        <td>Use in addition to regular <code>display: inline-block</code> to get IE7 support</td>
      </tr>
      <tr>
        <td><code>.size()</code></td>
        <td><code>@height: 5px, @width: 5px</code></td>
        <td>Quickly set the height and width on one line</td>
      </tr>
      <tr>
        <td><code>.square()</code></td>
        <td><code>@size: 5px</code></td>
        <td>Builds on <code>.size()</code> to set the width and height as same value</td>
      </tr>
      <tr>
        <td><code>.opacity()</code></td>
        <td><code>@opacity: 100</code></td>
        <td>Set, in whole numbers, the opacity percentage (e.g., "50" or "75")</td>
      </tr>
    </tbody>
  </table>
  <h3>Forms</h3>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th class="span4">Mixin</th>
        <th>Parameters</th>
        <th>Usage</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><code>.placeholder()</code></td>
        <td><code>@color: @placeholderText</code></td>
        <td>Set the <code>placeholder</code> text color for inputs</td>
      </tr>
    </tbody>
  </table>
  <h3>Typography</h3>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th class="span4">Mixin</th>
        <th>Parameters</th>
        <th>Usage</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><code>#font > #family > .serif()</code></td>
        <td><em class="muted">none</em></td>
        <td>Make an element use a serif font stack</td>
      </tr>
      <tr>
        <td><code>#font > #family > .sans-serif()</code></td>
        <td><em class="muted">none</em></td>
        <td>Make an element use a sans-serif font stack</td>
      </tr>
      <tr>
        <td><code>#font > #family > .monospace()</code></td>
        <td><em class="muted">none</em></td>
        <td>Make an element use a monospace font stack</td>
      </tr>
      <tr>
        <td><code>#font > .shorthand()</code></td>
        <td><code>@size: @baseFontSize, @weight: normal, @lineHeight: @baseLineHeight</code></td>
        <td>Easily set font size, weight, and leading</td>
      </tr>
      <tr>
        <td><code>#font > .serif()</code></td>
        <td><code>@size: @baseFontSize, @weight: normal, @lineHeight: @baseLineHeight</code></td>
        <td>Set font family to serif, and control size, weight, and leading</td>
      </tr>
      <tr>
        <td><code>#font > .sans-serif()</code></td>
        <td><code>@size: @baseFontSize, @weight: normal, @lineHeight: @baseLineHeight</code></td>
        <td>Set font family to sans-serif, and control size, weight, and leading</td>
      </tr>
      <tr>
        <td><code>#font > .monospace()</code></td>
        <td><code>@size: @baseFontSize, @weight: normal, @lineHeight: @baseLineHeight</code></td>
        <td>Set font family to monospace, and control size, weight, and leading</td>
      </tr>
    </tbody>
  </table>
  <h3>Grid system</h3>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th class="span4">Mixin</th>
        <th>Parameters</th>
        <th>Usage</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><code>.container-fixed()</code></td>
        <td><em class="muted">none</em></td>
        <td>Provide a fixed-width (set with <code>@siteWidth</code>) container for holding your content</td>
      </tr>
      <tr>
        <td><code>.columns()</code></td>
        <td><code>@columns: 1</code></td>
        <td>Build a grid column that spans any number of columns (defaults to 1 column)</td>
      </tr>
      <tr>
        <td><code>.offset()</code></td>
        <td><code>@columns: 1</code></td>
        <td>Offset a grid column with left margin that spans any number of columns</td>
      </tr>
      <tr>
        <td><code>.gridColumn()</code></td>
        <td><em class="muted">none</em></td>
        <td>Make an element float like a grid column</td>
      </tr>
    </tbody>
  </table>
  <h3>CSS3 properties</h3>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th class="span4">Mixin</th>
        <th>Parameters</th>
        <th>Usage</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><code>.border-radius()</code></td>
        <td><code>@radius: 5px</code></td>
        <td>Round the corners of an element. Can be a single value or four space-separated values</td>
      </tr>
      <tr>
        <td><code>.box-shadow()</code></td>
        <td><code>@shadow: 0 1px 3px rgba(0,0,0,.25)</code></td>
        <td>Add a drop shadow to an element</td>
      </tr>
      <tr>
        <td><code>.transition()</code></td>
        <td><code>@transition</code></td>
        <td>Add CSS3 transition effect (e.g., <code>all .2s linear</code>)</td>
      </tr>
      <tr>
        <td><code>.rotate()</code></td>
        <td><code>@degrees</code></td>
        <td>Rotate an element <em>n</em> degrees</td>
      </tr>
      <tr>
        <td><code>.scale()</code></td>
        <td><code>@ratio</code></td>
        <td>Scale an element to <em>n</em> times it\'s original size</td>
      </tr>
      <tr>
        <td><code>.translate()</code></td>
        <td><code>@x: 0, @y: 0</code></td>
        <td>Move an element on the x and y planes</td>
      </tr>
      <tr>
        <td><code>.background-clip()</code></td>
        <td><code>@clip</code></td>
        <td>Crop the backgroud of an element (useful for <code>border-radius</code>)</td>
      </tr>
      <tr>
        <td><code>.background-size()</code></td>
        <td><code>@size</code></td>
        <td>Control the size of background images via CSS3</td>
      </tr>
      <tr>
        <td><code>.box-sizing()</code></td>
        <td><code>@boxmodel</code></td>
        <td>Change the box model for an element (e.g., <code>border-box</code> for a full-width <code>input</code>)</td>
      </tr>
      <tr>
        <td><code>.user-select()</code></td>
        <td><code>@select</code></td>
        <td>Control cursor selection of text on a page</td>
      </tr>
      <tr>
        <td><code>.resizable()</code></td>
        <td><code>@direction: both</code></td>
        <td>Make any element resizable on the right and bottom</td>
      </tr>
      <tr>
        <td><code>.content-columns()</code></td>
        <td><code>@columnCount, @columnGap: @gridColumnGutter</code></td>
        <td>Make the content of any element use CSS3 columns</td>
      </tr>
    </tbody>
  </table>
  <h3>Backgrounds and gradients</h3>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th class="span4">Mixin</th>
        <th>Parameters</th>
        <th>Usage</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><code>.#translucent > .background()</code></td>
        <td><code>@color: @white, @alpha: 1</code></td>
        <td>Give an element a translucent background color</td>
      </tr>
      <tr>
        <td><code>.#translucent > .border()</code></td>
        <td><code>@color: @white, @alpha: 1</code></td>
        <td>Give an element a translucent border color</td>
      </tr>
      <tr>
        <td><code>.#gradient > .vertical()</code></td>
        <td><code>@startColor, @endColor</code></td>
        <td>Create a cross-browser vertical background gradient</td>
      </tr>
      <tr>
        <td><code>.#gradient > .horizontal()</code></td>
        <td><code>@startColor, @endColor</code></td>
        <td>Create a cross-browser horizontal background gradient</td>
      </tr>
      <tr>
        <td><code>.#gradient > .directional()</code></td>
        <td><code>@startColor, @endColor, @deg</code></td>
        <td>Create a cross-browser directional background gradient</td>
      </tr>
      <tr>
        <td><code>.#gradient > .vertical-three-colors()</code></td>
        <td><code>@startColor, @midColor, @colorStop, @endColor</code></td>
        <td>Create a cross-browser three-color background gradient</td>
      </tr>
      <tr>
        <td><code>.#gradient > .radial()</code></td>
        <td><code>@innerColor, @outerColor</code></td>
        <td>Create a cross-browser radial background gradient</td>
      </tr>
      <tr>
        <td><code>.#gradient > .striped()</code></td>
        <td><code>@color, @angle</code></td>
        <td>Create a cross-browser striped background gradient</td>
      </tr>
      <tr>
        <td><code>.#gradientBar()</code></td>
        <td><code>@primaryColor, @secondaryColor</code></td>
        <td>Used for buttons to assign a gradient and slightly darker border</td>
      </tr>
    </tbody>
  </table>
</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\'
})
',
    ),
  ),
  'docs-forms-editable' => 
  array (
    'templates' => 
    array (
      'docs-forms-editable' => '
<script src="include/javascript/jquery/jquery.jeditable.js"></script>

<!-- Editable
================================================== -->
<section id="editable">
  <div class="page-header">
    <h1>Editable <small>Inline edit inputs</small></h1>
  </div>
  <div class="row-fluid">

    <div class="span6">
      <h2>Inline editable field</h2>

      <div class="row-fluid control-group">
        <div class="span2">
          Label
        </div>
        <div class="span10 urleditable-wrap inline-editable-wrap">
          <span sfuuid="1">
            <a class="btn-mini btn inline-editable urleditable text-editable-trigger pull-left">
              <i class="fa fa-pencil fa-sm"></i>
            </a>
            <span class="urleditable-field editable-field">Some content</span>
          </span>
          <p class="help-block">
          </p>
        </div>
      </div>

      <div class="row-fluid control-group">
        <div class="span2">
          Label
        </div>
        <div class="span10 urleditable-wrap inline-editable-wrap ">
          <span sfuuid="1">
            <a class="btn-mini btn inline-editable urleditable text-editable-trigger pull-left">
              <i class="fa fa-pencil fa-sm"></i>
            </a>
            <span class="urleditable-field editable-field">Lots of content lots of content lots of contentlots of content lots of content</span>
          </span>
          <p class="help-block">
          </p>
        </div>
      </div>

      <div class="row-fluid control-group error">
        <div class="span2">
          Label
        </div>
        <div class="span10 urleditable-wrap inline-editable-wrap">
          <span sfuuid="1">
            <a class="btn-mini btn inline-editable urleditable text-editable-trigger pull-left">
              <i class="fa fa-pencil fa-sm"></i>
            </a>
            <span class="editable-field">Lots of content lots of content lots of contentlots of content lots of content</span>
          </span>
          <p class="help-block">
            Error. This field is required.
          </p>
        </div>
      </div>
    </div>

    <div class="span6">
      <h2>URL field</h2>

      <div class="row-fluid control-group">
        <div class="span2">
          Label
        </div>
        <div class="span10 urleditable-wrap inline-editable-wrap ">
          <span sfuuid="1">
            <a class="btn-mini btn inline-editable urleditable editable-trigger url-editable-trigger pull-left">
              <i class="fa fa-pencil fa-sm"></i>
            </a>
            <span class="urleditable-field editable-field"><a href=""><span>http://google.com</span></a></span>
          </span>
          <p class="help-block">
          </p>
        </div>
      </div>

      <div class="row-fluid control-group">
        <div class="span2">
          Label
        </div>
        <div class="span10 urleditable-wrap inline-editable-wrap ">
          <span sfuuid="1">
            <a class="btn-mini btn inline-editable urleditable editable-trigger url-editable-trigger pull-left">
              <i class="fa fa-pencil fa-sm"></i>
            </a>
            <span class="urleditable-field editable-field"><a href=""><span>https://sugarcrm.atlassian.net/secure/IssueNavigator.jspa&64;dasdsd</span></a></span>
          </span>
          <p class="help-block">
          </p>
        </div>
      </div>

      <div class="row-fluid control-group error">
        <div class="span2">
          Label
        </div>
        <div class="span10 urleditable-wrap inline-editable-wrap ">
          <span sfuuid="1">
            <a class="btn-mini btn inline-editable urleditable editable-trigger url-editable-trigger pull-left">
              <i class="fa fa-pencil fa-sm"></i>
            </a>
            <span class="urleditable-field editable-field"><a href=""><span>https://sugarcrm.atlassian.net/secure/IssueNavigator.jspa&64;dasdsd</span></a></span>
          </span>
          <p class="help-block">
            Error. This field is required.
          </p>
        </div>
      </div>

      <!-- <p>Take the same <code>&lt;pre&gt;</code> element and add two optional classes for enhanced rendering.</p>
      <pre class="prettyprint linenums" style="margin-bottom: 9px;">
      &lt;p&gt;Sample text here...&lt;/p&gt;
      </pre> -->
    </div>

  </div>
</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
  className: \'container-fluid\',

  // forms editable
  _renderHtml: function () {
      this._super(\'_renderHtml\');

      this.$(\'.url-editable-trigger\').on(\'click.styleguide\',function(){
        var uefield = $(this).next();
        uefield
          .html(uefield.text())
          .editable(
            function(value, settings) {
                var nvprep = \'<a href="\'+value+\'">\',
                    nvapp = \'</a>\',
                    value = nvprep.concat(value);
               return(value);
            },
            {onblur:\'submit\'}
          )
          .trigger(\'click.styleguide\');
      });

      this.$(\'.text-editable-trigger\').on(\'click.styleguide\',function(){
        var uefield = $(this).next();
        uefield
          .html(uefield.text())
          .editable()
          .trigger(\'click.styleguide\');
      });

      this.$(\'.urleditable-field > a\').each(function(){
        if(isEllipsis($(this))===true) {
          $(this).attr({\'data-original-title\':$(this).text(),\'rel\':\'tooltip\',\'class\':\'longUrl\'});
        }
      });

      function isEllipsis(e) { // check if ellipsis is present on el, add tooltip if so
        return (e[0].offsetWidth < e[0].scrollWidth);
      }

      this.$(\'.longUrl[rel=tooltip]\').tooltip({placement:\'top\'});
  }
})
',
    ),
  ),
  'docs-base-typography' => 
  array (
    'templates' => 
    array (
      'docs-base-typography' => '
<!-- Typography
================================================== -->
<section id="typography">
  <div class="page-header">
    <h1>Typography <small>Headings, paragraphs, lists, and other inline type elements</small></h1>
  </div>
  <h2>Family</h2>
  <div class="row-fluid">
    <div class="span4">
      <h3>Two fonts</h3>
      <p>There should not typically be more than two types of font families used across our properties.  The heading font applied to h1,h2,h3,h4 and then the main body font. </p>
    </div>
    <div class="span4">
      <h3>Font Demo</h3>
      <h4>Headings (h1-h4) - Open Sans (400 weight)</h4>
      <p>Normal - Open Sans (400 weight)</p>
      <p><strong>600 weight is available as well</strong></p>
    </div>
  </div>

  <h2>Headings &amp; body copy</h2>

  <!-- Headings & Paragraph Copy -->
  <div class="row-fluid">
    <div class="span4">
      <h3>Typographic scale</h3>
      <p>The entire typographic grid is based on two variables in our variables.less file: <code>@baseFontSize</code> and <code>@baseLineHeight</code>. The first is the base font-size used throughout and the second is the base line-height.</p>
      <p>We use those variables, and some math, to create the margins, paddings, and line-heights of all our type and more.</p>
    </div>
    <div class="span4">
      <h3>Example body text</h3>
      <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
      <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec sed odio dui.</p>
    </div>
    <div class="span4">
      <div class="well">
        <h1>h1. Heading 1</h1>
        <h2>h2. Heading 2</h2>
        <h3>h3. Heading 3</h3>
        <h4>h4. Heading 4</h4>
        <h5>h5. Heading 5</h5>
        <h6>h6. Heading 6</h6>
      </div>
    </div>
  </div>

  <h2 id="4jfAel">Usage of ellipsis for long text strings</h2>
  <div class="row-fluid">
    <div class="span8">
      <p>Ellipsis&nbsp;&mdash; a series of dots that usually indicate an intentional omission of a word, sentence or whole section from the original text being quoted...</p>
      <p>To avoid wrapping a string of text such as label, heading, etc, ellipsis should be used in conjunction with <a href="widgets.html#tooltips">tooltips</a> or <a href="widgets.html#popovers">popovers</a> to let user still see what the full text string says.</p>

      <h4>General markup</h4>
      <pre class="prettyprint linenums">
      &lt;p class="ellipsis_inline" rel="tooltip" data-original-title="p. This is a very long paragraph that need to be truncated"&gt;
        p. This is a very long paragraph that need to be truncated
      &lt;/p&gt;
      </pre>
      <h4>Notes</h4>
      <p>Enclose string that is to be truncated in an HTML element with class <code>ellipsis_inline</code>. This element is to be displayed as a block with its width attribute being optional as it is being inherited from its parent. If any siblings are to be displayed on the same line with truncated text, ensure they\'re float\'ing right or left. See examples in the right column.</p>
    </div>

    <div class="span4">
      <div class="well">
        <h2 class="ellipsis_inline" rel="tooltip" data-original-title="h2. This is a very long heading that need to be truncated 2">h2. This is a very long heading that need to be truncated 2</h2>
        <h3 class="ellipsis_inline" rel="tooltip" data-original-title="h3. This is a very long heading that need to be truncated 3">h3. This is a very long heading that need to be truncated 3</h3>
        <p class="ellipsis_inline" rel="tooltip" data-original-title="p. This is a very long paragraph that need to be truncated">p. This is a very long paragraph that need to be truncated</p>
        <div class="ellipsis_inline" rel="tooltip" data-original-title="div. This is a very long div that need to be truncated">span. This is a very long span that need to be truncated</div>
      </div>
      <div class="well">
        <div class="btn-group pull-right">
          <a class="btn btn-small btn-primary" style="top:-5px">Primary action</a>
        </div>
        <div class="ellipsis_inline" rel="tooltip" data-original-title="div. This is a very long div that need to be truncated">div. This is a very long div that need to be truncated</div>
        <hr>
        <div class="pull-left">
          <i class="fa fa-warning-sign" style="color:#D14"></i>&nbsp;
        </div>
        <div class="btn-group pull-right">
          <a class="btn btn-small btn-primary" style="top:-5px">Primary action</a>
        </div>
        <div class="ellipsis_inline" rel="tooltip" data-original-title="div. This is a very long div that need to be truncated">div. This is a very long div that need to be truncated</div>
        <hr>
        <div class="pull-left">
          <i class="fa fa-warning-sign" style="color:#D14"></i> <i class="fa fa-headphones"></i> <i class="fa fa-chevron-right"></i>&nbsp;
        </div>
        <div class="btn-group pull-right">
          <a class="btn btn-small btn-primary" style="top:-5px">Primary action</a>
        </div>
        <div class="ellipsis_inline" rel="tooltip" data-original-title="div. This is a very long div that need to be truncated">div. This is a very long div that need to be truncated</div>
        <hr>
        <div class="row-fluid">
          <div class="span3" style="border:1px dotted #ccc">
            <div class="ellipsis_inline" rel="tooltip" data-original-title="div. This is a very long div that need to be truncated">div. This is a very long div that need to be truncated</div>
          </div>
          <div class="span3" style="border:1px dotted #ccc">
            <div class="ellipsis_inline" rel="tooltip" data-original-title="div. This is a very long div that need to be truncated">div. This is a very long div that need to be truncated</div>
          </div>
          <div class="span6" style="border:1px dotted #ccc">
            <div class="ellipsis_inline" rel="tooltip" data-original-title="div. This is a very long div that need to be truncated">div. This is a very long div that need to be truncated</div>
          </div>
        </div>
        <hr>
        <div class="row-fluid control-group">
          <div class="span3">
            <label class="control-label ellipsis_inline" for="name" rel="tooltip" data-original-title="Label of the field">Label of the field</label>
          </div>
          <div class="span9">
            <span sfuuid="1">
              <input type="text" name="name" id="name" value="" class="input-medium" >
              <p class="help-block">
              </p>
            </span>
            <p class="help-block">
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Misc Elements -->
  <h2>Emphasis, address, and abbreviation</h2>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Element</th>
        <th>Usage</th>
        <th>Optional</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <code>&lt;strong&gt;</code>
        </td>
        <td>
          For emphasizing a snippet of text with <strong>important</strong>
        </td>
        <td>
          <span class="muted">None</span>
        </td>
      </tr>
      <tr>
        <td>
          <code>&lt;em&gt;</code>
        </td>
        <td>
          For emphasizing a snippet of text with <em>stress</em>
        </td>
        <td>
          <span class="muted">None</span>
        </td>
      </tr>
      <tr>
        <td>
          <code>&lt;abbr&gt;</code>
        </td>
        <td>
          Wraps abbreviations and acronyms to show the expanded version on hover
        </td>
        <td>
          Include optional <code>title</code> for expanded text
        </td>
      </tr>
      <tr>
        <td>
          <code>&lt;address&gt;</code>
        </td>
        <td>
          For contact information for its nearest ancestor or the entire body of work
        </td>
        <td>
          Preserve formatting by ending all lines with <code>&lt;br&gt;</code>
        </td>
      </tr>
    </tbody>
  </table>

  <div class="row-fluid">
    <div class="span4">
      <h3>Using emphasis</h3>
      <p><a>Fusce dapibus</a>, <strong>tellus ac cursus commodo</strong>, <em>tortor mauris condimentum nibh</em>, ut fermentum massa justo sit amet risus. Maecenas faucibus mollis interdum. Nulla vitae elit libero, a pharetra augue.</p>
      <p><strong>Note:</strong> Feel free to use <code>&lt;b&gt;</code> and <code>&lt;i&gt;</code> in HTML5, but their usage has changed a bit. <code>&lt;b&gt;</code> is meant to highlight words or phrases without conveying additional importance while <code>&lt;i&gt;</code> is mostly for voice, technical terms, etc.</p>
    </div>
    <div class="span4">
      <h3>Example addresses</h3>
      <p>Here are two examples of how the <code>&lt;address&gt;</code> tag can be used:</p>
      <address>
        <strong>SugarCRM, Inc.</strong><br>
        33 Some Ave, Suite 600<br>
        San Francisco, CA 94107<br>
        <abbr title="Phone">P:</abbr> (123) 456-7890
      </address>
      <address>
        <strong>Full Name</strong><br>
        <a href="mailto:#">first.last@gmail.com</a>
      </address>
    </div>
    <div class="span4">
      <h3>Example abbreviations</h3>
      <p>Abbreviations are styled with uppercase text and a light dotted bottom border. They also have a help cursor on hover so users have extra indication something will be shown on hover.</p>
      <p><abbr title="HyperText Markup Language">HTML</abbr> is the best thing since sliced bread.</p>
      <p>An abbreviation of the word attribute is <abbr title="attribute">attr</abbr>.</p>
    </div>
  </div>


  <!-- Blockquotes -->
  <h2>Blockquotes</h2>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Element</th>
        <th>Usage</th>
        <th>Optional</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <code>&lt;blockquote&gt;</code>
        </td>
        <td>
          Block-level element for quoting content from another source
        </td>
        <td>
          <p>Add <code>cite</code> attribute for source URL</p>
          Use <code>.pull-left</code> and <code>.pull-right</code> classes for floated options
        </td>
      </tr>
      <tr>
        <td>
          <code>&lt;small&gt;</code>
        </td>
        <td>
          Optional element for adding a user-facing citation, typically an author with title of work
        </td>
        <td>
          Place the <code>&lt;cite&gt;</code> around the title or name of source
        </td>
      </tr>
    </tbody>
  </table>
  <div class="row-fluid">
    <div class="span4">
      <p>To include a blockquote, wrap <code>&lt;blockquote&gt;</code> around any <abbr title="HyperText Markup Language">HTML</abbr> as the quote. For straight quotes we recommend a <code>&lt;p&gt;</code>.</p>
      <p>Include an optional <code>&lt;small&gt;</code> element to cite your source and you\'ll get an em dash <code>&amp;mdash;</code> before it for styling purposes.</p>
    </div>
    <div class="span8">
<pre class="prettyprint linenums">
&lt;blockquote&gt;
  &lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante venenatis.&lt;/p&gt;
  &lt;small&gt;Someone famous&lt;/small&gt;
&lt;/blockquote&gt;
</pre>
    </div>
  </div><!--/row-->

  <h3>Example blockquotes</h3>
  <div class="row-fluid">
    <div class="span6">
      <p>Default blockquotes are styled as such:</p>
      <blockquote>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante venenatis.</p>
        <small>Someone famous in <cite title="">Body of work</cite></small>
      </blockquote>
    </div>
    <div class="span6">
      <p>To float your blockquote to the right, add <code>class="pull-right"</code>:</p>
      <blockquote class="pull-right">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante venenatis.</p>
        <small>Someone famous in <cite title="">Body of work</cite></small>
      </blockquote>
    </div>
  </div>


  <!-- Lists -->
  <h2>Lists</h2>
  <div class="row-fluid">
    <div class="span3">
      <h4>Unordered</h4>
      <p><code>&lt;ul&gt;</code></p>
      <ul>
        <li>Lorem ipsum dolor sit amet</li>
        <li>Consectetur adipiscing elit</li>
        <li>Integer molestie lorem at massa</li>
        <li>Facilisis in pretium nisl aliquet</li>
        <li>Nulla volutpat aliquam velit
          <ul>
            <li>Phasellus iaculis neque</li>
            <li>Purus sodales ultricies</li>
            <li>Vestibulum laoreet porttitor sem</li>
            <li>Ac tristique libero volutpat at</li>
          </ul>
        </li>
        <li>Faucibus porta lacus fringilla vel</li>
        <li>Aenean sit amet erat nunc</li>
        <li>Eget porttitor lorem</li>
      </ul>
    </div>
    <div class="span3">
      <h4>Unstyled</h4>
      <p><code>&lt;ul class="unstyled"&gt;</code></p>
      <ul class="unstyled">
        <li>Lorem ipsum dolor sit amet</li>
        <li>Consectetur adipiscing elit</li>
        <li>Integer molestie lorem at massa</li>
        <li>Facilisis in pretium nisl aliquet</li>
        <li>Nulla volutpat aliquam velit
          <ul>
            <li>Phasellus iaculis neque</li>
            <li>Purus sodales ultricies</li>
            <li>Vestibulum laoreet porttitor sem</li>
            <li>Ac tristique libero volutpat at</li>
          </ul>
        </li>
        <li>Faucibus porta lacus fringilla vel</li>
        <li>Aenean sit amet erat nunc</li>
        <li>Eget porttitor lorem</li>
      </ul>
    </div>
    <div class="span3">
      <h4>Ordered</h4>
      <p><code>&lt;ol&gt;</code></p>
      <ol>
        <li>Lorem ipsum dolor sit amet</li>
        <li>Consectetur adipiscing elit</li>
        <li>Integer molestie lorem at massa</li>
        <li>Facilisis in pretium nisl aliquet</li>
        <li>Nulla volutpat aliquam velit</li>
        <li>Faucibus porta lacus fringilla vel</li>
        <li>Aenean sit amet erat nunc</li>
        <li>Eget porttitor lorem</li>
      </ol>
    </div>
    <div class="span3">
      <h4>Description</h4>
      <p><code>&lt;dl&gt;</code></p>
      <dl>
        <dt>Description lists</dt>
        <dd>A description list is perfect for defining terms.</dd>
        <dt>Euismod</dt>
        <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</dd>
        <dd>Donec id elit non mi porta gravida at eget metus.</dd>
        <dt>Malesuada porta</dt>
        <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
      </dl>
    </div>
  </div><!-- /row -->
</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\'
})
',
    ),
  ),
  'styleguide' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    _render: function() {
        var self = this;

        this._super(\'_render\');
    }
})
',
    ),
    'meta' => 
    array (
      'template_values' => 
      array (
        'last_updated' => '2013-05-06T22:47:00+00:00',
        'version' => '7.0.1',
      ),
    ),
    'templates' => 
    array (
      'styleguide' => '
<div class="page-header">
    <h1>Documentation <small>A guide to developing in Sugar7.</small></h1>
</div>

<section>
    <ul class="sg-main listed">
        <li><i class="fa fa-book fa-3x"></i><a href="#Styleguide/docs/index">Core Elements</a></li>
        <li><i class="fa fa-columns fa-3x"></i><a href="#Styleguide/layout/records">Default Module Layout</a></li>
        <li><i class="fa fa-bars fa-3x"></i><a href="#Styleguide/view/list">Default List View</a></li>
        {{! <li><i class="fa fa-list-alt fa-3x"></i><a href="#Styleguide/layout/record">Default Record Detail View</a></li> }}
        {{! <li><i class="fa fa-list-alt fa-3x"></i><a href="#Styleguide/layout/record-card2">Default Record Detail View (labels on left)</a></li> }}
        <li><i class="fa fa-plus fa-3x"></i><a href="#Styleguide/create">Default Record Create View</a></li>
        <li><i class="fa fa-list-alt fa-3x"></i><a href="#Styleguide/field/all">Example Sugar7 Fields</a></li>
        {{! <li><i class="fa fa-heart fa-3x"></i><a href="styleguide/tests/global.html">Styleguide Tests</a></li> }}
        <li><i class="fa fa-edit fa-3x"></i><a href="#Styleguide/docs/base-edit">Updating Documentation</a></li>
    </ul>
</section>
',
    ),
  ),
  'docs-components-popovers' => 
  array (
    'templates' => 
    array (
      'docs-components-popovers' => '
<!-- Popovers
================================================== -->
<section id="popovers">
  <div class="page-header">
    <h1>Popovers <small>bootstrap-popover.js</small></h1>
  </div>
  <div class="row-fluid">
    <div class="span3 columns">
      <h3>About popovers</h3>
      <p>Add small overlays of content, like those on the iPad, to any element for housing secondary information.</p>
      <p class="muted"><strong>*</strong> Requires <a href="#tooltip">Tooltip</a> to be included</p>
      <p>The bootsrap-popover.js plugin is included in the default build of SugarCRM.</p>
    </div>
    <div class="span9 columns">
      <h2>Example click popover</h2>
      <p>Hover over the button to trigger the popover.</p>
      <div class="well">
        <a href="javacript:void(0)" class="btn btn-danger" rel="popover" title="A Title" data-content="And here\'s some amazing content. It\'s very engaging. right?">click for popover</a>
      </div>
      <hr>
      <h2>Example hover popover</h2>
      <p>Hover over the button to trigger the popover.</p>
      <div class="well">
        <a class="btn btn-danger" rel="popoverHover" title="A Title" data-content="And here\'s some amazing content. It\'s very engaging. right?">hover for popover</a>
      </div>
      <hr>      <h2>Using bootstrap-popover.js</h2>
      <p>Enable popovers via javascript:</p>
      <pre class="prettyprint linenums">$(\'#example\').popover(options)</pre>
      <h3>Options</h3>
      <table class="table table-bordered table-striped">
        <thead>
         <tr>
           <th style="width: 100px;">Name</th>
           <th style="width: 100px;">type</th>
           <th style="width: 50px;">default</th>
           <th>description</th>
         </tr>
        </thead>
        <tbody>
         <tr>
           <td>animation</td>
           <td>boolean</td>
           <td>true</td>
           <td>apply a css fade transition to the tooltip</td>
         </tr>
         <tr>
           <td>placement</td>
           <td>string</td>
           <td>\'right\'</td>
           <td>how to position the popover - top | bottom | left | right</td>
         </tr>
         <tr>
           <td>selector</td>
           <td>string</td>
           <td>false</td>
           <td>if a selector is provided, tooltip objects will be delegated to the specified targets</td>
         </tr>
         <tr>
           <td>trigger</td>
           <td>string</td>
           <td>\'hover\'</td>
           <td>how tooltip is triggered - hover | focus | manual</td>
         </tr>
         <tr>
           <td>title</td>
           <td>string | function</td>
           <td>\'\'</td>
           <td>default title value if `title` attribute isn\'t present</td>
         </tr>
         <tr>
           <td>content</td>
           <td>string | function</td>
           <td>\'\'</td>
           <td>default content value if `data-content` attribute isn\'t present</td>
         </tr>
         <tr>
           <td>delay</td>
           <td>number | object</td>
           <td>0</td>
           <td>
            <p>delay showing and hiding the popover (ms)</p>
            <p>If a number is supplied, delay is applied to both hide/show</p>
            <p>Object structure is: <code>delay: { show: 500, hide: 100 }</code></p>
           </td>
         </tr>
        </tbody>
      </table>
      <div class="alert alert-info">
        <strong>Heads up!</strong>
        Options for individual popovers can alternatively be specified through the use of data attributes.
      </div>
      <h3>Markup</h3>
      <p>
      For performance reasons, the Tooltip and Popover data-apis are opt in. If you would like to use them just specify a the selector option.
      </p>
      <h3>Methods</h3>
      <h4>$().popover(options)</h4>
      <p>Initializes popovers for an element collection.</p>
      <h4>.popover(\'show\')</h4>
      <p>Reveals an elements popover.</p>
      <pre class="prettyprint linenums">$(\'#element\').popover(\'show\')</pre>
      <h4>.popover(\'hide\')</h4>
      <p>Hides an elements popover.</p>
      <pre class="prettyprint linenums">$(\'#element\').popover(\'hide\')</pre>
      <h4>.popover(\'toggle\')</h4>
      <p>Toggles an elements popover.</p>
      <pre class="prettyprint linenums">$(\'#element\').popover(\'toggle\')</pre>
    </div>
  </div>
</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // components popovers
    _renderHtml: function () {
        this._super(\'_renderHtml\');

        this.$(\'[rel=popover]\').popover();
        this.$(\'[rel=popoverHover]\').popover({trigger: \'hover\'});
        this.$(\'[rel=popoverTop]\').popover({placement: \'top\'});
        this.$(\'[rel=popoverBottom]\').popover({placement: \'bottom\'});
    }
})
',
    ),
  ),
  'docs-charts-implementation' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\'
})
',
    ),
    'templates' => 
    array (
      'docs-charts-implementation' => '
    <section id="implementation">

      <div class="page-header">
        <h2>Chart Implementation <small>Patterns for inserting and configuring charts.</small></h2>
      </div>

      <div class="row-fluid">

        <div class="span7">
          <h3>Simple Chart Instance</h3>
          <p>Creating new chart using default parameters and setting data model.</p>
<pre class="prettyprint linenums">
  &lt;div id="chart1"&gt;
    &lt;svg>&lt;/svg&gt;
  &lt;/div&gt;
  var chart = nv.models.multiBarChart();

  d3.select(\'#chart1 svg\')
    .datum(forecast_data_Q1)
    .transition().duration(500).call(chart);
</pre>

          <h3>Overriding Base Event Handlers</h3>
          <p>Default chart handlers (if defined in chart class) can be overridden by passing a function on instantiation.</p>
<pre class="prettyprint linenums">
  var chart = nv.models.multiBarChart()
                .barClick( function(data,e,selection) {
                    d3.select(\'#chart1 svg\')
                      .datum(forecast_data_Q2)
                      .transition().duration(500).call(chart);
                  }
                );
</pre>

          <h3>Setting Parameters</h3>
          <p>Chart parameters can be set by calling public getter/setter functions.</p>

<pre class="prettyprint linenums">
  var chart = nv.models.multiBarChart()
                .x(function(d) { return d.label })
                .y(function(d) { return d.value })
                .margin({top: 0, right: 0, bottom: 15, left: 90})
                .showValues(true)
                .tooltips(true)
                .showControls(false);
</pre>

          <h3>Instantiating Chart</h3>
          <p>A chart can be instantiated with generate and callback functions using NVD3 addGraph function.</p>
<pre class="prettyprint linenums">
    nv.addGraph({
      generate: function() {
          var chart = nv.models.multiBarChart();

          d3.select(\'#chart1 svg\')
            .datum(forecast_data_Q1)
            .transition().duration(500).call(chart);

          nv.utils.windowResize(chart.update);

          return chart;
      },
      callback: function(graph) {
        $(\'#log\').text(\'Chart is loaded\');
      }
    });
</pre>
        </div> <!-- end col -->


        <div class="span5">

          <h3>Standard Parameters</h3>
          <p>This is a set of common chart parameters.</p>
          <div>
<table class="table table-bordered table-striped">
  <thead>
   <tr>
     <th style="width: 100px;">Name</th>
     <th style="width: 50px;">type</th>
     <th style="width: 50px;">default</th>
     <th>description</th>
   </tr>
  </thead>
  <tbody>
   <tr>
     <td>margin</td>
     <td>map</td>
     <td>varies</td>
     <td><code>{top: 20, right: 10, bottom: 40, left: 40}</code></td>
   </tr>
   <tr>
     <td>width | height</td>
     <td>numeric</td>
     <td>null</td>
     <td>set fixed width; null sets chart to expand to containing div</td>
   </tr>
   <tr>
     <td>getX | getY</td>
     <td>function</td>
     <td><code>function(d) { return d.x }</code></td>
     <td>how to get to the x,y property in the datum</td>
   </tr>
   <tr>
     <td>color</td>
     <td>function</td>
     <td><code>nv.utils.defaultColor()</code></td>
     <td>call to function to return color map</td>
   </tr>
   <tr>
     <td>showControls</td>
     <td>boolean</td>
     <td>false</td>
     <td>show chart controls if any</td>
   </tr>
   <tr>
     <td>showLegend</td>
     <td>boolean</td>
     <td>true</td>
     <td>show chart legend</td>
   </tr>
   <tr>
     <td>reduceXTicks | reduceYTicks</td>
     <td>boolean</td>
     <td>true</td>
     <td>if false a tick will show for every data point</td>
   </tr>
   <tr>
     <td>rotateLabels</td>
     <td>boolean</td>
     <td>false</td>
     <td>angle to rotate axis labels</td>
   </tr>
   <tr>
     <td>tooltips</td>
     <td>boolean</td>
     <td>true</td>
     <td>show tooltips over charting elements</td>
   </tr>
   <tr>
     <td>tooltip</td>
     <td>function</td>
     <td><code><pre>function(key, x, y, e, graph) {
  return \'&lt;h3&gt;\' + key + \' - \' + x + \'&lt;/h3&gt;\' + \'&lt;p&gt;\' +  y + \'&lt;/p&gt;\'
}</pre></code></td>
     <td>function that returns an html formated string</td>
   </tr>
   <tr>
     <td>strings</td>
     <td>map</td>
     <td><code><pre>{
  legend: {close: \'Hide legend\', open: \'Show legend\'},
  controls: {close: \'Hide controls\', open: \'Show controls\'},
  noData: \'No Data Available.\'
}</pre></code></td>
     <td>message to display when no data is available</td>
   </tr>
   <tr>
     <td>hideEmptyGroups</td>
     <td>boolean</td>
     <td>true</td>
     <td>collapse multibar group when group total is zero</td>
   </tr>
  </tbody>
</table>
          </div>
        </div> <!-- end col -->

      </div> <!-- end row -->

      <div class="row-fluid">
        <div class="span12">

          <h3>Binding Chart Data with Backbone</h3>
          <p>A chart can be bound to a common data model using Backbone.</p>
<pre class="prettyprint linenums">
  var Chart = Backbone.Model.extend({});
  var Charts = Backbone.Collection.extend({ model: Chart });
  charts = new Charts();
  charts.reset(forecast_data_Q1);

  // The chart view controls the single svg element on the screen
  var ChartsView = Backbone.View.extend({

    initialize: function() {
      // bind to model change events and use enter() to modify the appropriate circle
      var self = this;

      self.collection.bind(
        \'reset\',
        function(model)
        {
          d3.select(self.el)
            .datum( model.models.map( function(d,i){return d.attributes} ) )
            .transition().duration(500).call(self.chart);
        }
      );
    },

    render: function() {
      this.$el.empty();

      this.chart = nv.models.multiBarChart();

      d3.select(this.el)
        .datum( this.collection.models.map( function(d,i){return d.attributes} ) )
        .transition().duration(500).call(this.chart);

      nv.utils.windowResize(this.chart.update);

      return this;
    }

  });

  var chartsView = new ChartsView({ el: $(\'#chart1 svg\'), collection: charts });
  chartsView.render();

  setTimeout(function() { charts.reset( forecast_data_Q2 ); },3000);
</pre>

        </div>
      </div>
    </section>
',
    ),
  ),
  'docs-components-dropdowns' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // components dropdowns
    _renderHtml: function () {
        this._super(\'_renderHtml\');

        this.$(\'#mm001demo *\').on(\'click.styleguide\', function(){ /* make this menu frozen in its state */
            return false;
        });

        this.$(\'*\').on(\'click.styleguide\', function(){
            /* not sure how to override default menu behaviour, catching any click, becuase any click removes class `open` from li.open div.btn-group */
            setTimeout(function(){
                this.$(\'#mm001demo\').find(\'li.open .btn-group\').addClass(\'open\');
            },0.1);
        });
    },

    _dispose: function() {
        this.$(\'#mm001demo *\').off(\'click.styleguide\');

        this._super(\'_dispose\');
    }
})
',
    ),
    'templates' => 
    array (
      'docs-components-dropdowns' => '
<!-- Dropdown
================================================== -->
<section id="dropdowns">
  <div class="page-header">
    <h2>Dropdowns <small>bootstrap-dropdown.js (v.3.0.0)</small></h2>
  </div>

  <div class="row-fluid">
    <div class="span3 columns">
      <h3>About dropdowns</h3>
      <p>Add dropdown menus to nearly anything with this simple plugin. Features full dropdown menu support on in the navbar, tabs, and pills.</p>
      <p>The bootsrap-dropdown.js plugin is included in the default build of SugarCRM.</p>

    </div>
    <div class="span9 columns">
      <h2>Standart menu (OEM Twitter Bootstrap)</h2>
      <p>Click on the dropdown nav links in the navbar and pills below to test dropdowns.</p>
      <div id="navbar-example" class="navbar navbar-static">
        <div class="navbar-inner">
          <div class="container" style="width: auto;">
            <a class="brand">Project Name</a>
            <ul class="nav">
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">Dropdown <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                  <li><a>Action</a></li>
                  <li><a>Another action</a></li>
                  <li><a>Something else here</a></li>
                  <li class="divider"></li>
                  <li><a>Separated link</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">Dropdown 2 <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                  <li><a>Action</a></li>
                  <li><a>Another action</a></li>
                  <li><a>Something else here</a></li>
                  <li class="divider"></li>
                  <li><a>Separated link</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav pull-right">
              <li id="fat-menu" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">Dropdown 3 <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                  <li><a>Action</a></li>
                  <li><a>Another action</a></li>
                  <li><a>Something else here</a></li>
                  <li class="divider"></li>
                  <li><a>Separated link</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div> <!-- /navbar-example -->

      <ul class="nav nav-pills">
        <li class="active"><a>Regular link</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown">Dropdown <i class="fa fa-caret-down"></i></a>
          <ul id="menu1" class="dropdown-menu">
            <li><a>Action</a></li>
            <li><a>Another action</a></li>
            <li><a>Something else here</a></li>
            <li class="divider"></li>
            <li><a>Separated link</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown">Dropdown 2 <i class="fa fa-caret-down"></i></a>
          <ul id="menu2" class="dropdown-menu">
            <li><a>Action</a></li>
            <li><a>Another action</a></li>
            <li><a>Something else here</a></li>
            <li class="divider"></li>
            <li><a>Separated link</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown">Dropdown 3 <i class="fa fa-caret-down"></i></a>
          <ul id="menu3" class="dropdown-menu">
            <li><a>Action</a></li>
            <li><a>Another action</a></li>
            <li><a>Something else here</a></li>
            <li class="divider"></li>
            <li><a>Separated link</a></li>
          </ul>
        </li>
      </ul> <!-- /tabs -->

      <hr>

      <h2>Using bootstrap-dropdown.js</h2>

      <h3>Markup</h3>
      <p>To quickly add dropdown functionality to any element just add <code>data-toggle="dropdown"</code> and any valid dropdown will automatically be activated.</p>

<pre class="prettyprint linenums">
&lt;ul class="nav pills"&gt;
  &lt;li class="active"&gt;&lt;a&gt;Regular link&lt;/a&gt;&lt;/li&gt;
  &lt;li class="dropdown" id="menu1"&gt;
    &lt;a class="dropdown-toggle" data-toggle="dropdown" href="#menu1"&gt;
      Dropdown
      &lt;i class="fa fa-caret-down"&gt;&lt;/i&gt;
    &lt;/a&gt;
    &lt;ul class="dropdown-menu"&gt;
      &lt;li&gt;&lt;a&gt;Action&lt;/a&gt;&lt;/li&gt;
      &lt;li&gt;&lt;a&gt;Another action&lt;/a&gt;&lt;/li&gt;
      &lt;li&gt;&lt;a&gt;Something else here&lt;/a&gt;&lt;/li&gt;
      &lt;li class="divider"&gt;&lt;/li&gt;
      &lt;li&gt;&lt;a&gt;Separated link&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
  &lt;/li&gt;
  ...
&lt;/ul&gt;
</pre>

      <h3>Methods</h3>
      <h4>$().dropdown()</h4>
      <p>In situations where you want to programatically call the dropdowns via javascript then use:</p>
      <pre class="prettyprint linenums">$(\'.dropdown-toggle\').dropdown()</pre>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span9 offset3 columns">
      <h3>Megamenus (Sugar7 customization)</h3>
      <p>The top navbar in SugarCRM uses a custom dropdown menu called "Megamenu". This dropdown menu has many custom features not found in the Bootstrap version.</p>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span9 offset3 columns">
      <h3>Associated Files</h3>

      <table class="table table-bordered table-striped">
        <tbody>
          <tr><td>JS file:</td><td>include / javascript / twitterbootstrap / bootstrap-dropdown.js</td></tr>
          <tr><td>LESS files</td><td>styleguide / less / sugar-specific / dropdowns.less</td></tr>
        </tbody>
      </table>
    </div>
  </div>

</section>
',
    ),
  ),
  'docs-base-grid' => 
  array (
    'templates' => 
    array (
      'docs-base-grid' => '
<section id="grid-system">
  <div class="page-header">
    <h1>Grid system <small>12 columns with a responsive twist</small></h1>
  </div>
  <h2>Default 940px grid</h2>
  <div class="row-fluid show-grid">
    <div class="span1">1</div>
    <div class="span1">1</div>
    <div class="span1">1</div>
    <div class="span1">1</div>
    <div class="span1">1</div>
    <div class="span1">1</div>
    <div class="span1">1</div>
    <div class="span1">1</div>
    <div class="span1">1</div>
    <div class="span1">1</div>
    <div class="span1">1</div>
    <div class="span1">1</div>
  </div>
  <div class="row-fluid show-grid">
    <div class="span4">4</div>
    <div class="span4">4</div>
    <div class="span4">4</div>
  </div>
  <div class="row-fluid show-grid">
    <div class="span4">4</div>
    <div class="span8">8</div>
  </div>
  <div class="row-fluid show-grid">
    <div class="span6">6</div>
    <div class="span6">6</div>
  </div>
  <div class="row-fluid show-grid">
    <div class="span12">12</div>
  </div>
  <div class="row-fluid">
    <div class="span4">
      <p>The default grid system provided is a <strong>940px-wide, 12-column grid</strong>.</p>
      <p>It also has four responsive variations for various devices and resolutions: phone, tablet portrait, table landscape and small desktops, and large widescreen desktops.</p>
    </div>
    <div class="span4">
<pre class="prettyprint linenums">
&lt;div class="row"&gt;
  &lt;div class="span4"&gt;...&lt;/div&gt;
  &lt;div class="span8"&gt;...&lt;/div&gt;
&lt;/div&gt;
</pre>
    </div>
    <div class="span4">
      <p>As shown here, a basic layout can be created with two "columns," each spanning a number of the 12 foundational columns we defined as part of our grid system.</p>
    </div>
  </div>

  <br>

  <h2>Offsetting columns</h2>
  <div class="row-fluid show-grid">
    <div class="span4">4</div>
    <div class="span4 offset4">4 offset 4</div>
  </div>
  <div class="row-fluid show-grid">
    <div class="span3 offset3">3 offset 3</div>
    <div class="span3 offset3">3 offset 3</div>
  </div>
  <div class="row-fluid show-grid">
    <div class="span8 offset4">8 offset 4</div>
  </div>
<pre class="prettyprint linenums">
&lt;div class="row"&gt;
  &lt;div class="span4"&gt;...&lt;/div&gt;
  &lt;div class="span4 offset4"&gt;...&lt;/div&gt;
&lt;/div&gt;
</pre>

  <br>

  <h2>Nesting columns</h2>
  <div class="row-fluid">
    <div class="span6">
      <p>With the static (non-fluid) grid system, nesting is easy. To nest your content, just add a new <code>.row</code> and set of <code>.span*</code> columns within an existing <code>.span*</code> column.</p>
      <h4>Example</h4>
      <div class="row-fluid show-grid">
        <div class="span6">
         vel 1 of column
          <div class="row-fluid show-grid">
            <div class="span3">
             vel 2
            </div>
            <div class="span3">
             vel 2
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="span6">
<pre class="prettyprint linenums">
&lt;div class="row"&gt;
  &lt;div class="span12"&gt;
    Level 1 of column
    &lt;div class="row"&gt;
      &lt;div class="span6"&gt;Level 2&lt;/div&gt;
      &lt;div class="span6"&gt;Level 2&lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
</pre>
    </div>
  </div>

  <h2>Grid customization</h2>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Variable</th>
        <th>Default value</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><code>@gridColumns</code></td>
        <td>12</td>
        <td>Number of columns</td>
      </tr>
      <tr>
        <td><code>@gridColumnWidth</code></td>
        <td>60px</td>
        <td>Width of each column</td>
      </tr>
      <tr>
        <td><code>@gridGutterWidth</code></td>
        <td>20px</td>
        <td>Negative space between columns</td>
      </tr>
      <tr>
        <td><code>@siteWidth</code></td>
        <td><em>Computed sum of all columns and gutters</em></td>
        <td>Counts number of columns and gutters to set width of the <code>.container-fixed()</code> mixin</td>
      </tr>
    </tbody>
  </table>
  <div class="row-fluid">
    <div class="span4">
      <h3>Variables in LESS</h3>
      <p>Built in are a handful of variables for customizing the default 940px grid system, documented above. All variables for the grid are stored in variables.less.</p>
    </div>
    <div class="span4">
      <h3>How to customize</h3>
      <p>Modifying the grid means changing the three <code>@grid*</code> variables and recompiling. Change the grid variables in variables.less and use one of the <a href="#compiling">four ways documented to recompile</a>. If you\'re adding more columns, be sure to add the CSS for those in grid.less.</p>
    </div>
    <div class="span4">
      <h3>Staying responsive</h3>
      <p>Customization of the grid only works at the default level, the 940px grid. To maintain the responsive aspects, you\'ll also have to customize the grids in responsive.less.</p>
    </div>
  </div>

</section>

<section id="layouts">
  <div class="page-header">
    <h1>Layouts <small>Basic templates to create webpages</small></h1>
  </div>

  <div class="row-fluid">
    <div class="span6">
      <h2>Fixed layout</h2>
      <p>The default and simple 940px-wide, centered layout for just about any website or page provided by a single <code>&lt;div class="container"&gt;</code>.</p>
      <div class="minicon-layout">
        <div class="minicon-layout-body"></div>
      </div>
<pre class="prettyprint linenums">
&lt;body&gt;
  &lt;div class="container"&gt;
    ...
  &lt;/div&gt;
&lt;/body&gt;
</pre>
  </div><!-- /col -->
  <div class="span6">
    <h2>Fluid layout</h2>
    <p><code>&lt;div class="container-fluid"&gt;</code> gives flexible page structure, min- and max-widths, and a left-hand sidebar. It\'s great for apps and docs.</p>
    <div class="minicon-layout fluid">
      <div class="minicon-layout-sidebar"></div>
      <div class="minicon-layout-body"></div>
    </div>
<pre class="prettyprint linenums">
&lt;div class="container-fluid"&gt;
  &lt;div class="row-fluid"&gt;
    &lt;div class="span2"&gt;
      &lt;!--Sidebar content--&gt;
    &lt;/div&gt;
    &lt;div class="span10"&gt;
      &lt;!--Body content--&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
</pre>
    </div><!-- /col -->
  </div>
</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\'
})
',
    ),
  ),
  'docs-index' => 
  array (
    'templates' => 
    array (
      'docs-index' => '
{{#index_search}}
<form class="filterform" action="#">
  <div class="row-fluid section-search">
    <div class="btn-toolbar span4 offset4">
      <div class="btn-group">
        <input type="text" name="section_search" class="filterinput" value="" placeholder="Find any pattern&hellip;">
        <a class="btn" href="#"><i class="fa fa-search"></i></a>
      </div>
    </div>
  </div>
</form>
{{/index_search}}

<section id="index">
    <div class="page-header">
        <p class="lead">{{{section_description}}}</p>
    </div>
    <div id="index_content"></div>
</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',
    section_description: \'\',
    section_key: \'\',

    /* RENDER index page
    *******************/
    _renderHtml: function() {
        var self = this,
            i = 0,
            html = \'\',
            request = this.context.attributes.request;

        this._super(\'_renderHtml\');

        this.section_key = request.keys[1];

        function fmtLink(s, p) {
            return \'#Styleguide/docs/\' +
                (p ? \'\' : \'index-\') +
                s.replace(/[\\s\\,]+/g,\'-\').toLowerCase() +
                (p ? \'-\' + p : \'\');
        }

        if (request.keys.length === 1) {

            // home index call
            $.each(request.page_data, function (kS, vS) {
                if (!vS.index) {
                    return;
                }

                html += (i % 3 === 0 ? \'<div class="row-fluid">\' : \'\');
                html += \'<div class="span4"><h3>\' +
                    \'<a class="section-link" href="\' +
                    (vS.url ? vS.url : fmtLink(kS)) + \'">\' +
                    vS.title + \'</a></h3><p>\' + vS.description + \'</p><ul>\';
                if (vS.pages) {
                    $.each(vS.pages, function (kP, vP) {
                        html += \'<li ><a class="section-link" href="\' +
                            (vP.url ? vP.url : fmtLink(kS, kP)) + \'">\' +
                            vP.label + \'</a></li>\';
                    });
                }
                html += \'</ul></div>\';
                html += (i % 3 === 2 ? \'</div>\' : \'\');

                i += 1;
            });

            this.section_description = request.page_data[request.keys[0]].description;

        } else {

            // section index call
            $.each(request.page_data[this.section_key].pages, function (kP, vP) {
                html += (i % 4 === 0 ? \'<div class="row-fluid">\' : \'\');
                html += \'<div class="span3"><h3>\' +
                    (!vP.items ?
                        (\'<a class="section-link" href="\' + (vP.url ? vP.url : fmtLink(self.section_key, kP)) + \'">\' + vP.label + \'</a>\') :
                        vP.label
                    ) +
                    \'</h3><p>\' + vP.description;
                // if (vS.items) {
                //     l = vS.items.length-1;
                //     $.each(d.items, function (kP,vP) {
                //         m += \' <a class="section-link" href="\'+ (vP.url ? vP.url : fmtLink(kS,kP)) +\'">\'+ d2 +\'</a>\'+ (j===l?\'.\':\', \');
                //     });
                // }
                html += \'</p></div>\';
                html += (i % 4 === 3 ? \'</div>\' : \'\');

                i += 1;
            });

            this.section_description = request.page_data[request.keys[1]].description;
        }

        this.$(\'#index_content\').append(\'<section id="section-menu"></section>\').html(html);
    }
})
',
    ),
  ),
  'docs-layouts-navbar' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\'
})
',
    ),
    'templates' => 
    array (
      'docs-layouts-navbar' => '
<!-- Navbar
================================================== -->
<section id="navbar">
  <div class="page-header">
    <h1>Navbar</h1>
  </div>
  <h2>Static navbar example</h2>
  <p>An example of a static (not fixed to the top) navbar with project name, navigation, and search form.</p>
  <div class="navbar">
    <div class="navbar-inner">
      <div class="container" style="width: auto;">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="fa fa-bar"></span>
          <span class="fa fa-bar"></span>
          <span class="fa fa-bar"></span>
        </a>
        <a class="brand">Project name</a>
        <div class="nav-collapse">
          <ul class="nav">
            <li class="active"><a>Home</a></li>
            <li><a>Link</a></li>
            <li><a>Link</a></li>
            <li><a>Link</a></li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown">Dropdown <i class="fa fa-caret-down"></i></a>
              <ul class="dropdown-menu">
                <li><a>Action</a></li>
                <li><a>Another action</a></li>
                <li><a>Something else here</a></li>
                <li class="divider"></li>
                <li><a>Separated link</a></li>
              </ul>
            </li>
          </ul>
          <form class="navbar-search pull-left" action="">
            <input type="text" class="search-query span2" placeholder="Search">
          </form>
          <ul class="nav pull-right">
            <li><a>Link</a></li>
            <li class="divider-vertical"></li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown">Dropdown <i class="fa fa-caret-down"></i></a>
              <ul class="dropdown-menu">
                <li><a>Action</a></li>
                <li><a>Another action</a></li>
                <li><a>Something else here</a></li>
                <li class="divider"></li>
                <li><a>Separated link</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div>
    </div><!-- /navbar-inner -->
  </div><!-- /navbar -->

  <div class="row-fluid">
    <div class="span8">
      <h3>Navbar scaffolding</h3>
      <p>The navbar requires only a few divs to structure it well for static or fixed display.</p>
<pre class="prettyprint linenums">
&lt;div class="navbar"&gt;
  &lt;div class="navbar-inner"&gt;
    &lt;div class="container"&gt;
      ...
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
</pre>
      <p>To make the navbar fixed to the top of the viewport, add <code>.navbar-fixed-top</code> to the outermost div, <code>.navbar</code>. In your CSS, you will also need to account for the overlap it causes by adding <code>padding-top: 40px;</code> to your <code>&lt;body&gt;</code>.</p>
<pre class="prettyprint linenums">
&lt;div class="navbar navbar-fixed-top"&gt;
  ...
&lt;/div&gt;
</pre>
      <h3>Brand name</h3>
      <p>A simple link to show your brand or project name only requires an anchor tag.</p>
<pre class="prettyprint linenums">
&lt;a class="brand"&gt;
  Project name
&lt;/a&gt;
</pre>
      <h3>Search form</h3>
      <p>Search forms receive custom styles in the navbar with the <code>.navbar-search</code> class. Include <code>.pull-left</code> or <code>.pull-right</code> on the <code>form</code> to align it.</p>
<pre class="prettyprint linenums">
&lt;form class="navbar-search pull-left"&gt;
  &lt;input type="text" class="search-query" placeholder="Search"&gt;
&lt;/form&gt;
</pre>
      <h3>Optional responsive variation</h3>
      <p>Depending on the amount of content in your topbar, you might want to implement the responsive options. To do so, wrap your nav content in a containing div, <code>.nav-collapse.collapse</code>, and add the navbar toggle button, <code>.btn-navbar</code>.</p>
<pre class="prettyprint linenums">
&lt;div class="navbar"&gt;
  &lt;div class="navbar-inner"&gt;
    &lt;div class="container"&gt;

      &lt;!-- .btn-navbar is used as the toggle for collapsed navbar content --&gt;
      &lt;a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"&gt;
        &lt;span class="fa fa-bar"&gt;&lt;/span&gt;
        &lt;span class="fa fa-bar"&gt;&lt;/span&gt;
        &lt;span class="fa fa-bar"&gt;&lt;/span&gt;
      &lt;/a&gt;

      &lt;!-- Be sure to leave the brand out there if you want it shown --&gt;
      &lt;a class="brand"&gt;Project name&lt;/a&gt;

      &lt;!-- Everything you want hidden at 940px or less, place within here --&gt;
      &lt;div class="nav-collapse"&gt;
        &lt;!-- .nav, .navbar-search, .navbar-form, etc --&gt;
      &lt;/div&gt;

    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
</pre>
      <div class="alert alert-info">
        <strong>Heads up!</strong> The responsive navbar requires the <a href="widgets.html#collapse">collapse plugin</a>.
      </div>

    </div><!-- /.span -->
    <div class="span4">
      <h3>Nav links</h3>
      <p>Nav items are simple to add via unordered lists.</p>
<pre class="prettyprint linenums">
&lt;ul class="nav"&gt;
  &lt;li class="active"&gt;
    &lt;a>Home&lt;/a&gt;
  &lt;/li&gt;
  &lt;li&gt;&lt;a&gt;Link&lt;/a&gt;&lt;/li&gt;
  &lt;li&gt;&lt;a&gt;Link&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;
</pre>
      <h3>Adding dropdowns</h3>
      <p>Adding dropdowns to the nav is super simple, but does require the use of <a href="widgets.html#dropdown">our javascript plugin</a>.</p>
<pre class="prettyprint linenums">
&lt;ul class="nav"&gt;
  &lt;li class="dropdown"&gt;
    &lt;a
          class="dropdown-toggle"
          data-toggle="dropdown">
          Account
          &lt;i class="fa fa-caret-down"&gt;&lt;/i&gt;
    &lt;/a&gt;
    &lt;ul class="dropdown-menu"&gt;
      ...
    &lt;/ul&gt;
  &lt;/li&gt;
&lt;/ul&gt;
</pre>
      <p><a class="btn" href="widgets.html#dropdown">Get the javascript &rarr;</a></p>
    </div><!-- /.span -->
  </div><!-- /.row -->

</section>
',
    ),
  ),
  'docs-components-alerts' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // components dropdowns
    _renderHtml: function () {
        this._super(\'_renderHtml\');

        this.$(\'[data-alert]\').on(\'click\', function() {

            var $button = $(this),
                level = $button.data(\'alert\'),
                state = $button.text(),
                auto_close = [\'info\',\'success\'].indexOf(level) > -1;

            app.alert.dismiss(\'core_meltdown_\' + level);

            if (state !== \'Example\') {
                $button.text(\'Example\');
            } else {
                app.alert.show(\'core_meltdown_\' + level, {
                    level: level,
                    messages: \'The core is in meltdown!!\',
                    autoClose: auto_close,
                    onClose: function () {
                        $button.text(\'Example\');
                    }
                });
                $button.text(\'Dismiss\');
            }
        });
    },

    _dispose: function() {
        this.$(\'[data-alert]\').off(\'click\');
        app.alert.dismissAll();

        this._super(\'_dispose\');
    }
})
',
    ),
    'templates' => 
    array (
      'docs-components-alerts' => '
<!-- Alerts & Messages
================================================== -->
{{!https://docs.google.com/a/sugarcrm.com/document/d/14FG1OkNNj05ULv6CnWJZckwxinT_VYiN0m_z4-lwOPM}}
<section id="alerts">
  <div class="page-header">
    <h1>Alerts <small>Styles for success, warning, and error messages</small></h1>
  </div>

  <div class="row-fluid">
    <div class="span4">
      <h2>About</h2>

      <h3>UX Rationale</h3>
      <p>Alerts notify users to a specific action, status of application service or services, state or dependency to service. Consistency is the goal so that the user has a clear expectation around both position, understanding and behavior with little extra effort spent to identify the action or disruption to normal flow. Screen placement, typography, time on screen and interaction to close are all considered.</p>
      <p>The placement of messages and alerts should be designed to not interfere with a normal user flow or interaction. Consideration was given to a growl type status but it has the potential to cover UI navigational elements. Any action or notification will typically give a user pause and take seconds or ms to digest so familiarity with the pattern and treatment will speed up that recognition.</p>

      <h3>Firing and Dismissing</h3>
      <p>Alerts can be fired anywhere in Sugar7 by calling <code>app.alert.show(\'alert_id\', {params})</code>. See below for parameters.</p>
      <p>The alert id should be unique to the particular alert condition. Alerts can be called with the autoclose option which sets the alert to close after 10 seconds. The default autoclose behaviour is displayed in the table below. Be sure to call <code>app.alert.dismiss(\'alert_id\')</code> in your view dispose methods.</p>

      <h3>Contextual Alerts</h3>
      <p>The alert utility supports various alert levels that correspond to the severity of your message. See information below on how to adjust styling of these alert levels.</p>
      <p>There are two special purpose alert types&mdash;Process and Modal Dialog. <b>Process</b> is generally not used by developers, it is called by Sugar7 to alert the user that data is loading from the API. <b>Modal Dialog</b>, should be used when the user needs to select an option before proceeding. Dialogues always have the same two buttons, “Cancel” and “Confirm” and stays and locks the user’s interactions until one of the two buttons is pressed. Messages should be worded to make the choice between “Cancel”/”Confirm” clear and concise.</p>
    </div>

    <div class="span8">
      <h2>Styles</h2>

      <p>Alert messages are added to the <code>&lt;div id="alerts"&gt;</code> block at the top of a Sugar7 layout and are stacked in reverse order. The LESS file with default colors and styling can be found in <code>stylguide/less/sugar-specific/alerts.less</code> and <code>stylguide/less/sugar-specific/loader.less</code>.</p>
      <div class="alert alert-block">
        <button class="close" data-action="close"><i class="fa fa-times"></i></button>
        <strong>Alert Level:</strong> This is the alert message!!
      </div>
<pre class="prettyprint linenums">
&lt;div class="alert alert-[level] alert-block"&gt;
  &lt;button class="close" data-action="close"&gt;&lt;i class="fa fa-times"&gt;&lt;/i&gt;&lt;/button&gt;
  &lt;strong&gt;Alert Level:&lt;/strong&gt; This is the alert message!!
&lt;/div&gt;
</pre>

      <h3>Content</h3>
      <p>Content of the alert can be any HTML however there is a special class called <code>.alert-heading</code> for a matching heading.</p>
      <div class="alert alert-block">
        <button class="close" data-action="close"><i class="fa fa-times"></i></button>
        <h4 class="alert-heading">Alert!</h4>
        <p>Best check yo self, you\'re not looking too good. Nulla vitae elit libero, a pharetra augue. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</p>
      </div>
<pre class="prettyprint linenums">
&lt;div class="alert alert-block"&gt;
  &lt;button class="close" data-action="close"&gt;&lt;i class="fa fa-times"&gt;&lt;/i&gt;&lt;/button&gt;
  &lt;h4 class="alert-heading"&gt;Alert!&lt;/h4&gt;
  &lt;p&gt;Best check yo self, you\'re not...&lt;/p&gt;
&lt;/div&gt;
</pre>

      <h3>Sugar7 Alert Utility</h3>
      <p>To make handling of alerts easier in Sugar7, there is now a utility function called <code>app.alert</code>. This function is based on Bootstrap\'s <code>bootstrap-alert.js</code> plugin. Although you should never need to access the Boostrap plugin directly, its documentation can be found here <a href=""><i class="fa fa-book"></i> boostrap-alert.js</a>.</p>

      <h3>Parameters</h3>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Parameter</th><th>Use</th><th>Example</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>level</td>
            <td>Pass the alert contextual level.</td>
            <td><code>{level: \'warning\'}</td>
          </tr>
          <tr>
            <td>messages</td>
            <td>The text of the message which can include links and other tags. Length of text should be kept to a maximum of 130 characters including spaces.</td>
            <td><code>{messages: \'This is your last warning.\'}</td>
          </tr>
          <tr>
            <td>autoClose</td>
            <td>Whether or not to autoclose the alert.</td>
            <td><code>{autoClose: true | false}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <h2>Details</h2>

      <div class="overflow" style="width:100%;overflow:scroll">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Level</th><th>CSS Class</th><th>Variables</th><th>Style</th><th>Timing</th><th style="width:60px;">Example</th>
          </tr>
        </thead>
        <tbody>

          <tr>
            <td>info</td>
            <td><code>.alert-info</code></td>
            <td>
<code>color: darken(@infoBackground, 70%);</code><br>
<code>background-color: @infoBackground;</code><br>
<code>border-color: @infoBorder;</code>
            </td>
            <td>
              <div class="alert alert-info alert-block" style="margin:0;">
                <b>Notice:</b> General information not covered below.
              </div>
            </td>
            <td>auto close (10s)</td>
            <td>
              <button data-alert="info">Example</button>
            </td>
          </tr>

          <tr>
            <td>success</td>
            <td><code>.alert-success</code></td>
            <td>
<code>color: darken(@successBackground, 70%);</code><br>
<code>background-color: @successBackground;</code><br>
<code>border-color: @successBorder;</code>
            </td>
            <td>
              <div class="alert alert-success alert-block" style="margin:0;">
                <b>Success:</b> Typically should occur as a result of a specific action by the user.
              </div>
            </td>
            <td>auto close (10s)</td>
            <td>
              <button data-alert="success">Example</button>
            </td>
          </tr>

          <tr>
            <td>warning</td>
            <td><code>.alert-warning</code></td>
            <td>
<code>color: @gray;</code><br>
<code>border: 1px solid @warningBorder;</code><br>
<code>background-color: @warningBackground;</code><br>
            </td>
            <td>
              <div class="alert alert-warning alert-block" style="margin:0;">
                <b>Warning:</b> Warnings can also be used as an indication of service disruption if the service is not dependent for the actual functioning of the app.
              </div>
            </td>
            <td>sustained until user action</td>
            <td>
              <button data-alert="warning">Example</button>
            </td>
          </tr>

          <tr>
            <td>error</td>
            <td><code>.alert-danger</code></td>
            <td>
<code>color: darken(@red, 10%);</code><br>
<code>background: @errorBackground;</code><br>
<code>border-color: @errorBorder;</code>
            </td>
            <td>
              <div class="alert alert-danger alert-block" style="margin:0;">
                <b>Error:</b> Typically the error is only used to define an error in input or disruption of a key service.
              </div>
            </td>
            <td>sustained until user closes</td>
            <td>
              <button data-alert="error">Example</button>
            </td>
          </tr>

          <tr>
            <td>process</td>
            <td><code>.alert-process</code></td>
            <td>
<code>color: @grayLight;</code><br>
<code>background-color: @grayLighter;</code><br>
<code>border: 1px solid @grayLight;</code>
            </td>
            <td>
              <div class="alert-top" style="position:relative;top:0;height:auto;">
                <div class="alert alert-process" style="margin:0;">
                  <strong>Loading</strong>
                  <div class="loading">
                    <i class="fa fa-circle l1"></i><i class="fa fa-circle l2"></i><i class="fa fa-circle l3"></i>
                  </div>
                </div>
              </div>
            </td>
            <td>immediately closes upon process completion</td>
            <td>
              <button data-alert="process">Example</button>
            </td>
          </tr>

          <tr>
            <td>confirmation</td>
            <td><code>.alert-warning</code></td>
            <td>
<code>Same as warning.</code>
            </td>
            <td>
              <div class="alert-confirmation" style="position:relative;top:0;">
                <div class="alert alert-warning alert-block" style="margin:0;">
                  <strong>Warning</strong>
                  <div class="alert-messages">Is the core is in meltdown?</div>
                  <div class="row-fluid">
                    <a class="span6 alert-btn-cancel" data-action="cancel">Cancel</a>
                    <a class="span6 alert-btn-confirm" data-action="confirm">Confirm</a>
                  </div>
                </div>
              </div>
            </td>
            <td>modal (blocks other user actions until user responds)</td>
            <td>
              <button data-alert="confirmation">Example</button>
            </td>
          </tr>

        </tbody>
      </table>
      </div>
    </div>
  </div>
</section>
',
    ),
  ),
  'docs-base-variables' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\'
})
',
    ),
    'templates' => 
    array (
      'docs-base-variables' => '
<!-- VARIABLES
================================================== -->
<section id="variables">
  <div class="page-header">
    <h1>Variables <small>LESS variables, HTML values, and usage guidelines</small></h1>
  </div>

  <h3>Base</h3>
  <div class="row-fluid">
    <div class="span7">

      <h4>Grid system</h4>
      <table class="table table-bordered table-striped">
        <tbody>
          <tr>
            <td><code>@gridColumns</code></td>
            <td class="mono">12</td>
          </tr>
          <tr>
            <td><code>@gridColumnWidth</code></td>
            <td class="mono">60px</td>
          </tr>
          <tr>
            <td><code>@gridGutterWidth</code></td>
            <td class="mono">20px</td>
          </tr>
          <tr>
            <td><code>@fluidGridColumnWidth</code></td>
            <td class="mono">6.382978723%</td>
          </tr>
          <tr>
            <td><code>@fluidGridGutterWidth</code></td>
            <td class="mono">2.127659574%</td>
          </tr>
        </tbody>
      </table>

      <h4>Typography</h4>
      <table class="table table-bordered table-striped">
        <tbody>
          <tr>
            <td><code>@baseFontSize</code></td>
            <td class="mono">13px</td>
          </tr>
          <tr>
            <td><code>@baseFontFamily</code></td>
            <td class="mono">Helvetica, Arial, sans-serif;</td>
          </tr>
          <tr>
            <td><code>@serifFontFamily</code></td>
            <td class="mono">Georgia, "Times New Roman", Times, serif;</td>
          </tr>
          <tr>
            <td><code>@monoFontFamily</code></td>
            <td class="mono">Menlo, Monaco, Consolas, "Courier New", monospace;</td>
          </tr>
          <tr>
            <td><code>@baseLineHeight</code></td>
            <td class="mono">18px</td>
          </tr>
        </tbody>
      </table>

      <h4>Theme colors</h4>
      <table class="table table-bordered table-striped">
        <tbody>
          <tr>
            <td><code>@BorderColor</code></td>
            <td class="hex mono">#e61718</td>
            <td class="swatch-col"><span class="swatch BorderColor"></span></td>
          </tr>
          <tr>
            <td><code>@NavigationBar</code></td>
            <td class="hex mono">#282828</td>
            <td><span class="swatch NavigationBar"></span></td>
          </tr>
          <tr>
            <td><code>@PrimaryButton</code></td>
            <td class="hex mono">#176de5</td>
            <td><span class="swatch PrimaryButton"></span></td>
          </tr>
        </tbody>
      </table>

      <h4>Common shades and tints</h4>
      <table class="table table-bordered table-striped">
        <tbody>
          <tr>
            <td><code>@tableBorderColor</text></td>
            <td><code>darken(@grayLighter, 5%)</code></td>
            <td class="hex mono">#e9e9e9</td>
            <td class="swatch-col"><span class="swatch" style="background:#e9e9e9"></span></td>
          </tr>
          <tr>
            <td><code>@btnBorder</code></td>
            <td><code>darken(@grayLighter, 10%)</code></td>
            <td class="hex mono">#dddddd</td>
            <td><span class="swatch" style="background:#dddddd"></span></td>
          </tr>
          <tr>
            <td><code>@dropdownLinkBackgroundHover</code></td>
            <td><code>lighten(@linkColor, 48%)</code></td>
            <td class="hex mono">#f3f8fe</td>
            <td><span class="swatch swatch-bordered" style="background:#f3f8fe"></span></td>
          </tr>
        </tbody>
      </table>

    </div>
    <div class="span5">

      <h4>Grayscale colors</h4>
      <table class="table table-bordered table-striped">
        <tbody>
          <tr>
            <td><code>@black</code></td>
            <td><code>.black, .black-text</code></td>
            <td class="hex mono">#000</td>
            <td class="swatch-col"><span class="swatch black"></span></td>
          </tr>
          <tr>
            <td><code>@grayDarker</code></td>
            <td><code>.gray-darker, .gray-darker-text</code></td>
            <td class="hex mono">#111</td>
            <td><span class="swatch gray-darker"></span></td>
          </tr>
          <tr>
            <td><code>@grayDark</code></td>
            <td><code>.gray-dark, .gray-dark-text</code></td>
            <td class="hex mono">#222</td>
            <td><span class="swatch gray-dark"></span></td>
          </tr>
          <tr>
            <td><code>@gray</code></td>
            <td><code>.gray, .gray-text</code></td>
            <td class="hex mono">#555</td>
            <td><span class="swatch gray"></span></td>
          </tr>
          <tr>
            <td><code>@grayLight</code></td>
            <td><code>.gray-light, .gray-light-text</code></td>
            <td class="hex mono">#717171</td>
            <td><span class="swatch gray-light"></span></td>
          </tr>
          <tr>
            <td><code>@grayLighter</code></td>
            <td><code>.gray-lighter, .gray-lighter-text</code></td>
            <td class="hex mono">#f6f6f6</td>
            <td><span class="swatch swatch-bordered gray-lighter"></span></td>
          </tr>
          <tr>
            <td><code>@white</code></td>
            <td><code>.white, .white-text</code></td>
            <td class="hex mono">#fff</td>
            <td><span class="swatch swatch-bordered white"></span></td>
          </tr>
        </tbody>
      </table>

      <h4>Accent colors</h4>
      <table class="table table-bordered table-striped">
        <tbody>
          <tr>
            <td><code>@mint</code></td>
            <td><code>.mint, .mint-text</code></td>
            <td class="hex mono">#0d8046</td>
            <td class="swatch-col"><span class="swatch mint"></span></td>
          </tr>
          <tr>
            <td><code>@green</code></td>
            <td><code>.green, .green-text</code></td>
            <td class="hex mono">#33800d</td>
            <td><span class="swatch green"></span></td>
          </tr>
          <tr>
            <td><code>@army</code></td>
            <td><code>.army, .army-text</code></td>
            <td class="hex mono">#6a800d</td>
            <td><span class="swatch army"></span></td>
          </tr>
          <tr>
            <td><code>@yellow</code></td>
            <td><code>.yellow, .yellow-text</code></td>
            <td class="hex mono">#e5a117</td>
            <td><span class="swatch yellow"></span></td>
          </tr>
          <tr>
            <td><code>@orange</code></td>
            <td><code>.orange, .orange-text</code></td>
            <td class="hex mono">#cc3314</td>
            <td><span class="swatch orange"></span></td>
          </tr>
          <tr>
            <td><code>@red</code></td>
            <td><code>.red, .red-text</code></td>
            <td class="hex mono">#e61718</td>
            <td><span class="swatch red"></span></td>
          </tr>
          <tr>
            <td><code>@pink</code></td>
            <td><code>.pink, .pink-text</code></td>
            <td class="hex mono">#e5176d</td>
            <td><span class="swatch pink"></span></td>
          </tr>
          <tr>
            <td><code>@purple</code></td>
            <td><code>.purple, .purple-text</code></td>
            <td class="hex mono">#6d17e5</td>
            <td><span class="swatch purple"></span></td>
          </tr>
          <tr>
            <td><code>@night</code></td>
            <td><code>.night, .night-text</code></td>
            <td class="hex mono">#1f12b3</td>
            <td><span class="swatch night"></span></td>
          </tr>

          <tr>
            <td><code>@blue</code></td>
            <td><code>.blue, .blue-text</code></td>
            <td class="hex mono">#176de5</td>
            <td><span class="swatch blue"></span></td>
          </tr>
          <tr>
            <td><code>@ocean</code></td>
            <td><code>.ocean, .ocean-text</code></td>
            <td class="hex mono">#1378bf</td>
            <td><span class="swatch ocean"></span></td>
          </tr>
          <tr>
            <td><code>@pacific</code></td>
            <td><code>.pacific, .pacific-text</code></td>
            <td class="hex mono">#0f7799</td>
            <td><span class="swatch pacific"></span></td>
          </tr>
          <tr>
            <td><code>@teal</code></td>
            <td><code>.teal, .teal-text</code></td>
            <td class="hex mono">#0d806c</td>
            <td><span class="swatch teal"></span></td>
          </tr>
          <tr>
            <td><code>@coral</code></td>
            <td><code>.coral, .coral-text</code></td>
            <td class="hex mono">#ff6fcf</td>
            <td><span class="swatch coral"></span></td>
          </tr>
        </tbody>
      </table>

    </div>
  </div> <!-- /row -->

  <h3>Components</h3>
  <div class="row-fluid">
    <div class="span4">

      <h4>Navbar</h4>
      <table class="table table-bordered table-striped">
        <tbody>
          <tr>
            <td class="span3"><code>@navbarHeight</code></td>
            <td class="mono">44px</td>
            <td class="hex mono"></td>
            <td class="swatch-col"></td>
          </tr>
          <tr>
            <td><code>@navbarBackground</code></td>
            <td class="mono"><code>@grayDarker</code></td>
            <td class="hex mono">#111</td>
            <td><span class="swatch gray-darker"></span></td>
          </tr>
          <tr>
            <td><code>@navbarBackgroundHighlight</code></td>
            <td class="mono"><code>@grayDark</code></td>
            <td class="hex mono">#222</td>
            <td><span class="swatch gray-dark"></span></td>
          </tr>
          <tr>
            <td><code>@navbarText</code></td>
            <td class="mono"><code>@grayLight</code></td>
            <td class="hex mono">#717171</td>
            <td><span class="swatch gray-light"></span></td>
          </tr>
          <tr>
            <td><code>@navbarLinkColor</code></td>
            <td class="mono"><code>@grayLight</code></td>
            <td class="hex mono">#717171</td>
            <td><span class="swatch swatch-bordered gray-light"></span></td>
          </tr>
          <tr>
            <td><code>@navbarLinkColorHover</code></td>
            <td class="mono"><code>@white</code></td>
            <td class="hex mono">#fff</td>
            <td><span class="swatch swatch-bordered white"></span></td>
          </tr>
        </tbody>
      </table>

      <h4>Hyperlinks and Text</h4>
      <table class="table table-bordered table-striped">
        <tbody>
          <tr>
            <td><code>@textColor</text></td>
            <td><code>@gray</code></td>
            <td class="hex mono">#555</td>
            <td class="swatch-col"><span class="swatch gray"></span></td>
          </tr>
          <tr>
            <td><code>@linkColor</code></td>
            <td><code>@PrimaryButton</code></td>
            <td class="hex mono">#176de5</td>
            <td><span class="swatch blue"></span></td>
          </tr>
          <tr>
            <td><code>@linkColorHover</code></td>
            <td><code>darken(@linkColor, 10%)</code></td>
            <td class="hex mono">#1257b7</td>
            <td><span class="swatch" style="background:#1257b7"></span></td>
          </tr>
        </tbody>
      </table>

    </div>
    <div class="span4">

      <h4>Forms and states</h4>
      <table class="table table-bordered table-striped">
        <tbody>
          <tr>
            <td class="span3"><code>@error</code></td>
            <td><code>@red</code></td>
            <td class="hex mono">#e61718</td>
            <td class="swatch-col"><span class="swatch red"></span></td>
          </tr>
          <tr>
            <td class="span3"><code>@warning</code></td>
            <td><code>@yellow</code></td>
            <td class="hex mono">#e5a117</td>
            <td><span class="swatch yellow"></span></td>
          </tr>
          <tr>
            <td class="span3"><code>@success</code></td>
            <td><code>@green</code></td>
            <td class="hex mono">#33800d</td>
            <td><span class="swatch green"></span></td>
          </tr>
          <tr>
            <td class="span3"><code>@inform</code></td>
            <td><code>@pacific</code></td>
            <td class="hex mono">#0f7799</td>
            <td><span class="swatch pacific"></span></td>
          </tr>
          <tr>
            <td class="span3"><code>@placeholderText</code></td>
            <td><code>@grayLight</code></td>
            <td class="hex mono">#717171</td>
            <td><span class="swatch swatch-bordered" style="background:#717171"></span></td>
          </tr>
        </tbody>
      </table>

      <h4>Buttons</h4>
      <table class="table table-bordered table-striped">
        <tbody>
          <tr>
            <td class="span3"><code>.btn-danger</code></td>
            <td><code>@btnDangerBackground</code></td>
            <td class="hex mono">#e5a117</td>
            <td><span class="swatch btn btn-danger"></span></td>
          </tr>
          <tr>
            <td class="span3"><code>.btn-warning</code></td>
            <td><code>@btnWarningBackground</code></td>
            <td class="hex mono">#e61718</td>
            <td><span class="swatch btn btn-warning"></span></td>
          </tr>
          <tr>
            <td class="span3"><code>.btn-success</code></td>
            <td><code>@btnSuccessBackground</code></td>
            <td class="hex mono">#33800d</td>
            <td><span class="swatch btn btn-success"></span></td>
          </tr>
          <tr>
            <td class="span3"><code>.btn-primary</code></td>
            <td><code>@primaryButtonBackground</code></td>
            <td class="hex mono">#176de5</td>
            <td class="swatch-col"><span class="swatch btn btn-primary"></span></td>
          </tr>
          <tr>
            <td class="span3"><code>.btn</code></td>
            <td><code>@btnBackground</code></td>
            <td class="hex mono">#f6f6f6</td>
            <td><span class="swatch btn"></span></td>
          </tr>
        </tbody>
      </table>

    </div>

    <div class="span4">

      <h4>Alerts</h4>
      <table class="table table-bordered table-striped">
        <tbody>
          <tr>
            <td class="span3"><code>@warningText</code></td>
            <td><code>darken(@warning, 40%)</code></td>
            <td class="span3"><code>.warning-text</code></td>
            <td class="hex mono">#2c1f04</td>
            <td class="swatch-col"><span class="swatch warning-text"></span></td>
          </tr>
          <tr>
            <td><code>@warningBackground</code></td>
            <td class="mono"><code>lighten(@warning, 47%)</code></td>
            <td class="span3"><code>.warning-background</code></td>
            <td class="hex mono">#fdf8ee</td>
            <td><span class="swatch warning-background"></span></td>
          </tr>
          <tr>
            <td><code>@warningBorder</code></td>
            <td class="mono"><code>lighten(@warning, 30%)</code></td>
            <td class="span3"><code>.warning-border</code></td>
            <td class="hex mono">#f5d9a0</td>
            <td><span class="swatch warning-border"></span></td>
          </tr>

          <tr>
            <td><code>@errorText</code></td>
            <td class="mono"><code>@error</code></td>
            <td class="span3"><code>.error-text</code></td>
            <td class="hex mono">#e61718</td>
            <td><span class="swatch error-text"></span></td>
          </tr>
          <tr>
            <td><code>@errorTextAlert</code></td>
            <td class="mono"><code>@white</code></td>
            <td class="span3"><code>.error-text-alert</code></td>
            <td class="hex mono">#fff</td>
            <td><span class="swatch error-text-alert swatch-bordered"></span></td>
          </tr>
          <tr>
            <td><code>@errorBackground</code></td>
            <td class="mono"><code>@error</code></td>
            <td class="span3"><code>.error-background</code></td>
            <td class="hex mono">#e61718</td>
            <td><span class="swatch error-background"></span></td>
          </tr>
          <tr>
            <td><code>@errorBorder</code></td>
            <td class="mono"><code>darken(@error, 10%)</code></td>
            <td class="span3"><code>.error-border</code></td>
            <td class="hex mono">#b81213</td>
            <td><span class="swatch error-border"></span></td>
          </tr>

          <tr>
            <td><code>@successText</code></td>
            <td class="mono"><code>@white</code></td>
            <td class="span3"><code>.success-text</code></td>
            <td class="hex mono">#fff</td>
            <td><span class="swatch success-text swatch-bordered"></span></td>
          </tr>
          <tr>
            <td><code>@successBackground</code></td>
            <td class="mono"><code>@success</code></td>
            <td class="span3"><code>.success-background</code></td>
            <td class="hex mono">#33800d</td>
            <td><span class="swatch success-background"></span></td>
          </tr>
          <tr>
            <td><code>@successBorder</code></td>
            <td class="mono"><code>darken(@success, 10%)</code></td>
            <td class="span3"><code>.success-border</code></td>
            <td class="hex mono">#215208</td>
            <td><span class="swatch success-border"></span></td>
          </tr>

          <tr>
            <td><code>@infoText</code></td>
            <td class="mono"><code>@white</code></td>
            <td class="span3"><code>.info-text</code></td>
            <td class="hex mono">#fff</td>
            <td><span class="swatch info-text swatch-bordered"></span></td>
          </tr>
          <tr>
            <td><code>@infoBackground</code></td>
            <td><code>@inform</code></td>
            <td class="span3"><code>.info-background</code></td>
            <td class="hex mono">#0f7799</td>
            <td><span class="swatch info-background"></span></td>
          </tr>
          <tr>
            <td><code>@infoBorder</code></td>
            <td><code>darken(@inform, 10%)</code></td>
            <td class="span3"><code>.info-border</code></td>
            <td class="hex mono">#0a536b</td>
            <td><span class="swatch info-border"></span></td>
          </tr>
        </tbody>
      </table>

    </div>
  </div><!-- /row -->

</section>
',
    ),
  ),
  'record' => 
  array (
    'meta' => 
    array (
      'panels' => 
      array (
        0 => 
        array (
          'name' => 'panel_header',
          'header' => true,
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'picture',
              'type' => 'avatar',
              'size' => 'large',
              'dismiss_label' => true,
            ),
            1 => 
            array (
              'name' => 'full_name',
              'label' => 'LBL_NAME',
              'dismiss_label' => true,
              'type' => 'fullname',
              'fields' => 
              array (
                0 => 'salutation',
                1 => 'first_name',
                2 => 'last_name',
              ),
            ),
            2 => 
            array (
              'name' => 'favorite',
              'label' => 'LBL_FAVORITE',
              'type' => 'favorite',
              'dismiss_label' => true,
            ),
            3 => 
            array (
              'name' => 'follow',
              'label' => 'LBL_FOLLOW',
              'type' => 'follow',
              'readonly' => true,
              'dismiss_label' => true,
            ),
          ),
        ),
        1 => 
        array (
          'name' => 'panel_body',
          'label' => 'LBL_RECORD_BODY',
          'columns' => 2,
          'labelsOnTop' => true,
          'placeholders' => true,
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'title',
              'label' => 'Base',
              'type' => 'text',
            ),
            1 => 
            array (
              'name' => 'do_not_call',
              'label' => 'Boolean',
              'type' => 'bool',
              'text' => 'Do not call',
            ),
            2 => 
            array (
              'name' => 'parent_name',
              'label' => 'Parent',
              'type' => 'parent',
            ),
            3 => 
            array (
              'name' => 'assigned_user_name',
              'label' => 'Relate',
              'type' => 'relate',
              'id' => 'ASSIGNED_USER_ID',
              'default' => true,
              'sortable' => false,
              'help' => 'This is the user that will be responsible for this record.',
            ),
            4 => 
            array (
              'name' => 'user_email',
              'label' => 'Email',
              'type' => 'email',
            ),
            5 => 
            array (
              'name' => 'team_name',
              'label' => 'Teamset',
              'type' => 'teamset',
              'module' => 'Teams',
              'help' => 'Teamset fields provide a way for records to be assigned to a group of users.',
            ),
          ),
        ),
        2 => 
        array (
          'columns' => 2,
          'name' => 'panel_hidden',
          'label' => 'LBL_RECORD_SHOWMORE',
          'hide' => true,
          'labelsOnTop' => true,
          'placeholders' => true,
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'primary_address',
              'type' => 'fieldset',
              'css_class' => 'address',
              'label' => 'LBL_PRIMARY_ADDRESS',
              'fields' => 
              array (
                0 => 
                array (
                  'name' => 'primary_address_street',
                  'css_class' => 'address_street',
                  'placeholder' => 'LBL_PRIMARY_ADDRESS_STREET',
                ),
                1 => 
                array (
                  'name' => 'primary_address_city',
                  'css_class' => 'address_city',
                  'placeholder' => 'LBL_PRIMARY_ADDRESS_CITY',
                ),
                2 => 
                array (
                  'name' => 'primary_address_state',
                  'css_class' => 'address_state',
                  'placeholder' => 'LBL_PRIMARY_ADDRESS_STATE',
                ),
                3 => 
                array (
                  'name' => 'primary_address_postalcode',
                  'css_class' => 'address_zip',
                  'placeholder' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
                ),
                4 => 
                array (
                  'name' => 'primary_address_country',
                  'css_class' => 'address_country',
                  'placeholder' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
                ),
              ),
            ),
            1 => 
            array (
              'name' => 'alt_address',
              'type' => 'fieldset',
              'css_class' => 'address',
              'label' => 'LBL_ALT_ADDRESS',
              'fields' => 
              array (
                0 => 
                array (
                  'name' => 'alt_address_street',
                  'css_class' => 'address_street',
                  'placeholder' => 'LBL_ALT_ADDRESS_STREET',
                ),
                1 => 
                array (
                  'name' => 'alt_address_city',
                  'css_class' => 'address_city',
                  'placeholder' => 'LBL_ALT_ADDRESS_CITY',
                ),
                2 => 
                array (
                  'name' => 'alt_address_state',
                  'css_class' => 'address_state',
                  'placeholder' => 'LBL_ALT_ADDRESS_STATE',
                ),
                3 => 
                array (
                  'name' => 'alt_address_postalcode',
                  'css_class' => 'address_zip',
                  'placeholder' => 'LBL_ALT_ADDRESS_POSTALCODE',
                ),
                4 => 
                array (
                  'name' => 'alt_address_country',
                  'css_class' => 'address_country',
                  'placeholder' => 'LBL_ALT_ADDRESS_COUNTRY',
                ),
                5 => 
                array (
                  'name' => 'copy',
                  'label' => 'NTC_COPY_PRIMARY_ADDRESS',
                  'type' => 'copy',
                  'mapping' => 
                  array (
                    'primary_address_street' => 'alt_address_street',
                    'primary_address_city' => 'alt_address_city',
                    'primary_address_state' => 'alt_address_state',
                    'primary_address_postalcode' => 'alt_address_postalcode',
                    'primary_address_country' => 'alt_address_country',
                  ),
                ),
              ),
            ),
            2 => 
            array (
              'name' => 'birthdate',
              'label' => 'Date',
              'type' => 'date',
            ),
            3 => 
            array (
              'name' => 'date_start',
              'label' => 'Datetimecombo',
              'type' => 'datetimecombo',
            ),
            4 => 
            array (
              'name' => 'filename',
              'label' => 'File',
              'type' => 'file',
            ),
            5 => 
            array (
              'name' => 'list_price',
              'label' => 'Currency',
              'type' => 'currency',
            ),
            6 => 
            array (
              'name' => 'website',
              'label' => 'URL',
              'type' => 'url',
            ),
            7 => 
            array (
              'name' => 'phone_home',
              'label' => 'Phone',
              'type' => 'phone',
            ),
            8 => 
            array (
              'name' => 'description',
              'label' => 'Textarea',
              'type' => 'textarea',
            ),
            9 => 
            array (
              'name' => 'radio_button_group',
              'type' => 'radioenum',
              'label' => 'Radioenum',
              'view' => 'edit',
              'options' => 
              array (
                'option_one' => 'Option One',
                'option_two' => 'Option Two',
              ),
              'default' => false,
              'enabled' => true,
            ),
            10 => 
            array (
              'name' => 'secret_password',
              'label' => 'Password',
              'type' => 'password',
            ),
            11 => 
            array (
              'name' => 'empty_text',
              'label' => 'Label',
              'type' => 'label',
              'default_value' => 'Static text string.',
            ),
            12 => 
            array (
              'name' => 'date_modified_by',
              'readonly' => true,
              'inline' => true,
              'type' => 'fieldset',
              'label' => 'LBL_DATE_MODIFIED',
              'fields' => 
              array (
                0 => 
                array (
                  'name' => 'date_modified',
                ),
                1 => 
                array (
                  'type' => 'label',
                  'default_value' => 'LBL_BY',
                ),
                2 => 
                array (
                  'name' => 'modified_by_name',
                ),
              ),
            ),
            13 => 
            array (
              'name' => 'date_entered_by',
              'readonly' => true,
              'inline' => true,
              'type' => 'fieldset',
              'label' => 'LBL_DATE_ENTERED',
              'fields' => 
              array (
                0 => 
                array (
                  'name' => 'date_entered',
                ),
                1 => 
                array (
                  'type' => 'label',
                  'default_value' => 'LBL_BY',
                ),
                2 => 
                array (
                  'name' => 'created_by_name',
                ),
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'docs-dashboards-dashlets' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // dashboard dashlets
    _renderHtml: function () {
        var self = this;

        this._super(\'_renderHtml\');

        // define event listeners
        app.events.on(\'preview:close\', function() {
            self.hideDashletPreview();
        });
        app.events.on(\'app:dashletPreview:close\', function() {
            self.hideDashletPreview();
        });
        app.events.on(\'app:dashletPreview:open\', function() {
            self.showDashletPreview();
        });

        app.events.trigger(\'app:dashletPreview:close\');

        this.$(\'.dashlet-example\').on(\'click.styleguide\', function(){
            self.$(\'.dashlet-example\').removeClass(\'active\');
            $(this).addClass(\'active\');
            app.events.trigger(\'app:dashletPreview:open\');
            var dashlet = $(this).data(\'dashlet\'),
                module = $(this).data(\'module\') || \'Styleguide\',
                metadata = app.metadata.getView(module, dashlet).dashlets[0];
            metadata.type = dashlet;
            metadata.component = dashlet;
            self.previewDashlet(metadata);
        });
    },

    _dispose: function() {
        this.$(\'.dashlet-example\').off(\'click.styleguide\');
        app.events.trigger(\'app:dashletPreview:close\');
        this._super(\'_dispose\');
    },

    showDashletPreview: function(event) {
        $(\'.main-pane\').addClass(\'span8\').removeClass(\'span12\');
        $(\'.preview-pane\').addClass(\'active\');
        $(\'.side\').css({visibility: \'visible\'});
    },

    hideDashletPreview: function(event) {
        $(\'.dashlet-example\').removeClass(\'active\');
        $(\'.main-pane\').addClass(\'span12\').removeClass(\'span8\');
        $(\'.side\').css({visibility: \'hidden\'});
    },

    /**
     * Load dashlet preview by passing preview metadata
     *
     * @param {Object} metadata Preview metadata.
     */
    previewDashlet: function(metadata) {
        var layout = this.layout,
            previewLayout;

        while (layout) {
            if (layout.getComponent(\'preview-pane\')) {
                previewLayout = layout.getComponent(\'preview-pane\').getComponent(\'dashlet-preview\');
                //previewLayout.showPreviewPanel();
                break;
            }
            layout = layout.layout;
        }

        if (previewLayout) {
            // If there is no preview property, use the config property
            if (!metadata.preview) {
                metadata.preview = metadata.config;
            }
            var previousComponent = _.last(previewLayout._components);

            if (previousComponent.name !== \'dashlet-preview\' && previousComponent.name !== \'preview-header\') {
                var index = previewLayout._components.length - 1;
                previewLayout._components[index].dispose();
                previewLayout.removeComponent(index);
            }

            var contextDef,
                component = {
                    label: app.lang.get(metadata.label, metadata.preview.module),
                    type: metadata.type,
                    preview: true
                };
            if (metadata.preview.module || metadata.preview.link) {
                contextDef = {
                    skipFetch: false,
                    forceNew: true,
                    module: metadata.preview.module,
                    link: metadata.preview.link
                };
            } else if (metadata.module) {
                contextDef = {
                    module: metadata.module
                };
            }

            component.view = _.extend({module: metadata.module}, metadata.preview, component);
            if (contextDef) {
                component.context = contextDef;
            }

            previewLayout._addComponentsFromDef([
                {
                    layout: {
                        type: \'dashlet\',
                        label: app.lang.get(metadata.preview.label || metadata.label, metadata.preview.module),
                        preview: true,
                        components: [
                            component
                        ]
                    }
                }
            ], this.context.parent);

            previewLayout.loadData();
            previewLayout.render();
        }
    }
})
',
    ),
    'templates' => 
    array (
      'docs-dashboards-dashlets' => '
<section id="dashboards">

<div class="page-header">
    <h1>Dashlets<small> general styles, patterns and layouts</small></h1>
</div>

<div class="row-fluid">
    <div class="span12">
        <h2>Basic layout and classes</h2>
    </div>
</div>
<div class="row-fluid">
    <div class="span6">
        <p>Dashlets are defined as Sugar7 views generally with an <code>.hbs</code> template file, a <code>.php</code> configuration file, and a <code>.js</code> controller.</p>
        <p>The outer dashlet chrome and general functionality is provided by the dashlet plugin and is included in the controller with <code>plugins: [\'Dashlet\']</code>. All basic features of the dashlet can be modified using the configuration file as shown below.</p>
        <p>The CSS classes specific to dashlet views are: <code>.dashlet</code>, <code>.dashlet-header</code>, <code>.dashlet-title</code>, <code>.dashlet-toolbar</code>, <code>.dashlet-options</code>, <code>.dashlet-content</code>, and the core Bootstrap class <code>.thumbnail</code>. The related LESS files are <code>styleguide/less/sugar-specific/dashlets.less</code> and <code>styleguide/less/sugar-specific/charts.less</code></p>
        <p>Please see the <a href="#Styleguide/docs/dashboards_home">Styleguide Dashboards</a> page for detailed information about dashboards.</p>
    </div>
    <div class="span6">
<pre class="prettyprint linenums">
&lt;div class="thumbnail dashlet" data-action="droppable"&gt;
&lt;div data-dashlet="toolbar"&gt;
    &lt;div class="dashlet-header"&gt;
        &lt;div class="btn-toolbar pull-right"&gt;[ACTIONS]&lt;/div&gt;
        &lt;h4 data-toggle="dashlet" class="dashlet-title"&gt;[TITLE]&lt;/h4&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;div class="dashlet-options"&gt;[OPTIONS]&lt;/div&gt;
&lt;div data-dashlet="dashlet" class="dashlet-content"&gt;
    &lt;div class="[WRAPPER CLASS]"&gt;
        [CONTENT]
    &lt;/div&gt;
&lt;div&gt;
&lt;/div&gt;
</pre>
    </div>
</div>


<div class="row-fluid">
    <div class="span12">
        <h2>Dashlet header</h2>
    </div>
</div>

<div class="row-fluid">
    <div class="span6">
        <h3>Title</h3>
        <p>The title of the dashlet is left-aligned within the header of the dashlet.</p>
        <p>It is defined in the dashlet configuration file as <code>\'label\' => \'LBL_YOUR_DASHLET\'</code>. A description of the dashlet should also be provided using <code>\'description\' => \'LBL_HISTORY_DASHLET_DESCRIPTION\'</code>.</p>
    </div>
    <div class="span6 leading-h3">
<pre class="prettyprint linenums">
&lt;h4 data-toggle="dashlet" class="dashlet-title"&gt;
</pre>
    </div>
</div>

<div class="row-fluid">
    <div class="span6">
        <h3>Actions</h3>
        <p>By default, the dashlet plugin provides the user with the following dashlet actions under the \'cog icon:</p>
        <ul>
            <li>Edit</li>
            <li>Refresh</li>
            <li>Minimize/maximize</li>
            <li>Remove</li>
        </ul>
        <p>These actions can be customized by the developer by adding \'dropdown_buttons\' to the the \'custom_toolbar\' array in the configuration file (see the history dashlet view configuration file as an example.<p>
        <p>If a dashlet requires a create action, the \'plus\' icon action button can be placed to the left of the cog by adding an \'actiondropdown\' array to the configuration file.</p>
    </div>
    <div class="span6 leading-h3">
<pre class="prettyprint linenums">
&lt;div class="btn-toolbar pull-right"&gt;
&lt;span class="actions btn-group dashlet-toolbar"&gt;
    &lt;a class="btn btn-invisible dropdown-toggle"&gt;
        &lt;span class="fa fa-plus"&gt;
&lt;div class="btn-group"&gt;
    &lt;a data-toggle="dropdown" class="btn btn-invisible dropdown-toggle"&gt;
        &lt;i class="fa fa-cog"&gt;
</pre>
<pre class="prettyprint linenums">
\'custom_toolbar\' => array(
\'buttons\' => array(
    array(
        \'type\' => \'actiondropdown\',
        \'no_default_action\' => true,
        \'icon\' => \'fa-plus\',
        \'buttons\' => array(
        ),
    )
    array(
        \'dropdown_buttons\' => array(
        ),
    )
</pre>
    </div>
</div>


<div class="row-fluid">
    <div class="span12">
        <h2>Dashlet options</h2>
        <p>Below the header the user should have any available content-manipulation options</p>
    </div>
</div>
<div class="row-fluid">
    <div class="span6">
        <h3>Dropdown</h3>
        <p>There should be only one dropdown available and it should be used for time-based content manipulation </p>
    </div>
    <div class="span6 leading-h3">
<pre class="prettyprint linenums">
&lt;div data-dashlet="dashlet" class="dashlet-content"&gt;
&lt;div class="dashlet-options"&gt;
</pre>
    </div>
</div>

<div class="row-fluid">
    <div class="span6">
        <h3>Toggles</h3>
        <p>The most common use of the toggles will be to filter between "my" and "my group" data. other uses may include \'likely/best/worst\' for forecasting. </p>
    </div>
    <div class="span6 leading-h3">
<pre class="prettyprint linenums">
&lt;div class="btn-group pull-right dashlet-group" data-toggle="buttons-radio"&gt;
&lt;button class="btn active" value="user" data-action="visibility-switcher"&gt;
    &lt;i class="fa fa-user"&gt;
&lt;button class="btn" value="group" data-action="visibility-switcher"&gt;
    &lt;i class="fa fa-users"&gt;
</pre>
    </div>
</div>


<div class="row-fluid">
    <div class="span12">
        <h2>Examples</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Dashlet</th>
                    <th>Components</th>
                    <th>Example</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Chart</td>
                    <td><p>The case summmary dashlet is comprised of the default header and tabs for viewing \'Summary\' or \'New\' cases; the content is visualized as a chart.</p></td>
                    <td><button class="btn btn-secondary dashlet-example" data-dashlet="dashlet-chart"><i class="fa fa-eye"></i></button></td>
                </tr>
                <tr>
                    <td>Summary</td>
                    <td>The forecast dashlet brings together several key bits of data and uses separators and labels for visualization.</td>
                    <td><button class="btn btn-secondary dashlet-example" data-dashlet="forecastdetails"><i class="fa fa-eye"></i></button></td>
                </tr>
                <tr>
                    <td>Tabbed</td>
                    <td>Tabs should be used to differentiate among different data types like meetings, emails and calls or completed vs pending tasks. The active tasks dashlet is made up of several components and patterns including the extra create header action, dashlet configuration toggles, line-item actions, avatars, labels, and dates.
<pre class="prettyprint linenums">
&lt;div class="dashlet-unordered-list"&gt;
&lt;div class="dashlet-tabs tabs[0-9]"&gt;
    &lt;div class="dashlet-tabs-row:&gt;
        &lt;div class="dashlet-tab [active]"&gt;
            &lt;a data-toggle="tab" data-action="tab-switcher"&gt;
</pre>
                    </td>
                    <td><button class="btn btn-secondary dashlet-example" data-dashlet="dashlet-tabbed"><i class="fa fa-eye"></i></button></td>
                </tr>
                <tr>
                    <td>Article</td>
                    <td>For a list of records that contain a additional elements like avatars and record details, the article dashlet pattern should be used.</td>
                    <td><button class="btn btn-secondary dashlet-example" data-dashlet="top-activity-user" data-module="Home"><i class="fa fa-eye"></i></button></td>
                </tr>
                <tr>
                    <td>Item</td>
                    <td>In dashlets which contain a list of items it is often useful to include item-specific actions. to maintain consistency it is best to use a dropdown containing all possible actions although currently some dashlets use individual buttons.</td>
                    <td><button class="btn btn-secondary dashlet-example" data-dashlet="dashlet-tabbed"><i class="fa fa-eye"></i></button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <h2>Content patterns</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Use</th>
                    <th>Example</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Separators</td>
                    <td>Use sparingly in dashlets to separate data types or provide specific desired look</td>
                    <td><button class="btn btn-secondary dashlet-example" data-dashlet="active-tasks"><i class="fa fa-eye"></i></button></td>
                </tr>
                <tr>
                    <td>Avatar</td>
                    <td>Used for content which belongs to a user
<pre class="prettyprint linenums">
&lt;a class="pull-left avatar avatar-lg"&gt;
&lt;img\\&gt;
&lt;span class="active-tasks"&gt;
&lt;span class="label label-important"&gt;Label&lt;/span&gt;
</pre>
                    </td>
                    <td><button class="btn btn-secondary dashlet-example" data-dashlet="top-activity-user" data-module="Home"><i class="fa fa-eye"></i></button></td>
                </tr>
                <tr>
                    <td>Labels</td>
                    <td>
                    <p>Used to draw attention to data types within a single view, for example:</p>
                    <ul>
                        <li>Overdue tasks</li>
                        <li>Sent emails</li>
                    </ul>
                    <p>The placement of the label is between the avatar and the item name</p>
<pre class="prettyprint linenums">
&lt;span class="label"&gt;
</pre>
                    </td>
                    <td><button class="btn btn-secondary dashlet-example" data-dashlet="dashlet-tabbed"><i class="fa fa-eye"></i></button></td>
                </tr>
                {{! <tr>
                    <td>Date/Time Stamps</td>
                    <td>Used when items have a relevant date or time related.
<pre class="prettyprint">
&lt;span class="relativetime"&gt;
</pre>
                    </td>
                </tr> }}
            </tbody>
        </table>
    </div>
</div>

</div>

</div>
</section>
',
    ),
  ),
  'docs-dashboards-home' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // dashboards home
    _renderHtml: function () {
        var self = this;
        this._super(\'_renderHtml\');

        this.$(\'.dashlet-example\').on(\'click.styleguide\', function(){
            var dashlet = $(this).data(\'dashlet\'),
                metadata = app.metadata.getView(\'Home\', dashlet).dashlets[0];
            metadata.type = dashlet;
            metadata.component = dashlet;
            self.layout.previewDashlet(metadata);
        });

        this.$(\'[data-modal]\').on(\'click.styleguide\', function(){
            var modal = $(this).data(\'modal\');
            $(modal).appendTo(\'body\').modal(\'show\');
        });
    },

    _dispose: function() {
        this.$(\'.dashlet-example\').off(\'click.styleguide\');
        this.$(\'[data-modal]\').off(\'click.styleguide\');
        this._super(\'_dispose\');
    }
})
',
    ),
    'templates' => 
    array (
      'docs-dashboards-home' => '
<section id="dashboards_home">

<div class="page-header">
    <h2>Home Module <small>Layout and patterns</small></h2>
</div>

<div class="row-fluid">
    <div class="span3">
        <h3>About</h3>
        <p>The home dashboard provides quick access to a user customizable layout of dashlets. Dashboard definitions are unique to each user and as many as needed can be created by the user.</p>
        <p>Dashlets are arranged in rows within a one, two or three column layout. Each row can contain one to three dashlets.</p>
        <p>The dashboard layout and title can be edited via the action menu in the dashboard headerpane or new dashboards can be created. Once more than one dashboard is created, they can be selected via the Cube dropdown in the navbar.</p>

        <h3>Home dashboard layout</h3>
        <p>Once a layout is created, rows can be arranged within a column using drag and drop while dashlets can be swapped with another in the layout using drag and drop as well.</p>
        <p>The general styling of the dashboard should normally not need to be modified, however, the related LESS files are <code>styleguide/less/sugar-specific/dashboard.less</code> and <code>styleguide/less/sugar-specific/dashlets.less</code>.

        <h3>CSS Classes and Javascript</h3>
        <p>Dashboard layouts make extensive use of three core Bootstrap modules&mdash;<a href="#Styleguide/docs/base_grid">fluid grid</a> (row-fluid &amp; span[1-12]), wells, and thumbnails.</p>
        <p>The drag and drop capability is provided by <a href="http://api.jqueryui.com/category/interactions/">jQuery UI Interactions</a> including Sortable, Draggable and Dropable.</p>
        <p>The CSS classes specific to dashboard layouts are: <code>.dashboard</code>, <code>.dashlets</code>, <code>.dashlet-row</code>, <code>.dashlet-cell</code>, <code>.dashlet-container</code>, <code>.cols</code>, and <code>.rows</code>.</p>
        <p>Please see the <a href="#Styleguide/docs/dashboards_dashlets">Styleguide Dashlets</a> page for detailed information about dashlets.</p

        <h3>Responsive Layout</h3>
        <p>For browser windows less than 768px wide, the dashboard layout will automatically adjust to one column with one dashlet per row.</p>
    </div>

    <div class="span6">
        <h3>Basic layout and classes</h3>
<pre class="prettyprint linenums">
&lt;div class="dashboard"&gt;
    &lt;div class="cols row-fluid"&gt;
        &lt;div class="preview-headerbar"&gt;
            &lt;div class="headerpane"&gt;&lt;/div&gt;
        &lt;/div&gt;
        &lt;ul class="dashlets row-fluid"&gt;
            &lt;li class="span4"&gt;
                &lt;ul class="dashlet-row ui-sortable"&gt;
                    &lt;li class="row-fluid sortable"&gt;
                        &lt;div class="rows well"&gt;
                            &lt;ul class="dashlet-cell rows row-fluid"&gt;
                                &lt;li class="dashlet-container span4 ui-droppable"&gt;
                                    &lt;div class="dashlet"&gt;&lt;/div&gt;
                                &lt;/li&gt;
                                &lt;li class="dashlet-container span4 ui-droppable"&gt;
                                    &lt;div class="dashlet"&gt;&lt;/div&gt;
                                &lt;/li&gt;
                                &lt;li class="dashlet-container span4 ui-droppable"&gt;
                                    &lt;div class="dashlet"&gt;&lt;/div&gt;
                                &lt;/li&gt;
                            &lt;/ul&gt;
                        &lt;/div&gt;
                    &lt;/li&gt;
                    &lt;li class="row-fluid sortable"&gt;
                    &lt;/li&gt;
                &lt;/ul&gt;
            &lt;/li&gt;
            &lt;li class="span8"&gt;
            &lt;/li&gt;
        &lt;/ul&gt;
    &lt;/div&gt;
&lt;/div&gt;
</pre>
    </div>

    <div class="span3">
        <h3>Home dashboard examples</h3>
        <p><a data-modal="#dashboards_homepage_2"><img src="styleguide/content/img/dashboards_home_1.png"></a></p>
        <p><a data-modal="#dashboards_homepage_2"><img src="styleguide/content/img/dashboards_home_2.png"></a></p>
    </div>
</div>

</section>

<div id="dashboards_homepage_2" class="modal hide fade" style="width:90%;margin-left:-45%;">
    <div class="modal-header">
        <a class="close btn btn-invisible" data-dismiss="modal"><i class="fa fa-times"></i></a>
        <h4>Edit Dashboard Layout</h4>
    </div>
    <div class="modal-body" style="padding:12px;max-height:90%;text-align:center;">
        <img src="styleguide/content/img/dashboards_home_2.png">
    </div>
</div>

<div id="dashboards_homepage_2" class="modal hide fade" style="width:90%;margin-left:-45%;">
    <div class="modal-header">
        <a class="close btn btn-invisible" data-dismiss="modal"><i class="fa fa-times"></i></a>
        <h4>Example Home Dashboard Layout</h4>
    </div>
    <div class="modal-body" style="padding:12px;max-height:90%;text-align:center;">
        <img src="styleguide/content/img/dashboards_home_2.png">
    </div>
</div>
',
    ),
  ),
  'docs-forms-buttons' => 
  array (
    'templates' => 
    array (
      'docs-forms-buttons' => '
<!-- Buttons
================================================== -->
<section id="buttons">
  <div class="page-header">
    <h1>Buttons</h1>
  </div>

  <h2>One class, multiple tags</h2>
  <p>Use the <code>.btn</code> class on an <code>&lt;a&gt;</code>, <code>&lt;button&gt;</code>, or <code>&lt;input&gt;</code> element.</p>
  <form class="bs-docs-example">
    <a class="btn" href="">Link</a>
    <button class="btn" type="submit">Button</button>
    <input class="btn" type="button" value="Input">
    <input class="btn" type="submit" value="Submit">
  </form>
<pre class="prettyprint linenums">
&lt;a class="btn" href=""&gt;Link&lt;/a&gt;
&lt;button class="btn" type="submit"&gt;Button&lt;/button&gt;
&lt;input class="btn" type="button" value="Input"&gt;
&lt;input class="btn" type="submit" value="Submit"&gt;
</pre>
  <p>As a best practice, try to match the element for your context to ensure matching cross-browser rendering. If you have an <code>input</code>, use an <code>&lt;input type="submit"&gt;</code> for your button.</p>

  <h2>Default buttons</h2>
  <p>Button styles can be applied to anything with the <code>.btn</code> class applied. However, typically you\'ll want to apply these to only <code>&lt;a&gt;</code> and <code>&lt;button&gt;</code> elements for the best rendering.</p>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Button</th>
        <th>class=""</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><button type="button" class="btn">Default</button></td>
        <td><code>btn</code></td>
        <td>Standard gray button with gradient</td>
      </tr>
      <tr>
        <td><button type="button" class="btn btn-primary">Primary</button></td>
        <td><code>btn btn-primary</code></td>
        <td>Provides extra visual weight and identifies the primary action in a set of buttons</td>
      </tr>
      <tr>
        <td><button type="button" class="btn btn-info">Info</button></td>
        <td><code>btn btn-info</code></td>
        <td>Used as an alternative to the default styles</td>
      </tr>
      <tr>
        <td><button type="button" class="btn btn-success">Success</button></td>
        <td><code>btn btn-success</code></td>
        <td>Indicates a successful or positive action</td>
      </tr>
      <tr>
        <td><button type="button" class="btn btn-warning">Warning</button></td>
        <td><code>btn btn-warning</code></td>
        <td>Indicates caution should be taken with this action</td>
      </tr>
      <tr>
        <td><button type="button" class="btn btn-danger">Danger</button></td>
        <td><code>btn btn-danger</code></td>
        <td>Indicates a dangerous or potentially negative action</td>
      </tr>
      <tr>
        <td><button type="button" class="btn btn-inverse">Inverse</button></td>
        <td><code>btn btn-inverse</code></td>
        <td>Alternate dark gray button, not tied to a semantic action or use</td>
      </tr>
      <tr>
        <td><button type="button" class="btn btn-link">Link</button></td>
        <td><code>btn btn-link</code></td>
        <td>Deemphasize a button by making it look like a link while maintaining button behavior</td>
      </tr>
    </tbody>
  </table>

  <h4>Cross browser compatibility</h4>
  <p>IE9 doesn\'t crop background gradients on rounded corners, so we remove it. Related, IE9 jankifies disabled <code>button</code> elements, rendering text gray with a nasty text-shadow that we cannot fix.</p>


  <h2>Button sizes</h2>
  <p>Fancy larger or smaller buttons? Add <code>.btn-large</code>, <code>.btn-small</code>, or <code>.btn-mini</code> for additional sizes.</p>
  <div class="bs-docs-example">
    <p>
      <button type="button" class="btn btn-large btn-primary">Large button</button>
      <button type="button" class="btn btn-large">Large button</button>
    </p>
    <p>
      <button type="button" class="btn btn-primary">Default button</button>
      <button type="button" class="btn">Default button</button>
    </p>
    <p>
      <button type="button" class="btn btn-small btn-primary">Small button</button>
      <button type="button" class="btn btn-small">Small button</button>
    </p>
    <p>
      <button type="button" class="btn btn-mini btn-primary">Mini button</button>
      <button type="button" class="btn btn-mini">Mini button</button>
    </p>
  </div>
<pre class="prettyprint linenums">
&lt;p&gt;
  &lt;button class="btn btn-large btn-primary" type="button"&gt;Large button&lt;/button&gt;
  &lt;button class="btn btn-large" type="button"&gt;Large button&lt;/button&gt;
&lt;/p&gt;
&lt;p&gt;
  &lt;button class="btn btn-primary" type="button"&gt;Default button&lt;/button&gt;
  &lt;button class="btn" type="button"&gt;Default button&lt;/button&gt;
&lt;/p&gt;
&lt;p&gt;
  &lt;button class="btn btn-small btn-primary" type="button"&gt;Small button&lt;/button&gt;
  &lt;button class="btn btn-small" type="button"&gt;Small button&lt;/button&gt;
&lt;/p&gt;
&lt;p&gt;
  &lt;button class="btn btn-mini btn-primary" type="button"&gt;Mini button&lt;/button&gt;
  &lt;button class="btn btn-mini" type="button"&gt;Mini button&lt;/button&gt;
&lt;/p&gt;
</pre>
  <p>Create block level buttons&mdash;those that span the full width of a parent&mdash; by adding <code>.btn-block</code>.</p>
  <div class="bs-docs-example">
    <div class="well" style="max-width: 400px; margin: 0 auto 10px;">
      <button type="button" class="btn btn-large btn-block btn-primary">Block level button</button>
      <button type="button" class="btn btn-large btn-block">Block level button</button>
    </div>
  </div>
<pre class="prettyprint linenums">
&lt;button class="btn btn-large btn-block btn-primary" type="button"&gt;Block level button&lt;/button&gt;
&lt;button class="btn btn-large btn-block" type="button"&gt;Block level button&lt;/button&gt;
</pre>


  <h2>Disabled state</h2>
  <p>Make buttons look unclickable by fading them back 50%.</p>

  <h3>Anchor element</h3>
  <p>Add the <code>.disabled</code> class to <code>&lt;a&gt;</code> buttons.</p>
  <p class="bs-docs-example">
    <a class="btn btn-large btn-primary disabled">Primary link</a>
    <a class="btn btn-large disabled">Link</a>
  </p>
<pre class="prettyprint linenums">
&lt;a class="btn btn-large btn-primary disabled"&gt;Primary link&lt;/a&gt;
&lt;a class="btn btn-large disabled"&gt;Link&lt;/a&gt;
</pre>
  <p>
    <span class="label label-info">Heads up!</span>
    We use <code>.disabled</code> as a utility class here, similar to the common <code>.active</code> class, so no prefix is required. Also, this class is only for aesthetic; you must use custom JavaScript to disable links here.
  </p>

  <h3>Button element</h3>
  <p>Add the <code>disabled</code> attribute to <code>&lt;button&gt;</code> buttons.</p>
  <p class="bs-docs-example">
    <button type="button" class="btn btn-large btn-primary disabled" disabled="disabled">Primary button</button>
    <button type="button" class="btn btn-large" disabled>Button</button>
  </p>
<pre class="prettyprint linenums">
&lt;button type="button" class="btn btn-large btn-primary disabled" disabled="disabled"&gt;Primary button&lt;/button&gt;
&lt;button type="button" class="btn btn-large" disabled&gt;Button&lt;/button&gt;
</pre>

  <h2>Invisible button background</h2>
  <p>Sometimes you want the same size, position and spacing options of a button without the background styling. This can be accomplished with the <code>.btn-invisible</code> class. This is often used for stand alone icons like the favorite star.</p>

  <p class="bs-docs-example">
    <a class="btn"><i class="fa fa-favorite"></i></a>
    <a class="btn btn-invisible"><i class="fa fa-favorite"></i></a>
  </p>
<pre class="prettyprint linenums">
    &lt;a class="btn"&gt;&lt;i class="fa fa-favorite"&gt;&lt;/i&gt;&lt;/a&gt;
    &lt;a class="btn btn-invisible"&gt;&lt;i class="fa fa-favorite"&gt;&lt;/i&gt;&lt;/a&gt;
</pre>

  <h2>Link style button</h2>
  <p>Sometimes you want the same size, position and spacing options of a button but have the button look like a link. This can be accomplished with the <code>.btn-invisible .btn-link</code> classes. This is often used to properly space a series of primary buttons and deemphasized secondary actions.</p>

  <p class="bs-docs-example">
    <a class="btn">Cancel</a>
    <a class="btn btn-invisible btn-link">Cancel</a>
  </p>
<pre class="prettyprint linenums">
    &lt;a class="btn"&gt;Cancel&lt;/a&gt;
    &lt;a class="btn btn-invisible btn-link"&gt;Cancel&lt;/a&gt;
</pre>
        </section>


<!-- Buttons
================================================== -->
<section id="buttons">
  <div class="page-header">
    <h1>All Together Now</h1>
  </div>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Button</th>
        <th>Classes</th>
        <th>Default</th>
        <th>Disabled</th>
        <th>Active</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Normal</td>
        <td><code>.btn</code></td>
        <td><a class="btn">Button</a><a class="btn"><i class="fa fa-ambulance"></i></a></td>
        <td><a class="btn disabled">Button</a><a class="btn disabled"><i class="fa fa-ambulance"></i></a></td>
        <td><a class="btn active">Button</a><a class="btn active"><i class="fa fa-ambulance"></i></a></td>
      </tr>
      <tr>
        <td>Invisible</td>
        <td><code>.btn .btn-invisible</code></td>
        <td><a class="btn btn-invisible">Button</a><a class="btn btn-invisible"><i class="fa fa-ambulance"></i></a></td>
        <td><a class="btn btn-invisible disabled">Button</a><a class="btn btn-invisible disabled"><i class="fa fa-ambulance"></i></a></td>
        <td><a class="btn btn-invisible active">Button</a><a class="btn btn-invisible active"><i class="fa fa-ambulance"></i></a></td>
      </tr>
      <tr>
        <td>Link</td>
        <td><code>.btn .btn-invisible .btn-link</code></td>
        <td><a class="btn btn-invisible btn-link">Button</a><a class="btn btn-invisible btn-link"><i class="fa fa-ambulance"></i></a></td>
        <td><a class="btn btn-invisible btn-link disabled">Button</a><a class="btn btn-invisible btn-link disabled"><i class="fa fa-ambulance"></i></a></td>
        <td><a class="btn btn-invisible btn-link active">Button</a><a class="btn btn-invisible btn-link active"><i class="fa fa-ambulance"></i></a></td>
      </tr>
    </tbody>
  </table>
</section>





<!-- Button Groups
================================================== -->
<section id="button-groups">
  <div class="page-header">
    <h1>Button groups <small>Join buttons for more toolbar-like functionality</small></h1>
  </div>
  <div class="row-fluid">
    <div class="span4">
      <h3>Button groups</h3>
      <p>Use button groups to join multiple buttons together as one composite component. Build them with a series of <code>&lt;a&gt;</code> or <code>&lt;button&gt;</code> elements.</p>
      <p>You can also combine sets of <code>&lt;div class="btn-group"&gt;</code> into a <code>&lt;div class="btn-toolbar"&gt;</code> for more complex projects.</p>
      <div class="btn-toolbar" style="margin-top: 18px;">
        <div class="btn-group">
          <a class="btn">Left</a>
          <a class="btn">Middle</a>
          <a class="btn">Right</a>
        </div>
      </div>
      <div class="btn-toolbar">
        <div class="btn-group">
          <a class="btn">1</a>
          <a class="btn">2</a>
          <a class="btn">3</a>
          <a class="btn">4</a>
        </div>
        <div class="btn-group">
          <a class="btn">5</a>
          <a class="btn">6</a>
          <a class="btn">7</a>
        </div>
        <div class="btn-group">
          <a class="btn">8</a>
        </div>
      </div>
    </div>
    <div class="span4">
      <h3>Example markup</h3>
      <p>Here\'s how the HTML looks for a standard button group built with anchor tag buttons:</p>
<pre class="prettyprint linenums">
&lt;div class="btn-group"&gt;
  &lt;a class="btn"&gt;1&lt;/a&gt;
  &lt;a class="btn"&gt;2&lt;/a&gt;
  &lt;a class="btn"&gt;3&lt;/a&gt;
&lt;/div&gt;
</pre>
      <p>And with a toolbar for multiple groups:</p>
<pre class="prettyprint linenums">
&lt;div class="btn-toolbar"&gt;
  &lt;div class="btn-group"&gt;
    ...
  &lt;/div&gt;
&lt;/div&gt;
</pre>
    </div>
    <div class="span4">
      <h3>Checkbox and radio flavors</h3>
      <p>Button groups can also function as radios, where only one button may be active, or checkboxes, where any number of buttons may be active. View <a href="widgets.html#buttons">the Javascript docs</a> for that.</p>
      <p><a class="btn js-btn" href="widgets.html#buttons">Get the javascript &raquo;</a></p>
      <hr>
      <h4 class="muted">Heads up</h4>
      <p class="muted">CSS for button groups is in a separate file, button-groups.less.</p>
    </div>
  </div>
</section>



<!-- Split button dropdowns
================================================== -->
<section id="button-dropdowns">
  <div class="page-header">
    <h1>Buttons dropdowns <small>Contextual dropdown menus built on button groups</small></h1>
  </div>

  <div class="row-fluid">
    <div class="span4">
      <h3>Button dropdowns</h3>
      <p>Use any button to trigger a dropdown menu by placing it within a <code>.btn-group</code> and providing the proper menu markup.</p>
      <div class="btn-toolbar" style="margin-top: 18px;">
        <div class="btn-group">
          <a class="btn dropdown-toggle" data-toggle="dropdown">Action <i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu">
            <li><a>Action</a></li>
            <li><a>Another action</a></li>
            <li><a>Something else here</a></li>
            <li class="divider"></li>
            <li><a>Separated link</a></li>
          </ul>
        </div><!-- /btn-group -->
        <div class="btn-group">
          <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action <i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu">
            <li><a>Action</a></li>
            <li><a>Another action</a></li>
            <li><a>Something else here</a></li>
            <li class="divider"></li>
            <li><a>Separated link</a></li>
          </ul>
        </div><!-- /btn-group -->
        <div class="btn-group">
          <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown">Danger <i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu">
            <li><a>Action</a></li>
            <li><a>Another action</a></li>
            <li><a>Something else here</a></li>
            <li class="divider"></li>
            <li><a>Separated link</a></li>
          </ul>
        </div><!-- /btn-group -->
      </div>
      <div class="btn-toolbar">
        <div class="btn-group">
          <a class="btn btn-success dropdown-toggle" data-toggle="dropdown">Success <i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu">
            <li><a>Action</a></li>
            <li><a>Another action</a></li>
            <li><a>Something else here</a></li>
            <li class="divider"></li>
            <li><a>Separated link</a></li>
          </ul>
        </div><!-- /btn-group -->
        <div class="btn-group">
          <a class="btn btn-info dropdown-toggle" data-toggle="dropdown">Info <i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu">
            <li><a>Action</a></li>
            <li><a>Another action</a></li>
            <li><a>Something else here</a></li>
            <li class="divider"></li>
            <li><a>Separated link</a></li>
          </ul>
        </div><!-- /btn-group -->
      </div>
    </div>
    <div class="span8">
      <h3>Example markup</h3>
      <p>Similar to a button group, our markup uses regular button markup, but with a handful of additions to refine the style and support the dropdown jQuery plugin.</p>
<pre class="prettyprint linenums">
&lt;div class="btn-group"&gt;
  &lt;a class="btn dropdown-toggle" data-toggle="dropdown"&gt;
    Action
    &lt;i class="fa fa-caret-down"&gt;&lt;/i&gt;
  &lt;/a&gt;
  &lt;ul class="dropdown-menu"&gt;
    &lt;!-- dropdown menu links --&gt;
  &lt;/ul&gt;
&lt;/div&gt;
</pre>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span4">
      <h3>Split button dropdowns</h3>
      <p>Building on the button group styles and markup, we can easily create a split button. Split buttons feature a standard action on the left and a dropdown toggle on the right with contextual links.</p>
      <div class="btn-toolbar" style="margin-top: 18px;">
        <div class="btn-group">
          <a class="btn">Action</a>
          <a class="btn dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu">
            <li><a>Action</a></li>
            <li><a>Another action</a></li>
            <li><a>Something else here</a></li>
            <li class="divider"></li>
            <li><a>Separated link</a></li>
          </ul>
        </div><!-- /btn-group -->
        <div class="btn-group">
          <a class="btn btn-primary">Action</a>
          <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu">
            <li><a>Action</a></li>
            <li><a>Another action</a></li>
            <li><a>Something else here</a></li>
            <li class="divider"></li>
            <li><a>Separated link</a></li>
          </ul>
        </div><!-- /btn-group -->
        <div class="btn-group">
          <a class="btn btn-danger">Danger</a>
          <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu">
            <li><a>Action</a></li>
            <li><a>Another action</a></li>
            <li><a>Something else here</a></li>
            <li class="divider"></li>
            <li><a>Separated link</a></li>
          </ul>
        </div><!-- /btn-group -->
      </div>
      <div class="btn-toolbar">
        <div class="btn-group">
          <a class="btn btn-success">Success</a>
          <a class="btn btn-success dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu">
            <li><a>Action</a></li>
            <li><a>Another action</a></li>
            <li><a>Something else here</a></li>
            <li class="divider"></li>
            <li><a>Separated link</a></li>
          </ul>
        </div><!-- /btn-group -->
        <div class="btn-group">
          <a class="btn btn-info">Info</a>
          <a class="btn btn-info dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu">
            <li><a>Action</a></li>
            <li><a>Another action</a></li>
            <li><a>Something else here</a></li>
            <li class="divider"></li>
            <li><a>Separated link</a></li>
          </ul>
        </div><!-- /btn-group -->
      </div>
    </div>
    <div class="span8">
      <h3>Example markup</h3>
      <p>We expand on the normal button dropdowns to provide a second button action that operates as a separate dropdown trigger.</p>
<pre class="prettyprint linenums">
&lt;div class="btn-group"&gt;
  &lt;a class="btn"&gt;Action&lt;/a&gt;
  &lt;a class="btn dropdown-toggle" data-toggle="dropdown"&gt;
    &lt;i class="fa fa-caret-down"&gt;&lt;/i&gt;
  &lt;/a&gt;
  &lt;ul class="dropdown-menu"&gt;
    &lt;!-- dropdown menu links --&gt;
  &lt;/ul&gt;
&lt;/div&gt;
</pre>
    </div>
  </div>
</section>



<!-- Buttons (Widget)
================================================== -->
<section id="buttons">
  <div class="page-header">
    <h1>Buttons <small>bootstrap-button.js</small></h1>
  </div>
  <div class="row-fluid">
    <div class="span3 columns">
      <h3>About</h3>
      <p>Do more with buttons. Control button states or create groups of buttons for more components like toolbars.</p>
      <a href="js/bootstrap-button.js" target="_blank" class="btn">Download file</a>
    </div>
    <div class="span9 columns">
      <h2>Example uses</h2>
      <p>Use the buttons plugin for states and toggles.</p>
      <table class="table table-bordered table-striped">
        <tbody>
         <tr>
           <td>Stateful</td>
           <td>
              <button id="fat-btn" data-loading-text="loading..." class="btn btn-primary">
                Loading State
              </button>
            </td>
         </tr>
         <tr>
           <td>Single toggle</td>
           <td>
              <button class="btn btn-primary" data-toggle="button">Single Toggle</button>
            </td>
         </tr>
         <tr>
           <td>Checkbox</td>
           <td>
              <div class="btn-group" data-toggle="buttons-checkbox">
                <button class="btn btn-primary">Left</button>
                <button class="btn btn-primary">Middle</button>
                <button class="btn btn-primary">Right</button>
              </div>
           </td>
         </tr>
         <tr>
           <td>Radio</td>
           <td>
              <div class="btn-group" data-toggle="buttons-radio">
                <button class="btn btn-primary">Left</button>
                <button class="btn btn-primary">Middle</button>
                <button class="btn btn-primary">Right</button>
              </div>
           </td>
         </tr>
        </tbody>
      </table>
      <hr>
      <h2>Using bootstrap-button.js</h2>
      <p>Enable buttons via javascript:</p>
      <pre class="prettyprint linenums">$(\'.tabs\').button()</pre>
        <h3>Markup</h3>
      <p>Data attributes are integral to the button plugin. Check out the example code below for the various markup types.</p>
<pre class="prettyprint linenums">
&lt;!-- Add data-toggle="button" to activate toggling on a single button --&gt;
&lt;button class="btn" data-toggle="button"&gt;Single Toggle&lt;/button&gt;

&lt;!-- Add data-toggle="buttons-checkbox" for checkbox style toggling on btn-group --&gt;
&lt;div class="btn-group" data-toggle="buttons-checkbox"&gt;
&lt;button class="btn"&gt;Left&lt;/button&gt;
&lt;button class="btn"&gt;Middle&lt;/button&gt;
&lt;button class="btn"&gt;Right&lt;/button&gt;
&lt;/div&gt;

&lt;!-- Add data-toggle="buttons-radio" for radio style toggling on btn-group --&gt;
&lt;div class="btn-group" data-toggle="buttons-radio"&gt;
&lt;button class="btn"&gt;Left&lt;/button&gt;
&lt;button class="btn"&gt;Middle&lt;/button&gt;
&lt;button class="btn"&gt;Right&lt;/button&gt;
&lt;/div&gt;
</pre>
      <h3>Methods</h3>
      <h4>$().button(\'toggle\')</h4>
      <p>Toggles push state. Gives btn the look that it\'s been activated.</p>
      <div class="alert alert-info">
        <strong>Heads up!</strong>
        You can enable auto toggling of a button by using the <code>data-toggle</code> attribute.
      </div>
      <pre class="prettyprint linenums">&lt;button class="btn" data-toggle="button" &gt;…&lt;/button&gt;</pre>
      <h4>$().button(\'loading\')</h4>
      <p>Sets button state to loading - disables button and swaps text to loading text. Loading text should be defined on the button element using the data attribute <code>data-loading-text</code>.
      </p>
      <pre class="prettyprint linenums">&lt;button class="btn" data-loading-text="loading stuff..." &gt;...&lt;/button&gt;</pre>
      <div class="alert alert-info">
        <strong>Heads up!</strong>
        <a href="https://github.com/twitter/bootstrap/issues/793">Firefox persists the disabled state across page loads</a>. A workaround for this is to use <code>autocomplete="off"</code>.
      </div>
      <h4>$().button(\'reset\')</h4>
      <p>Resets button state - swaps text to original text.</p>
      <h4>$().button(string)</h4>
      <p>Resets button state - swaps text to any data defined text state.</p>
<pre class="prettyprint linenums">&lt;button class="btn" data-complete-text="finished!" &gt;...&lt;/button&gt;
&lt;script&gt;
$(\'.btn\').button(\'complete\')
&lt;/script&gt;</pre>
    </div>
  </div>
</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',
    _render: function() {
        this._super(\'_render\');
        // button state demo
        this.$(\'#fat-btn\').click(function () {
            var btn = $(this);
            btn.button(\'loading\');
            setTimeout(function () {
              btn.button(\'reset\');
            }, 3000);
        })
    }
})
',
    ),
  ),
  'docs-charts-circular' => 
  array (
    'templates' => 
    array (
      'docs-charts-circular' => '
<section id="circular">
  <div class="page-header">
    <h2>Circular Charts <small>used for comparing parts to a whole</small></h2>
  </div>
  <div class="row-fluid">
    <div class="span6">
      <h3>Pie Chart</h3>
      <p>Example pie chart. [<a href="styleguide/content/charts/pieChart.html" target="_blank">Full Screen</a> | <a href="styleguide/content/charts/pieChart_colors.html" target="_blank">Color Options</a>]</p>
      <div>
<div id="pie" class="nv-chart">
<svg></svg>
</div>
      </div>
    </div>
    <div class="span6">
      <h3>Donut Chart</h3>
      <p>Example donut chart.</p>
      <div>
<div id="donut" class="nv-chart">
<svg></svg>
</div>
      </div>
    </div>
  </div>
</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
  className: \'container-fluid\',

  // charts circular
  _renderHtml: function() {
    this._super(\'_renderHtml\');

    // Pie Chart
    d3.json(\'styleguide/content/charts/data/pie_data.json\', function(data) {
      nv.addGraph(function() {
        var chart = nv.models.pieChart()
              .x(function(d) { return d.key })
              .y(function(d) { return d.value })
              .showLabels(true)
              .showTitle(false)
              .direction(app.lang.direction)
              .colorData(\'default\')
              .tooltipContent(function(key, x, y, e, graph) {
                return \'<p>Stage: <b>\' + key + \'</b></p>\' +
                       \'<p>Amount: <b>$\' + parseInt(y) + \'K</b></p>\' +
                       \'<p>Percent: <b>\' + x + \'%</b></p>\';
              });

          d3.select(\'#pie svg\')
              .datum(data)
            .transition().duration(500)
              .call(chart);

        return chart;
      });
    });

    // Donut Chart
    d3.json(\'styleguide/content/charts/data/pie_data.json\', function(data) {
      nv.addGraph(function() {
        var chart = nv.models.pieChart()
              .x(function(d) { return d.key })
              .y(function(d) { return d.value })
              .showLabels(true)
              .showTitle(false)
              .donut(true)
              .donutRatio(0.4)
              .donutLabelsOutside(true)
              .hole(10)
              .direction(app.lang.direction)
              .colorData(\'default\')
              .tooltipContent(function(key, x, y, e, graph) {
                return \'<p>Stage: <b>\' + key + \'</b></p>\' +
                       \'<p>Amount: <b>$\' + parseInt(y) + \'K</b></p>\' +
                       \'<p>Percent: <b>\' + x + \'%</b></p>\';
              });

          d3.select(\'#donut svg\')
              .datum(data)
            .transition().duration(1200)
              .call(chart);

        return chart;
      });
    });
  }
})
',
    ),
  ),
  'docs-layouts-drawer' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // layouts drawer
    _renderHtml: function () {
        this._super(\'_renderHtml\');

        this.$(\'#sg_open_drawer\').on(\'click.styleguide\', function(){
            app.drawer.open({
                layout: \'create\',
                context: {
                    create: true,
                    model: app.data.createBean(\'Styleguide\')
                }
            });
        });
    },

    _dispose: function() {
        this.$(\'#sg_open_drawer\').off(\'click.styleguide\');

        this._super(\'_dispose\');
    }
})
',
    ),
    'templates' => 
    array (
      'docs-layouts-drawer' => '
<!-- Drawers
================================================== -->
<section id="drawer">
  <div class="page-header">
    <h1>Drawers</h1>
  </div>
  <div class="row-fluid">
    <div class="span3 columns">
      <h3>About drawers</h3>
      <p>Drawer is a form of a modal that pushes main content down and expands from the top taking 100% of the screen width.
        It is used for various Create work flows. Content that was on screen prior to drawer trigger is visible in the drawer
        on the bottom part of the screen.
      </p>
    </div>
    <div class="span9 columns">
      <h2>Example</h2>
      <p><button class="btn btn-primary" id="sg_open_drawer">Open a Drawer</button></p>
    </div>
  </div>
</section>
',
    ),
  ),
  'docs-layouts-modals' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // layouts modals
    _renderHtml: function () {
        this._super(\'_renderHtml\');

        this.$(\'[rel=popover]\').popover();

        this.$(\'.modal\').tooltip({
          selector: \'[rel=tooltip]\'
        });
        this.$(\'#dp1\').datepicker({
          format: \'mm-dd-yyyy\'
        });
        this.$(\'#dp3\').datepicker();
        this.$(\'#tp1\').timepicker();
    }
})
',
    ),
    'templates' => 
    array (
      'docs-layouts-modals' => '
<!-- Modal
================================================== -->
<section id="modals">
  <div class="page-header">
    <h1>Modals <small>bootstrap-modal.js</small></h1>
  </div>
  <div class="row-fluid">
    <div class="span3 columns">
      <h3>About modals</h3>
      <p>A streamlined, but flexible, take on the traditional javascript modal plugin with only the minimum required functionality and smart defaults.</p>
      <p>The bootsrap-modal.js plugin is included in the default build of SugarCRM.</p>
    </div>
    <div class="span9 columns">
      <h2>Static example</h2>
      <p>Below is a statically rendered modal.</p>
      <div class="well modal-example" style="background-color: #888; border: none;">
        <div class="modal" style="position: relative; top: auto; left: auto; margin: 0 auto; z-index: 1">
          <div class="modal-header">
            <a class="close" data-dismiss="modal">&times;</a>
            <h3>Modal header</h3>
          </div>
          <div class="modal-body">
            <div class="modal-content">
              <p>One fine body…</p>
            </div>
            <div class="modal-footer">
              <a class="btn btn-invisible btn-link pull-left">Cancel</a>
              <a class="btn btn-primary">Save changes</a>
            </div>
          </div>
        </div>
      </div> <!-- /well -->

      <h2>Live demo</h2>
      <p>Toggle a modal via javascript by clicking the button below. It will slide down and fade in from the top of the page.</p>

      <!-- sample modal content -->
      <div id="myModal" class="modal hide fade">
        <div class="modal-header">
          <a class="close" data-dismiss="modal" >&times;</a>
          <h3>Modal Heading</h3>
        </div>
        <div class="modal-body">
          <!-- <div class="modal-content"> -->
            <h4>Text in a modal</h4>
            <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem.</p>

            <h4>Popover in a modal</h4>
            <p>This <a class="btn popover-test" rel="popover" title="A Title" data-content="And here\'s some amazing content. It\'s very engaging. right?">button</a> should trigger a popover on hover.</p>

            <h4>Tooltips in a modal</h4>
            <p><a rel="tooltip" title="Tooltip">This link</a> and <a rel="tooltip" title="Tooltip">that link</a> should have tooltips on hover.</p>
            <h4>Text in a modal</h4>
            <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem.</p>
          <!-- </div> -->
          <div class="modal-footer">
            <a class="btn btn-invisible btn-link pull-left" data-dismiss="modal">Cancel</a>
            <a class="btn btn-primary">Save changes</a>
          </div>
        </div>
      </div>

      <a data-toggle="modal" href="#myModal" class="btn btn-primary btn-large">Launch demo modal</a>

      <hr>

      <h2>Using bootstrap-modal</h2>
      <p>Call the modal via javascript:</p>
      <pre class="prettyprint linenums">$(\'#myModal\').modal(options)</pre>
      <h3>Options</h3>
      <table class="table table-bordered table-striped">
        <thead>
         <tr>
           <th style="width: 100px;">Name</th>
           <th style="width: 50px;">type</th>
           <th style="width: 50px;">default</th>
           <th>description</th>
         </tr>
        </thead>
        <tbody>
         <tr>
           <td>backdrop</td>
           <td>boolean</td>
           <td>true</td>
           <td>Includes a modal-backdrop element</td>
         </tr>
         <tr>
           <td>keyboard</td>
           <td>boolean</td>
           <td>true</td>
           <td>Closes the modal when escape key is pressed</td>
         </tr>
        </tbody>
      </table>
      <h3>Markup</h3>
      <p>You can activate modals on your page easily without having to write a single line of javascript. Just set <code>data-toggle="modal"</code> on a controller element with a <code>data-target="#foo"</code> or <code>href="#foo"</code> which corresponds to a modal element id, and when clicked, it will launch your modal.</p>
      <p>Also, to add options to your modal instance, just include them as additional data attributes on either the control element or the modal markup itself.</p>
<pre class="prettyprint linenums">
&lt;a class="btn" data-toggle="modal" href="#myModal"&gt;Launch Modal&lt;/a&gt;
</pre>

<pre class="prettyprint linenums">
&lt;div class="modal spanX"&gt;
  &lt;div class="modal-header"&gt;
    &lt;a class="close" data-dismiss="modal"&gt;&times;&lt;/a&gt;
    &lt;h3&gt;Modal header&lt;/h3&gt;
  &lt;/div&gt;
  &lt;div class="modal-body"&gt;
    <!-- &lt;div class="modal-content"&gt; -->
      &lt;p&gt;One fine body…&lt;/p&gt;
    <!-- &lt;/div&gt; -->
    &lt;div class="modal-footer"&gt;
      &lt;a class="btn btn-invisible btn-link pull-left"&gt;Cancel&lt;/a&gt;
      &lt;a class="btn btn-primary"&gt;Save changes&lt;/a&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
</pre>
      <div class="alert alert-info">
        <strong>Important Changes!</strong> The foooter has moved inside the <code>div.modal-body</code> element and a required <code>&lt;div&gt;</code> element now wraps the modal content. If you want to support vertical scrolling of the modal content, add the <code>modal.scroll</code> to that div.
      </div>

      <!-- sample modal content -->
      <div id="myModal-sidecar" class="modal hide fade">
        <div>
          <div class="modal-header header">
            <div class="buttons pull-right">
                <a href="javascript:void(0);" class="close" data-dismiss="modal" data-original-title="Close"><i class="fa fa-times fa-sm"></i></a>
            </div>
            <h3 class="title">
                Mass Update
            </h3>
          </div>
        </div>
        <div class="modal-body modal-scroll-content">
          <div class="layout_Accounts">
            <!-- <div style="padding:8px;height:28px;border-bottom:1px solid #ededed">
              <a class="btn">Submit</a>
            </div> -->
            <div>
              <div class="modal-content">
                 <!-- style="overflow:scroll;max-height:382px" -->
                <h4>Text in a modal</h4>
                <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem.</p>

                <h4>Popover in a modal</h4>
                <p>This <a class="btn popover-test" rel="popover" title="A Title" data-content="And here\'s some amazing content. It\'s very engaging. right?">button</a> should trigger a popover on hover.</p>

                <h4>Tooltips in a modal</h4>
                <p><a rel="tooltip" title="Tooltip">This link</a> and <a rel="tooltip" title="Tooltip">that link</a> should have tooltips on hover.</p>
                <h4>Text in a modal</h4>
                <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem.</p>

                <h4>Datepicker on span in a modal</h4>
                <div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="mm-dd-yyyy" rel="datepicker">
                  <input class="span2" size="16" type="text" value="" placeholder="mm-dd-yyyy">
                  <span class="add-on"><i class="fa fa-calendar"></i></span>
                </div>

                <h4>Datepicker and Timepicker on input in a modal</h4>
                <p><a rel="tooltip" title="Tooltip">This link</a> and <a rel="tooltip" title="Tooltip">that link</a> should have tooltips on hover.</p>
                <div class="well" style="position:relative">
                  <input type="text" class="span2" value="" placeholder="mm-dd-yyyy" id="dp1" rel="datepicker">
                  <input type="text" class="span2" placeholder="hh:mm" id="tp1" rel="timepicker">
                </div>

                <h4>Popover in a modal</h4>
                <p>This <a class="btn popover-test" rel="popover" title="A Title" data-content="And here\'s some amazing content. It\'s very engaging. right?">button</a> should trigger a popover on hover.</p>

                <h4>Tooltips in a modal</h4>
                <p><a rel="tooltip" title="Tooltip">This link</a> and <a rel="tooltip" title="Tooltip">that link</a> should have tooltips on hover.</p>
                <h4>Text in a modal</h4>
                <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem.</p>

                <h4>Popover in a modal</h4>
                <p>This <a class="btn popover-test" rel="popover" title="A Title" data-content="And here\'s some amazing content. It\'s very engaging. right?">button</a> should trigger a popover on hover.</p>

                <h4>Tooltips in a modal</h4>
                <p><a rel="tooltip" title="Tooltip">This link</a> and <a rel="tooltip" title="Tooltip">that link</a> should have tooltips on hover.</p>
                <h4>Text in a modal</h4>
                <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem.</p>

                <h4>Popover in a modal</h4>
                <p>This <a class="btn popover-test" rel="popover" title="A Title" data-content="And here\'s some amazing content. It\'s very engaging. right?">button</a> should trigger a popover on hover.</p>

                <h4>Tooltips in a modal</h4>
                <p><a rel="tooltip" title="Tooltip">This link</a> and <a rel="tooltip" title="Tooltip">that link</a> should have tooltips on hover.</p>
                <h4>Text in a modal</h4>
                <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem.</p>

                <h4>Popover in a modal</h4>
                <p>This <a class="btn popover-test" rel="popover" title="A Title" data-content="And here\'s some amazing content. It\'s very engaging. right?">button</a> should trigger a popover on hover.</p>

                <h4>Tooltips in a modal</h4>
                <p><a rel="tooltip" title="Tooltip">This link</a> and <a rel="tooltip" title="Tooltip">that link</a> should have tooltips on hover.</p>
              </div>
              <div class="modal-footer">
                <a class="btn btn-invisible btn-link pull-left" data-dismiss="modal">Cancel</a>
                <a class="btn btn-primary">Save changes</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <a data-toggle="modal" href="#myModal-sidecar" class="btn btn-primary btn-large">Launch sidecar modal</a>

      <hr>

      <div class="alert alert-info">
        <strong>Now With Widths!</strong> The outer modal div element now supports standards widths using the <code>.spanX</code> classes.
      </div>

      <!-- sample modal content -->
      <div id="myModal-wide" class="modal hide fade span12">
        <div class="modal-header">
          <a class="close" data-dismiss="modal" >&times;</a>
          <h3>Modal Heading</h3>
        </div>
        <div class="modal-body">
            <h4>Big Paragraph</h4>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>

            <h4>Big Paragraph</h4>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>
          <div class="modal-footer">
            <a class="btn btn-invisible btn-link pull-left" data-dismiss="modal">Cancel</a>
            <a class="btn btn-primary">Save changes</a>
          </div>
        </div>
      </div>
      <a data-toggle="modal" href="#myModal-wide" class="btn btn-primary btn-large">Launch wide modal</a>

      <hr>

      <div class="alert alert-info">
        <strong>Heads up!</strong> If you want your modal to animate in and out, just add a <code>.fade</code> class to the <code>.modal</code> element (refer to the demo to see this in action) and include bootstrap-transition.js.
      </div>
      <h3>Methods</h3>
      <h4>.modal(options)</h4>
      <p>Activates your content as a modal. Accepts an optional options <code>object</code>.</p>
<pre class="prettyprint linenums">
$(\'#myModal\').modal({
  keyboard: false
})</pre>
      <h4>.modal(\'toggle\')</h4>
      <p>Manually toggles a modal.</p>
      <pre class="prettyprint linenums">$(\'#myModal\').modal(\'toggle\')</pre>
      <h4>.modal(\'show\')</h4>
      <p>Manually opens a modal.</p>
      <pre class="prettyprint linenums">$(\'#myModal\').modal(\'show\')</pre>
      <h4>.modal(\'hide\')</h4>
      <p>Manually hides a modal.</p>
      <pre class="prettyprint linenums">$(\'#myModal\').modal(\'hide\')</pre>
      <h3>Events</h3>
      <p>Modal class exposes a few events for hooking into modal functionality.</p>
      <table class="table table-bordered table-striped">
        <thead>
         <tr>
           <th style="width: 150px;">Event</th>
           <th>Description</th>
         </tr>
        </thead>
        <tbody>
         <tr>
           <td>show</td>
           <td>This event fires immediately when the <code>show</code> instance method is called.</td>
         </tr>
         <tr>
           <td>shown</td>
           <td>This event is fired when the modal has been made visible to the user (will wait for css transitions to complete).</td>
         </tr>
         <tr>
           <td>hide</td>
           <td>This event is fired immediately when the <code>hide</code> instance method has been called.</td>
         </tr>
         <tr>
           <td>hide</td>
           <td>This event is fired when the modal has finished being hidden from the user (will wait for css transitions to complete).</td>
         </tr>
        </tbody>
      </table>

<pre class="prettyprint linenums">
$(\'#myModal\').on(\'hide\', function () {
  // do something…
})</pre>
    </div>
  </div>
</section>
',
    ),
  ),
  'docs-forms-jstree' => 
  array (
    'templates' => 
    array (
      'docs-forms-jstree' => '
<!-- jstree
================================================== -->
<section id="jstree">
    <div class="page-header">
        <h1>JSTree <small>tree control component built with jsTree jQuery plugin</small></h1>
    </div>
    <div class="row-fluid">
        <div class="span3 columns">
            <h3>About</h3>
            <p>jsTree is a javascript based, cross browser tree component.</p>
            <p>The jquery.jstree.js plugin is included in the default build of SugarCRM. [<a href="http://www.jstree.com/documentation"><i class="fa fa-book"></i> Docs</a>]</p>
        </div>
        <div class="span9 columns">
            <h2>Example</h2>
            <p>Click on the folder icons to expand/collapse children</p>
            <div id="people">
            </div>
            <hr>
            <h2>Using jquery.jstree.js</h2>
            <p>Call jstree via javascript:</p>
<pre class="prettyprint linenums">
$("#people").jstree({
    // generating tree from json data
    "json_data" : {
        "data" : [
            {
                "data" : "Sabra Khan",
                "state" : "open",
                "metadata" : { id : 1 },
                "children" : [
                    {"data" : "Mark Gibson","metadata" : { id : 2 }},
                    {"data" : "James Joplin","metadata" : { id : 3 }},
                    {"data" : "Terrence Li","metadata" : { id : 4 }},
                    {
                        "data" : "Amy McCray",
                        "metadata" : { id : 5 },
                        "children" : [
                            {"data" : "Troy McClure","metadata" : {id : 6}},
                            {"data" : "James Kirk","metadata" : {id : 7}}
                        ]
                    }
                ]
            }
        ]
    },
    // plugins used for this tree
    "plugins" : [ "json_data", "ui", "types" ]
})
.bind("loaded.jstree", function () {
    // do stuff when tree is loaded
    $("#people").addClass("jstree-sugar");
    $("#people > ul").addClass("list");
    $("#people > ul > li > a").addClass("jstree-clicked");
})
.bind("select_node.jstree", function (e, data) {
    // do stuff when a node is selected
    data.inst.toggle_node(data.rslt.obj);
});</pre>
            <h3>Plugins</h3>
            As of version 1.0 jsTree is extremely plugin friendly, so all functionality is now wrapped in plugins, which take care of various aspects of the tree and can be removed without affecting the functionality of other plugins. Below you will find a list of plugins - each with its own documentation page. Probably a good place to start is the core.
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th style="width: 100px;">Name</th>
                    <th>description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><a href="http://www.jstree.com/documentation/html_data" target="_blank">HTML_DATA plugin</a></td>
                    <td>enables jsTree to convert nested unordered lists to interactive trees, an already existing UL may be used or data could be retrieved from a server</td>

                </tr>
                <tr>
                    <td><a href="http://www.jstree.com/documentation/json_data" target="_blank">JSON_DATA plugin</a></td>
                    <td>enables jsTree to convert JSON objects to interactive trees, data can be set up in the config or retrieved from a server.</td>
                </tr>
                <tr>
                    <td><a href="http://www.jstree.com/documentation/xml_data" target="_blank">XML_DATA plugin</a></td>
                    <td>enables jsTree to convert XML objects to interactive trees (using XSL), data can be set up in the config or retrieved from a server</td>
                </tr>
                <!--tr>
                    <td>Themes plugin</td>
                    <td>controls the looks of jstree - without this plugin you will get a functional tree, but it will look just like an ordinary UL list</td>
                </tr-->
                <tr>
                    <td><a href="http://www.jstree.com/documentation/ui" target="_blank">UI plugin</a></td>
                    <td>handles selecting, deselecting and hovering tree items</td>
                </tr>
                <tr>
                    <td><a href="http://www.jstree.com/documentation/crrm" target="_blank">CRRM plugin</a></td>
                    <td>handles creating, renaming, removing and moving nodes by the user, also includes cut/copy/paste functions</td>
                </tr>
                <tr>
                    <td><a href="http://www.jstree.com/documentation/hotkeys" target="_blank">Hotkeys plugin</a></td>
                    <td>enables support for keyboard navigation & shortcuts, highly configurable</td>
                </tr>
                <tr>
                    <td><a href="http://www.jstree.com/documentation/languages" target="_blank">Languages plugin</a></td>
                    <td>enables multilanguage support - each node can have multiple titles, but only one is visible</td>
                </tr>
                <tr>
                    <td><a href="http://www.jstree.com/documentation/cookies" target="_blank">Cookies plugin</a></td>
                    <td>enables jstree to save the state of the tree across sessions, by saving selected and opened nodes in a cookie</td>
                </tr>
                <tr>
                    <td><a href="http://www.jstree.com/documentation/sort" target="_blank">Sort plugin</a></td>
                    <td>enables jstree to automatically sort all nodes
                        using a specified function</td>
                </tr>
                <tr>
                    <td><a href="http://www.jstree.com/documentation/dnd" target="_blank">DND plugin</a></td>
                    <td>enables drag\'n\'drop support for jstree, also using foreign nodes and drop targets</td>
                </tr>
                <tr>
                    <td><a href="http://www.jstree.com/documentation/checkbox" target="_blank">Checkbox plugin</a></td>
                    <td>makes multiselection possible using three-state checkboxes</td>
                </tr>
                <tr>
                    <td><a href="http://www.jstree.com/documentation/search" target="_blank">Search plugin</td>
                    <td>enables searching for nodes whose title contains a given string, works on async trees too</td>
                </tr>
                <tr>
                    <td><a href="http://www.jstree.com/documentation/contextmenu" target="_blank">Contextmenu plugin</a></td>
                    <td>enables a multilevel context menu on tree items</td>
                </tr>
                <tr>
                    <td><a href="http://www.jstree.com/documentation/types" target="_blank">Types plugin</a></td>
                    <td>each node can have a type, and you can define rules on how that type should behave</td>
                </tr>
                <tr>
                    <td><a href="http://www.jstree.com/documentation/themeroller" target="_blank">Themeroller plugin</a></td>
                    <td>adds support for jQuery UI\'s themes</td>
                </tr>
                <tr>
                    <td><a href="http://www.jstree.com/documentation/unique" target="_blank">Unique plugin</a></td>
                    <td>adds unique checking to jsTree</td>
                </tr>
                </tbody>
            </table>

            <h3>Markup</h3>
            <p>The basic structure you need when generating a tree from JSON data.</p>
<pre class="prettyprint linenums">
&lt;div id="people"&gt;&lt;/div&gt;
</pre>
        </div>
    </div>
</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // forms jstree
    _renderHtml: function () {
        var self = this;

        this._super(\'_renderHtml\');

        this.$(\'#people\').jstree({
            "json_data" : {
                "data" : [
                    {
                        "data" : "Sabra Khan",
                        "state" : "open",
                        "metadata" : { id : 1 },
                        "children" : [
                            {"data" : "Mark Gibson","metadata" : { id : 2 }},
                            {"data" : "James Joplin","metadata" : { id : 3 }},
                            {"data" : "Terrence Li","metadata" : { id : 4 }},
                            {"data" : "Amy McCray",
                                "metadata" : { id : 5 },
                                "children" : [
                                    {"data" : "Troy McClure","metadata" : {id : 6}},
                                    {"data" : "James Kirk","metadata" : {id : 7}}
                                ]
                            }
                        ]
                    }
                ]
            },
            // "themes" : { "theme" : "default", "dots" : false },
            "plugins" : [ "json_data", "ui", "types" ]
        })
        .bind(\'loaded.jstree\', function () {
            // do stuff when tree is loaded
            self.$(\'#people\').addClass(\'jstree-sugar\');
            self.$(\'#people > ul\').addClass(\'list\');
            self.$(\'#people > ul > li > a\').addClass(\'jstree-clicked\');
        })
        .bind(\'select_node.jstree\', function (e, data) {
            data.inst.toggle_node(data.rslt.obj);
        });
    }
})
',
    ),
  ),
  'headerpane' => 
  array (
    'meta' => 
    array (
      'buttons' => 
      array (
        0 => 
        array (
          'name' => 'create_button',
          'type' => 'button',
          'label' => 'LBL_CREATE_BUTTON_LABEL',
          'css_class' => 'btn-primary',
          'acl_action' => 'create',
          'route' => 
          array (
            'action' => 'create',
          ),
        ),
        1 => 
        array (
          'name' => 'import_vcard_button',
          'type' => 'button',
          'label' => 'LBL_IMPORT_VCARD',
          'css_class' => 'btn-primary',
          'acl_action' => 'import',
          'events' => 
          array (
            'click' => 'function(e){
                    app.drawer.open({
                            layout : "vcard-import",
                            context: {
                                create: true
                            }
                        });
                    }',
          ),
        ),
        2 => 
        array (
          'name' => 'sidebar_toggle',
          'type' => 'sidebartoggle',
        ),
      ),
    ),
  ),
  'docs-charts-custom' => 
  array (
    'templates' => 
    array (
      'docs-charts-custom' => '
<section id="custom">
  <div class="page-header">
    <h2>Custom Charts <small>used for comparing values in a process</small></h2>
  </div>

  <div class="row-fluid">
    <div class="span6">
      <h3>Pipeline By Sales Stage</h3>
      <p>A new NVD3 funnel chart type created for SugarCRM. [<a href="styleguide/content/charts/funnelChart.html" target="_blank">Full Screen</a> | <a href="styleguide/content/charts/funnelChart_colors.html" target="_blank">Color Options</a>]</p>
      <div>
<div id="funnel1" class="thumbnail nv-chart">
<svg></svg>
</div>
      </div>
    </div>
    <div class="span6">
      <h3>Closed Won Opportunities</h3>
      <p>A new NVD3 gauge chart type created for SugarCRM. [<a href="styleguide/content/charts/gaugeChart.html" target="_blank">Full Screen</a> | <a href="styleguide/content/charts/gaugeChart_colors.html" target="_blank">Color Options</a>]</p>
      <div>
<div id="gauge" class="thumbnail nv-chart">
<svg></svg>
</div>
      </div>
    </div>
  </div>

  <div class="row-fluid" style="margin-top:8px">
    <div class="span6">
      <h3>Treemap Chart</h3>
      <p>A new NVD3 treemap chart type created for SugarCRM. [<a href="styleguide/content/charts/treemapChart.html" target="_blank">Full Screen</a> | <a href="styleguide/content/charts/treemapChart_colors.html" target="_blank">Color Options</a>]</p>
      <div>
<div id="treemap1" class="thumbnail nv-chart nv-treemap">
<svg></svg>
</div>
      </div>
    </div>
    <div class="span6">
      <h3>Opportunities</h3>
      <p>A new NVD3 treemap chart type created for SugarCRM. [<a href="styleguide/content/charts/treemapChart_opportunities.html" target="_blank">Full Screen</a>]</p>
      <div>
<div id="treemap2" class="thumbnail nv-chart nv-treemap">
<svg></svg>
</div>
      </div>
    </div>
  </div>

  <div class="row-fluid" style="margin-top:8px">
    <div class="span6">
      <h3>Org Chart</h3>
      <p>A new NVD3 tree chart type created for SugarCRM. [<a href="styleguide/content/charts/orgChart.html" target="_blank">Full Screen</a>]</p>
      <div>
<div id="org" class="thumbnail nv-chart nv-chart-org">
<svg></svg>
</div>
      </div>
    </div>
    <div class="span6">
      <h3>Bubble Chart</h3>
      <p>A new NVD3 tree chart type created for SugarCRM. [<a href="styleguide/content/charts/bubbleChart.html" target="_blank">Full Screen</a> | <a href="styleguide/content/charts/bubbleChart_colors.html" target="_blank">Color Options</a>]</p>
      <div>
<div id="bubble" class="thumbnail nv-chart nv-bubble">
<svg></svg>
</div>
      </div>
    </div>
  </div>
</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
  className: \'container-fluid\',

  // charts custom
  _renderHtml: function() {
    this._super(\'_renderHtml\');

    // Funnel Chart
    d3.json(\'styleguide/content/charts/data/funnel_data.json\', function(data) {
      nv.addGraph(function() {
        var chart = nv.models.funnelChart()
              .showTitle(false)
              .direction(app.lang.direction)
              .fmtValueLabel(function(d) { return \'$\' + (d.label || d.value || d) + \'K\'; })
              .tooltipContent(function(key, x, y, e, graph) {
                return \'<p>Stage: <b>\' + key + \'</b></p>\' +
                       \'<p>Amount: <b>$\' + parseInt(y, 10) + \'K</b></p>\' +
                       \'<p>Percent: <b>\' + x + \'%</b></p>\';
              });

        d3.select(\'#funnel1 svg\')
            .datum(data)
          .transition().duration(500)
            .call(chart);

        return chart;
      });
    });

    // Gauge Chart
    d3.json(\'styleguide/content/charts/data/gauge_data.json\', function(data) {
      nv.addGraph(function() {
        var gauge = nv.models.gaugeChart()
              .x(function(d) { return d.key; })
              .y(function(d) { return d.y; })
              .showLabels(true)
              .showTitle(false)
              .colorData(\'default\')
              .ringWidth(50)
              .maxValue(9)
              .direction(app.lang.direction)
              .transitionMs(4000);

        d3.select(\'#gauge svg\')
            .datum(data)
          .transition().duration(500)
            .call(gauge);

        return gauge;
      });
    });

    // Treemap flare chart
    d3.json(\'styleguide/content/charts/data/flare.json\', function(data) {
      nv.addGraph(function() {

        var chart = nv.models.treemapChart()
              .leafClick(function(d) {
                alert(\'leaf clicked\');
              })
              .showTitle(false)
              .tooltips(true)
              .getSize(function(d) { return d.size; })
              .direction(app.lang.direction)
              .colorData(\'default\');

        d3.select(\'#treemap1 svg\')
            .datum(data)
          .transition().duration(500)
            .call(chart);

        return chart;
      });
    });

    // Tree org chart
    d3.json(\'styleguide/content/charts/data/tree_data.json\', function(data) {
      nv.addGraph(function() {

        var nodeRenderer = function(d) {
          return \'<img src="styleguide/content/charts/img/\' + d.image +
            \'" class="rep-avatar" width="32" height="32"><div class="rep-name">\' + d.name +
            \'</div><div class="rep-title">\' + d.title + \'</div>\';
        };

        var chart = nv.models.tree()
              .duration(300)
              .nodeSize({ \'width\': 124, \'height\': 56 })
              .nodeRenderer(nodeRenderer)
              .zoomExtents({ \'min\': 0.25, \'max\': 4 });

        d3.select(\'#org svg\')
            .datum(data)
          .transition().duration(700)
            .call(chart);

        nv.utils.windowResize(function() { chart.resize(); });

        return chart;
      });
    });

    // Bubble chart
    nv.addGraph(function() {
      var format = d3.time.format(\'%Y-%m-%d\'),
          now = new Date(),
          duration = 12,
          startDate = new Date(now.getFullYear(), (duration === 12 ? 0 : Math.ceil((now.getMonth()) / 3) - 1 + duration), 1),
          endDate = new Date(now.getFullYear(), (duration === 12 ? 12 : startDate.getMonth() + 3), 0),
          dateRange = [startDate, endDate];

      d3.json(\'styleguide/content/charts/data/bubble_data.json\', function(data) {
        /*var bubble_data = {
              data: d3.nest()
                      .key(function(d){ return d.assigned_user_name;})
                      .entries(
                          json.records
                              .filter(function(d){
                                  var oppDate = Date.parse(d.date_closed);
                                  return  oppDate >= dateRange[0] && oppDate <= dateRange[1];
                              })
                              .slice(0,10)
                              .map(function(d){
                                  return {
                                      id: d.id,
                                      x: d.date_closed,
                                      y: parseInt(d.amount,10),
                                      shape: \'circle\',
                                      account_name: d.account_name,
                                      assigned_user_name: d.assigned_user_name,
                                      sales_stage: d.sales_stage,
                                      probability: d.probability
                                  };
                              })
                      ),
              properties: { title: "Top 10 Opportunities", value: json.records.length }
        };*/
        //chart.colorData( \'graduated\', {c1: \'#e8e2ca\', c2: \'#3e6c0a\', l: bubble_data.data.length} );

        var chart = nv.models.bubbleChart()
            .x(function(d) { return format.parse(d.x); })
            .y(function(d) { return d.y; })
            .tooltipContent(function(key, x, y, e, graph) {
                return \'<p>Assigned: <b>\' + key + \'</b></p>\' +
                       \'<p>Amount: <b>$\' + d3.format(\',.02d\')(e.point.opportunity) + \'</b></p>\' +
                       \'<p>Cloase Date: <b>\' + d3.time.format(\'%x\')(format.parse(e.point.x)) + \'</b></p>\';
              })
            .showTitle(false)
            .tooltips(true)
            .showLegend(true)
            .direction(app.lang.direction)
            .colorData(\'graduated\', {c1: \'#d9edf7\', c2: \'#134158\', l: data.data.length});

        d3.select(\'#bubble svg\')
            .datum(data)
          .transition().duration(500)
            .call(chart);

        nv.utils.windowResize(chart.update);

        return chart;
      });

    });

    // Treemap opportunities chart
    d3.json(\'styleguide/content/charts/data/treemap_data.json\', function(data) {
      nv.addGraph(function() {
        var chart = nv.models.treemapChart()
              .leafClick(function(d) { alert(\'leaf clicked\'); })
              .getSize(function(d) { return d.value; })
              .showTitle(false)
              .tooltips(false)
              .direction(app.lang.direction)
              .colorData(\'class\');
        d3.select(\'#treemap2 svg\')
            .datum(parseData(data.records))
          .transition().duration(500)
            .call(chart);
        return chart;
      });
    });

    function parseData(data) {
      var root = {
            name: \'Opportunities\',
            children: [],
            x: 0,
            y: 0,
            dx: parseInt(document.getElementById(\'treemap2\').offsetWidth, 10),
            dy: parseInt(document.getElementById(\'treemap2\').offsetHeight, 10),
            depth: 0,
            colorIndex: \'0root_Opportunities\'
          },
          colorIndices = [\'0root_Opportunities\'],
          colors = d3.scale.category20().range();

      var today = new Date();
          today.setUTCHours(0, 0, 0, 0);

      var day_ms = 1000 * 60 * 60 * 24,
          d1 = new Date(today.getTime() + 31 * day_ms);

      var data = data.filter(function(model) {
        // Filter for 30 days from now.
        var d2 = new Date(model.date_closed || \'1970-01-01\');
        return (d2 - d1) / day_ms <= 30;
      }).map(function(d) {
        // Include properties to be included in leaves
        return {
          assigned_user_name: d.assigned_user_name,
          sales_stage: d.sales_stage,
          name: d.name,
          amount_usdollar: d.amount_usdollar,
          color: d.color
        };
      });

      data = _.groupBy(data, function(m) {
        return m.assigned_user_name;
      });

      _.each(data, function(value, key, list) {
        list[key] = _.groupBy(value, function(m) {
          return m.sales_stage;
        });
      });

      _.each(data, function(value1, key1) {
        var child = [];
        _.each(value1, function(value2, key2) {
          if (colorIndices.indexOf(\'2oppgroup_\' + key2) === -1) {
            colorIndices.push(\'2oppgroup_\' + key2);
          }
          _.each(value2, function(record) {
            record.className = \'stage_\' + record.sales_stage.toLowerCase().replace(\' \', \'\');
            record.value = parseInt(record.amount_usdollar, 10);
            record.colorIndex = \'2oppgroup_\' + key2;
          });
          child.push({
            name: key2,
            className: \'stage_\' + key2.toLowerCase().replace(\' \', \'\'),
            children: value2,
            colorIndex: \'2oppgroup_\' + key2
          });
        });
        if (colorIndices.indexOf(\'1rep_\' + key1) === -1) {
          colorIndices.push(\'1rep_\' + key1);
        }
        root.children.push({
          name: key1,
          children: child,
          colorIndex: \'1rep_\' + key1
        });
      });

      function accumulate(d) {
        if (d.children) {
          return d.value = d.children.reduce(function(p, v) { return p + accumulate(v); }, 0);
        }
        return d.value;
      }

      accumulate(root);

      colorIndices.sort(d3.ascending());

      //build color indexes
      function setColorIndex(d) {
        var i, l;
        d.colorIndex = colorIndices.indexOf(d.colorIndex);
        if (d.children) {
          l = d.children.length;
          for (i = 0; i < l; i += 1) {
            setColorIndex(d.children[i]);
          }
        }
      }

      setColorIndex(root);

      return root;
    }
  }
})
',
    ),
  ),
  'docs-base-edit' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\'
})
',
    ),
    'templates' => 
    array (
      'docs-base-edit' => '
<section id="edit-documentation">
  <div class="page-header">
    <h1>Edit Documentation <small>Instructions for updating Styleguide documentation.</small></h1>
  </div>

  <h2>Pages as Handlebar Templates</h2>
  <div class="row-fluid">
    <div class="span12">
      <p>Each page in the Styleguide Documentation exists as a Handlebars template (.hbs) in the folder <code>/sugarcrm/Modules/Styleguide/clients/base/views/content</code> using the following naming convention: <code>[SECTION].[PAGE]</code>.</p>
    </div>
  </div>

  <h2>Registering Page in View Metadata</h2>
  <div class="row-fluid">
    <div class="span5">
      <p>If you want a page to be listed in the Styleguide index page and in the headerpane select, it must be registered in a pageData associative array defined in the docs view metadata file <code>/sugarcrm/Modules/Styleguide/clients/base/views/sg-headerpane/sg-headerpane.php</code>.</p>
      <p>This array contains sections which contain a collection of page data arrays. The <code>[SECTION].[PAGE]</code> relationship is used to call an individual page like <code>&lt;a href="#Styleguide/docs/forms.datetime"&gt;Datetime picker&lt;/a&gt;</code>. Section index pages are called in the form <code>index.[SECTION]</code></p>
      <p>The page data can contain a url property if you want to link to a page outside the docs.</p>
    </div>
    <div class="span7">
<pre class="prettyprint linenums">
"forms" => array (
    "title" => "Form Elements",
    "description" => "Basic form elements and layouts for a consistent editing experience.",
    "index" => true,
    "pages" => array (
        "fields" => array("label"=>"Sugar7 fields", "url"=>"#Styleguide/field/all", "description"=>"Basic fields that support detail, record, and edit modes with error addons."),
        "buttons" => array("label"=>"Buttons", "description"=>"Standard css only button styles."),
        ...
        "jstree" => array("label"=>"jsTree", "description"=>"jQuery plugin cross browser tree component."),
        "range" => array("label"=>"Range Slider", "description"=>"jQuery plugin range picker."),
        "switch" => array("label"=>"Switch", "description"=>"jQuerty plugin turns check boxes into toggle switch."),
    )
),
</pre>
    </div>
  </div>

  <h2>Setting Page Variables</h2>
  <div class="row-fluid">
    <div class="span5">
      <p>Variables for use in the documentation pages are defined in the documentation view controller <code>/sugarcrm/Modules/Styleguide/clients/base/views/docs/docs.js</code>. If you need to define a variable, create a new function in <code>docs.js</code> in the <code>/*INIT*/</code> section using the following naming convention <code>init_[PAGE]</code>. For example, the list of Sugar7 modules for the <code>base.labels</code> page is defined prior to rendering using the function <code>init_labels</code>(which is called automatically by the doc controller).</p>
      <p>The pageData variable is an object that is available from within the Handlebars template.</p>
    </div>
    <div class="span7">
<pre class="prettyprint linenums">
init_labels: function(pageData) {
    pageData.module_list = _.without(app.metadata.getModuleNames({filter: \'display_tab\', access: \'read\'}), \'Home\');
    pageData.module_list.sort();
},
</pre>
    </div>
  </div>

  <h2>Using Page Variables</h2>
  <div class="row-fluid">
    <div class="span5">
      <p>The documentation pages are generally static HTML although, as a Handlebars template, dynamic variables can be inserted into the documentation page by wrapping the variable in double braces (<code>&#123;&#123;variable&#125;&#125;</code>). To escape variables containing HTML tags use triple braces (<code>&#123;&#123;&#123;html&#125;&#125;&#125;</code>). See complete <a href="http://handlebarsjs.com/" target="_blank">Handlebars documentation</a> for details.</p>
      <p>Using our <code>base.labels</code> page as an example, here is how the table of module element icons is built.
    </div>
    <div class="span7">
<pre class="prettyprint linenums">
&lt;table class="table table-bordered table-striped"&gt;
  &lt;thead&gt;
    &lt;tr&gt;
      &lt;th&gt;Module&lt;/th&gt;
      &lt;th&gt;Labels&lt;/th&gt;
    &lt;/tr&gt;
  &lt;/thead&gt;
  &lt;tbody&gt;
&#123;&#123;#each pageData.module_list&#125;&#125;
    &lt;tr&gt;
      &lt;td&gt;&lt;b&gt;&#123;&#123;this&#125;&#125;&lt;/b&gt;&lt;/td&gt;
      &lt;td&gt;
        &lt;span class="label label-module label-&#123;&#123;this&#125;&#125;" rel="tooltip" data-title="&#123;&#123;moduleIconToolTip this&#125;&#125;"&gt;&#123;&#123;moduleIconLabel this&#125;&#125;&lt;/span&gt;
      &lt;/td&gt;
    &lt;/tr&gt;
&#123;&#123;/each&#125;&#125;
  &lt;/tbody&gt;
&lt;/table&gt;
</pre>
    </div>
  </div>

  <h2>Using jQuery in Pages</h2>
  <div class="row-fluid">
    <div class="span5">
      <p>Just like for the functions you create for intializing page variables prior to rendering, if you want to use jQuery on your documentation page, create a render function in <code>docs.js</code>in the <code>/*RENDER*/</code> section using a similar naming convention: <code>render_[PAGE].</code></p>
      <p>These functions will be called automatically by the docs controller after the page is rendered.</p>
    </div>
    <div class="span7">
<pre class="prettyprint linenums">
_renderHtml: function() {
    this.$(\'#nav-tabs-pills\')
        .find(\'ul.nav-tabs > li > a, ul.nav-list > li > a, ul.nav-pills > li > a\')
        .on(\'click.styleguide\', function(e){
            e.preventDefault();
            e.stopPropagation();
            $(this).tab(\'show\');
        });
    this._super(\'_renderHtml\');
},
</pre>
    </div>
  </div>

</section>

',
    ),
  ),
  'docs-charts-line' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
  className: \'container-fluid\',

  // charts line
  _renderHtml: function() {
    this._super(\'_renderHtml\');

    // Line chart
    d3.json(\'styleguide/content/charts/data/line_data.json\', function(data) {
      nv.addGraph(function() {
        var chart = nv.models.lineChart()
              .x(function(d) { return d[0]; })
              .y(function(d) { return d[1]; })
              .showTitle(false)
              .tooltips(true)
              .useVoronoi(false)
              .showControls(false)
              .direction(app.lang.direction)
              .tooltipContent(function(key, x, y, e, graph) {
                  return \'<p>Category: <b>\' + key + \'</b></p>\' +
                         \'<p>Amount: <b>$\' + parseInt(y, 10) + \'M</b></p>\' +
                         \'<p>Date: <b>\' + x + \'</b></p>\';
              });

        chart.xAxis
            .tickFormat(function(d) { return d3.time.format(\'%x\')(new Date(d)); });

        chart.yAxis
            .axisLabel(\'Voltage (v)\')
            .tickFormat(d3.format(\',.2f\'));

        d3.select(\'#line1 svg\')
            .datum(data)
          .transition().duration(500)
            .call(chart);

        return chart;
      });
    });

    // Stacked area chart
    d3.json(\'styleguide/content/charts/data/line_data.json\', function(data) {
      nv.addGraph(function() {

        var chart = nv.models.stackedAreaChart()
              .x(function(d) { return d[0]; })
              .y(function(d) { return d[1]; })
              .tooltipContent(function(key, x, y, e, graph) {
                  return \'<p>Category: <b>\' + key + \'</b></p>\' +
                         \'<p>Amount: <b>$\' + parseInt(y, 10) + \'M</b></p>\' +
                         \'<p>Date: <b>\' + x + \'</b></p>\';
                })
              .showTitle(false)
              .tooltips(true)
              .useVoronoi(false)
              .showControls(false)
              .direction(app.lang.direction)
              .colorData(\'graduated\', {c1: \'#e8e2ca\', c2: \'#3e6c0a\', l: data.data.length});
              //.colorData( \'class\' )
              //.colorData( \'default\' )
              //.clipEdge(true)

        chart.xAxis
            .tickFormat(function(d) { return d3.time.format(\'%x\')(new Date(d)); });

        chart.yAxis
            .axisLabel(\'Expenditures ($)\')
            .tickFormat(d3.format(\',.2f\'));

        d3.select(\'#area svg\')
            .datum(data)
          .transition().duration(500)
            .call(chart);

        return chart;
      });
    });
  }
})
',
    ),
    'templates' => 
    array (
      'docs-charts-line' => '
<section id="line">
  <div class="page-header">
    <h2>Line <small>used for comparing data series</small></h2>
  </div>
  <div class="row-fluid">
    <div class="span6">
      <h3>Standard Line Chart</h3>
      <p>Line chart with baseline y-axis. [<a href="styleguide/content/charts/lineChart.html" target="_blank">Full Screen</a> | <a href="styleguide/content/charts/lineChart_colors.html" target="_blank">Color Options</a>].</p>
      <div>
<div id="line1" class="nv-chart">
<svg></svg>
</div>
      </div>
    </div>
    <div class="span6">
      <h3>Stacked Area Chart</h3>
      <p>Line chart with cumulative y-axis. [<a href="styleguide/content/charts/stackedAreaChart.html" target="_blank">Full Screen</a> | <a href="styleguide/content/charts/stackedAreaChart_colors.html" target="_blank">Color Options</a>]</p>
      <div>
<div id="area" class="nv-chart">
<svg></svg>
</div>
      </div>
    </div>
  </div>
</section>
',
    ),
  ),
  'docs-forms-datetime' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // forms datetime
    _renderHtml: function () {
        var self = this;

        this._super(\'_renderHtml\');

        // sugar7 date field
        //TODO: figure out how to set the date value when calling createField
        this.model.start_date = \'2000-01-01T22:47:00+00:00\';
        var fieldSettingsDate = {
            view: this,
            def: {
                name: \'start_date\',
                type: \'date\',
                view: \'edit\',
                enabled: true
            },
            viewName: \'edit\',
            context: this.context,
            module: this.module,
            model: this.model,
            meta: app.metadata.getField(\'date\')
        },
        dateField = app.view.createField(fieldSettingsDate);
        this.$(\'#sugar7_date\').append(dateField.el);
        dateField.render();

        // sugar7 datetimecombo field
        this.model.start_datetime = \'2000-01-01T22:47:00+00:00\';
        var fieldSettingsCombo = {
            view: this,
            def: {
                name: \'start_datetime\',
                type: \'datetimecombo\',
                view: \'edit\',
                enabled: true
            },
            viewName: \'edit\',
            context: this.context,
            module: this.module,
            model: this.model,
            meta: app.metadata.getField(\'datetimecombo\')
        },
        datetimecomboField = app.view.createField(fieldSettingsCombo);
        this.$(\'#sugar7_datetimecombo\').append(datetimecomboField.el);
        datetimecomboField.render();

        // static examples
        this.$(\'#dp1\').datepicker();
        this.$(\'#tp1\').timepicker();

        this.$(\'#dp2\').datepicker({format:\'mm-dd-yyyy\'});
        this.$(\'#tp2\').timepicker({timeformat:\'H.i.s\'});

        this.$(\'#dp3\').datepicker();

        var startDate = new Date(2012,1,20);
        var endDate = new Date(2012,1,25);

        this.$(\'#dp4\').datepicker()
          .on(\'changeDate\', function(ev){
            if (ev.date.valueOf() > endDate.valueOf()){
              self.$(\'#alert\').show().find(\'strong\').text(\'The start date can not be greater then the end date\');
            } else {
              self.$(\'#alert\').hide();
              startDate = new Date(ev.date);
              self.$(\'#startDate\').text(self.$(\'#dp4\').data(\'date\'));
            }
            self.$(\'#dp4\').datepicker(\'hide\');
          });

        this.$(\'#dp5\').datepicker()
          .on(\'changeDate\', function(ev){
            if (ev.date.valueOf() < startDate.valueOf()){
              self.$(\'#alert\').show().find(\'strong\').text(\'The end date can not be less then the start date\');
            } else {
              self.$(\'#alert\').hide();
              endDate = new Date(ev.date);
              self.$(\'#endDate\').text(self.$(\'#dp5\').data(\'date\'));
            }
            self.$(\'#dp5\').datepicker(\'hide\');
          });


        this.$(\'#tp3\').timepicker({\'scrollDefaultNow\': true});

        this.$(\'#tp4\').timepicker();
        this.$(\'#tp4_button\').on(\'click\', function (){
          self.$(\'#tp4\').timepicker(\'setTime\', new Date());
        });

        this.$(\'#tp5\').timepicker({
          \'minTime\': \'2:00pm\',
          \'maxTime\': \'6:00pm\',
          \'showDuration\': true
        });

        this.$(\'#tp6\').timepicker();
        this.$(\'#tp6\').on(\'changeTime\', function() {
          self.$(\'#tp6_legend\').text(\'You selected: \' + $(this).val());
        });

        this.$(\'#tp7\').timepicker({ \'step\': 5 });
    },

    _dispose: function() {
        this.$(\'#dp4\').off(\'changeDate\');
        this.$(\'#dp5\').off(\'changeDate\');
        this.$(\'#tp4_button\').off(\'click\');
        this.$(\'#tp6\').off(\'changeTime\');

        this._super(\'_dispose\');
    }
})
',
    ),
    'templates' => 
    array (
      'docs-forms-datetime' => '
<section id="datepicker">
  <div class="page-header">
    <h1>Date/time picker <small>bootstrap-datepicker.js</small>, <small>jquery.timepicker.js</small></h1>
  </div>

  <div class="row-fluid">
    <div class="span3 columns">
      <h3>About</h3>
      <p>Add a time/date picker UI to a field or to any other element.</p>
      <ul>
        <li>Datepicker [<a href="#usage">usage</a>]</li>
        <ul>
          <li>can be used as a component</li>
          <li>formats: dd, d, mm, m, yyyy, yy</li>
          <li>separators: -, /, .</li>
        </ul>
        <li>Timepicker [<a href="#usage">usage</a>]</li>
        <ul>
          <li>formats: uses <a href="http://php.net/manual/en/function.date.php">PHP date formatting</a>
          <li>separators: :, ., -</li>
        </ul>
      </ul>
      <p>The bootstrap-datepicker.js [<a href="http://www.eyecon.ro/bootstrap-datepicker/"><i class="fa fa-book"></i> Datepicker Docs</a>] and jquery.timepicker.js [<a href="http://jonthornton.github.com/jquery-timepicker//"><i class="fa fa-book"></i> Timepicker Docs</a>] plugins are included in the default build of SugarCRM.</p>
    </div>

    <div class="span9 columns">
      <h2>Sugar7 Examples</h2>

      <p>Date field rendered with default values in edit mode.</p>
      <div class="well" id="sugar7_date">
      </div>
      <p>Datetimecombo field rendered with default values in edit mode.</p>
      <div class="well" id="sugar7_datetimecombo">
      </div>

      <p>View the <a href="#Styleguide/field/date">date test page</a> for all rendering modes.</p>

      <h2>Static Examples</h2>

      <p>Attached to a field with default formatting.</p>
      <div class="well">
        <input type="text" class="span2" value="" placeholder="mm-dd-yyyy" id="dp1" rel="datepicker">
        <input type="text" class="span2" placeholder="hh:mm" id="tp1" rel="timepicker">
      </div>
      <pre class="prettyprint">
&lt;input type="text" class="span2" value="" placeholder="mm-dd-yyyy" id="dp1" rel="datepicker"&gt;
&lt;input type="text" class="span2" placeholder="hh:mm" id="tp1" rel="timepicker"&gt;

$(\'#dp1\').datepicker();
$(\'#tp1\').timepicker();</pre>

      <p>Attached to a field with custom formatting - date and time format specified in options.</p>
      <div class="well">
        <input type="text" class="span2" value="" placeholder="mm-dd-yyyy" data-date-format="mm/dd/yy" id="dp2" rel="datepicker">
        <input type="text" class="span2" placeholder="hh.mm.ss" id="tp2" rel="timepicker">
      </div>
      <pre class="prettyprint">
&lt;input type="text" class="span2" value="" placeholder="mm-dd-yyyy" data-date-format="mm/dd/yy" id="dp2" rel="datepicker"&gt;
&lt;input type="text" class="span2" placeholder="hh.mm.ss" id="tp2" rel="timepicker"&gt;

$(\'#dp2\').datepicker({format: \'mm-dd-yyyy\'});
$(\'#tp2\').timepicker({timeFormat:\'H.i.s\'});</pre>

      <p>Date picker as component - format specified via data tag .</p>
      <div class="well">
        <div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="mm-dd-yyyy" rel="datepicker">
          <input class="span2" size="16" type="text" value="" placeholder="mm-dd-yyyy">
          <span class="add-on"><i class="fa fa-calendar"></i></span>
        </div>
      </div>
      <pre class="prettyprint">
&lt;div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="mm-dd-yyyy" rel="datepicker"&gt;
  &lt;input class="span2" size="16" type="text" value="" placeholder="mm-dd-yyyy"&gt;
  &lt;span class="add-on"&gt;&lt;i class="fa fa-calendar">&lt;/i&gt;&lt;/span&gt;
&lt;/div&gt;

$(\'#dp3\').datepicker();</pre>

      <p>Date picker attached to other element then field and using events to work with the date values.</p>
      <div class="well">
        <div class="alert alert-error hide" id="alert">
          <strong>Oh snap!</strong>
        </div>
        <div class="row-fluid">
          <div class="span6"><b>Start date: </b><span id="startDate">2012-02-20</span></div>
          <div class="span6"><b>End date: </b><span id="endDate">2012-02-25</span></div>
        </div>
        <div class="row-fluid">
          <div class="span6" style="position:relative"><a class="btn small" id="dp4" data-date-format="yyyy-mm-dd" data-date="2012-02-20">Change</a></div>
          <div class="span6" style="position:relative"><a class="btn small" id="dp5" data-date-format="yyyy-mm-dd" data-date="2012-02-25">Change</a></div>
        </div>
      </div>
      <pre class="prettyprint">
var startDate = new Date(2012,1,20);
var endDate = new Date(2012,1,25);

$(\'#dp4\').datepicker()
  .on(\'changeDate\', function(ev){
    if (ev.date.valueOf() &gt; endDate.valueOf()){
      $(\'#alert\').show().find(\'strong\').text(\'The start date can not be greater then the end date\');
    } else {
      $(\'#alert\').hide();
      startDate = new Date(ev.date);
      $(\'#startDate\').text($(\'#dp4\').data(\'date\'));
    }
    $(\'#dp4\').datepicker(\'hide\');
  });

$(\'#dp5\').datepicker()
  .on(\'changeDate\', function(ev){
    if (ev.date.valueOf() &lt; startDate.valueOf()){
      $(\'#alert\').show().find(\'strong\').text(\'The end date can not be less then the start date\');
    } else {
      $(\'#alert\').hide();
      endDate = new Date(ev.date);
      $(\'#endDate\').text($(\'#dp5\').data(\'date\'));
    }
    $(\'#dp5\').datepicker(\'hide\');
  });</pre>

      <p>Time picker focused on current time.</p>
      <div class="well">
        <input type="text" class="span2" placeholder="hh:mm" id="tp3" rel="timepicker">
      </div>
      <pre class="prettyprint">
&lt;input type="text" class="span2" placeholder="hh:mm" id="tp3" rel="timepicker"&gt;

$(\'#tp3\').timepicker({\'scrollDefaultNow\': true});</pre>

      <p>Time picker with a button triggering current time.</p>
      <div class="well">
        <input id="tp4" type="text" class="span2" autocomplete="off">
        <button id="tp4_button" class="btn">Set current time</button>
      </div>
      <pre class="prettyprint">
&lt;input id="tp4" type="text" class="span2" autocomplete="off"&gt;
&lt;button id="tp4_button" class="btn" style="margin-bottom:9px"&gt;Set current time&lt;/button&gt;

$(\'#tp4\').timepicker();
$(\'#tp4_button\').on(\'click\', function (){
  $(\'#tp4\').timepicker(\'setTime\', new Date());
});</pre>

      <p>Time picker with custom start/end point and duration</p>
      <div class="well">
        <input id="tp5" type="text" class="span2" autocomplete="off">
      </div>
      <pre class="prettyprint">
&lt;input id="tp5" type="text" class="span2" autocomplete="off"&gt;

$(\'#tp5\').timepicker({
  \'minTime\': \'2:00pm\',
  \'maxTime\': \'6:00pm\',
  \'showDuration\': true
});</pre>

      <p>Time picker showing trigger an event after time selected</p>
      <div class="well">
<input id="tp6" type="text" class="span2" autocomplete="off">
<span id="tp6_legend"></span>
      </div>
      <pre class="prettyprint">
&lt;input id="tp6" type="text" class="span2" autocomplete="off"&gt;
&lt;span id="tp6_legend"&gt;&lt;/span&gt;

$(\'#tp6\').timepicker();
$(\'#tp6\').on(\'changeTime\', function() {
  $(\'#tp6_legend\').text(\'You selected: \' + $(this).val());
});</pre>

      <p>Time picker customizing time steps</p>
      <div class="well">
        <input id="tp7" type="text" class="span2" autocomplete="off">
      </div>
      <pre class="prettyprint">
&lt;input id="tp7" type="text" class="span2" autocomplete="off"&gt;

$(\'#tp7\').timepicker({ \'step\': 5 });</pre>

    </div>
  </div>

  <h2 id="usage">Usage</h2>

  <div class="row-fluid">
    <div class="span6">
      <h3>Datepicker markup</h3>
      <p>Format a component.</p>
      <pre class="prettyprint linenums">
&lt;div class=&quot;input-append date&quot; id=&quot;dp3&quot; data-date=&quot;12-02-2012&quot; data-date-format=&quot;dd-mm-yyyy&quot; rel=&quot; datepicker&quot;&gt;
&lt;input class=&quot;span2&quot; size=&quot;16&quot; type=&quot;text&quot; value=&quot;12-02-2012&quot;&gt;
&lt;span class=&quot;add-on&quot;&gt;&lt;i class=&quot;fa fa-th&quot;&gt;&lt;/i&gt;&lt;/span&gt;
&lt;/div&gt;</pre>
    </div>
    <div class="span6">
      <h3>Timepicker markup</h3>
      <p>Format a component.</p>
      <pre class="prettyprint linenums">
&lt;input type=&quot;text&quot; class=&quot;span2&quot; placeholder=&quot;hh:mm&quot; id=&quot;tp1&quot; rel=&quot;timepicker&quot;&gt;</pre>
    </div>
  </div>


  <div class="row-fluid">
    <div class="span6">
      <h3>Methods</h3>
      <p>Initializes a datepicker.</p>
      <pre class="prettyprint linenums">$(\'[rel=datepicker]\').datepicker(options)</pre>
    </div>
    <div class="span6">
      <h3>Methods</h3>
      <p>Initializes a timepicker.</p>
      <pre class="prettyprint linenums">$(\'[rel=timepicker]\').timepicker(options)</pre>
    </div>
  </div>


  <div class="row-fluid">
    <div class="span6">
      <h3>Events</h3>
      <p>Datepicker class exposes a few events for manipulating the dates.</p>
      <table class="table table-bordered table-striped">
        <thead>
         <tr>
           <th style="width: 150px;">Event</th>
           <th>Description</th>
         </tr>
        </thead>
        <tbody>
         <tr>
           <td>show</td>
           <td>This event fires immediately when the date picker is displayed.</td>
         </tr>
         <tr>
           <td>hide</td>
           <td>This event is fired immediately when the date picker is hidden.</td>
         </tr>
         <tr>
           <td>changeDate</td>
           <td>This event is fired when the date is changed.</td>
         </tr>
        </tbody>
      </table>
      <pre class="prettyprint linenums">
$(&#039;#dpX&#039;).datepicker()
  .on(&#039;changeDate&#039;, function(ev){
    if (ev.date.valueOf() &lt; startDate.valueOf()){
      ....
    }
  });</pre>
      <h3>Options</h3>
      <table class="table table-bordered table-striped">
        <thead>
         <tr>
           <th style="width: 100px;">Name</th>
           <th style="width: 50px;">type</th>
           <th style="width: 100px;">default</th>
           <th>description</th>
         </tr>
        </thead>
        <tbody>
          <tr>
           <td>format</td>
           <td>string</td>
           <td>\'mm/dd/yyyy\'</td>
           <td>the date format, combination of  d, dd, m, mm, yy, yyy.</td>
         </tr>
          <tr>
           <td>weekStart</td>
           <td>integer</td>
           <td>0</td>
           <td>day of the week start. 0 for Sunday -  6 for Saturday</td>
         </tr>
        </tbody>
      </table>
    </div>
    <div class="span6">
      <h3>Events</h3>
      <p>Timepicker class exposes a singel events for manipulating the times.</p>
      <table class="table table-bordered table-striped">
        <thead>
         <tr>
           <th style="width: 150px;">Event</th>
           <th>Description</th>
         </tr>
        </thead>
        <tbody>
         <tr>
           <td>changeTime</td>
           <td>Trigger an event after selecting a value.</td>
         </tr>
        </tbody>
      </table>
      <pre class="prettyprint linenums">
$(&#039;#tpX&#039;).on(&#039;changeTime&#039;, function() {
  $(&#039;#timeDisplay&#039;).text($(this).val());
});</pre>
      <h3>Options</h3>
      <table class="table table-bordered table-striped">
        <thead>
         <tr>
           <th style="width: 50px;">name</th>
           <th style="width: 100px;">value</th>
           <th>description</th>
         </tr>
        </thead>
        <tbody>
          <tr>
            <td>timeFormat</td>
            <td>\'H:i:s\'</td>
            <td>Set scroll position to local time (<a href="http://php.net/manual/en/function.date.php">PHP formatting</a>)</td>
          </tr>
          <tr>
            <td>scrollDefaultNow</td>
            <td>true</td>
            <td>Set scroll position to local time</td>
          </tr>
          <tr>
            <td>minTime</td>
            <td>\'2:30pm\'</td>
            <td>Set starting time</td>
          </tr>
          <tr>
            <td>maxTime</td>
            <td>\'11:30pm\'</td>
            <td>Set end time</td>
          </tr>
          <tr>
            <td>showDuration</td>
            <td>true</td>
            <td>Show duration between time intervals</td>
          </tr>
          <tr>
            <td>step</td>
            <td>15</td>
            <td>Set length of time</td>
         </tr>
        </tbody>
      </table>
    </div>
  </div>

</section>
',
    ),
  ),
  'docs-forms-fields' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\'
})
',
    ),
    'templates' => 
    array (
      'docs-forms-fields' => '
<!-- Form inputs
================================================== -->
<section id="form-inputs">
    <div class="page-header">
        <h1>Sugar7 Fields <small>Basic fields that support detail, record, and edit modes with error addons.</small></h1>
    </div>
    <div class="record">
        <table class="accordion table table-bordered table-striped table-condensed" id="accordion_fields">
            <thead>
                <tr>
                    <th>Field Name</th><th>Type</th><th>Sugar Field</th><th>Examples</th><th>Documentation</th>
                </tr>
            </thead>
        {{#each tempfields}}
            <tbody class="accordion-group">
                <tr>
                    <td>{{this.name}}</td>
                    <td>plugin</td>
                    <td>{{this.type}}</td>
                    <td class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_fields" data-target="#collapse_field_{{this.type}}">Example</a>
                    </td>
                    <td><a href="#Styleguide/docs/forms.datetime">Documentation</a></td>
                </tr>
                <tr>
                    <td class="accordion-body collapse" colspan="5">
                        <div class="accordion-inner" id="collapse_field_{{this.type}}" style="height:0px;">
                            <div class="row-fluid">
                                <h3>Detail</h3>
                                {{field ../this model=../this.model template="detail"}}
                            </div>
                            <div class="row-fluid">
                                <h3>Edit</h3>
                                {{field ../this model=../this.model template="edit"}}
                            </div>
                            <div class="row-fluid">
                                <h3>Disabled</h3>
                                {{field ../this model=../this.model template="disabled"}}
                            </div>
                            <div class="row-fluid">
                                <h3>List</h3>
                                {{field ../this model=../this.model template="list"}}
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        {{/each}}
        </table>
    </div>

    <div class="description">
    {{{description}}}
    </div>
</section>
',
    ),
  ),
  'docs-components-collapse' => 
  array (
    'templates' => 
    array (
      'docs-components-collapse' => '
<!-- Collapse
================================================== -->
<section id="collapse">
  <div class="page-header">
    <h1>Collapse <small>bootstrap-collapse.js</small></h1>
  </div>
  <div class="row-fluid">
    <div class="span3 columns">
      <h3>About</h3>
      <p>Get base styles and flexible support for collapsible components like accordions and navigation.</p>
      <p>The bootsrap-collapse.js plugin is included in the default build of SugarCRM.</p>
    </div>
    <div class="span9 columns">
      <h2>Example accordion</h2>
      <p>Using the collapse plugin, we built a simple accordion style widget:</p>

      <div class="accordion" id="accordion2">
        <div class="accordion-group">
          <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
              Collapsible Group Item #1
            </a>
          </div>
          <div id="collapseOne" class="accordion-body collapse in">
            <div class="accordion-inner">
              Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.
            </div>
          </div>
        </div>
        <div class="accordion-group">
          <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
              Collapsible Group Item #2
            </a>
          </div>
          <div id="collapseTwo" class="accordion-body collapse">
            <div class="accordion-inner">
              Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.
            </div>
          </div>
        </div>
        <div class="accordion-group">
          <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
              Collapsible Group Item #3
            </a>
          </div>
          <div id="collapseThree" class="accordion-body collapse">
            <div class="accordion-inner">
              Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.
            </div>
          </div>
        </div>
      </div>


      <hr>
      <h2>Using bootstrap-collapse.js</h2>
      <p>Enable via javascript:</p>
      <pre class="prettyprint linenums">$(".collapse").collapse()</pre>
      <h3>Options</h3>
      <table class="table table-bordered table-striped">
        <thead>
         <tr>
           <th style="width: 100px;">Name</th>
           <th style="width: 50px;">type</th>
           <th style="width: 50px;">default</th>
           <th>description</th>
         </tr>
        </thead>
        <tbody>
         <tr>
           <td>parent</td>
           <td>selector</td>
           <td>false</td>
           <td>If selector then all collapsible elements under the specified parent will be closed when this collasabile item is shown. (similar to traditional accordion behavior)</td>
         </tr>
         <tr>
           <td>toggle</td>
           <td>boolean</td>
           <td>true</td>
           <td>Toggles the collapsible element on invocation</td>
         </tr>
        </tbody>
      </table>
      <h3>Markup</h3>
      <p>Just add <code>data-toggle="collapse"</code> and a <code>data-target</code> to element to automatically assign control of a collapsible element. The <code>data-target</code> attribute accepts a css selector to apply the collapse to. Be sure to add the class <code>collapse</code> to the collapsible element. If you\'d like it to default open, add the additional class <code>in</code>.</p>
      <pre class="prettyprint linenums">
&lt;button class="btn btn-danger" data-toggle="collapse" data-target="#demo"&gt;
simple collapsible
&lt;/button&gt;

&lt;div id="demo" class="collapse in"&gt; … &lt;/div&gt;</pre>
      <div class="alert alert-info">
        <strong>Heads up!</strong>
        To add accordion-like group management to a collapsible control, add the data attribute <code>data-parent="#selector"</code>. Refer to the demo to see this in action.
      </div>
      <h3>Methods</h3>
      <h4>.collapse(options)</h4>
      <p>Activates your content as a collapsible element. Accepts an optional options <code>object</code>.
<pre class="prettyprint linenums">
$(\'#myCollapsible\').collapse({
toggle: false
})</pre>
      <h4>.collapse(\'toggle\')</h4>
      <p>Toggles a collapsible element to shown or hide.</p>
      <h4>.collapse(\'show\')</h4>
      <p>Shows a collapsible element.</p>
      <h4>.collapse(\'hide\')</h4>
      <p>Hides a collapsible element.</p>
      <h3>Events</h3>
      <p>
        Bootstrap\'s collapse class exposes a few events for hooking into collapse functionality.
      </p>
      <table class="table table-bordered table-striped">
        <thead>
         <tr>
           <th style="width: 150px;">Event</th>
           <th>Description</th>
         </tr>
        </thead>
        <tbody>
         <tr>
           <td>show</td>
           <td>This event fires immediately when the <code>show</code> instance method is called.</td>
         </tr>
         <tr>
           <td>shown</td>
           <td>This event is fired when a collapse element has been made visible to the user (will wait for css transitions to complete).</td>
         </tr>
         <tr>
           <td>hide</td>
           <td>
            This event is fired immediately when the <code>hide</code> method has been called.
           </td>
         </tr>
         <tr>
           <td>hide</td>
           <td>This event is fired when a collapse element has been hide from the user (will wait for css transitions to complete).</td>
         </tr>
        </tbody>
      </table>

<pre class="prettyprint linenums">
$(\'#myCollapsible\').on(\'hide\', function () {
// do something…
})</pre>
    </div>
  </div>
</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\'
})
',
    ),
  ),
  'docs-components-tooltips' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    //components tooltips
    _renderHtml: function () {
        this._super(\'_renderHtml\');

        this.$(\'#tooltips\').tooltip({
            selector: \'[rel=tooltip]\'
        });
    }
})
',
    ),
    'templates' => 
    array (
      'docs-components-tooltips' => '
<!-- Tooltips
================================================== -->
<section id="tooltips">
  <div class="page-header">
    <h1>Tooltips <small>bootstrap-tooltip.js</small></h1>
  </div>
  <div class="row-fluid">
    <div class="span3 columns">
      <h3>About Tooltips</h3>
      <p>Inspired by the excellent jQuery.tipsy plugin written by Jason Frame; Tooltips are an updated version, which don\'t rely on images, uss css3 for animations, and data-attributes for local title storage.</p>
      <p>The bootsrap-tooltip.js plugin is included in the default build of SugarCRM.</p>
      <div class="alert alert-info">
        <strong>Heads up!</strong> For performance reasons, the tooltip and popover data-apis are opt in, meaning <strong>you must initialize them yourself</strong>.
      </div>
    </div>
    <div class="span9 columns">

          <h2>Examples</h2>

          <p>Hover over the links below to see tooltips:</p>
          <div class="bs-docs-example tooltip-demo">
            <p class="muted" style="margin-bottom: 0;">Tight pants next level keffiyeh <a rel="tooltip" title="Default tooltip">you probably</a> haven\'t heard of them. Photo booth beard raw denim letterpress vegan messenger bag stumptown. Farm-to-table seitan, mcsweeney\'s fixie sustainable quinoa 8-bit american apparel <a rel="tooltip" title="Another tooltip">have a</a> terry richardson vinyl chambray. Beard stumptown, cardigans banh mi lomo thundercats. Tofu biodiesel williamsburg marfa, four loko mcsweeney\'s cleanse vegan chambray. A really ironic artisan <a rel="tooltip" title="A much longer tooltip belongs right here to demonstrate the max-width we apply.">whatever keytar</a>, scenester farm-to-table banksy Austin <a rel="tooltip" title="The last tip!">twitter handle</a> freegan cred raw denim single-origin coffee viral.</p>
          </div>

          <h3>Four directions</h3>
          <div class="bs-docs-example tooltip-demo">
            <ul class="bs-docs-tooltip-examples">
              <li><a rel="tooltip" data-placement="top" title="Tooltip on top">Tooltip on top</a></li>
              <li><a rel="tooltip" data-placement="right" title="Tooltip on right">Tooltip on right</a></li>
              <li><a rel="tooltip" data-placement="bottom" title="Tooltip on bottom">Tooltip on bottom</a></li>
              <li><a rel="tooltip" data-placement="left" title="Tooltip on left">Tooltip on left</a></li>
            </ul>
          </div>


          <h3>Tooltips in input groups</h3>
          <p>When using tooltips and popovers with the Bootstrap input groups, you\'ll have to set the <code>container</code> (documented below) option to avoid unwanted side effects.</p>

          <hr class="bs-docs-separator">


          <h2>Basic Usage</h2>

          <p>Markup elements:</p>
          <pre class="prettyprint linenums">
&lt;div id="example"&gt;
  &lt;a rel="tooltip" title="first tooltip"&gt;hover over me&lt;/a&gt;
&lt;/div&gt;
          </pre>
          <p>Trigger the tooltip via JavaScript:</p>
          <pre class="prettyprint linenums">
$(\'#example\').tooltip({selector: \'[rel="tooltip"]\'});
$(\'[rel=tooltip]\').tooltip();
          </pre>


          <h2>Sugar7 Implementation</h2>
          <p>Markup elements (in .hbs):</p>
          <pre class="prettyprint linenums">
&lt;a class="btn btn-mini comment" rel="tooltip" data-title="Comment"&gt;
    &lt;i class="fa fa-comment"&gt;&lt;/i&gt;
&lt;/a&gt;
          </pre>

          <p>Initialize tooltip (in .js):</p>
          <pre class="prettyprint linenums">
    events: {
        \'mouseenter [rel="tooltip"]\': \'showTooltip\',
        \'mouseleave [rel="tooltip"]\': \'hideTooltip\'
    },

    showTooltip: function(e) {
        this.$(e.currentTarget).tooltip("show");
    },

    hideTooltip: function(e) {
        this.$(e.currentTarget).tooltip("hide");
    },

    unbindDom: function() {
        // Unbind all tooltips on page
        var unbindTooltips = _.bind(function(sel) {
            this.$(sel).each(function() {
                $(this).tooltip(\'destroy\');
            });
        }, this);
        unbindTooltips(\'[rel="tooltip"]\');

        app.view.Field.prototype.unbindDom.call(this);
    }
          </pre>
      <div class="alert alert-info">
        <strong>Heads up!</strong> Either use the "title" or "data-title" attribute on elements you wish to use tooltips. The "title" attribute is removed by tooltips.js and replace with "data-title-original".
      </div>
          <h3>Options</h3>
          <p>Options can be passed via data attributes or JavaScript. For data attributes, append the option name to <code>data-</code>, as in <code>data-animation=""</code>.</p>
          <table class="table table-bordered table-striped">
            <thead>
             <tr>
               <th style="width: 100px;">Name</th>
               <th style="width: 100px;">type</th>
               <th style="width: 50px;">default</th>
               <th>description</th>
             </tr>
            </thead>
            <tbody>
             <tr>
               <td>animation</td>
               <td>boolean</td>
               <td>true</td>
               <td>apply a css fade transition to the tooltip</td>
             </tr>
             <tr>
               <td>html</td>
               <td>boolean</td>
               <td>false</td>
               <td>Insert html into the tooltip. If false, jquery\'s <code>text</code> method will be used to insert content into the dom. Use text if you\'re worried about XSS attacks.</td>
             </tr>
             <tr>
               <td>placement</td>
               <td>string | function</td>
               <td>\'top\'</td>
               <td>how to position the tooltip - top | bottom | left | right</td>
             </tr>
             <tr>
               <td>selector</td>
               <td>string</td>
               <td>false</td>
               <td>If a selector is provided, tooltip objects will be delegated to the specified targets.</td>
             </tr>
             <tr>
               <td>title</td>
               <td>string | function</td>
               <td>\'\'</td>
               <td>default title value if `title` tag isn\'t present</td>
             </tr>
             <tr>
               <td>trigger</td>
               <td>string</td>
               <td>\'hover focus\'</td>
               <td>how tooltip is triggered - click | hover | focus | manual. Note you case pass trigger mutliple, space seperated, trigger types.</td>
             </tr>
             <tr>
               <td>delay</td>
               <td>number | object</td>
               <td>0</td>
               <td>
                <p>delay showing and hiding the tooltip (ms) - does not apply to manual trigger type</p>
                <p>If a number is supplied, delay is applied to both hide/show</p>
                <p>Object structure is: <code>delay: { show: 500, hide: 100 }</code></p>
               </td>
             </tr>
             <tr>
               <td>container</td>
               <td>string | false</td>
               <td>false</td>
               <td>
                <p>Appends the tooltip to a specific element <code>container: \'body\'</code></p>
               </td>
             </tr>
            </tbody>
          </table>
          <div class="alert alert-info">
            <strong>Heads up!</strong>
            Options for individual tooltips can alternatively be specified through the use of data attributes.
          </div>

          <h3>Methods</h3>
          <h4>$().tooltip(options)</h4>
          <p>Attaches a tooltip handler to an element collection.</p>
          <h4>.tooltip(\'show\')</h4>
          <p>Reveals an element\'s tooltip.</p>
          <pre class="prettyprint linenums">$(\'#element\').tooltip(\'show\')</pre>
          <h4>.tooltip(\'hide\')</h4>
          <p>Hides an element\'s tooltip.</p>
          <pre class="prettyprint linenums">$(\'#element\').tooltip(\'hide\')</pre>
          <h4>.tooltip(\'toggle\')</h4>
          <p>Toggles an element\'s tooltip.</p>
          <pre class="prettyprint linenums">$(\'#element\').tooltip(\'toggle\')</pre>
          <h4>.tooltip(\'destroy\')</h4>
          <p>Hides and destroys an element\'s tooltip.</p>
          <pre class="prettyprint linenums">$(\'#element\').tooltip(\'destroy\')</pre>

    </div>
  </div>
</section>
',
    ),
  ),
  'docs-charts-vertical' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // charts vertical
    _renderHtml: function() {
        this._super(\'_renderHtml\');

        // Vertical Bar Chart without Line
        this.chart1 = nv.models.multiBarChart()
              .showTitle(false)
              .tooltips(true)
              .showControls(false)
              .direction(app.lang.direction)
              .colorData(\'default\')
              .tooltipContent(function(key, x, y, e, graph) {
                  return \'<p>Stage: <b>\' + key + \'</b></p>\' +
                         \'<p>Amount: <b>$\' + parseInt(y, 10) + \'K</b></p>\' +
                         \'<p>Percent: <b>\' + x + \'%</b></p>\';
              });

        nv.utils.windowResize(this.chart1.update);


        //Vertical Bar Chart with Line
        this.chart2 = nv.models.paretoChart()
              .showTitle(false)
              .showLegend(true)
              .tooltips(true)
              .showControls(false)
              .direction(app.lang.direction)
              .stacked(true)
              .clipEdge(false)
              .colorData(\'default\')
              .yAxisTickFormat(function(d) { return \'$\' + d3.format(\',.2s\')(d); })
              .quotaTickFormat(function(d) { return \'$\' + d3.format(\',.3s\')(d); });
              // override default barClick function
              // .barClick( function(data,e,selection) {
              //     //if only one bar series is disabled
              //     d3.select(\'#vert2 svg\')
              //       .datum(forecast_data_Manager)
              //       .call(chart);
              //   })

        nv.utils.windowResize(this.chart2.update);

        this.loadData();
    },

    loadData: function(options) {

      // Vertical Bar Chart without Line
      d3.json(\'styleguide/content/charts/data/multibar_data.json\', _.bind(function(data) {
          d3.select(\'#vert1 svg\')
              .datum(data)
            .transition().duration(500)
              .call(this.chart1);
      }, this));

      //Vertical Bar Chart with Line
      d3.json(\'styleguide/content/charts/data/pareto_data_salesrep.json\', _.bind(function(data) {
          d3.select(\'#vert2 svg\')
            .datum(data)
            .call(this.chart2);
      }, this));
    }
})
',
    ),
    'templates' => 
    array (
      'docs-charts-vertical' => '
<section id="vertical-bar">
  <div class="page-header">
    <h2>Vertical Bar <small>used for comparing multiple series with a few values</small></h2>
  </div>
  <div class="row-fluid">
    <div class="span6">
      <h3>Standard Vertical Bar Chart</h3>
      <p>Long description. [<a href="styleguide/content/charts/multiBarChart.html" target="_blank">Full Screen</a> | <a href="styleguide/content/charts/multiBarChart_colors.html" target="_blank">Color Options</a> ]</p></p>
      <div>
        <div id="vert1" class="nv-chart nv-chart-multibar">
        <svg></svg>
        </div>
      </div>
    </div>
    <div class="span6">
      <h3>Pareto Chart</h3>
      <p>This is a new NVD3 chart type created for SugarCRM. An example of usage in Sugar7 is on <a href="#Forecasts" target="_blank">forecasting page</a>. [<a href="styleguide/content/charts/paretoChart.html" target="_blank">Full Screen</a>]</p>
      <div>
        <div id="vert2" class="nv-chart nv-pareto">
        <svg></svg>
        </div>
      </div>
    </div>
  </div>
</section>
',
    ),
  ),
  'dashlet-tabbed' => 
  array (
    'meta' => 
    array (
      'dashlets' => 
      array (
        0 => 
        array (
          'label' => 'Tabbed Dashlet Example',
          'description' => 'LBL_ACTIVE_TASKS_DASHLET_DESCRIPTION',
          'config' => 
          array (
            'limit' => 10,
            'visibility' => 'user',
          ),
          'preview' => 
          array (
            'limit' => 10,
            'visibility' => 'user',
          ),
          'filter' => 
          array (
            'module' => 
            array (
              0 => 'Styleguide',
            ),
            'view' => 'record',
          ),
        ),
      ),
      'custom_toolbar' => 
      array (
        'buttons' => 
        array (
          0 => 
          array (
            'type' => 'actiondropdown',
            'no_default_action' => true,
            'icon' => 'fa-plus',
            'buttons' => 
            array (
              0 => 
              array (
                'type' => 'dashletaction',
                'action' => 'createRecord',
                'params' => 
                array (
                  'module' => 'Tasks',
                  'link' => 'tasks',
                ),
                'label' => 'LBL_CREATE_TASK',
                'acl_action' => 'create',
                'acl_module' => 'Tasks',
              ),
            ),
          ),
          1 => 
          array (
            'dropdown_buttons' => 
            array (
              0 => 
              array (
                'type' => 'dashletaction',
                'action' => 'editClicked',
                'label' => 'LBL_DASHLET_CONFIG_EDIT_LABEL',
              ),
              1 => 
              array (
                'type' => 'dashletaction',
                'action' => 'refreshClicked',
                'label' => 'LBL_DASHLET_REFRESH_LABEL',
              ),
              2 => 
              array (
                'type' => 'dashletaction',
                'action' => 'toggleClicked',
                'label' => 'LBL_DASHLET_MINIMIZE',
                'event' => 'minimize',
              ),
              3 => 
              array (
                'type' => 'dashletaction',
                'action' => 'removeClicked',
                'label' => 'LBL_DASHLET_REMOVE_LABEL',
              ),
            ),
          ),
        ),
      ),
      'panels' => 
      array (
        0 => 
        array (
          'name' => 'panel_body',
          'columns' => 2,
          'labelsOnTop' => true,
          'placeholders' => true,
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'visibility',
              'label' => 'LBL_DASHLET_CONFIGURE_MY_ITEMS_ONLY',
              'type' => 'enum',
              'options' => 'tasks_visibility_options',
            ),
            1 => 
            array (
              'name' => 'limit',
              'label' => 'LBL_DASHLET_CONFIGURE_DISPLAY_ROWS',
              'type' => 'enum',
              'options' => 'tasks_limit_options',
            ),
          ),
        ),
      ),
      'tabs' => 
      array (
        0 => 
        array (
          'active' => true,
          'filters' => 
          array (
            'status' => 
            array (
              '$not_in' => 
              array (
                0 => 'Completed',
                1 => 'Deferred',
              ),
            ),
            'date_due' => 
            array (
              '$lte' => 'today',
            ),
          ),
          'label' => 'LBL_ACTIVE_TASKS_DASHLET_DUE_NOW',
          'link' => 'tasks',
          'module' => 'Tasks',
          'order_by' => 'date_due:asc',
          'record_date' => 'date_due',
          'row_actions' => 
          array (
            0 => 
            array (
              'type' => 'rowaction',
              'icon' => 'fa-times-circle',
              'css_class' => 'btn btn-mini',
              'event' => 'active-tasks:close-task:fire',
              'target' => 'view',
              'tooltip' => 'LBL_ACTIVE_TASKS_DASHLET_COMPLETE_TASK',
              'acl_action' => 'edit',
            ),
            1 => 
            array (
              'type' => 'unlink-action',
              'icon' => 'fa-chain-broken',
              'css_class' => 'btn btn-mini',
              'event' => 'tabbed-dashlet:unlink-record:fire',
              'target' => 'view',
              'tooltip' => 'LBL_UNLINK_BUTTON',
              'acl_action' => 'edit',
            ),
          ),
          'overdue_badge' => 
          array (
            'name' => 'date_due',
            'type' => 'overdue-badge',
          ),
        ),
        1 => 
        array (
          'filters' => 
          array (
            'status' => 
            array (
              '$not_in' => 
              array (
                0 => 'Completed',
                1 => 'Deferred',
              ),
            ),
            'date_due' => 
            array (
              '$gt' => 'today',
            ),
          ),
          'label' => 'LBL_ACTIVE_TASKS_DASHLET_UPCOMING',
          'link' => 'tasks',
          'module' => 'Tasks',
          'order_by' => 'date_due:asc',
          'record_date' => 'date_due',
          'row_actions' => 
          array (
            0 => 
            array (
              'type' => 'rowaction',
              'icon' => 'fa-times-circle',
              'css_class' => 'btn btn-mini',
              'event' => 'active-tasks:close-task:fire',
              'target' => 'view',
              'tooltip' => 'LBL_ACTIVE_TASKS_DASHLET_COMPLETE_TASK',
              'acl_action' => 'edit',
            ),
            1 => 
            array (
              'type' => 'unlink-action',
              'icon' => 'fa-chain-broken',
              'css_class' => 'btn btn-mini',
              'event' => 'tabbed-dashlet:unlink-record:fire',
              'target' => 'view',
              'tooltip' => 'LBL_UNLINK_BUTTON',
              'acl_action' => 'edit',
            ),
          ),
        ),
        2 => 
        array (
          'filters' => 
          array (
            'status' => 
            array (
              '$not_in' => 
              array (
                0 => 'Completed',
                1 => 'Deferred',
              ),
            ),
            'date_due' => 
            array (
              '$is_null' => '',
            ),
          ),
          'label' => 'LBL_ACTIVE_TASKS_DASHLET_TODO',
          'link' => 'tasks',
          'module' => 'Tasks',
          'order_by' => 'date_entered:asc',
          'row_actions' => 
          array (
            0 => 
            array (
              'type' => 'rowaction',
              'icon' => 'fa-times-circle',
              'css_class' => 'btn btn-mini',
              'event' => 'active-tasks:close-task:fire',
              'target' => 'view',
              'tooltip' => 'LBL_ACTIVE_TASKS_DASHLET_COMPLETE_TASK',
              'acl_action' => 'edit',
            ),
            1 => 
            array (
              'type' => 'unlink-action',
              'icon' => 'fa-chain-broken',
              'css_class' => 'btn btn-mini',
              'event' => 'tabbed-dashlet:unlink-record:fire',
              'target' => 'view',
              'tooltip' => 'LBL_UNLINK_BUTTON',
              'acl_action' => 'edit',
            ),
          ),
        ),
      ),
      'visibility_labels' => 
      array (
        'user' => 'LBL_ACTIVE_TASKS_DASHLET_USER_BUTTON_LABEL',
        'group' => 'LBL_ACTIVE_TASKS_DASHLET_GROUP_BUTTON_LABEL',
      ),
    ),
    'templates' => 
    array (
      'records' => '
<div class="tab-pane active">
    {{#if collection.length}}
        <ul class="unstyled listed">
            {{#each collection.models}}
                <li>
                    {{#if ../../row_actions}}
                        <div class="actions pull-right">
                            {{#each ../../row_actions}}
                                {{field ../../../this model=../this}}
                            {{/each}}
                        </div>
                    {{/if}}
                    <p>
                        {{#if attributes.assigned_user_id}}
                            <a href="#{{buildRoute module="Employees" id=attributes.assigned_user_id action="detail"}}" class="pull-left avatar42" data-title="{{fieldValue this "assigned_user_name"}}">
                                <img src="{{fieldValue this "picture_url"}}" alt="{{fieldValue this "assigned_user_name"}}">
                            </a>
                        {{else}}
                            <span class="fa fa-stack pull-left">
                                <i class="fa fa-user fa-stack-base"></i>
                                <i class="fa fa-question-circle fa-light"></i>
                            </span>
                        {{/if}}
                        <a href="#{{buildRoute model=this action="detail"}}">{{fieldValue this "name"}}</a>
                    </p>
                    {{#if ../overdueBadge}}
                        {{#with ../../overdueBadge}}
                            {{field ../../../this model=../../this template=\'detail\'}}
                        {{/with}}
                    {{/if}}
                    <div class="details">
                        {{#if attributes.assigned_user_id}}
                            <a href="#{{buildRoute module="Employees" id=attributes.assigned_user_id action="detail"}}">
                                {{fieldValue this "assigned_user_name"}}&#44;
                            </a>
                        {{else}}
                            {{str "LBL_UNASSIGNED" this.module}}&#44;
                        {{/if}}
                        {{relativeTime attributes.record_date class=\'date\'}}
                    </div>
                </li>
            {{/each}}
            {{#notEq ../collection.next_offset "-1"}}
                <li><a class="more" data-action="show-more">{{str "LBL_SHOW_MORE_MODULE" this.module}}</a></li>
            {{/notEq}}
        </ul>
    {{else}}
        <div class="block-footer">{{#if ../collection.dataFetched}}{{str "LBL_NO_DATA_AVAILABLE" this.module}}{{else}}{{str "LBL_LOADING" this.module}}{{/if}}</div>
    {{/if}}
</div>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    extendsFrom: \'TabbedDashletView\',

    /**
     * {@inheritDoc}
     *
     * @property {Number} _defaultSettings.limit Maximum number of records to
     *   load per request, defaults to \'10\'.
     * @property {String} _defaultSettings.visibility Records visibility
     *   regarding current user, supported values are \'user\' and \'group\',
     *   defaults to \'user\'.
     */
    _defaultSettings: {
        limit: 10,
        visibility: \'user\'
    },

    /**
     * {@inheritDoc}
     */
    initialize: function(options) {
        options.meta = options.meta || {};
        options.meta.template = \'tabbed-dashlet\';

        this.plugins = _.union(this.plugins, [
            \'LinkedModel\'
        ]);

        this._super(\'initialize\', [options]);
    },

    /**
     * {@inheritDoc}
     *
     * FIXME: This should be removed when metadata supports date operators to
     * allow one to define relative dates for date filters.
     */
    _initTabs: function() {
        this._super("_initTabs");

        // FIXME: since there\'s no way to do this metadata driven (at the
        // moment) and for the sake of simplicity only filters with \'date_due\'
        // value \'today\' are replaced by today\'s date
        var today = new Date();
        today.setHours(23, 59, 59);
        today.toISOString();

        _.each(_.pluck(_.pluck(this.tabs, \'filters\'), \'date_due\'), function(filter) {
            _.each(filter, function(value, operator) {
                if (value === \'today\') {
                    filter[operator] = today;
                }
            });
        });
    },

   _renderHtml: function() {
        if (this.meta.config) {
            this._super(\'_renderHtml\');
            return;
        }

        var tab = this.tabs[this.settings.get(\'activeTab\')];

        if (tab.overdue_badge) {
            this.overdueBadge = tab.overdue_badge;
        }

        var model1 = app.data.createBean(\'Tasks\');
        model1.set("assigned_user_id", "seed_sally_id");
        model1.set("assigned_user_name", "Sally Bronsen");
        model1.set("name", "Programmatically added task");
        model1.set("date_due", "2014-02-07T07:15:00-05:00");
        model1.set("date_due_flag", false);
        model1.set("date_start", null);
        model1.set("date_start_flag", false);
        model1.set("status", "Not Started");

        this.collection.add(model1);

        _.each(this.collection.models, function(model) {
            var pictureUrl = app.api.buildFileURL({
                module: \'Users\',
                id: model.get(\'assigned_user_id\'),
                field: \'picture\'
            });
            model.set(\'picture_url\', pictureUrl);
        }, this);

        this._super(\'_renderHtml\');
    }
})
',
    ),
  ),
  'docs-forms-select2' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // forms range
    _renderHtml: function () {
        this._super(\'_renderHtml\');

        var $this,
            ctor;

        function select2ChartSelection(chart) {
            if (!chart.id) return chart.text; // optgroup
            return svgChartIcon(chart.id);
        }

        function select2ChartResult(chart) {
            if (!chart.id) return chart.text; // optgroup
            return svgChartIcon(chart.id) + chart.text;
        }

        //
        $(\'select[name="priority"]\').select2({minimumResultsForSearch: 7});

        //
        $(\'#priority\').select2({minimumResultsForSearch: 7, width: \'200px\'});

        //
        $("#e6").select2({
            placeholder: "Search for a movie",
            minimumInputLength: 1,
            ajax: { // instead of writing the function to execute the request we use Select2\'s convenient helper
                url: "styleguide/content/js/select2.json",
                dataType: \'json\',
                data: function (term, page) {
                    return {q:term};
                },
                results: function (data, page) { // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to alter remote JSON data
                    return {results: data.movies};
                }
            },
            formatResult: function(m) { return m.title; },
            formatSelection: function(m) { return m.title; }
        });

        //
        $this = $(\'#priority2\');
        ctor = this.getSelect2Constructor($this);
        $this.select2(ctor);

        //
        $this = $(\'#state\');
        ctor = this.getSelect2Constructor($this);
        ctor.formatSelection = function(state) { return state.id;};
        $this.select2(ctor);
        $(\'#states3\').select2({width: \'200px\', minimumResultsForSearch: 7, allowClear: true});

        //
        $this = $(\'#s2_hidden\');
        ctor = this.getSelect2Constructor($this);
        ctor.data = [
            {id: 0, text: \'enhancement\'},
            {id: 1, text: \'bug\'},
            {id: 2, text: \'duplicate\'},
            {id: 3, text: \'invalid\'},
            {id: 4, text: \'wontfix\'}
        ];
        ctor.placeholder = "Select a issue type...";
        $this.select2(ctor);
        $(\'#states4\').select2({width: \'200px\', minimumResultsForSearch: 1000, dropdownCssClass: \'select2-drop-bootstrap\'});

        //
        $this = $(\'select[name="chart_type"]\');
        ctor = this.getSelect2Constructor($this);
        ctor.dropdownCssClass = \'chart-results select2-narrow\';
        ctor.width = \'off\';
        ctor.minimumResultsForSearch = 9;
        ctor.formatResult = select2ChartResult;
        ctor.formatSelection = select2ChartSelection;
        ctor.escapeMarkup = function(m) { return m; };
        $this.select2(ctor);

        //
        $this = $(\'select[name="label_module"]\');
        ctor = this.getSelect2Constructor($this);
        ctor.width = \'off\';
        ctor.minimumResultsForSearch = 9;
        ctor.formatSelection = function(item) {
            return \'<span class="label label-module label-module-mini label-\' + item.text + \'">\' + item.id + \'</span>\';
        };
        ctor.escapeMarkup = function(m) { return m; };
        ctor.width = \'55px\';
        $this.select2(ctor);

        //
        $(\'#priority3\').select2({width: \'200px\', minimumResultsForSearch: 7, dropdownCssClass: \'select2-drop-error\'});

        //
        $(\'#multi1\').select2({width: \'100%\'});
        $(\'#multi2\').select2({width: \'300px\'});

        //
        $(\'#states5\').select2({
            width: \'100%\',
            minimumResultsForSearch: 7,
            //closeOnSelect: false,
            containerCssClass: \'select2-choices-pills-close\'
        });

        //
        $(\'#states4\').select2({
            width: \'100%\',
            minimumResultsForSearch: 7,
            containerCssClass: \'select2-choices-pills-close\',
            formatSelection: function(item) {
                return \'<span class="select2-choice-type">Link:</span><a href="javascript:void(0)" rel="\' + item.id + \'">\' + item.text + \'</a>\';
            },
            escapeMarkup: function(m) { return m; }
        });

        //
        /*$("select.select2").each(function(){
            $this = $(this),
                ctor = getSelect2Constructor($this);
            //$this.select2( ctor );
        });*/

        $(\'.error .select .error-tooltip\').tooltip({
            trigger: \'click\',
            container: \'body\'
        });
    },

    getSelect2Constructor: function($select) {
        var _ctor = {};
        _ctor.minimumResultsForSearch = 7;
        _ctor.dropdownCss = {};
        _ctor.dropdownCssClass = \'\';
        _ctor.containerCss = {};
        _ctor.containerCssClass = \'\';

        if ( $select.hasClass(\'narrow\') ) {
            _ctor.dropdownCss.width = \'auto\';
            _ctor.dropdownCssClass = \'select2-narrow \';
            _ctor.containerCss.width = \'75px\';
            _ctor.containerCssClass = \'select2-narrow\';
            _ctor.width = \'off\';
        }

        if ( $select.hasClass(\'inherit-width\') ) {
            _ctor.dropdownCssClass = \'select2-inherit-width \';
            _ctor.containerCss.width = \'100%\';
            _ctor.containerCssClass = \'select2-inherit-width\';
            _ctor.width = \'off\';
        }

        return _ctor;
    }
})
',
    ),
    'templates' => 
    array (
      'docs-forms-select2' => '
<!-- Form inputs
================================================== -->
<script src="styleguide/content/charts/js/chart-utils.js"></script>

<section id="select2">
  <div class="page-header">
    <h1>Select2 <small>a jQuery based replacement for select boxes. It supports searching, remote data sets, and infinite scrolling of results. <a href="http://ivaynberg.github.io/select2/" target="_blank"><i class="fa fa-book"></i> Docs</a> </small></h1>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <h2>Single Select</h2>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span12 padded">
      <h3>Basic Example</h3>
      <select name="priority" class="select2" data-placeholder="Choose a priority...">
        <option></option>
        <option value="Urgent">Urgent</option>
        <option value="High">High</option>
        <option value="Medium">Medium</option>
        <option disabled value="Low">Low</option>
      </select>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span6">
<pre class="prettyprint linenums" style="margin-bottom: 9px;">
 &lt;select class="select2"
      data-placeholder="Choose a priority..."&gt;
  &lt;option&gt;&lt;/option&gt;
  &lt;option value="Urgent"&gt;Urgent&lt;/option&gt;
  ...
&lt;/select&gt;
&lt;script&gt;
  var $select = $(\'select.select2\');
  $select.select2();
&lt;/script&gt;
</pre>
    </div>
    <div class="span6">
      <p>Select2 has many of the same features as Chosen with greater flexibility for customization. Configuration options are passed to Select2 in a constructor object <code>$select.select2({allowClear:true})</code>. All of the configuration options can be found at the <a href="http://ivaynberg.github.com/select2/">Select2 homepage</a>.</p>
      <p>Select2 creates two distinct containers for the select input elements. The first is the <b>container</b> that wraps the original form control and the stylized input divs. The second is the <b>dropdown</b> that wraps the select options and option filter input control.</p>
      <p class="alert alert-info"><b>Note:</b> Any classes that are assigned to the original select input will be added to the container and dropdown divs.</p>
    </div>
  </div>

  <!-- ==================== -->

  <div class="row-fluid">
    <div class="span12 padded">
      <h3>Retreive Selected Value</h3>
      <select id="priority" data-placeholder="Choose a priority...">
        <option></option>
        <option value="Urgent">Urgent</option>
        <option value="High">High</option>
        <option value="Medium">Medium</option>
        <option disabled value="Low">Low</option>
      </select>
      <a class="btn btn-primary" onclick="$(\'#priority\').select2(\'val\',\'High\');return false;">Set Value</a>
      <a class="btn btn-primary" onclick="alert($(\'#priority\').select2(\'val\'));return false">Get Value</a>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span6">
<pre class="prettyprint linenums" style="margin-bottom: 9px;">
&lt;a class="btn btn-primary" onclick="alert($(\'#priority\').select2(\'val,\'High\')"&gt;Set Value&lt;/a&gt;
&lt;a class="btn btn-primary" onclick="alert($(\'#priority\').select2(\'val\'))"&gt;Get Value&lt;/a&gt;
&lt;script&gt;
  $(\'#priority\').select2({width:\'200px\'});
&lt;/script&gt;
</pre>
    </div>
    <div class="span6">
      <p>The selected value of a Select2 input can be retrieved by passing the "val" parameter <code>$select.select2(\'val\')</code> and assigned by passing the "val" parameter and a "value" <code>$select.select2(\'val\',\'CA\')</code></p>
      <p>The width of the Select2 container can be defined explicitly, or ...</p>
    </div>
  </div>

  <!-- ==================== -->

  <div class="row-fluid">
    <div class="span12 padded">
      <h3>Loading results from json</h3>
     <input type="hidden" class="bigdrop" id="e6" style="width:600px"/></p>
    </div>
  </div>
  <hr>

  <!-- ==================== -->

  <div class="row-fluid">
    <div class="span12 padded">
      <h3>Full Width Dynamic</h3>
      <select id="priority2" class="select2 inherit-width" data-placeholder="Choose a priority...">
        <option></option>
        <option value="Urgent">Urgent</option>
        <option value="High">High</option>
        <option value="Medium">Medium</option>
        <option disabled value="Low">Low</option>
      </select>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span6">

<pre class="prettyprint linenums" style="margin-bottom: 9px;">
 &lt;select
      class="select2 inherit-width"
      data-placeholder="Choose a priority..."&gt;
  &lt;option&gt;&lt;/option&gt;
  &lt;option value="Urgent"&gt;Urgent&lt;/option&gt;
  ...
&lt;/select&gt;
&lt;script&gt;
  var $this = $(\'#priority2\')
    , ctor = getSelect2Constructor($this);
  $this.select2( ctor );
&lt;/script&gt;
</pre>

      <div class="padded">
        <h3>Small Select Container Width</h3>
        <select id="state" class="select2 narrow" tabindex="3" data-placeholder="State...">
          <option></option>
          <option value="NC">North Carolina</option>
          <option value="PA">Pennsylvania</option>
          <option value="WA">Washington</option>
          <option value="CA">California</option>
        </select>
      </div>

<pre class="prettyprint linenums" style="margin-bottom: 9px;">
 &lt;select
      id="state" class="select2 narrow"
      data-placeholder="Choose a priority..."&gt;
  &lt;option&gt;&lt;/option&gt;
  &lt;option value="Urgent"&gt;Urgent&lt;/option&gt;
  ...
&lt;/select&gt;
&lt;script&gt;
  function formatStateSelection (state) {
    return state.id;
  }

  var $select = $(\'#state\')
    , ctor = getSelect2Constructor($this);
      ctor.formatSelection = formatStateSelection;

  $select.select2( ctor );
&lt;/script&gt;
</pre>

    </div>

    <div class="span6">
      <p>We can leverage custom SugarCRM classes to control the select container width. One is <b>inherit-width</b> which expands the container and dropdown to 100% of the parent div of the original select input. The other is <b>narrow</b> which collapses the width of the Select2 container but expands the dropdown to allow for auto width of the selection options.</p>
      <p>These classes are not part of Select2 but rather used by a custom function to set up four properties in the Select2 constructor: <code>dropdownCss</code>, <code>dropdownCssClass</code>, <code>containerCss</code>, <code>containerCssClass</code>. Be careful about setting the width of the dropdown to 100% because it will grow to 100% of the page since it is attached directly to the body. Feel free to add any needed styling to the constructor function. The default select2-inherit-width and select2-narrow as defined in the select2.less file should cover most cases.</p>
<pre class="prettyprint linenums" style="margin-bottom: 9px;">
&lt;script&gt;
  function getSelect2Constructor($select) {
    var _ctor = {};
    _ctor.minimumResultsForSearch = 7;
    _ctor.dropdownCss = {};
    _ctor.dropdownCssClass = \'\';
    _ctor.containerCss = {};
    _ctor.containerCssClass = \'\';
    if ( $select.hasClass(\'narrow\') ) {
      _ctor.dropdownCss.width = \'auto\';
      _ctor.dropdownCssClass = \'select2-narrow \';
      _ctor.containerCss.width = \'75px\';
      _ctor.containerCssClass = \'select2-narrow\';
      _ctor.width = \'off\';
    }
    if ( $select.hasClass(\'inherit-width\') ) {
      _ctor.dropdownCssClass = \'select2-inherit-width \';
      _ctor.containerCss.width = \'100%\';
      _ctor.containerCssClass = \'select2-inherit-width\';
      _ctor.width = \'off\';
    }
    return _ctor;
  }
&lt;/script&gt;
</pre>
    </div>

  </div>

  <!-- ==================== -->

  <div class="row-fluid">
    <div class="span12 padded">
      <h3>Deselect &amp; Dropdown Fitler</h3>
      <select id="states3" class="select2" data-placeholder="Select a state...">
<option></option>
<option value="AL">Alabama</option>
<option value="AK">Alaska</option>
<option value="AZ">Arizona</option>
<option value="AR">Arkansas</option>
<option value="CA">California</option>
<option value="CO">Colorado</option>
<option value="CT">Connecticut</option>
<option value="DE">Delaware</option>
<option value="DC">District Of Columbia</option>
<option value="FL">Florida</option>
<option value="GA">Georgia</option>
<option value="HI">Hawaii</option>
<option value="ID">Idaho</option>
<option value="IL">Illinois</option>
<option value="IN">Indiana</option>
<option value="IA">Iowa</option>
<option value="KS">Kansas</option>
<option value="KY">Kentucky</option>
<option value="LA">Louisiana</option>
<option value="ME">Maine</option>
<option value="MD">Maryland</option>
<option value="MA">Massachusetts</option>
<option value="MI">Michigan</option>
<option value="MN">Minnesota</option>
<option value="MS">Mississippi</option>
<option value="MO">Missouri</option>
<option value="MT">Montana</option>
<option value="NE">Nebraska</option>
<option value="NV">Nevada</option>
<option value="NH">New Hampshire</option>
<option value="NJ">New Jersey</option>
<option value="NM">New Mexico</option>
<option value="NY">New York</option>
<option value="NC">North Carolina</option>
<option value="ND">North Dakota</option>
<option value="OH">Ohio</option>
<option value="OK">Oklahoma</option>
<option value="OR">Oregon</option>
<option value="PA">Pennsylvania</option>
<option value="RI">Rhode Island</option>
<option value="SC">South Carolina</option>
<option value="SD">South Dakota</option>
<option value="TN">Tennessee</option>
<option value="TX">Texas</option>
<option value="UT">Utah</option>
<option value="VT">Vermont</option>
<option value="VA">Virginia</option>
<option value="WA">Washington</option>
<option value="WV">West Virginia</option>
<option value="WI">Wisconsin</option>
<option value="WY">Wyoming</option>
      </select>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span6">
<pre class="prettyprint linenums" style="margin-bottom: 9px;">
&lt;script&gt;
  $(\'#states3\').select2({
    minimumResultsForSearch:7,
    allowClear:true
  });
&lt;/script&gt;
</pre>
    </div>
    <div class="span6">
      <p>To enable a deselect "x" icon to reset the Select2 control, pass the <code>allowClear</code> property in the constructor.</p>
      <p>The <code>minimumResultsForSearch</code> property is used to prevent a select option filter input if the number of select options is less than the number set.</p>
    </div>
  </div>

  <!-- ==================== -->

  <div class="row-fluid">
    <div class="span12 padded">
      <h3>Select with Hidden Input</h3>
      <input type="hidden" id="s2_hidden" class="select2 inherit-width">
    </div>
  </div>

  <div class="row-fluid">
    <div class="span6">
<pre class="prettyprint linenums" style="margin-bottom: 9px;">
&lt;input id="s2_hidden" class="select2 inherit-width"&gt;

&lt;script&gt;
  var $this = $(\'#s2_hidden\')
    , ctor = getSelect2Constructor($this);
  ctor.data = [{id:0,text:\'enhancement\'},{id:1,text:\'bug\'},{id:2,text:\'duplicate\'},{id:3,text:\'invalid\'},{id:4,text:\'wontfix\'}];
  ctor.placeholder = "Select a issue type...";
  $this.select2( ctor );
&lt;/script&gt;
</pre>
    </div>
    <div class="span6">
      <p>It is possible to use a <code>&lt;input type="hidden"&gt;</code> field as long as you pass data in the constructor. This example also shows the use of the <code>placeholder</code> property in the constructor.</p>
    </div>
  </div>

  <!-- ==================== -->
<!--
  <div class="row-fluid">
    <div class="span12 padded">
      <h3>Deselect &amp; Dropdown Fitler</h3>
      <select id="states4" class="select2" data-placeholder="Select a state...">
        <option></option>
        <option value="AL">Alabama</option>
        <option value="AK">Alaska</option>
        <option value="AZ">Arizona</option>
        <option value="AR">Arkansas</option>
        <option value="CA">California</option>
        <option value="CO">Colorado</option>
        <option value="CT">Connecticut</option>
        <option value="DE">Delaware</option>
        <option value="DC">District Of Columbia</option>
        <option value="FL">Florida</option>
        <option value="GA">Georgia</option>
        <option value="HI">Hawaii</option>
        <option value="ID">Idaho</option>
        <option value="IL">Illinois</option>
        <option value="IN">Indiana</option>
        <option value="IA">Iowa</option>
        <option value="KS">Kansas</option>
        <option value="KY">Kentucky</option>
        <option value="LA">Louisiana</option>
        <option value="ME">Maine</option>
        <option value="MD">Maryland</option>
        <option value="MA">Massachusetts</option>
        <option value="MI">Michigan</option>
        <option value="MN">Minnesota</option>
        <option value="MS">Mississippi</option>
        <option value="MO">Missouri</option>
        <option value="MT">Montana</option>
        <option value="NE">Nebraska</option>
        <option value="NV">Nevada</option>
        <option value="NH">New Hampshire</option>
        <option value="NJ">New Jersey</option>
        <option value="NM">New Mexico</option>
        <option value="NY">New York</option>
        <option value="NC">North Carolina</option>
        <option value="ND">North Dakota</option>
        <option value="OH">Ohio</option>
        <option value="OK">Oklahoma</option>
        <option value="OR">Oregon</option>
        <option value="PA">Pennsylvania</option>
        <option value="RI">Rhode Island</option>
        <option value="SC">South Carolina</option>
        <option value="SD">South Dakota</option>
        <option value="TN">Tennessee</option>
        <option value="TX">Texas</option>
        <option value="UT">Utah</option>
        <option value="VT">Vermont</option>
        <option value="VA">Virginia</option>
        <option value="WA">Washington</option>
        <option value="WV">West Virginia</option>
        <option value="WI">Wisconsin</option>
        <option value="WY">Wyoming</option>
      </select>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span6">
<pre class="prettyprint linenums" style="margin-bottom: 9px;">
&lt;script&gt;
  $(\'#states3\').select2({
    minimumResultsForSearch: 7,
    dropdownCssClass: \'select2-drop-bootstrap\'
  });
&lt;/script&gt;
</pre>
    </div>
    <div class="span6">
      <p>The Select2 dropdown can be styled to match the bootstrap dropdown by adding the <code></code> to the constructor.</p>
    </div>
  </div> -->

  <!-- ==================== -->

  <div class="row-fluid">
    <div class="span12 padded">
      <h3>Use images in Dropdowns</h3>
      <select name="chart_type" class="select2 narrow" data-placeholder="Choose a chart type...">
        <option></option>
        <option value="donut">Donut</option>
        <option value="funnel">Funnel</option>
        <option value="horizontal">Horizontal</option>
        <option value="line">Line</option>
        <option value="pareto">Pareto</option>
        <option value="pie">Pie</option>
        <option value="stack">Stack</option>
        <option value="vertical">Vertical</option>
      </select>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span6">
<pre class="prettyprint linenums" style="margin-bottom: 9px;">
&lt;script&gt;
  var $this = $(\'select[name="chart_type"]\')
    , ctor = getSelect2Constructor($this);
  ctor.dropdownCssClass = \'chart-results\';
  ctor.width = \'off\';
  ctor.minimumResultsForSearch = 9;
  ctor.formatResult = select2ChartResult;
  ctor.formatSelection = select2ChartSelection;
  ctor.escapeMarkup = function(m) { return m; };

  $this.select2(ctor);
&lt;/script&gt;
</pre>
    </div>
    <div class="span6">
      <p>Using a custom renderer, you can even use images in drop downs.</p>
    </div>
  </div>


  <!-- ==================== -->

  <div class="row-fluid">
    <div class="span12 padded">
      <h3>Use module icon in Dropdowns</h3>
      <select name="label_module" class="select2 narrow" data-placeholder="Choose a chart type...">
        <option></option>
        <option value="Ac">Accounts</option>
        <option value="Op">Opportunities</option>
        <option value="Co">Contacts</option>
      </select>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span6">
<pre class="prettyprint linenums" style="margin-bottom: 9px;">
&lt;script&gt;
  var $this = $(\'select[name="label_module"]\')
    , ctor = getSelect2Constructor($this);
  ctor.width = \'off\';
  ctor.minimumResultsForSearch = 9;
  ctor.formatSelection = function(item) {
      return \'&lt;span class="label label-module label-module-mini label-\' + item.text + \'"&gt;\' + item.id + \'&lt;/span&gt;\';
    };
  ctor.escapeMarkup = function(m) { return m; };
  ctor.width = \'55px\';

  $this.select2(ctor);
&lt;/script&gt;
</pre>
    </div>
    <div class="span6">
      <p>Using a custom renderer, you can even use images in drop downs.</p>
    </div>
  </div>

  <!-- ==================== -->
  <div class="row-fluid">
    <div class="span12 padded">

      <div class="control-group error">
        <h3>Error Addon</h3>
        <label style="display:block">Single Select Error</label>
        <div class="input-append error select">
          <select id="priority3" class="select2" data-placeholder="Choose a priority...">
            <option></option>
            <option value="Urgent">Urgent</option>
            <option value="High">High</option>
            <option value="Medium">Medium</option>
            <option value="Low">Low</option>
          </select>
          <span class="error-tooltip add-on select2" rel="tooltip" data-original-title="Error: This field is required"><i class="fa fa-exclamation-circle"></i></span>
        </div>
      </div>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span6">
<pre class="prettyprint linenums" style="margin-bottom: 9px;">
&lt;div class="control-group error"&gt;
  &lt;div class="input-append select"&gt;
    &lt;select id="priority3"
        class="select2"
        data-placeholder="Choose a priority..."&gt;
      &lt;option&gt;&lt;/option&gt;
      &lt;option value="Urgent"&gt;Urgent&lt;/option&gt;
      ...
    &lt;/select&gt;
    &lt;span class="add-on"&gt;&lt;i class="fa fa-exclamation-circle"&gt;&lt;/i&gt;&lt;/span&gt;
    &lt;p class="help-block"&gt;Error. This field is required.&lt;/p&gt;&lt;/span&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;script&gt;
  $(\'#priority3\').select2({
    width:\'200px\',
    minimumResultsForSearch:7,
    dropdownCssClass: \'select2-drop-error\'
  });
&lt;/script&gt;
</pre>
    </div>

    <div class="span6">
      <p>Select2 controls can be styled with error notifications just like other inputs.
    </div>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <h2>Multi Select</h2>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span6">
      <div class="control-group padded">
        <label style="display:block">Multi Select with Basic Choices</h3>
        <select id="multi1" size="3" multiple="multiple" class="select2">
            <option>Option 2</option>
            <option>Option 3</option>
            <option>Option 4</option>
        </select>
        <p class="help-block"></p></span>
      </div>

      <div class="control-group error padded">
        <label style="display:block">Label</label>
        <div class="input-append select error">
          <select id="multi2" size="3" multiple="multiple" class="select2">
              <option value="2">Option 2</option>
              <option value="3">Option 3</option>
              <option value="4">Option 4</option>
          </select>
            <span class="error-tooltip  add-on local" rel="tooltip" data-original-title="Error: This field is required"><i class="fa fa-exclamation-circle"></i></span>
        </div>
      </div>
    </div>

    <div class="span6">
      Setting up a multiselect control with Select2 is as easy as adding the <code>multiple</code> attribute to the select element.
    </div>

  </div><!--/row-->

  <!-- ==================== -->

  <div class="row-fluid">
    <div class="span6 padded">
      <h3>Standard Pill Style</h3>
      <select id="states5" class="select2" multiple="multiple" data-placeholder="Select a state...">
        <option></option>
        <option value="MO">Missouri</option>
        <option value="MT">Montana</option>
        <option value="NE">Nebraska</option>
        <option value="NV">Nevada</option>
        <option value="NH">New Hampshire</option>
        <option value="NJ">New Jersey</option>
        <option value="NM">New Mexico</option>
        <option value="NY">New York</option>
        <option value="NC">North Carolina</option>
      </select>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span6">
<pre class="prettyprint linenums" style="margin-bottom: 9px;">
&lt;script&gt;
  $(\'#states5\').select2({
    width:\'100%\',
    minimumResultsForSearch:7,
    closeOnSelect: false,
    containerCssClass: \'select2-choices-pills-close\'
  });
&lt;/script&gt;
</pre>
    </div>
    <div class="span6">
      <p>The Select2 multiselect choices can be styled to look like our standard pills by setting the <code>containerCssClass</code> constructuor property to <code>select2-choices-pills-close</code>. If you want to keep the dropdown open for fast multi select actions, pass the <code>closeOnSelect: false</code> option.</p>
      <p>Deleting the custom choice pill is like in Outlook where you use the delete key to focus on a pill and then delete again to remove.</p>
    </div>
  </div>

  <!-- ==================== -->

  <div class="row-fluid">
    <div class="span6 padded">
      <h3>Custom Formaters</h3>
      <select id="states4" class="select2" multiple="multiple" data-placeholder="Select a state...">
        <option></option>
        <option value="AL">Alabama</option>
        <option value="AK">Alaska</option>
        <option value="AZ">Arizona</option>
        <option value="AR">Arkansas</option>
        <option value="CA">California</option>
        <option value="CO">Colorado</option>
        <option value="CT">Connecticut</option>
        <option value="DE">Delaware</option>
        <option value="DC">District Of Columbia</option>
      </select>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span6">
<pre class="prettyprint linenums" style="margin-bottom: 9px;">
&lt;script&gt;

  $(\'#states4\').select2({
    width:\'100%\',
    containerCssClass: \'select2-choices-pills-close\',
    formatSelection: function(item) {
      return \'&lt;span class="select2-choice-type"&gt;Link:&lt;/span&gt;&lt;a class="select2-choice-filter" href="javascript:void(0)" rel="\' + item.id +\'"&gt;\'+ item.text +\'&lt;/a&gt;\';
    },
    escapeMarkup: function(m) { return m; }
  });
&lt;/script&gt;
</pre>
    </div>
    <div class="span6">
      <p>The Select2 multiselect choices can be styled to look like our split filter pills by adding the <code>select2-choices-pills</code> class to the constructor and passing the custom formatter for the choices in the <code>formatSelection</code> option.</p>
    </div>
  </div>

</section>
',
    ),
  ),
  'docs-charts-colors' => 
  array (
    'templates' => 
    array (
      'docs-charts-colors' => '
<style>
  .nv-chart {
    height: 280px;
  }
</style>

<section id="colors">

  <div class="page-header">
    <h2>Defining Chart Colors <small>Flexible methods for assigning color maps and fill methods to D3 charts.</small></h2>
  </div>

  <div class="row-fluid">

    <div class="span6">
      <h3>Standard Chart Colors</h3>
      <p>Using standard D3 chart colors is the default (Option 1 data).</p>
      <div id="gauge1" class="nv-chart">
        <svg></svg>
      </div>
<pre class="prettyprint linenums">
  var gauge = nv.models.gaugeChart()
      .colorData( \'default\' );

  d3.select("#gauge1 svg")
    .datum(gauge_data_1)
    .call(gauge);
</pre>
    </div>

    <div class="span6">
      <h3>Standard Chart Colors with Gradient Fill</h3>
      <p>It is possible to fill the chart shapes with a gradient using the active color palette.</p>
      <div id="gauge2" class="nv-chart">
        <svg></svg>
      </div>
<pre class="prettyprint linenums">
  var gauge = nv.models.gaugeChart()
        .colorData( \'default\', {gradient:true} );

  d3.select("#gauge2 svg")
    .datum(gauge_data_1)
    .call(gauge);
</pre>
    </div>

  </div>

  <div class="row-fluid">

    <div class="span6">
      <h3>Data-Defined Chart Colors</h3>
      <p>If colors are defined in the data, they are used instead of D3 colors (Option 2 data).</p>
      <div id="gauge3" class="nv-chart">
        <svg></svg>
      </div>
<pre class="prettyprint linenums">
  var gauge = nv.models.gaugeChart()
      .colorData( \'default\' );

  d3.select("#gauge3 svg")
    .datum(gauge_data_2)
    .call(gauge);
</pre>
    </div>

    <div class="span6">
      <h3>Data-Defined Chart Colors with Gradient Fill</h3>
      <p>It is possible to fill the chart shapes with a gradient using a graduated color palette.</p>
      <div id="gauge4" class="nv-chart">
        <svg></svg>
      </div>
<pre class="prettyprint linenums">
  var gauge = nv.models.gaugeChart()
        .colorData( \'default\', {gradient:true} );

  d3.select("#gauge4 svg")
    .datum(gauge_data_2)
    .call(gauge);
</pre>
    </div>

  </div>

  <div class="row-fluid">

    <div class="span6">
      <h3>Graduated Palette Chart Colors</h3>
      <p>It is also possible to use a graduated palette (any data option).</p>
      <div id="gauge5" class="nv-chart">
        <svg></svg>
      </div>
<pre class="prettyprint linenums">
  var gauge = nv.models.gaugeChart()
      .colorData( \'graduated\', {c1: \'#e8e2ca\', c2: \'#3e6c0a\', l: gauge_data.data.length} );

  d3.select("#gauge5 svg")
    .datum(gauge_data_1)
    .call(gauge);
</pre>
    </div>

    <div class="span6">
      <h3>Graduated Palette Chart Colors with Gradient Fill</h3>
      <p>It is possible to fill the chart shapes with a gradient using a graduated color palette.</p>
      <div id="gauge6" class="nv-chart">
        <svg></svg>
      </div>
<pre class="prettyprint linenums">
  var gauge = nv.models.gaugeChart()
      .colorData( \'graduated\', {c1: \'#e8e2ca\', c2: \'#3e6c0a\', l: gauge_data.data.length, gradient:true} );

  d3.select("#gauge6 svg")
    .datum(gauge_data_1)
    .call(gauge);
</pre>
    </div>

  </div>

  <div class="row-fluid">

    <div class="span6">
      <h3>CSS Class Chart Colors</h3>
      <p>Chart colors can be defined using classes. The default classes in themes). If classes are not defined in data, they are assigned sequentially.</p>
      <div id="gauge7" class="nv-chart">
        <svg></svg>
      </div>
<pre class="prettyprint linenums">
  var gauge = nv.models.gaugeChart()
      .colorData( \'class\' );

  d3.select("#gauge7 svg")
    .datum(gauge_data_1)
    .call(gauge);
</pre>
    </div>

    <div class="span6">
      <h3>Data-Defined Chart Classes</h3>
      <p>It is possible to specify which chart class to use for use for a data series in the chart data (Option 3 data).</p>
      <div id="gauge8" class="nv-chart">
        <svg></svg>
      </div>
<pre class="prettyprint linenums">
  var gauge = nv.models.gaugeChart()
      .colorData( \'class\', {gradient:true} );

  d3.select("#gauge8 svg")
    .datum(gauge_data_3)
    .call(gauge);
</pre>
    </div>

  </div>
      <div class="alert alert-info">
        <strong>Data-Defined Chart Classes with Gradient Fill</strong> It is possible to define gradient fills with CSS but requires use of SVG resource files <code>.nv-fill-gradient { fill: \'url(./custom_gradient.svg)\'; }</code>; however, they are not currently supported by the theming engine.
      </div>
</section>


<section id="colors">
  <div class="page-header">
    <h2>Example Chart Data Options <small>Options for setting chart color styles.</small></h2>
    <p>Color classes and RGB hex values can be embedded in the chart data. Depending on the colorData setting, they may or may not be used.</p>
  </div>
  <div class="row-fluid">

    <div class="span4">
      <h3>Option 1: Default Chart Data</h3>
      <p>A basic data definition for charts will use the standard D3 colors.</p>
<pre class="prettyprint linenums">
    var gauge_data_1 = {
      \'properties\': {
        \'title\': \'Closed Won Opportunities Gauge\',
        \'value\': 4
      },
      \'data\': [
        {
          key: "Range 1"
          , y: 3
        },
        {
          key: "Range 2"
          , y: 5
        },
        {
          key: "Range 3"
          , y: 7
        },
        {
          key: "Range 4"
          , y: 9
        }
      ]
    };
</pre>
    </div>

    <div class="span4">
      <h3>Option 2: Data-Defined Colors</h3>
      <p>If colors are defined in the data, they are used instead of D3 colors.</p>
<pre class="prettyprint linenums">
    var gauge_data_2 = {
      \'properties\': {
        \'title\': \'Closed Won Opportunities Gauge\',
        \'value\': 4
      },
      \'data\': [
        {
          key: "Range 1"
          , y: 3
          , color: "#d62728"
        },
        {
          key: "Range 2"
          , y: 5
          , color: "#ff7f0e"
        },
        {
          key: "Range 3"
          , y: 7
          , color: "#bcbd22"
        },
        {
          key: "Range 4"
          , y: 9
          , color: "#2ca02c"
        }
      ]
    };
</pre>
    </div>

    <div class="span4">
      <h3>Option 3: Data-Defined Classes</h3>
      <p>If classes are defined in the data, they are used to set the style properties.</p>
<pre class="prettyprint linenums">
    var gauge_data_3 = {
      \'properties\': {
        \'title\': \'Closed Won Opportunities Gauge\',
        \'value\': 4
      },
      \'data\': [
        {
          key: "Range 1"
          , y: 3
          , class: "nv-fill07"
        },
        {
          key: "Range 2"
          , y: 5
          , class: "nv-fill03"
        },
        {
          key: "Range 3"
          , y: 7
          , class: "nv-fill17"
        },
        {
          key: "Range 4"
          , y: 9
          , class: "nv-fill05"
        }
      ]
    };
</pre>
    </div>

  </div>

</section>


<section id="colors">
  <div class="page-header">
    <h2>Sugar7 Accent Color Classes for Charts</h2>
    <p>A description of the standard D3 categorical color scales is in <a href="https://github.com/mbostock/d3/wiki/Ordinal-Scales">D3 documentation</a>. New color scales can be generated using Cynthia Brewer\'s <a href="http://colorbrewer2.org/">ColorBrewer</a>.</p>
  </div>
  <div class="row-fluid">
    <div class="span12">
      <h3>Fill and Stroke</h3>
      <p>A progressive rainbow of colors.</p>
      <div>
<table class="table table-bordered table-striped">
          <tr>
            <td><code>@mint => @nv-fill00, @nv-stroke00</code></td>
            <td><code>.nv-fill00, .nv-stroke00</code></td>
            <td class="hex mono">#0d8046</td>
            <td class="swatch-col"><span class="swatch mint"></span></td>
          </tr>
          <tr>
            <td><code>@green => @nv-fill01, @nv-stroke01</code></td>
            <td><code>.nv-fill01, .nv-stroke01</code></td>
            <td class="hex mono">#33800d</td>
            <td><span class="swatch green"></span></td>
          </tr>
          <tr>
            <td><code>@army => @nv-fill02, @nv-stroke02</code></td>
            <td><code>.nv-fill02, .nv-stroke02</code></td>
            <td class="hex mono">#6a800d</td>
            <td><span class="swatch army"></span></td>
          </tr>
          <tr>
            <td><code>@yellow => @nv-fill03, @nv-stroke03</code></td>
            <td><code>.nv-fill03, .nv-stroke03</code></td>
            <td class="hex mono">#e5a117</td>
            <td><span class="swatch yellow"></span></td>
          </tr>
          <tr>
            <td><code>@orange => @nv-fill04, @nv-stroke04</code></td>
            <td><code>.nv-fill04, .nv-stroke04</code></td>
            <td class="hex mono">#cc3314</td>
            <td><span class="swatch orange"></span></td>
          </tr>
          <tr>
            <td><code>@red => @nv-fill05, @nv-stroke05</code></td>
            <td><code>.nv-fill05, .nv-stroke05</code></td>
            <td class="hex mono">#e61718</td>
            <td><span class="swatch red"></span></td>
          </tr>
          <tr>
            <td><code>@pink => @nv-fill06, @nv-stroke06</code></td>
            <td><code>.nv-fill06, .nv-stroke06</code></td>
            <td class="hex mono">#e5176d</td>
            <td><span class="swatch pink"></span></td>
          </tr>
          <tr>
            <td><code>@purple => @nv-fill07, @nv-stroke07</code></td>
            <td><code>.nv-fill07, .nv-stroke07</code></td>
            <td class="hex mono">#6d17e5</td>
            <td><span class="swatch purple"></span></td>
          </tr>
          <tr>
            <td><code>@night => @nv-fill08, @nv-stroke08</code></td>
            <td><code>.nv-fill08, .nv-stroke08</code></td>
            <td class="hex mono">#1f12b3</td>
            <td><span class="swatch night"></span></td>
          </tr>
          <tr>
            <td><code>@blue => @nv-fill09, @nv-stroke09</code></td>
            <td><code>.nv-fill09, .nv-stroke09</code></td>
            <td class="hex mono">#176de5</td>
            <td><span class="swatch blue"></span></td>
          </tr>
          <tr>
            <td><code>@ocean => @nv-fill10, @nv-stroke10</code></td>
            <td><code>.nv-fill10, .nv-stroke10</code></td>
            <td class="hex mono">#1378bf</td>
            <td><span class="swatch ocean"></span></td>
          </tr>
          <tr>
            <td><code>@pacific => @nv-fill11, @nv-stroke11</code></td>
            <td><code>.nv-fill11, .nv-stroke11</code></td>
            <td class="hex mono">#0f7799</td>
            <td><span class="swatch pacific"></span></td>
          </tr>
          <tr>
            <td><code>@teal => @nv-fill12, @nv-stroke12</code></td>
            <td><code>.nv-fill12, .nv-stroke12</code></td>
            <td class="hex mono">#0d806c</td>
            <td><span class="swatch teal"></span></td>
          </tr>
          <tr>
            <td><code>@coral => @nv-fill13, @nv-stroke13</code></td>
            <td><code>.nv-fill13, .nv-stroke13</code></td>
            <td class="hex mono">#ff6fcf</td>
            <td><span class="swatch coral"></span></td>
          </tr>
</table>
      </div>
    </div>


    {{!-- <div class="span6">
      <h3>Creating New Chart Color Themes</h3>

      <div class="alert alert-info">
        <p>New chart color themes are created in the <code>/styleguide/themes/clients/base</code> directory. Copy the <code>/default</code> folder and rename. Inside this folder, edit the variables.less file. In the CHART section, edit the @fillXX and @strokeXX LESS variables as needed. Then go to the Bootstrap Builder at <a href="../build/">/styleguide/build/</a>, choose your new theme folder and click the "Compile" button. Your new chart color theme will be available.</p>
        <p>Your new chart color theme will be visible in the charts on this page. To enable the use of chart color CSS classes, set the <code>.colorData( \'class\' )</code> property in your chart definition (see example above). Custom SVG gradient fills in CSS are not supported.</p>
      </div>
    </div> --}}
  </div>
</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
  className: \'container-fluid\',

  // charts colors
  _renderHtml: function () {
    this._super(\'_renderHtml\');

    var gauge_data_1 = {
      "properties": {
        "title": "Closed Won Opportunities Gauge",
        "values": [
          {
            "group": 1,
            "t": 4
          }
        ]
      },
      "data": [
        {
          "key": "Range 1"
          , "y": 3
        },
        {
          "key": "Range 2"
          , "y": 5
        },
        {
          "key": "Range 3"
          , "y": 7
        },
        {
          "key": "Range 4"
          , "y": 9
        }
      ]
    };

    var gauge_data_2 = {
      "properties": {
        "title": "Closed Won Opportunities Gauge",
        "values": [
          {
            "group": 1,
            "t": 4
          }
        ]
      },
      "data": [
        {
          "key": "Range 1"
          , "y": 3
          , "color": "#d62728"
        },
        {
          "key": "Range 2"
          , "y": 5
          , "color": "#ff7f0e"
        },
        {
          "key": "Range 3"
          , "y": 7
          , "color": "#bcbd22"
        },
        {
          "key": "Range 4"
          , "y": 9
          , "color": "#2ca02c"
        }
      ]
    };

    var gauge_data_3 = {
      "properties": {
        "title": "Closed Won Opportunities Gauge",
        "values": [
          {
            "group": 1,
            "t": 4
          }
        ]
      },
      "data": [
        {
          "key": "Range 1"
          , "y": 3
          , "class": "nv-fill07"
        },
        {
          "key": "Range 2"
          , "y": 5
          , "class": "nv-fill03"
        },
        {
          "key": "Range 3"
          , "y": 7
          , "class": "nv-fill17"
        },
        {
          "key": "Range 4"
          , "y": 9
          , "class": "nv-fill05"
        }
      ]
    };

    // Gauge Chart
    nv.addGraph(function() {
      var gauge = nv.models.gaugeChart()
          .x(function(d) { return d.key })
          .y(function(d) { return d.y })
          .showLabels(true)
          .showTitle(true)
          .colorData(\'default\')
          .ringWidth(50)
          .maxValue(9)
          .direction(app.lang.direction)
          .transitionMs(4000);

      d3.select(\'#gauge1 svg\')
          .datum(gauge_data_1)
          .call(gauge);

      return gauge;
    });

    nv.addGraph(function() {
      var gauge = nv.models.gaugeChart()
          .x(function(d) { return d.key })
          .y(function(d) { return d.y })
          .showLabels(true)
          .showTitle(true)
          .colorData(\'default\', {gradient: true})
          .ringWidth(50)
          .maxValue(9)
          .direction(app.lang.direction)
          .transitionMs(4000);

      d3.select(\'#gauge2 svg\')
          .datum(gauge_data_1)
        .transition().duration(500)
          .call(gauge);

      return gauge;
    });

    nv.addGraph(function() {
      var gauge = nv.models.gaugeChart()
          .x(function(d) { return d.key })
          .y(function(d) { return d.y })
          .showLabels(true)
          .showTitle(true)
          .colorData(\'default\')
          .ringWidth(50)
          .maxValue(9)
          .direction(app.lang.direction)
          .transitionMs(4000);

      d3.select(\'#gauge3 svg\')
          .datum(gauge_data_2)
        .transition().duration(500)
          .call(gauge);

      return gauge;
    });

    nv.addGraph(function() {
      var gauge = nv.models.gaugeChart()
          .x(function(d) { return d.key })
          .y(function(d) { return d.y })
          .showLabels(true)
          .showTitle(true)
          .colorData(\'default\', {gradient: true})
          .ringWidth(50)
          .maxValue(9)
          .direction(app.lang.direction)
          .transitionMs(4000);

      d3.select(\'#gauge4 svg\')
          .datum(gauge_data_2)
        .transition().duration(500)
          .call(gauge);

      return gauge;
    });

    nv.addGraph(function() {
      var gauge = nv.models.gaugeChart()
          .x(function(d) { return d.key })
          .y(function(d) { return d.y })
          .showLabels(true)
          .showTitle(true)
          .colorData(\'graduated\', {c1: \'#e8e2ca\', c2: \'#3e6c0a\', l: gauge_data_1.data.length})
          .ringWidth(50)
          .maxValue(9)
          .direction(app.lang.direction)
          .transitionMs(4000);

      d3.select(\'#gauge5 svg\')
          .datum(gauge_data_1)
        .transition().duration(500)
          .call(gauge);

      return gauge;
    });

    nv.addGraph(function() {
      var gauge = nv.models.gaugeChart()
          .x(function(d) { return d.key })
          .y(function(d) { return d.y })
          .showLabels(true)
          .showTitle(true)
          .colorData(\'graduated\', {c1: \'#e8e2ca\', c2: \'#3e6c0a\', l: gauge_data_1.data.length, gradient: true})
          .ringWidth(50)
          .maxValue(9)
          .direction(app.lang.direction)
          .transitionMs(4000);

      d3.select(\'#gauge6 svg\')
          .datum(gauge_data_1)
        .transition().duration(500)
          .call(gauge);

      return gauge;
    });


    nv.addGraph(function() {
      var gauge = nv.models.gaugeChart()
          .x(function(d) { return d.key })
          .y(function(d) { return d.y })
          .showLabels(true)
          .showTitle(true)
          .colorData(\'class\')
          .ringWidth(50)
          .maxValue(9)
          .direction(app.lang.default)
          .transitionMs(4000);

      d3.select(\'#gauge7 svg\')
          .datum(gauge_data_1)
        .transition().duration(500)
          .call(gauge);

      return gauge;
    });

    nv.addGraph(function() {
      var gauge = nv.models.gaugeChart()
          .x(function(d) { return d.key })
          .y(function(d) { return d.y })
          .showLabels(true)
          .showTitle(true)
          .colorData(\'class\', {gradient: true})
          .ringWidth(50)
          .maxValue(9)
          .direction(app.lang.direction)
          .transitionMs(4000);

      d3.select(\'#gauge8 svg\')
          .datum(gauge_data_3)
        .transition().duration(500)
          .call(gauge);

      return gauge;
    });
  }
})
',
    ),
  ),
  'docs-base-labels' => 
  array (
    'templates' => 
    array (
      'docs-base-labels' => '
<!-- Labels
================================================== -->
<style>
  .table-example .label-module {
    vertical-align: top;
  }
  .table-example .span2 {
    padding: 8px;
  }
</style>
<section id="labels">
  <div class="page-header">
    <h1>Inline labels <small>Label and annotate text</small></h1>
  </div>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Labels</th>
        <th>Markup</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><span class="label">Default</span></td>
        <td><code>&lt;span class="label"&gt;Default&lt;/span&gt;</code></td>
      </tr>
      <tr>
        <td><span class="label label-important">Important</span></td>
        <td><code>&lt;span class="label label-important"&gt;Important&lt;/span&gt;</code></td>
      </tr>
      <tr>
        <td><span class="label label-warning">Warning</span></td>
        <td><code>&lt;span class="label label-warning"&gt;warning&lt;/span&gt;</code></td>
      </tr>
      <tr>
        <td><span class="label label-pending">Pending</span></td>
        <td><code>&lt;span class="label label-pending"&gt;warning&lt;/span&gt;</code></td>
      </tr>
      <tr>
        <td><span class="label label-success">Success</span></td>
        <td><code>&lt;span class="label label-success"&gt;Success&lt;/span&gt;</code></td>
      </tr>
      <tr>
        <td><span class="label label-info">Info</span></td>
        <td><code>&lt;span class="label label-info"&gt;Info&lt;/span&gt;</code></td>
      </tr>
      <tr>
        <td><span class="label label-inverse">Inverse</span></td>
        <td><code>&lt;span class="label label-inverse"&gt;Inverse&lt;/span&gt;</code></td>
      </tr>
    </tbody>
  </table>

  <h3>Module Element Badges</h3>

  <table class="table table-bordered table-striped table-example">
    <thead>
      <tr>
        <th>Module</th>
        <th>Labels</th>
        <th>module Singular</th>
        <th>Class Name</th>
      </tr>
    </thead>
    <tbody>
  {{#each module_list}}
      <tr>
        <td><b>{{./this}}</b></td>
        <td>
          <span class="label label-module label-module-lg label-{{./this}}" rel="tooltip" data-title="{{moduleIconToolTip this}}">{{moduleIconLabel this}}</span>
          <span class="label label-module label-module-md label-{{./this}}" rel="tooltip" data-title="{{moduleIconToolTip this}}">{{moduleIconLabel this}}</span>
          <span class="label label-module label-module-btn label-{{./this}}" rel="tooltip" data-title="{{moduleIconToolTip this}}">{{moduleIconLabel this}}</span>
          <span class="label label-module label-{{./this}}" rel="tooltip" data-title="{{moduleIconToolTip this}}">{{moduleIconLabel this}}</span>
          <span class="label label-module label-module-sm label-{{./this}}" rel="tooltip" data-title="{{moduleIconToolTip this}}">{{moduleIconLabel this}}</span>
          <span class="label label-module label-module-mini label-{{./this}}" rel="tooltip" data-title="{{moduleIconToolTip this}}">{{moduleIconLabel this}}</span>
        </td>
        <td>{{moduleIconToolTip this}}</td>
        <td><code>.label-{{./this}}</code></td>
      </tr>
  {{/each}}
    </tbody>
  </table>
  </div>

  <h3>Markup</h3>

<pre class="prettyprint linenums">
&lt;span class="label label-module label-module-lg label-&#123;&#123;this.module}}" rel="tooltip" data-title="&#123;&#123;moduleIconToolTip this.module}}"&gt;&#123;&#123;moduleIconLabel this.module}}&lt;/span&gt;
</pre>

  <h3>CSS</h3>
  <p>The <code>.label-module</code> and <code>.avatar</code> classes share the same size suffixes</p>
  <div class="table-example">
    <div class="row-fluid">
      <div class="span2">
        <code>.label-module-lg</code>
        <code>.avatar-lg</code>
      </div>
      <div class="span2">
        <span class="label label-module label-module-lg label-Modules" rel="tooltip" data-title="Modules">Mo</span>
      </div>
      <div class="span2">
        <img src="styleguide/content/charts/img/avatar_sabra.jpg" class="avatar avatar-lg">
      </div>
      <div class="span2">
        42px &times; 42px
      </div>
    </div>
    <div class="row-fluid">
      <div class="span2">
        <code>.label-module-md</code>
        <code>.avatar-md</code>
      </div>
      <div class="span2">
        <span class="label label-module label-module-md label-Modules" rel="tooltip" data-title="Modules">Mo</span>
      </div>
      <div class="span2">
        <img src="styleguide/content/charts/img/avatar_sabra.jpg" class="avatar avatar-md">
      </div>
      <div class="span2">
        32px &times; 32px
      </div>
    </div>
    <div class="row-fluid">
      <div class="span2">
        <code>.label-module-btn</code>
        <code>.avatar-btn</code>
      </div>
      <div class="span2">
        <span class="label label-module label-module-btn label-Modules" rel="tooltip" data-title="Modules">Mo</span>
      </div>
      <div class="span2">
        <img src="styleguide/content/charts/img/avatar_sabra.jpg" class="avatar avatar-btn">
      </div>
      <div class="span2">
        28px &times; 28px
      </div>
    </div>
    <div class="row-fluid">
      <div class="span2">
        <code>.label-module</code>
        <code>.avatar</code>
      </div>
      <div class="span2">
        <span class="label label-module label-Modules" rel="tooltip" data-title="Modules">Mo</span>
      </div>
      <div class="span2">
        <img src="styleguide/content/charts/img/avatar_sabra.jpg" class="avatar">
      </div>
      <div class="span2">
        24px &times; 24px
      </div>
    </div>
    <div class="row-fluid">
      <div class="span2">
        <code>.label-module-sm</code>
        <code>.avatar-sm</code>
      </div>
      <div class="span2">
        <span class="label label-module label-module-sm label-Modules" rel="tooltip" data-title="Modules">Mo</span>
      </div>
      <div class="span2">
        <img src="styleguide/content/charts/img/avatar_sabra.jpg" class="avatar avatar-sm">
      </div>
      <div class="span2">
        20px &times; 20px
      </div>
    </div>
    <div class="row-fluid">
      <div class="span2">
        <code>.label-module-mini</code>
        <code>.avatar-mini</code>
      </div>
      <div class="span2">
        <span class="label label-module label-module-mini label-Modules" rel="tooltip" data-title="Modules">Mo</span>
      </div>
      <div class="span2">
        <img src="styleguide/content/charts/img/avatar_sabra.jpg" class="avatar avatar-mini">
      </div>
      <div class="span2">
        16px &times; 16px
      </div>
    </div>
  </div>
</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',
    module_list: [],

    _renderHtml: function () {
        this.module_list = _.without(app.metadata.getModuleNames({filter: \'display_tab\', access: \'read\'}), \'Home\');
        this.module_list.sort();
        this._super(\'_renderHtml\');
    }
})
',
    ),
  ),
  'dashlet-chart' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    extendsFrom: \'OpportunityMetricsView\',

    loadData: function (options) {
        if (this.meta.config) {
            return;
        }
        this.metricsCollection = {
          "won": {
            "amount_usdollar": 40000,
            "count": 4,
            "formattedAmount": "$30,000",
            "icon": "caret-up",
            "cssClass": "won",
            "dealLabel": "won",
            "stageLabel": "Won"
          },
          "lost": {
            "amount_usdollar": 10000,
            "count": 1,
            "formattedAmount": "$10,000",
            "icon": "caret-down",
            "cssClass": "lost",
            "dealLabel": "lost",
            "stageLabel": "Lost"
          },
          "active": {
            "amount_usdollar": 30000,
            "count": 3,
            "formattedAmount": "$30,000",
            "icon": "minus",
            "cssClass": "active",
            "dealLabel": "active",
            "stageLabel": "Active"
          }
        };
        this.chartCollection = {
          "data": [
            {
              "key": "Won",
              "value": 4,
              "classes": "won"
            },
            {
              "key": "Lost",
              "value": 1,
              "classes": "lost"
            },
            {
              "key": "Active",
              "value": 3,
              "classes": "active"
            }
          ],
          "properties": {
            "title": "Opportunity Metrics",
            "value": 8,
            "label": 8
          }
        };
        this.total = 8;
    }
})
',
    ),
    'templates' => 
    array (
      'dashlet-chart' => '
{{#if total}}
<div class="opportunity-metrics-wrapper">
    <div class="nv-chart nv-chart-donut">
        <svg id="{{cid}}"></svg>
    </div>
    {{#eachOptions metricsCollection}}
        <div class="opportunity-metric">
            <span class="label {{value.cssClass}}">{{value.count}}</span>
            <div class="deal-amount-metric {{key}}">{{value.formattedAmount}}</div>
            <div class="opportunity-metric-description">{{value.stageLabel}}</div>
        </div>
    {{/eachOptions}}
</div>
{{/if}}
{{#eq total 0}}
    <div class="block-footer">{{str "LBL_NO_DATA_AVAILABLE"}}</div>
{{/eq}}
',
    ),
    'meta' => 
    array (
      'dashlets' => 
      array (
        0 => 
        array (
          'label' => 'Chart Dashlet Example',
          'description' => 'LBL_DASHLET_OPPORTUNITY_DESCRIPTION',
          'filter' => 
          array (
            'module' => 
            array (
              0 => 'Styleguide',
            ),
            'view' => 'record',
          ),
          'config' => 
          array (
          ),
          'preview' => 
          array (
          ),
        ),
      ),
    ),
  ),
  'docs-layouts-tabs' => 
  array (
    'templates' => 
    array (
      'docs-layouts-tabs' => '
<!-- Nav, Tabs, & Pills
================================================== -->
<section id="nav-tabs-pills">
  <div class="page-header">
    <h1>Nav, tabs, and pills <small>Highly customizable list-style navigation</small></h1>
  </div>

  <h2>Lightweight defaults <small>Same markup, different classes</small></h2>
  <div class="row-fluid">
    <div class="span4">
      <h3>Powerful base class</h3>
      <p>All nav components here&mdash;tabs, pills, and lists&mdash;<strong>share the same base markup and styles</strong> through the <code>.nav</code> class.</p>
      <h3>Why tabs and pills</h3>
      <p>Tabs and pills are built on a <code>&lt;ul&gt;</code> with the same core HTML, a list of links. Swap between tabs or pills with only a class.</p>
      <p>Both options are great for sub-sections of content or navigating between pages of related content.</p>
    </div>
    <div class="span4">
      <h3>Basic tabs</h3>
      <p>Take a regular <code>&lt;ul&gt;</code> of links and add <code>.nav-tabs</code>:</p>
      <ul class="nav nav-tabs">
        <li class="active"><a>Home</a></li>
        <li><a>Profile</a></li>
        <li><a>Messages</a></li>
      </ul>
<pre class="prettyprint linenums">
&lt;ul class="nav nav-tabs"&gt;
  &lt;li class="active"&gt;
    &lt;a&gt;Home&lt;/a&gt;
  &lt;/li&gt;
  &lt;li&gt;&lt;a&gt;...&lt;/a&gt;&lt;/li&gt;
  &lt;li&gt;&lt;a&gt;...&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;
</pre>
    </div>
    <div class="span4">
      <h3>Basic pills</h3>
      <p>Take that same HTML, but use <code>.nav-pills</code> instead:</p>
      <ul class="nav nav-pills">
        <li class="active"><a>Home</a></li>
        <li><a>Profile</a></li>
        <li><a>Messages</a></li>
      </ul>
<pre class="prettyprint linenums">
&lt;ul class="nav nav-pills"&gt;
  &lt;li class="active"&gt;
    &lt;a&gt;Home&lt;/a&gt;
  &lt;/li&gt;
  &lt;li&gt;&lt;a&gt;...&lt;/a&gt;&lt;/li&gt;
  &lt;li&gt;&lt;a&gt;...&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;
</pre>
    </div>
  </div>

  <h2>Stackable <small>Make tabs or pills vertical</small></h2>
  <div class="row-fluid">
    <div class="span4">
      <h3>How to stack \'em</h3>
      <p>As tabs and pills are horizontal by default, just add a second class, <code>.nav-stacked</code>, to make them appear vertically stacked.</p>
    </div>
    <div class="span4">
      <h3>Stacked tabs</h3>
      <ul class="nav nav-tabs nav-stacked">
        <li class="active"><a>Home</a></li>
        <li><a>Profile</a></li>
        <li><a>Messages</a></li>
      </ul>
<pre class="prettyprint linenums">
&lt;ul class="nav nav-tabs nav-stacked"&gt;
  ...
&lt;/ul&gt;
</pre>
    </div>
    <div class="span4">
      <h3>Stacked pills</h3>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a>Home</a></li>
        <li><a>Profile</a></li>
        <li><a>Messages</a></li>
      </ul>
<pre class="prettyprint linenums">
&lt;ul class="nav nav-pills nav-stacked"&gt;
  ...
&lt;/ul&gt;
</pre>
    </div>
  </div>

  <h2>Dropdowns <small>For advanced nav components</small></h2>
  <div class="row-fluid">
    <div class="span4">
      <h3>Rich menus made easy</h3>
      <p>Dropdown menus in tabs and pills are super easy and require only a little extra HTML and a lightweight jQuery plugin.</p>
      <p>Head over to the Javascript page to read the docs on <a href="widgets.html#tabs">initializing dropdowns</a>.</p>
    </div>
    <div class="span4">
      <h3>Tabs with dropdowns</h3>
      <ul class="nav nav-tabs">
        <li class="active"><a>Home</a></li>
        <li><a>Profile</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown">Dropdown <i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu">
            <li><a>Action</a></li>
            <li><a>Another action</a></li>
            <li><a>Something else here</a></li>
            <li class="divider"></li>
            <li><a>Separated link</a></li>
          </ul>
        </li>
      </ul>
<pre class="prettyprint linenums">
&lt;ul class="nav nav-tabs"&gt;
  &lt;li class="dropdown"&gt;
    &lt;a class="dropdown-toggle"
       data-toggle="dropdown"
      &gt;
        Dropdown
        &lt;i class="fa fa-caret-down"&gt;&lt;/i&gt;
      &lt;/a&gt;
    &lt;ul class="dropdown-menu"&gt;
      &lt;!-- links --&gt;
    &lt;/ul&gt;
  &lt;/li&gt;
&lt;/ul&gt;
</pre>
    </div>
    <div class="span4">
      <h3>Pills with dropdowns</h3>
      <ul class="nav nav-pills">
        <li class="active"><a>Home</a></li>
        <li><a>Profile</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown">Dropdown <i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu">
            <li><a>Action</a></li>
            <li><a>Another action</a></li>
            <li><a>Something else here</a></li>
            <li class="divider"></li>
            <li><a>Separated link</a></li>
          </ul>
        </li>
      </ul>
<pre class="prettyprint linenums">
&lt;ul class="nav nav-pills"&gt;
  &lt;li class="dropdown"&gt;
    &lt;a class="dropdown-toggle"
       data-toggle="dropdown"
      &gt;
        Dropdown
        &lt;i class="fa fa-caret-down"&gt;&lt;/i&gt;
      &lt;/a&gt;
    &lt;ul class="dropdown-menu"&gt;
      &lt;!-- links --&gt;
    &lt;/ul&gt;
  &lt;/li&gt;
&lt;/ul&gt;
</pre>
    </div>
  </div>

  <h2>Nav lists <small>Build simple stacked navs, great for sidebars</small></h2>
  <div class="row-fluid">
    <div class="span4">
      <h3>Application-style navigation</h3>
      <p>Nav lists provide a simple and easy way to build groups of nav links with optional headers. They\'re best used in sidebars like the Finder in OS X.</p>
      <p>Structurally, they\'re built on the same core nav styles as tabs and pills, so usage and customization are straightforward.</p>
      <h4>With icons</h4>
      <p>Nav lists are also easy to equip with icons. Add the proper <code>&lt;i&gt;</code> tag with class and you\'re set.</p>
    </div>
    <div class="span4">
      <h3>Example nav list</h3>
      <p>Take a list of links and add <code>class="nav nav-list"</code>:</p>
      <div class="well" style="padding: 8px 0;">
        <ul class="nav nav-list">
          <li class="nav-header">List header</li>
          <li class="active"><a>Home</a></li>
          <li><a>Library</a></li>
          <li><a>Applications</a></li>
          <li class="nav-header">Another list header</li>
          <li><a>Profile</a></li>
          <li><a>Settings</a></li>
          <li><a>Help</a></li>
        </ul>
      </div> <!-- /well -->
<pre class="prettyprint linenums">
&lt;ul class="nav nav-list"&gt;
  &lt;li class="nav-header"&gt;
    List header
  &lt;/li&gt;
  &lt;li class="active"&gt;
    &lt;a&gt;Home&lt;/a&gt;
  &lt;/li&gt;
  &lt;li&gt;
    &lt;a&gt;Library&lt;/a&gt;
  &lt;/li&gt;
  ...
&lt;/ul&gt;
</pre>
    </div>
    <div class="span4">
      <h3>Example with Icons
        </h3>
      <p>Same example, but with <code>&lt;i&gt;</code> tags for icons.</p>
      <div class="well" style="padding: 8px 0;">
        <ul class="nav nav-list">
          <li class="nav-header">List header</li>
          <li class="active"><a><i class="fa fa-white fa-home"></i> Home</a></li>
          <li><a><i class="fa fa-book"></i> Library</a></li>
          <li><a><i class="fa fa-pencil"></i> Applications</a></li>
          <li class="nav-header">Another list header</li>
          <li><a><i class="fa fa-user"></i> Profile</a></li>
          <li><a><i class="fa fa-cog"></i> Settings</a></li>
          <li><a><i class="fa fa-flag"></i> Help</a></li>
        </ul>
      </div> <!-- /well -->
<pre class="prettyprint linenums">
&lt;ul class="nav nav-list"&gt;
  ...
  &lt;li&gt;
    &lt;a&gt;
      &lt;i class="fa fa-book"&gt;&lt;/i&gt;
      Library
    &lt;/a&gt;
  &lt;/li&gt;
  ...
&lt;/ul&gt;
</pre>
    </div>
  </div>


  <h2>Tabbable nav <small>Bring tabs to life via javascript</small></h2>
  <div class="row-fluid">
    <div class="span4">
      <h3>What\'s included</h3>
      <p>Bring your tabs to life with a simple plugin to toggle between content via tabs. The framework integrates tabbable tabs in four styles: top (default), right, bottom, and left.</p>
      <p>Changing between them is easy and only requires changing very little markup.</p>
    </div>
    <div class="span4">
      <h3>Tabbable example</h3>
      <p>To make tabs tabbable, wrap the <code>.nav-tabs</code> in another div with class <code>.tabbable</code>.</p>
      <div class="tabbable" style="margin-bottom: 9px;">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" data-target="tab1">Section 1</a></li>
          <li><a data-toggle="tab" data-target="tab2">Section 2</a></li>
          <li><a data-toggle="tab" data-target="tab3">Section 3</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab1">
            <p>I\'m in Section 1.</p>
          </div>
          <div class="tab-pane" id="tab2">
            <p>Howdy, I\'m in Section 2.</p>
          </div>
          <div class="tab-pane" id="tab3">
            <p>What up girl, this is Section 3.</p>
          </div>
        </div>
      </div> <!-- /tabbable -->
    </div>
    <div class="span4">
      <h3>Custom jQuery plugin</h3>
      <p>All tabbable tabs are powered by our lightweight jQuery plugin. Read more about how to bring tabbable tabs to life on the javascript docs page.</p>
      <p><a class="btn" href="widgets.html#tabs">Get the javascript &rarr;</a></p>
    </div>
  </div>

  <h3>Straightforward markup</h3>
  <p>Using tabbable tabs requires a wrapping div, a set of tabs, and a set of tabbable panes of content.</p>
<pre class="prettyprint linenums">
&lt;div class="tabbable"&gt;
  &lt;ul class="nav nav-tabs"&gt;
    &lt;li class="active"&gt;&lt;a data-toggle="tab" data-target="tab1"&gt;Section 1&lt;/a&gt;&lt;/li&gt;
    &lt;li&gt;&lt;a data-toggle="tab" data-target="tab2"&gt;Section 2&lt;/a&gt;&lt;/li&gt;
  &lt;/ul&gt;
  &lt;div class="tab-content"&gt;
    &lt;div class="tab-pane active" id="tab1"&gt;
      &lt;p&gt;I\'m in Section 1.&lt;/p&gt;
    &lt;/div&gt;
    &lt;div class="tab-pane" id="tab2"&gt;
      &lt;p&gt;Howdy, I\'m in Section 2.&lt;/p&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
</pre>

  <h3>Tabbable in any direction</h3>
  <div class="row-fluid">
    <div class="span4">
      <h4>Tabs on the bottom</h4>
      <p>Flip the order of the HTML and add a class to put tabs on the bottom.</p>
      <div class="tabbable tabs-below">
        <div class="tab-content">
          <div class="tab-pane active" id="tabA">
            <p>I\'m in Section A.</p>
          </div>
          <div class="tab-pane" id="tabB">
            <p>Howdy, I\'m in Section B.</p>
          </div>
          <div class="tab-pane" id="tabC">
            <p>What up girl, this is Section C.</p>
          </div>
        </div>
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" data-target="tabA">Section 1</a></li>
          <li><a data-toggle="tab" data-target="tabB">Section 2</a></li>
          <li><a data-toggle="tab" data-target="tabC">Section 3</a></li>
        </ul>
      </div> <!-- /tabbable -->
<pre class="prettyprint linenums" style="margin-top: 11px;">
&lt;div class="tabbable tabs-below"&gt;
  &lt;div class="tab-content"&gt;
    ...
  &lt;/div&gt;
  &lt;ul class="nav nav-tabs"&gt;
    ...
  &lt;/ul&gt;
&lt;/div&gt;
</pre>
    </div>
    <div class="span4">
      <h4>Tabs on the left</h4>
      <p>Swap the class to put tabs on the left.</p>
      <div class="tabbable tabs-left">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" data-target="tablA">Section 1</a></li>
          <li><a data-toggle="tab" data-target="tablB">Section 2</a></li>
          <li><a data-toggle="tab" data-target="tablC">Section 3</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tablA">
            <p>I\'m in Section A.</p>
          </div>
          <div class="tab-pane" id="tablB">
            <p>Howdy, I\'m in Section B.</p>
          </div>
          <div class="tab-pane" id="tablC">
            <p>What up girl, this is Section C.</p>
          </div>
        </div>
      </div> <!-- /tabbable -->
<pre class="prettyprint linenums">
&lt;div class="tabbable tabs-left"&gt;
  &lt;ul class="nav nav-tabs"&gt;
    ...
  &lt;/ul&gt;
  &lt;div class="tab-content"&gt;
    ...
  &lt;/div&gt;
&lt;/div&gt;
</pre>
    </div>
    <div class="span4">
      <h4>Tabs on the right</h4>
      <p>Swap the class to put tabs on the right.</p>
      <div class="tabbable tabs-right">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" data-target="tabrA">Section 1</a></li>
          <li><a data-toggle="tab" data-target="tabrA">Section 2</a></li>
          <li><a data-toggle="tab" data-target="tabrA">Section 3</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tabrA">
            <p>I\'m in Section A.</p>
          </div>
          <div class="tab-pane" id="tabrB">
            <p>Howdy, I\'m in Section B.</p>
          </div>
          <div class="tab-pane" id="tabrC">
            <p>What up girl, this is Section C.</p>
          </div>
        </div>
      </div> <!-- /tabbable -->
<pre class="prettyprint linenums">
&lt;div class="tabbable tabs-right"&gt;
  &lt;ul class="nav nav-tabs"&gt;
    ...
  &lt;/ul&gt;
  &lt;div class="tab-content"&gt;
    ...
  &lt;/div&gt;
&lt;/div&gt;
</pre>
    </div>
  </div>

</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',

    // layouts tabs
    _renderHtml: function () {
        this._super(\'_renderHtml\');

        this.$(\'#nav-tabs-pills\')
            .find(\'ul.nav-tabs > li > a, ul.nav-list > li > a, ul.nav-pills > li > a\')
            .on(\'click.styleguide\', function(e){
                e.preventDefault();
                e.stopPropagation();
                $(this).tab(\'show\');
            });
    },

    _dispose: function() {
        this.$(\'#nav-tabs-pills\')
            .find(\'ul.nav-tabs > li > a, ul.nav-list > li > a, ul.nav-pills > li > a\')
            .off(\'click.styleguide\');

        this._super(\'_dispose\');
    }
})
',
    ),
  ),
  'field' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\',
    section: {},
    useTable: true,
    parent_link: \'\',
    tempfields: [],

    _render: function() {
        var self = this,
            fieldTypeReq = this.context.get(\'field_type\'),
            fieldTypes = (fieldTypeReq === \'all\' ? [\'text\',\'bool\',\'date\',\'datetimecombo\',\'currency\',\'email\'] : [fieldTypeReq]),
                //\'textarea\',\'url\',\'phone\',\'password\',\'full_name\'
            fieldStates = [\'detail\',\'edit\',\'error\',\'disabled\'],
            fieldLayouts = [\'base\',\'record\',\'list\'],
            fieldMeta = {};

            this.section.title = \'Form Elements\';
            this.section.description = \'Basic fields that support detail, record, and edit modes with error addons.\';
            this.useTable = (fieldTypeReq === \'all\' ? true : false);
            this.parent_link = (fieldTypeReq === \'all\' ? \'docs/index-forms\' : \'field/all\');
            this.tempfields = [];

        _.each(fieldTypes, function(fieldType){

            //build meta data for field examples from model fields
            fieldMeta = _.find(self.model.fields, function(field) {
                if (field.type === \'datetime\' && fieldType.indexOf(\'date\') === 0) {
                    field.type = fieldType;
                }
                return field.type === fieldType;
            }, self);

            //insert metadata into array for hbs template
            if (fieldMeta) {
                var metaData = self.meta[\'template_values\'][fieldType];

                if (_.isObject(metaData) && !_.isArray(metaData)) {
                    _.each(metaData, function(value, name) {
                        self.model.set(name, value);
                    }, self);
                } else {
                    self.model.set(fieldMeta.name, metaData);
                }

                self.tempfields.push(fieldMeta);
            }
        });

        this._super(\'_render\');

        //render example fields into accordion grids
        //e.g., [\'text\',\'bool\',\'date\',\'datetimecombo\',\'currency\',\'email\']
        _.each(fieldTypes, function(fieldType){

            var fieldMeta = _.find(self.tempfields, function(field) {
                    return field.type === fieldType;
                }, self);

            //e.g., [\'detail\',\'edit\',\'error\',\'disabled\']
            _.each(fieldStates, function(fieldState) {

                //e.g., [\'base\',\'record\',\'list\']
                _.each(fieldLayouts, function(fieldLayout) {
                    var fieldTemplate = fieldState;

                    //set field view template name
                    if (fieldLayout === \'list\') {
                        if (fieldState === \'edit\') {
                            fieldTemplate = \'list-edit\';
                        } else {
                            fieldTemplate = \'list\';
                        }
                    } else if (fieldState === \'error\') {
                        fieldTemplate = \'edit\';
                    }

                    var fieldSettings = {
                            view: self,
                            def: {
                                name: fieldMeta.name,
                                type: fieldType,
                                view: fieldTemplate,
                                default: true,
                                enabled: fieldState === \'disabled\' ? false : true
                            },
                            viewName: fieldTemplate,
                            context: self.context,
                            module: self.module,
                            model: self.model,
                            meta: fieldMeta
                        };

                    var fieldObject = app.view.createField(fieldSettings),
                        fieldDivId = \'#\' + fieldType + \'_\' + fieldState + \'_\' + fieldLayout;

                    //pre render field setup
                    if (fieldState !== \'detail\') {
                        if (!fieldObject.plugins || !_.contains(fieldObject.plugins, "ListEditable") || fieldLayout !== \'list\') {
                            fieldObject.setMode(\'edit\');
                        } else {
                            fieldObject.setMode(\'list-edit\');
                        }
                    }
                    if (fieldState === \'disabled\') {
                        fieldObject.setDisabled(true);
                    }

                    //render field
                    self.$(fieldDivId).append(fieldObject.el);
                    fieldObject.render();

                    //post render field setup
                    if (fieldType === \'currency\' && fieldState === \'edit\') {
                        fieldObject.setMode(\'edit\');
                    }
                    if (fieldState === \'error\') {
                        if (fieldType === \'email\') {
                            var errors = {email: [\'primary@example.info\']};
                            fieldObject.decorateError(errors);
                        } else {
                            fieldObject.setMode(\'edit\');
                            fieldObject.decorateError(\'You did a bad, bad thing.\');
                        }
                    }
                });

            });

            if (fieldTypeReq !== \'all\') {
                self.title = fieldTypeReq + \' field\';
                var descTpl = app.template.getView(\'styleguide.\' + fieldTypeReq, self.module);
                if (descTpl) {
                    self.description = descTpl();
                }
            }
        });
    }
})
',
    ),
    'meta' => 
    array (
      'template_values' => 
      array (
        'email' => 
        array (
          0 => 
          array (
            'email_address' => 'primary@example.info',
            'primary_address' => true,
            'opt_out' => false,
            'invalid_email' => false,
          ),
          1 => 
          array (
            'email_address' => 'optout@example.info',
            'primary_address' => false,
            'opt_out' => true,
            'invalid_email' => false,
          ),
          2 => 
          array (
            'email_address' => 'invalid@example.info',
            'primary_address' => false,
            'opt_out' => false,
            'invalid_email' => true,
          ),
          3 => 
          array (
            'email_address' => 'normal@example.info',
            'primary_address' => false,
            'opt_out' => false,
            'invalid_email' => false,
          ),
        ),
        'datetimecombo' => '2013-05-06T22:47:00+00:00',
        'date' => '2013-05-06T22:47:00+00:00',
        'currency' => 
        array (
          'list_price' => 12345.700000000001,
          'currency_id' => -99,
          'list_price_ERROR' => 'xyc',
        ),
        'bool' => 
        array (
          'do_not_call' => 1,
          'do_not_call_ERROR' => 0,
        ),
        'text' => 
        array (
          'description' => 'The styleguide module description.',
          'description_ERROR' => 'This description of the styleguide module is too long.',
        ),
        'phone' => 
        array (
          'phone_home' => '999-123-4567',
          'phone_home_ERROR' => '999-123-456',
        ),
        'url' => 
        array (
          'website' => 'http://www.sugarcrm.com',
          'website_ERROR' => 'http://www.sugar',
        ),
        'textarea' => 
        array (
          'description' => 'Dr. Max Wiznitzer, a pediatric neurologist and autism specialist at the Rainbow and Babies Childrens Hospital in Cleveland, Ohio, says this new study is a continuation of previous work in babies. He says this research makes sense to him. "There is a decrease in the amount of attention to eyes as an early marker of social behavior (think of it as a primitive level of socialization)." Wiznitzer suggests the failure to establish these early social skills has ramifications later as "social behavior shifts into more sophisticated patterns."',
          'description_ERROR' => 'This description of the styleguide module is too short.',
        ),
        'password' => 
        array (
          'secret_password' => 'asd@f23YAS#DFuu&',
          'secret_password_ERROR' => 'asdf',
        ),
      ),
    ),
    'templates' => 
    array (
      'field' => '
{{#useTable}}
<div class="page-header">
    <p class="lead">{{{section.description}}}</p>
</div>
{{/useTable}}
{{#unless useTable}}
    {{{description}}}
{{/unless}}

<div class="field-examples">
    {{#useTable}}
    <table class="accordion table table-bordered table-striped table-condensed" id="accordion_fields">
        <thead>
            <tr>
                <th>Sugar Field</th><th>Field Name</th><th>Example</th><th>Documentation</th>
            </tr>
        </thead>
    {{/useTable}}

    {{#each tempfields}}

        {{#if ../useTable}}
        <tbody class="accordion-group">
            <tr class="accordion-heading">
                <td>{{this.type}}</td>
                <td>{{this.name}}</td>
                <td>
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_fields" data-target="#collapse_field_{{this.type}}">Example</a>
                </td>
                <td><a href="#Styleguide/field/{{this.type}}">Documentation</a></td>
            </tr>
            <tr>
                <td class="accordion-body collapse" colspan="5">
                    <div class="accordion-inner" id="collapse_field_{{this.type}}" style="height:0px;">
        {{/if}}
                        <div class="row-fluid">
                            <div class="span4">
                                <h2>Base View</h2>
                            </div>
                            <div class="span4">
                                <h2>Record View</h2>
                            </div>
                            <div class="span4">
                                <h2>List View</h2>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12">
                                <h3>Detail</h3>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span4">
                                <div class="base" id="{{this.type}}_detail_base">
                                </div>
                            </div>
                            <div class="span4">
                                <div class="record">
                                    <div class="row-fluid">
                                        <div class="span12 record-cell" data-type="{{this.type}}">
                                            <span class="normal index" data-fieldname="{{this.name}}" id="{{this.type}}_detail_record"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="list-view">
                                    <table class="table table-striped dataTable">
                                        <tbody>
                                            <tr class="single">
                                                <td data-type="{{this.type}}" id="{{this.type}}_detail_list">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span12">
                                <h3>Edit</h3>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span4">
                                <div class="base" id="{{this.type}}_edit_base">
                                </div>
                            </div>
                            <div class="span4">
                                <div class="record">
                                    <div class="row-fluid">
                                        <div class="span12 record-cell" data-type="{{this.type}}" id="{{this.type}}_edit_record">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="list-view">
                                    <table class="table table-striped dataTable">
                                        <tbody>
                                            <tr class="single tr-inline-edit">
                                                <td data-type="{{this.type}}" id="{{this.type}}_edit_list">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span12">
                                <h3>Error</h3>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span4" data-type="{{this.type}}">
                                <div class="base" id="{{this.type}}_error_base">
                                </div>
                            </div>
                            <div class="span4">
                                <div class="record">
                                    <div class="row-fluid">
                                        <div class="span12 record-cell" data-type="{{this.type}}" id="{{this.type}}_error_record">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="list-view">
                                    <table class="table table-striped dataTable">
                                        <tbody>
                                            <tr class="single tr-inline-edit">
                                                <td data-type="{{this.type}}" id="{{this.type}}_error_list">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span12">
                                <h3>Disabled</h3>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span4">
                                <div class="base" id="{{this.type}}_disabled_base">
                                </div>
                            </div>
                            <div class="span4">
                                <div class="record">
                                    <div class="row-fluid">
                                        <div class="span12 record-cell" data-type="{{this.type}}" id="{{this.type}}_disabled_record">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="list-view">
                                    <table class="table table-striped dataTable">
                                        <tbody>
                                            <tr class="single tr-inline-edit">
                                                <td data-type="{{this.type}}" id="{{this.type}}_disabled_list">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
        {{#if ../useTable}}
                    </div>
                </td>
            </tr>
        </tbody>
        {{/if}}
    {{/each}}
    {{#useTable}}
    </table>
    {{/useTable}}
</div>
',
      'email' => '
<div class="page-header">
    <h1>Email Field <small>multi state text input with properties</small></h1>
</div>
<div class="description">
    <p>This is the email field implementation details.</p>
</div>
',
      'date' => '
<div class="page-header">
    <h1>Date Field <small>driven by jQuery datetime picker plugin</small></h1>
</div>
<div class="description">
    <p>See the <a href="#Styleguide/docs/forms.datetime">documentation page</a> for implementation details for the date and datetimecombo fields.</p>
</div>
',
    ),
  ),
  'docs-base-responsive' => 
  array (
    'templates' => 
    array (
      'docs-base-responsive' => '
<section id="responsive-design">
  <div class="page-header">
    <h1>Responsive design <small>Media queries for various devices and resolutions</small></h1>
  </div>
  <!-- Supported devices -->
  <div class="row-fluid">
    <div class="span4">
      <img src="styleguide/content/img/responsive-illustrations.png" alt="Responsive devices">
    </div>
    <div class="span8">
      <h2>Supported devices</h2>
      <p>Supports a handful of media queries to help make your projects more appropriate on different devices and screen resolutions. Here\'s what\'s included:</p>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Label</th>
            <th>Layout width</th>
            <th>Column width</th>
            <th>Gutter width</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Smartphones</td>
            <td>480px and below</td>
            <td class="muted" colspan="2">Fluid columns, no fixed widths</td>
          </tr>
          <tr>
            <td>Portrait tablets</td>
            <td>480px to 768px</td>
            <td class="muted" colspan="2">Fluid columns, no fixed widths</td>
          </tr>
          <tr>
            <td>Landscape tablets</td>
            <td>768px to 980px</td>
            <td>44px</td>
            <td>20px</td>
          </tr>
          <tr>
            <td>Default</td>
            <td>980px and up</td>
            <td>60px</td>
            <td>20px</td>
          </tr>
          <tr>
            <td>Large display</td>
            <td>1210px and up</td>
            <td>70px</td>
            <td>30px</td>
          </tr>
        </tbody>
      </table>

      <h3>What they do</h3>
      <p>Media queries allow for custom CSS based on a number of conditions&mdash;ratios, widths, display type, etc&mdash;but usually focuses around <code>min-width</code> and <code>max-width</code>.</p>
      <ul>
        <li>Modify the width of column in our grid</li>
        <li>Stack elements instead of float wherever necessary</li>
        <li>Resize headings and text to be more appropriate for devices</li>
      </ul>
    </div>
  </div>

</section>
',
    ),
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: \'container-fluid\'
})
',
    ),
  ),
  'create-actions' => 
  array (
    'controller' => 
    array (
      'base' => '/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    extendsFrom: \'CreateActionsView\',
    showHelpText: false,
    showErrorDecoration: false,
    events: {
        \'click a[name=show_help_text]:not(.disabled)\': \'toggleHelpText\',
        \'click a[name=display_error_state]:not(.disabled)\': \'toggleErrorDecoration\'
    },

    _render: function() {
        this._super(\'_render\');
        var error_string = \'You did a bad, bad thing.\';
        if (this.showErrorDecoration) {
            _.each(this.fields, function(field) {
                if (!_.contains([\'button\',\'rowaction\',\'actiondropdown\'], field.type)) {
                    field.setMode(\'edit\');
                    field._errors = error_string;
                    if (field.type === \'email\') {
                        var errors = {email: [\'primary@example.info\']};
                        field.handleValidationError([errors]);
                    } else {
                        if (_.contains([\'image\',\'picture\',\'avatar\'], field.type)) {
                            field.handleValidationError(error_string);
                        } else {
                            field.decorateError(error_string);
                        }
                    }
                }
            }, this);
        }
    },

    _renderField: function(field) {
        app.view.View.prototype._renderField.call(this, field);
        var error_string = \'You did a bad, bad thing.\';
        if (!this.showHelpText) {
            field.def.help = null;
            field.options.def.help = null;
        }
    },

    toggleHelpText: function() {
        this.showHelpText = !this.showHelpText;
        this.render();
    },

    toggleErrorDecoration: function() {
        this.showErrorDecoration = !this.showErrorDecoration;
        this.render();
    }
})
',
    ),
    'meta' => 
    array (
      'template' => 'record',
      'buttons' => 
      array (
        0 => 
        array (
          'name' => 'cancel_button',
          'type' => 'button',
          'label' => 'LBL_CANCEL_BUTTON_LABEL',
          'css_class' => 'btn-invisible btn-link',
          'events' => 
          array (
            'click' => 'button:cancel_button:click',
          ),
        ),
        1 => 
        array (
          'type' => 'actiondropdown',
          'name' => 'main_dropdown',
          'primary' => true,
          'switch_on_click' => true,
          'showOn' => 'create',
          'buttons' => 
          array (
            0 => 
            array (
              'type' => 'rowaction',
              'name' => 'save_button',
              'label' => 'LBL_SAVE_BUTTON_LABEL',
              'events' => 
              array (
                'click' => 'button:save_button:click',
              ),
            ),
            1 => 
            array (
              'type' => 'rowaction',
              'name' => 'save_view_button',
              'label' => 'LBL_SAVE_AND_VIEW',
              'events' => 
              array (
                'click' => 'button:save_view_button:click',
              ),
            ),
            2 => 
            array (
              'type' => 'rowaction',
              'name' => 'save_create_button',
              'label' => 'LBL_SAVE_AND_CREATE_ANOTHER',
              'events' => 
              array (
                'click' => 'button:save_create_button:click',
              ),
            ),
            3 => 
            array (
              'type' => 'rowaction',
              'name' => 'show_help_text',
              'label' => 'Toggle help text',
            ),
            4 => 
            array (
              'type' => 'rowaction',
              'name' => 'display_error_state',
              'label' => 'Toggle error state',
            ),
          ),
        ),
        2 => 
        array (
          'type' => 'actiondropdown',
          'name' => 'duplicate_dropdown',
          'primary' => true,
          'showOn' => 'duplicate',
          'buttons' => 
          array (
            0 => 
            array (
              'type' => 'rowaction',
              'name' => 'save_button',
              'label' => 'LBL_IGNORE_DUPLICATE_AND_SAVE',
              'events' => 
              array (
                'click' => 'button:save_button:click',
              ),
            ),
          ),
        ),
        3 => 
        array (
          'type' => 'actiondropdown',
          'name' => 'select_dropdown',
          'primary' => true,
          'showOn' => 'select',
          'buttons' => 
          array (
            0 => 
            array (
              'type' => 'rowaction',
              'name' => 'save_button',
              'label' => 'LBL_SAVE_BUTTON_LABEL',
              'events' => 
              array (
                'click' => 'button:save_button:click',
              ),
            ),
          ),
        ),
        4 => 
        array (
          'name' => 'sidebar_toggle',
          'type' => 'sidebartoggle',
        ),
      ),
    ),
  ),
  'recordlist' => 
  array (
    'meta' => 
    array (
      'selection' => 
      array (
        'type' => 'multi',
        'actions' => 
        array (
          0 => 
          array (
            'name' => 'mass_email_button',
            'type' => 'mass-email-button',
            'label' => 'LBL_EMAIL_COMPOSE',
            'primary' => true,
            'events' => 
            array (
              'click' => 'list:massaction:hide',
            ),
            'acl_module' => 'Emails',
            'acl_action' => 'edit',
            'related_fields' => 
            array (
              0 => 'name',
              1 => 'email',
            ),
          ),
          1 => 
          array (
            'name' => 'edit_button',
            'type' => 'button',
            'label' => 'LBL_MASS_UPDATE',
            'primary' => true,
            'events' => 
            array (
              'click' => 'list:massupdate:fire',
            ),
            'acl_action' => 'massupdate',
          ),
          2 => 
          array (
            'name' => 'calc_field_button',
            'type' => 'button',
            'label' => 'LBL_UPDATE_CALC_FIELDS',
            'events' => 
            array (
              'click' => 'list:updatecalcfields:fire',
            ),
            'acl_action' => 'massupdate',
          ),
          3 => 
          array (
            'name' => 'merge_button',
            'type' => 'button',
            'label' => 'LBL_MERGE',
            'primary' => true,
            'events' => 
            array (
              'click' => 'list:mergeduplicates:fire',
            ),
            'acl_action' => 'edit',
          ),
          4 => 
          array (
            'name' => 'delete_button',
            'type' => 'button',
            'label' => 'LBL_DELETE',
            'acl_action' => 'delete',
            'primary' => true,
            'events' => 
            array (
              'click' => 'list:massdelete:fire',
            ),
          ),
          5 => 
          array (
            'name' => 'export_button',
            'type' => 'button',
            'label' => 'LBL_EXPORT',
            'acl_action' => 'export',
            'primary' => true,
            'events' => 
            array (
              'click' => 'list:massexport:fire',
            ),
          ),
        ),
      ),
    ),
  ),
  'twitter' => 
  array (
    'meta' => 
    array (
      'dashlets' => 
      array (
        0 => 
        array (
          'name' => 'LBL_TWITTER_NAME',
          'description' => 'LBL_TWITTER_DESCRIPTION',
          'config' => 
          array (
            'limit' => '20',
          ),
          'preview' => 
          array (
            'title' => 'LBL_TWITTER_MY_ACCOUNT',
            'twitter' => 'sugarcrm',
            'limit' => '3',
          ),
        ),
      ),
      'config' => 
      array (
        'fields' => 
        array (
          0 => 
          array (
            'name' => 'limit',
            'label' => 'LBL_TWITTER_DISPLAY_ROWS',
            'type' => 'enum',
            'options' => 
            array (
              5 => 5,
              10 => 10,
              15 => 15,
              20 => 20,
              50 => 50,
            ),
          ),
        ),
      ),
    ),
  ),
  'subpanel-list' => 
  array (
    'meta' => 
    array (
      'panels' => 
      array (
        0 => 
        array (
          'name' => 'panel_header',
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'full_name',
              'type' => 'fullname',
              'fields' => 
              array (
                0 => 'salutation',
                1 => 'first_name',
                2 => 'last_name',
              ),
              'link' => true,
              'css_class' => 'full-name',
              'label' => 'LBL_LIST_NAME',
              'enabled' => true,
              'default' => true,
            ),
            1 => 
            array (
              'name' => 'email',
              'label' => 'LBL_LIST_EMAIL',
              'enabled' => true,
              'default' => true,
              'sortable' => false,
            ),
            2 => 
            array (
              'name' => 'phone_work',
              'label' => 'LBL_LIST_PHONE',
              'enabled' => true,
              'default' => true,
            ),
          ),
        ),
      ),
    ),
  ),
  'selection-list' => 
  array (
    'meta' => 
    array (
      'panels' => 
      array (
        0 => 
        array (
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'name',
              'label' => 'LBL_NAME',
              'default' => true,
              'enabled' => true,
              'link' => true,
            ),
            1 => 
            array (
              'name' => 'team_name',
              'label' => 'LBL_TEAM',
              'default' => true,
              'enabled' => true,
            ),
            2 => 
            array (
              'name' => 'assigned_user_name',
              'label' => 'LBL_ASSIGNED_TO_NAME',
              'default' => true,
              'enabled' => true,
              'link' => true,
            ),
            3 => 
            array (
              'label' => 'LBL_DATE_MODIFIED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_modified',
              'readonly' => true,
            ),
          ),
        ),
      ),
      'orderBy' => 
      array (
        'field' => 'date_modified',
        'direction' => 'desc',
      ),
    ),
  ),
  'dupecheck-list' => 
  array (
    'meta' => 
    array (
      'panels' => 
      array (
        0 => 
        array (
          'label' => 'LBL_PANEL_1',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'name',
              'label' => 'LBL_NAME',
              'default' => true,
              'enabled' => true,
              'link' => true,
            ),
            1 => 
            array (
              'name' => 'team_name',
              'label' => 'LBL_TEAM',
              'default' => true,
              'enabled' => true,
            ),
            2 => 
            array (
              'name' => 'assigned_user_name',
              'label' => 'LBL_ASSIGNED_TO_NAME',
              'default' => true,
              'enabled' => true,
              'link' => true,
            ),
            3 => 
            array (
              'label' => 'LBL_DATE_MODIFIED',
              'enabled' => true,
              'default' => true,
              'name' => 'date_modified',
              'readonly' => true,
            ),
          ),
        ),
      ),
    ),
  ),
  'massupdate' => 
  array (
    'meta' => 
    array (
      'buttons' => 
      array (
        0 => 
        array (
          'type' => 'button',
          'value' => 'cancel',
          'css_class' => 'btn-link btn-invisible cancel_button',
          'label' => 'LBL_CANCEL_BUTTON_LABEL',
          'primary' => false,
        ),
        1 => 
        array (
          'name' => 'update_button',
          'type' => 'button',
          'label' => 'LBL_UPDATE',
          'acl_action' => 'massupdate',
          'css_class' => 'btn-primary',
          'primary' => true,
        ),
      ),
      'panels' => 
      array (
        0 => 
        array (
          'fields' => 
          array (
          ),
        ),
      ),
    ),
  ),
  '_hash' => '7bbe6965dabc0ffe5952e693c49a80ab',
);

