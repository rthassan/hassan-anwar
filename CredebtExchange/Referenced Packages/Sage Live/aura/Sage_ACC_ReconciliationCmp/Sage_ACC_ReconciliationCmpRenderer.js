({
    afterRender: function(component, helper) {
        var concreteComponent = component.getConcreteComponent();
        helper.registerSelectItemHandler(concreteComponent);
        helper.registerJournalItemDimensionTypeChangedHandler(concreteComponent);
        helper.registerSelectAvailableTagHandler(concreteComponent);
        helper.registerTagRemovedFromJournalItemHandler(concreteComponent);
        helper.registerValidateJournalItemHandler(concreteComponent);
        helper.registerCancelJournalItemHandler(concreteComponent);
        helper.registerChangeFilterHandler(concreteComponent);
        helper.registerDoneClickedFilterHandler(concreteComponent);
        helper.registerClearClickedFilterHandler(concreteComponent);
        helper.registerChangeDatedFilterHandler(concreteComponent);  
        helper.registerMenuOptionChangedHandler(concreteComponent);
        helper.registerTransactionTabHandler(concreteComponent);
        helper.registerSearchCriteriaChangedHandler(concreteComponent);
        helper.registerCardListIconsChangedHandler(concreteComponent);
        helper.registerJournalSearchHandler(concreteComponent);
        helper.registerSelectLookupMenuItemHandler(concreteComponent);
        helper.registerOffsetChangedHandler(concreteComponent);
 	    this.superAfterRender();
  	},
})