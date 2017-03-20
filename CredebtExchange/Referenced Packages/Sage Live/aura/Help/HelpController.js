/**
 * Created by marc.albaladejo on 14/10/2016.
 */
({
     doInit: function(component,event,helper){
     },

     handle_knowledge_onclick: function(component, event, helper) {
        helper.callServer(component,'c.getHelpUrl', function(response) {
            window.open(response,'_blank');
        },null,true);

        //window.open(component.get('v.kBaseUrl'),'_blank');
     },

     startMonitoringBatch : function (component, event, helper) {
         var batchId = event.getParam("batchId");
         var description = event.getParam("description");
         var userId = event.getParam("userId");
         var now = Math.floor(Date.now() / 1000);

         var batches = component.get("v.batches");

         // start monitoring if isn't already
         if (batches.length == 0) helper.monitorBatches(component, helper);

         batches.push({'id' : batchId, 'description' : description, 'userId' : userId, 'started' : now });
         component.set('v.batches', batches);

         console.log('Monitoring Batch: '  + batchId);
     }
})