/*
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
///////////////////////////////////////////////
// Class SugarClass
// superclass for all Sugar* sub-classes
//
///////////////////////////////////////////////

function SugarClass() {
    this.init();
}

SugarClass.prototype.init = function() {}

// create inheritance for a class
SugarClass.inherit = function(className,parentClassName) {
  var str = className+".prototype = new "+parentClassName+"();";
  str += className+".prototype.constructor = "+className+";";
  str += className+".superclass = "+parentClassName+".prototype;";

  try {
    eval(str);
  } catch (e) {}
}

//Root class of Sugar JS Application:

SugarClass.inherit("SugarContainer", "SugarClass");

function SugarContainer(root_div) {
    GLOBAL_REGISTRY.container = this;
    this.init(root_div);
}

SugarContainer.prototype.init = function(root_div) {
    this.root_div = root_div;
    SugarContainer.superclass.init.call(this);
}

SugarContainer.prototype.start = function(root_widget) {
      this.root_widget = new root_widget();
      this.root_widget.load(this.root_div);
}

if(typeof(global_request_registry) == "undefined") {
    var global_request_registry = new Object();
}
var req_count = 0;

//////////////////////////////////////////////////
// class: SugarDateTime 
// date and time utilities
//
//////////////////////////////////////////////////

SugarClass.inherit("SugarDateTime","SugarClass");

function SugarDateTime() {
    this.init(root_div);
}

SugarDateTime.prototype.init = function(root_div) {
    this.root_div = root_div;
}

// return the javascript Date object
// given the Sugar Meetings date_start/time_start or date_end/time_end
SugarDateTime.mysql2jsDateTime = function(mysql_date, mysql_time) {
    var match = new RegExp(date_reg_format);
    if (((result = match.exec(mysql_date))) == null) {
        return null;
    }

    var match2 = new RegExp(time_reg_format);
    
    if ((result2 = match2.exec(mysql_time)) == null) {
        result2 = [0,0,0,0];
    }

    var match3 = /^0(\d)/;

    if ((result3 = match3.exec(result2[1])) != null) {
        result2[1] = result3[1];
    }

    if (typeof (result2[3]) != 'undefined') {
        if (result2[3] == 'pm' || result2[3] == 'PM') {
            if (parseInt(result2[1]) != 12) {
                result2[1] = parseInt(result2[1]) + 12;
            }
        }
        else if (result2[1] == 12) {
            result2[1] = 0;
        }
    }

    return new Date(result[date_reg_positions['Y']], result[date_reg_positions['m']] - 1, result[date_reg_positions['d']], result2[1], result2[2], 0, 0);
}
// make it a static func

// return the formatted day of the week of the date given a date object
SugarDateTime.prototype.getFormattedDate = function(date_obj) {
    var returnDate = '';
    var userDateFormat = GLOBAL_REGISTRY['current_user']['fields']['date_time_format']['date'];
    var dow = GLOBAL_REGISTRY['calendar_strings']['dom_cal_weekdays_long'][date_obj.getDay()];
    var month = date_obj.getMonth() + 1;
    month = GLOBAL_REGISTRY['calendar_strings']['dom_cal_month_long'][month];

    returnDate = dow;

    for (i = 0; i < 5; i++) {
        switch (userDateFormat.charAt(i)) {
            case "Y":
                returnDate += " " + date_obj.getFullYear();
                break;
            case "m":
                returnDate += " " + month;
                break;
            case "d":
                returnDate += " " + date_obj.getDate();
                break;
            default:
            // cn: use locale's date separator? probably not.
            //returnDate += " " + userDateFormat.charAt(i);
        }
    }

    return returnDate;
}

SugarDateTime.getFormattedDate = SugarDateTime.prototype.getFormattedDate;

// return the formatted day of the week of the date given a date object
SugarDateTime.prototype.getFormattedDOW = function(date_obj) {
    var hour = config.strings.mod_strings.Calendar.dow[date_obj.getDay()];
}
SugarDateTime.getFormattedDOW = SugarDateTime.prototype.getFormattedDOW;

// return the formatted hour of the date given a date object
SugarDateTime.getAMPM = function(date_obj) {
    var hour = date_obj.getHour();
    var am_pm = 'AM';
    if (hour > 12) {
        hour -= 12;
        am_pm = 'PM';
    }
    else if (hour == 12) {
        am_pm = 'PM';
    }
    else if (hour == 0) {
        hour = 12;
    }
    return am_pm;
}
SugarDateTime.getFormattedHour = SugarDateTime.prototype.getFormattedHour;

//mod.SugarDateTime.getFormattedDate = publ.getFormattedDate;

// return the javascript Date object given a vCal UTC string
SugarDateTime.prototype.parseUTCDate = function(date_string) {
    var match = /(\d{4})(\d{2})(\d{2})T(\d{2})(\d{2})(\d{2})Z/;
    if (((result = match.exec(date_string))) != null) {
        var new_date = new Date(Date.UTC(result[1], result[2] - 1, result[3], result[4], result[5], parseInt(result[6]) + time_offset));
        return new_date;
    }

}

SugarDateTime.parseUTCDate = SugarDateTime.prototype.parseUTCDate;

SugarDateTime.prototype.parseAdjustedDate = function(date_string, dst_start, dst_end, gmt_offset_secs) {

    var match = /(\d{4})(\d{2})(\d{2})T(\d{2})(\d{2})(\d{2})Z/;
    dst_start_parse = match.exec(dst_start);
    dst_end_parse = match.exec(dst_end);

    if (dst_start_parse == null || dst_end_parse == null) {
        var new_date = new Date(result[1], result[2] - 1, result[3], result[4], result[5], parseInt(result[6]));
        new_date = new Date(new_date.getTime() + gmt_offset_secs * 1000);
    } else {
        dst_start_obj = new Date(dst_start_parse[1], dst_start_parse[2] - 1, dst_start_parse[3], dst_start_parse[4], dst_start_parse[5], parseInt(dst_start_parse[6]));
        dst_end_obj = new Date(dst_end_parse[1], dst_end_parse[2] - 1, dst_end_parse[3], dst_end_parse[4], dst_end_parse[5], parseInt(dst_end_parse[6]));

        if (((result = match.exec(date_string))) != null) {
            var new_date = new Date(result[1], result[2] - 1, result[3], result[4], result[5], parseInt(result[6]));
            var event_ts = new_date.getTime();
            var dst_start_ts = dst_start_obj.getTime();
            var dst_end_ts = dst_end_obj.getTime();

            if (((event_ts >= dst_start_ts || event_ts < dst_end_ts) && dst_start_ts > dst_end_ts)
                    || (event_ts >= dst_start_ts && event_ts < dst_end_ts)) {
                new_date = new Date(new_date.getTime() + 60 * 60 * 1000);
            }

            new_date = new Date(new_date.getTime() + gmt_offset_secs * 1000);

        }
    }
    return new_date;
}

SugarDateTime.parseAdjustedDate = SugarDateTime.prototype.parseAdjustedDate;

// create a hash based on a date
SugarDateTime.prototype.getUTCHash = function(startdate) {
    var month = (startdate.getUTCMonth() < 10) ? "0" + startdate.getUTCMonth() : "" + startdate.getUTCMonth();
    var day = (startdate.getUTCDate() < 10) ? "0" + startdate.getUTCDate() : "" + startdate.getUTCDate();
    var hours = (startdate.getUTCHours() < 10) ? "0" + startdate.getUTCHours() : "" + startdate.getUTCHours();
    var minutes = (startdate.getUTCMinutes() < 10) ? "0" + startdate.getUTCMinutes() : "" + startdate.getUTCMinutes();
    return startdate.getUTCFullYear() + month + day + hours + minutes;
}

SugarDateTime.getUTCHash = SugarDateTime.prototype.getUTCHash;

/* End of File include/javascript/jsclass_base.js */

