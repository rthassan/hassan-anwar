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

if(typeof(SUGAR.collection) == "undefined") {
    SUGAR.collection = function(form_name, field_name, module, popupData){

    	/*
         * boolean variable to handle expand/collapse views
         * false if the collection field is collapsed and true if the rows are expanded.
         */
        this.more_status = false;
        
        /*
         * Store the form name containing this field.  Example: EditView
         */
        this.form = form_name;
        
        /*
         * Store the name of the collection field. Example: account_name 
         */
        this.field = field_name;
        
        
        /*
         * Store the unique form + field name that uses the combination of form and field
         */
        this.field_element_name = this.form + '_' + this.field;
        
        /*
         * Store the name of the module from where come the field. Example: Accounts 
         */
        this.module = module;
        
        /*
         * Number of secondaries linked records (total of linked records - 1). 
         */
        this.fields_count = 0;
        
        /*
         * Number of extra fields. 
         */
        this.extra_fields_count = 0;
        
        /*
         * Set to true if it is the initialization. 
         */
        this.first = true;
        
        /*
         * Name of the primary field. Example: "accounts_collection_0" 
         */
        this.primary_field = "";
        
        /*
         * Store the row cloned in key "0" and the context cloned in key "1". 
         */
        this.cloneField = new Array();
        
        /*
         * Store the sqs_objects for the cloned row encoded in JSON. 
         */
        this.sqs_clone = "";
        
        /*
         * Store the name and the id of all the secondaries linked records. this is used to create the secondary rows. 
         */
        this.secondaries_values = new Array();
        
        /*
         * Store all the extra fields which has been updated in the collection field to save on save of the main record. 
         */
        this.update_fields = new Object();
        
        /*
         * boolean variable indicating whether or not to show the expand/collapse arrow
         */
        this.show_more_image = true;

    };
    
    SUGAR.collection.prototype = {
        /*
         * Remove the row designated by the passed 'id' or clear the row if there is only one row. 
         */
        remove: function(num){
            // if there is only one record, clear it instead of removing it
    	    // this is determined by the visibility of the drop down arrow element
    	    var radio_els = this.get_radios();
            var div_el;
            if(radio_els.length == 1) {
                div_el = document.getElementById(this.field_element_name + '_input_div_' + num);
                var input_els = div_el.getElementsByTagName('input');
                //Clear text field
                input_els[0].value = '';
                
                //Clear hidden field
                input_els[1].value = '';
                
                if(this.primary_field) {
                   div_el = document.getElementById(this.field_element_name + '_radio_div_' + num);
                   radio_els = div_el.getElementsByTagName('input');
                   //Clear the radio field
                   radio_els[0].checked = false;
                }
            } else {	
            	div_el = document.getElementById(this.field_element_name + '_input_div_' + num);
            	if (!div_el)
                    div_el = document.getElementById(this.field_element_name + '_radio_div_' + num);
                var tr_to_remove = document.getElementById('lineFields_' + this.field_element_name + '_' + num);
            	div_el.parentNode.parentNode.parentNode.removeChild(tr_to_remove);
            	
                var div_id = 'lineFields_' + this.field_element_name + '_' + num;
                if (typeof sqs_objects[div_id.replace("_field_", "_")] != 'undefined') {
                    delete (sqs_objects[div_id.replace("_field_", "_")]);
                }
                var checked=false;
                for(var k=0; k< radio_els.length; k++){
                    if(radio_els[k].checked){
                        checked=true;
                    }
                }
                // If we remove an entry marked as the primary, set another record as the primary 
                var primary_checked = document.forms[this.form].elements[this.field+"_allowed_to_check"];
                var allowed_to_check = true;
                if(primary_checked && primary_checked.value == 'false'){
                	allowed_to_check = false;
                }
                if(/EditView/.test(this.form) && !checked && typeof radio_els[0] != 'undefined' && allowed_to_check) {
                    radio_els[0].checked = true;
                    this.changePrimary(true);
                    this.js_more();
                    this.js_more();
                }
                // if there is now only one record, hide the "more..." link
                if(radio_els.length == 1){
                    this.more_status = false;
					if (document.getElementById('more_'+this.field_element_name) && document.getElementById('more_'+this.field_element_name).style.display != 'none') {
	                    document.getElementById('more_'+this.field_element_name).style.display='none';			
					}

                    this.show_arrow_label(false);
                    this.js_more();
                }else{
                	this.js_more();
                    this.js_more();
                }
            }
        },
        
        get_radios: function() {
        	return YAHOO.util.Selector.query('input[name^=primary]', document.getElementById(this.field_element_name+'_table'));
        },
        
        /*
         * Add a new empty row.
         */
        add: function(values){
            this.fields_count++;
            var Field0 = this.init_clone(values);
            this.cloneField[1].appendChild(Field0);
            //Enable quicksearch for this field
            enableQS(true);
            this.changePrimary(false);
                      
            //If the arrow field and label are collapsed, un-collapse it
            if(document.getElementById('more_'+this.field_element_name) && document.getElementById('more_'+this.field_element_name).style.display == 'none'){
               document.getElementById('more_'+this.field_element_name).style.display='';
            }
            
            if(!this.is_expanded()) {
               this.js_more();
               this.show_arrow_label(true);
            }
        },
        
        /*
         * Add the secondaries rows on load of the page.
         */
        add_secondaries: function(){
            var clone_id = this.form + '_' + this.field + '_collection_0';
            YAHOO.util.Event.onContentReady(clone_id, function(c){
                c.create_clone();
                enableQS();
                c.changePrimary(true);
                for(key in c.secondaries_values){
                    if (isInteger(key)) {
                        c.add(c.secondaries_values[key]);
                    }
                }
                c.js_more();

                if (!_.isUndefined(window.parent.SUGAR) && !_.isUndefined(window.parent.SUGAR.App.view)) {
                    window.parent.SUGAR.App.controller.layout.getComponent('bwc').revertBwcModel();
                }
            }, this);
        },
        /*
         * Create the new row from a cloned row. 
         */
        init_clone: function(values){
        	
        	//Safety check, this means that the clone field was not created yet
        	if(typeof this.cloneField[0] == 'undefined') {
        	   return;
        	}
        	
            if (typeof values == "undefined") {
                values = new Array();
                values['name'] = "";
                values['id'] = "";
            }
            
            var count = this.fields_count;
            
            //Clone the table element containing the fields for each row, use safe_clone uder IE to prevent events from being cloned
            var Field0 = SUGAR.isIE ? 
            	SUGAR.collection.safe_clone(this.cloneField[0], true) : 
            	this.cloneField[0].cloneNode(true);

            Field0.id = "lineFields_"+this.field_element_name+"_"+count;
                        
            for ( var ii = 0; ii < Field0.childNodes.length; ii++ ){
                if(typeof(Field0.childNodes[ii].tagName) != 'undefined' && Field0.childNodes[ii].tagName == "TD") {      	
                    for (var jj = 0; jj < Field0.childNodes[ii].childNodes.length; jj++) {
                    	currentNode = Field0.childNodes[ii].childNodes[jj];
                    	this.process_node(Field0.childNodes[ii], currentNode, values);
                    } //for
                } //if
            } //for
            return Field0;
        },
        /**
         * process_node
         * 
         * method to process cloning of nodes, moved out of init_clone so that
         * this may be recursively called
         */
        process_node: function(parentNode, currentNode, values) {
            if(parentNode.className == 'td_extra_field'){
                // If this is an extra field
                if(parentNode.id){
                    parentNode.id='';
                }
                var toreplace = this.field + "_collection_extra_0";
                var re = new RegExp(toreplace, 'g');
                parentNode.innerHTML = parentNode.innerHTML.replace(re, this.field + "_collection_extra_" + this.fields_count);
            } else if (currentNode.tagName && currentNode.tagName == 'SPAN') { 
                //If it is our div element, recursively find all input elements to process
                currentNode.id = /_input/.test(currentNode.id) ? this.field_element_name + '_input_div_' + this.fields_count :  this.field_element_name + '_radio_div_' + this.fields_count;         	
				if (/_input/.test(currentNode.id)) {
					currentNode.name = 'teamset_div';
				}
            	
            	var input_els = currentNode.getElementsByTagName('input');
            	for ( var x = 0; x < input_els.length; x++ ){

                    //if the input tag id is blank (IE bug), then set it equal to that of the parent span id
                    if(typeof(input_els[x].id) == 'undefined' || input_els[x].id == '') {
                        input_els[x].id = currentNode.id;
                    }

                	if(input_els[x].tagName && input_els[x].tagName == 'INPUT') {
                	   this.process_node(parentNode, input_els[x], values);
                	}
                }
            } else if (currentNode.name) {
                // If this is a standard field
                var toreplace = this.field + "_collection_0";
                var re = new RegExp(toreplace, 'g');
                var name = currentNode.name;                
                var new_name = name.replace(re, this.field + "_collection_" + this.fields_count);
                var new_id = currentNode.id.replace(re, this.field + "_collection_" + this.fields_count);

                switch (name) {
                    case toreplace:
                    	var sqs_id = this.form + '_' + new_name;
                        if (typeof this.sqs_clone != 'undefined') {
                        	var sqs_clone = YAHOO.lang.JSON.stringify(this.sqs_clone);
                            eval('sqs_objects[sqs_id]=' + sqs_clone);
                            
                            for (var pop_field in sqs_objects[sqs_id]['populate_list']) {
                                if (typeof sqs_objects[sqs_id]['populate_list'][pop_field] == 'string') {
                                    sqs_objects[sqs_id]['populate_list'][pop_field] = sqs_objects[sqs_id]['populate_list'][pop_field].replace(RegExp('_0', 'g'), "_" + this.fields_count);
                                }
                            }
                            for (var req_field in sqs_objects[sqs_id]['required_list']) {
                                if (typeof sqs_objects[sqs_id]['required_list'][req_field] == 'string') {
                                    sqs_objects[sqs_id]['required_list'][req_field] = sqs_objects[sqs_id]['required_list'][req_field].replace(RegExp('_0', 'g'), "_" + this.fields_count);
                                }
                            }
                        }
                        
                        currentNode.name = new_name;
                        currentNode.id = new_id;
                        currentNode.value = values['name'];
                        break;
                    case "id_" + toreplace:
                        currentNode.name = new_name.replace(RegExp('_0', 'g'), "_" + this.fields_count);
                        currentNode.id = new_id.replace(RegExp('_0', 'g'), "_" + this.fields_count);
                        currentNode.value = values['id'];
                        break;
                    case "btn_" + toreplace:
                        currentNode.name = new_name;
                        currentNode.attributes['onclick'].value = currentNode.attributes['onclick'].value.replace(re, this.field + "_collection_" + this.fields_count);
                        currentNode.attributes['onclick'].value = currentNode.attributes['onclick'].value.replace(RegExp(this.field + "_collection_extra_0", 'g'), this.field + "_collection_extra_" + this.fields_count);
                        break;
                    case "allow_new_value_" + toreplace:
                        currentNode.name = new_name;
                        currentNode.id = new_id;
                        break;
                    case "remove_" + toreplace:
                        currentNode.name = new_name;
                        currentNode.id = new_id;
                        currentNode.setAttribute('collection_id', this.field_element_name);
                        currentNode.setAttribute('remove_id', this.fields_count);
                        currentNode.onclick = function() { 
                               collection[this.getAttribute('collection_id')].remove(this.getAttribute('remove_id'));
                        };
                        break;
                    case "primary_" + this.field + "_collection":
                        currentNode.id = new_id;
                        currentNode.value = this.fields_count;
                        currentNode.checked = false; //Firefox
                        currentNode.setAttribute('defaultChecked', '');
                        break;
                    default:
                        alert(toreplace + '|' + currentNode.name + '|' + name + '|' + new_name);
                        break;
                } //switch
            } //if-else
        	
        },
        
        /*
         * Collapse or expand the rows to show for the editview(depending of the this.more_status attribute).
         */
        js_more: function(val){
            if(this.show_more_image){
	            var more_ = document.getElementById('more_img_'+this.field_element_name);
	            var arrow = document.getElementById('arrow_'+this.field);
	            var radios = this.get_radios();
	            // if we want to collapse
	            if(this.more_status == false){
	                more_.src = "index.php?entryPoint=getImage&themeName="+SUGAR.themes.theme_name+"&imageName=advanced_search.gif";
	                this.more_status = true;
	                // show the primary only and hidde the other one.
	                var hidden_count = 0;
	                for(var k=0; k< radios.length; k++){
	                    if (radios[k].type && radios[k].type == 'radio') {
	                        if (radios[k].checked) {
	                            radios[k].parentNode.parentNode.parentNode.style.display = '';
	                        } else {
	                            radios[k].parentNode.parentNode.parentNode.style.display = 'none';
	                            hidden_count++;
	                        }
	                    }
	                }
	                //rrs - add code to not remove the first field if non if the fields are selected as primary
	                if(hidden_count == radios.length){
	                	radios[0].parentNode.parentNode.parentNode.style.display = '';
	                }
	                
	                arrow.value = 'hide';
	            }else{
	                more_.src = "index.php?entryPoint=getImage&themeName="+SUGAR.themes.theme_name+"&imageName=basic_search.gif";
	                this.more_status=false;
	                // display all the records
	                for(var k=0; k< radios.length; k++){
	                    if(isInteger(k)){
	                        radios[k].parentNode.parentNode.parentNode.style.display='';
	                    }
	                }

	                arrow.value = 'show';
	            }
                if (!_.isUndefined(window.parent.SUGAR) && !_.isUndefined(window.parent.SUGAR.App.view)) {
                    var model = window.parent.SUGAR.App.controller.layout.getComponent('bwc').bwcModel;
                    model.set($(arrow).attr('name'), arrow.value);
                }

	            var more_div = document.getElementById('more_div_'+this.field_element_name);
	            if(more_div) {
	              more_div.innerHTML = arrow.value == 'show' ? SUGAR.language.get('app_strings','LBL_HIDE') : SUGAR.language.get('app_strings','LBL_SHOW');
	            }
	            
	        }
        },
        /*
         * Create the clone on load of the page and store it in this.cloneField
         */
        create_clone: function() {
            var oneField = document.getElementById('lineFields_'+this.field_element_name+'_0');
            this.cloneField[0] = SUGAR.isIE ?
                SUGAR.collection.safe_clone(oneField, true) :
                oneField.cloneNode(true);
            this.cloneField[1] = oneField.parentNode;
            //fixing bug @48829: Team field shows fully expanded multiple teams instead of hiding multiple teams
            //this.more_status = true;
            var clone_id = this.form + '_' + this.field + '_collection_0';

            if (typeof sqs_objects != 'undefined' && typeof sqs_objects[clone_id] != 'undefined') {
                var clone = YAHOO.lang.JSON.stringify(sqs_objects[clone_id]);
                eval('this.sqs_clone=' + clone);
            }
        },
        /**
         * Validates team set to check if the primary team id has been set or not
         */
		validateTemSet : function(formname, fieldname) {
			var table_element_id = formname + '_' + fieldname + '_table';
			if(document.getElementById(table_element_id)) {
			   var input_elements = YAHOO.util.Selector.query('input[type=radio]', document.getElementById(table_element_id));
			   var has_primary = false;
			   var primary_field_id = fieldname + '_collection_0';
			   for(t in input_elements) {
				    primary_field_id = fieldname + '_collection_' + input_elements[t].value;
			        if(input_elements[t].type && input_elements[t].type == 'radio' && input_elements[t].checked == true) {
			           if(document.forms[formname].elements[primary_field_id].value != '') {
			        	  has_primary = true;
			           }
			           break;
			        }								   
			   }	   
			   if(!has_primary) {
			   		return false;
			   }
			   return true;
			}
			return true;
		}, 
        /**
         * return an array of teamids for a team field
         */
		getTeamIdsfromUI: function(formname, fieldname) {
			var team_ids = new Array();
			var table_element_id = formname + '_' + fieldname + '_table';
			if(document.getElementById(table_element_id)) {
			   input_elements = YAHOO.util.Selector.query('input[type=hidden]', document.getElementById(table_element_id));
			   for(t = 0; t < input_elements.length; t++) {
			     if (input_elements[t].id.match( fieldname + "_collection_") != null) {
			     	team_ids.push(input_elements[t].value);
			     } // if
			   } // for	   	   
			} // if
		    return team_ids;
		},
        /**
         * return a primary team id
         */
		getPrimaryTeamidsFromUI: function(formname, fieldname) {
			var table_element_id = formname + '_' + fieldname + '_table';
			if(document.getElementById(table_element_id)) {
		   		var input_elements = YAHOO.util.Selector.query('input[type=radio]', document.getElementById(table_element_id));
			    	for(t in input_elements) {
			    		var primary_field_id = 'id_' + document.forms[formname][fieldname].name + '_collection_' + input_elements[t].value;
			    		if(input_elements[t].type && input_elements[t].type == 'radio' && input_elements[t].checked == true) {
				           if(document.forms[formname].elements[primary_field_id].value != '') {
				        	   return document.forms[formname].elements[primary_field_id].value;
				           } // if
			    		} // if
			    	} // for
			} // if
			return '';	
		},
        /*
         * Change the primary row onchange of the radio button.
         */
        changePrimary: function(noAdd){
            var old_primary = this.primary_field;
            var radios=this.get_radios();
            for (var k = 0; k < radios.length; k++) {
                var qs_id = radios[k].id.replace('primary_','');
                if (radios[k].checked) {
                    this.primary_field = qs_id;
                } else {
                	qs_id = qs_id + '_' + k;
                }

                qs_id = this.form + '_' + qs_id;

                if(typeof sqs_objects != 'undefined' && typeof sqs_objects[qs_id] != 'undefined' && sqs_objects[qs_id]['primary_field_list']){
                    for (var ii = 0; ii < sqs_objects[qs_id]['primary_field_list'].length; ii++) {
                        if (radios[k].checked && qs_id != old_primary) {
                            sqs_objects[qs_id]['field_list'].push(sqs_objects[qs_id]['primary_field_list'][ii]);
                            sqs_objects[qs_id]['populate_list'].push(sqs_objects[qs_id]['primary_populate_list'][ii]);
                        }else if(old_primary == qs_id && !radios[k].checked){
                            sqs_objects[qs_id]['field_list'].pop();
                            sqs_objects[qs_id]['populate_list'].pop();
                        }
                    }
                }
            }
            
            if (noAdd) {
            	enableQS(false);
            }
            this.first = false;
        },
        /*
         * Collapse or expand the rows to show for the detailview. 
         */
        js_more_detail: function(id){
            var more_img = document.getElementById('more_img_'+id);
            if(more_img.style.display == 'inline'){
                more_img.src = "index.php?entryPoint=getImage&themeName="+SUGAR.themes.theme_name+"&imageName=advanced_search.gif";
            }else{
                more_img.src = "index.php?entryPoint=getImage&themeName="+SUGAR.themes.theme_name+"&imageName=basic_search.gif";
            }
        },
        /*
         * Replace the first field with the specified values
         */
        replace_first: function(values){
        	for (var i = 0; i <= this.fields_count; i++) {
        		var div_el = document.getElementById(this.field_element_name + '_input_div_' + i);
                if(div_el) { 
		        	var name_field = document.getElementById(this.field_element_name+"_collection_" + i);
					var id_field = document.getElementById("id_"+this.field_element_name+"_collection_" + i);
		        	name_field.value = values['name'];
		        	id_field.value = values['id'];
		        	break;
                }
        	}
        },
        /*
         * Remove all empty fields from the widget.
         */
        clean_up: function(){
            //clean up any rows that have been added but do not contain any data
            var divsToClean = new Array();
            var isFirstFieldEmpty = false;
            var divCount = 0;
            for (var i = 0; i <= this.fields_count; i++) {
                var div_el = document.getElementById(this.field_element_name + '_input_div_' + i);
                if(div_el) {        
	                input_els = div_el.getElementsByTagName('input');
	                for ( var x = 0; x < input_els.length; x++ ){
	                	if(input_els[x].id && input_els[x].name == (this.field + '_collection_' + i) && trim(input_els[x].value) == '') {
	                		if(divCount == 0){
	                			isFirstFieldEmpty = true;
	                		} else {
	                			divsToClean.push(i);
	                		}
	                	}
	                	
	                }
	                divCount++;
                }
            }

            for(var j = 0; j < divsToClean.length; j++){
            	this.remove(divsToClean[j]);
            }
            return isFirstFieldEmpty;
        },
        
        show_arrow_label: function(show) {
            var more_div = document.getElementById('more_div_'+this.field_element_name);
            if(more_div) {
               more_div.style.display = show ? '' : 'none';
            }        	
        },
        
        /**
         * is_expanded
         * helper function to determine whether or not the widget is expanded (all teams are shown)
         */
        is_expanded: function() {
            var more_div = document.getElementById('more_div_'+this.field_element_name);
            if(more_div) {
               return more_div.style.display == '';
            }
            return false;
        }
    };

	SUGAR.collection.safe_clone = function(e, recursive)
	{
		if (e.nodeName == "#text")
		{
			return document.createTextNode(e.data);
		}
		if(!e.tagName) return false;
		
		var newNode = document.createElement(e.tagName);
		if (!newNode) return false;

        var properties = [ 'id', 'class', 'style', 'name', 'type', 'valign', 'border', 'width', 'height', 'top', 'bottom', 'left', 'right', 'scope', 'row', 'columns', 'src', 'href', 'className', 'align', 'nowrap'];

        //clee. - Bug: 44976 - IE7 just does not calculate height properties correctly for input elements
        if(SUGAR.isIE7 && e.tagName.toLowerCase() == 'input')
        {
            var properties = [ 'id', 'class', 'style', 'name', 'type', 'valign', 'border', 'width', 'top', 'bottom', 'left', 'right', 'scope', 'row', 'columns', 'src', 'href', 'className', 'align', 'nowrap'];
        }
		
		for (var i in properties)
		{
			if (e[properties[i]])
			{
                //There are two groups of conditional checks here:
                //The first group is to ignore the style and type attributes for IE browsers
                //The second group is to ensure that only <a> and <iframe> tags have href attribute
                if ((properties[i] != 'style' || !SUGAR.isIE) &&
                    //Only <a> and <iframe> tags can have hrefs
                    (properties[i] != 'href'  || e.tagName == 'a' || e.tagName == 'iframe')) {
                        if(properties[i] == "type") {
                            newNode.setAttribute(properties[i], e[properties[i]]);
                        } else {
                            newNode[properties[i]] = e[properties[i]];
                        }
                }
			}
		}
		if(recursive)
		{
			for (var i in e.childNodes)
			{
				if(e.childNodes[i].nodeName && (!e.className || e.className != "yui-ac-container"))
				{
					var child = SUGAR.collection.safe_clone(e.childNodes[i], true);
					if (child) newNode.appendChild(child);
				}
			}
		}
		return newNode;
	}
}

