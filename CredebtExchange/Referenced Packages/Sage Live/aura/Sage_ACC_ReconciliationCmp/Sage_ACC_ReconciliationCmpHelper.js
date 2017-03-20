({
    fireGetClassifications : function(component) {
        var action = component.get("c.getJournalClassifications");
        action.setCallback(this, function(response) {
            var state = response.getState();
            if (state === "SUCCESS") {
                var classifications = response.getReturnValue();
                component.set("v.classifications", classifications);
                component.set("v.classification", null);
                component.set("v.journalTypes", []);
                component.set("v.journalList", []);

                var classificationParam = component.get("v.classificationParam");
 				if (classificationParam && classificationParam.length>0)
                {
                    component.set("v.classification", {"label": classificationParam, "value": classificationParam});
                    component.set("v.classificationParam", "");
                    this.fireGetJournalTypes(component, classificationParam);
                }
                else {
     	           this.renderFilterHeader(component);
                }
            }
        });
        $A.enqueueAction(action);
    },

	fireGetJournalTypes : function(component, classification) {
		var action = component.get("c.getJournalTypes");
        action.setParams({ classification : classification });
        action.setCallback(this, function(response) {
            var state = response.getState();
            if (state === "SUCCESS") {
                var journalTypes = response.getReturnValue();
                component.set("v.journalTypes", journalTypes);
                component.set("v.journalList", []);
                component.set("v.journalType", null);
                component.set("v.journals", []);
                component.set("v.journalSearchValue", null);

                var journalType;
                var typeIdParam = component.get("v.typeIdParam");
 				if (typeIdParam && typeIdParam.length>0)
                {
                    component.set("v.typeIdParam", "");

                    //Search for this type in the journal types
                    //var journalType;
                    var journalTypesFound = journalTypes.filter(function( obj ) {
                    return obj.Id.toString() === typeIdParam.toString();
    				});
                    if (journalTypesFound.length > 0) {
                        journalType = journalTypesFound[0];
                    }
                }

                if (journalTypes.length === 1){
                 journalType = journalTypes[0];
                }

                if (journalType) {
                   component.set("v.journalType", {"label": journalType.Name, "value": journalType.Id});

  		            //var journal;
                   var journalIdParam = component.get("v.journalIdParam");
 				   if (journalIdParam && journalIdParam.length>0)
                   {
 	                   component.set("v.journalIdParam", "");
                       this.fireGetJournal(component, journalIdParam);
                       return;
                   }
                }

 	            this.renderFilterHeader(component);
            }
        });
       $A.enqueueAction(action);
	},

    fireGetJournal : function(component, journalId) {
        var action = component.get("c.getJournal");
        if (journalId.indexOf(',') > -1) {
            action = component.get("c.getJournalsByList");
            action.setParams({ journals : journalId });
        }
        else
        {
            action.setParams({ journal : journalId });
        }
        action.setCallback(this, function(response) {
            var state = response.getState();
            if (state === "SUCCESS") {
                var journals = response.getReturnValue();
                if (journals) {
                    if (journals.length === 1) journals = [journals];
                	component.set("v.journals", journals);
                	component.set("v.journalSearchValue", null);
                	component.set("v.journalList", null);
                    var offset = component.get("v.paginationOffset");
                	this.renderFilterHeader(component);
                	this.fireGetJournalItems(component, journals, false, offset);
                    return;
                }
            }

            component.set("v.journals", []);
            component.set("v.journalSearchValue", null);
            component.set("v.journalList", null);
            this.renderFilterHeader(component);
        });
       $A.enqueueAction(action);
    },

	fireGetJournals : function(component, journalType) {
        var searchValue = component.get("v.journalSearchValue");
    	//qqq Pass search criteria to getJournals
		var action = component.get("c.getJournals");
        action.setParams({
            journalType : journalType,
            searchString: searchValue
        });
        action.setCallback(this, function(response) {
            var state = response.getState();
            if (state === "SUCCESS") {
                var journalList = response.getReturnValue();
                component.set("v.journalList", journalList);
                component.set("v.journals", []);
                this.renderFilterHeader(component);
            }
        });
       $A.enqueueAction(action);
	},

    fireGetJournalsFromMenu : function(component, journalType) {
        var searchValue = component.get("v.journalSearchValue");
    	//qqq Pass search criteria to getJournals
		var action = component.get("c.getJournalsFromMenu");
        action.setParams({
            journalType : journalType,
            searchString: searchValue
        });
        action.setCallback(this, function(response) {
            var state = response.getState();
            if (state === "SUCCESS") {
                var journalList = response.getReturnValue();
                component.set("v.journalList", journalList);
                component.set("v.journals", []);
                this.renderFilterHeader(component);
            }
        });
       $A.enqueueAction(action);
	},

    showJournalSpinner: function(component, show) {
        var spinner = component.find("journalItemsSpinner").getElement();
 		if (!spinner) return;
        if (show) {
        	spinner.removeAttribute('class', 'sagelive-slds-hide');
        } else {
        	spinner.setAttribute('class', 'sagelive-slds-hide');
        }
    },

    fireGetJournalItems: function(component, journals, displaySplitMessage, offset) {
        if (!offset) offset = 0;
        var paginationLimit = component.get('v.paginationLimit');

        this.showJournalSpinner(component, true);
        var journalIDs = [];
        if (!Array.isArray(journals)) journals = [journals];

        for(var i = 0; i < journals.length; i++)
        {
            if (journals[i].Id) {
                journalIDs.push(journals[i].Id);
            }
            else {
                journalIDs.push(journals[i]);
            }
        }

       	component.set("v.selectedJournals", journalIDs);
        component.set("v.paginationOffset", offset);
        var startDateString = component.get("v.startDate");
        var endDateString = component.get("v.endDate");
        if (startDateString) {
            startDateString = startDateString + " 00:00:00";
        }
        if (endDateString) {
            endDateString = endDateString + " 00:00:00";
        }
        var action = component.get("c.getJournalItems");
        var firstTabSelected = component.get("v.firstTabSelected");
        var status = (firstTabSelected ? "NotTagged" : null);

        // TODO: include startDate and endDate in filter
        // To be passed to function getJournalItems in Sage_ACC_Rec_Ctrl_M server controller
        action.setParams({
            	journals : journalIDs.join(),
           	 	Status: status,
            	StartDateString: startDateString,
            	EndDateString: endDateString,
                paginationOffset: offset.toString(),
                paginationLimit: paginationLimit.toString(),
        	});

        action.setCallback(this, function(response) {
            var state = response.getState();
            if (state === "SUCCESS") {
                var result = response.getReturnValue();
     			var journalItems = result.journalItems;
                component.set("v.journalItems", journalItems);
                component.set("v.journalItemsTotal", result.journalItemsTotal);

                var cancelledJournalItemId = component.get("v.cancelledJournalItemId");
                component.set("v.cancelledJournalItemId", null);

                if (cancelledJournalItemId && cancelledJournalItemId.length > 0)
                {
                    //This is a "refresh" of a specific journal item - so we need to re-select
                    //that journal item.
                    var journalItem;

                    for (i = 0; i < journalItems.length; i++)
        			{
            			if (journalItems[i].id.toString() === cancelledJournalItemId.toString())
            			{
                            journalItems[i].selected = true;
                            journalItem = journalItems[i];
                            break;
                        }
                    }

                    if (journalItem)
                    {
                        //Force update of the journal items.
                        component.set("v.journalItems", null);
        				this.renderJournalItems(component, false, false, false, false, null);

                        component.set("v.journalItems", journalItems);
 						component.set("v.selectedJournalItem", journalItem);
                    	this.renderJournalItems(component, false, false, false, false, null);
                        this.renderTabs(component, result.tagged, result.notTagged);
                        this.fireGetAvailableTags(component, journalItem);
                        return;
                    }
                }

                component.set("v.searchCriteria", null);
        	    component.set("v.selectedJournalItem", null);
            	component.set("v.availableTags", null);
                this.renderJournalItems(component, false, displaySplitMessage, false, false, null);
               	this.renderTabs(component, result.tagged, result.notTagged);
                this.renderAvailableTags(component);
             }
        });

        $A.enqueueAction(action);
    },

    fireGetAvailableTags: function(component, journalItem) {
    	var tagAction = component.get("c.getAvailableTags");
        var searchCriteria = component.get("v.searchCriteria");
        tagAction.setParams({
            journalItemJSON : JSON.stringify(journalItem),
            filterText : (!searchCriteria || searchCriteria.length === 0) ? null : searchCriteria
        });
        tagAction.setCallback(this, function(response) {
            var state = response.getState();
            if (state === "SUCCESS") {
            	var tags = response.getReturnValue();

                component.set("v.dimensionId", "");
                component.set("v.dimensionName", "All");
                component.set("v.dimensionSort", "Amount");
                component.set("v.availableTags", tags);
                this.renderAvailableTags(component);
            }
        });
        $A.enqueueAction(tagAction);
    },

    fireCancelJournalItem: function(component, journalItem) {
        component.set("v.selectedJournalItem", null);
        component.set("v.availableTags", null);
        component.set("v.searchCriteria", null);
        this.renderAvailableTags(component);

        var journals = component.get("v.selectedJournals");
        var offset = component.get("v.paginationOffset");

        component.set("v.cancelledJournalItemId", journalItem.id);
       	this.fireGetJournalItems(component, journals, false, offset);
    },

    fireValidateJournalItem: function(component, journalItem, split) {
    	var validateAction = component.get("c.ValidateJournalItem");

        if (split) {
          for (var i = 0; i < journalItem.dimensions.length; i++) {
            var dim = journalItem.dimensions[i];
            if (dim.dimensionId !== journalItem.JournalDimensionTypeId && dim.selectedAmount < dim.balance){
              var dim2 = JSON.parse(JSON.stringify(dim));
              dim2.balance = null;
              dim2.tagId = null;
              dim2.tagName = '';
              journalItem.dimensions.push(dim2);
            }
          }
        }
        //console.log(journalItem);

        validateAction.setParams({ "journalItemJSON" : JSON.stringify(journalItem)});
        
        validateAction.setCallback(this, function(response) {
            var state = response.getState();
            if (state === "SUCCESS") {
            	var results = response.getReturnValue();
                var success = false;
                var split_res = false;

                if (results && results.length > 0) {
                  //Check to see whether the operation was a success, split, or failure
                  var result = results[0].toString();
                  success = (result === "Success");
                  split_res = (result === "Split");
                }

                if (success) {
                    if (results.length > 1) {
                        journalItem = JSON.parse(results[1]);
                        this.updateJournalItem(component, journalItem);
                    }
                	this.renderJournalItems(component, true, false, false, false, null);
                } else if (split_res) {
                    var journal = component.get("v.selectedJournals");
                    this.fireGetJournalItems(component, journal, true, null);
                } else {
                    this.renderJournalItems(component, false, false, true, true, results);
                }
            } else {
                //An error occurred in the Apex controller
            	this.renderJournalItems(component, false, false, true, true, null);
            }
        });
        $A.enqueueAction(validateAction);
    },

    fireReprocessJournalItem : function(component, split) {
        var action = component.get("c.ReprocessJournalItem");
        action.setParams({ "journalItemJSON" : JSON.stringify(component.get("v.selectedJournalItem")) });
        action.setCallback(this, function(response) {
            var state = response.getState();
            if (state === "SUCCESS") {
                var journalItem = response.getReturnValue();
                this.updateJournalItem(component, journalItem);
                this.renderJournalItems(component, false, false, false, true, null);
 			    this.fireGetAvailableTags(component, journalItem);
            }
            else {
                //console.log("Call to ReprocessJournalItem failed.");
            }
        });
        $A.enqueueAction(action);
    },

    registerCardListIconsChangedHandler : function(component) {
        var handleEvent = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_CardListIconsChanged");
			event.fire();
        }

        var cardListElement = component.find("cardListWrapper").getElement();
        cardListElement.addEventListener("iconDisplayChanged", $A.getCallback(handleEvent), false);
    },

    registerCancelJournalItemHandler : function(component) {
        var handleEvent = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_CancelJournalItem");
			event.setParams({"item": e.detail});
			event.fire();
        }

        var cardListElement = component.find("cardListWrapper").getElement();
        cardListElement.addEventListener("cancelItem", $A.getCallback(handleEvent), false);
    },

    registerValidateJournalItemHandler : function(component) {
        var handleEvent = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_ValidateJournalItemEvent");
			      event.setParams({"item": e.detail.item});
            event.setParams({"split": e.detail.split});
			      event.fire();
        }

        var cardListElement = component.find("cardListWrapper").getElement();
        cardListElement.addEventListener("validateItem", $A.getCallback(handleEvent), false);
    },

    registerJournalSearchHandler : function(component) {
        var handleEvent = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_SearchJournalEvent");
            event.setParams({"searchValue": e.detail});
            event.fire();
        }
        var filterElement = component.find("filterWrapper").getElement();
        filterElement.addEventListener("journalSearch", $A.getCallback(handleEvent), false);
    },

    registerSelectLookupMenuItemHandler : function(component) {
        var handleEvent = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_SelectLookupMenuItemEvent");
            event.setParams({"searchValue": e.detail});
            event.fire();
        }
        var filterElement = component.find("filterWrapper").getElement();
        filterElement.addEventListener("selectLookupMenuItem", $A.getCallback(handleEvent), false);
    },

    registerOffsetChangedHandler : function(component) {
        var handleEvent = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_OffsetChangedEvent");
            event.setParams({"offset": e.detail});
            event.fire();
        }
        var pagination = component.find("pagination").getElement();
        pagination.addEventListener("navigateOffset", $A.getCallback(handleEvent), false);
    },

    registerChangeFilterHandler : function(component) {
        var handleEvent1 = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_ChangeFilter");
            event.setParams({"filterValue": e.detail, "filterNumber": "1"});
			event.fire();
        }
        var handleEvent2 = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_ChangeFilter");
            event.setParams({"filterValue": e.detail, "filterNumber": "2"});
			event.fire();
        }
        var handleEvent3 = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_ChangeFilter");
            event.setParams({"filterValue": e.detail, "filterNumber": "3"});
			event.fire();
        }
        var filterElement = component.find("filterWrapper").getElement();
        filterElement.addEventListener("classificationChanged", $A.getCallback(handleEvent1), false);
        filterElement.addEventListener("typeChanged", $A.getCallback(handleEvent2), false);
        filterElement.addEventListener("journalChanged", $A.getCallback(handleEvent3), false);
    },

    registerDoneClickedFilterHandler : function(component) {

        var handleEvent = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_DoneClickedFilter");
            event.fire();
        }
        var filterElement = component.find("filterWrapper").getElement();
        filterElement.addEventListener("filterDoneClicked", $A.getCallback(handleEvent), false);
    },
    
    registerClearClickedFilterHandler : function(component) {
      
        var handleEvent = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_ClearClickedFilter");
            event.fire();
        }
        var filterElement = component.find("filterWrapper").getElement();
        filterElement.addEventListener("filterClearClicked", $A.getCallback(handleEvent), false);
    },

    registerChangeDatedFilterHandler : function(component) {
        var handleEvent1 = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_ChangeFilter");
            event.setParams({"filterValue": e.detail.value, "filterNumber": "4"});
            event.fire();
        }
        var handleEvent2 = function(e) {
            e.stopPropagation();

            var event = $A.get("e.s2cor:Sage_ACC_Rec_ChangeFilter");
            event.setParams({"filterValue": e.detail.value, "filterNumber": "5"});
			event.fire();
        }
       var handleEvent3 = function(e) {
            e.stopPropagation();

            var event = $A.get("e.s2cor:Sage_ACC_Rec_ChangeFilter");
            event.setParams({"filterNumber": "6"});
			event.fire();
        }
       var filterElement = component.find("filterWrapper").getElement();
        filterElement.addEventListener("classificationChanged", $A.getCallback(handleEvent1), false);
