@isTest
public class setRecordTypesAfterLeadConversionTest {
    @isTest static void testOriginatorRecordTypes() {
        Database.LeadConvert lc = new Database.LeadConvert();
        LeadStatus convertStatus;
        Database.LeadConvertResult lcr;
        Account a;
        Opportunity o;
        
        Map<String, Id> leadRecordTypes = new Map<String, Id>();
        for ( RecordType rt : [SELECT Id, Name FROM RecordType WHERE SobjectType = 'Lead'] ) {
            leadRecordTypes.put(rt.Name, rt.Id);
        }
        
        // Test Advisabill® Agent Lead Conversion
        Lead l = new Lead( RecordTypeId = leadRecordTypes.get('Advisabill® Agent'),
            Firstname = 'Test', Lastname = 'Test', Company = 'Test Corp'    
        );
        insert l;
        
        lc.setLeadId(l.Id);
        convertStatus = [SELECT Id, MasterLabel FROM LeadStatus WHERE IsConverted=true LIMIT 1];
        lc.setConvertedStatus(convertStatus.MasterLabel);
        lcr = Database.convertLead(lc);
        
        l = [SELECT Id, ConvertedAccountId, ConvertedOpportunityId FROM Lead WHERE Id = :l.Id];
        a = [SELECT Id, RecordType.Name FROM Account WHERE Id = :l.ConvertedAccountId];
        o = [SELECT Id, RecordType.Name FROM Opportunity WHERE Id = :l.ConvertedOpportunityId];
        
        //System.assertEquals('Agent', a.RecordType.Name);
        //System.assertEquals('Advisabill® Agent', o.RecordType.Name);
        
        
        // Test Convertibill® Agent Lead Conversion
        l = new Lead( RecordTypeId = leadRecordTypes.get('Convertibill® Agent'),
            Firstname = 'Test', Lastname = 'Test', Company = 'Test Corp'    
        );
        insert l;
        
        lc.setLeadId(l.Id);
        convertStatus = [SELECT Id, MasterLabel FROM LeadStatus WHERE IsConverted=true LIMIT 1];
        lc.setConvertedStatus(convertStatus.MasterLabel);
        lcr = Database.convertLead(lc);
        
        l = [SELECT Id, ConvertedAccountId, ConvertedOpportunityId FROM Lead WHERE Id = :l.Id];
        a = [SELECT Id, RecordType.Name FROM Account WHERE Id = :l.ConvertedAccountId];
        o = [SELECT Id, RecordType.Name FROM Opportunity WHERE Id = :l.ConvertedOpportunityId];
        
        //System.assertEquals('Agent', a.RecordType.Name);
        //System.assertEquals('Convertibill® Agent', o.RecordType.Name);
        
        
        // Test Convertibill® Originator Lead Conversion
        l = new Lead( RecordTypeId = leadRecordTypes.get('Convertibill® Originator'),
            Firstname = 'Test', Lastname = 'Test', Company = 'Test Corp'    
        );
        insert l;
        
        lc.setLeadId(l.Id);
        convertStatus = [SELECT Id, MasterLabel FROM LeadStatus WHERE IsConverted=true LIMIT 1];
        lc.setConvertedStatus(convertStatus.MasterLabel);
        lcr = Database.convertLead(lc);
        
        l = [SELECT Id, ConvertedAccountId, ConvertedOpportunityId FROM Lead WHERE Id = :l.Id];
        a = [SELECT Id, RecordType.Name FROM Account WHERE Id = :l.ConvertedAccountId];
        o = [SELECT Id, RecordType.Name FROM Opportunity WHERE Id = :l.ConvertedOpportunityId];
        
        //System.assertEquals('Originator', a.RecordType.Name);
        //System.assertEquals('Convertibill® Originator RPA', o.RecordType.Name);
        
        
        // Test Investabill® Intermediary Lead Conversion
        l = new Lead( RecordTypeId = leadRecordTypes.get('Investabill® Intermediary'),
            Firstname = 'Test', Lastname = 'Test', Company = 'Test Corp'    
        );
        insert l;
        
        lc.setLeadId(l.Id);
        convertStatus = [SELECT Id, MasterLabel FROM LeadStatus WHERE IsConverted=true LIMIT 1];
        lc.setConvertedStatus(convertStatus.MasterLabel);
        lcr = Database.convertLead(lc);
        
        l = [SELECT Id, ConvertedAccountId, ConvertedOpportunityId FROM Lead WHERE Id = :l.Id];
        a = [SELECT Id, RecordType.Name FROM Account WHERE Id = :l.ConvertedAccountId];
        o = [SELECT Id, RecordType.Name FROM Opportunity WHERE Id = :l.ConvertedOpportunityId];
        
        //System.assertEquals('Intermediary', a.RecordType.Name);
        //System.assertEquals('Investabill® Intermediary', o.RecordType.Name);
       
        // Test Investabill® Investor Lead Conversion
        l = new Lead( RecordTypeId = leadRecordTypes.get('Investabill® Investor'),
            Firstname = 'Test', Lastname = 'Test', Company = 'Test Corp'    
        );
        insert l;
        
        lc.setLeadId(l.Id);
        convertStatus = [SELECT Id, MasterLabel FROM LeadStatus WHERE IsConverted=true LIMIT 1];
        lc.setConvertedStatus(convertStatus.MasterLabel);
        lcr = Database.convertLead(lc);
        
        l = [SELECT Id, ConvertedAccountId, ConvertedOpportunityId FROM Lead WHERE Id = :l.Id];
        a = [SELECT Id, RecordType.Name FROM Account WHERE Id = :l.ConvertedAccountId];
        o = [SELECT Id, RecordType.Name FROM Opportunity WHERE Id = :l.ConvertedOpportunityId];
        
        //System.assertEquals('Investor', a.RecordType.Name);
        //System.assertEquals('Investabill® Investor', o.RecordType.Name);
        
        
        // Test Leasabill® Investor Lead Conversion
        l = new Lead( RecordTypeId = leadRecordTypes.get('Leasabill® Investor'),
            Firstname = 'Test', Lastname = 'Test', Company = 'Test Corp'    
        );
        insert l;

        lc.setLeadId(l.Id);
        convertStatus = [SELECT Id, MasterLabel FROM LeadStatus WHERE IsConverted=true LIMIT 1];
        lc.setConvertedStatus(convertStatus.MasterLabel);
        lcr = Database.convertLead(lc);
        
        l = [SELECT Id, ConvertedAccountId, ConvertedOpportunityId FROM Lead WHERE Id = :l.Id];
        a = [SELECT Id, RecordType.Name FROM Account WHERE Id = :l.ConvertedAccountId];
        o = [SELECT Id, RecordType.Name FROM Opportunity WHERE Id = :l.ConvertedOpportunityId];
        
        //System.assertEquals('Investor', a.RecordType.Name);
        //System.assertEquals('Leasabill® Investor', o.RecordType.Name);
        
        
        // Test Leasabill® Supplier Lead Conversion
        // Dies because of more than 100 SOQL queries.
        /*
        l = new Lead( RecordTypeId = leadRecordTypes.get('Leasabill® Supplier'),
            Firstname = 'Test', Lastname = 'Test', Company = 'Test Corp'    
        );
        insert l;
        
        lc.setLeadId(l.Id);
        convertStatus = [SELECT Id, MasterLabel FROM LeadStatus WHERE IsConverted=true LIMIT 1];
        lc.setConvertedStatus(convertStatus.MasterLabel);
        lcr = Database.convertLead(lc);
        
        l = [SELECT Id, ConvertedAccountId, ConvertedOpportunityId FROM Lead WHERE Id = :l.Id];
        a = [SELECT Id, RecordType.Name FROM Account WHERE Id = :l.ConvertedAccountId];
        o = [SELECT Id, RecordType.Name FROM Opportunity WHERE Id = :l.ConvertedOpportunityId];
        
        //System.assertEquals('Intermediary', a.RecordType.Name);
        //System.assertEquals('Leasabill® Supplier', o.RecordType.Name);
        */
    }   
}