/* End of File include/SugarFields/Fields/Collection/SugarFieldCollection.js */

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
function set_return_teams_for_editview(popup_reply_data) {
	var form_name = popup_reply_data.form_name;
	var field_name = popup_reply_data.field_name;
	teams = popup_reply_data.teams;
	var team_values = Array();
	
	//remove any empty fields before adding more.
	var isFirstFieldEmpty = collection[form_name + '_' + field_name].clean_up();
	var index = 0;
	
	for(team_id in teams) {
		 if(teams[team_id]['team_id']) {
			 var temp_array = []; 
			 temp_array['name'] = teams[team_id]['team_name'];

			 temp_array['name'] = replaceHTMLChars(temp_array['name']);
			 
	         temp_array['id'] = teams[team_id]['team_id'];
	         if(isFirstFieldEmpty && index == 0){
	         	collection[form_name + '_' + field_name].replace_first(temp_array);
	         }else{
	         	collection[form_name + '_' + field_name].add(temp_array);
	         }
	         index++;
		 }
	}
	if(collection[form_name + '_' + field_name].more_status) {
    	collection[form_name + '_' + field_name].js_more();
        collection[form_name + '_' + field_name].show_arrow_label(true);
    }
}


function set_primary_team(form_name, element_name, primary_team) {	
    radioElement = window.document.forms[form_name][element_name];
    if(radioElement.type) {
    	radioElement.checked = true;
    } else if(primary_team == '') {
    	found_checked = false;
    	for(i=0; i < radioElement.length; i++) {
    		if(radioElement[i].checked) {
    	   		found_checked = true;
    	   		break;
    		}
    	}	 
    	
    	if(!found_checked) {
    	   radioElement[0].checked = true;	
    	}   	
    } else {
    	for(i=0; i < radioElement.length; i++) {
    		if(radioElement[i].value == primary_team) {
    	   		radioElement[i].checked = true;
    	   		break;
    		}
    	}	
    }
}


