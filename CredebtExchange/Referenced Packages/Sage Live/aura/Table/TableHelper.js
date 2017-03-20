/**
 * Created by daniel.nicholson on 12/08/2016.
 */
({
    /*
     * Fire Event Event_Table_Select_Rows / Event_Table_Unselect_Rows for list of IDs.
     * @param object component - Component reference
     * @param ID[] idList - List of IDs to send in event params
     * @param boolean checked - Determines whether Event_Table_Select_Rows or Event_Table_Unselect_Rows should be fired
     */
    fireSelectEvent : function (component, idList, checked) {
        //alert((checked ? "Event_Table_Select_Rows" : "Event_Table_Unselect_Rows") + ' with ' + idList.join(', '));
        var compEvent = $A.get((checked ? "e.s2cor:Event_Table_Select_Rows" : "e.s2cor:Event_Table_Unselect_Rows"));
        compEvent.setParams({"IDs" : idList });
        compEvent.fire();
    },
    /*
     * Fire ClearSelectionEvent
     * @param object component - Component reference
     */
    fireClearSelectionEvent : function (component) {
        var compEvent = $A.get("e.s2cor:Event_Table_Clear_Rows");
        compEvent.fire();
    }
})