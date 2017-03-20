/*
This file is generated and isn't the actual source code for this
managed global class.
This read-only file shows the class's global constructors,
methods, variables, and properties.
To enable code to compile, all methods return null.
*/
global abstract class Sage_COR_Base_Addon_3_0 implements s2cor.Sage_COR_IAddon_2_0 {
    global s2cor__Sage_ACC_Feed_Broker__c broker;
    global s2cor__Sage_ACC_Feed__c feed;
    global s2cor__Sage_ACC_Feed_Execution__c feedExecution;
    global Sage_COR_Base_Addon_3_0() {

    }
    global static s2cor.Sage_COR_Base_Addon_3_0 CreateAddonInstance(s2cor__Sage_ACC_Feed_Broker__c broker) {
        return null;
    }
    global static s2cor.Sage_COR_Base_Addon_3_0 CreateAddonInstance(s2cor__Sage_ACC_Feed_Execution__c feedExec) {
        return null;
    }
    global static s2cor.Sage_COR_Base_Addon_3_0 CreateAddonInstance(s2cor__Sage_ACC_Feed__c feed) {
        return null;
    }
    global static s2cor.Sage_COR_Base_Addon_3_0 CreateAddonInstance(String className) {
        return null;
    }
    global void addErrorNote(String body) {

    }
    global virtual void addLogData(String title, String body) {

    }
    global void addLogNote(String title, String body) {

    }
    global void addTransactionsLogFile(String title, String body) {

    }
    global void addWarningNote(String body) {

    }
    global virtual Boolean canDeleteFeedExecution(s2cor__Sage_ACC_Feed_Execution__c execution) {
        return null;
    }
    global virtual Boolean canDeleteFeedExecution(List<s2cor__Sage_ACC_Feed_Execution__c> executions) {
        return null;
    }
    global virtual String decrypt(String encryptedText) {
        return null;
    }
    global virtual String encrypt(String decriptedText) {
        return null;
    }
    global virtual Integer getBatchSize() {
        return null;
    }
    global virtual Boolean getBuildFeedItems() {
        return null;
    }
    global abstract String getClassName();
    global virtual String getConfigurationURL() {
        return null;
    }
    global virtual Integer getDataBatchSize() {
        return null;
    }
    global abstract String getDescription();
    global String getEndURL() {
        return null;
    }
    global String getFeedConfiguration() {
        return null;
    }
    global virtual String getFeedConfigurationURL() {
        return null;
    }
    global virtual String getFeedProcessURL() {
        return null;
    }
    global virtual String getInputDataScope(List<Object> params) {
        return null;
    }
    global virtual Boolean getLogEnabled() {
        return null;
    }
    global virtual String getMoreInformationURL() {
        return null;
    }
    global abstract String getName();
    global virtual String getNoSuccessURL() {
        return null;
    }
    global virtual String getProcessDataScope(List<Object> params) {
        return null;
    }
    global virtual Boolean getSensitiveConfiguration() {
        return null;
    }
    global virtual String getSuccessURL() {
        return null;
    }
    global abstract String getTransactionDtoClassName();
    global abstract Object getTransactionEntityInstance();
    global abstract String getType();
    global virtual String getUID() {
        return null;
    }
    global virtual String getVersion() {
        return null;
    }
    global Boolean isRegistered() {
        return null;
    }
    global virtual void loadFeed(Id feedId) {

    }
    global Boolean makeAddonReady() {
        return null;
    }
    global virtual void onDeleteFeedExecution(s2cor__Sage_ACC_Feed_Execution__c execution) {

    }
    global virtual void onDeleteFeedExecution(List<s2cor__Sage_ACC_Feed_Execution__c> executions) {

    }
    global virtual String onFinishProcessData() {
        return null;
    }
    global virtual void onRegistered() {

    }
    global virtual void onUnregistered() {

    }
    global s2cor__Sage_ACC_Feed_Execution__c process() {
        return null;
    }
    global s2cor__Sage_ACC_Feed_Execution__c process(List<Object> params) {
        return null;
    }
    global Boolean register() {
        return null;
    }
    global void setFeedConfiguration(String configuration) {

    }
    global void setStep(String step) {

    }
    global Boolean unregister() {
        return null;
    }
}