/*
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



//////////////////////////////////////////////////////////////////
// called on the return of a JSON-RPC async request,
// and calls the display() method on the widget registered
// in the registry at the request_id key returned by the server


//////////////////////////////////////////////////////////////////

/**
 * This is the callback function called from SugarRPCClient.prototype.call_method
 * found below.
 * @param o The response object returned by YUI2's ajax request.
 */
function method_callback (o) {
    var resp = YAHOO.lang.JSON.parse(o.responseText),
        request_id = o.tId,
        result = resp.result;

	if(result == null) {
	    return;
	}
    reqid = global_request_registry[request_id];
	if(typeof (reqid)  != 'undefined') {
	    widget = global_request_registry[request_id][0];
	    method_name = global_request_registry[request_id][1];
	    widget[method_name](result);
	}
}

//////////////////////////////////////////////////
// class: SugarVCalClient
// async retrieval/parsing of vCal freebusy info
//
//////////////////////////////////////////////////

SugarClass.inherit("SugarVCalClient","SugarClass");

function SugarVCalClient() {
	this.init();
}

SugarVCalClient.prototype.init = function() {}

SugarVCalClient.prototype.load = function(user_id, request_id) {
    this.user_id = user_id;

    // Bug 44239: Removed reliance on jsolait
    YAHOO.util.Connect.asyncRequest('GET', './vcal_server.php?type=vfb&source=outlook&user_id=' + user_id, {
        success: function (result) {
            if (typeof GLOBAL_REGISTRY.freebusy == 'undefined') {
                GLOBAL_REGISTRY.freebusy = new Object();
            }
            if (typeof GLOBAL_REGISTRY.freebusy_adjusted == 'undefined') {
                GLOBAL_REGISTRY.freebusy_adjusted = new Object();
            }
            // parse vCal and put it in the registry using the user_id as a key:
            GLOBAL_REGISTRY.freebusy[user_id] = SugarVCalClient.prototype.parseResults(result.responseText, false);
            // parse for current user adjusted vCal
            GLOBAL_REGISTRY.freebusy_adjusted[user_id] = SugarVCalClient.prototype.parseResults(result.responseText, true);
            // now call the display() on the widget registered at request_id:
            global_request_registry[request_id][0].display();
        },
        failure: function(result) { this.success(result); },
        argument: { result: result }
    });
}

// parse vCal freebusy info and return object
SugarVCalClient.prototype.parseResults = function(textResult, adjusted) {
    var match = /FREEBUSY.*?\:([\w]+)\/([\w]+)/g;
    //  datetime = new SugarDateTime();
    var result;
    var timehash = new Object();
    var dst_start;
    var dst_end;

    if (GLOBAL_REGISTRY.current_user.fields.dst_start == null)
        dst_start = '19700101T000000Z';
    else
        dst_start = GLOBAL_REGISTRY.current_user.fields.dst_start.replace(/ /gi, 'T').replace(/:/gi, '').replace(/-/gi, '') + 'Z';

    if (GLOBAL_REGISTRY.current_user.fields.dst_end == null)
        dst_end = '19700101T000000Z';
    else
        dst_end = GLOBAL_REGISTRY.current_user.fields.dst_end.replace(/ /gi, 'T').replace(/:/gi, '').replace(/-/gi, '') + 'Z';

    gmt_offset_secs = GLOBAL_REGISTRY.current_user.fields.gmt_offset * 60;
    // loop thru all FREEBUSY matches
    while (((result = match.exec(textResult))) != null) {
        var startdate;
        var enddate;
        if (adjusted) {// send back adjusted for current_user
            startdate = SugarDateTime.parseAdjustedDate(result[1], dst_start, dst_end, gmt_offset_secs);
            enddate = SugarDateTime.parseAdjustedDate(result[2], dst_start, dst_end, gmt_offset_secs);
        }
        else { // GMT
            startdate = SugarDateTime.parseUTCDate(result[1]);
            enddate = SugarDateTime.parseUTCDate(result[2]);
        }

        var startmins = startdate.getUTCMinutes();

        // pick the start slot based on the minutes
        if (startmins >= 0 && startmins < 15) {
            startdate.setUTCMinutes(0);
        }
        else if (startmins >= 15 && startmins < 30) {
            startdate.setUTCMinutes(15);
        }
        else if (startmins >= 30 && startmins < 45) {
            startdate.setUTCMinutes(30);
        }
        else {
            startdate.setUTCMinutes(45);
        }

        // starting at startdate, create hash of each busy 15 min
        // timeslot and store as a key
		while (startdate.valueOf() < enddate.valueOf()) {
			var hash = SugarDateTime.getUTCHash(startdate);
			if (typeof (timehash[hash]) == 'undefined') {
				timehash[hash] = 0;
			}
			timehash[hash] += 1;
			startdate = new Date(startdate.valueOf() + (15 * 60 * 1000));

		}
    }

    return timehash;
}

