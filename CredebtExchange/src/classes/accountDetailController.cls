public with sharing class accountDetailController {
    
    public Account acc {get; set;}
    
    public accountDetailController(apexpages.StandardController con){
        Id originatorAccRecType = [SELECT Id FROM RecordType WHERE sObjectType = 'Account' AND Name = 'Originator'][0].Id;
        acc = [SELECT Id FROM Account WHERE RecordTypeId = :originatorAccRecType LIMIT 1];
    }

}