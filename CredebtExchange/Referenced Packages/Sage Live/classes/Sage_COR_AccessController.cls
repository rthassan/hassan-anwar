/*
This file is generated and isn't the actual source code for this
managed global class.
This read-only file shows the class's global constructors,
methods, variables, and properties.
To enable code to compile, all methods return null.
*/
global class Sage_COR_AccessController {
    global Sage_COR_AccessController() {

    }
    global Sage_COR_AccessController(s2cor.Sage_COR_AccessController.SharingMode smode, s2cor.Sage_COR_AccessController.OperationMode omode) {

    }
    global Sage_COR_AccessController(s2cor.Sage_COR_AccessController.SharingMode smode, s2cor.Sage_COR_AccessController.OperationMode omode, s2cor.Sage_COR_AccessController.OperationMode oarrmode) {

    }
    global void deleteAsUser(SObject someObj) {

    }
    global s2cor.Sage_COR_AccessControlResults.DeleteResults deleteAsUser(List<SObject> someObjs) {
        return null;
    }
    global List<Schema.SObjectField> getCreatableFields(SObject someObj) {
        return null;
    }
    global List<Schema.SObjectField> getCreatableFields(Schema.SObjectType someType) {
        return null;
    }
    global s2cor.Sage_COR_AccessController.OperationMode getLastSetArrayOperationMode() {
        return null;
    }
    global List<Schema.SObjectField> getUpdateableFields(SObject someObj) {
        return null;
    }
    global List<Schema.SObjectField> getUpdateableFields(Schema.SObjectType someType) {
        return null;
    }
    global List<Schema.SObjectField> getViewableFields(SObject someObj) {
        return null;
    }
    global List<Schema.SObjectField> getViewableFields(Schema.SObjectType someType) {
        return null;
    }
    global SObject insertAsUser(SObject someObj) {
        return null;
    }
    global s2cor.Sage_COR_AccessControlResults.InsertResults insertAsUserWithResults(List<SObject> someObjs) {
        return null;
    }
    global List<SObject> insertAsUser(List<SObject> someObjs) {
        return null;
    }
    global SObject insertAsUser(SObject someObj, List<Schema.SObjectField> fieldsToSet) {
        return null;
    }
    global SObject insertAsUser(SObject someObj, List<String> fieldsToSet) {
        return null;
    }
    global s2cor.Sage_COR_AccessControlResults.InsertResults insertAsUser(List<SObject> someObjs, List<Schema.SObjectField> fieldsToSet) {
        return null;
    }
    global s2cor.Sage_COR_AccessControlResults.InsertResults insertAsUser(List<SObject> someObjs, List<String> fieldsToSet) {
        return null;
    }
    global Boolean isAuthorizedToCreate(Schema.SObjectType someType, List<Schema.SObjectField> fields) {
        return null;
    }
    global Boolean isAuthorizedToCreate(Schema.SObjectType someType, List<String> fields) {
        return null;
    }
    global Boolean isAuthorizedToDelete(Schema.SObjectType someType) {
        return null;
    }
    global Boolean isAuthorizedToUpdate(Schema.SObjectType someType, List<Schema.SObjectField> fields) {
        return null;
    }
    global Boolean isAuthorizedToUpdate(Schema.SObjectType someType, List<String> fields) {
        return null;
    }
    global Boolean isAuthorizedToView(Schema.SObjectType someType, List<Schema.SObjectField> fields) {
        return null;
    }
    global Boolean isAuthorizedToView(Schema.SObjectType someType, List<String> fields) {
        return null;
    }
    global void setArrayOperationMode(s2cor.Sage_COR_AccessController.OperationMode oarrmode) {

    }
    global void setOperationMode(s2cor.Sage_COR_AccessController.OperationMode omode) {

    }
    global void setSharingMode(s2cor.Sage_COR_AccessController.SharingMode smode) {

    }
    global SObject updateAsUser(SObject someObj) {
        return null;
    }
    global s2cor.Sage_COR_AccessControlResults.UpdateResults updateAsUserWithResults(List<SObject> someObjs) {
        return null;
    }
    global List<SObject> updateAsUser(List<SObject> someObjs) {
        return null;
    }
    global SObject updateAsUser(SObject someObj, List<Schema.SObjectField> fieldsToUpdate) {
        return null;
    }
    global SObject updateAsUser(SObject someObj, List<String> fieldsToUpdate) {
        return null;
    }
    global s2cor.Sage_COR_AccessControlResults.UpdateResults updateAsUser(Map<Id,SObject> objMap, List<Schema.SObjectField> fieldsToUpdate) {
        return null;
    }
    global s2cor.Sage_COR_AccessControlResults.UpdateResults updateAsUser(Map<Id,SObject> objMap, List<String> fieldsToUpdate) {
        return null;
    }
    global SObject upsertAsUser(SObject someObj) {
        return null;
    }
    global SObject upsertAsUserCheck(SObject someObj) {
        return null;
    }
    global List<SObject> upsertAsUserCheck(List<SObject> someObjs) {
        return null;
    }
    global s2cor.Sage_COR_AccessControlResults.UpsertResults upsertAsUserWithResults(List<SObject> someObjs) {
        return null;
    }
    global List<SObject> upsertAsUser(List<SObject> someObjs) {
        return null;
    }
    global SObject upsertAsUser(SObject someObj, List<String> fieldsToSet) {
        return null;
    }
    global s2cor.Sage_COR_AccessControlResults.UpsertResults upsertAsUser(List<SObject> someObjs, List<String> fieldsToSet) {
        return null;
    }
global class AccessControlDmlException extends Exception {
}
global enum OperationMode {ALL_OR_NONE, BEST_EFFORT}
global enum SharingMode {INHERIT, WITH, WITHOUT}
}
