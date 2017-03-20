({
	doInit : function(component, event, helper) {
		var body = document.getElementsByTagName("body");
		if (body) {
		    body = body[0];
		    if (body) {
		        body.style.height="100%";
		    }
		}

		var bankFeedIdParam = component.get("v.bankFeedIdParam");
        var bankFeedNameParam = component.get("v.bankFeedNameParam");
        var feedBrokerIdParam = component.get("v.feedBrokerIdParam");
        var feedBrokerNameParam = component.get("v.feedBrokerNameParam");

        if (bankFeedIdParam && bankFeedIdParam.length > 0 && bankFeedNameParam && bankFeedNameParam.length > 0 &&
		feedBrokerIdParam && feedBrokerIdParam.length > 0 && feedBrokerNameParam && feedBrokerNameParam.length > 0) {
		     component.set("v.feedName", {"label": bankFeedNameParam, "value": bankFeedIdParam});
		     component.set("v.feedNames", {"label": bankFeedNameParam, "value": bankFeedIdParam});
		     component.set("v.feedBrokers", {"label": feedBrokerNameParam, "value": feedBrokerIdParam});
		     component.set("v.feedType", {"label": feedBrokerNameParam, "value": feedBrokerIdParam});
		     helper.fireGetBankStatement(component);
		}
		else {
		    helper.fireGetBankFeedTypes(component);
		}
	},
	onFeedTypeChanged : function(component, event, helper) {
		component.set("v.feedType", event.getParam("feedType"));
		component.set("v.feedNames", []);
		component.set("v.feedName", null);
		component.set("v.accountTag", []);
		component.set("v.bankStatement", null);
		helper.fireGetBankFeedNames(component);
	},
	onFeedNameChanged : function(component, event, helper) {
		component.set("v.feedName", event.getParam("feedName"));
		helper.fireGetBankStatement(component);
	}
})