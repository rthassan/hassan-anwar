trigger sumUpReferrals on Account (after insert, after update) {
    Map<Id,Account> accounts = new Map<Id, Account>();
    Set<Id> accIds = new Set<Id>();
    List<Account> updateAccs = new List<Account>();
    Account acc;
    Id accId;
    Decimal referral;
    
    Id refId;
	for(Account a : trigger.new){
        if ( a.Referrer_c__c != NULL ) {
            accounts.put(a.Id, a);
            refId = a.Referrer_c__c;
            // add Ids of referrer i.e. parent not referred
            accIds.add(a.Referrer_c__c);
        }   
    }
    
    if ( accounts.size() > 0 ) {
        //accIds = accounts.keySet();
        List<Id> accList = new List<Id>(accIds);
        AggregateResult[] groupedResults = [SELECT COUNT(Id), Referrer_c__c FROM Account WHERE Referrer_c__r.Id IN :accIds GROUP BY Referrer_c__c];
        String accIdsString = '\'' + accList[0] + '\'';
        for ( Integer i = 1; i<accList.size(); i++  ) {
            accIdsString += ',\'' + accList[i] + '\'';
        }
        
        AggregateResult[] groupedResults2 = Database.query('SELECT COUNT(Id), Referrer_c__c FROM Account WHERE Referrer_c__r.Id IN (' + accIdsString + ') GROUP BY Referrer_c__c');
        for (AggregateResult ar : groupedResults)  {
            accId = (string)ar.get('Referrer_c__c');
            referral = (decimal)ar.get('expr0');
            acc = new Account(Id = accId,
                Referred_Organisations__c = referral
            );
            updateAccs.add(acc);
        }
        
        if (updateAccs.size() > 0 ) {
            update updateAccs;
        }
    }
}