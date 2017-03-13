public with sharing class requestRPAcontroller {
    
    public Opportunity opp {get; set;}
    public Account acc {get; set;}
    public Contact con {get; set;}
    public credit_history__c credHis {get; set;}
    public List<credit_history__c> creditHistories {get; set;}
    
    public string errorString {get; set;}
    
    public List<selectOption> approvers {get; set;}
    public string selectedApprover {get; set;}
    
    public requestRPAcontroller(apexpages.StandardController control){
        
        opp = [SELECT Id, Name,Credit_Card__c, AccountId,RecordType.Name, Account.Name, currencyISOcode, c_ETR_Required__c, o_ETR__c, d_ETR_Required__c, a_ETR__c, c_ETR_Discount_Value__C,c_ETR_Discount__c, c_ETR_Deposit__c, d_ETR_Sell_Rate__c,  
               Monthly_Fee__c, Arrangement_Fee__c, Processing_Commission__c, Revolving_Purchase__c, Purchase_Payment__c, specific_conditions__c, working_capital_requirement__c,
               posting_fee__c, debtors_rating_fee__c, digi_access_fee__c,  first_repayment__c, repayment_every__c, settled_within__c, ATR_Calculated__c, average_dso__c, turnover_last_year__c, turnover_expected_this_year__c, No_ATR__c, 
               Approver__c, approver__r.Name, Type, closeDate, Average_Gross_margin__c, Probability, RPA_Accepted_Date__c, Traded_Date__c,End_of_Term_Value__c ,Term__c,a_ETR_Value__c 
               FROM Opportunity WHERE Id = :control.getId()];
         
        if(opp.recordType.Name == '2. Convertibill® Sales Finance')
        {
            if(opp.End_of_Term_Value__c == null)
            {
                opp.End_of_Term_Value__c = 1000;
            }
            
            if(opp.Term__c == null)
            {
                opp.Term__c = 36;
            }
            
            if(opp.a_ETR_Value__c == null)
            {
                opp.a_ETR_Value__c = 36;
            }
            
            opp.a_ETR__c = true;
        }
         
        acc = [SELECT Id, BillingStreet, BillingCity, BillingState, BillingPostalCode, BillingCountry, Name,  IDF_Provider__c, NACE_Section__c, NACE_Code__c, Company_registration_number__c, Country_of_registration__c 
               FROM Account WHERE Id = :opp.AccountID];
        List<contact> conList = [SELECT Id, FirstName, lastName, Phone, Email, Name FROM Contact WHERE Id IN (SELECT ContactId FROM opportunityContactRole WHERE OpportunityId = :opp.Id AND IsPrimary = TRUE)];
        if(!conList.isEmpty()){
            con = conList[0];
        }
        else{
            con = new contact(
                accountId = acc.Id
            );
        }
          
        //con = [SELECT Id, FirstName, lastName, Phone, Email FROM Contact WHERE Id IN (SELECT ContactId FROM opportunityContactRole WHERE OpportunityId = :opp.Id AND IsPrimary = TRUE)];
        credHis = new credit_history__c(
            originator__c = acc.Id,
            Opportunity__c = opp.Id
        );
        creditHistories = [SELECT Id, credit_data_provider__c, credit_limit__c, Creditsafe_Rating__c, Y_E_Trade_Creditors__c, Y_E_Trade_debtors__c, createdDate, as_at_date__c FROM Credit_History__c WHERE Originator__c = :acc.Id ORDER BY createdDate];
        
        approvers = new List<selectOption>();     
        
        User patrick = [SELECT Id, Name FROM User WHERE alias = 'PRenolds'];
        set<Id> approverIds = new Set<Id>();
        
        if(patrick.Name != null){
            approvers.add(new selectOption(patrick.Id, patrick.Name));
            approverIds.add(patrick.Id);
        }
        for(User u : [SELECT Id, Name FROM User WHERE isActive = TRUE AND Profile.Name = 'CE Approver']){
            approvers.add(new selectOption(u.Id, u.Name));
            approverIds.add(u.Id);
        }
        if(opp.Approver__c != null && !approverIds.contains(opp.Approver__c) ){
            approvers.add(new SelectOption(opp.Approver__c, opp.Approver__r.Name));
        }
        
        if(opp.Approver__c != null){
            selectedApprover = opp.Approver__c;
        }
    }
    
   
    
    public void save(){
        opp.Approver__c = selectedApprover;
        update opp;
        update acc;
        if(con.lastName != null){
            upsert con;
            List<opportunityContactRole> ocrList = [SELECT Id FROM opportunityContactRole WHERE opportunityId = :opp.Id AND contactId = :con.Id];
            if(ocrList.isEmpty()){
                opportunityContactRole ocr = new opportunityContactRole(opportunityId = opp.Id, contactId = con.Id, isPrimary = true, Role = 'RPA Approver');
                insert ocr;
            }
        }
    }
    
    public void requestRPA(){
        
        List<string> errorList = new List<string>();
        if(opp.Turnover_Expected_this_Year__c == null || opp.Turnover_Last_year__c == null || (opp.d_ETR_Required__c == null && opp.Working_Capital_Requirement__c == null) || opp.Average_DSO__c == null){
            errorList.add('\nOpportunity Information Missing');            
            if(opp.Turnover_Expected_this_Year__c == null ){
                ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR, ' Opportunity: Turnover Expected This Year Required'));            
            }
            if( opp.Turnover_Last_year__c == null){
                ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR,  ' Opportunity: Turnover Last Year  Required'));            
            }
            if((opp.d_ETR_Required__c == null && opp.Working_Capital_Requirement__c == null)){
                ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR, ' Opportunity: d-ETR or Working Capital Requirement Required'));            
            }
            if(opp.Average_DSO__c == null){
                ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR, ' Opportunity: Average DSO Required'));            
            }
        }
        system.debug(acc);
        if(acc.IDF_Provider__c == null || acc.BillingStreet == null || acc.BillingCity == null || acc.NACE_Code__c == null  || acc.Company_Registration_number__c == null || acc.country_of_registration__c == null){
            errorList.add('\nOrganisation Information is Missing');
            if(acc.IDF_Provider__c == null ){
                ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR, ' Organisation: IDF Provider is Missing'));                
            }
            if(acc.BillingStreet == null  || acc.BillingCity == null){
                ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR, ' Organisation: Address Information is Missing'));
                
            }
            if(acc.NACE_Code__c == null ){
                ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR, ' Organisation: NACE Code is Missing'));
            }            
            if(acc.company_registration_number__c == null ){
                ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR, ' Organisation: Company Registration Number is Missing'));
            }
            if(acc.Country_of_registration__c == null ){
                ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR, ' Organisation: Country of Registration is Missing'));
            }
        }
        if(con.lastName == null || con.Phone == null || con.email == null){
            errorList.add('\nContact Information is Missing');
            ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR, ' Contact Information Missing: \n Last Name, Phone & Email are Required'));
        }
        
        if(creditHistories.isEmpty()){
            errorList.add('\nCredit Information is Missing');
            ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR, ' Credit Data Missing: \n At least one Credit History is required'));
        }
        
        
            errorString = '';
            for(string e : errorList){
                errorString += e + '\n';
            }
        //opp.addError(errorString);
        //ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR, errorString));
        system.debug(errorString);
        if(errorString == ''){
            save();
            //User approver = [SELECT Id FROM User WHERE Alias = 'dgill'];
            //User approver = [SELECT Id FROM User WHERE Alias = 'PRenolds'];  
            id approverId;
                if(opp.Approver__c != null){
                    approverId = opp.Approver__c;
                }else{
                    approverId = [SELECT Id FROM User WHERE alias = 'PRenolds'].Id;
                }
                      
            Task t = new Task(
                Subject = 'RPA Approval - ' + opp.Account.Name,
                //OwnerId = approver.Id,
                OwnerId = approverId,
                ActivityDate = system.today(),
                Type = 'Approve RPA',
                Description = 'Opportunity has been submitted for approval ' + opp.Name + '. To approve go to ' +URL.getSalesforceBaseUrl().toExternalForm() +'/apex/approveRPALightning?id=' +opp.id
                //Task_Category__c = 'Internal'
                
            );
            if(!test.isRunningTest()){
                insert t;
            }
            opp.RPA_Status__c = 'Requested';
            upsert opp;
            ApexPages.addmessage(new ApexPages.message(ApexPages.severity.INFO, 'Submitted for Approval'));
        }
    }
    
    public void addCredit(){
        insert credHis;
        creditHistories = [SELECT Id, credit_data_provider__c, credit_limit__c, Creditsafe_Rating__c, Y_E_Trade_Creditors__c, Y_E_Trade_debtors__c, createdDate, as_at_date__c FROM Credit_History__c WHERE Originator__c = :acc.Id ORDER BY createdDate];
        credHis = new credit_history__c(
            Originator__c = acc.Id,
            Opportunity__c = opp.Id
        );
    }
    
    public pageReference viewPdf(){
        pagereference home = new pageReference('/apex/provisionalRPAofferPDF?id='+opp.Id);
        home.setRedirect(true);
        return home;
    }
    
    

}