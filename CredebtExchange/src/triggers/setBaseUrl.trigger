trigger setBaseUrl on Account (before insert) {
    for(Account a: Trigger.New)
    {
        a.baseurl__c=URL.getSalesforceBaseUrl().toExternalForm();
    }
}