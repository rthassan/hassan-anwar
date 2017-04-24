/*--------------------------------------------------------------
# Normalize
--------------------------------------------------------------*/
img,legend{border:0}legend,td,th{padding:0}html{font-family:sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}body{margin:0}article,aside,details,figcaption,figure,footer,header,main,menu,nav,section,summary{display:block}audio,canvas,progress,video{display:inline-block;vertical-align:baseline}audio:not([controls]){display:none;height:0}[hidden],template{display:none}a{background-color:transparent}a:active,a:hover{outline:0}abbr[title]{border-bottom:1px dotted}b,optgroup,strong{font-weight:700}dfn{font-style:italic}h1{font-size:2em;margin:.67em 0}mark{background:#ff0;color:#000}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sup{top:-.5em}sub{bottom:-.25em}svg:not(:root){overflow:hidden}figure{margin:1em 40px}hr{box-sizing:content-box;height:0}pre,textarea{overflow:auto}code,kbd,pre,samp{font-family:monospace,monospace;font-size:1em}button,input,optgroup,select,textarea{color:inherit;font:inherit;margin:0}button{overflow:visible}button,select{text-transform:none}button,html input[type=button],input[type=reset],input[type=submit]{-webkit-appearance:button;cursor:pointer}button[disabled],html input[disabled]{cursor:default}button::-moz-focus-inner,input::-moz-focus-inner{border:0;padding:0}input{line-height:normal}input[type=checkbox],input[type=radio]{box-sizing:border-box;padding:0}input[type=number]::-webkit-inner-spin-button,input[type=number]::-webkit-outer-spin-button{height:auto}input[type=search]::-webkit-search-cancel-button,input[type=search]::-webkit-search-decoration{-webkit-appearance:none}fieldset{border:1px solid silver;margin:0 2px;padding:.35em .625em .75em}table{border-collapse:collapse;border-spacing:0}

/*--------------------------------------------------------------
# Variables
--------------------------------------------------------------*/
:root {
  --blue: rgb(79,198,224);
  --navy: rgb(46,67,105);
  --white: #ffffff;
  --grey-light: rgb(239,241,240);
  --grey: rgb(97,100,108);
  --black: rgb(7,9,12);
  --green: rgb(98,199,74);
  --yellow: rgb(255,220,40);
  --font-family: 'Libre Franklin', Helvetica, sans-serif;
  --content-width: 960px;
}

/*--------------------------------------------------------------
# Salesforce Community Application Additions -- START
--------------------------------------------------------------*/
.noSidebarCell, .sidebarCell .fixed {
    padding: none;
}
.bodyDiv {
    border-top: none;
}
.helpOrb {
    background-image: url(/img/help/helpOrbs.gif) !important;
    width: 20px !important;
    height: 15px !important;
    right: -18px !important;
}                              
.slds-scope img {
    max-width: 100%;
    height: auto;
}
.apexp .bPageBlock.apexDefaultPageBlock .pbBody .pbSubheader {
    background-color: #DDE4E9!important;
}
.slds-scope .slds-form-element__label {
    font-weight: bold;
    <!--font-size: .8125rem;-->
}
.slds-scope h3 {
    display: inline !important;
}
body .bPageTitle .ptBody h1.noSecondHeader {
    font-size: 2em !important;
    color: rgb(97,100,108);
}
body .bPageBlock .pbTitle h2, body {
    color: rgb(97,100,108);
    font-size: 1.5em !important;
    font-weight:bold;
}
.slds-scope h1, .slds-scope h2, .slds-scope h4, .slds-scope h5, .slds-scope h6 {
    font-weight: inherit;
    font-size: 1.3em !important;
}
        
.slds-scope h2 {
    color: #000;   
}
h3 {
	font: 700 normal 1.25em/1.25 var(--font-family);
	color: var(--navy);
	margin: 0 0 0.5em;
}
.application-tabs a h1 {
    padding-top:14px !important;
    padding-bottom:14px !important;
    padding-left:12px !important;
    padding-right:12px !important;
    font-size:1.3em !important;
}
.application-tabs a:hover {
    text-decoration:none !important;
}
.application-tabs a h1:hover {
    color: var(--navy) !important;
    background:#4fc6e0 !important;
    transition: all 0.25s ease;
}
body, button, input, select, textarea {
    color: rgb(7,9,12);
}  
body, button {
    font: 400 normal 1em/1 'Libre Franklin', Helvetica, sans-serif !important;
}  
.bPageBlock .pbTitle {
    width: 33% !important;
}
        
.bPageHeader {
    display: none;
}
.noSidebarCell, .sidebarCell .fixed {
    padding: 0px !important;
}
html body.sfdcBody {
    padding: 0px !important;
}
.loginError1 {
    color: #C23934;
    margin-bottom: 14px !important;
    font-size: 12px !important;
}
.logoutlink {
    position:absolute !important;
    top:140px !important;
    right:50px !important;
    color: rgb(7,9,12) !important;
    font-weight: 700 !important;
    text-decoration: none !important;
    padding: 2px 12px !important;
}
.helpText {
    text-decoration: none;
    position: absolute;
    display: none;
    opacity: 0;
    width: auto;
    z-index: 12;
    font-size: .8125rem !important;
    background-color: var(--navy) !important;
    padding: 10px 10px !important;
    border: none !important;
    border-radius:5px;
    text-align: left;
    white-space: normal;
    font-weight: normal;
    color: #fff;
}

/*--------------------------------------------------------------
# Salesforce Community Application Additions -- END
--------------------------------------------------------------*/



/*--------------------------------------------------------------
# From original Visualforce Page
--------------------------------------------------------------*/
.info {
    font-size: 18px;
    font-weight: bold;
}
.complete {
	color: var(--blue);
}
.incomplete {
	color: var(--grey);
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
    background-color: var(--blue);
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
	color: var(--black);
	font: 400 normal 1em/1 var(--font-family);
}

h1 {
	font: 100 normal 2.5em/1.1 var(--font-family);
	color: var(--blue);
	letter-spacing: -0.01em;
	margin: 0 0 0.5em;
}
h2 {
	font: 100 normal 2em/1.2 var(--font-family);
	color: var(--blue);
	margin: 0 0 0.5em;
}
h3 {
	font: 700 normal 1.25em/1.25 var(--font-family);
	color: var(--navy);
	margin: 0 0 0.5em;
}
h4 {
	font: 700 normal 1em/1.25 var(--font-family);
	color: var(--blue);
	margin: 0 0 0.25em;
}
h5 {
	font: 700 normal 1em/1 var(--font-family);
	color: var(--navy);
	text-transform: uppercase;
	margin: 0 0 0.25em;
}
h6 {
	font: 700 normal 1em/1 var(--font-family);
	color: var(--black);
	text-transform: uppercase;
	margin: 0 0 0.25em;
}
p, ul, ol {
	font: 400 normal 1em/1.5 var(--font-family);
	color: var(--black);
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
	background: var(--grey-light); 
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
.outer-wrapper {
	margin: 0 auto;
	padding: 25px;
}
.inner-wrapper {
	max-width: 1200px;
	margin: 0 auto;
	padding: 0;
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

/*--------------------------------------------------------------
# Navigation
--------------------------------------------------------------*/
/*--------------------------------------------------------------
## Links
--------------------------------------------------------------*/
a {
	color: var(--blue);
}
a:visited {
}
a:hover,
a:focus,
a:active {
	color: var(--navy);
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
	font-weight: 400;
	text-align: center;
	color: #fff;
	margin: 0 auto;
	padding: 15px 25px;
	text-transform: uppercase;
	text-decoration: none;
	border-radius: 4px;
	background-color: var(--navy);
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
	color: var(--navy);
	background-color: #fff;
}
.btn.navy {
	color: #fff;
	background-color: var(--navy);
}
.btn.blue {
	color: #fff;
	background-color: var(--blue);
}
.btn.yellow {
	color: var(--black);
	background-color: var(--yellow);
}
.btn.transparent {
	color: var(--blue);
	border: 1px solid #aaa;
	background: none;
}
.btn.transparent.white {
	color: #fff;
	border: 1px solid #fff;
	background: none;
}
.btn:hover {
	color: #fff;
	background-color: var(--grey);
}

/*--------------------------------------------------------------
# Page Header
--------------------------------------------------------------*/
.page-header {
	-ms-flex-pack: space-between;
	-webkit-justify-content: space-between;
	justify-content: space-between;
	position: relative;
	width: 100%;
	margin: 0 auto;
	padding: 0;
	text-align: center;
	background-color: #fff;
}
.page-branding {
	padding: 25px;
}
.page-logo {
	width: 300px;
	vertical-align: middle;
}
.header-cta {
	width: 100%;
	padding: 23px 25px;
	background-color: var(--grey-light);
}
.header-cta h3 {
	margin: 0;
	line-height: 20px;
	color: var(--black);
}

.page-title {
	padding: 16px 25px;
	background-color: var(--navy);
}
.page-title-inside-sf {
	padding: 2px;
	background-color: var(--navy);
}
.page-title h1 {
	display: inline-block;
	margin: 0;
	color: #fff;
	font-size: 16px;
	font-weight: 700;
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

/* Refer A Friend */
.header-refer {
	margin: 0;
	padding: 0;
	text-align: left;
	background-color: rgb(255,220,40);
}
.refer-a-friend {
	padding: 25px;
	color: rgb(7,9,12);
}
.refer-a-friend * {
	display: inline-block;
	vertical-align: middle;
}
.refer-a-friend a {
	color: rgb(7,9,12);
	text-decoration: none;
}
.refer-a-friend .icon {
	float: left;
	width: 50px;
	height: 50px;
	margin-right: 15px;
}
.refer-a-friend h3 {
	color: rgb(7,9,12);
	line-height: 1;
}
.refer-a-friend h3 span:first-child {
	font-size: 75%;
	font-weight: 300;
}
.refer-a-friend .fa-angle-right {
	float: right;
}

/*--------------------------------------------------------------
# Tabs
--------------------------------------------------------------*/
.tab-container {
	border: none;
	overflow-y: hidden;
}
.tab-container ul.nav-tabs {
	list-style: none;
	margin: 0;
	padding: 0 25px;
}
.tab-container ul li {
	display: inline-block;
	margin-left: 3px;
	padding: 10px 15px;
	color: #fff;
	font-size: 12px;
	border-radius: 4px 4px 0 0;
	background-color: var(--blue);
	box-shadow: inset 0 -4px 0 rgba(0,0,0,0.1);
	transition: all 0.5s ease;
}
.tab-container ul li:hover {
	cursor: pointer;
	background-color: var(--navy);
}
.tab-container ul li:first-of-type {
	margin-left: 0;
}
.tab-container ul li.active {
	color: var(--black);
	background-color: #fff;
	box-shadow: 0 2px 4px rgba(0,0,0,0.35);
}

/*--------------------------------------------------------------
# Content Panels
--------------------------------------------------------------*/
.panel {
	margin: 0 auto;
	padding: 25px;
	border-radius: 4px;
	background-color: #fff;
	box-shadow: 0 2px 4px rgba(0,0,0,0.35);
}

/*--------------------------------------------------------------
# Forms
--------------------------------------------------------------*/
/* Tables */
table {
	width: 100%;
	margin: 0 auto 25px;
	font-size: 13px;
	font-weight: 400;
	text-align: left;
	border: none;
	border-collapse: collapse;
	border-spacing: 0;
}
table tr th,
table tr td {
	padding: 10px 0;
}
table tr th,
table thead th {
	font-weight: 700;
}
table tr td {
	padding: 10px 0;
}
.row-highlight,
.panel .row-highlight {
	background-color: rgba(79,198,224,0.15);
}

/* Form Elements */
label {
	padding-right: 15px;
}
button,
input[type="button"],
input[type="reset"],
input[type="submit"] {
	font-weight: 700;
	text-align: center;
	color: #fff !important;
	margin: 0 auto;
	padding: 10px 15px !important;
	text-transform: uppercase;
	text-decoration: none;
	border: none;
	border-radius: 4px;
	background: #16325c;
	transition: all 0.5s ease;
}

button:hover,
input[type="button"]:hover,
input[type="reset"]:hover,
input[type="submit"]:hover {
	background-color: var(--blue);
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
input[type="checkbox"],
textarea {
	color: #666;
	border: 1px solid #ccc;
	border-radius: 4px;
	padding: 9px;
	box-shadow: inset 0 2px 3px rgba(0,0,0,0.1);
}
select {
	-moz-appearance: none;
	-webkit-appearance: none;
	appearance: none;
	cursor: pointer;
	margin: 0 auto;
	padding: 10px 40px 10px 15px;
	max-width: 300px;
	color: var(--black);
	line-height: 16px;
	border-radius: 4px;
	border: 1px solid #ccc;
	background-image: url('convertibill-dropdown.png'), linear-gradient(#eee 0, #fff 10%, #fff 90%, #eee 100%);
	background-position: right center;
	background-repeat: no-repeat, no-repeat;
	background-color: #fff;
	box-shadow: 0 1px 1px rgba(0,0,0,0.2);
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
	color: var(--black);
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

.fa-question-circle {
	padding: 0 3px;
	color: var(--blue);
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
	background-image: url('convertibill-marque.png');
	background-repeat: no-repeat;
	background-position: bottom 0 right 100px;
	background-color: #fff;
}
.footer-logo {
	width: 300px;
	height: auto;
	margin: 0 auto 25px;
}

/* Site Info */
.page-info {
	background-color: #fff;
	border-top: 1px solid #ddd;
}
.page-info p {
	width: 100%;
	margin: 0 auto;
	font-size: 12px;
	color: rgb(153,153,153);
	line-height: 1;
}
.page-info a {
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

/* 	800px Breakpoint	*/
@media only screen and (min-width: 800px) {

.page-header {
	background-image: url('better-way-to-finance-your-business.png'), linear-gradient( to top, rgb(239,241,240) 66px, rgb(255,255,255) 66px );
	background-position: right -80px bottom 0, bottom left;
	background-repeat: no-repeat, no-repeat;
	background-size: 270px 180px, 100% 66px;
}
.page-branding {
	order: 2;
	flex: 0 1 auto;
}
.page-logo {
	width: 300px;
}
.header-refer {
	display: flex;
	order: 3;
	flex: 0 1 auto;
	margin: 20px 25px auto 0;
}
.refer-a-friend {
	padding: 12px;
}
.header-cta {
	order: 3;
	text-align: left;
	background-color: transparent;
}
.header-cta br {
	display: none;
}
.header-cta .btn {
	margin: 0 0 0 15px;
}
.panel {
	padding: 50px;
}

}

/* 	900px Breakpoint	*/
@media only screen and (min-width: 900px) {

.site-header {
	background-position: right 240px top 49px, bottom left;
}
.header-cta {
	flex: 1 1 70%;
}

}

/* 	1000px Breakpoint	*/
@media only screen and (min-width: 1000px) {

.page-header {
	background-image: url('better-way-to-finance-your-business.png'), linear-gradient( to top, rgb(239,241,240) 122px, rgb(255,255,255) 122px );
	background-position: right 280px top 0, bottom left;
}
table tr {
	width: 48%;
}
table tr th,
table tr td {
	padding: 10px 0;
}

}