//        filterElement.addEventListener("startDateChanged", handleEvent1, false);
        filterElement.addEventListener("endDateChanged", $A.getCallback(handleEvent2), false);
        filterElement.addEventListener("dateDisplayChanged", $A.getCallback(handleEvent3), false);
    },

    registerTransactionTabHandler : function(component) {
        var handleEvent = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_TransactionTabChanged");
            event.setParams({
                "firstTabSelected": e.detail,
            });
			event.fire();
        }
        var tabsElement = component.find("tabsWrapper").getElement();
        tabsElement.addEventListener("bankReconciliationTabChanged", $A.getCallback(handleEvent), false);
    },

    registerMenuOptionChangedHandler : function(component) {
        var handleEvent = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_MenuOptionChangedEvent");
            event.setParams({
                "dimensionId": e.detail.dimensionId,
                "dimensionName" : e.detail.dimensionName,
                "sort": e.detail.dimensionSort
            });
			event.fire();
        }
        var tagsElement = component.find("tagsTable").getElement();
        tagsElement.addEventListener("menuOptionChanged", $A.getCallback(handleEvent), false);
    },

    registerSearchCriteriaChangedHandler : function(component) {
        var handleEvent = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_SearchCriteriaChanged");
            event.setParams({
                "searchCriteria": e.detail
            });
			event.fire();
        }
        var tagsElement = component.find("tagsTable").getElement();
        tagsElement.addEventListener("searchCriteriaChanged", $A.getCallback(handleEvent), false);
    },

    registerSelectItemHandler : function(component) {
        var handleEvent = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_JournalItemSelectedEvent");
			event.setParams({"item": e.detail});
			event.fire();
        }

        var cardListElement = component.find("cardListWrapper").getElement();
        cardListElement.addEventListener("selectItem", $A.getCallback(handleEvent), false);
    },

    registerJournalItemDimensionTypeChangedHandler : function(component) {
        var handleEvent = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_JournalItemDimTypeChangedEvent");
			event.setParams({"item": e.detail});
			event.fire();
        }

        var cardListElement = component.find("cardListWrapper").getElement();
        cardListElement.addEventListener("changeItemDimensionType", $A.getCallback(handleEvent), false);
    },

    registerSelectAvailableTagHandler : function(component) {
        var handleEvent = function(e) {
            e.stopPropagation();
            var item = component.get("v.selectedJournalItem");
            var event = $A.get("e.s2cor:Sage_ACC_Rec_AvailableTagSelectedEvent");
            event.setParams({
                "tag": e.detail,
                "item": item
            });
			event.fire();
        }

        var cardListElement = component.find("tagsTable").getElement();
        cardListElement.addEventListener("selectAvailableTag", $A.getCallback(handleEvent), false);
    },

    registerTagRemovedFromJournalItemHandler : function(component) {
        var handleEvent = function(e) {
            e.stopPropagation();
            var event = $A.get("e.s2cor:Sage_ACC_Rec_TagRemovedFromJournalItemEvent");
			event.setParams({"item": e.detail});
			event.fire();
        }

        var cardListElement = component.find("cardListWrapper").getElement();
        cardListElement.addEventListener("tagRemovedFromJournalItem", $A.getCallback(handleEvent), false);
    },

    renderFilterHeader : function(component){
        var startDateParam = component.get("v.startDateParam");
        var endDateParam = component.get("v.endDateParam");
		if (startDateParam && startDateParam.length > 0) {
            component.set("v.startDate", startDateParam);
        }
        if (endDateParam && endDateParam.length > 0) {
            component.set("v.endDate", endDateParam);
        }
        component.set("v.startDateParam", "");
        component.set("v.endDateParam", "");

        var filterWrapper = component.find('filterWrapper').elements[0];

        var journalClassifications = component.get("v.classifications");
        var journalClassificationsForFilter = this.prepareArrayForDropDown(journalClassifications);
        var journalTypes = component.get("v.journalTypes");
        var journalTypesForFilter = this.prepareArrayForDropDown(journalTypes);
        var searchValue = component.get("v.journalSearchValue");
        var journalList = component.get("v.journalList");
        var defaultJournalClassification = journalClassificationsForFilter.length > 0 ? component.get("v.classification") : "";
        //var journalType =  component.get("v.journalType");
        var defaultJournalType = journalTypesForFilter.length > 0 ? component.get("v.journalType") : null;
        var defaultJournal = component.get("v.journals");
        var defaultStartDate = component.get("v.startDate");
        if (defaultStartDate && defaultStartDate.length === 0) {
            defaultStartDate = null;
        }
        var defaultEndDate = component.get("v.endDate");
        if (defaultEndDate && defaultEndDate.length === 0) {
            defaultEndDate = null;
        }

        var labels = {
      		Classification: $A.get("$Label.s2cor.VF_Bank_Reconciliation_Journal_Classification"),
      		Type: $A.get("$Label.s2cor.VF_Generic_Journal_Type"),
      		Journal: $A.get("$Label.s2cor.VF_Generic_Journal"),
            Journals: $A.get("$Label.s2cor.VF_Generic_Journals"),
      		ClassificationPrompt: $A.get("$Label.s2cor.VF_Bank_Reconciliation_Classification_Prompt"),
      		TypePrompt: $A.get("$Label.s2cor.VF_Bank_Reconciliation_Type_Prompt"),
      		JournalPrompt: $A.get("$Label.s2cor.VF_Generic_Select_Journal"),
      		StartDate: $A.get("$Label.s2cor.VF_Generic_Start_Date"),
      		EndDate: $A.get("$Label.s2cor.VF_Generic_End_Date"),
      		OK: $A.get("$Label.s2cor.OK"),
      		OKAssist: ("$Label.s2cor.VF_Bank_Reconciliation_OK_Assist"),
      		FilterAssist: $A.get("$Label.s2cor.VF_Generic_Journal_Filter"),
      		EditFilterAssist: $A.get("$Label.s2cor.VF_Generic_Edit_Journal_Filter"),
      		ClearFilter:  $A.get("$Label.s2cor.VF_Generic_Clear_Filters"),
            ClearJournalSearchFilter: $A.get("$Label.s2cor.VF_Generic_Clear_Journal_Filter_Search"),
      		RemoveStartDateAssist: $A.get("$Label.s2cor.VF_Generic_Remove_Filter_Start_Date"),
      		RemoveEndDateAssist: $A.get("$Label.s2cor.VF_Generic_Remove_Filter_End_Date"),
            StartDatePrompt: $A.get("$Label.s2cor.VF_Generic_Start_Date_Prompt"),
      		EndDatePrompt: $A.get("$Label.s2cor.VF_Generic_End_Date_Prompt"),
            searching: $A.get("$Label.s2cor.VF_Generic_Searching"),
      		noResultsFound: $A.get("$Label.s2cor.VF_Generic_No_Results"),
          RecentlyViewed: $A.get("$Label.s2cor.VF_Generic_Recently_Viewed"),
          RecentlyCreated: $A.get("$Label.s2cor.VF_Generic_Recently_Created"),
          RecentlyUpdated: $A.get("$Label.s2cor.VF_Generic_Recently_Updated"),
          FindList: $A.get("$Label.s2cor.VF_Generic_Find_List")
    	}

        Carbon.ReactDOM.render(
        	Carbon.React.createElement(Carbon.BRF, {
            	journalClassifications:journalClassificationsForFilter,
            	journalTypes:journalTypesForFilter,
                journalResults: journalList,
                journalSearchString: searchValue,
                labels: labels,
                selectedJournalClassification: defaultJournalClassification,
                selectedJournalType: defaultJournalType,
                selectedJournals: defaultJournal,
                selectedStartDate: defaultStartDate,
                selectedEndDate: defaultEndDate
        	}),
        	filterWrapper
      	);

        var mainSpinner = document.getElementById("mainSpinner");
 		if (mainSpinner)
        {
        	mainSpinner.setAttribute('class', 'sagelive-slds-hide');
        }

        this.fixIcons(component);
        this.renderTabs(component, 0, 0);
        this.renderJournalItems(component, false, false, false, false, null);
        this.renderAvailableTags(component);
    },

    renderTabs : function(component, taggedCount, notTaggedCount){
        var firstTabSelected = component.get("v.firstTabSelected");
        var allCount = taggedCount + notTaggedCount;
        var needAttentionLabel = (notTaggedCount === 1) ? "(1 "+ $A.get("$Label.s2cor.VF_Generic_Item") + ")" : "(" + notTaggedCount + " " + $A.get("$Label.s2cor.VF_Generic_Items") + ")";
        var allItemsLabel = (allCount === 1) ? "(1 " + $A.get("$Label.s2cor.VF_Generic_Item") + ")" : "(" + allCount + " " + $A.get("$Label.s2cor.VF_Generic_Items") + ")";
        var firstTabLabel = $A.get("$Label.s2cor.VF_Bank_Reconciliation_Need_Attention") + " " + needAttentionLabel;
        var secondTabLabel = $A.get("$Label.s2cor.VF_Bank_Reconciliation_All_Transactions") + " " + allItemsLabel;
        var tabsWrapper = component.find('tabsWrapper').elements[0];

        Carbon.ReactDOM.render(
        	Carbon.React.createElement(Carbon.BankReconciliationTabs, {
        		firstTabLabel: firstTabLabel,
        		secondTabLabel: secondTabLabel,
                firstTabSelected: firstTabSelected
        	}),
        	tabsWrapper
      	);

        this.fixIcons(component);
    },

    renderJournalItems : function(component, displaySuccess, displaySplit, displayError, modified, errorDetails) {
 		var locale = $A.get("$Locale.userLocaleLang");
        var showBank = false;
        var bankDimensionName = "";
        var journal = component.get("v.selectedJournalItem");
        var firstTabSelected = component.get("v.firstTabSelected");
        var displaySuccessMessageForItem = (displaySuccess && journal) ? journal.id : null;
        var displayErrorMessageForItem = (displayError && journal) ? journal.id : null;

 		var journalItems = component.get("v.journalItems");
        var paginationOffset = component.get("v.paginationOffset");
        var paginationLimit = 20;
        var journalItemsTotal = component.get("v.journalItemsTotal");
        component.set("v.paginationLimit", paginationLimit);
        if (journalItems && journalItems.length > 0)
        {
 			//Check the first journal item - if the feedDimensionName is blank then we will not show the bank column
 			var journalItem = journalItems[0];
        	if ((journalItem.feedDimensionName) && (journalItem.feedDimensionName.length > 0))
            {
    			showBank = true;
                bankDimensionName = journalItem.feedDimensionName;
            }
        }

        var labels = {
        	items: $A.get("$Label.s2cor.VF_Bank_Reconciliation_Items"),
        	entryDate: $A.get("$Label.s2cor.VF_Generic_Entry_Date"),
        	itemName: $A.get("$Label.s2cor.VF_Generic_Item_Name"),
        	reference: $A.get("$Label.s2cor.VF_Generic_Reference"),
        	type: $A.get("$Label.s2cor.VF_Generic_Type"),
        	amount: $A.get("$Label.s2cor.VF_Generic_Amount"),
          all: $A.get("$Label.s2cor.VF_Generic_All"),
          date: $A.get("$Label.s2cor.VF_Generic_Date"),
          FilterOptions: $A.get("$Label.s2cor.VF_Generic_Filter_Options"),
          SearchCriteria: $A.get("$Label.s2cor.VF_Generic_Search_Criteria"),
          NoRecords: $A.get("$Label.s2cor.VF_Generic_No_Records"),
        	bank: bankDimensionName + ":",
        	postingStatusLabel : $A.get("$Label.s2cor.VF_Generic_Posting_Status_Label"),
        	description: $A.get("$Label.s2cor.VF_Generic_Description"),
        	validate: $A.get("$Label.s2cor.Validate"),
        	cancel: $A.get("$Label.s2cor.Cancel"),
        	removeTagAssist: $A.get("$Label.s2cor.VF_Generic_Remove_Item"),
        	validateAssist: $A.get("$Label.s2cor.VF_Generic_Save_Changes"),
        	cancelAssist: $A.get("$Label.s2cor.VF_Generic_Cancel_Changes"),
        	validateSpinnerTest: $A.get("$Label.s2cor.VF_Generic_Validating"),
        	messageClose: $A.get("$Label.s2cor.VF_Generic_Close"),
        	errorMessage: $A.get("$Label.s2cor.VF_Error_One_Or_More"),
        	errorAssist: $A.get("$Label.s2cor.VF_Error"),
        	successMessage: $A.get("$Label.s2cor.VF_Bank_Reconciliation_Match_Success"),
        	successAssist: $A.get("$Label.s2cor.VF_Generic_Success"),
        	successUndo: $A.get("$Label.s2cor.VF_Generic_Undo"),
            listSuccessMessage: $A.get("$Label.s2cor.VF_Bank_Reconciliation_List_Match_Success"),
            detailsLink: $A.get("$Label.s2cor.VF_Generic_Details"),
        	detailsTitle: $A.get("$Label.s2cor.VF_Generic_Details"),
            errorMessageMultiple: $A.get("$Label.s2cor.VF_Error_Multiple_Dimension"),
        	errorMessageBlankTag: $A.get("$Label.s2cor.VF_Error_Blank_Dimension"),
        	closeAssist: $A.get("$Label.s2cor.VF_Generic_Close_Without_Save"),
        	allocationTitle: $A.get("$Label.s2cor.VF_Bank_Reconciliation_Allocation_Title"),
          split: $A.get("$Label.s2cor.VF_Bank_Reconciliation_Split"),
        	allocationInstructions: $A.get("$Label.s2cor.VF_Bank_Reconciliation_Allocation_Instructions"),
        	allocationTotalAmount: $A.get("$Label.s2cor.VF_Bank_Reconciliation_Allocation_Total"),
        	allocationRemainingAmount: $A.get("$Label.s2cor.VF_Bank_Reconciliation_Allocation_Remaining"),
      	}

        var cardListWrapper = component.find('cardListWrapper').elements[0];

        var list = Carbon.ReactDOM.render(
        	Carbon.React.createElement(Carbon.CardList, {
                labels:labels,
                UserLocale: locale,
            	items:journalItems,
                showBank: showBank,
                showStatus: !firstTabSelected,
                displaySuccessMessageForItem: displaySuccessMessageForItem,
                displayErrorMessageForItem: displayErrorMessageForItem,
                displaySuccess: displaySplit,
                errorDetails: errorDetails,
        	}),
        	cardListWrapper
      	);
        var paginationWrapper = component.find('pagination').elements[0];

        Carbon.ReactDOM.render(
        	Carbon.React.createElement(Carbon.Pagination, {
                offset: paginationOffset,
                limit: paginationLimit,
                totalResults: (journalItems ? journalItemsTotal : 0)
        	}),
        	paginationWrapper
      	);

        if (journal) {
            if (modified) {
            	list.setCardModified(journal, modified);
            }
            if (displaySplit) {
            	list.setCardModified(journal, false);
            	list.setCardValidating(journal, false);
            }
        }
        this.showJournalSpinner(component, false);
        this.fixIcons(component);
    },

    renderAvailableTags : function(component) {
        var locale = $A.get("$Locale.userLocaleLang");
        var availableTags = component.get("v.availableTags");
        var searchCriteria = component.get("v.searchCriteria");
        var dimensionId = component.get("v.dimensionId");
        var dimensionName = component.get("v.dimensionName");
        var sort = component.get("v.dimensionSort");
        var dimensions = this.generateDimensions(availableTags, sort);
        var labels = {
        	Amount: $A.get("$Label.s2cor.VF_Generic_Amount"),
          All: $A.get("$Label.s2cor.VF_Generic_All"),
          Date: $A.get("$Label.s2cor.VF_Generic_Date"),
          FilterOptions: $A.get("$Label.s2cor.VF_Generic_Filter_Options"),
          SearchCriteria: $A.get("$Label.s2cor.VF_Generic_Search_Criteria"),
          NoRecords: $A.get("$Label.s2cor.VF_Generic_No_Records")
        };

          Carbon.ReactDOM.render(
        	Carbon.React.createElement(Carbon.BRTL,{
                UserLocale: locale,
            	dimensions : dimensions,
                StartDateLabel : $A.get("$Label.s2cor.VF_Generic_Start_Date"),
                EndDateLabel : $A.get("$Label.s2cor.VF_Generic_End_Date"),
                headerText : $A.get("$Label.s2cor.VF_Bank_Reconciliation_Outstanding_Items"),
                dimensionFilter : {dimensionId:dimensionId,dimensionName:dimensionName},
                dimensionSort : sort,
                searchCriteria: searchCriteria,
                labels: labels
            }),
            component.find('tagsTable').elements[0]
      	);

        this.fixIcons(component);
    },

    addTagToJournalItem : function(component, journalItem, tag)
	{
        //Add the tag to the journal item:
        //1. First search to see if there is already a dimension in the journal item with a blank tag - and replace that with this one
        //2. Otherwise - add the tag
        var dimensionId = tag.dimensionId;
        var dimensionFound = false;
        var newTag = {
            balance: tag.balance,
			dimensionId: tag.dimensionId,
			dimensionName: tag.dimensionName,
			tagName: tag.tagName,
            tagId: tag.tagid,
        }

        for (var i = 0; i < journalItem.dimensions.length; i++)
        {
            if (journalItem.dimensions[i].dimensionId.toString() === dimensionId.toString())
            {
                if (journalItem.dimensions[i].tagId && journalItem.dimensions[i].tagId.toString() === newTag.tagId.toString())
                {
                    //This tag was already added to the journal item for this dimension
                    dimensionFound = true;
                }
                else if ((!journalItem.dimensions[i].tagId) || (journalItem.dimensions[i].tagId.length === 0))
                {
                    //The dimension exists - but the tag is blank
                    dimensionFound = true;
                }
            }
            if (dimensionFound)
            {
                journalItem.dimensions[i] = newTag;
                break;
            }
        }
        if (!dimensionFound)
        {
	        journalItem.dimensions.push(newTag);
        }
        //Remove the tag from the available tags
        var availableTags = component.get("v.availableTags");
 		var elementPos = availableTags.map(function(x) {return x.tagid; }).indexOf(tag.tagid);
   		if (elementPos >= 0) {
        	availableTags.splice(elementPos, 1);
        	component.set("v.availableTags", availableTags);
        }
        this.updateJournalItem(component, journalItem);
     	this.renderJournalItems(component, false, false, false, true, null);
        this.renderAvailableTags(component);
  	},

    tagRemovedFromJournalItem : function(component, journalItem)
	{
        this.updateJournalItem(component, journalItem);

        //Call server to get the list of available tags
        this.fireGetAvailableTags(component, journalItem);
	},

	updateJournalItem : function(component, journalItem)
	{
    	//Locate the journalItem in the list of journal items - and replace it
        var journalItems = component.get("v.journalItems");
		var elementPos = journalItems.map(function(x) {return x.id; }).indexOf(journalItem.id);
        if (elementPos >= 0) {
        	//var objectFound = journalItems[elementPos];
        	journalItems[elementPos] = journalItem;
        	component.set("v.journalItems", journalItems);
        }
        if (journalItem.selected) {
        	component.set("v.selectedJournalItem", journalItem);
        }
  	},

    prepareArrayForDropDown : function(anArray) {
        return anArray.map( function(x) {
            var y = x.Name ? x.Name : x;
            var z = x.Id ? x.Id : x;
            return {"label": y, "value": z};
        });
    },

    fixIcons : function(component) {
        var sageCarbonResource = component.get("v.sageCarbon");
        var sageCarbonResourcePath = '/resource/' + sageCarbonResource;
        var iconElements = document.getElementsByTagName("svg");
        if (iconElements)
        {
        	var len = iconElements.length;
			for (var i=0; i<len; ++i) {
            	var iconElement = iconElements[i];
            	this.fixSVG(sageCarbonResourcePath, iconElement);
 			}
        }
        var imageElements = document.getElementsByTagName("img");
        if (imageElements)
        {
        	len = imageElements.length;
          for (i=0; i<len; ++i) {
            	var imageElement = imageElements[i];
            	this.fixIMG(sageCarbonResourcePath, imageElement);
 			}
        }
    },

    fixSVG : function(sageCarbonResourcePath, svg) {
       	if (!svg) return;

        var hidden = svg.getAttribute('aria-hidden');
        if (hidden.toString() !== 'true') return;

   		var useNode = svg.firstElementChild;
        if (!useNode) return;

        //Replace the url
        var originalUrl = useNode.getAttribute('xlink:href');
        if (originalUrl.length > 0) {
            var start = originalUrl.substring(0, 8);
            if (start === "/assets/")
            {
				var imageURL = sageCarbonResourcePath + originalUrl;
 	        	useNode.setAttribute('xlink:href', imageURL);
		    	svg.setAttribute('aria-hidden', 'false');
            }
        }
    },

    fixIMG : function(sageCarbonResourcePath, img) {
       	if (!img) return;

        //Replace the url
        var originalUrl = img.getAttribute('src');
        if (originalUrl.length > 0) {
            var start = originalUrl.substring(0, 8);
            if (start === "/assets/")
            {
				var imageURL = sageCarbonResourcePath + originalUrl;
 	        	img.setAttribute('src', imageURL);
            }
        }
    },

    generateDimensions : function(availableTags, sort) {
      	var dimensions = [];
        if (!availableTags) {
            return dimensions;
        }

        var tagsCount = availableTags.length;

        for (var i = 0; i < tagsCount; i++)
        {
            var dimensionId = availableTags[i].dimensionId;
            var dimensionName = availableTags[i].dimensionName;

            var dimension = this.findByDimensionId(dimensions, dimensionId);
            if (!dimension)
            {
                dimension = {
                    dimensionId: dimensionId,
                    dimensionName: dimensionName,
                    items : [availableTags[i]]
                };
                dimensions.push(dimension);
            }
            else
            {
                dimension.items.push(availableTags[i]);
            }
        }

        for (i = 0; i < dimensions.length; i++)
        {
            if (sort.toString() === "Amount")
            {
       	     	dimensions[i].items.sort(function(a, b){return a.amountDistance-b.amountDistance});
            }
            else
            {
       	     	dimensions[i].items.sort(function(a, b){return a.dateDistance-b.dateDistance});
            }
        }

        return dimensions;
    },

    findByDimensionId : function(source, id) {
    	return source.filter(function( obj ) {
        	return obj.dimensionId.toString() === id.toString();
    	})[ 0 ];
    }
})