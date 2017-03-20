/*
This file is generated and isn't the actual source code for this
managed global class.
This read-only file shows the class's global constructors,
methods, variables, and properties.
To enable code to compile, all methods return null.
*/
global virtual class Sage_COR_Trigger_Handler {
    global Sage_COR_Trigger_Handler() {

    }
    @TestVisible
    global virtual void afterDelete() {

    }
    @TestVisible
    global virtual void afterInsert() {

    }
    @TestVisible
    global virtual void afterUndelete() {

    }
    @TestVisible
    global virtual void afterUpdate() {

    }
    @TestVisible
    global virtual void beforeDelete() {

    }
    @TestVisible
    global virtual void beforeInsert() {

    }
    @TestVisible
    global virtual void beforeUpdate() {

    }
    global static void bypass(String handlerName) {

    }
    global static void bypass(String handlerName, s2cor.Sage_COR_Trigger_Handler.TriggerContext context) {

    }
    global static void clearAllBypasses() {

    }
    global static void clearBypass(String handlerName) {

    }
    global static void clearBypass(String handlerName, s2cor.Sage_COR_Trigger_Handler.TriggerContext context) {

    }
    global virtual void clearMaxLoopCount() {

    }
    global virtual List<SObject> getRecords() {
        return null;
    }
    global virtual List<SObject> getRecords(List<String> fields) {
        return null;
    }
    global virtual List<SObject> getRecords(String field, String originalValue, String newValue) {
        return null;
    }
    global static Boolean isBypassed(String handlerName) {
        return null;
    }
    global static Boolean isBypassed(String handlerName, s2cor.Sage_COR_Trigger_Handler.TriggerContext context) {
        return null;
    }
    global virtual void run() {

    }
    global virtual void setMaxLoopCount(Integer max) {

    }
global enum TriggerContext {AFTER_DELETE, AFTER_INSERT, AFTER_UNDELETE, AFTER_UPDATE, BEFORE_DELETE, BEFORE_INSERT, BEFORE_UPDATE}
global class TriggerHandlerException extends Exception {
}
}
