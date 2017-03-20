/**
 * Created by daniel.nicholson on 16/08/2016.
 */
({
    handleCustomSetting : function(component) {
        //console.log('DN: Full_List_View.handleCustomSetting()');
        var listView = component.get('v.listView');
        //console.log('mm ' + component.get('v.SObjectType'));
        if (component.get('v.SObjectType') != null ){
            var params = {"sObjectType" : component.get('v.SObjectType'),
                                         "UID" : component.get('v.UID')};
            if (listView == null) {
                //console.log('getting');
                this.callServer(component,'c.getListView', function(response) {
                    //console.log('DN: Full_List_View.handleCustomSetting() getter response: ' + response);
                    component.set('v.listView',response);
                    component.set('v.title', '');
                },params,null,function(error) {
                    //console.log('Error ' + error);
                });
            }
            else {
                params["listView"] = listView;
                //console.log('setting to ' + listView );
                this.callServer(component,'c.setListView', function(response) {
                        //console.log('DN: Full_List_View.handleCustomSetting() setter response');
                        //$A.get('e.force:refreshView').fire();
                    },
                    params,true,function(error) {
                        //console.log('Error ' + error);
                    });
            }
        }
    }
})