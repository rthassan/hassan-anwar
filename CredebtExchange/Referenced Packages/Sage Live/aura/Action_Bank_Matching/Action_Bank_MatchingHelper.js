/**
 * Created by Josh.Hunter on 20/12/2016.
 */
({
   doInit : function (component)
   {
       this.initBind(component, this);
       var ids = this.getRecordIds(component);
       console.log(ids);

       //Record-level action
       if (ids.length == 1) {
           this.callServer(component, 'c.getMatchingFeeds', function(response) {
               console.log("c.getMatchingFeeds response:");

               feeds = JSON.parse(response);
               component.set('v.feeds', feeds);

               if (feeds.length > 1){
                    //Display the available feeds in a drop-down list.
                    component.set('v.showFeedSelector', true);
               }
               else if (feeds.length == 1) {
                   component.set("v.selectedFeed", feeds[0].id);
                   this.changeSelectedFeed(component);
                   this.onAccept(component);
               }
               else {
                   this.showToast(
                       component,
                       $A.get("$Label.s2cor.No_Feeds_Available"),
                       "error"
                   );
               }
               this.hideSpinner(component);
               },
               {
                "bankIds": ids
               });
       }
       //Global action
       else {
           //TODO: Stuff here for global Bank Matching action (if ever..)
       }
   },
   onAccept : function (component, event)
   {
       component.set('v.acceptEnabled', false);
       var feed = component.get('v.selectedFeed');

       this.callServer(component, 'c.getBankMatchingURL', function(response) {
           console.log("c.getBankMatchingURL response:" + response);
           var url = response;
           var urlEvent = $A.get("e.force:navigateToURL");
           urlEvent.setParams({
               "url" : url
           });

           urlEvent.fire();
       },
       {
           "feedId": feed
       });
   },
   changeSelectedFeed : function (component)
   {
       var selectedFeed = component.get("v.selectedFeed");
       if (selectedFeed != '') {
           component.set('v.acceptEnabled', true);
       }
       else {
           component.set('v.acceptEnabled', false);
       }
       this.hideSpinner(component);
   }
})