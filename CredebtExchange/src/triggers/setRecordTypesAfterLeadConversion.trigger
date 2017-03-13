trigger setRecordTypesAfterLeadConversion on Lead (after update) {
    Map<String, Id> leadRecordTypes = new Map<String, Id>();
    Map<String, Id> accountRecordTypes = new Map<String, Id>();
    Map<String, Id> oppRecordTypes = new Map<String, Id>();
    
    for ( RecordType rt : [SELECT Id, Name FROM RecordType WHERE SobjectType = 'Lead'] ) {
        leadRecordTypes.put(rt.Name, rt.Id);
    }
    
    for ( RecordType rt : [SELECT Id, Name FROM RecordType WHERE SobjectType = 'Account'] ) {
        accountRecordTypes.put(rt.Name, rt.Id);
    }
    
    for ( RecordType rt : [SELECT Id, Name FROM RecordType WHERE SobjectType = 'Opportunity'] ) {
        oppRecordTypes.put(rt.Name, rt.Id);
    }
    
    List<Account> accs = new List<Account>();
    List<Opportunity> opps = new List<Opportunity>();
    
    Id accountRecordType;
    Id opportunityRecordType;
    
    for(Lead lead:System.Trigger.new) {
        if (lead.IsConverted) {
            
            
            if ( Lead.RecordTypeId == leadRecordTypes.get('Convertibill® Originator') ) {
                accountRecordType = accountRecordTypes.get('Originator');
                opportunityRecordType = oppRecordTypes.get('1. Convertibill® Trade Finance');
            }
            
            if ( Lead.RecordTypeId == leadRecordTypes.get('Convertibill® Supplier') ) {
                accountRecordType = accountRecordTypes.get('Leasabill® Vendor');
                opportunityRecordType = oppRecordTypes.get('2. Convertibill® Sales Finance');
            }
            
            if ( Lead.RecordTypeId == leadRecordTypes.get('Advisabill® Agent') ) {
                accountRecordType = accountRecordTypes.get('Agent');
                opportunityRecordType = oppRecordTypes.get('3. Advisabill® Agent');
            }
            
            if ( Lead.RecordTypeId == leadRecordTypes.get('Convertibill® Agent') ) {
                accountRecordType = accountRecordTypes.get('Agent');
                opportunityRecordType = oppRecordTypes.get('4. Convertibill® Agent');
            }
            
            if ( Lead.RecordTypeId == leadRecordTypes.get('Investabill® Intermediary') ) {
                accountRecordType = accountRecordTypes.get('Intermediary');
                opportunityRecordType = oppRecordTypes.get('5. Investabill® Intermediary');
            }
            
            if ( Lead.RecordTypeId == leadRecordTypes.get('Pension Trustee') ) {
                accountRecordType = accountRecordTypes.get('Trustee');
                opportunityRecordType = oppRecordTypes.get('6. Pension Trustee');
            }
            
            if ( lead.RecordTypeId == leadRecordTypes.get('Investabill® Investor') ) {
                accountRecordType = accountRecordTypes.get('Investor');
                opportunityRecordType = oppRecordTypes.get('7. Investabill® Investor');
            }
            
            if ( lead.RecordTypeId == leadRecordTypes.get('Leasabill® Investor') ) {
                accountRecordType = accountRecordTypes.get('Investor');
                opportunityRecordType = oppRecordTypes.get('8. Leasabill® Investor');
            }
            
            Account a = new Account(
                Id = lead.ConvertedAccountId,
                RecordTypeId = accountRecordType
            );
            accs.add(a);
            
            Opportunity o = new Opportunity(
                Id = lead.ConvertedOpportunityId,
                RecordTypeId = opportunityRecordType
            );
            opps.add(o);
        }
    }
    
    if ( accs.size() > 0 ) {
        update accs;
        update opps;
    }
}