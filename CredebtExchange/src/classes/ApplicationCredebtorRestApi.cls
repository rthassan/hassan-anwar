public  class ApplicationCredebtorRestApi {

		//@future(callout=true)
		/*public static void sendDebtors(ID DebtorId)
		{
			string json ;
            string type = null;
            
            Id DebtType = [Select id,SObjectType from RecordType where Name='Debtor' and SObjectType = 'Account'].id;
            Id CredtType = [Select id,SObjectType from RecordType where Name='Creditor' and SObjectType = 'Account'].id;
            
            
            
			List<Account> Debtor = [Select originator__c,id,name,CurrencyIsoCode,Trading_Name__c, Counterparty_Since__c,
                                    Website,Company_Registration_Number__c, NACE_Section__c, NACE_Code__c,recordTypeId,
                                    Year_of_Registration__c,Country_of_Registration__c,Average_Cycle_Payment__c,
                                    ShippingAddress,ShippingStreet,ShippingCity,ShippingCountry,ShippingPostalcode,
                                    ShippingState,BillingStreet,BillingCity,BillingCountry,BillingPostalcode,
                                    BillingState from Account where id =: DebtorId];
			
			for(Account d : Debtor)
			{
                List<Account> originator = [Select id,originator_reference_id__c from Account 
                                            where id =: d.originator__c Limit 1];
                if(d.recordTypeId == DebtType)
                {
                    type = 'Debtor';
                }
                else if(d.recordTypeId == CredtType)
                {
                    type = 'Creditor';
                }
                string oid;
                if(originator.size() > 0)
                {
					oid = originator[0].originator_reference_id__c;
                }
				List<Bank_Account__c> BankAccount = [Select Name,Bank_Account_Number__c,Bank__c,CurrencyIsoCode,
                                                     IBAN_Number__c,Sort_Code__c,Swift_Code__c from Bank_Account__c 
                                                     where Account__c =: d.id];
				List<Contact> Contacts = [Select firstname,lastname,phone,email from Contact where AccountId =: d.id];
                json = json + '{"request_type":"Credebtors", "originator_reference_id": "'+oid+'", "type": "'+type+'", "currency_code": "'+d.CurrencyIsoCode+'" ,"debtor_name":"'+d.name+'", "trade_name":"'+d.Trading_Name__c+'", "customer_since":"'+d.Counterparty_Since__c+'", "website":"'+d.website+'", "debtor_company_registration_number":"'+d.Company_Registration_Number__c+'", "nace_category":"'+d.NACE_Section__c+'", "nace_code":"'+d.NACE_Code__c+'", "founded":"'+d.Year_of_Registration__c+'","organisation_jurisdiction":"'+d.Country_of_Registration__c+'","average_payment_cycle":'+d.Average_Cycle_Payment__c+',  "Registered Address":{"address_line_one":"'+d.ShippingStreet+'", "address_city":"'+d.ShippingCity+'", "address_zipcode":"'+d.ShippingPostalcode+'" ,"address_state":"'+d.ShippingState+'" , "address_country": "'+d.ShippingCountry+'"},"Billing Address":{"address_line_one":"'+d.BillingStreet+'", "address_city":"'+d.BillingCity+'", "address_zipcode":"'+d.BillingPostalcode+'" ,"address_state":"'+d.BillingState+'" ,  "address_country": "'+d.BillingCountry+'" }';
				if(BankAccount.size() > 0)
				{
					Bank_Account__c b = BankAccount[0];
                    json = json + ',"BankAccount" : {"account_name":"'+b.name+'","account_no":"'+b.Bank_Account_Number__c+'","organisation_bank":"'+b.Bank__c+'","currency_code":"'+b.CurrencyIsoCode+'","iban_code":"'+b.IBAN_Number__c+'","sort_code":"'+b.Sort_Code__c+'","swift_code":"'+b.Swift_Code__c+'"}';
				}
				
				if(Contacts.size() > 0)
				{
					Contact c = Contacts[0];
                    json = json + ',"Contacts":{"email_address":"'+c.email+'","first_name":"'+c.firstname+'","last_name":"'+c.lastname+'","phone":"'+c.phone+'"}';
				}
				
				json = json + '}';	
			
			}
			system.debug(json);
			
			Http http = new Http();
			HttpRequest request = new HttpRequest();
		    request.setEndpoint('https://staging3.rolustech.com:44362/getCreditor.php');
		    request.setMethod('POST');
		    request.setHeader('Content-Type', 'application/json;charset=UTF-8');
		    request.setTimeout(120000);
		    request.setBody(json);
		    
		   // HttpResponse response =  http.send(request);
		    //email=response.getBody();
		   
		   // if (response.getStatusCode() != 200) {
		       // System.debug('The status code returned was not expected: ' +
		         //            response.getStatusCode() + ' ' + response.getBody()); 
		    //}
		}
		
		@future(callout=true)
		public static void sendOriginator(ID OriginatorId)
		{
			string json ;
			List<Account> Originator = [Select id,name,originator_reference_id__c,CurrencyIsoCode,Trading_Name__c,
                                        NumberOfEmployees,Website,Accounting_Software__c,Company_Registration_Number__c,
                                        VAT_Number__c, Company_Structure__c,Credit_Insurer__c,IDF_Provider__c,
                                        Number_of_Directors__c,NACE_Section__c, NACE_Code__c,Year_of_Registration__c,
                                        Country_of_Registration__c, ShippingAddress,ShippingStreet,ShippingCity,
                                        ShippingCountry,ShippingPostalcode,ShippingState,BillingStreet,BillingCity,
                                        BillingCountry,BillingPostalcode,BillingState from Account 
                                        where id =: OriginatorId];
			
			for(Account o : Originator)
			{
				List<Bank_Account__c> BankAccounts = [Select Name,Bank_Account_Number__c,Bank__c,CurrencyIsoCode,
                                                      IBAN_Number__c,Sort_Code__c,Swift_Code__c from Bank_Account__c 
                                                      where Account__c =: o.id];
				List<Contact> Contacts = [Select firstname,lastname,phone,email,MailingStreet,MailingCity,
                                          MailingPostalCode,MailingCountry,OtherStreet,OtherCity,OtherPostalCode,
                                          OtherCountry from Contact where AccountId =: o.id and Director__c = false];
				LIst<Contact> Directors = [Select email,firstname,lastname,phone,Director__c,MailingStreet,MailingCity,
                                           MailingPostalCode,MailingCountry,OtherStreet,OtherCity,OtherPostalCode,
                                           OtherCountry from Contact where AccountId =: o.id and Director__c = true];
				List<Opportunity> Opportunity = [Select Trade_Commission__c,Processing_Commission__c,
                                                 Purchase_Payment__c,d_ETR_Sell_Rate__c	,c_ETR_Deposit__c from
                                                Opportunity where AccountId =: o.id Limit 1];
				json = json + '{"request_type":"Originator", "currency_code": "'+o.CurrencyIsoCode+'" ,"organisation_name":"'+o.name+'", "organisation_trade_name":"'+o.Trading_Name__c+'", "total_employee":'+o.NumberOfEmployees+', "website":"'+o.website+'","accounting_software":"'+o.Accounting_Software__c+'", "vat_number":"'+o.Company_Registration_Number__c+'", "tax_number": "'+o.VAT_Number__c+'", "organisation_type":"'+o.Company_Structure__c+'", "insurance_provider":"'+o.Credit_Insurer__c+'",	 "discount_provider":"'+o.IDF_Provider__c+'","number_of_directors":'+o.Number_of_Directors__c+',"nace_category":"'+o.NACE_Section__c+'", "nace_code":"'+o.NACE_Code__c+'","formation_year":"'+o.Year_of_Registration__c+'","organisation_jurisdiction":"'+o.Country_of_Registration__c+'","Billing Address": {"address_line_one":"'+o.BillingStreet+'","address_city":"'+o.BillingCity+'","address_zipcode":"'+o.BillingPostalCode+'","address_state":"'+o.BillingState+'","address_country":"'+o.BillingCountry+'"},  "Delivery Address" : {"address_line_one":"'+o.ShippingStreet+'","address_city":"'+o.ShippingCity+'","address_zipcode":"'+o.ShippingPostalCode+'","address_state":"'+o.ShippingState+'" ,"address_country":"'+o.ShippingCountry+'"}';
				
				json = json + ',"BankAccounts" : [';
				Integer bCount = 1;
				for(Bank_Account__c b: BankAccounts)
				{
					json = json + '{"account_name":"'+b.name+'","account_no":"'+b.Bank_Account_Number__c+'","organisation_bank":"'+b.Bank__c+'","currency_code":"'+b.CurrencyIsoCode+'","iban_code":"'+b.IBAN_Number__c+'","sort_code":"'+b.Sort_Code__c+'","swift_code":"'+b.Swift_Code__c+'"}';
				    if(bCount < BankAccounts.size())
				    {
				    	json = json + ',';
				    }
				    bCount = bCount + 1;
				}
				
				bCount = 1;
				json = json + '], "Diretors": [';
				for(Contact d: Directors)
				{
					Integer isDirector = 1;
					
					json = json + '{"is_director":'+isDirector+',"email_address":"'+d.email+'","first_name":"'+d.firstname+'","last_name":"'+d.lastname+'","phone":"'+d.phone+'","Mailing Address":{"address_1":"'+d.MailingStreet+'","city":"'+d.MailingCity+'","area_code":"'+d.MailingPostalCode+'","address_country":"'+d.MailingCountry+'" }}';
					
					if(bCount < Directors.size())
				    {
				    	json = json + ',';
				    }
				    bCount = bCount + 1;
				}
				
				bCount = 1;
				json = json + '], "Contacts": [';
				
				
				for(Contact c : Contacts)
				{
					json = json + '{"email_address":"'+c.email+'","first_name":"'+c.firstname+'","last_name":"'+c.lastname+'","phone":"'+c.phone+'", "Home Address": {"address_1":"'+c.MailingStreet+'","city":"'+c.MailingCity+'","area_code":"'+c.MailingPostalCode+'","address_country":"'+c.MailingCountry+'"},  "Work Address" : {"address_1":"'+c.OtherStreet+'","city":"'+c.OtherCity+'","area_code":"'+c.OtherPostalCode+'","address_country":"'+c.OtherCountry+'" }}';
					if(bCount < Contacts.size())
				    {
				    	json = json + ',';
				    }
				    bCount = bCount + 1;
				}
				
				json = json + '], "Opportunity":';	
                if(Opportunity.size() > 0)
                {
                    Opportunity op = Opportunity[0];
                    json = json + '{"processing_fee":'+op.Trade_Commission__c+',"trade_fee":'+op.Processing_Commission__c+',"purchase_price":'+op.Purchase_Payment__c+',"agreed_rate":'+op.d_ETR_Sell_Rate__c+',"credit_agreed_rate":12,"orpa_deposit_percent":'+op.c_ETR_Deposit__c+'}}';
                }
                
                system.debug(json);
			
                Http http = new Http();
                HttpRequest request = new HttpRequest();
                request.setEndpoint('https://staging3.rolustech.com:44362/CheckOriginator.php');
                request.setMethod('POST');
                request.setHeader('Content-Type', 'application/json;charset=UTF-8');
                request.setTimeout(120000);
                request.setBody(json);
                
                HttpResponse response =  http.send(request);
                system.debug(response.getBody());
                Map<String,Object> results = (Map<String,Object>)System.JSON.deserializeUntyped(response.getBody());
                String orig_id = (String)results.get('originator_id');
                system.debug(orig_id);
                o.originator_reference_id__c = orig_id;
                update o;
                
			}
			
              
		   // if (response.getStatusCode() != 200) {
		       // System.debug('The status code returned was not expected: ' +
		         //            response.getStatusCode() + ' ' + response.getBody()); 
		    //}
		}*/
}