SugarVCalClient.parseResults = SugarVCalClient.prototype.parseResults;
//////////////////////////////////////////////////
// class: SugarRPCClient
// wrapper around async JSON-RPC client class
//
//////////////////////////////////////////////////
SugarRPCClient.allowed_methods = ['retrieve','query','save','set_accept_status','get_objects_from_module', 'email', 'get_user_array', 'get_full_list'];

SugarClass.inherit("SugarRPCClient","SugarClass");

function SugarRPCClient() {
	this.init();
}

/*
 * PUT NEW METHODS IN THIS ARRAY:
 */
SugarRPCClient.prototype.allowed_methods = ['retrieve','query','get_objects_from_module'];

SugarRPCClient.prototype.init = function() {
	this._showError= function (e){
		alert("ERROR CONNECTING to: ./index.php?entryPoint=json_server, ERROR:"+e);
	}
	this.serviceURL = './index.php?entryPoint=json_server';
}

/**
 * Note: This method used to depend on JSOlait which is now removed. It has been reworked to use YUI for the aynchronous call
 * and the synchronous call in sugar_3.js.
 * @param method
 * @param args
 * @param synchronous Pass in true if synchronous call is desired
 */
SugarRPCClient.prototype.call_method = function(method, args, synchronous) {
    var result,
        transaction,
        post_data = YAHOO.lang.JSON.stringify({method: method, id: 1, params: [args]});

    synchronous = synchronous || false;

    try {
        if (synchronous) {
            result = http_fetch_sync(this.serviceURL, post_data);
            result = YAHOO.lang.JSON.parse(result.responseText).result;
            return result;
        } else { // asynchronous call
            // note: Unfortunately we don't have a separate error handler and it is built into the method_callback. Maybe a future todo.
            transaction = YAHOO.util.Connect.asyncRequest('POST', this.serviceURL, {success: method_callback, failure: method_callback}, post_data);
            return transaction.tId;
        }
    } catch(e) { // error before calling server
        this._showError(e);
    }
}

var global_rpcClient =  new SugarRPCClient();

/* End of File include/javascript/jsclass_async.js */

