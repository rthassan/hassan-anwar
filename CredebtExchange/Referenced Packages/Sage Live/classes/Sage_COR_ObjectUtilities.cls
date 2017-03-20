/*
This file is generated and isn't the actual source code for this
managed global class.
This read-only file shows the class's global constructors,
methods, variables, and properties.
To enable code to compile, all methods return null.
*/
global class Sage_COR_ObjectUtilities {
    global Sage_COR_ObjectUtilities() {

    }
    global static String AddNamespaceToFieldName(Schema.SObjectType objType, String fieldName) {
        return null;
    }
    global static SObject ClonesObject(SObject originalItem, List<String> fields) {
        return null;
    }
    global static Boolean ExtractBoolean(Object obj) {
        return null;
    }
    global static Id ExtractId(Object obj) {
        return null;
    }
    global static Map<String,Schema.SObjectField> GetFieldMap(Schema.SObjectType objType) {
        return null;
    }
    global static Schema.SObjectField GetSinglesObjectField(SObject originalItem, String field) {
        return null;
    }
    global static Object GetSinglesObjectFieldValue(SObject originalItem, String field) {
        return null;
    }
    global static Object GetSinglesObjectFieldValue(SObject originalItem, String field, Schema.SoapType expectedType) {
        return null;
    }
    global static String MapStringFormatReplace(Map<String,Object> lookup, String value) {
        return null;
    }
    global static String MapStringFormatReplace(Map<String,Object> lookup, String value, Boolean clearNonMatches) {
        return null;
    }
    global static String MapStringReplacement(Map<String,Object> lookup, String value) {
        return null;
    }
    global static String MapStringReplacement(Map<String,Object> lookup, String value, Boolean clearNonMatches) {
        return null;
    }
    global static String MapStringReplacement(Map<String,Object> lookup, String value, Boolean clearNonMatches, Map<String,String> bucket) {
        return null;
    }
    global static Set<String> discoverAccessibleFields(String className) {
        return null;
    }
    global static Set<String> discoverCreateableFields(String className) {
        return null;
    }
    global static Set<String> discoverFieldsByAccess(String className, s2cor.Sage_COR_ObjectUtilities.AccessType mode) {
        return null;
    }
    global static Set<String> discoverUpdateableFields(String className) {
        return null;
    }
    global static void ensureTopicExists(String name, Boolean forCreate, Boolean forUpdate, Boolean forDelete, Boolean forUndelete) {

    }
    global static Decimal getSortItem(SObject item, String name) {
        return null;
    }
    global static Decimal getSortItemByField(SObject item, Schema.SObjectField field) {
        return null;
    }
    global static Integer getVal(Integer value, Integer defaultValue) {
        return null;
    }
    global static String getVal(String value, String defaultValue) {
        return null;
    }
    global static Boolean isStringAnId(String test) {
        return null;
    }
    global static String joinList(Set<String> theList, String separator) {
        return null;
    }
    global static Map<Id,List<SObject>> mapChildObjects(List<SObject> childObjects, String parentFieldName) {
        return null;
    }
    global static String namespaceForSObject(Schema.DescribeSObjectResult res) {
        return null;
    }
    global static void pushDashboardUpdates() {

    }
    global static List<SObject> queryOnObject(Id parentId, String parentField, Schema.SObjectType objType, Set<String> fieldNames) {
        return null;
    }
    global static List<SObject> queryOnObjects(List<Id> parentIds, Set<Id> childIds, String parentField, Schema.SObjectType objType, Set<String> fieldNames) {
        return null;
    }
    global static List<SObject> queryOnObjects(List<Id> parentIds, String parentField, Schema.SObjectType objType, Set<String> fieldNames) {
        return null;
    }
    global static String quoteKeySet(Set<Id> mapKeySet) {
        return null;
    }
    global static String sObjectFieldStringReplacement(SObject objItem, String value) {
        return null;
    }
    global static List<SObject> selectAllOnObject(Id objectId, Schema.SObjectType objType, Set<String> fieldNames) {
        return null;
    }
    global static List<SObject> selectAllOnObjects(List<Id> objectIds, Schema.SObjectType objType, Set<String> fieldNames) {
        return null;
    }
    global static List<SObject> selectAllOnObjects(List<Id> objectIds, Schema.SObjectType objType, Set<String> fieldNames, String parentFieldName) {
        return null;
    }
    global static void setCurrentCompanyOnObject() {

    }
    global static Boolean testDML(Set<String> requiredFields, String className, s2cor.Sage_COR_ObjectUtilities.AccessType mode, Boolean throwOnFail) {
        return null;
    }
global enum AccessType {accessible, createable, updateable}
}
