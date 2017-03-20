({
	doInit : function(component, event, helper) {
        //The following is a hack to get the scrolling to work when the page is accessed from the mobile.
        //var body = document.getElementsByTagName("body");
        //if (body)
        //{
        //   body = body[0];
        //    if (body)
        //    {
        //        body.style.height="100%";
        //    }
        //}
        component.set("v.firstTabSelected", true);
        component.set("v.dimensionSort", "Amount");
        component.set("v.dimensionId", "");
        component.set("v.dimensionName", "All");

        helper.fireGetClassifications(component);
    },    

    onCardListIconsChanged : function(component, event, helper) {
    	helper.fixIcons(component);    
    },
    
    onJournalItemDimensionTypeChanged : function(component, event, helper) {
        var item = event.getParam("item");
        component.set("v.selectedJournalItem", item);
        component.set("v.searchCriteria", null);
        helper.fireReprocessJournalItem(component);
    },
    
    onJournalItemSelected : function(component, event, helper) {
        var item = event.getParam("item");
        var selectedItem = component.get("v.selectedJournalItem");
        
        //Only request the available tags if they have changed the journal item that is selected
        if (selectedItem && item && (item.id.toString() === selectedItem.id.toString())) return;
        
        component.set("v.selectedJournalItem", item);
        helper.fireGetAvailableTags(component, item, helper);
    },
    
    onValidateJournalItem : function(component, event, helper) {
        var item = event.getParam("item");
				var split = event.getParam("split");
        helper.fireValidateJournalItem(component, item, split);
    },
    
    onCancelJournalItem : function(component, event, helper) {
        var item = event.getParam("item");
        helper.fireCancelJournalItem(component, item);
    },
    
    onChangeFilter: function(component, event, helper) {
        var detail = event.getParam("filterValue");
        var filterNumber = parseInt(event.getParam("filterNumber"),10);
        //var detailValue = detail ? detail.label : "";
        if ( filterNumber === 1) {
            component.set("v.classification", {"label": detail.label, "value": detail.value});
            component.set("v.journalType", null);
            component.set("v.journals", null);
            component.set("v.journalSearchValue", null);
            component.set("v.journalList", null);
            
            var classification= detail.value;
            helper.fireGetJournalTypes(component, classification);
        }
        if ( filterNumber === 2) {
            component.set("v.journalType", {"label": detail.label, "value": detail.value});
            component.set("v.journals", null);
            component.set("v.journalSearchValue", null);
            component.set("v.journalList", null);
       }
        if ( filterNumber === 3) {
            component.set("v.journalSearchValue", null);
            component.set("v.journals", detail);
        }
        if ( filterNumber === 4) {
            component.set("v.startDate",detail);
        } 
        if ( filterNumber === 5) {
            component.set("v.endDate",detail);
        } 
        if ( filterNumber === 6) {
            helper.fixIcons(component);
        }
    },
    
    onDoneClickedFilter: function(component, event, helper) {
        var journals = component.get("v.journals");
        helper.fireGetJournalItems(component, journals, false, 0); 
    }, 

    onClearClickedFilter: function(component, event, helper) {
      component.set("v.journalItems", null);
      component.set("v.journals", null);
      component.set("v.journalType", null);
      component.set("v.journalSearchValue", null);
      component.set("v.journalList", null);
      
      helper.renderFilterHeader(component);
    }, 
 
    onTransactionTabChanged: function(component, event, helper) {
        var firstTabSelected = event.getParam("firstTabSelected");
        var currentFirstTabSelected = component.get("v.firstTabSelected");
        if (firstTabSelected.toString() === currentFirstTabSelected.toString()) {
            return;
        }
        component.set("v.firstTabSelected", firstTabSelected);
        var journals = component.get("v.journals")
        if (journals && journals.length > 0)
        {
        	helper.fireGetJournalItems(component, journals, false, 0);
        }
    },
    
    onMenuOptionChanged: function(component, event, helper) {
        var dimensionId = event.getParam("dimensionId");
        var dimensionName = event.getParam("dimensionName");
        
        component.set("v.dimensionId", dimensionId);
        component.set("v.dimensionName", dimensionName);
 
        var sort = event.getParam("sort").toString();
        var currentSort = component.get("v.dimensionSort").toString();
    	
        if (sort !== currentSort)
        {
            component.set("v.dimensionSort", sort);
            helper.renderAvailableTags(component);
        }
        else
        {
	    	helper.fixIcons(component);
        }
    },
    
    onSearchJournal: function(component, event, helper) {
    	var searchValue = event.getParam("searchValue");
        var currentSearchValue = component.get("v.journalSearchValue");
        if (searchValue === currentSearchValue) {
            return;
        }
        component.set("v.journalSearchValue", searchValue);
        
        if ((searchValue === null) || (searchValue.length < 2) )
        {
            component.set("v.journalList", null);
            component.set("v.journals", null);
            helper.renderFilterHeader(component);
			return;    
        }
        
        //Call server to get the list of journals matching this search criteria
        var journalType = component.get("v.journalType");
        helper.fireGetJournals(component, journalType.value);
	},
    
    onSelectLookupMenuItem: function(component, event, helper) {
    	var searchValue = event.getParam("searchValue");
        component.set("v.journalSearchValue", searchValue);
        
        if ((searchValue === null) || (searchValue.length < 2) )
        {
            component.set("v.journalList", null);
            component.set("v.journals", null);
            helper.renderFilterHeader(component);
			return;    
        }
        
        //Call server to get the list of journals matching this search criteria
        var journalType = component.get("v.journalType");
        helper.fireGetJournalsFromMenu(component, journalType.value);
	},
    
    onOffsetChanged: function(component, event, helper) {
        var offset = event.getParam("offset");
        
        //Call server to get the list of journal items matching this search criteria (with offset)
        var journals = component.get("v.journals")
        if (journals && journals.length > 0)
        {
        	helper.fireGetJournalItems(component, journals, false, offset);
        }
    },
    
    onSearchCriteriaChanged: function(component, event, helper) {
        var searchCriteria = event.getParam("searchCriteria");
        var currentSearchCriteria = component.get("v.searchCriteria");
        if (searchCriteria === currentSearchCriteria) {
            return;
        }
        component.set("v.searchCriteria", searchCriteria);
	    //Call server to get the list of available tags matching this search criteria
	    var item = component.get("v.selectedJournalItem");
        if (item)
        {
    	    helper.fireGetAvailableTags(component, item, helper);
	    }
  	},
    
    onAvailableTagSelected: function(component, event, helper) {
        var item = event.getParam("item");
        var tag = event.getParam("tag");
        helper.addTagToJournalItem(component, item, tag);
    },
    
    onTagRemovedFromJournalItem: function(component, event, helper) {
        var item = event.getParam("item");
        helper.tagRemovedFromJournalItem(component, item);
	},   
})