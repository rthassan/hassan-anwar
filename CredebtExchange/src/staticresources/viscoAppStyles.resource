/*--------------------------------------------------------------
# Normalize
--------------------------------------------------------------*/
html {
	font-family: sans-serif;
	-webkit-text-size-adjust: 100%;
	-ms-text-size-adjust:     100%;
}

body {
	margin: 0;
}

article,
aside,
details,
figcaption,
figure,
footer,
header,
main,
menu,
nav,
section,
summary {
	display: block;
}

audio,
canvas,
progress,
video {
	display: inline-block;
	vertical-align: baseline;
}

audio:not([controls]) {
	display: none;
	height: 0;
}

[hidden],
template {
	display: none;
}

a {
	background-color: transparent;
}

a:active,
a:hover {
	outline: 0;
}

abbr[title] {
	border-bottom: 1px dotted;
}

b,
strong {
	font-weight: bold;
}

dfn {
	font-style: italic;
}

h1 {
	font-size: 2em;
	margin: 0.67em 0;
}

mark {
	background: #ff0;
	color: #000;
}

small {
	font-size: 80%;
}

sub,
sup {
	font-size: 75%;
	line-height: 0;
	position: relative;
	vertical-align: baseline;
}

sup {
	top: -0.5em;
}

sub {
	bottom: -0.25em;
}

img {
	border: 0;
}

svg:not(:root) {
	overflow: hidden;
}

figure {
	margin: 1em 40px;
}

hr {
	box-sizing: content-box;
	height: 0;
}

pre {
	overflow: auto;
}

code,
kbd,
pre,
samp {
	font-family: monospace, monospace;
	font-size: 1em;
}

button,
input,
optgroup,
select,
textarea {
	color: inherit;
	font: inherit;
	margin: 0;
}

button {
	overflow: visible;
}

button,
select {
	text-transform: none;
}

button,
html input[type="button"],
input[type="reset"],
input[type="submit"] {
	-webkit-appearance: button;
	cursor: pointer;
}

button[disabled],
html input[disabled] {
	cursor: default;
}

button::-moz-focus-inner,
input::-moz-focus-inner {
	border: 0;
	padding: 0;
}

input {
	line-height: normal;
}

input[type="checkbox"],
input[type="radio"] {
	box-sizing: border-box;
	padding: 0;
}

input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
	height: auto;
}

input[type="search"]::-webkit-search-cancel-button,
input[type="search"]::-webkit-search-decoration {
	-webkit-appearance: none;
}

fieldset {
	border: 1px solid #c0c0c0;
	margin: 0 2px;
	padding: 0.35em 0.625em 0.75em;
}

legend {
	border: 0;
	padding: 0;
}

textarea {
	overflow: auto;
}

optgroup {
	font-weight: bold;
}

table {
	border-collapse: collapse;
	border-spacing: 0;
}

td,
th {
	padding: 0;
}

/*--------------------------------------------------------------
# From original Visualforce Page
--------------------------------------------------------------*/
.info {
    font-size: 18px;
    font-weight: bold;
}
.complete {
	color: rgb(79,198,224);
}
.incomplete {
	color: rgb(97,100,108);
}

/*--------------------------------------------------------------
# Override Rich styles
--------------------------------------------------------------*/
.rich-tab-bottom-line {
	padding: 0;
	border: none;
}
.rich-tab-bottom-line [id*=rich-tabhdr-cell-] {
	padding: 15px;
}
.rich-tab-bottom-line td {
	padding: 0;
}
.rich-tabhdr-side-border {
    background-image: none;
}
.rich-tabhdr-side-cell {
    border: none;
}
.rich-tab-inactive {
	border: none;
    background-image: none;
    background-color: rgb(79,198,224);
    cursor: default;
}
/*--------------------------------------------------------------
# Clearings
--------------------------------------------------------------*/
.inner-wrapper:before,
.inner-wrapper:after,
.clear:before,
.clear:after {
	content: "";
	display: table;
	table-layout: fixed;
}
.inner-wrapper:after,
.clear:after {
	clear: both;
}