/*
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

// $Id: jsclass_scheduler.js 56853 2010-06-08 02:36:54Z clee $
//////////////////////////////////////////////////
// class: SugarWidgetListView
// widget to display a list view
//
//////////////////////////////////////////////////

SugarClass.inherit("SugarWidgetListView","SugarClass");

function SugarWidgetListView() {
	this.init();
}

SugarWidgetListView.prototype.init = function() {

}

SugarWidgetListView.prototype.load = function(parentNode) {
	this.parentNode = parentNode;
	this.display();
}

SugarWidgetListView.prototype.display = function() {

	if(typeof GLOBAL_REGISTRY['result_list'] == 'undefined') {
		this.display_loading();
		return;
	}

	var div = document.getElementById('list_div_win');
	div.style.display = 'block';
	//div.style.height='125px';
	var html = '<table width="100%" cellpadding="0" cellspacing="0" border="0" class="list view">';
	html += '<tr>';
	html += '<th width="2%" nowrap="nowrap">&nbsp;</th>';
	html += '<th width="20%" nowrap="nowrap">'+GLOBAL_REGISTRY['meeting_strings']['LBL_NAME']+'</th>';
	html += '<th width="20%" nowrap="nowrap">'+GLOBAL_REGISTRY['meeting_strings']['LBL_EMAIL']+'</th>';
	html += '<th width="20%" nowrap="nowrap">'+GLOBAL_REGISTRY['meeting_strings']['LBL_PHONE']+'</th>';
    html += '<th width="20%" nowrap="nowrap">'+GLOBAL_REGISTRY['meeting_strings']['LBL_ACCOUNT_NAME']+'</th>';
	html += '<th width="18%" nowrap="nowrap">&nbsp;</th>';
	html += '</tr>';
	//var html = '<table width="100%" cellpadding="0" cellspacing="0">';
	for(var i=0;i<GLOBAL_REGISTRY['result_list'].length;i++) {
		var bean = GLOBAL_REGISTRY['result_list'][i];
		var disabled = false;
		var className='evenListRowS1';

		if(typeof(GLOBAL_REGISTRY.focus.users_arr_hash[ bean.fields.id]) != 'undefined') {
			disabled = true;
		}
		if((i%2) == 0) {
			className='oddListRowS1';
		} else {
			className='evenListRowS1';
		}
		if(typeof (bean.fields.first_name) == 'undefined') {
			bean.fields.first_name = '';
		}
		if(typeof (bean.fields.email1) == 'undefined' || bean.fields.email1 == "") {
			bean.fields.email1 = '&nbsp;';
		}
		if(typeof (bean.fields.phone_work) == 'undefined' || bean.fields.phone_work == "") {
			bean.fields.phone_work = '&nbsp;';
		}
		if (!bean.fields.account_name || typeof (bean.fields.account_name) == 'undefined' || bean.fields.account_name == 'null') {
			bean.fields.account_name = '&nbsp;';
		}
		html += '<tr class="'+className+'">';
		html += '<td><img src="'+GLOBAL_REGISTRY.config['site_url']+'/index.php?entryPoint=getImage&themeName='+SUGAR.themes.theme_name+'&imageName='+bean.module+'s.gif"/></td>';
		html += '<td>'+bean.fields.full_name+'</td>';
		html += '<td>'+bean.fields.email1+'</td>';
		html += '<td>'+bean.fields.phone_work+'</td>';
        html += '<td>'+bean.fields.account_name+'</td>';
		html += '<td align="right">';
		//	hidden = 'hidden';
		hidden = 'visible';
		if(!disabled) {
			//	hidden = 'visible';
		}
		html += '<input type="button" id="invitees_add_'+(i+1)+'" class="button" onclick="this.disabled=true;SugarWidgetSchedulerAttendees.form_add_attendee('+i+');" value="'+GLOBAL_REGISTRY['meeting_strings']['LBL_ADD_BUTTON']+'"/ style="visibility: '+hidden+'"/>';
		html += '</td>';

		html += '</tr>';
	}
	html += '</table>';
	//this.parentNode.innerHTML = html;

	div.innerHTML = html;
}

SugarWidgetListView.prototype.display_loading = function() {

}

//////////////////////////////////////////////////
// class: SugarWidgetSchedulerSearch
// widget to display the meeting scheduler search box
//
//////////////////////////////////////////////////

SugarClass.inherit("SugarWidgetSchedulerSearch","SugarClass");

function SugarWidgetSchedulerSearch() {
	this.init();
}

SugarWidgetSchedulerSearch.prototype.init = function() {
	this.form_id = 'scheduler_search';
	GLOBAL_REGISTRY['widget_element_map'] = new Object();
	GLOBAL_REGISTRY['widget_element_map'][this.form_id] = this;
    GLOBAL_REGISTRY.scheduler_search_obj = this;
}

SugarWidgetSchedulerSearch.prototype.load = function(parentNode) {
	this.parentNode = parentNode;
	this.display();
}

SugarWidgetSchedulerSearch.submit = function(form) {

	SugarWidgetSchedulerSearch.hideCreateForm();

	//construct query obj:
	var conditions	= new Array();

	var queryModules = ["Users","Contacts"
        ,"Leads"
    ];
	if(form.search_first_name.value != '') {
		conditions[conditions.length] = {"name":"first_name","op":"starts_with","value":form.search_first_name.value}
	}
	if(form.search_last_name.value != '') {
		conditions[conditions.length] = {"name":"last_name","op":"starts_with","value":form.search_last_name.value}
	}
	if(form.search_email.value != '') {
		conditions[conditions.length] = {"name":"email1","op":"starts_with","value":form.search_email.value}
	}
	if (form.search_account_name.value != '') {
		conditions[conditions.length] = {"name" : "account_name","op" : "starts_with","value" : form.search_account_name.value}
        var queryModules = [ "Contacts", "Leads" ];
	}

	var query = {"modules":queryModules,"group":"and","field_list":['id','full_name','email1','phone_work','account_name'],"conditions":conditions};
	global_request_registry[req_count] = [this,'display'];
	req_id = global_rpcClient.call_method('query',query);
	global_request_registry[req_id] = [ GLOBAL_REGISTRY['widget_element_map'][form.id],'refresh_list'];
}

SugarWidgetSchedulerSearch.prototype.refresh_list = function(rslt) {

	GLOBAL_REGISTRY['result_list'] = rslt['list'];

	if (rslt['list'].length > 0) {
		this.list_view.display();
		document.getElementById('empty-search-message').style.display = 'none';
	}else{
		document.getElementById('list_div_win').style.display = 'none';
		document.getElementById('empty-search-message').style.display = '';
	}

}

SugarWidgetSchedulerSearch.prototype.display = function() {
	var html ='<div class="schedulerInvitees"><h3>'+GLOBAL_REGISTRY['meeting_strings']['LBL_ADD_INVITEE']+'</h5><table border="0" cellpadding="0" cellspacing="0" width="100%" class="edit view">';
	html +='<tr><td>';
	html += '<form name="schedulerwidget" id="'+this.form_id+'" onsubmit="SugarWidgetSchedulerSearch.submit(this);return false;">';

	html += '<table width="100%" cellpadding="0" cellspacing="0" width="100%" >'
	html += '<tr>';
	//html += '<form id="'+this.form_id+'"><table width="100%"><tbody><tr>';
	html += '<td scope="col" nowrap><label for="search_first_name">'+GLOBAL_REGISTRY['meeting_strings']['LBL_FIRST_NAME']+':</label>&nbsp;&nbsp;<input  name="search_first_name" id="search_first_name" value="" type="text" size="10"></td>';
	html += '<td scope="col" nowrap><label for="search_last_name">'+GLOBAL_REGISTRY['meeting_strings']['LBL_LAST_NAME']+':</label>&nbsp;&nbsp;<input  name="search_last_name" id="search_last_name" value="" type="text" size="10"></td>';
	html += '<td scope="col" nowrap><label for="search_email">'+GLOBAL_REGISTRY['meeting_strings']['LBL_EMAIL']+':</label>&nbsp;&nbsp;<input name="search_email" id="search_email" type="text" value="" size="15"></td>';
	html += '<td scope="col" nowrap><label for="search_account_name">'+GLOBAL_REGISTRY['meeting_strings']['LBL_ACCOUNT_NAME']+':</label>&nbsp;&nbsp;<input  name="search_account_name" id="search_account_name" type="text" value="" size="15"></td>';
	//html += '<td valign="center"><input type="submit" onclick="SugarWidgetSchedulerSearch.submit(this.form);" value="Search" ></td></tr></tbody></table></form>';
	html += '<td valign="center"><input id="invitees_search" type="submit" class="button" value="'+GLOBAL_REGISTRY['meeting_strings']['LBL_SEARCH_BUTTON']+'" ></td></tr>';
	html += '</table>';
	html += '</form>';
	html += '</td></tr></table></div>';

	// append the list_view as the third row of the outside table
	this.parentNode.innerHTML += html;


	var div = document.createElement('div');
	div.setAttribute('id','list_div_win');
	div.style.overflow = 'auto';
	div.style.width = '100%';
	div.style.height= '100%';
	div.style.display = 'none';
    this.parentNode.appendChild(div);


	html = '';
	html += '<div id="create-invitees" style="margin-bottom: 10px;">';
	html += '<div id="empty-search-message" style="display: none;">' + GLOBAL_REGISTRY['meeting_strings']['LBL_EMPTY_SEARCH_RESULT'] + '</div>';
	html += '<h3 id="create-invitees-title">' + GLOBAL_REGISTRY['meeting_strings']['LBL_CREATE_INVITEE'] + '</h3>';
	html += '<div id="create-invitees-buttons">';
	html += '<button type="button" id="create_invitee_as_contact" onclick="SugarWidgetSchedulerSearch.showCreateForm(\'Contacts\');">' + GLOBAL_REGISTRY['meeting_strings']['LBL_CREATE_CONTACT'] + '</button> ';
	html += '<button type="button" id="create_invitee_as_lead" onclick="SugarWidgetSchedulerSearch.showCreateForm(\'Leads\');">' + GLOBAL_REGISTRY['meeting_strings']['LBL_CREATE_LEAD'] + '</button> ';
	html += '</div>';

	html += '<div id="create-invitee-edit" style="display: none;">';
	html += '<form name="createInviteeForm" id="createInviteeForm" onsubmit="SugarWidgetSchedulerSearch.createInvitee(this); return false;">';
	html += '<input type="hidden" name="inviteeModule" value="Contacts">';
	html += '<table class="edit view" cellpadding="0" cellspacing="0" style="width: 330px; margin-top: 2px;">'
	html += '<tr>';
	html += '<td valign="top" width="33%">' + GLOBAL_REGISTRY['meeting_strings']['LBL_FIRST_NAME'] + ': </td><td valign="top"><input name="first_name" type="text" size="19"></td>';
	html += '</tr>';
	html += '<tr>';
	html += '<td valign="top" width="33%">' + GLOBAL_REGISTRY['meeting_strings']['LBL_LAST_NAME'] + ': <span class="required">*</span></td><td valign="top"><input name="last_name" type="text" size="19"></td>';
	html += '</tr>';
	html += '<tr>';
	html += '<td valign="top" width="33%">' + GLOBAL_REGISTRY['meeting_strings']['LBL_EMAIL'] + ': </td><td valign="top"><input name="email1" type="text" size="19"></td>';
	html += '</tr>';
	html += '</table>';
	html += '<button type="button" id="create-invitee-btn" onclick="SugarWidgetSchedulerSearch.createInvitee(this.form);">' + GLOBAL_REGISTRY['meeting_strings']['LBL_CREATE_AND_ADD'] + '</button> ';
	html += '<button type="button" id="cancel-create-invitee-btn" onclick="SugarWidgetSchedulerSearch.hideCreateForm();">' + GLOBAL_REGISTRY['meeting_strings']['LBL_CANCEL_CREATE_INVITEE'] + '</button> ';
	html += '</form>';
	html += '</div>';
	html += '</div>';
	this.parentNode.innerHTML += html;

	addToValidate('createInviteeForm', 'last_name', 'last_name', true, GLOBAL_REGISTRY['meeting_strings']['LBL_LAST_NAME']);

    this.list_view = new SugarWidgetListView();
	this.list_view.load(div);
}

SugarWidgetSchedulerSearch.showCreateForm = function(module){
	document.getElementById('create-invitee-edit').style.display = '';
	document.getElementById('create-invitees-buttons').style.display = 'none';
	document.getElementById('list_div_win').style.display = 'none';
	document.forms['createInviteeForm'].elements['inviteeModule'].value = module;

	document.getElementById('empty-search-message').style.display = 'none';

	if (typeof document.createInviteeForm.first_name != 'undefined' && typeof document.schedulerwidget.search_first_name != 'undefined')
		document.createInviteeForm.first_name.value = document.schedulerwidget.search_first_name.value;
	if (typeof document.createInviteeForm.last_name != 'undefined' && typeof document.schedulerwidget.search_last_name != 'undefined')
		document.createInviteeForm.last_name.value = document.schedulerwidget.search_last_name.value;
	if (typeof document.createInviteeForm.email1 != 'undefined' && typeof document.schedulerwidget.search_email != 'undefined')
		document.createInviteeForm.email1.value = document.schedulerwidget.search_email.value;

}

SugarWidgetSchedulerSearch.hideCreateForm = function(module){
	document.getElementById('create-invitee-edit').style.display = 'none';
	document.getElementById('create-invitees-buttons').style.display = '';

	document.forms['createInviteeForm'].reset();
}

SugarWidgetSchedulerSearch.resetSearchForm = function() {
    if(GLOBAL_REGISTRY.scheduler_search_obj && document.forms[GLOBAL_REGISTRY.scheduler_search_obj.form_id]) {
        //if search form is initiated, it clears the input fields.
        document.forms[GLOBAL_REGISTRY.scheduler_search_obj.form_id].reset();
    }
}

SugarWidgetSchedulerSearch.createInvitee = function(form){
	if(!(check_form('createInviteeForm'))){
		return false;
	}

	document.getElementById('create-invitee-btn').setAttribute('disabled', 'disabled');
	document.getElementById('cancel-create-invitee-btn').setAttribute('disabled', 'disabled');

	ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_SAVING'));

	var callback = {
		success: function (response) {

			var rObj = eval("("+response.responseText+")");

			ajaxStatus.hideStatus();

			if (typeof rObj.noAccess != 'undefined') {
				var alertMsg = GLOBAL_REGISTRY['meeting_strings']['LBL_NO_ACCESS'];
				alertMsg = alertMsg.replace("\$module", rObj.module);
				SugarWidgetSchedulerSearch.hideCreateForm();
				alert(alertMsg);
				return false;
			}

			GLOBAL_REGISTRY.focus.users_arr[GLOBAL_REGISTRY.focus.users_arr.length] = rObj;
			GLOBAL_REGISTRY.scheduler_attendees_obj.display();

			SugarWidgetSchedulerSearch.hideCreateForm();
            //Bug#51357: Reset the search input fields after invitee is added.
            SugarWidgetSchedulerSearch.resetSearchForm();

			document.getElementById('create-invitee-btn').removeAttribute('disabled');
			document.getElementById('cancel-create-invitee-btn').removeAttribute('disabled');
		}
	};

	var fieldList = ['id', 'full_name', 'email1', 'phone_work'];

	var t = [];
	for (i in fieldList) {
		t.push("fieldList[]=" + encodeURIComponent(fieldList[i]));
	}
	var postData = t.join("&");

	var url = "index.php?module=Calendar&action=CreateInvitee&sugar_body_only=true";
	YAHOO.util.Connect.setForm(document.forms['createInviteeForm']);
	YAHOO.util.Connect.asyncRequest('POST', url, callback, postData);

}

//////////////////////////////////////////////////
// class: SugarWidgetScheduler
// widget to display the meeting scheduler
//
//////////////////////////////////////////////////

SugarClass.inherit("SugarWidgetScheduler","SugarClass");

function SugarWidgetScheduler() {
	this.init();
}

SugarWidgetScheduler.prototype.init = function() {
	//var row = new	SugarWidgetScheduleAttendees();
	//row.load(this);
}

SugarWidgetScheduler.prototype.load = function(parentNode) {
	this.parentNode = parentNode;
	this.display();
}

SugarWidgetScheduler.fill_invitees = function(form) {
	for(var i=0;i<GLOBAL_REGISTRY.focus.users_arr.length;i++) {
		if(GLOBAL_REGISTRY.focus.users_arr[i].module == 'User') {
			form.user_invitees.value += GLOBAL_REGISTRY.focus.users_arr[i].fields.id + ",";
		} else if(GLOBAL_REGISTRY.focus.users_arr[i].module == 'Contact') {
			form.contact_invitees.value += GLOBAL_REGISTRY.focus.users_arr[i].fields.id + ",";
		} else if(GLOBAL_REGISTRY.focus.users_arr[i].module == 'Lead') {
			form.lead_invitees.value += GLOBAL_REGISTRY.focus.users_arr[i].fields.id + ",";
		}
	}
}

SugarWidgetScheduler.update_time = function() {

	var form_name;
	if(typeof document.EditView != 'undefined')
		form_name = "EditView";
	else if(typeof document.CalendarEditView != 'undefined')
		form_name = "CalendarEditView";
	else
		return;

   //check for field value, we can't do anything if it doesnt exist.
    if(typeof document.forms[form_name].date_start == 'undefined')
		return;

	var date_start = document.forms[form_name].date_start.value;
	if(date_start.length < 16) {
		return;
	}
	var hour_start = parseInt(date_start.substring(11,13), 10);
	var minute_start = parseInt(date_start.substring(14,16), 10);
	var has_meridiem = /am|pm/i.test(date_start);
	if(has_meridiem) {
	var meridiem = trim(date_start.substring(16));
	}

	GLOBAL_REGISTRY.focus.fields.date_start = date_start;

	if(has_meridiem) {
		GLOBAL_REGISTRY.focus.fields.time_start = hour_start + time_separator + minute_start + meridiem;
	} else {
		GLOBAL_REGISTRY.focus.fields.time_start = hour_start + time_separator + minute_start;
	}

	GLOBAL_REGISTRY.focus.fields.duration_hours = document.forms[form_name].duration_hours.value;
	GLOBAL_REGISTRY.focus.fields.duration_minutes = document.forms[form_name].duration_minutes.value;
	GLOBAL_REGISTRY.focus.fields.datetime_start = SugarDateTime.mysql2jsDateTime(GLOBAL_REGISTRY.focus.fields.date_start,GLOBAL_REGISTRY.focus.fields.time_start);

	GLOBAL_REGISTRY.scheduler_attendees_obj.init();
	GLOBAL_REGISTRY.scheduler_attendees_obj.display();
}

SugarWidgetScheduler.prototype.display = function() {
    this.parentNode.innerHTML = '';

	var attendees = new SugarWidgetSchedulerAttendees();
	attendees.load(this.parentNode);

	var search = new SugarWidgetSchedulerSearch();
	search.load(this.parentNode);
}


//////////////////////////////////////////////////
// class: SugarWidgetSchedulerAttendees
// widget to display the meeting attendees and availability
//
//////////////////////////////////////////////////

SugarClass.inherit("SugarWidgetSchedulerAttendees","SugarClass");

function SugarWidgetSchedulerAttendees() {
	this.init();
}

SugarWidgetSchedulerAttendees.prototype.init = function() {

	var form_name;
	if(typeof document.EditView != 'undefined')
		form_name = "EditView";
	else if(typeof document.CalendarEditView != 'undefined')
		form_name = "CalendarEditView";
	else
		return;

	// this.datetime = new SugarDateTime();
	GLOBAL_REGISTRY.scheduler_attendees_obj = this;
	var date_start = document.forms[form_name].date_start.value;
	var hour_start = parseInt(date_start.substring(11,13), 10);
	var minute_start = parseInt(date_start.substring(14,16), 10);
	var has_meridiem = /am|pm/i.test(date_start);
	if(has_meridiem) {
	var meridiem = trim(date_start.substring(16));
	}

	if(has_meridiem) {
		GLOBAL_REGISTRY.focus.fields.time_start = hour_start + time_separator + minute_start + meridiem;
	} else {
		GLOBAL_REGISTRY.focus.fields.time_start = hour_start+time_separator+minute_start;
		//GLOBAL_REGISTRY.focus.fields.time_start = document.forms[form_name].time_hour_start.value+time_separator+minute_start;
	}

	GLOBAL_REGISTRY.focus.fields.date_start = document.forms[form_name].date_start.value;
	GLOBAL_REGISTRY.focus.fields.duration_hours = document.forms[form_name].duration_hours.value;
	GLOBAL_REGISTRY.focus.fields.duration_minutes = document.forms[form_name].duration_minutes.value;
	GLOBAL_REGISTRY.focus.fields.datetime_start = SugarDateTime.mysql2jsDateTime(GLOBAL_REGISTRY.focus.fields.date_start,GLOBAL_REGISTRY.focus.fields.time_start);

	this.timeslots = new Array();
	this.hours = 9;
	this.segments = 4;
	this.start_hours_before = 4;

	var minute_interval = 15;
	var dtstart = GLOBAL_REGISTRY.focus.fields.datetime_start;

	// initialize first date in timeslots
	var curdate = new Date(dtstart.getFullYear(),dtstart.getMonth(),dtstart.getDate(),dtstart.getHours()-this.start_hours_before,0);

	if(typeof(GLOBAL_REGISTRY.focus.fields.duration_minutes) == 'undefined') {
		GLOBAL_REGISTRY.focus.fields.duration_minutes = 0;
	}
	GLOBAL_REGISTRY.focus.fields.datetime_end = new Date(dtstart.getFullYear(),dtstart.getMonth(),dtstart.getDate(),dtstart.getHours()+parseInt(GLOBAL_REGISTRY.focus.fields.duration_hours),dtstart.getMinutes()+parseInt(GLOBAL_REGISTRY.focus.fields.duration_minutes),0);

	var has_start = false;
	var has_end = false;

	for(i=0;i < this.hours*this.segments; i++) {
		var hash = SugarDateTime.getUTCHash(curdate);
		var obj = {"hash":hash,"date_obj":curdate};
		if(has_start == false && GLOBAL_REGISTRY.focus.fields.datetime_start.getTime() <= curdate.getTime()) {
			obj.is_start = true;
			has_start = true;
		}
		if(has_end == false && GLOBAL_REGISTRY.focus.fields.datetime_end.getTime() <= curdate.getTime()) {
			obj.is_end = true;
			has_end = true;
		}
		this.timeslots.push(obj);

		curdate = new Date(curdate.getFullYear(),curdate.getMonth(),curdate.getDate(),curdate.getHours(),curdate.getMinutes()+minute_interval);
	}
    //Bug#51357: Reset the search input fields after attandee popup is initiated.
    SugarWidgetSchedulerSearch.resetSearchForm();
}

SugarWidgetSchedulerAttendees.prototype.load = function (parentNode) {
	this.parentNode = parentNode;
	this.display();
}

SugarWidgetSchedulerAttendees.prototype.display = function() {

	var form_name;
	if(typeof document.EditView != 'undefined')
		form_name = "EditView";
	else if(typeof document.CalendarEditView != 'undefined')
		form_name = "CalendarEditView";
	else
		return;

	var dtstart = GLOBAL_REGISTRY.focus.fields.datetime_start;
	var top_date = SugarDateTime.getFormattedDate(dtstart);
	var html = '<h3>'+GLOBAL_REGISTRY['meeting_strings']['LBL_SCHEDULING_FORM_TITLE']+'</h3><table id ="schedulerTable">';
	html += '<tr class="schedulerTopRow">';
	html += '<th colspan="'+((this.hours*this.segments)+2)+'"><h4>'+ top_date +'</h4></th>';
	html += '</tr>';
	html += '<tr class="schedulerTimeRow">';
	html += '<td>&nbsp;</td>';

	for(var i=0;i < (this.timeslots.length/this.segments); i++) {
		var hours = this.timeslots[i*this.segments].date_obj.getHours();
		var am_pm = '';

		if(time_reg_format.indexOf('A') >= 0 || time_reg_format.indexOf('a') >= 0) {
			am_pm = "AM";

			if(hours > 12) {
				am_pm = "PM";
				hours -= 12;
			}
			if(hours == 12) {
				am_pm = "PM";
			}
			if(hours == 0) {
				hours = 12;
				am_pm = "AM";
			}
			if(time_reg_format.indexOf('a') >= 0) {
				am_pm = am_pm.toLowerCase();
			}
			if(hours != 0 && hours != 12 && i != 0) {
				am_pm = "";
			}

		}

		var form_hours = hours+time_separator+"00";
		html += '<th scope="col" colspan="'+this.segments+'">'+form_hours+am_pm+'</th>';
	}

	html += '<td>&nbsp;</td>';
	html += '</tr>';
	html += '</table>';
    if ( this.parentNode.childNodes.length < 1 )
        this.parentNode.innerHTML += '<div class="schedulerDiv">' + html + '</div>';
    else
        this.parentNode.childNodes[0].innerHTML = html;

	var thetable = "schedulerTable";

	if(typeof (GLOBAL_REGISTRY) == 'undefined') {
		return;
	}

	//set the current user (as event-coordinator) so that they can be added to invitee list
	//only IF the first removed flag has not been set AND this is a new record
	if((typeof (GLOBAL_REGISTRY.focus.users_arr) == 'undefined' || GLOBAL_REGISTRY.focus.users_arr.length == 0)
      && document.forms[form_name].record.value =='' && typeof(GLOBAL_REGISTRY.FIRST_REMOVE)=='undefined') {
		GLOBAL_REGISTRY.focus.users_arr = [ GLOBAL_REGISTRY.current_user ];
	}

	if(typeof GLOBAL_REGISTRY.focus.users_arr_hash == 'undefined') {
		GLOBAL_REGISTRY.focus.users_arr_hash = new Object();
	}

	// append attendee rows
	for(var i=0;i < GLOBAL_REGISTRY.focus.users_arr.length;i++) {
		var row = new SugarWidgetScheduleRow(this.timeslots);
		row.focus_bean = GLOBAL_REGISTRY.focus.users_arr[i];
		GLOBAL_REGISTRY.focus.users_arr_hash[ GLOBAL_REGISTRY.focus.users_arr[i]['fields']['id']] =	GLOBAL_REGISTRY.focus.users_arr[i];
		row.load(thetable);
	}
}

SugarWidgetSchedulerAttendees.form_add_attendee = function (list_row) {
	if(typeof (GLOBAL_REGISTRY.result_list[list_row]) != 'undefined' && typeof(GLOBAL_REGISTRY.focus.users_arr_hash[ GLOBAL_REGISTRY.result_list[list_row].fields.id]) == 'undefined') {
		GLOBAL_REGISTRY.focus.users_arr[ GLOBAL_REGISTRY.focus.users_arr.length ] = GLOBAL_REGISTRY.result_list[list_row];
	}
	GLOBAL_REGISTRY.scheduler_attendees_obj.display();
}


//////////////////////////////////////////////////
// class: SugarWidgetScheduleRow
// widget to display each row in the scheduler
//
//////////////////////////////////////////////////
SugarClass.inherit("SugarWidgetScheduleRow","SugarClass");

function SugarWidgetScheduleRow(timeslots) {
	this.init(timeslots);
}

SugarWidgetScheduleRow.prototype.init = function(timeslots) {
	this.timeslots = timeslots;
}

SugarWidgetScheduleRow.prototype.load = function (thetableid) {
	this.thetableid = thetableid;
	var self = this;

	vcalClient = new SugarVCalClient();
	if (this.focus_bean.module === 'User' && (typeof (GLOBAL_REGISTRY['freebusy_adjusted']) == 'undefined' || typeof (GLOBAL_REGISTRY['freebusy_adjusted'][this.focus_bean.fields.id]) == 'undefined')) {
		global_request_registry[req_count] = [this,'display'];
		vcalClient.load(this.focus_bean.fields.id,req_count);
		req_count++;
	} else {
		this.display();
	}
}

SugarWidgetScheduleRow.prototype.display = function() {
	SUGAR.util.doWhen("document.getElementById('" + this.thetableid + "') != null", function(){
        var tr;
        this.thetable = document.getElementById(this.thetableid);

        if(typeof (this.element) != 'undefined') {
            if (this.element.parentNode != null)
                this.thetable.deleteRow(this.element.rowIndex);

            tr = document.createElement('tr');
            this.thetable.appendChild(tr);
        } else {
            tr = this.thetable.insertRow(this.thetable.rows.length);
        }
        tr.className = "schedulerAttendeeRow";

        td = document.createElement('td');
        tr.appendChild(td);
        //insertCell(tr.cells.length);

        // icon + full name
        td.scope = 'row';
        var img = '<img align="absmiddle" src="index.php?entryPoint=getImage&themeName='
                + SUGAR.themes.theme_name+'&imageName='+this.focus_bean.module+'s.gif"/>&nbsp;';
        td.innerHTML = img;

        td.innerHTML = td.innerHTML;

        if (this.focus_bean.fields.full_name)
            td.innerHTML += ' ' + this.focus_bean.fields.full_name;
        else
            td.innerHTML += ' ' + this.focus_bean.fields.name;

        // add freebusy tds here:
        this.add_freebusy_nodes(tr);

        // delete button
        var td = document.createElement('td');
        tr.appendChild(td);
        //var td = tr.insertCell(tr.cells.length);
        td.className = 'schedulerAttendeeDeleteCell';
        td.noWrap = true;
        //CCL - Remove check to disallow removal of assigned user or current user
        //if ( GLOBAL_REGISTRY.focus.fields.assigned_user_id != this.focus_bean.fields.id && GLOBAL_REGISTRY.current_user.fields.id != this.focus_bean.fields.id) {
       td.innerHTML = '<a title="'+ GLOBAL_REGISTRY['meeting_strings']['LBL_REMOVE']
                    + '" class="listViewTdToolsS1" style="text-decoration:none;" '
                    + 'href="javascript:SugarWidgetScheduleRow.deleteRow(\''+this.focus_bean.fields.id+'\');">&nbsp;'
                    + '<img src="index.php?entryPoint=getImage&themeName='+SUGAR.themes.theme_name+'&imageName=delete_inline.gif" '
                    + 'align="absmiddle" alt="'+ GLOBAL_REGISTRY['meeting_strings']['LBL_REMOVE'] +'" border="0"> '
                    + GLOBAL_REGISTRY['meeting_strings']['LBL_REMOVE'] +'</a>';
        //}
        this.element = tr;
        this.element_index = this.thetable.rows.length - 1;
    }, null, this);
}

SugarWidgetScheduleRow.deleteRow = function(bean_id) {
	// can't delete organizer
	/*
	if(GLOBAL_REGISTRY.focus.users_arr.length == 1 || GLOBAL_REGISTRY.focus.fields.assigned_user_id == bean_id) {
		return;
	}
    */
	for(var i=0;i<GLOBAL_REGISTRY.focus.users_arr.length;i++) {
		if(GLOBAL_REGISTRY.focus.users_arr[i]['fields']['id']==bean_id) {
			delete GLOBAL_REGISTRY.focus.users_arr_hash[GLOBAL_REGISTRY.focus.users_arr[i]['fields']['id']];
			GLOBAL_REGISTRY.focus.users_arr.splice(i,1);
	     	//set first remove flag to true for processing in display() function
			GLOBAL_REGISTRY.FIRST_REMOVE = true;
			GLOBAL_REGISTRY.container.root_widget.display();
		}
	}
}