function is_primary_team_selected(form_name, element_name) {
	table_element_id = form_name + '_' + document.forms[form_name][element_name].name + '_table';
	if(document.getElementById(table_element_id)) {
		   input_elements = YAHOO.util.Selector.query('input[type=radio]', document.getElementById(table_element_id));
		   has_primary = false;

		   for(t in input_elements) {
			    primary_field_id = document.forms[form_name][element_name].name + '_collection_' + input_elements[t].value;
		        if(input_elements[t].type && input_elements[t].type == 'radio' && input_elements[t].checked == true) {
		           if(document.forms[form_name].elements[primary_field_id].value != '') {
		        	  has_primary = true;
		           }
		           break;
		        }								   
		   }   
		   return has_primary;
	} //if
	return true;
}


function get_selected_teams(form_name, element_name) {
	var selected_teams = new Array();
	selected_teams['primary'] = new Array();
	selected_teams['secondaries'] = new Array();
	
	table_element_id = form_name + '_' + document.forms[form_name][element_name].name + '_table';
	if(document.getElementById(table_element_id)) {
		   input_elements = YAHOO.util.Selector.query('input[type=radio]', document.getElementById(table_element_id));
           var secondary_count = 0;
		   
		   for(t in input_elements) {
			    primary_field_id = 'id_' + document.forms[form_name][element_name].name + '_collection_' + input_elements[t].value;
			    if(input_elements[t].type && input_elements[t].type == 'radio' && input_elements[t].checked == true) {
		           if(document.forms[form_name].elements[primary_field_id].value != '') {
		        	   selected_teams['primary'] = document.forms[form_name].elements[primary_field_id].value;
		           } 
		        } else if(document.forms[form_name].elements[primary_field_id].value != '') {
		           selected_teams['secondaries'][secondary_count++] = document.forms[form_name].elements[primary_field_id].value;
		        }
		   }
	} //if
	return selected_teams;
}

