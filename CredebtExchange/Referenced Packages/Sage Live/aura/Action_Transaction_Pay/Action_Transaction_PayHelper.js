({
    onAccept : function(component, event) {
        this.payTransaction(component, event);
    },
    doInit: function(component, event, helper) {
        helper.initBind(component,helper);

        var ids = component.get('v.recordIds');
        if (ids.length < 1) { ids=[component.get("v.recordId")]; }

        var params = {transactionIDs : ids};

        helper.callServer(component,'c.preparePaymentModal', function(response){
            component.set("v.errors", response.errorStrings);
            component.set("v.paymentDate", response.paymentDate);
            component.set("v.journalTypeOptions", response.journalTypeOptions);
            component.set("v.payJournalTypeId", response.payJournalTypeId || '-1');
            component.set("v.journalTypeItemDimensionOptions", response.journalTypeItemDimensionOptions);
            component.set("v.payJournalTypeItemDimensionTagId", response.payJournalTypeItemDimensionTagId || '-1');
            component.set("v.existingTags", response.existingTags);
            component.set("v.documentLabel", response.documentLabel);
            component.set("v.payJournalTypeItemDimension", response.payJournalTypeItemDimension);
            component.set("v.innerPayments", response.innerPayments);
            component.set("v.payJournalType",response.payJournalType);
            component.set("v.payJournalTypeItemDimensionTag", helper.getOptionsLabel(response.journalTypeItemDimensionOptions, response.payJournalTypeItemDimensionTagId));

            var cmpJournalTypeItemSelect = component.find('journalTypeItemSelect');
            var divPayments = component.find('divPayments');
            var divInnerPayments = component.find('divInnerPayments');

            $A.util.addClass(cmpJournalTypeItemSelect, 'slds-hide');
            $A.util.addClass(divPayments, 'slds-hide');
            $A.util.addClass(divInnerPayments, 'slds-hide');

            if (helper.validateCurrencies(component,event,helper))
            {
                var amountLabel = response.innerPayments.currencySymbol ? $A.get("$Label.s2cor.VF_Generic_Amount") : $A.get("$Label.s2cor.VF_Generic_Amount") + ' (' + response.innerPayments[0].currencySymbol  + ')';
                component.set("v.amountLabel", amountLabel);

                $A.util.removeClass(divPayments, 'slds-hide');

                helper.populateDTOs(component,event,helper);

                if (response.innerPayments.length <= 10)
                {
                    $A.util.removeClass(divInnerPayments, 'slds-hide');
                }

                if (response.payJournalType != null && response.payJournalTypeItemDimension != null)
                {
                    $A.util.removeClass(cmpJournalTypeItemSelect, 'slds-hide');
                }
            }

            helper.togglePayButton(component,event,helper);
        }, params);
    },
    changeJournalType: function(component,event,helper){
        component.set("v.tagsHitCount",0);
        component.set("v.payJournalType",helper.getOptionsLabel(event.target.options, event.target.value));
        component.set('v.payJournalTypeItemDimension', ' ');
        component.set('v.journalTypeItemDimensionOptions', []);
        component.set('v.payJournalTypeItemDimensionTag', '');
        component.set('v.payJournalTypeItemDimensionTagId', '-1');

        var payJournalTypeId = component.get('v.payJournalTypeId');
        var cmpJournalTypeItemSelect = component.find('journalTypeItemSelect');

        $A.util.addClass(cmpJournalTypeItemSelect, 'slds-hide');

        if (payJournalTypeId == '-1')
        {
            helper.populateDTOs(component,event,helper);
            return;
        }

        var params = {"paymentJournalTypeId": payJournalTypeId};

        helper.callServer(component,'c.getJournalTypeItemDimensionOptions', function(response)
        {
            var payJournalTypeItemDimension = response.payJournalTypeItemDimension;
            component.set('v.payJournalTypeItemDimension', payJournalTypeItemDimension);
            component.set('v.journalTypeItemDimensionOptions', response.journalTypeItemDimensionOptions);

            if (payJournalTypeItemDimension != undefined)
            {
                $A.util.removeClass(cmpJournalTypeItemSelect, 'slds-hide');
            }

            helper.populateDTOs(component,event,helper);
        }, params);
    },
    changeItemTags:function(component,event,helper){
        component.set("v.tagsHitCount",1);  // Needs to be reset to 1 as dtoHeader is not being rebuild.  This work is part of the anti disco modal screen movement.
        component.set("v.payJournalTypeItemDimensionTag",helper.getOptionsLabel(event.target.options, event.target.value));
        helper.populateDtoItem(component,event,helper);
    },
    tagsChanged: function(component,event,helper)
    {
        if (component.get('v.tagsHitCount') > 2)
        {
            var tagsBucket = {}
            var itemTags = component.get('v.itemTags');
            var headerTags = component.get('v.headerTags');

            for (i = 0; i < itemTags.length; i++)
            {
                tagsBucket["Item.[" + itemTags[i].Dimension__r.Name + "]"] = itemTags[i].Name;
            }

            for (j = 0; j < headerTags.length; j++)
            {
                tagsBucket["Header.[" + headerTags[j].Dimension__r.Name + "]"] = headerTags[j].Name;
            }

            component.set('v.tagsBucket', tagsBucket);
        }
    },
    validateCurrencies:function(component,event,helper){
        var innerPayments = component.get('v.innerPayments');

        if (innerPayments == undefined || innerPayments.length <= 0)
            return false;

        var previousCurrencyCode = innerPayments[0].currencyCode;

        for (var i = 1; i < innerPayments.length; i++)
        {
            if (innerPayments[i].currencyCode != previousCurrencyCode)
            {
                var errors = component.get('v.errors');
                errors.push($A.get("$Label.s2cor.Currency_Mismatch"));
                component.set('v.errors', errors);

                return false;
            }
            previousCurrencyCode = innerPayments[i].currencyCode;
        }

        return true;
    },
    getOptionsLabel:function(options, value){
        if (value == undefined || value == "-1" || options == undefined || options.length == 0)
            return;

        for (var i = 0; i < options.length; i++)
        {
            if (options[i].value == value)
            {
                return options[i].text;
            }
        }
    },
    togglePayButton:function(component,event,helper){
        var validHeaderTags = component.get("v.allHeaderRequiredTagsSelected");
        var validItemTags = component.get("v.allItemRequiredTagsSelected");
        var validJournalTypeItemDimensionTagId = (component.get("v.payJournalTypeItemDimensionTagId") != undefined && component.get("v.payJournalTypeItemDimensionTagId") != '-1');
        var validPayJournalTypeId = (component.get("v.payJournalTypeId") != undefined && component.get("v.payJournalTypeId") != '-1');
        var noItemDimension = (component.get("v.payJournalTypeItemDimension") == undefined || component.get("v.payJournalTypeItemDimension") == ' ');

        var innerPayments = component.get("v.innerPayments");
        var validInnerPayments = false;

        for (var i = 0; i < innerPayments.length; i++)
        {
            if (parseFloat(innerPayments[i].paymentAmount) > 0 && parseFloat(innerPayments[i].paymentAmount) <= parseFloat(innerPayments[i].maxOutstanding))
            {
                validInnerPayments = true;
            }
            else
            {
                validInnerPayments = false;
                break;
            }
        }

        var readyToPay = ((validHeaderTags && validPayJournalTypeId && validItemTags && validInnerPayments) && (validJournalTypeItemDimensionTagId || noItemDimension)) ? true : false;
        helper.toggleAccept(component, readyToPay);
    },
    populateDTOs: function(component,event,helper){
        helper.populateDtoHeader(component,event,helper);
        helper.populateDtoItem(component,event,helper);
    },
    populateDtoHeader: function(component,event,helper) {
        component.set("v.dtoHeader", {'renderType': 'Input'
                                        ,'type': component.get("v.payJournalType")
                                        ,'postingRuleType' : 'Header'
                                        ,'suppliedTags' : component.get("v.existingTags")
                                        ,'showOptional' : true});
    },
    populateDtoItem: function(component,event,helper){
        component.set("v.dtoItem", {'renderType': 'Input'
                                          ,'type': component.get("v.payJournalType")
                                          ,'itemType' :  component.get("v.payJournalTypeItemDimensionTag")
                                          ,'postingRuleType' : 'Item'
                                          ,'suppliedTags' : component.get("v.existingTags")
                                          ,'showOptional' : true});
    },
    payTransaction: function(component, event, helper) {
        var cmpSpinner = component.find('spinner');
        $A.util.removeClass(cmpSpinner, 'slds-hide');

        this.toggleAccept(component, false);

        var paymentDate = component.get('v.paymentDate');
        var innerPayments = component.get('v.innerPayments');
        var headerTags = component.get('v.headerTags') == undefined ? component.get("v.existingTags") : component.get('v.headerTags');
        var itemTags = component.get('v.itemTags');
        var payJournalTypeId = component.get('v.payJournalTypeId');
        var payJournalType = component.get('v.payJournalType');

        var buckets = [];
        var errorStrings = [];

        if (innerPayments == undefined || innerPayments.length <= 0)
        {
            errorStrings.push($A.get("$Label.s2cor.No_payment_specified"));
        }
        else
        {
            for (i = 0; i < innerPayments.length; ++i)
            {
                if (isNaN(innerPayments[i].paymentAmount))
                {
                    errorStrings.push(innerPayments[i].documentNumber + ': ' + $A.get("$Label.s2cor.amount_not_a_number"));
                    continue;
                }

                if (parseFloat(innerPayments[i].paymentAmount) > parseFloat(innerPayments[i].maxOutstanding))
                {
                    errorStrings.push(innerPayments[i].documentNumber + ': ' + $A.get("$Label.s2cor.amount_exceeded") + ' '+ innerPayments[i].maxOutstanding);
                    continue;
                }

                if (parseFloat(innerPayments[i].paymentAmount) < 0)
                {
                    errorStrings.push(innerPayments[i].documentNumber + ': ' + $A.get("$Label.s2cor.invalid_amount"));
                    continue;
                }

                if (parseFloat(innerPayments[i].paymentAmount) == 0)
                {
                    errorStrings.push(innerPayments[i].documentNumber + ': ' + $A.get("$Label.s2cor.amount_required"));
                    continue;
                }

                var bucket = {}
                bucket["payJournalTypeId"] = payJournalTypeId;
                bucket["Item.Amount__c"] = innerPayments[i].paymentAmount;
                bucket["Currency"] = innerPayments[i].currencyCode;
                bucket["Header.Date__c"] = paymentDate;
                bucket["Item.Date__c"] = paymentDate;
                bucket["Item.Type"] = component.get('v.payJournalTypeItemDimensionTag');

                for (j = 0; j < headerTags.length; j++)
                {
                    bucket["Header.[" + headerTags[j].Dimension_UID__c + "]"] = innerPayments[i][headerTags[j].Dimension_UID__c] || headerTags[j].Name;
                }

                for (j = 0; j < itemTags.length; j++)
                {
                    bucket["Item.[" + itemTags[j].Dimension_UID__c + "]"] = innerPayments[i][itemTags[j].Dimension_UID__c] || itemTags[j].Name;
                }

                buckets.push(bucket);
            }
        }

        if (errorStrings.length > 0)
        {
            component.set("v.errors", errorStrings)
            return;
        }

        var params = { "strBuckets" : JSON.stringify(buckets)};

        this.callServer(component,'c.payDocument', function(response){
            if (response.length == 0)
            {
                this.showToast(component,$A.get("$Label.s2cor.Payment_was_successful"),"success");
                return;
            }

            component.set('v.errors',response);
            this.toggleAccept(component, true);
        }, params);
    }
})