function DL_GetElementLeft(eElement) {
	/*
	 * ifargument is invalid
	 * (not specified, is null or is 0)
	 * and function is a method
	 * identify the element as the method owner
	 */
	if(!eElement && this) {
		eElement = this;
	}

	/*
	 * initialize var to store calculations
	 * identify first offset parent element
	 * move up through element hierarchy
	 * appending left offset of each parent
	 * until no more offset parents exist
	 */
	var nLeftPos = eElement.offsetLeft;
	var eParElement = eElement.offsetParent;
	while (eParElement != null) {
		nLeftPos += eParElement.offsetLeft;
		eParElement = eParElement.offsetParent;
	}
	return nLeftPos; // return the number calculated
}


function DL_GetElementTop(eElement) {
	if(!eElement && this) {
		eElement = this;
	}

	var nTopPos = eElement.offsetTop;
	var eParElement = eElement.offsetParent;
	while (eParElement != null) {
		nTopPos += eParElement.offsetTop;
		eParElement = eParElement.offsetParent;
	}
	return nTopPos;
}


//////////////////////////////////////////
// adds the <td>s for freebusy display within a row
SugarWidgetScheduleRow.prototype.add_freebusy_nodes = function(tr,attendee) {
	var hours = 9;
	var segments = 4;
	var html = '';
	var is_loaded = false;

	if(typeof GLOBAL_REGISTRY['freebusy_adjusted'] != 'undefined' && typeof GLOBAL_REGISTRY['freebusy_adjusted'][this.focus_bean.fields.id] != 'undefined') {
		is_loaded = true;
	}

	for(var i=0;i < this.timeslots.length; i++) {
		var td = document.createElement('td');
		tr.appendChild(td);
		//var td = tr.insertCell(tr.cells.length);
        td.innerHTML = '&nbsp;';
		if(typeof(this.timeslots[i]['is_start']) != 'undefined') {
			td.className = 'schedulerSlotCellStartTime';
		}
		if(typeof(this.timeslots[i]['is_end']) != 'undefined') {
			td.className = 'schedulerSlotCellEndTime';
		}

		if(is_loaded) {
			// iftheres a freebusy stack in this slice
			if(	typeof(GLOBAL_REGISTRY['freebusy_adjusted'][this.focus_bean.fields.id][this.timeslots[i].hash]) != 'undefined') {
				td.style.backgroundColor="#4D5EAA";

				if(	GLOBAL_REGISTRY['freebusy_adjusted'][this.focus_bean.fields.id][this.timeslots[i].hash] > 1) {
					td.style.backgroundColor="#AA4D4D";
				}
			}
		}
	}
}

/* End of File modules/Meetings/jsclass_scheduler.js */