/* End of File include/SugarFields/Fields/Teamset/Teamset.js */

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
/**
 * Datetimecombo.js
 * This is a javascript object that handles rendering the non-date portions
 * of a datetime field.  There are some assumptions that are made so this
 * class serves more as a utility rather than a building block.  It is used
 * primarily to handle the datetime field shown for Call, Meetings and Tasks
 * edit views.
 */
 
/*
 * Datetimecombo constructor
 * @param datetime 
 * @param fieldname
 * @param timeformat
 * @param tabindex
 * @allowEmptyHM - if this param was set true , the hour and minute select field will has an empty option.
 */
function Datetimecombo (datetime, field, timeformat, tabindex, showCheckbox, checked, allowEmptyHM) {
    this.datetime = datetime;
    this.allowEmptyHM = allowEmptyHM;
    if(typeof this.datetime == "undefined" || datetime == '' || trim(datetime).length < 10) {
       this.datetime = '';
       var d = new Date();
       var month = d.getMonth();
       var date = d.getDate();
       var year = d.getYear();
       var hours = d.getHours();
       var minutes = d.getMinutes(); 
    }

    this.fieldname = field;
    //Get hours and minutes and adjust as necessary
    
    if(datetime != '')
    {
    	parts = datetime.split(' ');
        this.hrs = parseInt(parts[1].substring(0,2), 10);
        this.mins = parseInt(parts[1].substring(3,5), 10);    	
    }
    
    this.timeformat = timeformat;  //23:00 || 11:00
    this.tabindex = tabindex == null || isNaN(tabindex) ? 1 : tabindex;
    
    // Calculate other derived values
    this.timeseparator = this.timeformat.substring(2,3);
    this.has12Hours = /^11/.test(this.timeformat);
    this.hasMeridiem = /am|pm/i.test(this.timeformat);
	if(this.hasMeridiem) {
	   this.pm = /pm/.test(this.timeformat);
    }
    this.meridiem = this.hasMeridiem ? trim(this.datetime.substring(16)) : '';
    this.datetime = this.datetime.substr(0,10);
    this.showCheckbox = showCheckbox;
    this.checked = parseInt(checked);
    YAHOO.util.Selector.query('input#' + this.fieldname + '_date')[0].value = this.datetime;

    //A safety scan to make sure hrs and minutes are formatted correctly
	if (this.mins > 0 && this.mins < 15) {
		this.mins = 15;
	} else if (this.mins > 15 && this.mins < 30) {
		this.mins = 30;
	} else if (this.mins > 30 && this.mins < 45) {
		this.mins = 45;
	} else if (this.mins > 45) {
		this.hrs += 1;
		this.mins = 0;
		if(this.hasMeridiem && this.hrs == 12) {
			if(this.meridiem == "pm" || this.meridiem == "am") {
				if(this.meridiem == "pm") {
					this.meridiem = "am";
				} else {
					this.meridiem = "pm";
				}
			} else {
				if(this.meridiem == "PM") {
					this.meridiem = "AM";
				} else {
					this.meridiem = "PM";
				}
			}
		}
		if (this.hasMeridiem && this.hrs > 12) {
			this.hrs = this.hrs - 12;
		}
	} //if-else

}