/*--------------------------------------------------------------
# Typography
--------------------------------------------------------------*/
body,
button,
input,
select,
textarea {
	color: rgb(7,9,12);
	font: 400 normal 1em/1 'Libre Franklin', Helvetica, sans-serif;
}

h1 {
	font: 100 normal 2.5em/1.1 'Libre Franklin', Helvetica, sans-serif;
	color: rgb(97,100,108);
	letter-spacing: -0.01em;
	margin: 0 0 0.5em;
}
h2 {
	font: 100 normal 2em/1.2 'Libre Franklin', Helvetica, sans-serif;
	color: rgb(79,198,224);
	margin: 0 0 0.5em;
}
h3 {
	font: 700 normal 1.25em/1.25 'Libre Franklin', Helvetica, sans-serif;
	color: rgb(46,67,105);
	margin: 0 0 0.5em;
}
h4 {
	font: 700 normal 1em/1.25 'Libre Franklin', Helvetica, sans-serif;
	color: rgb(20,39,53);
	margin: 0 0 0.25em;
}
h5 {
	font: 700 normal 1em/1 'Libre Franklin', Helvetica, sans-serif;
	color: rgb(79,198,224);
	text-transform: uppercase;
	margin: 0 0 0.25em;
}
h6 {
	font: 700 normal 1em/1 'Libre Franklin', Helvetica, sans-serif;
	color: rgb(20,39,53);
	text-transform: uppercase;
	margin: 0 0 0.25em;
}
p, ul, ol {
	font: 400 normal 1em/1.5 'Libre Franklin', Helvetica, sans-serif;
	color: rgb(7,9,12);
	margin: 0 0 1em;
}

/*--------------------------------------------------------------
# Elements
--------------------------------------------------------------*/
html {
	box-sizing: border-box;
}

*,
*:before,
*:after { 
	box-sizing: inherit;
}

body {
	background: rgb(239,241,240); 
}
ul,
ol {
	margin: 0 auto 1em;
	padding: 0 0 0 1.25em;
}

/*--------------------------------------------------------------
# Structure
--------------------------------------------------------------*/

/* Global
--------------------------------------------------------------*/
.flex-container {
	display: -ms-flexbox;
	display: -webkit-flex;
	display: flex;
	-ms-flex-direction: row;
	-ms-flex-wrap: wrap;
    -webkit-flex-direction: row;
    -webkit-flex-wrap: wrap;
	flex-flow: row wrap;
	-ms-flex-pack: start;
	-webkit-justify-content: flex-start;
	justify-content: flex-start;
	-ms-flex: 0 0 100%;
	-webkit-flex: 0 0 100%;
	flex: 0 0 100%;
	margin: 0;
	padding: 0;
}

/* Layout
--------------------------------------------------------------*/
[class*=inner-wrapper] {
	max-width: 1200px;
	margin: 0 auto;
	padding: 25px;
}
.row {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0;
}
.col {
	float: left;
	width: 100%;
	margin: 0;
	padding-right: 25px;
}
.col-span-1,
.col-span-2,
.col-span-3,
.col-span-4,
.col-span-5,
.col-span-6,
.col-span-7,
.col-span-8,
.col-span-9,
.col-span-10,
.col-span-11,
.col-span-12 {
    width: 100%;
}
.col.align-right {
    float: right;
}

.clear:after {
	content: "";
	clear: both;
}

/*--------------------------------------------------------------
# Form Globals
--------------------------------------------------------------*/
button,
input[type="button"],
input[type="reset"],
input[type="submit"] {
	font: 700 normal 16px/1 'Libre Franklin', Helvetica, sans-serif;
	text-align: center;
	color: #fff;
	margin: 0 auto;
	padding: 12px 15px;
	text-transform: uppercase;
	text-decoration: none;
	border: none;
	border-radius: 4px;
	background-color: rgb(46,67,105);
	transition: all 0.5s ease;
}

button:hover,
input[type="button"]:hover,
input[type="reset"]:hover,
input[type="submit"]:hover {
	background-color: rgb(79,198,224);
}

