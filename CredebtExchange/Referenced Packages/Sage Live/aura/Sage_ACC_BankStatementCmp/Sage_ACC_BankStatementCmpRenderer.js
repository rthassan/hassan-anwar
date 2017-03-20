({
	afterRender: function(component, helper) {
			var concreteComponent = component.getConcreteComponent();
			helper.registerGetFeedBrokersHandler(concreteComponent);
			helper.registerGetFeedsHandler(concreteComponent);
		this.superAfterRender();
	},
})