/**
 * jsscript
 * This function renders the javascript portion to handle updates
 * on the calendar widget.  We have to do this because browsers like Mozilla
 * have errors when attempting to handle events inside a class function.
 * This is the reason why this code that is generated is not placed within
 * the update function of the Datetimecombo class.  Instead, it is run
 * using the eval() method when the widget is loaded.
 */
Datetimecombo.prototype.jsscript = function(callback) {
	//text = '\n<script language="javascript" type="text/html">';
	text = '\nfunction update_' + this.fieldname + '(calendar) {';
	/*
	text += '\nif(calendar != null) {';
	text += '\ncalendar.onUpdateTime();';
	text += '\ncalendar.onSetTime();';
	text += '\ncalendar.hide();';
	text += '\n}'
	*/
    text += '\nd = YAHOO.util.Selector.query("input#' + this.fieldname + '_date")[0].value;';
    text += '\nh = YAHOO.util.Selector.query("select#' + this.fieldname + '_hours")[0].value;';
    text += '\nm = YAHOO.util.Selector.query("select#' + this.fieldname + '_minutes")[0].value;';
    text += '\nnewdate = d + " " + h + "' + this.timeseparator + '" + m;';
    if(this.hasMeridiem) {
        text += '\nif(typeof YAHOO.util.Selector.query("select#' + this.fieldname + '_meridiem")[0] != "undefined") {';
        text += '\n   newdate += YAHOO.util.Selector.query("select#' + this.fieldname + '_meridiem")[0].value;';
        text += '\n}';
    }
    text += '\nif(trim(newdate) =="'+ this.timeseparator +'") newdate="";';
    text += '\nYAHOO.util.Selector.query("select#' + this.fieldname + '")[0].value = newdate;';
    text += '\n' + callback;
    text += '\n}';
    //text += '\n</script>';
    return text;
}