button:focus,
input[type="button"]:focus,
input[type="reset"]:focus,
input[type="submit"]:focus,
button:active,
input[type="button"]:active,
input[type="reset"]:active,
input[type="submit"]:active {
}

input[type="text"],
input[type="email"],
input[type="url"],
input[type="password"],
input[type="search"],
input[type="number"],
input[type="tel"],
input[type="range"],
input[type="date"],
input[type="month"],
input[type="week"],
input[type="time"],
input[type="datetime"],
input[type="datetime-local"],
input[type="color"],
textarea {
	color: #666;
	border: 1px solid #ccc;
	border-radius: 4px;
	padding: 9px;
}

select {
	-moz-appearance: none;
	-webkit-appearance: none;
	appearance: none;
	cursor: pointer;
	margin: 0 auto;
	padding: 10px 40px 10px 15px;
	max-width: 300px;
	color: #444;
	line-height: 16px;
	border-radius: 4px;
	border: 1px solid #ddd;
	background: url('viscoDropdown.png') #fff right center no-repeat;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="url"]:focus,
input[type="password"]:focus,
input[type="search"]:focus,
input[type="number"]:focus,
input[type="tel"]:focus,
input[type="range"]:focus,
input[type="date"]:focus,
input[type="month"]:focus,
input[type="week"]:focus,
input[type="time"]:focus,
input[type="datetime"]:focus,
input[type="datetime-local"]:focus,
input[type="color"]:focus,
textarea:focus {
	color: rgb(7,9,12);
}

textarea {
	width: 100%;
	-webkit-appearance: none;
	-webkit-border-radius: 0;
	color: #666;
	padding: 8px;
	border: 1px solid #ddd;
	border-radius: 4px;
}

/*--------------------------------------------------------------
## Tables
--------------------------------------------------------------*/
table {
	width: 100%;
	margin: 0;
	font-size: 13px;
	font-weight: 400;
	text-align: left;
	border: none;
	border-collapse: collapse;
	border-spacing: 0;
}
table tr th,
table tr td {
	padding: 10px;
}
table tr th,
table thead th {
	font-weight: 700;
}
table tr td {
}
.row-highlight,
.panel .row-highlight {
	background-color: rgba(79,198,224,0.15);
}

/*--------------------------------------------------------------
# Navigation
--------------------------------------------------------------*/
/*--------------------------------------------------------------
## Links
--------------------------------------------------------------*/
a {
	color: rgb(79,198,224);
}
a:visited {
}
a:hover,
a:focus,
a:active {
	color: rgb(46,67,105);
}
a:focus,
a:hover,
a:active {
	outline: 0;
}

/* Styled Links */
.btn,
input.btn {
	display: inline-block;
	font: 400 normal 16px/1 'Libre Franklin', Helvetica, sans-serif;
	text-align: center;
	color: #fff;
	margin: 0 auto;
	padding: 12px 15px;
	text-transform: uppercase;
	text-decoration: none;
	border-radius: 4px;
	background-color: rgb(46,67,105);
	transition: all 0.5s ease;
}
.more::after {
	font-family: FontAwesome;
	content: "\f105";
	margin-left: 8px;
	color: inherit;
	opacity: 0.5;
}
.less::before {
	font-family: FontAwesome;
	content: "\f104";
	margin-right: 8px;
	color: inherit;
	opacity: 0.5;
}
.btn .fa {
	margin-left: 8px;
	opacity: 0.5;
}
.btn.small {
	font-size: 75%;
}
.btn.large {
	font-size: 120%;
	padding: 20px 25px;
}
.btn.white {
	color: rgb(46,67,105);
	background-color: #fff;
}
.btn.navy {
	color: #fff;
	background-color: rgb(46,67,105);
}
.btn.blue {
	color: #fff;
	background-color: rgb(79,198,224);
}
.btn.yellow {
	color: rgb(7,9,12);
	background-color: rgb(255,220,40);
}
.btn.transparent {
	color: rgb(79,198,224);
	border: 1px solid #aaa;
	background: none;
}
.btn.transparent.white {
	color: #fff;
	border: 1px solid #fff;
	background: none;
}
.btn:hover {
	opacity: 0.85;
}

/*--------------------------------------------------------------
# Page Header
--------------------------------------------------------------*/
.page-header {
	margin: 0;
	padding: 0;
	background-color: #fff;
}
.site-logo {
	width: 300px;
	height: auto;
}
.page-header .col:nth-child(2) span {
	float: right;
}
address p {
	text-align: left;
	font-size: 13px;
	line-height: 1.25;
}
.page-title {
	background-color: rgb(46,67,105);
}
.page-title h1 {
	display: inline-block;
	margin: 0 25px 0 0;
	color: #fff;
}
.page-title .btn {
	float: right;
}
.subpage-title {
	background-color: #fff;
	border-bottom: 1px solid #ccc;
}
.subpage-title h1 {
	display: inline-block;
	margin: 0 25px 0 0;
}

/*--------------------------------------------------------------
# Tabs
--------------------------------------------------------------*/
.form-container {
	padding: 25px;
}
.tab-container {
	border: none;
}
[id*=tab] {
	padding: 0;
}
.panel {
	margin: 0 auto 25px;
	padding: 25px;
	background-color: #fff;
	box-shadow: 0 2px 4px rgba(0,0,0,0.35);
}
.panel table tr th,
.panel table thead th {
	width: 50%;
	background-color: rgb(239,241,240);
}
.panel.note {
	padding-left: 65px;
	background-image: url('viscoNote.png');
	background-repeat: no-repeat;
	background-position: left center;
	background-color: rgba(79,198,224,0.1);
}
.panel.note p {
	margin: 0;
}
.panel.note.col-span-12 {
	max-width: calc(100% - 25px);
	margin-left: 0;
}
.panel.confirmed {
	display: block;
	color: rgb(98,199,74);
	padding-left: 65px;
	background-image: url('viscoConfirmed.png');
	background-repeat: no-repeat;
	background-position: left center;
	background-color: rgba(98,199,74,0.1);
}
.panel.confirmed p {
	margin: 0;
	color: rgb(98,199,74);
	font-size: 125%;
}
.panel.warning {
	border: 3px solid #000;
	text-align: center;
}

/* Facility Overview */

/* Repayment Details */

/* Cost of Funds */
.cost-of-funds th {
	text-align: right;
}

/*--------------------------------------------------------------
# Terms & Conditions (iFrame)
--------------------------------------------------------------*/
.terms-conditions {
	border-bottom: 1px solid #ccc;
}
.terms-image {
	margin-bottom: 25px;
}
.numbered-list {
	margin: 0;
	padding: 0;
	list-style: none;
}
.numbered-list li {
	margin-bottom: 15px;
}

/*--------------------------------------------------------------
# Page Footer
--------------------------------------------------------------*/
.page-footer {
	margin: 0;
	padding: 0;
	background-image: url('viscoMarque.png');
	background-repeat: no-repeat;
	background-position: bottom 60px right 100px;
	background-color: #fff;
}

/* Site Info */
.site-info {
	margin: 0 auto;
	padding: 0;
	background-color: #fff;
	border-top: 1px solid #ddd;
}
.site-info p {
	width: 100%;
	max-width: 1200px;
	margin: 0 auto;
	font-size: 12px;
	color: rgb(153,153,153);
	line-height: 1;
}
.site-info a {
	color: rgb(153,153,153);
}

/*--------------------------------------------------------------
# Media Queries
--------------------------------------------------------------*/

/* 	600px Breakpoint	*/
@media only screen and (min-width: 600px) {

.col-span-1 {
	max-width: 8.33%;
}
.col-span-2 {
    width: 16.66%;
}
.col-span-3 {
    width: 33.33%;
}
.col-span-4 {
    width: 25%;
}
.col-span-6 {
    width: 50%;
}
.col-span-8 {
    width: 66.66%;
}
.col-span-9 {
    width: 75%;
}
.col-span-12 {
    width: 100%;
}

}

/* 	1000px Breakpoint	*/
@media only screen and (min-width: 1000px) {

table tr th,
table tr td {
	padding: 10px 25px;
}
.table-3 {
	float: right;
}

}
