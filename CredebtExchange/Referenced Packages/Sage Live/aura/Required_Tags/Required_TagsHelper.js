({
    renderComponent:function(component, event, helper)
    {
        component.set("v.error",false);
        component.set("v.errorMessage",'');
        var tagsHitCount = component.get("v.tagsHitCount");
        component.set("v.tagsHitCount", ++tagsHitCount);

        component.set("v.loaded",false);
        component.set("v.requiredDimsCount",0);

        var renderType = component.get("v.parameterDTO.renderType");
        var type = component.get("v.parameterDTO.type");
        var postingRuleType = component.get("v.parameterDTO.postingRuleType");
        var itemType = component.get("v.parameterDTO.itemType");
        var suppliedTags = component.get("v.parameterDTO.suppliedTags");
        var showOptional = component.get("v.parameterDTO.showOptional");
        var tagsBucket = component.get("v.tagsBucket");
        if (showOptional == null)
            showOptional = false;

        if (postingRuleType == 'Header' || postingRuleType == 'Item')
        {
            var bucket = {};
            for (var i in tagsBucket)
            {
                bucket[i] = tagsBucket[i];
            }

            bucket["USEME"] = suppliedTags;

            var params = {
                "renderType": renderType,
                "type": type,
                "postingRuleType": postingRuleType,
                "itemType": itemType,
                "showOptional": showOptional,
                "tagsBucket": bucket
            };

            helper.callServer(component,'c.doInitApex', function(response)
            {
                helper.createSelectLists(component, event, helper,response,suppliedTags, tagsBucket);
            }, params, false, function(result)
            {
                component.set("v.error",true);
                component.set("v.theErrorMessage",result);
                // remove the spinner
                component.set("v.loaded",true);
            });
        }
        else
        {
            // TODO errors the postingRuleType is not valid so we can't lookup against it
            // This would only be hit if the parent component passed in the wrong type
        }
    },
    createSelectLists:function(component, event, helper, response, suppliedTags, tagsBucket)
    {
        // this is what will be output to the v.body
        var content = [];

        var suppliedTagIdsByDim = {};
        // create the supplied tags map
        var suppliedMap = JSON.parse(suppliedTags);

        var dims = response.allDimensions;
        var optionalDims = response.optionalDimensions;

        // parse the Map<String,List<Map<String,String>>>
        var map = JSON.parse(response.tagSelectLists);
        // Loop through the Map
        for (var i = 0; i < dims.length; i++)
        {
            // This is the Tag tag.Dimension__r.Key__c that is returned from  Sage_ACC_Journal_Helper.GetCompulsoryDimensions
            var dim = dims[i];

            // Get the List<Map<String,String> from the outer map
            var data = map[dim];

            // get the supplied tag based on the dim we are looking at
            var suppliedTagsForDim = null
            if (suppliedMap != null && suppliedMap.hasOwnProperty(dim) )
            {
                suppliedTagsForDim = suppliedMap[dim];
            }

            // make this a function
            // this gets the mode of the drop down list e.g. EDIT/READONLY/HIDE
            var dropDownMode = 'EDIT'; // by default
            if (suppliedTagsForDim != null)
            {
                for(var propName in suppliedTagsForDim)
                {
                    suppliedTagIdsByDim[dim] = propName;

                    if(suppliedTagsForDim.hasOwnProperty(propName))
                    {
                        var dropDownMode = suppliedTagsForDim[propName];
                    }
                }
            }
            // if this select list exists in optionalDims then set it as optional.
            var requiredSelectList =  (optionalDims != null ? (optionalDims.indexOf(dim) == -1 ? true : false)  : true);
            // If there is data in the list i.e. there could be required dimensions that do not have any tags in the Org
            if (data != null)
            {
                // create a lightning:select
                var aId = (requiredSelectList ? "requiredTagSelect" : "optionalTagSelect");

                $A.createComponent(
                    "lightning:select",
                    {
                        "aura:id": aId,
                        "label": dim,
                        "onchange": component.getReference("c.handleChangeSelect"), // add an onchange event
                        "required": requiredSelectList,
                        "class": (dropDownMode == 'HIDE' ? 'slds-hide' : '')
                    },
                    function(newSelect, status, errorMessage)
                    {

                        // if the select was created add the options
                        if (status === "SUCCESS")
                        {
                            var listOptions = [];
                            var defaultVal = '-1';
                            var itemTagName;

                            // itemTagName is needed to set defaulVal to the tag in the tagsBucket
                            for (var bucketDim in tagsBucket) {

                                var key = bucketDim

                                bucketDim = bucketDim.replace('Header.[', '');
                                bucketDim = bucketDim.replace('Item.[', '');
                                bucketDim = bucketDim.replace(']', '');

                                if (bucketDim == dim)
                                {
                                    itemTagName = tagsBucket[key];

                                    break;
                                }
                            }

                            // loop through each of the List items in data, these are the select options key and value
                            data.forEach(function (opt)
                            {
                                // Create a drop down for each of the options
                                $A.createComponent(
                                 'aura:html',
                                 {
                                     tag: 'option',
                                     HTMLAttributes: {
                                         value: opt.key,
                                         text: opt.value
                                     }
                                 },
                                 // Add the drop down to the body of the select list
                                 function (newOption)
                                 {
                                     //Add options to the body
                                     if (newOption.isValid())
                                     {
                                        listOptions.push(newOption);
                                     }
                                 });

                                 if (itemTagName == opt.value)
                                 {
                                     defaultVal = opt.key;
                                     suppliedTagIdsByDim[dim] = opt.key;
                                 }

                                 if (defaultVal == '-1')
                                 {
                                    // never try to match the selected tag if the option is -1 (please select)
                                    // or dont try to match if there were no tags supplied for this required dim
                                    if (opt.key != '-1' && suppliedTagsForDim != null)
                                    {
                                        if (suppliedTagsForDim[opt.key] != null)
                                        {
                                            defaultVal = opt.key;
                                        }
                                    }
                                }
                             });

                             // set the select options in one call
                             newSelect.set("v.body",listOptions);
                             newSelect.set('v.value', defaultVal);
                             newSelect.set('v.disabled', (dropDownMode != null && dropDownMode == 'READONLY' ? true : false)); // disabled is readonly in the UI
                            // add the select list to the select list array to add to the component later
                            if (newSelect.isValid())
                            {
                                content.push(newSelect);
                            }
                        }
                    }
                );
            }
            else
            {
                // only show the error if the dropdown mode is edit
                if (dropDownMode == "EDIT")
                {
                    var noTagText =  $A.get("$Label.s2cor.No_Tags_Dropdown") + ' ' + dim + '.';
                    // there isn't any tags for this dimension add a link to it
                    // create a div with style
                    $A.createComponent("aura:html", {"tag":"p", "body":noTagText, "HTMLAttributes":{"id":"noTag-"+dim}},
                                function(noTagDiv, status)
                                {
                                    if (noTagDiv.isValid())
                                    {
                                        content.push(noTagDiv);
                                    }
                                }
                    );
                }
            }
            // to count if the select list is required or not for validation purposes later
            if (dropDownMode != 'HIDE' && requiredSelectList == true)
            {
                var currentRequiredCount = component.get("v.requiredDimsCount");
                var newCurrentRequiredCount = (currentRequiredCount + 1);
                component.set("v.requiredDimsCount",newCurrentRequiredCount);
            }
        }

        component.set("v.body", content);

        // set the ids of the supplied tags to the component variable
        if (Object.keys(suppliedTagIdsByDim).length > 0)
        {
            var ids = Object.keys(suppliedTagIdsByDim).map(function(key){ return suppliedTagIdsByDim[key] });
            component.set("v.tagIds", ids);
        }
        helper.checkRequiredSelectLists(component, event, helper);
        component.set("v.loaded",true);
    },
    buildTagListFromIds:function(component, event, helper)
    {
       var tagIds = component.get("v.tagIds");

       if (tagIds != null)
       {
            var params = { tagIds: JSON.stringify(tagIds) };

            helper.callServer(component,'c.getTagsAsMap', function(response)
            {
                var tags = response;
                var oldTags = component.get("v.tagsToReturn");
                var newTagIds = helper.createTagIdsSet(component, event, helper, tags);
                var oldTagsIds= helper.createTagIdsSet(component, event, helper, oldTags);
                var tagsChanged = !helper.eqSet(component, event, helper, newTagIds, oldTagsIds);

                if (tagsChanged)
                {
                    component.set("v.tagsToReturn",tags);
                }

                // do the required check after the tags call
                helper.checkRequiredSelectLists(component, event, helper);
            }, params, false, function(result)
            {
                component.set("v.error",true);
                component.set("v.theErrorMessage",result);
                // remove the spinner
                component.set("v.loaded",true);
            });
       }
    },
    createTagIdsSet:function(component, event, helper, tags)
    {
        let set = new Set();
        if (tags == undefined || tags.length <= 0)
            return set;

        for (var i = 0; i < tags.length; i++)
        {
            if (tags[i].Id != undefined)
                set.add(tags[i].Id);
        }

        return set;
    },
    eqSet:function(component, event, helper, newTagIds, oldTagsIds) {

        return newTagIds.size === oldTagsIds.size && all(isIn(oldTagsIds), newTagIds);

        function all(pred, as) {
           for (var a of as) if (!pred(a)) return false;
           return true;
        }

        function isIn(as) {
           return function (a) {
               return as.has(a);
           };
        }
    },
    setTagIdsFromSelectLists:function(component, event, helper)
    {
        var tagsHitCount = component.get("v.tagsHitCount");
        component.set("v.tagsHitCount", ++tagsHitCount);

        var newTagIds = [];
        // get all the select lists
        var selects = component.find({ instancesOf : "lightning:select" });

        if (selects != null)
        {
            for (var i = 0; i < selects.length; i++)
            {
                var select = selects[i];
                var listVal = select.get("v.value");
                if (listVal != null && listVal != '-1') // if it hasn't been selected then don't include it
                {
                    // add it to the array
                    newTagIds.push(listVal);
                }
            }
        }
        if (newTagIds != null)
        {
            // update the component attribute that will trigger the handler "change" for value="{!v.tagIds}"
            component.set("v.tagIds", newTagIds);
        }
    },
    checkRequiredSelectLists:function(component, event, helper)
    {
        var currentRequiredCount = component.get("v.requiredDimsCount");
        var validSelectCount = 0;
        var selects = component.find({ instancesOf : "lightning:select" });
        for (var i = 0; i < selects.length; i++)
        {
            var select = selects[i];
            if (select.isValid())
            {
                var listVal = select.get("v.value");
                if (listVal != null && listVal != '-1') // if it hasn't been selected then don't include it
                {
                    if (select.get("v.required"))
                    {
                        // only count drop downs you can see
                        if (select.get("v.class") != "slds-hide")
                        {
                            validSelectCount = (validSelectCount + 1);
                        }
                    }
                }

            }
        }
        if (currentRequiredCount == validSelectCount)
        {
            component.set("v.allSelected", true);
        }
        else
        {
            component.set("v.allSelected", false);
        }
    }
})