/**
 * html
 * This function renders the HTML form elements for this widget
 */
Datetimecombo.prototype.html = function(callback) {
	
	//Now render the items
	var text = '<span style="position:relative; top:6px;"><select class="datetimecombo_time" size="1" id="' + this.fieldname + '_hours" tabindex="' + this.tabindex + '" onchange="combo_' + this.fieldname + '.update(); ' + callback + '">';
	var h1 = this.has12Hours ? 1 : 0;
	var h2 = this.has12Hours ? 12 : 23;
	if(this.allowEmptyHM){
		 text += '<option></option>';
	}
	for(i=h1; i <= h2; i++) {
	    val = i < 10 ? "0" + i : i;
	    text += '<option value="' + val + '" ' + (i == this.hrs ? "SELECTED" : "") +  '>' + val + '</option>';
	}
	
	text += '\n</select>&nbsp;';
	text += this.timeseparator;
	text += '\n&nbsp;<select class="datetimecombo_time" size="1" id="' + this.fieldname + '_minutes" tabindex="' + this.tabindex + '" onchange="combo_' + this.fieldname + '.update(); ' + callback + '">';
	if(this.allowEmptyHM){
		text += '\n<option></option>';
	}
	text += '\n<option value="00" ' + (this.mins == 0 ? "SELECTED" : "") + '>00</option>';
	text += '\n<option value="15" ' + (this.mins == 15 ? "SELECTED" : "") + '>15</option>';
	text += '\n<option value="30" ' + (this.mins == 30 ? "SELECTED" : "") + '>30</option>';
	text += '\n<option value="45" ' + (this.mins == 45 ? "SELECTED" : "") + '>45</option>';
	text += '\n</select>';
	
	if(this.hasMeridiem) {
		text += '\n&nbsp;';
		text += '\n<select class="datetimecombo_time" size="1" id="' + this.fieldname + '_meridiem" tabindex="' + this.tabindex + '" onchange="combo_' + this.fieldname + '.update(); ' + callback + '">';
		if(this.allowEmptyHM){
			text += '\n<option></option>';
		}
		text += '\n<option value="' + (this.pm ? "am" : "AM") + '" ' + (/am/i.test(this.meridiem) ? "SELECTED" : "") + '>' + (this.pm ? "am" : "AM") + '</option>';
		text += '\n<option value="' + (this.pm ? "pm" : "PM") + '" ' + (/pm/i.test(this.meridiem) ? "SELECTED" : "") + '>' + (this.pm ? "pm" : "PM") + '</option>';
		text += '\n</select>';
	}
	
	if(this.showCheckbox) {
	    text += '\n<input style="visibility:hidden;" type="checkbox" name="' + this.fieldname + '_flag" id="' + this.fieldname + '_flag" tabindex="' + this.tabindex + '" onchange="combo_' + this.fieldname + '.update(); ' + callback + '" ' + (this.checked ? 'CHECKED' : '') + '>';
	    //text += '&nbsp;' + SUGAR.language.get("app_strings", "LBL_LINK_NONE");	
	}

    text += '</span>';
	return text;
};


