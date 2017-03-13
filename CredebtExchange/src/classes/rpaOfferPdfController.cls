public with sharing class rpaOfferPdfController  {
    
    public Opportunity opp {get; set;}
    public Account acc {get; set;}
    public Contact cont {get; set;}
    
    public String address {get; set;}
    public string nace {get; set;}
    
    public Date todayDate {get; set;}
    
    public rpaOfferPdfController(apexpages.StandardController con){
        
        opp = [SELECT Id,LDC_Premium_Commission__c, Deposit_Value__c,LDC_Premium__c,RecordType.Name,Deposit_Payment_No__c,a_ETR_Value__c,Term__c,Deposit_Payment__c,Monthly_Payment__c,R_M_Service__c,   Monthly_Payment_incl_VAT__c,d_ETR_Sell_Rate_formula__c,Revolving_Sale__c, Name, AccountId, currencyISOcode, c_ETR_Required__c, o_ETR__c, d_ETR_Required__c, a_ETR__c, c_ETR_Discount_Value__C,c_ETR_Discount__c, c_ETR_Deposit__c, d_ETR_Sell_Rate__c, 
               Monthly_Fee__c, Arrangement_Fee__c, Processing_Commission__c,  Revolving_Purchase__c, Purchase_Payment__c, specific_conditions__c, Average_DSO__c,
               posting_fee__c, debtors_rating_fee__c, digi_access_fee__c,  first_repayment__c, repayment_every__c, settled_within__c, ATR_Calculated__c, owner.Name, No_ATR__c, Annual_RPA__c, Annual_RSA__c
               FROM Opportunity WHERE Id = :con.getId()];
        acc = [SELECT Id, BillingStreet, BillingCity, BillingState, BillingPostalCode, BillingCountry, Name, Company_registration_number__c, NACE_Code__c, NACE_Section__c, Fiscal_Year_End__c, Trading_Name__c  FROM Account WHERE Id = :opp.AccountID];
        opportunityContactRole ocr = [SELECT ContactId FROM opportunityContactRole WHERE OpportunityId = :opp.Id AND IsPrimary = TRUE];
        cont = [SELECT Id, FirstName, LastName, Email, Phone FROM Contact WHERE Id = :ocr.ContactId];
        
        
        if(acc.BillingStreet != null){
            address = acc.BillingStreet;
        }
        if(acc.BillingCity != null){
            address += ', ' + acc.BillingCity;
        }
        if(acc.BillingState != null){
            address += ', ' + acc.BillingState;
        }
        if(acc.BillingPostalCode != null){
            address += ', ' + acc.BillingPostalCode;
        }
        if(acc.BillingCountry != null){
            address += ', ' + acc.BillingCountry;
        }
        nace = '';
        if(acc.NACE_Section__c != null && acc.NACE_Code__c != null){
            nace = acc.NACE_Section__c.left(acc.NACE_Section__c.indexOf(' ')) + '/' + acc.NACE_Code__c.left(acc.NACE_code__c.indexOf(' '));
        }
        
        
        todayDate = system.today();
        
    }
    
    

}