/**
 * update
 * This method handles events on the hour, minute and meridiem elements for the widget
 * 
 * XXX TODO 20100317 Frank Steegmans: The code in this module is violating so many best practices
 * that it will need to get rewritten. Also note that it still stems from before the datetime unification.
 */
Datetimecombo.prototype.update = function(updateListeners) {
	//On initial load, we call update but we don't want to trigger listeners as the value hasn't really changed.
	if (typeof (updateListeners) == "undefined")
		updateListeners = true;

	// Bug 42025: hour/minute/second still required when start_date is non required
	//			  Fixing this by just assigning default when they aren't required
    var d = YAHOO.util.Selector.query('input#' + this.fieldname + '_date')[0];
    var h = YAHOO.util.Selector.query('select#' + this.fieldname + '_hours')[0];
    var m = YAHOO.util.Selector.query('select#' + this.fieldname + '_minutes')[0];
    var mer = YAHOO.util.Selector.query('select#' + this.fieldname + "_meridiem")[0];

    if(d.value == "") { // if date is not set wipe time settings
		h.selectedIndex = 0;
		m.selectedIndex = 0;
		if(mer) mer.selectedIndex = 0;
	} else { // if date is set and hours/minutes are not allowed empty, initialize them
		if(this.allowEmptyHM) {
			if(h.selectedIndex == 0) h.selectedIndex = 12;
			if(m.selectedIndex == 0) m.selectedIndex = 1;
			if(mer && (mer.selectedIndex == 0)) mer.selectedIndex = 1;
		}
	}
	
	var newdate = d.value + ' ' + h.value + this.timeseparator  + m.value;

	if(this.hasMeridiem) {
        ampm = YAHOO.util.Selector.query('select#' + this.fieldname + "_meridiem")[0].value;
        newdate += ampm;
	}
	if(trim(newdate) == ""+this.timeseparator+""){
		newdate = '';
	}
    YAHOO.util.Selector.query('input#' + this.fieldname)[0].value = newdate;
    //Check for onchange actions and fire them
	if(updateListeners)
		SUGAR.util.callOnChangeListers(this.fieldname);

    if(this.showCheckbox) {	
         flag = this.fieldname + '_flag';
         date = this.fieldname + '_date';
         hours = this.fieldname + '_hours';
         mins = this.fieldname + '_minutes';

        if (YAHOO.util.Selector.query('input#' + flag)[0].checked)
        {
            YAHOO.util.Selector.query('input#' + flag)[0].value = 1;
            YAHOO.util.Selector.query('input#' + this.fieldname)[0].value = '';
            YAHOO.util.Selector.query('input#' + date)[0].disabled = true;
            YAHOO.util.Selector.query('select#' + hours)[0].disabled = true;
            YAHOO.util.Selector.query('select#' + mins)[0].disabled = true;
        }
        else
        {
            YAHOO.util.Selector.query('input#' + flag)[0].value = 0;
            YAHOO.util.Selector.query('input#' + date)[0].disabled = false;
            YAHOO.util.Selector.query('select#' + hours)[0].disabled = false;
            YAHOO.util.Selector.query('select#' + mins)[0].disabled = false;
        }
    }
};

/* End of File include/SugarFields/Fields/Datetimecombo/Datetimecombo.js */

